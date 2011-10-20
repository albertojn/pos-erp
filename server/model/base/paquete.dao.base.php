<?php
/** Paquete Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Paquete }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class PaqueteDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_paquete ){
			$pk = "";
			$pk .= $id_paquete . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_paquete){
			$pk = "";
			$pk .= $id_paquete . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_paquete ){
			$pk = "";
			$pk .= $id_paquete . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Paquete} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Paquete [$paquete] El objeto de tipo Paquete
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$paquete )
	{
		if(  self::getByPK(  $paquete->getIdPaquete() ) !== NULL )
		{
			try{ return PaqueteDAOBase::update( $paquete) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return PaqueteDAOBase::create( $paquete) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Paquete} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Paquete} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Paquete Un objeto del tipo {@link Paquete}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_paquete )
	{
		if(self::recordExists(  $id_paquete)){
			return self::getRecord( $id_paquete );
		}
		$sql = "SELECT * FROM paquete WHERE (id_paquete = ? ) LIMIT 1;";
		$params = array(  $id_paquete );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Paquete( $rs );
			self::pushRecord( $foo,  $id_paquete );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Paquete}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Paquete}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from paquete";
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
			$bar = new Paquete($foo);
    		array_push( $allData, $bar);
			//id_paquete
    		self::pushRecord( $bar, $foo["id_paquete"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Paquete} de la base de datos. 
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
	  * @param Paquete [$paquete] El objeto de tipo Paquete
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $paquete , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from paquete WHERE ("; 
		$val = array();
		if( $paquete->getIdPaquete() != NULL){
			$sql .= " id_paquete = ? AND";
			array_push( $val, $paquete->getIdPaquete() );
		}

		if( $paquete->getNombre() != NULL){
			$sql .= " nombre = ? AND";
			array_push( $val, $paquete->getNombre() );
		}

		if( $paquete->getDescripcion() != NULL){
			$sql .= " descripcion = ? AND";
			array_push( $val, $paquete->getDescripcion() );
		}

		if( $paquete->getMargenUtilidad() != NULL){
			$sql .= " margen_utilidad = ? AND";
			array_push( $val, $paquete->getMargenUtilidad() );
		}

		if( $paquete->getDescuento() != NULL){
			$sql .= " descuento = ? AND";
			array_push( $val, $paquete->getDescuento() );
		}

		if( $paquete->getFotoPaquete() != NULL){
			$sql .= " foto_paquete = ? AND";
			array_push( $val, $paquete->getFotoPaquete() );
		}

		if( $paquete->getCostoEstandar() != NULL){
			$sql .= " costo_estandar = ? AND";
			array_push( $val, $paquete->getCostoEstandar() );
		}

		if( $paquete->getPrecio() != NULL){
			$sql .= " precio = ? AND";
			array_push( $val, $paquete->getPrecio() );
		}

		if( $paquete->getActivo() != NULL){
			$sql .= " activo = ? AND";
			array_push( $val, $paquete->getActivo() );
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
			$bar =  new Paquete($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_paquete"] );
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
	  * @param Paquete [$paquete] El objeto de tipo Paquete a actualizar.
	  **/
	private static final function update( $paquete )
	{
		$sql = "UPDATE paquete SET  nombre = ?, descripcion = ?, margen_utilidad = ?, descuento = ?, foto_paquete = ?, costo_estandar = ?, precio = ?, activo = ? WHERE  id_paquete = ?;";
		$params = array( 
			$paquete->getNombre(), 
			$paquete->getDescripcion(), 
			$paquete->getMargenUtilidad(), 
			$paquete->getDescuento(), 
			$paquete->getFotoPaquete(), 
			$paquete->getCostoEstandar(), 
			$paquete->getPrecio(), 
			$paquete->getActivo(), 
			$paquete->getIdPaquete(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Paquete suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Paquete dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Paquete [$paquete] El objeto de tipo Paquete a crear.
	  **/
	private static final function create( &$paquete )
	{
		$sql = "INSERT INTO paquete ( id_paquete, nombre, descripcion, margen_utilidad, descuento, foto_paquete, costo_estandar, precio, activo ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$paquete->getIdPaquete(), 
			$paquete->getNombre(), 
			$paquete->getDescripcion(), 
			$paquete->getMargenUtilidad(), 
			$paquete->getDescuento(), 
			$paquete->getFotoPaquete(), 
			$paquete->getCostoEstandar(), 
			$paquete->getPrecio(), 
			$paquete->getActivo(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $paquete->setIdPaquete( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Paquete} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Paquete}.
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
	  * @param Paquete [$paquete] El objeto de tipo Paquete
	  * @param Paquete [$paquete] El objeto de tipo Paquete
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $paqueteA , $paqueteB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from paquete WHERE ("; 
		$val = array();
		if( (($a = $paqueteA->getIdPaquete()) !== NULL) & ( ($b = $paqueteB->getIdPaquete()) !== NULL) ){
				$sql .= " id_paquete >= ? AND id_paquete <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_paquete = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getNombre()) !== NULL) & ( ($b = $paqueteB->getNombre()) !== NULL) ){
				$sql .= " nombre >= ? AND nombre <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " nombre = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getDescripcion()) !== NULL) & ( ($b = $paqueteB->getDescripcion()) !== NULL) ){
				$sql .= " descripcion >= ? AND descripcion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " descripcion = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getMargenUtilidad()) !== NULL) & ( ($b = $paqueteB->getMargenUtilidad()) !== NULL) ){
				$sql .= " margen_utilidad >= ? AND margen_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " margen_utilidad = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getDescuento()) !== NULL) & ( ($b = $paqueteB->getDescuento()) !== NULL) ){
				$sql .= " descuento >= ? AND descuento <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " descuento = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getFotoPaquete()) !== NULL) & ( ($b = $paqueteB->getFotoPaquete()) !== NULL) ){
				$sql .= " foto_paquete >= ? AND foto_paquete <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " foto_paquete = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getCostoEstandar()) !== NULL) & ( ($b = $paqueteB->getCostoEstandar()) !== NULL) ){
				$sql .= " costo_estandar >= ? AND costo_estandar <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " costo_estandar = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getPrecio()) !== NULL) & ( ($b = $paqueteB->getPrecio()) !== NULL) ){
				$sql .= " precio >= ? AND precio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " precio = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paqueteA->getActivo()) !== NULL) & ( ($b = $paqueteB->getActivo()) !== NULL) ){
				$sql .= " activo >= ? AND activo <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " activo = ? AND"; 
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
    		array_push( $ar, new Paquete($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Paquete suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Paquete [$paquete] El objeto de tipo Paquete a eliminar
	  **/
	public static final function delete( &$paquete )
	{
		if(self::getByPK($paquete->getIdPaquete()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM paquete WHERE  id_paquete = ?;";
		$params = array( $paquete->getIdPaquete() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
