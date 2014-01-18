<?php
/** DevolucionSobreCompra Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link DevolucionSobreCompra }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class DevolucionSobreCompraDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link DevolucionSobreCompra} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$devolucion_sobre_compra )
	{
		if( ! is_null ( self::getByPK(  $devolucion_sobre_compra->getIdDevolucionSobreCompra() ) ) )
		{
			try{ return DevolucionSobreCompraDAOBase::update( $devolucion_sobre_compra) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return DevolucionSobreCompraDAOBase::create( $devolucion_sobre_compra) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link DevolucionSobreCompra} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link DevolucionSobreCompra} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link DevolucionSobreCompra Un objeto del tipo {@link DevolucionSobreCompra}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_devolucion_sobre_compra )
	{
		$sql = "SELECT * FROM devolucion_sobre_compra WHERE (id_devolucion_sobre_compra = ? ) LIMIT 1;";
		$params = array(  $id_devolucion_sobre_compra );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new DevolucionSobreCompra( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link DevolucionSobreCompra}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link DevolucionSobreCompra}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from devolucion_sobre_compra";
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
			$bar = new DevolucionSobreCompra($foo);
    		array_push( $allData, $bar);
			//id_devolucion_sobre_compra
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link DevolucionSobreCompra} de la base de datos. 
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
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $devolucion_sobre_compra , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from devolucion_sobre_compra WHERE ("; 
		$val = array();
		if( ! is_null( $devolucion_sobre_compra->getIdDevolucionSobreCompra() ) ){
			$sql .= " `id_devolucion_sobre_compra` = ? AND";
			array_push( $val, $devolucion_sobre_compra->getIdDevolucionSobreCompra() );
		}

		if( ! is_null( $devolucion_sobre_compra->getIdCompra() ) ){
			$sql .= " `id_compra` = ? AND";
			array_push( $val, $devolucion_sobre_compra->getIdCompra() );
		}

		if( ! is_null( $devolucion_sobre_compra->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $devolucion_sobre_compra->getIdUsuario() );
		}

		if( ! is_null( $devolucion_sobre_compra->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $devolucion_sobre_compra->getFecha() );
		}

		if( ! is_null( $devolucion_sobre_compra->getMotivo() ) ){
			$sql .= " `motivo` = ? AND";
			array_push( $val, $devolucion_sobre_compra->getMotivo() );
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
			$bar =  new DevolucionSobreCompra($foo);
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
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra a actualizar.
	  **/
	private static final function update( $devolucion_sobre_compra )
	{
		$sql = "UPDATE devolucion_sobre_compra SET  `id_compra` = ?, `id_usuario` = ?, `fecha` = ?, `motivo` = ? WHERE  `id_devolucion_sobre_compra` = ?;";
		$params = array( 
			$devolucion_sobre_compra->getIdCompra(), 
			$devolucion_sobre_compra->getIdUsuario(), 
			$devolucion_sobre_compra->getFecha(), 
			$devolucion_sobre_compra->getMotivo(), 
			$devolucion_sobre_compra->getIdDevolucionSobreCompra(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto DevolucionSobreCompra suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto DevolucionSobreCompra dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra a crear.
	  **/
	private static final function create( &$devolucion_sobre_compra )
	{
		$sql = "INSERT INTO devolucion_sobre_compra ( `id_devolucion_sobre_compra`, `id_compra`, `id_usuario`, `fecha`, `motivo` ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$devolucion_sobre_compra->getIdDevolucionSobreCompra(), 
			$devolucion_sobre_compra->getIdCompra(), 
			$devolucion_sobre_compra->getIdUsuario(), 
			$devolucion_sobre_compra->getFecha(), 
			$devolucion_sobre_compra->getMotivo(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $devolucion_sobre_compra->setIdDevolucionSobreCompra( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link DevolucionSobreCompra} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link DevolucionSobreCompra}.
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
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $devolucion_sobre_compraA , $devolucion_sobre_compraB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from devolucion_sobre_compra WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $devolucion_sobre_compraA->getIdDevolucionSobreCompra()) ) ) & ( ! is_null ( ($b = $devolucion_sobre_compraB->getIdDevolucionSobreCompra()) ) ) ){
				$sql .= " `id_devolucion_sobre_compra` >= ? AND `id_devolucion_sobre_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_devolucion_sobre_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $devolucion_sobre_compraA->getIdCompra()) ) ) & ( ! is_null ( ($b = $devolucion_sobre_compraB->getIdCompra()) ) ) ){
				$sql .= " `id_compra` >= ? AND `id_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $devolucion_sobre_compraA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $devolucion_sobre_compraB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $devolucion_sobre_compraA->getFecha()) ) ) & ( ! is_null ( ($b = $devolucion_sobre_compraB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $devolucion_sobre_compraA->getMotivo()) ) ) & ( ! is_null ( ($b = $devolucion_sobre_compraB->getMotivo()) ) ) ){
				$sql .= " `motivo` >= ? AND `motivo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `motivo` = ? AND"; 
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
    		array_push( $ar, new DevolucionSobreCompra($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto DevolucionSobreCompra suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param DevolucionSobreCompra [$devolucion_sobre_compra] El objeto de tipo DevolucionSobreCompra a eliminar
	  **/
	public static final function delete( &$devolucion_sobre_compra )
	{
		if( is_null( self::getByPK($devolucion_sobre_compra->getIdDevolucionSobreCompra()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM devolucion_sobre_compra WHERE  id_devolucion_sobre_compra = ?;";
		$params = array( $devolucion_sobre_compra->getIdDevolucionSobreCompra() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
