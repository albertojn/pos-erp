<?php



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server/bootstrap.php");

		$page = new GerenciaComponentPage(  );


		//
		// Parametros necesarios
		//
		$page->requireParam(  "pid", "GET", "Este proveedor no existe." );
		$este_usuario = UsuarioDAO::getByPK( $_GET["pid"] );
				$esta_direccion = DireccionDAO::getByPK( $este_usuario->getIdDireccion() );
				if(is_null($esta_direccion))
					$esta_direccion = new Direccion();


		//
		// Titulo de la pagina
		//
		$page->addComponent( new TitleComponent( "Detalles de " . $este_usuario->getNombre() , 2 ));


		//
		// Menu de opciones
		//
				if($este_usuario->getActivo())
				{
					$menu = new MenuComponent();

					$menu->addItem("Editar este proveedor", "proveedores.editar.php?pid=".$_GET["pid"]);

					$btn_eliminar = new MenuItem("Desactivar este proveedor", null);
					$btn_eliminar->addApiCall("api/proveedor/eliminar", "GET");
					$btn_eliminar->onApiCallSuccessRedirect("proveedores.lista.php");
					$btn_eliminar->addName("eliminar");

					$funcion_eliminar = " function eliminar_proveedor(btn){".
								"if(btn == 'yes')".
								"{".
									"var p = {};".
									"p.id_proveedor = ".$_GET["pid"].";".
									"sendToApi_eliminar(p);".
								"}".
							"}".
							"      ".
							"function confirmar(){".
							" Ext.MessageBox.confirm('Desactivar', 'Desea eliminar este proveedor?', eliminar_proveedor );".
							"}";

					$btn_eliminar->addOnClick("confirmar", $funcion_eliminar);

					$menu->addMenuItem($btn_eliminar);

					$page->addComponent( $menu);
				}

		//
		// Forma de producto
		//
		$form = new DAOFormComponent( $este_usuario );
		$form->setEditable(false);
		//$form->setEditable(false);
		$form->hideField(array(
			"id_usuario",
			"id_direccion",
			"id_direccion_alterna",
			"id_clasificacion_proveedor",
			"id_clasificacion_cliente"
		));

				$form->createComboBoxJoin( "id_ciudad", "nombre", CiudadDAO::getAll() , $esta_direccion->getIdCiudad());
				$form->createComboBoxJoin( "id_rol", "nombre", RolDAO::getAll() , $este_usuario->getIdRol());

		$form->createComboBoxJoin( "id_moneda", "nombre", MonedaDAO::getAll() , $este_usuario->getIdMoneda());

		$response = ContactosController::DetallesCategoria($este_usuario->getIdCategoriaContacto());
		if (!is_null($response['categoria'])) {
			$form->setValueField('id_categoria_contacto', $response['categoria']->getNombre());
		}
		$form->setCaption('id_categoria_contacto', 'Categor&iacute;a');


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
