<?php 



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage();

		$historial = EfectivoController::ObtenerHistorialTipoCambio();
		$mostrar_act = EfectivoController::MostrarEquivalenciasActualizar();

        $page->addComponent( new TitleComponent( "Tipos de Cambio" ) );


        if(count($mostrar_act["servicios"])>0) {
			$page->addComponent("<div class=\"POS Boton\" onclick=\"window.location = 'efectivo.editar.tipo_cambio.php'\">Actualizar Tipos Cambio</div>");
        	$tabla = new TableComponent( 
				array(
					"conversion"               => "Tipo Cambio al ".date("d-m-Y", $mostrar_act["servicios"][0]["fecha"])." (".$mostrar_act["servicios"][0]["servicio"].")"
				),
				$mostrar_act["servicios"][0]["tipos_cambio"]
			);

			$page->addComponent( $tabla );

        }else {
        	$page->addComponent( new TitleComponent( "Si usted requiere tipos de cambio, verifique lo siguiente:", 2 ));
        	$page->addComponent( new TitleComponent( "- Que tenga configurada la moneda base de la <a href=\"empresas.lista.php\">Empresa</a>", 3 ));
        	$page->addComponent( new TitleComponent( "- Que tenga activa mas de una <a href=\"efectivo.lista.moneda.php\">moneda</a> en el sistema", 3 ));
        	$page->addComponent( new TitleComponent( "- Si tiene estos parametros de configuracion y no aparecen los tipos de cambio, contacte a personal de Caffeina", 3 ));
        }

		if (count($mostrar_act["sistema"])>0) {
			$tabla2 = new TableComponent( 
				array(
					"conversion" => "Sistema actualizado al ".date("d-m-Y",$mostrar_act["sistema"][0]["fecha"])
				),
				$mostrar_act["sistema"][0]["tipos_cambio"]
			);

			$page->addComponent( $tabla2 );
		}

		$page->addComponent( new TitleComponent( "Historial de Tipos Cambio en el Sistema", 2 ));

		if(count($historial)<1)
		{
			$page->addComponent( new TitleComponent( "No hay registros", 3 ));
		} else {

			$datos_concentrados = array();
			foreach ($historial as $h) {
				$servicio = $h["servicio"];
				$fecha = date("d-m-Y h:i:s", $h["fecha"]);
				$moneda_origen = $h["moneda_origen"];

				foreach ($h["tipos_cambio"] as $tc) {
					foreach ($tc as $tip_c) {
						$moneda = $tip_c["moneda"];
						$equivalencia = $tip_c["equivalencia"];

						array_push($datos_concentrados, 
									array("servicio"=>$servicio,"fecha"=>$fecha,
										"moneda_origen"=>$moneda_origen,"moneda"=>$moneda,
										"equivalencia"=>$equivalencia)
						);
					}
				}
			}

			$tablaH = new TableComponent( 
				array(
					"fecha"					=> "Fecha",
					"servicio"				=> "Servicio",
					"moneda_origen"			=> "Moneda Origen",
					"moneda"               	=> "Moneda",
					"equivalencia"			=> "Equivalencia"
				),
				$datos_concentrados
			);

			$page->addComponent( $tablaH );

		}
                /*function funcion_moneda($moneda)
                {
                    return "1 - ".$moneda." -";
                }
                
                $tabla->addColRender("moneda", "funcion_moneda");*/
                
		//$tabla->addOnClick( "id_moneda", "(function(a){ window.location = 'efectivo.moneda.ver.php?mid=' + a; })" );


		$page->render();
