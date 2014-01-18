<?php
/** OrdenDeServicio Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link OrdenDeServicio }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class OrdenDeServicioDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link OrdenDeServicio} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$orden_de_servicio )
	{
		if( ! is_null ( self::getByPK(  $orden_de_servicio->getIdOrdenDeServicio() ) ) )
		{
			try{ return OrdenDeServicioDAOBase::update( $orden_de_servicio) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return OrdenDeServicioDAOBase::create( $orden_de_servicio) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link OrdenDeServicio} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link OrdenDeServicio} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link OrdenDeServicio Un objeto del tipo {@link OrdenDeServicio}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_orden_de_servicio )
	{
		$sql = "SELECT * FROM orden_de_servicio WHERE (id_orden_de_servicio = ? ) LIMIT 1;";
		$params = array(  $id_orden_de_servicio );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new OrdenDeServicio( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link OrdenDeServicio}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link OrdenDeServicio}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from orden_de_servicio";
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
			$bar = new OrdenDeServicio($foo);
    		array_push( $allData, $bar);
			//id_orden_de_servicio
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link OrdenDeServicio} de la base de datos. 
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
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $orden_de_servicio , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from orden_de_servicio WHERE ("; 
		$val = array();
		if( ! is_null( $orden_de_servicio->getIdOrdenDeServicio() ) ){
			$sql .= " `id_orden_de_servicio` = ? AND";
			array_push( $val, $orden_de_servicio->getIdOrdenDeServicio() );
		}

		if( ! is_null( $orden_de_servicio->getIdServicio() ) ){
			$sql .= " `id_servicio` = ? AND";
			array_push( $val, $orden_de_servicio->getIdServicio() );
		}

		if( ! is_null( $orden_de_servicio->getIdUsuarioVenta() ) ){
			$sql .= " `id_usuario_venta` = ? AND";
			array_push( $val, $orden_de_servicio->getIdUsuarioVenta() );
		}

		if( ! is_null( $orden_de_servicio->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $orden_de_servicio->getIdUsuario() );
		}

		if( ! is_null( $orden_de_servicio->getIdUsuarioAsignado() ) ){
			$sql .= " `id_usuario_asignado` = ? AND";
			array_push( $val, $orden_de_servicio->getIdUsuarioAsignado() );
		}

		if( ! is_null( $orden_de_servicio->getFechaOrden() ) ){
			$sql .= " `fecha_orden` = ? AND";
			array_push( $val, $orden_de_servicio->getFechaOrden() );
		}

		if( ! is_null( $orden_de_servicio->getFechaEntrega() ) ){
			$sql .= " `fecha_entrega` = ? AND";
			array_push( $val, $orden_de_servicio->getFechaEntrega() );
		}

		if( ! is_null( $orden_de_servicio->getActiva() ) ){
			$sql .= " `activa` = ? AND";
			array_push( $val, $orden_de_servicio->getActiva() );
		}

		if( ! is_null( $orden_de_servicio->getCancelada() ) ){
			$sql .= " `cancelada` = ? AND";
			array_push( $val, $orden_de_servicio->getCancelada() );
		}

		if( ! is_null( $orden_de_servicio->getDescripcion() ) ){
			$sql .= " `descripcion` = ? AND";
			array_push( $val, $orden_de_servicio->getDescripcion() );
		}

		if( ! is_null( $orden_de_servicio->getMotivoCancelacion() ) ){
			$sql .= " `motivo_cancelacion` = ? AND";
			array_push( $val, $orden_de_servicio->getMotivoCancelacion() );
		}

		if( ! is_null( $orden_de_servicio->getAdelanto() ) ){
			$sql .= " `adelanto` = ? AND";
			array_push( $val, $orden_de_servicio->getAdelanto() );
		}

		if( ! is_null( $orden_de_servicio->getPrecio() ) ){
			$sql .= " `precio` = ? AND";
			array_push( $val, $orden_de_servicio->getPrecio() );
		}

		if( ! is_null( $orden_de_servicio->getExtraParams() ) ){
			$sql .= " `extra_params` = ? AND";
			array_push( $val, $orden_de_servicio->getExtraParams() );
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
			$bar =  new OrdenDeServicio($foo);
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
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio a actualizar.
	  **/
	private static final function update( $orden_de_servicio )
	{
		$sql = "UPDATE orden_de_servicio SET  `id_servicio` = ?, `id_usuario_venta` = ?, `id_usuario` = ?, `id_usuario_asignado` = ?, `fecha_orden` = ?, `fecha_entrega` = ?, `activa` = ?, `cancelada` = ?, `descripcion` = ?, `motivo_cancelacion` = ?, `adelanto` = ?, `precio` = ?, `extra_params` = ? WHERE  `id_orden_de_servicio` = ?;";
		$params = array( 
			$orden_de_servicio->getIdServicio(), 
			$orden_de_servicio->getIdUsuarioVenta(), 
			$orden_de_servicio->getIdUsuario(), 
			$orden_de_servicio->getIdUsuarioAsignado(), 
			$orden_de_servicio->getFechaOrden(), 
			$orden_de_servicio->getFechaEntrega(), 
			$orden_de_servicio->getActiva(), 
			$orden_de_servicio->getCancelada(), 
			$orden_de_servicio->getDescripcion(), 
			$orden_de_servicio->getMotivoCancelacion(), 
			$orden_de_servicio->getAdelanto(), 
			$orden_de_servicio->getPrecio(), 
			$orden_de_servicio->getExtraParams(), 
			$orden_de_servicio->getIdOrdenDeServicio(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto OrdenDeServicio suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto OrdenDeServicio dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio a crear.
	  **/
	private static final function create( &$orden_de_servicio )
	{
		$sql = "INSERT INTO orden_de_servicio ( `id_orden_de_servicio`, `id_servicio`, `id_usuario_venta`, `id_usuario`, `id_usuario_asignado`, `fecha_orden`, `fecha_entrega`, `activa`, `cancelada`, `descripcion`, `motivo_cancelacion`, `adelanto`, `precio`, `extra_params` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$orden_de_servicio->getIdOrdenDeServicio(), 
			$orden_de_servicio->getIdServicio(), 
			$orden_de_servicio->getIdUsuarioVenta(), 
			$orden_de_servicio->getIdUsuario(), 
			$orden_de_servicio->getIdUsuarioAsignado(), 
			$orden_de_servicio->getFechaOrden(), 
			$orden_de_servicio->getFechaEntrega(), 
			$orden_de_servicio->getActiva(), 
			$orden_de_servicio->getCancelada(), 
			$orden_de_servicio->getDescripcion(), 
			$orden_de_servicio->getMotivoCancelacion(), 
			$orden_de_servicio->getAdelanto(), 
			$orden_de_servicio->getPrecio(), 
			$orden_de_servicio->getExtraParams(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $orden_de_servicio->setIdOrdenDeServicio( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link OrdenDeServicio} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link OrdenDeServicio}.
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
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $orden_de_servicioA , $orden_de_servicioB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from orden_de_servicio WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $orden_de_servicioA->getIdOrdenDeServicio()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getIdOrdenDeServicio()) ) ) ){
				$sql .= " `id_orden_de_servicio` >= ? AND `id_orden_de_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_orden_de_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getIdServicio()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getIdServicio()) ) ) ){
				$sql .= " `id_servicio` >= ? AND `id_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getIdUsuarioVenta()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getIdUsuarioVenta()) ) ) ){
				$sql .= " `id_usuario_venta` >= ? AND `id_usuario_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getIdUsuarioAsignado()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getIdUsuarioAsignado()) ) ) ){
				$sql .= " `id_usuario_asignado` >= ? AND `id_usuario_asignado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_asignado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getFechaOrden()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getFechaOrden()) ) ) ){
				$sql .= " `fecha_orden` >= ? AND `fecha_orden` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_orden` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getFechaEntrega()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getFechaEntrega()) ) ) ){
				$sql .= " `fecha_entrega` >= ? AND `fecha_entrega` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_entrega` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getActiva()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getActiva()) ) ) ){
				$sql .= " `activa` >= ? AND `activa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `activa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getCancelada()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getCancelada()) ) ) ){
				$sql .= " `cancelada` >= ? AND `cancelada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getDescripcion()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getDescripcion()) ) ) ){
				$sql .= " `descripcion` >= ? AND `descripcion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descripcion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getMotivoCancelacion()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getMotivoCancelacion()) ) ) ){
				$sql .= " `motivo_cancelacion` >= ? AND `motivo_cancelacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `motivo_cancelacion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getAdelanto()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getAdelanto()) ) ) ){
				$sql .= " `adelanto` >= ? AND `adelanto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `adelanto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getPrecio()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getPrecio()) ) ) ){
				$sql .= " `precio` >= ? AND `precio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `precio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $orden_de_servicioA->getExtraParams()) ) ) & ( ! is_null ( ($b = $orden_de_servicioB->getExtraParams()) ) ) ){
				$sql .= " `extra_params` >= ? AND `extra_params` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `extra_params` = ? AND"; 
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
    		array_push( $ar, new OrdenDeServicio($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto OrdenDeServicio suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param OrdenDeServicio [$orden_de_servicio] El objeto de tipo OrdenDeServicio a eliminar
	  **/
	public static final function delete( &$orden_de_servicio )
	{
		if( is_null( self::getByPK($orden_de_servicio->getIdOrdenDeServicio()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM orden_de_servicio WHERE  id_orden_de_servicio = ?;";
		$params = array( $orden_de_servicio->getIdOrdenDeServicio() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
