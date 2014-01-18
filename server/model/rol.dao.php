<?php

require_once ('Estructura.php');
require_once("base/rol.dao.base.php");
require_once("base/rol.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Andres
  * @package docs
  * 
  */
/** Rol Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Rol }. 
  * @author Andres
  * @access public
  * @package docs
  * 
  */
class RolDAO extends RolDAOBase
{
	/**
     * buscar($activa, $limit, $order, $order_by, $query, $start)
     *
     * Muestra todas la empresas en el sistema que conicidan con los parametros indicados
     *
     * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
     * @param activa bool Verdadero para mostrar solo las empresas activas. En caso de false, se mostraran ambas.
     * @param limit string Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la bsqueda.
     * @param order string Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
     * @param order_by string Indica por que campo se ordenan los resultados.
     * @param query string Valor que se buscara en la consulta
     * @param start string Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la bsqueda.
     * @return array numero de resultados
     **/
    public static function buscar($limit, $order, $order_by, $query, $start)
    {
        global $conn;

        $sql = "SELECT * FROM rol "
             . ($query !== NULL ? "WHERE " . ($query !== NULL ? " nombre LIKE '%{$query}%' OR descripcion LIKE '%{$query}%' OR salario LIKE '%{$query}%'" : "") : "")
             . "ORDER BY {$order_by} {$order} "
             . ($limit === NULL ? "" : ($start !== NULL ? " LIMIT {$start}, {$limit}" : "LIMIT {$limit}"));
		 Logger::log($sql);
        $res = $conn->GetAssoc($sql, false, false, false);

        $a = array();

        foreach ($res as $v) {
            array_push($a, $v);
        }

        return $a;
    }
}
