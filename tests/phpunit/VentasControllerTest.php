<?php



require_once("../../server/bootstrap.php");


class VentasControllerTest extends PHPUnit_Framework_TestCase {

	private $current_client;

	protected function setUp(){
		Logger::log("-----------------------------");

		$r = SesionController::Iniciar(123, 1, true);

		if($r["login_succesful"] == false){
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");

			$r = SesionController::Iniciar(123, 1, true);
		}


		



		$this->current_client = $this->nuevoCliente();
		$this->current_client = $this->current_client["id_cliente"];

	}

	private function nuevoCliente(){
		return ClientesController::Nuevo( "02558a70324e7c4f269c69825450cec8" );
	}
	

	/**
     * @expectedException InvalidDataException
     */
	public function testNuevaVentaSinDetalles(){

		$detalle_venta = new stdClass;

		VentasController::Nueva(
	        /*$descuento*/  			0,
	        /*$id_comprador_venta*/ 	$this->current_client, 
	        /*$impuesto*/ 				0,
	        /*$subtotal*/ 				1,
	        /*$tipo_venta*/ 			"contado",
	        /*$total*/ 					1,
	        /*$datos_cheque = null*/	null,
	        /*$detalle_orden = null*/ 	null,
	        /*$detalle_paquete = null*/	null,
	        /*$detalle_venta = null*/	$detalle_venta
	        /*$id_sucursal = null*/
	        /*$saldo = "0"*/
	        /*$tipo_de_pago = null*/
	    );
	}



}