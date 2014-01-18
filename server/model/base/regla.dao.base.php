<?php
/** Regla Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Regla }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class ReglaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Regla} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Regla [$regla] El objeto de tipo Regla
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$regla )
	{
		if( ! is_null ( self::getByPK(  $regla->getIdRegla() ) ) )
		{
			try{ return ReglaDAOBase::update( $regla) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return ReglaDAOBase::create( $regla) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Regla} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Regla} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Regla Un objeto del tipo {@link Regla}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_regla )
	{
		$sql = "SELECT * FROM regla WHERE (id_regla = ? ) LIMIT 1;";
		$params = array(  $id_regla );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Regla( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Regla}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Regla}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from regla";
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
			$bar = new Regla($foo);
    		array_push( $allData, $bar);
			//id_regla
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Regla} de la base de datos. 
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
	  * @param Regla [$regla] El objeto de tipo Regla
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $regla , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from regla WHERE ("; 
		$val = array();
		if( ! is_null( $regla->getIdRegla() ) ){
			$sql .= " `id_regla` = ? AND";
			array_push( $val, $regla->getIdRegla() );
		}

		if( ! is_null( $regla->getIdVersion() ) ){
			$sql .= " `id_version` = ? AND";
			array_push( $val, $regla->getIdVersion() );
		}

		if( ! is_null( $regla->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $regla->getNombre() );
		}

		if( ! is_null( $regla->getIdProducto() ) ){
			$sql .= " `id_producto` = ? AND";
			array_push( $val, $regla->getIdProducto() );
		}

		if( ! is_null( $regla->getIdClasificacionProducto() ) ){
			$sql .= " `id_clasificacion_producto` = ? AND";
			array_push( $val, $regla->getIdClasificacionProducto() );
		}

		if( ! is_null( $regla->getIdUnidad() ) ){
			$sql .= " `id_unidad` = ? AND";
			array_push( $val, $regla->getIdUnidad() );
		}

		if( ! is_null( $regla->getIdServicio() ) ){
			$sql .= " `id_servicio` = ? AND";
			array_push( $val, $regla->getIdServicio() );
		}

		if( ! is_null( $regla->getIdClasificacionServicio() ) ){
			$sql .= " `id_clasificacion_servicio` = ? AND";
			array_push( $val, $regla->getIdClasificacionServicio() );
		}

		if( ! is_null( $regla->getIdPaquete() ) ){
			$sql .= " `id_paquete` = ? AND";
			array_push( $val, $regla->getIdPaquete() );
		}

		if( ! is_null( $regla->getCantidadMinima() ) ){
			$sql .= " `cantidad_minima` = ? AND";
			array_push( $val, $regla->getCantidadMinima() );
		}

		if( ! is_null( $regla->getIdTarifa() ) ){
			$sql .= " `id_tarifa` = ? AND";
			array_push( $val, $regla->getIdTarifa() );
		}

		if( ! is_null( $regla->getPorcentajeUtilidad() ) ){
			$sql .= " `porcentaje_utilidad` = ? AND";
			array_push( $val, $regla->getPorcentajeUtilidad() );
		}

		if( ! is_null( $regla->getUtilidadNeta() ) ){
			$sql .= " `utilidad_neta` = ? AND";
			array_push( $val, $regla->getUtilidadNeta() );
		}

		if( ! is_null( $regla->getMetodoRedondeo() ) ){
			$sql .= " `metodo_redondeo` = ? AND";
			array_push( $val, $regla->getMetodoRedondeo() );
		}

		if( ! is_null( $regla->getMargenMin() ) ){
			$sql .= " `margen_min` = ? AND";
			array_push( $val, $regla->getMargenMin() );
		}

		if( ! is_null( $regla->getMargenMax() ) ){
			$sql .= " `margen_max` = ? AND";
			array_push( $val, $regla->getMargenMax() );
		}

		if( ! is_null( $regla->getSecuencia() ) ){
			$sql .= " `secuencia` = ? AND";
			array_push( $val, $regla->getSecuencia() );
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
			$bar =  new Regla($foo);
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
	  * @param Regla [$regla] El objeto de tipo Regla a actualizar.
	  **/
	private static final function update( $regla )
	{
		$sql = "UPDATE regla SET  `id_version` = ?, `nombre` = ?, `id_producto` = ?, `id_clasificacion_producto` = ?, `id_unidad` = ?, `id_servicio` = ?, `id_clasificacion_servicio` = ?, `id_paquete` = ?, `cantidad_minima` = ?, `id_tarifa` = ?, `porcentaje_utilidad` = ?, `utilidad_neta` = ?, `metodo_redondeo` = ?, `margen_min` = ?, `margen_max` = ?, `secuencia` = ? WHERE  `id_regla` = ?;";
		$params = array( 
			$regla->getIdVersion(), 
			$regla->getNombre(), 
			$regla->getIdProducto(), 
			$regla->getIdClasificacionProducto(), 
			$regla->getIdUnidad(), 
			$regla->getIdServicio(), 
			$regla->getIdClasificacionServicio(), 
			$regla->getIdPaquete(), 
			$regla->getCantidadMinima(), 
			$regla->getIdTarifa(), 
			$regla->getPorcentajeUtilidad(), 
			$regla->getUtilidadNeta(), 
			$regla->getMetodoRedondeo(), 
			$regla->getMargenMin(), 
			$regla->getMargenMax(), 
			$regla->getSecuencia(), 
			$regla->getIdRegla(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Regla suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Regla dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Regla [$regla] El objeto de tipo Regla a crear.
	  **/
	private static final function create( &$regla )
	{
		$sql = "INSERT INTO regla ( `id_regla`, `id_version`, `nombre`, `id_producto`, `id_clasificacion_producto`, `id_unidad`, `id_servicio`, `id_clasificacion_servicio`, `id_paquete`, `cantidad_minima`, `id_tarifa`, `porcentaje_utilidad`, `utilidad_neta`, `metodo_redondeo`, `margen_min`, `margen_max`, `secuencia` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$regla->getIdRegla(), 
			$regla->getIdVersion(), 
			$regla->getNombre(), 
			$regla->getIdProducto(), 
			$regla->getIdClasificacionProducto(), 
			$regla->getIdUnidad(), 
			$regla->getIdServicio(), 
			$regla->getIdClasificacionServicio(), 
			$regla->getIdPaquete(), 
			$regla->getCantidadMinima(), 
			$regla->getIdTarifa(), 
			$regla->getPorcentajeUtilidad(), 
			$regla->getUtilidadNeta(), 
			$regla->getMetodoRedondeo(), 
			$regla->getMargenMin(), 
			$regla->getMargenMax(), 
			$regla->getSecuencia(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $regla->setIdRegla( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Regla} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Regla}.
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
	  * @param Regla [$regla] El objeto de tipo Regla
	  * @param Regla [$regla] El objeto de tipo Regla
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $reglaA , $reglaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from regla WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $reglaA->getIdRegla()) ) ) & ( ! is_null ( ($b = $reglaB->getIdRegla()) ) ) ){
				$sql .= " `id_regla` >= ? AND `id_regla` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_regla` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdVersion()) ) ) & ( ! is_null ( ($b = $reglaB->getIdVersion()) ) ) ){
				$sql .= " `id_version` >= ? AND `id_version` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_version` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getNombre()) ) ) & ( ! is_null ( ($b = $reglaB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdProducto()) ) ) & ( ! is_null ( ($b = $reglaB->getIdProducto()) ) ) ){
				$sql .= " `id_producto` >= ? AND `id_producto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_producto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdClasificacionProducto()) ) ) & ( ! is_null ( ($b = $reglaB->getIdClasificacionProducto()) ) ) ){
				$sql .= " `id_clasificacion_producto` >= ? AND `id_clasificacion_producto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_producto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdUnidad()) ) ) & ( ! is_null ( ($b = $reglaB->getIdUnidad()) ) ) ){
				$sql .= " `id_unidad` >= ? AND `id_unidad` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_unidad` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdServicio()) ) ) & ( ! is_null ( ($b = $reglaB->getIdServicio()) ) ) ){
				$sql .= " `id_servicio` >= ? AND `id_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdClasificacionServicio()) ) ) & ( ! is_null ( ($b = $reglaB->getIdClasificacionServicio()) ) ) ){
				$sql .= " `id_clasificacion_servicio` >= ? AND `id_clasificacion_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdPaquete()) ) ) & ( ! is_null ( ($b = $reglaB->getIdPaquete()) ) ) ){
				$sql .= " `id_paquete` >= ? AND `id_paquete` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_paquete` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getCantidadMinima()) ) ) & ( ! is_null ( ($b = $reglaB->getCantidadMinima()) ) ) ){
				$sql .= " `cantidad_minima` >= ? AND `cantidad_minima` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cantidad_minima` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getIdTarifa()) ) ) & ( ! is_null ( ($b = $reglaB->getIdTarifa()) ) ) ){
				$sql .= " `id_tarifa` >= ? AND `id_tarifa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getPorcentajeUtilidad()) ) ) & ( ! is_null ( ($b = $reglaB->getPorcentajeUtilidad()) ) ) ){
				$sql .= " `porcentaje_utilidad` >= ? AND `porcentaje_utilidad` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `porcentaje_utilidad` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getUtilidadNeta()) ) ) & ( ! is_null ( ($b = $reglaB->getUtilidadNeta()) ) ) ){
				$sql .= " `utilidad_neta` >= ? AND `utilidad_neta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `utilidad_neta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getMetodoRedondeo()) ) ) & ( ! is_null ( ($b = $reglaB->getMetodoRedondeo()) ) ) ){
				$sql .= " `metodo_redondeo` >= ? AND `metodo_redondeo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `metodo_redondeo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getMargenMin()) ) ) & ( ! is_null ( ($b = $reglaB->getMargenMin()) ) ) ){
				$sql .= " `margen_min` >= ? AND `margen_min` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `margen_min` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getMargenMax()) ) ) & ( ! is_null ( ($b = $reglaB->getMargenMax()) ) ) ){
				$sql .= " `margen_max` >= ? AND `margen_max` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `margen_max` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $reglaA->getSecuencia()) ) ) & ( ! is_null ( ($b = $reglaB->getSecuencia()) ) ) ){
				$sql .= " `secuencia` >= ? AND `secuencia` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `secuencia` = ? AND"; 
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
    		array_push( $ar, new Regla($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Regla suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Regla [$regla] El objeto de tipo Regla a eliminar
	  **/
	public static final function delete( &$regla )
	{
		if( is_null( self::getByPK($regla->getIdRegla()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM regla WHERE  id_regla = ?;";
		$params = array( $regla->getIdRegla() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
