<?php
/** HistorialTipoCambio Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link HistorialTipoCambio }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class HistorialTipoCambioDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link HistorialTipoCambio} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$historial_tipo_cambio )
	{
		if( ! is_null ( self::getByPK(  $historial_tipo_cambio->getIdHistorialTipoCambio() ) ) )
		{
			try{ return HistorialTipoCambioDAOBase::update( $historial_tipo_cambio) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return HistorialTipoCambioDAOBase::create( $historial_tipo_cambio) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link HistorialTipoCambio} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link HistorialTipoCambio} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link HistorialTipoCambio Un objeto del tipo {@link HistorialTipoCambio}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_historial_tipo_cambio )
	{
		$sql = "SELECT * FROM historial_tipo_cambio WHERE (id_historial_tipo_cambio = ? ) LIMIT 1;";
		$params = array(  $id_historial_tipo_cambio );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new HistorialTipoCambio( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link HistorialTipoCambio}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link HistorialTipoCambio}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from historial_tipo_cambio";
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
			$bar = new HistorialTipoCambio($foo);
    		array_push( $allData, $bar);
			//id_historial_tipo_cambio
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link HistorialTipoCambio} de la base de datos. 
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
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $historial_tipo_cambio , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from historial_tipo_cambio WHERE ("; 
		$val = array();
		if( ! is_null( $historial_tipo_cambio->getIdHistorialTipoCambio() ) ){
			$sql .= " `id_historial_tipo_cambio` = ? AND";
			array_push( $val, $historial_tipo_cambio->getIdHistorialTipoCambio() );
		}

		if( ! is_null( $historial_tipo_cambio->getIdMonedaBase() ) ){
			$sql .= " `id_moneda_base` = ? AND";
			array_push( $val, $historial_tipo_cambio->getIdMonedaBase() );
		}

		if( ! is_null( $historial_tipo_cambio->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $historial_tipo_cambio->getFecha() );
		}

		if( ! is_null( $historial_tipo_cambio->getJsonEquivalencias() ) ){
			$sql .= " `json_equivalencias` = ? AND";
			array_push( $val, $historial_tipo_cambio->getJsonEquivalencias() );
		}

		if( ! is_null( $historial_tipo_cambio->getIdEmpresa() ) ){
			$sql .= " `id_empresa` = ? AND";
			array_push( $val, $historial_tipo_cambio->getIdEmpresa() );
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
			$bar =  new HistorialTipoCambio($foo);
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
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio a actualizar.
	  **/
	private static final function update( $historial_tipo_cambio )
	{
		$sql = "UPDATE historial_tipo_cambio SET  `id_moneda_base` = ?, `fecha` = ?, `json_equivalencias` = ?, `id_empresa` = ? WHERE  `id_historial_tipo_cambio` = ?;";
		$params = array( 
			$historial_tipo_cambio->getIdMonedaBase(), 
			$historial_tipo_cambio->getFecha(), 
			$historial_tipo_cambio->getJsonEquivalencias(), 
			$historial_tipo_cambio->getIdEmpresa(), 
			$historial_tipo_cambio->getIdHistorialTipoCambio(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto HistorialTipoCambio suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto HistorialTipoCambio dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio a crear.
	  **/
	private static final function create( &$historial_tipo_cambio )
	{
		$sql = "INSERT INTO historial_tipo_cambio ( `id_historial_tipo_cambio`, `id_moneda_base`, `fecha`, `json_equivalencias`, `id_empresa` ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$historial_tipo_cambio->getIdHistorialTipoCambio(), 
			$historial_tipo_cambio->getIdMonedaBase(), 
			$historial_tipo_cambio->getFecha(), 
			$historial_tipo_cambio->getJsonEquivalencias(), 
			$historial_tipo_cambio->getIdEmpresa(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $historial_tipo_cambio->setIdHistorialTipoCambio( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link HistorialTipoCambio} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link HistorialTipoCambio}.
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
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $historial_tipo_cambioA , $historial_tipo_cambioB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from historial_tipo_cambio WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $historial_tipo_cambioA->getIdHistorialTipoCambio()) ) ) & ( ! is_null ( ($b = $historial_tipo_cambioB->getIdHistorialTipoCambio()) ) ) ){
				$sql .= " `id_historial_tipo_cambio` >= ? AND `id_historial_tipo_cambio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_historial_tipo_cambio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $historial_tipo_cambioA->getIdMonedaBase()) ) ) & ( ! is_null ( ($b = $historial_tipo_cambioB->getIdMonedaBase()) ) ) ){
				$sql .= " `id_moneda_base` >= ? AND `id_moneda_base` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_moneda_base` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $historial_tipo_cambioA->getFecha()) ) ) & ( ! is_null ( ($b = $historial_tipo_cambioB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $historial_tipo_cambioA->getJsonEquivalencias()) ) ) & ( ! is_null ( ($b = $historial_tipo_cambioB->getJsonEquivalencias()) ) ) ){
				$sql .= " `json_equivalencias` >= ? AND `json_equivalencias` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `json_equivalencias` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $historial_tipo_cambioA->getIdEmpresa()) ) ) & ( ! is_null ( ($b = $historial_tipo_cambioB->getIdEmpresa()) ) ) ){
				$sql .= " `id_empresa` >= ? AND `id_empresa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_empresa` = ? AND"; 
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
    		array_push( $ar, new HistorialTipoCambio($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto HistorialTipoCambio suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param HistorialTipoCambio [$historial_tipo_cambio] El objeto de tipo HistorialTipoCambio a eliminar
	  **/
	public static final function delete( &$historial_tipo_cambio )
	{
		if( is_null( self::getByPK($historial_tipo_cambio->getIdHistorialTipoCambio()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM historial_tipo_cambio WHERE  id_historial_tipo_cambio = ?;";
		$params = array( $historial_tipo_cambio->getIdHistorialTipoCambio() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
