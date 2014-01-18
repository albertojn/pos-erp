<?php
/** AbonoCompra Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link AbonoCompra }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class AbonoCompraDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link AbonoCompra} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$abono_compra )
	{
		if( ! is_null ( self::getByPK(  $abono_compra->getIdAbonoCompra() ) ) )
		{
			try{ return AbonoCompraDAOBase::update( $abono_compra) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return AbonoCompraDAOBase::create( $abono_compra) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link AbonoCompra} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link AbonoCompra} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link AbonoCompra Un objeto del tipo {@link AbonoCompra}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_abono_compra )
	{
		$sql = "SELECT * FROM abono_compra WHERE (id_abono_compra = ? ) LIMIT 1;";
		$params = array(  $id_abono_compra );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new AbonoCompra( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link AbonoCompra}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link AbonoCompra}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from abono_compra";
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
			$bar = new AbonoCompra($foo);
    		array_push( $allData, $bar);
			//id_abono_compra
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link AbonoCompra} de la base de datos. 
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
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $abono_compra , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from abono_compra WHERE ("; 
		$val = array();
		if( ! is_null( $abono_compra->getIdAbonoCompra() ) ){
			$sql .= " `id_abono_compra` = ? AND";
			array_push( $val, $abono_compra->getIdAbonoCompra() );
		}

		if( ! is_null( $abono_compra->getIdCompra() ) ){
			$sql .= " `id_compra` = ? AND";
			array_push( $val, $abono_compra->getIdCompra() );
		}

		if( ! is_null( $abono_compra->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $abono_compra->getIdSucursal() );
		}

		if( ! is_null( $abono_compra->getMonto() ) ){
			$sql .= " `monto` = ? AND";
			array_push( $val, $abono_compra->getMonto() );
		}

		if( ! is_null( $abono_compra->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $abono_compra->getIdCaja() );
		}

		if( ! is_null( $abono_compra->getIdDeudor() ) ){
			$sql .= " `id_deudor` = ? AND";
			array_push( $val, $abono_compra->getIdDeudor() );
		}

		if( ! is_null( $abono_compra->getIdReceptor() ) ){
			$sql .= " `id_receptor` = ? AND";
			array_push( $val, $abono_compra->getIdReceptor() );
		}

		if( ! is_null( $abono_compra->getNota() ) ){
			$sql .= " `nota` = ? AND";
			array_push( $val, $abono_compra->getNota() );
		}

		if( ! is_null( $abono_compra->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $abono_compra->getFecha() );
		}

		if( ! is_null( $abono_compra->getTipoDePago() ) ){
			$sql .= " `tipo_de_pago` = ? AND";
			array_push( $val, $abono_compra->getTipoDePago() );
		}

		if( ! is_null( $abono_compra->getCancelado() ) ){
			$sql .= " `cancelado` = ? AND";
			array_push( $val, $abono_compra->getCancelado() );
		}

		if( ! is_null( $abono_compra->getMotivoCancelacion() ) ){
			$sql .= " `motivo_cancelacion` = ? AND";
			array_push( $val, $abono_compra->getMotivoCancelacion() );
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
			$bar =  new AbonoCompra($foo);
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
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra a actualizar.
	  **/
	private static final function update( $abono_compra )
	{
		$sql = "UPDATE abono_compra SET  `id_compra` = ?, `id_sucursal` = ?, `monto` = ?, `id_caja` = ?, `id_deudor` = ?, `id_receptor` = ?, `nota` = ?, `fecha` = ?, `tipo_de_pago` = ?, `cancelado` = ?, `motivo_cancelacion` = ? WHERE  `id_abono_compra` = ?;";
		$params = array( 
			$abono_compra->getIdCompra(), 
			$abono_compra->getIdSucursal(), 
			$abono_compra->getMonto(), 
			$abono_compra->getIdCaja(), 
			$abono_compra->getIdDeudor(), 
			$abono_compra->getIdReceptor(), 
			$abono_compra->getNota(), 
			$abono_compra->getFecha(), 
			$abono_compra->getTipoDePago(), 
			$abono_compra->getCancelado(), 
			$abono_compra->getMotivoCancelacion(), 
			$abono_compra->getIdAbonoCompra(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto AbonoCompra suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto AbonoCompra dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra a crear.
	  **/
	private static final function create( &$abono_compra )
	{
		$sql = "INSERT INTO abono_compra ( `id_abono_compra`, `id_compra`, `id_sucursal`, `monto`, `id_caja`, `id_deudor`, `id_receptor`, `nota`, `fecha`, `tipo_de_pago`, `cancelado`, `motivo_cancelacion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$abono_compra->getIdAbonoCompra(), 
			$abono_compra->getIdCompra(), 
			$abono_compra->getIdSucursal(), 
			$abono_compra->getMonto(), 
			$abono_compra->getIdCaja(), 
			$abono_compra->getIdDeudor(), 
			$abono_compra->getIdReceptor(), 
			$abono_compra->getNota(), 
			$abono_compra->getFecha(), 
			$abono_compra->getTipoDePago(), 
			$abono_compra->getCancelado(), 
			$abono_compra->getMotivoCancelacion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $abono_compra->setIdAbonoCompra( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link AbonoCompra} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link AbonoCompra}.
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
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $abono_compraA , $abono_compraB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from abono_compra WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $abono_compraA->getIdAbonoCompra()) ) ) & ( ! is_null ( ($b = $abono_compraB->getIdAbonoCompra()) ) ) ){
				$sql .= " `id_abono_compra` >= ? AND `id_abono_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_abono_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getIdCompra()) ) ) & ( ! is_null ( ($b = $abono_compraB->getIdCompra()) ) ) ){
				$sql .= " `id_compra` >= ? AND `id_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $abono_compraB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getMonto()) ) ) & ( ! is_null ( ($b = $abono_compraB->getMonto()) ) ) ){
				$sql .= " `monto` >= ? AND `monto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `monto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getIdCaja()) ) ) & ( ! is_null ( ($b = $abono_compraB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getIdDeudor()) ) ) & ( ! is_null ( ($b = $abono_compraB->getIdDeudor()) ) ) ){
				$sql .= " `id_deudor` >= ? AND `id_deudor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_deudor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getIdReceptor()) ) ) & ( ! is_null ( ($b = $abono_compraB->getIdReceptor()) ) ) ){
				$sql .= " `id_receptor` >= ? AND `id_receptor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_receptor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getNota()) ) ) & ( ! is_null ( ($b = $abono_compraB->getNota()) ) ) ){
				$sql .= " `nota` >= ? AND `nota` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nota` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getFecha()) ) ) & ( ! is_null ( ($b = $abono_compraB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getTipoDePago()) ) ) & ( ! is_null ( ($b = $abono_compraB->getTipoDePago()) ) ) ){
				$sql .= " `tipo_de_pago` >= ? AND `tipo_de_pago` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_de_pago` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getCancelado()) ) ) & ( ! is_null ( ($b = $abono_compraB->getCancelado()) ) ) ){
				$sql .= " `cancelado` >= ? AND `cancelado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $abono_compraA->getMotivoCancelacion()) ) ) & ( ! is_null ( ($b = $abono_compraB->getMotivoCancelacion()) ) ) ){
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
    		array_push( $ar, new AbonoCompra($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto AbonoCompra suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param AbonoCompra [$abono_compra] El objeto de tipo AbonoCompra a eliminar
	  **/
	public static final function delete( &$abono_compra )
	{
		if( is_null( self::getByPK($abono_compra->getIdAbonoCompra()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM abono_compra WHERE  id_abono_compra = ?;";
		$params = array( $abono_compra->getIdAbonoCompra() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
