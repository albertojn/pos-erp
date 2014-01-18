<?php
/** DocumentoBase Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link DocumentoBase }. 
  * @author Anonymous
  * @access private
  * @abstract
  * @package docs
  * 
  */
abstract class DocumentoBaseDAOBase extends DAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link DocumentoBase} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase
	  * @return Un entero mayor o igual a cero denotando las filas afectadas.
	  **/
	public static final function save( &$documento_base )
	{
		if( ! is_null ( self::getByPK(  $documento_base->getIdDocumentoBase() ) ) )
		{
			try{ return DocumentoBaseDAOBase::update( $documento_base) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return DocumentoBaseDAOBase::create( $documento_base) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link DocumentoBase} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link DocumentoBase} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return @link DocumentoBase Un objeto del tipo {@link DocumentoBase}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_documento_base )
	{
		$sql = "SELECT * FROM documento_base WHERE (id_documento_base = ? ) LIMIT 1;";
		$params = array(  $id_documento_base );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
			$foo = new DocumentoBase( $rs );
			return $foo;
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link DocumentoBase}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link DocumentoBase}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from documento_base";
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
			$bar = new DocumentoBase($foo);
    		array_push( $allData, $bar);
			//id_documento_base
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link DocumentoBase} de la base de datos. 
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
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function search( $documento_base , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from documento_base WHERE ("; 
		$val = array();
		if( ! is_null( $documento_base->getIdDocumentoBase() ) ){
			$sql .= " `id_documento_base` = ? AND";
			array_push( $val, $documento_base->getIdDocumentoBase() );
		}

		if( ! is_null( $documento_base->getIdEmpresa() ) ){
			$sql .= " `id_empresa` = ? AND";
			array_push( $val, $documento_base->getIdEmpresa() );
		}

		if( ! is_null( $documento_base->getIdSucursal() ) ){
			$sql .= " `id_sucursal` = ? AND";
			array_push( $val, $documento_base->getIdSucursal() );
		}

		if( ! is_null( $documento_base->getNombre() ) ){
			$sql .= " `nombre` = ? AND";
			array_push( $val, $documento_base->getNombre() );
		}

		if( ! is_null( $documento_base->getActivo() ) ){
			$sql .= " `activo` = ? AND";
			array_push( $val, $documento_base->getActivo() );
		}

		if( ! is_null( $documento_base->getJsonImpresion() ) ){
			$sql .= " `json_impresion` = ? AND";
			array_push( $val, $documento_base->getJsonImpresion() );
		}

		if( ! is_null( $documento_base->getNombrePlantilla() ) ){
			$sql .= " `nombre_plantilla` = ? AND";
			array_push( $val, $documento_base->getNombrePlantilla() );
		}

		if( ! is_null( $documento_base->getUltimaModificacion() ) ){
			$sql .= " `ultima_modificacion` = ? AND";
			array_push( $val, $documento_base->getUltimaModificacion() );
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
			$bar =  new DocumentoBase($foo);
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
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase a actualizar.
	  **/
	private static final function update( $documento_base )
	{
		$sql = "UPDATE documento_base SET  `id_empresa` = ?, `id_sucursal` = ?, `nombre` = ?, `activo` = ?, `json_impresion` = ?, `nombre_plantilla` = ?, `ultima_modificacion` = ? WHERE  `id_documento_base` = ?;";
		$params = array( 
			$documento_base->getIdEmpresa(), 
			$documento_base->getIdSucursal(), 
			$documento_base->getNombre(), 
			$documento_base->getActivo(), 
			$documento_base->getJsonImpresion(), 
			$documento_base->getNombrePlantilla(), 
			$documento_base->getUltimaModificacion(), 
			$documento_base->getIdDocumentoBase(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto DocumentoBase suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto DocumentoBase dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase a crear.
	  **/
	private static final function create( &$documento_base )
	{
		$sql = "INSERT INTO documento_base ( `id_documento_base`, `id_empresa`, `id_sucursal`, `nombre`, `activo`, `json_impresion`, `nombre_plantilla`, `ultima_modificacion` ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$documento_base->getIdDocumentoBase(), 
			$documento_base->getIdEmpresa(), 
			$documento_base->getIdSucursal(), 
			$documento_base->getNombre(), 
			$documento_base->getActivo(), 
			$documento_base->getJsonImpresion(), 
			$documento_base->getNombrePlantilla(), 
			$documento_base->getUltimaModificacion(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		/* save autoincremented value on obj */  $documento_base->setIdDocumentoBase( $conn->Insert_ID() ); /*  */ 
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link DocumentoBase} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link DocumentoBase}.
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
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase
	  * @param $orderBy Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $orden 'ASC' o 'DESC' el default es 'ASC'
	  **/
	public static final function byRange( $documento_baseA , $documento_baseB , $orderBy = null, $orden = 'ASC')
	{
		$sql = "SELECT * from documento_base WHERE ("; 
		$val = array();
		if( ( !is_null (($a = $documento_baseA->getIdDocumentoBase()) ) ) & ( ! is_null ( ($b = $documento_baseB->getIdDocumentoBase()) ) ) ){
				$sql .= " `id_documento_base` >= ? AND `id_documento_base` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_documento_base` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getIdEmpresa()) ) ) & ( ! is_null ( ($b = $documento_baseB->getIdEmpresa()) ) ) ){
				$sql .= " `id_empresa` >= ? AND `id_empresa` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_empresa` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getIdSucursal()) ) ) & ( ! is_null ( ($b = $documento_baseB->getIdSucursal()) ) ) ){
				$sql .= " `id_sucursal` >= ? AND `id_sucursal` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `id_sucursal` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getNombre()) ) ) & ( ! is_null ( ($b = $documento_baseB->getNombre()) ) ) ){
				$sql .= " `nombre` >= ? AND `nombre` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getActivo()) ) ) & ( ! is_null ( ($b = $documento_baseB->getActivo()) ) ) ){
				$sql .= " `activo` >= ? AND `activo` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `activo` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getJsonImpresion()) ) ) & ( ! is_null ( ($b = $documento_baseB->getJsonImpresion()) ) ) ){
				$sql .= " `json_impresion` >= ? AND `json_impresion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `json_impresion` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getNombrePlantilla()) ) ) & ( ! is_null ( ($b = $documento_baseB->getNombrePlantilla()) ) ) ){
				$sql .= " `nombre_plantilla` >= ? AND `nombre_plantilla` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `nombre_plantilla` = ? AND"; 
			$a = is_null ( $a ) ? $b : $a;
			array_push( $val, $a);
			
		}

		if( ( !is_null (($a = $documento_baseA->getUltimaModificacion()) ) ) & ( ! is_null ( ($b = $documento_baseB->getUltimaModificacion()) ) ) ){
				$sql .= " `ultima_modificacion` >= ? AND `ultima_modificacion` <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( !is_null ( $a ) || !is_null ( $b ) ){
			$sql .= " `ultima_modificacion` = ? AND"; 
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
    		array_push( $ar, new DocumentoBase($foo));
		}
		return $ar;
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto DocumentoBase suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param DocumentoBase [$documento_base] El objeto de tipo DocumentoBase a eliminar
	  **/
	public static final function delete( &$documento_base )
	{
		if( is_null( self::getByPK($documento_base->getIdDocumentoBase()) ) ) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM documento_base WHERE  id_documento_base = ?;";
		$params = array( $documento_base->getIdDocumentoBase() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
