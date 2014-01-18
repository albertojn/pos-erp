<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaComponentPage();

	// Parametros necesarios
	$page->requireParam("sid", "GET", "Esta sucursal no existe.");
	$esta_sucursal  = SucursalDAO::getByPK($_GET["sid"]);
	$esta_direccion = DireccionDAO::getByPK($esta_sucursal->getIdDireccion());

	// Titulo de la pagina
	$page->addComponent(new TitleComponent("Editar sucursal " . $esta_sucursal->getDescripcion(), 2));

	//forma de nueva empresa
	$sucursal_form = new DAOFormComponent($esta_sucursal);

	$sucursal_form->hideField( array( "id_sucursal", "id_direccion", "fecha_apertura", "fecha_baja" ));

	$sucursal_form->renameField(array("id_gerente" => "id_usuario"));
	$sucursal_form->createComboBoxJoin( "id_usuario", "nombre", UsuarioDAO::getAll(), $esta_sucursal->getIdGerente());
	$sucursal_form->createComboBoxJoin( "id_tarifa", "nombre", TarifaDAO::getAll(), $esta_sucursal->getIdTarifa());
	
	$sucursal_form->createComboBoxJoin("activa", "activa", array(
		array("id" => false, "caption" => "No"),
		array("id" => true, "caption" => "S&iacute;")
	), $esta_sucursal->getActiva());

	$page->addComponent( $sucursal_form );

	$page->addComponent(new TitleComponent("Direccion", 3));

	$direccion_form = new DAOFormComponent( $esta_direccion );

	$direccion_form->hideField(array( 
		"id_direccion",
		"ultima_modificacion",
		"id_usuario_ultima_modificacion"
	));
			
	$direccion_form->createComboBoxJoin("id_ciudad", "nombre", CiudadDAO::getAll(), $esta_direccion->getIdDireccion());		
	
	$direccion_form->renameField(array( 
		"id_ciudad" => "ciudad",
	));

	$js = "(function(){
				POS.API.POST(\"api/sucursal/editar/\",{
					id_sucursal		: " .  $_GET['sid'] . ",
					descripcion		: Ext.get(\"".$sucursal_form->getGuiComponentId()."descripcion\").getValue(),
					id_gerente		: Ext.get(\"".$sucursal_form->getGuiComponentId()."id_usuario\").getValue(),
					id_tarifa		: Ext.get(\"".$sucursal_form->getGuiComponentId()."id_tarifa\").getValue(),
					activo			: Ext.get(\"".$sucursal_form->getGuiComponentId()."activa\").getValue(),
					direccion : Ext.JSON.encode({
						 	calle			: Ext.get(\"".$direccion_form->getGuiComponentId()."calle\").getValue(),
							numero_exterior	: Ext.get(\"".$direccion_form->getGuiComponentId()."numero_exterior\").getValue(),
						    numero_interior	: Ext.get(\"".$direccion_form->getGuiComponentId()."numero_interior\").getValue(),
						    colonia			: Ext.get(\"".$direccion_form->getGuiComponentId()."colonia\").getValue(),
						    codigo_postal	: Ext.get(\"".$direccion_form->getGuiComponentId()."codigo_postal\").getValue(),
						    telefono1		: Ext.get(\"".$direccion_form->getGuiComponentId()."telefono\").getValue(),
						    telefono2		: Ext.get(\"".$direccion_form->getGuiComponentId()."telefono2\").getValue(),
						    id_ciudad		: Ext.get(\"".$direccion_form->getGuiComponentId()."ciudad\").getValue(),
						    referencia		: Ext.get(\"".$direccion_form->getGuiComponentId()."referencia\").getValue()
					})
				},{ callback : function(a,b){
					window.onbeforeunload = function(){ return;	};
					window.location = \"sucursales.ver.php?sid=\"+ " .  $_GET['sid'] . ";
				}});
			})()";

	$direccion_form->addOnClick( "Editar sucursal", $js );

	$page->addComponent( $direccion_form );

	$page->render();