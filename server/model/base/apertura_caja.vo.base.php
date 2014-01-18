<?php
/** Value Object file for table apertura_caja.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class AperturaCaja extends VO
{
	/**
	  * Constructor de AperturaCaja
	  * 
	  * Para construir un objeto de tipo AperturaCaja debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return AperturaCaja
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_apertura_caja']) ){
				$this->id_apertura_caja = $data['id_apertura_caja'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['saldo']) ){
				$this->saldo = $data['saldo'];
			}
			if( isset($data['id_cajero']) ){
				$this->id_cajero = $data['id_cajero'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto AperturaCaja en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_apertura_caja" => $this->id_apertura_caja,
			"id_caja" => $this->id_caja,
			"fecha" => $this->fecha,
			"saldo" => $this->saldo,
			"id_cajero" => $this->id_cajero
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_apertura_caja
	  * 
	  * ID de la apertura de la caja<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_apertura_caja;

	/**
	  * id_caja
	  * 
	  * Id de la caja que se abre<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * fecha
	  * 
	  * Fecha en que se realizo la apertura de caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * saldo
	  * 
	  * Saldo con que inicia operaciones la caja<br>
	  * @access public
	  * @var float
	  */
	public $saldo;

	/**
	  * id_cajero
	  * 
	  * Id del usuario que realizarÃƒÆ’Ã‚Â¡ las funciones de cajero<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cajero;

	/**
	  * getIdAperturaCaja
	  * 
	  * Get the <i>id_apertura_caja</i> property for this object. Donde <i>id_apertura_caja</i> es ID de la apertura de la caja
	  * @return int(11)
	  */
	final public function getIdAperturaCaja()
	{
		return $this->id_apertura_caja;
	}

	/**
	  * setIdAperturaCaja( $id_apertura_caja )
	  * 
	  * Set the <i>id_apertura_caja</i> property for this object. Donde <i>id_apertura_caja</i> es ID de la apertura de la caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_apertura_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdAperturaCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAperturaCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAperturaCaja( $id_apertura_caja )
	{
		$this->id_apertura_caja = $id_apertura_caja;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja que se abre
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja que se abre.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realizo la apertura de caja
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realizo la apertura de caja.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getSaldo
	  * 
	  * Get the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo con que inicia operaciones la caja
	  * @return float
	  */
	final public function getSaldo()
	{
		return $this->saldo;
	}

	/**
	  * setSaldo( $saldo )
	  * 
	  * Set the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo con que inicia operaciones la caja.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldo( $saldo )
	{
		$this->saldo = $saldo;
	}

	/**
	  * getIdCajero
	  * 
	  * Get the <i>id_cajero</i> property for this object. Donde <i>id_cajero</i> es Id del usuario que realizarÃƒÆ’Ã‚Â¡ las funciones de cajero
	  * @return int(11)
	  */
	final public function getIdCajero()
	{
		return $this->id_cajero;
	}

	/**
	  * setIdCajero( $id_cajero )
	  * 
	  * Set the <i>id_cajero</i> property for this object. Donde <i>id_cajero</i> es Id del usuario que realizarÃƒÆ’Ã‚Â¡ las funciones de cajero.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cajero</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCajero( $id_cajero )
	{
		$this->id_cajero = $id_cajero;
	}

}
