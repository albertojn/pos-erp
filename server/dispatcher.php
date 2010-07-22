<?php
/**
* Archivo principal del sistema, por aquí pasan todas la peticiones del cliente.
*
* Este archivo incluye los scripts que estan disponibles en todo el sistema. Ademas
* gestiona los niveles de seguridad de los usuarios y recibe los datos necesarios
* para despues pasarlos a la aplicación adecuada.
*
* @author Manuel Alejandro Gómez Nicasio <alejandro.gomez@alejandrogomez.org>
* @package pos
*/

/**
* Loggin del sistema.
*
* @see logger.php
*/
require_once('mx.caffeina.logger/logger.php');

/**
* Conexión a la base de datos.
*
* @see DBConnection.php
*/
require_once('db/DBConnection.php');

//Comprobamos que la variable que trae la funcion a ejecutar exista y despues 
//entramos al switch.
if ( !isset($_REQUEST['action']) )
{
	echo "{ \"success\": false }";
        return;
}

switch ($_REQUEST['action']) {
    case 'insert_customer':
        $rfc = $_REQUEST['rfc'];
        $nombre = $_REQUEST['nombre'];
        $direccion = $_REQUEST['direccion'];
        $limite_credito = $_REQUEST['limite_credito'];
        $descuento = $_REQUEST['descuento'];
        $telefono = $_REQUEST['telefono'];
        $e_mail = $_REQUEST['e_mail'];
        unset($_REQUEST);
        $ans = insert_customer($rfc, $nombre, $direccion, $limite_credito, $descuento, $telefono, $e_mail);
        echo $ans;
        break;
        
        
        case 'getGridDataClientesDeudores':
        
        	$page = strip_tags($_POST['page']);
		$rp = strip_tags($_POST['rp']);
		$sortname = strip_tags($_POST['sortname']);
		$sortorder = strip_tags($_POST['sortorder']);
		
		if(isset($_POST['query']) && !empty($_POST['query']))
		{
		        $search = strip_tags($_POST['query']);
		        $qtype = strip_tags($_POST['qtype']);
		}
		
		//Si no se envia el dato de page, significa que estamos en la 1
		if(isset($_POST['page']))
		{
			$page = strip_tags($_POST['page']);
		}
		else{
			$page = 1;
		}
        
        	unset($_POST);
        
        	$ans = getGridDataClientesDeudores($page,$rp,$sortname,$sortorder,$search,$qtype, $page);
        	echo $ans;
        
        	break;
        	
        	
//===========================funciones ventas==================================================
	case 'getGridDataVentasPorClientes':
		$page = strip_tags($_POST['page']);
		$rp = strip_tags($_POST['rp']);
		$sortname = strip_tags($_POST['sortname']);
		$sortorder = strip_tags($_POST['sortorder']);
		
		if(isset($_POST['query']) && !empty($_POST['query']))
		{
		        $search = strip_tags($_POST['query']);
		        $qtype = strip_tags($_POST['qtype']);
		}

		unset($_POST);
		
		$ans = getGridDataVentasPorClientes($page,$rp,$sortname,$sortorder,$search,$qtype);
		echo $ans;
		break;
		
	case 'getGridDataVentasACreditoPorClientes':
	
		$id_cliente=$_REQUEST['id_cliente'];
		$de=$_REQUEST['de'];
		$al=$_REQUEST['al'];
		
		//Si no se envia el dato de page, significa que estamos en la 1
		if(isset($_POST['page']))
		{
			$page = strip_tags($_POST['page']);
		}
		else{
			$page = 1;
		}

		unset($_REQUEST);
		
		$ans = getGridDataVentasACreditoPorClientes($id_cliente, $de, $al, $page);
		echo $ans;
		break;
		
	case 'getGridDataVentasDeContadoPorClientes':
	
		$id_cliente=$_REQUEST['id_cliente'];
		$de=$_REQUEST['de'];
		$al=$_REQUEST['al'];
		
		//Si no se envia el dato de page, significa que estamos en la 1
		if(isset($_POST['page']))
		{
			$page = strip_tags($_POST['page']);
		}
		else{
			$page = 1;
		}
				
		unset($_REQUEST);
		
		$ans = getGridDataVentasDeContadoPorClientes($id_cliente, $de, $al, $page);

	
		break;
}

//switch enorme para ejectuar un action de algun modelo.
//aquí va la seguridad del sistema (ACL)
