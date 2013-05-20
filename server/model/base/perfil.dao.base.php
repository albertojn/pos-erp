<?php
/** Perfil Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Perfil }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class PerfilDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Perfil} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Perfil [$perfil] El objeto de tipo Perfil
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$perfil )
	{
		if( ! is_null ( self::getByPK(  $perfil->getIdPerfil() ) ) )
		{
			try{ return PerfilDAOBase::update( $perfil) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return PerfilDAOBase::create( $perfil) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Perfil} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Perfil} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Perfil Un objeto del tipo {@link Perfil}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_perfil )
	{
		$sql = "SELECT * FROM perfil WHERE (id_perfil = ? ) LIMIT 1;";
		$params = array(  $id_perfil );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Perfil( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Perfil}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Perfil}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from perfil";
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
			$bar = new Perfil($foo);
    		array_push( $allData, $bar);
			//id_perfil
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Perfil} de la base de datos. 
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
	  * @param Perfil [$perfil] El objeto de tipo Perfil
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $perfil , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from perfil WHERE ("; 
		$val = array();
		if( ! is_null( $perfil->getIdPerfil() ) ){
			$sql .= " `id_perfil` = ? AND";
			array_push( $val, $perfil->getIdPerfil() );
		}

		if( ! is_null( $perfil->getDescripcion() ) ){
			$sql .= " `descripcion` = ? AND";
			array_push( $val, $perfil->getDescripcion() );
		}

		if( ! is_null( $perfil->getConfiguracion() ) ){
			$sql .= " `configuracion` = ? AND";
			array_push( $val, $perfil->getConfiguracion() );
		}

		if( ! is_null( $perfil->getFechaCreacion() ) ){
			$sql .= " `fecha_creacion` = ? AND";
			array_push( $val, $perfil->getFechaCreacion() );
		}

		if( ! is_null( $perfil->getFechaModificacion() ) ){
			$sql .= " `fecha_modificacion` = ? AND";
			array_push( $val, $perfil->getFechaModificacion() );
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
			$bar =  new Perfil($foo);
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
	  * @param Perfil [$perfil] El objeto de tipo Perfil a actualizar.
	  **/
	private static final function update( $perfil )
	{
		$sql = "UPDATE perfil SET  `descripcion` = ?, `configuracion` = ?, `fecha_creacion` = ?, `fecha_modificacion` = ? WHERE  `id_perfil` = ?;";
		$params = array( 
			$perfil->getDescripcion(), 
			$perfil->getConfiguracion(), 
			$perfil->getFechaCreacion(), 
			$perfil->getFechaModificacion(), 
			$perfil->getIdPerfil(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Perfil suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Perfil dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Perfil [$perfil] El objeto de tipo Perfil a crear.
	  **/
	private static final function create( &$perfil )
	{
		$sql = "INSERT INTO perfil ( `id_perfil`, `descripcion`, `configuracion`, `fecha_creacion`, `fecha_modificacion` ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$perfil->getIdPerfil(), 
			$perfil->getDescripcion(), 
			$perfil->getConfiguracion(), 
			$perfil->getFechaCreacion(), 
			$perfil->getFechaModificacion(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Perfil} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Perfil}.
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
	  * @param Perfil [$perfil] El objeto de tipo Perfil
	  * @param Perfil [$perfil] El objeto de tipo Perfil
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $perfilA , $perfilB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from perfil WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $perfilA->getIdPerfil()) ) ) & ( ! is_null ( ($b = $perfilB->getIdPerfil()) ) ) ){
				$sql .= " `id_perfil` >= ? AND `id_perfil` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_perfil` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $perfilA->getDescripcion()) ) ) & ( ! is_null ( ($b = $perfilB->getDescripcion()) ) ) ){
				$sql .= " `descripcion` >= ? AND `descripcion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descripcion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $perfilA->getConfiguracion()) ) ) & ( ! is_null ( ($b = $perfilB->getConfiguracion()) ) ) ){
				$sql .= " `configuracion` >= ? AND `configuracion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `configuracion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $perfilA->getFechaCreacion()) ) ) & ( ! is_null ( ($b = $perfilB->getFechaCreacion()) ) ) ){
				$sql .= " `fecha_creacion` >= ? AND `fecha_creacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_creacion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $perfilA->getFechaModificacion()) ) ) & ( ! is_null ( ($b = $perfilB->getFechaModificacion()) ) ) ){
				$sql .= " `fecha_modificacion` >= ? AND `fecha_modificacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_modificacion` = ? AND"; 
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
    		array_push( $ar, new Perfil($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Perfil suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Perfil [$perfil] El objeto de tipo Perfil a eliminar
	  **/
	public static final function delete( &$perfil )
	{
		if( is_null( self::getByPK($perfil->getIdPerfil()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM perfil WHERE  id_perfil = ?;";
		$params = array( $perfil->getIdPerfil() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
