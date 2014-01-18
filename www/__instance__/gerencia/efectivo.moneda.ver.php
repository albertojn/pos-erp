<?php 



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage(  );


		//
		// Parametros necesarios
		// 
		$page->requireParam(  "mid", "GET", "Esta moneda no existe." );
		$esta_moneda = MonedaDAO::getByPK( $_GET["mid"] );
		
		
		//
		// Titulo de la pagina
		// 
		$page->addComponent( new TitleComponent( "Detalles de " . $esta_moneda->getNombre() , 2 ));

		
		//
		// Menu de opciones
		// 
                if($esta_moneda->getActiva())
                {
                    $menu = new MenuComponent();
                    //$menu->addItem("Editar esta moneda", "efectivo.editar.moneda.php?mid=".$_GET["mid"]);
                    //$menu->addItem("Desactivar este producto", null);

                    $btn_eliminar = new MenuItem("Desactivar esta moneda", null);
                    $btn_eliminar->addApiCall("api/efectivo/moneda/eliminar", "GET");
                    $btn_eliminar->onApiCallSuccessRedirect("efectivo.lista.moneda.php");
                    $btn_eliminar->addName("eliminar");

                    $funcion_eliminar = " function eliminar_moneda(btn){".
                                "if(btn == 'yes')".
                                "{".
                                    "var p = {};".
                                    "p.id_moneda = ".$_GET["mid"].";".
                                    "sendToApi_eliminar(p);".
                                "}".
                            "}".
                            "      ".
                            "function confirmar(){".
                            " Ext.MessageBox.confirm('Desactivar', 'Desea eliminar esta moneda?', eliminar_moneda );".
                            "}";

                    $btn_eliminar->addOnClick("confirmar", $funcion_eliminar);

                    $menu->addMenuItem($btn_eliminar);

                    $page->addComponent( $menu);

                } else {

                	$menu = new MenuComponent();

                    $btn_activar = new MenuItem("Activar esta moneda", null);
                    $btn_activar->addApiCall("api/efectivo/moneda/editar", "GET");
                    $btn_activar->onApiCallSuccessRedirect("efectivo.lista.moneda.php");
                    $btn_activar->addName("activar");

                    $funcion_activar = " function activar_moneda(btn){".
                                "if(btn == 'yes')".
                                "{".
                                    "var m = {};".
                                    "m.id_moneda = ".$_GET["mid"]."; m.activa=1;".
                                    "sendToApi_activar(m);".
                                "}".
                            "}".
                            "      ".
                            "function confirmar(){".
                            " Ext.MessageBox.confirm('Activar', 'Desea activar esta moneda?', activar_moneda );".
                            "}";

                    $btn_activar->addOnClick("confirmar", $funcion_activar);

                    $menu->addMenuItem($btn_activar);

                    $page->addComponent( $menu);

                }
		
		//
		// Forma de producto
		// 
		$form = new DAOFormComponent( $esta_moneda );
		$form->setEditable(false);
		//$form->setEditable(false);		
		$form->hideField( array( 
				"id_moneda",
				"activa"
			 ));
//		$form->makeObligatory(array( 
//				"compra_en_mostrador",
//				"costo_estandar",
//				"nombre_producto",
//				"id_empresas",
//				"codigo_producto",
//				"metodo_costeo",
//				"activo"
//			));
//	    $form->createComboBoxJoin("id_unidad", "nombre", UnidadDAO::getAll(), $este_producto->getIdUnidad() );
		$page->addComponent( $form );
		
		$page->render();
