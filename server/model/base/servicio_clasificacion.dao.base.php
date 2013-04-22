<?php
/** ServicioClasificacion Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ServicioClasificacion }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ServicioClasificacionDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link ServicioClasificacion} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$servicio_clasificacion )
	{
		if( ! is_null ( self::getByPK(  $servicio_clasificacion->getIdServicio() , $servicio_clasificacion->getIdClasificacionServicio() ) ) )
		{
			try{ return ServicioClasificacionDAOBase::update( $servicio_clasificacion) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ServicioClasificacionDAOBase::create( $servicio_clasificacion) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link ServicioClasificacion} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link ServicioClasificacion} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link ServicioClasificacion Un objeto del tipo {@link ServicioClasificacion}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_servicio, $id_clasificacion_servicio )
	{
		$sql = "SELECT * FROM servicio_clasificacion WHERE (id_servicio = ? AND id_clasificacion_servicio = ? ) LIMIT 1;";
		$params = array(  $id_servicio, $id_clasificacion_servicio );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new ServicioClasificacion( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link ServicioClasificacion}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link ServicioClasificacion}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from servicio_clasificacion";
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
			$bar = new ServicioClasificacion($foo);
    		array_push( $allData, $bar);
			//id_servicio
			//id_clasificacion_servicio
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ServicioClasificacion} de la base de datos. 
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
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $servicio_clasificacion , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from servicio_clasificacion WHERE ("; 
		$val = array();
		if( ! is_null( $servicio_clasificacion->getIdServicio() ) ){
			$sql .= " `id_servicio` = ? AND";
			array_push( $val, $servicio_clasificacion->getIdServicio() );
		}

		if( ! is_null( $servicio_clasificacion->getIdClasificacionServicio() ) ){
			$sql .= " `id_clasificacion_servicio` = ? AND";
			array_push( $val, $servicio_clasificacion->getIdClasificacionServicio() );
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
			$bar =  new ServicioClasificacion($foo);
    		array_push( $ar,$bar);
		}
		return $ar;
	}


	/**
	  *	Actualizar registros.
	  *	
	  * Este metodo es un metodo de ayuda para uso interno. Se ejecutara todas las manipulaciones
	  * en la base de datos que estan dadas en el objeto pasado.No se haran consultas SELECT 
	  * aqui, sin embargo. El valor de retorno indica cu�ntas filas se vieron afectadas.
	  *	
	  * @internal private information for advanced developers only
	  * @return Filas afectadas o un string con la descripcion del error
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion a actualizar.
	  **/
	private static final function update( $servicio_clasificacion )
	{
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto ServicioClasificacion suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto ServicioClasificacion dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion a crear.
	  **/
	private static final function create( &$servicio_clasificacion )
	{
		$sql = "INSERT INTO servicio_clasificacion ( `id_servicio`, `id_clasificacion_servicio` ) VALUES ( ?, ?);";
		$params = array( 
			$servicio_clasificacion->getIdServicio(), 
			$servicio_clasificacion->getIdClasificacionServicio(), 
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
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link ServicioClasificacion} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link ServicioClasificacion}.
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
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $servicio_clasificacionA , $servicio_clasificacionB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from servicio_clasificacion WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $servicio_clasificacionA->getIdServicio()) ) ) & ( ! is_null ( ($b = $servicio_clasificacionB->getIdServicio()) ) ) ){
				$sql .= " `id_servicio` >= ? AND `id_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $servicio_clasificacionA->getIdClasificacionServicio()) ) ) & ( ! is_null ( ($b = $servicio_clasificacionB->getIdClasificacionServicio()) ) ) ){
				$sql .= " `id_clasificacion_servicio` >= ? AND `id_clasificacion_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_servicio` = ? AND"; 
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
    		array_push( $ar, new ServicioClasificacion($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto ServicioClasificacion suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param ServicioClasificacion [$servicio_clasificacion] El objeto de tipo ServicioClasificacion a eliminar
	  **/
	public static final function delete( &$servicio_clasificacion )
	{
		if( is_null( self::getByPK($servicio_clasificacion->getIdServicio(), $servicio_clasificacion->getIdClasificacionServicio()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM servicio_clasificacion WHERE  id_servicio = ? AND id_clasificacion_servicio = ?;";
		$params = array( $servicio_clasificacion->getIdServicio(), $servicio_clasificacion->getIdClasificacionServicio() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
