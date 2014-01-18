#include <cstdio>
#include <mysql++.h>
#include <hiredis.h>
#include <ctime>
#include <sstream>
#include "utils.h"

using namespace std;
using namespace mysqlpp;

#define MISSING_INSTANCE 	1
#define WRONG_INSTANCE 		2
#define MISSING_AUTHTOKEN 	3
#define WRONG_AUTHTOKEN 	4
#define MISSING_ARGUMENT 	5
#define NOT_FOUND			6
#define NO_REDIS			7
#define INTERNAL_ERROR		8

/**
  *
  *
  **/
class HttpResponse{

	public:
		static void error(int err_code){
			switch(err_code){
				case MISSING_INSTANCE :
					cout << "{ \"status\" : \"false\", \"reason\" : \"You must provide an instance token.\" }";
				break;

				case WRONG_INSTANCE :
					cout << "{ \"status\" : \"false\", \"reason\" : \"This instance token is invalid.\" }";
				break;

				case MISSING_AUTHTOKEN :
					cout << "{ \"status\" : \"false\", \"reason\" : \"You must provide an auth token.\" }";
				break;

				case WRONG_AUTHTOKEN :
					cout << "{ \"status\" : \"false\", \"reason\" : \"The auth token you provided is invalid.\" }";
				break;

				case MISSING_ARGUMENT :
					cout << "{ \"status\" : \"false\", \"reason\" : \"You are missing arguments to make this call.\" }";
				break;

				case NOT_FOUND :
					cout << "{ \"status\" : \"false\", \"reason\" : \"This method does not exist.\" }";
				break;

				case NO_REDIS:
					cout << "{ \"status\" : \"false\", \"reason\" : \"Could not connect to redis server.\" }";
				break;

				case INTERNAL_ERROR:
					cout << "{ \"status\" : \"false\", \"reason\" : \"Internal error.\" }";
				break;
			}

			exit(EXIT_SUCCESS);
		}

		static void debug(char * s){
			cout << "{ \"status\" : \"false\", \"reason\" : \"" << s <<"\" }";
			exit(EXIT_SUCCESS);
		}

		static void bootstrap(){
			printf("Content-type: application/json\n\n");
		}
};

char **argss;
int nargss;

string header( const string &headerName ){
	nargss = 30;

	for(int i = 0 ; i < nargss; i++){

		if(!argss[i]){
			continue;
		}

		if(startsWith(argss[i], headerName )) {

			string s (argss[i]);

			int j, found = 0;
			for (j = 0; argss[i][j] != '\0'; ++j){

				if(argss[i][j] == '='){
					found = 1;
					break;
				}
			}
			return found ? & argss[i][j+1] : string();
		}
	}

	return string();
}

string _get(const string &p){

	string h = header( "QUERY_STRING" );

	string * parts = split( h , '&' );

	int oc = split_ocurrences( h, '&' );

	for (int j = 0; j < oc; ++j){
		if( startsWith( parts[ j ], p )){
			size_t io = parts[j].find("=");
			return parts[ j].substr( io  + 1);
		}
	}

	return string("__________NULL");
}

/**
  *
  *
  **/
class DB{

private:
	static Connection coreConn;
	static Connection instanceConn;
	static string intanceToken;

	DB(){
	}

public:
	void bootstrap(){
	}

	static Connection getCoreConn(){
		Connection coreConn(false);
		coreConn.connect("pos-nightly", "127.0.0.1", "root", "anti4581549");
		return coreConn;
	}

	static Connection getInstanceConn(string token){

		Connection instanceConn(false);

		try{

			Connection conn = DB::getCoreConn();

			Query query = conn.query();

			query << "select instance_id, db_user, db_password, db_name, db_driver, db_host  from instances where instance_token = \"" + token + "\";";

			StoreQueryResult bres = query.store();

			if ( bres.num_rows() != 1 ){
				HttpResponse::error(MISSING_INSTANCE);
			}

			instanceConn.connect( bres[0]["db_name"], bres[0]["db_host"], bres[0]["db_user"], bres[0]["db_password"] );

			return instanceConn;

		}catch(BadQuery er){

			HttpResponse::error(INTERNAL_ERROR);
			//cout << "Error:" << er.what() << endl ;
			return instanceConn;

		}catch(const BadConversion& er){
			HttpResponse::error(INTERNAL_ERROR);
			//cout << "Conversion error " << er.what() << endl;
			return instanceConn; 

		}catch(const Exception& er){
			HttpResponse::error(INTERNAL_ERROR);
			//cout << "Error" << er.what() << endl;
			return instanceConn; 

		}
	}

	static Connection getInstanceConn(){
		return instanceConn;
	}

	static redisContext* getRedisConnection(){
		redisContext *redis = redisConnect("127.0.0.1", 6379);

		if (redis->err) {
			//printf("Error: %s\n", redis->errstr);
			HttpResponse::error(NO_REDIS);
		}

		return redis;
	}
};

class InstanceController{

public:
	static int instanceExists(string token){

		try{

			Connection conn = DB::getCoreConn();

			Query query = conn.query();

			query << "select * from instances where instance_token = \"" + token + "\";";

			StoreQueryResult bres = query.store();

			return ( bres.num_rows() == 1 );

		}catch(BadQuery er){
			cout << "Error:" << er.what() << endl ;
			return 0;

		}catch(const BadConversion& er){
			cout << "Conversion error " << er.what() << endl;
			return 0; 

		}catch(const Exception& er){
			cout << "Error" << er.what() << endl;
			return 0;

		}

	}

	static int getInstanceId(string token){

		try{

			Connection conn = DB::getCoreConn();

			Query query = conn.query();

			query << "select instance_id from instances where instance_token = \"" + token + "\";";

			StoreQueryResult bres = query.store();

			return bres[0]["instance_id"];

		}catch(BadQuery er){
			cout << "Error:" << er.what() << endl ;
			return 0;

		}catch(const BadConversion& er){
			cout << "Conversion error " << er.what() << endl;
			return 0; 

		}catch(const Exception& er){
			cout << "Error" << er.what() << endl;
			return 0;

		}
	}
};

class SesionController{
public:
	static int isValidSesion(string at){
		try{

			Connection conn = DB::getInstanceConn(_get("instance"));

			Query query = conn.query();

			query << "select id_usuario from sesion where auth_token  = \"" + at + "\" limit 1;";

			StoreQueryResult bres = query.store();

			return ( bres.num_rows() == 1 );

		}catch(BadQuery er){
			cout << "Error:" << er.what() << endl ;
			return 0;

		}catch(const BadConversion& er){
			cout << "Conversion error " << er.what() << endl;
			return 0; 

		}catch(const Exception& er){
			cout << "Error" << er.what() << endl;
			return 0;

		}
		return 1;
	}

	static int getUserIdFromAuthToken(string at){

		try{

			Connection conn = DB::getInstanceConn(_get("instance"));

			Query query = conn.query();

			query << "select id_usuario from sesion where auth_token  = \"" + at + "\" limit 1;";
			
			StoreQueryResult bres = query.store();

			if( bres.num_rows() != 1 ){
				//do smething
			}

			return bres[0]["id_usuario"];

		}catch(BadQuery er){
			cout << "Error:" << er.what() << endl ;
			return 0;

		}catch(const BadConversion& er){
			cout << "Conversion error " << er.what() << endl;
			return 0; 

		}catch(const Exception& er){
			cout << "Error" << er.what() << endl;
			return 0;

		}

		return 1;
	}
};

class ChatController{

public:
	static void postMessage(){
		//reciever
		string to_user_id = _get("to");

		//instance id
		int instance_id = InstanceController::getInstanceId( _get("instance") );

		//from
		int from_user_id = SesionController::getUserIdFromAuthToken(_get("auth_token"));

		//content
		string content = _get("content");

		string key("");

		key.append( to_string(instance_id) );
		key.append( "-" );
		key.append( to_string(to_user_id) );
		key.append( "-unread" );

		string json( "{\"from\":" );
		json.append( to_string(from_user_id) );
		json.append( ",\"date\":" );
		json.append( to_string(time(0)) );
		json.append( ",\"content\":\"" );
		json.append( content );
		json.append( "\"}" );

		//post to them
		string redisCmd ("lpush ");
		redisCmd.append( key );
		redisCmd.append( " " );
		redisCmd.append( json );

		redisContext* redis = DB::getRedisConnection();
		redisCommand(redis, redisCmd.c_str());

		cout << "{ \"status\" : \"ok\" }";
	}

	static void getMessages(){

		redisContext* redis = DB::getRedisConnection();

		//get curret user
		string at = _get("auth_token");

		int user_id = SesionController::getUserIdFromAuthToken(at);
		int instance_id = InstanceController::getInstanceId( _get("instance") );

		string rCmd ("llen ");
		rCmd.append( to_string(instance_id) );
		rCmd.append("-");
		rCmd.append( to_string(user_id) );
		rCmd.append("-unread");

		redisReply *res ;

		res = (redisReply*)redisCommand(redis, rCmd.c_str());

		int results = res->integer;

		cout << "{ \"number_of_results\" : "<< results << ",\"results\" : [";
		rCmd.clear();
		rCmd.append( "lpop " );
		rCmd.append( to_string(instance_id) );
		rCmd.append("-");
		rCmd.append( to_string(user_id) );
		rCmd.append("-unread");

		for (int i = 0; i < results; ++i){
			res = (redisReply*)redisCommand(redis, rCmd.c_str());

			cout << res->str ;

			if(i < (results - 1)){
				cout << ", ";
			}
		}

		cout << "]}";
	}
};

class ContactsController{
	private:
		ContactsController(){
		};

	public:
		static void getOnlineContacts(){
			try{
				Connection conn = DB::getInstanceConn(_get("instance"));

				Query query = conn.query();

				query << "select \
								usuario.id_usuario,\
								usuario.id_rol,\
								usuario.nombre,\
								usuario.correo_electronico,\
								sesion.ip,\
								rol.descripcion,\
								rol.nombre as rol_nombre\
							from \
								usuario,\
								sesion, \
								rol \
							where\
								sesion.id_usuario = usuario.id_usuario\
								AND rol.id_rol = usuario.id_rol\
								and sesion.fecha_de_vencimiento < NOW()\
								and usuario.activo = 1" \
								" AND usuario.id_usuario != " << SesionController::getUserIdFromAuthToken(_get("auth_token")) << ";";

				StoreQueryResult bres = query.store();

				cout << "{ \"status\" : \"ok\" , \"number_of_results\" : " << bres.num_rows() << ", \"children\" : [ ";
				cout << "{ \"nombre\" : \"online\", \"expanded\": true, \"children\": [";

				for(size_t i = 0 ; i < bres.num_rows(); i++){
					cout << "{" ;
					cout << "\"leaf\":true, \"iconCls\": \"user-green\",";
					cout << "\"id_usuario\" : "						<< bres[i]["id_usuario"] << ",";
					cout << "\"id_rol\":"							<< bres[i]["id_rol"] << ",";
					cout << "\"rol_descripcion\" : \""				<< bres[i]["descripcion"] << "\",";
					cout << "\"rol_nombre\" : \""					<< bres[i]["rol_nombre"] << "\",";
					cout << "\"nombre\" : \"" 						<< bres[i]["nombre"] << "\",";
					cout << "\"correo_electronico\" : \""			<< bres[i]["correo_electronico"] << "\",";
					cout << "\"ip\" : \"" 							<< bres[i]["ip"] << "\"";
					cout << "}";

					if(i < bres.num_rows() - 1){
						cout << ",";
					}
				}

				cout << "]},";

				//Obtener los usuarios offline
				query = conn.query();

				query << "select \
								usuario.id_usuario,\
								usuario.id_rol,\
								usuario.nombre,\
								usuario.correo_electronico,\
								rol.descripcion,\
								rol.nombre as rol_nombre\
							from \
								rol, \
								usuario LEFT JOIN sesion ON sesion.id_usuario = usuario.id_usuario \
							where\
								sesion.id_usuario IS NULL \
								AND rol.id_rol = usuario.id_rol\
								AND usuario.activo =1;"; 

				bres = query.store();

				cout << "{ \"nombre\" : \"offline\", \"expanded\": true, \"children\": [" ;

				for(size_t i = 0 ; i < bres.num_rows(); i++){
					cout << "{" ;
					cout << "\"leaf\" : true, \"iconCls\": \"user-red\",";
					cout << "\"id_usuario\" : " 				<< bres[i]["id_usuario"] << ",";
					cout << "\"id_rol\" : " 					<< bres[i]["id_rol"] << ",";
					cout << "\"rol_descripcion\":\""			<< bres[i]["descripcion"] << "\",";
					cout << "\"rol_nombre\" : \""				<< bres[i]["rol_nombre"] << "\",";
					cout << "\"nombre\" : \""					<< bres[i]["nombre"] << "\",";
					cout << "\"correo_electronico\" : \""		<< bres[i]["correo_electronico"] << "\"";
					cout << "}";

					if(i < bres.num_rows() - 1){
						cout << ",";
					}
				}

				cout << "]}";
				cout << "]}";

			}catch(BadQuery er){
				cout << "Error:" << er.what() << endl ;

			}catch(const BadConversion& er){
				cout << "Conversion error " << er.what() << endl;

			}catch(const Exception& er){
				cout << "Error" << er.what() << endl;

			}
		}
};

class ApiHandler{

	private:
	int testInstance(){
		string instance = _get("instance");

		if(instance == "__________NULL"){
			HttpResponse::error(MISSING_INSTANCE);
		}

		if(!InstanceController::instanceExists(instance)){
			HttpResponse::error(WRONG_INSTANCE);
		}

		//test auth token
		string auth_token = _get("auth_token");

		if(auth_token == "__________NULL"){
			HttpResponse::error(MISSING_AUTHTOKEN);
		}

		if(!SesionController::isValidSesion(auth_token)){
			HttpResponse::error(WRONG_AUTHTOKEN);
		}
	}

	public:
	void dispatch( string path ){

		//look for global necesary params
		testInstance();

		string * spath = split( path, '/' );
		int spath_size = split_ocurrences(path, '/');

		if(_get("cmd") == "getOnlineContacts"){
			ContactsController::getOnlineContacts();
			return;

		}else if(_get("cmd") == "postMessage"){
			ChatController::postMessage();
			return;

		}else if(_get("cmd") == "getMessages"){
			ChatController::getMessages();
			return;
		}

		HttpResponse::error(NOT_FOUND);
	}
};

/**
  * Main entry point
  *
  **/
int main( int nargs, char **args ){

	// Set global variables
	argss = args;
	nargss = nargs;

	HttpResponse::bootstrap();

	ApiHandler ah ;

	ah.dispatch( header("PATH_INFO")  );

	return EXIT_SUCCESS;
}

