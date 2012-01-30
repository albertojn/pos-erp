<?php
/**
  *
  *
  *
  **/
	
  interface IClientes {
  
  
	/**
 	 *
 	 *Busca un cliente por su razon social, denominacion comercial, rfc o representante legal y regresa un objeto que contiene un conjunto de objetos que contiene la informacion de los clientes que coincidieron con la busqueda
 	 *
 	 * @param limit int Indica el registro final del conjunto de datos que se desea mostrar
 	 * @param page int Indica en que pagina se encuentra dentro del conjunto de resultados que coincidieron en la bsqueda
 	 * @param query string El texto a buscar
 	 * @param start int Indica el registro inicial del conjunto de datos que se desea mostrar
 	 * @return numero_de_resultados int Numero de registros que regreso esta busqueda
 	 * @return resultados json Lista de clientes que clientes que satisfacen la busqueda
 	 **/
  static function Buscar
	(
		$limit = 50, 
		$page = null, 
		$query = null, 
		$start = 0
	);  
  
  
	
  
	/**
 	 *
 	 *Busca una clasificaci?n por clave, nombre o descripci?n
 	 *
 	 * @param limit int Indica el registro final del conjunto de datos que se desea mostrar
 	 * @param page int Indica en que pagina se encuentra dentro del conjunto de resultados que coincidieron en la bsqueda
 	 * @param query string El texto a buscar
 	 * @param start int Indica el registro inicial del conjunto de datos que se desea mostrar
 	 * @return numero_de_resultados int 
 	 * @return resultados json Objeto que contendra la lista de clasificaciones de cliente
 	 **/
  static function BuscarClasificacion
	(
		$limit = 50, 
		$page = null, 
		$query = null, 
		$start = 0
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informacion de la clasificacion de cliente
 	 *
 	 * @param id_clasificacion_cliente int Id de la clasificacion del cliente a modificar
 	 * @param clave_interna string Clave interna de la clasificacion
 	 * @param descripcion string Descripcion larga de la clasificacion
 	 * @param nombre string Nombre de la clasificacion
 	 **/
  static function EditarClasificacion
	(
		$id_clasificacion_cliente, 
		$clave_interna = null, 
		$descripcion = null, 
		$nombre = null
	);  
  
  
	
  
	/**
 	 *
 	 *Los cliente forzosamente pertenecen a una categoria. En base a esta categoria se calcula el precio que se le dara en una venta, o el descuento, o el credito.
 	 *
 	 * @param clave_interna string Una clave interna para darle a este tipo de clientes. Y buscarlos de manera mas rapida.
 	 * @param nombre string Nombre de la clasificacion
 	 * @param descripcion string Una descripcion para este tipo de cliente
 	 * @return id_categoria_cliente int El id para esta nueva categoria de cliente.
 	 **/
  static function NuevaClasificacion
	(
		$clave_interna, 
		$nombre, 
		$descripcion = null
	);  
  
  
	
  
	/**
 	 *
 	 *Obtener los detalles de un cliente.
 	 *
 	 * @param id_cliente int Id del cliente del cual se listarn sus datos.
 	 * @return cliente json Arreglo que contendr la informacin del cliente. 
 	 **/
  static function Detalle
	(
		$id_cliente
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informaci?n de un cliente. Se diferenc?a del m?todo editar_perfil en qu? est? m?todo modifica informaci?n m?s sensible del cliente. El campo fecha_ultima_modificacion ser? llenado con la fecha actual del servidor. El campo Usuario_ultima_modificacion ser? llenado con la informaci?n de la sesi?n activa.

Si no se envia alguno de los datos opcionales del cliente. Entonces se quedaran los datos que ya tiene.
 	 *
 	 * @param id_cliente int Id del cliente a modificar.
 	 * @param clasificacion_cliente int La clasificacin del cliente.
 	 * @param codigo_cliente string Codigo interno del cliente
 	 * @param cuenta_de_mensajeria string Este parmetro se vuelve obligatorio si el parmetro Mensajera es true. Especifica la cuenta de mensajera y paquetera del cliente.
 	 * @param curp string CURP del cliente.
 	 * @param denominacion_comercial string Nombre comercial del cliente.
 	 * @param descuento_general float Descuento que se le dara al usuario
 	 * @param direccion_web string Direccin web del cliente.
 	 * @param email string E-mail del cliente.
 	 * @param id_tarifa_compra int Id de la tarifa de compra por default que se le asiganara a este cliente
 	 * @param id_tarifa_venta int Id de la tarifa de venta por default que se le asiganara a este cliente
 	 * @param limite_de_credito float Valor asignado al lmite del crdito para este cliente.
 	 * @param mensajeria bool Si el cliente cuenta con un cliente de mensajera y paquetera.
 	 * @param moneda_del_cliente string Moneda que maneja el cliente
 	 * @param password string Password del cliente
 	 * @param password_actual string En caso de enviar el parametro `password` con una contrasena. Se debera enviar `password_anterior` con la contrasena actual del sistema. Esto para evitar que si alguien consiguie acceso a un auth_token valido, pueda cambiar la contrasena de la cuenta por si mismo.
 	 * @param razon_social string Nombre o razon social del cliente.
 	 * @param representante_legal string Nombre del representante legal del cliente.
 	 * @param rfc string RFC del cliente.
 	 * @param sucursal int Si se desea cambiar al cliente de sucursal, se pasa el id de la nueva sucursal.
 	 * @param telefono1 string Telefono del cliente
 	 * @param telefono_personal2 string Telefono personal del cliente
 	 **/
  static function Editar
	(
		$id_cliente, 
		$clasificacion_cliente = null, 
		$codigo_cliente = null, 
		$cuenta_de_mensajeria = null, 
		$curp = null, 
		$denominacion_comercial = null, 
		$descuento_general = null, 
		$direccion_web = null, 
		$email = null, 
		$id_tarifa_compra = null, 
		$id_tarifa_venta = null, 
		$limite_de_credito = null, 
		$mensajeria = null, 
		$moneda_del_cliente = null, 
		$password = null, 
		$password_actual = null, 
		$razon_social = null, 
		$representante_legal = null, 
		$rfc = null, 
		$sucursal = null, 
		$telefono1 = null, 
		$telefono_personal2 = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea un nuevo cliente en el sistema.

Al crear un cliente en el sistema tambi?n creara un usuario para la interfaz de cliente, en caso de especificar un email se enviara un correo con los datos de acceso para la interfaz de clientes.
 	 *
 	 * @param razon_social string Se refiere al nombre con la que est registrada la empresa o cooperativa en el Registro Mercantil o bien el nombre del cliente en caso de no estar registrado.
 	 * @param clasificacion_cliente int Id de la clasificacion del cliente.
 	 * @param cuenta_de_mensajeria string Cuenta de mensajera del cliente
 	 * @param curp string CURP del cliente.
 	 * @param denominacion_comercial string Se refiere al nombre con que se conoce comercialmente a la empresa. 
 	 * @param direcciones json [{    "tipo": 1,    "calle": "Francisco I Madero",    "numero_exterior": "1009A",    "numero_interior": 12,    "colonia": "centro",    "codigo_postal": "38000",    "telefono1": "4611223312",    "telefono2": "",    "email": "tortas.rosy@gmail.com",    "id_ciudad": 3,    "referencia": "El local naranja"}]
 	 * @param direccion_web string Direccin web del cliente.
 	 * @param email string E-mail del cliente
 	 * @param id_cliente_padre int Id del cliente padre al cual pertenece, en caso de querer construir una jerarquia de empresas
 	 * @param id_moneda int `id_moneda` del tipo de moneda que se usara para mostrarle al cliente.El `id_moneda` de la moneda default es 0, que corresponde al peso mexicano.
 	 * @param id_tarifa_compra int Id de la tarifa de compra por default para este cliente
 	 * @param id_tarifa_venta int Id de la tarifa de venta por default para este cliente
 	 * @param limite_credito float Limite de credito del usuario en la moneda base del sistema.
 	 * @param password string Password del cliente, si no se envia se le creara uno automaticamente.
 	 * @param representante_legal string Nombre del representante legal del cliente.
 	 * @param rfc string RFC del cliente.
 	 * @param telefono string Telefono del cliente
 	 * @return id_cliente int Id autogenerado del cliente que se insert
 	 **/
  static function Nuevo
	(
		$razon_social, 
		$clasificacion_cliente = "", 
		$cuenta_de_mensajeria = "", 
		$curp = null, 
		$denominacion_comercial = null, 
		$direcciones = null, 
		$direccion_web = "", 
		$email = null, 
		$id_cliente_padre = null, 
		$id_moneda = 0, 
		$id_tarifa_compra = null, 
		$id_tarifa_venta = null, 
		$limite_credito = 0, 
		$password = "", 
		$representante_legal = "", 
		$rfc = null, 
		$telefono = null
	);  
  
  
	
  }
