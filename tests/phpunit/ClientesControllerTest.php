<?php



require_once("../../server/bootstrap.php");


class ClientesControllerTests extends PHPUnit_Framework_TestCase {

	protected function setUp() {
		Logger::log("-----------------------------");

		$r = SesionController::Iniciar(123, 1, true);

		if ($r["login_succesful"] == false) {
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");

			$r = SesionController::Iniciar(123, 1, true);
		}
	}

	public function testExtraParamsOutOfSync() {


		//create user A
		$userA = ClientesController::Nuevo("userA".time());
		Logger::log("Create client A  [userid=". $userA["id_cliente"]."]");

		//create extra param
		$extraParamStruct = new ExtraParamsEstructura();
		$extraParamStruct->setTabla("usuarios");
		$extraParamStruct->setCampo("campo" . time());
		$extraParamStruct->setTipo("string");
		$extraParamStruct->setEnum(NULL);
		$extraParamStruct->setLongitud(128);
		$extraParamStruct->setObligatorio(FALSE);
		$extraParamStruct->setCaption("caption" . time());
		$extraParamStruct->setDescripcion("description".time());

		ExtraParamsEstructuraDAO::save( $extraParamStruct );
		Logger::log("Extra params " . $extraParamStruct->getIdExtraParamsEstructura() . " created");

		//create user B
		$userB = ClientesController::Nuevo("userB".time());
		Logger::log("Create client B  [userid=". $userB["id_cliente"]."]");

		//user B should have extra param
		Logger::log("Looking for extra params in clientB");
		$userBExtraParams = ExtraParamsValoresDAO::getVals("usuarios", $userB["id_cliente"]);

		$found = false;
		for ($i = 0 ; $i < sizeof($userBExtraParams); $i++) {
				if ($userBExtraParams[$i]["campo"] == $extraParamStruct->getCampo()) {
				$found = true;
			}
		}

		$this->assertTrue($found, "ClientB should have the new extra param campo=" . $extraParamStruct->getCampo());

		ExtraParamsValoresDAO::actualizarRegistros("usuarios");

		//user A should have extra param
		$userAExtraParams = ExtraParamsValoresDAO::getVals("usuarios", $userA["id_cliente"]);

		$found = false;
		for ($i = 0 ; $i < sizeof($userAExtraParams); $i++) {
			if ($userAExtraParams[$i]["campo"] == $extraParamStruct->getCampo()) {
				$found = true;
			}
		}

		$this->assertTrue($found, "When adding new extraparams old users should get updated" . $extraParamStruct->getCampo());
	}


	public function testNuevaClasificacionCliente() {

		$id = ClientesController::NuevaClasificacion('Cla-' . time(), 'Cla-' . time(), $descripcion = null);

		$this->assertInternalType("int" , $id['id_categoria_cliente'], "---- 'testNuevaClasificacionCliente' 'id' NO ES UN ENTERO , algo salio mal con la insercion");
	}

	public function RandomString($length = 10,$uc = FALSE, $n = FALSE, $sc = FALSE) {
		$source = 'abcdefghijklmnopqrstuvwxyz';
		if ($uc == 1) {
			$source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		}
		if ($n == 1) {
			$source .= '1234567890';
		}
		if ($sc == 1) {
			$source .= '|@#~$%()=^*+[]{}-_';
		}

		if ($length > 0) {
			$rstr = "";
			$source = str_split($source, 1);

			for ($i = 1; $i <= $length; $i++) {
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1, count($source));
				$rstr .= $source[$num-1];
			}
		}
		return $rstr;
	}


	public function testNuevoCliente() {
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();

		$c = ClientesController::nuevo(
			$nombre,
			$clasificacion_cliente = null,
			$codigo_cliente = time(),
			$cuenta_de_mensajeria = null,
			$curp = null,
			$denominacion_comercial = null,
			$descuento_general = null,
			$direcciones = Array(Array(
				"calle"				=> "Monte Balcanes",
				"numero_exterior"	=> "107",
				"colonia"			=> "Arboledas",
				"id_ciudad"			=> 334,
				"codigo_postal"		=> "38060",
				"numero_interior"	=> null,
				"texto_extra"		=> "Calle cerrada",
				"telefono1"			=> "4616149974",
				"telefono2"			=> "45*451*454"
			)),
			$email = null,
			$id_cliente_padre = null,
			$id_moneda = 1 ,
			$id_tarifa_compra = null,
			$id_tarifa_venta = null,
			$limite_credito = null,
			$password = null,
			$representante_legal = null,
			$rfc = null,
			$sitio_web = null,
			$telefono_personal1 = null,
			$telefono_personal2 = null
		);

		$this->assertInternalType("int" , $c["id_cliente"], "---- 'testNuevoCliente' 'id_cliente' NO ES UN ENTERO");
		$array_datos_cliente = ClientesController::Detalle($c['id_cliente']);
		$this->assertNotEquals(null , $array_datos_cliente[0]->getIdDireccion(), "---- 'testNuevoCliente' 'id_direccion' NO TIENE VALOR, NO SE INSERTÓ LA DIRECCION");

	}


	public function testDetalleCliente() {
		//se crea un nuevo cliente 
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$nuevo_cliente = ClientesController::nuevo($nombre);
		$this->assertInternalType("int" , $nuevo_cliente["id_cliente"], "---- 'testDetalleCliente' 'id_cliente' NO ES UN ENTERO");

		$array_datos_cliente = ClientesController::Detalle($nuevo_cliente['id_cliente']);
		$this->assertEquals($nombre, $array_datos_cliente[0]->getNombre(), "---- 'testDetalleCliente' LOS DATOS EXTRAÍDOS NO COINCIDEN CON EL DEL ID SOLICITADO");

	}

	public function testEditarCliente() {
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$denominacion = "Denominacion - " . time();
		$descuento = 10;
		$limite_credito = 1000;
		$pass = "hola123";
		$sitio = "myweb.com";
		//se crea el cliente que despues será editado
		$nuevo_cliente = ClientesController::nuevo(
			$nombre,
			$clasificacion_cliente = null,
			$codigo_cliente = null,
			$cuenta_de_mensajeria = null,
			$curp = null,
			$denominacion_comercial = $denominacion,
			$descuento_general = $descuento,
			$direcciones = null,
			$email = null,
			$id_cliente_padre = null,
			$id_moneda =  1 ,
			$id_tarifa_compra = null,
			$id_tarifa_venta = null,
			$limite_credito = $limite_credito,
			$password = $pass,
			$representante_legal = null,
			$rfc = null,
			$sitio_web = $sitio,
			$telefono_personal1 = null,
			$telefono_personal2 = null
		);
		//se edita el cliente recien ingresado
		ClientesController::Editar(
			$nuevo_cliente['id_cliente'],
			$clasificacion_cliente = null,
			$codigo_cliente = null,
			$cuenta_de_mensajeria = null,
			$curp = null,
			$denominacion_comercial = $denominacion . "-123",//se modifica este campo
			$descuento_general = 0,//se cambia a 0
			$direcciones = null,
			$email = null,
			$extra_params = null,
			$id_cliente_padre = null,
			$id_moneda =  null ,
			$id_tarifa_compra = null,
			$id_tarifa_venta = null,
			$limite_credito = 1500,//se cambia
			$password = "hola",//se cambia
			$password_anterior = "hola123",
			$razon_social = null,
			$representante_legal = null,
			$rfc = null,
			$sitio_web = $sitio.".mx",//se cambia
			$telefono_personal1 = null,
			$telefono_personal2 = null
		);

		$array_datos_cliente = ClientesController::Detalle($nuevo_cliente['id_cliente']);
		$this->assertNotEquals($denominacion, 	$array_datos_cliente[0]->getDenominacionComercial(), "---- 'testEditarCliente' LA DENOMINACION NO SE ACTUALIZÓ");
		$this->assertNotEquals(10, 				$array_datos_cliente[0]->getDescuento(),			 "---- 'testEditarCliente' EL DESCUENTO GENERAL NO SE ACTUALIZÓ");
		$this->assertNotEquals(1000, 			$array_datos_cliente[0]->getLimiteCredito(),		 "---- 'testEditarCliente' LIMINTE DE CREDITO NO SE ACTUALIZÓ");
		$this->assertNotEquals("hola123", 		$array_datos_cliente[0]->getPassword(),				 "---- 'testEditarCliente' PASSWORD NO SE ACTUALIZÓ");
		$this->assertNotEquals($sitio, 			$array_datos_cliente[0]->getPaginaWeb(),			 "---- 'testEditarCliente' SITIO WEB NO SE ACTUALIZÓ");
	}



	public function testBuscarClientesPorID_Usuario() {
		//se crea un nuevo cliente que es el que debe de ser encontrado en el query
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$nuevo_cliente = ClientesController::nuevo($nombre);

		$res = ClientesController::Buscar($id_suc = null, $id_usuario = $nuevo_cliente['id_cliente']);

		$this->assertInternalType("int" , $res["numero_de_resultados"], "---- 'testBuscarClientesPorID_Usuario' 'numero_de_resultados' NO ES UN ENTERO");

		$this->assertEquals(1, $res['numero_de_resultados'], "---- 'testBuscarClientesPorID_Usuario' SE DEBIÓ DE ENCONTRAR SÓLO 1 RESULTADO");

		if($res["numero_de_resultados"] > 0 && $res["resultados"][0]["id_usuario"] != $nuevo_cliente['id_cliente']) {
			$this->assertEquals($res["resultados"][0]->getIdUsuario(), $nuevo_cliente['id_cliente'], "---- 'testBuscarClientesPorID_Usuario' LOS IDS NO COINCIDEN SE ENVIÓ EL id_usuario =".$nuevo_cliente['id_cliente']."Y LA CONSULTA DEVOLVIÓ id_usuario = ".$res["resultados"][0]->getIdUsuario());
		}
	}

	public function testBuscarClientesPorQuery() {
		//se crea un nuevo cliente que es el que debe de ser encontrado en el query
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$nuevo_cliente = ClientesController::nuevo($nombre);

		$res = ClientesController::Buscar($id_sucursal = null, $id_usuario = null, $limit = 50, $page = null, $query = $nombre);//se busca el usr recien insertado
		$this->assertInternalType("int" , 	$res["numero_de_resultados"], "---- 'testBuscarClientesPorQuery' 'numero_de_resultados' NO ES UN ENTERO");
		$this->assertGreaterThanOrEqual(1, 	$res['numero_de_resultados'], "---- 'testBuscarClientesPorQuery' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO");
	}

	public function testBuscarClientes() {

		//se crea un nuevo cliente
		$nombre = self::RandomString(12, FALSE, FALSE, FALSE);
		$nuevo_cliente = ClientesController::nuevo($nombre);

		$busqueda = ClientesController::Buscar();
		//se realiza una busqueda general y se verifica que contenga los parametros de respuesta
		$this->assertArrayHasKey('resultados', $busqueda);
		$this->assertArrayHasKey('numero_de_resultados', $busqueda);
		//que los tipos de datos sean los esperados
		$this->assertInternalType('int', 	$busqueda['numero_de_resultados'], "---- 'testBuscarClientes' 'numero_de_resultados' NO ES UN ENTERO");
		$this->assertInternalType('array', 	$busqueda['resultados'],		   "---- 'testBuscarClientes' 'resultados' NO ES UN ARRAY");

		$this->assertGreaterThanOrEqual(0, $busqueda['numero_de_resultados'], "---- 'testBuscarClientes' 'numero_de_resultados' NO ES UN VALOR VALIDO");

		//probamos busqueda por start
		$busqueda = ClientesController::Buscar($id_sucursal = null, $id_usuario = null, $limit = 50 , $page = null, $query = null, $start = 1);       
		$this->assertGreaterThanOrEqual(1, $busqueda["numero_de_resultados"], "---- 'testBuscarClientes' DEBE DE DEVOLVER ALMENOS 1 RESULTADO");

		//probamos busqueda por limit
		$busqueda = ClientesController::Buscar($id_sucursal = null, $id_usuario = null, $limit = 1, $page = null, $query = null, $start = null);
		$this->assertGreaterThanOrEqual(1, $busqueda["numero_de_resultados"], "---- 'testBuscarClientes' DEBE DE DEVOLVER ALMENOS 1 RESULTADO");

		//probamos busqueda por query
		$busqueda = ClientesController::Buscar($id_sucursal = null, $id_usuario = null, $limit = 1, $page = null, $query = $nombre, $start = null);
		$this->assertGreaterThanOrEqual(0, $busqueda["numero_de_resultados"], "---- 'testBuscarClientes' 'numero_de_resultados' NO ES UN VALOR VALIDO");

		//valores combinados
		$busqueda = ClientesController::Buscar($id_sucursal = null, $id_usuario = null, $limit = 5 , $page = null, $query = $nombre, $start = 1);

		$this->assertGreaterThanOrEqual(0, $busqueda["numero_de_resultados"], "---- 'testBuscarClientes' 'numero_de_resultados' NO ES UN VALOR VALIDO");

	}

	public function testNuevaClasificacion() {
		$nombre_clasificacion = time();
		$clave_clasificacion = "c" . time();
		$desc = self::RandomString(25, FALSE, FALSE, FALSE) . " - ";

		$nueva = ClientesController::NuevaClasificacion($clave_clasificacion, $nombre_clasificacion, $desc);

		$this->assertInternalType('int', $nueva['id_categoria_cliente'], "---- 'testNuevaClasificacion' 'id_categoria_cliente' NO ES UN ENTERO");
	}


	/**
	 * @expectedException BusinessLogicException
	 */
	public function testNuevaClasificacionConMismoNombre() {
		//se inserta una clasificacion
		$nombre_clasificacion = self::RandomString(5, FALSE, FALSE, FALSE) . " - ";
		$clave_clasificacion = self::RandomString(2, TRUE, FALSE, FALSE) . " - ";
		$desc = self::RandomString(25, FALSE, FALSE, FALSE) . " - ";

		$nueva = ClientesController::NuevaClasificacion($clave_clasificacion, $nombre_clasificacion,$desc);
		$this->assertInternalType('int', $nueva['id_categoria_cliente'], "---- 'testNuevaClasificacionConMismoNombre' 'id_categoria_cliente' NO ES UN ENTERO");

		//se trata de insertar otra clasificacion con el mismo nombre y los demás datos
		$nueva2 = ClientesController::NuevaClasificacion($clave_clasificacion, $nombre_clasificacion, $desc);
	}

	public function testEditarClasificacion() {
		//se inserta una clasificacion
		$nombre_clasificacion = self::RandomString(5, FALSE, FALSE, FALSE) . "-";
		$clave_clasificacion = self::RandomString(8, TRUE, FALSE, FALSE) . " - ";
		$desc = self::RandomString(25, FALSE, FALSE, FALSE) . " - ";

		$nueva = ClientesController::NuevaClasificacion($clave_clasificacion, $nombre_clasificacion,$desc);
		$this->assertInternalType('int', $nueva['id_categoria_cliente'], "---- 'testEditarClasificacion' 'id_categoria_cliente' NO ES UN ENTERO");

		//se edita la clasificacion recien ingresada
		ClientesController::EditarClasificacion($nueva['id_categoria_cliente'], $clave_clasificacion . "1", $desc, $nombre_clasificacion . "1");

	}

	public function testBuscarClasificacionClientesPorQuery() {
		//se crea una nueva clasificacion que es la que debe de ser encontrada en el query
		$nombre_clasificacion = self::RandomString(5, FALSE, FALSE, FALSE) . "-";
		$clave_clasificacion = self::RandomString(8,TRUE, FALSE, FALSE) . " - ";
		$desc = self::RandomString(25, FALSE, FALSE, FALSE) . " - ";

		$nueva = ClientesController::NuevaClasificacion($clave_clasificacion, $nombre_clasificacion, $desc);
		$this->assertInternalType('int', $nueva['id_categoria_cliente'], "---- 'testBuscarClasificacionClientesPorQuery' 'id_categoria_cliente' NO ES UN ENTERO");

		$res = ClientesController::BuscarClasificacion($limit =  50 , $page = null, $query = $nombre_clasificacion , $start =  0);//se busca el usr recien insertado
		$this->assertNotNull($res, "---- 'testBuscarClasificacionClientesPorQuery' ::BuscarClasificacion() NO DEVOLVIÓ NINGÚN VALOR");
		$this->assertInternalType("int" , $res["numero_de_resultados"], "---- 'testBuscarClasificacionClientesPorQuery' 'numero_de_resultados' NO ES UN ENTERO");
		$this->assertGreaterThanOrEqual(1, $res['numero_de_resultados'], "---- 'testBuscarClasificacionClientesPorQuery' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO");
	}

	public function testNuevoAval() {
		//Crear un cliente
		$a = ClientesController::nuevo(time() . "cliente");
		
		//crear su aval
		$b = ClientesController::nuevo(time() . "aval");
		
		//asignar el aval al cliente
		ClientesController::NuevoAval(array(array("id_aval" => $b["id_cliente"] , "tipo_aval" => "prendario")), $a["id_cliente"]);

		$r = ClienteAvalDAO::getByPK($a["id_cliente"], $b["id_cliente"]);

		$this->assertNotNull($r);
	}

	public function testNuevoClienteDesdeAdminPAQ() {

		POSController::DropBd();
		
		$raw_exportation = file_get_contents("adminpaq.catalogo.clientes.csv");

		ClientesController::Importar($raw_exportation);

	}

	public function testNuevoClienteDesdeCSV() {

		POSController::DropBd();

		$raw_exportation = file_get_contents("adminpaq.catalogo.clientes.csv");

		ClientesController::ImportarCSV($raw_exportation);

	}

// public function testInsertarUsuariosSapuraiya() {

// 				$json_agenda = '{
// "items": [
// {
// "id_cita": "1",
// "inicia": "1373896800",
// "termina": "1373898000",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "2",
// "inicia": "1373898300",
// "termina": "1373899500",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "3",
// "inicia": "1373899800",
// "termina": "1373901000",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "4",
// "inicia": "1373901300",
// "termina": "1373902500",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "5",
// "inicia": "1373902800",
// "termina": "1373904000",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "6",
// "inicia": "1373904300",
// "termina": "1373905500",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "7",
// "inicia": "1373905800",
// "termina": "1373907000",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "8",
// "inicia": "1373907300",
// "termina": "1373908500",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "9",
// "inicia": "1373908800",
// "termina": "1373910000",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "10",
// "inicia": "1373910300",
// "termina": "1373911500",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "11",
// "inicia": "1373916600",
// "termina": "1373917800",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "12",
// "inicia": "1373918100",
// "termina": "1373919300",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "13",
// "inicia": "1373919600",
// "termina": "1373920800",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "14",
// "inicia": "1373921100",
// "termina": "1373922300",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "15",
// "inicia": "1373922600",
// "termina": "1373923800",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "16",
// "inicia": "1373924100",
// "termina": "1373925300",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "17",
// "inicia": "1373925600",
// "termina": "1373926800",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "18",
// "inicia": "1373927100",
// "termina": "1373928300",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// },
// {
// "id_cita": "19",
// "inicia": "1373928600",
// "termina": "1373929800",
// "id_empresa": "",
// "razon_social": "",
// "status": "0",
// "descripcion_status": "Libre",
// "confirmacion": "0",
// "cancelacion": "0",
// "concretada": "0",
// "satisfaccion": "0",
// "token": "",
// "hora_solicitud" : "0",
// "hora_llegada" : "0"
// }
// ]
// }';

// 		$NombreArchivo = "sapuraiya_testing_durango.xls";
// 		$this->assertTrue(file_exists ($NombreArchivo));
// 		if(! file_exists ($NombreArchivo))
// 			return;

// 		$FilaInicio=2;
// 		$ColInicio=-1;
// 		$FilaFin=-1;
// 		$ColFin=-1;
// 		$Cabeceras=array();//Crea el arreglo de cabeceras
// 		$Contenido=array();//Crea el arreglo de contenido
// 		$ItCols=0;$ItFils=0;
// 		$Lector = new PHPExcel_Reader_Excel5;
// 		$ObjExcel = $Lector->load($NombreArchivo);
// 		$Hoja=$ObjExcel->getActiveSheet();//Obtiene la hoja activa

// 		$a = array('À','Á','Â','Ã','Ä','Å','Æ','Ç','È','É','Ê','Ë','Ì','Í','Î','Ï','Ð','Ñ','Ò','Ó','Ô','Õ','Ö','Ø','Ù','Ú','Û','Ü','Ý','ß',
// 					'à','á','â','ã','ä','å','æ','ç','è','é','ê','ë','ì','í','î','ï','ñ','ò','ó','ô','õ','ö','ø','ù','ú','�»','ü','ý','ÿ',
// 					'Ā','ā','Ă','ă','Ą','ą','Ć','ć','Ĉ','ĉ','Ċ','ċ','Č','č','Ď','ď','Đ','đ','Ē','ē','Ĕ','ĕ','Ė','ė','Ę','ę','Ě','ě','Ĝ','ĝ',
// 					'Ğ','ğ','Ġ','ġ','Ģ','ģ','Ĥ','ĥ','Ħ','ħ','Ĩ','ĩ','Ī','ī','Ĭ','ĭ','Į','į','İ','ı','Ĳ','ĳ','Ĵ','ĵ','Ķ','ķ','Ĺ','ĺ','�»','ļ',
// 					'Ľ','ľ','Ŀ','ŀ','Ł','ł','Ń','ń','Ņ','ņ','Ň','ň','ŉ','Ō','ō','Ŏ','ŏ','Ő','ő','Œ','œ','Ŕ','ŕ','Ŗ','ŗ','Ř','ř','Ś','ś','Ŝ','ŝ',
// 					'Ş','ş','Š','š','Ţ','ţ','Ť','ť','Ŧ','ŧ','Ũ','ũ','Ū','ū','Ŭ','ŭ','Ů','ů','Ű','ű','Ų','ų','Ŵ','ŵ','Ŷ','ŷ','Ÿ','Ź','ź','�»','ż',
// 					'Ž','ž','ſ','ƒ','Ơ','ơ','Ư','ư','Ǻ','�»','Ǽ','ǽ','Ǿ','ǿ');
// 		$b = array('A','A','A','A','A','A','AE','C','E','E','E','E','I','I','I','I','D','N','O','O','O','O','O','O','U','U','U','U','Y','s','a',
// 					'a','a','a','a','a','ae','c','e','e','e','e','i','i','i','i','n','o','o','o','o','o','o','u','u','u','u','y','y','A','a','A','a','A',
// 					'a','C','c','C','c','C','c','C','c','D','d','D','d','E','e','E','e','E','e','E','e','E','e','G','g','G','g','G','g','G','g','H','h',
// 					'H','h','I','i','I','i','I','i','I','i','I','i','IJ','ij','J','j','K','k','L','l','L','l','L','l','L','l','l','l','N','n','N','n','N',
// 					'n','n','O','o','O','o','O','o','OE','oe','R','r','R','r','R','r','S','s','S','s','S','s','S','s','T','t','T','t','T','t','U','u','U',
// 					'u','U','u','U','u','U','u','U','u','W','w','Y','y','Y','Z','z','Z','z','Z','z','s','f','O','o','U','u','A','a','I','i','O','o','U','u',
// 					'A','a','AE','ae','O','o');

// 		foreach($Hoja->getRowIterator() as $IteradorFilas){
// 			foreach($IteradorFilas->getCellIterator() as $IteradorColumnas){
// 				if($ItFils==$FilaInicio){//Carga las cabeceras
// 					if($ColFin>-1){
// 						if(($ItCols>$ColInicio)&&($ItCols<$ColFin)){//Comprueba que esté dentro de los límites de columnas

// 							$nueva = strtolower(str_replace($a, $b, $IteradorColumnas->getValue()));

// 							array_push($Cabeceras,$nueva);
// 						}
// 					}else{
// 							if($ItCols>$ColInicio){//Comprueba que esté dentro de los límites de columnas

// 								$nueva = strtolower(str_replace($a, $b, $IteradorColumnas->getValue()));

// 								array_push($Cabeceras,$nueva);
// 							}
// 					}
// 				}
// 				$ItCols++;
// 			}
// 			$ItCols=0;
// 			$ItFils++;
// 		}
// 		if(($ColFin<=(sizeof($Cabeceras)-1))&&($ColFin>-1)){
// 			$X=$ColFin;
// 		}else{
// 			$X=sizeof($Cabeceras)-1;
// 		}
// 		if(($FilaFin>-1)&&($FilaFin<=$ItFils)){
// 			$Y=$ItFils;
// 		}else{
// 			$Y=$ItFils;
// 		}

// 		for($m=($FilaInicio+2);$m<=$Y;$m++){
// 			$ArrFila=array();//Reinicia la variable
// 			for($n=$ColInicio;$n<=$X;$n++){
// 				if($n < 0){
// 					continue;
// 				}

// 					$encabezado = $Cabeceras[$n];
// 					$celda = $Hoja->getCellByColumnAndRow($n, $m)->getValue();
// 					$ArrFila[$encabezado] = $celda;
// 			}
// 			array_push($Contenido, $ArrFila);
// 		}

// 		$params = array();
// 		$i=1;

// 		foreach ($Cabeceras as $c) {

// 			if($c !='R.F.C' && $c!="r.f.c" && $c!="NOMBRE O RAZÓN SOCIAL" && $c!="nombre o razón social"
// 				&& $c!="TELÉFONO" && $c!="teléfono" && $c!="CORREO ELECTRÓNICO" && $c!="correo electrónico"
// 				&& $c!="PÁGINA WEB" && $c!="página web")
// 			{

// 				$extra = new ExtraParamsEstructura();
// 				$extra->setTabla("usuarios");
// 				$extra->setTipo("string");
// 				$extra->setObligatorio(0);
// 				if(strlen($c)>32){
// 					$aux = str_replace(" ","_",substr($c,0,31));
// 					$extra->setCampo(str_replace(".","_",$aux));

// 					$extra->setCaption(substr($c,0,28)."...");
// 				}else{
// 					$extra->setCaption($c);

// 					$aux = str_replace(" ","_",$c);
// 					$extra->setCampo(str_replace(".","_",$aux));
// 				}
// 				$extra->setDescripcion($c);
// 				$extra->setLongitud(999999999);
// 				try{
// 					Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 					ExtraParamsEstructuraDAO::save( $extra );
// 					$i++;
// 					$extra->setCampo($c);
// 					$extra->setCaption($c);
// 					array_push($params,$extra);
// 				}catch(Exception $e){
// 					Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 				}

// 			}
// 		}
// //PARAMETROS EXTRA QUE SE DAN DE ALTA QUE NO VIENEN EN EL EXCEL
// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("Agenda");
// 		$extra->setCampo("Agenda");
// 		$extra->setDescripcion("La agenda de Sapuraiya");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("num_credenciales");
// 		$extra->setCampo("num_credenciales");
// 		$extra->setDescripcion("Numero de credenciales");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("credenciales_restantes");
// 		$extra->setCampo("credenciales_restantes");
// 		$extra->setDescripcion("Las credenciales restantes");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("hora_llegada");
// 		$extra->setCampo("hora_llegada");
// 		$extra->setDescripcion("Las hora de llegada");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("tipo_empresa");
// 		$extra->setCampo("tipo_empresa");
// 		$extra->setDescripcion("El tipo de empresa");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("nro_empleados");
// 		$extra->setCampo("nro_empleados");
// 		$extra->setDescripcion("El numero de empleados con los que cuenta la empresa");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("ubicacion");
// 		$extra->setCampo("ubicacion");
// 		$extra->setDescripcion("La ubicacion de la empresa");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// 		$extra = new ExtraParamsEstructura();
// 		$extra->setTabla("usuarios");
// 		$extra->setTipo("string");
// 		$extra->setObligatorio(0);
// 		$extra->setCaption("maquinaria_equipo");
// 		$extra->setCampo("maquinaria_equipo");
// 		$extra->setDescripcion("La ubicacion de la empresa");
// 		$extra->setLongitud(999999999);
// 		try{
// 			Logger::log("---($i) AGREGANDO NUEVO PARAM EXTRA: ".$extra->campo);
// 			ExtraParamsEstructuraDAO::save( $extra );
// 			array_push($params,$extra);
// 		}catch(Exception $e){
// 			Logger::log("--------> Error al insertar Parametro extra desde ClientesControllerTest, Error:".$e);
// 		}

// //usuarios a pincel

// 		$nuevo = new Usuario();
// 		$nuevo->setFechaAsignacionRol(time());
// 		$nuevo->setFechaAlta(time());
// 		$nuevo->setPassword(hash("md5","password"));
// 		$nuevo->setTarifaCompraObtenida('cliente');
// 		$nuevo->setTarifaVentaObtenida('cliente');
// 		$nuevo->setIdRol(0);
// 		$nuevo->setActivo(1);
// 		$nuevo->setIdPerfil(1);
// 		$nuevo->setConsignatario(0);
// 		$nuevo->setIdTarifaCompra(2);
// 		$nuevo->setIdTarifaVenta(1);
// 		$nuevo->setLimiteCredito(0);
// 		$nuevo->setSaldoDelEjercicio(0);
// 		$nuevo->setNombre("usr1");
// 		$nuevo->setCodigoUsuario("usr1");
// 		UsuarioDAO::save($nuevo);

// 		$nuevo = new Usuario();
// 		$nuevo->setFechaAsignacionRol(time());
// 		$nuevo->setFechaAlta(time());
// 		$nuevo->setPassword(hash("md5","password"));
// 		$nuevo->setTarifaCompraObtenida('cliente');
// 		$nuevo->setTarifaVentaObtenida('cliente');
// 		$nuevo->setIdRol(0);
// 		$nuevo->setActivo(1);
// 		$nuevo->setIdPerfil(1);
// 		$nuevo->setConsignatario(0);
// 		$nuevo->setIdTarifaCompra(2);
// 		$nuevo->setIdTarifaVenta(1);
// 		$nuevo->setLimiteCredito(0);
// 		$nuevo->setSaldoDelEjercicio(0);
// 		$nuevo->setNombre("usr2");
// 		$nuevo->setCodigoUsuario("usr2");
// 		UsuarioDAO::save($nuevo);

// 		$nuevo = new Usuario();
// 		$nuevo->setFechaAsignacionRol(time());
// 		$nuevo->setFechaAlta(time());
// 		$nuevo->setPassword(hash("md5","password"));
// 		$nuevo->setTarifaCompraObtenida('cliente');
// 		$nuevo->setTarifaVentaObtenida('cliente');
// 		$nuevo->setIdRol(0);
// 		$nuevo->setActivo(1);
// 		$nuevo->setIdPerfil(1);
// 		$nuevo->setConsignatario(0);
// 		$nuevo->setIdTarifaCompra(2);
// 		$nuevo->setIdTarifaVenta(1);
// 		$nuevo->setLimiteCredito(0);
// 		$nuevo->setSaldoDelEjercicio(0);
// 		$nuevo->setNombre("usr3");
// 		$nuevo->setCodigoUsuario("usr3");
// 		UsuarioDAO::save($nuevo);

// //FIN PARAMETROS EXTRA QUE SE DAN A PINCEL

// 		$i=1;
// 		$nuevos_user = array();
// 		foreach ($Contenido as $c) {
// 			$nuevo = new Usuario();
// 			$nuevo->setFechaAsignacionRol(time());
// 			$nuevo->setFechaAlta(time());
// 			$nuevo->setPassword(hash("md5","54pR7@21"));
// 			$nuevo->setTarifaCompraObtenida('cliente');
// 			$nuevo->setTarifaVentaObtenida('cliente');
// 			$nuevo->setIdRol(5);
// 			$nuevo->setActivo(1);
// 			$nuevo->setIdPerfil(1);
// 			$nuevo->setConsignatario(0);
// 			$nuevo->setIdTarifaCompra(2);
// 			$nuevo->setIdTarifaVenta(1);
// 			$nuevo->setLimiteCredito(0);
// 			$nuevo->setSaldoDelEjercicio(0);

// 			if(array_key_exists('R.F.C', $c) || array_key_exists("r.f.c", $c)){
// 				if(array_key_exists('R.F.C', $c)){
// 					$nuevo->setRfc($c["R.F.C"]);
// 				}
// 				if (array_key_exists("r.f.c", $c)) {
// 					$nuevo->setRfc($c["r.f.c"]);
// 				}
// 			}

// 			if(array_key_exists("NOMBRE O RAZON SOCIAL", $c) || array_key_exists("nombre o razon social", $c)){
// 				if(array_key_exists('NOMBRE O RAZON SOCIAL', $c)){
// 					$nuevo->setNombre($c["NOMBRE O RAZON SOCIAL"]);
// 				}
// 				if (array_key_exists("nombre o razon social", $c)) {
// 					$nuevo->setNombre($c["nombre o razon social"]);
// 				}
// 			}

// 			if(array_key_exists("TELEFONO", $c) || array_key_exists("telefono", $c)){
// 				if(array_key_exists('TELEFONO', $c)){
// 					$nuevo->setTelefonoPersonal1($c["TELEFONO"]);
// 				}
// 				if (array_key_exists("telefono", $c)) {
// 					$nuevo->setTelefonoPersonal1($c["telefono"]);
// 				}
// 			}

// 			if(array_key_exists("CORREO ELECTRONICO", $c) || array_key_exists("correo electronico", $c)){
// 				if(array_key_exists('CORREO ELECTRONICO', $c)){
// 					$nuevo->setCorreoElectronico($c["CORREO ELECTRONICO"]);
// 					$nuevo->setCodigoUsuario($c["CORREO ELECTRONICO"]);
// 				}
// 				if (array_key_exists("correo electronico", $c)) {
// 					$nuevo->setCorreoElectronico($c["correo electronico"]);
// 					$nuevo->setCodigoUsuario($c["correo electronico"]);
// 				}
// 			}

// 			if(array_key_exists("PAGINA WEB", $c) || array_key_exists("pagina web", $c)){
// 				if(array_key_exists('PAGINA WEB', $c)){
// 					$nuevo->setPaginaWeb($c["PAGINA WEB"]);
// 				}
// 				if (array_key_exists("pagina web", $c)) {
// 					$nuevo->setPaginaWeb($c["pagina web"]);
// 				}
// 			}

// 			if(array_key_exists("PASSWORD PARA SISTEMA DE AGENDA", $c) || array_key_exists("password para sistema de agenda", $c)){
// 				if(array_key_exists('PASSWORD PARA SISTEMA DE AGENDA', $c)){
// 					if(strlen($c["PASSWORD PARA SISTEMA DE AGENDA"])>0)
// 						$nuevo->setPassword(hash("md5",$c["PASSWORD PARA SISTEMA DE AGENDA"]));
// 				}
// 				if (array_key_exists("password para sistema de agenda", $c)) {
// 					if(strlen($c["password para sistema de agenda"])>0)
// 						$nuevo->setPassword(hash("md5",$c["password para sistema de agenda"]));
// 				}
// 			}

// 			try{
// 				UsuarioDAO::save($nuevo);
// 				$i++;
// 				array_push($nuevos_user,$nuevo);
// 			}catch(Exception $e){
// 				Logger::log("--------> Error al insertar Usuario nuevo desde ClientesControllerTest, Error:".$e);
// 			}
// 		}


// $json_agenda = str_replace(chr(10), " ", $json_agenda);//salto linea
// $json_agenda = str_replace(chr(13), " ", $json_agenda);//retorno

// $json_maquinaria = '{%d}';

// 		//Logger::log("------------------------------------------------------------- Contenido: ".print_r($Contenido,true));
// 		//Logger::log("------------------------------------------------------------- Contenido: ".print_r($nuevos_user,true));

// 		foreach ($nuevos_user as $u) {
// 			$para = array();
// 			foreach ($Contenido as $c) {
// 				if ($c["correo electronico"]==$u->correo_electronico) {

// 					/*$para["Agenda"] = $json_agenda;
// 					$para["hora_llegada"] = "0";
// 					$para["tipo_empresa"]= "0";*/

// 					foreach ($params as $p) {
// 						$index = $p->campo;
// 						$prop ="";
// 						if(strlen($index)>32){
// 							$prop = str_replace(".","_",(str_replace(" ","_",substr($index,0,31))));
// 						}else{
// 							$prop = str_replace(".","_",(str_replace(" ","_",$index)));
// 						}

// 						if($index!="Agenda" && $index!="hora_llegada" && $index!="tipo_empresa" 
// 							&& $index!="num_credenciales" && $index!="credenciales_restantes"
// 							&& $index!="pagina_web" && $index!="correo_electronico"
// 							&& $index!= "nombre_o_razon_social" && $index != "password_para_sistema_de_agenda"
// 							&& $index!= "nro_empleados" && $index != "ubicacion"
// 							&& $index!= "maquinaria_equipo"
// 							/*&& $index!="parametro_extra1" && $index!="parametro_extra2"
// 							&& $index!="parametro_extra3" && $index!="parametro_extra4"
// 							&& $index!="parametro_extra5"*/){

// 							//if(strlen($c[$index])<1 || $c[$index]==NULL)
// 							//{
// 							//	$para[$prop] = "";
// 								//Logger::log("----------------------- LA PROPIEDAD : ".$prop." NO TIENE VALOR");
// 							//}
// 							//else
// 							//{
// 								$aux = str_replace($a, $b,$c[$index] );
// 								$aux = str_replace(chr(10), " ", $aux);//salto linea
// 								$aux = str_replace(chr(13), " ", $aux);//retorno
// 								$aux = str_replace(chr(34), "", $aux);//comilla doble
// 								$aux = str_replace(chr(39), "", $aux);//comilla simple
// 								$para[$prop] = $aux;
// 							//}

// 						}
// 					}
// 				}
// 			}

// 			//Se colocan los valores por default de los parametros extra que se dan a pincel
// 			$para["Agenda"] = $json_agenda;
// 			$para["hora_llegada"] = "0";
// 			$para["tipo_empresa"]= "0";

// 			$para["num_credenciales"] = "2";
// 			$para["credenciales_restantes"] = "2";

// 			$num_creden = explode(",",$para["quiero_participar_en_sapuraiya_"]);

// 			for ($i=0; $i < count($num_creden); $i++) { 
// 				$num_creden[$i] = trim($num_creden[$i]);
// 				if($num_creden[$i] =="AREA DE EXPOSICION CON STAND")
// 				{
// 					$para["num_credenciales"] = "4";
// 				}
// 			}

// 			if(count($num_creden)==1){
// 				if(strlen($num_creden[0])>1)
// 				{
// 					if($num_creden[0]=="AREA DE EXPOSICION CON STAND")
// 						$para["num_credenciales"] .= "b";
// 					else
// 						$para["num_credenciales"] .= "a";
// 				}
// 				else
// 				{
// 					$para["num_credenciales"] = "0";//registros 2012 no tienen ningun valor
// 					$para["credenciales_restantes"] = "0";//registros 2012 no tienen ningun valor
// 				}
// 			}

// 			if(count($num_creden)==2){
// 				if(in_array("ENCUENTRO DE NEGOCIOS CON TRACTORAS DEL SECTOR AUTOMOTRIZ",$num_creden)
// 					&& in_array("ENCUENTRO DE NEGOCIOS CON OTROS COMPRADORES",$num_creden))
// 					$para["num_credenciales"] .= "a";
// 				else
// 					$para["num_credenciales"] .= "c";
// 			}

// 			if(count($num_creden)==3){
// 				$para["num_credenciales"] .= "c";
// 			}

// 			$para["credenciales_restantes"] = substr($para["num_credenciales"], 0,1);

// 			$maquinaria = '"m1" : {"descripcion" : "'.str_replace(chr(34), "", $para["descripcion_1"]).'" , "marca" : "'.str_replace(chr(34), "", $para["marca_1"]).'" , "edad" : "'.str_replace(chr(34), "", $para["edad_1"]).'" , "unidades" : "'.str_replace(chr(34), "", $para["unidades_1"]).'" },';
// 			$maquinaria .= '"m2" : {"descripcion" : "'.str_replace(chr(34), "", $para["descripcion_2"]).'" , "marca" : "'.str_replace(chr(34), "", $para["marca_2"]).'" , "edad" : "'.str_replace(chr(34), "", $para["edad_2"]).'" , "unidades" : "'.str_replace(chr(34), "", $para["unidades_2"]).'" },';
// 			$maquinaria .= '"m3" : {"descripcion" : "'.str_replace(chr(34), "", $para["descripcion_3"]).'" , "marca" : "'.str_replace(chr(34), "", $para["marca_3"]).'" , "edad" : "'.str_replace(chr(34), "", $para["edad_3"]).'" , "unidades" : "'.str_replace(chr(34), "", $para["unidades_3"]).'" },';
// 			$maquinaria .= (trim($para["cuenta_con_certificaciones"])=="SI")?' "c" : "1"' : ' "c" : "0"';

// 			$para["maquinaria_equipo"] = str_replace("%d", $maquinaria, $json_maquinaria);//retorno
// 			$para["nro_empleados"] = $para["num__administrativos"] + $para["num__operadores"];
// 			$para["ubicacion"] = $para["delegacion_o_municipio"].", ".$para["estado"].", ".$para["pais"];

// 			//Logger::log(" ::::::::::::::::::::::::::::::::::::::::: Ubicación-> Municipio: '".print_r($para["delegacion_o_municipio"],true)."', estado: '".print_r($para["estado"],true)."' pais: '".print_r($para["pais"],true)."'");


// 			unset($para['quiero_participar_en_sapuraiya_']);//quitar ese param extra dado que solo se usaron los valores pero ya no se necesitan en la BD
// 			unset($para['pagina_web']);
// 			unset($para['correo_electronico']);
// 			unset($para['nombre_o_razon_social']);
// 			unset($para['password_para_sistema_de_agenda']);
// 			unset($para['estado']);
// 			unset($para['pais']);
// 			unset($para['delegacion_o_municipio']);
// 			unset($para['num__administrativos']);
// 			unset($para['num__operadores']);
// 			unset($para['cuenta_con_certificaciones']);
// 			unset($para['descripcion_1']);
// 			unset($para['marca_1']);
// 			unset($para['edad_1']);
// 			unset($para['unidades_1']);
// 			unset($para['descripcion_2']);
// 			unset($para['marca_2']);
// 			unset($para['edad_2']);
// 			unset($para['unidades_2']);
// 			unset($para['descripcion_3']);
// 			unset($para['marca_3']);
// 			unset($para['edad_3']);
// 			unset($para['unidades_3']);


// 			//fin valores por default de los params extra dados a pincel

// 			ClientesController::Editar(
// 										$id_cliente= $u->id_usuario, 
// 										$clasificacion_cliente = null, 
// 										$codigo_cliente = null, 
// 										$cuenta_de_mensajeria = null, 
// 										$curp = null, 
// 										$denominacion_comercial = null, 
// 										$descuento_general = null, 
// 										$direcciones = null, 
// 										$email = null, 
// 										$extra_params = $para, 
// 										$id_cliente_padre = null, 
// 										$id_moneda = null, 
// 										$id_tarifa_compra = null, 
// 										$id_tarifa_venta = null, 
// 										$limite_credito = null, 
// 										$password = null, 
// 										$password_anterior = null, 
// 										$razon_social = null, 
// 										$representante_legal = null, 
// 										$rfc = null, 
// 										$sitio_web = null, 
// 										$telefono_personal1 = null, 
// 										$telefono_personal2 = null
// 									);

// 		}

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("quiero_participar_en_sapuraiya_");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("pagina_web");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("correo_electronico");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("nombre_o_razon_social");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("password_para_sistema_de_agenda");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("estado");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("pais");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("delegacion_o_municipio");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("num__operadores");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("num__administrativos");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("cuenta_con_certificaciones");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("marca_1");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("edad_1");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("unidades_1");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("descripcion_1");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("marca_2");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("edad_2");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("unidades_2");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("descripcion_2");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("marca_3");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("edad_3");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("unidades_3");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 		$pe = new ExtraParamsEstructura();//borar params extra estructura
// 		$pe->setCampo("descripcion_3");
// 		$r = ExtraParamsEstructuraDAO::search($pe);
// 		ExtraParamsEstructuraDAO::delete($r[0]);

// 	}

	public function testCredenciales_Sapuraiya() {

		$res = ExtraParamsEstructuraDAO::search(new ExtraParamsEstructura(array("tabla" => "usuarios", "campo" => "Agenda")));

		if (count($res) <= 0) {
			return;
		}

		$u = UsuarioDAO::getAll();
		$o = "Empresa | Credenciales restantes | Numero de credenciales\n";

		foreach ($u as $user) {
			$out = ExtraParamsValoresDAO::getVals("usuarios", $user->getIdUsuario());

			$cr = $out[4]["val"];
			$nc = $out[8]["val"];

			if (strlen($nc > 1)) {
				$tipo_creden = substr($nc, 1, 1);
				switch ($tipo_creden) {
					case 'a':
						$nc = str_replace('a', " Proveedor", $nc);
						break;
					case 'b':
						$nc = str_replace('b', " Expositor", $nc);
						break;
					case 'c':
						$nc = str_replace('c', " Expositor/Proveedor", $nc);
						break;
					case 'd':
						$nc = str_replace('d', " Empresa Tractora", $nc);
						break;
				}
			}

			Logger::log("Credenciales restantes: " . $cr);
			Logger::log("Num credenciales: " . $nc);

			$o .= $user->getNombre() . " | " . $cr . " | " . $nc . "\n";

		}
		$fp = fopen('credenciales.txt', 'w');
		fwrite($fp, $o);
		fclose($fp);
	}

}

