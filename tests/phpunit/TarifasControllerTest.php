<?php

require_once("../../server/bootstrap.php");


class TarifasControllerTest extends PHPUnit_Framework_TestCase {
	
	protected function setUp(){
		Logger::log("-----------------------------");

		$r = SesionController::Iniciar(123, 1, true);

		if($r["login_succesful"] == false){
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");
		}

		$r = SesionController::Iniciar(123, 1, true);
		

	}
	
	

	public function testNuevaTarifaVenta(){
		
		$monedas = MonedaDAO::getAll();
		
		if(sizeof($monedas) == 0){
			throw new Exception("No hay monedas");
		}
		
		//crear nueva tarifa de venta
		$tv = TarifasController::Nueva(
						$monedas[0]->getIdMoneda(),
						"tarifav" . time(),
						"venta"
						
					);
		
		$this->assertInternalType("int", $tv["id_tarifa"]);
	}
	
	
	
	
	public function testNuevaTarifaCompra(){
		
		$monedas = MonedaDAO::getAll();
		
		if(sizeof($monedas) == 0){
			throw new Exception("No hay monedas");
		}
		
		//crear nueva tarifa de venta
		$tc = TarifasController::Nueva(
						$monedas[0]->getIdMoneda(),
						"tarifac" . time(),
						"compra"
						
					);
		
		$this->assertInternalType("int", $tc["id_tarifa"]);
	}	
	
	
	
	public function testEditarTiposDeTarifas(){
		$monedas = MonedaDAO::getAll();

		//crear nueva tarifa de venta
		$tv = TarifasController::Nueva(
						$monedas[0]->getIdMoneda(),
						"tarifa_e_" . time(),
						"compra"
					);
		

		//crear nueva tarifa de compra
		$tc = TarifasController::Nueva(
						$monedas[0]->getIdMoneda(),
						"tarifa_d_" . time(),
						"compra"
					);
		
		//editar tarifa compra
		TarifasController::Editar(
					$id_tarifa = $tc["id_tarifa"], 
					$default = null, 
					$fecha_fin = null, 
					$fecha_inicio = null, 
					$formulas = null, 
					$id_moneda = null, 
					$nombre = "_" . "tarifa_d_" . time(), 
					$tipo_tarifa = "venta"
				);
				
		//Editar la tarifa de venta
		TarifasController::Editar(
					$id_tarifa = $tv["id_tarifa"], 
					$default = null, 
					$fecha_fin = null, 
					$fecha_inicio = null, 
					$formulas = null, 
					$id_moneda = null, 
					$nombre = "_" . "tarifa_ef_" . time(), 
					$tipo_tarifa = "compra"
				);		
	}
}