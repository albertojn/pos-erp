<?php

require_once ('Estructura.php');
require_once("base/clasificacion_producto.dao.base.php");
require_once("base/clasificacion_producto.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Andres
  * @package docs
  * 
  */
/** ClasificacionProducto Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link ClasificacionProducto }. 
  * @author Andres
  * @access public
  * @package docs
  * 
  */
class ClasificacionProductoDAO extends ClasificacionProductoDAOBase
{
	public static function ChecarRecursion($id, $id_padre) {
        $nivel = 100;
        while ($id_padre) {
            $categoria = self::getByPK($id_padre);
            $id_padre = $categoria->getIdCategoriaPadre();
            if ($id_padre == $id) {
                return false;
            }
            if (!$nivel) {
                return false;
            }
        }
        return true;
    }

    public static function NombreCompleto($id) {
        $categoria = self::getByPK($id);
        $nombre = '';
        if ($categoria->getIdCategoriaPadre()) {
            $nombre .= self::NombreCompleto($categoria->getIdCategoriaPadre()).'/';
        }
        return $nombre.$categoria->getNombre();
    }
}
