<?php
/** Caja Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Caja }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class CajaDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_caja ){
			$pk = "";
			$pk .= $id_caja . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_caja){
			$pk = "";
			$pk .= $id_caja . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_caja ){
			$pk = "";
			$pk .= $id_caja . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Caja} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Caja [$caja] El objeto de tipo Caja
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$caja )
	{
		if(  self::getByPK(  $caja->getIdCaja() ) !== NULL )
		{
			try{ return CajaDAOBase::update( $caja) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return CajaDAOBase::create( $caja) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Caja} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Caja} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Caja Un objeto del tipo {@link Caja}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_caja )
	{
		if(self::recordExists(  $id_caja)){
			return self::getRecord( $id_caja );
		}
		$sql = "SELECT * FROM caja WHERE (id_caja = ? ) LIMIT 1;";
		$params = array(  $id_caja );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Caja( $rs );
			self::pushRecord( $foo,  $id_caja );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Caja}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Caja}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from caja";
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
			$bar = new Caja($foo);
    		array_push( $allData, $bar);
			//id_caja
    		self::pushRecord( $bar, $foo["id_caja"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Caja} de la base de datos. 
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
	  * @param Caja [$caja] El objeto de tipo Caja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $caja , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from caja WHERE ("; 
		$val = array();
		if( $caja->getIdCaja() != NULL){
			$sql .= " id_caja = ? AND";
			array_push( $val, $caja->getIdCaja() );
		}

		if( $caja->getIdSucursal() != NULL){
			$sql .= " id_sucursal = ? AND";
			array_push( $val, $caja->getIdSucursal() );
		}

		if( $caja->getToken() != NULL){
			$sql .= " token = ? AND";
			array_push( $val, $caja->getToken() );
		}

		if( $caja->getDescripcion() != NULL){
			$sql .= " descripcion = ? AND";
			array_push( $val, $caja->getDescripcion() );
		}

		if( $caja->getAbierta() != NULL){
			$sql .= " abierta = ? AND";
			array_push( $val, $caja->getAbierta() );
		}

		if( $caja->getSaldo() != NULL){
			$sql .= " saldo = ? AND";
			array_push( $val, $caja->getSaldo() );
		}

		if( $caja->getControlBilletes() != NULL){
			$sql .= " control_billetes = ? AND";
			array_push( $val, $caja->getControlBilletes() );
		}

		if( $caja->getActiva() != NULL){
			$sql .= " activa = ? AND";
			array_push( $val, $caja->getActiva() );
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
			$bar =  new Caja($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_caja"] );
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
	  * @param Caja [$caja] El objeto de tipo Caja a actualizar.
	  **/
	private static final function update( $caja )
	{
		$sql = "UPDATE caja SET  id_sucursal = ?, token = ?, descripcion = ?, abierta = ?, saldo = ?, control_billetes = ?, activa = ? WHERE  id_caja = ?;";
		$params = array( 
			$caja->getIdSucursal(), 
			$caja->getToken(), 
			$caja->getDescripcion(), 
			$caja->getAbierta(), 
			$caja->getSaldo(), 
			$caja->getControlBilletes(), 
			$caja->getActiva(), 
			$caja->getIdCaja(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Caja suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Caja dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Caja [$caja] El objeto de tipo Caja a crear.
	  **/
	private static final function create( &$caja )
	{
		$sql = "INSERT INTO caja ( id_caja, id_sucursal, token, descripcion, abierta, saldo, control_billetes, activa ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$caja->getIdCaja(), 
			$caja->getIdSucursal(), 
			$caja->getToken(), 
			$caja->getDescripcion(), 
			$caja->getAbierta(), 
			$caja->getSaldo(), 
			$caja->getControlBilletes(), 
			$caja->getActiva(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $caja->setIdCaja( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Caja} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Caja}.
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
	  * @param Caja [$caja] El objeto de tipo Caja
	  * @param Caja [$caja] El objeto de tipo Caja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $cajaA , $cajaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from caja WHERE ("; 
		$val = array();
		if( (($a = $cajaA->getIdCaja()) != NULL) & ( ($b = $cajaB->getIdCaja()) != NULL) ){
				$sql .= " id_caja >= ? AND id_caja <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_caja = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getIdSucursal()) != NULL) & ( ($b = $cajaB->getIdSucursal()) != NULL) ){
				$sql .= " id_sucursal >= ? AND id_sucursal <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_sucursal = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getToken()) != NULL) & ( ($b = $cajaB->getToken()) != NULL) ){
				$sql .= " token >= ? AND token <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " token = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getDescripcion()) != NULL) & ( ($b = $cajaB->getDescripcion()) != NULL) ){
				$sql .= " descripcion >= ? AND descripcion <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " descripcion = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getAbierta()) != NULL) & ( ($b = $cajaB->getAbierta()) != NULL) ){
				$sql .= " abierta >= ? AND abierta <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " abierta = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getSaldo()) != NULL) & ( ($b = $cajaB->getSaldo()) != NULL) ){
				$sql .= " saldo >= ? AND saldo <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " saldo = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getControlBilletes()) != NULL) & ( ($b = $cajaB->getControlBilletes()) != NULL) ){
				$sql .= " control_billetes >= ? AND control_billetes <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " control_billetes = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $cajaA->getActiva()) != NULL) & ( ($b = $cajaB->getActiva()) != NULL) ){
				$sql .= " activa >= ? AND activa <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " activa = ? AND"; 
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
    		array_push( $ar, new Caja($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Caja suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Caja [$caja] El objeto de tipo Caja a eliminar
	  **/
	public static final function delete( &$caja )
	{
		if(self::getByPK($caja->getIdCaja()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM caja WHERE  id_caja = ?;";
		$params = array( $caja->getIdCaja() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
