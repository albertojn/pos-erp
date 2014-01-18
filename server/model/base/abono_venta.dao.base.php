<?php
/** AbonoVenta Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link AbonoVenta }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class AbonoVentaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link AbonoVenta} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$abono_venta )
	{
		if( ! is_null ( self::getByPK(  $abono_venta->getIdAbonoVenta() ) ) )
		{
			try{ return AbonoVentaDAOBase::update( $abono_venta) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return AbonoVentaDAOBase::create( $abono_venta) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link AbonoVenta} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link AbonoVenta} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link AbonoVenta Un objeto del tipo {@link AbonoVenta}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_abono_venta )
	{
		$sql = "SELECT * FROM abono_venta WHERE (id_abono_venta = ? ) LIMIT 1;";
		$params = array(  $id_abono_venta );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new AbonoVenta( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link AbonoVenta}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link AbonoVenta}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from abono_venta";
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
			$bar = new AbonoVenta($foo);
    		array_push( $allData, $bar);
			//id_abono_venta
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link AbonoVenta} de la base de datos. 
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
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $abono_venta , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from abono_venta WHERE ("; 
		$val = array();
		if( ! is_null( $abono_venta->getIdAbonoVenta() ) ){
			$sql .= " `id_abono_venta` = ? AND";
			array_push( $val, $abono_venta->getIdAbonoVenta() );
		}

		if( ! is_null( $abono_venta->getIdVenta() ) ){
			$sql .= " `id_venta` = ? AND";
			array_push( $val, $abono_venta->getIdVenta() );
		}

		if( ! is_null( $abono_venta->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $abono_venta->getIdSucursal() );
		}

		if( ! is_null( $abono_venta->getMonto() ) ){
			$sql .= " `monto` = ? AND";
			array_push( $val, $abono_venta->getMonto() );
		}

		if( ! is_null( $abono_venta->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $abono_venta->getIdCaja() );
		}

		if( ! is_null( $abono_venta->getIdDeudor() ) ){
			$sql .= " `id_deudor` = ? AND";
			array_push( $val, $abono_venta->getIdDeudor() );
		}

		if( ! is_null( $abono_venta->getIdReceptor() ) ){
			$sql .= " `id_receptor` = ? AND";
			array_push( $val, $abono_venta->getIdReceptor() );
		}

		if( ! is_null( $abono_venta->getNota() ) ){
			$sql .= " `nota` = ? AND";
			array_push( $val, $abono_venta->getNota() );
		}

		if( ! is_null( $abono_venta->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $abono_venta->getFecha() );
		}

		if( ! is_null( $abono_venta->getTipoDePago() ) ){
			$sql .= " `tipo_de_pago` = ? AND";
			array_push( $val, $abono_venta->getTipoDePago() );
		}

		if( ! is_null( $abono_venta->getCancelado() ) ){
			$sql .= " `cancelado` = ? AND";
			array_push( $val, $abono_venta->getCancelado() );
		}

		if( ! is_null( $abono_venta->getMotivoCancelacion() ) ){
			$sql .= " `motivo_cancelacion` = ? AND";
			array_push( $val, $abono_venta->getMotivoCancelacion() );
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
			$bar =  new AbonoVenta($foo);
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
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta a actualizar.
	  **/
	private static final function update( $abono_venta )
	{
		$sql = "UPDATE abono_venta SET  `id_venta` = ?, `id_sucursal` = ?, `monto` = ?, `id_caja` = ?, `id_deudor` = ?, `id_receptor` = ?, `nota` = ?, `fecha` = ?, `tipo_de_pago` = ?, `cancelado` = ?, `motivo_cancelacion` = ? WHERE  `id_abono_venta` = ?;";
		$params = array( 
			$abono_venta->getIdVenta(), 
			$abono_venta->getIdSucursal(), 
			$abono_venta->getMonto(), 
			$abono_venta->getIdCaja(), 
			$abono_venta->getIdDeudor(), 
			$abono_venta->getIdReceptor(), 
			$abono_venta->getNota(), 
			$abono_venta->getFecha(), 
			$abono_venta->getTipoDePago(), 
			$abono_venta->getCancelado(), 
			$abono_venta->getMotivoCancelacion(), 
			$abono_venta->getIdAbonoVenta(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto AbonoVenta suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto AbonoVenta dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta a crear.
	  **/
	private static final function create( &$abono_venta )
	{
		$sql = "INSERT INTO abono_venta ( `id_abono_venta`, `id_venta`, `id_sucursal`, `monto`, `id_caja`, `id_deudor`, `id_receptor`, `nota`, `fecha`, `tipo_de_pago`, `cancelado`, `motivo_cancelacion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$abono_venta->getIdAbonoVenta(), 
			$abono_venta->getIdVenta(), 
			$abono_venta->getIdSucursal(), 
			$abono_venta->getMonto(), 
			$abono_venta->getIdCaja(), 
			$abono_venta->getIdDeudor(), 
			$abono_venta->getIdReceptor(), 
			$abono_venta->getNota(), 
			$abono_venta->getFecha(), 
			$abono_venta->getTipoDePago(), 
			$abono_venta->getCancelado(), 
			$abono_venta->getMotivoCancelacion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $abono_venta->setIdAbonoVenta( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link AbonoVenta} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link AbonoVenta}.
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
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $abono_ventaA , $abono_ventaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from abono_venta WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $abono_ventaA->getIdAbonoVenta()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getIdAbonoVenta()) ) ) ){
				$sql .= " `id_abono_venta` >= ? AND `id_abono_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_abono_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getIdVenta()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getIdVenta()) ) ) ){
				$sql .= " `id_venta` >= ? AND `id_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getMonto()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getMonto()) ) ) ){
				$sql .= " `monto` >= ? AND `monto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `monto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getIdCaja()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getIdDeudor()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getIdDeudor()) ) ) ){
				$sql .= " `id_deudor` >= ? AND `id_deudor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_deudor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getIdReceptor()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getIdReceptor()) ) ) ){
				$sql .= " `id_receptor` >= ? AND `id_receptor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_receptor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getNota()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getNota()) ) ) ){
				$sql .= " `nota` >= ? AND `nota` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nota` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getFecha()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getTipoDePago()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getTipoDePago()) ) ) ){
				$sql .= " `tipo_de_pago` >= ? AND `tipo_de_pago` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_de_pago` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getCancelado()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getCancelado()) ) ) ){
				$sql .= " `cancelado` >= ? AND `cancelado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_ventaA->getMotivoCancelacion()) ) ) & ( ! is_null ( ($b = $abono_ventaB->getMotivoCancelacion()) ) ) ){
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
    		array_push( $ar, new AbonoVenta($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto AbonoVenta suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param AbonoVenta [$abono_venta] El objeto de tipo AbonoVenta a eliminar
	  **/
	public static final function delete( &$abono_venta )
	{
		if( is_null( self::getByPK($abono_venta->getIdAbonoVenta()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM abono_venta WHERE  id_abono_venta = ?;";
		$params = array( $abono_venta->getIdAbonoVenta() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
