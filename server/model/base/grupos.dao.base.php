<?php
/** Grupos Data Access Object (DAO) Base.
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Grupos }. 
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access private
  * 
  */
abstract class GruposDAOBase
{

	/**
	  *	metodo save 
	  *	
	  *	Este metodo guarda el estado actual del objeto {@link Grupos} pasado en la base de datos. La llave 
	  *	primaria indicara que instancia va a ser actualizado en base de datos. Si la llave primara 
	  *	no esta definicda en el objeto, entonces save() creara una nueva fila.
	  *	
	  *	@static
	  * @param Grupos [$grupos] El objeto de tipo Grupos
	  * @return bool Verdadero si el metodo guardo correctamente este objeto, falso si no.
	  **/
	public static final function save( &$grupos )
	{
		if(  $grupos->getIdGrupo()  )
		{
			return GruposDAOBase::update( $grupos) ;
		}else{
			return GruposDAOBase::create( $grupos) ;
		}
	}


	/**
	  *	Obtener {@link Grupos} por llave primaria. 
	  *	
	  * This will create and load {@link Grupos} objects contents from database 
	  * using given Primary-Key as identifier. 
	  *	
	  *	@static
	  * @return Objeto Un objeto del tipo {@link Grupos}.
	  **/
	public static final function getByPK(  $id_grupo )
	{
		$sql = "SELECT * FROM grupos WHERE (id_grupo = ?) LIMIT 1;";
		$params = array(  $id_grupo );
		global $db;
		$rs = $db->GetRow($sql, $params);
		return new Grupos( $rs );
	}


	/**
	  *	Obtener todas las filas.
	  *	
	  * Esta funcion leera todos los contenidos de la tabla en la base de datos y construira
	  * un vector que contiene objetos de tipo {@link Grupos}. Tenga en cuenta que este metodo
	  * consumen enormes cantidades de recursos si la tabla tiene muchas filas. 
	  * Este metodo solo debe usarse cuando las tablas destino tienen solo pequenas cantidades de datos
	  *	
	  *	@static
	  * @return Array Un arreglo que contiene objetos del tipo {@link Grupos}.
	  **/
	public static final function getAll( )
	{
		$sql = "SELECT * from grupos ;";
		global $db;
		$rs = $db->Execute($sql);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Grupos($foo));
		}
		return $allData;
	}


	/**
	  *	Buscar registros.
	  *	
	  * Este metodo proporciona capacidad de busqueda para conseguir un juego de objetos {@link Grupos} de la base de datos. 
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
	  * @param Objeto Un objeto del tipo {@link Grupos}.
	  **/
	public static final function search( $grupos )
	{
		$sql = "SELECT * from cliente WHERE ("; 
		$val = array();
		if($cliente->getIdGrupo() != NULL){
			$sql .= " id_grupo = ? AND";
			array_push( $val, $cliente->getIdGrupo() );
		}

		if($cliente->getNombre() != NULL){
			$sql .= " nombre = ? AND";
			array_push( $val, $cliente->getNombre() );
		}

		if($cliente->getDescripcion() != NULL){
			$sql .= " descripcion = ? AND";
			array_push( $val, $cliente->getDescripcion() );
		}

		$sql = substr($sql, 0, -3) . " )";
		global $db;
		$rs = $db->Execute($sql, $val);
		$allData = array();
		foreach ($rs as $foo) {
    		array_push( $allData, new Grupos($foo));
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
	  * @param Objeto El objeto del tipo {@link Grupos} a actualizar. 
	  **/
	private static final function update( $grupos )
	{
		$sql = "UPDATE grupos SET  nombre = ?, descripcion = ? WHERE  id_grupo = ?;";
		$params = array( 
			$grupos->getNombre(), 
			$grupos->getDescripcion(), 
			$grupos->getIdGrupo(), );
		global $db;
		$db->Execute($sql, $params);
	}


	/**
	  *	Crear registros.
	  *	
	  * Este metodo creara una nueva fila en la base de datos de acuerdo con los 
	  * contenidos del objeto Grupos suministrado. Asegurese
	  * de que los valores para todas las columnas NOT NULL se ha especificado 
	  * correctamente. Despues del comando INSERT, este metodo asignara la clave 
	  * primaria generada en el objeto Grupos.
	  *	
	  * @internal private information for advanced developers only
	  * @param Objeto El objeto del tipo {@link Grupos} a crear. 
	  **/
	private static final function create( &$grupos )
	{
		$sql = "INSERT INTO grupos ( id_grupo, nombre, descripcion ) VALUES ( ?, ?, ?);";
		$params = array( 
			$grupos->getIdGrupo(), 
			$grupos->getNombre(), 
			$grupos->getDescripcion(), 
		 );
		global $db;
		$db->Execute($sql, $params);
		
	}


	/**
	  *	Eliminar registros.
	  *	
	  * Este metodo eliminara la informacion de base de datos identificados por la clave primaria
	  * en el objeto Grupos suministrado. Una vez que se ha suprimido un objeto, este no 
	  * puede ser restaurado llamando a save(). Restaurarlo solo se puede hacer usando el metodo create(), 
	  * pero el objeto resultante tendra una diferente clave primaria de la que estaba en el objeto eliminado. 
	  * Si no puede encontrar eliminar fila coincidente, NotFoundException sera lanzada.
	  *	
	  * @param Objeto El objeto del tipo {@link Grupos} a eliminar. 
	  **/
	public static final function delete( &$grupos )
	{
		$sql = "DELETE FROM grupos WHERE  id_grupo = ?;";

		$params = array( 
			$grupos->getIdGrupo(), );

		global $db;

		$db->Execute($sql, $params);
	}


}
