<?php



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage();

		$page->addComponent( new TitleComponent( "Proveedores" ) );
		$page->addComponent( new MessageComponent( "Lista de proveedores" ) );



		$proveedoresLista =  ProveedoresController::Lista();

		$tabla = new TableComponent(
			array(
				"nombre"                        => "Nombre",
				"id_categoria_contacto" 	    => "Clasificacion de proveedor",
				"activo"                        => "Activo",
				"consignatario"                 => "Consignatario"
			),
			$proveedoresLista["resultados"]

		);

		$tabla->addColRender("id_categoria_contacto", "funcion_clasificacion_proveedor");
		$tabla->addColRender("activo", "funcion_activo");
		$tabla->addColRender("consignatario", "funcion_consignatario");

		$tabla->addOnClick( "id_usuario", "(function(a){ window.location = 'proveedores.ver.php?pid=' + a; })" );


		$page->addComponent( $tabla );

		$page->render();
