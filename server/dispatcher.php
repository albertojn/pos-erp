<?php

/**
* Archivo principal del sistema, por aquí pasan todas la peticiones del cliente.
*
* Este archivo incluye los scripts que estan disponibles en todo el sistema. Ademas
* gestiona los niveles de seguridad de los usuarios y recibe los datos necesarios
* para despues pasarlos a la aplicación adecuada.
*
* @package pos
*/



require_once('bootstrap.php');


if( isset($_GET['action'])  && ($_GET['action'] == 666) ){
	var_dump($_SESSION);
	die();
}


//Comprobamos que la variable que trae la funcion a ejecutar exista y despues 
//entramos al switch.
if ( !isset($_REQUEST['action']) )
{
	echo '{ "success": false , "reason" : "Invalid method call for dispatching." }';	
    Logger::log("Invalid method call for dispatching. No hay action en el request.");
    return;
}


require_once('controller/login.controller.php');


//validar los parametros de la conexion, salvo para estos dos que necesitan llegar
//a sus controllers, son verificar estado de sesion y hacer login, dado que al inicio
//no hay token, pues hay que saltar esta validacion, para todas las demas se debera pasar
if( ! (
	//revisar estado de sesion en sucursal
	$_REQUEST['action']  == "2001" 
	
	//logout
	|| $_REQUEST['action']  == "2002" 
	
	//Login de sucursal
	|| $_REQUEST['action']  == "2004" 
	
	//login de admin o ingeniero
	|| $_REQUEST['action']  == "2099"
	
	//login de clientes
	|| $_REQUEST['action']  == "2009" 
) )
{
	
	if(!checkCurrentSession()){
		Logger::log("Sesion invalida ! Cerrando la sesion y forzando reboot.");
		
		//cerrar esta sesion
		logOut(false);
		
		//morir con un js que diga que hay que salir
		die( '{"success": false , "reason": "Accesso denegado" , "reboot" : true }' );
	}
    
}


//solo dejar pasar algunos para el cliente
// 
/*
if( ! (
	//revisar estado de sesion en sucursal
	$_REQUEST['action']  == "2001" 
	
	//logout
	|| $_REQUEST['action']  == "2002" 
	
	//Login de sucursal
	|| $_REQUEST['action']  == "2004" 
	
	//login de admin o ingeniero
	|| $_REQUEST['action']  == "2099"
	
	//login de clientes
	|| $_REQUEST['action']  == "2009" 
) )
{
	
	if(!checkCurrentSession()){
		Logger::log("Sesion invalida ! Cerrando la sesion y forzando reboot.");
		
		//cerrar esta sesion
		logOut(false);
		
		//morir con un js que diga que hay que salir
		die( '{"success": false , "reason": "Accesso denegado" , "reboot" : true }' );
	}
    
}*/


/*
foreach( $_REQUEST as $r ){
	$args = stripslashes( $r ) ....
}
*/

$args = $_REQUEST;
unset($_POST);
unset($_GET);


if( ! (($args['action'] == 1101) || ($args['action'] == 207) )){
	Logger::log("Request for action ".$args['action']." ");	
}


//main dispatching
switch( ((int)($args['action'] / 100))*100 )
{
	
	case 100: 
		require_once('controller/mostrador.controller.php');
	break;
	
	case 200:
		require_once('controller/autorizaciones.controller.php');
	break;
	
	case 300:
		require_once('controller/clientes.controller.php');
	break;
	
	case 400: 
		require_once('controller/inventario.controller.php');
	break;
	
	case 500: 
		require_once('controller/personal.controller.php');
	break;
	
	case 600: 
		require_once('controller/efectivo.controller.php');
	break;

	case 700:
		require_once('controller/sucursales.controller.php');
	break;

	case 800:
		require_once('controller/ventas.controller.php');
	break;

	case 900:
		require_once('controller/proveedor.controller.php');
	break;
	
	case 1000:
		require_once('controller/compras.controller.php');
	break;
	
	case 1100:
		require_once('controller/pos.controller.php');
	break;
	
	case 1200:
	    require_once('controller/factura.controller.php');
	break;

    case 1300:
	    require_once('controller/printer.controller.php');
	break;
	
	case 2000:
		//ya he requerido a controller/login.controller.php
		//llamare a su funcion especial login_controller_dispatch()
		//que contiene su switch principal
		login_controller_dispatch($args);
	break;
	
}

return;

