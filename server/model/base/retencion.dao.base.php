<?php
/** Retencion Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Retencion }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class RetencionDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_retencion ){
			$pk = "";
			$pk .= $id_retencion . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_retencion){
			$pk = "";
			$pk .= $id_retencion . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_retencion ){
			$pk = "";
			$pk .= $id_retencion . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Retencion} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Retencion [$retencion] El objeto de tipo Retencion
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$retencion )
	{
		if(  self::getByPK(  $retencion->getIdRetencion() ) !== NULL )
		{
			try{ return RetencionDAOBase::update( $retencion) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return RetencionDAOBase::create( $retencion) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Retencion} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Retencion} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Retencion Un objeto del tipo {@link Retencion}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_retencion )
	{
		if(self::recordExists(  $id_retencion)){
			return self::getRecord( $id_retencion );
		}
		$sql = "SELECT * FROM retencion WHERE (id_retencion = ? ) LIMIT 1;";
		$params = array(  $id_retencion );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Retencion( $rs );
			self::pushRecord( $foo,  $id_retencion );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Retencion}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Retencion}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from retencion";
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
			$bar = new Retencion($foo);
    		array_push( $allData, $bar);
			//id_retencion
    		self::pushRecord( $bar, $foo["id_retencion"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Retencion} de la base de datos. 
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
	  * @param Retencion [$retencion] El objeto de tipo Retencion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $retencion , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from retencion WHERE ("; 
		$val = array();
		if( $retencion->getIdRetencion() != NULL){
			$sql .= " id_retencion = ? AND";
			array_push( $val, $retencion->getIdRetencion() );
		}

		if( $retencion->getMontoPorcentaje() != NULL){
			$sql .= " monto_porcentaje = ? AND";
			array_push( $val, $retencion->getMontoPorcentaje() );
		}

		if( $retencion->getEsMonto() != NULL){
			$sql .= " es_monto = ? AND";
			array_push( $val, $retencion->getEsMonto() );
		}

		if( $retencion->getNombre() != NULL){
			$sql .= " nombre = ? AND";
			array_push( $val, $retencion->getNombre() );
		}

		if( $retencion->getDescripcion() != NULL){
			$sql .= " descripcion = ? AND";
			array_push( $val, $retencion->getDescripcion() );
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
			$bar =  new Retencion($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_retencion"] );
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
	  * @param Retencion [$retencion] El objeto de tipo Retencion a actualizar.
	  **/
	private static final function update( $retencion )
	{
		$sql = "UPDATE retencion SET  monto_porcentaje = ?, es_monto = ?, nombre = ?, descripcion = ? WHERE  id_retencion = ?;";
		$params = array( 
			$retencion->getMontoPorcentaje(), 
			$retencion->getEsMonto(), 
			$retencion->getNombre(), 
			$retencion->getDescripcion(), 
			$retencion->getIdRetencion(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Retencion suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Retencion dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Retencion [$retencion] El objeto de tipo Retencion a crear.
	  **/
	private static final function create( &$retencion )
	{
		$sql = "INSERT INTO retencion ( id_retencion, monto_porcentaje, es_monto, nombre, descripcion ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$retencion->getIdRetencion(), 
			$retencion->getMontoPorcentaje(), 
			$retencion->getEsMonto(), 
			$retencion->getNombre(), 
			$retencion->getDescripcion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $retencion->setIdRetencion( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Retencion} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Retencion}.
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
	  * @param Retencion [$retencion] El objeto de tipo Retencion
	  * @param Retencion [$retencion] El objeto de tipo Retencion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $retencionA , $retencionB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from retencion WHERE ("; 
		$val = array();
		if( (($a = $retencionA->getIdRetencion()) != NULL) & ( ($b = $retencionB->getIdRetencion()) != NULL) ){
				$sql .= " id_retencion >= ? AND id_retencion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_retencion = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $retencionA->getMontoPorcentaje()) != NULL) & ( ($b = $retencionB->getMontoPorcentaje()) != NULL) ){
				$sql .= " monto_porcentaje >= ? AND monto_porcentaje <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " monto_porcentaje = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $retencionA->getEsMonto()) != NULL) & ( ($b = $retencionB->getEsMonto()) != NULL) ){
				$sql .= " es_monto >= ? AND es_monto <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " es_monto = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $retencionA->getNombre()) != NULL) & ( ($b = $retencionB->getNombre()) != NULL) ){
				$sql .= " nombre >= ? AND nombre <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " nombre = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $retencionA->getDescripcion()) != NULL) & ( ($b = $retencionB->getDescripcion()) != NULL) ){
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
    		array_push( $ar, new Retencion($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Retencion suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Retencion [$retencion] El objeto de tipo Retencion a eliminar
	  **/
	public static final function delete( &$retencion )
	{
		if(self::getByPK($retencion->getIdRetencion()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM retencion WHERE  id_retencion = ?;";
		$params = array( $retencion->getIdRetencion() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
