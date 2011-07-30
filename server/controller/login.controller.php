<?php

require_once("model/usuario.dao.php");
require_once("model/grupos_usuarios.dao.php");
require_once("model/grupos.dao.php");
require_once("model/sucursal.dao.php");
require_once("model/equipo.dao.php");
require_once("model/equipo_sucursal.dao.php");
require_once("model/cliente.dao.php");


/**
 * 
 * Funciones LOGIN de Cliente
 * 
 * 
 * 
 * 
 * */

function loginCliente($u, $p){
	$user = new Cliente();
	$user->setRfc( $u );
	$user->setPassword( $p );	

	try{
		$res = ClienteDAO::search( $user );		
	}catch(Exception $e){
		echo "{\"success\": false , \"reason\": 101, \"text\" : \"Error interno.\" }";
        Logger::log($e);
		return;		
	}


	if(count($res) != 1){
    	//este usuario no existe
		if( isset( $_SESSION[ 'c' ] )) $_SESSION[ 'c' ] ++; else $_SESSION[ 'c' ] = 1;

        Logger::log("Credenciales invalidas para el CLIENTE " . $u . " intento:" . $_SESSION[ 'c' ], 1);
		die(  "{\"success\": false , \"reason\": \"Invalidas\", \"text\" : \"Credenciales invalidas. Intento numero <b>". $_SESSION[ 'c' ] . "</b>. \" }" );

	}
	

	//login correcto 
	unset( $_SESSION[ 'c' ] );	

	//buscar en que grupo esta este usuario
	$cliente = $res[0];

    $_SESSION['ip'] 	= getip();
    $_SESSION['pass'] 	= $p;
	$_fua 				= $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ua'] 	= $_fua;
	$_SESSION['grupo']  = 4;
	$_SESSION['cliente_id'] = $cliente->getIdCliente();
	

    Logger::log("Accesso autorizado para cliente  " . $u );

	echo '{"success": true }';
}




function checkCurrentClientSession(){


    $ip = getip();

    if( !(isset( $_SESSION['ip'] ) && $_SESSION['ip'] == $ip) ){
        Logger::log("session[ip] not set or wrong!");
        Logger::log("session:" . $_SESSION['ip'] . " actual:" . $ip );
        return false;
    }

    $user = ClienteDAO::getByPK( $_SESSION['cliente_id'] );

    if($user === null){
        Logger::log("Cliente en sesion ya no existe en la base de datos");
        return false;
    }

    $pass = $user->getPassword();

    if( !(isset( $_SESSION['pass'] ) && $_SESSION['pass'] == $pass) ){
        Logger::log("Cliente: session[pass] not set or wrong !");
        return false;
    }

    if( !(isset( $_SESSION['ua'] ) &&  $_SESSION['ua'] == $_SERVER['HTTP_USER_AGENT']) ){
        Logger::log("Cliente: session[ua] not set or wrong!");
        return false;
    }


    return true;
}


/**
 * 
 * Funciones LOGIN de Sucursal y Admin
 * 
 * 
 * 
 * 
 * */
function login( $u, $p ){

	$user = new Usuario();
	$user->setIdUsuario( $u );
	$user->setContrasena( $p );	

	if(strlen($p) < 5 || strlen($u) < 1){
		if( isset( $_SESSION[ 'c' ] )) $_SESSION[ 'c' ] ++; else $_SESSION[ 'c' ] = 1;

        Logger::log("Credenciales muy cortas para el usuario " . $u . " intento:" . $_SESSION[ 'c' ], 1);
		die(  "{\"success\": false , \"reason\": \"Invalidas\", \"text\" : \"Credenciales invalidas. Intento numero <b>". $_SESSION[ 'c' ] . "</b>. \" }" );	
	}

	try{
		$res = UsuarioDAO::search( $user );	
			
	}catch(Exception $e){
		echo "{\"success\": false , \"reason\": 101, \"text\" : \"Error interno.\" }";
        Logger::log($e);
		return;		
		
	}


	if(count($res) != 1){
    	//este usuario no existe
		if( isset( $_SESSION[ 'c' ] )) $_SESSION[ 'c' ] ++; else $_SESSION[ 'c' ] = 1;

        Logger::log("Credenciales invalidas para el usuario " . $u . " intento:" . $_SESSION[ 'c' ], 1);
		die(  "{\"success\": false , \"reason\": \"Invalidas\", \"text\" : \"Credenciales invalidas. Intento numero <b>". $_SESSION[ 'c' ] . "</b>. \" }" );

	}
	

	//login correcto 
	unset( $_SESSION[ 'c' ] );	


	//buscar en que grupo esta este usuario
	$user = $res[0];


	//ver si este usuario esta activo o no
	if(	!$user->getActivo() ){
        Logger::log("El usuario " . $u . " intento loggearse pero no esta activo en el sistema", 2);
		die(  "{\"success\": false , \"reason\": \"Invalidas\", \"text\" : \"Su cuenta ha sido suspendida.\" }" );
	}

	$grpu = new GruposUsuarios();
	$grpu->setIdUsuario( $user->getIdUsuario() );
	$res = GruposUsuariosDAO::search( $grpu );
	
	if(count($res) < 1){
		echo "{\"success\": false , \"reason\": 101,  \"text\" : \"Aun no perteneces a ningun grupo.\" }";
        Logger::log("Usuario  " . $u . " no pertenence a ningun grupo." , 1);
		return;
	}

	if($grpu->getIdGrupo() > 1 && !sucursalTest()){
		die( "{\"success\": false , \"reason\": 101,  \"text\" : \"Este equipo no es una sucursal valida.\" }" );
	}

    //usuario valido, y grupo valido
	$grpu = $res[0];

    $_SESSION['ip'] = getip();
    $_SESSION['pass'] = $p;
	$_fua = $_SERVER['HTTP_USER_AGENT'];
    $_SESSION['ua'] = $_fua;
	$_SESSION['grupo']  =  $grpu->getIdGrupo();
	$_SESSION['userid'] =  $user->getIdUsuario();


    if($grpu->getIdGrupo() == 1){
        if( $user->getIdSucursal()  == null){
            Logger::log("Este administrador no tiene vinculada ninguna sucursal !", 2);
        }
        $_SESSION['sucursal'] = $user->getIdSucursal();
    }



    if($grpu->getIdGrupo() == 3){

        if($user->getIdSucursal() != $_SESSION['sucursal']){
            Logger::log("cajero intento loggearse en una sucursal que no es suya");
            die( "{\"success\": false , \"reason\": 101,  \"text\" : \"No perteneces a esta sucursal.\" }" );
        }

    }


    Logger::log("Accesso autorizado para usuario  " . $u );
	echo "{\"success\": true , \"payload\": { \"sucursaloverride\": false , \"type\": \"" . $grpu->getIdGrupo() . "\" }}";
		
	return true;

}




function getUserType(){
	if(isset($_SESSION['grupo']))
	    echo $_SESSION['grupo'];
	else
        die( '{"success": false , "reason": "Accesso denegado" }' );

}






/*
    regresa verdadero si la sesion actual 
    es valida para el grupo de usuario dado
    regresa falso si no hay sesion alguna
    o bien si los parametros de session
    no concuerdan
 */
function checkCurrentSession(){
	

	
	if( !isset( $_SESSION['grupo'] ) ){
        Logger::log("checkCurrentSession(): session[grupo] not set !");
        return false;
	}

	//revisamos si vamos a validar
	//la sesion de un cliente,
	//ya que se maneja de otra manera
	if(isset($_SESSION['cliente_id'])){
		//voy a validar la sesion de un cliente
		return checkCurrentClientSession();
	}

    if(!isset($_SESSION['userid'])){
        Logger::log("checkCurrentSession(): session[userid] not set !");
        return false;
    }

    $ip = getip();
    if( !(isset( $_SESSION['ip'] ) && $_SESSION['ip'] == $ip) ){
		//ok, el ip ha cambiado, si es una sucursal, no hay pex
		if( $_SESSION["grupo"] == 2
			|| $_SESSION["grupo"] == 3
		){
			//soy una sucursal	
			Logger::log("------ Esta sucursal ha cambiado de IP ------- ");
			$_SESSION["ip"] = $ip;
			
		}else{
			//soy otro tipo de usuario
			Logger::log("session[ip] not set or wrong!");
	        Logger::log("session:" . $_SESSION['ip'] . " actual:" . $ip );
	        return false;
		}

    }

    $user = UsuarioDAO::getByPK( $_SESSION['userid'] );

    if($user === null){
        Logger::log("Usuario en sesion no existe en la base de datos");
        return false;
    }

    $pass = $user->getContrasena();

    if( !(isset( $_SESSION['pass'] ) && $_SESSION['pass'] == $pass) ){
        Logger::log("session[pass] not set or wrong !");
        return false;
    }

    if( !(isset( $_SESSION['ua'] ) &&  $_SESSION['ua'] == $_SERVER['HTTP_USER_AGENT']) ){
        Logger::log("session[ua] not set or wrong!");
        return false;
    }

    $grupoUsuario = GruposUsuariosDAO::getByPK( $_SESSION['userid'] );
    
    if( $grupoUsuario->getIdGrupo() != $_SESSION['grupo'] ){
        Logger::log("session[grupo] wrong ! !");
        return false;
    }


    //si es cajero, revisar que este en su sucursal
    if( $_SESSION['grupo'] == 3 ){
        if( $_SESSION['sucursal'] != $user->getIdSucursal() ){
             Logger::log("session[sucursal] wrong for cajero !");
            return false;
        }
    }

    return true;
}




function logOut( $verbose = true  )
{
    
    if(isset($_SESSION['userid']))
        Logger::log("---- Cerrando sesion para {$_SESSION['userid']} ----");
    else if(isset($_SESSION['cliente_id']))
		Logger::log("---- Cerrando sesion para cliente {$_SESSION['cliente_id']} ----");
	else
		Logger::log("---- Cerrando sesion generica ----");

    if($verbose){
	
		if(isset($_SESSION["INSTANCE_ID"])){
			$print_instance = "?i=" . $_SESSION["INSTANCE_ID"]; 
		}else{
			$print_instance = "";
		}
		
        if(isset($_SESSION['grupo'])){
			
            if($_SESSION['grupo'] <= 1)
                	print ('<script>window.location= "./admin/'.$print_instance.'"</script>');
            else
                	print ('<script>window.location= ".'.$print_instance.'"</script>');

        }else{
        	print ('<script>window.location= ".'.$print_instance.'"</script>');                
        }
    }


	//por alguna razon, usar session_unset
	//no me deja volver a poner el valor de 
	//la instancia de nuevo en la sesion
	//asi que es mejor si borro individualmente
	//cada una
	
    //session_unset ();

    unset($_SESSION['ip']);
    unset($_SESSION['pass']);
    unset($_SESSION['ua']);
	unset($_SESSION['grupo']);
	unset($_SESSION['userid']);
	
	// unset($_SESSION['sucursal']); 

}





/**
  *  revisar si vengo de una sucursal valida
  *  regresa verdadero si es una sucursal valida
  *  si es una sucursal valida, la pone en
  *  la variable de sesion de sucursal.
  *
  **/
function sucursalTest( ){
	return $_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'];
}


/**
  *  Validar el TOKEN DE SEGURIDAD que envia el cliente.
  *
  **/
function sucursalTestToken( $pin ){
	
	//buscar ese pin en la lista de equipos
	Logger::log("Buscando token " . $pin);
	
	$equipo_q = new Equipo();
    $equipo_q->setToken( $pin );
    $search = EquipoDAO::search( $equipo_q );

	if(sizeof($search) == 0){
		Logger::log("Equipo no encontrado !");
		return false;
	}else{
		$equipo = $search[0];
		Logger::log("Token encontrado para el equipo ". $equipo->getIdEquipo() ." ( ". $equipo->getDescripcion() ." )!");
	}

    $esuc = new EquipoSucursal();
    $esuc->setIdEquipo($equipo->getIdEquipo());

    $search = EquipoSucursalDAO::search( $esuc );    

    if(sizeof($search) != 1){
        Logger::log("Equipo {$equipo->getIdEquipo()} no se encuentra vinculado a ninguna sucursal");
        return false;
    }

    $suc = $search[0];

    //ver que si exista esta sucursal
    $suc = SucursalDAO::getByPK($suc->getIdSucursal());
    
    if($suc === null){
        Logger::log("equipo {$equipo->getIdEquipo()} vinculado a sucursal {$esuc->getIdSucursal()} pero esta no existe !", 2);
        return false;
    }
    
    if($suc->getActivo() == 0){
        Logger::log("equipo {$equipo->getIdEquipo()} vinculado a suc {$suc->getIdSucursal()} pero esta no esta activa !", 2);
        return false; 
    }

    Logger::log("Sucursal para esta sesion: " . $suc->getIdSucursal() . ", " . $suc->getDescripcion() );

    $_SESSION['sucursal'] 	= $suc->getIdSucursal();
    $_SESSION['id_equipo'] 	= $equipo->getIdEquipo();
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

    return true;

}

function dispatch($args){
	
	Logger::log("Dispatching route for user group {$_SESSION['grupo']} ");
	
	if(!isset($_SESSION['grupo'])){
		Logger::log("Accesso no autorizado ! [No hay grupo]");
		die( "Accesso no autorizado." );
	}
	
	if(!isset($_SERVER['HTTP_REFERER'])){
		//este request tiene que venir de alguien mas
        Logger::log("No hay HTTP_REFERER para esta solicitud de dispatching !", 1);
		die( "Acceso no autorizado." );		
	}
	
	$debug = isset($args['DEBUG']) ? "?debug" : "";


	switch($_SESSION['grupo']){
        case "0" : echo "<script>window.location = 'ingenieria/?i=" . $_SESSION["INSTANCE_ID"] .$debug."'</script>"; break;
		case "1" : echo "<script>window.location = 'admin/?i=" . $_SESSION["INSTANCE_ID"] .$debug."'</script>"; break;
		case "2" : echo "<script>window.location = 'sucursal/sucursal.php?i=" . $_SESSION["INSTANCE_ID"] .$debug."'</script>"; break;
		case "3" : echo "<script>window.location = 'sucursal/sucursal.php?i=" . $_SESSION["INSTANCE_ID"] .$debug."'</script>"; break;
        case "4" : echo "<script>window.location = 'cliente/?i=" . $_SESSION["INSTANCE_ID"] .$debug."'</script>"; break;
	}
}

function validip($ip) {
 	

	if (!( !empty($ip) && ip2long($ip)!=-1)) {
		return false;
	}
 
	$reserved_ips = array (

		array('0.0.0.0','2.255.255.255'),

		array('10.0.0.0','10.255.255.255'),

		array('127.0.0.0','127.255.255.255'),

		array('169.254.0.0','169.254.255.255'),

		array('172.16.0.0','172.31.255.255'),

		array('192.0.2.0','192.0.2.255'),

		array('192.168.0.0','192.168.255.255'),

		array('255.255.255.0','255.255.255.255')

	);


	foreach ($reserved_ips as $r) {

		$min = ip2long($r[0]);

		$max = ip2long($r[1]);

		if ((ip2long($ip) >= $min) && (ip2long($ip) <= $max)) return false;

	}

	return true;
 
}
 
function getip() {

	if ( isset($_SERVER["HTTP_CLIENT_IP"]) && validip($_SERVER["HTTP_CLIENT_IP"])) {
		return $_SERVER["HTTP_CLIENT_IP"] ;
	}

	if( isset($_SERVER["HTTP_X_FORWARDED_FOR"]) ){
		foreach (explode(",",$_SERVER["HTTP_X_FORWARDED_FOR"]) as $ip) {
	 		if (validip(trim($ip))) {
	 			return $ip ;
	 		}
	 	}		
	}

 
	if ( isset($_SERVER["HTTP_X_FORWARDED"]) && validip($_SERVER["HTTP_X_FORWARDED"])) {
 
		return $_SERVER["HTTP_X_FORWARDED"] ;
 
	} elseif ( isset($_SERVER["HTTP_FORWARDED_FOR"]) && validip($_SERVER["HTTP_FORWARDED_FOR"])) {
 
		return $_SERVER["HTTP_FORWARDED_FOR"] ;
 
	} elseif ( isset($_SERVER["HTTP_FORWARDED"]) && validip($_SERVER["HTTP_FORWARDED"])) {
 
		return $_SERVER["HTTP_FORWARDED"] ;
 
	} elseif ( isset($_SERVER["HTTP_X_FORWARDED"]) && validip($_SERVER["HTTP_X_FORWARDED"])) {
 
		return $_SERVER["HTTP_X_FORWARDED"] ;
 
	} else {
 
		return $_SERVER["REMOTE_ADDR"] ;
 
	}

}




function login_controller_dispatch($args){

	if(isset($args['action'])){

		switch($args['action'])
		{
			 
			case '2001':

		        //revisar estado de sesion en sucursal
				if(!sucursalTestToken( $args['pin']  )){
		            //NO paso el test de la sucursal
		           print(  '{"success": false, "response" : "Porfavor utilize un punto de venta destinado para esta sucursal."  }' ) ;

		        }else{

		            //la sucursal esta bien, hay que ver si esta logginiado
		            if( checkCurrentSession( ) ){
		               //logged in !
		                print(  '{"success":true, "sesion":true}' );
		            }else{
		                //not logged in
		                $sucursal = SucursalDAO::getByPK( $_SESSION['sucursal'] );
		                Logger::log("Sesion invalida: cerrando sesion");
		                logOut(false);
		                print(  '{"success":true,"sesion":false,"sucursal":"' .$sucursal->getDescripcion(). '"}' );                    
		            }
		        }
			break;

			case '2002':
				logOut(true);
			break;

			/*
			case '2003':
				sucursalTest();
			break;
			*/

			case '2004':
			   /**
			    * Login de sucursal
			    * 
			    * 
			    * */
				if(!sucursalTest(  )){
		            //si no pasa el test de la sucursal...
		           print(  '{"success": false, "response" : "Porfavor utilize un punto de venta destinado para esta sucursal."  }' ) ;
		        }else{
		            //enviar login
		            login($args['u'], $args['p']);
		        }
			break;




			case '2099':
			   /**
			    * Login de admin/ingeniero
			    * 
			    * 
			    * */
			    if(!isset($args['u'])){
			    	$u = "";
			    }else{
			    	$u = $args['u'];
			    }
			    
			    if(!isset($args['p'])){
			    	$p = "";
			    }else{
			    	$p = $args['p'];
			    }
			    
		        login($u, $p);
			break;






			case '2005':
				dispatch($args);
			break;




			case '2007':
				getUserType();
			break;





			case '2009':
			   /**
			    * Login de clientes
			    * 
			    * Los clientes pueden iniciar sesion para descargar sus facturas
			    * */
		  	  if(!isset($args['u'])){
			    	$u = "";
			    }else{
			    	$u = $args['u'];
			    }
		    
			    if(!isset($args['p'])){
			    	$p = "";
			    }else{
			    	$p = $args['p'];
			    }
		    
		        loginCliente($u, $p);
			break;
		}
	}

}






