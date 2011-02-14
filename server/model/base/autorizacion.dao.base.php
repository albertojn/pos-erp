<?php
/** Autorizacion Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Autorizacion }. 
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class AutorizacionDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_autorizacion ){
			$pk = "";
			$pk .= $id_autorizacion . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_autorizacion){
			$pk = "";
			$pk .= $id_autorizacion . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_autorizacion ){
			$pk = "";
			$pk .= $id_autorizacion . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Autorizacion} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$autorizacion )
	{
		if(  self::getByPK(  $autorizacion->getIdAutorizacion() ) !== NULL )
		{
			try{ return AutorizacionDAOBase::update( $autorizacion) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return AutorizacionDAOBase::create( $autorizacion) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Autorizacion} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Autorizacion} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Autorizacion Un objeto del tipo {@link Autorizacion}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_autorizacion )
	{
		if(self::recordExists(  $id_autorizacion)){
			return self::getRecord( $id_autorizacion );
		}
		$sql = "SELECT * FROM autorizacion WHERE (id_autorizacion = ? ) LIMIT 1;";
		$params = array(  $id_autorizacion );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Autorizacion( $rs );
			self::pushRecord( $foo,  $id_autorizacion );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Autorizacion}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Autorizacion}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from autorizacion";
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
			$bar = new Autorizacion($foo);
    		array_push( $allData, $bar);
			//id_autorizacion
    		self::pushRecord( $bar, $foo["id_autorizacion"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Autorizacion} de la base de datos. 
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
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $autorizacion , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from autorizacion WHERE ("; 
		$val = array();
		if( $autorizacion->getIdAutorizacion() != NULL){
			$sql .= " id_autorizacion = ? AND";
			array_push( $val, $autorizacion->getIdAutorizacion() );
		}

		if( $autorizacion->getIdUsuario() != NULL){
			$sql .= " id_usuario = ? AND";
			array_push( $val, $autorizacion->getIdUsuario() );
		}

		if( $autorizacion->getIdSucursal() != NULL){
			$sql .= " id_sucursal = ? AND";
			array_push( $val, $autorizacion->getIdSucursal() );
		}

		if( $autorizacion->getFechaPeticion() != NULL){
			$sql .= " fecha_peticion = ? AND";
			array_push( $val, $autorizacion->getFechaPeticion() );
		}

		if( $autorizacion->getFechaRespuesta() != NULL){
			$sql .= " fecha_respuesta = ? AND";
			array_push( $val, $autorizacion->getFechaRespuesta() );
		}

		if( $autorizacion->getEstado() != NULL){
			$sql .= " estado = ? AND";
			array_push( $val, $autorizacion->getEstado() );
		}

		if( $autorizacion->getParametros() != NULL){
			$sql .= " parametros = ? AND";
			array_push( $val, $autorizacion->getParametros() );
		}

		if( $autorizacion->getTipo() != NULL){
			$sql .= " tipo = ? AND";
			array_push( $val, $autorizacion->getTipo() );
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
			$bar =  new Autorizacion($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_autorizacion"] );
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
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion a actualizar.
	  **/
	private static final function update( $autorizacion )
	{
		$sql = "UPDATE autorizacion SET  id_usuario = ?, id_sucursal = ?, fecha_peticion = ?, fecha_respuesta = ?, estado = ?, parametros = ?, tipo = ? WHERE  id_autorizacion = ?;";
		$params = array( 
			$autorizacion->getIdUsuario(), 
			$autorizacion->getIdSucursal(), 
			$autorizacion->getFechaPeticion(), 
			$autorizacion->getFechaRespuesta(), 
			$autorizacion->getEstado(), 
			$autorizacion->getParametros(), 
			$autorizacion->getTipo(), 
			$autorizacion->getIdAutorizacion(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Autorizacion suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Autorizacion dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion a crear.
	  **/
	private static final function create( &$autorizacion )
	{
		$sql = "INSERT INTO autorizacion ( id_autorizacion, id_usuario, id_sucursal, fecha_peticion, fecha_respuesta, estado, parametros, tipo ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$autorizacion->getIdAutorizacion(), 
			$autorizacion->getIdUsuario(), 
			$autorizacion->getIdSucursal(), 
			$autorizacion->getFechaPeticion(), 
			$autorizacion->getFechaRespuesta(), 
			$autorizacion->getEstado(), 
			$autorizacion->getParametros(), 
			$autorizacion->getTipo(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Autorizacion} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Autorizacion}.
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
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $autorizacionA , $autorizacionB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from autorizacion WHERE ("; 
		$val = array();
		if( (($a = $autorizacionA->getIdAutorizacion()) != NULL) & ( ($b = $autorizacionB->getIdAutorizacion()) != NULL) ){
				$sql .= " id_autorizacion >= ? AND id_autorizacion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_autorizacion = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getIdUsuario()) != NULL) & ( ($b = $autorizacionB->getIdUsuario()) != NULL) ){
				$sql .= " id_usuario >= ? AND id_usuario <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_usuario = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getIdSucursal()) != NULL) & ( ($b = $autorizacionB->getIdSucursal()) != NULL) ){
				$sql .= " id_sucursal >= ? AND id_sucursal <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_sucursal = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getFechaPeticion()) != NULL) & ( ($b = $autorizacionB->getFechaPeticion()) != NULL) ){
				$sql .= " fecha_peticion >= ? AND fecha_peticion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " fecha_peticion = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getFechaRespuesta()) != NULL) & ( ($b = $autorizacionB->getFechaRespuesta()) != NULL) ){
				$sql .= " fecha_respuesta >= ? AND fecha_respuesta <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " fecha_respuesta = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getEstado()) != NULL) & ( ($b = $autorizacionB->getEstado()) != NULL) ){
				$sql .= " estado >= ? AND estado <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " estado = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getParametros()) != NULL) & ( ($b = $autorizacionB->getParametros()) != NULL) ){
				$sql .= " parametros >= ? AND parametros <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " parametros = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $autorizacionA->getTipo()) != NULL) & ( ($b = $autorizacionB->getTipo()) != NULL) ){
				$sql .= " tipo >= ? AND tipo <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " tipo = ? AND"; 
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
    		array_push( $ar, new Autorizacion($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Autorizacion suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Autorizacion [$autorizacion] El objeto de tipo Autorizacion a eliminar
	  **/
	public static final function delete( &$autorizacion )
	{
		if(self::getByPK($autorizacion->getIdAutorizacion()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM autorizacion WHERE  id_autorizacion = ?;";
		$params = array( $autorizacion->getIdAutorizacion() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
