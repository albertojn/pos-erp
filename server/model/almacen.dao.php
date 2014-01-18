<?php

require_once ('Estructura.php');
require_once("base/almacen.dao.base.php");
require_once("base/almacen.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Andres
  * @package docs
  * 
  */
/** Almacen Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Almacen }. 
  * @author Andres
  * @access public
  * @package docs
  * 
  */
class AlmacenDAO extends AlmacenDAOBase
{
    public static function Existencias(){

        $sql = "select  
                 s.id_sucursal, 
                 a.id_almacen, 
                 a.nombre as nombre_almacen, 
                 lp.id_producto,
                 sum(lp.cantidad) as cantidad
              from 
                 lote l, lote_producto lp, almacen a, sucursal s
              where 
                 lp.id_lote = l.id_lote 
                 and l.id_almacen = a.id_almacen 
                 and a.id_sucursal = s.id_sucursal
              group by id_almacen, id_producto";

     
        global $conn;
        return $conn->Execute( $sql )->GetArray();

    }
}
