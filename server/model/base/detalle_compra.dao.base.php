<?php
/** DetalleCompra Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link DetalleCompra }. 
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class DetalleCompraDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link DetalleCompra} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$detalle_compra )
	{
		if( self::getByPK(  $detalle_compra->getIdCompra() , $detalle_compra->getIdProducto() ) === NULL )
		{
			try{ return DetalleCompraDAOBase::create( $detalle_compra) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return DetalleCompraDAOBase::update( $detalle_compra) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link DetalleCompra} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link DetalleCompra} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link DetalleCompra Un objeto del tipo {@link DetalleCompra}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_compra, $id_producto )
	{
		$sql = "SELECT * FROM detalle_compra WHERE (id_compra = ? AND id_producto = ? ) LIMIT 1;";
		$params = array(  $id_compra, $id_producto );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
		return new DetalleCompra( $rs );
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link DetalleCompra}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link DetalleCompra}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from detalle_compra";
		if($orden != NULL)
		{ $sql .= " ORDER BY " . $orden . " " . $tipo_de_orden;	}
		if($pagina != NULL)
		{
			$sql .= " LIMIT " . (( $pagina - 1 )*$columnas_por_pagina) . "," . $columnas_por_pagina; 
		}
		global $conn;
		$rs = $conn->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new DetalleCompra($foo));
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link DetalleCompra} de la base de datos. 
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
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $detalle_compra , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from detalle_compra WHERE ("; 
		$val = array();
		if( $detalle_compra->getIdCompra() != NULL){
			$sql .= " id_compra = ? AND";
			array_push( $val, $detalle_compra->getIdCompra() );
		}

		if( $detalle_compra->getIdProducto() != NULL){
			$sql .= " id_producto = ? AND";
			array_push( $val, $detalle_compra->getIdProducto() );
		}

		if( $detalle_compra->getCantidad() != NULL){
			$sql .= " cantidad = ? AND";
			array_push( $val, $detalle_compra->getCantidad() );
		}

		if( $detalle_compra->getPrecio() != NULL){
			$sql .= " precio = ? AND";
			array_push( $val, $detalle_compra->getPrecio() );
		}

		if(sizeof($val) == 0){return array();}
		$sql = substr($sql, 0, -3) . " )";
		if( $orderBy !== null ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
    		array_push( $ar, new DetalleCompra($foo));
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
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra a actualizar.
	  **/
	private static final function update( $detalle_compra )
	{
		$sql = "UPDATE detalle_compra SET  cantidad = ?, precio = ? WHERE  id_compra = ? AND id_producto = ?;";
		$params = array( 
			$detalle_compra->getCantidad(), 
			$detalle_compra->getPrecio(), 
			$detalle_compra->getIdCompra(),$detalle_compra->getIdProducto(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto DetalleCompra suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto DetalleCompra dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra a crear.
	  **/
	private static final function create( &$detalle_compra )
	{
		$sql = "INSERT INTO detalle_compra ( id_compra, id_producto, cantidad, precio ) VALUES ( ?, ?, ?, ?);";
		$params = array( 
			$detalle_compra->getIdCompra(), 
			$detalle_compra->getIdProducto(), 
			$detalle_compra->getCantidad(), 
			$detalle_compra->getPrecio(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link DetalleCompra} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link DetalleCompra}.
	  * 
	  * Aquellas variables que tienen valores NULL seran excluidos en la busqueda. 
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
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $detalle_compraA , $detalle_compraB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from detalle_compra WHERE ("; 
		$val = array();
		if( (($a = $detalle_compraA->getIdCompra()) != NULL) & ( ($b = $detalle_compraB->getIdCompra()) != NULL) ){
				$sql .= " id_compra >= ? AND id_compra <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_compra = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $detalle_compraA->getIdProducto()) != NULL) & ( ($b = $detalle_compraB->getIdProducto()) != NULL) ){
				$sql .= " id_producto >= ? AND id_producto <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_producto = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $detalle_compraA->getCantidad()) != NULL) & ( ($b = $detalle_compraB->getCantidad()) != NULL) ){
				$sql .= " cantidad >= ? AND cantidad <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " cantidad = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $detalle_compraA->getPrecio()) != NULL) & ( ($b = $detalle_compraB->getPrecio()) != NULL) ){
				$sql .= " precio >= ? AND precio <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " precio = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		$sql = substr($sql, 0, -3) . " )";
		if( $orderBy !== null ){
		    $sql .= " order by " . $orderBy . " " . $orden ;
		
		}
		global $conn;
		$rs = $conn->Execute($sql, $val);
		$ar = array();
		foreach ($rs as $foo) {
    		array_push( $ar, new DetalleCompra($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto DetalleCompra suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param DetalleCompra [$detalle_compra] El objeto de tipo DetalleCompra a eliminar
	  **/
	public static final function delete( &$detalle_compra )
	{
		if(self::getByPK($detalle_compra->getIdCompra(), $detalle_compra->getIdProducto()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM detalle_compra WHERE  id_compra = ? AND id_producto = ?;";
		$params = array( $detalle_compra->getIdCompra(), $detalle_compra->getIdProducto() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
