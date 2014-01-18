<?php
/** TraspasoProducto Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link TraspasoProducto }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class TraspasoProductoDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link TraspasoProducto} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$traspaso_producto )
	{
		if( ! is_null ( self::getByPK(  $traspaso_producto->getIdTraspaso() , $traspaso_producto->getIdProducto() , $traspaso_producto->getIdUnidad() ) ) )
		{
			try{ return TraspasoProductoDAOBase::update( $traspaso_producto) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return TraspasoProductoDAOBase::create( $traspaso_producto) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link TraspasoProducto} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link TraspasoProducto} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link TraspasoProducto Un objeto del tipo {@link TraspasoProducto}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_traspaso, $id_producto, $id_unidad )
	{
		$sql = "SELECT * FROM traspaso_producto WHERE (id_traspaso = ? AND id_producto = ? AND id_unidad = ? ) LIMIT 1;";
		$params = array(  $id_traspaso, $id_producto, $id_unidad );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new TraspasoProducto( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link TraspasoProducto}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link TraspasoProducto}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from traspaso_producto";
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
			$bar = new TraspasoProducto($foo);
    		array_push( $allData, $bar);
			//id_traspaso
			//id_producto
			//id_unidad
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link TraspasoProducto} de la base de datos. 
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
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $traspaso_producto , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from traspaso_producto WHERE ("; 
		$val = array();
		if( ! is_null( $traspaso_producto->getIdTraspaso() ) ){
			$sql .= " `id_traspaso` = ? AND";
			array_push( $val, $traspaso_producto->getIdTraspaso() );
		}

		if( ! is_null( $traspaso_producto->getIdProducto() ) ){
			$sql .= " `id_producto` = ? AND";
			array_push( $val, $traspaso_producto->getIdProducto() );
		}

		if( ! is_null( $traspaso_producto->getIdUnidad() ) ){
			$sql .= " `id_unidad` = ? AND";
			array_push( $val, $traspaso_producto->getIdUnidad() );
		}

		if( ! is_null( $traspaso_producto->getCantidadEnviada() ) ){
			$sql .= " `cantidad_enviada` = ? AND";
			array_push( $val, $traspaso_producto->getCantidadEnviada() );
		}

		if( ! is_null( $traspaso_producto->getCantidadRecibida() ) ){
			$sql .= " `cantidad_recibida` = ? AND";
			array_push( $val, $traspaso_producto->getCantidadRecibida() );
		}

		if( ! is_null( $traspaso_producto->getIdLoteOrigen() ) ){
			$sql .= " `id_lote_origen` = ? AND";
			array_push( $val, $traspaso_producto->getIdLoteOrigen() );
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
			$bar =  new TraspasoProducto($foo);
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
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto a actualizar.
	  **/
	private static final function update( $traspaso_producto )
	{
		$sql = "UPDATE traspaso_producto SET  `cantidad_enviada` = ?, `cantidad_recibida` = ?, `id_lote_origen` = ? WHERE  `id_traspaso` = ? AND `id_producto` = ? AND `id_unidad` = ?;";
		$params = array( 
			$traspaso_producto->getCantidadEnviada(), 
			$traspaso_producto->getCantidadRecibida(), 
			$traspaso_producto->getIdLoteOrigen(), 
			$traspaso_producto->getIdTraspaso(),$traspaso_producto->getIdProducto(),$traspaso_producto->getIdUnidad(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto TraspasoProducto suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto TraspasoProducto dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto a crear.
	  **/
	private static final function create( &$traspaso_producto )
	{
		$sql = "INSERT INTO traspaso_producto ( `id_traspaso`, `id_producto`, `id_unidad`, `cantidad_enviada`, `cantidad_recibida`, `id_lote_origen` ) VALUES ( ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$traspaso_producto->getIdTraspaso(), 
			$traspaso_producto->getIdProducto(), 
			$traspaso_producto->getIdUnidad(), 
			$traspaso_producto->getCantidadEnviada(), 
			$traspaso_producto->getCantidadRecibida(), 
			$traspaso_producto->getIdLoteOrigen(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link TraspasoProducto} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link TraspasoProducto}.
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
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $traspaso_productoA , $traspaso_productoB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from traspaso_producto WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $traspaso_productoA->getIdTraspaso()) ) ) & ( ! is_null ( ($b = $traspaso_productoB->getIdTraspaso()) ) ) ){
				$sql .= " `id_traspaso` >= ? AND `id_traspaso` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_traspaso` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspaso_productoA->getIdProducto()) ) ) & ( ! is_null ( ($b = $traspaso_productoB->getIdProducto()) ) ) ){
				$sql .= " `id_producto` >= ? AND `id_producto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_producto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspaso_productoA->getIdUnidad()) ) ) & ( ! is_null ( ($b = $traspaso_productoB->getIdUnidad()) ) ) ){
				$sql .= " `id_unidad` >= ? AND `id_unidad` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_unidad` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspaso_productoA->getCantidadEnviada()) ) ) & ( ! is_null ( ($b = $traspaso_productoB->getCantidadEnviada()) ) ) ){
				$sql .= " `cantidad_enviada` >= ? AND `cantidad_enviada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_enviada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspaso_productoA->getCantidadRecibida()) ) ) & ( ! is_null ( ($b = $traspaso_productoB->getCantidadRecibida()) ) ) ){
				$sql .= " `cantidad_recibida` >= ? AND `cantidad_recibida` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_recibida` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspaso_productoA->getIdLoteOrigen()) ) ) & ( ! is_null ( ($b = $traspaso_productoB->getIdLoteOrigen()) ) ) ){
				$sql .= " `id_lote_origen` >= ? AND `id_lote_origen` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_lote_origen` = ? AND"; 
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
    		array_push( $ar, new TraspasoProducto($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto TraspasoProducto suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param TraspasoProducto [$traspaso_producto] El objeto de tipo TraspasoProducto a eliminar
	  **/
	public static final function delete( &$traspaso_producto )
	{
		if( is_null( self::getByPK($traspaso_producto->getIdTraspaso(), $traspaso_producto->getIdProducto(), $traspaso_producto->getIdUnidad()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM traspaso_producto WHERE  id_traspaso = ? AND id_producto = ? AND id_unidad = ?;";
		$params = array( $traspaso_producto->getIdTraspaso(), $traspaso_producto->getIdProducto(), $traspaso_producto->getIdUnidad() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
