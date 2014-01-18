<?php
/** BilleteCorteCaja Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link BilleteCorteCaja }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class BilleteCorteCajaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link BilleteCorteCaja} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$billete_corte_caja )
	{
		if( ! is_null ( self::getByPK(  $billete_corte_caja->getIdBillete() , $billete_corte_caja->getIdCorteCaja() ) ) )
		{
			try{ return BilleteCorteCajaDAOBase::update( $billete_corte_caja) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return BilleteCorteCajaDAOBase::create( $billete_corte_caja) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link BilleteCorteCaja} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link BilleteCorteCaja} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link BilleteCorteCaja Un objeto del tipo {@link BilleteCorteCaja}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_billete, $id_corte_caja )
	{
		$sql = "SELECT * FROM billete_corte_caja WHERE (id_billete = ? AND id_corte_caja = ? ) LIMIT 1;";
		$params = array(  $id_billete, $id_corte_caja );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new BilleteCorteCaja( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link BilleteCorteCaja}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link BilleteCorteCaja}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from billete_corte_caja";
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
			$bar = new BilleteCorteCaja($foo);
    		array_push( $allData, $bar);
			//id_billete
			//id_corte_caja
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link BilleteCorteCaja} de la base de datos. 
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
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $billete_corte_caja , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from billete_corte_caja WHERE ("; 
		$val = array();
		if( ! is_null( $billete_corte_caja->getIdBillete() ) ){
			$sql .= " `id_billete` = ? AND";
			array_push( $val, $billete_corte_caja->getIdBillete() );
		}

		if( ! is_null( $billete_corte_caja->getIdCorteCaja() ) ){
			$sql .= " `id_corte_caja` = ? AND";
			array_push( $val, $billete_corte_caja->getIdCorteCaja() );
		}

		if( ! is_null( $billete_corte_caja->getCantidadEncontrada() ) ){
			$sql .= " `cantidad_encontrada` = ? AND";
			array_push( $val, $billete_corte_caja->getCantidadEncontrada() );
		}

		if( ! is_null( $billete_corte_caja->getCantidadDejada() ) ){
			$sql .= " `cantidad_dejada` = ? AND";
			array_push( $val, $billete_corte_caja->getCantidadDejada() );
		}

		if( ! is_null( $billete_corte_caja->getCantidadSobrante() ) ){
			$sql .= " `cantidad_sobrante` = ? AND";
			array_push( $val, $billete_corte_caja->getCantidadSobrante() );
		}

		if( ! is_null( $billete_corte_caja->getCantidadFaltante() ) ){
			$sql .= " `cantidad_faltante` = ? AND";
			array_push( $val, $billete_corte_caja->getCantidadFaltante() );
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
			$bar =  new BilleteCorteCaja($foo);
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
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja a actualizar.
	  **/
	private static final function update( $billete_corte_caja )
	{
		$sql = "UPDATE billete_corte_caja SET  `cantidad_encontrada` = ?, `cantidad_dejada` = ?, `cantidad_sobrante` = ?, `cantidad_faltante` = ? WHERE  `id_billete` = ? AND `id_corte_caja` = ?;";
		$params = array( 
			$billete_corte_caja->getCantidadEncontrada(), 
			$billete_corte_caja->getCantidadDejada(), 
			$billete_corte_caja->getCantidadSobrante(), 
			$billete_corte_caja->getCantidadFaltante(), 
			$billete_corte_caja->getIdBillete(),$billete_corte_caja->getIdCorteCaja(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto BilleteCorteCaja suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto BilleteCorteCaja dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja a crear.
	  **/
	private static final function create( &$billete_corte_caja )
	{
		$sql = "INSERT INTO billete_corte_caja ( `id_billete`, `id_corte_caja`, `cantidad_encontrada`, `cantidad_dejada`, `cantidad_sobrante`, `cantidad_faltante` ) VALUES ( ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$billete_corte_caja->getIdBillete(), 
			$billete_corte_caja->getIdCorteCaja(), 
			$billete_corte_caja->getCantidadEncontrada(), 
			$billete_corte_caja->getCantidadDejada(), 
			$billete_corte_caja->getCantidadSobrante(), 
			$billete_corte_caja->getCantidadFaltante(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link BilleteCorteCaja} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link BilleteCorteCaja}.
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
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $billete_corte_cajaA , $billete_corte_cajaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from billete_corte_caja WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $billete_corte_cajaA->getIdBillete()) ) ) & ( ! is_null ( ($b = $billete_corte_cajaB->getIdBillete()) ) ) ){
				$sql .= " `id_billete` >= ? AND `id_billete` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_billete` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_corte_cajaA->getIdCorteCaja()) ) ) & ( ! is_null ( ($b = $billete_corte_cajaB->getIdCorteCaja()) ) ) ){
				$sql .= " `id_corte_caja` >= ? AND `id_corte_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_corte_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_corte_cajaA->getCantidadEncontrada()) ) ) & ( ! is_null ( ($b = $billete_corte_cajaB->getCantidadEncontrada()) ) ) ){
				$sql .= " `cantidad_encontrada` >= ? AND `cantidad_encontrada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_encontrada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_corte_cajaA->getCantidadDejada()) ) ) & ( ! is_null ( ($b = $billete_corte_cajaB->getCantidadDejada()) ) ) ){
				$sql .= " `cantidad_dejada` >= ? AND `cantidad_dejada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_dejada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_corte_cajaA->getCantidadSobrante()) ) ) & ( ! is_null ( ($b = $billete_corte_cajaB->getCantidadSobrante()) ) ) ){
				$sql .= " `cantidad_sobrante` >= ? AND `cantidad_sobrante` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_sobrante` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $billete_corte_cajaA->getCantidadFaltante()) ) ) & ( ! is_null ( ($b = $billete_corte_cajaB->getCantidadFaltante()) ) ) ){
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
    		array_push( $ar, new BilleteCorteCaja($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto BilleteCorteCaja suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param BilleteCorteCaja [$billete_corte_caja] El objeto de tipo BilleteCorteCaja a eliminar
	  **/
	public static final function delete( &$billete_corte_caja )
	{
		if( is_null( self::getByPK($billete_corte_caja->getIdBillete(), $billete_corte_caja->getIdCorteCaja()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM billete_corte_caja WHERE  id_billete = ? AND id_corte_caja = ?;";
		$params = array( $billete_corte_caja->getIdBillete(), $billete_corte_caja->getIdCorteCaja() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
