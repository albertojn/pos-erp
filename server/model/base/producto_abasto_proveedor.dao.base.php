<?php
/** ProductoAbastoProveedor Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ProductoAbastoProveedor }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ProductoAbastoProveedorDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ProductoAbastoProveedor} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$producto_abasto_proveedor )
	{
		if( ! is_null ( self::getByPK(  $producto_abasto_proveedor->getIdAbastoProveedor() , $producto_abasto_proveedor->getIdProducto() , $producto_abasto_proveedor->getIdUnidad() ) ) )
		{
			try{ return ProductoAbastoProveedorDAOBase::update( $producto_abasto_proveedor) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ProductoAbastoProveedorDAOBase::create( $producto_abasto_proveedor) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ProductoAbastoProveedor} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ProductoAbastoProveedor} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ProductoAbastoProveedor Un objeto del tipo {@link ProductoAbastoProveedor}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_abasto_proveedor, $id_producto, $id_unidad )
	{
		$sql = "SELECT * FROM producto_abasto_proveedor WHERE (id_abasto_proveedor = ? AND id_producto = ? AND id_unidad = ? ) LIMIT 1;";
		$params = array(  $id_abasto_proveedor, $id_producto, $id_unidad );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ProductoAbastoProveedor( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ProductoAbastoProveedor}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ProductoAbastoProveedor}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from producto_abasto_proveedor";
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
			$bar = new ProductoAbastoProveedor($foo);
    		array_push( $allData, $bar);
			//id_abasto_proveedor
			//id_producto
			//id_unidad
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ProductoAbastoProveedor} de la base de datos. 
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
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $producto_abasto_proveedor , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from producto_abasto_proveedor WHERE ("; 
		$val = array();
		if( ! is_null( $producto_abasto_proveedor->getIdAbastoProveedor() ) ){
			$sql .= " `id_abasto_proveedor` = ? AND";
			array_push( $val, $producto_abasto_proveedor->getIdAbastoProveedor() );
		}

		if( ! is_null( $producto_abasto_proveedor->getIdProducto() ) ){
			$sql .= " `id_producto` = ? AND";
			array_push( $val, $producto_abasto_proveedor->getIdProducto() );
		}

		if( ! is_null( $producto_abasto_proveedor->getIdUnidad() ) ){
			$sql .= " `id_unidad` = ? AND";
			array_push( $val, $producto_abasto_proveedor->getIdUnidad() );
		}

		if( ! is_null( $producto_abasto_proveedor->getCantidad() ) ){
			$sql .= " `cantidad` = ? AND";
			array_push( $val, $producto_abasto_proveedor->getCantidad() );
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
			$bar =  new ProductoAbastoProveedor($foo);
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
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor a actualizar.
	  **/
	private static final function update( $producto_abasto_proveedor )
	{
		$sql = "UPDATE producto_abasto_proveedor SET  `cantidad` = ? WHERE  `id_abasto_proveedor` = ? AND `id_producto` = ? AND `id_unidad` = ?;";
		$params = array( 
			$producto_abasto_proveedor->getCantidad(), 
			$producto_abasto_proveedor->getIdAbastoProveedor(),$producto_abasto_proveedor->getIdProducto(),$producto_abasto_proveedor->getIdUnidad(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ProductoAbastoProveedor suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ProductoAbastoProveedor dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor a crear.
	  **/
	private static final function create( &$producto_abasto_proveedor )
	{
		$sql = "INSERT INTO producto_abasto_proveedor ( `id_abasto_proveedor`, `id_producto`, `id_unidad`, `cantidad` ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$producto_abasto_proveedor->getIdAbastoProveedor(), 
			$producto_abasto_proveedor->getIdProducto(), 
			$producto_abasto_proveedor->getIdUnidad(), 
			$producto_abasto_proveedor->getCantidad(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ProductoAbastoProveedor} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ProductoAbastoProveedor}.
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
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $producto_abasto_proveedorA , $producto_abasto_proveedorB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from producto_abasto_proveedor WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $producto_abasto_proveedorA->getIdAbastoProveedor()) ) ) & ( ! is_null ( ($b = $producto_abasto_proveedorB->getIdAbastoProveedor()) ) ) ){
				$sql .= " `id_abasto_proveedor` >= ? AND `id_abasto_proveedor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_abasto_proveedor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $producto_abasto_proveedorA->getIdProducto()) ) ) & ( ! is_null ( ($b = $producto_abasto_proveedorB->getIdProducto()) ) ) ){
				$sql .= " `id_producto` >= ? AND `id_producto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_producto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $producto_abasto_proveedorA->getIdUnidad()) ) ) & ( ! is_null ( ($b = $producto_abasto_proveedorB->getIdUnidad()) ) ) ){
				$sql .= " `id_unidad` >= ? AND `id_unidad` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_unidad` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $producto_abasto_proveedorA->getCantidad()) ) ) & ( ! is_null ( ($b = $producto_abasto_proveedorB->getCantidad()) ) ) ){
				$sql .= " `cantidad` >= ? AND `cantidad` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad` = ? AND"; 
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
    		array_push( $ar, new ProductoAbastoProveedor($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ProductoAbastoProveedor suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ProductoAbastoProveedor [$producto_abasto_proveedor] El objeto de tipo ProductoAbastoProveedor a eliminar
	  **/
	public static final function delete( &$producto_abasto_proveedor )
	{
		if( is_null( self::getByPK($producto_abasto_proveedor->getIdAbastoProveedor(), $producto_abasto_proveedor->getIdProducto(), $producto_abasto_proveedor->getIdUnidad()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM producto_abasto_proveedor WHERE  id_abasto_proveedor = ? AND id_producto = ? AND id_unidad = ?;";
		$params = array( $producto_abasto_proveedor->getIdAbastoProveedor(), $producto_abasto_proveedor->getIdProducto(), $producto_abasto_proveedor->getIdUnidad() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
