<?php

/**
* Description:
*
* TODO:
* 
* Need to test 'NuevaSucursal' with missing 'Direccion' indexes.
*
* Author:
*
**/

require_once("../../server/bootstrap.php");

class SucursalesControllerTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		$r = SesionController::Iniciar(123, 1, true);

		if ($r["login_succesful"] == false) {
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");
		}

		$r = SesionController::Iniciar(123, 1, true);
	}

	public function testNuevaSucursal() {
		$direccion = array(
			"calle"				=> "Monte Balcanes",
			"numero_exterior"	=> "107",
			"numero_interior"	=> null,
			"colonia"			=> "Arboledas",
			"codigo_postal"		=> "38060",
			"id_ciudad"			=> 334,
			"referencia"		=> "Calle cerrada",
			"telefono1"			=> "4616149974",
			"telefono2"			=> "45*451*454"
		);

		$sucursal = SucursalesController::Nueva("Sucursal de phpunit nueva " . time(), $direccion, 1, 1, null);

		$this->assertInternalType("int", $sucursal["id_sucursal"]);
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaSucursalRepetida() {
		$direccion = Array(
			"calle"				=> "Monte Balcanes",
			"numero_exterior"	=> "107",
			"colonia"			=> "Arboledas",
			"id_ciudad"			=> 334,
			"codigo_postal"		=> "38060",
			"numero_interior"	=> null,
			"referencia"		=> "Calle cerrada",
			"telefono1"			=> "4616149974",
			"telefono2"			=> "45*451*454"
		);

		try {
			SucursalesController::Nueva("Sucursal_Repetida", $direccion, 1);
		} catch (Exception $e) {

		}

		SucursalesController::Nueva("Sucursal_Repetida", $direccion, 1);
	}

	public function testBuscar() {
		$direccion = array (
			"calle"				=> "Monte Balcanes",
			"numero_exterior"	=> "107",
			"numero_interior"	=> null,
			"colonia"			=> "Arboledas",
			"codigo_postal"		=> "38060",
			"id_ciudad"			=> 334,
			"referencia"		=> "Calle cerrada",
			"telefono1"			=> "4616149974",
			"telefono2"			=> "45*451*454"
		);

		//creamos una sucursal para fines del experimento
		$sucursal = SucursalesController::Nueva("Sucursal de phpunit buscar " . time(), $direccion, 1, 1, null);

		//realizamos una busqueda general y verificamso que contenga los parametros de respuesta
		$busqueda = SucursalesController::Buscar();

		$this->assertArrayHasKey('resultados',			 $busqueda);
		$this->assertArrayHasKey('numero_de_resultados', $busqueda);

		$this->assertInternalType('int',   $busqueda['numero_de_resultados']);
		$this->assertInternalType('array', $busqueda['resultados']);

		$this->assertGreaterThanOrEqual(0, $busqueda['numero_de_resultados']);

		//probamos la busqueda por activo, al menos debe de haber una, ya que cuando se cree esta sucursal estara activa  
		$busqueda = SucursalesController::Buscar($activo = 1, $id_empresa = null, $limit = null, $query = null, $sort = null, $start = null);
		$this->assertGreaterThanOrEqual(1, $busqueda["numero_de_resultados"]);

		//probamos busqueda por start
		$busqueda = SucursalesController::Buscar($activo = null, $id_empresa = null, $limit = null, $query = null, $sort = null, $start = 1);
		$this->assertGreaterThanOrEqual(1, $busqueda["numero_de_resultados"]);

		//probamos busqueda por limit
		$busqueda = SucursalesController::Buscar($activo = null, $id_empresa = null, $limit = 1, $query = null, $sort = null, $start = null);
		$this->assertGreaterThanOrEqual(1, $busqueda["numero_de_resultados"]);

		//probamos busqueda por query
		$busqueda = SucursalesController::Buscar($activo = null, $id_empresa = null, $limit = null, $query = 1, $sort = null, $start = null);
		$this->assertGreaterThanOrEqual(0, $busqueda["numero_de_resultados"]);

		//probamos busqueda por id_empresa
		$busqueda = SucursalesController::Buscar($activo = null, $id_empresa = 1, $limit = null, $query = null, $sort = null, $start = null);
		$this->assertGreaterThanOrEqual(0, $busqueda["numero_de_resultados"]);

		//valores combinados
		$busqueda = SucursalesController::Buscar($activo = 1, $id_empresa = 1, $limit = 1, $query = 1, $sort = 1, $start = 1);

		$this->assertGreaterThanOrEqual(0, $busqueda["numero_de_resultados"]);
	}

	public function testEliminar(){
		//creamos una sucursal para fines del experimento
		$direccion = array(
			"calle"				=> "Monte Balcanes",
			"numero_exterior"	=> "107",
			"numero_interior"	=> null,
			"colonia"			=> "Arboledas",
			"codigo_postal"		=> "38060",
			"id_ciudad"			=> 334,
			"referencia"		=> "Calle cerrada",
			"telefono1"			=> "4616149974",
			"telefono2"			=> "45*451*454"
		);

		$sucursal = SucursalesController::Nueva("Sucursal de phpunit eliminar " . time(), $direccion, 1, 1, null);

		//eliminamos la sucursal (desactivamos)
		SucursalesController::Eliminar($sucursal["id_sucursal"]);
		$sucursal = SucursalDAO::getByPK($sucursal["id_sucursal"]);
		$this->assertEquals(0, $sucursal->getActiva());
	}

	public function testEditar() {
		//creamos una sucursal para fines del experimento
		$direccion = array(
			"calle"				=> "Monte Balcanes",
			"numero_exterior"	=> "107",
			"numero_interior"	=> null,
			"colonia"			=> "Arboledas",
			"codigo_postal"		=> "38060",
			"id_ciudad"			=> 334,
			"referencia"		=> "Calle cerrada",
			"telefono1"			=> "4616149974",
			"telefono2"			=> "45*451*454"
		);

		$sucursal = SucursalesController::Nueva("Sucursal de phpunit editar " . time(), $direccion, 1, 1, null);

		//para cambiar la moneda
		try {
			$moneda = new Moneda(array( 
				"nombre" => "Moneda_" . time(),
				"simbolo" => "Simbolo_" . time(),
				"activa" => 1
			));
			MonedaDAO::save($moneda);
		}catch(Exception $e){

		}

		//editar basico
		SucursalesController::Editar(
			$id_sucursal = $sucursal["id_sucursal"],
			$activo = 0,
			$descripcion = "Descripcion de la sucursal",
			$direccion = null,
			$empresas = null,
			$id_gerente = 1,
			$id_moneda = $moneda->getIdMoneda(),
			$razon_social = "Empresa x",
			$saldo_a_favor = "100000"
		);

		//editar la direccion
		SucursalesController::Editar(
			$id_sucursal = $sucursal["id_sucursal"],
			$activo = 0,
			$descripcion = "_EDITADO_" . time(),
			$direccion = Array(
				"calle"				=> "Monte Balcanes",
				"numero_exterior"	=> "107",
				"colonia"			=> "Arboledas",
				"id_ciudad"			=> 334,
				"codigo_postal"		=> "38060",
				"numero_interior"	=> null,
				"texto_extra"		=> "Calle cerrada",
				"telefono1"			=> "4616149974",
				"telefono2"			=> "45*451*454"
			),
			$empresas = null,
			$id_gerente = 1,
			$id_moneda = $moneda->getIdMoneda(),
			$razon_social = "Empresa x",
			$saldo_a_favor = "100000"
		);

		//vamos a ver si si se edito esa madre
		$_s = SucursalDAO::getByPK( $sucursal["id_sucursal"]);
		$this->assertEquals($descripcion, $_s->getDescripcion());

		$_d = DireccionDAO::getByPK($_s->getIdDireccion());

		$this->assertEquals($_d->getCalle(),			"Monte Balcanes");
		$this->assertEquals($_d->getNumeroExterior(),	"107");
		$this->assertEquals($_d->getColonia(),			"Arboledas");
		$this->assertEquals($_d->getIdCiudad(),			334);
		$this->assertEquals($_d->getCodigoPostal(),		"38060");
		//$this->assertEquals($_d->getTextoExtra(),		"Calle cerrada");
	}

}
