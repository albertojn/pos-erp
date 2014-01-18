<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaComponentPage();

	//
	// Titulo
	//
	$page->addComponent(new TitleComponent("Nuevo Producto", 2));


	//
	// Forma de nuevo producto
	//
	$form = new DAOFormComponent(new Producto());
	$form->addApiCall("api/producto/nuevo/");
	$form->onApiCallSuccessRedirect("productos.lista.php");
	$form->renameField(array( "precio" => "precio_de_venta" ));
	$form->hideField(array( "id_producto", "peso_producto" ));
	$form->renameField( array("descripcion" => "descripcion_producto"));


	$form->makeObligatory(array(
	    "compra_en_mostrador",
	    "nombre_producto",
	    "id_empresas",
	    "codigo_producto",
	    "metodo_costeo",
	    "activo",
	    "id_unidad_compra",
	    "id_unidad"
	));

	$form->createComboBoxJoinDistintName("id_unidad_compra","id_unidad_medida" ,"descripcion", UnidadMedidaDAO::search(new UnidadMedida(array(
	    "activa" => 1
	))));

	$form->setCaption("id_unidad_compra", "Unidad de compra");

	$form->createComboBoxJoinDistintName("id_unidad", "id_unidad_medida", "descripcion", UnidadMedidaDAO::search(new UnidadMedida(array(
	    "activa" => 1
	))));

	$form->setCaption("id_unidad", "Unidades de este producto");

	$form->createComboBoxJoin("metodo_costeo", "metodo_costeo", array(
	    "precio",
	    "costo"
	));

	$form->createComboBoxJoin("compra_en_mostrador", "compra_en_mostrador", array(
	    array(
	        "id" => 1,
	        "caption" => "Si"
	    ),
	    array(
	        "id" => 0,
	        "caption" => "No"
	    )
	), 1);

	$form->createComboBoxJoin("visible_en_vc", "visible_en_vc", array(
	    array(
	        "id" => 1,
	        "caption" => "Si"
	    ),
	    array(
	        "id" => 0,
	        "caption" => "No"
	    )
	), 1);

	$form->createComboBoxJoin("activo", "activo", array(
	    array(
	        "id" => 1,
	        "caption" => "Si"
	    ),
	    array(
	        "id" => 0,
	        "caption" => "No"
	    )
	), 1);

	$page->addComponent($form);

	//
	// Render the page
	//
	$page->render();
