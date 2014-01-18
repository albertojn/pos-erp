<?php
/**
  *
  *
  *
  **/
	
  interface IEfectivo {
  
  
	/**
 	 *
 	 *Mostrar? un comparativo de valores entre las diferentes monedas con respecto a la moneda base, esto para ver si estan diferentes los valores y hacer una actualizacion de tipos de cambio.
 	 *
 	 **/
  static function MostrarEquivalenciasActualizar
	(
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informacion de un billete
 	 *
 	 * @param id_billete int Id del billete a editar
 	 * @param foto_billete string Url de la foto del billete
 	 * @param id_moneda int Id de la moneda a la que pertenece el billete
 	 * @param nombre string Nombre del billete, valor en texto, "cincuenta", "cien", etc
 	 * @param valor int Valor del billete
 	 **/
  static function EditarBillete
	(
		$id_billete, 
		$foto_billete = null, 
		$id_moneda = null, 
		$nombre = null, 
		$valor = null
	);  
  
  
	
  
	/**
 	 *
 	 *Desactiva un billete
 	 *
 	 * @param id_billete int Id del billete a desactivar
 	 **/
  static function EliminarBillete
	(
		$id_billete
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los billetes de una instancia
 	 *
 	 * @param activo bool Si este valor no es obtenido, se listaran tanto activos como inactivos, si es verdadero, se listaran solo los activos, si es falso, se listaran solo los inactivos
 	 * @param ordenar string Nombre de la columan por el cual se ordenara la lista
 	 * @return billetes json Lista de billetes
 	 **/
  static function ListaBillete
	(
		$activo = null, 
		$ordenar = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea un nuevo billete, se puede utilizar para monedas tambien.
 	 *
 	 * @param id_moneda int Id de la moneda a la que pertence el billete
 	 * @param nombre string Nombre del billete, puede ser el valor en texto, "cincuenta", "cien", etc.
 	 * @param valor int Valor del billete
 	 * @param foto_billete string Url de la foto del billete
 	 * @return id_billete int Id del billete autogenerado
 	 **/
  static function NuevoBillete
	(
		$id_moneda, 
		$nombre, 
		$valor, 
		$foto_billete = null
	);  
  
  
	
  
	/**
 	 *
 	 *Actualizar? los tipo de cambio con respecto a la moneda base de la empresa.
 	 *
 	 * @param id_empresa int El id de la empresa
 	 * @param monedas json Los valores de las equivalencias de las monedas activas con respecto a la moneda base
 	 * @param moneda_base string El codigo de la moneda base, una cadena de tres caracteres: "MXN"
 	 * @param servicios string El servicio de donde se van a actualizar los valores que el usuario introdujo
 	 **/
  static function ActualizarTiposCambio
	(
		$id_empresa, 
		$monedas, 
		$moneda_base, 
		$servicios
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informacion de una moneda
 	 *
 	 * @param id_moneda int Id de la moneda a editar
 	 * @param activa bool Si se va a activar/desactivar
 	 * @param nombre string Nombre de la moneda
 	 * @param simbolo string Simbolo de la moneda
 	 **/
  static function EditarMoneda
	(
		$id_moneda, 
		$activa = null, 
		$nombre = null, 
		$simbolo = null
	);  
  
  
	
  
	/**
 	 *
 	 *Desactiva una moneda
 	 *
 	 * @param id_moneda int Id de la moneda a desactivar
 	 **/
  static function EliminarMoneda
	(
		$id_moneda
	);  
  
  
	
  
	/**
 	 *
 	 *Regresar? la equivalencia de esa moneda con respecto a la moneda base de la empresa que se le indique.
 	 *
 	 * @param id_empresa int El id de la empresa
 	 * @param id_moneda int El id de la moneda a la que se le desea sacar la equivalencia
 	 **/
  static function ObtenerEquivalenciaMoneda
	(
		$id_empresa, 
		$id_moneda
	);  
  
  
	
  
	/**
 	 *
 	 *Lista las monedas de una instancia
 	 *
 	 * @param activo bool Si este valor no es recibido, se listaran tanto activos como inactivos, si es verdadero, se listaran solo los activos, si es falso, se listaran solo los inactivos.
 	 * @param orden string Nombre de la columan por el cual se ordenara la lista
 	 * @return monedas json Lista de monedas
 	 **/
  static function ListaMoneda
	(
		$activo = null, 
		$orden = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea una moneda, "pesos", "dolares", etc.
 	 *
 	 * @param nombre string Nombre de la moneda
 	 * @param simbolo string Simbolo de la moneda
 	 * @return id_moneda int Id de la moneda recien creada
 	 **/
  static function NuevaMoneda
	(
		$nombre, 
		$simbolo
	);  
  
  
	
  
	/**
 	 *
 	 *Realizar? una consulta a la BD ?pos? en la tabla tipos_cambio y regresar? las equivalencias de la moneda base con respecto a las monedas activas en esa instancia.
 	 *
 	 * @param id_moneda_base int El id de la moneda a la que se le desea sacar las equivalencias de tipo de cambio
 	 **/
  static function ObtenerEquivalenciasServicio
	(
		$id_moneda_base
	);  
  
  
	
  }
