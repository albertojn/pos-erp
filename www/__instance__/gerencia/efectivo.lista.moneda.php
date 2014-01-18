<?php 



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage();

                $page->addComponent( new TitleComponent( "Monedas" ) );
		$page->addComponent( new MessageComponent( "Lista de monedas" ) );
		
		$tabla = new TableComponent( 
			array(
                                "nombre"                => "Nombre",
				"simbolo"               => "Simbolo",
				"activa" => "Activa"
			),
			EfectivoController::ListaMoneda()
		);

		function funcion_bool_to_string($valor){
			return ($valor===true || $valor==="1" || $valor===1) ? "<strong>Si</strong>" : "No";
        }

        $tabla->addColRender("activa", "funcion_bool_to_string");
//                
//                function funcion_moneda($id_moneda)
//                {
//                    return (MonedaDAO::getByPK($id_moneda) ? MonedaDAO::getByPK($id_moneda)->getNombre() : "-----" );
//                }
                
//                $tabla->addColRender("id_moneda", "funcion_moneda");
                
		$tabla->addOnClick( "id_moneda", "(function(a){ window.location = 'efectivo.moneda.ver.php?mid=' + a; })" );
                
                $page->addComponent( $tabla );
                
		$page->render();
