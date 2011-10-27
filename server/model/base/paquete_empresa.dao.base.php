<?php
/** PaqueteEmpresa Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link PaqueteEmpresa }. 
  * @author Andres
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class PaqueteEmpresaDAOBase extends DAO
{

		private static $loadedRecords = array();

		private static function recordExists(  $id_paquete, $id_empresa ){
			$pk = "";
			$pk .= $id_paquete . "-";
			$pk .= $id_empresa . "-";
			return array_key_exists ( $pk , self::$loadedRecords );
		}
		private static function pushRecord( $inventario,  $id_paquete, $id_empresa){
			$pk = "";
			$pk .= $id_paquete . "-";
			$pk .= $id_empresa . "-";
			self::$loadedRecords [$pk] = $inventario;
		}
		private static function getRecord(  $id_paquete, $id_empresa ){
			$pk = "";
			$pk .= $id_paquete . "-";
			$pk .= $id_empresa . "-";
			return self::$loadedRecords[$pk];
		}
	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link PaqueteEmpresa} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$paquete_empresa )
	{
		if( ! is_null ( self::getByPK(  $paquete_empresa->getIdPaquete() , $paquete_empresa->getIdEmpresa() ) ) )
		{
			try{ return PaqueteEmpresaDAOBase::update( $paquete_empresa) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return PaqueteEmpresaDAOBase::create( $paquete_empresa) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link PaqueteEmpresa} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link PaqueteEmpresa} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link PaqueteEmpresa Un objeto del tipo {@link PaqueteEmpresa}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_paquete, $id_empresa )
	{
		if(self::recordExists(  $id_paquete, $id_empresa)){
			return self::getRecord( $id_paquete, $id_empresa );
		}
		$sql = "SELECT * FROM paquete_empresa WHERE (id_paquete = ? AND id_empresa = ? ) LIMIT 1;";
		$params = array(  $id_paquete, $id_empresa );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new PaqueteEmpresa( $rs );
			self::pushRecord( $foo,  $id_paquete, $id_empresa );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link PaqueteEmpresa}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link PaqueteEmpresa}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from paquete_empresa";
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
			$bar = new PaqueteEmpresa($foo);
    		array_push( $allData, $bar);
			//id_paquete
			//id_empresa
    		self::pushRecord( $bar, $foo["id_paquete"],$foo["id_empresa"] );
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link PaqueteEmpresa} de la base de datos. 
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
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $paquete_empresa , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from paquete_empresa WHERE ("; 
		$val = array();
		if( ! is_null( $paquete_empresa->getIdPaquete() ) ){
			$sql .= " id_paquete = ? AND";
			array_push( $val, $paquete_empresa->getIdPaquete() );
		}

		if( ! is_null( $paquete_empresa->getIdEmpresa() ) ){
			$sql .= " id_empresa = ? AND";
			array_push( $val, $paquete_empresa->getIdEmpresa() );
		}

		if( ! is_null( $paquete_empresa->getPrecioUtilidad() ) ){
			$sql .= " precio_utilidad = ? AND";
			array_push( $val, $paquete_empresa->getPrecioUtilidad() );
		}

		if( ! is_null( $paquete_empresa->getEsMargenUtilidad() ) ){
			$sql .= " es_margen_utilidad = ? AND";
			array_push( $val, $paquete_empresa->getEsMargenUtilidad() );
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
			$bar =  new PaqueteEmpresa($foo);
    		array_push( $ar,$bar);
    		self::pushRecord( $bar, $foo["id_paquete"],$foo["id_empresa"] );
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
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa a actualizar.
	  **/
	private static final function update( $paquete_empresa )
	{
		$sql = "UPDATE paquete_empresa SET  precio_utilidad = ?, es_margen_utilidad = ? WHERE  id_paquete = ? AND id_empresa = ?;";
		$params = array( 
			$paquete_empresa->getPrecioUtilidad(), 
			$paquete_empresa->getEsMargenUtilidad(), 
			$paquete_empresa->getIdPaquete(),$paquete_empresa->getIdEmpresa(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto PaqueteEmpresa suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto PaqueteEmpresa dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa a crear.
	  **/
	private static final function create( &$paquete_empresa )
	{
		$sql = "INSERT INTO paquete_empresa ( id_paquete, id_empresa, precio_utilidad, es_margen_utilidad ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$paquete_empresa->getIdPaquete(), 
			$paquete_empresa->getIdEmpresa(), 
			$paquete_empresa->getPrecioUtilidad(), 
			$paquete_empresa->getEsMargenUtilidad(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link PaqueteEmpresa} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link PaqueteEmpresa}.
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
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $paquete_empresaA , $paquete_empresaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from paquete_empresa WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $paquete_empresaA->getIdPaquete()) ) ) & ( ! is_null ( ($b = $paquete_empresaB->getIdPaquete()) ) ) ){
				$sql .= " id_paquete >= ? AND id_paquete <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " id_paquete = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $paquete_empresaA->getIdEmpresa()) ) ) & ( ! is_null ( ($b = $paquete_empresaB->getIdEmpresa()) ) ) ){
				$sql .= " id_empresa >= ? AND id_empresa <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " id_empresa = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $paquete_empresaA->getPrecioUtilidad()) ) ) & ( ! is_null ( ($b = $paquete_empresaB->getPrecioUtilidad()) ) ) ){
				$sql .= " precio_utilidad >= ? AND precio_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " precio_utilidad = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $paquete_empresaA->getEsMargenUtilidad()) ) ) & ( ! is_null ( ($b = $paquete_empresaB->getEsMargenUtilidad()) ) ) ){
				$sql .= " es_margen_utilidad >= ? AND es_margen_utilidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " es_margen_utilidad = ? AND"; 
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
    		array_push( $ar, new PaqueteEmpresa($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto PaqueteEmpresa suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param PaqueteEmpresa [$paquete_empresa] El objeto de tipo PaqueteEmpresa a eliminar
	  **/
	public static final function delete( &$paquete_empresa )
	{
		if( is_null( self::getByPK($paquete_empresa->getIdPaquete(), $paquete_empresa->getIdEmpresa()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM paquete_empresa WHERE  id_paquete = ? AND id_empresa = ?;";
		$params = array( $paquete_empresa->getIdPaquete(), $paquete_empresa->getIdEmpresa() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
