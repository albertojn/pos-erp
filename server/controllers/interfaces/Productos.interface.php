<?php
/**
  *
  *
  *
  **/
	
  interface IProductos {
  
  
	/**
 	 *
 	 *Buscar productos por codigo_producto, nombre_producto, descripcion_producto.

 	 *
 	 * @param query string Buscar productos por codigo_producto, nombre_producto, descripcion_producto.
 	 * @param id_producto int Si estoy buscando un producto del cual ya tengo conocido su id. Si se envia `id_producto` todos los demas campos seran ignorados.
 	 * @param id_sucursal int Buscar las existencias de este producto en una sucursal especifica.
 	 * @return numero_de_resultados int 
 	 * @return resultados json 
 	 **/
  static function Buscar
	(
		$query, 
		$id_producto = null, 
		$id_sucursal = null
	);  
  
  
	
  
	/**
 	 *
 	 *Busca las categorias de los productos
 	 *
 	 * @param activa bool Se buscan categorias por el estado de estas.
 	 * @param query string Buscar categoria por nombre y/o descripcion.
 	 * @return resultados json json con los resultados de la busqueda
 	 **/
  static function BuscarCategoria
	(
		$activa =  true , 
		$query = null
	);  
  
  
	
  
	/**
 	 *
 	 *Obtiene una categoria y sus propiedades.
 	 *
 	 * @param id_categoria int El ID de la categoria a obtener.
 	 * @return categoria json El objeto categoria obtenido.
 	 **/
  static function DetallesCategoria
	(
		$id_categoria
	);  
  
  
	
  
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
  static function EditarCategoria
	(
		$id_clasificacion_producto, 
		$activa = null, 
		$descripcion = null, 
		$id_categoria_padre = null, 
		$nombre = null
	);  
  
  
	
  
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
  static function NuevaCategoria
	(
		$nombre, 
		$activa =  true , 
		$descripcion = null, 
		$id_categoria_padre = null
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo sirve para dar de baja un producto
 	 *
 	 * @param id_producto int Id del producto a desactivar
 	 **/
  static function Desactivar
	(
		$id_producto
	);  
  
  
	
  
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
	);  
  
  
	
  
	/**
 	 *
 	 *importar una lista de productos
 	 *
 	 * @param raw_content string el texto a parsear
 	 * @return errores json 
 	 **/
  static function Importar
	(
		$raw_content
	);  
  
  
	
  
	/**
 	 *
 	 *Crear un nuevo producto, 

NOTA: Se crea un producto tipo = 1 que es para productos.
 	 *
 	 * @param activo bool Si queremos que este activo o no este producto despues de crearlo.
 	 * @param codigo_producto string El codigo de control de la empresa para este producto, no se puede repetir
 	 * @param compra_en_mostrador bool Verdadero si este producto se puede comprar en mostrador, para aquello de compra-venta
 	 * @param id_unidad_compra string Unidad de medida por defecto utilizada para los pedidos de compra. Debe estar en la misma categora que la unidad de medida por defecto.
 	 * @param metodo_costeo string `costo` el precio de coste es fijo y se recalcula periodicamente (normalmente al finalizar el anio).`precio` 
 	 * @param nombre_producto string Nombre del producto
 	 * @param visible_en_vc bool Si queremos que este productos sea visible a los clientes.
 	 * @param codigo_de_barras string El Codigo de barras para este producto
 	 * @param control_de_existencia int 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote
 	 * @param costo_estandar float Este valor sera tomado solo en caso de seleccionar `costo` como metodo de costeo
 	 * @param descripcion_producto string Descripcion larga del producto
 	 * @param foto_del_producto string url a una foto de este producto
 	 * @param garantia int Numero de meses de garantia con los que cuenta esta categoria de producto
 	 * @param id_categoria int id de la categora a la cual pertenece el producto
 	 * @param id_empresas json Arreglo que contendra los ids de las empresas a las que pertenece este producto, en caso de no indicarlo este producto pertenecera a todas las empresas que esten relacionadas con la sucursal
 	 * @param id_unidad int Unidad de medida por defecto empelada para todas las operaciones en el stok
 	 * @param impuestos json array de ids de impuestos que tiene este producto
 	 * @param precio_de_venta int Precio base para calcular el precio del cliente
 	 * @return id_producto int Id generado por la insercin del nuevo producto
 	 **/
  static function Nuevo
	(
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
	);  
  
  
	
  
	/**
 	 *
 	 *Agregar productos en volumen mediante un archivo CSV.
 	 *
 	 * @param productos json Arreglo de objetos que contendrán la información del nuevo producto
 	 * @return id_productos json Arreglo de enteros que contendrá los ids de los productos insertados.
 	 **/
  static function VolumenEnNuevo
	(
		$productos
	);  
  
  
	
  
	/**
 	 *
 	 *Lista las categor?as de unidades.
 	 *
 	 * @param activa bool Status de las categorías a buscar.Si es null busca tanto activas como inactivas.
 	 * @param query string Cadena de texto a buscar en descripción.Si es null, las devuelve todas.
 	 * @return resultados json Lista de categoras obtenidas.
 	 **/
  static function BuscarCategoriaUdm
	(
		$activa =  true , 
		$query = null
	);  
  
  
	
  
	/**
 	 *
 	 *Obtener las propiedades de una categor?a.
 	 *
 	 * @param id_categoria_unidad_medida int ID de la categoría a mostrar.
 	 * @return categoria json Objeto con las propiedades de la categoría.
 	 **/
  static function DetallesCategoriaUdm
	(
		$id_categoria_unidad_medida
	);  
  
  
	
  
	/**
 	 *
 	 *Edita una categor?a de unidades.
 	 *
 	 * @param id_categoria_unidad_medida int ID de la categora a editar.
 	 * @param activo int Nuevo status de la categora.Si es null no se editar.
 	 * @param descripcion string Nueva descripcin de la categora.Si es null no se editar. Lanza excepción si ya existe otra con la misma descripción.
 	 **/
  static function EditarCategoriaUdm
	(
		$id_categoria_unidad_medida, 
		$activo = null, 
		$descripcion = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea una nueva categor?a para unidades.
 	 *
 	 * @param descripcion string Descripción de la nueva categoría. Lanza excepción si ya existe otra con la misma descripción.
 	 * @param activo bool Status de la nueva categora.
 	 * @return id_categoria int ID de la nueva categoria.
 	 **/
  static function NuevaCategoriaUdm
	(
		$descripcion, 
		$activo =  true 
	);  
  
  
	
  
	/**
 	 *
 	 *Lista las equivalencias existentes. Se puede ordenar por sus atributos
 	 *
 	 * @param query string Cadena de texto a buscar en abreviación  y descripción. Si es null, las devuelve todas.
 	 * @return resultados json Objeto que contendra la lista de udm
 	 **/
  static function BuscarUnidadUdm
	(
		$query = null
	);  
  
  
	
  
	/**
 	 *
 	 *Desactivar una unidad de medida
 	 *
 	 * @param id_unidad_medida int ID de la unidad a desactivar.
 	 **/
  static function DesactivarUnidadUdm
	(
		$id_unidad_medida
	);  
  
  
	
  
	/**
 	 *
 	 *Obtener un objeto con las propiedades de una unidad.
 	 *
 	 * @param id_unidad_medida int ID de la unidad a mostrar.
 	 * @return unidad_medida json Un objeto con las propiedades de la unidad.
 	 **/
  static function DetallesUnidadUdm
	(
		$id_unidad_medida
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo modifica la informacion de una unidad.
 	 *
 	 * @param id_categoria_unidad_medida string Id de la categoria a la cual pertenece la unidad.
 	 * @param id_unidad_medida int ID de la unidad de medida que se desea editar.
 	 * @param abreviacion string Descripcin corta de la unidad, normalmente sera empelada en ticket de venta. No puede ser vaca y no puede haber otra igual en la misma categora.
 	 * @param descripcion string Descripcin de la unidad de medida. No puede ser vaca y no puede haber otra igual en la misma categora.
 	 * @param factor_conversion float Equivalencia de esta unidad con respecto a la unidad de medida base obtenida de la categora a la cual pertenece esta unidad. En caso de que se seleccione el valor de tipo_unidad_medida = "Referencia UdM para esta categoria" este valor sera igual a uno automticamente sin posibilidad de ingresar otro valor diferente
 	 * @param tipo_unidad_medida string Tipo enum cuyo valores son los siguientes : "Referencia UdM para esta categoria" (define a esta unidad como la unidad base de referencia de esta categora, en caso de seleccionar esta opcin automticamente el factor de conversin sera igual a uno sin posibilidad de ingresar otro valor diferente), "Mayor que la UdM de referencia" (indica que esta unidad de medida sera mayor que la unidad de medida base d la categora que se indique) y "Menor que la UdM de referencia" (indica que esta unidad de medida sera menor que la unidad de medida base de la categora que se indique). Cuando se defina una nueva unidad de referencia las dems unidades de esta categora se modificarn para establecer los nuevos factores de conversin.
 	 **/
  static function EditarUnidadUdm
	(
		$id_unidad_medida, 
		$id_categoria_unidad_medida = null,
		$abreviacion = null, 
		$descripcion = null, 
		$factor_conversion = null, 
		$tipo_unidad_medida = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Crea una nueva unidad de medida.
 	 *
 	 * @param abreviacion string Descripción corta de la unidad, normalmente sera empleada en ticket de venta. No debe ser vacía. No puede haber dos iguales en la misma categoría.
 	 * @param descripcion string Descripción o nombre de la unidad de medida. No debe ser vacía. No puede haber dos iguales en la misma categoría.
 	 * @param factor_conversion float Equivalencia de esta unidad con respecto a la unidad de medida base obtenida de la categora a la cual pertenece esta unidad. En caso de que se seleccione el valor de tipo_unidad_medida = "Referencia UdM para esta categoría"  este valor sera igual a uno automáticamente sin posibilidad de ingresar otro valor diferente. Debe ser mayor que cero.
 	 * @param id_categoria_unidad_medida int Id de la categora a la cual pertenece la unidad. La categoría debe existir.
 	 * @param tipo_unidad_medida enum Tipo enum cuyo valores son los siguientes : "Referencia UdM para esta categoria" (define a esta unidad como la unidad base de referencia de esta categora, en caso de seleccionar esta opción automticamente el factor de conversin sera igual a uno sin posibilidad de ingresar otro valor diferente), "Mayor que la UdM de referencia" (indica que esta unidad de medida sera mayor que la unidad de medida base d la categora que se indique) y "Menor que la UdM de referencia" (indica que esta unidad de medida sera menor que la unidad de medida base de la categora que se indique). Cuando se defina una nueva unidad de referencia las demás unidades de esta categoría se modificarán para establecer los nuevos factores de conversión.
 	 * @return id_unidad_medida int ID de la unidad de medida recién creada.
 	 **/
  static function NuevaUnidadUdm
	(
		$abreviacion, 
		$descripcion, 
		$factor_conversion, 
		$id_categoria_unidad_medida, 
		$tipo_unidad_medida
	);  
  
  
	
  }
