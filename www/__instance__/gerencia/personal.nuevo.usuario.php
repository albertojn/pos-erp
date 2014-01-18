<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaComponentPage();

	//titulos
	$page->addComponent(new TitleComponent("Nuevo Usuario"));

	//forma de nuevo usuario
	$page->addComponent(new TitleComponent("Datos del usuario", 3));
	
	$page->addComponent("<p>Si desea enviar un mensaje de bienvenida al nuevo usuario, no olvide ingresar su correo electronico</p>");
	
	$form = new DAOFormComponent(array(
	    new Usuario(),
	    new Direccion()
	));

	$form->beforeSend("atach_address");
	
	$page->partialRender();
	?>
	
	<script type="text/javascript" charset="utf-8">
		function atach_address(o){

			o.direcciones = Ext.JSON.encode([{
				calle 			: o.calle,
				numero_exterior	: o.numero_exterior,
				numero_interior	: o.numero_interior,
				referencia		: o.referencia,
				colonia			: o.colonia,
				id_ciudad		: o.id_ciudad,
				codigo_postal	: o.codigo_postal,
				telefono1		: o.telefono1,
				telefono2		: o.telefono2
			}]);
			console.log(o);			
			return o;
		}
	</script>
	
	<?php

	$form->hideField(array(
	    "id_usuario",
	    "id_direccion",
	    "id_direccion_alterna",
	    "id_sucursal",
	    "fecha_asignacion_rol",
	    "fecha_alta",
	    "fecha_baja",
	    "activo",
	    "last_login",
	    "consignatario",
	    "id_direccion",
	    "ultima_modificacion",
	    "id_usuario_ultima_modificacion",
	    "id_direccion",
	    "ultima_modificacion",
	    "id_usuario_ultima_modificacion",
	    "ventas_a_credito",
	    "tiempo_entrega",
		"tarifa_compra_obtenida",
		"id_tarifa_venta",
		"denominacion_comercial",
		"descuento",
		"dia_de_revision",
		"dias_de_credito",
		"id_clasificacion_proveedor",
		"facturar_a_terceros",
		"id_clasificacion_cliente",
		"id_moneda",
		"dias_de_embarque",
		"cuenta_de_mensajeria",
		"saldo_del_ejercicio",
		"limite_credito",
		"mensajeria",
		"referencia",
		"intereses_moratorios",
		"representante_legal",
		"id_tarifa_compra",
		"token_recuperacion_pass",
		"tarifa_venta_obtenida",
		"telefono",
		"telefono2"		
	));

	$form->createComboBoxJoin("id_ciudad", "nombre", CiudadDAO::getAll());
	$form->createComboBoxJoin( "tarifa_venta_obtenida", "tarifa_venta_obtenida", array("rol", "proveedor", "cliente","usuario") );
	$form->createComboBoxJoin("id_perfil", "descripcion", POSController::ListaPerfilConfiguracion());
	
	$form->renameField(array(
	    "id_ciudad" => "ciudad"
	));
	

	$form->addApiCall("api/personal/usuario/nuevo/");
	$form->onApiCallSuccessRedirect("personal.usuario.ver.php?just_created=1");
	
	$form->setType("password", "password");

	$form->makeObligatory(array(
	    "nombre",
	    "id_rol",
	    "password",
	    "codigo_usuario",
		"id_perfil"
	));



	

	$form->createComboBoxJoin("id_rol", "nombre", RolDAO::getAll() );

	

	$form->createComboBoxJoin("id_moneda", "nombre", MonedaDAO::search(new Moneda(array(
	    "activa" => 1
	))));

	$form->createComboBoxJoin("id_clasificacion_cliente", "nombre", ClasificacionClienteDAO::getAll());

	$form->createComboBoxJoin("id_clasificacion_proveedor", "nombre", ClasificacionProveedorDAO::search(new ClasificacionProveedor(array(
	    "activa" => 1
	))));

	$page->addComponent($form);


	//render the page
	$page->render();
