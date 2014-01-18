<?php
/** LoteEntrada Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link LoteEntrada }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class LoteEntradaDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link LoteEntrada} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$lote_entrada )
	{
		if( ! is_null ( self::getByPK(  $lote_entrada->getIdLoteEntrada() ) ) )
		{
			try{ return LoteEntradaDAOBase::update( $lote_entrada) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return LoteEntradaDAOBase::create( $lote_entrada) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link LoteEntrada} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link LoteEntrada} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link LoteEntrada Un objeto del tipo {@link LoteEntrada}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_lote_entrada )
	{
		$sql = "SELECT * FROM lote_entrada WHERE (id_lote_entrada = ? ) LIMIT 1;";
		$params = array(  $id_lote_entrada );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new LoteEntrada( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link LoteEntrada}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link LoteEntrada}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from lote_entrada";
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
			$bar = new LoteEntrada($foo);
    		array_push( $allData, $bar);
			//id_lote_entrada
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link LoteEntrada} de la base de datos. 
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
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $lote_entrada , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from lote_entrada WHERE ("; 
		$val = array();
		if( ! is_null( $lote_entrada->getIdLoteEntrada() ) ){
			$sql .= " `id_lote_entrada` = ? AND";
			array_push( $val, $lote_entrada->getIdLoteEntrada() );
		}

		if( ! is_null( $lote_entrada->getIdLote() ) ){
			$sql .= " `id_lote` = ? AND";
			array_push( $val, $lote_entrada->getIdLote() );
		}

		if( ! is_null( $lote_entrada->getIdDocumento() ) ){
			$sql .= " `id_documento` = ? AND";
			array_push( $val, $lote_entrada->getIdDocumento() );
		}

		if( ! is_null( $lote_entrada->getIdUsuario() ) ){
			$sql .= " `id_usuario` = ? AND";
			array_push( $val, $lote_entrada->getIdUsuario() );
		}

		if( ! is_null( $lote_entrada->getFechaRegistro() ) ){
			$sql .= " `fecha_registro` = ? AND";
			array_push( $val, $lote_entrada->getFechaRegistro() );
		}

		if( ! is_null( $lote_entrada->getMotivo() ) ){
			$sql .= " `motivo` = ? AND";
			array_push( $val, $lote_entrada->getMotivo() );
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
			$bar =  new LoteEntrada($foo);
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
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada a actualizar.
	  **/
	private static final function update( $lote_entrada )
	{
		$sql = "UPDATE lote_entrada SET  `id_lote` = ?, `id_documento` = ?, `id_usuario` = ?, `fecha_registro` = ?, `motivo` = ? WHERE  `id_lote_entrada` = ?;";
		$params = array( 
			$lote_entrada->getIdLote(), 
			$lote_entrada->getIdDocumento(), 
			$lote_entrada->getIdUsuario(), 
			$lote_entrada->getFechaRegistro(), 
			$lote_entrada->getMotivo(), 
			$lote_entrada->getIdLoteEntrada(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto LoteEntrada suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto LoteEntrada dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada a crear.
	  **/
	private static final function create( &$lote_entrada )
	{
		$sql = "INSERT INTO lote_entrada ( `id_lote_entrada`, `id_lote`, `id_documento`, `id_usuario`, `fecha_registro`, `motivo` ) VALUES ( ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$lote_entrada->getIdLoteEntrada(), 
			$lote_entrada->getIdLote(), 
			$lote_entrada->getIdDocumento(), 
			$lote_entrada->getIdUsuario(), 
			$lote_entrada->getFechaRegistro(), 
			$lote_entrada->getMotivo(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $lote_entrada->setIdLoteEntrada( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link LoteEntrada} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link LoteEntrada}.
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
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $lote_entradaA , $lote_entradaB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from lote_entrada WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $lote_entradaA->getIdLoteEntrada()) ) ) & ( ! is_null ( ($b = $lote_entradaB->getIdLoteEntrada()) ) ) ){
				$sql .= " `id_lote_entrada` >= ? AND `id_lote_entrada` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_lote_entrada` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $lote_entradaA->getIdLote()) ) ) & ( ! is_null ( ($b = $lote_entradaB->getIdLote()) ) ) ){
				$sql .= " `id_lote` >= ? AND `id_lote` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_lote` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $lote_entradaA->getIdDocumento()) ) ) & ( ! is_null ( ($b = $lote_entradaB->getIdDocumento()) ) ) ){
				$sql .= " `id_documento` >= ? AND `id_documento` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_documento` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $lote_entradaA->getIdUsuario()) ) ) & ( ! is_null ( ($b = $lote_entradaB->getIdUsuario()) ) ) ){
				$sql .= " `id_usuario` >= ? AND `id_usuario` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_usuario` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $lote_entradaA->getFechaRegistro()) ) ) & ( ! is_null ( ($b = $lote_entradaB->getFechaRegistro()) ) ) ){
				$sql .= " `fecha_registro` >= ? AND `fecha_registro` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `fecha_registro` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $lote_entradaA->getMotivo()) ) ) & ( ! is_null ( ($b = $lote_entradaB->getMotivo()) ) ) ){
				$sql .= " `motivo` >= ? AND `motivo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `motivo` = ? AND"; 
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
    		array_push( $ar, new LoteEntrada($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto LoteEntrada suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param LoteEntrada [$lote_entrada] El objeto de tipo LoteEntrada a eliminar
	  **/
	public static final function delete( &$lote_entrada )
	{
		if( is_null( self::getByPK($lote_entrada->getIdLoteEntrada()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM lote_entrada WHERE  id_lote_entrada = ?;";
		$params = array( $lote_entrada->getIdLoteEntrada() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
