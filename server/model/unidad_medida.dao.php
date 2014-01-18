<?php

require_once ('Estructura.php');
require_once("base/unidad_medida.dao.base.php");
require_once("base/unidad_medida.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Anonymous
  * @package docs
  * 
  */
/** UnidadMedida Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link UnidadMedida }. 
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */
class UnidadMedidaDAO extends UnidadMedidaDAOBase
{
    /**
     * Busca unidades de medida cuya descripcion o abreviacion coincida con query.
     * @author Mauricio Nunez <mauricio@caffeina.mx>
     * @param activa Status de las categorias a obtener.
     * @param query Cadena a buscar en la descripcion de las categorias.
     * @return array Resultados coincidentes.
     **/
    public static function buscar($query) {
        global $conn;

        $sql = "SELECT * FROM unidad_medida"
        . ($query !== NULL ? " WHERE descripcion LIKE '%{$query}%' OR abreviacion LIKE '%{$query}%'" : "");

        $res = $conn->GetAssoc($sql, false, false, false);

        $a = array();

        foreach ($res as $v) {
            array_push($a, $v);
        }

        return $a;
    }

    public static function convertir( $id_unidad_desde, $id_unidad_destino, $cantidad_desde) {
        //buscar esas unidades
        $x = self::getByPK( $id_unidad_desde );
        $y = self::getByPK( $id_unidad_destino );
        $c = $cantidad_desde;

        if(is_null( $x)) throw new InvalidDataException("La unidad no existe (desde)");
        if(is_null( $y)) throw new InvalidDataException("La unidad no existe (destino)");

        //verifiquemos que las dos unidades sean de la misma categoria
        if($x->getIdCategoriaUnidadMedida() != $y->getIdCategoriaUnidadMedida()){
            Logger::error("En UnidadMedidaDAO::convertir(id_unidad_desde $id_unidad_desde, id_unidad_destino $id_unidad_destino, cantidad_desde $cantidad_desde)");
            Logger::error("No se pueden convertir entre diferentes categorias");
            throw new BusinessLogicException("No se pueden convertir entre diferentes categorias");
        }

        $r = ($x->getFactorConversion() * $c / $y->getFactorConversion());
        return $r;
    }
}
