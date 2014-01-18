<?php
/** Traspaso Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Traspaso }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class TraspasoDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Traspaso} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$traspaso )
	{
		if( ! is_null ( self::getByPK(  $traspaso->getIdTraspaso() ) ) )
		{
			try{ return TraspasoDAOBase::update( $traspaso) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return TraspasoDAOBase::create( $traspaso) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Traspaso} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Traspaso} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link Traspaso Un objeto del tipo {@link Traspaso}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_traspaso )
	{
		$sql = "SELECT * FROM traspaso WHERE (id_traspaso = ? ) LIMIT 1;";
		$params = array(  $id_traspaso );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new Traspaso( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Traspaso}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Traspaso}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from traspaso";
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
			$bar = new Traspaso($foo);
    		array_push( $allData, $bar);
			//id_traspaso
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Traspaso} de la base de datos. 
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
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $traspaso , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from traspaso WHERE ("; 
		$val = array();
		if( ! is_null( $traspaso->getIdTraspaso() ) ){
			$sql .= " `id_traspaso` = ? AND";
			array_push( $val, $traspaso->getIdTraspaso() );
		}

		if( ! is_null( $traspaso->getIdUsuarioPrograma() ) ){
			$sql .= " `id_usuario_programa` = ? AND";
			array_push( $val, $traspaso->getIdUsuarioPrograma() );
		}

		if( ! is_null( $traspaso->getIdUsuarioEnvia() ) ){
			$sql .= " `id_usuario_envia` = ? AND";
			array_push( $val, $traspaso->getIdUsuarioEnvia() );
		}

		if( ! is_null( $traspaso->getIdAlmacenEnvia() ) ){
			$sql .= " `id_almacen_envia` = ? AND";
			array_push( $val, $traspaso->getIdAlmacenEnvia() );
		}

		if( ! is_null( $traspaso->getFechaEnvioProgramada() ) ){
			$sql .= " `fecha_envio_programada` = ? AND";
			array_push( $val, $traspaso->getFechaEnvioProgramada() );
		}

		if( ! is_null( $traspaso->getFechaEnvio() ) ){
			$sql .= " `fecha_envio` = ? AND";
			array_push( $val, $traspaso->getFechaEnvio() );
		}

		if( ! is_null( $traspaso->getIdUsuarioRecibe() ) ){
			$sql .= " `id_usuario_recibe` = ? AND";
			array_push( $val, $traspaso->getIdUsuarioRecibe() );
		}

		if( ! is_null( $traspaso->getIdAlmacenRecibe() ) ){
			$sql .= " `id_almacen_recibe` = ? AND";
			array_push( $val, $traspaso->getIdAlmacenRecibe() );
		}

		if( ! is_null( $traspaso->getFechaRecibo() ) ){
			$sql .= " `fecha_recibo` = ? AND";
			array_push( $val, $traspaso->getFechaRecibo() );
		}

		if( ! is_null( $traspaso->getEstado() ) ){
			$sql .= " `estado` = ? AND";
			array_push( $val, $traspaso->getEstado() );
		}

		if( ! is_null( $traspaso->getCancelado() ) ){
			$sql .= " `cancelado` = ? AND";
			array_push( $val, $traspaso->getCancelado() );
		}

		if( ! is_null( $traspaso->getCompleto() ) ){
			$sql .= " `completo` = ? AND";
			array_push( $val, $traspaso->getCompleto() );
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
			$bar =  new Traspaso($foo);
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
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso a actualizar.
	  **/
	private static final function update( $traspaso )
	{
		$sql = "UPDATE traspaso SET  `id_usuario_programa` = ?, `id_usuario_envia` = ?, `id_almacen_envia` = ?, `fecha_envio_programada` = ?, `fecha_envio` = ?, `id_usuario_recibe` = ?, `id_almacen_recibe` = ?, `fecha_recibo` = ?, `estado` = ?, `cancelado` = ?, `completo` = ? WHERE  `id_traspaso` = ?;";
		$params = array( 
			$traspaso->getIdUsuarioPrograma(), 
			$traspaso->getIdUsuarioEnvia(), 
			$traspaso->getIdAlmacenEnvia(), 
			$traspaso->getFechaEnvioProgramada(), 
			$traspaso->getFechaEnvio(), 
			$traspaso->getIdUsuarioRecibe(), 
			$traspaso->getIdAlmacenRecibe(), 
			$traspaso->getFechaRecibo(), 
			$traspaso->getEstado(), 
			$traspaso->getCancelado(), 
			$traspaso->getCompleto(), 
			$traspaso->getIdTraspaso(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Traspaso suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Traspaso dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso a crear.
	  **/
	private static final function create( &$traspaso )
	{
		$sql = "INSERT INTO traspaso ( `id_traspaso`, `id_usuario_programa`, `id_usuario_envia`, `id_almacen_envia`, `fecha_envio_programada`, `fecha_envio`, `id_usuario_recibe`, `id_almacen_recibe`, `fecha_recibo`, `estado`, `cancelado`, `completo` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$traspaso->getIdTraspaso(), 
			$traspaso->getIdUsuarioPrograma(), 
			$traspaso->getIdUsuarioEnvia(), 
			$traspaso->getIdAlmacenEnvia(), 
			$traspaso->getFechaEnvioProgramada(), 
			$traspaso->getFechaEnvio(), 
			$traspaso->getIdUsuarioRecibe(), 
			$traspaso->getIdAlmacenRecibe(), 
			$traspaso->getFechaRecibo(), 
			$traspaso->getEstado(), 
			$traspaso->getCancelado(), 
			$traspaso->getCompleto(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $traspaso->setIdTraspaso( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Traspaso} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Traspaso}.
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
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $traspasoA , $traspasoB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from traspaso WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $traspasoA->getIdTraspaso()) ) ) & ( ! is_null ( ($b = $traspasoB->getIdTraspaso()) ) ) ){
				$sql .= " `id_traspaso` >= ? AND `id_traspaso` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_traspaso` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getIdUsuarioPrograma()) ) ) & ( ! is_null ( ($b = $traspasoB->getIdUsuarioPrograma()) ) ) ){
				$sql .= " `id_usuario_programa` >= ? AND `id_usuario_programa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_programa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getIdUsuarioEnvia()) ) ) & ( ! is_null ( ($b = $traspasoB->getIdUsuarioEnvia()) ) ) ){
				$sql .= " `id_usuario_envia` >= ? AND `id_usuario_envia` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_envia` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getIdAlmacenEnvia()) ) ) & ( ! is_null ( ($b = $traspasoB->getIdAlmacenEnvia()) ) ) ){
				$sql .= " `id_almacen_envia` >= ? AND `id_almacen_envia` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_almacen_envia` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getFechaEnvioProgramada()) ) ) & ( ! is_null ( ($b = $traspasoB->getFechaEnvioProgramada()) ) ) ){
				$sql .= " `fecha_envio_programada` >= ? AND `fecha_envio_programada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_envio_programada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getFechaEnvio()) ) ) & ( ! is_null ( ($b = $traspasoB->getFechaEnvio()) ) ) ){
				$sql .= " `fecha_envio` >= ? AND `fecha_envio` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_envio` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getIdUsuarioRecibe()) ) ) & ( ! is_null ( ($b = $traspasoB->getIdUsuarioRecibe()) ) ) ){
				$sql .= " `id_usuario_recibe` >= ? AND `id_usuario_recibe` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario_recibe` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getIdAlmacenRecibe()) ) ) & ( ! is_null ( ($b = $traspasoB->getIdAlmacenRecibe()) ) ) ){
				$sql .= " `id_almacen_recibe` >= ? AND `id_almacen_recibe` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_almacen_recibe` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getFechaRecibo()) ) ) & ( ! is_null ( ($b = $traspasoB->getFechaRecibo()) ) ) ){
				$sql .= " `fecha_recibo` >= ? AND `fecha_recibo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_recibo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getEstado()) ) ) & ( ! is_null ( ($b = $traspasoB->getEstado()) ) ) ){
				$sql .= " `estado` >= ? AND `estado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `estado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getCancelado()) ) ) & ( ! is_null ( ($b = $traspasoB->getCancelado()) ) ) ){
				$sql .= " `cancelado` >= ? AND `cancelado` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `cancelado` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $traspasoA->getCompleto()) ) ) & ( ! is_null ( ($b = $traspasoB->getCompleto()) ) ) ){
				$sql .= " `completo` >= ? AND `completo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `completo` = ? AND"; 
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
    		array_push( $ar, new Traspaso($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Traspaso suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Traspaso [$traspaso] El objeto de tipo Traspaso a eliminar
	  **/
	public static final function delete( &$traspaso )
	{
		if( is_null( self::getByPK($traspaso->getIdTraspaso()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM traspaso WHERE  id_traspaso = ?;";
		$params = array( $traspaso->getIdTraspaso() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
