<?php
/**
  *
  *
  *
  **/
	
  interface IPersonalYAgentes {
  
  
	/**
 	 *
 	 *Muestra los detalles de un Rol especifico
 	 *
 	 * @param id_rol int Id del rol
 	 * @return detalles json objeto con los detalles del rol
 	 * @return perfil json objeto con la descripcion del perfil
 	 **/
  static function DetallesRol
	(
		$id_rol
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informacion de un grupo, puede usarse para editar los permisos del mismo
 	 *
 	 * @param id_rol int Id del rol a editar
 	 * @param descripcion string Descripcion larga del grupo
 	 * @param id_perfil int Id del perfil de usuario en el sistema
 	 * @param id_rol_padre int Id del rol padre
 	 * @param id_tarifa_compra int Id de la tarifa de compora por default que aplicara a los usuarios de este rol. Si un usuario tiene otra tarifa de compra, no sera sobreescrita
 	 * @param id_tarifa_venta int Id de la tarifa de venta por default que aplicara a los usuarios de este rol . Si un usuario ya tiene otra tarifa de venta, no sera sobreescrita.
 	 * @param nombre string Nombre del grupo
 	 * @param salario float Salario base para este rol
 	 **/
  static function EditarRol
	(
		$id_rol, 
		$descripcion = null, 
		$id_perfil = null, 
		$id_rol_padre = null, 
		$id_tarifa_compra = null, 
		$id_tarifa_venta = null, 
		$nombre = null, 
		$salario = "0"
	);  
  
  
	
  
	/**
 	 *
 	 *Este m?todo desactiva un rol, solo se podr? desactivar un rol si no hay ning?n usuario que pertenezca a ?l.
 	 *
 	 * @param id_rol int Id del rol a eliminar
 	 **/
  static function EliminarRol
	(
		$id_rol
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los roles, se puede filtrar y ordenar por sus atributos
 	 *
 	 * @param activa bool Verdadero para mostrar solo los roles activos. En caso de false, se mostraran ambas.
 	 * @param limit string Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
 	 * @param order string Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
 	 * @param order_by string Indica por que campo se ordenan los resultados.
 	 * @param query string Valor que se buscara en la consulta
 	 * @param start string Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
 	 * @return resultados json Arreglo de objetos que contendr las empresas de la instancia
 	 * @return numero_de_resultados int Numero de resultados obtenidos
 	 **/
  static function ListaRol
	(
		$activa =  false , 
		$limit = null, 
		$order = null, 
		$order_by = null, 
		$query = null, 
		$start = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea un nuevo grupo de usuarios. Se asignaran los permisos de este grupo al momento de su creacion.
 	 *
 	 * @param nombre string Nombre del grupo. Este no puede existir en el sistema, no puede ser una cadena vacia y no puede ser mayor a 30 caracteres.
 	 * @param descripcion string Descripcion larga del grupo. La descripcion no puede ser una cadena vacia ni mayor a 256 caracteres.
 	 * @param id_perfil int Id del perfil de usuario en el sistema
 	 * @param id_rol_padre int Id del rol padre
 	 * @param id_tarifa_compra int Id de la tarifa de compra por default que aplicara a los usuario de este rol
 	 * @param id_tarifa_venta int Id de la tarifa de venta por default que aplicara a los suarios de este rol
 	 * @param salario float El salario de este rol.
 	 * @return id_rol int El nuero id del rol que se ha generado.
 	 **/
  static function NuevoRol
	(
		$nombre, 
		$descripcion = null, 
		$id_perfil = null, 
		$id_rol_padre = null, 
		$id_tarifa_compra = null, 
		$id_tarifa_venta = null, 
		$salario = "0"
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo asigna permisos a un rol. Cada vez que se llame a este metodo, se asignaran estos permisos a los usuarios que pertenezcan a este rol.
 	 *
 	 * @param id_permiso int Arreglo de ids de los permisos que seran asignados al rol
 	 * @param id_rol int Id del rol al que se le asignaran los permisos
 	 **/
  static function AsignarPermisoRol
	(
		$id_permiso, 
		$id_rol
	);  
  
  
	
  
	/**
 	 *
 	 *Regresa un alista de permisos, nombres y ids de los permisos del sistema.
 	 *
 	 * @param id_permiso int Se listaran los roles que tienen este permiso
 	 * @param id_rol int Se listaran los permisos de este rol
 	 * @return permisos_roles json lista de permisos
 	 **/
  static function ListaPermisoRol
	(
		$id_permiso = null, 
		$id_rol = null
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo quita un permiso de un rol. Al remover este permiso de un rol, los permisos que un usuario especifico tiene gracias a una asignacion especial se mantienen. 
 	 *
 	 * @param id_permiso int Id del permiso a remover
 	 * @param id_rol int Id del rol al que se le quitaran los permisos
 	 **/
  static function RemoverPermisoRol
	(
		$id_permiso, 
		$id_rol
	);  
  
  
	
  
	/**
 	 *
 	 *Editar los detalles de un usuario.
 	 *
 	 * @param id_usuario int Usuario a editar
 	 * @param codigo_usuario string Codigo interno del usuario
 	 * @param comision_ventas float El porcentaje que gana como comision por ventas este usuario
 	 * @param correo_electronico string correo electronico del usuario
 	 * @param cuenta_bancaria string Cuenta bancaria del usuario
 	 * @param cuenta_mensajeria string Cuenta de mensajeria del usuario
 	 * @param curp string CURP del usuario
 	 * @param denominacion_comercial string Denominacion comercial del cliente
 	 * @param descuento float Descuento que se le hara al usuario al venderle
 	 * @param descuento_es_porcentaje bool Si el descuento es un porcentaje o es un valor fijo
 	 * @param dias_de_credito int Dias de credito del cliente
 	 * @param dias_de_embarque int Dias de emabrque del proveedor ( Lunes, Miercoles, etc)
 	 * @param dia_de_pago string Fecha de pago del cliente
 	 * @param dia_de_revision string Fecha de revision del cliente
 	 * @param direcciones json [{    
"tipo": 1,
    "calle": "Francisco I Madero",
    "numero_exterior": "1009A",
    "numero_interior": 12,
    "colonia": "centro",
    "codigo_postal": "38000",
    "telefono1": "4611223312",
    "telefono2": "",
       "id_ciudad": 3,
    "referencia": "El local naranja"
}] 
 	 * @param facturar_a_terceros bool Si el usuario puede facturar a terceros
 	 * @param id_clasificacion_cliente int Id de la clasificacion del cliente
 	 * @param id_clasificacion_proveedor int Id de la clasificacion del proveedor
 	 * @param id_moneda int Id de la moneda preferente del usuario
 	 * @param id_rol int Id rol del usuario
 	 * @param id_sucursal int Id de la sucursal en la que fue creada este usuario o donde labora.
 	 * @param id_tarifa_compra int Id de la tarifa de compra por default que aplicara a este usuario.
 	 * @param id_tarifa_venta int Id de la tarifa de venta por default que aplicara a este usuario
 	 * @param id_usuario_padre int Id del usuario padre de este usuario
 	 * @param impuestos json Objeto que contendra los ids de los impuestos que afectan a este usuario
 	 * @param intereses_moratorios float Intereses moratorios del cliente
 	 * @param limite_de_credito float Limite de credito del usuario
 	 * @param mensajeria bool Si el usuario tiene una cuenta de mensajeria
 	 * @param nombre string Nombre del usuario
 	 * @param pagina_web string Pagina web del usuario
 	 * @param password string Password del usuario
 	 * @param representante_legal string Nombre del representante legal del usuario
 	 * @param retenciones json Ids de las retenciones que afectan a este usuario
 	 * @param rfc string RFC del usuario
 	 * @param salario float Si el usuario contara con un salario no establecido por el rol
 	 * @param saldo_del_ejercicio float Saldo del ejercicio del cliente
 	 * @param telefono_personal_1 string telefono personal del usuario
 	 * @param telefono_personal_2 string Telefono personal alterno del usuario
 	 * @param tiempo_entrega int Numero de dias que tarda el proveedor en realizar una entrega
 	 * @param ventas_a_credito int Ventas a credito del cliente
 	 **/
  static function EditarUsuario
	(
		$id_usuario, 
		$codigo_usuario = null, 
		$comision_ventas = null, 
		$correo_electronico = null, 
		$cuenta_bancaria = null, 
		$cuenta_mensajeria = null, 
		$curp = null, 
		$denominacion_comercial = null, 
		$descuento = null, 
		$descuento_es_porcentaje = null, 
		$dias_de_credito = null, 
		$dias_de_embarque = null, 
		$dia_de_pago = null, 
		$dia_de_revision = null, 
		$direcciones = null, 
		$facturar_a_terceros = null, 
		$id_clasificacion_cliente = null, 
		$id_clasificacion_proveedor = null, 
		$id_moneda = null, 
		$id_rol = null, 
		$id_sucursal = null, 
		$id_tarifa_compra = null, 
		$id_tarifa_venta = null, 
		$id_usuario_padre = null, 
		$impuestos = null, 
		$intereses_moratorios = null, 
		$limite_de_credito = null, 
		$mensajeria = null, 
		$nombre = null, 
		$pagina_web = null, 
		$password = null, 
		$representante_legal = null, 
		$retenciones = null, 
		$rfc = null, 
		$salario = null, 
		$saldo_del_ejercicio = null, 
		$telefono_personal_1 = null, 
		$telefono_personal_2 = null, 
		$tiempo_entrega = null, 
		$ventas_a_credito = null
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo desactiva un usuario, usese cuando un empleado ya no trabaje para usted. Que pasa cuando el usuario tiene cuentas abiertas o ventas a credito con saldo.
 	 *
 	 * @param id_usuario int Id del usuario a eliminar
 	 **/
  static function EliminarUsuario
	(
		$id_usuario
	);  
  
  
	
  
	/**
 	 *
 	 *Listar a todos los usuarios del sistema. Se puede ordenar por los atributos del usuario y filtrar en activos e inactivos
 	 *
 	 * @param activo bool True si se mostrarn solo los usuarios activos, false si solo se mostrarn los usuarios inactivos
 	 * @param ordenar string Nombre de la columna por la cual se editara la lista
 	 * @return usuarios json Arreglo de objetos que contendrá la información de los usuarios del sistema
 	 **/
  static function ListaUsuario
	(
		$activo = null, 
		$ordenar = null
	);  
  
  
	
  
	/**
 	 *
 	 *Insertar un nuevo usuario. El usuario que lo crea sera tomado de la sesion actual y la fecha sera tomada del servidor. Un usuario no puede tener mas de un rol en una misma sucursal de una misma empresa.
 	 *
 	 * @param codigo_usuario string Codigo interno del usuario
 	 * @param id_rol int El rol que este usuario tomara en el sistema. 
 	 * @param nombre string Nombre del nuevo usuario.
 	 * @param password string Password del usuario. Debe ser mayor a 4 caracteres y no puede ser el mismo que el codigo de usuario.
 	 * @param comision_ventas float El porcentaje de la comision que ganara este usuario especificamente por ventas
 	 * @param correo_electronico string Correo Electronico del agente
 	 * @param cuenta_bancaria string Cuenta bancaria del usuario
 	 * @param cuenta_mensajeria string Cuenta de mensajeria del usuario
 	 * @param curp string CURP del agente
 	 * @param denominacion_comercial string Denominacion comercial del cliente
 	 * @param descuento float El porcentaje de descuento que se le hara al usuario al venderle
 	 * @param dias_de_credito int Dias de credito del cliente
 	 * @param dias_de_embarque int Dias de embarque del proveedor ( Lunes, Miercoles, Viernes, etc)
 	 * @param dia_de_pago string Fecha de pago del cliente
 	 * @param dia_de_revision string Fecha de revision del cliente
 	 * @param direcciones json Arreglo de direcciones del usuario [{    
"tipo": 1,
    "calle": "Francisco I Madero",
    "numero_exterior": "1009A",
    "numero_interior": 12,
    "colonia": "centro",
    "codigo_postal": "38000",
    "telefono1": "4611223312",
    "telefono2": "",
       "id_ciudad": 3,
    "referencia": "El local naranja"
}]
 	 * @param facturar_a_terceros bool Si el usuario puede facturar a terceros
 	 * @param id_clasificacion_cliente int Id de la clasificacion del cliente
 	 * @param id_clasificacion_proveedor int Id de la clasificacion del proveedor
 	 * @param id_moneda int Id de la moneda del cliente
 	 * @param id_sucursal int Id de la sucursal a la que se quiere relacionar un usuario. Es decir, cual es su sucursal matriz. De omitirse se dejara nulo.
 	 * @param id_tarifa_compra int Id de la tarifa de compra por default que se aplicara a este usuario
 	 * @param id_tarifa_venta int Id de la tarifa de venta por default que se aplicara a este usuario
 	 * @param id_usuario_padre int Id del usuario padre del usuario
 	 * @param impuestos json Objeto que contendra los impuestos que afectan a este usuario
 	 * @param intereses_moratorios float Intereses moratorios del cliente
 	 * @param limite_credito float El limite de credito del usuario
 	 * @param mensajeria bool Si el cliente tiene una cuenta de mensajeria
 	 * @param pagina_web string Pagina web del usuario
 	 * @param representante_legal string Nombre del representante legal del usuario
 	 * @param retenciones json Ids de las retenciones que afectan a este usuario
 	 * @param rfc string RFC del agente
 	 * @param salario float Si el usuario contara con un salario especial no especificado por el rol
 	 * @param saldo_del_ejercicio float Saldo del ejercicio del cliente
 	 * @param telefono_personal1 string Telefono personal del usuario
 	 * @param telefono_personal2 string Telefono personal del usuario
 	 * @param tiempo_entrega int Numero de dias que tarda el proveedor en realizar una entrega
 	 * @param ventas_a_credito int Ventas a credito del cliente
 	 * @return id_usuario int El nuevo identificador de este usuario.
 	 **/
  static function NuevoUsuario
	(
		$codigo_usuario, 
		$id_rol, 
		$nombre, 
		$password, 
		$comision_ventas = "0", 
		$correo_electronico = null, 
		$cuenta_bancaria = null, 
		$cuenta_mensajeria = null, 
		$curp = null, 
		$denominacion_comercial = null, 
		$descuento = null, 
		$dias_de_credito = null, 
		$dias_de_embarque = null, 
		$dia_de_pago = null, 
		$dia_de_revision = null, 
		$direcciones = null, 
		$facturar_a_terceros = null, 
		$id_clasificacion_cliente = null, 
		$id_clasificacion_proveedor = null, 
		$id_moneda = null, 
		$id_sucursal = null, 
		$id_tarifa_compra = null, 
		$id_tarifa_venta = null, 
		$id_usuario_padre = null, 
		$impuestos = null, 
		$intereses_moratorios = null, 
		$limite_credito = "0", 
		$mensajeria = null, 
		$pagina_web = null, 
		$representante_legal = null, 
		$retenciones = null, 
		$rfc = null, 
		$salario = null, 
		$saldo_del_ejercicio = null, 
		$telefono_personal1 = null, 
		$telefono_personal2 = null, 
		$tiempo_entrega = null, 
		$ventas_a_credito = null
	);  
  
  
	
  
	/**
 	 *
 	 *Asigna uno o varios permisos especificos a un usuario. No se pueden asignar permisos que ya se tienen
 	 *
 	 * @param id_permiso int Id del permiso que se le asignaran a este usuario en especial
 	 * @param id_usuario int Id del usuario al que se le asignara el permiso
 	 **/
  static function AsignarPermisoUsuario
	(
		$id_permiso, 
		$id_usuario
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los permisos con los usuarios asigandos. Puede filtrarse por id_usuario o id_rol
 	 *
 	 * @param id_permiso int Se listaran los usuarios con este permiso
 	 * @param id_usuario int Se listaran los permisos de este usuario
 	 * @return permisos_usuario json Lista de usuarios con sus permisos
 	 **/
  static function ListaPermisoUsuario
	(
		$id_permiso = null, 
		$id_usuario = null
	);  
  
  
	
  
	/**
 	 *
 	 *Quita uno o varios permisos a un usuario. No se puede negar un permiso que no se tiene
 	 *
 	 * @param id_permiso int Id del permiso a quitar de este usuario
 	 * @param id_usuario int Id del usuario al que se le niegan los permisos
 	 **/
  static function RemoverPermisoUsuario
	(
		$id_permiso, 
		$id_usuario
	);  
  
  
	
  
	/**
 	 *
 	 *eviar un mail a esa persona para resetear su pass
 	 *
 	 * @param clave string 
 	 * @param email string 
 	 **/
  static function PasswordRecordarUsuario
	(
		$clave = "", 
		$email = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Crear un seguimiento de texto a este agente
 	 *
 	 * @param id_usuario int El id_usuario de a quien le haremos el seguimeinto
 	 * @param texto string El texto que ingresa el que realiza el seguimiento
 	 * @return id_usuario_seguimiento int 
 	 **/
  static function NuevoSeguimientoUsuario
	(
		$id_usuario, 
		$texto
	);  
  
  
	
  }
