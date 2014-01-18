<?php


require_once("../../server/bootstrap.php");





class ServiciosControllerTest extends PHPUnit_Framework_TestCase {

	private $cservicio ;

	protected function setUp(){
		Logger::log("-----------------------------");

		$r = SesionController::Iniciar(123, 1, true);

		if($r["login_succesful"] == false){
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");
				
			$r = SesionController::Iniciar(123, 1, true);
		}




	}



	public function testBuscarEliminarYNuevo(){

		//buscar el servicio que se llama prestamo

		$servs = ServiciosController::Buscar();

		$this->assertEquals( $servs["numero_de_resultados"], sizeof($servs["resultados"]) );

		$old_size = sizeof($servs["resultados"]);

		for ($i=0; $i < $servs["numero_de_resultados"]; $i++) { 
			$s = $servs["resultados"][$i]->asArray();
			if(($s["nombre_servicio"] == "prestamo") && ($s["activo"] == 1) ){
				ServiciosController::Eliminar( $s["id_servicio"] );
			}
		}


		$this->cservicio = "CA91" . time();

		$s = ServiciosController::Nuevo(
			$codigo_servicio = $this->cservicio,  
			$compra_en_mostrador=false, 
			$costo_estandar	= 0, 
			$metodo_costeo = "variable", 
			$nombre_servicio = $this->cservicio
		);

		$servs = ServiciosController::Buscar();

		$this->assertGreaterThan($old_size, $servs["numero_de_resultados"]);
	}



	/**
	 * @expectedException BusinessLogicException
	 */
	public function testInsertarCodigoRepetido(){
		$s = ServiciosController::Nuevo(
			$codigo_servicio = $this->cservicio,  
			$compra_en_mostrador=false, 
			$costo_estandar	= 0, 
			$metodo_costeo = "variable", 
			$nombre_servicio = $this->cservicio
		);
	}

	/*
	public function testBuscarSoloActivos(){
		$servs_todos = ServiciosController::Buscar();
		$servs_activos = ServiciosController::Buscar(true);
		
		$this->assertGreaterThan($servs_activos["numero_de_resultados"] , $servs_todos["numero_de_resultados"] );
	}
	*/

	public function testBuscarEliminarYNuevaCategoria(){
		//buscar la categoria

		//eliminarla si existe

		//insertarla de nuevo

		//buscar la categoria
	}



	public function testNuevaOrdenSinCreditoSuficiente(){

		$s = ServiciosController::Nuevo(
			$codigo_servicio 		= "testNuevoServicio-2db94458" . time(), 
			$compra_en_mostrador	= false, 
			$costo_estandar			= 0, 
			$metodo_costeo			= "precio", 
			$nombre_servicio		= "testNuevoServicio-2db94458" . time(), 
			$activo 				=  true , 	
			$clasificaciones 		= null, 
			$control_de_existencia 	= null, 
			$descripcion_servicio 	= null, 
			$empresas 				= null, 
			$extra_params 			= null, 
			$foto_servicio 			= null, 
			$garantia 				= null, 
			$impuestos 				= null, 
			$precio 				= 1542.15, 
			$retenciones			= null, 
			$sucursales 			= null

		);



		$c = ClientesController::nuevo( "testNuevaOrdenCliente -2db94458" . time() );

		$o = ServiciosController::NuevaOrden(
				$c["id_cliente"], 
				$s["id_servicio"]  
		);



	}





	public function testNuevaOrden(){

		$s = ServiciosController::Nuevo(
			$codigo_servicio 		= "testNuevoServicio-2db94458_2" . time(), 
			$compra_en_mostrador	= false, 
			$costo_estandar			= 0, 
			$metodo_costeo			= "precio", 
			$nombre_servicio		= "testNuevoServicio-2db94458_2" . time(), 
			$activo 				=  true , 	
			$clasificaciones 		= null, 
			$control_de_existencia 	= null, 
			$descripcion_servicio 	= null, 
			$empresas 				= null, 
			$extra_params 			= null, 
			$foto_servicio 			= null, 
			$garantia 				= null, 
			$impuestos 				= null, 
			$precio 				= 1542.15, 
			$retenciones			= null, 
			$sucursales 			= null
		);



		$c = ClientesController::Nuevo(
				$razon_social =  "testNuevaOrden-2db9445f" . time() , 
				$clasificacion_cliente = null, 
				$codigo_cliente = "t" . time(), 
				$cuenta_de_mensajeria = null, 
				$curp = null, 
				$denominacion_comercial = null, 
				$descuento_general = 0, 
				$direcciones = null, 
				$email = null, 
				$id_cliente_padre = null, 
				$id_moneda =  1 , 
				$id_tarifa_compra = null, 
				$id_tarifa_venta = null, 
				$limite_credito = 1542.15, 
				$password = null, 
				$representante_legal = null, 
				$rfc = null, 
				$sitio_web = null, 
				$telefono_personal1 = null, 
				$telefono_personal2 = null);


		Logger::testerLog("Nueva orde de servicio (" . $c["id_cliente"] .", ". $s["id_servicio"] ." )");

		$o = ServiciosController::NuevaOrden(
				$c["id_cliente"], 
				$s["id_servicio"]  
		);

		$this->assertInternalType("int", $o["id_orden"]);

		define("_pos_phpunit_servicios_id_cliente", $c["id_cliente"]);
		define("_pos_phpunit_servicios_id_servicio", $s["id_servicio"]);


		//ok ya que se hizo el servicio, ver que se halla creado
		//una venta a credito a este cliente
		/*
		El metodo de ServiciosController::NuevaOrden no genera una venta a credito, por lo tanto no se valida esta parte
		$lista_de_ventas = VentasController::Lista();

		$found = false;

		for ($i=0; $i < $lista_de_ventas["numero_de_resultados"]; $i++) { 
			if($lista_de_ventas["resultados"][$i]["cliente"]["id_cliente"] == $c["id_cliente"]){
				$found = true;
			}
		}

		$this->assertTrue($found);
		//vamos a buscar que ese cliente ya no tenga limite de credito
		$u = UsuarioDAO::getByPK($c["id_cliente"]);

		$this->assertEquals( 0, $u->getLimiteCredito() );
		//hacerle un abono
		CargosYAbonosController::NuevoAbono( 
			$c["id_cliente"], 
			1, 
			"efectivo",
			null, 
			null, 
			null, 
			null, 
			null,
			null );
		*/



	}


	/**
	 * @expectedException BusinessLogicException
	 */
	public function testElimnarServicioConOrdenes(){
		//no se debe poder eliminar un id_servicio ya que hay una orden activa en ese servicio
		ServiciosController::Eliminar(_pos_phpunit_servicios_id_servicio);


	}



	public function testListaYNuevoSeguimiento(){


		//buscar la ultima orden de servicio
		$ordns = ServiciosController::ListaOrden();
		
		$this->assertInternalType("int", $ordns["numero_de_resultados"]);
		$orden_de_servicio_id = null;

		for ($i=0; $i < $ordns["numero_de_resultados"]; $i++) { 

			$o = $ordns["resultados"][$i]->asArray();

			//Logger::log($o["id_usuario_venta"] ."=======". $cliente["id_usuario"]);

			if($o["id_usuario_venta"] == _pos_phpunit_servicios_id_cliente){

				$orden_de_servicio_id = $o["id_orden_de_servicio"];
			}
		}
		define("_pos_phpunit_servicios_orden_de_servicio" , $o["id_orden_de_servicio"]);

		$this->assertFalse( is_null($orden_de_servicio_id) );

		ServiciosController::SeguimientoOrden($orden_de_servicio_id, null, null, "nota para la orden");


	}



	public function testBuscarSeguimientosDeOrden(){
		$lista = ServiciosController::ListaOrden(  );

		$this->assertInternalType('int', $lista["numero_de_resultados"]);

		//debe haber por lo menos un resultado
		$this->assertGreaterThan( 0, $lista["numero_de_resultados"] );

		$old = $lista["numero_de_resultados"];

		//insertar un seguimiento...
		ServiciosController::SeguimientoOrden(_pos_phpunit_servicios_orden_de_servicio, null, null, "nota para la orden 2");


		//$lista = ServiciosController::ListaOrden(  );

		//$this->assertEquals( $lista["numero_de_resultados"], $old + 1);
	}


	public function testEditarServicio(){

		//Crear un nuevo servicio
		$s = ServiciosController::Nuevo(
			$codigo_servicio	= "SERV" . time(), 
			$compra_en_mostrador= false, 
			$costo_estandar		= 0,	 
			$metodo_costeo		= "precio", 
			$nombre_servicio	= "SERV" . time(),
			$activo = true, 
			$clasificaciones 		= null, 
			$control_de_existencia 	= null, 
			$descripcion_servicio 	= null, 
			$empresas 				= null, 
			$extra_params 			= null, 
			$foto_servicio 			= null, 
			$garantia 				= null, 
			$impuestos 				= null,
			$precio = 0, 
			$retenciones = null, 
			$sucursales = null

			);


		//Editar el servicio, (descripcion)
		ServiciosController::Editar(
			$id_servicio = $s["id_servicio"], 
			$clasificaciones = null, 
			$codigo_servicio = null, 
			$compra_en_mostrador = null, 
			$control_de_existencia = null, 
			$costo_estandar = null, 
			$descripcion_servicio = "nueva desc", 
			$empresas = null, 
			$foto_servicio = null, 
			$garantia = null, 
			$impuestos = null, 
			$metodo_costeo = null, 
			$nombre_servicio = null, 
			$precio = null, 
			$retenciones = null, 
			$sucursales = null
		);


	}



}