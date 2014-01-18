<?php
/** Venta Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Venta }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class VentaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Venta} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Venta [$venta] El objeto de tipo Venta
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$venta )
	{
		if( ! is_null ( self::getByPK(  $venta->getIdVenta() ) ) )
		{
			try{ return VentaDAOBase::update( $venta) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return VentaDAOBase::create( $venta) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Venta} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Venta} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Venta Un objeto del tipo {@link Venta}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_venta )
	{
		$sql = "SELECT * FROM venta WHERE (id_venta = ? ) LIMIT 1;";
		$params = array(  $id_venta );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Venta( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Venta}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Venta}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from venta";
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
			$bar = new Venta($foo);
    		array_push( $allData, $bar);
			//id_venta
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Venta} de la base de datos. 
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
	  * @param Venta [$venta] El objeto de tipo Venta
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $venta , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta WHERE ("; 
		$val = array();
		if( ! is_null( $venta->getIdVenta() ) ){
			$sql .= " `id_venta` = ? AND";
			array_push( $val, $venta->getIdVenta() );
		}

		if( ! is_null( $venta->getEsCotizacion() ) ){
			$sql .= " `es_cotizacion` = ? AND";
			array_push( $val, $venta->getEsCotizacion() );
		}

		if( ! is_null( $venta->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $venta->getIdCaja() );
		}

		if( ! is_null( $venta->getIdVentaCaja() ) ){
			$sql .= " `id_venta_caja` = ? AND";
			array_push( $val, $venta->getIdVentaCaja() );
		}

		if( ! is_null( $venta->getIdCompradorVenta() ) ){
			$sql .= " `id_comprador_venta` = ? AND";
			array_push( $val, $venta->getIdCompradorVenta() );
		}

		if( ! is_null( $venta->getTipoDeVenta() ) ){
			$sql .= " `tipo_de_venta` = ? AND";
			array_push( $val, $venta->getTipoDeVenta() );
		}

		if( ! is_null( $venta->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $venta->getFecha() );
		}

		if( ! is_null( $venta->getSubtotal() ) ){
			$sql .= " `subtotal` = ? AND";
			array_push( $val, $venta->getSubtotal() );
		}

		if( ! is_null( $venta->getImpuesto() ) ){
			$sql .= " `impuesto` = ? AND";
			array_push( $val, $venta->getImpuesto() );
		}

		if( ! is_null( $venta->getDescuento() ) ){
			$sql .= " `descuento` = ? AND";
			array_push( $val, $venta->getDescuento() );
		}

		if( ! is_null( $venta->getTotal() ) ){
			$sql .= " `total` = ? AND";
			array_push( $val, $venta->getTotal() );
		}

		if( ! is_null( $venta->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $venta->getIdSucursal() );
		}

		if( ! is_null( $venta->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $venta->getIdUsuario() );
		}

		if( ! is_null( $venta->getSaldo() ) ){
			$sql .= " `saldo` = ? AND";
			array_push( $val, $venta->getSaldo() );
		}

		if( ! is_null( $venta->getCancelada() ) ){
			$sql .= " `cancelada` = ? AND";
			array_push( $val, $venta->getCancelada() );
		}

		if( ! is_null( $venta->getTipoDePago() ) ){
			$sql .= " `tipo_de_pago` = ? AND";
			array_push( $val, $venta->getTipoDePago() );
		}

		if( ! is_null( $venta->getRetencion() ) ){
			$sql .= " `retencion` = ? AND";
			array_push( $val, $venta->getRetencion() );
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
			$bar =  new Venta($foo);
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
	  * @param Venta [$venta] El objeto de tipo Venta a actualizar.
	  **/
	private static final function update( $venta )
	{
		$sql = "UPDATE venta SET  `es_cotizacion` = ?, `id_caja` = ?, `id_venta_caja` = ?, `id_comprador_venta` = ?, `tipo_de_venta` = ?, `fecha` = ?, `subtotal` = ?, `impuesto` = ?, `descuento` = ?, `total` = ?, `id_sucursal` = ?, `id_usuario` = ?, `saldo` = ?, `cancelada` = ?, `tipo_de_pago` = ?, `retencion` = ? WHERE  `id_venta` = ?;";
		$params = array( 
			$venta->getEsCotizacion(), 
			$venta->getIdCaja(), 
			$venta->getIdVentaCaja(), 
			$venta->getIdCompradorVenta(), 
			$venta->getTipoDeVenta(), 
			$venta->getFecha(), 
			$venta->getSubtotal(), 
			$venta->getImpuesto(), 
			$venta->getDescuento(), 
			$venta->getTotal(), 
			$venta->getIdSucursal(), 
			$venta->getIdUsuario(), 
			$venta->getSaldo(), 
			$venta->getCancelada(), 
			$venta->getTipoDePago(), 
			$venta->getRetencion(), 
			$venta->getIdVenta(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Venta suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Venta dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Venta [$venta] El objeto de tipo Venta a crear.
	  **/
	private static final function create( &$venta )
	{
		$sql = "INSERT INTO venta ( `id_venta`, `es_cotizacion`, `id_caja`, `id_venta_caja`, `id_comprador_venta`, `tipo_de_venta`, `fecha`, `subtotal`, `impuesto`, `descuento`, `total`, `id_sucursal`, `id_usuario`, `saldo`, `cancelada`, `tipo_de_pago`, `retencion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$venta->getIdVenta(), 
			$venta->getEsCotizacion(), 
			$venta->getIdCaja(), 
			$venta->getIdVentaCaja(), 
			$venta->getIdCompradorVenta(), 
			$venta->getTipoDeVenta(), 
			$venta->getFecha(), 
			$venta->getSubtotal(), 
			$venta->getImpuesto(), 
			$venta->getDescuento(), 
			$venta->getTotal(), 
			$venta->getIdSucursal(), 
			$venta->getIdUsuario(), 
			$venta->getSaldo(), 
			$venta->getCancelada(), 
			$venta->getTipoDePago(), 
			$venta->getRetencion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $venta->setIdVenta( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Venta} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Venta}.
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
	  * @param Venta [$venta] El objeto de tipo Venta
	  * @param Venta [$venta] El objeto de tipo Venta
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $ventaA , $ventaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from venta WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $ventaA->getIdVenta()) ) ) & ( ! is_null ( ($b = $ventaB->getIdVenta()) ) ) ){
				$sql .= " `id_venta` >= ? AND `id_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getEsCotizacion()) ) ) & ( ! is_null ( ($b = $ventaB->getEsCotizacion()) ) ) ){
				$sql .= " `es_cotizacion` >= ? AND `es_cotizacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `es_cotizacion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getIdCaja()) ) ) & ( ! is_null ( ($b = $ventaB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getIdVentaCaja()) ) ) & ( ! is_null ( ($b = $ventaB->getIdVentaCaja()) ) ) ){
				$sql .= " `id_venta_caja` >= ? AND `id_venta_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_venta_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getIdCompradorVenta()) ) ) & ( ! is_null ( ($b = $ventaB->getIdCompradorVenta()) ) ) ){
				$sql .= " `id_comprador_venta` >= ? AND `id_comprador_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_comprador_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getTipoDeVenta()) ) ) & ( ! is_null ( ($b = $ventaB->getTipoDeVenta()) ) ) ){
				$sql .= " `tipo_de_venta` >= ? AND `tipo_de_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_de_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getFecha()) ) ) & ( ! is_null ( ($b = $ventaB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getSubtotal()) ) ) & ( ! is_null ( ($b = $ventaB->getSubtotal()) ) ) ){
				$sql .= " `subtotal` >= ? AND `subtotal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `subtotal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getImpuesto()) ) ) & ( ! is_null ( ($b = $ventaB->getImpuesto()) ) ) ){
				$sql .= " `impuesto` >= ? AND `impuesto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `impuesto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getDescuento()) ) ) & ( ! is_null ( ($b = $ventaB->getDescuento()) ) ) ){
				$sql .= " `descuento` >= ? AND `descuento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descuento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getTotal()) ) ) & ( ! is_null ( ($b = $ventaB->getTotal()) ) ) ){
				$sql .= " `total` >= ? AND `total` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `total` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $ventaB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $ventaB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getSaldo()) ) ) & ( ! is_null ( ($b = $ventaB->getSaldo()) ) ) ){
				$sql .= " `saldo` >= ? AND `saldo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getCancelada()) ) ) & ( ! is_null ( ($b = $ventaB->getCancelada()) ) ) ){
				$sql .= " `cancelada` >= ? AND `cancelada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getTipoDePago()) ) ) & ( ! is_null ( ($b = $ventaB->getTipoDePago()) ) ) ){
				$sql .= " `tipo_de_pago` >= ? AND `tipo_de_pago` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_de_pago` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $ventaA->getRetencion()) ) ) & ( ! is_null ( ($b = $ventaB->getRetencion()) ) ) ){
				$sql .= " `retencion` >= ? AND `retencion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `retencion` = ? AND"; 
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
    		array_push( $ar, new Venta($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Venta suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Venta [$venta] El objeto de tipo Venta a eliminar
	  **/
	public static final function delete( &$venta )
	{
		if( is_null( self::getByPK($venta->getIdVenta()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM venta WHERE  id_venta = ?;";
		$params = array( $venta->getIdVenta() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
