<?php
/** VentaEmpresa Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link VentaEmpresa }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class VentaEmpresaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link VentaEmpresa} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$venta_empresa )
	{
		if( ! is_null ( self::getByPK(  $venta_empresa->getIdVenta() , $venta_empresa->getIdEmpresa() ) ) )
		{
			try{ return VentaEmpresaDAOBase::update( $venta_empresa) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return VentaEmpresaDAOBase::create( $venta_empresa) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link VentaEmpresa} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link VentaEmpresa} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link VentaEmpresa Un objeto del tipo {@link VentaEmpresa}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_venta, $id_empresa )
	{
		$sql = "SELECT * FROM venta_empresa WHERE (id_venta = ? AND id_empresa = ? ) LIMIT 1;";
		$params = array(  $id_venta, $id_empresa );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new VentaEmpresa( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link VentaEmpresa}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link VentaEmpresa}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from venta_empresa";
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
			$bar = new VentaEmpresa($foo);
    		array_push( $allData, $bar);
			//id_venta
			//id_empresa
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link VentaEmpresa} de la base de datos. 
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
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $venta_empresa , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta_empresa WHERE ("; 
		$val = array();
		if( ! is_null( $venta_empresa->getIdVenta() ) ){
			$sql .= " `id_venta` = ? AND";
			array_push( $val, $venta_empresa->getIdVenta() );
		}

		if( ! is_null( $venta_empresa->getIdEmpresa() ) ){
			$sql .= " `id_empresa` = ? AND";
			array_push( $val, $venta_empresa->getIdEmpresa() );
		}

		if( ! is_null( $venta_empresa->getTotal() ) ){
			$sql .= " `total` = ? AND";
			array_push( $val, $venta_empresa->getTotal() );
		}

		if( ! is_null( $venta_empresa->getSaldada() ) ){
			$sql .= " `saldada` = ? AND";
			array_push( $val, $venta_empresa->getSaldada() );
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
			$bar =  new VentaEmpresa($foo);
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
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa a actualizar.
	  **/
	private static final function update( $venta_empresa )
	{
		$sql = "UPDATE venta_empresa SET  `total` = ?, `saldada` = ? WHERE  `id_venta` = ? AND `id_empresa` = ?;";
		$params = array( 
			$venta_empresa->getTotal(), 
			$venta_empresa->getSaldada(), 
			$venta_empresa->getIdVenta(),$venta_empresa->getIdEmpresa(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto VentaEmpresa suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto VentaEmpresa dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa a crear.
	  **/
	private static final function create( &$venta_empresa )
	{
		$sql = "INSERT INTO venta_empresa ( `id_venta`, `id_empresa`, `total`, `saldada` ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$venta_empresa->getIdVenta(), 
			$venta_empresa->getIdEmpresa(), 
			$venta_empresa->getTotal(), 
			$venta_empresa->getSaldada(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link VentaEmpresa} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link VentaEmpresa}.
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
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $venta_empresaA , $venta_empresaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta_empresa WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $venta_empresaA->getIdVenta()) ) ) & ( ! is_null ( ($b = $venta_empresaB->getIdVenta()) ) ) ){
				$sql .= " `id_venta` >= ? AND `id_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_empresaA->getIdEmpresa()) ) ) & ( ! is_null ( ($b = $venta_empresaB->getIdEmpresa()) ) ) ){
				$sql .= " `id_empresa` >= ? AND `id_empresa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_empresa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_empresaA->getTotal()) ) ) & ( ! is_null ( ($b = $venta_empresaB->getTotal()) ) ) ){
				$sql .= " `total` >= ? AND `total` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `total` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $venta_empresaA->getSaldada()) ) ) & ( ! is_null ( ($b = $venta_empresaB->getSaldada()) ) ) ){
				$sql .= " `saldada` >= ? AND `saldada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldada` = ? AND"; 
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
    		array_push( $ar, new VentaEmpresa($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto VentaEmpresa suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param VentaEmpresa [$venta_empresa] El objeto de tipo VentaEmpresa a eliminar
	  **/
	public static final function delete( &$venta_empresa )
	{
		if( is_null( self::getByPK($venta_empresa->getIdVenta(), $venta_empresa->getIdEmpresa()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM venta_empresa WHERE  id_venta = ? AND id_empresa = ?;";
		$params = array( $venta_empresa->getIdVenta(), $venta_empresa->getIdEmpresa() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
