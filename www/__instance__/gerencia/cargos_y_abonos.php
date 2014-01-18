<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaTabPage( );

	$page->addComponent( new TitleComponent( "Cargos y abonos", 1 ));

	$page->nextTab( "Overview" );
	$rep = new ReporteComponent( );
	$dataForReportTotal = array();
	$ingresos = CargosYAbonosController::ListaIngreso( );
	$listaIngresos = $ingresos["resultados"];

	$dataForReportIngresos = array();
	foreach($listaIngresos as $d) {
		array_push($dataForReportIngresos, array(
				"fecha" => date( "Y-m-d" ,$d->fecha_del_ingreso),
				"value" => $d->monto
			));
	}


	$gastos = CargosYAbonosController::ListaGasto( );
	$listaGastos = $gastos["resultados"];
	$dataForReportGastos = array();
	foreach($listaGastos as $d) {
		array_push($dataForReportGastos, array(
				"fecha" => date( "Y-m-d" ,$d->fecha_del_gasto),
				"value" => $d->monto
			));
	}


	$rep->agregarMuestra	( "uno", $dataForReportGastos, false );
	$rep->agregarMuestra	( "dos", $dataForReportIngresos, false );
	$rep->fechaDeInicio( strtotime( "2012-01-01"));
	$page->addComponent($rep);

	/*
	$r = new ReporteComponent();
	$data = array(
		array(
			"fecha" => "2012-01-01",
			"value" => "15"
		),
		array(
			"fecha" => "2012-01-02",
			"value" => "20"
		),		
		array(
			"fecha" => "2012-01-03",
			"value" => "25"
		)		
	);
	
	$data = EmpresasController::flujoEfectivo( (int)$_GET["eid"] );

	$r->agregarMuestra	( "uno", $data, true );
	$r->fechaDeInicio( strtotime( "2012-03-01"));
	$page->addComponent($r);
	*/


	$page->nextTab( "Gastos" );

	/*
	 * Nuevo Gasto
	 **/
	$page->addComponent( new TitleComponent( "Nuevo Gasto" , 3 ) );
	$form = new DAOFormComponent(array(
		new Gasto( ),
		//new ConceptoGasto( )
	));

	$form->hideField( array(
		//"activo",
		"cancelado",
		"id_usuario",
		"id_gasto",
		"motivo_cancelacion",
		"fecha_de_registro",
		"id_sucursal",
		"id_caja",
		"id_orden_de_servicio",
		//"nombre"
	));

	$form->createComboBoxJoin( "id_empresa", "razon_social", EmpresaDAO::getAll( ) );
	$form->createComboBoxJoin( "id_concepto_gasto", "nombre", ConceptoGastoDAO::getAll( ) );
	$form->createComboBoxJoin( "id_caja", "descripcion", CajaDAO::getAll( ) );
	$form->makeObligatory( array( "fecha_del_gasto", "monto", "id_empresa", "id_concepto_gasto" ) );

	//this should be post
	$form->addApiCall("api/cargosyabonos/gasto/nuevo", "POST");
	$form->onApiCallSuccess("window.location.reload");

	$form->setCaption("id_empresa", "Empresa");
	$form->setCaption("id_concepto_gasto", "Concepto");
	$form->renameField( array(
		"fecha_del_gasto" => "fecha_gasto", 
	) );
	$form->setType( "fecha_gasto", "date" );

	$page->addComponent( $form );

	/*
	 * Lista de gastos
	 **/
	$page->addComponent( new TitleComponent( "Gastos", 3 ) );
	$lista = CargosYAbonosController::ListaGasto( );
	$tabla = new TableComponent(
		array(
			"id_empresa"			=> "Empresa",
			"id_concepto_gasto"		=> "Concepto",
			"id_usuario"			=> "Usuario",
			"descripcion"			=> "Descripcion",
			"fecha_del_gasto"		=> "Fecha",
			"monto"					=> "Monto"
		),
		$lista["resultados"]
	);

	$tabla->addColRender( "id_empresa", 		"R::RazonSocialFromIdEmpresa");
	$tabla->addColRender( "monto", 				"R::MoneyFromDouble");
	$tabla->addColRender( "id_concepto_gasto", 	"R::ConceptoGastoFromId" );
	$tabla->addColRender( "fecha_del_gasto", 	"R::FriendlyDateFromUnixTime");
	$tabla->addColRender( "id_usuario", 		"R::UserFullNameFromId");
	$tabla->addColRender( "cancelado", 			"funcion_cancelado" );
	$page->addComponent( $tabla );





	$page->nextTab( "Ingresos" );


	/*
	 * Nuevo Ingreso
	 **/
	$page->addComponent( new TitleComponent( "Nuevo Ingreso" , 3 ) );

	$form = new DAOFormComponent( array(
		new Ingreso( ),
		//new ConceptoIngreso( )
	));

	$form->hideField( array(
		//"activo",
		"cancelado",
		"id_usuario",
		"id_ingreso",
		"motivo_cancelacion",
		"fecha_de_registro",
		"id_sucursal",
		"id_caja"
	));

	$form->createComboBoxJoin( "id_empresa", "razon_social", EmpresaDAO::getAll( ) );
	$form->createComboBoxJoin( "id_concepto_ingreso", "nombre", ConceptoIngresoDAO::getAll( ) );
	$form->createComboBoxJoin( "id_caja", "descripcion", CajaDAO::getAll( ) );
	$form->makeObligatory( array( "fecha_del_ingreso", "monto", "id_empresa", "id_concepto_ingreso" ) );
	$form->renameField( array(
		"fecha_del_ingreso" => "fecha_ingreso", 
	) );
	$form->onApiCallSuccess("window.location.reload");
	$form->setCaption("id_empresa", "Empresa");
	$form->setCaption("id_concepto_ingreso", "Concepto");
	$form->setType( "fecha_ingreso", "date" );
	$form->addApiCall( "api/cargosyabonos/ingreso/nuevo", "POST" );
	
	$page->addComponent( $form );



	/*
	 * Lista de ingresos
	 **/
	$page->addComponent( new TitleComponent( "Ingresos", 3 ) );
	$lista = CargosYAbonosController::ListaIngreso( );

	$tabla = new TableComponent( array(
				"id_empresa"	 		=> "Empresa",
				"id_concepto_ingreso"	=> "Concepto",
				"id_usuario"			=> "Usuario",
				"descripcion"			=> "Descripcion",
				"fecha_del_ingreso"		=> "Fecha",
				"monto"					=> "Monto"
			),
			$lista["resultados"]
		);

	$tabla->addColRender( "cancelado", 				"funcion_cancelado" );
	$tabla->addColRender( "id_empresa", 			"R::RazonSocialFromIdEmpresa");
	$tabla->addColRender( "monto",					"R::MoneyFromDouble");
	$tabla->addColRender( "id_concepto_ingreso",	"R::ConceptoIngresoFromId" );
	$tabla->addColRender( "fecha_del_ingreso",		"R::FriendlyDateFromUnixTime");
	$tabla->addColRender( "id_usuario",				"R::UserFullNameFromId");
	$tabla->addColRender( "cancelado",				"funcion_cancelado" );
	$page->addComponent( $tabla );



	/*
	 * Conceptos de ingresos
	 **/
	$gastos = ContabilidadController::ListarCuentasConceptosGastos();

	$ingresos = ContabilidadController::ListarCuentasConceptosIngresos();

	$page->nextTab( "Conceptos" );
	$page->addComponent( new TitleComponent( "Nuevo concepto de ingreso" , 3 ) );
	$form = new DAOFormComponent( new ConceptoIngreso() );
	$form->addApiCall( "api/cargosyabonos/ingreso/concepto/nuevo", "POST" );
	$form->onApiCallSuccessRedirect("cargos_y_abonos.php");
	$form->hideField( array( "id_concepto_ingreso" ) );
	$form->hideField( array( "activo" ) );
	$form->createComboBoxJoin( "id_cuenta_contable", "nombre_cuenta", $ingresos["resultados"]);

	$form->makeObligatory( array( "nombre" ) );
	$form->makeObligatory( array( "id_cuenta_contable" ) );
	$page->addComponent( $form );

	/*
	 * Conceptos de gasto
	 **/
	$form = new DAOFormComponent( new ConceptoGasto() );
	$page->addComponent( new TitleComponent( "Nuevo concepto de gasto" , 3 ) );
	$form->addApiCall( "api/cargosyabonos/gasto/concepto/nuevo", "POST" );
	$form->onApiCallSuccessRedirect("cargos_y_abonos.php");
	$form->hideField( array( "id_concepto_gasto" ) );
	$form->hideField( array( "activo" ) );
	$form->createComboBoxJoin( "id_cuenta_contable", "nombre_cuenta", $gastos["resultados"]);

	$form->makeObligatory( array( "nombre" ) );
	$form->makeObligatory( array( "id_cuenta_contable" ) );
	$page->addComponent( $form );

	$page->render( );
