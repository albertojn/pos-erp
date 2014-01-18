<?php
require_once("../../server/bootstrap.php");

class ContabilidadControllerTest extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		Logger::log("-----------------------------");

		$r = SesionController::Iniciar(123, 1, true);

		if($r["login_succesful"] == false) {
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");

			$r = SesionController::Iniciar(123, 1, true);
		}
	}

	public function RandomString($length = 10, $uc = FALSE, $n = FALSE, $sc = FALSE) {
		$source = 'abcdefghijklmnopqrstuvwxyz';
		if ($uc == 1) { $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'; }
		if ($n == 1) { $source .= '1234567890'; }
		if ($sc == 1) { $source .= '|@#~$%()=^*+[]{}-_'; }

		if($length > 0) {
			$rstr = "";
			$source = str_split($source, 1);

			for($i = 1; $i <= $length; $i++) {
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1, count($source));
				$rstr .= $source[$num-1];
			}
		}
		return $rstr;
	}

	public function NuevoCatalogoCuentas() {

		$dir = array(
			"calle"				=> self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time(),
			"numero_exterior"	=> "" . time(),
			"colonia"			=> "Colonia " . time(),
			"id_ciudad"			=> 1,
			"codigo_postal"		=> "" . time(),
			"numero_interior"	=> null,
			"texto_extra"		=> "Calle cerrada" . time(),
			"telefono1"			=> time(),
			"telefono2"			=> time()
		);

		$razon_social = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$rfc  = self::RandomString(10, FALSE, FALSE, FALSE) . "-" . time();

		$c = new stdClass();
		$c->id_moneda			= 1;
		$c->ejercicio			= "2013";
		$c->periodo_actual		= 1;
		$c->duracion_periodo	= 1;

		$empresa = EmpresasController::Nuevo(
			$contabilidad		= $c,
			$direccion			= $dir,
			$razon_social,
			$rfc,
			$cuentas_bancarias	= null,
			$direccion_web		= null,
			$duplicar			= false,
			$email				= time() . "d",
			$impuestos_compra	= null, 
			$impuestos_venta	= null,
			$mensajes_morosos	= null,
			$representante_legal= null,
			$uri_logo			= null
		);

		$this->assertInternalType('int', $empresa["id_empresa"]);

		$catalogo = ContabilidadController::NuevoCatalogoCuentasEmpresa($empresa["id_empresa"]);
		$this->assertInternalType('int', $catalogo["id_catalogo_cuentas"]);

		return $catalogo["id_catalogo_cuentas"];
	}

	public function testCatalogoCuentasEmpresa() {

		$dir = array(
			"calle"				=> self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time(),
			"numero_exterior"	=> "" . time(),
			"colonia"			=> "Col-" . time(),
			"id_ciudad"			=> 1,
			"codigo_postal"		=> "" . time(),
			"numero_interior"	=> null,
			"texto_extra"		=> time(),
			"telefono1"			=> time(),
			"telefono2"			=> time()
		);

		$razon_social = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$rfc  = self::RandomString(10, FALSE, FALSE, FALSE) . "-" . time();

		$c = new stdClass();
		$c->id_moneda			= 1;
		$c->ejercicio			= "2013";
		$c->periodo_actual		= 1;
		$c->duracion_periodo	= 1;

		$empresa = EmpresasController::Nuevo(
			$contabilidad		= $c,
			$direccion			= array($dir),
			$razon_social,
			$rfc,
			$cuentas_bancarias	= null,
			$direccion_web		= null,
			$duplicar			= false,
			$email				= time() . "d",
			$impuestos_compra	= null, 
			$impuestos_venta	= null,
			$mensajes_morosos	= null,
			$representante_legal= null,
			$uri_logo			= null
		);

		$this->assertInternalType('int', $empresa["id_empresa"]);

		$catalogo = ContabilidadController::NuevoCatalogoCuentasEmpresa($empresa["id_empresa"]);
		$this->assertInternalType('int', $catalogo["id_catalogo_cuentas"]);
		$this->assertSame('ok', $catalogo["status"]);
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaMismoNombre() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");

		ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaMayorYOrden() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 1, $id_catalogo_cuentas, "Deudora",
											"Cajas", "Balance", $id_cuenta_padre = "");
	}

	public function testNuevaCuentaSeaAfectable() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		$randmon_str = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$id_nueva_cuenta = ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											$randmon_str, "Balance", $id_cuenta_padre = "");

		$nueva = ContabilidadController::DetalleCuenta($id_nueva_cuenta['id_cuenta_contable']);

		$this->assertEquals($nueva["afectable"], 1);
	}

	public function testNuevaCuentaSeaAfectablePadreNoAfectable() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		$randmon_str = self::RandomString(15, FALSE, FALSE, FALSE) . " Padre " . time();
		$id_nueva_cuenta = ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											$randmon_str, "Balance", $id_cuenta_padre = "");

		$padre = ContabilidadController::DetalleCuenta($id_nueva_cuenta['id_cuenta_contable']);

		$this->assertEquals($padre["afectable"], 1);

		$randmon_str = self::RandomString(15, FALSE, FALSE, FALSE) ." Hija " . time();
		$id_nueva_cuenta2 = ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											$randmon_str, "Balance", $id_nueva_cuenta['id_cuenta_contable']);
		$hija = ContabilidadController::DetalleCuenta($id_nueva_cuenta2['id_cuenta_contable']);
		//se vuelve a trar a cuenta padre para obtener el valor actualzado
		$padre = ContabilidadController::DetalleCuenta($id_nueva_cuenta['id_cuenta_contable']);

		$this->assertEquals($hija["afectable"], 1);
		$this->assertEquals($padre["afectable"], 0);
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceDeudoraNoIngresos() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Ingresos', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");

	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceDeudoraNoEgresos() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Egresos', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceDeudoraNoPasivoCirculante() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceDeudoraNoPasivoLargoPlazo() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Pasivo Largo Plazo', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceDeudoraNoCapitalContable() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Capital Contable', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceAcreedoraNoIngresos() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Ingresos', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceAcreedoraNoEgresos() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Egresos', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Balance", $id_cuenta_padre = "" );

	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceAcreedoraNoActivoDiferido() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Diferido', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceAcreedoraNoActivoFijo() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Fijo', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceAcreedoraNoActivoCirculante() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaBalanceAcreedoraNoCapitalContable() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Capital Contable', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Balance", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoActivoFijo() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Fijo', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoActivoCirculante() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoActivoDiferido() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Diferido', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoPasivoCirculante() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoPasivoLargoPlazo() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Pasivo Largo Plazo', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoCapitalContable() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1,'Capital Contable', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosAcreedoraNoEgresos() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1,'Egresos', 1, 0, $id_catalogo_cuentas, "Acreedora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoActivoFijo() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Fijo', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoActivoCirculante() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoActivoDiferido() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Activo Diferido', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoPasivoCirculante() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoPasivoLargoPlazo() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Pasivo Largo Plazo', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoCapitalContable() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Capital Contable', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCuentaEstadoResultadosDeudoraNoIngresos() {
		$id_catalogo_cuentas = self::NuevoCatalogoCuentas();
		ContabilidadController::NuevaCuenta(0, 1, 'Ingresos', 1, 0, $id_catalogo_cuentas, "Deudora",
											"Bancos", "Estado de Resultados", $id_cuenta_padre = "");
	}

}
?>
