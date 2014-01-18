<?php
/** Value Object file for table inspeccion_consignacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class InspeccionConsignacion extends VO
{
	/**
	  * Constructor de InspeccionConsignacion
	  * 
	  * Para construir un objeto de tipo InspeccionConsignacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return InspeccionConsignacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_inspeccion_consignacion']) ){
				$this->id_inspeccion_consignacion = $data['id_inspeccion_consignacion'];
			}
			if( isset($data['id_consignacion']) ){
				$this->id_consignacion = $data['id_consignacion'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['fecha_inspeccion']) ){
				$this->fecha_inspeccion = $data['fecha_inspeccion'];
			}
			if( isset($data['monto_abonado']) ){
				$this->monto_abonado = $data['monto_abonado'];
			}
			if( isset($data['cancelada']) ){
				$this->cancelada = $data['cancelada'];
			}
			if( isset($data['motivo_cancelacion']) ){
				$this->motivo_cancelacion = $data['motivo_cancelacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto InspeccionConsignacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_inspeccion_consignacion" => $this->id_inspeccion_consignacion,
			"id_consignacion" => $this->id_consignacion,
			"id_usuario" => $this->id_usuario,
			"id_caja" => $this->id_caja,
			"fecha_inspeccion" => $this->fecha_inspeccion,
			"monto_abonado" => $this->monto_abonado,
			"cancelada" => $this->cancelada,
			"motivo_cancelacion" => $this->motivo_cancelacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_inspeccion_consignacion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_inspeccion_consignacion;

	/**
	  * id_consignacion
	  * 
	  * Id de la consignacion a la que se le hace la inspeccion<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_consignacion;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que realiza la inspeccion<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_caja
	  * 
	  * Id de la caja en la que se deposita el monto<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * fecha_inspeccion
	  * 
	  * fecha en que se programa la inspeccion<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_inspeccion;

	/**
	  * monto_abonado
	  * 
	  * Monto abonado a la inspeccion<br>
	  * @access public
	  * @var float
	  */
	public $monto_abonado;

	/**
	  * cancelada
	  * 
	  * Si esta inspeccion sigue programada o se ha cancelado<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelada;

	/**
	  * motivo_cancelacion
	  * 
	  * motivo por el cual se ha cancelado la inspeccion<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo_cancelacion;

	/**
	  * getIdInspeccionConsignacion
	  * 
	  * Get the <i>id_inspeccion_consignacion</i> property for this object. Donde <i>id_inspeccion_consignacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdInspeccionConsignacion()
	{
		return $this->id_inspeccion_consignacion;
	}

	/**
	  * setIdInspeccionConsignacion( $id_inspeccion_consignacion )
	  * 
	  * Set the <i>id_inspeccion_consignacion</i> property for this object. Donde <i>id_inspeccion_consignacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_inspeccion_consignacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdInspeccionConsignacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdInspeccionConsignacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdInspeccionConsignacion( $id_inspeccion_consignacion )
	{
		$this->id_inspeccion_consignacion = $id_inspeccion_consignacion;
	}

	/**
	  * getIdConsignacion
	  * 
	  * Get the <i>id_consignacion</i> property for this object. Donde <i>id_consignacion</i> es Id de la consignacion a la que se le hace la inspeccion
	  * @return int(11)
	  */
	final public function getIdConsignacion()
	{
		return $this->id_consignacion;
	}

	/**
	  * setIdConsignacion( $id_consignacion )
	  * 
	  * Set the <i>id_consignacion</i> property for this object. Donde <i>id_consignacion</i> es Id de la consignacion a la que se le hace la inspeccion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_consignacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdConsignacion( $id_consignacion )
	{
		$this->id_consignacion = $id_consignacion;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza la inspeccion
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza la inspeccion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja en la que se deposita el monto
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja en la que se deposita el monto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getFechaInspeccion
	  * 
	  * Get the <i>fecha_inspeccion</i> property for this object. Donde <i>fecha_inspeccion</i> es fecha en que se programa la inspeccion
	  * @return int(11)
	  */
	final public function getFechaInspeccion()
	{
		return $this->fecha_inspeccion;
	}

	/**
	  * setFechaInspeccion( $fecha_inspeccion )
	  * 
	  * Set the <i>fecha_inspeccion</i> property for this object. Donde <i>fecha_inspeccion</i> es fecha en que se programa la inspeccion.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_inspeccion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaInspeccion( $fecha_inspeccion )
	{
		$this->fecha_inspeccion = $fecha_inspeccion;
	}

	/**
	  * getMontoAbonado
	  * 
	  * Get the <i>monto_abonado</i> property for this object. Donde <i>monto_abonado</i> es Monto abonado a la inspeccion
	  * @return float
	  */
	final public function getMontoAbonado()
	{
		return $this->monto_abonado;
	}

	/**
	  * setMontoAbonado( $monto_abonado )
	  * 
	  * Set the <i>monto_abonado</i> property for this object. Donde <i>monto_abonado</i> es Monto abonado a la inspeccion.
	  * Una validacion basica se hara aqui para comprobar que <i>monto_abonado</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMontoAbonado( $monto_abonado )
	{
		$this->monto_abonado = $monto_abonado;
	}

	/**
	  * getCancelada
	  * 
	  * Get the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si esta inspeccion sigue programada o se ha cancelado
	  * @return tinyint(1)
	  */
	final public function getCancelada()
	{
		return $this->cancelada;
	}

	/**
	  * setCancelada( $cancelada )
	  * 
	  * Set the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si esta inspeccion sigue programada o se ha cancelado.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelada</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelada( $cancelada )
	{
		$this->cancelada = $cancelada;
	}

	/**
	  * getMotivoCancelacion
	  * 
	  * Get the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es motivo por el cual se ha cancelado la inspeccion
	  * @return varchar(255)
	  */
	final public function getMotivoCancelacion()
	{
		return $this->motivo_cancelacion;
	}

	/**
	  * setMotivoCancelacion( $motivo_cancelacion )
	  * 
	  * Set the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es motivo por el cual se ha cancelado la inspeccion.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo_cancelacion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivoCancelacion( $motivo_cancelacion )
	{
		$this->motivo_cancelacion = $motivo_cancelacion;
	}

}
