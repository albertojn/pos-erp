<?php
/** Usuario Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Usuario }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class UsuarioDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Usuario} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Usuario [$usuario] El objeto de tipo Usuario
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$usuario )
	{
		if( ! is_null ( self::getByPK(  $usuario->getIdUsuario() ) ) )
		{
			try{ return UsuarioDAOBase::update( $usuario) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return UsuarioDAOBase::create( $usuario) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Usuario} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Usuario} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Usuario Un objeto del tipo {@link Usuario}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_usuario )
	{
		$sql = "SELECT * FROM usuario WHERE (id_usuario = ? ) LIMIT 1;";
		$params = array(  $id_usuario );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Usuario( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Usuario}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Usuario}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from usuario";
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
			$bar = new Usuario($foo);
    		array_push( $allData, $bar);
			//id_usuario
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Usuario} de la base de datos. 
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
	  * @param Usuario [$usuario] El objeto de tipo Usuario
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $usuario , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from usuario WHERE ("; 
		$val = array();
		if( ! is_null( $usuario->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $usuario->getIdUsuario() );
		}

		if( ! is_null( $usuario->getIdDireccion() ) ){
			$sql .= " `id_direccion` = ? AND";
			array_push( $val, $usuario->getIdDireccion() );
		}

		if( ! is_null( $usuario->getIdDireccionAlterna() ) ){
			$sql .= " `id_direccion_alterna` = ? AND";
			array_push( $val, $usuario->getIdDireccionAlterna() );
		}

		if( ! is_null( $usuario->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $usuario->getIdSucursal() );
		}

		if( ! is_null( $usuario->getIdRol() ) ){
			$sql .= " `id_rol` = ? AND";
			array_push( $val, $usuario->getIdRol() );
		}

		if( ! is_null( $usuario->getIdCategoriaContacto() ) ){
			$sql .= " `id_categoria_contacto` = ? AND";
			array_push( $val, $usuario->getIdCategoriaContacto() );
		}

		if( ! is_null( $usuario->getIdClasificacionProveedor() ) ){
			$sql .= " `id_clasificacion_proveedor` = ? AND";
			array_push( $val, $usuario->getIdClasificacionProveedor() );
		}

		if( ! is_null( $usuario->getIdClasificacionCliente() ) ){
			$sql .= " `id_clasificacion_cliente` = ? AND";
			array_push( $val, $usuario->getIdClasificacionCliente() );
		}

		if( ! is_null( $usuario->getIdMoneda() ) ){
			$sql .= " `id_moneda` = ? AND";
			array_push( $val, $usuario->getIdMoneda() );
		}

		if( ! is_null( $usuario->getFechaAsignacionRol() ) ){
			$sql .= " `fecha_asignacion_rol` = ? AND";
			array_push( $val, $usuario->getFechaAsignacionRol() );
		}

		if( ! is_null( $usuario->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $usuario->getNombre() );
		}

		if( ! is_null( $usuario->getRfc() ) ){
			$sql .= " `rfc` = ? AND";
			array_push( $val, $usuario->getRfc() );
		}

		if( ! is_null( $usuario->getCurp() ) ){
			$sql .= " `curp` = ? AND";
			array_push( $val, $usuario->getCurp() );
		}

		if( ! is_null( $usuario->getComisionVentas() ) ){
			$sql .= " `comision_ventas` = ? AND";
			array_push( $val, $usuario->getComisionVentas() );
		}

		if( ! is_null( $usuario->getTelefonoPersonal1() ) ){
			$sql .= " `telefono_personal1` = ? AND";
			array_push( $val, $usuario->getTelefonoPersonal1() );
		}

		if( ! is_null( $usuario->getTelefonoPersonal2() ) ){
			$sql .= " `telefono_personal2` = ? AND";
			array_push( $val, $usuario->getTelefonoPersonal2() );
		}

		if( ! is_null( $usuario->getFechaAlta() ) ){
			$sql .= " `fecha_alta` = ? AND";
			array_push( $val, $usuario->getFechaAlta() );
		}

		if( ! is_null( $usuario->getFechaBaja() ) ){
			$sql .= " `fecha_baja` = ? AND";
			array_push( $val, $usuario->getFechaBaja() );
		}

		if( ! is_null( $usuario->getActivo() ) ){
			$sql .= " `activo` = ? AND";
			array_push( $val, $usuario->getActivo() );
		}

		if( ! is_null( $usuario->getLimiteCredito() ) ){
			$sql .= " `limite_credito` = ? AND";
			array_push( $val, $usuario->getLimiteCredito() );
		}

		if( ! is_null( $usuario->getDescuento() ) ){
			$sql .= " `descuento` = ? AND";
			array_push( $val, $usuario->getDescuento() );
		}

		if( ! is_null( $usuario->getPassword() ) ){
			$sql .= " `password` = ? AND";
			array_push( $val, $usuario->getPassword() );
		}

		if( ! is_null( $usuario->getLastLogin() ) ){
			$sql .= " `last_login` = ? AND";
			array_push( $val, $usuario->getLastLogin() );
		}

		if( ! is_null( $usuario->getConsignatario() ) ){
			$sql .= " `consignatario` = ? AND";
			array_push( $val, $usuario->getConsignatario() );
		}

		if( ! is_null( $usuario->getSalario() ) ){
			$sql .= " `salario` = ? AND";
			array_push( $val, $usuario->getSalario() );
		}

		if( ! is_null( $usuario->getCorreoElectronico() ) ){
			$sql .= " `correo_electronico` = ? AND";
			array_push( $val, $usuario->getCorreoElectronico() );
		}

		if( ! is_null( $usuario->getPaginaWeb() ) ){
			$sql .= " `pagina_web` = ? AND";
			array_push( $val, $usuario->getPaginaWeb() );
		}

		if( ! is_null( $usuario->getSaldoDelEjercicio() ) ){
			$sql .= " `saldo_del_ejercicio` = ? AND";
			array_push( $val, $usuario->getSaldoDelEjercicio() );
		}

		if( ! is_null( $usuario->getVentasACredito() ) ){
			$sql .= " `ventas_a_credito` = ? AND";
			array_push( $val, $usuario->getVentasACredito() );
		}

		if( ! is_null( $usuario->getRepresentanteLegal() ) ){
			$sql .= " `representante_legal` = ? AND";
			array_push( $val, $usuario->getRepresentanteLegal() );
		}

		if( ! is_null( $usuario->getFacturarATerceros() ) ){
			$sql .= " `facturar_a_terceros` = ? AND";
			array_push( $val, $usuario->getFacturarATerceros() );
		}

		if( ! is_null( $usuario->getDiaDePago() ) ){
			$sql .= " `dia_de_pago` = ? AND";
			array_push( $val, $usuario->getDiaDePago() );
		}

		if( ! is_null( $usuario->getMensajeria() ) ){
			$sql .= " `mensajeria` = ? AND";
			array_push( $val, $usuario->getMensajeria() );
		}

		if( ! is_null( $usuario->getInteresesMoratorios() ) ){
			$sql .= " `intereses_moratorios` = ? AND";
			array_push( $val, $usuario->getInteresesMoratorios() );
		}

		if( ! is_null( $usuario->getDenominacionComercial() ) ){
			$sql .= " `denominacion_comercial` = ? AND";
			array_push( $val, $usuario->getDenominacionComercial() );
		}

		if( ! is_null( $usuario->getDiasDeCredito() ) ){
			$sql .= " `dias_de_credito` = ? AND";
			array_push( $val, $usuario->getDiasDeCredito() );
		}

		if( ! is_null( $usuario->getCuentaDeMensajeria() ) ){
			$sql .= " `cuenta_de_mensajeria` = ? AND";
			array_push( $val, $usuario->getCuentaDeMensajeria() );
		}

		if( ! is_null( $usuario->getDiaDeRevision() ) ){
			$sql .= " `dia_de_revision` = ? AND";
			array_push( $val, $usuario->getDiaDeRevision() );
		}

		if( ! is_null( $usuario->getCodigoUsuario() ) ){
			$sql .= " `codigo_usuario` = ? AND";
			array_push( $val, $usuario->getCodigoUsuario() );
		}

		if( ! is_null( $usuario->getDiasDeEmbarque() ) ){
			$sql .= " `dias_de_embarque` = ? AND";
			array_push( $val, $usuario->getDiasDeEmbarque() );
		}

		if( ! is_null( $usuario->getTiempoEntrega() ) ){
			$sql .= " `tiempo_entrega` = ? AND";
			array_push( $val, $usuario->getTiempoEntrega() );
		}

		if( ! is_null( $usuario->getCuentaBancaria() ) ){
			$sql .= " `cuenta_bancaria` = ? AND";
			array_push( $val, $usuario->getCuentaBancaria() );
		}

		if( ! is_null( $usuario->getIdTarifaCompra() ) ){
			$sql .= " `id_tarifa_compra` = ? AND";
			array_push( $val, $usuario->getIdTarifaCompra() );
		}

		if( ! is_null( $usuario->getTarifaCompraObtenida() ) ){
			$sql .= " `tarifa_compra_obtenida` = ? AND";
			array_push( $val, $usuario->getTarifaCompraObtenida() );
		}

		if( ! is_null( $usuario->getIdTarifaVenta() ) ){
			$sql .= " `id_tarifa_venta` = ? AND";
			array_push( $val, $usuario->getIdTarifaVenta() );
		}

		if( ! is_null( $usuario->getTarifaVentaObtenida() ) ){
			$sql .= " `tarifa_venta_obtenida` = ? AND";
			array_push( $val, $usuario->getTarifaVentaObtenida() );
		}

		if( ! is_null( $usuario->getTokenRecuperacionPass() ) ){
			$sql .= " `token_recuperacion_pass` = ? AND";
			array_push( $val, $usuario->getTokenRecuperacionPass() );
		}

		if( ! is_null( $usuario->getIdPerfil() ) ){
			$sql .= " `id_perfil` = ? AND";
			array_push( $val, $usuario->getIdPerfil() );
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
			$bar =  new Usuario($foo);
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
	  * @param Usuario [$usuario] El objeto de tipo Usuario a actualizar.
	  **/
	private static final function update( $usuario )
	{
		$sql = "UPDATE usuario SET  `id_direccion` = ?, `id_direccion_alterna` = ?, `id_sucursal` = ?, `id_rol` = ?, `id_categoria_contacto` = ?, `id_clasificacion_proveedor` = ?, `id_clasificacion_cliente` = ?, `id_moneda` = ?, `fecha_asignacion_rol` = ?, `nombre` = ?, `rfc` = ?, `curp` = ?, `comision_ventas` = ?, `telefono_personal1` = ?, `telefono_personal2` = ?, `fecha_alta` = ?, `fecha_baja` = ?, `activo` = ?, `limite_credito` = ?, `descuento` = ?, `password` = ?, `last_login` = ?, `consignatario` = ?, `salario` = ?, `correo_electronico` = ?, `pagina_web` = ?, `saldo_del_ejercicio` = ?, `ventas_a_credito` = ?, `representante_legal` = ?, `facturar_a_terceros` = ?, `dia_de_pago` = ?, `mensajeria` = ?, `intereses_moratorios` = ?, `denominacion_comercial` = ?, `dias_de_credito` = ?, `cuenta_de_mensajeria` = ?, `dia_de_revision` = ?, `codigo_usuario` = ?, `dias_de_embarque` = ?, `tiempo_entrega` = ?, `cuenta_bancaria` = ?, `id_tarifa_compra` = ?, `tarifa_compra_obtenida` = ?, `id_tarifa_venta` = ?, `tarifa_venta_obtenida` = ?, `token_recuperacion_pass` = ?, `id_perfil` = ? WHERE  `id_usuario` = ?;";
		$params = array( 
			$usuario->getIdDireccion(), 
			$usuario->getIdDireccionAlterna(), 
			$usuario->getIdSucursal(), 
			$usuario->getIdRol(), 
			$usuario->getIdCategoriaContacto(), 
			$usuario->getIdClasificacionProveedor(), 
			$usuario->getIdClasificacionCliente(), 
			$usuario->getIdMoneda(), 
			$usuario->getFechaAsignacionRol(), 
			$usuario->getNombre(), 
			$usuario->getRfc(), 
			$usuario->getCurp(), 
			$usuario->getComisionVentas(), 
			$usuario->getTelefonoPersonal1(), 
			$usuario->getTelefonoPersonal2(), 
			$usuario->getFechaAlta(), 
			$usuario->getFechaBaja(), 
			$usuario->getActivo(), 
			$usuario->getLimiteCredito(), 
			$usuario->getDescuento(), 
			$usuario->getPassword(), 
			$usuario->getLastLogin(), 
			$usuario->getConsignatario(), 
			$usuario->getSalario(), 
			$usuario->getCorreoElectronico(), 
			$usuario->getPaginaWeb(), 
			$usuario->getSaldoDelEjercicio(), 
			$usuario->getVentasACredito(), 
			$usuario->getRepresentanteLegal(), 
			$usuario->getFacturarATerceros(), 
			$usuario->getDiaDePago(), 
			$usuario->getMensajeria(), 
			$usuario->getInteresesMoratorios(), 
			$usuario->getDenominacionComercial(), 
			$usuario->getDiasDeCredito(), 
			$usuario->getCuentaDeMensajeria(), 
			$usuario->getDiaDeRevision(), 
			$usuario->getCodigoUsuario(), 
			$usuario->getDiasDeEmbarque(), 
			$usuario->getTiempoEntrega(), 
			$usuario->getCuentaBancaria(), 
			$usuario->getIdTarifaCompra(), 
			$usuario->getTarifaCompraObtenida(), 
			$usuario->getIdTarifaVenta(), 
			$usuario->getTarifaVentaObtenida(), 
			$usuario->getTokenRecuperacionPass(), 
			$usuario->getIdPerfil(), 
			$usuario->getIdUsuario(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Usuario suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Usuario dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Usuario [$usuario] El objeto de tipo Usuario a crear.
	  **/
	private static final function create( &$usuario )
	{
		$sql = "INSERT INTO usuario ( `id_usuario`, `id_direccion`, `id_direccion_alterna`, `id_sucursal`, `id_rol`, `id_categoria_contacto`, `id_clasificacion_proveedor`, `id_clasificacion_cliente`, `id_moneda`, `fecha_asignacion_rol`, `nombre`, `rfc`, `curp`, `comision_ventas`, `telefono_personal1`, `telefono_personal2`, `fecha_alta`, `fecha_baja`, `activo`, `limite_credito`, `descuento`, `password`, `last_login`, `consignatario`, `salario`, `correo_electronico`, `pagina_web`, `saldo_del_ejercicio`, `ventas_a_credito`, `representante_legal`, `facturar_a_terceros`, `dia_de_pago`, `mensajeria`, `intereses_moratorios`, `denominacion_comercial`, `dias_de_credito`, `cuenta_de_mensajeria`, `dia_de_revision`, `codigo_usuario`, `dias_de_embarque`, `tiempo_entrega`, `cuenta_bancaria`, `id_tarifa_compra`, `tarifa_compra_obtenida`, `id_tarifa_venta`, `tarifa_venta_obtenida`, `token_recuperacion_pass`, `id_perfil` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$usuario->getIdUsuario(), 
			$usuario->getIdDireccion(), 
			$usuario->getIdDireccionAlterna(), 
			$usuario->getIdSucursal(), 
			$usuario->getIdRol(), 
			$usuario->getIdCategoriaContacto(), 
			$usuario->getIdClasificacionProveedor(), 
			$usuario->getIdClasificacionCliente(), 
			$usuario->getIdMoneda(), 
			$usuario->getFechaAsignacionRol(), 
			$usuario->getNombre(), 
			$usuario->getRfc(), 
			$usuario->getCurp(), 
			$usuario->getComisionVentas(), 
			$usuario->getTelefonoPersonal1(), 
			$usuario->getTelefonoPersonal2(), 
			$usuario->getFechaAlta(), 
			$usuario->getFechaBaja(), 
			$usuario->getActivo(), 
			$usuario->getLimiteCredito(), 
			$usuario->getDescuento(), 
			$usuario->getPassword(), 
			$usuario->getLastLogin(), 
			$usuario->getConsignatario(), 
			$usuario->getSalario(), 
			$usuario->getCorreoElectronico(), 
			$usuario->getPaginaWeb(), 
			$usuario->getSaldoDelEjercicio(), 
			$usuario->getVentasACredito(), 
			$usuario->getRepresentanteLegal(), 
			$usuario->getFacturarATerceros(), 
			$usuario->getDiaDePago(), 
			$usuario->getMensajeria(), 
			$usuario->getInteresesMoratorios(), 
			$usuario->getDenominacionComercial(), 
			$usuario->getDiasDeCredito(), 
			$usuario->getCuentaDeMensajeria(), 
			$usuario->getDiaDeRevision(), 
			$usuario->getCodigoUsuario(), 
			$usuario->getDiasDeEmbarque(), 
			$usuario->getTiempoEntrega(), 
			$usuario->getCuentaBancaria(), 
			$usuario->getIdTarifaCompra(), 
			$usuario->getTarifaCompraObtenida(), 
			$usuario->getIdTarifaVenta(), 
			$usuario->getTarifaVentaObtenida(), 
			$usuario->getTokenRecuperacionPass(), 
			$usuario->getIdPerfil(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $usuario->setIdUsuario( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Usuario} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Usuario}.
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
	  * @param Usuario [$usuario] El objeto de tipo Usuario
	  * @param Usuario [$usuario] El objeto de tipo Usuario
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $usuarioA , $usuarioB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from usuario WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $usuarioA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdDireccion()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdDireccion()) ) ) ){
				$sql .= " `id_direccion` >= ? AND `id_direccion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_direccion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdDireccionAlterna()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdDireccionAlterna()) ) ) ){
				$sql .= " `id_direccion_alterna` >= ? AND `id_direccion_alterna` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_direccion_alterna` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdRol()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdRol()) ) ) ){
				$sql .= " `id_rol` >= ? AND `id_rol` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_rol` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdCategoriaContacto()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdCategoriaContacto()) ) ) ){
				$sql .= " `id_categoria_contacto` >= ? AND `id_categoria_contacto` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_categoria_contacto` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdClasificacionProveedor()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdClasificacionProveedor()) ) ) ){
				$sql .= " `id_clasificacion_proveedor` >= ? AND `id_clasificacion_proveedor` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_proveedor` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdClasificacionCliente()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdClasificacionCliente()) ) ) ){
				$sql .= " `id_clasificacion_cliente` >= ? AND `id_clasificacion_cliente` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_clasificacion_cliente` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdMoneda()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdMoneda()) ) ) ){
				$sql .= " `id_moneda` >= ? AND `id_moneda` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_moneda` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getFechaAsignacionRol()) ) ) & ( ! is_null ( ($b = $usuarioB->getFechaAsignacionRol()) ) ) ){
				$sql .= " `fecha_asignacion_rol` >= ? AND `fecha_asignacion_rol` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_asignacion_rol` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getNombre()) ) ) & ( ! is_null ( ($b = $usuarioB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getRfc()) ) ) & ( ! is_null ( ($b = $usuarioB->getRfc()) ) ) ){
				$sql .= " `rfc` >= ? AND `rfc` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `rfc` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getCurp()) ) ) & ( ! is_null ( ($b = $usuarioB->getCurp()) ) ) ){
				$sql .= " `curp` >= ? AND `curp` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `curp` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getComisionVentas()) ) ) & ( ! is_null ( ($b = $usuarioB->getComisionVentas()) ) ) ){
				$sql .= " `comision_ventas` >= ? AND `comision_ventas` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `comision_ventas` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getTelefonoPersonal1()) ) ) & ( ! is_null ( ($b = $usuarioB->getTelefonoPersonal1()) ) ) ){
				$sql .= " `telefono_personal1` >= ? AND `telefono_personal1` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `telefono_personal1` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getTelefonoPersonal2()) ) ) & ( ! is_null ( ($b = $usuarioB->getTelefonoPersonal2()) ) ) ){
				$sql .= " `telefono_personal2` >= ? AND `telefono_personal2` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `telefono_personal2` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getFechaAlta()) ) ) & ( ! is_null ( ($b = $usuarioB->getFechaAlta()) ) ) ){
				$sql .= " `fecha_alta` >= ? AND `fecha_alta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_alta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getFechaBaja()) ) ) & ( ! is_null ( ($b = $usuarioB->getFechaBaja()) ) ) ){
				$sql .= " `fecha_baja` >= ? AND `fecha_baja` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_baja` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getActivo()) ) ) & ( ! is_null ( ($b = $usuarioB->getActivo()) ) ) ){
				$sql .= " `activo` >= ? AND `activo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `activo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getLimiteCredito()) ) ) & ( ! is_null ( ($b = $usuarioB->getLimiteCredito()) ) ) ){
				$sql .= " `limite_credito` >= ? AND `limite_credito` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `limite_credito` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getDescuento()) ) ) & ( ! is_null ( ($b = $usuarioB->getDescuento()) ) ) ){
				$sql .= " `descuento` >= ? AND `descuento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `descuento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getPassword()) ) ) & ( ! is_null ( ($b = $usuarioB->getPassword()) ) ) ){
				$sql .= " `password` >= ? AND `password` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `password` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getLastLogin()) ) ) & ( ! is_null ( ($b = $usuarioB->getLastLogin()) ) ) ){
				$sql .= " `last_login` >= ? AND `last_login` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `last_login` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getConsignatario()) ) ) & ( ! is_null ( ($b = $usuarioB->getConsignatario()) ) ) ){
				$sql .= " `consignatario` >= ? AND `consignatario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `consignatario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getSalario()) ) ) & ( ! is_null ( ($b = $usuarioB->getSalario()) ) ) ){
				$sql .= " `salario` >= ? AND `salario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `salario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getCorreoElectronico()) ) ) & ( ! is_null ( ($b = $usuarioB->getCorreoElectronico()) ) ) ){
				$sql .= " `correo_electronico` >= ? AND `correo_electronico` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `correo_electronico` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getPaginaWeb()) ) ) & ( ! is_null ( ($b = $usuarioB->getPaginaWeb()) ) ) ){
				$sql .= " `pagina_web` >= ? AND `pagina_web` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `pagina_web` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getSaldoDelEjercicio()) ) ) & ( ! is_null ( ($b = $usuarioB->getSaldoDelEjercicio()) ) ) ){
				$sql .= " `saldo_del_ejercicio` >= ? AND `saldo_del_ejercicio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `saldo_del_ejercicio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getVentasACredito()) ) ) & ( ! is_null ( ($b = $usuarioB->getVentasACredito()) ) ) ){
				$sql .= " `ventas_a_credito` >= ? AND `ventas_a_credito` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `ventas_a_credito` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getRepresentanteLegal()) ) ) & ( ! is_null ( ($b = $usuarioB->getRepresentanteLegal()) ) ) ){
				$sql .= " `representante_legal` >= ? AND `representante_legal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `representante_legal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getFacturarATerceros()) ) ) & ( ! is_null ( ($b = $usuarioB->getFacturarATerceros()) ) ) ){
				$sql .= " `facturar_a_terceros` >= ? AND `facturar_a_terceros` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `facturar_a_terceros` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getDiaDePago()) ) ) & ( ! is_null ( ($b = $usuarioB->getDiaDePago()) ) ) ){
				$sql .= " `dia_de_pago` >= ? AND `dia_de_pago` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `dia_de_pago` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getMensajeria()) ) ) & ( ! is_null ( ($b = $usuarioB->getMensajeria()) ) ) ){
				$sql .= " `mensajeria` >= ? AND `mensajeria` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `mensajeria` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getInteresesMoratorios()) ) ) & ( ! is_null ( ($b = $usuarioB->getInteresesMoratorios()) ) ) ){
				$sql .= " `intereses_moratorios` >= ? AND `intereses_moratorios` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `intereses_moratorios` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getDenominacionComercial()) ) ) & ( ! is_null ( ($b = $usuarioB->getDenominacionComercial()) ) ) ){
				$sql .= " `denominacion_comercial` >= ? AND `denominacion_comercial` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `denominacion_comercial` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getDiasDeCredito()) ) ) & ( ! is_null ( ($b = $usuarioB->getDiasDeCredito()) ) ) ){
				$sql .= " `dias_de_credito` >= ? AND `dias_de_credito` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `dias_de_credito` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getCuentaDeMensajeria()) ) ) & ( ! is_null ( ($b = $usuarioB->getCuentaDeMensajeria()) ) ) ){
				$sql .= " `cuenta_de_mensajeria` >= ? AND `cuenta_de_mensajeria` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cuenta_de_mensajeria` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getDiaDeRevision()) ) ) & ( ! is_null ( ($b = $usuarioB->getDiaDeRevision()) ) ) ){
				$sql .= " `dia_de_revision` >= ? AND `dia_de_revision` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `dia_de_revision` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getCodigoUsuario()) ) ) & ( ! is_null ( ($b = $usuarioB->getCodigoUsuario()) ) ) ){
				$sql .= " `codigo_usuario` >= ? AND `codigo_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `codigo_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getDiasDeEmbarque()) ) ) & ( ! is_null ( ($b = $usuarioB->getDiasDeEmbarque()) ) ) ){
				$sql .= " `dias_de_embarque` >= ? AND `dias_de_embarque` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `dias_de_embarque` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getTiempoEntrega()) ) ) & ( ! is_null ( ($b = $usuarioB->getTiempoEntrega()) ) ) ){
				$sql .= " `tiempo_entrega` >= ? AND `tiempo_entrega` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tiempo_entrega` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getCuentaBancaria()) ) ) & ( ! is_null ( ($b = $usuarioB->getCuentaBancaria()) ) ) ){
				$sql .= " `cuenta_bancaria` >= ? AND `cuenta_bancaria` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cuenta_bancaria` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdTarifaCompra()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdTarifaCompra()) ) ) ){
				$sql .= " `id_tarifa_compra` >= ? AND `id_tarifa_compra` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa_compra` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getTarifaCompraObtenida()) ) ) & ( ! is_null ( ($b = $usuarioB->getTarifaCompraObtenida()) ) ) ){
				$sql .= " `tarifa_compra_obtenida` >= ? AND `tarifa_compra_obtenida` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tarifa_compra_obtenida` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdTarifaVenta()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdTarifaVenta()) ) ) ){
				$sql .= " `id_tarifa_venta` >= ? AND `id_tarifa_venta` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_tarifa_venta` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getTarifaVentaObtenida()) ) ) & ( ! is_null ( ($b = $usuarioB->getTarifaVentaObtenida()) ) ) ){
				$sql .= " `tarifa_venta_obtenida` >= ? AND `tarifa_venta_obtenida` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `tarifa_venta_obtenida` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getTokenRecuperacionPass()) ) ) & ( ! is_null ( ($b = $usuarioB->getTokenRecuperacionPass()) ) ) ){
				$sql .= " `token_recuperacion_pass` >= ? AND `token_recuperacion_pass` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `token_recuperacion_pass` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $usuarioA->getIdPerfil()) ) ) & ( ! is_null ( ($b = $usuarioB->getIdPerfil()) ) ) ){
				$sql .= " `id_perfil` >= ? AND `id_perfil` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_perfil` = ? AND"; 
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
    		array_push( $ar, new Usuario($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Usuario suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Usuario [$usuario] El objeto de tipo Usuario a eliminar
	  **/
	public static final function delete( &$usuario )
	{
		if( is_null( self::getByPK($usuario->getIdUsuario()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM usuario WHERE  id_usuario = ?;";
		$params = array( $usuario->getIdUsuario() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
