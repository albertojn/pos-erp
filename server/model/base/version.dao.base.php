<?php
/** Version Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Version }. 
  * @author someone@caffeina.mx
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class VersionDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Version} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Version [$version] El objeto de tipo Version
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$version )
	{
		if( ! is_null ( self::getByPK(  $version->getIdVersion() ) ) )
		{
			try{ return VersionDAOBase::update( $version) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return VersionDAOBase::create( $version) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Version} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Version} de la base de datos 
      * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Version Un objeto del tipo {@link Version}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_version )
	{
		if(  is_null( $id_version )  ){ return NULL; }
            if(!is_null( self::$redisConection ) && !is_null($obj = self::$redisConection->get( "Version-" . $id_version ))){
                Logger::log("REDIS !");
                return new Version($obj);
            }
		$sql = "SELECT * FROM version WHERE (id_version = ? ) LIMIT 1;";
		$params = array(  $id_version );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0) return NULL;
		$foo = new Version( $rs );
		if(!is_null(self::$redisConection)) self::$redisConection->set(  "Version-" . $id_version, $foo );
		return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Version}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Version}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from version";
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
			$bar = new Version($foo);
    		array_push( $allData, $bar);
                if(!is_null(self::$redisConection)) self::$redisConection->set(  "Version-" . $bar->getIdVersion(), $bar );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Version} de la base de datos. 
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
	  * @param Version [$version] El objeto de tipo Version
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $version , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from version WHERE ("; 
		$val = array();
		if( ! is_null( $version->getIdVersion() ) ){
			$sql .= " `id_version` = ? AND";
			array_push( $val, $version->getIdVersion() );
		}

		if( ! is_null( $version->getIdTarifa() ) ){
			$sql .= " `id_tarifa` = ? AND";
			array_push( $val, $version->getIdTarifa() );
		}

		if( ! is_null( $version->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $version->getNombre() );
		}

		if( ! is_null( $version->getActiva() ) ){
			$sql .= " `activa` = ? AND";
			array_push( $val, $version->getActiva() );
		}

		if( ! is_null( $version->getFechaInicio() ) ){
			$sql .= " `fecha_inicio` = ? AND";
			array_push( $val, $version->getFechaInicio() );
		}

		if( ! is_null( $version->getFechaFin() ) ){
			$sql .= " `fecha_fin` = ? AND";
			array_push( $val, $version->getFechaFin() );
		}

		if( ! is_null( $version->getDefault() ) ){
			$sql .= " `default` = ? AND";
			array_push( $val, $version->getDefault() );
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
			$bar =  new Version($foo);
    		array_push( $ar,$bar);
                    if(!is_null(self::$redisConection)) self::$redisConection->set(  "Version-" . $bar->getIdVersion(), $bar );
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
	  * @param Version [$version] El objeto de tipo Version a actualizar.
	  **/
	private static final function update( $version )
	{
		$sql = "UPDATE version SET  `id_tarifa` = ?, `nombre` = ?, `activa` = ?, `fecha_inicio` = ?, `fecha_fin` = ?, `default` = ? WHERE  `id_version` = ?;";
		$params = array( 
			$version->getIdTarifa(), 
			$version->getNombre(), 
			$version->getActiva(), 
			$version->getFechaInicio(), 
			$version->getFechaFin(), 
			$version->getDefault(), 
			$version->getIdVersion(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Version suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Version dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Version [$version] El objeto de tipo Version a crear.
	  **/
	private static final function create( &$version )
	{
		$sql = "INSERT INTO version ( `id_version`, `id_tarifa`, `nombre`, `activa`, `fecha_inicio`, `fecha_fin`, `default` ) VALUES ( ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$version->getIdVersion(), 
			$version->getIdTarifa(), 
			$version->getNombre(), 
			$version->getActiva(), 
			$version->getFechaInicio(), 
			$version->getFechaFin(), 
			$version->getDefault(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $version->setIdVersion( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Version} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Version}.
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
	  * @param Version [$version] El objeto de tipo Version
	  * @param Version [$version] El objeto de tipo Version
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $versionA , $versionB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from version WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $versionA->getIdVersion()) ) ) & ( ! is_null ( ($b = $versionB->getIdVersion()) ) ) ){
				$sql .= " `id_version` >= ? AND `id_version` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_version` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $versionA->getIdTarifa()) ) ) & ( ! is_null ( ($b = $versionB->getIdTarifa()) ) ) ){
				$sql .= " `id_tarifa` >= ? AND `id_tarifa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $versionA->getNombre()) ) ) & ( ! is_null ( ($b = $versionB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $versionA->getActiva()) ) ) & ( ! is_null ( ($b = $versionB->getActiva()) ) ) ){
				$sql .= " `activa` >= ? AND `activa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `activa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $versionA->getFechaInicio()) ) ) & ( ! is_null ( ($b = $versionB->getFechaInicio()) ) ) ){
				$sql .= " `fecha_inicio` >= ? AND `fecha_inicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_inicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $versionA->getFechaFin()) ) ) & ( ! is_null ( ($b = $versionB->getFechaFin()) ) ) ){
				$sql .= " `fecha_fin` >= ? AND `fecha_fin` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_fin` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $versionA->getDefault()) ) ) & ( ! is_null ( ($b = $versionB->getDefault()) ) ) ){
				$sql .= " `default` >= ? AND `default` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `default` = ? AND"; 
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
    		array_push( $ar, $bar = new Version($foo));
                    if(!is_null(self::$redisConection)) self::$redisConection->set(  "Version-" . $bar->getIdVersion(), $bar );
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Version suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Version [$version] El objeto de tipo Version a eliminar
	  **/
	public static final function delete( &$version )
	{
		if( is_null( self::getByPK($version->getIdVersion()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM version WHERE  id_version = ?;";
		$params = array( $version->getIdVersion() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
