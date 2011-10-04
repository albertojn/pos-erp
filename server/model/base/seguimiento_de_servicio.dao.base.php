<?php
/** SeguimientoDeServicio Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link SeguimientoDeServicio }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class SeguimientoDeServicioDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_seguimiento_de_servicio ){
			$pk = "";
			$pk .= $id_seguimiento_de_servicio . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_seguimiento_de_servicio){
			$pk = "";
			$pk .= $id_seguimiento_de_servicio . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_seguimiento_de_servicio ){
			$pk = "";
			$pk .= $id_seguimiento_de_servicio . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link SeguimientoDeServicio} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$seguimiento_de_servicio )
	{
		if(  self::getByPK(  $seguimiento_de_servicio->getIdSeguimientoDeServicio() ) !== NULL )
		{
			try{ return SeguimientoDeServicioDAOBase::update( $seguimiento_de_servicio) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return SeguimientoDeServicioDAOBase::create( $seguimiento_de_servicio) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link SeguimientoDeServicio} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link SeguimientoDeServicio} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link SeguimientoDeServicio Un objeto del tipo {@link SeguimientoDeServicio}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_seguimiento_de_servicio )
	{
		if(self::recordExists(  $id_seguimiento_de_servicio)){
			return self::getRecord( $id_seguimiento_de_servicio );
		}
		$sql = "SELECT * FROM seguimiento_de_servicio WHERE (id_seguimiento_de_servicio = ? ) LIMIT 1;";
		$params = array(  $id_seguimiento_de_servicio );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new SeguimientoDeServicio( $rs );
			self::pushRecord( $foo,  $id_seguimiento_de_servicio );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link SeguimientoDeServicio}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link SeguimientoDeServicio}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from seguimiento_de_servicio";
		if($orden != NULL)
		{ $sql .= " ORDER BY " . $orden . " " . $tipo_de_orden;	}
		if($pagina != NULL)
		{
			$sql .= " LIMIT " . (( $pagina - 1 )*$columnas_por_pagina) . "," . $columnas_por_pagina; 
		}
		global $conn;
		$rs = $conn->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
			$bar = new SeguimientoDeServicio($foo);
    		array_push( $allData, $bar);
			//id_seguimiento_de_servicio
    		self::pushRecord( $bar, $foo["id_seguimiento_de_servicio"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link SeguimientoDeServicio} de la base de datos. 
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
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $seguimiento_de_servicio , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from seguimiento_de_servicio WHERE ("; 
		$val = array();
		if( $seguimiento_de_servicio->getIdSeguimientoDeServicio() != NULL){
			$sql .= " id_seguimiento_de_servicio = ? AND";
			array_push( $val, $seguimiento_de_servicio->getIdSeguimientoDeServicio() );
		}

		if( $seguimiento_de_servicio->getIdOrdenDeServicio() != NULL){
			$sql .= " id_orden_de_servicio = ? AND";
			array_push( $val, $seguimiento_de_servicio->getIdOrdenDeServicio() );
		}

		if( $seguimiento_de_servicio->getIdLocalizacion() != NULL){
			$sql .= " id_localizacion = ? AND";
			array_push( $val, $seguimiento_de_servicio->getIdLocalizacion() );
		}

		if( $seguimiento_de_servicio->getIdUsuario() != NULL){
			$sql .= " id_usuario = ? AND";
			array_push( $val, $seguimiento_de_servicio->getIdUsuario() );
		}

		if( $seguimiento_de_servicio->getIdSucursal() != NULL){
			$sql .= " id_sucursal = ? AND";
			array_push( $val, $seguimiento_de_servicio->getIdSucursal() );
		}

		if( $seguimiento_de_servicio->getEstado() != NULL){
			$sql .= " estado = ? AND";
			array_push( $val, $seguimiento_de_servicio->getEstado() );
		}

		if( $seguimiento_de_servicio->getFechaSeguimiento() != NULL){
			$sql .= " fecha_seguimiento = ? AND";
			array_push( $val, $seguimiento_de_servicio->getFechaSeguimiento() );
		}

		if(sizeof($val) == 0){return array();}
		$sql = substr($sql, 0, -3) . " )";
		if( $orderBy !== null ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
			$bar =  new SeguimientoDeServicio($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_seguimiento_de_servicio"] );
		}
		return $ar;
	}


	/**
	  *	Actualizar registros.
	  *	
	  * Este metodo es un metodo de ayuda para uso interno. Se ejecutara todas las manipulaciones
	  * en la base de datos que estan dadas en el objeto pasado.No se haran consultas SELECT 
	  * aqui, sin embargo. El valor de retorno indica cu�ntas filas se vieron afectadas.
	  *	
	  * @internal private information for advanced developers only
	  * @return Filas afectadas o un string con la descripcion del error
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio a actualizar.
	  **/
	private static final function update( $seguimiento_de_servicio )
	{
		$sql = "UPDATE seguimiento_de_servicio SET  id_orden_de_servicio = ?, id_localizacion = ?, id_usuario = ?, id_sucursal = ?, estado = ?, fecha_seguimiento = ? WHERE  id_seguimiento_de_servicio = ?;";
		$params = array( 
			$seguimiento_de_servicio->getIdOrdenDeServicio(), 
			$seguimiento_de_servicio->getIdLocalizacion(), 
			$seguimiento_de_servicio->getIdUsuario(), 
			$seguimiento_de_servicio->getIdSucursal(), 
			$seguimiento_de_servicio->getEstado(), 
			$seguimiento_de_servicio->getFechaSeguimiento(), 
			$seguimiento_de_servicio->getIdSeguimientoDeServicio(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto SeguimientoDeServicio suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto SeguimientoDeServicio dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio a crear.
	  **/
	private static final function create( &$seguimiento_de_servicio )
	{
		$sql = "INSERT INTO seguimiento_de_servicio ( id_seguimiento_de_servicio, id_orden_de_servicio, id_localizacion, id_usuario, id_sucursal, estado, fecha_seguimiento ) VALUES ( ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$seguimiento_de_servicio->getIdSeguimientoDeServicio(), 
			$seguimiento_de_servicio->getIdOrdenDeServicio(), 
			$seguimiento_de_servicio->getIdLocalizacion(), 
			$seguimiento_de_servicio->getIdUsuario(), 
			$seguimiento_de_servicio->getIdSucursal(), 
			$seguimiento_de_servicio->getEstado(), 
			$seguimiento_de_servicio->getFechaSeguimiento(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $seguimiento_de_servicio->setIdSeguimientoDeServicio( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link SeguimientoDeServicio} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link SeguimientoDeServicio}.
	  * 
	  * Aquellas variables que tienen valores NULL seran excluidos en la busqueda. 
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
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $seguimiento_de_servicioA , $seguimiento_de_servicioB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from seguimiento_de_servicio WHERE ("; 
		$val = array();
		if( (($a = $seguimiento_de_servicioA->getIdSeguimientoDeServicio()) != NULL) & ( ($b = $seguimiento_de_servicioB->getIdSeguimientoDeServicio()) != NULL) ){
				$sql .= " id_seguimiento_de_servicio >= ? AND id_seguimiento_de_servicio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_seguimiento_de_servicio = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $seguimiento_de_servicioA->getIdOrdenDeServicio()) != NULL) & ( ($b = $seguimiento_de_servicioB->getIdOrdenDeServicio()) != NULL) ){
				$sql .= " id_orden_de_servicio >= ? AND id_orden_de_servicio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_orden_de_servicio = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $seguimiento_de_servicioA->getIdLocalizacion()) != NULL) & ( ($b = $seguimiento_de_servicioB->getIdLocalizacion()) != NULL) ){
				$sql .= " id_localizacion >= ? AND id_localizacion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_localizacion = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $seguimiento_de_servicioA->getIdUsuario()) != NULL) & ( ($b = $seguimiento_de_servicioB->getIdUsuario()) != NULL) ){
				$sql .= " id_usuario >= ? AND id_usuario <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_usuario = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $seguimiento_de_servicioA->getIdSucursal()) != NULL) & ( ($b = $seguimiento_de_servicioB->getIdSucursal()) != NULL) ){
				$sql .= " id_sucursal >= ? AND id_sucursal <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_sucursal = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $seguimiento_de_servicioA->getEstado()) != NULL) & ( ($b = $seguimiento_de_servicioB->getEstado()) != NULL) ){
				$sql .= " estado >= ? AND estado <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " estado = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $seguimiento_de_servicioA->getFechaSeguimiento()) != NULL) & ( ($b = $seguimiento_de_servicioB->getFechaSeguimiento()) != NULL) ){
				$sql .= " fecha_seguimiento >= ? AND fecha_seguimiento <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " fecha_seguimiento = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		$sql = substr($sql, 0, -3) . " )";
		if( $orderBy !== null ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
    		array_push( $ar, new SeguimientoDeServicio($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto SeguimientoDeServicio suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param SeguimientoDeServicio [$seguimiento_de_servicio] El objeto de tipo SeguimientoDeServicio a eliminar
	  **/
	public static final function delete( &$seguimiento_de_servicio )
	{
		if(self::getByPK($seguimiento_de_servicio->getIdSeguimientoDeServicio()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM seguimiento_de_servicio WHERE  id_seguimiento_de_servicio = ?;";
		$params = array( $seguimiento_de_servicio->getIdSeguimientoDeServicio() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
