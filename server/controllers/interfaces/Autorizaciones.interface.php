<?php
/**
  *
  *
  *
  **/
	
  interface IAutorizaciones {
  
  
	/**
 	 *
 	 *Solicitud para cambiar alg?n dato de un cliente. La fecha de petici?n se tomar? del servidor. El usuario y la sucursal que emiten la autorizaci?n ser?n tomadas de la sesi?n.

La autorizacion se guardara con los datos del usuario que la pidio. Si es aceptada, entonces el usuario podra editar al cliente una vez.
 	 *
 	 * @param id_cliente int Id del cliente que se desea editar
 	 * @return id_autorizacion int El id de la autorizacion creada
 	 **/
  static function EditarCliente
	(
		$id_cliente
	);  
  
  
	
  
	/**
 	 *
 	 *Solicitud para cambiar la relaci?n entre cliente y el precio ofrecido para cierto producto ya sea en compra o en venta. La fecha de peticion se tomar? del servidor. El usuario y la sucursal que emiten la autorizaci?n ser?n tomadas de la sesi?n.

UPDATE : Actualmente como se maneja esto es por medio de las ventas preferenciales, es decir, se manda una autorizaci?n para que el cajero pueda editar todos los precios que desee, de todos los productos "solo para esa venta y solo para ese cliente especificamente", ya que si el cliente quisiera que le vendieran mas de un solo producto a diferente precio tendr?as que generar mas de una autorizaci?n, esto implica un incremento considerable en el tiempo de respuesta y aplicaci?n de los cambios.

UPDATE 2: Creo que los metodos : 
api/autorizaciones/editar_precio_cliente y api/autorizaciones/editar_siguiente_compra_venta_precio_cliente
Se podr?an combinar y as? tener un solo m?todo para una compra venta preferencial.
 	 *
 	 * @param compra bool Si es true, el nuevo precio ser requerido para compras en el producto especificado, si es false, el nuevo precio ser requerido para ventas en el producto especificado.
 	 * @param descripcion string Justificacin del cambio de precio del cliente.
 	 * @param id_cliente int Id del cliente al que se le har el cambio.
 	 * @param id_productos json Arreglo de Ids de los productos en los que se hara el cambio 
 	 * @param siguiente_compra bool Si es true, el cambio solo se acplicara a la siguiente compra/venta, pero si es false, el cambio se hara sobre la relacion del cliente con el tipo de precio
 	 * @param id_precio int Id del nuevo precio requerido.
 	 * @param precio float Si el precio deseado no se encuentra en los campos del precio de acuerdo al tipo del cliente, se pued especificar el precio que se desea dar.
 	 **/
  static function PrecioCliente
	(
		$compra, 
		$descripcion, 
		$id_cliente, 
		$id_productos, 
		$siguiente_compra, 
		$id_precio = null, 
		$precio = null
	);  
  
  
	
  
	/**
 	 *
 	 *Solicitud para devolver una compra.

Consideraciones:
-Que hacer con el dinero
-Que hacer con la mercancia

 	 *
 	 * @param id_compra int El `id_compra` de la compra que queremos devolver.
 	 * @param descripcion int Una descripcion que se le mostrara al administrador que conteste esta autorizacion.
 	 * @return id_autorizacion int El id de la autorizacion recien creada
 	 **/
  static function DevolucionCompra
	(
		$id_compra, 
		$descripcion = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Muestra la informacion detallada de una autorizacion.
 	 *
 	 * @param id_autorizacion	 int Id de la autorizacion a inspeccionar.
 	 * @return solicitante json El id del usuario que pidio la autorizacion. {            "id usuario": 24,            "nombre usuario": "Juana Escobar Martinez"        }
 	 * @return sucursal_origen json El id de la sucursal donde se inicio la peticion en caso de existir. En caso de que no aplique, vendra el valor null. {            "id sucursal": 24,            "nombre sucursal": "Sucursal del norte"        }
 	 * @return id_autorizacion int El `id_autorizacion`de esta autorizacion.
 	 * @return fecha_respuesta string La fecha en tiempo Unix de cuando se respondio esta peticion.
 	 * @return fecha_peticion string La fecha en tiempo Unix de cuando se creo esta peticion.
 	 **/
  static function Detalle
	(
		$id_autorizacion	
	);  
  
  
	
  
	/**
 	 *
 	 *Editar una autorizacion en caso de tener permiso.

Update :  Creo que seriabuena idea que se definiera de una vez la estructura de las autorizaciones, ya que como se maneja actualemnte es de la siguiente manera : 

Digo que seria buena idea definir el formato de las autorizaciones para ir pensando en como en un futuro se van a mostrar en las interfaces, apartir de que se se crearan los formularios, actualmente se toma el campo tipo para de ahi saber que tipo de autorizacion es y crear un formulario de este tipo para desplegar los datos, y dependiendo del tipo se identifica que formato de JSON se espera que contenga el campo parametros .



Al momento de editar la autorizacion veo que aparentemente se podria editar el id_autorizacion, id_usuario, id_sucursal, peticion y estado, creo yo que no es prudente editar ninguno de estos campos ya que el mal uso de esta informacion puede da?ar gravemente la integridad del sistema.
 	 *
 	 * @param descripcion string Justificacin de la solicitud.
 	 * @param estado int Id del estado de la autorizacin
 	 * @param id_autorizacion	 int Id de la autorizacin a modificar
 	 **/
  static function Editar
	(
		$descripcion, 
		$estado, 
		$id_autorizacion	
	);  
  
  
	
  
	/**
 	 *
 	 *En caso de que el usuario no tenga persmiso para realizar gasto, puede pedir una autorizacion para registrar un gasto. 
 	 *
 	 * @param descripcion string Justificacin por la cual se pide el gasto.
 	 * @param monto float Monto a gastar
 	 * @return id_autorizacion int El id_autorizacion de la autorizacion recien creada.
 	 **/
  static function Gasto
	(
		$descripcion, 
		$monto
	);  
  
  
	
  
	/**
 	 *
 	 *Muestra la lista de autorizaciones, con la opci?n de filtrar por pendientes, aceptadas, rechazadas, en tr?nsito, embarques recibidos y de ordenar seg?n los atributos de autorizaciones. 
Update :  falta definir el ejemplo de envio.
 	 *
 	 * @param filtro string Nombre de la columna por la cual se ordenara la lista
 	 * @param ordenar string Nombre de la columan por el cual se ordenara la lista
 	 * @return autorizaciones json Arreglo de objetos que contendrá las autorizaciones
 	 **/
  static function Lista
	(
		$filtro = null, 
		$ordenar = null
	);  
  
  
	
  
	/**
 	 *
 	 *Responde a una autorizaci?n en estado pendiente. Este m?todo no se puede aplicar a una autorizaci?n ya resuelta.
 	 *
 	 * @param aceptar bool Valor booleano que indicara si se debe aceptar o no esta autorizacion.
 	 * @param id_autorizacion int Id de la autorizacin a responder
 	 **/
  static function Responder
	(
		$aceptar, 
		$id_autorizacion
	);  
  
  
	
  
	/**
 	 *
 	 *Solicitud de un producto, la fecha de peticion se tomar? del servidor. El usuario y la sucursal que emiten la autorizaci?n ser?n tomadas de la sesi?n.
Update :  Me parece que no es buena idea manejar en los argumentos solo un id_producto y cantidad, creo que seria mejor manejar un array de objetos producto, que tuvieran como propiedades el id del producto y la cantidad solicitada, ya que si por ejemplo llega un cliente grande y necesita mas de un producto, y no pudiera cubrir la cantidad solicitada, por cada producto tendr?as que solicitar una autorizaci?n.
 
 	 *
 	 * @param descripcion string Justificacin del porqu la solicitud del producto.
 	 * @param productos json Json que contendra los ids de los productos con sus respectivas cantidades.
 	 **/
  static function ProductoSolicitar
	(
		$descripcion, 
		$productos
	);  
  
  
	
  
	/**
 	 *
 	 *Solicitud para devolver una venta. La fecha de petici?n se tomar? del servidor. El usuario y la sucursal que emiten la autorizaci?n ser?n tomadas de la sesi?n.
 	 *
 	 * @param descripcion string Justificacin de la devolucin de la compra
 	 * @param id_venta int Id de la venta a devolver
 	 * @return id_autorizacion int El id de la nueva autorizacion 
 	 **/
  static function DevolucionVenta
	(
		$descripcion, 
		$id_venta
	);  
  
  
	
  }
