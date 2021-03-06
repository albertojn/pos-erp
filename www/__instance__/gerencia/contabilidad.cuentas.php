<?php

		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server//bootstrap.php");

		$page = new GerenciaTabPage();
		$controller = new ContabilidadController();
		$page->requireParam(  "idcc", "GET", "Este catalogo de cuentas no existe." );
		$catalogo = $controller::DetalleCatalogoCuentas( $_GET["idcc"] );

		$page->addComponent(new TitleComponent($catalogo["descripcion"], 2));

		$page->addComponent( "<div class='POS Boton' onClick='window.location=\"contabilidad.cuentas.catalogo.php\"'> << Regresar</div> " );

		$page->addComponent( "<div class='POS Boton' onClick='window.location=\"contabilidad.cuentas.nueva.php?idcc={$_GET["idcc"]}\"'>Nueva Cuenta</div> " );

		$lista = ContabilidadController::BuscarCuenta($_GET["idcc"]);

		$page->addComponent(sizeof($lista["resultados"]) ." cuentas.");
		
		$tabla = new TableComponent( 
			array(
				"clave"							=> "Clave",
				"nombre_cuenta"					=> "Cuenta",
				"tipo_cuenta"					=> "Tipo",
				"naturaleza"					=> "Naturaleza",
				"clasificacion"					=> "Clasificacion",
				"es_cuenta_mayor"				=> "Cuenta Mayor",
				"es_cuenta_orden"				=> "Cuenta de Orden",
				"afectable"						=> "Afectable"
			),
			$lista["resultados"]
		);

		function funcion_bool_to_string($valor){
			return ($valor===true || $valor==="1" || $valor===1) ? "Si" : "No";
        }

        $tabla->addColRender("es_cuenta_orden", "funcion_bool_to_string");
        $tabla->addColRender("es_cuenta_mayor", "funcion_bool_to_string");
        $tabla->addColRender("afectable", "funcion_bool_to_string");

		$tabla->convertToExtJs(false);
 		$tabla->addOnClick( "id_cuenta_contable", "(function(a){ window.location = 'contabilidad.cuentas.ver.php?cid=' + a; })" );

		$page->addComponent( $tabla );

		$page->render();





