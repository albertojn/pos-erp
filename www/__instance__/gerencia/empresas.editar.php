<?php 

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	$page = new GerenciaTabPage();

	// Requerir parametros
	$page->requireParam(  "eid", "GET", "Esta empresa no existe." );

	$empresa = EmpresasController::Detalles($_GET["eid"]);

	$page->addComponent("<div class=\"POS Boton OK\" onclick=\"editarEmpresa();\">Guardar Cambios</div> &oacute; <a href=\"empresas.ver.php?eid=" . $_GET["eid"] . "\" style = \"margin-left:12px;\">Descartar</a> <div class=\"POS Boton\" onclick=\"\" style=\"float:right;\">Vista Previa de Documentos</div>");

	$html = "<table style = \"margin-top:10px;\">"
		  . "	<tr>"
		  . "		<td>"
		  . "			<img id = \"img_logo\" width=\"100\" height=\"93\" title=\"\" alt=\"\" src=\"" . urldecode($empresa["detalles"]->logo) . "\" /><br />"
		  . "			<input type=\"file\" id=\"file_logo\"name=\"pic\" size=\"40\" onChange=\"cambiarLogo(this);\">"
		  . "		</td>"
		  . "		<td>"
		  . "			<h1>Empresa</h1><br />"
		  . "			<input type = \"text\" id = \"razon_social\" placeholder=\"Razon Social\" style = \"width:200px; height:25px;\" value = \"" . $empresa["detalles"]->getRazonSocial() . "\"/><br />"
		  . "			<input type = \"text\" id = \"rfc\" placeholder=\"RFC\" style = \"width:200px; height:25px; margin-top:10px;\" value = \"" . $empresa["detalles"]->getRfc() . "\"/><br />"
		  . "		</td>"
		  . "	</tr>"
		  . "</table>"

		  . "<script>"

		  . "	var cambiarLogo = function (evt)"
		  . "	{"
		  . "		var file = document.getElementById('file_logo');"
		  . "		var f = file.files[0];"

		  . "		if (!f.type.match('image.*')) {"
		  . "			file.value = '';"
		  . "			alert('solo se permiten imagenes');"
		  . "			return;"
		  . "		}"

		  . "		var max_size = 32768;"
		  . "		if(f.size > max_size){"
		  . "			alert('HTML form max file size (' + (max_size / 1024) + ' kb) exceeded');"
		  . "			return;"
		  . "		}"

		  . "		var reader = new FileReader();"

		  . "		reader.readAsDataURL(f);"

		  . "		reader.onload = cambiarImagenLogo(f);"
		  . "	};"

		  . "	var cambiarImagenLogo = function (archivoImagen)"
		  . "	{"
		  . "		return function(e) {"
		  . "			var nodoImagen = document.getElementById('img_logo');"
		  . "			nodoImagen.src = e.target.result;"
		  . "			nodoImagen.title = escape(archivoImagen.name);"
		  . "		};"
		  . "	};"
		
		  . "</script>";

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

	$page->addComponent($impuestos_compra_form);

	/*
	 * Tab Pagos
	 */

	$page->nextTab("Pagos fuera de plazo");

	$mensaje_form = new FormComponent();

	$mensaje_form->addField("mensaje", "Mensaje pagos vencidos", "textarea", $empresa["detalles"]->getMensajeMorosos(), "mensaje");

	$page->addComponent($mensaje_form);

	/*
	 * Logica de envio de informacion
	 */

	$html = "<script>"
		  . "	var impuestosSeleccionados = function(id_select){"
		  . "		var select = Ext.get(id_select);"
		  . "		var impuestos = [];"
		  . "		for(var i = 0; i < select.dom.options.length; i++){"
		  . "			if(select.dom.options[i].selected === true){"
		  . "				impuestos[impuestos.length] = select.dom.options[i].value"
		  . "			}"
		  . "		}"
		  . "		return impuestos;"
		  . "	};"
		  . ""
		  . "	var editarEmpresa = function(){"
		  . "		POS.API.POST("
		  . "			\"api/empresa/editar\","
		  . "			{"
		  . "				\"id_empresa\" : \"" . $_GET["eid"] . "\","
		  . "				\"razon_social\": Ext.get(\"razon_social\").getValue(),"
		  . "				\"rfc\": Ext.get(\"rfc\").getValue(),"
		  . "				\"representante_legal\": \"\","
		  . "				\"direccion_web\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "sitio_web\").getValue(),"
		  . "				\"direccion\": Ext.JSON.encode({"
		  . "					\"calle\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "calle\").getValue(),"
		  . "					\"numero_exterior\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "numero_exterior\").getValue(),"
		  . "					\"numero_interior\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "numero_interior\").getValue(),"
		  . "					\"colonia\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "colonia\").getValue(),"
		  . "					\"codigo_postal\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "codigo_postal\").getValue(),"
		  . "					\"telefono1\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "telefono\").getValue(),"
		  . "					\"telefono2\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "telefono2\").getValue(),"
		  . "					\"id_ciudad\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "ciudad\").getValue(),"
		  . "					\"referencia\": Ext.get(\"" . $direccion_form->getGuiComponentId() . "referencia\").getValue()"
		  . "				}),"
		  . "				\"uri_logo\": encodeURIComponent(Ext.get(\"img_logo\").dom.src),"
		  . "				\"impuestos_compra\": Ext.JSON.encode(impuestosSeleccionados(\"" . $impuestos_compra_form->getGuiComponentId() . "impuestos_compra" . "\")),"
		  . "				\"impuestos_venta\": Ext.JSON.encode(impuestosSeleccionados(\"" . $impuestos_compra_form->getGuiComponentId() . "impuestos_venta" . "\")),"
		  . "				\"cuentas_bancarias\":Ext.JSON.encode([]),"
		  . "				\"mensaje_morosos\": Ext.get(\"" . $mensaje_form->getGuiComponentId() . "mensaje\").getValue(),"
		  . "			},"
		  . "			{"
		  . "				callback:function(a){"
		  . "					if(a.status === \"ok\"){"
		  . "						Ext.Msg.alert(\"Modificar Empresa\",\"Empresa modificada correctamente\", function(){location.href=\"empresas.ver.php?eid=" . $_GET["eid"] . "\"});"
		  . "					}else{"
		  . "						Ext.Msg.alert(\"Modificar Empresa\",\"a.error\");"
		  . "					}"
		  . "				}"
		  . "			}"
		  . "		);"
		  . "	}"
		  . "</script>";

	$page->addComponent($html);

	$page->render();