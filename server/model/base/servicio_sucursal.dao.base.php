<?php
/** ServicioSucursal Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ServicioSucursal }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ServicioSucursalDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_servicio, $id_sucursal ){
			$pk = "";
			$pk .= $id_servicio . "-";
			$pk .= $id_sucursal . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_servicio, $id_sucursal){
			$pk = "";
			$pk .= $id_servicio . "-";
			$pk .= $id_sucursal . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_servicio, $id_sucursal ){
			$pk = "";
			$pk .= $id_servicio . "-";
			$pk .= $id_sucursal . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ServicioSucursal} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$servicio_sucursal )
	{
		if(  self::getByPK(  $servicio_sucursal->getIdServicio() , $servicio_sucursal->getIdSucursal() ) !== NULL )
		{
			try{ return ServicioSucursalDAOBase::update( $servicio_sucursal) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ServicioSucursalDAOBase::create( $servicio_sucursal) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ServicioSucursal} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ServicioSucursal} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ServicioSucursal Un objeto del tipo {@link ServicioSucursal}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_servicio, $id_sucursal )
	{
		if(self::recordExists(  $id_servicio, $id_sucursal)){
			return self::getRecord( $id_servicio, $id_sucursal );
		}
		$sql = "SELECT * FROM servicio_sucursal WHERE (id_servicio = ? AND id_sucursal = ? ) LIMIT 1;";
		$params = array(  $id_servicio, $id_sucursal );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ServicioSucursal( $rs );
			self::pushRecord( $foo,  $id_servicio, $id_sucursal );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ServicioSucursal}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ServicioSucursal}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from servicio_sucursal";
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
			$bar = new ServicioSucursal($foo);
    		array_push( $allData, $bar);
			//id_servicio
			//id_sucursal
    		self::pushRecord( $bar, $foo["id_servicio"],$foo["id_sucursal"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ServicioSucursal} de la base de datos. 
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
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $servicio_sucursal , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from servicio_sucursal WHERE ("; 
		$val = array();
		if( $servicio_sucursal->getIdServicio() != NULL){
			$sql .= " id_servicio = ? AND";
			array_push( $val, $servicio_sucursal->getIdServicio() );
		}

		if( $servicio_sucursal->getIdSucursal() != NULL){
			$sql .= " id_sucursal = ? AND";
			array_push( $val, $servicio_sucursal->getIdSucursal() );
		}

		if( $servicio_sucursal->getPrecioUtilidad() != NULL){
			$sql .= " precio_utilidad = ? AND";
			array_push( $val, $servicio_sucursal->getPrecioUtilidad() );
		}

		if( $servicio_sucursal->getEsMargenUtilidad() != NULL){
			$sql .= " es_margen_utilidad = ? AND";
			array_push( $val, $servicio_sucursal->getEsMargenUtilidad() );
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
			$bar =  new ServicioSucursal($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_servicio"],$foo["id_sucursal"] );
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
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal a actualizar.
	  **/
	private static final function update( $servicio_sucursal )
	{
		$sql = "UPDATE servicio_sucursal SET  precio_utilidad = ?, es_margen_utilidad = ? WHERE  id_servicio = ? AND id_sucursal = ?;";
		$params = array( 
			$servicio_sucursal->getPrecioUtilidad(), 
			$servicio_sucursal->getEsMargenUtilidad(), 
			$servicio_sucursal->getIdServicio(),$servicio_sucursal->getIdSucursal(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ServicioSucursal suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ServicioSucursal dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal a crear.
	  **/
	private static final function create( &$servicio_sucursal )
	{
		$sql = "INSERT INTO servicio_sucursal ( id_servicio, id_sucursal, precio_utilidad, es_margen_utilidad ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$servicio_sucursal->getIdServicio(), 
			$servicio_sucursal->getIdSucursal(), 
			$servicio_sucursal->getPrecioUtilidad(), 
			$servicio_sucursal->getEsMargenUtilidad(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ServicioSucursal} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ServicioSucursal}.
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
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $servicio_sucursalA , $servicio_sucursalB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from servicio_sucursal WHERE ("; 
		$val = array();
		if( (($a = $servicio_sucursalA->getIdServicio()) !== NULL) & ( ($b = $servicio_sucursalB->getIdServicio()) !== NULL) ){
				$sql .= " id_servicio >= ? AND id_servicio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_servicio = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $servicio_sucursalA->getIdSucursal()) !== NULL) & ( ($b = $servicio_sucursalB->getIdSucursal()) !== NULL) ){
				$sql .= " id_sucursal >= ? AND id_sucursal <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_sucursal = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $servicio_sucursalA->getPrecioUtilidad()) !== NULL) & ( ($b = $servicio_sucursalB->getPrecioUtilidad()) !== NULL) ){
				$sql .= " precio_utilidad >= ? AND precio_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " precio_utilidad = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $servicio_sucursalA->getEsMargenUtilidad()) !== NULL) & ( ($b = $servicio_sucursalB->getEsMargenUtilidad()) !== NULL) ){
				$sql .= " es_margen_utilidad >= ? AND es_margen_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " es_margen_utilidad = ? AND"; 
			$a = $a === NULL ? $b : $a;
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
    		array_push( $ar, new ServicioSucursal($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ServicioSucursal suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ServicioSucursal [$servicio_sucursal] El objeto de tipo ServicioSucursal a eliminar
	  **/
	public static final function delete( &$servicio_sucursal )
	{
		if(self::getByPK($servicio_sucursal->getIdServicio(), $servicio_sucursal->getIdSucursal()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM servicio_sucursal WHERE  id_servicio = ? AND id_sucursal = ?;";
		$params = array( $servicio_sucursal->getIdServicio(), $servicio_sucursal->getIdSucursal() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
