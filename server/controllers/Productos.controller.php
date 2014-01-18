<?php
require_once("interfaces/Productos.interface.php");
/**
 *
 *
 *
 **/

class ProductosController extends ValidacionesController implements IProductos {

	/**
	 *
	 *Crea una nueva categoria de producto, la categoria de un producto se relaciona con los meses de garantia del mismo, las unidades en las que se almacena entre, si se es suceptible a devoluciones, entre otros.
	 *
	 * @param nombre string Nombre de la categoria
	 * @param activa bool Estado de la nueva categoria.
	 * @param descripcion string Descripcion larga de la categoria
	 * @param id_categoria_padre int Id de la categora padre, en caso de que tuviera un padre
	 * @return id_categoria int Id atogenerado por la insercion de la categoria
	 **/
	static function NuevaCategoria($nombre, $activa=true , $descripcion=null, $id_categoria_padre=null) {
		$categoria = new ClasificacionProducto(array(
			'nombre' => $nombre,
			'activa' => $activa,
			'descripcion' => $descripcion,
			'id_categoria_padre' => $id_categoria_padre
		));

		try {
			ClasificacionProductoDAO::save($categoria);
		} catch (Exception $e) {
			throw new BusinessLogicException("Error al crear categoria, verifique sus datos.");
		}

		return array("id_categoria" => ((int) $categoria->getIdClasificacionProducto()));
	}

	/**
	 *
	 *Este metodo cambia la informacion de una categoria de producto
	 *
	 * @param id_clasificacion_producto int Id de la categoria del producto
	 * @param activa bool Estado de la categoria.
	 * @param descripcion string Descripcion larga de la categoria
	 * @param id_categoria_padre int Id de la categora padre en caso de tenerla
	 * @param nombre string Nombre de la categoria del producto
	 **/
	public static function EditarCategoria($id_clasificacion_producto, $activa=null, $descripcion=null, $id_categoria_padre=null, $nombre=null) {
		$categoria = ClasificacionProductoDAO::getByPK($id_clasificacion_producto);

		if (!is_null($activa)) {
			$categoria->setActiva($activa);
		}
		if (!is_null($descripcion)) {
			$categoria->setDescripcion($descripcion);
		}
		if (!is_null($nombre)) {
			$categoria->setNombre($nombre);
		}

		if (!is_null($id_categoria_padre)) {
			echo "......".$id_categoria_padre;
			$categoria->setIdCategoriaPadre($id_categoria_padre);

			if (ClasificacionProductoDAO::ChecarRecursion($categoria->getIdClasificacionProducto(), $categoria->getIdCategoriaPadre())) {
				try {
					ClasificacionProductoDAO::save($categoria);
				} catch (Exception $e) {
					throw new Exception("Error al modificar categoria, verifique sus datos.", 901);
				}
			} else {
				throw new Exception("Una categoria no puede ser hija de otra categoria descendiente, verifique sus datos.", 901);
			}
		}
	}

	/**
	 *
	 *Busca las categorias de los productos
	 *
	 * @param activa bool Se buscan categorias por el estado de estas.
	 * @param query string Buscar categoria por nombre y/o descripcion.
	 * @return resultados json json con los resultados de la busqueda
	 **/
	static function BuscarCategoria($activa=true, $query=null) {
		$categoria = new ClasificacionProducto();

		if (!is_null($activa)) {
			$categoria->setActiva($activa);
		}
		if (!is_null($query)) {
			$categoria->setNombre($query);
			$categoria->setDescripcion($query);
		}

		$categorias = ClasificacionProductoDAO::search($categoria);

		foreach ($categorias as $key => $categoria) {
			$id_categoria = $categoria->getIdClasificacionProducto();
			$nombre_completo = ClasificacionProductoDAO::NombreCompleto($id_categoria);
			$categorias[$key]->nombre_completo = $nombre_completo;
		}

		return array('categorias' => $categorias);
	}

	/**
	 *
	 *Obtiene una categoria y sus propiedades.
	 *
	 * @param id_categoria int El ID de la categoria a obtener.
	 * @return categoria json El objeto categoria obtenido.
	 **/
	static function DetallesCategoria($id_categoria) {
		$categoria = ClasificacionProductoDAO::getByPK($id_categoria);
		$alert = '';

		if (!is_null($categoria)) {
			$categoria->nombre_completo = ClasificacionProductoDAO::NombreCompleto($categoria->getIdClasificacionProducto());
		}

		return array('categoria' => $categoria);
	}

	/*
	 * Valida los parametros de la tabla producto. Regresa un string con el error
	 * cuando se ha encontrado alguno, regresa true en caso contrario
	 */
	private static function validarParametrosProducto($id_producto = null, $compra_en_mostrador = null, $metodo_costeo = null, $activo = null, $codigo_producto = null, $nombre_producto = null, $garantia = null, $costo_estandar = null, $id_unidad_compra = null, $control_de_existencia = null, $descripcion = null, $foto_del_producto = null, $costo_extra_almacen = null, $codigo_de_barras = null, $peso_producto = null, $id_unidad = null, $precio = null)
	{
		//valida que el producto exista y que este activo
		if (!is_null($id_producto)) {
			$producto = ProductoDAO::getByPK($id_producto);
			if (is_null($producto)) {
				return "El producto con id " . $id_producto . " no existe";
			} //is_null($producto)
			if (!$producto->getActivo()) {
				return "El producto esta desactivado";
			} //!$producto->getActivo()
		} //!is_null($id_producto)

		//valida el boleano compra en mostrador
		if (!is_null($compra_en_mostrador)) {
			$e = self::validarNumero($compra_en_mostrador, 1, "compra en mostrador");
			if (is_string($e))
				return $e;
		} //!is_null($compra_en_mostrador)

		//valida que el metodo de costeo sea valido
		if (!is_null($metodo_costeo)) {
			if ($metodo_costeo != "precio" && $metodo_costeo != "costo") {
				Logger::error("Metodo de costeo `$metodo_costeo` invalido");
				throw new InvalidDataException("El metodo de costeo (" . $metodo_costeo . ") es invalido");
				//return "El metodo de costeo (" . $metodo_costeo . ") es invalido";
			} //$metodo_costeo != "precio" && $metodo_costeo != "costo"

		} //!is_null($metodo_costeo)

		//valida el boleano activo
		if (!is_null($activo)) {
			$e = self::validarNumero($activo, 1, "activo");
			if (is_string($e))
				return $e;
		} //!is_null($activo)

		//valida que el codigo de producto este en rango y que no se repita
		if (!is_null($codigo_producto)) {
			if (FALSE === self::validarLongitudDeCadena($codigo_producto, 2, 32)) {
				return "El codigo de producto $codigo_producto debe ser entre 2 y 30";

			} //FALSE === self::validarLongitudDeCadena($codigo_producto, 2, 32)


			if (!is_null($id_producto)) {
				$productos = array_diff(ProductoDAO::search(new Producto(array(
					"codigo_producto" => trim($codigo_producto)
				))), array(
					$producto
				));
			} //!is_null($id_producto)
			else {
				$productos = ProductoDAO::search(new Producto(array(
					"codigo_producto" => trim($codigo_producto)
				)));
			}
			foreach ($productos as $p) {
				if ($p->getActivo()){
						throw new BusinessLogicException("El codigo de producto (" . $codigo_producto . ") ya esta en uso por el producto " . $p->getIdProducto());
				}

			} //$productos as $p
		} //!is_null($codigo_producto)

		//valida que el nombre del producto este en rango y que no se repita
		if (!is_null($nombre_producto)) {
			if (FALSE === self::validarLongitudDeCadena($nombre_producto, 2, 150)) {
				return "El nombre de producto es muy corto";
			} //FALSE === self::validarLongitudDeCadena($nombre_producto, 2, 150)

			if (!is_null($id_producto)) {
				$productos = array_diff(ProductoDAO::search(new Producto(array(
					"nombre_producto" => trim($nombre_producto)
				))), array(
					$producto
				));
			} //!is_null($id_producto)
			else {
				$productos = ProductoDAO::search(new Producto(array(
					"nombre_producto" => trim($nombre_producto)
				)));
			}
			foreach ($productos as $p) {
				if ($p->getActivo())
					return "El nombre (" . $nombre_producto . ") ya esta en uso por el producto " . $p->getIdProducto();
			} //$productos as $p
		} //!is_null($nombre_producto)

		//valida que la garantia este en rango
		if (!is_null($garantia)) {
			$e = self::validarNumero($garantia, PHP_INT_MAX, "garantia");
			if (is_string($e))
				return $e;
		} //!is_null($garantia)

		//valida que el costo estandar este en rango
		if (!is_null($costo_estandar)) {
			$e = self::validarNumero($costo_estandar, 1.8e200, "costo estandar");
			if (is_string($e))
				return $e;
		} //!is_null($costo_estandar)

		//valida que la unidad_compra exista y que este activa
		if (!is_null($id_unidad_compra)) {
			$e = self::validarParametrosUnidad($id_unidad_compra);
			if (is_string($e))
				return $e;
		} //!is_null($id_unidad_compra)

		//valida que el control de existencia este en rango
		if (!is_null($control_de_existencia)) {
			$e = self::validarNumero($control_de_existencia, 1.8e200, "control de existencia");
			if (is_string($e))
				return $e;
		} //!is_null($control_de_existencia)

		//valida que la foto del producto este en rango
		if (!is_null($foto_del_producto)) {
			$e = self::validarString($foto_del_producto, 100, "foto del producto");
			if (is_string($e))
				return $e;
		} //!is_null($foto_del_producto)

		//valida que el costo extra de almacen este en rango
		if (!is_null($costo_extra_almacen)) {
			$e = self::validarNumero($costo_extra_almacen, 1.8e200, "costo extra de almacen");
			if (is_string($e))
				return $e;
		} //!is_null($costo_extra_almacen)

		//valida que el codigo de barras este en rango y que no se repita
		if (!is_null($codigo_de_barras)) {
			$e = self::validarString($codigo_de_barras, 30, "codigo de barras");
			if (is_string($e))
				return $e;
			if (!is_null($id_producto)) {
				$productos = array_diff(ProductoDAO::search(new Producto(array(
					"codigo_de_barras" => trim($codigo_de_barras)
				))), array(
					$producto
				));
			} //!is_null($id_producto)
			else {
				$productos = ProductoDAO::search(new Producto(array(
					"codigo_de_barras" => trim($codigo_de_barras)
				)));
			}
			foreach ($productos as $producto) {
				if ($producto->getActivo())
					return "El codigo de barras (" . $codigo_de_barras . ") ya esta en uso por el producto " . $producto->getIdProducto();
			} //$productos as $producto
		} //!is_null($codigo_de_barras)

		//valida que el peso del producto este en rango
		if (!is_null($peso_producto)) {
			$e = self::validarNumero($peso_producto, 1.8e200, "peso de producto");
			if (is_string($e))
				return $e;
		} //!is_null($peso_producto)

		//valida que la unidad exista y que este activa
		if (!is_null($id_unidad)) {
			$e = self::validarParametrosUnidad($id_unidad);
			if (is_string($e))
				return $e;
		} //!is_null($id_unidad)

		//valida que el precio este en rango
		if (!is_null($precio)) {
			$e = self::validarNumero($precio, 1.8e200, "precio");
			if (is_string($e))
				return $e;
		} //!is_null($precio)

		//valida que la descripcion este en rango
		if (!is_null($descripcion)) {
			$e = self::validarString($descripcion, 255, "descripcion");
			if (is_string($e))
				return $e;
		} //!is_null($descripcion)

		//No se encontro error, regresa verdadero
		return true;
	}





	/*
	 * Valida los parametros de la tabla producto_empresa. Regres aun string con el error si encuentra
	 * alguno, regresa verdadero en caso contrario.
	 */

	private static function validarParametrosProductoEmpresa($id_empresa = null)
	{
		//valida que la empresa exista y este activa
		if (!is_null($id_empresa)) {
			$empresa = EmpresaDAO::getByPK($id_empresa);
			if (is_null($empresa))
				return "La empresa con id " . $id_empresa . " no existe";

			if (!$empresa->getActivo())
				return "La empresa esta desactivada";
		} //!is_null($id_empresa)

		//No se encontro error, regresa true
		return true;
	}





	/*
	 * Valida los parametros de la tabla clasificacion_produco. Regres aun string con el error
	 * en caso de encontrar alguno. Regresa verdadero en caso contrario.
	 */
	private static function validarParametrosClasificacionProducto($id_clasificacion_producto = null, $nombre = null, $descripcion = null, $garantia = null, $activa = null)
	{
		//valida que la clasificacion de producto exista y este activa
		if (!is_null($id_clasificacion_producto)) {
			$clasificacion_producto = ClasificacionProductoDAO::getByPK($id_clasificacion_producto);
			if (is_null($clasificacion_producto))
				return "La clasificacion de producto con id " . $id_clasificacion_producto . " no existe";

			if (!$clasificacion_producto->getActiva())
				return "La clasificacion de producto con id " . $id_clasificacion_producto . " esta desactivada";
		} //!is_null($id_clasificacion_producto)

		//valida que el nombre este en rango y que no se repita
		if (!is_null($nombre)) {
			$e = self::validarString($nombre, 64, "nombre");
			if (is_string($e))
				return $e;

			if (!is_null($id_clasificacion_producto)) {
				$clasificaciones_producto = array_diff(ClasificacionProductoDAO::search(new ClasificacionProducto(array(
					"nombre" => trim($nombre)
				))), array(
					ClasificacionProductoDAO::getByPK($id_clasificacion_producto)
				));
			} //!is_null($id_clasificacion_producto)
			else {
				$clasificaciones_producto = ClasificacionProductoDAO::search(new ClasificacionProducto(array(
					"nombre" => trim($nombre)
				)));
			}
			foreach ($clasificaciones_producto as $c_p) {
				if ($c_p->getActiva())
					return "El nombre (" . $nombre . ") ya esta siendo usado por la clasificacion " . $c_p->getIdClasificacionProducto();
			} //$clasificaciones_producto as $c_p
		} //!is_null($nombre)

		//valida que la descripcion este en rango
		if (!is_null($descripcion)) {
			$e = self::validarString($descripcion, 255, "descripcion");
			if (is_string($e))
				return $e;
		} //!is_null($descripcion)

		//valida que la garantia este en rango
		if (!is_null($garantia)) {
			$e = self::validarNumero($garantia, PHP_INT_MAX, "Garantia");
			if (is_string($e))
				return $e;
		} //!is_null($garantia)

		//valida el boleano activa
		if (!is_null($activa)) {
			$e = self::validarNumero($activa, 1, "activa");
			if (is_string($e))
				return $e;
		} //!is_null($activa)

		//No se encontro error, regresa true
		return true;
	}





















	/**
	 *
	 *Lista las unidades. Se puede filtrar por activas o inactivas y ordenar por sus atributos
	 *
	 * @param activo bool Si este valor no es obtenido, se listaran tanto activas como inactivas, si es true, se listaran solo las activas, si es false se listaran solo las inactivas
	 * @param ordenar json Valor que determina el orden de la lista
	 * @return unidades_convertibles json Lista de unidades convertibles
	 **/
	public static function ListaUnidad($activo = null, $ordenar = null)
	{
		Logger::log("Listando unidades");

		//valida los parametros recibidos
		$validar = self::validarParametrosUnidad(null, null, null, null, $activo);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)
		if (!is_null($ordenar)) {
			if ($ordenar != "id_unidad" && $ordenar != "nombre" && $ordenar != "descripcion" && $ordenar != "es_entero" && $ordenar != "activa") {
				Logger::error("La variable ordenar (" . $ordenar . ") es invalida");
				throw new Exception("La variable ordenar (" . $ordenar . ") es invalida");
			} //$ordenar != "id_unidad" && $ordenar != "nombre" && $ordenar != "descripcion" && $ordenar != "es_entero" && $ordenar != "activa"
		} //!is_null($ordenar)

		$unidades = null;
		if (is_null($activo)) {
			Logger::log("No se recibieron parametros, se listan todas las unidades");
			$unidades = UnidadDAO::getAll(null, null, $ordenar);
		} //is_null($activo)
		else {
			Logger::log("Se recibieron parametros, se listan las unidades en rango");
			$unidades = UnidadDAO::search(new Unidad(array(
				"activa" => $activo
			)), $ordenar);
		}
		Logger::log("Lista de unidades obtenida con " . count($unidades) . " elementos");
		return $unidades;
	}

	/**
	 *
	 *Crea un registro de la equivalencia entre una unidad y otra. Ejemplo: 1 kg = 2.204 lb
	 *
	 * @param id_unidad int Id de la unidad. Esta unidad es tomada con coeficiente 1 en la ecuacion de, en el ejemplo es el kilogramo equivalencia
	 * @param id_unidades int Id de la unidad equivalente, en el ejemplo es la libra
	 * @param equivalencia float Valor del coeficiente de la segunda unidad, es decir, las veces que cabe la segunda unidad en la primera
	 **/
	public static function Nueva_equivalenciaUnidad($equivalencia, $id_unidad, $id_unidades)
	{
		Logger::log("Crenado nueva equivalencia de unidades");

		//valida los parametros recibidos
		$validar = self::validarParametrosUnidad($id_unidad);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)
		$validar = self::validarParametrosUnidad($id_unidades);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)
		$valdiar = self::validarNumero($equivalencia, 1.8e200, "equivalencia");
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)

		if ($id_unidad == $id_unidades) {
			Logger::error("No se puede crear una equivalencia para la misma unidad");
			throw new Exception("No se puede crear una equivalencia para la misma unidad");
		} //$id_unidad == $id_unidades
		$unidad_equivalencia = new UnidadEquivalencia(array(
			"id_unidad" => $id_unidad,
			"equivalencia" => $equivalencia,
			"id_unidades" => $id_unidades
		));
		DAO::transBegin();
		try {
			UnidadEquivalenciaDAO::save($unidad_equivalencia);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo crear la equivalencia: " . $e);
			throw new Exception("No se pudo crear la equivalencia");
		}
		DAO::transEnd();
		Logger::log("La equivalencia fue creada exitosamente");
	}

	/**
	 *
	 *Edita la equivalencia entre dos unidades.
	 1 kg = 2.204 lb
	 *
	 * @param id_unidades int Id de la segunda unidad, en el ejemplo son libras
	 * @param equivalencia float La nueva equivalencia que se pondra entre los dos valores, en el ejemplo es 2.204
	 * @param id_unidad int Id de la unidad, en el ejemplo son kilogramos
	 **/
	/*
	public static function Editar_equivalenciaUnidad
	(
	$equivalencia,
	$id_unidad,
	$id_unidades
	)
	{
	Logger::log("Editando la equivalencia entre la unidad ".$id_unidad." y las unidades ".$id_unidades);

	//valida los parametros
	$unidad_equivalencia = UnidadEquivalenciaDAO::getByPK($id_unidad, $id_unidades);
	if(is_null($unidad_equivalencia))
	{
	Logger::error("La equivalencia entre la unidad ".$id_unidad." y las unidades ".$id_unidades." no existe");
	throw new Exception("La equivalencia entre la unidad ".$id_unidad." y las unidades ".$id_unidades." no existe");
	}
	$validar = self::validarNumero($equivalencia, 1.8e200, "equivalencia");
	if(is_string($validar))
	{
	Logger::error($validar);
	throw new Exception($validar);
	}

	$unidad_equivalencia->setEquivalencia($equivalencia);
	DAO::transBegin();
	try
	{
	UnidadEquivalenciaDAO::save($unidad_equivalencia);
	}
	catch(Exception $e)
	{
	DAO::transRollback();
	Logger::error("No se pudo editar la equivalencia: ".$e);
	throw new Exception("No se pudo editar la equivalencia");
	}
	DAO::transEnd();

	Logger::log("Equivalencia editada exitosamente");
	}
	*/


	/**
	 *
	 *Se puede ordenar por los atributos de producto.
	 *
	 * @param activo bool Si es true, mostrar solo los productos que estn activos, si es false mostrar solo los productos que no lo sean.
	 * @param id_lote int Id del lote del cual se vern sus productos.
	 * @param id_almacen int Id del almacen del cual se vern sus productos.
	 * @param id_empresa int Id de la empresa de la cual se vern los productos.
	 * @param id_sucursal int Id de la sucursal de la cual se vern los productos.
	 * @return productos json Objeto que contendr� el arreglo de productos en inventario.
	 **/
	public static function Lista(
		$activo = null,
		$compra_en_mostrador = null,
		$id_almacen = null,
		$id_empresa = null,
		$metodo_costeo = null
	)
	{
		Logger::log("Listando los productos");
		$productos  = array();
		//Se verifica si se reciben parametros o no para usar el metodo getAll o search
		$parametros = false;
		if (!is_null($activo) || !is_null($compra_en_mostrador) || !is_null($metodo_costeo)) {
			Logger::log("Se recibieron parametros, se listan los productos en rango");

			//Si se recibe el parametro id_empresa, se traen los productos de esa empresa y se intersectan
			//con los que cumplen los demas parametros. Si no se recibe, se busca el parametro id_almacen
			//
			//Si se recibe el parametro id_almacen, se traen los productos de ese almacen y se intersectan
			//con los que cumplen los demas parametros. Si no se recibe, la interseccion se hara con todos los productos
			$productos1 = array();
			$productos2 = array();
			if (!is_null($id_empresa)) {
				$productos_empresa = ProductoEmpresaDAO::search(new ProductoEmpresa(array(
					"id_empresa" => $id_empresa
				)));
				foreach ($productos_empresa as $p_e) {
					array_push($productos1, ProductoDAO::getByPK($p_e->getIdProducto()));
				} //$productos_empresa as $p_e
			} //!is_null($id_empresa)
			else if (!is_null($id_almacen)) {
				$productos_almacen = ProductoAlmacenDAO::search(new ProductoAlmacen(array(
					"id_almacen" => $id_almacen
				)));
				foreach ($productos_almacen as $p_a) {
					array_push($productos1, ProductoDAO::getByPK($p_a->getIdProducto()));
				} //$productos_almacen as $p_a
			} //!is_null($id_almacen)
			else {
				$productos1 = ProductoDAO::getAll();
			}
			$producto_criterio = new Producto(array(
				"activo" => $activo,
				"compra_en_mostrador" => $compra_en_mostrador,
				"metodo_costeo" => $metodo_costeo
			));
			$productos2        = ProductoDAO::search($producto_criterio);
			$productos         = array_intersect($productos1, $productos2);
		} //!is_null($activo) || !is_null($compra_en_mostrador) || !is_null($metodo_costeo)
		else {
			Logger::log("No se recibieron parametros, se listan todos los productos");
			if (!is_null($id_empresa)) {
				$productos_empresa = ProductoEmpresaDAO::search(new ProductoEmpresa(array(
					"id_empresa" => $id_empresa
				)));
				foreach ($productos_empresa as $p_e) {
					array_push($productos, ProductoDAO::getByPK($p_e->getIdProducto()));
				} //$productos_empresa as $p_e
			} //!is_null($id_empresa)
			else if (!is_null($id_almacen)) {
				$productos_almacen = ProductoAlmacenDAO::search(new ProductoAlmacen(array(
					"id_almacen" => $id_almacen
				)));
				foreach ($productos_almacen as $p_a) {
					array_push($productos, ProductoDAO::getByPK($p_a->getIdProducto()));
				} //$productos_almacen as $p_a
			} //!is_null($id_almacen)
			else {
				$productos = ProductoDAO::getAll();
			}
		}
		Logger::log("Lista obtenida exitosamente con " . count($productos) . " elementos");
		return $productos;
	}

	/**
	 *
	 *Crear un nuevo producto,

	 NOTA: Se crea un producto tipo = 1 que es para productos
	 *
	 * @param activo bool Si queremos que este activo o no este producto despues de crearlo.
	 * @param codigo_producto string El codigo de control de la empresa para este producto, no se puede repetir
	 * @param id_empresas json Objeto que contendra el arreglo de ids de las empresas a la que pertenece este producto
	 * @param nombre_producto string Nombre del producto
	 * @param metodo_costeo string  Mtodo de costeo del producto: 1 = Costo Promedio en Base a Entradas.2 = Costo Promedio en Base a Entradas Almacn.3 = ltimo costo.4 = UEPS.5 = PEPS.6 = Costo especfico.7 = Costo Estndar
	 * @param costo_estandar float Valor del costo estndar del producto.
	 * @param compra_en_mostrador bool Verdadero si este producto se puede comprar en mostrador, para aquello de compra-venta. Para poder hacer esto, el sistema debe poder hacer compras en mostrador
	 * @param garant�a int Si este producto cuenta con un nmero de meses de garanta  que no aplica a los productos de su categora
	 * @param costo_extra_almacen float Si este producto produce un costo extra por tenerlo en almacen
	 * @param margen_de_utilidad float Un porcentage de 0 a 100 si queremos que este producto marque utilidad en especifico
	 * @param control_de_existencia int 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote
	 * @param peso_producto float el peso de este producto en KG
	 * @param descripcion_producto string Descripcion larga del producto
	 * @param impuestos json array de ids de impuestos que tiene este producto
	 * @param clasificaciones json Uno o varios id_clasificacion de este producto, esta clasificacion esta dada por el usuarioArray
	 * @param id_unidad_convertible int Si este producto se relacionara con una unidad convertible ( kilos, litros, libras, etc.)
	 * @param codigo_de_barras string El Codigo de barras para este producto
	 * @param id_unidad_no_convertible int Si este producto se relacionara con una unidad no convertible ( lotes, cajas, costales, etc.)
	 * @param foto_del_producto string url a una foto de este producto
	 * @param descuento float Descuento que se aplicara a este producot
	 * @return id_producto int Id generado por la inserci�n del nuevo producto
	 **/
	public static function Nuevo(
		$activo,
		$codigo_producto,
		$compra_en_mostrador,
		$id_unidad_compra,
		$metodo_costeo,
		$nombre_producto,
		$visible_en_vc,
		$codigo_de_barras = null,
		$control_de_existencia = null,
		$costo_estandar = null,
		$descripcion_producto = null,
		$foto_del_producto = null,
		$garantia = null,
		$id_categoria = null,
		$id_empresas = null,
		$id_unidad = null,
		$impuestos = null,
		$precio_de_venta = null
	)
	{
		Logger::log("======= Creando nuevo producto `$codigo_producto` ==== ;");

		//valida los parametros recibidos
		/*$validar = self::validarParametrosProducto(null, $compra_en_mostrador, $metodo_costeo, $activo, $codigo_producto, $nombre_producto, $garantia, $costo_estandar, $id_unidad_compra, $control_de_existencia, $descripcion_producto, $foto_del_producto, $costo_extra_almacen = null, $codigo_de_barras, $peso_producto = null, $id_unidad, $precio_de_venta);



		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)*/

		//buscar otro producto con el mismo codigo de producto
		$search = ProductoDAO::search(new Producto( array( "codigo_producto" => $codigo_producto ) ));


		if(sizeof($search) > 0){
			throw new BusinessLogicException("Ya hay un producto con ese codigo de producto");
		}

		//Se verifica que si se recibio precio como metodo de costeo, se reciba un precio,
		//o si se recibe margen, que se reciba un margen de utilidad.

		if ($metodo_costeo == "precio" && is_null($precio_de_venta)) {
			Logger::error("Se intenta registrar un producto con metodo de costeo precio sin especificar un precio");
			throw new InvalidDataException("Se intenta registrar un producto con metodo de costeo precio sin especificar un precio", 901);
		} //$metodo_costeo == "precio" && is_null($precio_de_venta)

		else if ($metodo_costeo == "costo" && is_null($costo_estandar)) {
			Logger::error("Se intenta registrar un producto con metodo de costeo costo sin especificar un costo");
			throw new Exception("Se intenta registrar un producto con metodo de costeo costo sin especificar un costo", 901);
		} //$metodo_costeo == "costo" && is_null($costo_estandar)

		$costo_estandar = ($metodo_costeo == "costo")? $costo_estandar : null;//sólo en caso de que se haya seleccionado metodo_costeo == 'costo' tomar en cuenta este valor ver API

		$producto = new Producto(array(
			"compra_en_mostrador" => $compra_en_mostrador,
			"metodo_costeo" => $metodo_costeo,
			"activo" => $activo,
			"codigo_producto" => trim($codigo_producto),
			"nombre_producto" => trim($nombre_producto),
			"visible_en_vc" => $visible_en_vc,
			"garantia" => $garantia,
			"costo_estandar" => $costo_estandar,
			"control_de_existencia" => $control_de_existencia,
			"descripcion" => $descripcion_producto,
			"foto_del_producto" => $foto_del_producto,
			//"costo_extra_almacen" => $costo_extra_almacen,
			"codigo_de_barras" => trim($codigo_de_barras),
			//"peso_producto" => $peso_producto,
			"id_unidad" => $id_unidad,
			"precio" => $precio_de_venta,
			"id_unidad_compra" => $id_unidad_compra
		));

		DAO::transBegin();

		try {
			//Se guarda el producto creado y se asignan las empresas, los impuestos y las clasificaciones recibidas
			ProductoDAO::save($producto);

			if (!is_null($id_empresas)) {

				if (!is_array($id_empresas)) {
					$id_empresas = object_to_array($id_empresas);
				} //!is_array($id_empresas)

				if (!is_array($id_empresas)) {
					throw new Exception("Las empresas fueron enviadas incorrectamente", 901);
				} //!is_array($id_empresas)

				$producto_empresa = new ProductoEmpresa(array(
					"id_producto" => $producto->getIdProducto()
				));

				foreach ($id_empresas as $id_empresa) {
					$validar = self::validarParametrosProductoEmpresa($id_empresa);
					if (is_string($validar))
						throw new BusinessLogicException($validar, 901);

					$producto_empresa->setIdEmpresa($id_empresa);
					Logger::log("vinculando producto con empresa ".$id_empresa);
					ProductoEmpresaDAO::save($producto_empresa);
				} //$id_empresas as $id_empresa
			} //!is_null($id_empresas)


			if (!is_null($impuestos)) {
				$impuestos = object_to_array($impuestos);

				if (!is_array($impuestos)) {
					throw new BusinessLogicException("Los impuestos fueron recibidos incorrectamente", 901);
				} //!is_array($impuestos)

				$impuesto_producto = new ImpuestoProducto(array(
					"id_producto" => $producto->getIdProducto()
				));
				foreach ($impuestos as $impuesto) {
					if (is_null(ImpuestoDAO::getByPK($impuesto)))
						throw new BusinessLogicException("El impuesto con id " . $impuesto . " no existe", 901);
					$impuesto_producto->setIdImpuesto($impuesto);
					ImpuestoProductoDAO::save($impuesto_producto);
				} //$impuestos as $impuesto
			} //!is_null($impuestos)

			/* Fin if de impuestos */
			/*
			if (!is_null($clasificaciones)) {
				$clasificaciones = object_to_array($clasificaciones);

				if (!is_array($clasificaciones)) {
					throw new Exception("Las clasificaciones del producto fueron recibidas incorrectamente", 901);
				} //!is_array($clasificaciones)

				$producto_clasificacion = new ProductoClasificacion(array(
					"id_producto" => $producto->getIdProducto()
				));
				foreach ($clasificaciones as $clasificacion) {
					$c = ClasificacionProductoDAO::getByPK($clasificacion);
					if (is_null($c))
						throw new Exception("La clasificacion de producto con id " . $clasificacion . " no existe", 901);

					if (!$c->getActiva())
						throw new Exception("La clasificaicon de producto con id " . $clasificacion . " no esta activa", 901);

					$producto_clasificacion->setIdClasificacionProducto($clasificacion);
					ProductoClasificacionDAO::save($producto_clasificacion);
				} //$clasificaciones as $clasificacion
			} //!is_null($clasificaciones)
			*/
			/* Fin if de clasificaciones */
		}
		catch (Exception $e) {
			DAO::transRollback();

			Logger::error("No se pudo guardar el nuevo producto: " . $e);

			if ($e->getCode() == 901)
				throw new BusinessLogicException("No se pudo guardar el nuevo producto: " . $e->getMessage(), 901);

			throw new BusinessLogicException("No se pudo guardar el nuevo producto " . $e->getMessage(), 901);
		}

		DAO::transEnd();

		Logger::log("Producto creado exitosamente, id=".$producto->getIdProducto());

		return array( "id_producto" => (int)$producto->getIdProducto() );

	}

	/**
	 *
	 *Agregar productos en volumen mediante un archivo CSV.
	 *
	 * @param productos json Arreglo de objetos que contendr�n la informaci�n del nuevo producto
	 * @return id_productos json Arreglo de enteros que contendr� los ids de los productos insertados.
	 **/
	public static function VolumenEnNuevo($productos)
	{
		Logger::log("Insertando productos en volumen");

		if(!is_array($productos)){
			$productos = object_to_array($productos);
		}

		//var_dump($productos);

		if (!is_array($productos)) {
			Logger::error("Los productos recibidos son invalidossss");
			throw new Exception("Los productos recibidos son invalidos", 901);
		} //!is_array($productos)

		Logger::log("Se recibieron " . count($productos) . " productos, se procede a insertarlos");

		//Se llama muchas veces al metodo producto nuevo y se almacenan los ids generados
		$id_productos = array();
		DAO::transBegin();
		try {

			foreach ($productos as $producto) {
				if (! 	array_key_exists("codigo_producto", $producto)
					|| !array_key_exists("nombre_producto", $producto)
					//|| !array_key_exists("precio", $producto)
					|| !array_key_exists("costo_estandar", $producto)
					|| !array_key_exists("compra_en_mostrador", $producto)
					|| !array_key_exists("metodo_costeo", $producto)

				)
				{
					Logger::log( json_encode($producto) );

					throw new InvalidDataException("Los productos recibidos son invalidos", 901);
				} //!array_key_exists("codigo_producto", $producto) || !array_key_exists("id_empresas", $producto) || !array_key_exists("nombre_producto", $producto) || !array_key_exists("precio", $producto) || !array_key_exists("costo_estandar", $producto) || !array_key_exists("compra_en_mostrador", $producto)

				array_push($id_productos, self::Nuevo(
						1,
						$producto["codigo_producto"],
						$producto["compra_en_mostrador"],
						null, // id_unidad_compra
						$producto["metodo_costeo"],
						$producto["nombre_producto"],
						null, //codigo_barras
						null, //control de existencia
						$producto["costo_estandar"]
						));

			} //$productos as $producto
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudieron guardar los productos: " . $e);
			if ($e->getCode() == 901)
				throw new Exception("No se pudieron guardar los productos: " . $e->getMessage(), 901);
			throw new Exception("No se pudieron guardar los productos", 901);
		}
		DAO::transEnd();
		Logger::log("Productos insertados exitosamente....");
		return $id_productos;
	}

	/**
	 *
	 *Este metodo sirve para dar de baja un producto
	 *
	 * @param id_producto int Id del producto a desactivar
	 **/
	public static function Desactivar($id_producto)
	{
		Logger::log("Desactivando producto " . $id_producto);

		//valida que el producto exista y que no haya sido desactivado antes
		$validar = self::validarParametrosProducto($id_producto);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)
		//Si el producto forma parte de algun paquete activo no puede ser eliminado
		$productos_paquete = ProductoPaqueteDAO::search(new ProductoPaquete(array(
			"id_producto" => $id_producto
		)));
		foreach ($productos_paquete as $producto_paquete) {
			$paquete = PaqueteDAO::getByPK($producto_paquete->getIdProducto());
			if ($paquete->getActivo()) {
				Logger::error("No se puede borrar este producto pues el paquete " . $paquete->getIdPaquete() . " aun lo contiene");
				throw new Exception("No se puede borrar este producto pues el paquete " . $paquete->getIdPaquete() . " aun lo contiene");
			} //$paquete->getActivo()
		} //$productos_paquete as $producto_paquete

		//Si el producto aun esta en existencia en algun almacen, no puede ser eliminado
		$productos_almacen = LoteProductoDAO::search(new LoteProducto(array(
			"id_producto" => $id_producto
		)));
		foreach ($productos_almacen as $producto_almacen) {
			if ($producto_almacen->getCantidad() != 0) {
				Logger::error("El producto " . $id_producto . " no puede ser eliminado pues aun hay existencia en el almcen " . $producto_almacen->getIdAlmacen());
				throw new Exception("El producto " . $id_producto . " no puede ser eliminado pues aun hay existencia en el almcen " . $producto_almacen->getIdAlmacen());
			} //$producto_almacen->getCantidad() != 0
		} //$productos_almacen as $producto_almacen

		$producto = ProductoDAO::getByPK($id_producto);
		$producto->setActivo(0);

		//Se obtienen los registros de las tablas producto_empresa, producto_clasificacion e impuesto_producto
		//pues seran eliminados
		$productos_empresa       = ProductoEmpresaDAO::search(new ProductoEmpresa(array(
			"id_producto" => $id_producto
		)));
		$productos_clasificacion = ProductoClasificacionDAO::search(new ProductoClasificacion(array(
			"id_producto" => $id_producto
		)));
		$impuestos_producto      = ImpuestoProductoDAO::search(new ImpuestoProducto(array(
			"id_producto" => $id_producto
		)));

		DAO::transBegin();
		try {
			ProductoDAO::save($producto);
			foreach ($productos_empresa as $producto_empresa) {
				ProductoEmpresaDAO::delete($producto_empresa);
			} //$productos_empresa as $producto_empresa
			foreach ($productos_clasificacion as $producto_clasificacion) {
				ProductoClasificacionDAO::delete($producto_clasificacion);
			} //$productos_clasificacion as $producto_clasificacion
			foreach ($impuestos_producto as $impuesto_producto) {
				ImpuestoProductoDAO::delete($impuesto_producto);
			} //$impuestos_producto as $impuesto_producto
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se ha podido descativar el producto " . $id_producto . " : " . $e);
			throw new Exception("No se ha podido descativar el producto " . $id_producto);
		}
		DAO::transEnd();
		LOgger::log("El producto ha sido eliminado exitosamente");
	}

	/**
	 *
	 *Edita la informaci?n de un producto
	 *
	 * @param id_producto int Id del producto a editar
	 * @param clasificaciones json Uno o varios id_clasificacion de este producto, esta clasificacion esta dada por el usuario
	 * @param codigo_de_barras string El Codigo de barras para este producto
	 * @param codigo_producto string Codigo del producto
	 * @param compra_en_mostrador bool Verdadero si este producto se puede comprar en mostrador, para aquello de compra-venta
	 * @param control_de_existencia int 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote
	 * @param costo_estandar float Valor del costo estndar del producto.
	 * @param costo_extra_almacen float Si este producto produce un costo extra por tenerlo en almacen
	 * @param descripcion_producto string Descripcion larga del producto
	 * @param empresas json arreglo de ids de empresas a las que pertenece este producto
	 * @param foto_del_producto string url a una foto de este producto
	 * @param garantia int Numero de meses de garantia con los que cuenta esta categoria de producto
	 * @param id_unidad int La unidad preferente de este producto
	 * @param id_unidad_compra int El id de la unidad de medida en la que se adquiere el producto al comprarlo
	 * @param impuestos json array de ids de impuestos que tiene este producto
	 * @param metodo_costeo string Puede ser "precio" o "costo" e indican si el precio final sera tomado a partir del costo del producto o del precio del mismo
	 * @param nombre_producto string Nombre del producto
	 * @param peso_producto float el peso de este producto en KG
	 * @param precio int El precio de este producto
	 * @param visible_en_vc bool Verdadero si este producto sera visible a los clientes.
	 **/
	static function Editar
	(
		$id_producto,
		$clasificaciones = null,
		$codigo_de_barras = null,
		$codigo_producto = null,
		$compra_en_mostrador = null,
		$control_de_existencia = null,
		$costo_estandar = null,
		$costo_extra_almacen = null,
		$descripcion_producto = null,
		$empresas = null,
		$foto_del_producto = null,
		$garantia = null,
		$id_unidad = null,
		$id_unidad_compra = null,
		$impuestos = null,
		$metodo_costeo = null,
		$nombre_producto = null,
		$peso_producto = null,
		$precio = null,
		$visible_en_vc = null
	)
	{
		Logger::log("== Editando producto " . $id_producto . " ==");



		//se validan los parametros recibidos
		$validar = self::validarParametrosProducto($id_producto, $compra_en_mostrador, $metodo_costeo, null, $codigo_producto, $nombre_producto, $garantia, $costo_estandar, $control_de_existencia, $descripcion_producto, $foto_del_producto, $costo_extra_almacen, $codigo_de_barras, $peso_producto, $id_unidad, $precio);

		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)

		$producto = ProductoDAO::getByPK($id_producto);

		//Los parametros que no sean nulos seran tomados como una actualizacion

		if (!is_null($compra_en_mostrador)) {
			$producto->setCompraEnMostrador($compra_en_mostrador);
		} //!is_null($compra_en_mostrador)

		if (!is_null($descripcion_producto)) {
			$producto->setDescripcion($descripcion_producto);
		} //!is_null($descripcion_producto)

		if (!is_null($metodo_costeo)) {
			$producto->setMetodoCosteo($metodo_costeo);
		} //!is_null($metodo_costeo)

		if (!is_null($codigo_producto)) {
			$producto->setCodigoProducto(trim($codigo_producto));
		} //!is_null($codigo_producto)

		if (!is_null($nombre_producto)) {
			$producto->setNombreProducto(trim($nombre_producto));
		} //!is_null($nombre_producto)

		if (!is_null($garantia)) {
			$producto->setGarantia($garantia);
		} //!is_null($garantia)

		if (!is_null($costo_estandar)) {
			$costo_estandar = ($metodo_costeo == "costo")? $costo_estandar : null;//sólo en caso de que se haya seleccionado metodo_costeo == 'costo' tomar en cuenta este valor ver API
			$producto->setCostoEstandar($costo_estandar);
		} //!is_null($costo_estandar)

		if (!is_null($control_de_existencia)) {
			$producto->setControlDeExistencia($control_de_existencia);
		} //!is_null($control_de_existencia)

		if (!is_null($foto_del_producto)) {
			$producto->setFotoDelProducto($foto_del_producto);
		} //!is_null($foto_del_producto)

		if (!is_null($costo_extra_almacen)) {
			$producto->setCostoExtraAlmacen($costo_extra_almacen);
		} //!is_null($costo_extra_almacen)

		if (!is_null($codigo_de_barras)) {
			$producto->setCodigoDeBarras(trim($codigo_de_barras));
		} //!is_null($codigo_de_barras)

		if (!is_null($peso_producto)) {
			$producto->setPesoProducto($peso_producto);
		} //!is_null($peso_producto)

		if (!is_null($id_unidad)) {
			$producto->setIdUnidad($id_unidad);
		} //!is_null($id_unidad)

		if (!is_null($id_unidad_compra)) {
			$producto->setIdUnidadCompra($id_unidad_compra);
		} //!is_null($id_unidad_compra)

		if (!is_null($precio)) {
			$producto->setPrecio($precio);
		} //!is_null($precio)

		if (!is_null($visible_en_vc)) {
			$producto->setVisibleEnVc($visible_en_vc);
		}

		if ($metodo_costeo == "precio" && is_null($producto->getPrecio())) {
			Logger::error("Se intenta registrar un producto con metodo de costeo precio sin especificar un precio");
			throw new Exception("Se intenta registrar un producto con metodo de costeo precio sin especificar un precio", 901);
		} //$metodo_costeo == "precio" && is_null($producto->getPrecio())

		else if ($metodo_costeo == "costo" && is_null($producto->getCostoEstandar())) {
			Logger::error("Se intenta registrar un producto con metodo de costeo costo sin especificar un costo estandar");
			throw new Exception("Se intenta registrar un producto con metodo de costeo costo sin especificar un costo estandar", 901);
		} //$metodo_costeo == "costo" && is_null($producto->getCostoEstandar())

		DAO::transBegin();
		try {
			ProductoDAO::save($producto);
			//Si se reciben empresas, clasificaciones y/o impuestos se modifican en sus respectivas tablas
			//
			//Primero se guardan o actualizan los registros pasados en la lista, despues se recorren los registros
			//actuales y si alguno no se encuentra en la lista se elimina.
			if (!is_null($empresas)) {
				$empresas = object_to_array($empresas);

				if (!is_array($empresas)) {
					throw new Exception("Las empresas fueron enviadas incorrectamente", 901);
				} //!is_array($empresas)

				$producto_empresa = new ProductoEmpresa(array(
					"id_producto" => $id_producto
				));
				foreach ($empresas as $empresa) {
					$validar = self::validarParametrosProductoEmpresa($empresa);
					if (is_string($validar))
						throw new Exception($validar, 901);

					$producto_empresa->setIdEmpresa($empresa);
					ProductoEmpresaDAO::save($producto_empresa);
				} //$empresas as $empresa
				$productos_empresa = ProductoEmpresaDAO::search(new ProductoEmpresa(array(
					"id_producto" => $id_producto
				)));
				foreach ($productos_empresa as $p_e) {
					$encontrado = false;
					foreach ($empresas as $empresa) {
						if ($empresa == $p_e->getIdEmpresa()) {
							$encontrado = true;
						} //$empresa == $p_e->getIdEmpresa()
					} //$empresas as $empresa
					if (!$encontrado)
						ProductoEmpresaDAO::delete($p_e);
				} //$productos_empresa as $p_e
			} //!is_null($empresas)

			/* Fin if de empresas */
			if (!is_null($clasificaciones)) {
				$clasificaciones = object_to_array($clasificaciones);

				if (!is_array($clasificaciones)) {
					throw new Exception("Las clasificaciones fueron recibidas incorrectamente", 901);
				} //!is_array($clasificaciones)

				$producto_clasificacion = new ProductoClasificacion(array(
					"id_producto" => $id_producto
				));
				foreach ($clasificaciones as $clasificacion) {
					$c = ClasificacionProductoDAO::getByPK($clasificacion);
					if (is_null($c))
						throw new Exception("La clasificacion de producto con id " . $clasificacion . " no existe", 901);

					if (!$c->getActiva())
						throw new Exception("La clasificaicon de producto con id " . $clasificacion . " no esta activa", 901);

					$producto_clasificacion->setIdClasificacionProducto($clasificacion);
					ProductoClasificacionDAO::save($producto_clasificacion);
				} //$clasificaciones as $clasificacion
				$productos_clasificacion = ProductoClasificacionDAO::search(new ProductoClasificacion(array(
					"id_producto" => $id_producto
				)));
				foreach ($productos_clasificacion as $p_c) {
					$encontrado = false;
					foreach ($clasificaciones as $clasificacion) {
						if ($clasificacion == $p_c->getIdClasificacionProducto()) {
							$encontrado = true;
						} //$clasificacion == $p_c->getIdClasificacionProducto()
					} //$clasificaciones as $clasificacion
					if (!$encontrado)
						ProductoClasificacionDAO::delete($p_c);
				} //$productos_clasificacion as $p_c
			} //!is_null($clasificaciones)

			/* Fin if de clasificaciones */
			if (!is_null($impuestos)) {
				$impuestos = object_to_array($impuestos);

				if (!is_array($impuestos)) {
					throw new Exception("Los impuestos fueron recibidos incorrectamente", 901);
				} //!is_array($impuestos)

				$impuesto_producto = new ImpuestoProducto(array(
					"id_producto" => $producto->getIdProducto()
				));
				foreach ($impuestos as $impuesto) {
					if (is_null(ImpuestoDAO::getByPK($impuesto)))
						throw new Exception("El impuesto con id " . $impuesto . " no existe", 901);
					$impuesto_producto->setIdImpuesto($impuesto);
					ImpuestoProductoDAO::save($impuesto_producto);
				} //$impuestos as $impuesto
				$impuestos_producto = ImpuestoProductoDAO::search(new ImpuestoProducto(array(
					"id_producto" => $id_producto
				)));
				foreach ($impuestos_producto as $i_p) {
					$encontrado = false;
					foreach ($impuestos as $impuesto) {
						if ($impuesto == $i_p->getIdImpuesto()) {
							$encontrado = true;
						} //$impuesto == $i_p->getIdImpuesto()
					} //$impuestos as $impuesto
					if (!$encontrado)
						ImpuestoProductoDAO::delete($i_p);
				} //$impuestos_producto as $i_p
			} //!is_null($impuestos)

			/* Fin if de impuestos */
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("El producto no pudo ser editado: " . $e);
			if ($e->getCode() == 901)
				throw new Exception("El producto no pudo ser editado: " . $e->getMessage(), 901);
			throw new Exception("El producto no pudo ser editado", 901);
		}
		DAO::transEnd();
		Logger::log("Producto editado exitosamente");

	}

	/**
	 *
	 *Elimina una equivalencia entre dos unidades.
	 Ejemplo: 1 kg = 2.204 lb
	 *
	 * @param id_unidades int En el ejemplo son las libras
	 * @param id_unidad int En el ejemplo es el kilogramo
	 **/
	public static function EquivalenciaEditarUnidad($equivalencia, $id_unidad, $id_unidades)
	{
		Logger::log("Eliminando equivalencia entre la unidad " . $id_unidad . " y las unidades " . $id_unidades);

		//valida que exista la relacion
		$unidad_equivalencia = UnidadEquivalenciaDAO::getByPK($id_unidad, $id_unidades);
		if (is_null($unidad_equivalencia)) {
			Logger::error("La equivalencia entre la unidad " . $id_unidad . " y las unidades " . $id_unidades . " no existe");
			throw new Exception("La equivalencia entre la unidad " . $id_unidad . " y las unidades " . $id_unidades . " no existe");
		} //is_null($unidad_equivalencia)

		//Elimina la equivalencia
		DAO::transBegin();
		try {
			UnidadEquivalenciaDAO::delete($unidad_equivalencia);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo eliminar la equivalencia entre la unidad " . $id_unidad . " y las unidades " . $id_unidades . ": " . $e);
			throw new Exception("No se pudo eliminar la equivalencia");
		}
		DAO::transEnd();
		Logger::log("Equivalencia eliminada exitosamente");
	}

	/**
	 *
	 *Lista las equivalencias existentes. Se puede ordenar por sus atributos
	 *
	 * @param orden string Nombre de la columna de la tabla por la cual se ordenara la lista
	 * @return unidades_equivalencia json Lista de unidades
	 **/
	private static function Lista_equivalenciaUnidad($orden = null)
	{
		Logger::log("Listando equivalencias");

		//valida la variable orden
		if (!is_null($orden)) {
			if ($orden != "id_unidad" && $orden != "equivalencia" && $orden != "id_unidades") {
				Logger::error("La variable orden (" . $orden . ") es invalida");
				throw new Exception("La variable orden (" . $orden . ") es invalida");
			} //$orden != "id_unidad" && $orden != "equivalencia" && $orden != "id_unidades"
		} //!is_null($orden)

		return UnidadEquivalenciaDAO::getAll(null, null, $orden);
	}

	/**
	 *
	 *Este metodo crea unidades, como son Kilogramos, Libras, Toneladas, Litros, costales, cajas, arpillas, etc.
	 *
	 * @param nombre string Nombre de la unidad convertible
	 * @param descripcion string Descripcion de la unidad convertible
	 * @return id_unidad_convertible string Id de la unidad convertible
	 **/
	public static function NuevaUnidad($es_entero, $nombre, $descripcion = null)
	{
		Logger::log("Creando una nueva unidad");

		//valida los parametros recibidos
		$validar = self::validarParametrosUnidad(null, $nombre, $descripcion, $es_entero);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)

		$unidad = new Unidad(array(
			"nombre" => trim($nombre),
			"es_entero" => $es_entero,
			"descripcion" => $descripcion,
			"activa" => 1
		));
		DAO::transBegin();
		try {
			UnidadDAO::save($unidad);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo crear la unidad: " . $e);
			throw new Exception("No se pudo crear la unidad");
		}
		DAO::transEnd();
		Logger::log("Unidad creada exitosamente");
		return array(
			"id_unidad" => $unidad->getIdUnidad()
		);
	}

	/**
	 *
	 *Este metodo modifica la informacion de una unidad
	 *
	 * @param id_unidad_convertible string Id de la unidad convertible a editar
	 * @param descripcion string Descripcion de la unidad convertible
	 * @param nombre string Nombre de la unidad convertible
	 **/
	public static function EditarUnidad($id_unidad, $descripcion = null, $es_entero = null, $nombre = null)
	{
		Logger::log("Editando unidad " . $id_unidad);

		//Se validan los parametros
		$validar = self::validarParametrosUnidad($id_unidad, $nombre, $descripcion, $es_entero);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)

		//Los parametros que no sean nulos se tomaran como actualizacion
		$unidad = UnidadDAO::getByPK($id_unidad);
		if (!is_null($descripcion)) {
			$unidad->setDescripcion($descripcion);
		} //!is_null($descripcion)
		if (!is_null($nombre)) {
			$unidad->setNombre(trim($nombre));
		} //!is_null($nombre)
		if (!is_null($es_entero)) {
			$unidad->setEsEntero($es_entero);
		} //!is_null($es_entero)

		//se guardan los cambios
		DAO::transBegin();
		try {
			UnidadDAO::save($unidad);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo editar la unidad " . $id_unidad . ": " . $e);
			throw new Exception("No se pudo editar la unidad");
		}
		DAO::transEnd();
		Logger::log("Unidad editada exitosamente");
	}

	/**
	 *
	 *Descativa una unidad para que no sea usada por otro metodo
	 *
	 * @param id_unidad_convertible int Id de la unidad convertible a eliminar
	 **/
	public static function EliminarUnidad($id_unidad)
	{
		Logger::log("Eliminando la unidad " . $id_unidad);

		//valida la unidad
		$validar = self::validarParametrosUnidad($id_unidad);
		if (is_string($validar)) {
			Logger::error($validar);
			throw new Exception($validar);
		} //is_string($validar)

		$unidad = UnidadDAO::getByPK($id_unidad);
		$unidad->setActiva(0);

		//Se eliminaran los registros de la tabla unidad equivalencia que contengan a esta unidad,
		//tanto como id_unidad como id_unidades
		$unidades_equivalencia_unidad   = UnidadEquivalenciaDAO::search(new UnidadEquivalencia(array(
			"id_unidad" => $id_unidad
		)));
		$unidades_equivalencia_unidades = UnidadEquivalenciaDAO::search(new UnidadEquivalencia(array(
			"id_unidades" => $id_unidad
		)));

		DAO::transBegin();
		try {
			UnidadDAO::save($unidad);
			foreach ($unidades_equivalencia_unidad as $unidad_equivalencia) {
				UnidadEquivalenciaDAO::delete($unidad_equivalencia);
			} //$unidades_equivalencia_unidad as $unidad_equivalencia
			foreach ($unidades_equivalencia_unidades as $unidad_equivalencia) {
				UnidadEquivalenciaDAO::delete($unidad_equivalencia);
			} //$unidades_equivalencia_unidades as $unidad_equivalencia
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("La unidad " . $id_unidad . "  no pudo ser eliminada: " . $e);
			throw new Exception("La unidad no pudo ser eliminada");
		}
		DAO::transEnd();
		Logger::log("La unidad ha sido eliminada exitosamente");
	}


	/**
	 *
	 * Buscar productos por codigo_producto, nombre_producto, descripcion_producto.
	 *
	 * @param query string Buscar productos por codigo_producto, nombre_producto, descripcion_producto.
	 * @param id_producto int Si estoy buscando un producto del cual ya tengo conocido su id. Si se envia `id_producto` todos los demas campos seran ignorados.
	 * @param id_sucursal int Buscar las existencias de este producto en una sucursal especifica.
	 * @return resultados json
	 * @return numero_de_resultados int
	 **/
	public static function Buscar(
		$query,
		$id_producto = null,
		$id_sucursal = null
	)
	{
		if (!is_null($id_producto)) {
			Logger::log("Buscando producto por id_producto = $id_producto.... " );

			$p = ProductoDAO::getByPK($id_producto);

			if(is_null($p)){
				return array(
					"resultados" => array(),
					"numero_de_resultados" => 0
				);
			}

			return array(
				"resultados" => array($p->asArray()),
				"numero_de_resultados" => 1
			);
		} //!is_null($id_producto)

		if (!is_null($id_sucursal)) {
			Logger::log("Buscando producto por id_sucursal = $id_sucursal.... " );

			$empresas = SucursalEmpresaDAO::search( new SucursalEmpresa(array( "id_sucursal" => $id_sucursal )));

			if(empty($empresas)){
				Logger::log("no results");
				return array( "resultados" => array(),"numero_de_resultados" => 0);
			}

			$results = array();

			foreach ($empresas as $e) {

				Logger::log("suc $id_sucursal pertenece a empresa:" . $e->getIdEmpresa() );

				$productos_e = ProductoEmpresaDAO::search( new ProductoEmpresa( array("id_empresa" => $e->getIdEmpresa()) ) );

				foreach ($productos_e as $p_e) {
					$p = ProductoDAO::getByPK( $p_e->getIdProducto() );
					if(is_null($p)){
						throw new BusinessLogicException( "el producto ". $p_e->getIdProducto() .  " no existe");
					}
					array_push($results, $p->asArray());
				}
			}

			if(sizeof($results) == 0){
				array_push($results, array(
						"nombre_producto" => "lksadjfklaj",
						"descripcion" => "asdf"
					));
			}

			return array(
				"numero_de_resultados" => sizeof( $results ),
				"resultados" => $results
			);

		}//if (!is_null($id_sucursal))


		$productos = ProductoDAO::buscarProductos($query);

		$resultado = array();

		foreach ($productos as $p) {
			$r = $p->asArray();

			//una vez que tengo los productos vamos a agergarle sus
			//precios tarifarios
			$r["tarifas"] = TarifasController::_CalcularTarifa($p, "venta");

			//buscar sus existencias

			$existencias = InventarioController::Existencias( /* $id_almacen */ null, /* $id_empresa */ null, /* $id_producto */ $p->getIdProducto(), /* $id_sucursal */ null);

			$r["existencias"] = $existencias["resultados"];

			array_push($resultado, $r);
		} //$productos as $p



		if((strlen($query) > 0) && (sizeof($resultado) == 0)){
			array_push($resultado, array(
					"nombre_producto" => "El producto <i>$query</i> no se encuentra.",
					"descripcion" => "&iquest; Desea agregarlo ahora ?",
					"id_producto" => -99,
					"query" => $query
				));
		}


		return array(
			"resultados" => $resultado,
			"numero_de_resultados" => sizeof($resultado)
		);
	}


	public static function EquivalenciaEliminarUnidad($id_unidad, $id_unidades)
	{
	}






	public static function EquivalenciaNuevaUnidad($equivalencia, $id_unidad, $id_unidades)
	{
	}

	// - - CATEGORIAS DE UDM - - //

	/**
	 *
	 * Lista las categorias de unidades.
	 *
	 * @param activa bool Status de las categorias a buscar. Si es null busca tanto activas como inactivas.
	 * @param query string Cadena de texto a buscar en descripcion. Si es null, las devuelve todas.
	 * @return resultados json Lista de categorias obtenidas.
	 **/
	public static function BuscarCategoriaUdm($activa=true, $query=null) {
		if (is_null($activa) && is_null($query)) {
			$resultado = CategoriaUnidadMedidaDAO::getAll();
		}
		else {
			$resultado = CategoriaUnidadMedidaDAO::buscar($activa, $query);
		}

		return array("resultados" => $resultado);
	}

	/**
	 *
	 * Crea una nueva categoria para unidades.
	 *
	 * @param descripcion string Descripcion de la nueva categoria.
	 * @param activo bool Status de la nueva categoria.
	 * @throws BusinessLogicException si ya existe otra categoria con la misma descripcion.
	 * @return id_categoria_unidad_medida int ID de la nueva categoria.
	 **/
	public static function NuevaCategoriaUdm($descripcion, $activo=true) {
		Logger::log("Creando una nueva categoria unidad de medida....");

		if (empty($descripcion)) {
			throw new InvalidArgumentException("Descripcion vacía", 1);
		}

		//buscar esa descripcion de unidad
		$cat_udm = new CategoriaUnidadMedida(array(
			"descripcion" => $descripcion
		));


		$n = CategoriaUnidadMedidaDAO::search($cat_udm);

		if(sizeof($n) > 0){
			throw new BusinessLogicException("Ya existe esta descripcion");
		}

		if(is_null($activo)) $activo = true;

		$cat_udm->setActiva( $activo );

		DAO::transBegin();
		try {
			CategoriaUnidadMedidaDAO::save($cat_udm);

		}catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo crear la categoria unidad de medida: " . $e);
			throw new Exception("No se pudo crear la categoria unidad de medida");

		}

		DAO::transEnd();
		Logger::log("Categoria Unidad de Medida creada exitosamente");

		return array(
			"id_categoria_unidad_medida" => (int)$cat_udm->getIdCategoriaUnidadMedida()
		);
	}

	/**
	 *
	 * Obtener las propiedades de una categoria.
	 *
	 * @param id_categoria_unidad_medida int ID de la categoria a mostrar.
	 * @throws InvalidDatabaseOperationException si la categoria no existe.
	 * @return categoria_unidad_medida json Objeto con las propiedades de la categoria.
	 **/
	public static function DetallesCategoriaUdm($id_categoria_unidad_medida) {
		$categoria = CategoriaUnidadMedidaDAO::getByPK($id_categoria_unidad_medida);

		if (is_null($categoria)) {
			throw new InvalidDatabaseOperationException("La categoria no existe", 1);
		}

		return array(
			'categoria_unidad_medida' => $categoria
		);
	}

	/**
	 *
	 * Edita una categoria de unidades.
	 *
	 * @param id_categoria_unidad_medida int ID de la categoria a editar.
	 * @param activo int Nuevo status de la categoria. Si es null no se editara.
	 * @param descripcion string Nueva descripcion de la categoria. Si es null no se editara.
	 * @throws InvalidDatabaseOperationException si la categoria no existe.
	 **/
	public static function EditarCategoriaUdm($id_categoria_unidad_medida, $activo = null, $descripcion = null) {
		Logger::log("Editando categoria unidad de medida " . $id_categoria_unidad_medida);

		$cat_unidad = CategoriaUnidadMedidaDAO::getByPK($id_categoria_unidad_medida);
		if (is_null($cat_unidad)) {
			throw new InvalidDatabaseOperationException("La categoria no existe", 1);
		}

		if (!is_null($activo)) {
			$cat_unidad->setActiva($activo);
		}
		if (!is_null($descripcion)) {
			$cat_unidad->setDescripcion($descripcion);
		}

		//se guardan los cambios
		DAO::transBegin();
		try {
			CategoriaUnidadMedidaDAO::save($cat_unidad);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo editar la categoria unidad de medida" . $id_categoria . ": " . $e);
			throw new Exception("No se pudo editar la categoria unidad de medida");
		}
		DAO::transEnd();
		Logger::log("Categoria Unidad de Medida editada exitosamente");
	}

	// - - Unidades de Medida -- //

	/**
	 *
	 * Lista las equivalencias existentes. Se puede ordenar por sus atributos
	 *
	 * @param query string Cadena de texto a buscar en abreviación  y descripción. Si es null, las devuelve todas.
	 * @return resultados json Objeto que contendra la lista de udm.
	 **/
	public static function BuscarUnidadUdm($query=null) {
		if (is_null($query)) {
			$r = UnidadMedidaDAO::getAll();
		}
		else {
			$r = UnidadMedidaDAO::buscar($query);
		}

		return array(
			"resultados" => $r
		);
	}

	/**
	 *
	 * Crea una nueva unidad de medida.
	 *
	 * @param abreviacion string Abreviacion de la unidad.
	 * @param descripcion string Nombre de la unidad.
	 * @param factor_conversion float Equivalencia de esta unidad con respecto a la unidad de medida base obtenida de la
	 *        categoria a la cual pertenece esta unidad. En caso de que se seleccione el valor de tipo_unidad_medida =
	 *        "Referencia UdM para esta categoría" este valor sera igual a uno automáticamente sin posibilidad de ingresar
	 *        otro valor diferente.
	 * @param id_categoria_unidad_medida int Id de la categoria a la cual pertenece la unidad.
	 * @param tipo_unidad_medida enum Tipo de unidad cuyo valores son los siguientes: "Referencia UdM para esta categoria"
	 *        (define a esta unidad como la unidad base de referencia de esta categoria, en caso de seleccionar esta opción
	 *        automticamente el factor de conversion sera igual a uno sin posibilidad de ingresar otro valor diferente), "Mayor
	 *        que la UdM de referencia" (indica que esta unidad de medida sera mayor que la unidad de medida base d la
	 *        categoria que se indique) y "Menor que la UdM de referencia" (indica que esta unidad de medida sera menor que la
	 *        unidad de medida base de la categora que se indique). Cuando se defina una nueva unidad de referencia las demás
	 *        unidades de esta categoría se modificarán para establecer los nuevos factores de conversión.
	 * @return id_unidad_medida int ID de la unidad de medida recién creada.
	 * @throws BusinessLogicException si abreviacion y/o descripcion ya existen en la categoria, si factor_conversion no es
	 *         mayor que cero o si tipo_unidad_medida no es valido.
	 * @throws InvalidArgumentException si abreviacion y/o descripcion son cadenas vacias.
	 * @throws InvalidDatabaseOperationException si la categoria no existe.
	 **/
	public static function NuevaUnidadUdm(
		$abreviacion,
		$descripcion,
		$factor_conversion,
		$id_categoria_unidad_medida,
		$tipo_unidad_medida
	) {
		Logger::log("Creando una nueva unidad de medida");

		$factor_conversion = self::validarParametrosUnidad(
			$abreviacion, $descripcion, $id_categoria_unidad_medida, $tipo_unidad_medida, $factor_conversion
		);

		$udm = new UnidadMedida(array(
			"abreviacion" => trim($abreviacion),
			"descripcion" => $descripcion,
			"factor_conversion" => $factor_conversion,
			"id_categoria_unidad_medida" => $id_categoria_unidad_medida,
			"tipo_unidad_medida" => $tipo_unidad_medida,
			"activa" => 1
		));
		DAO::transBegin();
		try {
			UnidadMedidaDAO::save($udm);
		}
		catch (Exception $e) {
			DAO::transRollback();
			Logger::error("No se pudo crear la unidad de medida: " . $e);
			throw new Exception("No se pudo crear la unidad de medida");
		}
		DAO::transEnd();
		Logger::log("Unidad de Medida creada exitosamente");
		return array(
			"id_unidad_medida" => (int)$udm->getIdUnidadMedida()
		);
	}

	/**
	 *
	 * Obtener un objeto con las propiedades de una unidad.
	 *
	 * @param id_unidad_medida int ID de la unidad a mostrar.
	 * @return unidad_medida json Un objeto con las propiedades de la unidad.
	 * @throws InvalidDatabaseOperationException si la unidad no existe.
	 **/
	public static function DetallesUnidadUdm($id_unidad_medida) {
		$unidad = UnidadMedidaDAO::getByPK($id_unidad_medida);
		if (is_null($unidad)) {
			throw new InvalidDatabaseOperationException("Unidad no existe.", 1);
		}

		return array(
			"unidad_medida" => $unidad
		);
	}

	/**
	 *
	 * Este metodo modifica la informacion de una unidad.
	 *
	 * @param id_unidad_medida int ID de la unidad de medida que se desea editar.
	 * @param abreviacion string Abreviacion de la unidad.
	 * @param descripcion string Nombre de la unidad.
	 * @param factor_conversion float Equivalencia de esta unidad con respecto a la unidad de medida base obtenida de la
	 *        categoria a la cual pertenece esta unidad. En caso de que se seleccione el valor de tipo_unidad_medida =
	 *        "Referencia UdM para esta categoría" este valor sera igual a uno automáticamente sin posibilidad de ingresar
	 *        otro valor diferente.
	 * @param id_categoria_unidad_medida int Id de la categoria a la cual pertenece la unidad.
	 * @param tipo_unidad_medida enum Tipo de unidad cuyo valores son los siguientes: "Referencia UdM para esta categoria"
	 *        (define a esta unidad como la unidad base de referencia de esta categora, en caso de seleccionar esta opción
	 *        automticamente el factor de conversin sera igual a uno sin posibilidad de ingresar otro valor diferente), "Mayor
	 *        que la UdM de referencia" (indica que esta unidad de medida sera mayor que la unidad de medida base d la
	 *        categoria que se indique) y "Menor que la UdM de referencia" (indica que esta unidad de medida sera menor que la
	 *        unidad de medida base de la categora que se indique). Cuando se defina una nueva unidad de referencia las demás
	 *        unidades de esta categoría se modificarán para establecer los nuevos factores de conversión.
	 * @return id_unidad_medida int ID de la unidad de medida recién creada.
	 * @throws BusinessLogicException si abreviacion y/o descripcion ya existen en la categoria o si factor_conversion no es
	 *         mayor que cero.
	 * @throws InvalidArgumentException si abreviacion y/o descripcion son cadenas vacias.
	 **/
	public static function EditarUnidadUdm(
		$id_unidad_medida,
		$id_categoria_unidad_medida = null,
		$abreviacion = null,
		$descripcion = null,
		$factor_conversion = null,
		$tipo_unidad_medida = ""
	) {
		$unidad = UnidadMedidaDAO::getByPK($id_unidad_medida);
		if (is_null($unidad)) {
			throw new InvalidDatabaseOperationException("Unidad no existe.", 1);
		}

		if (is_null($abreviacion)) {
			$abreviacion = $unidad->getAbreviacion();
		} else {
			$unidad->setAbreviacion($abreviacion);
		}

		if (is_null($descripcion)) {
			$descripcion = $unidad->getDescripcion();
		} else {
			$unidad->setDescripcion($descripcion);
		}

		if (is_null($id_categoria_unidad_medida)) {
			$id_categoria_unidad_medida = $unidad->getIdCategoriaUnidadMedida();
		} else {
			$unidad->setIdCategoriaUnidadMedida($id_categoria_unidad_medida);
		}

		if (empty($tipo_unidad_medida)) {
			$tipo_unidad_medida = $unidad->getTipoUnidadMedida();
		} else {
			$unidad->setTipoUnidadMedida($tipo_unidad_medida);
		}

		if (is_null($factor_conversion)) {
			$factor_conversion = $unidad->getFactorConversion();
		} else {
			$unidad->setFactorConversion(self::validarParametrosUnidad(
				$abreviacion, $descripcion, $id_categoria_unidad_medida, $tipo_unidad_medida, $factor_conversion
			));
		}

		UnidadMedidaDAO::save($unidad);
	}

	/**
	 *
	 * Desactivar una unidad de medida
	 *
	 * @param id_unidad_medida int ID de la unidad a desactivar.
	 * @throws InvalidDatabaseOperationException si la unidad no existe.
	 **/
	public static function DesactivarUnidadUdm($id_unidad_medida) {
		$unidad = UnidadMedidaDAO::getByPK($id_unidad_medida);
		if (is_null($unidad)) {
			throw new InvalidDatabaseOperationException("Unidad no existe.", 1);
		}

		$unidad->setActiva(0);
		UnidadMedidaDAO::save($unidad);
	}

	private static function validarParametrosUnidad(
		$abreviacion, $descripcion, $id_categoria_unidad_medida, $tipo_unidad_medida, $factor_conversion
	) {
		if (empty($abreviacion)) {
			throw new InvalidArgumentException("Abreviación vacía", 1);
		}
		if (empty($descripcion)) {
			throw new InvalidArgumentException("Descripción vacía", 1);
		}


		if (is_null(CategoriaUnidadMedidaDAO::getByPK($id_categoria_unidad_medida))) {
			throw new InvalidDatabaseOperationException("Categoria no existe.", 1);
		}

		$unidades = UnidadMedidaDAO::search(new UnidadMedida(array(
			'id_categoria_unidad_medida' => $id_categoria_unidad_medida,
			'abreviacion' => $abreviacion,
			'activa' => 1
		)));
		if (!empty($unidades)) {
			throw new BusinessLogicException("Abreviación ya existe.", 1);
		}

		$unidades = UnidadMedidaDAO::search(new UnidadMedida(array(
			'id_categoria_unidad_medida' => $id_categoria_unidad_medida,
			'descripcion' => $descripcion,
			'activa' => 1
		)));
		if (!empty($unidades)) {
			throw new BusinessLogicException("Descripción ya existe.", 1);
		}

		if ($factor_conversion <= 0) {
			throw new BusinessLogicException("Factor menor o igual a cero.", 1);
		}

		$tipos = array(
			"Referencia UdM para esta categoria",
			"Menor que la UdM de referencia",
			"Mayor que la UdM de referencia"
		);
		if (!in_array($tipo_unidad_medida, $tipos)) {
			throw new BusinessLogicException("Tipo inválido", 1);
		}

		if($tipo_unidad_medida == $tipos[0]){
			$factor_conversion = 1;
		}
		elseif ($tipo_unidad_medida == $tipos[1] && $factor_conversion > 1) {
			$factor_conversion = 1.0 / $factor_conversion;
		}

		return $factor_conversion;
	}

	private static function importarCSV( $raw_contents ){
		Logger::log("Importando como CSV");

		 $firstLine =   strpos( $raw_contents , "\n");

		$head = str_getcsv( substr ( $raw_contents , 0 , $firstLine), ',' ,'"' );

		$data = str_getcsv( substr ( $raw_contents , $firstLine ), ',' ,'"' );

		$soh = sizeof($head);




		$indices_names = array(
						"activo",
						"codigo_producto",
						"compra_en_mostrador",
						"id_unidad_compra",
						"metodo_costeo" ,
						"nombre_producto",
						"codigo_de_barras",
						"control_de_existencia",
						"costo_estandar",
						"descripcion_producto",
						"foto_del_producto",
						"garantia",
						"id_categoria",
						"id_empresas",
						"id_unidad",
						"impuestos",
						"precio_de_venta"
				);


		for ($i=0; $i < sizeof($indices_names); $i++) {
			$indices[$indices_names[$i]] = array_search($indices_names[$i], $head);

			/*if( $indices[$indices_names[$i]] !== FALSE )
					Logger::log("there is NORMAL param at $i => " . $head[ $indices[$indices_names[$i]] ]  );*/

		}


		//indices, del 0 al max_indice
		//quitar los que esten en $indices[*]
		$extra_params_indices = array();

		for ($i=0; $i < sizeof($head); $i++) {

			if(array_search($i, $indices) !== FALSE )    continue;

			array_push($extra_params_indices, $i);

			/*Logger::log("there is extra param at $i => " . $head[ $i ] );*/
		}

		$iteraciones = sizeof($data) / $soh;

		//Logger::log("soh=" . $soh . " , sod=" . sizeof($data) . " , " . " it=" . $iteraciones);

		$i = 0;

		while( $i < $iteraciones ) {

				try{

					/*
					for ($h=0; $h < sizeof($indices_names); $h++) {
						//$indices_names[$h]
						if($indices[$indices_names[$h]] !== FALSE)
						Logger::log($indices_names[$h] . " =   ($i * $soh) + " . $indices[$indices_names[$h]]  . " = " . (($i * $soh) + $indices[$indices_names[$h]] ) . " = " .   ($data[ ($i * $soh) + $indices[$indices_names[$h]] ])    );
					}*/

					/*
					if( (($i * $soh) + $indices["razon_social"]) >= $soh ){
						//ya no hay campos
						Logger::log("//ya no hay campos ");
						break;
					}*/

					//buscar todos los demas parametros que no estan en
					//$indicies, y mandarlos como un arreglo asociativo
					//a extra_params
					$extra_params = array();
					for ($j=0; $j < sizeof($extra_params_indices); $j++) {
						$extra_params[ $head[ $extra_params_indices[ $j ] ] ] = $data[ ($i * $soh) + $extra_params_indices[ $j ] ];
					}




					$nc = self::Nuevo(

						$indices["activo"] !== FALSE ?            $data[ ($i * $soh) + $indices["activo"] ] : 1,
						$indices["codigo_producto"] !== FALSE ?            $data[ ($i * $soh) + $indices["codigo_producto"] ] : NULL,
						$indices["compra_en_mostrador"] !== FALSE ?            $data[ ($i * $soh) + $indices["compra_en_mostrador"] ] : 0,
						$indices["id_unidad_compra"] !== FALSE ?            $data[ ($i * $soh) + $indices["id_unidad_compra"] ] : 6,
						$indices["metodo_costeo"] !== FALSE ?            $data[ ($i * $soh) + $indices["metodo_costeo"] ] : "precio",
						$indices["nombre_producto"] !== FALSE ?            $data[ ($i * $soh) + $indices["nombre_producto"] ] : NULL,
						$indices["codigo_de_barras"] !== FALSE ?            $data[ ($i * $soh) + $indices["codigo_de_barras"] ] : NULL,
						$indices["control_de_existencia"] !== FALSE ?            $data[ ($i * $soh) + $indices["control_de_existencia"] ] : NULL,
						$indices["costo_estandar"] !== FALSE ?            $data[ ($i * $soh) + $indices["costo_estandar"] ] : NULL,
						$indices["descripcion_producto"] !== FALSE ?            $data[ ($i * $soh) + $indices["descripcion_producto"] ] : NULL,
						$indices["foto_del_producto"] !== FALSE ?            $data[ ($i * $soh) + $indices["foto_del_producto"] ] : NULL,
						$indices["garantia"] !== FALSE ?            $data[ ($i * $soh) + $indices["garantia"] ] : NULL,
						$indices["id_categoria"] !== FALSE ?            $data[ ($i * $soh) + $indices["id_categoria"] ] : NULL,
						$indices["id_empresas"] !== FALSE ?            $data[ ($i * $soh) + $indices["id_empresas"] ] : NULL,
						$indices["id_unidad"] !== FALSE ?            $data[ ($i * $soh) + $indices["id_unidad"] ] : NULL,
						$indices["impuestos"] !== FALSE ?            $data[ ($i * $soh) + $indices["impuestos"] ] : NULL,
						$indices["precio_de_venta"] !== FALSE ?            $data[ ($i * $soh) + $indices["precio_de_venta"] ] : NULL

				   );




				}catch(Exception $e){
					Logger::Warn($e);
					//continuar
				}


				$i ++;

		}//for

	}





	public static function Importar($raw_contents){

		Logger::log("====== Importando productos ========");

		Logger::log("El tamaño del archivo es de " . strlen( $raw_contents ) . " bytes.");



		$lines = explode( "\n", $raw_contents );
		$nline = 0;

		//buscar las llaves de cliente
		while( ( $nline < sizeof($lines) ) && ($lines[$nline] != "MGW10005" ) ) $nline++;

		if($nline >= sizeof($lines)){
			//no econtre esa madre de adminpaq, es un SCV
			return self::ImportarCSV($raw_contents);
		}









		$productos_importados = 0;
		$productos_no_importados = 0;
		$errores = array();
		$lines = explode( "\n", $raw_contents );
		$nline = -1;

		//buscar las llaves de cliente
		$size = sizeof($lines);

		while( ( $nline < ($size-1) )&&( trim($lines[++$nline]) != "MGW10005")) ;

		if($nline == ($size-1)){
			Logger::log("No encontre la seccion de productos...");
			return;
		}

		//ya encontre los productos, vamos a guardar las llaves

		$keys = array();

		$c = -1;


		while( trim($lines[$nline]) != "/MGW10005"){

			$keys[$c++] = trim($lines[$nline]);

			$nline++;
		}



		//ok ya tengo las llaves, iniciemos el proceso de busqueda
		while ( ++$nline < ($size-1) )  {



			if(trim($lines[$nline]) == "MGW10005"){

				$aProducto = Array();

				Logger::log("Encontre producto en " . ($nline +1));



				//encontre el producto
				for ($pindex=0, ++$nline; $pindex < (sizeof( $keys )-1); $pindex++, $nline++) {

					$cline  = trim($lines[$nline]);

					if($cline == "{"){
						$mtext = "";
						$nline++;
						Logger::log("Encontre multitexto en " . ($nline+1));
						while( trim($lines[$nline]) != "}" ) {
							$mtext .= trim($lines[$nline]);
							$nline++;
						}

						Logger::log("Multitexto termino en " . ($nline+1));

						$aProducto[ $keys[ $pindex ] ] = $mtext;

					}else{
						$aProducto[ $keys[ $pindex ] ] = trim($lines[$nline]);
					}







				}



				Logger::log("Insertando `". $aProducto["cNombreProducto"] ."` ...");


				if(strlen(trim($aProducto["cNombreUnidadCompra"])) == 0){
					$aProducto["cNombreUnidadCompra"] = 1;
				}

				if(strlen(trim($aProducto["cCodigoValorClasif1"])) == 0){
					$aProducto["cCodigoValorClasif1"] = null;
				}

				try{
					self::nuevo(
						$activo                 = $aProducto["cStatusProducto"],
						$codigo_producto		= $aProducto["cCodigoProducto"],
						$compra_en_mostrador	= false,
						$id_unidad_compra		= $aProducto["cNombreUnidadCompra"],
						$metodo_costeo			= "precio",
						$nombre_producto		= $aProducto["cNombreProducto"],
						$codigo_de_barras = null,
						$control_de_existencia = $aProducto["cControlExistencia"],
						$costo_estandar = null,
						$descripcion_producto = $aProducto["cDescripcionProducto"],
						$foto_del_producto = null,
						$garantia = null,
						$id_categoria = $aProducto["cCodigoValorClasif1"],
						$id_empresas = null,
						$id_unidad = null,
						$impuestos = null,
						$precio_de_venta = $aProducto["cPrecio1"]

					);

					$productos_importados++;

				}catch(InvalidDataException $ide){
					Logger::error( $ide->getMessage() );
					$productos_no_importados++;
					array_push($errores, $ide->getMessage() );

				}catch(InvalidDatabaseOperationException $idoe){
					Logger::error( $idoe->getMessage() );
					$productos_no_importados++;
					array_push($errores, $idoe->getMessage() );

				}catch(Exception $e){
					Logger::error( $e->getMessage() );
					$productos_no_importados++;
					array_push($errores, $e->getMessage() );
				}
			}
		}//while


		return array(
				"productos_importados" => $productos_importados,
				"productos_no_importados" => $productos_no_importados,
				"errores" => $errores
			);

	}//importar productos

	/**
	 *Lista los productos por empresa, almacen y lote
	 */
	public static function listarProductosLote($activo = null,
		$id_almacen = null,
		$id_empresa = null
	)
	{

		//objeto que se regresara
		$company = new stdClass();
		//contiene todas las empresas
		$company->empresas = array();

		//obtenemos todas las empresas
		$empresas = EmpresaDAO::getAll();

		//iteramos las empresas para obtener sus almacenes
		foreach( $empresas as $empresa ){

			//insertamos la empresa a la compañia
			$e = new stdClass();
			$e->id_empresa = $empresa->getIdEmpresa();
			$e->nombre = $empresa->getRazonSocial();
			$e->almacenes = array();

			$almacenes = AlmacenDAO::search( new Almacen( array( "id_empresa" => $empresa->getIdEmpresa() ) ) );

			//iteramos todos los almacenes de la empresa
			foreach( $almacenes as $almacen ){

				$a = new stdClass();
				$a->id_almacen = $almacen->getIdAlmacen();
				$a->nombre = $almacen->getNombre();
				$a->id_sucursal = $almacen->getIdSucursal();
				$a->sucursal = SucursalDAO::getByPK($a->id_sucursal)->getRazonSocial();
				$a->lotes = array();

				//obtenemos todos los lotes del almacen
				$lotes =  LoteDAO::search( new Lote( array( "id_almacen" => $almacen->getIdAlmacen() ) ) );

				//iteramos todos los lotes del almacen
				foreach($lotes as $lote){

					$l = new StdClass();
					$l->id_lote = $lote->getIdLote();
					$l->id_almacen = $lote->getIdAlmacen();
					$l->folio = $lote->getFolio();
					$l->lotes_producto = array();

					//obtenemos todos los productos de un lote
					$lotes_producto = LoteProductoDAO::search( new LoteProducto( array( "id_lote" => $lote->getIdLote() ) ) );

					//iteramos lodos los lotes con producto que perteneces al lote
					foreach($lotes_producto as $lote_producto ){

						$producto = ProductoDAO::getByPK( $lote_producto->getIdProducto() );

						$lp = new StdClass();
						$lp->id_lote = $lote_producto->getIdLote();
						$lp->id_producto = $lote_producto->getIdProducto();
						$lp->cantidad = $lote_producto->getCantidad();
						$lp->id_unidad = $lote_producto->getIdUnidad();
						$lp->unidad = UnidadMedidaDAO::getByPK($lp->id_unidad)->getAbreviacion();
						//$lp->recalculo = ProductoDAO::ExistenciasTotales($lp->id_producto);
						$lp->recalculo = ProductoDAO::ExistenciasLote($lp->id_producto, $lp->id_lote, $lp->id_unidad);
						$lp->nombre = $producto->getNombreProducto();
						$lp->codigo = $producto->getCodigoProducto();
						array_push($l->lotes_producto, $lp);

					}

					array_push($a->lotes, $l);

				}

				array_push($e->almacenes, $a);

			}

			array_push($company->empresas, $e);

		}

		return $company;

	}

}
