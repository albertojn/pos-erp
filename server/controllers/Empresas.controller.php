<?php
require_once("interfaces/Empresas.interface.php");
/**
 *
 *
 *
 **/

class EmpresasController implements IEmpresas
{
	
	/**
	 * 
	 * 
	 * */
	public static function flujoEfectivo($id_empresa, $unix_fecha_inicio = null)
	{
		
		if (($empresa = EmpresaDAO::getByPK($id_empresa)) == null) {
			throw new InvalidDataException("Esta empresa no existe");
		}
		
		//traerme los abonos a ventas
		$abonos = CargosYAbonosController::ListaAbono(1, 1, 1);
		
		$flujo = 0;
		
		$out = array();
		
		for ($a = 0; $a < $abonos["numero_de_resultados"]; $a++) {
			
			array_push($out, array(
				"fecha" => $abonos["resultados"]["ventas"][$a]->fecha,
				"value" => $abonos["resultados"]["ventas"][$a]->monto,
				"tipo" => "abono"
			));
		}
		
		$gastos = CargosYAbonosController::ListaGasto();
		
		for ($a = 0; $a < $gastos["numero_de_resultados"]; $a++) {
			
			
			array_push($out, array(
				"fecha" => $gastos["resultados"][$a]->fecha_del_gasto,
				"value" => $gastos["resultados"][$a]->monto * -1,
				"tipo" => "gastos"
			));
		}

		return $out;
	}
	
	/*
	 * Valida los parametros de la tabla empresa haciendo uso de las validaciones basicas
	 * de string y num. El minimo y el maximo se toman de la tabla y de su uso en particular.
	 */
	private static function validarParametrosEmpresa($id_empresa = null, $id_direccion = null, $curp = null, $rfc = null, $razon_social = null, $representante_legal = null, $activo = null, $direccion_web = null)
	{
		//Se valida que la empresa exista en la base de datos
		if (!is_null($id_empresa)) {
			if (is_null(EmpresaDAO::getByPK($id_empresa))) {
				Logger::warn("La empresa con id: " . $id_empresa . " no existe");
				return "La empresa con id: " . $id_empresa . " no existe";
			}
		}
		//se valida que la direccion exista en la base de datos
		if (!is_null($id_direccion)) {
			if (is_null(DireccionDAO::getByPK($id_direccion))) {
				Logger::log("La direccion con id: " . $id_direccion . " no existe");
				return "La direccion con id: " . $id_direccion . " no existe";
			}
		}

		//se valida que la curp tenga solo letras mayusculas y numeros
		if (!is_null($curp)) {
			$e = self::validarString($curp, 30, "curp");
			if (is_string($e))
				return $e;
			if (preg_match('/[^A-Z0-9]/', $curp))
				return "El curp " . $curp . " contiene caracteres fuera del rango A-Z y 0-9";
		}

		//se valida que el rfc tenga solo letras mayusculas y numeros.
		if (!is_null($rfc)) {
			$e = self::validarString($curp, 30, "rfc");
			if (is_string($e))
				return $e;
			if (preg_match('/[^A-Z0-9]/', $rfc)){
				Logger::warn("El rfc " . $rfc . " contiene caracteres fuera del rango A-Z y 0-9");
				return "El rfc " . $rfc . " contiene caracteres fuera del rango A-Z y 0-9";
			}
		}

		//se valida que la razon social este en le rango
		if (!is_null($razon_social)) {
			$e = self::validarString($razon_social, 100, "razon social");
			if (is_string($e))
				return $e;
		}

		//se valida que el representante legal este en el rango
		if (!is_null($representante_legal)) {
			$e = self::validarString($representante_legal, 100, "representante legal");
			if (is_string($e))
				return $e;
		}

		//se valida que el boleano activo este en el rango
		if (!is_null($activo)) {
			$e = self::validarNumero($activo, 1, "activo");
			if (is_string($e))
				return $e;
		}

		//se valida que la direccion web tenga un formato adecuado
		if (!is_null($direccion_web)) {
			$e = self::validarString($direccion_web, 20, "direccion web");
			if (is_string($e))
				return $e;
			if (!preg_match('/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}' . '((:[0-9]{1,5})?\/.*)?$/i', $direccion_web) && !preg_match('/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}' . '((:[0-9]{1,5})?\/.*)?$/i', $direccion_web)){
				Logger::warn("La direccion web " . $direccion_web . " no cumple el formato esperado");
				return "La direccion web " . $direccion_web . " no cumple el formato esperado";
			}
		}

		//No se encontro error
		return true;
	}
	
	/*
	 * Valida los parametros de la tabla sucursal_empresa
	 */
	private static function validarParametrosSucursalEmpresa($id_sucursal = null, $id_empresa = null)
	{
		//verifica que la sucursal exista en la base de datos
		if (!is_null($id_sucursal)) {
			if (is_null(SucursalDAO::getByPK($id_sucursal))) {
				Logger::error("La sucursal con id: " . $id_sucursal . " no existe");
				return "La sucursal con id: " . $id_sucursal . " no existe";
			}
		}
		
		//verifica que la empresa exista en la base de datos
		if (!is_null($id_empresa)) {
			if (is_null(EmpresaDAO::getByPK($id_empresa))) {
				Logger::error("La empresa con id: " . $id_empresa . " no existe");
				return "La empresa con id: " . $id_empresa . " no existe";
			}
		}
		
		return true;
	}

	/**
	 * Buscar($activa, $limit, $order, $order_by, $query, $start)
	 *
	 * Mostrar todas la empresas en el sistema. Por default no se mostraran las empresas ni sucursales inactivas. 
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param activa bool Verdadero para mostrar solo las empresas activas. En caso de false, se mostraran ambas.
	 * @param limit string Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la bsqueda.
	 * @param order string Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
	 * @param order_by string Indica por que campo se ordenan los resultados.
	 * @param query string Valor que se buscara en la consulta
	 * @param start string Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la bsqueda.
	 * @return resultados json Arreglo de objetos que contendr las empresas de la instancia
	 * @return numero_de_resultados int 
	 **/
	public static function Buscar($activa = false, $limit = null, $order = null, $order_by = null, $query = null, $start = null)
	{
		if ($activa !== NULL && is_bool($activa) === false) {
			Logger::error("Buscar() verifique el valor especificado en activa, se esperaba boolean, se encontro : (" . gettype($activa) . ") {$activa}");
			return array("success" => false, "reason" => "Buscar() verifique el valor especificado en activa, se esperaba boolean, se encontro : (" . gettype($activa) . ") {$activa}");
		}

		if ($order !== NULL && !($order === "ASC" || $order === "DESC")) {
			Logger::error("Buscar() verifique el valor especificado en order, se esperaba ASC || DESC, se encontro : (" . gettype($order) . ") {$order}");
			return array("success" => false, "reason" => "Buscar() verifique el valor especificado en order, se esperaba ASC || DESC, se encontro : (" . gettype($order) . ") {$order}");
		}

		if ($order_by === NULL) {
			$order_by = "razon_social";
		}

		if ($limit !== NULL && !(is_numeric($limit) && $limit >= 0)) {
			Logger::error("Buscar() verifique el valor especificado en limit, se esperaba un int >= 0, se encontro : (" . gettype($limit) . ") {$limit}");
			return array("success" => false, "reason" => "Buscar() verifique el valor especificado en limit, se esperaba un int >= 0, se encontro : (" . gettype($limit) . ") {$limit}");
		}

		if ($start !== NULL && !(is_numeric($start) && $start >= 0)) {
			Logger::error("Buscar() verifique el valor especificado en start, se esperaba un int >= 0, se encontro : (" . gettype($start) . ") {$start}");
			return array("success" => false, "reason" =>"Buscar() verifique el valor especificado en start, se esperaba un int >= 0, se encontro : (" . gettype($start) . ") {$start}");
		}

		if ($start !== NULL && $limit === NULL) {
			Logger::error("Buscar() esta especificando un valor de start, pero no especifica un limit, solo el valor limit se puede usar sin start.");
			return array("success" => false, "reason" => "Buscar() esta especificando un valor de start, pero no especifica un limit, solo el valor limit se puede usar sin start.");
		}

		if (!($start === NULL && $limit === NULL) && ($start > $limit)) {
			Logger::error("Buscar() el valor de start debe ser <= que el valor de limit, se encontro start = {$start}, limit = {$limit}");
			return array("success" => false, "reason" => "Buscar() el valor de start debe ser <= que el valor de limit, se encontro start = {$start}, limit = {$limit}");
		}

		$empresas = EmpresaDAO::buscar($activa, $limit, $order, $order_by, $query, $start);

		return array("success" => true, "numero_de_resultados" => count($empresas), "resultados" => $empresas);
	}
	
	/**
	 *
	 *Relacionar una sucursal a esta empresa. Cuando se llama a este metodo, se crea un almacen de esta sucursal para esta empresa
	 *
	 * @param id_empresa int 
	 * @param sucursales json Arreglo de objetos que tendran los ids de sucursales, un campo opcional de  margen de utilidad que simboliza el margen de utilidad que esas sucursales ganaran para los productos de esa empresa y un campo de descuento, que indica el descuento que se aplicara a todas los productos de esa empresa en esa sucursal
	 **/
	public static function Agregar_sucursales($id_empresa, $sucursales)
	{
		//Se valida que la empresa exista en la base de datos
		$validar = self::validarParametrosEmpresa($id_empresa);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar, 901);
		}

		//Se valida el objeto sucursales
		$sucursales = object_to_array($sucursales);
		
		if (!is_array($sucursales)) {
			Logger::error("El parametro sucursales recibido es invalido");
			throw new Exception("El parametro sucursales recibido es invalido", 901);
		}

		//Se crea un registro de sucursal-empresa y se le asigna como empresa la obtenida.
		$sucursal_empresa = new SucursalEmpresa();
		$sucursal_empresa->setIdEmpresa($id_empresa);

		DAO::transBegin();

		try {
			//Por cada una de las sucursales como sucursal, se validan los parametros que contiene
			//y si son v'alidos, se almacenan en el objeto sucursal-empresa para luego guardarlo.
			foreach ($sucursales as $sucursal) {
				$validar = self::validarParametrosSucursalEmpresa($sucursal);
				if (is_string($validar)) {
					throw new Exception($validar, 901);
				}
				$sucursal_empresa->setIdSucursal($sucursal);
				SucursalEmpresaDAO::save($sucursal_empresa);
			}
		}catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudieron agregar las sucursales a la empresa: " . $e);
			if ($e->getCode() == 901)
				throw new Exception("No se pudieron agregar las sucursales a la empresa: " . $e->getMessage(), 901);
			throw new Exception("No se pudieron agregar las sucursales a la empresa, consulte a su administrador de sistema", 901);
		}
		DAO::transEnd();
		Logger::log("Sucursales agregadas exitosamente");
	}

	/**
	 *
	 * Crear una nueva empresa. Por default una nueva empresa no tiene sucursales.
	 * Varios RFC`s pueden repetirse siempre y cuando solo exista una empresa activa.
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 *
	 * @param contabilidad json JSON donde se describe la moneda que usara como base la empresa, indica la descripción del ejercicio, el periodo inicial y la duración de cada periodo
	 * @param direccion json {    "calle": "Francisco I Madero",    "numero_exterior": "1009A",    "numero_interior": 12,     "colonia": "centro",    "codigo_postal": "38000",    "telefono1": "4611223312",    "telefono2": "",       "id_ciudad": 3,    "referencia": "El local naranja"}
	 * @param razon_social string El nombre de la nueva empresa.
	 * @param rfc string RFC de la nueva empresa.
	 * @param cuentas_bancarias json arreglo que contiene los id de las cuentas bancarias
	 * @param direccion_web string Direccion del sitio de la empresa
	 * @param duplicar bool Significa que se duplicara una empresa, solo es una bandera, en caso de que exista y sea = true ,  significa que duplicara todo lo referente a la empresa (direccion, impuestos asociados, cuentas bancarias, etc..)
	 * @param email string Correo electronico de la empresa
	 * @param impuestos_compra json Impuestos de compra por default que se heredan  a los productos
	 * @param impuestos_venta json Impuestos de venta por default que se heredan a los productos
	 * @param mensaje_morosos string mensaje enviado a los clientes cuando un pago es demorado
	 * @param representante_legal string El nombre del representante legal de la nueva empresa.
	 * @param uri_logo string url del logo de la empresa
	 * @return id_empresa int El ID autogenerado de la nueva empresa.
	 **/
	static function Nuevo($contabilidad, $direccion, $razon_social, $rfc, $cuentas_bancarias = null, 
		$direccion_web = null, $duplicar =  false , $email = null, $impuestos_compra = null, 
		$impuestos_venta = null, $mensaje_morosos = null, $representante_legal = null, $uri_logo = null
	) {				
		//validamos la estructura de los impuestos
		{
			//verificamos los impuestos de compra
			if ($impuestos_compra !== NULL && !is_array($impuestos_compra)) {
				Logger::error("Error : Verifique los datos especiicados en los impuestos de compra, debe ser una array no vacio");
				throw new InvalidDataException("Error : Verifique los datos especiicados en los impuestos de compra, debe ser una array no vacio");
			}

			//verificamos los impuestos de venta
			if ($impuestos_venta !== NULL && !is_array($impuestos_venta)) {
				Logger::error("Error : Verifique los datos especiicados en los impuestos de venta, debe ser una array no vacio");
				throw new InvalidDataException("Error : Verifique los datos especiicados en los impuestos de venta, debe ser una array no vacio");
			}
		}

		//Logger::error($contabilidad);		
		//verificamos los datos de contabilidad
		{
			//verificamos si se enviaron todos los parametros
			if (empty($contabilidad->id_moneda) || empty($contabilidad->ejercicio) || 
				empty($contabilidad->periodo_actual) || empty($contabilidad->duracion_periodo)
			) {
				Logger::error("Error : Verifique que la información de contabilidad este completa");
				throw new InvalidDataException("Verifique que la información de contabilidad este completa : " . $contabilidad);
			}

			//verificamos si se enviaron valores correctos
			if (!is_numeric($contabilidad->id_moneda) || 
				!is_numeric($contabilidad->periodo_actual) || !is_numeric($contabilidad->duracion_periodo)
			) {
				Logger::error("Error : Verifique que la información de contabilidad sea correcta");
				throw new InvalidDataException("Verifique que la información de contabilidad sea correcta");
			}

			//validamos decimales
			if ($contabilidad->id_moneda - ((int) $contabilidad->id_moneda) !== 0 ||
				$contabilidad->periodo_actual - ((int) $contabilidad->periodo_actual) !== 0 ||
				$contabilidad->duracion_periodo - ((int) $contabilidad->duracion_periodo) !== 0
			) {
				Logger::error("Error : Verifique que la información de contabilidad sea correcta, el id_moneda, periodo_actual y duracion_periodo deben ser valores enteros");
				throw new InvalidDataException("Error : Verifique que la información de contabilidad sea correcta, el id_moneda, periodo_actual y duracion_periodo deben ser valores enteros");
			}

			if ($contabilidad->duracion_periodo < "1" || 
				$contabilidad->duracion_periodo === "5" || $contabilidad->duracion_periodo > "6"
			) {
				Logger::error("Error : Verifique que la duracion de los perodos, solo pueden durar 1, 2, 3, 4 y 6 meses");
				throw new InvalidDataException("Error : Verifique que la duracion de los perodos, solo pueden durar 1, 2, 3, 4 y 6 meses");
			}

			if($contabilidad->periodo_actual > (12 / $contabilidad->duracion_periodo)){
				Logger::error("Error : Verifique el valor del periodo actual, debe concordar con la relacion de la duracion de los periodos");
				throw new InvalidDataException("Error : Verifique el valor del periodo actual, debe concordar con la relacion de la duracion de los periodos");	
			}

		}

		//creamos la direccion
		{
			if (is_null($direccion)) {
				throw new InvalidDataException("Missing direccion");
			}

			if (!is_array($direccion)) {
				$direccion = object_to_array($direccion);
			} 

			$id_direccion = DireccionController::NuevaDireccion(
				isset($direccion["calle"])           ? $direccion["calle"]           : null, 
				isset($direccion["numero_exterior"]) ? $direccion["numero_exterior"] : null, 
				isset($direccion["colonia"])         ? $direccion["colonia"]         : null, 
				isset($direccion["id_ciudad"])       ? $direccion["id_ciudad"]       : null, 
				isset($direccion["codigo_postal"])   ? $direccion["codigo_postal"]   : null, 
				isset($direccion["numero_interior"]) ? $direccion["numero_interior"] : null, 
				isset($direccion["referencia"])      ? $direccion["referencia"]      : null, 
				isset($direccion["telefono1"])       ? $direccion["telefono1"]       : null, 
				isset($direccion["telefono2"])       ? $direccion["telefono2"]       : null
			);
		}

		DAO::transBegin();

		$id_logo = -1;

		//verificamos si se ha enviado informacion sobre un logo
		if (!empty($uri_logo)) {

			$logo = new Logo(array(
				"imagen" => $uri_logo,
				"tipo" => "-"
			));

			try {
				LogoDAO::save($logo);
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("No se pudo crear la empresa, error al crear el logo: " . $e->getMessage());
				throw new Exception("No se pudo crear la empresa, consulte a su administrador de sistema", 901);
			}

				$id_logo = $logo->getIdLogo();
		}

		//creamos la empresa
		{
			//Se crea la empresa con los parametros obtenidos.
			$empresa = new Empresa(array(
				"id_direccion"        => $id_direccion,
				"rfc"                 => $rfc,
				"razon_social"        => trim($razon_social),
				"representante_legal" => $representante_legal,
				"fecha_alta"          => time(),
				"fecha_baja"          => null,
				"activo"              => true,
				"direccion_web"       => $direccion_web,
				"cedula"              => "",
				"id_logo"             => $id_logo,
				"mensaje_morosos"     => $mensaje_morosos
			));

			//Se busca el rfc en la base de datos. Si hay una empresa activa con el mismo rfc se lanza un error
			$empresas = EmpresaDAO::search(new Empresa(array(
				"rfc"    => $rfc,
				"activo" => 1
			)));
			
			if (!empty($empresas)) {
				Logger::error("Este rfc ya esta en uso por la empresa activa");
				throw new InvalidDataException("El rfc: " . $rfc . " ya esta en uso", 901);
			}

			/*
			* Se busca la razon social en la base de datos. 
			* Si hay una empresa activa con la misma razon zocial se lanza un error. 
			* Se usa trim para cubrir los casos "caffeina" y "    caffeina    ".
			*/
			$empresas = EmpresaDAO::search(new Empresa(array(
				"razon_social" => trim($razon_social),
				"activo"       => 1
			)));

			if (!empty($empresas)) {
				Logger::error("La razon social: " . $razon_social . " ya esta en uso por la empresa: " . $empresas[0]->getIdEmpresa());
				throw new InvalidDataException("La razon social: " . $razon_social . " ya esta en uso", 901);
			}

			try {
				EmpresaDAO::save($empresa);
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("No se pudo crear la empresa: " . $e->getMessage());
				throw new Exception("No se pudo crear la empresa, consulte a su administrador de sistema", 901);
			}
		}

		//establecemos la moneda base
		{
			//verificamos si la moneda que se esta indicando exista
			if (!$moneda = MonedaDAO::getByPK($contabilidad->id_moneda)) {
				DAO::transRollback();
				Logger::error("Error : No existe la moneda indicada.");
				throw new InvalidDataException("Error : No existe la moneda indicada.", 901);
			}

			//creamos la configuracion de la moneda para esta empresa
			$moneda_base = new Configuracion(array(
				"descripcion" => "id_moneda_base",
				"valor"       => $contabilidad->id_moneda,
				"id_usuario"  => "",
				"fecha"       => time()
			));

			try {
				ConfiguracionDAO::save($moneda_base);
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("No se pudo crear la configuracion de la moneda base para la empresa: " . $e->getMessage());
				throw new Exception("No se pudo crear la configuracion de la moneda base para la empresa", 901);
			}

			//relacionamos la configuracion con la empresa que estamos creando
			$configuracion_empresa = new ConfiguracionEmpresa(array(
				"id_configuracion" => $moneda_base->getIdConfiguracion(),
				"id_empresa"       => $empresa->getIdEmpresa()
			));

			try {
				ConfiguracionEmpresaDAO::save($configuracion_empresa);
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("No se pudo crear la relacion entre la moneda base y la empresa: " . $e->getMessage());
				throw new Exception("No se pudo crear la relacion entre la moneda base y la empresa", 901);
			}

			//creamos la configuracion del tipo de cambio para esta empresa
			$tc = new Configuracion(array(
				"descripcion" => "tipo_cambio",
				"valor"       => "",
				"id_usuario"  => "",
				"fecha"       => time()
			));

			try {
				ConfiguracionDAO::save($tc);
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("No se pudo crear la configuracion del tipo de cambio para la empresa: " . $e->getMessage());
				throw new Exception("No se pudo crear la configuracion del tipo de cambio para la empresa", 901);
			}

			//relacionamos la configuracion con la empresa que estamos creando
			$conf_empresa = new ConfiguracionEmpresa(array(
				"id_configuracion" => $tc->getIdConfiguracion(),
				"id_empresa"       => $empresa->getIdEmpresa()
			));

			try {
				ConfiguracionEmpresaDAO::save($conf_empresa);
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("No se pudo crear la relacion entre el tipo de cambio y la empresa: " . $e->getMessage());
				throw new Exception("No se pudo crear la relacion entre el tipo de cambio y la empresa", 901);
			}

		}

		//creamos los periodos, ejercicios y la relacion con la empresa
		{
			//creamos los periodos necesarios
			$_p = 1;

			$_periodo = NULL;
			$_ejercicio = NULL;

			$_mes_inicial = 1;
			$_mes_final = 1;
			$_anio = date("Y");

			$_inicio = 0;
			$_fin = 0;

			for ($i = $contabilidad->duracion_periodo; $i <= 12; $i += $contabilidad->duracion_periodo) {
				//obtenemos la fecha inicial
				$_inicio = mktime(0, 0, 0, $_mes_inicial, 1, $_anio);

				//obtenemos la fecha final
				$_mes_final = $_mes_inicial * $_p;
				$_fin = mktime(23, 59, 59, $_mes_final, getUltimoDiaDelMes( $_mes_final, $_anio ), $_anio);

				//damos de alta los periodos
				try {
					$_periodo = new Periodo(array(
						"periodo" => $_p, 
						"inicio" => $_inicio,
						"fin" => $_fin
					));
					PeriodoDAO::save($_periodo);
				}catch (Exception $e) {
					DAO::transRollback();
					Logger::error("Error al crear los periodos : " . $e->getMessage());
					throw new Exception("Error al crear los periodos", 901);
				}

				//damos de alta el ejercicio
				if ($_p == $contabilidad->periodo_actual) {
					try {
						$_ejercicio = new Ejercicio(array(
							"anio" => $_anio,
							"id_periodo" => $_periodo->getIdPeriodo(), 
							"inicio" => $_inicio,
							"fin" => $_fin,
							"vigente" => 1
						));
						EjercicioDAO::save($_ejercicio);
					}catch (Exception $e) {
						DAO::transRollback();
						Logger::error("Error al crear el ejercicio : " . $e->getMessage());
						throw new Exception("Error al crear el ejercicio", 901);
					}
				}

				$_mes_inicial = $_mes_final + 1;
				$_p++;
			}

			//relacionamos a la empresa con el ejercicio
			try {
				EjercicioEmpresaDAO::save(new EjercicioEmpresa(array(
					"id_ejercicio" => $_ejercicio->getIdEjercicio(),
					"id_empresa" => $empresa->getIdEmpresa()
				)));
			}catch (Exception $e) {
				DAO::transRollback();
				Logger::error("Error al relacionar la empresa con el ejercicio: " . $e->getMessage());
				throw new Exception("Error al relacionar la empresa con el ejercicio", 901);
			}
		}

		//En caso de haber recibido un array de impuestos de compra o venta registramos los impuestos
		{
			if (!empty($impuestos_compra)) {
				for ($i=0; $i < count($impuestos_compra); $i++) { 
					try {
						ImpuestoEmpresaDAO::save(new ImpuestoEmpresa(array(
							"id_empresa" => $empresa->getIdEmpresa(),
							"id_impuesto" => $impuestos_compra[$i]
						)));
					} catch (Exception $e) {
						Logger::warn("Error al guardar un impuesto de compra : " . $e->getMessage());
					}
				}
			}

			if (!empty($impuestos_venta)) {
				for ($i=0; $i < count($impuestos_venta); $i++) { 
					try {
						ImpuestoEmpresaDAO::save(new ImpuestoEmpresa(array(
							"id_empresa" => $empresa->getIdEmpresa(),
							"id_impuesto" => $impuestos_venta[$i]
						)));
					} catch (Exception $e) {
						Logger::warn("Error al guardar un impuesto de venta : " . $e->getMessage());
					}
				}
			}
		}

		//Editamos las cuentas bancarias
		{
			if (!empty($cuentas_bancarias)) {
				foreach ($cuentas_bancarias as $cuenta_bancarias) {
					//Pendiente hasta que se haga el SPEC de cuentas bancarias
				}
			}
		}

		DAO::transEnd();

		//Creamos el catalogo de cuentas por default para esta nueva empresa
		ContabilidadController::NuevoCatalogoCuentasEmpresa($empresa->getIdEmpresa());

		Logger::log("Empresa creada exitosamente, id=" . $empresa->getIdEmpresa());

		return array("id_empresa" => ((int) $empresa->getIdEmpresa()));
	}

	/**
	 * Eliminar($id_empresa)
	 *
	 * Para poder eliminar una empresa es necesario que la empresa no tenga sucursales activas, sus saldos sean 0, que los clientes asociados a dicha empresa no tengan adeudo, ...
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_empresa int id de la empresa a eliminar
	 **/
	public static function Eliminar($id_empresa)
	{
		//verificamos si la sucursal existe
		if (!$empresa = EmpresaDAO::getByPK($id_empresa)) {
			Logger::error("No se tiene registro de la empresa {$id_empresa}");
			throw new InvalidDataException("No se tiene registro de la empresa {$id_empresa}");
		}

		//verificamos si esta activa
		if ($empresa->getActivo() === "0") {
			Logger::error("La empresa $id_empresa ya esta desactivada");
			throw new Exception("La empresa ya esta desactivada",901);
		}

		//Se buscan las sucursales pertenecientes a esta empresa
		$sucursales_empresa = SucursalEmpresaDAO::search(new SucursalEmpresa(array(
			"id_empresa" => $id_empresa
		)));

		//Verificamos si existen sucursales activas pertenecientes a la empresa
		foreach ($sucursales_empresa as $sucursal) {
			if ($sucursal->getActivo() === "1") {
				Logger::error("Error : Hay una o mas sucursales activas, la empresa no se puede desactivar");
				throw new Exception("Error : Hay una o mas sucursales activas, la empresa no se puede desactivar",901);
			}
		}

		//verificamos si existen ejercicios vigentes relacionados con la empresa
		$ejercicios_empresas = EjercicioEmpresaDAO::search(new EjercicioEmpresa(array(
			"id_empresa" => $id_empresa
		)));

		foreach ($ejercicios_empresas as $ejercicio_empresa) {
			$ejercicios = EjercicioDAO::search(new Ejercicio(array(
				"id_ejercicio" => $ejercicio_empresa->getIdEjercicio()
			)));
			foreach ($ejercicios as $ejercicio) {
				/*
				* TODO : De momento esta validacion esta desactivada debido a que no hay manera de 
				* terminar los ejercicios, en cuanto se programe esa funcionalidad esta validacion 
				* debera de entrar en funcionamiento.
				*
				* if ($ejercicio->getVigente() === "1") {
				* 	Logger::error("No se puede eliminar la empresa {$id_empresa}, ya que tiene un ejercicio vigente");
				* 	throw new Exception("No se puede eliminar la empresa {$id_empresa}, ya que tiene un ejercicio vigente",901);
				* }
				*/
			}
		}

		//Se cambia el campo activo a falso y se registra la fecha de baja
		$empresa->setActivo(0);
		$empresa->setFechaBaja(time());

		try {
			EmpresaDAO::save($empresa);
		} catch(Exception $e) {
			Logger::error("Error la modificar la empresa : " . $e->getMessage());
			throw new Exception("Error al modificar la empresa.",901);
		}

		Logger::log("Empresa desactivada exitosamente...");
	}

	/**
	 *
	 * Un administrador puede editar una sucursal, incuso si hay puntos de venta con sesiones activas que pertenecen a esa empresa. 
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_empresa int Id de la empresa a modificar
	 * @param cuentas_bancarias json Arreglo que contiene los id de las cuentas bancarias
	 * @param direccion json {    "tipo": "fiscal",    "calle": "Francisco I Madero",    "numero_exterior": "1009A",    "numero_interior": 12,    "colonia": "centro",    "codigo_postal": "38000",    "telefono1": "4611223312",    "telefono2": "",       "id_ciudad": 3,    "referencia": "El local naranja"}
	 * @param direccion_web string Direccion del sitio de la empresa
	 * @param email string Correo electronico de la empresa
	 * @param id_moneda string Id de la moneda base que manejaran las sucursales
	 * @param impuestos_compra json Impuestos de compra por default que se heredan a las sucursales y estas a su vez a los productos
	 * @param impuestos_venta json Impuestos de venta por default que se heredan a las sucursales y estas a su vez a los productos
	 * @param mensaje_morosos string mensaje enviado a los clientes (email) cuando un pago es demorado
	 * @param razon_social string El nombre de la nueva empresa.
	 * @param representante_legal string El nombre del representante legal de la nueva empresa.
	 * @param rfc string RFC de la empresa
	 * @param uri_logo string url del logo de la empresa
	 **/
	public static function Editar($id_empresa, $cuentas_bancarias = null, $direccion = null, $direccion_web = null, 
		$email = null, $id_moneda = "0", $impuestos_compra = null, $impuestos_venta = null, 
		$mensaje_morosos = null, $razon_social = null, $representante_legal = null, $rfc = null, $uri_logo = null
	) {		
		//se guarda el registro de la empresa y se verifica que este activa
		$empresa = EmpresaDAO::getByPK($id_empresa);

		if (!$empresa->getActivo()) {
			Logger::error("La empresa no esta activa, no se puede editar una empresa desactivada");
			throw new Exception("La empresa no esta activa, no se puede editar una empresa desactivada", 901);
		}

		//editamos los campos referentes solo a la tabla empresa
		{
			$empresa->setDireccionWeb($direccion_web);

			//TODO : Por que carajos no esta el campo email!!
			//$empresa->setEmail($email);

			//TODO : No se debe de editar
			//$empresa->setIdMoneda($id_moneda);

			$empresa->setMensajeMorosos($mensaje_morosos);
			$empresa->setRazonSocial($razon_social);
			$empresa->setRepresentanteLegal($representante_legal);
			$empresa->setRfc($rfc);

			//editamos el id del logo
			if (!empty($uri_logo)) {
				//varificamos si cambio el logo

				$_logo = LogoDAO::getByPK($empresa->getIdLogo());

				if($uri_logo !== $_logo->getImagen()){
					$logo = new Logo(array(
						"imagen" => $uri_logo,
						"tipo" => "-"
					));

					try {
						LogoDAO::save($logo);
					}catch (Exception $e) {
						DAO::transRollback();
						Logger::error("No se pudo crear la empresa, error al crear el logo: " . $e->getMessage());
						throw new Exception("No se pudo crear la empresa, consulte a su administrador de sistema", 901);
					}

					$id_logo = $logo->getIdLogo();

					$empresa->setIdLogo($id_logo);
				}
				
			}

		}

		//lógica para manejar la edicion o agregado de una direccion verificamos si se cambiaron las direcciones
		if (!is_null($direccion)) {

			if (!is_array($direccion)) {
				//Logger::error("Verifique el formato de los datos de las direcciones, se esperaba un array ");
				//throw new Exception("Verifique el formato de los datos de las empresas, se esperaba un array ");
				$direccion = object_to_array($direccion);
			}

			$_direccion = new Direccion($direccion);

			$d = DireccionDAO::getByPK($empresa->getIdDireccion());

			//verificamos si se va a editar una direccion o se va a crear una nueva
			if (isset($d->id_direccion)) {

				//se edita la direccion
				if (!$_direccion = DireccionDAO::getByPK($d->id_direccion)) {
					DAO::transRollback();
					Logger::error("No se tiene registro de la dirección con id : {$direccion->id_direccion}");
					throw new InvalidDataException("No se tiene registro de la dirección con id : {$direccion->id_direccion}");
				}
				$_direccion->setIdDireccion($d->id_direccion);

				//bandera que indica si cambia algun parametro de la direccion
				$cambio_direccion = false;

				//calle
				if (isset($d->calle)) {
					$cambio_direccion = true;
					$_direccion->setCalle($direccion['calle']);
				}

				//numero_exterior
				if (isset($d->numero_exterior)) {
					$cambio_direccion = true;
					$_direccion->setNumeroExterior($direccion['numero_exterior']);
				}

				//numero_interior
				if (isset($d->numero_interior)) {
					$cambio_direccion = true;
					$_direccion->setNumeroInterior($direccion['numero_interior']);
				}

				//referencia
				if (isset($d->referencia)) {
					$cambio_direccion = true;
					$_direccion->setReferencia($direccion['referencia']);
				}

				//colonia
				if (isset($d->colonia)) {
					$cambio_direccion = true;
					$_direccion->setColonia($direccion['colonia']);
				}

				//id_ciudad
				if (isset($d->id_ciudad)) {
					$cambio_direccion = true;
					$_direccion->setIdCiudad($direccion['id_ciudad']);
				}

				//codigo_postal
				if (isset($d->codigo_postal)) {
					$cambio_direccion = true;
					$_direccion->setCodigoPostal($direccion['codigo_postal']);
				}

				//telefono
				if (isset($d->telefono)) {
					$cambio_direccion = true;
					$_direccion->setTelefono($direccion['telefono1']);
				}

				//telefono2
				if (isset($d->telefono2)) {
					$cambio_direccion = true;
					$_direccion->setTelefono2($direccion['telefono2']);
				}

				//Si cambio algun parametro de direccion, se actualiza el usuario que modifica y la fecha
				if ($cambio_direccion) {
					DireccionController::EditarDireccion($_direccion);
				} else {
					DireccionController::NuevaDireccion($calle = isset($d->calle) ? $d->calle : "", $numero_exterior = isset($d->numero_exterior) ? $d->numero_exterior : "", $colonia = isset($d->colonia) ? $d->colonia : "", $id_ciudad = isset($d->id_ciudad) ? $d->id_ciudad : "", $codigo_postal = isset($d->codigo_postal) ? $d->codigo_postal : "", $numero_interior = isset($d->numero_interior) ? $d->numero_interior : "", $referencia = isset($d->referencia) ? $d->referencia : "", $telefono = isset($d->telefono) ? $d->telefono : "", $telefono2 = isset($d->telefono2) ? $d->telefono2 : "");
				}
			}
		}

		DAO::transBegin();
		try {
			//Se guardan los cambios hechos en la empresa
			EmpresaDAO::save($empresa);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo modificar la empresa: " . $e);
			throw new Exception("No se pudo modificar la empresa");
		}

		/*
		* Si se obtiene el parametro impuestos se buscan los impuestos actuales de la empresa.
		* Por cada impuesto recibido, se verifica que el impuesto exista y se almacena en la tabla
		* impuesto_empresa. Si esta relacion ya existe solo se actualizara.
		*
		* Despues, se recorren los impuestos actuales y se buscan en la lista de impuestos recibidos.
		* Se eliminaran aquellos impuestos qe no esten en la lista recibida.
		*/
		{
			$impuestos_empresa = ImpuestoEmpresaDAO::search(new ImpuestoEmpresa(array(
				"id_empresa" => $empresa->getIdEmpresa()
			)));

			//quitamos los impuestos que no estan actualmente
			foreach ($impuestos_empresa as $impuesto_empresa) {
				$exist_ic = false;

				foreach ($impuestos_compra as $impuesto_compra) {
					if ($impuesto_compra->getIdImpuesto() == $impuesto_empresa->getIdImpuesto()) {
						$exist_ic = true;
					}
				}

				if (!$exist_ic) {
					try {
						ImpuestoEmpresaDAO::delete($impuesto_empresa);
					} catch (Exception $e) {
						Logger::warn("Error al eliminar impuesto : " . $e->getMessage());
					}
				}
			}

			$impuestos_empresa = ImpuestoEmpresaDAO::search(new ImpuestoEmpresa(array(
				"id_empresa" => $empresa->getIdEmpresa()
			)));

			foreach ($impuestos_empresa as $impuesto_empresa) {
				$exist_iv = false;

				foreach ($impuestos_venta as $impuesto_venta) {
					if ($impuesto_venta->getIdImpuesto() == $impuesto_venta->getIdImpuesto()) {
						$exist_iv = true;
					}
				}

				if (!$exist_iv) {
					try {
						ImpuestoEmpresaDAO::delete($impuesto_empresa);
					} catch (Exception $e) {
						Logger::warn("Error al eliminar impuesto : " . $e->getMessage());
					}
				}
			}

			//agregamos los impuestos de compra que no existen
			$impuestos_empresa = ImpuestoEmpresaDAO::search(new ImpuestoEmpresa(array(
				"id_empresa" => $empresa->getIdEmpresa()
			)));
			
			if ($impuestos_compra != NULL) {
				foreach ($impuestos_compra as $impuesto_compra) {
					$exist_ic = false;

					foreach ($impuestos_empresa as $impuesto_empresa) {
						if ($impuesto_compra->getIdImpuesto() == $impuesto_empresa->getIdImpuesto()) {
							$exist_ic = true;
						}
					}

					if (!$exist_ic) {
						try {
							ImpuestoEmpresaDAO::save(new ImpuestoEmpresa(array(
								"id_empresa" => $empresa->getIdEmpresa(),
								"id_impuesto" => $impuesto_compra->getIdImpuesto()
							)));
						} catch (Exception $e) {
							Logger::warn("Error al guardar un impuesto compra : " . $e->getMessage());
						}
					}
				}
			}

			//agregamos los impuestos de venta que no existen
			$impuestos_empresa = ImpuestoEmpresaDAO::search(new ImpuestoEmpresa(array(
				"id_empresa" => $empresa->getIdEmpresa()
			)));

			if ($impuestos_venta != NULL) {
				foreach ($impuestos_venta as $impuesto_venta) {
					$exist_iv = false;

					foreach ($impuestos_venta as $impuesto_venta) {
						if ($impuesto_venta->getIdImpuesto() == $impuesto_venta->getIdImpuesto()) {
							$exist_iv = true;
						}
					}

					if (!$exist_iv) {
						try {
							ImpuestoEmpresaDAO::save(new ImpuestoEmpresa(array(
								"id_empresa" => $empresa->getIdEmpresa(),
								"id_impuesto" => $impuesto_venta->getIdImpuesto()
							)));
						} catch (Exception $e) {
							Logger::warn("Error al guardar un impuesto venta : " . $e->getMessage());
						}
					}
				}
			}
		}

		//Editamos las cuentas bancarias
		{
			if ($cuentas_bancarias != NULL) {
				foreach ($cuentas_bancarias as $cuenta_bancarias) {
					//Pendiente hasta que se haga el SPEC de cuentas bancarias
				}
			}
		}

		DAO::transEnd();
		Logger::log("Empresa editada con exito");
	}

	/**
	 *Detalles($id_empresa)
	 *
	 *Muestra los detalles de una empresa en especifico. 
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_empresa int Id de la empresa
	 **/
	public static function Detalles($id_empresa)
	{
		//verificamos si la empresa a consular existe
		if (!$empresa = EmpresaDAO::getByPK($id_empresa)) {
			Logger::error("No se tiene registro de la empresa {$id_empresa}");
			throw new InvalidDataException("No se tiene registro de la empresa {$id_empresa}");
		}

		//extraemos su domicilio fiscal
		if (!$direccion = DireccionDAO::getByPK($empresa->getIdDireccion())) {
			$direccion = new stdClass();
		}

		//relacionamos a la empresa con la direccion
		$empresa->direccion = $direccion;

		//obtenemos el logo
		$logo = LogoDAO::getByPK($empresa->getIdLogo());

		if($logo === NULL) {
			$logo = LogoDAO::getByPK(-1);
		}

		$empresa->logo = $logo->getImagen();

		//obtenemos su contabilidad

		$contabilidad = array();

		$contabilidad["moneda_base"] = EmpresaDAO::getMonedaBase($empresa->getIdEmpresa());
		$contabilidad["ejercicio"] = EmpresaDAO::getEjercicioActual($empresa->getIdEmpresa());

		//extraemos sus sucursales
		$sucursales = array();

		$sucursales_empresa = SucursalEmpresaDAO::search(new SucursalEmpresa(array(
			"id_empresa" => $id_empresa
		)));

		foreach ($sucursales_empresa as $sucursal_empresa) {
			if ($sucursal = SucursalDAO::getByPK($sucursal_empresa->getIdSucursal())) {
				array_push($sucursales, $sucursal);
			}
		}

		//obtenemos todos los impuestos relacionados a la empresa
		$impuestos_empresa = ImpuestoEmpresaDAO::search(new ImpuestoEmpresa(array(
			"id_empresa" => $id_empresa
		)));

		//extraemos sus impuestos de compra
		$impuestos_compra = array();

		foreach ($impuestos_empresa as $impuesto_compra_empresa) {

			if (!$impuesto = ImpuestoDAO::getByPK($impuesto_compra_empresa->getIdImpuesto())) {
				Logger::warn("No se tiene registro de un impuesto con id = " . $impuesto_compra_empresa->getIdImpuesto());
				throw new InvalidDataException("No se tiene registro de un impuesto con id = " . $impuesto_compra_empresa->getIdImpuesto());
			}

			if ($impuesto->getAplica() === "compra" || $impuesto->getAplica() === "ambos") {
				array_push($impuestos_compra, $impuesto);
			}
		}

		//extraemos sus impuestos de venta
		$impuestos_venta = array();

		foreach ($impuestos_empresa as $impuesto_venta_empresa) {

			if (!$impuesto = ImpuestoDAO::getByPK($impuesto_venta_empresa->getIdImpuesto())) {
				Logger::warn("No se tiene registro de un impuesto con id = " . $impuesto_venta_empresa->getIdImpuesto());
				throw new InvalidDataException("No se tiene registro de un impuesto con id = " . $impuesto_venta_empresa->getIdImpuesto());
			}

			if ($impuesto->getAplica() === "venta" || $impuesto->getAplica() === "ambos") {
				array_push($impuestos_venta, $impuesto);
			}
		}

		return array("detalles" => $empresa, "sucursales" => $sucursales, "impuestos_compra" => $impuestos_compra, "impuestos_venta" => $impuestos_venta, "contabilidad" => $contabilidad);

		Logger::log("Detalles de la empresa enviados con exito");
	}

}
