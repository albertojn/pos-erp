<?php
require_once("../../server/bootstrap.php");

class ProductosControllerTest extends PHPUnit_Framework_TestCase {
	protected function setUp() {
		$r = SesionController::Iniciar(123, 1, true);

		if ($r["login_succesful"] == false) {
			global $POS_CONFIG;
			$POS_CONFIG["INSTANCE_CONN"]->Execute("INSERT INTO `usuario` (`id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_clasificacion_cliente`, `id_clasificacion_proveedor`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`) VALUES
				(1, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2011-10-24 18:28:24', 'Administrador', NULL, NULL, NULL, NULL, NULL, '2011-10-24 18:28:34', NULL, 1, 0, NULL, '202cb962ac59075b964b07152d234b70', NULL, 0, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 'rol', 0, 'rol');");

			$r = SesionController::Iniciar(123, 1, true);
		}
	}

	public function RandomString($length = 10, $uc = FALSE, $n = FALSE, $sc = FALSE) {
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
			$source = str_split($source,1);

			for ($i = 1; $i <= $length; $i++) {
				mt_srand((double)microtime() * 1000000);
				$num = mt_rand(1,count($source));
				$rstr .= $source[$num-1];
			}
		}

		return $rstr;
	}

	public function testImportarProductos() {
		$p = ProductosController::Importar(file_get_contents("adminpaq.catalogo.productos.csv"));
	}

	public function testNuevoProducto() {
		$codigo_p = self::RandomString(5,  FALSE, FALSE, FALSE);
		$nombre_p = self::RandomString(15, FALSE, FALSE, FALSE);

		$p = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= $codigo_p,
			$compra_en_mostrador	= true,
			$id_unidad_compra		= 1,
			$metodo_costeo			= "costo",
			$nombre_producto		= $nombre_p,
			$visible_en_vc			= true,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$costo_estandar			= 10,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= null,
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= null
		);

		$this->assertInternalType("int", $p["id_producto"], "---- 'testNuevoProducto' 'id_producto' NO ES UN ENTERO");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevoProductoConMismoNombre() {
		//se crea un nuevo producto
		$codigo_p = self::RandomString(5,  FALSE, FALSE, FALSE);
		$nombre_p = self::RandomString(15, FALSE, FALSE, FALSE);

		$p = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= $codigo_p,
			$compra_en_mostrador	= true,
			$costo_estandar			= 10,
			$id_unidad_compra		= 1,
			$metodo_costeo			= "costo",
			$nombre_producto		= $nombre_p,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= null,
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= 12
		);

		$this->assertInternalType("int", $p["id_producto"], "---- 'testNuevoProducto' 'id_producto' NO ES UN ENTERO");

		//se trata de insertar otro producto con el mismo nombre y codigo
		$p2 = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= $codigo_p,
			$compra_en_mostrador	= true,
			$costo_estandar			= 10,
			$id_unidad_compra		= 1,
			$metodo_costeo			="costo",
			$nombre_producto		= $nombre_p,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= null,
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= 12
		);
	}

	public function testEditarProducto() {
		$p = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= self::RandomString(5, FALSE, FALSE, FALSE),
			$compra_en_mostrador	= true,
			$id_unidad_compra		= 1,
			$metodo_costeo			= "costo",
			$nombre_producto		= self::RandomString(5, FALSE, FALSE, FALSE),
			$visible_en_vc			= true,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$costo_estandar			= 10,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= null,
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= 12
		);

		$this->assertInternalType("int", $p["id_producto"], "---- 'testEditarProducto' 'id_producto' NO ES UN ENTERO");

		//se edita el cliente recien ingresado
		ProductosController::Editar(
			$id_producto			= $p['id_producto'],
			$clasificaciones		= null,
			$codigo_de_barras		= null,
			$codigo_producto		= null,
			$compra_en_mostrador	= null,
			$control_de_existencia	= null,
			//se cambia
			$costo_estandar			= 12,
			$costo_extra_almacen	= null,
			$descripcion_producto	= null,
			$empresas				= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_unidad				= null,
			$id_unidad_compra		= null,
			$impuestos				= null,
			$metodo_costeo			= null,
			//se cambia
			$nombre_producto		= time() . "-E",
			$peso_producto			= null,
			$precio					= null
		);
	}

	public function testBuscarProductosPorID_Sucursal() {
		$dir_suc = self::RandomString(25, FALSE, FALSE, FALSE);
		$desc = self::RandomString(10, FALSE, FALSE, FALSE);

		$sucursal = SucursalesController::Nueva(
			$descripcion	= $desc,
			$direccion		= $dir_suc,
			$id_tarifa		= 1
		);

		$this->assertInternalType("int", $sucursal['id_sucursal'], "---- 'testBuscarProductosPorID_Sucursal' 'id_sucursal' NO ES UN ENTERO");

		$empresa_rfc	= self::RandomString(13, FALSE, FALSE, FALSE);
		$empresa_razon	= self::RandomString(10, FALSE, FALSE, FALSE);

		$contabilidad['id_moneda']			= 1;
		$contabilidad['ejercicio']			= "2013";
		$contabilidad['periodo_actual']		= 1;
		$contabilidad['duracion_periodo']	= 1;

		$empresa = EmpresasController::Nuevo(
			(object) $contabilidad,
			$direccion = array(array(
				"calle"				=> "Monte Balcanes",
				"numero_exterior"	=> "107",
				"colonia"			=> "Arboledas",
				"id_ciudad"			=> 334,
				"codigo_postal"		=> "38060",
				"numero_interior"	=> null,
				"referencia"		=> "Calle cerrada",
				"telefono1"			=> "4616149974",
				"telefono2"			=> "45*451*454"
			)),
			$razon_social = $empresa_razon,
			$rfc = $empresa_rfc
		);

		$this->assertInternalType("int", $empresa['id_empresa'], "---- 'testBuscarProductosPorID_Sucursal' 'id_empresa' NO ES UN ENTERO");

		//se crea un nuevo producto
		$codigo_p = self::RandomString(5,  FALSE, FALSE, FALSE);
		$nombre_p = self::RandomString(15, FALSE, FALSE, FALSE);

		$p = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= $codigo_p,
			$compra_en_mostrador	= true,
			$id_unidad_compra		= 1,
			$metodo_costeo			= "costo",
			$nombre_producto		= $nombre_p,
			$visible_en_vc			= true,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$costo_estandar			= 10,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= array($empresa['id_empresa']),
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= 12
		);

		//TODO: En un futuro desaparecera esto ya que por instancia lo correctro es que haya una sola empresa y todas als sucursales perteneceran a la empresa
		ProductoEmpresaDAO::save(new ProductoEmpresa(array("id_producto" => $p["id_producto"], "id_empresa" => $empresa['id_empresa'])));
		SucursalEmpresaDAO::save(new SucursalEmpresa(array("id_sucursal" => $sucursal['id_sucursal'], "id_empresa" => $empresa['id_empresa'])));

		$res = ProductosController::Buscar($query = null, $id_producto = null, $id_sucursal = $sucursal['id_sucursal']);
		$this->assertInternalType("int", $res["numero_de_resultados"], "---- 'testBuscarProductosPorID_Sucursal' 'numero_de_resultados' NO ES UN ENTERO");
		$this->assertGreaterThan(0, $res['numero_de_resultados'], "---- 'testBuscarProductosPorID_Sucursal' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO CON NOMBRE PRODUCTO: " . $nombre_p);
	}

	public function testBuscarProductosPorID_Producto(){
		//se crea un nuevo producto para buscarlo por su id
		$codigo_p = self::RandomString(5,  FALSE, FALSE, FALSE);
		$nombre_p = self::RandomString(15, FALSE, FALSE, FALSE);

		$p = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= $codigo_p,
			$compra_en_mostrador	= true,
			$id_unidad_compra		= 1,
			$metodo_costeo			= "costo",
			$nombre_producto		= $nombre_p,
			$visible_en_vc			= true,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$costo_estandar			= 10,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= null,
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= 12
		);

		$this->assertInternalType("int", $p["id_producto"], "---- 'testNuevoProducto' 'id_producto' NO ES UN ENTERO");

		$res = ProductosController::Buscar($query = null, $id_producto = $p['id_producto'], $id_sucursal = null);

		$this->assertInternalType("int", $res["numero_de_resultados"], "---- 'testBuscarProductosPorID_Producto' 'numero_de_resultados' NO ES UN ENTERO");
		$this->assertEquals($res['numero_de_resultados'], 1, "---- 'testBuscarProductosPorID_Producto' SE DEBIÓ DE ENCONTRAR SÓLO 1 RESULTADO CON id_producto = " . $p['id_producto']);

		foreach ($res["resultados"] as $row) {
			if ($row['id_producto'] != $p['id_producto']) {
				$this->assertEquals($row['id_producto'], $p['id_producto'], "---- 'testBuscarProductosPorID_Producto' LOS IDS NO COINCIDEN SE ENVIÓ EL id_producto =" . $p['id_producto'] . " Y LA CONSULTA DEVOLVIÓ id_producto = " . $row['id_producto']);
			}
		}
	}

	public function testBuscarProductosPorQuery(){
		//se crea un nuevo cliente que es el que debe de ser encontrado en el query
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$codigo = self::RandomString(5,  FALSE, FALSE, FALSE);

		$nuevo_prod = ProductosController::Nuevo(
			$activo					= true,
			$codigo_producto		= $codigo,
			$compra_en_mostrador	= true,
			$id_unidad_compra		= 1,
			$metodo_costeo			= "costo",
			$nombre_producto		= $nombre,
			$visible_en_vc			= true,
			$codigo_de_barras		= null,
			$control_de_existencia	= null,
			$costo_estandar			= 10,
			$descripcion_producto	= null,
			$foto_del_producto		= null,
			$garantia				= null,
			$id_categoria			= null,
			$id_empresas			= null,
			$id_unidad				= null,
			$impuestos				= null,
			$precio_de_venta		= 12
		);

		// se busca el prod recien insertado
		$res = ProductosController::Buscar(
			$query			= $nombre,
			$id_producto	= null,
			$id_sucursal	= null
		);

		$this->assertInternalType("int", $res["numero_de_resultados"], "---- 'testBuscarProductosPorQuery' 'numero_de_resultados' NO ES UN ENTERO");
		$this->assertGreaterThan(0, $res['numero_de_resultados'], "---- 'testBuscarProductosPorQuery' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO CON NOMBRE: " . $nombre);
	}

	public function testDesactivarProducto() {
		//se crea un nuevo cliente que es el que debe de ser encontrado en el query
		$nombre = self::RandomString(15, FALSE, FALSE, FALSE) . " - " . time();
		$codigo = self::RandomString(5,  FALSE, FALSE, FALSE);
		$nuevo_prod = ProductosController::Nuevo($activo = true, $codigo_producto = $codigo, $compra_mostrador = true, $costo_estandar = "costo", $id_unidad_compra = 1, $metodo_costeo = "costo", $nombre_producto = $nombre);
		$this->assertInternalType("int", $nuevo_prod["id_producto"], "---- 'testDesactivarProducto' 'id_producto' NO ES UN ENTERO");

		ProductosController::Desactivar($nuevo_prod["id_producto"]);
		//se busca el prod recien insertado para ver si esta activo = 0
		$res = ProductoDAO::getByPK($nuevo_prod["id_producto"]);
		$this->assertEquals(0, $res->getActivo(), "---- 'testDesactivarProducto' EL PRODUCTO NO SE DESACTIVÓ  id_producto= " . $nuevo_prod["id_producto"]);
	}

	public function testNuevaCategoria() {
		$nombre_cat = self::RandomString(15, true, FALSE, FALSE);

		$c = ProductosController::NuevaCategoria($nombre_cat);
		$this->assertInternalType("int", $c["id_categoria"], "---- 'testNuevaCategoria' 'id_categoria' NO ES UN ENTERO");
	}

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCategoriaMismoNombre() {
		$nombre_cat = self::RandomString(15, FALSE, FALSE, FALSE);
		$c = ProductosController::NuevaCategoria(
			$nombre				= $nombre_cat,
			$descripcion		= null,
			$id_categoria_padre	= null
		);
		$this->assertInternalType("int", $c["id_categoria"], "---- 'testNuevaCategoriaMismoNombre' 'id_categoria' NO ES UN ENTERO");
		//se intenta insertar otra cat con mismo nombre
		$cat2 = ProductosController::NuevaCategoria($nombre = $nombre_cat);
	}

	public function testEditarCategoria() {
		//se crea un nueva categoria
		$nombre_cat = self::RandomString(15, TRUE, FALSE, FALSE);
		$desc = self::RandomString(25, FALSE, FALSE, FALSE);

		$c = ProductosController::NuevaCategoria(
			$nombre				= $nombre_cat,
			$descripcion		= $desc,
			$id_categoria_padre	= null
		);

		$this->assertInternalType("int", $c["id_categoria"], "---- 'testEditarCategoria' 'id_categoria' NO ES UN ENTERO");

		//se edita la categoria recien ingresada
		ProductosController::EditarCategoria(
			$id_clasificacion_producto	= $c["id_categoria"],
			$descripcion				= "",
			$nombre						= $nombre_cat."-edit"
		);
	}

	public function testDetallesCategoria() {
		//se genera una categoria para despues buscarla por su id
		$nombre_cat = self::RandomString(15, FALSE, FALSE, FALSE);
		$c = ProductosController::NuevaCategoria($nombre_cat);
		$this->assertInternalType("int", $c["id_categoria"], "---- 'testNuevaCategoria' 'id_categoria' NO ES UN ENTERO");

		$res = ProductosController::DetallesCategoria($c['id_categoria']);
		$this->assertEquals(1, count($res), "---- 'testBuscarProductosPorID_Categoria' SE DEBIÓ DE ENCONTRAR UNICAMENTE 1 RESULTADO CON id_categoria = " . $c['id_categoria']);
	}

	public function testBuscarCategoriaPorQuery() {
		//se genera una categoria para despues buscarla por su nombre
		$nombre_cat = self::RandomString(15, FALSE, FALSE, FALSE);
		$desc = self::RandomString(25, FALSE, FALSE, FALSE);

		$c = ProductosController::NuevaCategoria(
			$nombre				= $nombre_cat,
			$descripcion		= $desc,
			$id_categoria_padre	= null
		);

		$this->assertInternalType("int", $c["id_categoria"], "---- 'testNuevaCategoria' 'id_categoria' NO ES UN ENTERO");

		$res = ProductosController::BuscarCategoria($id_categoria = null, $id_categoria_padre = null, $query = $nombre_cat);
		$this->assertGreaterThanOrEqual(1, count($res['categorias']), "---- 'testBuscarProductosPorID_Categoria' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO CON nombre = " . $nombre_cat);
	}


		/*
		public function testBuscarCategoriaPorID_CategoriaPadre(){
			//se genera una categoria para despues asignarla como id_padre a la otra
			$nombre_cat_padre = self::RandomString(15,FALSE,FALSE,FALSE);
			$desc_padre = self::RandomString(25,FALSE,FALSE,FALSE);
			$cp = ProductosController::NuevaCategoria($nombre = $nombre_cat_padre,
											$descripcion = $desc_padre,
											$id_categoria_padre = null
											);
			$this->assertInternalType("int" , $cp["id_categoria"],"---- 'testNuevaCategoria' 'id_categoria' NO ES UN ENTERO");

			$nombre_cat = self::RandomString(15,FALSE,FALSE,FALSE);
			$desc = self::RandomString(25,FALSE,FALSE,FALSE);
			$c = ProductosController::NuevaCategoria($nombre = $nombre_cat,
											$descripcion = $desc,
											$id_categoria_padre = $cp['id_categoria']
											);
			$this->assertInternalType("int" , $c["id_categoria"],"---- 'testNuevaCategoria' 'id_categoria' NO ES UN ENTERO");

			$res = ProductosController::BuscarCategoria($id_categoria = null, $id_categoria_padre = $cp['id_categoria'], $query = null );
			$this->assertInternalType("int" , $res["numero_de_resultados"],"---- 'testBuscarProductosPorID_CategoriaPadre' 'numero_de_resultados' NO ES UN ENTERO");
			$this->assertGreaterThanOrEqual(1, $res['numero_de_resultados'],"---- 'testBuscarProductosPorID_CategoriaPadre' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO CON id_categoria_padre = ".$cp['id_categoria']);

			foreach($res["resultados"] as $row){
				if($row['id_categoria'] != $cp['id_categoria'] || is_null($row->getIdProducto()))
					$this->assertEquals($row['id_categoria'],$cp['id_categoria'],"---- 'testBuscarProductosPorID_CategoriaPadre' LOS IDS NO COINCIDEN SE ENVIÓ EL id_categoria_padre = ".$cp['id_categoria']." Y LA CONSULTA DEVOLVIÓ id_categoria_padre = ".$row['id_categoria']);
			}
		}
		*/

		/*
		public function testVolumenEnNuevo(){
			$codigo_p = self::RandomString(5,FALSE,FALSE,FALSE);
			$nombre_p = self::RandomString(15,FALSE,FALSE,FALSE);
			$codigo_p2 = self::RandomString(5,FALSE,FALSE,FALSE);
			$nombre_p2 = self::RandomString(15,FALSE,FALSE,FALSE);
			$codigo_p3 = self::RandomString(5,FALSE,FALSE,FALSE);
			$nombre_p3 = self::RandomString(15,FALSE,FALSE,FALSE);

			$productos = array(
							array(
								"activo"				=> true,
								"codigo_producto"		=> $codigo_p,
								"compra_en_mostrador" 	=> true,
								"costo_estandar"   		=> 10,
								"id_unidad_compra"   	=> 1,
								"metodo_costeo"			=> "costo",
								"nombre_producto"		=> $nombre_p,
							),
							array(
								"activo"				=> true,
								"codigo_producto"		=> $codigo_p2,
								"compra_en_mostrador" 	=> true,
								"costo_estandar"   		=> 20,
								"id_unidad_compra"   	=> 1,
								"metodo_costeo"			=> "costo",
								"nombre_producto"		=> $nombre_p2,
							),
							array(
								"activo"				=> true,
								"codigo_producto"		=> $codigo_p3,
								"compra_en_mostrador" 	=> true,
								"costo_estandar"   		=> 30,
								"id_unidad_compra"   	=> 1,
								"metodo_costeo"			=> "costo",
								"nombre_producto"		=> $nombre_p3,
							)
						);
			$prod_insertados = ProductosController::VolumenEnNuevo($productos);
			$this->assertEquals(count($productos),count($prod_insertados),"---- 'testVolumenEnNuevo' SE DEBIERON DE INSERTAR ".count($productos)." PRODUCTOS, INSERTADOS: ".count($prod_insertados));
		}

		public function testNuevaCategoriaUdm(){
			$descripcion_catUdm = self::RandomString(15,true,FALSE,FALSE);

			$c = ProductosController::NuevaCategoriaUdm($descripcion = $descripcion_catUdm, $activo = null);
			$this->assertInternalType("int" , $c["id_categoria"],"---- 'testNuevaCategoriaUdm' 'id_categoria' NO ES UN ENTERO");
		}
		*/

	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaCategoriaUdmMismoNombre() {
		$c = ProductosController::NuevaCategoriaUdm("s");

		// $this->assertInternalType("int", $c["id_categoria_unidad_medida"],"---- 'testNuevaCategoriaUdm' 'id_categoria' NO ES UN ENTERO");

		//se intenta insertar otra cat con mismo nombre
		$cat2 = ProductosController::NuevaCategoriaUdm("s");
	}

		/*
		 *
		 * Aqui editar categoria se refiere a ProductoCategoria, no a CategoriaUdm
		 */
		/*
		public function testEditarCategoriaUdm(){
			//se crea un nueva categoria
			$descripcion_catUdm = self::RandomString(15,true,FALSE,FALSE);
			$descripcion_editada = self::RandomString(15,true,FALSE,FALSE);

			$c = ProductosController::NuevaCategoriaUdm($descripcion = $descripcion_catUdm, $activo = null);
			$this->assertInternalType("int" , $c["id_categoria_unidad_medida"],"'testEditarCategoriaUdm' 'id_categoria' NO ES UN ENTERO");

			$catUdm = CategoriaUnidadMedidaDAO::getByPK($c['id_categoria_unidad_medida']);
			//se edita la categoriaUdm recien ingresada

			ProductosController::EditarCategoria(
					$activa = $catUdm->getActiva(),
					$descripcion = $descripcion_editada,
					$c['id_categoria_unidad_medida']);


			//se redefine el obj para comparar valores
			$catUdm = CategoriaUnidadMedidaDAO::getByPK($c['id_categoria_unidad_medida']);


			$this->assertEquals( $catUdm->getDescripcion(),  $descripcion_editada, "NO SE EDITÓ LA CategoriaUdm SE DEBIÓ CAMBIAR: ".$descripcion_catUdm." POR: ".$descripcion_editada );

		}
		*/
		/*
		public function testBuscarCategoriaUdmPorQuery(){
			//se genera una categoria para despues buscarla por su nombre
			$descripcion_catUdm = self::RandomString(15,true,FALSE,FALSE);

			$c = ProductosController::NuevaCategoriaUdm($descripcion = $descripcion_catUdm, $activo = null);
			$this->assertInternalType("int" , $c["id_categoria"],"---- 'testBuscarCategoriaUdmPorQuery' 'id_categoria' NO ES UN ENTERO");

			$res = ProductosController::BuscarCategoria($limit =  50 , $page = null, $query = $descripcion_catUdm, $start =  0  );
			$this->assertInternalType("int" , $res["numero_de_resultados"],"---- 'testBuscarCategoriaUdmPorQuery' 'numero_de_resultados' NO ES UN ENTERO");
			$this->assertGreaterThanOrEqual(1, $res['numero_de_resultados'],"---- 'testBuscarCategoriaUdmPorQuery' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO CON nombre = ".$descripcion_catUdm);
		}
		*/

	public function testNuevaUnidadUdm() {
		$abreviatura_Udm = self::RandomString(5, true, FALSE, FALSE);
		$descripcion_Udm = self::RandomString(15, true, FALSE, FALSE);
		$descripcion_catUdm = self::RandomString(15, true, FALSE, FALSE);

		$cat = ProductosController::NuevaCategoriaUdm($descripcion = $descripcion_catUdm, $activo = null);

		$udm = ProductosController::NuevaUnidadUdm(
			$abreviatura				= $abreviatura_Udm,
			$descripcion				= $descripcion_Udm,
			$factor_conversion			= 1,
			$id_categoria_unidad_medida	= $cat['id_categoria_unidad_medida'],
			$tipo_unidad_medida			= "Referencia UdM para esta categoria",
			$activa						= null
		);

		$this->assertInternalType("int", $udm["id_unidad_medida"], "---- 'testNuevaUnidadUdm' 'id_unidad_medida' NO ES UN ENTERO");
	}



	/**
	* @expectedException BusinessLogicException
	*/
	public function testNuevaUnidadUdmNombreRepetido() {
		$abreviatura_Udm	= self::RandomString(5,  true, FALSE, FALSE);
		$descripcion_Udm	= self::RandomString(15, true, FALSE, FALSE);
		$descripcion_catUdm	= self::RandomString(15, true, FALSE, FALSE);

		$cat = ProductosController::NuevaCategoriaUdm($descripcion = $descripcion_catUdm, $activo = null);

		$udm = ProductosController::NuevaUnidadUdm(
			$abreviatura				= $abreviatura_Udm,
			$descripcion				= $descripcion_Udm,
			$factor_conversion			= 1,
			$id_categoria_unidad_medida	= $cat['id_categoria_unidad_medida'],
			$tipo_unidad_medida			= "Referencia UdM para esta categoria",
			$activa						= null
		);

		$this->assertInternalType("int", $udm["id_unidad_medida"], "---- 'testNuevaUnidadUdmNombreRepetido' 'id_unidad_medida' NO ES UN ENTERO");

		//se intenta repetir la UDM
		$udm2 = ProductosController::NuevaUnidadUdm(
			$abreviatura				= $abreviatura_Udm,
			$descripcion				= $descripcion_Udm,
			$factor_conversion			= 1,
			$id_categoria_unidad_medida	= $cat['id_categoria_unidad_medida'],
			$tipo_unidad_medida			= "Referencia UdM para esta categoria",
			$activa						= null
		);
	}

	public function testEditarUnidadUdm() {
		//se crea un nueva udm y categoria
		$abreviatura_Udm			= self::RandomString(5,  true, FALSE, FALSE);
		$abreviatura_Udm_editada	= self::RandomString(5,  true, FALSE, FALSE);
		$descripcion_Udm			= self::RandomString(15, true, FALSE, FALSE);
		$descripcion_catUdm			= self::RandomString(15, true, FALSE, FALSE);

		$cat = ProductosController::NuevaCategoriaUdm($descripcion_catUdm);

		$udm = ProductosController::NuevaUnidadUdm(
			$abreviatura				= $abreviatura_Udm,
			$descripcion				= $descripcion_Udm,
			$factor_conversion			= 1,
			$id_categoria_unidad_medida	= $cat['id_categoria_unidad_medida'],
			$tipo_unidad_medida			= "Referencia UdM para esta categoria"
		);

		$this->assertInternalType("int", $udm["id_unidad_medida"], "---- 'testEditarUnidadUdm' 'id_unidad_medida' NO ES UN ENTERO");

		$udmObj = UnidadMedidaDAO::getByPK($udm['id_unidad_medida']);

		//se edita la Udm recien ingresada
		ProductosController::EditarUnidadUdm(
			$id_unidad_medida			= $udmObj->getIdUnidadMedida(),
			$id_categoria_unidad_medida	= $udmObj->getIdCategoriaUnidadMedida(),
			$abreviacion				= $abreviatura_Udm_editada,
			$descripcion				= "descripcion",
			$factor_conversion			= $udmObj->getFactorConversion(),
			$tipo_unidad_medida			= $udmObj->getTipoUnidadMedida()
		);

		//se redefine el obj para comparar valores
		$udmObj2 = UnidadMedidaDAO::getByPK($udmObj->getIdUnidadMedida());

		$this->assertEquals($udmObj2->getAbreviacion(), $abreviatura_Udm_editada, "NO SE EDITÓ LA CategoriaUdm");
	}

		/*
		public function testBuscarUnidadUdmPorQuery(){
			//se genera una categoria y udm para despues buscarla por su nombre
			$abreviatura_Udm = self::RandomString(5,true,FALSE,FALSE);
			$descripcion_Udm = self::RandomString(15,true,FALSE,FALSE);
			$descripcion_catUdm = self::RandomString(15,true,FALSE,FALSE);

			$cat = ProductosController::NuevaCategoriaUdm($descripcion = $descripcion_catUdm, $activo = null);

			$udm = ProductosController::NuevaUnidadUdm(
														$abreviatura = $abreviatura_Udm,
														$descripcion = $descripcion_Udm,
														$factor_conversion = 1,
														$id_categoria_unidad_medida = $cat['id_categoria_unidad_medida'],
														$tipo_unidad_medida = "Referencia UdM para esta categoria",
														$activa = null
													);

			$res = ProductosController::BuscarUnidadUdm(
														$limit =  50 ,
														$page = null,
														$query = $abreviatura_Udm,
														$start =  0
													);

			$this->assertInternalType("int" , $res["numero_de_resultados"],"---- 'testBuscarUnidadUdmPorQuery' 'numero_de_resultados' NO ES UN ENTERO");
			$this->assertGreaterThanOrEqual(1, $res['numero_de_resultados'],"---- 'testBuscarUnidadUdmPorQuery' SE DEBIÓ DE ENCONTRAR ALMENOS 1 RESULTADO CON abreviacion = ".$abreviatura_Udm);
		}

	*/

}



