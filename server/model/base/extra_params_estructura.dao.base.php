<?php
/** ExtraParamsEstructura Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ExtraParamsEstructura }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ExtraParamsEstructuraDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ExtraParamsEstructura} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$extra_params_estructura )
	{
		if( ! is_null ( self::getByPK(  $extra_params_estructura->getIdExtraParamsEstructura() ) ) )
		{
			try{ return ExtraParamsEstructuraDAOBase::update( $extra_params_estructura) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ExtraParamsEstructuraDAOBase::create( $extra_params_estructura) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ExtraParamsEstructura} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ExtraParamsEstructura} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ExtraParamsEstructura Un objeto del tipo {@link ExtraParamsEstructura}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_extra_params_estructura )
	{
		$sql = "SELECT * FROM extra_params_estructura WHERE (id_extra_params_estructura = ? ) LIMIT 1;";
		$params = array(  $id_extra_params_estructura );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ExtraParamsEstructura( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ExtraParamsEstructura}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ExtraParamsEstructura}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from extra_params_estructura";
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
			$bar = new ExtraParamsEstructura($foo);
    		array_push( $allData, $bar);
			//id_extra_params_estructura
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ExtraParamsEstructura} de la base de datos. 
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
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $extra_params_estructura , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from extra_params_estructura WHERE ("; 
		$val = array();
		if( ! is_null( $extra_params_estructura->getIdExtraParamsEstructura() ) ){
			$sql .= " `id_extra_params_estructura` = ? AND";
			array_push( $val, $extra_params_estructura->getIdExtraParamsEstructura() );
		}

		if( ! is_null( $extra_params_estructura->getTabla() ) ){
			$sql .= " `tabla` = ? AND";
			array_push( $val, $extra_params_estructura->getTabla() );
		}

		if( ! is_null( $extra_params_estructura->getCampo() ) ){
			$sql .= " `campo` = ? AND";
			array_push( $val, $extra_params_estructura->getCampo() );
		}

		if( ! is_null( $extra_params_estructura->getTipo() ) ){
			$sql .= " `tipo` = ? AND";
			array_push( $val, $extra_params_estructura->getTipo() );
		}

		if( ! is_null( $extra_params_estructura->getEnum() ) ){
			$sql .= " `enum` = ? AND";
			array_push( $val, $extra_params_estructura->getEnum() );
		}

		if( ! is_null( $extra_params_estructura->getLongitud() ) ){
			$sql .= " `longitud` = ? AND";
			array_push( $val, $extra_params_estructura->getLongitud() );
		}

		if( ! is_null( $extra_params_estructura->getObligatorio() ) ){
			$sql .= " `obligatorio` = ? AND";
			array_push( $val, $extra_params_estructura->getObligatorio() );
		}

		if( ! is_null( $extra_params_estructura->getCaption() ) ){
			$sql .= " `caption` = ? AND";
			array_push( $val, $extra_params_estructura->getCaption() );
		}

		if( ! is_null( $extra_params_estructura->getDescripcion() ) ){
			$sql .= " `descripcion` = ? AND";
			array_push( $val, $extra_params_estructura->getDescripcion() );
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
			$bar =  new ExtraParamsEstructura($foo);
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
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura a actualizar.
	  **/
	private static final function update( $extra_params_estructura )
	{
		$sql = "UPDATE extra_params_estructura SET  `tabla` = ?, `campo` = ?, `tipo` = ?, `enum` = ?, `longitud` = ?, `obligatorio` = ?, `caption` = ?, `descripcion` = ? WHERE  `id_extra_params_estructura` = ?;";
		$params = array( 
			$extra_params_estructura->getTabla(), 
			$extra_params_estructura->getCampo(), 
			$extra_params_estructura->getTipo(), 
			$extra_params_estructura->getEnum(), 
			$extra_params_estructura->getLongitud(), 
			$extra_params_estructura->getObligatorio(), 
			$extra_params_estructura->getCaption(), 
			$extra_params_estructura->getDescripcion(), 
			$extra_params_estructura->getIdExtraParamsEstructura(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ExtraParamsEstructura suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ExtraParamsEstructura dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura a crear.
	  **/
	private static final function create( &$extra_params_estructura )
	{
		$sql = "INSERT INTO extra_params_estructura ( `id_extra_params_estructura`, `tabla`, `campo`, `tipo`, `enum`, `longitud`, `obligatorio`, `caption`, `descripcion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$extra_params_estructura->getIdExtraParamsEstructura(), 
			$extra_params_estructura->getTabla(), 
			$extra_params_estructura->getCampo(), 
			$extra_params_estructura->getTipo(), 
			$extra_params_estructura->getEnum(), 
			$extra_params_estructura->getLongitud(), 
			$extra_params_estructura->getObligatorio(), 
			$extra_params_estructura->getCaption(), 
			$extra_params_estructura->getDescripcion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $extra_params_estructura->setIdExtraParamsEstructura( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ExtraParamsEstructura} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ExtraParamsEstructura}.
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
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $extra_params_estructuraA , $extra_params_estructuraB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from extra_params_estructura WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $extra_params_estructuraA->getIdExtraParamsEstructura()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getIdExtraParamsEstructura()) ) ) ){
				$sql .= " `id_extra_params_estructura` >= ? AND `id_extra_params_estructura` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_extra_params_estructura` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getTabla()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getTabla()) ) ) ){
				$sql .= " `tabla` >= ? AND `tabla` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tabla` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getCampo()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getCampo()) ) ) ){
				$sql .= " `campo` >= ? AND `campo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `campo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getTipo()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getTipo()) ) ) ){
				$sql .= " `tipo` >= ? AND `tipo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getEnum()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getEnum()) ) ) ){
				$sql .= " `enum` >= ? AND `enum` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `enum` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getLongitud()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getLongitud()) ) ) ){
				$sql .= " `longitud` >= ? AND `longitud` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `longitud` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getObligatorio()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getObligatorio()) ) ) ){
				$sql .= " `obligatorio` >= ? AND `obligatorio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `obligatorio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getCaption()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getCaption()) ) ) ){
				$sql .= " `caption` >= ? AND `caption` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `caption` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $extra_params_estructuraA->getDescripcion()) ) ) & ( ! is_null ( ($b = $extra_params_estructuraB->getDescripcion()) ) ) ){
				$sql .= " `descripcion` >= ? AND `descripcion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descripcion` = ? AND"; 
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
    		array_push( $ar, new ExtraParamsEstructura($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ExtraParamsEstructura suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ExtraParamsEstructura [$extra_params_estructura] El objeto de tipo ExtraParamsEstructura a eliminar
	  **/
	public static final function delete( &$extra_params_estructura )
	{
		if( is_null( self::getByPK($extra_params_estructura->getIdExtraParamsEstructura()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM extra_params_estructura WHERE  id_extra_params_estructura = ?;";
		$params = array( $extra_params_estructura->getIdExtraParamsEstructura() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
