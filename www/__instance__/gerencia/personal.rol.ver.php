<?php 

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaComponentPage();

	$page->requireParam("rid", "GET", "Este rol no existe.");
	
	//$este_rol = RolDAO::getByPK($_GET["rid"]);
	$este_rol = PersonalYAgentesController::DetallesRol($_GET["rid"]);
	$este_rol = $este_rol["detalles"];

	$menu = new MenuComponent();
	$menu->addItem("Editar este rol", "personal.editar.rol.php?rid=".$_GET["rid"]);

	$usuarios_rol = UsuarioDAO::search(new Usuario(array("id_rol" => $_GET["rid"] , "activo" => 1)));

	if (empty($usuarios_rol)) {

		$btn_eliminar = new MenuItem("Eliminar este rol", null);
		$btn_eliminar->addApiCall("api/personal/rol/eliminar");
		$btn_eliminar->onApiCallSuccessRedirect("personal.rol.lista.php");
		$btn_eliminar->addName("eliminar");

		$funcion_eliminar = "function eliminar_rol (btn) {"
						  . "	if(btn == 'yes')"
						  . "	{"
						  . "		var p = {};"
						  . "		p.id_rol = ".$_GET["rid"].";"
						  . "		sendToApi_eliminar(p);"
						  . "	}"
						  . "}"
						  . ""
						  . "function confirmar () {"
						  . "	Ext.MessageBox.confirm('Eliminar', 'Desea eliminar este rol?', eliminar_rol );"
						  . "}";

		$btn_eliminar->addOnClick("confirmar", $funcion_eliminar);

		$menu->addMenuItem($btn_eliminar);
	}

	$page->addComponent($menu);

	$page->addComponent(new TitleComponent("Detalles de " . $este_rol["nombre"] , 2));

	// Forma de producto
	$form = new DAOFormComponent(RolDAO::getByPK($este_rol["id_rol"]));
	$form->setEditable(false);
	$form->hideField(array( 
		"id_rol",
	));
	
	$form->createComboBoxJoinDistintName("id_tarifa_venta", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))), $este_rol["id_tarifa_venta"]);
	$form->createComboBoxJoinDistintName("id_tarifa_compra", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))), $este_rol["id_tarifa_compra"]);
	$form->createComboBoxJoinDistintName("id_rol_padre", "id_rol", "nombre", RolDAO::getAll(), $este_rol["id_rol_padre"]);
	$form->createComboBoxJoin("id_perfil", "descripcion", POSController::ListaPerfilConfiguracion(), $este_rol["id_perfil"]);
	$form->setType("descripcion", "textarea");

	$page->addComponent( $form );

	$page->addComponent(new TitleComponent("Usuarios con este rol"), 3 );

	$tabla = new TableComponent(array(
		"codigo_usuario" => "Codigo de usuario",
		"nombre"		 => "Nombre"
	), $usuarios_rol);

	$tabla->addOnClick("id_usuario", "(function(a){window.location = 'personal.usuario.ver.php?uid=' + a;})");

	$page->addComponent($tabla);

	$page->render();
