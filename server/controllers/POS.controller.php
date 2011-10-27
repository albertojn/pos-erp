<?php
require_once("interfaces/POS.interface.php");
/**
  *
  *
  * @author Alan Gonzalez <alan@caffeina.mx>
  **/
	
  class POSController implements IPOS{
  
  
	/**
 	 *
 	 *Si un perdidad de conectividad sucediera, es responsabilidad del cliente registrar las ventas o compras realizadas desde que se perdio conectividad. Cuando se restablezca la conexcion se deberan enviar las ventas o compras. 
 	 *
 	 * @param compras json Objeto que contendr la informacin de las compras as como su detalle.
 	 * @param ventas json Objeto que contendr la informacin de las ventas as como su detalle.
 	 * @return id_compras json Arreglo de ids generados por las inserciones de compras si las hay
 	 * @return id_ventas json Arreglo de ids generados por las inserciones de ventas si las hay
 	 **/
	public static function EnviarOffline
	(
		$compras = null, 
		$ventas = null
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Gerenra y /o valida un hash
 	 *
 	 **/
	public static function Hash
	(
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Cuando un cliente pierde comunicacion se lanzan peticiones a intervalos pequenos de tiempo para revisar conectividad. Esos requests deberan hacerse a este metodo para que el servidor se de cuenta de que el cliente perdio conectvidad y tome medidas aparte como llenar estadistica de conectividad, ademas esto asegurara que el cliente puede enviar cambios ( compras, ventas, nuevos clientes ) de regreso al servidor. 
 	 *
 	 **/
	public static function Probar_conexion
	(
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Si el cliente lo desea puede respaldar toda su informacion personal. Esto descargara la base de datos y los documentos que se generan automaticamente como las facturas. Para descargar la base de datos debe tenerse un grupo de 0 o bien el permiso correspondiente.
 	 *
 	 **/
	public static function RespaldarBd
	(
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Revisar la version que esta actualmente en el servidor. 
 	 *
 	 **/
	public static function Check_current_client_versionClient
	(
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Descargar un zip con la ultima version del cliente.
 	 *
 	 **/
	public static function DownloadClient
	(
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Metodo que elimina todos los registros en la base de datos, especialmente util para hacer pruebas unitarias. Este metodo NO estara disponible al publico.
 	 *
 	 **/
	public static function DropBd
	(
	)
	{  

  		$sql = "TRUNCATE TABLE `rol`;";
		
		global $conn;

		$rs = $conn->Execute($sql);

	}
  }
