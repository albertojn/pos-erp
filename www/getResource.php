<?php

if (substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();

//requerir la configuracion
require ( "../server/config.php" );



/* 
 * Este archivo es para el JSloader, recibe un parametro que es la carpeta dentro de js,
 * y regresa todos los archivos dentro de esa carpeta para que javascript los cargue 
 */





	//cargar cada directorio
	function loadDir( $dir, $type )
	{


		//leeer los archivos en ese directorio
		$address = '../'.$type.'/'.$dir.'/';
		
		if ($handle = opendir($address)) {
			
		    while ($file = readdir($handle)) {
				
				if( endsWith( $file, "." . $type ) ){
					echo file_get_contents($address . $file) . "\n";

				}
				
				
				
		    }//directory loop

		    closedir($handle);
		}
		
		
		


	}


	//revisar parametros
	if(! ( isset($_REQUEST['mod']) && isset($_REQUEST['type'] ) )) die("{success: false}");
	
	$module = $_REQUEST['mod'];
	$type = $_REQUEST['type'];

	
	
	//imprimir el header
	switch($type)
	{
		case 'js' : header('Content-Type:text/javascript'); break;
		case 'css' : header('Content-Type:text/css'); break;
		default : die("{success: false}");
		
	}
	
	
	
	
	switch($module)
	{
		//cargar modulos de admin
		case 'admin' :
			
			if(isset($_SESSION['grupo']) && ($_SESSION['grupo'] == 1 || $_SESSION['grupo'] == 0))
				loadDir( $module, $type );
			else
				die("/* ACCESO DENEGADO */");
		break;
		
		//cargar modulos de sucursal
		case 'sucursal':
		
			if(!isset($_SESSION['grupo']))
				die(" /* ACCESO DENEGADO */ window.location = '.'; /* ACCESSO DENEGADO */ ");
			
			if($type == "css"){
				loadDir($module, $type);
				break;
			}
			
			echo "Ext.ns('POS', 'sink', 'Ext.ux');";			

			//cargar modulos de sucursal
			loadDir( "sucursal/pre" , $type );


            //imprimir que tipo de usuario soy
            if(isset($_SESSION['grupo']))
            	echo "POS.U.g = " . (($_SESSION['grupo'] == 2) ? "true" : "false" ) . ";";



			loadDir( "sucursal/apps" , $type );
						
						
			if($_SESSION['grupo'] == 2 ){
				//si es gerente tambien cargar los de gerencia
				loadDir( "sucursal/apps/gerente" , $type );
			}
			
			loadDir( "sucursal/post" , $type );

		break;
		
		
		//cargar modulos compartidos
		case 'shared': loadDir( $module, $type ); break;
		
		//cargar login
		case 'login' : loadDir( $module, $type ); break;
		
		default : die("{success: false}");
		
	}
	

?>
