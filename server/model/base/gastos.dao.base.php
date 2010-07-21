<?php
/** Gastos Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Gastos }. 
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access private
  * 
  */
abstract class GastosDAOBase
{

	/**
	  *	metodo save 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Gastos} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara 
	  *	no esta definicda en el objeto, entonces save() creara una nueva fila.
	  *	
	  *	@static
	  * @param Gastos [$gastos] El objeto de tipo Gastos
	  * @return bool Verdadero si el metodo guardo correctamente este objeto, falso si no.
	  **/
	public static final function save( &$gastos )
	{
		if(  $gastos->getIdGasto()  )
		{
			return GastosDAOBase::update( $gastos) ;
		}else{
			return GastosDAOBase::create( $gastos) ;
		}
	}


	/**
	  *	Obtener {@link Gastos} por llave primaria. 
	  *	
	  * This will create and load {@link Gastos} objects contents from database 
	  * using given Primary-Key as identifier. 
	  *	
	  *	@static
	  * @return Objeto Un objeto del tipo {@link Gastos}.
	  **/
	public static final function getByPK(  $id_gasto )
	{
		$sql = "SELECT * FROM gastos WHERE (id_gasto = ?) LIMIT 1;";
		$params = array(  $id_gasto );
		global $db;
		$rs = $db->GetRow($sql, $params);
		return new Gastos( $rs );
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Gastos}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos
	  *	
	  *	@static
	  * @return Array Un arreglo que contiene objetos del tipo {@link Gastos}.
	  **/
	public static final function getAll( )
	{
		$sql = "SELECT * from gastos ;";
		global $db;
		$rs = $db->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Gastos($foo));
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Gastos} de la base de datos. 
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
	  * @param Objeto Un objeto del tipo {@link Gastos}.
	  **/
	public static final function search( $gastos )
	{
		$sql = "SELECT * from cliente WHERE ("; 
		$val = array();
		if($cliente->getIdGasto() != NULL){
			$sql .= " id_gasto = ? AND";
			array_push( $val, $cliente->getIdGasto() );
		}

		if($cliente->getConcepto() != NULL){
			$sql .= " concepto = ? AND";
			array_push( $val, $cliente->getConcepto() );
		}

		if($cliente->getMonto() != NULL){
			$sql .= " monto = ? AND";
			array_push( $val, $cliente->getMonto() );
		}

		if($cliente->getFecha() != NULL){
			$sql .= " fecha = ? AND";
			array_push( $val, $cliente->getFecha() );
		}

		if($cliente->getIdSucursal() != NULL){
			$sql .= " id_sucursal = ? AND";
			array_push( $val, $cliente->getIdSucursal() );
		}

		if($cliente->getIdUsuario() != NULL){
			$sql .= " id_usuario = ? AND";
			array_push( $val, $cliente->getIdUsuario() );
		}

		$sql = substr($sql, 0, -3) . " )";
		global $db;
		$rs = $db->Execute($sql, $val);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Gastos($foo));
		}
		return $allData;
	}


	/**
	  *	Actualizar registros.
	  *	
	  * Este metodo es un metodo de ayuda para uso interno. Se ejecutara todas las manipulaciones
	  * en la base de datos que estan dadas en el objeto pasado.No se haran consultas SELECT 
	  * aqui, sin embargo. El valor de retorno indica cuántas filas se vieron afectadas.
	  *	
	  * @internal private information for advanced developers only
	  * @param Objeto El objeto del tipo {@link Gastos} a actualizar. 
	  **/
	private static final function update( $gastos )
	{
		$sql = "UPDATE gastos SET  concepto = ?, monto = ?, fecha = ?, id_sucursal = ?, id_usuario = ? WHERE  id_gasto = ?;";
		$params = array( 
			$gastos->getConcepto(), 
			$gastos->getMonto(), 
			$gastos->getFecha(), 
			$gastos->getIdSucursal(), 
			$gastos->getIdUsuario(), 
			$gastos->getIdGasto(), );
		global $db;
		$db->Execute($sql, $params);
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Gastos suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Gastos.
	  *	
	  * @internal private information for advanced developers only
	  * @param Objeto El objeto del tipo {@link Gastos} a crear. 
	  **/
	private static final function create( &$gastos )
	{
		$sql = "INSERT INTO gastos ( concepto, monto, fecha, id_sucursal, id_usuario ) VALUES ( ?, ?, ?, ?, ?);";
		$params = array( 
			$gastos->getConcepto(), 
			$gastos->getMonto(), 
			$gastos->getFecha(), 
			$gastos->getIdSucursal(), 
			$gastos->getIdUsuario(), 
		 );
		global $db;
		$db->Execute($sql, $params);
		$gastos->setIdGasto( $db->Insert_ID() );
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Gastos suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). Restaurarlo solo se puede hacer usando el metodo create(), 
	  * pero el objeto resultante tendra una diferente clave primaria de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente, NotFoundException sera lanzada.
	  *	
	  * @param Objeto El objeto del tipo {@link Gastos} a eliminar. 
	  **/
	public static final function delete( &$gastos )
	{
		$sql = "DELETE FROM gastos WHERE  id_gasto = ?;";

		$params = array( 
			$gastos->getIdGasto(), );

		global $db;

		$db->Execute($sql, $params);
	}


}
