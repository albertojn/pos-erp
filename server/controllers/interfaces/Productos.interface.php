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
 	 * @param id_categoria int Se busca una categoria dado su id_categoria
 	 * @param id_categoria_padre int Se buscan las categorias pertenecientes a una categoria padre dado su id_categoria_padre. 
 	 * @param query string Buscar categoria por nombre_producto, codigo_producto, codigo_de_barras
 	 * @return numero_de_resultados int El numero de resultados obtenido de la busqueda
 	 * @return resultados json json con los resultados de la busqueda
 	 **/
  static function BuscarCategoria
	(
		$id_categoria = null, 
		$id_categoria_padre = null, 
		$query = null
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo desactiva una categoria de tal forma que ya no se vuelva a usar como categoria sobre un producto.
 	 *
 	 * @param id_categoria int Id de la categoria a desactivar
 	 **/
  static function DesactivarCategoria
	(
		$id_categoria
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo cambia la informacion de una categoria de producto
 	 *
 	 * @param id_categoria int Id de la categoria del producto
 	 * @param descripcion string Descripcion larga de la categoria
 	 * @param id_categoria_padre string Id de la categora padre en caso de tenerla
 	 * @param nombre string Nombre de la categoria del producto
 	 **/
  static function EditarCategoria
	(
		$id_categoria, 
		$descripcion = null, 
		$id_categoria_padre = null, 
		$nombre = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Crea una nueva categoria de producto, la categoria de un producto se relaciona con los meses de garantia del mismo, las unidades en las que se almacena entre, si se es suceptible a devoluciones, entre otros.
 	 *
 	 * @param nombre string Nombre de la categoria
 	 * @param descripcion string Descripcion larga de la categoria
 	 * @param id_categoria_padre string Id de la categor�a padre, en caso de que tuviera un padre
 	 * @return id_categoria int Id atogenerado por la insercion de la categoria
 	 **/
  static function NuevaCategoria
	(
		$nombre, 
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
 	 * @param garantia int Numero de meses de garantia de este producto
 	 * @param garantia int Numero de meses de garantia con los que cuenta esta categoria de producto
 	 * @param id_unidad int La unidad preferente de este producto
 	 * @param impuestos json array de ids de impuestos que tiene este producto
 	 * @param metodo_costeo string Puede ser "precio" o "costo" e indican si el precio final sera tomado a partir del costo del producto o del precio del mismo
 	 * @param nombre_producto string Nombre del producto
 	 * @param peso_producto float el peso de este producto en KG
 	 * @param precio int El precio de este producto
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
		$impuestos = null, 
		$metodo_costeo = null, 
		$nombre_producto = null, 
		$peso_producto = null, 
		$precio = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crear un nuevo producto, 

NOTA: Se crea un producto tipo = 1 que es para productos.
 	 *
 	 * @param activo bool Si queremos que este activo o no este producto despues de crearlo.
 	 * @param codigo_producto string El codigo de control de la empresa para este producto, no se puede repetir
 	 * @param compra_en_mostrador bool Verdadero si este producto se puede comprar en mostrador, para aquello de compra-venta
 	 * @param costo_estandar string Este valor sera tomado solo en caso de seleccionar `costo estandar` como mtodo de costeo
 	 * @param id_unidad_compra string Unidad de medida por defecto utilizada para los pedidos de compra. Debe estar en la misma categora que la unidad de medida por defecto.
 	 * @param metodo_costeo string `costo estandar` el precio de coste es fijo y se recalcula periodicamente (normalmente al finalizar el anio).`precio` 
 	 * @param nombre_producto string Nombre del producto
 	 * @param codigo_de_barras string El Codigo de barras para este producto
 	 * @param control_de_existencia int 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote
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
		$costo_estandar, 
		$id_unidad_compra, 
		$metodo_costeo, 
		$nombre_producto, 
		$codigo_de_barras = null, 
		$control_de_existencia = null, 
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
 	 * @param productos json Arreglo de objetos que contendr�n la informaci�n del nuevo producto
 	 * @return id_productos json Arreglo de enteros que contendr� los ids de los productos insertados.
 	 **/
  static function VolumenEnNuevo
	(
		$productos
	);  
  
  
	
  
	/**
 	 *
 	 *Lista las categor?as de unidades
 	 *
 	 * @param limit int Indica el registro final del conjunto de datos que se desea mostrar
 	 * @param page int Indica en que pagina se encuentra dentro del conjunto de resultados que coincidieron en la bsqueda
 	 * @param query string El texto a buscar
 	 * @param start int Indica el registro inicial del conjunto de datos que se desea mostrar
 	 * @return numero_de_resultados int 
 	 * @return resultados json Objeto que contendr la lista de categoras de unidades
 	 **/
  static function BuscarCategoriaUdm
	(
		$limit =  50 , 
		$page = null, 
		$query = null, 
		$start =  0 
	);  
  
  
	
  
	/**
 	 *
 	 *Edita una categor?a de unidades
 	 *
 	 * @param activo int Indica si la categor�a esta activa
 	 * @param descripcion string Descripcin de la categora
 	 * @param id_categoria int Id de la categora que se desea editar
 	 **/
  static function EditarCategoriaUdm
	(
		$activo, 
		$descripcion, 
		$id_categoria
	);  
  
  
	
  
	/**
 	 *
 	 *Crea una nueva categor?a para unidades
 	 *
 	 * @param descripcion string Descripcin de la categora
 	 * @param activo int Indica si la categor�a esta activa, en caso de no indicarlo se tomara como activo
 	 * @return id_categoria int Id de la categoria
 	 **/
  static function NuevaCategoriaUdm
	(
		$descripcion, 
		$activo = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Lista las equivalencias existentes. Se puede ordenar por sus atributos
 	 *
 	 * @param limit int Indica el registro final del conjunto de datos que se desea mostrar
 	 * @param page int Indica en que pagina se encuentra dentro del conjunto de resultados que coincidieron en la bsqueda
 	 * @param query string El texto a buscar
 	 * @param start int Indica el registro inicial del conjunto de datos que se desea mostrar
 	 * @return numero_de_resultados int Lista de unidades
 	 * @return resultados json Objeto que contendra la lista de udm
 	 **/
  static function BuscarUnidadUdm
	(
		$limit =  50 , 
		$page = null, 
		$query = null, 
		$start =  0 
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo modifica la informacion de una unidad
 	 *
 	 * @param activa int Indica si la unidad esta activa
 	 * @param descripcion string Descripci�n de la unidad de medida
 	 * @param factor_conversion float 	 Equivalencia de esta unidad con respecto a la unidad de medida base obtenida de la categor�a a la cual pertenece esta unidad. En caso de que se seleccione el valor de tipo_unidad_medida = "Referencia UdM para esta categoria" este valor sera igual a uno autom�ticamente sin posibilidad de ingresar otro valor diferente
 	 * @param tipo_unidad_medida string 	 Tipo enum cuyo valores son los siguientes : "Referencia UdM para esta categoria" (define a esta unidad como la unidad base de referencia de esta categor�a, en caso de seleccionar esta opci�n autom�ticamente el factor de conversi�n sera igual a uno sin posibilidad de ingresar otro valor diferente), "Mayor que la UdM de referencia" (indica que esta unidad de medida sera mayor que la unidad de medida base d la categor�a que se indique) y "Menor que la UdM de referencia" (indica que esta unidad de medida sera menor que la unidad de medida base de la categor�a que se indique)
 	 * @param abreviatura string Descripci�n corta de la unidad, normalmente sera empelada en ticket de venta
 	 * @param id_categoria_unidad_medida int Id de la categor�a a la cual pertenece la unidad
 	 * @param id_unidad_medida int Id de la unidad de medida que se desea editar
 	 **/
  static function EditarUnidadUdm
	(
		$activa, 
		$descripcion, 
		$factor_conversion, 
		$tipo_unidad_medida, 
		$abreviatura = "", 
		$id_categoria_unidad_medida = "", 
		$id_unidad_medida = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Crea una nueva unidad de medida
 	 *
 	 * @param abreviatura string Descripcin corta de la unidad, normalmente sera empelada en ticket de venta
 	 * @param descripcion string Descripcin de la unidad de medida
 	 * @param factor_conversion float Equivalencia de esta unidad con respecto a la unidad de medida base obtenida de la categora a la cual pertenece esta unidad. En caso de que se seleccione el valor de tipo_unidad_medida = "Referencia UdM para esta categoria"  este valor sera igual a uno automticamente sin posibilidad de ingresar otro valor diferente
 	 * @param id_categoria_unidad_medida int Id de la categora a la cual pertenece la unidad
 	 * @param tipo_unidad_medida string Tipo enum cuyo valores son los siguientes : "Referencia UdM para esta categoria" (define a esta unidad como la unidad base de referencia de esta categora, en caso de seleccionar esta opcin automticamente el factor de conversin sera igual a uno sin posibilidad de ingresar otro valor diferente), "Mayor que la UdM de referencia" (indica que esta unidad de medida sera mayor que la unidad de medida base d la categora que se indique) y "Menor que la UdM de referencia" (indica que esta unidad de medida sera menor que la unidad de medida base de la categora que se indique)
 	 * @param activa string Indica si la unidad esta activa, en caso de no indicarse este valor se considera como que si esta activa la unidad
 	 * @return id_unidad_medida int 
 	 **/
  static function NuevaUnidadUdm
	(
		$abreviatura, 
		$descripcion, 
		$factor_conversion, 
		$id_categoria_unidad_medida, 
		$tipo_unidad_medida, 
		$activa = ""
	);  
  
  
	
  }
