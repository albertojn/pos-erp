<?php 

    define("BYPASS_INSTANCE_CHECK", false);

    require_once("../../../server/bootstrap.php");

    $page = new GerenciaComponentPage();

	$menu = new MenuComponent();
	$menu->addItem("Descartar", "personal.rol.lista.php");
	$page->addComponent( $menu );

    //Nuevo rol
	$page->addComponent( new TitleComponent( "Nuevo Rol" ) );
	$form = new DAOFormComponent( array( new Rol() ) );

	$form->hideField( array( 
		"id_rol"
	));

	$form->addApiCall( "api/personal/rol/nuevo/" );
	$form->onApiCallSuccessRedirect("personal.rol.lista.php");
	$form->makeObligatory(array("nombre"));

	$form->createComboBoxJoinDistintName("id_tarifa_venta", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))));
	$form->createComboBoxJoinDistintName("id_tarifa_compra", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))));
	$form->createComboBoxJoinDistintName("id_rol_padre", "id_rol", "nombre", RolDAO::getAll());
	$form->createComboBoxJoin("id_perfil", "descripcion", POSController::ListaPerfilConfiguracion());
	$form->setType("descripcion", "textarea");
	$page->addComponent( $form );

	$page->render();
