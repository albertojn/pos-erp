<?php
require_once("interfaces/Contabilidad.interface.php");
/**
  *
  *
  *
  **/
	
  class ContabilidadController implements IContabilidad
  {
	/**
 	 *
 	 *Lista todas las facturas emitadas. Puede filtrarse por empresa, sucursal, estado y ordenarse por sus atributos 
	 *Update : �Es correcto como se esta manejando el argumento id_sucursal? Ya que entiendo que de esta manera solo se estan obteniendo las facturas de una sola sucursal.
 	 *
 	 * @param activos bool Si este valor no es obtenido, se listaran tanto facturas activas como canceladas, si es true, se listaran solo las facturas activas, si es false se listaran solo las facturas canceladas
 	 * @param id_empresa int Id de la empresa de la cual se listaran las facturas
 	 * @param id_sucursal int Id de la sucursal de la cual se listaran las facturas
 	 * @param orden json Valor que determinara el orden de la lista
 	 * @return facturas json Objeto que contendra la lista de facturas.
 	 **/
	public static function ListaFacturas
	(
		$activos = null, 
		$id_empresa = null, 
		$id_sucursal = null, 
		$orden = null
	)
	{  
  
  
	}

	/**
 	 *
 	 *Realiza una busqueda de las cuentas contables en base a los par?metros que se le pasen
 	 *
 	 * @param id_cuenta_padre int El id de la cuenta de la que depende
 	 * @param clasificacion enum `Activo Circulante`,`Activo Fijo`,`Activo Diferido`,`Pasivo Circulante`,`Pasivo Largo Plazo`,`Capital Contable`,`Ingresos`,`Egresos` 	 
 	 **/
	public static function NuevaClaveCuentaContable($id_catalogo_cuentas, $id_cuenta_padre = "", $clasificacion = "")
	{
		if($id_cuenta_padre!=null) {
			if (is_null(CuentaContableDAO::getByPK($id_cuenta_padre))) {
				return null;
			}
		}

		$clave = "";

		if ($id_cuenta_padre == "") {
			switch ($clasificacion) {
			case 'Activo Circulante':
				$clave .= "11";
				break;

			case 'Activo Fijo':
				$clave .= "12";
				break;

			case 'Activo Diferido':
				$clave .= "13";
				break;

			case 'Pasivo Circulante':
				$clave .= "14";
				break;

			case 'Pasivo Largo Plazo':
				$clave .= "15";
				break;

			case 'Capital Contable':
				$clave .= "16";
				break;

			case 'Ingresos':
				$clave .= "17";
				break;

			case 'Egresos':
				$clave .= "18";
				break;

			default:
				$clave .= "";
				break;
			}//switch

			$cuentas_nivel_1 = self::BuscarCuenta($id_catalogo_cuentas,"", $clasificacion ,
											"", "",
											"", "",
											"", "",
											"", $nivel = 1,
											"", ""
								);

			if (count($cuentas_nivel_1["resultados"])>0) { 

				$pre_clave = $cuentas_nivel_1["resultados"][count($cuentas_nivel_1["resultados"]) - 1]->getConsecutivoEnNivel() +1;
				$clave .= "-" . $pre_clave;

			} else {
				$clave .= "-1";
			}

		} else {
			$subcuentas = self::BuscarCuenta($id_catalogo_cuentas,"", "",
										"", "",
										"", "",
										"", $id_cuenta_padre,
										"", "",
										"", ""
							);
			$detalle_c = CuentaContableDAO::getByPK($id_cuenta_padre);
			$clave_padre = $detalle_c->getClave();

			if (count($subcuentas["resultados"])>0) {
				$pre_clave = $subcuentas["resultados"][count($subcuentas["resultados"]) - 1]->getConsecutivoEnNivel() +1;
				$clave .= $clave_padre. "-" . $pre_clave;
			} else {
				$clave .= $clave_padre . "-1";
			}

		}
		return $clave;

	}

	/**
 	 *
 	 *Realiza una busqueda de las cuentas contables en base a los par?metros que se le pasen
 	 *
 	 * @param afectable bool indica si sobre esta cuenta ya se pueden realizar operaciones
 	 * @param clasificacion enum `Activo Circulante`,`Activo Fijo`,`Activo Diferido`,`Pasivo Circulante`,`Pasivo Largo Plazo`,`Capital Contable`,`Ingresos`,`Egresos`
 	 * @param clave string La clave que se le dará a la nueva cuenta contable
 	 * @param consecutivo_en_nivel int Dependiendo del nivel de profundidad de la cuenta contable, este valor indicara dentro de su nivel que numero consecutivo le corresponde con respecto a las mismas que estan en su mismo nivel
 	 * @param es_cuenta_mayor bool Indica si la cuenta es de mayor
 	 * @param es_cuenta_orden bool si la cuenta no se contemplara en los estados financieros
 	 * @param id_cuenta_contable int El id de la cuenta contable
 	 * @param id_cuenta_padre int El id de la cuenta de la que depende
 	 * @param naturaleza enum `Acreedora`,`Deudora`
 	 * @param nivel int Nivel de profundidad que tendra la cuenta en el arbol de cuentas
 	 * @param nombre_cuenta string El nombre de la cuenta
 	 * @param tipo_cuenta enum `Balance`,`Estado de Resultados`
 	 **/
	public static function BuscarCuenta($id_catalogo_cuentas, $afectable = "", $clasificacion = "",
		$clave = "", $consecutivo_en_nivel = "", $es_cuenta_mayor = "",
		$es_cuenta_orden = "", $id_cuenta_contable = "", $id_cuenta_padre = "",
		$naturaleza = "", $nivel = "", $nombre_cuenta = "", $tipo_cuenta = ""
	) {

		$cuenta_buscar = new CuentaContable();

		$cat_buscar = CatalogoCuentasDAO::getByPK($id_catalogo_cuentas);
		if (is_null($cat_buscar)) {
			throw new InvalidDatabaseOperationException("El catalogo de cuentas con id " . $id_catalogo_cuentas . " no existe");
		}

		$cuenta_buscar->setIdCatalogoCuentas($id_catalogo_cuentas);

		if ($afectable!="") {
			$cuenta_buscar->setAfectable($afectable);
		}
		if ($clasificacion!="") {
			$cuenta_buscar->setClasificacion($clasificacion);
		}
		if ($clave!="") {
			$cuenta_buscar->setClave($clave);
		}
		if ($consecutivo_en_nivel!="") {
			$cuenta_buscar->setConsecutivoEnNivel($consecutivo_en_nivel);
		}
		if ($es_cuenta_mayor!="") {
			$cuenta_buscar->setEsCuentaMayor($es_cuenta_mayor);
		}
		if ($es_cuenta_orden!="") {
			$cuenta_buscar->setEsCuentaOrden($es_cuenta_orden);
		}
		if ($id_cuenta_contable!="") {
			$cuenta_buscar->setIdCuentaContable($id_cuenta_contable);
		}
		if ($id_cuenta_padre!="") {
			$cuenta_buscar->setIdCuentaPadre($id_cuenta_padre);
		}
		if ($naturaleza!="") {
			$cuenta_buscar->setNaturaleza($naturaleza);
		}
		if ($nivel!="") {
			$cuenta_buscar->setNivel($nivel);
		}
		if ($nombre_cuenta!="") {
			$cuenta_buscar->setNombreCuenta($nombre_cuenta);
		}
		if ($tipo_cuenta!="") {
			$cuenta_buscar->setTipoCuenta($tipo_cuenta);
		}
		$cuenta_buscar->setActiva(1);

		$cuentas = CuentaContableDAO::search($cuenta_buscar, "`clave`", "ASC");
		return array("resultados" => $cuentas);
	}

	public function ListarCatalogosCuentas()
	{
		$catalogos = CatalogoCuentasDAO::getAll();
		return array("resultados" => $catalogos);
	}

	public function ListarCuentasConceptosGastos(){

		$ctas = self::BuscarCuenta(1, $afectable = 1, $clasificacion = "Egresos",
								$clave = "", $consecutivo_en_nivel = "", $es_cuenta_mayor = "",
								$es_cuenta_orden = "", $id_cuenta_contable = "", $id_cuenta_padre = "",
								$naturaleza = "", $nivel = "", $nombre_cuenta = "", $tipo_cuenta = ""
								);
		//$x = self::ObtenerTodasSubcuentasCuentaContable(37);
		//Logger::log("::::::::::::::::::::: Recur x= ".print_r($x,true));
		return $ctas;
	}

	public function ObtenerTodasSubcuentasCuentaContable($id){

		$hijos = self::BuscarCuenta(1, $afectable = "", $clasificacion = "Egresos",
								$clave = "", $consecutivo_en_nivel = "", $es_cuenta_mayor = "",
								$es_cuenta_orden = "", $id_cuenta_contable = "", $id_cuenta_padre = $id,
								$naturaleza = "", $nivel = "", $nombre_cuenta = "", $tipo_cuenta = ""
								);
		$res = $hijos["resultados"];
		//Logger::log("----------------------- ObtenerCuentasConceptosGastos, hijos['resultados']: ".count($hijos["resultados"]));
		//Logger::log("::::::::::::::::::::::: ObtenerCuentasConceptosGastos, Res: ".count($res));
		foreach ($hijos["resultados"] as $h) {//Logger::log("----------------------- Dentro de foreach= ".$h->nombre_cuenta);
			$nietos = self::ObtenerCuentasConceptosGastos($h->getIdCuentaContable());
			$hijos = array_merge_recursive($hijos["resultados"],$nietos);//Logger::log("----------------------- Array hijos= ".print_r($hijos,true));
		}
		return $hijos["resultados"];
	}

	public function ListarCuentasConceptosIngresos(){

		return self::BuscarCuenta(1, $afectable = 1, $clasificacion = "Ingresos",
								$clave = "", $consecutivo_en_nivel = "", $es_cuenta_mayor = "",
								$es_cuenta_orden = "", $id_cuenta_contable = "", $id_cuenta_padre = "",
								$naturaleza = "", $nivel = "", $nombre_cuenta = "", $tipo_cuenta = ""
								);
	}

	/**
 	 *
 	 *Edita una cuenta contable que exista en el sistema
 	 *
 	 * @param id_cuenta_contable int El id de la cuenta a editar
 	 * @param abonos_aumentan bool si abonos aumentan es igual a 1 significa que en los movimientos los abonos aumentantaran
 	 * @param afectable bool Si se va a permitir realizar movimientos en ésta cuenta o no
 	 * @param cargos_aumentan bool Si es igual 1 significa que en los movimientos cuando se cargue a esta cuenta los cargos aumentaran
 	 * @param es_cuenta_mayor bool Indica si es cuenta de mayor
 	 * @param es_cuenta_orden bool Indica si es cuenta de orden
 	 * @param id_cuenta_padre int El Id de la cuenta a la que va a pertencer
 	 * @param naturaleza enum `Acreedora`,`Deudora`
 	 * @param nombre_cuenta string El nombre de la cuenta reemplazado
 	 * @param tipo_cuenta enum `Balance`,`Estado de Resultados`
 	 **/
	public static function EditarCuenta($id_cuenta_contable, $abonos_aumentan = "", 
		$afectable = "", $cargos_aumentan = "", $es_cuenta_mayor = "", $es_cuenta_orden = "", 
		$id_cuenta_padre = "", $naturaleza = "", $nombre_cuenta = "", $tipo_cuenta = ""
	) {

		$editar_cuenta = CuentaContableDAO::getByPK($id_cuenta_contable);
		if (is_null($editar_cuenta)) {
			throw new InvalidDatabaseOperationException("La cuenta con id " . $id_cuenta_contable . " no existe");
		}
		
		$subctas = self::BuscarCuenta($editar_cuenta->getIdCatalogoCuentas(),"", "",
											"", "",
											"", "",
											"", $id_cuenta_contable,
											"", "",
											"", ""
								);

		if (count($subctas["resultados"])>0) {
			throw new BusinessLogicException("No se puede editar una cuenta que tiene subcuentas. ");
		}

		if ($editar_cuenta->getNivel()==1 && count($subctas["resultados"])>0) {
			throw new BusinessLogicException("Una cuenta de Mayor nivel 1 que es por default no se puede editar");
		}

		if ($es_cuenta_orden == 1 && $es_cuenta_mayor == 1) {
			throw new BusinessLogicException("Una cuenta de Mayor no puede ser de Orden");
		}

		$cuenta_buscar = new CuentaContable();
		$cuenta_buscar->setNombreCuenta($nombre_cuenta);
		if (count(CuentaContableDAO::search($cuenta_buscar))>0) {
			throw new BusinessLogicException("Ya existe una cuenta con el nombre " . $nombre_cuenta);
		}

		$subcuenta = new CuentaContable();
		$subcuenta->setIdCuentaPadre($id_cuenta_contable);
		if (count(CuentaContableDAO::search($subcuenta))>0) {
			throw new BusinessLogicException("Ya existe subcuentas en esta cuenta con id " . $id_cuenta_contable . ", no se puede editar" );
		}

		$nivel ="";
		if ($editar_cuenta->getIdCuentaPadre()!=$id_cuenta_padre 
			&& !is_null($editar_cuenta->getIdCuentaPadre())
			&& $id_cuenta_padre!="") 
		{
		//cambia de cuenta padre, debe de cambiar la clave, nivel y el consecutivo
			
			$clave = self::NuevaClaveCuentaContable($editar_cuenta->getIdCatalogoCuentas(),$id_cuenta_padre,$editar_cuenta->getClasificacion());
			$nivel = 1;
			$consecutivo = 1;

			if ($id_cuenta_padre!="") {

				$detalle_c = CuentaContableDAO::getByPK($id_cuenta_padre);
				if (is_null($detalle_c)) {
					throw new InvalidDatabaseOperationException("La cuenta con id " . $id_cuenta_padre . " no existe");
				}

				$nivel = $detalle_c->getNivel() + 1;
				$subcuentas = self::BuscarCuenta($editar_cuenta->getIdCatalogoCuentas(),"", "",
											"", "",
											"", "",
											"", $id_cuenta_padre,
											"", "",
											"", ""
								);
				if (count($subcuentas["resultados"])>0) {
					$consecutivo = $subcuentas["resultados"][count($subcuentas["resultados"])-1]->getConsecutivoEnNivel() + 1;
				}

			} else {

				$cuentas_clasifi = self::BuscarCuenta($editar_cuenta->getIdCatalogoCuentas(),"", $clasificacion,
											"", "",
											"", "",
											"", "",
											"", $nivel=1,
											"", ""
								);
				if (count($cuentas_clasifi["resultados"])>0) {
					$consecutivo = $cuentas_clasifi["resultados"][count($cuentas_clasifi["resultados"])-1]->getConsecutivoEnNivel() + 1;
				}
			}
			$editar_cuenta->setClave($clave);
			$editar_cuenta->setNivel($nivel);
			$editar_cuenta->setConsecutivoEnNivel($consecutivo);
			$editar_cuenta->setIdCuentaPadre($id_cuenta_padre);
		}

		if ($nivel == 1 && $id_cuenta_padre != "") {
			throw new BusinessLogicException("Las cuentas de Nivel 1 no deben tener cuentas padre");
		}
		if ($nombre_cuenta!="") {
			$editar_cuenta->setNombreCuenta($nombre_cuenta);
		}
		if ($tipo_cuenta!="") {
			$editar_cuenta->setTipoCuenta($tipo_cuenta);
		}
		if ($naturaleza!="") {
			$editar_cuenta->setNaturaleza($naturaleza);
		}
		if ($afectable!="") {
			$editar_cuenta->setAfectable($afectable);
		}

		if ($tipo_cuenta=="Estado de Resultados" && $naturaleza=="Acreedora") {
			$editar_cuenta->setAbonosAumentan(1);
			$editar_cuenta->setCargosAumentan(0);
		}
		if ($tipo_cuenta=="Estado de Resultados" && $naturaleza=="Deudora") {
			$editar_cuenta->setAbonosAumentan(0);
			$editar_cuenta->setCargosAumentan(1);
		}
		if ($tipo_cuenta=="Balance" && $naturaleza=="Acreedora") {
			$editar_cuenta->setAbonosAumentan(1);
			$editar_cuenta->setCargosAumentan(0);
		}
		if ($tipo_cuenta=="Balance" && $naturaleza=="Deudora") {
			$editar_cuenta->setAbonosAumentan(0);
			$editar_cuenta->setCargosAumentan(1);
		}
		$editar_cuenta->setEsCuentaOrden($es_cuenta_orden);
		$editar_cuenta->setEsCuentaMayor($es_cuenta_mayor);


		DAO::transBegin();
        try {
            CuentaContableDAO::save($editar_cuenta);
            if ($id_cuenta_padre != "") {
				$cuenta_padre_afec = CuentaContableDAO::getByPK($id_cuenta_padre);
				if ($cuenta_padre_afec->getAfectable()==true) {
					$cuenta_padre_afec->setAfectable(false);
					CuentaContableDAO::save($cuenta_padre_afec);
				}
			}
        }catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se ha podido editar la cuenta: " . $e);
            if ($e->getCode() == 901)
                throw new Exception("No se ha podido editar la cuenta|: " . $e->getMessage(), 901);
            throw new Exception("No se ha podido editar la cuenta", 901);
        }
        DAO::transEnd();

        return array("status"=>"ok");

	}
	
	/**
 	 *
 	 *Desactiva una cuenta contable que exista en el sistema, no la elimina fisicamente de la BD, solo cambia su estado activa = 0
 	 *
 	 * @param id_cuenta_contable int El id de la cuenta a desactivar
 	 **/
	public static function EliminarCuenta($id_cuenta_contable)
	{
		$cuenta = CuentaContableDAO::getByPK($id_cuenta_contable);
		if (is_null($cuenta)) {
			throw new InvalidDatabaseOperationException("La cuenta con id " . $id_cuenta_contable . " no existe");
		}

		$subcuentas = self::BuscarCuenta($cuenta->getIdCatalogo(),"", "",
											"", "",
											"", "",
											"", $id_cuenta_contable,
											"", "",
											"", ""
								);
		if (count($subcuentas["resultados"])>0) {
			throw new BusinessLogicException("No se puede eliminar una cuenta que tiene subcuentas. ");
		}

		$cuenta->setActiva(false);
		DAO::transBegin();
        try {
            CuentaContableDAO::save($cuenta);
        }catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se ha podido desactivar la cuenta con id $id_cuenta_contable: " . $e);
            if ($e->getCode() == 901)
                throw new Exception("No se ha podido desactivar la cuenta con id $id_cuenta_contable | " . $e->getMessage(), 901);
            throw new Exception("No se ha podido desactivar la cuenta con id $id_cuenta_contable", 901);
        }
        DAO::transEnd();

        return array("status"=>"ok");
	}

	/**
 	 *
 	 *Genera una nueva cuenta contable en el sistema
 	 *
 	 * @param abonos_aumentan bool si abonos aumentan es igual a 1 significa que en los movimientos los abonos aumentantaran
 	 * @param cargos_aumentan bool Si es igual 1 significa que en los movimientos cuando se cargue a esta cuenta los cargos aumentaran
 	 * @param clasificacion enum `Activo Circulante`,`Activo Fijo`,`Activo Diferido`,`Pasivo Circulante`,`Pasivo Largo Plazo`,`Capital Contable`,`Ingresos`,`Egresos`
 	 * @param es_cuenta_mayor bool Indica si la cuenta es de mayor
 	 * @param es_cuenta_orden bool si la cuenta no se contemplara en los estados financieros
 	 * @param naturaleza enum `Acreedora`,`Deudora`
 	 * @param nombre_cuenta string El nombre de la cuenta
 	 * @param tipo_cuenta enum `Balance`,`Estado de Resultados`
 	 * @param id_cuenta_padre int id de la cuenta de la que depende
 	 **/
	public static function NuevaCuenta($abonos_aumentan, $cargos_aumentan,
		$clasificacion, $es_cuenta_mayor, $es_cuenta_orden, $id_catalogo_cuentas, $naturaleza, 
		$nombre_cuenta, $tipo_cuenta, $id_cuenta_padre = ""
	) {

		if ($es_cuenta_orden == 1 && $es_cuenta_mayor == 1) {
			throw new BusinessLogicException("Una cuenta de Mayor no puede ser de Orden");
		}

		if (($tipo_cuenta == "Balance" && $naturaleza == "Deudora") &&
			($clasificacion != "Activo Circulante"
			&& $clasificacion != "Activo Fijo"
			&& $clasificacion != "Activo Diferido")) {
			throw new BusinessLogicException("Clasificacion incorrecta para la cuenta de tipo Balance y Naturaleza Deudora");
		}

		if (($tipo_cuenta == "Balance" && $naturaleza == "Acreedora") &&
			($clasificacion != "Pasivo Circulante"
			&& $clasificacion != "Pasivo Largo Plazo"
			&& $clasificacion != "Capital Contable")) {
			throw new BusinessLogicException("Clasificacion incorrecta para la cuenta de tipo Balance y Naturaleza Acreedora");
		}

		if ($tipo_cuenta == "Estado de Resultados" && $naturaleza == "Acreedora" && $clasificacion != "Ingresos") {
			throw new BusinessLogicException("Clasificacion incorrecta para la cuenta de tipo Estado de Resultados y Naturaleza Acreedora");
		}

		if ($tipo_cuenta == "Estado de Resultados" && $naturaleza == "Deudora" && $clasificacion != "Egresos") {
			throw new BusinessLogicException("Clasificacion incorrecta para la cuenta de tipo Estado de Resultados y Naturaleza Deudora");
		}

		$cuenta_buscar = new CuentaContable();
		$cuenta_buscar->setNombreCuenta($nombre_cuenta);
		$cuenta_buscar->setIdCatalogoCuentas($id_catalogo_cuentas);
		$cc2 = CuentaContableDAO::search($cuenta_buscar);
		if (count($cc2)>0) {
			throw new BusinessLogicException(" Ya existe una cuenta con el nombre " . $nombre_cuenta);
		}

		$clave = self::NuevaClaveCuentaContable($id_catalogo_cuentas, $id_cuenta_padre,$clasificacion);
		$nivel = 1;
		$consecutivo = 1;

		if ($id_cuenta_padre!="") {

			$detalle_c = CuentaContableDAO::getByPK($id_cuenta_padre);
			if (is_null($detalle_c)) {
				throw new BusinessLogicException("La cuenta con id " . $id_cuenta_padre . " no existe");
			}

			$nivel = $detalle_c->getNivel() + 1;
			$subcuentas = self::BuscarCuenta($id_catalogo_cuentas,"", "",
										"", "",
										"", "",
										"", $id_cuenta_padre,
										"", "",
										"", ""
							);
			if (count($subcuentas["resultados"])>0) {
				$consecutivo = $subcuentas["resultados"][count($subcuentas["resultados"])-1]->getConsecutivoEnNivel() + 1;
			}

		} else {

			$cuentas_clasifi = self::BuscarCuenta($id_catalogo_cuentas,"", $clasificacion,
										"", "",
										"", "",
										"", "",
										"", $nivel=1,
										"", ""
							);

			if (count($cuentas_clasifi["resultados"])>0) {

				$consecutivo = $cuentas_clasifi["resultados"][count($cuentas_clasifi["resultados"])-1]->getConsecutivoEnNivel() + 1;
			}
		}

		if ($nivel == 1 && $id_cuenta_padre != "") {
			throw new BusinessLogicException("Las cuentas de Nivel 1 no deben tener cuentas padre");
		}

		$nueva_cuenta = new CuentaContable();
		$nueva_cuenta->setClave($clave);
		$nueva_cuenta->setNivel($nivel);
		$nueva_cuenta->setConsecutivoEnNivel($consecutivo);
		$nueva_cuenta->setNombreCuenta($nombre_cuenta);
		$nueva_cuenta->setTipoCuenta($tipo_cuenta);
		$nueva_cuenta->setNaturaleza($naturaleza);
		$nueva_cuenta->setClasificacion($clasificacion);
		$nueva_cuenta->setAfectable(1);
		$nueva_cuenta->setActiva(1);
		$nueva_cuenta->setAbonosAumentan($abonos_aumentan);
		$nueva_cuenta->setCargosAumentan($cargos_aumentan);
		if ($tipo_cuenta=="Estado de Resultados" && $naturaleza=="Acreedora") {
			$nueva_cuenta->setAbonosAumentan(1);
			$nueva_cuenta->setCargosAumentan(0);
		}
		if ($tipo_cuenta=="Estado de Resultados" && $naturaleza=="Deudora") {
			$nueva_cuenta->setAbonosAumentan(0);
			$nueva_cuenta->setCargosAumentan(1);
		}
		if ($tipo_cuenta=="Balance" && $naturaleza=="Acreedora") {
			$nueva_cuenta->setAbonosAumentan(1);
			$nueva_cuenta->setCargosAumentan(0);
		}
		if ($tipo_cuenta=="Balance" && $naturaleza=="Deudora") {
			$nueva_cuenta->setAbonosAumentan(0);
			$nueva_cuenta->setCargosAumentan(1);
		}
		$nueva_cuenta->setEsCuentaOrden($es_cuenta_orden);
		$nueva_cuenta->setEsCuentaMayor($es_cuenta_mayor);
		if($id_cuenta_padre!=""){
			$nueva_cuenta->setIdCuentaPadre($id_cuenta_padre);
		}
		$nueva_cuenta->setIdCatalogoCuentas($id_catalogo_cuentas);


		DAO::transBegin();
        try {
            CuentaContableDAO::save($nueva_cuenta);
            if ($id_cuenta_padre != "") {
				$cuenta_padre_afec = CuentaContableDAO::getByPK($id_cuenta_padre);
				if ($cuenta_padre_afec->getAfectable()==true) {
					$cuenta_padre_afec->setAfectable(false);
					CuentaContableDAO::save($cuenta_padre_afec);
				}
			}
        }catch (Exception $e) {
            DAO::transRollback();
            Logger::error("Desde Controller) No se ha podido guardar la nueva cuenta: " . $e);
            if ($e->getCode() == 901)
                throw new Exception("No se ha podido guardar la nueva cuenta|: " . $e->getMessage(), 901);
            throw new Exception("No se ha podido guardar la nueva cuenta", 901);
        }
        DAO::transEnd();

        return array("status"=>"ok","id_cuenta_contable"=>$nueva_cuenta->getIdCuentaContable());
	}

	/**
 	 *
 	 *
 	 *Dado un id obtiene una cuenta contable en el sistema que corresponda con ese id.
 	 *
 	 * @param id_cuenta_contable int id de la cuenta contable
 	 **/
	public static function DetalleCuenta($id_cuenta_contable)
	{
		$cuenta = CuentaContableDAO::getByPK($id_cuenta_contable);
		if (is_null($cuenta)) {
			throw new InvalidDatabaseOperationException("La cuenta con id " . $id_cuenta_contable . " no existe");
		}
		return object_to_array($cuenta);
	}

	public function DetalleCatalogoCuentas($id_catalogo_cuentas)
	{
		$catalogo = CatalogoCuentasDAO::getByPK($id_catalogo_cuentas);
		if (is_null($catalogo)) {
			throw new InvalidDatabaseOperationException("El catalogo de cuentas con id " . $id_catalogo_cuentas . " no existe");
		}
		return object_to_array($catalogo);
	}

	public function NuevoCatalogoCuentasEmpresa($id_empresa)
	{
		$empresa = EmpresaDAO::getByPK($id_empresa);

		if (is_null($empresa)) {
			throw new InvalidDatabaseOperationException("La empresa con id " . $id_empresa . " no existe");
		}

		$nuevo_catalogo_cuentas = new CatalogoCuentas();
		$nuevo_catalogo_cuentas->setIdEmpresa($id_empresa);
		$nuevo_catalogo_cuentas->setDescripcion("Catalogo de cuentas ".$empresa->getRazonSocial());

		DAO::transBegin();
        try {
            CatalogoCuentasDAO::save($nuevo_catalogo_cuentas);
        }catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se ha podido guardar la nueva cuenta: " . $e);
            throw new Exception("No se ha podido guardar el nuevo catalogo de cuentas|: " . $e->getMessage(), 901);
            
        }
        DAO::transEnd();

        self::InsertarCatalogoCuentasDefault($nuevo_catalogo_cuentas->getIdCatalogo());

        return array("status"=>"ok","id_catalogo_cuentas"=>$nuevo_catalogo_cuentas->getIdCatalogo());

	}

	public function InsertarCatalogoCuentasDefault($id_catalogo_cuentas)
	{
		self::CuentasActivoCirculante($id_catalogo_cuentas);
		self::CuentasActivoFijo($id_catalogo_cuentas);
		self::CuentasActivoDiferido($id_catalogo_cuentas);
		self::CuentasPasivoCirculante($id_catalogo_cuentas);
		self::CuentasPasivoLargoPlazo($id_catalogo_cuentas);
		self::CuentasCapitalContable($id_catalogo_cuentas);
		self::CuentasIngresos($id_catalogo_cuentas);
		self::CuentasEgresos($id_catalogo_cuentas);

	}

	public function CuentasActivoCirculante($id_catalogo_cuentas)
	{
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Bancos', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Caja', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Inversiones', 'Balance', $id_cuenta_padre = ""
						);
		$inventarios = self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Inventarios', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas,'Deudora', 
						'Inventarios en Materia Prima', 'Balance', $inventarios['id_cuenta_contable']
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Inventarios en Producto Procesado', 'Balance', $inventarios['id_cuenta_contable']
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Inventarios en Producto Terminado', 'Balance', $inventarios['id_cuenta_contable']
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Cuentas por Cobrar', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Deudores Diversos', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Impuestos a Favor', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Documentos por Cobrar', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'IVA Acreditable', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Circulante', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Anticipos de Impuestos', 'Balance', $id_cuenta_padre = ""
						);
	}

	public function CuentasActivoFijo($id_catalogo_cuentas)
	{
		self::NuevaCuenta(0, 1,
						'Activo Fijo', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Maquinaria y Equipos', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Fijo', 1, 0, $id_catalogo_cuentas,'Deudora', 
						'Terrenos', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Fijo', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Construccion o Edificios', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Fijo', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Equipo de Computo', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Fijo', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Mobiliario Equipo de Oficina', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Fijo', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Equipo de Transporte', 'Balance', $id_cuenta_padre = ""
						);
	}

	public function CuentasActivoDiferido($id_catalogo_cuentas)
	{
		self::NuevaCuenta(0, 1,
						'Activo Diferido', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Primas de seguro', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Activo Diferido', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Depositos en Garantía', 'Balance', $id_cuenta_padre = ""
						);
	}

	public function CuentasPasivoCirculante($id_catalogo_cuentas)
	{
		self::NuevaCuenta(1, 0,
						'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Proveedores', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Acreedores', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Impuestos por Pagar', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Anticipos a Clientes', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Documentos a Pagar a Corto Plazo', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Pasivo Circulante', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'IVA Causado', 'Balance', $id_cuenta_padre = ""
						);
	}

	public function CuentasPasivoLargoPlazo($id_catalogo_cuentas)
	{
		self::NuevaCuenta(1, 0,
						'Pasivo Largo Plazo', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Documentos por pagar a largo plazo', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Pasivo Largo Plazo', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Hipotecas', 'Balance', $id_cuenta_padre = ""
						);
	}

	public function CuentasCapitalContable($id_catalogo_cuentas)
	{
		$capital_social = self::NuevaCuenta(1, 0,
						'Capital Contable', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Capital Social', 'Balance', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Capital Contable', 0, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Fijo', 'Balance', $capital_social['id_cuenta_contable']
						);
		self::NuevaCuenta(1, 0,
						'Capital Contable', 0, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Variable', 'Balance', $capital_social['id_cuenta_contable']
						);
	}

	public function CuentasIngresos($id_catalogo_cuentas)
	{
		self::NuevaCuenta(1, 0,
						'Ingresos', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Ventas', 'Estado de Resultados', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(1, 0,
						'Ingresos', 1, 0, $id_catalogo_cuentas, 'Acreedora', 
						'Devoluciones Ventas', 'Estado de Resultados', $id_cuenta_padre = ""
						);
	}

	public function CuentasEgresos($id_catalogo_cuentas)
	{
		self::NuevaCuenta(0, 1,
						'Egresos', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Costos de Venta', 'Estado de Resultados', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Egresos', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Compras', 'Estado de Resultados', $id_cuenta_padre = ""
						);
		$eg = self::NuevaCuenta(0, 1,
						'Egresos', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Gastos', 'Estado de Resultados', $id_cuenta_padre = ""
						);
		self::NuevaCuenta(0, 1,
						'Egresos', 0, 0, $id_catalogo_cuentas, 'Deudora', 
						'Gastos de Administracion', 'Estado de Resultados', $eg['id_cuenta_contable']
						);
		self::NuevaCuenta(0, 1,
						'Egresos', 0, 0, $id_catalogo_cuentas, 'Deudora', 
						'Gastos de Venta', 'Estado de Resultados', $eg['id_cuenta_contable']
						);
		self::NuevaCuenta(0, 1,
						'Egresos', 0, 0, $id_catalogo_cuentas, 'Deudora', 
						'Gastos de Produccion', 'Estado de Resultados', $eg['id_cuenta_contable']
						);
		self::NuevaCuenta(0, 1,
						'Egresos', 1, 0, $id_catalogo_cuentas, 'Deudora', 
						'Resultado Integral Financiero', 'Estado de Resultados', $id_cuenta_padre = ""
						);
	}

  }
