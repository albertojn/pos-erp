<?php
/** ClasificacionProveedor Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ClasificacionProveedor }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ClasificacionProveedorDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ClasificacionProveedor} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$clasificacion_proveedor )
	{
		if( ! is_null ( self::getByPK(  $clasificacion_proveedor->getIdClasificacionProveedor() ) ) )
		{
			try{ return ClasificacionProveedorDAOBase::update( $clasificacion_proveedor) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ClasificacionProveedorDAOBase::create( $clasificacion_proveedor) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ClasificacionProveedor} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ClasificacionProveedor} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ClasificacionProveedor Un objeto del tipo {@link ClasificacionProveedor}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_clasificacion_proveedor )
	{
		$sql = "SELECT * FROM clasificacion_proveedor WHERE (id_clasificacion_proveedor = ? ) LIMIT 1;";
		$params = array(  $id_clasificacion_proveedor );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ClasificacionProveedor( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ClasificacionProveedor}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ClasificacionProveedor}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from clasificacion_proveedor";
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
			$bar = new ClasificacionProveedor($foo);
    		array_push( $allData, $bar);
			//id_clasificacion_proveedor
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ClasificacionProveedor} de la base de datos. 
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
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $clasificacion_proveedor , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from clasificacion_proveedor WHERE ("; 
		$val = array();
		if( ! is_null( $clasificacion_proveedor->getIdClasificacionProveedor() ) ){
			$sql .= " `id_clasificacion_proveedor` = ? AND";
			array_push( $val, $clasificacion_proveedor->getIdClasificacionProveedor() );
		}

		if( ! is_null( $clasificacion_proveedor->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $clasificacion_proveedor->getNombre() );
		}

		if( ! is_null( $clasificacion_proveedor->getDescripcion() ) ){
			$sql .= " `descripcion` = ? AND";
			array_push( $val, $clasificacion_proveedor->getDescripcion() );
		}

		if( ! is_null( $clasificacion_proveedor->getActiva() ) ){
			$sql .= " `activa` = ? AND";
			array_push( $val, $clasificacion_proveedor->getActiva() );
		}

		if( ! is_null( $clasificacion_proveedor->getIdTarifaCompra() ) ){
			$sql .= " `id_tarifa_compra` = ? AND";
			array_push( $val, $clasificacion_proveedor->getIdTarifaCompra() );
		}

		if( ! is_null( $clasificacion_proveedor->getIdTarifaVenta() ) ){
			$sql .= " `id_tarifa_venta` = ? AND";
			array_push( $val, $clasificacion_proveedor->getIdTarifaVenta() );
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
			$bar =  new ClasificacionProveedor($foo);
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
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor a actualizar.
	  **/
	private static final function update( $clasificacion_proveedor )
	{
		$sql = "UPDATE clasificacion_proveedor SET  `nombre` = ?, `descripcion` = ?, `activa` = ?, `id_tarifa_compra` = ?, `id_tarifa_venta` = ? WHERE  `id_clasificacion_proveedor` = ?;";
		$params = array( 
			$clasificacion_proveedor->getNombre(), 
			$clasificacion_proveedor->getDescripcion(), 
			$clasificacion_proveedor->getActiva(), 
			$clasificacion_proveedor->getIdTarifaCompra(), 
			$clasificacion_proveedor->getIdTarifaVenta(), 
			$clasificacion_proveedor->getIdClasificacionProveedor(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ClasificacionProveedor suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ClasificacionProveedor dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor a crear.
	  **/
	private static final function create( &$clasificacion_proveedor )
	{
		$sql = "INSERT INTO clasificacion_proveedor ( `id_clasificacion_proveedor`, `nombre`, `descripcion`, `activa`, `id_tarifa_compra`, `id_tarifa_venta` ) VALUES ( ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$clasificacion_proveedor->getIdClasificacionProveedor(), 
			$clasificacion_proveedor->getNombre(), 
			$clasificacion_proveedor->getDescripcion(), 
			$clasificacion_proveedor->getActiva(), 
			$clasificacion_proveedor->getIdTarifaCompra(), 
			$clasificacion_proveedor->getIdTarifaVenta(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $clasificacion_proveedor->setIdClasificacionProveedor( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ClasificacionProveedor} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ClasificacionProveedor}.
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
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $clasificacion_proveedorA , $clasificacion_proveedorB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from clasificacion_proveedor WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $clasificacion_proveedorA->getIdClasificacionProveedor()) ) ) & ( ! is_null ( ($b = $clasificacion_proveedorB->getIdClasificacionProveedor()) ) ) ){
				$sql .= " `id_clasificacion_proveedor` >= ? AND `id_clasificacion_proveedor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_proveedor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_proveedorA->getNombre()) ) ) & ( ! is_null ( ($b = $clasificacion_proveedorB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_proveedorA->getDescripcion()) ) ) & ( ! is_null ( ($b = $clasificacion_proveedorB->getDescripcion()) ) ) ){
				$sql .= " `descripcion` >= ? AND `descripcion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descripcion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_proveedorA->getActiva()) ) ) & ( ! is_null ( ($b = $clasificacion_proveedorB->getActiva()) ) ) ){
				$sql .= " `activa` >= ? AND `activa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `activa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_proveedorA->getIdTarifaCompra()) ) ) & ( ! is_null ( ($b = $clasificacion_proveedorB->getIdTarifaCompra()) ) ) ){
				$sql .= " `id_tarifa_compra` >= ? AND `id_tarifa_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $clasificacion_proveedorA->getIdTarifaVenta()) ) ) & ( ! is_null ( ($b = $clasificacion_proveedorB->getIdTarifaVenta()) ) ) ){
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
    		array_push( $ar, new ClasificacionProveedor($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ClasificacionProveedor suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ClasificacionProveedor [$clasificacion_proveedor] El objeto de tipo ClasificacionProveedor a eliminar
	  **/
	public static final function delete( &$clasificacion_proveedor )
	{
		if( is_null( self::getByPK($clasificacion_proveedor->getIdClasificacionProveedor()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM clasificacion_proveedor WHERE  id_clasificacion_proveedor = ?;";
		$params = array( $clasificacion_proveedor->getIdClasificacionProveedor() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
