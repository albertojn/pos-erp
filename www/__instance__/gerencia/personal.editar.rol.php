<?php 

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaComponentPage();

	$page->requireParam(  "rid", "GET", "Este rol no existe." );
	$este_rol = RolDAO::getByPK( $_GET["rid"] );
		
	$page->addComponent( new TitleComponent( "Editar rol de " . $este_rol->getNombre() , 2 ));

	$form = new DAOFormComponent( $este_rol );
	$form->hideField( array( 
		"id_rol",
	));

	$form->sendHidden("id_rol");

	$form->createComboBoxJoinDistintName("id_tarifa_venta", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))), $este_rol->getIdTarifaVenta());
	$form->createComboBoxJoinDistintName("id_tarifa_compra", "id_tarifa" ,"nombre", TarifaDAO::search(new Tarifa(array("tipo_tarifa"=>"venta"))), $este_rol->getIdTarifaCompra());
	$form->createComboBoxJoinDistintName("id_rol_padre", "id_rol", "nombre", RolDAO::getAll(), $este_rol->getIdRolPadre());
	$form->createComboBoxJoin("id_perfil", "descripcion", POSController::ListaPerfilConfiguracion(), $este_rol->getIdPerfil());

	$form->addApiCall( "api/personal/rol/editar/" );

	$form->onApiCallSuccessRedirect("personal.rol.ver.php?rid=" . $_GET["rid"]);

	$page->addComponent( $form );

	$page->render();