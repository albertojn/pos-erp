<?php 

	define("BYPASS_INSTANCE_CHECK", false);
	require_once("../../../server//bootstrap.php");

	$page = new GerenciaTabPage();
	$page->addComponent("<div class=\"POS Boton OK\" onclick=\"crearEmpresa();\">Crear</div> &oacute; <a href=\"empresas.lista.php\" style = \"margin-left:12px;\">Descartar</a> <div class=\"POS Boton\" onclick=\"\" style=\"float:right;\">Vista Previa de Documentos</div>");

	$html = "<table style = \"margin-top:10px;\">"
		  . "	<tr>"
		  . "		<td>"
		  . "			<img id = \"img_logo\" width=\"100\" height=\"93\" title=\"\" alt=\"\" src=\"data:image/png;base64,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\" /><br />"
		  . "			<input type=\"file\" id=\"file_logo\"name=\"pic\" size=\"40\" onChange=\"cambiarLogo(this);\">"
		  . "		</td>"
		  . "		<td>"
		  . "			<h1>Nueva Empresa</h1><br />"
		  . "			<input type = \"text\" id = \"razon_social\" placeholder=\"Razon Social\" style = \"width:200px; height:25px;\"/><br />"
		  . "			<input type = \"text\" id = \"rfc\" placeholder=\"RFC\" style = \"width:200px; height:25px; margin-top:10px;\"/><br />"
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

	$direccion_form = new DAOFormComponent( new Direccion() );

	$direccion_form->hideField( array( 
		"id_direccion",
		"ultima_modificacion",
		"id_usuario_ultima_modificacion"
		
	));

	$direccion_form->createComboBoxJoin( "id_ciudad", "nombre", CiudadDAO::getAll(), 6 );
	$direccion_form->renameField( array( 
		"id_ciudad" => "ciudad",
	));

	$direccion_form->addField("sitio_web", "Sitio Web", "text", "");

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
	$configuracion_formatos->addField("formato_papel", "Formato de Papel", "text", "A4");

	$page->addComponent($configuracion_formatos);

	/*
	 * Tab Configuración
	 */

	$page->nextTab("Configuracion");

	$page->addComponent(new TitleComponent("Contabilidad", 2));

	$page->addComponent("<br />");

	$configuracion_moneda_form = new DAOFormComponent(new Moneda());

	$configuracion_moneda_form->hideField( array( 
		"simbolo",
		"nombre",
		"activa"
	));

	$configuracion_moneda_form->createComboBoxJoin( "id_moneda", "simbolo", EfectivoController::ListaMoneda() );

	$page->addComponent($configuracion_moneda_form);

	$page->addComponent("<br />");

	$page->addComponent(new TitleComponent("Ejercicio", 3));

	$configuracion_ejercicio_form = new FormComponent();

	$configuracion_ejercicio_form->addField("ejercicio", "A&#241;o del Ejercicio", "text", date("Y"), "ejercicio");

	$page->addComponent($configuracion_ejercicio_form);

	$page->addComponent(new TitleComponent("Periodo", 3));

	$configuracion_periodo_form = new FormComponent();

	$configuracion_periodo_form->addField("duracion_periodo", "Duracion de periodos (meses)", "number", "1", "duracion_periodo");
	$configuracion_periodo_form->addField("periodo_actual", "Periodo Actual", "number", "1", "periodo_actual");

	$page->addComponent($configuracion_periodo_form);

	$page->addComponent(new TitleComponent("Impuestos", 2));

	$impuestos_compra_form = new FormComponent();

	$valores = array();

	foreach(ImpuestoDAO::getAll() as $impuesto){
		array_push($valores, array("id"=>$impuesto->getIdImpuesto(), "caption"=>$impuesto->getNombre()));
	}

	$impuestos_compra_form->addField('impuestos_compra', 'Impuestos Compra', 'listbox', $valores, 'impuestos_compra');
	$impuestos_compra_form->addField('impuestos_venta', 'Impuestos Venta', 'listbox', $valores, 'impuestos_venta');

	$page->addComponent($impuestos_compra_form);

	/*
	 * Tab Pagos
	 */
	$page->nextTab("Pagos fuera de plazo");

	$msj = "Estimado/a se&#241;or/se&#241;ora,

Nuestros registros indican que algunos pagos en nuestra cuenta est&aacute;n a&uacute;n pendientes. Puede encontrar los detalles a continuaci&oacute;n.

%s

Si la cantidad ha sido ya pagada, por favor, descarte esta notificaci&oacute;n. En otro caso, por favor rem&iacute;tanos el importe total abajo indicado.

%s

Si tiene alguna pregunta con respecto a su cuenta, por favor cont&aacute;ctenos.

Gracias de antemano por su colaboraci&oacute;n.
Saludos cordiales,";

	$mensaje_form = new FormComponent();

	$mensaje_form->addField("mensaje", "Mensaje pagos vencidos", "textarea", $msj, "mensaje");

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
		  . "	var crearEmpresa = function(){"
		  . "		POS.API.POST("
		  . "			\"api/empresa/nuevo\","
		  . "			{"
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
		  . "				\"contabilidad\": Ext.JSON.encode({"
		  . "					\"id_moneda\": Ext.get(\"" . $configuracion_moneda_form->getGuiComponentId() . "id_moneda\").getValue(),"
		  . "					\"ejercicio\": Ext.get(\"" . $configuracion_ejercicio_form->getGuiComponentId() . "ejercicio\").getValue(),"
		  . "					\"periodo_actual\": Ext.get(\"" . $configuracion_periodo_form->getGuiComponentId() . "periodo_actual\").getValue(),"
		  . "					\"duracion_periodo\": Ext.get(\"" . $configuracion_periodo_form->getGuiComponentId() . "duracion_periodo\").getValue()"
		  . "				})"
		  . "			},"
		  . "			{"
		  . "				callback:function(a){"
		  . "					if(a.status === \"ok\"){"
		  . "						Ext.Msg.alert(\"Nueva Empresa\",\"Empresa creada correctamente\", function(){location.href=\"empresas.lista.php\"});"
		  . "					}else{"
		  . "						Ext.Msg.alert(\"Nueva Empresa\",\"a.error\");"
		  . "					}"
		  . "				}"
		  . "			}"
		  . "		);"
		  . "	}"
		  . "</script>";

	$page->addComponent($html);

	$page->render();