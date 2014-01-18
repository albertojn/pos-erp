<?php
/** Compra Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Compra }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class CompraDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Compra} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Compra [$compra] El objeto de tipo Compra
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$compra )
	{
		if( ! is_null ( self::getByPK(  $compra->getIdCompra() ) ) )
		{
			try{ return CompraDAOBase::update( $compra) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return CompraDAOBase::create( $compra) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Compra} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Compra} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Compra Un objeto del tipo {@link Compra}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_compra )
	{
		$sql = "SELECT * FROM compra WHERE (id_compra = ? ) LIMIT 1;";
		$params = array(  $id_compra );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Compra( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Compra}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Compra}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from compra";
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
			$bar = new Compra($foo);
    		array_push( $allData, $bar);
			//id_compra
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Compra} de la base de datos. 
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
	  * @param Compra [$compra] El objeto de tipo Compra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $compra , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from compra WHERE ("; 
		$val = array();
		if( ! is_null( $compra->getIdCompra() ) ){
			$sql .= " `id_compra` = ? AND";
			array_push( $val, $compra->getIdCompra() );
		}

		if( ! is_null( $compra->getIdCaja() ) ){
			$sql .= " `id_caja` = ? AND";
			array_push( $val, $compra->getIdCaja() );
		}

		if( ! is_null( $compra->getIdCompraCaja() ) ){
			$sql .= " `id_compra_caja` = ? AND";
			array_push( $val, $compra->getIdCompraCaja() );
		}

		if( ! is_null( $compra->getIdVendedorCompra() ) ){
			$sql .= " `id_vendedor_compra` = ? AND";
			array_push( $val, $compra->getIdVendedorCompra() );
		}

		if( ! is_null( $compra->getTipoDeCompra() ) ){
			$sql .= " `tipo_de_compra` = ? AND";
			array_push( $val, $compra->getTipoDeCompra() );
		}

		if( ! is_null( $compra->getFecha() ) ){
			$sql .= " `fecha` = ? AND";
			array_push( $val, $compra->getFecha() );
		}

		if( ! is_null( $compra->getSubtotal() ) ){
			$sql .= " `subtotal` = ? AND";
			array_push( $val, $compra->getSubtotal() );
		}

		if( ! is_null( $compra->getImpuesto() ) ){
			$sql .= " `impuesto` = ? AND";
			array_push( $val, $compra->getImpuesto() );
		}

		if( ! is_null( $compra->getDescuento() ) ){
			$sql .= " `descuento` = ? AND";
			array_push( $val, $compra->getDescuento() );
		}

		if( ! is_null( $compra->getTotal() ) ){
			$sql .= " `total` = ? AND";
			array_push( $val, $compra->getTotal() );
		}

		if( ! is_null( $compra->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $compra->getIdSucursal() );
		}

		if( ! is_null( $compra->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $compra->getIdUsuario() );
		}

		if( ! is_null( $compra->getIdEmpresa() ) ){
			$sql .= " `id_empresa` = ? AND";
			array_push( $val, $compra->getIdEmpresa() );
		}

		if( ! is_null( $compra->getSaldo() ) ){
			$sql .= " `saldo` = ? AND";
			array_push( $val, $compra->getSaldo() );
		}

		if( ! is_null( $compra->getCancelada() ) ){
			$sql .= " `cancelada` = ? AND";
			array_push( $val, $compra->getCancelada() );
		}

		if( ! is_null( $compra->getTipoDePago() ) ){
			$sql .= " `tipo_de_pago` = ? AND";
			array_push( $val, $compra->getTipoDePago() );
		}

		if( ! is_null( $compra->getRetencion() ) ){
			$sql .= " `retencion` = ? AND";
			array_push( $val, $compra->getRetencion() );
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
			$bar =  new Compra($foo);
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
	  * @param Compra [$compra] El objeto de tipo Compra a actualizar.
	  **/
	private static final function update( $compra )
	{
		$sql = "UPDATE compra SET  `id_caja` = ?, `id_compra_caja` = ?, `id_vendedor_compra` = ?, `tipo_de_compra` = ?, `fecha` = ?, `subtotal` = ?, `impuesto` = ?, `descuento` = ?, `total` = ?, `id_sucursal` = ?, `id_usuario` = ?, `id_empresa` = ?, `saldo` = ?, `cancelada` = ?, `tipo_de_pago` = ?, `retencion` = ? WHERE  `id_compra` = ?;";
		$params = array( 
			$compra->getIdCaja(), 
			$compra->getIdCompraCaja(), 
			$compra->getIdVendedorCompra(), 
			$compra->getTipoDeCompra(), 
			$compra->getFecha(), 
			$compra->getSubtotal(), 
			$compra->getImpuesto(), 
			$compra->getDescuento(), 
			$compra->getTotal(), 
			$compra->getIdSucursal(), 
			$compra->getIdUsuario(), 
			$compra->getIdEmpresa(), 
			$compra->getSaldo(), 
			$compra->getCancelada(), 
			$compra->getTipoDePago(), 
			$compra->getRetencion(), 
			$compra->getIdCompra(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Compra suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Compra dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Compra [$compra] El objeto de tipo Compra a crear.
	  **/
	private static final function create( &$compra )
	{
		$sql = "INSERT INTO compra ( `id_compra`, `id_caja`, `id_compra_caja`, `id_vendedor_compra`, `tipo_de_compra`, `fecha`, `subtotal`, `impuesto`, `descuento`, `total`, `id_sucursal`, `id_usuario`, `id_empresa`, `saldo`, `cancelada`, `tipo_de_pago`, `retencion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$compra->getIdCompra(), 
			$compra->getIdCaja(), 
			$compra->getIdCompraCaja(), 
			$compra->getIdVendedorCompra(), 
			$compra->getTipoDeCompra(), 
			$compra->getFecha(), 
			$compra->getSubtotal(), 
			$compra->getImpuesto(), 
			$compra->getDescuento(), 
			$compra->getTotal(), 
			$compra->getIdSucursal(), 
			$compra->getIdUsuario(), 
			$compra->getIdEmpresa(), 
			$compra->getSaldo(), 
			$compra->getCancelada(), 
			$compra->getTipoDePago(), 
			$compra->getRetencion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $compra->setIdCompra( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Compra} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Compra}.
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
	  * @param Compra [$compra] El objeto de tipo Compra
	  * @param Compra [$compra] El objeto de tipo Compra
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $compraA , $compraB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from compra WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $compraA->getIdCompra()) ) ) & ( ! is_null ( ($b = $compraB->getIdCompra()) ) ) ){
				$sql .= " `id_compra` >= ? AND `id_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getIdCaja()) ) ) & ( ! is_null ( ($b = $compraB->getIdCaja()) ) ) ){
				$sql .= " `id_caja` >= ? AND `id_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getIdCompraCaja()) ) ) & ( ! is_null ( ($b = $compraB->getIdCompraCaja()) ) ) ){
				$sql .= " `id_compra_caja` >= ? AND `id_compra_caja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_compra_caja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getIdVendedorCompra()) ) ) & ( ! is_null ( ($b = $compraB->getIdVendedorCompra()) ) ) ){
				$sql .= " `id_vendedor_compra` >= ? AND `id_vendedor_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_vendedor_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getTipoDeCompra()) ) ) & ( ! is_null ( ($b = $compraB->getTipoDeCompra()) ) ) ){
				$sql .= " `tipo_de_compra` >= ? AND `tipo_de_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_de_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getFecha()) ) ) & ( ! is_null ( ($b = $compraB->getFecha()) ) ) ){
				$sql .= " `fecha` >= ? AND `fecha` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getSubtotal()) ) ) & ( ! is_null ( ($b = $compraB->getSubtotal()) ) ) ){
				$sql .= " `subtotal` >= ? AND `subtotal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `subtotal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getImpuesto()) ) ) & ( ! is_null ( ($b = $compraB->getImpuesto()) ) ) ){
				$sql .= " `impuesto` >= ? AND `impuesto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `impuesto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getDescuento()) ) ) & ( ! is_null ( ($b = $compraB->getDescuento()) ) ) ){
				$sql .= " `descuento` >= ? AND `descuento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descuento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getTotal()) ) ) & ( ! is_null ( ($b = $compraB->getTotal()) ) ) ){
				$sql .= " `total` >= ? AND `total` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `total` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $compraB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $compraB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getIdEmpresa()) ) ) & ( ! is_null ( ($b = $compraB->getIdEmpresa()) ) ) ){
				$sql .= " `id_empresa` >= ? AND `id_empresa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_empresa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getSaldo()) ) ) & ( ! is_null ( ($b = $compraB->getSaldo()) ) ) ){
				$sql .= " `saldo` >= ? AND `saldo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getCancelada()) ) ) & ( ! is_null ( ($b = $compraB->getCancelada()) ) ) ){
				$sql .= " `cancelada` >= ? AND `cancelada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getTipoDePago()) ) ) & ( ! is_null ( ($b = $compraB->getTipoDePago()) ) ) ){
				$sql .= " `tipo_de_pago` >= ? AND `tipo_de_pago` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tipo_de_pago` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $compraA->getRetencion()) ) ) & ( ! is_null ( ($b = $compraB->getRetencion()) ) ) ){
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
    		array_push( $ar, new Compra($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Compra suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Compra [$compra] El objeto de tipo Compra a eliminar
	  **/
	public static final function delete( &$compra )
	{
		if( is_null( self::getByPK($compra->getIdCompra()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM compra WHERE  id_compra = ?;";
		$params = array( $compra->getIdCompra() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
