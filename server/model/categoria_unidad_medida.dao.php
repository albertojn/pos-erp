<?php

require_once ('Estructura.php');
require_once("base/categoria_unidad_medida.dao.base.php");
require_once("base/categoria_unidad_medida.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Anonymous
  * @package docs
  * 
  */
/** CategoriaUnidadMedida Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link CategoriaUnidadMedida }. 
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */
class CategoriaUnidadMedidaDAO extends CategoriaUnidadMedidaDAOBase {

	/**
	 * Busca categorias cuya descripcion coincida con query.
	 * @author Mauricio Nunez <mauricio@caffeina.mx>
	 * @param activa Status de las categorias a obtener.
	 * @param query Cadena a buscar en la descripcion de las categorias.
	 * @return array Resultados coincidentes.
	 **/
	public static function buscar($activa, $query) {
		global $conn;

        $sql = "SELECT * FROM categoria_unidad_medida "
        . (!is_null($activa) || $query !== NULL ? "WHERE " . (!is_null($activa) ? "activa = " . (int) $activa . " " . ($query !== NULL ? "AND " : "") : "") . ($query !== NULL ? " descripcion LIKE '%{$query}%'" : "") : "");

        $res = $conn->GetAssoc($sql, false, false, false);

        $a = array();

        foreach ($res as $v) {
            array_push($a, $v);
        }

        return $a;
	}
}
