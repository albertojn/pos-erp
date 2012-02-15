<?php
/** EntradaAlmacen Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link EntradaAlmacen }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class EntradaAlmacenDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_entrada_almacen ){
			$pk = "";
			$pk .= $id_entrada_almacen . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_entrada_almacen){
			$pk = "";
			$pk .= $id_entrada_almacen . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_entrada_almacen ){
			$pk = "";
			$pk .= $id_entrada_almacen . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link EntradaAlmacen} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$entrada_almacen )
	{
		if( ! is_null ( self::getByPK(  $entrada_almacen->getIdEntradaAlmacen() ) ) )
		{
			try{ return EntradaAlmacenDAOBase::update( $entrada_almacen) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return EntradaAlmacenDAOBase::create( $entrada_almacen) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link EntradaAlmacen} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link EntradaAlmacen} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link EntradaAlmacen Un objeto del tipo {@link EntradaAlmacen}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_entrada_almacen )
	{
		if(self::recordExists(  $id_entrada_almacen)){
			return self::getRecord( $id_entrada_almacen );
		}
		$sql = "SELECT * FROM entrada_almacen WHERE (id_entrada_almacen = ? ) LIMIT 1;";
		$params = array(  $id_entrada_almacen );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new EntradaAlmacen( $rs );
			self::pushRecord( $foo,  $id_entrada_almacen );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link EntradaAlmacen}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link EntradaAlmacen}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from entrada_almacen";
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
			$bar = new EntradaAlmacen($foo);
    		array_push( $allData, $bar);
			//id_entrada_almacen
    		self::pushRecord( $bar, $foo["id_entrada_almacen"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link EntradaAlmacen} de la base de datos. 
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
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $entrada_almacen , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from entrada_almacen WHERE ("; 
		$val = array();
		if( ! is_null( $entrada_almacen->getIdEntradaAlmacen() ) ){
			$sql .= " id_entrada_almacen = ? AND";
			array_push( $val, $entrada_almacen->getIdEntradaAlmacen() );
		}

		if( ! is_null( $entrada_almacen->getIdAlmacen() ) ){
			$sql .= " id_almacen = ? AND";
			array_push( $val, $entrada_almacen->getIdAlmacen() );
		}

		if( ! is_null( $entrada_almacen->getIdUsuario() ) ){
			$sql .= " id_usuario = ? AND";
			array_push( $val, $entrada_almacen->getIdUsuario() );
		}

		if( ! is_null( $entrada_almacen->getFechaRegistro() ) ){
			$sql .= " fecha_registro = ? AND";
			array_push( $val, $entrada_almacen->getFechaRegistro() );
		}

		if( ! is_null( $entrada_almacen->getMotivo() ) ){
			$sql .= " motivo = ? AND";
			array_push( $val, $entrada_almacen->getMotivo() );
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
			$bar =  new EntradaAlmacen($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_entrada_almacen"] );
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
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen a actualizar.
	  **/
	private static final function update( $entrada_almacen )
	{
		$sql = "UPDATE entrada_almacen SET  id_almacen = ?, id_usuario = ?, fecha_registro = ?, motivo = ? WHERE  id_entrada_almacen = ?;";
		$params = array( 
			$entrada_almacen->getIdAlmacen(), 
			$entrada_almacen->getIdUsuario(), 
			$entrada_almacen->getFechaRegistro(), 
			$entrada_almacen->getMotivo(), 
			$entrada_almacen->getIdEntradaAlmacen(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto EntradaAlmacen suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto EntradaAlmacen dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen a crear.
	  **/
	private static final function create( &$entrada_almacen )
	{
		$sql = "INSERT INTO entrada_almacen ( id_entrada_almacen, id_almacen, id_usuario, fecha_registro, motivo ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$entrada_almacen->getIdEntradaAlmacen(), 
			$entrada_almacen->getIdAlmacen(), 
			$entrada_almacen->getIdUsuario(), 
			$entrada_almacen->getFechaRegistro(), 
			$entrada_almacen->getMotivo(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $entrada_almacen->setIdEntradaAlmacen( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link EntradaAlmacen} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link EntradaAlmacen}.
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
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $entrada_almacenA , $entrada_almacenB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from entrada_almacen WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $entrada_almacenA->getIdEntradaAlmacen()) ) ) & ( ! is_null ( ($b = $entrada_almacenB->getIdEntradaAlmacen()) ) ) ){
				$sql .= " id_entrada_almacen >= ? AND id_entrada_almacen <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " id_entrada_almacen = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $entrada_almacenA->getIdAlmacen()) ) ) & ( ! is_null ( ($b = $entrada_almacenB->getIdAlmacen()) ) ) ){
				$sql .= " id_almacen >= ? AND id_almacen <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " id_almacen = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $entrada_almacenA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $entrada_almacenB->getIdUsuario()) ) ) ){
				$sql .= " id_usuario >= ? AND id_usuario <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " id_usuario = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $entrada_almacenA->getFechaRegistro()) ) ) & ( ! is_null ( ($b = $entrada_almacenB->getFechaRegistro()) ) ) ){
				$sql .= " fecha_registro >= ? AND fecha_registro <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " fecha_registro = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $entrada_almacenA->getMotivo()) ) ) & ( ! is_null ( ($b = $entrada_almacenB->getMotivo()) ) ) ){
				$sql .= " motivo >= ? AND motivo <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " motivo = ? AND"; 
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
    		array_push( $ar, new EntradaAlmacen($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto EntradaAlmacen suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param EntradaAlmacen [$entrada_almacen] El objeto de tipo EntradaAlmacen a eliminar
	  **/
	public static final function delete( &$entrada_almacen )
	{
		if( is_null( self::getByPK($entrada_almacen->getIdEntradaAlmacen()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM entrada_almacen WHERE  id_entrada_almacen = ?;";
		$params = array( $entrada_almacen->getIdEntradaAlmacen() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
