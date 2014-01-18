<?php
/** VentaOrden Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link VentaOrden }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class VentaOrdenDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link VentaOrden} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$venta_orden )
	{
		if( ! is_null ( self::getByPK(  $venta_orden->getIdVenta() , $venta_orden->getIdOrdenDeServicio() ) ) )
		{
			try{ return VentaOrdenDAOBase::update( $venta_orden) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return VentaOrdenDAOBase::create( $venta_orden) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link VentaOrden} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link VentaOrden} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link VentaOrden Un objeto del tipo {@link VentaOrden}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_venta, $id_orden_de_servicio )
	{
		$sql = "SELECT * FROM venta_orden WHERE (id_venta = ? AND id_orden_de_servicio = ? ) LIMIT 1;";
		$params = array(  $id_venta, $id_orden_de_servicio );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new VentaOrden( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link VentaOrden}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link VentaOrden}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from venta_orden";
		if( ! is_null ( $orden ) )
		{ $sql .= " ORDER BY " . $orden . " " . $tipo_de_orden;	}
		if( ! is_null ( $pagina ) )
		{
			$sql .= " LIMIT " . (( $pagina - 1 )*$columnas_por_pagina) . "," . $columnas_por_pagina; 
		}
		global $conn;
		$rs = $conn->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
			$bar = new VentaOrden($foo);
    		array_push( $allData, $bar);
			//id_venta
			//id_orden_de_servicio
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link VentaOrden} de la base de datos. 
	  * Consiste en buscar todos los objetos que coinciden con las variables permanentes instanciadas de objeto pasado como argumento. 
	  * Aquellas variables que tienen valores NULL seran excluidos en busca de criterios.
	  *	
	  * <code>
	  *  /**
	  *   * Ejemplo de uso - buscar todos los clientes que tengan limite de credito igual a 20000
	  *   {@*} 
	  *	  $cliente = new Cliente();
	  *	  $cliente->setLimiteCredito("20000");
	  *	  $resultados = ClienteDAO::search($cliente);
	  *	  
	  *	  foreach($resultados as $c ){
	  *	  	echo $c->getNombre() . "<br>";
	  *	  }
	  * </code>
	  *	@static
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $venta_orden , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta_orden WHERE ("; 
		$val = array();
		if( ! is_null( $venta_orden->getIdVenta() ) ){
			$sql .= " `id_venta` = ? AND";
			array_push( $val, $venta_orden->getIdVenta() );
		}

		if( ! is_null( $venta_orden->getIdOrdenDeServicio() ) ){
			$sql .= " `id_orden_de_servicio` = ? AND";
			array_push( $val, $venta_orden->getIdOrdenDeServicio() );
		}

		if( ! is_null( $venta_orden->getPrecio() ) ){
			$sql .= " `precio` = ? AND";
			array_push( $val, $venta_orden->getPrecio() );
		}

		if( ! is_null( $venta_orden->getDescuento() ) ){
			$sql .= " `descuento` = ? AND";
			array_push( $val, $venta_orden->getDescuento() );
		}

		if( ! is_null( $venta_orden->getImpuesto() ) ){
			$sql .= " `impuesto` = ? AND";
			array_push( $val, $venta_orden->getImpuesto() );
		}

		if( ! is_null( $venta_orden->getRetencion() ) ){
			$sql .= " `retencion` = ? AND";
			array_push( $val, $venta_orden->getRetencion() );
		}

		if(sizeof($val) == 0){return self::getAll(/* $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' */);}
		$sql = substr($sql, 0, -3) . " )";
		if( ! is_null ( $orderBy ) ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
			$bar =  new VentaOrden($foo);
    		array_push( $ar,$bar);
		}
		return $ar;
	}


	/**
	  *	Actualizar registros.
	  *	
	  * Este metodo es un metodo de ayuda para uso interno. Se ejecutara todas las manipulaciones
	  * en la base de datos que estan dadas en el objeto pasado.No se haran consultas SELECT 
	  * aqui, sin embargo. El valor de retorno indica cuántas filas se vieron afectadas.
	  *	
	  * @internal private information for advanced developers only
	  * @return Filas afectadas o un string con la descripcion del error
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden a actualizar.
	  **/
	private static final function update( $venta_orden )
	{
		$sql = "UPDATE venta_orden SET  `precio` = ?, `descuento` = ?, `impuesto` = ?, `retencion` = ? WHERE  `id_venta` = ? AND `id_orden_de_servicio` = ?;";
		$params = array( 
			$venta_orden->getPrecio(), 
			$venta_orden->getDescuento(), 
			$venta_orden->getImpuesto(), 
			$venta_orden->getRetencion(), 
			$venta_orden->getIdVenta(),$venta_orden->getIdOrdenDeServicio(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto VentaOrden suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto VentaOrden dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden a crear.
	  **/
	private static final function create( &$venta_orden )
	{
		$sql = "INSERT INTO venta_orden ( `id_venta`, `id_orden_de_servicio`, `precio`, `descuento`, `impuesto`, `retencion` ) VALUES ( ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$venta_orden->getIdVenta(), 
			$venta_orden->getIdOrdenDeServicio(), 
			$venta_orden->getPrecio(), 
			$venta_orden->getDescuento(), 
			$venta_orden->getImpuesto(), 
			$venta_orden->getRetencion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */   /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link VentaOrden} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link VentaOrden}.
	  * 
	  * Aquellas variables que tienen valores NULL seran excluidos en la busqueda (los valores 0 y false no son tomados como NULL) .
	  * No es necesario ordenar los objetos criterio, asi como tambien es posible mezclar atributos.
	  * Si algun atributo solo esta especificado en solo uno de los objetos de criterio se buscara que los resultados conicidan exactamente en ese campo.
	  *	
	  * <code>
	  *  /**
	  *   * Ejemplo de uso - buscar todos los clientes que tengan limite de credito 
	  *   * mayor a 2000 y menor a 5000. Y que tengan un descuento del 50%.
	  *   {@*} 
	  *	  $cr1 = new Cliente();
	  *	  $cr1->setLimiteCredito("2000");
	  *	  $cr1->setDescuento("50");
	  *	  
	  *	  $cr2 = new Cliente();
	  *	  $cr2->setLimiteCredito("5000");
	  *	  $resultados = ClienteDAO::byRange($cr1, $cr2);
	  *	  
	  *	  foreach($resultados as $c ){
	  *	  	echo $c->getNombre() . "<br>";
	  *	  }
	  * </code>
	  *	@static
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $venta_ordenA , $venta_ordenB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta_orden WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $venta_ordenA->getIdVenta()) ) ) & ( ! is_null ( ($b = $venta_ordenB->getIdVenta()) ) ) ){
				$sql .= " `id_venta` >= ? AND `id_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_ordenA->getIdOrdenDeServicio()) ) ) & ( ! is_null ( ($b = $venta_ordenB->getIdOrdenDeServicio()) ) ) ){
				$sql .= " `id_orden_de_servicio` >= ? AND `id_orden_de_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_orden_de_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_ordenA->getPrecio()) ) ) & ( ! is_null ( ($b = $venta_ordenB->getPrecio()) ) ) ){
				$sql .= " `precio` >= ? AND `precio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `precio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_ordenA->getDescuento()) ) ) & ( ! is_null ( ($b = $venta_ordenB->getDescuento()) ) ) ){
				$sql .= " `descuento` >= ? AND `descuento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descuento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_ordenA->getImpuesto()) ) ) & ( ! is_null ( ($b = $venta_ordenB->getImpuesto()) ) ) ){
				$sql .= " `impuesto` >= ? AND `impuesto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `impuesto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_ordenA->getRetencion()) ) ) & ( ! is_null ( ($b = $venta_ordenB->getRetencion()) ) ) ){
				$sql .= " `retencion` >= ? AND `retencion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `retencion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		$sql = substr($sql, 0, -3) . " )";
		if( !is_null ( $orderBy ) ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
    		array_push( $ar, new VentaOrden($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto VentaOrden suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param VentaOrden [$venta_orden] El objeto de tipo VentaOrden a eliminar
	  **/
	public static final function delete( &$venta_orden )
	{
		if( is_null( self::getByPK($venta_orden->getIdVenta(), $venta_orden->getIdOrdenDeServicio()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM venta_orden WHERE  id_venta = ? AND id_orden_de_servicio = ?;";
		$params = array( $venta_orden->getIdVenta(), $venta_orden->getIdOrdenDeServicio() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
