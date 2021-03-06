<?php
/** Gasto Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Gasto }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class GastoDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Gasto} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Gasto [$gasto] El objeto de tipo Gasto
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$gasto )
	{
		if( ! is_null ( self::getByPK(  $gasto->getIdGasto() ) ) )
		{
			try{ return GastoDAOBase::update( $gasto) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return GastoDAOBase::create( $gasto) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Gasto} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Gasto} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Gasto Un objeto del tipo {@link Gasto}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_gasto )
	{
		$sql = "SELECT * FROM gasto WHERE (id_gasto = ? ) LIMIT 1;";
		$params = array(  $id_gasto );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Gasto( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Gasto}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Gasto}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from gasto";
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
			$bar = new Gasto($foo);
    		array_push( $allData, $bar);
			//id_gasto
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Gasto} de la base de datos. 
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
	  * @param Gasto [$gasto] El objeto de tipo Gasto
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $gasto , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from gasto WHERE ("; 
		$val = array();
		if( ! is_null( $gasto->getIdGasto() ) ){
			$sql .= " `id_gasto` = ? AND";
			array_push( $val, $gasto->getIdGasto() );
		}

		if( ! is_null( $gasto->getIdEmpresa() ) ){
			$sql .= " `id_empresa` = ? AND";
			array_push( $val, $gasto->getIdEmpresa() );
		}

		if( ! is_null( $gasto->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $gasto->getIdUsuario() );
		}

		if( ! is_null( $gasto->getIdConceptoGasto() ) ){
			$sql .= " `id_concepto_gasto` = ? AND";
			array_push( $val, $gasto->getIdConceptoGasto() );
		}

		if( ! is_null( $gasto->getIdOrdenDeServicio() ) ){
			$sql .= " `id_orden_de_servicio` = ? AND";
			array_push( $val, $gasto->getIdOrdenDeServicio() );
		}

		if( ! is_null( $gasto->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $gasto->getIdCaja() );
		}

		if( ! is_null( $gasto->getFechaDelGasto() ) ){
			$sql .= " `fecha_del_gasto` = ? AND";
			array_push( $val, $gasto->getFechaDelGasto() );
		}

		if( ! is_null( $gasto->getFechaDeRegistro() ) ){
			$sql .= " `fecha_de_registro` = ? AND";
			array_push( $val, $gasto->getFechaDeRegistro() );
		}

		if( ! is_null( $gasto->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $gasto->getIdSucursal() );
		}

		if( ! is_null( $gasto->getNota() ) ){
			$sql .= " `nota` = ? AND";
			array_push( $val, $gasto->getNota() );
		}

		if( ! is_null( $gasto->getDescripcion() ) ){
			$sql .= " `descripcion` = ? AND";
			array_push( $val, $gasto->getDescripcion() );
		}

		if( ! is_null( $gasto->getFolio() ) ){
			$sql .= " `folio` = ? AND";
			array_push( $val, $gasto->getFolio() );
		}

		if( ! is_null( $gasto->getMonto() ) ){
			$sql .= " `monto` = ? AND";
			array_push( $val, $gasto->getMonto() );
		}

		if( ! is_null( $gasto->getCancelado() ) ){
			$sql .= " `cancelado` = ? AND";
			array_push( $val, $gasto->getCancelado() );
		}

		if( ! is_null( $gasto->getMotivoCancelacion() ) ){
			$sql .= " `motivo_cancelacion` = ? AND";
			array_push( $val, $gasto->getMotivoCancelacion() );
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
			$bar =  new Gasto($foo);
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
	  * @param Gasto [$gasto] El objeto de tipo Gasto a actualizar.
	  **/
	private static final function update( $gasto )
	{
		$sql = "UPDATE gasto SET  `id_empresa` = ?, `id_usuario` = ?, `id_concepto_gasto` = ?, `id_orden_de_servicio` = ?, `id_caja` = ?, `fecha_del_gasto` = ?, `fecha_de_registro` = ?, `id_sucursal` = ?, `nota` = ?, `descripcion` = ?, `folio` = ?, `monto` = ?, `cancelado` = ?, `motivo_cancelacion` = ? WHERE  `id_gasto` = ?;";
		$params = array( 
			$gasto->getIdEmpresa(), 
			$gasto->getIdUsuario(), 
			$gasto->getIdConceptoGasto(), 
			$gasto->getIdOrdenDeServicio(), 
			$gasto->getIdCaja(), 
			$gasto->getFechaDelGasto(), 
			$gasto->getFechaDeRegistro(), 
			$gasto->getIdSucursal(), 
			$gasto->getNota(), 
			$gasto->getDescripcion(), 
			$gasto->getFolio(), 
			$gasto->getMonto(), 
			$gasto->getCancelado(), 
			$gasto->getMotivoCancelacion(), 
			$gasto->getIdGasto(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Gasto suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Gasto dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Gasto [$gasto] El objeto de tipo Gasto a crear.
	  **/
	private static final function create( &$gasto )
	{
		$sql = "INSERT INTO gasto ( `id_gasto`, `id_empresa`, `id_usuario`, `id_concepto_gasto`, `id_orden_de_servicio`, `id_caja`, `fecha_del_gasto`, `fecha_de_registro`, `id_sucursal`, `nota`, `descripcion`, `folio`, `monto`, `cancelado`, `motivo_cancelacion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$gasto->getIdGasto(), 
			$gasto->getIdEmpresa(), 
			$gasto->getIdUsuario(), 
			$gasto->getIdConceptoGasto(), 
			$gasto->getIdOrdenDeServicio(), 
			$gasto->getIdCaja(), 
			$gasto->getFechaDelGasto(), 
			$gasto->getFechaDeRegistro(), 
			$gasto->getIdSucursal(), 
			$gasto->getNota(), 
			$gasto->getDescripcion(), 
			$gasto->getFolio(), 
			$gasto->getMonto(), 
			$gasto->getCancelado(), 
			$gasto->getMotivoCancelacion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $gasto->setIdGasto( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Gasto} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Gasto}.
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
	  * @param Gasto [$gasto] El objeto de tipo Gasto
	  * @param Gasto [$gasto] El objeto de tipo Gasto
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $gastoA , $gastoB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from gasto WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $gastoA->getIdGasto()) ) ) & ( ! is_null ( ($b = $gastoB->getIdGasto()) ) ) ){
				$sql .= " `id_gasto` >= ? AND `id_gasto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_gasto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getIdEmpresa()) ) ) & ( ! is_null ( ($b = $gastoB->getIdEmpresa()) ) ) ){
				$sql .= " `id_empresa` >= ? AND `id_empresa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_empresa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $gastoB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getIdConceptoGasto()) ) ) & ( ! is_null ( ($b = $gastoB->getIdConceptoGasto()) ) ) ){
				$sql .= " `id_concepto_gasto` >= ? AND `id_concepto_gasto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_concepto_gasto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getIdOrdenDeServicio()) ) ) & ( ! is_null ( ($b = $gastoB->getIdOrdenDeServicio()) ) ) ){
				$sql .= " `id_orden_de_servicio` >= ? AND `id_orden_de_servicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_orden_de_servicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getIdCaja()) ) ) & ( ! is_null ( ($b = $gastoB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getFechaDelGasto()) ) ) & ( ! is_null ( ($b = $gastoB->getFechaDelGasto()) ) ) ){
				$sql .= " `fecha_del_gasto` >= ? AND `fecha_del_gasto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_del_gasto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getFechaDeRegistro()) ) ) & ( ! is_null ( ($b = $gastoB->getFechaDeRegistro()) ) ) ){
				$sql .= " `fecha_de_registro` >= ? AND `fecha_de_registro` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_de_registro` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $gastoB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getNota()) ) ) & ( ! is_null ( ($b = $gastoB->getNota()) ) ) ){
				$sql .= " `nota` >= ? AND `nota` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nota` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getDescripcion()) ) ) & ( ! is_null ( ($b = $gastoB->getDescripcion()) ) ) ){
				$sql .= " `descripcion` >= ? AND `descripcion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descripcion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getFolio()) ) ) & ( ! is_null ( ($b = $gastoB->getFolio()) ) ) ){
				$sql .= " `folio` >= ? AND `folio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `folio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getMonto()) ) ) & ( ! is_null ( ($b = $gastoB->getMonto()) ) ) ){
				$sql .= " `monto` >= ? AND `monto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `monto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getCancelado()) ) ) & ( ! is_null ( ($b = $gastoB->getCancelado()) ) ) ){
				$sql .= " `cancelado` >= ? AND `cancelado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $gastoA->getMotivoCancelacion()) ) ) & ( ! is_null ( ($b = $gastoB->getMotivoCancelacion()) ) ) ){
				$sql .= " `motivo_cancelacion` >= ? AND `motivo_cancelacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `motivo_cancelacion` = ? AND"; 
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
    		array_push( $ar, new Gasto($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Gasto suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Gasto [$gasto] El objeto de tipo Gasto a eliminar
	  **/
	public static final function delete( &$gasto )
	{
		if( is_null( self::getByPK($gasto->getIdGasto()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM gasto WHERE  id_gasto = ?;";
		$params = array( $gasto->getIdGasto() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
