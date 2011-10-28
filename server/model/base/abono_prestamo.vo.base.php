<?php
/** Value Object file for table abono_prestamo.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Andres
  * @access public
  * @package docs
  * 
  */

class AbonoPrestamo extends VO
{
	/**
	  * Constructor de AbonoPrestamo
	  * 
	  * Para construir un objeto de tipo AbonoPrestamo debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return AbonoPrestamo
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_abono_prestamo']) ){
				$this->id_abono_prestamo = $data['id_abono_prestamo'];
			}
			if( isset($data['id_prestamo']) ){
				$this->id_prestamo = $data['id_prestamo'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['monto']) ){
				$this->monto = $data['monto'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['id_deudor']) ){
				$this->id_deudor = $data['id_deudor'];
			}
			if( isset($data['id_receptor']) ){
				$this->id_receptor = $data['id_receptor'];
			}
			if( isset($data['nota']) ){
				$this->nota = $data['nota'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['tipo_de_pago']) ){
				$this->tipo_de_pago = $data['tipo_de_pago'];
			}
			if( isset($data['cancelado']) ){
				$this->cancelado = $data['cancelado'];
			}
			if( isset($data['motivo_cancelacion']) ){
				$this->motivo_cancelacion = $data['motivo_cancelacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto AbonoPrestamo en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_abono_prestamo" => $this->id_abono_prestamo,
			"id_prestamo" => $this->id_prestamo,
			"id_sucursal" => $this->id_sucursal,
			"monto" => $this->monto,
			"id_caja" => $this->id_caja,
			"id_deudor" => $this->id_deudor,
			"id_receptor" => $this->id_receptor,
			"nota" => $this->nota,
			"fecha" => $this->fecha,
			"tipo_de_pago" => $this->tipo_de_pago,
			"cancelado" => $this->cancelado,
			"motivo_cancelacion" => $this->motivo_cancelacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_abono_prestamo
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_abono_prestamo;

	/**
	  * id_prestamo
	  * 
	  * Id prestamo al que se le abona<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_prestamo;

	/**
	  * id_sucursal
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * monto
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var float
	  */
	public $monto;

	/**
	  * id_caja
	  * 
	  * Id de la caja donde se registra el abono<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * id_deudor
	  * 
	  * Id del usuario que abona<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_deudor;

	/**
	  * id_receptor
	  * 
	  * Id del usuario que registra el abono<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_receptor;

	/**
	  * nota
	  * 
	  * Nota del abono<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $nota;

	/**
	  * fecha
	  * 
	  * Fecha en que se realiza el abono<br>
	  * @access public
	  * @var datetime
	  */
	public $fecha;

	/**
	  * tipo_de_pago
	  * 
	  * Si el tipo de pago es con tarjeta, con cheque, o en efectivo<br>
	  * @access public
	  * @var enum('cheque','tarjeta','efectivo')
	  */
	public $tipo_de_pago;

	/**
	  * cancelado
	  * 
	  * Si este abono es cancelado<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelado;

	/**
	  * motivo_cancelacion
	  * 
	  * Motivo por el cual se realiza la cancelacion<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo_cancelacion;

	/**
	  * getIdAbonoPrestamo
	  * 
	  * Get the <i>id_abono_prestamo</i> property for this object. Donde <i>id_abono_prestamo</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdAbonoPrestamo()
	{
		return $this->id_abono_prestamo;
	}

	/**
	  * setIdAbonoPrestamo( $id_abono_prestamo )
	  * 
	  * Set the <i>id_abono_prestamo</i> property for this object. Donde <i>id_abono_prestamo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_abono_prestamo</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdAbonoPrestamo( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAbonoPrestamo( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAbonoPrestamo( $id_abono_prestamo )
	{
		$this->id_abono_prestamo = $id_abono_prestamo;
	}

	/**
	  * getIdPrestamo
	  * 
	  * Get the <i>id_prestamo</i> property for this object. Donde <i>id_prestamo</i> es Id prestamo al que se le abona
	  * @return int(11)
	  */
	final public function getIdPrestamo()
	{
		return $this->id_prestamo;
	}

	/**
	  * setIdPrestamo( $id_prestamo )
	  * 
	  * Set the <i>id_prestamo</i> property for this object. Donde <i>id_prestamo</i> es Id prestamo al que se le abona.
	  * Una validacion basica se hara aqui para comprobar que <i>id_prestamo</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdPrestamo( $id_prestamo )
	{
		$this->id_prestamo = $id_prestamo;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getMonto
	  * 
	  * Get the <i>monto</i> property for this object. Donde <i>monto</i> es  [Campo no documentado]
	  * @return float
	  */
	final public function getMonto()
	{
		return $this->monto;
	}

	/**
	  * setMonto( $monto )
	  * 
	  * Set the <i>monto</i> property for this object. Donde <i>monto</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>monto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMonto( $monto )
	{
		$this->monto = $monto;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja donde se registra el abono
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja donde se registra el abono.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getIdDeudor
	  * 
	  * Get the <i>id_deudor</i> property for this object. Donde <i>id_deudor</i> es Id del usuario que abona
	  * @return int(11)
	  */
	final public function getIdDeudor()
	{
		return $this->id_deudor;
	}

	/**
	  * setIdDeudor( $id_deudor )
	  * 
	  * Set the <i>id_deudor</i> property for this object. Donde <i>id_deudor</i> es Id del usuario que abona.
	  * Una validacion basica se hara aqui para comprobar que <i>id_deudor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdDeudor( $id_deudor )
	{
		$this->id_deudor = $id_deudor;
	}

	/**
	  * getIdReceptor
	  * 
	  * Get the <i>id_receptor</i> property for this object. Donde <i>id_receptor</i> es Id del usuario que registra el abono
	  * @return int(11)
	  */
	final public function getIdReceptor()
	{
		return $this->id_receptor;
	}

	/**
	  * setIdReceptor( $id_receptor )
	  * 
	  * Set the <i>id_receptor</i> property for this object. Donde <i>id_receptor</i> es Id del usuario que registra el abono.
	  * Una validacion basica se hara aqui para comprobar que <i>id_receptor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdReceptor( $id_receptor )
	{
		$this->id_receptor = $id_receptor;
	}

	/**
	  * getNota
	  * 
	  * Get the <i>nota</i> property for this object. Donde <i>nota</i> es Nota del abono
	  * @return varchar(255)
	  */
	final public function getNota()
	{
		return $this->nota;
	}

	/**
	  * setNota( $nota )
	  * 
	  * Set the <i>nota</i> property for this object. Donde <i>nota</i> es Nota del abono.
	  * Una validacion basica se hara aqui para comprobar que <i>nota</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setNota( $nota )
	{
		$this->nota = $nota;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realiza el abono
	  * @return datetime
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realiza el abono.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>datetime</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param datetime
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getTipoDePago
	  * 
	  * Get the <i>tipo_de_pago</i> property for this object. Donde <i>tipo_de_pago</i> es Si el tipo de pago es con tarjeta, con cheque, o en efectivo
	  * @return enum('cheque','tarjeta','efectivo')
	  */
	final public function getTipoDePago()
	{
		return $this->tipo_de_pago;
	}

	/**
	  * setTipoDePago( $tipo_de_pago )
	  * 
	  * Set the <i>tipo_de_pago</i> property for this object. Donde <i>tipo_de_pago</i> es Si el tipo de pago es con tarjeta, con cheque, o en efectivo.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_de_pago</i> es de tipo <i>enum('cheque','tarjeta','efectivo')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('cheque','tarjeta','efectivo')
	  */
	final public function setTipoDePago( $tipo_de_pago )
	{
		$this->tipo_de_pago = $tipo_de_pago;
	}

	/**
	  * getCancelado
	  * 
	  * Get the <i>cancelado</i> property for this object. Donde <i>cancelado</i> es Si este abono es cancelado
	  * @return tinyint(1)
	  */
	final public function getCancelado()
	{
		return $this->cancelado;
	}

	/**
	  * setCancelado( $cancelado )
	  * 
	  * Set the <i>cancelado</i> property for this object. Donde <i>cancelado</i> es Si este abono es cancelado.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelado</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelado( $cancelado )
	{
		$this->cancelado = $cancelado;
	}

	/**
	  * getMotivoCancelacion
	  * 
	  * Get the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Motivo por el cual se realiza la cancelacion
	  * @return varchar(255)
	  */
	final public function getMotivoCancelacion()
	{
		return $this->motivo_cancelacion;
	}

	/**
	  * setMotivoCancelacion( $motivo_cancelacion )
	  * 
	  * Set the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Motivo por el cual se realiza la cancelacion.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo_cancelacion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivoCancelacion( $motivo_cancelacion )
	{
		$this->motivo_cancelacion = $motivo_cancelacion;
	}

}
