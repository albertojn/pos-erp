<?php
/** PaqueteSucursal Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link PaqueteSucursal }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class PaqueteSucursalDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_paquete, $id_sucursal ){
			$pk = "";
			$pk .= $id_paquete . "-";
			$pk .= $id_sucursal . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_paquete, $id_sucursal){
			$pk = "";
			$pk .= $id_paquete . "-";
			$pk .= $id_sucursal . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_paquete, $id_sucursal ){
			$pk = "";
			$pk .= $id_paquete . "-";
			$pk .= $id_sucursal . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link PaqueteSucursal} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$paquete_sucursal )
	{
		if(  self::getByPK(  $paquete_sucursal->getIdPaquete() , $paquete_sucursal->getIdSucursal() ) !== NULL )
		{
			try{ return PaqueteSucursalDAOBase::update( $paquete_sucursal) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return PaqueteSucursalDAOBase::create( $paquete_sucursal) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link PaqueteSucursal} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link PaqueteSucursal} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link PaqueteSucursal Un objeto del tipo {@link PaqueteSucursal}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_paquete, $id_sucursal )
	{
		if(self::recordExists(  $id_paquete, $id_sucursal)){
			return self::getRecord( $id_paquete, $id_sucursal );
		}
		$sql = "SELECT * FROM paquete_sucursal WHERE (id_paquete = ? AND id_sucursal = ? ) LIMIT 1;";
		$params = array(  $id_paquete, $id_sucursal );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new PaqueteSucursal( $rs );
			self::pushRecord( $foo,  $id_paquete, $id_sucursal );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link PaqueteSucursal}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link PaqueteSucursal}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from paquete_sucursal";
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
			$bar = new PaqueteSucursal($foo);
    		array_push( $allData, $bar);
			//id_paquete
			//id_sucursal
    		self::pushRecord( $bar, $foo["id_paquete"],$foo["id_sucursal"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link PaqueteSucursal} de la base de datos. 
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
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $paquete_sucursal , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from paquete_sucursal WHERE ("; 
		$val = array();
		if( $paquete_sucursal->getIdPaquete() != NULL){
			$sql .= " id_paquete = ? AND";
			array_push( $val, $paquete_sucursal->getIdPaquete() );
		}

		if( $paquete_sucursal->getIdSucursal() != NULL){
			$sql .= " id_sucursal = ? AND";
			array_push( $val, $paquete_sucursal->getIdSucursal() );
		}

		if( $paquete_sucursal->getPrecioUtilidad() != NULL){
			$sql .= " precio_utilidad = ? AND";
			array_push( $val, $paquete_sucursal->getPrecioUtilidad() );
		}

		if( $paquete_sucursal->getEsMargenUtilidad() != NULL){
			$sql .= " es_margen_utilidad = ? AND";
			array_push( $val, $paquete_sucursal->getEsMargenUtilidad() );
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
			$bar =  new PaqueteSucursal($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_paquete"],$foo["id_sucursal"] );
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
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal a actualizar.
	  **/
	private static final function update( $paquete_sucursal )
	{
		$sql = "UPDATE paquete_sucursal SET  precio_utilidad = ?, es_margen_utilidad = ? WHERE  id_paquete = ? AND id_sucursal = ?;";
		$params = array( 
			$paquete_sucursal->getPrecioUtilidad(), 
			$paquete_sucursal->getEsMargenUtilidad(), 
			$paquete_sucursal->getIdPaquete(),$paquete_sucursal->getIdSucursal(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto PaqueteSucursal suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto PaqueteSucursal dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal a crear.
	  **/
	private static final function create( &$paquete_sucursal )
	{
		$sql = "INSERT INTO paquete_sucursal ( id_paquete, id_sucursal, precio_utilidad, es_margen_utilidad ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$paquete_sucursal->getIdPaquete(), 
			$paquete_sucursal->getIdSucursal(), 
			$paquete_sucursal->getPrecioUtilidad(), 
			$paquete_sucursal->getEsMargenUtilidad(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link PaqueteSucursal} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link PaqueteSucursal}.
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
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $paquete_sucursalA , $paquete_sucursalB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from paquete_sucursal WHERE ("; 
		$val = array();
		if( (($a = $paquete_sucursalA->getIdPaquete()) !== NULL) & ( ($b = $paquete_sucursalB->getIdPaquete()) !== NULL) ){
				$sql .= " id_paquete >= ? AND id_paquete <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_paquete = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paquete_sucursalA->getIdSucursal()) !== NULL) & ( ($b = $paquete_sucursalB->getIdSucursal()) !== NULL) ){
				$sql .= " id_sucursal >= ? AND id_sucursal <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " id_sucursal = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paquete_sucursalA->getPrecioUtilidad()) !== NULL) & ( ($b = $paquete_sucursalB->getPrecioUtilidad()) !== NULL) ){
				$sql .= " precio_utilidad >= ? AND precio_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a !== NULL|| $b !== NULL ){
			$sql .= " precio_utilidad = ? AND"; 
			$a = $a === NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $paquete_sucursalA->getEsMargenUtilidad()) !== NULL) & ( ($b = $paquete_sucursalB->getEsMargenUtilidad()) !== NULL) ){
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
    		array_push( $ar, new PaqueteSucursal($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto PaqueteSucursal suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param PaqueteSucursal [$paquete_sucursal] El objeto de tipo PaqueteSucursal a eliminar
	  **/
	public static final function delete( &$paquete_sucursal )
	{
		if(self::getByPK($paquete_sucursal->getIdPaquete(), $paquete_sucursal->getIdSucursal()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM paquete_sucursal WHERE  id_paquete = ? AND id_sucursal = ?;";
		$params = array( $paquete_sucursal->getIdPaquete(), $paquete_sucursal->getIdSucursal() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
