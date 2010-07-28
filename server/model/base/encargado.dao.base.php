<?php
/** Encargado Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Encargado }. 
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access private
  * 
  */
abstract class EncargadoDAOBase extends TablaDAO
{

	/**
	  *	Guardar registros. 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Encargado} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara o combinacion de llaves
	  *	primarias describen una fila que no se encuentra en la base de datos, entonces save() creara una nueva fila, insertando
	  *	en ese objeto el ID recien creado.
	  *	
	  *	@static
	  * @throws Exception si la operacion fallo.
	  * @param Encargado [$encargado] El objeto de tipo Encargado
	  * @return Un entero mayor o igual a cero denotando las filas afectadas, o un string con el error si es que hubo alguno.
	  **/
	public static final function save( &$encargado )
	{
		if( self::getByPK(  $encargado->getIdUsuario() ) === NULL )
		{
			try{ return EncargadoDAOBase::create( $encargado) ; } catch(Exception $e){ throw $e; }
		}else{
			try{ return EncargadoDAOBase::update( $encargado) ; } catch(Exception $e){ throw $e; }
		}
	}


	/**
	  *	Obtener {@link Encargado} por llave primaria. 
	  *	
	  * Este metodo cargara un objeto {@link Encargado} de la base de datos 
	  * usando sus llaves primarias. 
	  *	
	  *	@static
	  * @return Objeto Un objeto del tipo {@link Encargado}. NULL si no hay tal registro.
	  **/
	public static final function getByPK(  $id_usuario )
	{
		$sql = "SELECT * FROM encargado WHERE (id_usuario = ? ) LIMIT 1;";
		$params = array(  $id_usuario );
		global $conn;
		$rs = $conn->GetRow($sql, $params);
		if(count($rs)==0)return NULL;
		return new Encargado( $rs );
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Encargado}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos o se usan sus parametros para obtener un menor numero de filas.
	  *	
	  *	@static
	  * @param $pagina Pagina a ver.
	  * @param $columnas_por_pagina Columnas por pagina.
	  * @param $orden Debe ser una cadena con el nombre de una columna en la base de datos.
	  * @param $tipo_de_orden 'ASC' o 'DESC' el default es 'ASC'
	  * @return Array Un arreglo que contiene objetos del tipo {@link Encargado}.
	  **/
	public static final function getAll( $pagina = NULL, $columnas_por_pagina = NULL, $orden = NULL, $tipo_de_orden = 'ASC' )
	{
		$sql = "SELECT * from encargado";
		if($pagina != NULL)
		{
			if($orden != NULL)
			{ $sql .= " ORDER BY " . $orden . " " . $tipo_de_orden;	}
			$sql .= " LIMIT " . (( $pagina - 1 )*$columnas_por_pagina) . "," . $columnas_por_pagina; 
		}
		global $conn;
		$rs = $conn->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Encargado($foo));
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Encargado} de la base de datos. 
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
	  * @param Encargado [$encargado] El objeto de tipo Encargado
	  * @param bool [$json] Verdadero para obtener los resultados en forma JSON y no objetos. En caso de no presentare este parametro se tomara el valor default de false.
	  **/
	public static final function search( $encargado , $json = false)
	{
		$sql = "SELECT * from encargado WHERE ("; 
		$val = array();
		if( $encargado->getIdUsuario() != NULL){
			$sql .= " id_usuario = ? AND";
			array_push( $val, $encargado->getIdUsuario() );
		}

		if( $encargado->getPorciento() != NULL){
			$sql .= " porciento = ? AND";
			array_push( $val, $encargado->getPorciento() );
		}

		$sql = substr($sql, 0, -3) . " )";
		global $conn;
		$rs = $conn->Execute($sql, $val);
		if($json === false){
			$ar = array();
			foreach ($rs as $foo) {
    			array_push( $ar, new Encargado($foo));
			}
			return $ar;
		}else{
			$allData = '[';
			foreach ($rs as $foo) {
    			$allData .= new Encargado($foo) . ',';
			}
    		$allData = substr($allData, 0 , -1) . ']';
			return $allData;
		}
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
	  * @param Encargado [$encargado] El objeto de tipo Encargado a actualizar.
	  **/
	private static final function update( $encargado )
	{
		$sql = "UPDATE encargado SET  porciento = ? WHERE  id_usuario = ?;";
		$params = array( 
			$encargado->getPorciento(), 
			$encargado->getIdUsuario(), );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		return $conn->Affected_Rows();
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Encargado suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Encargado dentro de la misma transaccion.
	  *	
	  * @internal private information for advanced developers only
	  * @return Un entero mayor o igual a cero identificando las filas afectadas, en caso de error, regresara una cadena con la descripcion del error
	  * @param Encargado [$encargado] El objeto de tipo Encargado a crear.
	  **/
	private static final function create( &$encargado )
	{
		$sql = "INSERT INTO encargado ( id_usuario, porciento ) VALUES ( ?, ?);";
		$params = array( 
			$encargado->getIdUsuario(), 
			$encargado->getPorciento(), 
		 );
		global $conn;
		try{$conn->Execute($sql, $params);}
		catch(Exception $e){ throw new Exception ($e->getMessage()); }
		$ar = $conn->Affected_Rows();
		if($ar == 0) return 0;
		
		return $ar;
	}


	/**
	  *	Buscar por rango.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Encargado} de la base de datos siempre y cuando 
	  * esten dentro del rango de atributos activos de dos objetos criterio de tipo {@link Encargado}.
	  * 
	  * Aquellas variables que tienen valores NULL seran excluidos en la busqueda. 
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
	  * @param Encargado [$encargado] El objeto de tipo Encargado
	  * @param Encargado [$encargado] El objeto de tipo Encargado
	  * @param bool [$json] Verdadero para obtener los resultados en forma JSON y no objetos. En caso de no presentare este parametro se tomara el valor default de false.
	  **/
	public static final function byRange( $encargadoA , $encargadoB , $json = false)
	{
		$sql = "SELECT * from encargado WHERE ("; 
		$val = array();
		if( (($a = $encargadoA->getIdUsuario()) != NULL) & ( ($b = $encargadoB->getIdUsuario()) != NULL) ){
				$sql .= " id_usuario >= ? AND id_usuario <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " id_usuario = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		if( (($a = $encargadoA->getPorciento()) != NULL) & ( ($b = $encargadoB->getPorciento()) != NULL) ){
				$sql .= " porciento >= ? AND porciento <= ? AND";
				array_push( $val, min($a,$b)); 
				array_push( $val, max($a,$b)); 
		}elseif( $a || $b ){
			$sql .= " porciento = ? AND"; 
			$a = $a == NULL ? $b : $a;
			array_push( $val, $a);
			
		}

		$sql = substr($sql, 0, -3) . " )";
		global $conn;
		$rs = $conn->Execute($sql, $val);
		if($json === false){
			$ar = array();
			foreach ($rs as $foo) {
    			array_push( $ar, new Encargado($foo));
			}
			return $ar;
		}else{
			$allData = '[';
			foreach ($rs as $foo) {
    			$allData .= new Encargado($foo) . ',';
			}
    		$allData = substr($allData, 0 , -1) . ']';
			return $allData;
		}
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Encargado suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). save() al ver que este es un objeto vacio, creara una nueva fila 
	  * pero el objeto resultante tendra una clave primaria diferente de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente a eliminar, Exception sera lanzada.
	  *	
	  *	@throws Exception Se arroja cuando el objeto no tiene definidas sus llaves primarias.
	  *	@return int El numero de filas afectadas.
	  * @param Encargado [$encargado] El objeto de tipo Encargado a eliminar
	  **/
	public static final function delete( &$encargado )
	{
		if(self::getByPK($encargado->getIdUsuario()) === NULL) throw new Exception('Campo no encontrado.');
		$sql = "DELETE FROM encargado WHERE  id_usuario = ?;";
		$params = array( $encargado->getIdUsuario() );
		global $conn;

		$conn->Execute($sql, $params);
		return $conn->Affected_Rows();
	}


}
