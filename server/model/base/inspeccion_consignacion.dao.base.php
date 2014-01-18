<?php
/** InspeccionConsignacion Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link InspeccionConsignacion }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class InspeccionConsignacionDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link InspeccionConsignacion} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$inspeccion_consignacion )
	{
		if( ! is_null ( self::getByPK(  $inspeccion_consignacion->getIdInspeccionConsignacion() ) ) )
		{
			try{ return InspeccionConsignacionDAOBase::update( $inspeccion_consignacion) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return InspeccionConsignacionDAOBase::create( $inspeccion_consignacion) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link InspeccionConsignacion} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link InspeccionConsignacion} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link InspeccionConsignacion Un objeto del tipo {@link InspeccionConsignacion}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_inspeccion_consignacion )
	{
		$sql = "SELECT * FROM inspeccion_consignacion WHERE (id_inspeccion_consignacion = ? ) LIMIT 1;";
		$params = array(  $id_inspeccion_consignacion );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new InspeccionConsignacion( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link InspeccionConsignacion}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link InspeccionConsignacion}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from inspeccion_consignacion";
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
			$bar = new InspeccionConsignacion($foo);
    		array_push( $allData, $bar);
			//id_inspeccion_consignacion
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link InspeccionConsignacion} de la base de datos. 
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
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $inspeccion_consignacion , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from inspeccion_consignacion WHERE ("; 
		$val = array();
		if( ! is_null( $inspeccion_consignacion->getIdInspeccionConsignacion() ) ){
			$sql .= " `id_inspeccion_consignacion` = ? AND";
			array_push( $val, $inspeccion_consignacion->getIdInspeccionConsignacion() );
		}

		if( ! is_null( $inspeccion_consignacion->getIdConsignacion() ) ){
			$sql .= " `id_consignacion` = ? AND";
			array_push( $val, $inspeccion_consignacion->getIdConsignacion() );
		}

		if( ! is_null( $inspeccion_consignacion->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $inspeccion_consignacion->getIdUsuario() );
		}

		if( ! is_null( $inspeccion_consignacion->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $inspeccion_consignacion->getIdCaja() );
		}

		if( ! is_null( $inspeccion_consignacion->getFechaInspeccion() ) ){
			$sql .= " `fecha_inspeccion` = ? AND";
			array_push( $val, $inspeccion_consignacion->getFechaInspeccion() );
		}

		if( ! is_null( $inspeccion_consignacion->getMontoAbonado() ) ){
			$sql .= " `monto_abonado` = ? AND";
			array_push( $val, $inspeccion_consignacion->getMontoAbonado() );
		}

		if( ! is_null( $inspeccion_consignacion->getCancelada() ) ){
			$sql .= " `cancelada` = ? AND";
			array_push( $val, $inspeccion_consignacion->getCancelada() );
		}

		if( ! is_null( $inspeccion_consignacion->getMotivoCancelacion() ) ){
			$sql .= " `motivo_cancelacion` = ? AND";
			array_push( $val, $inspeccion_consignacion->getMotivoCancelacion() );
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
			$bar =  new InspeccionConsignacion($foo);
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
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion a actualizar.
	  **/
	private static final function update( $inspeccion_consignacion )
	{
		$sql = "UPDATE inspeccion_consignacion SET  `id_consignacion` = ?, `id_usuario` = ?, `id_caja` = ?, `fecha_inspeccion` = ?, `monto_abonado` = ?, `cancelada` = ?, `motivo_cancelacion` = ? WHERE  `id_inspeccion_consignacion` = ?;";
		$params = array( 
			$inspeccion_consignacion->getIdConsignacion(), 
			$inspeccion_consignacion->getIdUsuario(), 
			$inspeccion_consignacion->getIdCaja(), 
			$inspeccion_consignacion->getFechaInspeccion(), 
			$inspeccion_consignacion->getMontoAbonado(), 
			$inspeccion_consignacion->getCancelada(), 
			$inspeccion_consignacion->getMotivoCancelacion(), 
			$inspeccion_consignacion->getIdInspeccionConsignacion(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto InspeccionConsignacion suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto InspeccionConsignacion dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion a crear.
	  **/
	private static final function create( &$inspeccion_consignacion )
	{
		$sql = "INSERT INTO inspeccion_consignacion ( `id_inspeccion_consignacion`, `id_consignacion`, `id_usuario`, `id_caja`, `fecha_inspeccion`, `monto_abonado`, `cancelada`, `motivo_cancelacion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$inspeccion_consignacion->getIdInspeccionConsignacion(), 
			$inspeccion_consignacion->getIdConsignacion(), 
			$inspeccion_consignacion->getIdUsuario(), 
			$inspeccion_consignacion->getIdCaja(), 
			$inspeccion_consignacion->getFechaInspeccion(), 
			$inspeccion_consignacion->getMontoAbonado(), 
			$inspeccion_consignacion->getCancelada(), 
			$inspeccion_consignacion->getMotivoCancelacion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $inspeccion_consignacion->setIdInspeccionConsignacion( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link InspeccionConsignacion} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link InspeccionConsignacion}.
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
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $inspeccion_consignacionA , $inspeccion_consignacionB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from inspeccion_consignacion WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $inspeccion_consignacionA->getIdInspeccionConsignacion()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getIdInspeccionConsignacion()) ) ) ){
				$sql .= " `id_inspeccion_consignacion` >= ? AND `id_inspeccion_consignacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_inspeccion_consignacion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getIdConsignacion()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getIdConsignacion()) ) ) ){
				$sql .= " `id_consignacion` >= ? AND `id_consignacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_consignacion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getIdCaja()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getFechaInspeccion()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getFechaInspeccion()) ) ) ){
				$sql .= " `fecha_inspeccion` >= ? AND `fecha_inspeccion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_inspeccion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getMontoAbonado()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getMontoAbonado()) ) ) ){
				$sql .= " `monto_abonado` >= ? AND `monto_abonado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `monto_abonado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getCancelada()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getCancelada()) ) ) ){
				$sql .= " `cancelada` >= ? AND `cancelada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $inspeccion_consignacionA->getMotivoCancelacion()) ) ) & ( ! is_null ( ($b = $inspeccion_consignacionB->getMotivoCancelacion()) ) ) ){
				$sql .= " `motivo_cancelacion` >= ? AND `motivo_cancelacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `motivo_cancelacion` = ? AND"; 
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
    		array_push( $ar, new InspeccionConsignacion($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto InspeccionConsignacion suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param InspeccionConsignacion [$inspeccion_consignacion] El objeto de tipo InspeccionConsignacion a eliminar
	  **/
	public static final function delete( &$inspeccion_consignacion )
	{
		if( is_null( self::getByPK($inspeccion_consignacion->getIdInspeccionConsignacion()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM inspeccion_consignacion WHERE  id_inspeccion_consignacion = ?;";
		$params = array( $inspeccion_consignacion->getIdInspeccionConsignacion() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
