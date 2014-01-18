<?php

require_once("interfaces/Sesion.interface.php");


class SesionController implements ISesion{

	private static $_is_logged_in;
	private static $_current_user;

	/**
 	 *
 	 *Regresa informacion sobre la sesion actual.
 	 *
 	 * @return id_caja int 
 	 * @return id_sucursal int El id_sucursal de la sucursal donde este usuario inico sesion en caso de haberlo hecho desde un mostraodr. Un gerente no tendra id_sucursal asociada a el dado que puede iniciar sesion desde cualquier lugar.
 	 * @return id_usuario int 
 	 **/
	public static function Actual( ) {
		if ( !is_null(self::$_is_logged_in) && self::$_is_logged_in ) {
			if ( !is_null( self::$_current_user ) ) {
				return array( "id_caja" => null, "id_sucursal" => null, "id_usuario" => self::$_current_user->getIdUsuario( ) );
			}

			$foo = self::getCurrentUser( );
			return array( "id_caja" => null, "id_sucursal" => null, "id_usuario" => $foo->getIdUsuario());

		}else{
			return array( "id_caja" => null, "id_sucursal" => null, "id_usuario" => null);
		}
	}


	/**
 	 *
 	 *Regresa un url de redireccion segun el tipo de usuario.
 	 *
 	 * @param auth_token string El token de autorizacion generado al iniciar la sesion
 	 * @return forward_to string La url de continuaci�n de acuerdo al id que cerr� sesi�n.
 	 **/
	public static function Cerrar
	(
		$auth_token = null
	){
		$s = SesionDAO::search( new Sesion( array( "auth_token" => $auth_token  )  ) );

		if(sizeof($s) != 1){
			//no existe este auth token
		}
	
		try{
			SesionDAO::delete( $s[0]  );
		}catch(Exception $e){

		}

	
		self::$_is_logged_in = null;
		self::$_current_user = null;
		$sm = SessionManager::getInstance();
		$sm->SetCookie( 'at', 'deleted', 1, '/' );
	}

	/**
	 * Cerrar las sesiones que ya caducaron
	 * 
	 * 
	 * */
	public static function Limpiar( ){

		$sesiones = SesionDAO::getAll();

		foreach( $sesiones as $s ) {
			if( $s->getFechaDeVencimiento( ) < time( ) ) {
				try{
					SesionDAO::delete( $s );
				}catch(Exception $e){
					throw new InvalidDatabaseOperationException($e);
				}
			}
		}

	}


	public static function HeartBeat( ){
		if(!self::isLoggedIn()) return;
		
		$s = self::Actual();
		
		if(!is_null($s["id_usuario"])){
			
			//sesion activa !
			/*$u = UsuarioDAO::getByPK($s["id_usuario"]);
			try{
				$u->setFechaDeVencimiento( date("Y-m-d h:i:j") );
				
				UsuarioDAO::save($u);
			}catch(Exception $e){
				throw InvalidDatabaseException();
			}*/
		}else{
			//Logger::log("JN?O");
		}
	}

	/**
 	 *
 	 * Valida las credenciales de un usuario y regresa un url a donde se debe de redireccionar. 
 	 * Este m?todo no necesita de ning?n tipo de autenticaci?n. 
 	 * Si se detecta un tipo de usuario inferior a admin y no se ha llamado 
 	 * antes a api/sucursal/revisar_sucursal se regresar? un 403 Authorization 
 	 * Required y la sesi?n no se iniciar?.
 	 * Si el usuario que esta intentando iniciar sesion, esta descativado...
 	 * 403 Authorization Required supongo
 	 *
 	 * @param password string La contrasena del usuario.
 	 * @param usuario string El id de usuario a intentar iniciar sesion.
 	 * @param request_token bool Si se envia, y es verdadero, el seguimiento de esta sesi�n se har� mediante un token, de lo contrario se har� mediante cookies.
 	 * @return usuario_grupo int El grupo al que este usuario pertenece.
 	 * @return siguiente_url string La url a donde se debe de redirigir.
 	 * @return login_succesful	 bool Si la validaci�n del usuario es correcta.
 	 * @return auth_token string El token si es que fue solicitado.
 	 **/
	public static function Iniciar
	(
		$password, 
		$usuario, 
		$request_token = null
	)
	{
		//user is not logged in, look for him
		$user = UsuarioDAO::findUser( $usuario, $password );

		if( is_null($user) ) {
			Logger::warn("===== Credenciales invalidas para usuario {$usuario} ====== ");
			return array( "login_succesful" => false, "reason" => "Credenciales Invalidas" );
		}

		//verificamos si la instancia esta activa
		if (INSTANCE_ACCESS === "0") {
			return array( "login_succesful" => false, "reason" => "Acceso denegado, su instancia esta desactivada");
		}

		//ok user is ok, buscar su usuario en los tokens actuales
		$sesiones_actuales  = SesionDAO::search( new Sesion( array( "id_usuario" => $user->getIdUsuario() ) ) );
		
		if(sizeof($sesiones_actuales) > 0){
			foreach($sesiones_actuales	as $s ){
				
				try{
					SesionDAO::delete( $s );
					
				}catch(Exception $e){
					//Logger::error($e->getMessage());
					throw new InvalidDatabaseOperationException($e);
				}
			}
		}
		
		
		//si tiene un token actualmente que es valido, regenerar el token actualizar la fecha y darle el nuevo token
		$nueva_sesion = new Sesion();
		$nueva_sesion->setIdUsuario( $user->getIdUsuario( ) );
		$nueva_sesion->setAuthToken( self::GenerarAuthToken( ) );
		$nueva_sesion->setFechaDeVencimiento( time( ) + 3600 );
		
		if(isset($_SERVER["HTTP_USER_AGENT"])){
			$nueva_sesion->setClientUserAgent( $_SERVER["HTTP_USER_AGENT"] );
		}else{
			$nueva_sesion->setClientUserAgent( "CLI" );
		}

		if(isset($_SERVER["REMOTE_ADDR"])){
			$nueva_sesion->setIp( $_SERVER["REMOTE_ADDR"] );
		}else{
			$nueva_sesion->setIp( "CLI" );
		}

		try{
			SesionDAO::save( $nueva_sesion );

		}catch(Exception $e){
			throw new InvalidDatabaseOperationException($e);

		}

		self::login( $nueva_sesion->getAuthToken(), $nueva_sesion->getIdUsuario(), $user->getIdRol()  );

		self::$_current_user = $user;
		self::$_is_logged_in = true;

		switch($user->getIdRol()) {
			case 0:
			case 1:
			case 2:
			case 3:
			case 4: $next_url = "g/"; break;
			case 5: $next_url = "c/"; break;
		}
		
		$r = array( 
				"auth_token" => $nueva_sesion->getAuthToken(), 
				"login_succesful" => true,
				"usuario_grupo" => $user->getIdRol(),				
				"siguiente_url" => $next_url,				
			);
                
               if ($user->getIdRol() == 5) {
                   $r["detalles_usuario"] = ClientesController::Detalle($user->getIdUsuario());
               } 
                
                return $r;
	}


	private static function GenerarAuthToken
	(
		$salt = null,
		$vencimiento = null
	){
		return md5( rand(  ) );
	}




	/**
 	 *
 	 *Obtener las sesiones activas.
 	 *
 	 * @param id_grupo int Obtener la lista de sesiones activas para un grupo de usuarios especifico.
 	 * @return en_linea json Arreglo de objetos que contendr�n la informaci�n de las sesiones activas
 	 **/
	public static function Lista
	(
		$id_grupo = null
	)
	{
  		$out = array();
		$sesiones = SesionDAO::getAll(  );
		
		for ($i=0; $i < sizeof($sesiones); $i++) { 
			array_push( $out, $sesiones[$i]->asArray() );
		}
		
		return array(
			"numero_de_resultados" => sizeof($out),
			"resultados"			=> $out
		);
	}




	/**
	  * Buscar a un usuario y passwor y regresar el objeto de ese usuario
	  *
	  *
	  **/
	public static function testLogin($user, $pass){
		//Logger::log("testLogin( {$user} )");

		//user is not logged in, look for him
		$user = UsuarioDAO::findUser( $user, $pass );

		if( $user === NULL ) {
			//Logger::warn("No se encontro el usuario " . $user);
			return NULL;	
		}

		//ok user is ok, log him in
		self::login( $user->getIdUsuario(), $pass, $user->getIdRol() );

		//dispatch
		self::dispatchUser($user->getIdRol());
		
		
	}



	private static function dispatchUser( $group ){
		switch($group){
			case 1: die( header( "Location: gerencia/" ) );
		}
		
	}



	static function isLoggedIn() {

		if (isset(self::$_is_logged_in) && !is_null(self::$_is_logged_in) && self::$_is_logged_in) {
			return true;
		}

		$auth_token = null;

		if (isset($_GET["at"]) ) {
			$auth_token =$_GET["at"];

		} else if(isset($_POST["at"])){
			$auth_token =$_POST["at"];

		} else {
			$sm = SessionManager::getInstance();
			$auth_token = $sm->GetCookie("at");

		}

		if (is_null($auth_token)) {
			Logger::log("No auth token in GET/POST/COOKIE");
			self::$_is_logged_in = false;
			return false;
		}

		$user = SesionDAO::getUserByAuthToken($auth_token);

		if (is_null($user)) {
			self::$_is_logged_in = false;
			return false;
		}else{
			self::$_is_logged_in = true;
			return true;
		}
	}

	private static function login( $auth_token, $user_id, $rol_id ){
		if(headers_sent( )){
			return;
		}
		
		$sm = SessionManager::getInstance( );
		$sm->SetCookie( 'at',  $auth_token, 	time()+60*60*24, '/' );
		$sm->SetCookie( 'rid', $rol_id, 		time()+60*60*24, '/' );
		$sm->SetCookie( 'uid', $user_id, 		time()+60*60*24, '/' );
	}


	public static function getCurrentUser(  ){
		if( !is_null(self::$_current_user) ) {
			return self::$_current_user;
		}

		$auth_token = null;

		if(isset($_GET["auth_token"]) ){
			$auth_token =$_GET["auth_token"];

		} else if(isset($_POST["auth_token"])){
			$auth_token =$_POST["auth_token"];

		} else if(isset($_GET["at"])){
			$auth_token =$_GET["at"];

		} else if(isset($_POST["at"])){
			$auth_token =$_POST["at"];

		} else {
			$sm = SessionManager::getInstance();
			$auth_token = $sm->GetCookie("at");

		}
		
		self::$_current_user = null;
		
				
		if(!is_null($auth_token)){
			self::$_current_user = SesionDAO::getUserByAuthToken( $auth_token );	
		}
		
		/*
		//there is authtoken in the POST message
		if( isset($_POST["at"]) && !is_null($_POST["at"]) ){
			//Logger::log("post");
			self::$_current_user = SesionDAO::getUserByAuthToken( $_POST["at"] );
		}
		
		//there is authtoken in the GET message
		if(isset($_GET["at"]) && !is_null($_GET["at"])){
			//Logger::log("get");
			self::$_current_user = SesionDAO::getUserByAuthToken( $_GET["at"] );
		}
		*/
		return self::$_current_user;
	}
}
