<?php
/** PrecioServicioTipoCliente Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link PrecioServicioTipoCliente }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class PrecioServicioTipoClienteDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_servicio, $id_tipo_cliente ){
			$pk = "";
			$pk .= $id_servicio . "-";
			$pk .= $id_tipo_cliente . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_servicio, $id_tipo_cliente){
			$pk = "";
			$pk .= $id_servicio . "-";
			$pk .= $id_tipo_cliente . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_servicio, $id_tipo_cliente ){
			$pk = "";
			$pk .= $id_servicio . "-";
			$pk .= $id_tipo_cliente . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link PrecioServicioTipoCliente} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$precio_servicio_tipo_cliente )
	{
		if(  self::getByPK(  $precio_servicio_tipo_cliente->getIdServicio() , $precio_servicio_tipo_cliente->getIdTipoCliente() ) !== NULL )
		{
			try{ return PrecioServicioTipoClienteDAOBase::update( $precio_servicio_tipo_cliente) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return PrecioServicioTipoClienteDAOBase::create( $precio_servicio_tipo_cliente) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link PrecioServicioTipoCliente} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link PrecioServicioTipoCliente} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link PrecioServicioTipoCliente Un objeto del tipo {@link PrecioServicioTipoCliente}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_servicio, $id_tipo_cliente )
	{
		if(self::recordExists(  $id_servicio, $id_tipo_cliente)){
			return self::getRecord( $id_servicio, $id_tipo_cliente );
		}
		$sql = "SELECT * FROM precio_servicio_tipo_cliente WHERE (id_servicio = ? AND id_tipo_cliente = ? ) LIMIT 1;";
		$params = array(  $id_servicio, $id_tipo_cliente );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new PrecioServicioTipoCliente( $rs );
			self::pushRecord( $foo,  $id_servicio, $id_tipo_cliente );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link PrecioServicioTipoCliente}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link PrecioServicioTipoCliente}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from precio_servicio_tipo_cliente";
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
			$bar = new PrecioServicioTipoCliente($foo);
    		array_push( $allData, $bar);
			//id_servicio
			//id_tipo_cliente
    		self::pushRecord( $bar, $foo["id_servicio"],$foo["id_tipo_cliente"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link PrecioServicioTipoCliente} de la base de datos. 
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
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $precio_servicio_tipo_cliente , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from precio_servicio_tipo_cliente WHERE ("; 
		$val = array();
		if( $precio_servicio_tipo_cliente->getIdServicio() != NULL){
			$sql .= " id_servicio = ? AND";
			array_push( $val, $precio_servicio_tipo_cliente->getIdServicio() );
		}

		if( $precio_servicio_tipo_cliente->getIdTipoCliente() != NULL){
			$sql .= " id_tipo_cliente = ? AND";
			array_push( $val, $precio_servicio_tipo_cliente->getIdTipoCliente() );
		}

		if( $precio_servicio_tipo_cliente->getEsMargenUtilidad() != NULL){
			$sql .= " es_margen_utilidad = ? AND";
			array_push( $val, $precio_servicio_tipo_cliente->getEsMargenUtilidad() );
		}

		if( $precio_servicio_tipo_cliente->getPrecioUtilidad() != NULL){
			$sql .= " precio_utilidad = ? AND";
			array_push( $val, $precio_servicio_tipo_cliente->getPrecioUtilidad() );
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
			$bar =  new PrecioServicioTipoCliente($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_servicio"],$foo["id_tipo_cliente"] );
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
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente a actualizar.
	  **/
	private static final function update( $precio_servicio_tipo_cliente )
	{
		$sql = "UPDATE precio_servicio_tipo_cliente SET  es_margen_utilidad = ?, precio_utilidad = ? WHERE  id_servicio = ? AND id_tipo_cliente = ?;";
		$params = array( 
			$precio_servicio_tipo_cliente->getEsMargenUtilidad(), 
			$precio_servicio_tipo_cliente->getPrecioUtilidad(), 
			$precio_servicio_tipo_cliente->getIdServicio(),$precio_servicio_tipo_cliente->getIdTipoCliente(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto PrecioServicioTipoCliente suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto PrecioServicioTipoCliente dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente a crear.
	  **/
	private static final function create( &$precio_servicio_tipo_cliente )
	{
		$sql = "INSERT INTO precio_servicio_tipo_cliente ( id_servicio, id_tipo_cliente, es_margen_utilidad, precio_utilidad ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$precio_servicio_tipo_cliente->getIdServicio(), 
			$precio_servicio_tipo_cliente->getIdTipoCliente(), 
			$precio_servicio_tipo_cliente->getEsMargenUtilidad(), 
			$precio_servicio_tipo_cliente->getPrecioUtilidad(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link PrecioServicioTipoCliente} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link PrecioServicioTipoCliente}.
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
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $precio_servicio_tipo_clienteA , $precio_servicio_tipo_clienteB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from precio_servicio_tipo_cliente WHERE ("; 
		$val = array();
		if( (($a = $precio_servicio_tipo_clienteA->getIdServicio()) !== NULL) & ( ($b = $precio_servicio_tipo_clienteB->getIdServicio()) !== NULL) ){
				$sql .= " id_servicio >= ? AND id_servicio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_servicio = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $precio_servicio_tipo_clienteA->getIdTipoCliente()) !== NULL) & ( ($b = $precio_servicio_tipo_clienteB->getIdTipoCliente()) !== NULL) ){
				$sql .= " id_tipo_cliente >= ? AND id_tipo_cliente <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_tipo_cliente = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $precio_servicio_tipo_clienteA->getEsMargenUtilidad()) !== NULL) & ( ($b = $precio_servicio_tipo_clienteB->getEsMargenUtilidad()) !== NULL) ){
				$sql .= " es_margen_utilidad >= ? AND es_margen_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " es_margen_utilidad = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $precio_servicio_tipo_clienteA->getPrecioUtilidad()) !== NULL) & ( ($b = $precio_servicio_tipo_clienteB->getPrecioUtilidad()) !== NULL) ){
				$sql .= " precio_utilidad >= ? AND precio_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " precio_utilidad = ? AND"; 
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
    		array_push( $ar, new PrecioServicioTipoCliente($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto PrecioServicioTipoCliente suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param PrecioServicioTipoCliente [$precio_servicio_tipo_cliente] El objeto de tipo PrecioServicioTipoCliente a eliminar
	  **/
	public static final function delete( &$precio_servicio_tipo_cliente )
	{
		if(self::getByPK($precio_servicio_tipo_cliente->getIdServicio(), $precio_servicio_tipo_cliente->getIdTipoCliente()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM precio_servicio_tipo_cliente WHERE  id_servicio = ? AND id_tipo_cliente = ?;";
		$params = array( $precio_servicio_tipo_cliente->getIdServicio(), $precio_servicio_tipo_cliente->getIdTipoCliente() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
