<?php
/** CorteDeCaja Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link CorteDeCaja }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class CorteDeCajaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link CorteDeCaja} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$corte_de_caja )
	{
		if( ! is_null ( self::getByPK(  $corte_de_caja->getIdCorteDeCaja() ) ) )
		{
			try{ return CorteDeCajaDAOBase::update( $corte_de_caja) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return CorteDeCajaDAOBase::create( $corte_de_caja) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link CorteDeCaja} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link CorteDeCaja} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link CorteDeCaja Un objeto del tipo {@link CorteDeCaja}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_corte_de_caja )
	{
		$sql = "SELECT * FROM corte_de_caja WHERE (id_corte_de_caja = ? ) LIMIT 1;";
		$params = array(  $id_corte_de_caja );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new CorteDeCaja( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link CorteDeCaja}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link CorteDeCaja}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from corte_de_caja";
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
			$bar = new CorteDeCaja($foo);
    		array_push( $allData, $bar);
			//id_corte_de_caja
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link CorteDeCaja} de la base de datos. 
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
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $corte_de_caja , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from corte_de_caja WHERE ("; 
		$val = array();
		if( ! is_null( $corte_de_caja->getIdCorteDeCaja() ) ){
			$sql .= " `id_corte_de_caja` = ? AND";
			array_push( $val, $corte_de_caja->getIdCorteDeCaja() );
		}

		if( ! is_null( $corte_de_caja->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $corte_de_caja->getIdCaja() );
		}

		if( ! is_null( $corte_de_caja->getIdCajero() ) ){
			$sql .= " `id_cajero` = ? AND";
			array_push( $val, $corte_de_caja->getIdCajero() );
		}

		if( ! is_null( $corte_de_caja->getIdCajeroNuevo() ) ){
			$sql .= " `id_cajero_nuevo` = ? AND";
			array_push( $val, $corte_de_caja->getIdCajeroNuevo() );
		}

		if( ! is_null( $corte_de_caja->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $corte_de_caja->getFecha() );
		}

		if( ! is_null( $corte_de_caja->getSaldoReal() ) ){
			$sql .= " `saldo_real` = ? AND";
			array_push( $val, $corte_de_caja->getSaldoReal() );
		}

		if( ! is_null( $corte_de_caja->getSaldoEsperado() ) ){
			$sql .= " `saldo_esperado` = ? AND";
			array_push( $val, $corte_de_caja->getSaldoEsperado() );
		}

		if( ! is_null( $corte_de_caja->getSaldoFinal() ) ){
			$sql .= " `saldo_final` = ? AND";
			array_push( $val, $corte_de_caja->getSaldoFinal() );
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
			$bar =  new CorteDeCaja($foo);
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
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja a actualizar.
	  **/
	private static final function update( $corte_de_caja )
	{
		$sql = "UPDATE corte_de_caja SET  `id_caja` = ?, `id_cajero` = ?, `id_cajero_nuevo` = ?, `fecha` = ?, `saldo_real` = ?, `saldo_esperado` = ?, `saldo_final` = ? WHERE  `id_corte_de_caja` = ?;";
		$params = array( 
			$corte_de_caja->getIdCaja(), 
			$corte_de_caja->getIdCajero(), 
			$corte_de_caja->getIdCajeroNuevo(), 
			$corte_de_caja->getFecha(), 
			$corte_de_caja->getSaldoReal(), 
			$corte_de_caja->getSaldoEsperado(), 
			$corte_de_caja->getSaldoFinal(), 
			$corte_de_caja->getIdCorteDeCaja(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto CorteDeCaja suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto CorteDeCaja dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja a crear.
	  **/
	private static final function create( &$corte_de_caja )
	{
		$sql = "INSERT INTO corte_de_caja ( `id_corte_de_caja`, `id_caja`, `id_cajero`, `id_cajero_nuevo`, `fecha`, `saldo_real`, `saldo_esperado`, `saldo_final` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$corte_de_caja->getIdCorteDeCaja(), 
			$corte_de_caja->getIdCaja(), 
			$corte_de_caja->getIdCajero(), 
			$corte_de_caja->getIdCajeroNuevo(), 
			$corte_de_caja->getFecha(), 
			$corte_de_caja->getSaldoReal(), 
			$corte_de_caja->getSaldoEsperado(), 
			$corte_de_caja->getSaldoFinal(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $corte_de_caja->setIdCorteDeCaja( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link CorteDeCaja} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link CorteDeCaja}.
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
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $corte_de_cajaA , $corte_de_cajaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from corte_de_caja WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $corte_de_cajaA->getIdCorteDeCaja()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getIdCorteDeCaja()) ) ) ){
				$sql .= " `id_corte_de_caja` >= ? AND `id_corte_de_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_corte_de_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getIdCaja()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getIdCajero()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getIdCajero()) ) ) ){
				$sql .= " `id_cajero` >= ? AND `id_cajero` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_cajero` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getIdCajeroNuevo()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getIdCajeroNuevo()) ) ) ){
				$sql .= " `id_cajero_nuevo` >= ? AND `id_cajero_nuevo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_cajero_nuevo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getFecha()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getSaldoReal()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getSaldoReal()) ) ) ){
				$sql .= " `saldo_real` >= ? AND `saldo_real` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldo_real` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getSaldoEsperado()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getSaldoEsperado()) ) ) ){
				$sql .= " `saldo_esperado` >= ? AND `saldo_esperado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldo_esperado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $corte_de_cajaA->getSaldoFinal()) ) ) & ( ! is_null ( ($b = $corte_de_cajaB->getSaldoFinal()) ) ) ){
				$sql .= " `saldo_final` >= ? AND `saldo_final` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldo_final` = ? AND"; 
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
    		array_push( $ar, new CorteDeCaja($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto CorteDeCaja suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param CorteDeCaja [$corte_de_caja] El objeto de tipo CorteDeCaja a eliminar
	  **/
	public static final function delete( &$corte_de_caja )
	{
		if( is_null( self::getByPK($corte_de_caja->getIdCorteDeCaja()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM corte_de_caja WHERE  id_corte_de_caja = ?;";
		$params = array( $corte_de_caja->getIdCorteDeCaja() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
