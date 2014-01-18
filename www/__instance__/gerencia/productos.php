<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaTabPage();

	$page->addComponent(new TitleComponent( "Productos" ));

	$page->nextTab("Lista");

	$cols = array(
		"codigo_producto" 	=> "Codigo producto",
		"nombre_producto"	=> "Nombre Producto",
		"id_unidad" 		=> "Existencias",
		"precio" 			=> "Precio",
		"activo"			=>	"Activo"
	);


	$tabla = new TableComponent(
		$cols,
		ProductosController::Lista( )
	);


	function precio( $precio, $obj )
	{
		if( $obj["metodo_costeo"] === "costo" )
		{
			return FormatMoney( $obj["costo_estandar"] );
		}

		return FormatMoney( $precio );
	}

	function calcExistencias($id_unidad, $row)
	{
		$unidadM = UnidadMedidaDAO::getByPK($id_unidad);

		if( is_null( $unidadM ) )
		{
			return ProductoDAO::ExistenciasTotales( $row["id_producto"] );
		}

		return ProductoDAO::ExistenciasTotales( $row["id_producto"] ) . " " . $unidadM->getAbreviacion();
	}



	$tabla->addColRender("activo", "funcion_activo");
	$tabla->addColRender( "precio", "precio" );
	$tabla->addColRender( "id_unidad" , "calcExistencias");
	$tabla->addOnClick( "id_producto", "(function(a){ window.location = 'productos.ver.php?pid=' + a; })" );

	$page->addComponent( $tabla );
	


	$page->nextTab("Unidades");


	$page->addComponent(new TitleComponent("Lista de unidades existentes", 2));

	$u = ProductosController::BuscarUnidadUdm(   );

	$tUnidades = new TableComponent(array(
	"id_categoria_unidad_medida" =>"Categoria",
	"abreviacion" =>"Nombre",
	"factor_conversion" => "Factor de conversion",
	"activa" =>"Activa"
	),$u["resultados"]);

	function nombreRender($v, $obj){
	return $obj["descripcion"] . " (". $v .")";
	}

	function uCatRender($v, $obj){
	$c = CategoriaUnidadMedidaDAO::getByPK($v);
	return $c->getDescripcion();
	}

	function uFactorConversion($fConversion, $obj){
	//if($fConversion == 1) return "-";

	//de lo contrario, buscar a que categoria pertenece
	//y poner $fConversion . unidad_referencia
	$ref = UnidadMedidaDAO::search( new UnidadMedida( array(
	"id_categoria_unidad_medida" => $obj["id_categoria_unidad_medida"],
	"tipo_unidad_medida" => "Referencia UdM para esta categoria"
	)) );

	if(sizeof($ref) == 0){
	return "Error. No hay unidad ref.";
	}

	if(sizeof($ref) > 1){
	return "Error. Hay mas de una ref.";
	}

	return $fConversion . " " . $ref[0]->getDescripcion();

	}


	$tUnidades->addColRender("factor_conversion", "uFactorConversion");		
	$tUnidades->addColRender("id_categoria_unidad_medida", "uCatRender");		
	$tUnidades->addColRender("abreviacion", "nombreRender");
	$page->addcomponent($tUnidades);






	$page->addComponent(new TitleComponent("Nueva unidad de medida", 2));





	$nudmf = new DAOFormComponent(new UnidadMedida());
	$nudmf->hideField(array("id_unidad_medida"));
	$nudmf->addApiCall("api/producto/udm/unidad/nueva", "POST");
	$nudmf->createComboBoxJoin("id_categoria_unidad_medida", "descripcion", CategoriaUnidadMedidaDAO::getAll());
	$nudmf->createComboBoxJoin(	"tipo_unidad_medida", "desc", array( "desc" => "Referencia UdM para esta categoria","Mayor que la UdM de referencia","Menor que la UdM de referencia" ) );
	$nudmf->createComboBoxJoin(	"activa", null,  array( "Si", "No" ) );
	$nudmf->setCaption("id_categoria_unidad_medida", "Categoria");
	$nudmf->makeObligatory(array("abreviacion", "descripcion", "factor_conversion", "id_categoria_unidad_medida", "tipo_unidad_medida"));
	$page->addComponent( $nudmf );





	$page->addComponent(new TitleComponent("Nueva categoria de unidad de medida", 2));
	$ncudmf = new DAOFormComponent(new CategoriaUnidadMedida());
	$ncudmf->hideField(array("id_categoria_unidad_medida"));
	$ncudmf->createComboBoxJoin(	"activa", null,  array( "Si", "No" ) );
	$ncudmf->addApiCall("api/producto/udm/categoria/nueva", "POST");
	$ncudmf->makeObligatory(array("descripcion"));
	$page->addComponent( $ncudmf );





	$page->render();






