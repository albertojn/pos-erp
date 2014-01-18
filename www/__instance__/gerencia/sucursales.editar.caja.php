<?php 



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage();

                //
		// Parametros necesarios
		// 
		$page->requireParam(  "cid", "GET", "Esta caja no existe." );
		$esta_caja = CajaDAO::getByPK( $_GET["cid"] );
		//
		// Titulo de la pagina
		// 
		$page->addComponent( new TitleComponent( "Editar caja " . $esta_caja->getToken()  , 2 ));

		//
		// Forma de usuario
		// 
		$form = new DAOFormComponent( $esta_caja );
		$form->hideField( array( 
                                "id_caja",
                                "id_sucursal",
                                "abierta",
                                "saldo",
                                "activa",
                                "id_cuenta_contable"
			 ));
                $form->sendHidden("id_caja");
                
                $form->addApiCall( "api/sucursal/caja/editar/", "GET" );
                $form->onApiCallSuccessRedirect("sucursales.lista.caja.php");
                
                $form->createComboBoxJoin("control_billetes", "control_billetes", 
                        array(
                            array( "id" => 1, "caption" => "Llevar control" ),
                            array( "id" => 0, "caption" => "No llevar control"  ) 
                            ),
                        $esta_caja->getControlBilletes()
                        );
                
		$page->addComponent( $form );
                
		$page->render();
