<?php
/** ClasificacionCliente Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ClasificacionCliente }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ClasificacionClienteDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ClasificacionCliente} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$clasificacion_cliente )
	{
		if( ! is_null ( self::getByPK(  $clasificacion_cliente->getIdClasificacionCliente() ) ) )
		{
			try{ return ClasificacionClienteDAOBase::update( $clasificacion_cliente) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ClasificacionClienteDAOBase::create( $clasificacion_cliente) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ClasificacionCliente} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ClasificacionCliente} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ClasificacionCliente Un objeto del tipo {@link ClasificacionCliente}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_clasificacion_cliente )
	{
		$sql = "SELECT * FROM clasificacion_cliente WHERE (id_clasificacion_cliente = ? ) LIMIT 1;";
		$params = array(  $id_clasificacion_cliente );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ClasificacionCliente( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ClasificacionCliente}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ClasificacionCliente}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from clasificacion_cliente";
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
			$bar = new ClasificacionCliente($foo);
    		array_push( $allData, $bar);
			//id_clasificacion_cliente
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ClasificacionCliente} de la base de datos. 
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
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $clasificacion_cliente , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from clasificacion_cliente WHERE ("; 
		$val = array();
		if( ! is_null( $clasificacion_cliente->getIdClasificacionCliente() ) ){
			$sql .= " `id_clasificacion_cliente` = ? AND";
			array_push( $val, $clasificacion_cliente->getIdClasificacionCliente() );
		}

		if( ! is_null( $clasificacion_cliente->getClaveInterna() ) ){
			$sql .= " `clave_interna` = ? AND";
			array_push( $val, $clasificacion_cliente->getClaveInterna() );
		}

		if( ! is_null( $clasificacion_cliente->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $clasificacion_cliente->getNombre() );
		}

		if( ! is_null( $clasificacion_cliente->getDescripcion() ) ){
			$sql .= " `descripcion` = ? AND";
			array_push( $val, $clasificacion_cliente->getDescripcion() );
		}

		if( ! is_null( $clasificacion_cliente->getIdTarifaCompra() ) ){
			$sql .= " `id_tarifa_compra` = ? AND";
			array_push( $val, $clasificacion_cliente->getIdTarifaCompra() );
		}

		if( ! is_null( $clasificacion_cliente->getIdTarifaVenta() ) ){
			$sql .= " `id_tarifa_venta` = ? AND";
			array_push( $val, $clasificacion_cliente->getIdTarifaVenta() );
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
			$bar =  new ClasificacionCliente($foo);
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
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente a actualizar.
	  **/
	private static final function update( $clasificacion_cliente )
	{
		$sql = "UPDATE clasificacion_cliente SET  `clave_interna` = ?, `nombre` = ?, `descripcion` = ?, `id_tarifa_compra` = ?, `id_tarifa_venta` = ? WHERE  `id_clasificacion_cliente` = ?;";
		$params = array( 
			$clasificacion_cliente->getClaveInterna(), 
			$clasificacion_cliente->getNombre(), 
			$clasificacion_cliente->getDescripcion(), 
			$clasificacion_cliente->getIdTarifaCompra(), 
			$clasificacion_cliente->getIdTarifaVenta(), 
			$clasificacion_cliente->getIdClasificacionCliente(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ClasificacionCliente suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ClasificacionCliente dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente a crear.
	  **/
	private static final function create( &$clasificacion_cliente )
	{
		$sql = "INSERT INTO clasificacion_cliente ( `id_clasificacion_cliente`, `clave_interna`, `nombre`, `descripcion`, `id_tarifa_compra`, `id_tarifa_venta` ) VALUES ( ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$clasificacion_cliente->getIdClasificacionCliente(), 
			$clasificacion_cliente->getClaveInterna(), 
			$clasificacion_cliente->getNombre(), 
			$clasificacion_cliente->getDescripcion(), 
			$clasificacion_cliente->getIdTarifaCompra(), 
			$clasificacion_cliente->getIdTarifaVenta(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $clasificacion_cliente->setIdClasificacionCliente( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ClasificacionCliente} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ClasificacionCliente}.
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
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $clasificacion_clienteA , $clasificacion_clienteB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from clasificacion_cliente WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $clasificacion_clienteA->getIdClasificacionCliente()) ) ) & ( ! is_null ( ($b = $clasificacion_clienteB->getIdClasificacionCliente()) ) ) ){
				$sql .= " `id_clasificacion_cliente` >= ? AND `id_clasificacion_cliente` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_cliente` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_clienteA->getClaveInterna()) ) ) & ( ! is_null ( ($b = $clasificacion_clienteB->getClaveInterna()) ) ) ){
				$sql .= " `clave_interna` >= ? AND `clave_interna` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `clave_interna` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_clienteA->getNombre()) ) ) & ( ! is_null ( ($b = $clasificacion_clienteB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_clienteA->getDescripcion()) ) ) & ( ! is_null ( ($b = $clasificacion_clienteB->getDescripcion()) ) ) ){
				$sql .= " `descripcion` >= ? AND `descripcion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descripcion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_clienteA->getIdTarifaCompra()) ) ) & ( ! is_null ( ($b = $clasificacion_clienteB->getIdTarifaCompra()) ) ) ){
				$sql .= " `id_tarifa_compra` >= ? AND `id_tarifa_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_clienteA->getIdTarifaVenta()) ) ) & ( ! is_null ( ($b = $clasificacion_clienteB->getIdTarifaVenta()) ) ) ){
				$sql .= " `id_tarifa_venta` >= ? AND `id_tarifa_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa_venta` = ? AND"; 
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
    		array_push( $ar, new ClasificacionCliente($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ClasificacionCliente suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ClasificacionCliente [$clasificacion_cliente] El objeto de tipo ClasificacionCliente a eliminar
	  **/
	public static final function delete( &$clasificacion_cliente )
	{
		if( is_null( self::getByPK($clasificacion_cliente->getIdClasificacionCliente()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM clasificacion_cliente WHERE  id_clasificacion_cliente = ?;";
		$params = array( $clasificacion_cliente->getIdClasificacionCliente() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
