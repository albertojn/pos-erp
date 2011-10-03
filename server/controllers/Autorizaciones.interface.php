<?php
/**
  *
  *
  *
  **/

  interaface IAutorizaciones {
  
  
	/**
 	 *
 	 *La fecha de peticion se tomar� del servidor. El usuario y la sucursal que emiten la autorizaci�n ser�n tomadas de la sesi�n.
 	 *
 	 **/
	protected function Gasto();  
  
  
  
  
	/**
 	 *
 	 *Solicitud para cambiar alg�n dato de un cliente. La fecha de petici�n se tomar� del servidor. El usuario y la sucursal que emiten la autorizaci�n ser�n tomadas de la sesi�n.
<br><br>
La autorizacion se guardara con los datos del usuario que la pidio. Si es aceptada, entonces el usuario podra editar al cliente una vez.
 	 *
 	 **/
	protected function EditarCliente();  
  
  
  
  
	/**
 	 *
 	 *Solicitud para devolver una compra. La fecha de petici�n se tomar� del servidor. El usuario y la sucursal que emiten la autorizaci�n ser�n tomadas de la sesi�n.
 	 *
 	 **/
	protected function DevolucionCompra();  
  
  
  
  
	/**
 	 *
 	 *Solicitud para devolver una venta. La fecha de petici�n se tomar� del servidor. El usuario y la sucursal que emiten la autorizaci�n ser�n tomadas de la sesi�n.
 	 *
 	 **/
	protected function DevolucionVenta();  
  
  
  
  
	/**
 	 *
 	 *Solicitud para cambiar la relaci�n entre cliente y el precio ofrecido para cierto producto ya sea en compra o en venta. La fecha de peticion se tomar� del servidor. El usuario y la sucursal que emiten la autorizaci�n ser�n tomadas de la sesi�n.

<br/><br/><b>UPDATE :</b> Actualmente como se maneja esto es por medio de las ventas preferenciales, es decir, se manda una autorizaci�n para que el cajero pueda editar todos los precios que desee, de todos los productos "solo para esa venta y solo para ese cliente especificamente", ya que si el cliente quisiera que le vendieran mas de un solo producto a diferente precio tendr�as que generar mas de una autorizaci�n, esto implica un incremento considerable en el tiempo de respuesta y aplicaci�n de los cambios.

<br/><br/><b>UPDATE 2:</b> Creo que los metodos : 
<br/><i><b>api/autorizaciones/editar_precio_cliente</b></i> y <i><b>api/autorizaciones/editar_siguiente_compra_venta_precio_cliente</b></i>
<br/>Se podr�an combinar y as� tener un solo m�todo para una compra venta preferencial.
 	 *
 	 **/
	protected function Editar_precio_cliente();  
  
  
  
  
	/**
 	 *
 	 *Muestra la lista de autorizaciones, con la opci�n de filtrar por pendientes, aceptadas, rechazadas, en tr�nsito, embarques recibidos y de ordenar seg�n los atributos de autorizaciones. 
<br/><br/><b>Update : </b> falta definir el ejemplo de envio.
 	 *
 	 **/
	protected function Lista();  
  
  
  
  
	/**
 	 *
 	 *Responde a una autorizaci�n en estado pendiente. Este m�todo no se puede aplicar a una autorizaci�n ya resuelta.
 	 *
 	 **/
	protected function Responder();  
  
  
  
  
	/**
 	 *
 	 *Solicitud de un producto, la fecha de peticion se tomar� del servidor. El usuario y la sucursal que emiten la autorizaci�n ser�n tomadas de la sesi�n.
<br/><br/><b>Update : </b> Me parece que no es buena idea manejar en los argumentos solo un id_producto y cantidad, creo que seria mejor manejar un array de objetos producto, que tuvieran como propiedades el id del producto y la cantidad solicitada, ya que si por ejemplo llega un cliente grande y necesita mas de un producto, y no pudiera cubrir la cantidad solicitada, por cada producto tendr�as que solicitar una autorizaci�n.
 
 	 *
 	 **/
	protected function Solicitar_producto();  
  
  
  
  
	/**
 	 *
 	 *Muestra la informacion detallada de una autorizacion.
 	 *
 	 **/
	protected function Detalle();  
  
  
  
  
	/**
 	 *
 	 *Editar una autorizacion en caso de tener permiso.

<br/><br/><b>Update : </b> Creo que seriabuena idea que se definiera de una vez la estructura de las autorizaciones, ya que como se maneja actualemnte es de la siguiente manera : 

Digo que seria buena idea definir el formato de las autorizaciones para ir pensando en como en un futuro se van a mostrar en las interfaces, apartir de que se se crearan los formularios, actualmente se toma el campo <b>tipo</b> para de ahi saber que tipo de autorizacion es y crear un formulario de este tipo para desplegar los datos, y dependiendo del <b>tipo</b> se identifica que formato de JSON se espera que contenga el campo <b>parametros</b> .

<br/><br/>

Al momento de editar la autorizacion veo que aparentemente se podria editar el id_autorizacion, id_usuario, id_sucursal, peticion y estado, creo yo que no es prudente editar ninguno de estos campos ya que el mal uso de esta informacion puede da�ar gravemente la integridad del sistema.
 	 *
 	 **/
	protected function Editar();  
  
  
  
  }
