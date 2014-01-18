<?php

require_once ('Estructura.php');
require_once("base/empresa.dao.base.php");
require_once("base/empresa.vo.base.php");
/** Page-level DocBlock .
  * 
  * @author Andres
  * @package docs
  * 
  */
/** Empresa Data Access Object (DAO).
  * 
  * Esta clase contiene toda la manipulacion de bases de datos que se necesita para 
  * almacenar de forma permanente y recuperar instancias de objetos {@link Empresa }. 
  * @author Andres
  * @access public
  * @package docs
  * 
  */
class EmpresaDAO extends EmpresaDAOBase
{

    public function getByRFC( $rfc ){
        return self::search( new Empresa( array( "rfc" => $rfc ) ) );
    }

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
    public function buscar($activa, $limit, $order, $order_by, $query, $start)
    {
        global $conn;

        $sql = "SELECT * FROM empresa "
             . ($activa === true || $query !== NULL ? "WHERE " . ($activa === true ? "activo = " . (int) $activa . " " . ($query !== NULL ? "AND " : "") : "") . ($query !== NULL ? " rfc LIKE '%{$query}%' OR razon_social LIKE '%{$query}%' OR representante_legal LIKE '%{$query}%' OR direccion_web LIKE '%{$query}%' OR cedula LIKE '%{$query}%'" : "") : "")
             . "ORDER BY {$order_by} {$order} "
             . ($limit === NULL ? "" : ($start !== NULL ? " LIMIT {$start}, {$limit}" : "LIMIT {$limit}"));

        $res = $conn->GetAssoc($sql, false, false, false);

        $a = array();

        foreach ($res as $v) {
            array_push($a, $v);
        }

        return $a;
    }

    /**
     * getMonedaBase($id_empresa)
     *
     * Obtiene la moneda base de una empresa
     *
     * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
     * @param params array Contiene lso parametros que se desean pasar a la consulta
     * @return array Arreglo aosciatico con las propiedades de la moneda base
     **/
    public function getMonedaBase($id_empresa)
	{
		global $conn;

		$params = array("id_moneda_base", $id_empresa);

		$sql = "SELECT" 
			 . "	moneda.id_moneda, moneda.nombre, moneda.simbolo "
			 . "FROM"
			 . "	empresa JOIN configuracion_empresa ON (empresa.id_empresa = configuracion_empresa.id_empresa) "
			 . "	JOIN configuracion ON (configuracion_empresa.id_configuracion = configuracion.id_configuracion  AND configuracion.descripcion = ?) "
			 . "	JOIN moneda ON (moneda.id_moneda = configuracion.valor) "
			 . "WHERE"
			 . "	empresa.id_empresa = ?";

		$res = $conn->Execute($sql, $params);

		$a = array();

		foreach ($res as $v) {
			array_push($a, $v);
		}

		return $a[0];
	}

	/**
     * getEjercicioActual($id_empresa)
     *
     * Obtiene informacion sobre el ejercicio de una empresa
     *
     * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
     * @param params array Contiene lso parametros que se desean pasar a la consulta
     * @return array Arreglo aosciatico con las propiedades de la moneda base
     **/
    public function getEjercicioActual($id_empresa)
	{
		global $conn;

		$params = array($id_empresa);

		$sql = "SELECT "
			 . "	ejercicio.id_ejercicio, ejercicio.anio, ejercicio.id_periodo, ejercicio.inicio as 'ejercicio_inicio', ejercicio.fin as 'ejercicio_fin', ejercicio.vigente, "
			 . "	periodo.periodo, periodo.inicio as 'periodo_inicio', periodo.fin as 'periodo_fin'"
			 . "FROM "
			 . "	empresa JOIN ejercicio_empresa "
			 . "		ON (empresa.id_empresa = ejercicio_empresa.id_empresa AND empresa.id_empresa = ?) "
			 . "	JOIN ejercicio ON (ejercicio_empresa.id_ejercicio = ejercicio.id_ejercicio) "
			 . "	JOIN periodo ON (periodo.id_periodo = ejercicio.id_periodo)";

		$res = $conn->Execute($sql, $params);

		$a = array();

		foreach ($res as $v) {
			array_push($a, $v);
		}

		return $a[0];
	}

}
