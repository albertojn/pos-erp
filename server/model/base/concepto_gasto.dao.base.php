<?php
/** ConceptoGasto Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ConceptoGasto }. 
  * @author Alan Gonzalez
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ConceptoGastoDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_concepto_gasto ){
			$pk = "";
			$pk .= $id_concepto_gasto . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_concepto_gasto){
			$pk = "";
			$pk .= $id_concepto_gasto . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_concepto_gasto ){
			$pk = "";
			$pk .= $id_concepto_gasto . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ConceptoGasto} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$concepto_gasto )
	{
		if( ! is_null ( self::getByPK(  $concepto_gasto->getIdConceptoGasto() ) ) )
		{
			try{ return ConceptoGastoDAOBase::update( $concepto_gasto) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ConceptoGastoDAOBase::create( $concepto_gasto) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ConceptoGasto} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ConceptoGasto} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ConceptoGasto Un objeto del tipo {@link ConceptoGasto}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_concepto_gasto )
	{
		if(self::recordExists(  $id_concepto_gasto)){
			return self::getRecord( $id_concepto_gasto );
		}
		$sql = "SELECT * FROM concepto_gasto WHERE (id_concepto_gasto = ? ) LIMIT 1;";
		$params = array(  $id_concepto_gasto );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ConceptoGasto( $rs );
			self::pushRecord( $foo,  $id_concepto_gasto );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ConceptoGasto}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ConceptoGasto}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from concepto_gasto";
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
			$bar = new ConceptoGasto($foo);
    		array_push( $allData, $bar);
			//id_concepto_gasto
    		self::pushRecord( $bar, $foo["id_concepto_gasto"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ConceptoGasto} de la base de datos. 
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
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $concepto_gasto , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from concepto_gasto WHERE ("; 
		$val = array();
		if( ! is_null( $concepto_gasto->getIdConceptoGasto() ) ){
			$sql .= " id_concepto_gasto = ? AND";
			array_push( $val, $concepto_gasto->getIdConceptoGasto() );
		}

		if( ! is_null( $concepto_gasto->getNombre() ) ){
			$sql .= " nombre = ? AND";
			array_push( $val, $concepto_gasto->getNombre() );
		}

		if( ! is_null( $concepto_gasto->getDescripcion() ) ){
			$sql .= " descripcion = ? AND";
			array_push( $val, $concepto_gasto->getDescripcion() );
		}

		if( ! is_null( $concepto_gasto->getMonto() ) ){
			$sql .= " monto = ? AND";
			array_push( $val, $concepto_gasto->getMonto() );
		}

		if( ! is_null( $concepto_gasto->getActivo() ) ){
			$sql .= " activo = ? AND";
			array_push( $val, $concepto_gasto->getActivo() );
		}

		if(sizeof($val) == 0){return array();}
		$sql = substr($sql, 0, -3) . " )";
		if( ! is_null ( $orderBy ) ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
			$bar =  new ConceptoGasto($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_concepto_gasto"] );
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
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto a actualizar.
	  **/
	private static final function update( $concepto_gasto )
	{
		$sql = "UPDATE concepto_gasto SET  nombre = ?, descripcion = ?, monto = ?, activo = ? WHERE  id_concepto_gasto = ?;";
		$params = array( 
			$concepto_gasto->getNombre(), 
			$concepto_gasto->getDescripcion(), 
			$concepto_gasto->getMonto(), 
			$concepto_gasto->getActivo(), 
			$concepto_gasto->getIdConceptoGasto(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ConceptoGasto suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ConceptoGasto dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto a crear.
	  **/
	private static final function create( &$concepto_gasto )
	{
		$sql = "INSERT INTO concepto_gasto ( id_concepto_gasto, nombre, descripcion, monto, activo ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$concepto_gasto->getIdConceptoGasto(), 
			$concepto_gasto->getNombre(), 
			$concepto_gasto->getDescripcion(), 
			$concepto_gasto->getMonto(), 
			$concepto_gasto->getActivo(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $concepto_gasto->setIdConceptoGasto( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ConceptoGasto} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ConceptoGasto}.
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
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $concepto_gastoA , $concepto_gastoB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from concepto_gasto WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $concepto_gastoA->getIdConceptoGasto()) ) ) & ( ! is_null ( ($b = $concepto_gastoB->getIdConceptoGasto()) ) ) ){
				$sql .= " id_concepto_gasto >= ? AND id_concepto_gasto <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " id_concepto_gasto = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $concepto_gastoA->getNombre()) ) ) & ( ! is_null ( ($b = $concepto_gastoB->getNombre()) ) ) ){
				$sql .= " nombre >= ? AND nombre <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " nombre = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $concepto_gastoA->getDescripcion()) ) ) & ( ! is_null ( ($b = $concepto_gastoB->getDescripcion()) ) ) ){
				$sql .= " descripcion >= ? AND descripcion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " descripcion = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $concepto_gastoA->getMonto()) ) ) & ( ! is_null ( ($b = $concepto_gastoB->getMonto()) ) ) ){
				$sql .= " monto >= ? AND monto <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " monto = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $concepto_gastoA->getActivo()) ) ) & ( ! is_null ( ($b = $concepto_gastoB->getActivo()) ) ) ){
				$sql .= " activo >= ? AND activo <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " activo = ? AND"; 
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
    		array_push( $ar, new ConceptoGasto($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ConceptoGasto suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ConceptoGasto [$concepto_gasto] El objeto de tipo ConceptoGasto a eliminar
	  **/
	public static final function delete( &$concepto_gasto )
	{
		if( is_null( self::getByPK($concepto_gasto->getIdConceptoGasto()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM concepto_gasto WHERE  id_concepto_gasto = ?;";
		$params = array( $concepto_gasto->getIdConceptoGasto() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
