<?php
/** VentaArpilla Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link VentaArpilla }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class VentaArpillaDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_venta_arpilla ){
			$pk = "";
			$pk .= $id_venta_arpilla . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_venta_arpilla){
			$pk = "";
			$pk .= $id_venta_arpilla . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_venta_arpilla ){
			$pk = "";
			$pk .= $id_venta_arpilla . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link VentaArpilla} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$venta_arpilla )
	{
		if(  self::getByPK(  $venta_arpilla->getIdVentaArpilla() ) !== NULL )
		{
			try{ return VentaArpillaDAOBase::update( $venta_arpilla) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return VentaArpillaDAOBase::create( $venta_arpilla) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link VentaArpilla} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link VentaArpilla} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link VentaArpilla Un objeto del tipo {@link VentaArpilla}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_venta_arpilla )
	{
		if(self::recordExists(  $id_venta_arpilla)){
			return self::getRecord( $id_venta_arpilla );
		}
		$sql = "SELECT * FROM venta_arpilla WHERE (id_venta_arpilla = ? ) LIMIT 1;";
		$params = array(  $id_venta_arpilla );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new VentaArpilla( $rs );
			self::pushRecord( $foo,  $id_venta_arpilla );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link VentaArpilla}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link VentaArpilla}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from venta_arpilla";
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
			$bar = new VentaArpilla($foo);
    		array_push( $allData, $bar);
			//id_venta_arpilla
    		self::pushRecord( $bar, $foo["id_venta_arpilla"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link VentaArpilla} de la base de datos. 
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
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $venta_arpilla , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta_arpilla WHERE ("; 
		$val = array();
		if( $venta_arpilla->getIdVentaArpilla() != NULL){
			$sql .= " id_venta_arpilla = ? AND";
			array_push( $val, $venta_arpilla->getIdVentaArpilla() );
		}

		if( $venta_arpilla->getIdVenta() != NULL){
			$sql .= " id_venta = ? AND";
			array_push( $val, $venta_arpilla->getIdVenta() );
		}

		if( $venta_arpilla->getPesoDestino() != NULL){
			$sql .= " peso_destino = ? AND";
			array_push( $val, $venta_arpilla->getPesoDestino() );
		}

		if( $venta_arpilla->getFechaOrigen() != NULL){
			$sql .= " fecha_origen = ? AND";
			array_push( $val, $venta_arpilla->getFechaOrigen() );
		}

		if( $venta_arpilla->getFolio() != NULL){
			$sql .= " folio = ? AND";
			array_push( $val, $venta_arpilla->getFolio() );
		}

		if( $venta_arpilla->getNumeroDeViaje() != NULL){
			$sql .= " numero_de_viaje = ? AND";
			array_push( $val, $venta_arpilla->getNumeroDeViaje() );
		}

		if( $venta_arpilla->getPesoOrigen() != NULL){
			$sql .= " peso_origen = ? AND";
			array_push( $val, $venta_arpilla->getPesoOrigen() );
		}

		if( $venta_arpilla->getArpillas() != NULL){
			$sql .= " arpillas = ? AND";
			array_push( $val, $venta_arpilla->getArpillas() );
		}

		if( $venta_arpilla->getPesoPorArpilla() != NULL){
			$sql .= " peso_por_arpilla = ? AND";
			array_push( $val, $venta_arpilla->getPesoPorArpilla() );
		}

		if( $venta_arpilla->getProductor() != NULL){
			$sql .= " productor = ? AND";
			array_push( $val, $venta_arpilla->getProductor() );
		}

		if( $venta_arpilla->getMermaPorArpilla() != NULL){
			$sql .= " merma_por_arpilla = ? AND";
			array_push( $val, $venta_arpilla->getMermaPorArpilla() );
		}

		if( $venta_arpilla->getTotalOrigen() != NULL){
			$sql .= " total_origen = ? AND";
			array_push( $val, $venta_arpilla->getTotalOrigen() );
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
			$bar =  new VentaArpilla($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_venta_arpilla"] );
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
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla a actualizar.
	  **/
	private static final function update( $venta_arpilla )
	{
		$sql = "UPDATE venta_arpilla SET  id_venta = ?, peso_destino = ?, fecha_origen = ?, folio = ?, numero_de_viaje = ?, peso_origen = ?, arpillas = ?, peso_por_arpilla = ?, productor = ?, merma_por_arpilla = ?, total_origen = ? WHERE  id_venta_arpilla = ?;";
		$params = array( 
			$venta_arpilla->getIdVenta(), 
			$venta_arpilla->getPesoDestino(), 
			$venta_arpilla->getFechaOrigen(), 
			$venta_arpilla->getFolio(), 
			$venta_arpilla->getNumeroDeViaje(), 
			$venta_arpilla->getPesoOrigen(), 
			$venta_arpilla->getArpillas(), 
			$venta_arpilla->getPesoPorArpilla(), 
			$venta_arpilla->getProductor(), 
			$venta_arpilla->getMermaPorArpilla(), 
			$venta_arpilla->getTotalOrigen(), 
			$venta_arpilla->getIdVentaArpilla(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto VentaArpilla suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto VentaArpilla dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla a crear.
	  **/
	private static final function create( &$venta_arpilla )
	{
		$sql = "INSERT INTO venta_arpilla ( id_venta_arpilla, id_venta, peso_destino, fecha_origen, folio, numero_de_viaje, peso_origen, arpillas, peso_por_arpilla, productor, merma_por_arpilla, total_origen ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$venta_arpilla->getIdVentaArpilla(), 
			$venta_arpilla->getIdVenta(), 
			$venta_arpilla->getPesoDestino(), 
			$venta_arpilla->getFechaOrigen(), 
			$venta_arpilla->getFolio(), 
			$venta_arpilla->getNumeroDeViaje(), 
			$venta_arpilla->getPesoOrigen(), 
			$venta_arpilla->getArpillas(), 
			$venta_arpilla->getPesoPorArpilla(), 
			$venta_arpilla->getProductor(), 
			$venta_arpilla->getMermaPorArpilla(), 
			$venta_arpilla->getTotalOrigen(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $venta_arpilla->setIdVentaArpilla( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link VentaArpilla} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link VentaArpilla}.
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
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $venta_arpillaA , $venta_arpillaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta_arpilla WHERE ("; 
		$val = array();
		if( (($a = $venta_arpillaA->getIdVentaArpilla()) != NULL) & ( ($b = $venta_arpillaB->getIdVentaArpilla()) != NULL) ){
				$sql .= " id_venta_arpilla >= ? AND id_venta_arpilla <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_venta_arpilla = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getIdVenta()) != NULL) & ( ($b = $venta_arpillaB->getIdVenta()) != NULL) ){
				$sql .= " id_venta >= ? AND id_venta <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_venta = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getPesoDestino()) != NULL) & ( ($b = $venta_arpillaB->getPesoDestino()) != NULL) ){
				$sql .= " peso_destino >= ? AND peso_destino <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " peso_destino = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getFechaOrigen()) != NULL) & ( ($b = $venta_arpillaB->getFechaOrigen()) != NULL) ){
				$sql .= " fecha_origen >= ? AND fecha_origen <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " fecha_origen = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getFolio()) != NULL) & ( ($b = $venta_arpillaB->getFolio()) != NULL) ){
				$sql .= " folio >= ? AND folio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " folio = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getNumeroDeViaje()) != NULL) & ( ($b = $venta_arpillaB->getNumeroDeViaje()) != NULL) ){
				$sql .= " numero_de_viaje >= ? AND numero_de_viaje <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " numero_de_viaje = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getPesoOrigen()) != NULL) & ( ($b = $venta_arpillaB->getPesoOrigen()) != NULL) ){
				$sql .= " peso_origen >= ? AND peso_origen <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " peso_origen = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getArpillas()) != NULL) & ( ($b = $venta_arpillaB->getArpillas()) != NULL) ){
				$sql .= " arpillas >= ? AND arpillas <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " arpillas = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getPesoPorArpilla()) != NULL) & ( ($b = $venta_arpillaB->getPesoPorArpilla()) != NULL) ){
				$sql .= " peso_por_arpilla >= ? AND peso_por_arpilla <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " peso_por_arpilla = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getProductor()) != NULL) & ( ($b = $venta_arpillaB->getProductor()) != NULL) ){
				$sql .= " productor >= ? AND productor <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " productor = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getMermaPorArpilla()) != NULL) & ( ($b = $venta_arpillaB->getMermaPorArpilla()) != NULL) ){
				$sql .= " merma_por_arpilla >= ? AND merma_por_arpilla <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " merma_por_arpilla = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $venta_arpillaA->getTotalOrigen()) != NULL) & ( ($b = $venta_arpillaB->getTotalOrigen()) != NULL) ){
				$sql .= " total_origen >= ? AND total_origen <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " total_origen = ? AND"; 
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
    		array_push( $ar, new VentaArpilla($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto VentaArpilla suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param VentaArpilla [$venta_arpilla] El objeto de tipo VentaArpilla a eliminar
	  **/
	public static final function delete( &$venta_arpilla )
	{
		if(self::getByPK($venta_arpilla->getIdVentaArpilla()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM venta_arpilla WHERE  id_venta_arpilla = ?;";
		$params = array( $venta_arpilla->getIdVentaArpilla() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
