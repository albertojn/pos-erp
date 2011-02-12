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



require_once('config.php');

require_once('logger.php');



//Comprobamos que la variable que trae la funcion a ejecutar exista y despues 
//entramos al switch.
if ( !isset($_REQUEST['action']) )
{
	echo "{ \"success\": false , \"reason\" : \"Invalid method call for dispatching.\" }";
    Logger::log("Invalid method call for dispatching. No hay action en el request.");
    return;
}


require_once('controller/login.controller.php');


//validar los parametros de la conexion, salvo para estos dos que necesitan llegar
//a sus controllers, son verificar estado de sesion y hacer login, dado que al inicio
//no hay token, pues hay que saltar esta validacion, para todas las demas se debera pasar
if( ! ($_REQUEST['action']  == "2001" || $_REQUEST['action']  == "2004" || $_REQUEST['action']  == "2099") )
{
	if(!checkCurrentSession()){
		Logger::log("Sesion invalida.");
		die( '{"success": false , "reason": "Accesso denegado" }' );
	}
    
}





/*
foreach( $_REQUEST as $r ){
	$args = stripslashes( $r ) ....
}
*/
$args = $_REQUEST;
unset($_POST);
unset($_GET);

Logger::log("Iniciando peticion (".$args['action'].") !");

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
	
	case 2000:
		//ya he requerido a controller/login.controller.php
		//llamare a su funcion especial login_controller_dispatch()
		//que contiene su switch principal
		login_controller_dispatch($args);
	break;
	
}

return;

