<?php
/** Corte Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Corte }. 
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access private
  * 
  */
abstract class CorteDAOBase
{

	/**
	  *	metodo save 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Corte} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara 
	  *	no esta definicda en el objeto, entonces save() creara una nueva fila.
	  *	
	  *	@static
	  * @param Corte [$corte] El objeto de tipo Corte
	  * @return bool Verdadero si el metodo guardo correctamente este objeto, falso si no.
	  **/
	public static final function save( &$corte )
	{
		if(  $corte->getNumCorte()  )
		{
			return CorteDAOBase::update( $corte) ;
		}else{
			return CorteDAOBase::create( $corte) ;
		}
	}


	/**
	  *	Obtener {@link Corte} por llave primaria. 
	  *	
	  * This will create and load {@link Corte} objects contents from database 
	  * using given Primary-Key as identifier. 
	  *	
	  *	@static
	  * @return Objeto Un objeto del tipo {@link Corte}.
	  **/
	public static final function getByPK(  $num_corte )
	{
		$sql = "SELECT * FROM corte WHERE (num_corte = ?) LIMIT 1;";
		$params = array(  $num_corte );
		global $db;
		$rs = $db->GetRow($sql, $params);
		return new Corte( $rs );
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Corte}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos
	  *	
	  *	@static
	  * @return Array Un arreglo que contiene objetos del tipo {@link Corte}.
	  **/
	public static final function getAll( )
	{
		$sql = "SELECT * from corte ;";
		global $db;
		$rs = $db->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Corte($foo));
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Corte} de la base de datos. 
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
	  * @param Objeto Un objeto del tipo {@link Corte}.
	  **/
	public static final function search( $corte )
	{
		$sql = "SELECT * from cliente WHERE ("; 
		$val = array();
		if($cliente->getNumCorte() != NULL){
			$sql .= " num_corte = ? AND";
			array_push( $val, $cliente->getNumCorte() );
		}

		if($cliente->getAnio() != NULL){
			$sql .= " anio = ? AND";
			array_push( $val, $cliente->getAnio() );
		}

		if($cliente->getInicio() != NULL){
			$sql .= " inicio = ? AND";
			array_push( $val, $cliente->getInicio() );
		}

		if($cliente->getFin() != NULL){
			$sql .= " fin = ? AND";
			array_push( $val, $cliente->getFin() );
		}

		if($cliente->getVentas() != NULL){
			$sql .= " ventas = ? AND";
			array_push( $val, $cliente->getVentas() );
		}

		if($cliente->getAbonosVentas() != NULL){
			$sql .= " abonosVentas = ? AND";
			array_push( $val, $cliente->getAbonosVentas() );
		}

		if($cliente->getCompras() != NULL){
			$sql .= " compras = ? AND";
			array_push( $val, $cliente->getCompras() );
		}

		if($cliente->getAbonosCompra() != NULL){
			$sql .= " AbonosCompra = ? AND";
			array_push( $val, $cliente->getAbonosCompra() );
		}

		if($cliente->getGastos() != NULL){
			$sql .= " gastos = ? AND";
			array_push( $val, $cliente->getGastos() );
		}

		if($cliente->getIngresos() != NULL){
			$sql .= " ingresos = ? AND";
			array_push( $val, $cliente->getIngresos() );
		}

		if($cliente->getGananciasNetas() != NULL){
			$sql .= " gananciasNetas = ? AND";
			array_push( $val, $cliente->getGananciasNetas() );
		}

		$sql = substr($sql, 0, -3) . " )";
		global $db;
		$rs = $db->Execute($sql, $val);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Corte($foo));
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
	  * @param Objeto El objeto del tipo {@link Corte} a actualizar. 
	  **/
	private static final function update( $corte )
	{
		$sql = "UPDATE corte SET  anio = ?, inicio = ?, fin = ?, ventas = ?, abonosVentas = ?, compras = ?, AbonosCompra = ?, gastos = ?, ingresos = ?, gananciasNetas = ? WHERE  num_corte = ?;";
		$params = array( 
			$corte->getAnio(), 
			$corte->getInicio(), 
			$corte->getFin(), 
			$corte->getVentas(), 
			$corte->getAbonosVentas(), 
			$corte->getCompras(), 
			$corte->getAbonosCompra(), 
			$corte->getGastos(), 
			$corte->getIngresos(), 
			$corte->getGananciasNetas(), 
			$corte->getNumCorte(), );
		global $db;
		$db->Execute($sql, $params);
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Corte suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Corte.
	  *	
	  * @internal private information for advanced developers only
	  * @param Objeto El objeto del tipo {@link Corte} a crear. 
	  **/
	private static final function create( &$corte )
	{
		$sql = "INSERT INTO corte ( anio, inicio, fin, ventas, abonosVentas, compras, AbonosCompra, gastos, ingresos, gananciasNetas ) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
		$params = array( 
			$corte->getAnio(), 
			$corte->getInicio(), 
			$corte->getFin(), 
			$corte->getVentas(), 
			$corte->getAbonosVentas(), 
			$corte->getCompras(), 
			$corte->getAbonosCompra(), 
			$corte->getGastos(), 
			$corte->getIngresos(), 
			$corte->getGananciasNetas(), 
		 );
		global $db;
		$db->Execute($sql, $params);
		$corte->setNumCorte( $db->Insert_ID() );
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Corte suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). Restaurarlo solo se puede hacer usando el metodo create(), 
	  * pero el objeto resultante tendra una diferente clave primaria de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente, NotFoundException sera lanzada.
	  *	
	  * @param Objeto El objeto del tipo {@link Corte} a eliminar. 
	  **/
	public static final function delete( &$corte )
	{
		$sql = "DELETE FROM corte WHERE  num_corte = ?;";

		$params = array( 
			$corte->getNumCorte(), );

		global $db;

		$db->Execute($sql, $params);
	}


}
