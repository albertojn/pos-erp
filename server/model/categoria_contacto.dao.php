<?php

require_once ('Estructura.php');
require_once("base/categoria_contacto.dao.base.php");
require_once("base/categoria_contacto.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Anonymous
  * @package docs
  * 
  */
/** CategoriaContacto Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link CategoriaContacto }. 
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */
class CategoriaContactoDAO extends CategoriaContactoDAOBase {

    public static function ChecarRecursion($id, $id_padre) {
        $nivel = 100;
        while ($id_padre) {
            $categoria = self::getByPK($id_padre);
            $id_padre = $categoria->getIdPadre();
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
        if ($categoria->getIdPadre()) {
            $nombre .= self::NombreCompleto($categoria->getIdPadre()).'/';
        }
        return $nombre.$categoria->getNombre();
    }
}
