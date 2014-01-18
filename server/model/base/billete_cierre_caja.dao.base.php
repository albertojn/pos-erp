<?php
/** BilleteCierreCaja Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link BilleteCierreCaja }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class BilleteCierreCajaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link BilleteCierreCaja} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$billete_cierre_caja )
	{
		if( ! is_null ( self::getByPK(  $billete_cierre_caja->getIdBillete() , $billete_cierre_caja->getIdCierreCaja() ) ) )
		{
			try{ return BilleteCierreCajaDAOBase::update( $billete_cierre_caja) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return BilleteCierreCajaDAOBase::create( $billete_cierre_caja) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link BilleteCierreCaja} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link BilleteCierreCaja} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link BilleteCierreCaja Un objeto del tipo {@link BilleteCierreCaja}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_billete, $id_cierre_caja )
	{
		$sql = "SELECT * FROM billete_cierre_caja WHERE (id_billete = ? AND id_cierre_caja = ? ) LIMIT 1;";
		$params = array(  $id_billete, $id_cierre_caja );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new BilleteCierreCaja( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link BilleteCierreCaja}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link BilleteCierreCaja}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from billete_cierre_caja";
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
			$bar = new BilleteCierreCaja($foo);
    		array_push( $allData, $bar);
			//id_billete
			//id_cierre_caja
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link BilleteCierreCaja} de la base de datos. 
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
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $billete_cierre_caja , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from billete_cierre_caja WHERE ("; 
		$val = array();
		if( ! is_null( $billete_cierre_caja->getIdBillete() ) ){
			$sql .= " `id_billete` = ? AND";
			array_push( $val, $billete_cierre_caja->getIdBillete() );
		}

		if( ! is_null( $billete_cierre_caja->getIdCierreCaja() ) ){
			$sql .= " `id_cierre_caja` = ? AND";
			array_push( $val, $billete_cierre_caja->getIdCierreCaja() );
		}

		if( ! is_null( $billete_cierre_caja->getCantidadEncontrada() ) ){
			$sql .= " `cantidad_encontrada` = ? AND";
			array_push( $val, $billete_cierre_caja->getCantidadEncontrada() );
		}

		if( ! is_null( $billete_cierre_caja->getCantidadSobrante() ) ){
			$sql .= " `cantidad_sobrante` = ? AND";
			array_push( $val, $billete_cierre_caja->getCantidadSobrante() );
		}

		if( ! is_null( $billete_cierre_caja->getCantidadFaltante() ) ){
			$sql .= " `cantidad_faltante` = ? AND";
			array_push( $val, $billete_cierre_caja->getCantidadFaltante() );
		}

		if(sizeof($val) == 0){return self::getAll(/* $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' */);}
		$sql = substr($sql, 0, -3) . " )";
		if( ! is_null ( $orderBy ) ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
			$bar =  new BilleteCierreCaja($foo);
    		array_push( $ar,$bar);
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
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja a actualizar.
	  **/
	private static final function update( $billete_cierre_caja )
	{
		$sql = "UPDATE billete_cierre_caja SET  `cantidad_encontrada` = ?, `cantidad_sobrante` = ?, `cantidad_faltante` = ? WHERE  `id_billete` = ? AND `id_cierre_caja` = ?;";
		$params = array( 
			$billete_cierre_caja->getCantidadEncontrada(), 
			$billete_cierre_caja->getCantidadSobrante(), 
			$billete_cierre_caja->getCantidadFaltante(), 
			$billete_cierre_caja->getIdBillete(),$billete_cierre_caja->getIdCierreCaja(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto BilleteCierreCaja suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto BilleteCierreCaja dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja a crear.
	  **/
	private static final function create( &$billete_cierre_caja )
	{
		$sql = "INSERT INTO billete_cierre_caja ( `id_billete`, `id_cierre_caja`, `cantidad_encontrada`, `cantidad_sobrante`, `cantidad_faltante` ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$billete_cierre_caja->getIdBillete(), 
			$billete_cierre_caja->getIdCierreCaja(), 
			$billete_cierre_caja->getCantidadEncontrada(), 
			$billete_cierre_caja->getCantidadSobrante(), 
			$billete_cierre_caja->getCantidadFaltante(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link BilleteCierreCaja} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link BilleteCierreCaja}.
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
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $billete_cierre_cajaA , $billete_cierre_cajaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from billete_cierre_caja WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $billete_cierre_cajaA->getIdBillete()) ) ) & ( ! is_null ( ($b = $billete_cierre_cajaB->getIdBillete()) ) ) ){
				$sql .= " `id_billete` >= ? AND `id_billete` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_billete` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_cierre_cajaA->getIdCierreCaja()) ) ) & ( ! is_null ( ($b = $billete_cierre_cajaB->getIdCierreCaja()) ) ) ){
				$sql .= " `id_cierre_caja` >= ? AND `id_cierre_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_cierre_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_cierre_cajaA->getCantidadEncontrada()) ) ) & ( ! is_null ( ($b = $billete_cierre_cajaB->getCantidadEncontrada()) ) ) ){
				$sql .= " `cantidad_encontrada` >= ? AND `cantidad_encontrada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_encontrada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_cierre_cajaA->getCantidadSobrante()) ) ) & ( ! is_null ( ($b = $billete_cierre_cajaB->getCantidadSobrante()) ) ) ){
				$sql .= " `cantidad_sobrante` >= ? AND `cantidad_sobrante` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_sobrante` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_cierre_cajaA->getCantidadFaltante()) ) ) & ( ! is_null ( ($b = $billete_cierre_cajaB->getCantidadFaltante()) ) ) ){
				$sql .= " `cantidad_faltante` >= ? AND `cantidad_faltante` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_faltante` = ? AND"; 
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
    		array_push( $ar, new BilleteCierreCaja($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto BilleteCierreCaja suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param BilleteCierreCaja [$billete_cierre_caja] El objeto de tipo BilleteCierreCaja a eliminar
	  **/
	public static final function delete( &$billete_cierre_caja )
	{
		if( is_null( self::getByPK($billete_cierre_caja->getIdBillete(), $billete_cierre_caja->getIdCierreCaja()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM billete_cierre_caja WHERE  id_billete = ? AND id_cierre_caja = ?;";
		$params = array( $billete_cierre_caja->getIdBillete(), $billete_cierre_caja->getIdCierreCaja() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
