<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server//bootstrap.php");

	$page = new GerenciaTabPage();

	// Parametros necesarios
	//
	$page->requireParam("cid", "GET", "Este cliente no existe.");


	$este_cliente = UsuarioDAO::getByPK($_GET["cid"]);

	//titulos
	$page->addComponent(new TitleComponent("Editando a " . $este_cliente->getNombre(), 2));


	$page->nextTab("General");
	$form = new DAOFormComponent($este_cliente);

	$form->hideField(array(
		"id_usuario",
		"id_rol",
		"id_clasificacion_proveedor",
		"id_direccion",
		"id_direccion_alterna",
		"fecha_asignacion_rol",
		"comision_ventas",
		"fecha_alta",
		"fecha_baja",
		"activo",
		"last_login",
		"salario",
		"dias_de_embarque",
		"consignatario",
		"tiempo_entrega",
		"cuenta_bancaria",
		"mensajeria",
		"token_recuperacion_pass",
		"ventas_a_credito",
		"dia_de_pago",
		"dia_de_revision",
		"id_clasificacion_cliente"
	));

	$form->renameField(array(
		"id_usuario" => "id_cliente"
	));

	$form->sendHidden("id_cliente");

	$form->setValueField("password", "");


	$form->createComboBoxJoin("id_moneda", "nombre", MonedaDAO::search(new Moneda(array(
		"activa" => 1
	))), $este_cliente->getIdMoneda());

	$clasificaciones = ContactosController::BuscarCategoria();
	$clasificaciones = $clasificaciones['categorias'];
	foreach ($clasificaciones as $key => $clasificacion) {
		$clasificacion->caption = $clasificacion->nombre;
		$clasificaciones[$key] = $clasificacion->asArray();
	}
	$form->createComboBoxJoin(
		'id_categoria_contacto',
		'nombre',
		$clasificaciones
	);

	$form->createComboBoxJoin("id_sucursal", "razon_social", SucursalDAO::search(new Sucursal(array(
		"activa" => 1
	))), $este_cliente->getIdSucursal());
	$form->createComboBoxJoinDistintName("id_tarifa_venta", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))));
	$form->createComboBoxJoin("id_tarifa_compra", "nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"compra"))));
	$form->createComboBoxJoin( "tarifa_compra_obtenida", "tarifa_compra_obtenida", array("rol", "proveedor", "cliente","usuario") );
	$form->createComboBoxJoin( "tarifa_venta_obtenida", "tarifa_venta_obtenida", array("rol", "proveedor", "cliente","usuario") );

	$form->addApiCall("api/cliente/editar/", "POST");
	$form->onApiCallSuccessRedirect("clientes.ver.php?cid=" . $_GET["cid"]);



	$form->renameField(array(
		"nombre" => "razon_social",
		"codigo_usuario" => "codigo_cliente",
		"correo_electronico" => "email",
		"id_categoria_contacto" => "clasificacion_cliente",
		"id_moneda" => "moneda_del_cliente",
		"pagina_web" => "sitio_web",
		"id_sucursal" => "sucursal"
	));

	$page->addComponent($form);

































	$page->nextTab("Otros");


	//buscar los parametros extra
	$out = ExtraParamsValoresDAO::getVals("usuarios", $este_cliente->getIdUsuario());

	$epform = new FormComponent();
	$epform->setEditable(true);


	foreach($out as $ep){
		$epform->addField($ep["campo"], $ep["caption"], $ep["tipo"], $ep["val"]);

		if(!is_null($ep["descripcion"])){
			$epform->setHelp($ep["campo"], $ep["descripcion"]);
		}

	}

	$epform->beforeSend("editar_extra_p");

	$page->addComponent('
			<script>
				var cliente = ' . $_GET["cid"] . ';
				function editar_extra_p(obj){
					return	{
						id_cliente		: cliente,
						extra_params	: Ext.JSON.encode(obj)
					}
				}
			</script>
		');
	$epform->addApiCall("api/cliente/editar/", "POST");
	$page->addComponent($epform);


























	$page->nextTab("Direccion");

	if(is_null($este_cliente->getIdDireccion())){

		//no existe direccion
		Logger::log("El uid=" . $_GET["cid"] . " no tiene direccion. Insertando." );

		DireccionController::NuevaDireccionParaUsuario(  $_GET["cid"] );

		//recargar el objeto de cliente
		$este_cliente = UsuarioDAO::getByPK( $_GET["cid"] );
	}



	$esta_dir = DireccionDAO::getByPK($este_cliente->getIdDireccion());


	if(is_null($esta_dir)){
		//esta definida pero el registro no existe por alguna razon
		Logger::error("user " . $_GET["cid"] . " se supone que tiene id direccion = " .$este_cliente->getIdDireccion()   . " , pero esta en null ...");

		DAO::transBegin();

		$este_cliente->setIdDireccion(NULL);

		try{
			UsuarioDAO::save($este_cliente);

			DireccionController::NuevaDireccionParaUsuario(  $este_cliente->getIdUsuario() );

			//recargar el objeto de cliente
			$este_cliente = UsuarioDAO::getByPK( $_GET["cid"] );

		} catch(Exception $e) {
			DAO::transRollback();
			throw new Exception("No se pudo crear la direccion: ".$e);

		}

		DAO::transEnd();

	}





	$esta_dir = DireccionDAO::getByPK($este_cliente->getIdDireccion());



	//titulos


	//forma de nuevo cliente

	$form = new DAOFormComponent($esta_dir);

	$form->hideField(array(
		"id_direccion",
		"id_usuario_ultima_modificacion",
		"ultima_modificacion"
	));

	$form->sendHidden("id_direccion");

	$form->createComboBoxJoin("id_ciudad", "nombre", CiudadDAO::getAll(), $esta_dir->getIdCiudad());
	$form->setCaption("id_ciudad", "Ciudad");

	$form->addApiCall("api/cliente/editar/");
	$form->beforeSend("editar_direccion");




	$page->addComponent('
			<script>
				var cliente = ' . $_GET["cid"] . ';
				function editar_direccion(obj){
					return	{
						id_cliente		: cliente,
						direcciones 		: Ext.JSON.encode([obj])
					}
				}
			</script>
		');

	$form->onApiCallSuccessRedirect("clientes.ver.php?cid=".$_GET["cid"]."");

	$page->addComponent($form);








	//render the page
	$page->render();
