<?php
/** Tarifa Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Tarifa }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class TarifaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Tarifa} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$tarifa )
	{
		if( ! is_null ( self::getByPK(  $tarifa->getIdTarifa() ) ) )
		{
			try{ return TarifaDAOBase::update( $tarifa) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return TarifaDAOBase::create( $tarifa) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Tarifa} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Tarifa} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Tarifa Un objeto del tipo {@link Tarifa}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_tarifa )
	{
		$sql = "SELECT * FROM tarifa WHERE (id_tarifa = ? ) LIMIT 1;";
		$params = array(  $id_tarifa );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Tarifa( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Tarifa}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Tarifa}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from tarifa";
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
			$bar = new Tarifa($foo);
    		array_push( $allData, $bar);
			//id_tarifa
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Tarifa} de la base de datos. 
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
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $tarifa , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from tarifa WHERE ("; 
		$val = array();
		if( ! is_null( $tarifa->getIdTarifa() ) ){
			$sql .= " `id_tarifa` = ? AND";
			array_push( $val, $tarifa->getIdTarifa() );
		}

		if( ! is_null( $tarifa->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $tarifa->getNombre() );
		}

		if( ! is_null( $tarifa->getTipoTarifa() ) ){
			$sql .= " `tipo_tarifa` = ? AND";
			array_push( $val, $tarifa->getTipoTarifa() );
		}

		if( ! is_null( $tarifa->getActiva() ) ){
			$sql .= " `activa` = ? AND";
			array_push( $val, $tarifa->getActiva() );
		}

		if( ! is_null( $tarifa->getIdMoneda() ) ){
			$sql .= " `id_moneda` = ? AND";
			array_push( $val, $tarifa->getIdMoneda() );
		}

		if( ! is_null( $tarifa->getDefault() ) ){
			$sql .= " `default` = ? AND";
			array_push( $val, $tarifa->getDefault() );
		}

		if( ! is_null( $tarifa->getIdVersionDefault() ) ){
			$sql .= " `id_version_default` = ? AND";
			array_push( $val, $tarifa->getIdVersionDefault() );
		}

		if( ! is_null( $tarifa->getIdVersionActiva() ) ){
			$sql .= " `id_version_activa` = ? AND";
			array_push( $val, $tarifa->getIdVersionActiva() );
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
			$bar =  new Tarifa($foo);
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
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa a actualizar.
	  **/
	private static final function update( $tarifa )
	{
		$sql = "UPDATE tarifa SET  `nombre` = ?, `tipo_tarifa` = ?, `activa` = ?, `id_moneda` = ?, `default` = ?, `id_version_default` = ?, `id_version_activa` = ? WHERE  `id_tarifa` = ?;";
		$params = array( 
			$tarifa->getNombre(), 
			$tarifa->getTipoTarifa(), 
			$tarifa->getActiva(), 
			$tarifa->getIdMoneda(), 
			$tarifa->getDefault(), 
			$tarifa->getIdVersionDefault(), 
			$tarifa->getIdVersionActiva(), 
			$tarifa->getIdTarifa(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Tarifa suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Tarifa dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa a crear.
	  **/
	private static final function create( &$tarifa )
	{
		$sql = "INSERT INTO tarifa ( `id_tarifa`, `nombre`, `tipo_tarifa`, `activa`, `id_moneda`, `default`, `id_version_default`, `id_version_activa` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$tarifa->getIdTarifa(), 
			$tarifa->getNombre(), 
			$tarifa->getTipoTarifa(), 
			$tarifa->getActiva(), 
			$tarifa->getIdMoneda(), 
			$tarifa->getDefault(), 
			$tarifa->getIdVersionDefault(), 
			$tarifa->getIdVersionActiva(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $tarifa->setIdTarifa( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Tarifa} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Tarifa}.
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
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $tarifaA , $tarifaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from tarifa WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $tarifaA->getIdTarifa()) ) ) & ( ! is_null ( ($b = $tarifaB->getIdTarifa()) ) ) ){
				$sql .= " `id_tarifa` >= ? AND `id_tarifa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getNombre()) ) ) & ( ! is_null ( ($b = $tarifaB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getTipoTarifa()) ) ) & ( ! is_null ( ($b = $tarifaB->getTipoTarifa()) ) ) ){
				$sql .= " `tipo_tarifa` >= ? AND `tipo_tarifa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_tarifa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getActiva()) ) ) & ( ! is_null ( ($b = $tarifaB->getActiva()) ) ) ){
				$sql .= " `activa` >= ? AND `activa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `activa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getIdMoneda()) ) ) & ( ! is_null ( ($b = $tarifaB->getIdMoneda()) ) ) ){
				$sql .= " `id_moneda` >= ? AND `id_moneda` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_moneda` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getDefault()) ) ) & ( ! is_null ( ($b = $tarifaB->getDefault()) ) ) ){
				$sql .= " `default` >= ? AND `default` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `default` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getIdVersionDefault()) ) ) & ( ! is_null ( ($b = $tarifaB->getIdVersionDefault()) ) ) ){
				$sql .= " `id_version_default` >= ? AND `id_version_default` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_version_default` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $tarifaA->getIdVersionActiva()) ) ) & ( ! is_null ( ($b = $tarifaB->getIdVersionActiva()) ) ) ){
				$sql .= " `id_version_activa` >= ? AND `id_version_activa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_version_activa` = ? AND"; 
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
    		array_push( $ar, new Tarifa($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Tarifa suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Tarifa [$tarifa] El objeto de tipo Tarifa a eliminar
	  **/
	public static final function delete( &$tarifa )
	{
		if( is_null( self::getByPK($tarifa->getIdTarifa()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM tarifa WHERE  id_tarifa = ?;";
		$params = array( $tarifa->getIdTarifa() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
