<?php 

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaTabPage();

	// Requerir parametros
	$page->requireParam(  "eid", "GET", "Esta empresa no existe." );

	$empresa = EmpresasController::Detalles($_GET["eid"]);

	$page->addComponent("<div class=\"POS Boton\" onclick=\"window.location = 'empresas.editar.php?eid=" . $_GET["eid"] . "'\">Editar Empresa</div><div class=\"POS Boton\" onclick=\"\" style=\"float:right;\">Vista Previa de Documentos</div>");

	$html = "<table style = \"margin-top:10px;\">"
		  . "	<tr>"
		  . "		<td>"
		  . "			<img id = \"img_logo\" width=\"100\" height=\"93\" title=\"\" alt=\"\" src=\"" . urldecode($empresa["detalles"]->logo) . "\" /><br />"
		  . "		</td>"
		  . "		<td>"
		  . "			<h1 id = \"razon_social\" style = \"\"/>" . $empresa["detalles"]->getRazonSocial() . "</hi>"
		  . "			<h3 id = \"rfc\" style = \"margin-top:15px;\"/>" . $empresa["detalles"]->getRfc() . "</h3>"
		  . "		</td>"
		  . "	</tr>"
		  . "</table>";

	$page->addComponent($html);

	/*
	 * Tab Informacion
	 */

	$page->nextTab("Informacion");
	$page->addComponent(new TitleComponent("Direcci&oacute;n", 2));

	$direccion_form = new DAOFormComponent( DireccionDAO::getByPK($empresa["detalles"]->direccion->getIdDireccion()) );

	$direccion_form->hideField( array( 
		"id_direccion",
		"ultima_modificacion",
		"id_usuario_ultima_modificacion"
		
	));

	$direccion_form->createComboBoxJoin( "id_ciudad", "nombre", CiudadDAO::getAll(), $empresa["detalles"]->direccion->getIdCiudad() );
	$direccion_form->renameField( array( 
		"id_ciudad" => "ciudad",
	));

	$direccion_form->addField("sitio_web", "Sitio Web", "text", $empresa["detalles"]->direccion_web);

	$direccion_form->setEditable(false);

	$page->addComponent($direccion_form);

	$page->addComponent(new TitleComponent("Cuentas Bancarias", 2));

	$tabla_cuentas_bancarias = new TableComponent(array(
		"numero_cuenta" => "Numero de cuenta",
		"nombre_banco" => "Nombre del banco",
		"propietario_cuenta" => "Propietario cuenta"
	),array());

	$tabla_cuentas_bancarias->addNoData("No hay ninguna cuenta bancaria registrada. <a href='#'>&iquest; Desea agregar un elemento?.</a>");

	$page->addComponent($tabla_cuentas_bancarias);

	$page->addComponent(new TitleComponent("Configuracion de formatos", 2));

	$configuracion_formatos = new FormComponent();

	$configuracion_formatos->addField("pie_pagina", "Pie de Pagina", "text", "");
	$configuracion_formatos->addField("formato_papel", "Formato de Papel", "text", "");

	$configuracion_formatos->setEditable(false);

	$page->addComponent($configuracion_formatos);

	/*
	 * Tab Configuración
	 */

	$page->nextTab("Configuracion");

	$page->addComponent(new TitleComponent("Contabilidad", 2));

	$page->addComponent("<br />");

	$configuracion_moneda_form = new DAOFormComponent(new Moneda());

	$configuracion_moneda_form->hideField( array( 
		"id_moneda",
		"nombre",
		"activa"
	));

	$configuracion_moneda_form->addField("simbolo", "Moneda", "text", $empresa["contabilidad"]["moneda_base"]["simbolo"]);

	$configuracion_moneda_form->setEditable(false);

	$page->addComponent($configuracion_moneda_form);

	$page->addComponent("<br />");

	$page->addComponent(new TitleComponent("Ejercicio", 3));

	$configuracion_ejercicio_form = new FormComponent();

	$configuracion_ejercicio_form->addField("ejercicio", "A&#241;o del Ejercicio", "text", $empresa["contabilidad"]["ejercicio"]["anio"], "ejercicio");

	$configuracion_ejercicio_form->setEditable(false);

	$page->addComponent($configuracion_ejercicio_form);

	$page->addComponent(new TitleComponent("Periodo", 3));

	$configuracion_periodo_form = new FormComponent();

	$configuracion_periodo_form->addField("periodo_actual", "Periodo Actual", "text", $empresa["contabilidad"]["ejercicio"]["periodo"], "periodo_actual");
	$configuracion_periodo_form->addField("periodo_inicio", "Inicio", "text", FormatTime($empresa["contabilidad"]["ejercicio"]["periodo_inicio"]), "periodo_inicio");
	$configuracion_periodo_form->addField("periodo_fin", "Fin", "text", FormatTime($empresa["contabilidad"]["ejercicio"]["periodo_fin"]), "periodo_fin");

	$configuracion_periodo_form->setEditable(false);

	$page->addComponent($configuracion_periodo_form);

	$page->addComponent(new TitleComponent("Impuestos", 2));

	$impuestos_compra_form = new FormComponent();

	$impuestos_compra = array();
	foreach($empresa["impuestos_compra"] as $impuesto){
		array_push($impuestos_compra, array("id"=>$impuesto->getIdImpuesto(), "caption"=>$impuesto->getNombre()));
	}

	$impuestos_venta = array();
	foreach($empresa["impuestos_venta"] as $impuesto){
		array_push($impuestos_venta, array("id"=>$impuesto->getIdImpuesto(), "caption"=>$impuesto->getNombre()));
	}

	$impuestos_compra_form->addField('impuestos_compra', 'Impuestos Compra', 'listbox', $impuestos_compra, 'impuestos_compra');
	$impuestos_compra_form->addField('impuestos_venta', 'Impuestos Venta', 'listbox', $impuestos_venta, 'impuestos_venta');

	$impuestos_compra_form->setEditable(false);

	$page->addComponent($impuestos_compra_form);

	/*
	 * Tab Pagos
	 */

	$page->nextTab("Pagos fuera de plazo");

	$mensaje_form = new FormComponent();

	$mensaje_form->addField("mensaje", "Mensaje pagos vencidos", "textarea", $empresa["detalles"]->getMensajeMorosos(), "mensaje");

	$mensaje_form->setEditable(false);

	$page->addComponent($mensaje_form);

	$page->render();