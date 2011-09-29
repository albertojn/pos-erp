<?php

require_once("success.php");

/**
 * Archivo que contiene la clase ExpedidoPor la cual provee de los medios necesarios para validar
 * la estructura de los datos generales del formato de solicitud de factura electronica
 */
class ExpedidoPor {

    /**
     * Nombre de la clase
     * @var String Nombre de la clase
     */
    private $type = "ExpedidoPor";

    /**
     * Regresa el nombre de esta clase
     * @return String Nombde de la clase
     */
    public function getType() {
        return $this->type;
    }

    /**
     *
     * @var <type>
     */
    private $calle = null;

    /**
     *
     * @return <type>
     */
    public function getCalle() {
        return $this->calle;
    }

    /**
     *
     * @param <type> $param
     */
    public function setCalle($param) {
        $this->calle = $param;
    }

    /**
     *
     * @var <type>
     */
    private $numero_exterior = null;

    /**
     *
     * @return <type>
     */
    public function getNumeroExterior() {
        return $this->numero_exterior;
    }

    /**
     *
     * @param <type> $param
     */
    public function setNumeroExterior($param) {
        $this->numero_exterior = $param;
    }

    /**
     *
     * @var <type>
     */
    private $numero_interior = null;

    /**
     *
     * @return <type>
     */
    public function getNumeroInterior() {
        return $this->numero_interior;
    }

    /**
     *
     * @param <type> $param
     */
    public function setNumeroInterior($param) {
        $this->numero_interior = $param;
    }

    /**
     *
     * @var <type>
     */
    private $colonia = null;

    /**
     *
     * @return <type>
     */
    public function getColonia() {
        return $this->colonia;
    }

    /**
     *
     * @param <type> $param
     */
    public function setColonia($param) {
        $this->colonia = $param;
    }

    /**
     *
     * @var <type>
     */
    private $localidad = null;

    /**
     *
     * @return <type>
     */
    public function getLocalidad() {
        return $this->localidad;
    }

    /**
     *
     * @param <type> $param
     */
    public function setLocalidad($param) {
        $this->localidad = $param;
    }

    /**
     *
     * @var <type>
     */
    private $referencia = null;

    /**
     *
     * @return <type>
     */
    public function getReferencia() {
        return $this->referencia;
    }

    /**
     *
     * @param <type> $param
     */
    public function setReferencia($param) {
        $this->referencia = $param;
    }

    /**
     *
     * @var <type>
     */
    private $municipio = null;

    /**
     *
     * @return <type>
     */
    public function getMunicipio() {
        return $this->municipio;
    }

    /**
     *
     * @param <type> $param
     */
    public function setMunicipio($param) {
        $this->municipio = $param;
    }

    /**
     *
     * @var <type>
     */
    private $estado = null;

    /**
     *
     * @return <type>
     */
    public function getEstado() {
        return $this->estado;
    }

    /**
     *
     * @param <type> $param
     */
    public function setEstado($param) {
        $this->estado = $param;
    }

    /**
     *
     * @var <type>
     */
    private $pais = null;

    /**
     *
     * @return <type>
     */
    public function getPais() {
        return $this->pais;
    }

    /**
     *
     * @param <type> $param
     */
    public function setPais($param) {
        $this->pais = $param;
    }

    /**
     *
     * @var <type>
     */
    private $codigo_postal = null;

    /**
     *
     * @return <type>
     */
    public function getCodigoPostal() {
        return $this->codigo_postal;
    }

    /**
     *
     * @param <type> $param
     */
    public function setCodigoPostal($param) {
        $this->codigo_postal = $param;
    }

    /**
     * Contiene informacion acerca de posibles errores
     * @var String
     */
    private $error = "";

    /**
     *
     * @return <type>
     */
    public function getError() {
        return $this->error;
    }

    /**
     *
     * @param <type> $param
     */
    public function setError($param) {
        $this->error = $param;
    }

    /**
     *
     */
    public function __construct() {

    }

    /**
     * Verifica que el objeto contenga toda la informacion necesaria
     * @return Object Success
     */
    public function isValid() {

        //verificamos si existe la calle
        if (!($this->getCalle() != null && $this->getCalle() != "")) {
            $this->setError("No se ha definido la calle de la sucursal.");
        }

        //verificamos si existe el numero exterior
        if (!($this->getNumeroExterior() != null && $this->getNumeroExterior() != "")) {
            $this->setError("No se ha definido el nuemro exterior de la sucursal.");
        }

        //verificamos si existe la colonia
        if (!($this->getColonia() != null && $this->getColonia() != "")) {
            $this->setError("No se ha definido la colonia de la sucursal.");
        }

        //verificamos si existe el municipio
        if (!($this->getMunicipio() != null && $this->getMunicipio() != "")) {
            $this->setError("No se ha definido el municipio de la sucursal.");
        }

        //verificamos si existe el estado
        if (!($this->getEstado() != null && $this->getEstado() != "")) {
            $this->setError("No se ha definido el estado de la sucursal.");
        }

        //verificamos si existe el codigo postal
        if (!($this->getCodigoPostal() != null && $this->getCodigoPostal() != "")) {
            $this->setError("No se ha definido el codigo postal de la sucursal.");
        }

        //verificamos si existe el pais
        if (!($this->getPais() != null && $this->getPais() != "")) {
            $this->setError("No se ha definido el pais de la sucursal.");
        }

        $this->success = new Success($this->getError());
        return $this->success;
    }

}

?>