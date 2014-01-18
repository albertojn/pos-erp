<?php 



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage();

		$mostrar_act = EfectivoController::MostrarEquivalenciasActualizar();


        $page->addComponent( new TitleComponent( "Tipos de Cambio" ) );

		$page->addComponent("<div class=\"POS Boton OK\" onclick=\"actualizarTiposCambio();\">Guardar Cambios</div> &oacute; <a href=\"efectivo.lista.tipo_cambio.php\" style = \"margin-left:12px;\">Descartar</a>");

        if (count($mostrar_act["sistema"])>0) {
			$tabla2 = new TableComponent( 
				array(
					"conversion"               => "Sistema actualizado al ".date("d-m-Y",$mostrar_act["sistema"][0]["fecha"])
				),
				$mostrar_act["sistema"][0]["tipos_cambio"]
			);

			$page->addComponent( $tabla2 );
		} else {
			$page->addComponent( new TitleComponent( "No hay historial de los tipos de cambio en el sistema, agregar los tipo de cambio desde aqui", 3 ));
		}

        if(count($mostrar_act["servicios"])>0) {

        	/*$tabla = new TableComponent( 
				array(
					"conversion"               => "Tipo Cambio al ".date("d-m-Y", $mostrar_act["servicios"][0]["fecha"])
				),
				$mostrar_act["servicios"][0]["tipos_cambio"]
			);

			$page->addComponent( $tabla );*/
			$page->addComponent( new TitleComponent("Tipo Cambio al ".date("d-m-Y", $mostrar_act["servicios"][0]["fecha"]), 3 ));

			$page->addComponent( new TitleComponent( "Moneda Base: ".$mostrar_act["servicios"][0]["moneda_origen"], 3 ));

			foreach ($mostrar_act["servicios"][0]["tipos_cambio"] as $tc) {
				$page->addComponent( new FreeHtmlComponent( '<label>1 '.$mostrar_act["servicios"][0]["moneda_origen"].' = </label><input type="text" style="font-size: 17px;" placeholder="'.$tc["equivalencia"].'" id="'.$tc["moneda"].'">&nbsp;<label>'.$tc["moneda"].'</label><br>'));
			}

        }else {
        	$page->addComponent( new TitleComponent( "No hay registros de los tipos de cambio en el servidor, contactar a Caffeina para notificar", 3 ));
        }

$html_json = "";

	foreach ($mostrar_act["servicios"][0]["tipos_cambio"] as $tc) {
		$html_json .= "{";
		$html_json .= "\"codigo\": \"" . $tc["moneda"] . "\",";
		$html_json .= "\"equivalencia\": Ext.get(\"" . $tc["moneda"] . "\").getValue() ";
		$html_json .= "},";
	}

	$html_json = substr($html_json, 0, strlen($html_json)-1);

	$js ="";
	foreach ($mostrar_act["servicios"][0]["tipos_cambio"] as $tc) {
		$js .= "if( Ext.get(\"" . $tc["moneda"] . "\").getValue() != ".$tc["equivalencia"].") {";
		$js .= "	servicio = 'Editado por Usuario';";
		$js .= "}";
	}

$html = "<script>"
		  . "	function obtenerServicio(){"
		  . "		var servicio='';"
		  . "		servicio = '". $mostrar_act["servicios"][0]["servicio"] ."';"
		  . "		$js"
		  . "		return servicio;"
		  . "	}"
		  . "	var actualizarTiposCambio = function(){"
		  . "		POS.API.POST("
		  . "			\"api/efectivo/cambio/tipos/actualizar\","
		  . "			{"
		  . "				\"id_empresa\" : \"1\","
		  . "				\"moneda_base\": \"" . $mostrar_act["servicios"][0]["moneda_origen"] . "\","
		  . "				\"servicios\": obtenerServicio(),"
		  . "				\"monedas\": Ext.JSON.encode([ "
		  . "		$html_json	])"
		  . "			},"
		  . "			{"
		  . "				callback:function(a){"
		  . "					if(a.status === \"ok\"){"
		  . "						location.href=\"efectivo.lista.tipo_cambio.php\";"
		  . "					}else{"
		  . "						Ext.Msg.alert(\"Editar Tipos Cambio\",\"a.error\");"
		  . "					}"
		  . "				}"
		  . "			}"
		  . "		);"
		  . "	}"
		  . "</script>";

	$page->addComponent($html);

	$page->render();
