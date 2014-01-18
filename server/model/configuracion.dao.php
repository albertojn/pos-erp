<?php

require_once ('Estructura.php');
require_once("base/configuracion.dao.base.php");
require_once("base/configuracion.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Anonymous
  * @package docs
  * 
  */
/** Configuracion Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Configuracion }. 
  * @author Mau Nunez
  * @access public
  * @package docs
  * 
  */
class ConfiguracionDAO extends ConfiguracionDAOBase
{
    private static $descripcion_productos = 'productos_visibles_en_vc';


    /*
     * Guarda la configuracion para mostrar los productos al cliente.
     * param mostrar: boolean
     * param id_usuario: int
     * param propiedades: array de strings
     */
    public static function GuardarConfigDeVC($mostrar, $id_usuario, $propiedades)
    {
        $campos = array_keys(get_class_vars('Producto'));

        // if propiedades_array NO es subconjunto de campos
        if (is_array($propiedades)) {
            if (!array_intersect($propiedades, $campos) == $propiedades)
            {
                throw new InvalidArgumentException("Conjunto de propiedades inválido");
            }
        }

        $valor = array("mostrar" => $mostrar, "propiedades" => $propiedades);

        self::GuardarConfig(self::$descripcion_productos, $id_usuario, $valor);
    }

    /*
     * Devuelve true si sí se deben mostrar los productos.
     */
    public static function MostrarProductos()
    {
        $configuracion = self::BuscarConfig(self::$descripcion_productos);

        if (!$configuracion->getValor())
        {
            return false;
        }

        $valor = json_decode($configuracion->getValor());
        if ($valor->mostrar == 0)
        {
            return false;
        }

        return true;
    }

    /*
     * Devuelve un arreglo de string con los campos que se mostraran al cliente
     */
    public static function Propiedades()
    {
        $configuracion = self::BuscarConfig(self::$descripcion_productos);

        if ($configuracion->getValor())
        {
            $valor = json_decode($configuracion->getValor());
            return $valor->propiedades;
        }

        return null;
    }

    /*
     * Guarda la configuracion para conectarse a un servidor adminpaq
     */
    public static function GuardarConfigDeAdminpaq($ip, $path, $num_precio, $id_usuario)
    {
        $descripcion = 'adminpaq';
        $valor = array("ip" => $ip, "path" => $path, "num_precio" => $num_precio);
        self::GuardarConfig($descripcion, $id_usuario, $valor);
    }

    /*
     * Crea o actualiza la configuracion.
     */
    private static function GuardarConfig($descripcion, $id_usuario, $valor)
    {
        $configuracion = self::BuscarConfig($descripcion);
        $configuracion->setValor(json_encode($valor));
        $configuracion->setIdUsuario($id_usuario);
        $configuracion->setFecha(time());
        
        parent::save($configuracion);
    }

    /*
     * Busca la configuracion si no la encuentra devuelve una nueva.
     */
    private static function BuscarConfig($descripcion)
    {
        $configuracion = new Configuracion(array(
            'descripcion' => $descripcion
        ));

        $configuraciones = parent::search($configuracion);

        if (count($configuraciones) > 0)
        {
            $configuracion = $configuraciones[0];
        }

        return $configuracion;
    }
}