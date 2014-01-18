<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaComponentPage();

	$page->addComponent( new TitleComponent( "Nueva Sucursal" ) );

	$page->addComponent( new TitleComponent( "Datos de la sucursal" , 3 ) );

	$sucursal_form = new DAOFormComponent( new Sucursal() );

	$sucursal_form->hideField( array( "id_sucursal", "id_direccion", "activa", "fecha_baja", "fecha_apertura"));

	$sucursal_form->renameField(array("id_gerente" => "id_usuario"));
	$sucursal_form->createComboBoxJoin( "id_usuario", "nombre", UsuarioDAO::getAll() );
	$sucursal_form->createComboBoxJoin( "id_tarifa", "nombre", TarifaDAO::getAll() );
	
	$sucursal_form->makeObligatory(array("descripcion" ));

	$page->addComponent( $sucursal_form );

	$page->addComponent(new TitleComponent("Direccion", 3));

	$direccion_form = new DAOFormComponent( new Direccion() );

	$direccion_form->hideField(array( 
		"id_direccion",
		"ultima_modificacion",
		"id_usuario_ultima_modificacion"	
	));

	$direccion_form->createComboBoxJoin( "id_ciudad", "nombre", CiudadDAO::getAll() );
	$direccion_form->renameField(array("id_ciudad" => "ciudad"));

	$js = "(function(){
				POS.API.POST(\"api/sucursal/nueva/\",{
					descripcion		: Ext.get(\"".$sucursal_form->getGuiComponentId()."descripcion\").getValue(),
					id_gerente	: Ext.get(\"".$sucursal_form->getGuiComponentId()."id_usuario\").getValue(),
					id_tarifa	: Ext.get(\"".$sucursal_form->getGuiComponentId()."id_tarifa\").getValue(),
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
					window.location = \"sucursales.ver.php?sid=\"+ a.id_sucursal;
				}});
			})()";

	$direccion_form->addOnClick( "Crear sucursal", $js );

	$page->addComponent( $direccion_form );

	$page->render();