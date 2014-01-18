<?php
/** ClienteSeguimiento Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ClienteSeguimiento }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ClienteSeguimientoDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ClienteSeguimiento} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$cliente_seguimiento )
	{
		if( ! is_null ( self::getByPK(  $cliente_seguimiento->getIdClienteSeguimiento() ) ) )
		{
			try{ return ClienteSeguimientoDAOBase::update( $cliente_seguimiento) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ClienteSeguimientoDAOBase::create( $cliente_seguimiento) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ClienteSeguimiento} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ClienteSeguimiento} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ClienteSeguimiento Un objeto del tipo {@link ClienteSeguimiento}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_cliente_seguimiento )
	{
		$sql = "SELECT * FROM cliente_seguimiento WHERE (id_cliente_seguimiento = ? ) LIMIT 1;";
		$params = array(  $id_cliente_seguimiento );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ClienteSeguimiento( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ClienteSeguimiento}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ClienteSeguimiento}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from cliente_seguimiento";
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
			$bar = new ClienteSeguimiento($foo);
    		array_push( $allData, $bar);
			//id_cliente_seguimiento
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ClienteSeguimiento} de la base de datos. 
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
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $cliente_seguimiento , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from cliente_seguimiento WHERE ("; 
		$val = array();
		if( ! is_null( $cliente_seguimiento->getIdClienteSeguimiento() ) ){
			$sql .= " `id_cliente_seguimiento` = ? AND";
			array_push( $val, $cliente_seguimiento->getIdClienteSeguimiento() );
		}

		if( ! is_null( $cliente_seguimiento->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $cliente_seguimiento->getIdUsuario() );
		}

		if( ! is_null( $cliente_seguimiento->getIdCliente() ) ){
			$sql .= " `id_cliente` = ? AND";
			array_push( $val, $cliente_seguimiento->getIdCliente() );
		}

		if( ! is_null( $cliente_seguimiento->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $cliente_seguimiento->getFecha() );
		}

		if( ! is_null( $cliente_seguimiento->getTexto() ) ){
			$sql .= " `texto` = ? AND";
			array_push( $val, $cliente_seguimiento->getTexto() );
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
			$bar =  new ClienteSeguimiento($foo);
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
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento a actualizar.
	  **/
	private static final function update( $cliente_seguimiento )
	{
		$sql = "UPDATE cliente_seguimiento SET  `id_usuario` = ?, `id_cliente` = ?, `fecha` = ?, `texto` = ? WHERE  `id_cliente_seguimiento` = ?;";
		$params = array( 
			$cliente_seguimiento->getIdUsuario(), 
			$cliente_seguimiento->getIdCliente(), 
			$cliente_seguimiento->getFecha(), 
			$cliente_seguimiento->getTexto(), 
			$cliente_seguimiento->getIdClienteSeguimiento(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ClienteSeguimiento suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ClienteSeguimiento dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento a crear.
	  **/
	private static final function create( &$cliente_seguimiento )
	{
		$sql = "INSERT INTO cliente_seguimiento ( `id_cliente_seguimiento`, `id_usuario`, `id_cliente`, `fecha`, `texto` ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$cliente_seguimiento->getIdClienteSeguimiento(), 
			$cliente_seguimiento->getIdUsuario(), 
			$cliente_seguimiento->getIdCliente(), 
			$cliente_seguimiento->getFecha(), 
			$cliente_seguimiento->getTexto(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $cliente_seguimiento->setIdClienteSeguimiento( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ClienteSeguimiento} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ClienteSeguimiento}.
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
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $cliente_seguimientoA , $cliente_seguimientoB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from cliente_seguimiento WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $cliente_seguimientoA->getIdClienteSeguimiento()) ) ) & ( ! is_null ( ($b = $cliente_seguimientoB->getIdClienteSeguimiento()) ) ) ){
				$sql .= " `id_cliente_seguimiento` >= ? AND `id_cliente_seguimiento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_cliente_seguimiento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $cliente_seguimientoA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $cliente_seguimientoB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $cliente_seguimientoA->getIdCliente()) ) ) & ( ! is_null ( ($b = $cliente_seguimientoB->getIdCliente()) ) ) ){
				$sql .= " `id_cliente` >= ? AND `id_cliente` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_cliente` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $cliente_seguimientoA->getFecha()) ) ) & ( ! is_null ( ($b = $cliente_seguimientoB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $cliente_seguimientoA->getTexto()) ) ) & ( ! is_null ( ($b = $cliente_seguimientoB->getTexto()) ) ) ){
				$sql .= " `texto` >= ? AND `texto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `texto` = ? AND"; 
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
    		array_push( $ar, new ClienteSeguimiento($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ClienteSeguimiento suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ClienteSeguimiento [$cliente_seguimiento] El objeto de tipo ClienteSeguimiento a eliminar
	  **/
	public static final function delete( &$cliente_seguimiento )
	{
		if( is_null( self::getByPK($cliente_seguimiento->getIdClienteSeguimiento()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM cliente_seguimiento WHERE  id_cliente_seguimiento = ?;";
		$params = array( $cliente_seguimiento->getIdClienteSeguimiento() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
