<?php
/** GastosFijos Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link GastosFijos }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class GastosFijosDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_gasto_fijo ){
			$pk = "";
			$pk .= $id_gasto_fijo . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_gasto_fijo){
			$pk = "";
			$pk .= $id_gasto_fijo . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_gasto_fijo ){
			$pk = "";
			$pk .= $id_gasto_fijo . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link GastosFijos} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$gastos_fijos )
	{
		if(  self::getByPK(  $gastos_fijos->getIdGastoFijo() ) !== NULL )
		{
			try{ return GastosFijosDAOBase::update( $gastos_fijos) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return GastosFijosDAOBase::create( $gastos_fijos) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link GastosFijos} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link GastosFijos} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link GastosFijos Un objeto del tipo {@link GastosFijos}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_gasto_fijo )
	{
		if(self::recordExists(  $id_gasto_fijo)){
			return self::getRecord( $id_gasto_fijo );
		}
		$sql = "SELECT * FROM gastos_fijos WHERE (id_gasto_fijo = ? ) LIMIT 1;";
		$params = array(  $id_gasto_fijo );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new GastosFijos( $rs );
			self::pushRecord( $foo,  $id_gasto_fijo );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link GastosFijos}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link GastosFijos}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from gastos_fijos";
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
			$bar = new GastosFijos($foo);
    		array_push( $allData, $bar);
			//id_gasto_fijo
    		self::pushRecord( $bar, $foo["id_gasto_fijo"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link GastosFijos} de la base de datos. 
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
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $gastos_fijos , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from gastos_fijos WHERE ("; 
		$val = array();
		if( $gastos_fijos->getIdGastoFijo() != NULL){
			$sql .= " id_gasto_fijo = ? AND";
			array_push( $val, $gastos_fijos->getIdGastoFijo() );
		}

		if( $gastos_fijos->getNombre() != NULL){
			$sql .= " nombre = ? AND";
			array_push( $val, $gastos_fijos->getNombre() );
		}

		if( $gastos_fijos->getDescripcion() != NULL){
			$sql .= " descripcion = ? AND";
			array_push( $val, $gastos_fijos->getDescripcion() );
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
			$bar =  new GastosFijos($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_gasto_fijo"] );
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
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos a actualizar.
	  **/
	private static final function update( $gastos_fijos )
	{
		$sql = "UPDATE gastos_fijos SET  nombre = ?, descripcion = ? WHERE  id_gasto_fijo = ?;";
		$params = array( 
			$gastos_fijos->getNombre(), 
			$gastos_fijos->getDescripcion(), 
			$gastos_fijos->getIdGastoFijo(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto GastosFijos suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto GastosFijos dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos a crear.
	  **/
	private static final function create( &$gastos_fijos )
	{
		$sql = "INSERT INTO gastos_fijos ( id_gasto_fijo, nombre, descripcion ) VALUES ( ?, ?, ?);";
		$params = array( 
			$gastos_fijos->getIdGastoFijo(), 
			$gastos_fijos->getNombre(), 
			$gastos_fijos->getDescripcion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $gastos_fijos->setIdGastoFijo( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link GastosFijos} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link GastosFijos}.
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
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $gastos_fijosA , $gastos_fijosB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from gastos_fijos WHERE ("; 
		$val = array();
		if( (($a = $gastos_fijosA->getIdGastoFijo()) != NULL) & ( ($b = $gastos_fijosB->getIdGastoFijo()) != NULL) ){
				$sql .= " id_gasto_fijo >= ? AND id_gasto_fijo <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_gasto_fijo = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $gastos_fijosA->getNombre()) != NULL) & ( ($b = $gastos_fijosB->getNombre()) != NULL) ){
				$sql .= " nombre >= ? AND nombre <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " nombre = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $gastos_fijosA->getDescripcion()) != NULL) & ( ($b = $gastos_fijosB->getDescripcion()) != NULL) ){
				$sql .= " descripcion >= ? AND descripcion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " descripcion = ? AND"; 
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
    		array_push( $ar, new GastosFijos($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto GastosFijos suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param GastosFijos [$gastos_fijos] El objeto de tipo GastosFijos a eliminar
	  **/
	public static final function delete( &$gastos_fijos )
	{
		if(self::getByPK($gastos_fijos->getIdGastoFijo()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM gastos_fijos WHERE  id_gasto_fijo = ?;";
		$params = array( $gastos_fijos->getIdGastoFijo() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
