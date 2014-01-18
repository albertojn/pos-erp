<?php

	/**
	* Description:
	*	Detalles de una sucursal
	*
	* Author:
	*     Juan Manuel Garcia Carmona <manuel@caffeina.mx>
	*     Alan Gonzalez <alan@caffeina.mx>
	*
	**/

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaTabPage(  );

	// Parametros necesarios
	$page->requireParam(  "sid", "GET", "Esta sucursal no existe." );
	$esta_sucursal = SucursalDAO::getByPK( $_GET["sid"] );

	$menu = new MenuComponent();
	$menu->addItem("Editar", "sucursales.editar.php?sid=".$_GET["sid"]);
	
	// Menu de opciones
	if ($esta_sucursal->getActiva()) {		
		$menu->addItem("Corte", "ventas.corte.php?sid=".$_GET["sid"]);

		$btn_eliminar = new MenuItem("Desactivar", null);
		$btn_eliminar->addApiCall("api/sucursal/eliminar", "POST");
		$btn_eliminar->onApiCallSuccessRedirect("sucursales.lista.php");
		$btn_eliminar->addName("eliminar");

		$funcion_eliminar = "function eliminar_sucursal (btn) {"
						  . "	if (btn == 'yes') {"
						  . "		var p = {};"
						  . "		p.id_sucursal = ".$_GET["sid"].";"
						  . "		sendToApi_eliminar(p);"
						  . "	}"
						  . "}"
						  . "function confirmar () {"
						  . "	Ext.MessageBox.confirm('Desactivar', '&iquest;Desea eliminar esta sucursal?', eliminar_sucursal );"
						  . "}";

		$btn_eliminar->addOnClick("confirmar", $funcion_eliminar);

		$menu->addMenuItem( $btn_eliminar );
	}

	$page->addComponent( $menu );

	// Titulo de la pagina
	$page->addComponent(new TitleComponent("Detalles de sucursal"));
	$page->addComponent(new TitleComponent($esta_sucursal->getDescripcion(), 2));

	/*
	 * Tab Detalles
	 */
	$page->nextTab("Detalles");

	$esta_direccion = DireccionDAO::getByPK($esta_sucursal->getIdDireccion());
	if (is_null( $esta_direccion)) {
		$esta_direccion = new Direccion();
	}

	$form = new DAOFormComponent($esta_sucursal);
	$form->setEditable(false);
	$form->hideField(array( 
		"id_sucursal",
		"id_direccion",
		"id_gerente",
		"fecha_apertura",
		"fecha_baja"
	));

	$form->createComboBoxJoin( "id_tarifa", "nombre", TarifaDAO::getAll(), $esta_sucursal->getIdTarifa());
	$form->setCaption("id_tarifa", "Tarifa");
	$form->addField("fecha_apertura_format", "Fecha Apertura", "text", FormatTime($esta_sucursal->getFechaApertura()), "fecha_apertura_format");
	$form->addField("fecha_baja_format", "Fecha Baja", "text", FormatTime($esta_sucursal->getFechaBaja()), "fecha_baja_format");
	$form->createComboBoxJoin("activa", "activa", array(
		array("id" => false, "caption" => "No"),
		array("id" => true, "caption" => "S&iacute;")
	), $esta_sucursal->getActiva());

	$page->addComponent( $form );

	if (!is_null($esta_sucursal->getIdDireccion())) {
		$page->addComponent(new TitleComponent("Direcci&oacute;n", 3));
		$form = new DAOFormComponent($esta_direccion);
		$form->setEditable(false);
		$form->hideField(array("id_direccion", "id_usuario_ultima_modificacion"));
		$form->createComboBoxJoin("id_ciudad", "nombre", CiudadDAO::getAll(), $esta_direccion->getIdCiudad());
		$page->addComponent($form);
	}

	/*
	 * Tab Cajas
	 */
	$page->nextTab("Cajas");
	$page->addComponent(new TitleComponent("Cajas", 3));

	$tabla = new TableComponent(array(
		"descripcion"=> "Descripcion",
		"abierta"=> "Abierta",
		"activa"=>"Activa"
	), SucursalesController::ListaCaja(NULL, $_GET["sid"]));

	$tabla->addColRender("abierta", "funcion_abierta");
	$tabla->addColRender("activa", "funcion_activa");

	$tabla->addOnClick( "id_caja", "(function(a){window.location = 'sucursales.caja.ver.php?cid='+a;})" );
	$tabla->addNoData("No hay ninguna caja asociada a esta sucursal. <a href='sucursales.nueva.caja.php'>&iquest; Desea agregar un elemento?.</a>");
	
	$page->addComponent($tabla);

	/*
	 * Tab Almacenes
	 */
	$page->nextTab("Almacenes");
	$page->addComponent(new TitleComponent("Almacenes" , 3));

	$sucs = AlmacenesController::Buscar();

	$tabla = new TableComponent(array(
		"nombre" => "Nombre",
		"id_empresa"=> "Empresa",
		"id_tipo_almacen"=> "Tipo de almacen",
		"activo"=> "Activo"
	),$sucs["resultados"]);

	$tabla->addColRender("id_empresa", "funcion_empresa");
	$tabla->addColRender("id_tipo_almacen", "funcion_tipo_almacen");
	$tabla->addColRender("activo", "funcion_activo");
	$tabla->addOnClick( "id_almacen", "(function(a){window.location = '#';})" );
	$tabla->addNoData("No hay ningun almacen asociado a esta sucursal. <a href='#'>&iquest; Desea agregar un elemento?.</a>");

	$page->addComponent($tabla);

	/*$page->addComponent(new TitleComponent("Nuevo almacen en esta sucursal", 2 ));

	$nalmacen_obj = new Almacen();
	$nalmacen_obj->setIdSucursal($esta_sucursal->getIdSucursal());

	$nalmacen = new DAOFormComponent($nalmacen_obj);
	$nalmacen->hideField(array(
		"id_sucursal",
		"id_almacen"
	));

	$nalmacen->sendHidden("id_sucursal");

	$nalmacen->createComboBoxJoin("id_tipo_almacen", "descripcion", TipoAlmacenDAO::GetAll());	
	$nalmacen->createComboBoxJoin("id_empresa", "razon_social", EmpresaDAO::GetAll() );
	$nalmacen->createComboBoxJoin("activo", "foo", array("foo" => "si"));

	$nalmacen->addApiCall("api/almacen/nuevo", "POST");
	$nalmacen->onApiCallSuccessRedirect("sucursales.ver.php?sid=". $_GET["sid"]."");

	$nalmacen->setCaption("id_tipo_almacen", "Tipo de almacen");
	$nalmacen->setCaption("id_empresa", "Empresa");
	$nalmacen->makeObligatory(array("id_empresa", "id_sucursal", "id_tipo_almacen", "nombre"));
	
	$page->addComponent($nalmacen);*/
	
	$page->render();
