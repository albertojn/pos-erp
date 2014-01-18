<?php
/**
  *
  *
  *
  **/
	
  interface IPOS {
  
  
	/**
 	 *
 	 *Borra en archivo especificado en el argumento a partir del id de instancia y del tiempo establecido

 	 *
 	 * @param id_instacia int Id de la instancia del archivo que se va a borrar
 	 * @param time int Tiempo del archivo que se va a borrar, en formato UNIX
 	 * @return status string Estado del proceso
 	 **/
  static function RespaldoBorrarBd
	(
		$id_instacia, 
		$time
	);  
  
  
	
  
	/**
 	 *
 	 *editar una columna dado su campo y tabla
 	 *
 	 * @param campo string 
 	 * @param tabla string 
 	 * @param caption string 
 	 * @param descripcion string 
 	 * @param longitud int 
 	 * @param obligatorio bool 
 	 * @param tipo enum "string","int","float","date","bool","contacto","enum","direccion"
 	 **/
  static function EditarColumnaBd
	(
		$campo, 
		$tabla, 
		$caption = "", 
		$descripcion = "", 
		$longitud = "", 
		$obligatorio = "", 
		$tipo = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Eliminar una columna extra
 	 *
 	 * @param campo string 
 	 * @param tabla string 
 	 **/
  static function EliminarColumnaBd
	(
		$campo, 
		$tabla
	);  
  
  
	
  
	/**
 	 *
 	 *No la agrega fisicamente a la BD pero fuera del API se puede asumir que si.
 	 *
 	 * @param campo string un id que identifique este campo. No puede haber 2 campos iguales para una misma tabla.
 	 * @param caption string El texto que se mostrara al pedir este campo.
 	 * @param obligatorio bool Si el campo es obligatorio para esta tabla.
 	 * @param tabla string La tabla padre. La tabla debe existir fisicamente salvo unas tablas que hemos creado para usted.
 	 * @param tipo enum "string","int","float","date","bool","contacto","enum","direccion"
 	 * @param descripcion string La descrpcion de ayuda para este campo.
 	 * @param longitud int 
 	 * @return id_extra_params_estructura int El id de esta estructura
 	 **/
  static function NuevaColumnaBd
	(
		$campo, 
		$caption, 
		$obligatorio, 
		$tabla, 
		$tipo, 
		$descripcion = "", 
		$longitud = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Metodo que elimina todos los registros en la base de datos, especialmente util para hacer pruebas unitarias. Este metodo NO estara disponible al publico.
 	 *
 	 **/
  static function DropBd
	(
	);  
  
  
	
  
	/**
 	 *
 	 *Si el cliente lo desea puede respaldar toda su informacion personal. Esto descargara la base de datos y los documentos que se generan automaticamente como las facturas. Para descargar la base de datos debe tenerse un grupo de 0 o bien el permiso correspondiente.
 	 *
 	 **/
  static function RespaldarBd
	(
	);  
  
  
	
  
	/**
 	 *
 	 *Busca en el erp
 	 *
 	 * @param query string 
 	 * @return numero_de_resultados int 
 	 * @return resultados json 
 	 **/
  static function Buscar
	(
		$query
	);  
  
  
	
  
	/**
 	 *
 	 *Revisar la version que esta actualmente en el servidor. 
 	 *
 	 **/
  static function VersionClientCurrentCheckClient
	(
	);  
  
  
	
  
	/**
 	 *
 	 *Descargar un zip con la ultima version del cliente.
 	 *
 	 **/
  static function DownloadClient
	(
	);  
  
  
	
  
	/**
 	 *
 	 *Configura el numero de decimales que se usaran para ciertas operaciones del sistema, como precios de venta, costos, tipos de cambio, entre otros
 	 *
 	 * @param cambio int Tipos de Cambio
 	 * @param cantidades int Cantidades
 	 * @param costos int Costos y Precio de Compra
 	 * @param ventas int Precio de Venta
 	 * @return status string ok
 	 **/
  static function DecimalesConfiguracion
	(
		$cambio, 
		$cantidades, 
		$costos, 
		$ventas
	);  
  
  
	
  
	/**
 	 *
 	 *Detalles de un perfil espec?fico
 	 *
 	 * @param id_perfil int Id del perfil
 	 * @return detalles json Objeto con la descripción de los detalles del perfil
 	 **/
  static function DetallesPerfilConfiguracion
	(
		$id_perfil
	);  
  
  
	
  
	/**
 	 *
 	 *Edita un perfil de usuario.
 	 *
 	 * @param id_perfil int Id del perfil que se desea modificar
 	 * @param configuracion json configuración del perfil
 	 * @param descripcion string descripción del perfil
 	 **/
  static function EditarPerfilConfiguracion
	(
		$id_perfil, 
		$configuracion = "", 
		$descripcion = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Elimina u perfil
 	 *
 	 * @param id_perfil int Id del perfil a eliminar
 	 **/
  static function EliminarPerfilConfiguracion
	(
		$id_perfil
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los perfiles relacionadas con esta  empresa. Se puede filtrar por empresa, descripci?n, fecha de creaci?n, ordenar ascendente o descendentemente.
 	 *
 	 * @param activo bool True para mostrar solo los perfiles activos, false para mostrar todos.
 	 * @param limit string Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
 	 * @param order string Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
 	 * @param order_by string Indica por que campo se ordenan los resultados.
 	 * @param query string Valor que se buscara en la consulta
 	 * @param start string Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la bsqueda.
 	 * @return resultados json Array que contiene objetos con los detalles de los perfiles
 	 * @return numero_de_resultados int Numero de resultados encontrados
 	 **/
  static function ListaPerfilConfiguracion
	(
		$activo =  false , 
		$limit = null, 
		$order = null, 
		$order_by = null, 
		$query = null, 
		$start = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea un nuevo perfil de usuario.
 	 *
 	 * @param configuracion json Configuración del Perfil tomando como base la plantilla de de configuración
 	 * @param descripcion string Descripción del perfil
 	 * @return id_perfil int Id del perfil creado
 	 **/
  static function NuevoPerfilConfiguracion
	(
		$configuracion, 
		$descripcion
	);  
  
  
	
  
	/**
 	 *
 	 *Permite establecer si habra productos que mostrar al cliente y cuales propiedades de ellos.
 	 *
 	 * @param mostrar bool Si queremos que se muestren productos al cliente.
 	 * @param propiedades json Arreglo de strings con los campos de los productos que se mostraran al cliente.
 	 **/
  static function ClientesVistasConfiguracion
	(
		$mostrar, 
		$propiedades = null
	);  
  
  
	
  
	/**
 	 *
 	 *Gerenra y /o valida un hash
 	 *
 	 **/
  static function Hash
	(
	);  
  
  
	
  
	/**
 	 *
 	 *Dada una direccion IP, el path de la empresa y el numero de la lista de precios, obtiene todos los datos de los clientes y los productos de AdminPAQ y los reproduce en el POS.
 	 *
 	 * @param ip string La direccion IP de su servidor de AdminPAQ.
 	 * @param path string El path donde se encuentra el folder de la empresa en el servidor.
 	 * @param num_precio int Indica que precio de la lista se usara para los productos en el POS.
 	 **/
  static function AdminpaqImportar
	(
		$ip, 
		$path, 
		$num_precio =  1 
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo se utiliza para poder enviar un correo electronico a un tercero. 
 	 *
 	 * @param cuerpo string El cuerpo del correo electronico.
 	 * @param destinatario string El correo electronico a enviar.
 	 * @param titulo string El titulo del correo electronico. 
 	 * @param emisor string El correo electronico de donde se enviara este correo si es que esta configurado para esta instancia. De no enviarse se enviara un correo de la cuenta default de POS ERP.
 	 **/
  static function EnviarMail
	(
		$cuerpo, 
		$destinatario, 
		$titulo, 
		$emisor = "no-reply@caffeina.mx"
	);  
  
  
	
  
	/**
 	 *
 	 *Si un perdidad de conectividad sucediera, es responsabilidad del cliente registrar las ventas o compras realizadas desde que se perdio conectividad. Cuando se restablezca la conexcion se deberan enviar las ventas o compras. 
 	 *
 	 * @param compras json Objeto que contendr la informacin de las compras as como su detalle.
 	 * @param ventas json Objeto que contendr la informacin de las ventas as como su detalle.
 	 * @return id_ventas json Arreglo de ids generados por las inserciones de ventas si las hay
 	 * @return id_compras json Arreglo de ids generados por las inserciones de compras si las hay
 	 **/
  static function EnviarOffline
	(
		$compras = null, 
		$ventas = null
	);  
  
  
	
  
	/**
 	 *
 	 *Cuando un cliente pierde comunicacion se lanzan peticiones a intervalos pequenos de tiempo para revisar conectividad. Esos requests deberan hacerse a este metodo para que el servidor se de cuenta de que el cliente perdio conectvidad y tome medidas aparte como llenar estadistica de conectividad, ademas esto asegurara que el cliente puede enviar cambios ( compras, ventas, nuevos clientes ) de regreso al servidor. 
 	 *
 	 **/
  static function ConexionProbar
	(
	);  
  
  
	
  }
