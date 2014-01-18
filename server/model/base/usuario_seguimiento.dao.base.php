<?php
/** UsuarioSeguimiento Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link UsuarioSeguimiento }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class UsuarioSeguimientoDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link UsuarioSeguimiento} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$usuario_seguimiento )
	{
		if( ! is_null ( self::getByPK(  $usuario_seguimiento->getIdUsuarioSeguimiento() ) ) )
		{
			try{ return UsuarioSeguimientoDAOBase::update( $usuario_seguimiento) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return UsuarioSeguimientoDAOBase::create( $usuario_seguimiento) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link UsuarioSeguimiento} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link UsuarioSeguimiento} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link UsuarioSeguimiento Un objeto del tipo {@link UsuarioSeguimiento}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_usuario_seguimiento )
	{
		$sql = "SELECT * FROM usuario_seguimiento WHERE (id_usuario_seguimiento = ? ) LIMIT 1;";
		$params = array(  $id_usuario_seguimiento );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new UsuarioSeguimiento( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link UsuarioSeguimiento}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link UsuarioSeguimiento}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from usuario_seguimiento";
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
			$bar = new UsuarioSeguimiento($foo);
    		array_push( $allData, $bar);
			//id_usuario_seguimiento
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link UsuarioSeguimiento} de la base de datos. 
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
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $usuario_seguimiento , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from usuario_seguimiento WHERE ("; 
		$val = array();
		if( ! is_null( $usuario_seguimiento->getIdUsuarioSeguimiento() ) ){
			$sql .= " `id_usuario_seguimiento` = ? AND";
			array_push( $val, $usuario_seguimiento->getIdUsuarioSeguimiento() );
		}

		if( ! is_null( $usuario_seguimiento->getIdUsuarioRedacto() ) ){
			$sql .= " `id_usuario_redacto` = ? AND";
			array_push( $val, $usuario_seguimiento->getIdUsuarioRedacto() );
		}

		if( ! is_null( $usuario_seguimiento->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $usuario_seguimiento->getIdUsuario() );
		}

		if( ! is_null( $usuario_seguimiento->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $usuario_seguimiento->getFecha() );
		}

		if( ! is_null( $usuario_seguimiento->getTexto() ) ){
			$sql .= " `texto` = ? AND";
			array_push( $val, $usuario_seguimiento->getTexto() );
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
			$bar =  new UsuarioSeguimiento($foo);
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
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento a actualizar.
	  **/
	private static final function update( $usuario_seguimiento )
	{
		$sql = "UPDATE usuario_seguimiento SET  `id_usuario_redacto` = ?, `id_usuario` = ?, `fecha` = ?, `texto` = ? WHERE  `id_usuario_seguimiento` = ?;";
		$params = array( 
			$usuario_seguimiento->getIdUsuarioRedacto(), 
			$usuario_seguimiento->getIdUsuario(), 
			$usuario_seguimiento->getFecha(), 
			$usuario_seguimiento->getTexto(), 
			$usuario_seguimiento->getIdUsuarioSeguimiento(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto UsuarioSeguimiento suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto UsuarioSeguimiento dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento a crear.
	  **/
	private static final function create( &$usuario_seguimiento )
	{
		$sql = "INSERT INTO usuario_seguimiento ( `id_usuario_seguimiento`, `id_usuario_redacto`, `id_usuario`, `fecha`, `texto` ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$usuario_seguimiento->getIdUsuarioSeguimiento(), 
			$usuario_seguimiento->getIdUsuarioRedacto(), 
			$usuario_seguimiento->getIdUsuario(), 
			$usuario_seguimiento->getFecha(), 
			$usuario_seguimiento->getTexto(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $usuario_seguimiento->setIdUsuarioSeguimiento( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link UsuarioSeguimiento} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link UsuarioSeguimiento}.
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
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $usuario_seguimientoA , $usuario_seguimientoB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from usuario_seguimiento WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $usuario_seguimientoA->getIdUsuarioSeguimiento()) ) ) & ( ! is_null ( ($b = $usuario_seguimientoB->getIdUsuarioSeguimiento()) ) ) ){
				$sql .= " `id_usuario_seguimiento` >= ? AND `id_usuario_seguimiento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_seguimiento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuario_seguimientoA->getIdUsuarioRedacto()) ) ) & ( ! is_null ( ($b = $usuario_seguimientoB->getIdUsuarioRedacto()) ) ) ){
				$sql .= " `id_usuario_redacto` >= ? AND `id_usuario_redacto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_redacto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuario_seguimientoA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $usuario_seguimientoB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuario_seguimientoA->getFecha()) ) ) & ( ! is_null ( ($b = $usuario_seguimientoB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuario_seguimientoA->getTexto()) ) ) & ( ! is_null ( ($b = $usuario_seguimientoB->getTexto()) ) ) ){
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
    		array_push( $ar, new UsuarioSeguimiento($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto UsuarioSeguimiento suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param UsuarioSeguimiento [$usuario_seguimiento] El objeto de tipo UsuarioSeguimiento a eliminar
	  **/
	public static final function delete( &$usuario_seguimiento )
	{
		if( is_null( self::getByPK($usuario_seguimiento->getIdUsuarioSeguimiento()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM usuario_seguimiento WHERE  id_usuario_seguimiento = ?;";
		$params = array( $usuario_seguimiento->getIdUsuarioSeguimiento() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
