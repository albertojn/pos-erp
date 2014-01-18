<?php
/** Value Object file for table traspaso.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Traspaso extends VO
{
	/**
	  * Constructor de Traspaso
	  * 
	  * Para construir un objeto de tipo Traspaso debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Traspaso
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_traspaso']) ){
				$this->id_traspaso = $data['id_traspaso'];
			}
			if( isset($data['id_usuario_programa']) ){
				$this->id_usuario_programa = $data['id_usuario_programa'];
			}
			if( isset($data['id_usuario_envia']) ){
				$this->id_usuario_envia = $data['id_usuario_envia'];
			}
			if( isset($data['id_almacen_envia']) ){
				$this->id_almacen_envia = $data['id_almacen_envia'];
			}
			if( isset($data['fecha_envio_programada']) ){
				$this->fecha_envio_programada = $data['fecha_envio_programada'];
			}
			if( isset($data['fecha_envio']) ){
				$this->fecha_envio = $data['fecha_envio'];
			}
			if( isset($data['id_usuario_recibe']) ){
				$this->id_usuario_recibe = $data['id_usuario_recibe'];
			}
			if( isset($data['id_almacen_recibe']) ){
				$this->id_almacen_recibe = $data['id_almacen_recibe'];
			}
			if( isset($data['fecha_recibo']) ){
				$this->fecha_recibo = $data['fecha_recibo'];
			}
			if( isset($data['estado']) ){
				$this->estado = $data['estado'];
			}
			if( isset($data['cancelado']) ){
				$this->cancelado = $data['cancelado'];
			}
			if( isset($data['completo']) ){
				$this->completo = $data['completo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Traspaso en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_traspaso" => $this->id_traspaso,
			"id_usuario_programa" => $this->id_usuario_programa,
			"id_usuario_envia" => $this->id_usuario_envia,
			"id_almacen_envia" => $this->id_almacen_envia,
			"fecha_envio_programada" => $this->fecha_envio_programada,
			"fecha_envio" => $this->fecha_envio,
			"id_usuario_recibe" => $this->id_usuario_recibe,
			"id_almacen_recibe" => $this->id_almacen_recibe,
			"fecha_recibo" => $this->fecha_recibo,
			"estado" => $this->estado,
			"cancelado" => $this->cancelado,
			"completo" => $this->completo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_traspaso
	  * 
	  * Id de la tabla traspaso<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_traspaso;

	/**
	  * id_usuario_programa
	  * 
	  * Id del usuario que programa el traspaso<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_programa;

	/**
	  * id_usuario_envia
	  * 
	  * Id del usuario que envia<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_envia;

	/**
	  * id_almacen_envia
	  * 
	  * Id del almacen que envia los productos<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_almacen_envia;

	/**
	  * fecha_envio_programada
	  * 
	  * Fecha de envio programada para este traspaso<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_envio_programada;

	/**
	  * fecha_envio
	  * 
	  * Fecha en que se envia<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_envio;

	/**
	  * id_usuario_recibe
	  * 
	  * Id del usuario que recibe<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_recibe;

	/**
	  * id_almacen_recibe
	  * 
	  * Id del almacen que recibe los productos<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_almacen_recibe;

	/**
	  * fecha_recibo
	  * 
	  * Fecha en que se recibe el envio<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_recibo;

	/**
	  * estado
	  * 
	  * Si el traspaso esta en solicitud, en envio o si ya fue recibida<br>
	  * @access public
	  * @var enum('Envio
	  */
	public $estado;

	/**
	  * cancelado
	  * 
	  * Si la solicitud de traspaso fue cancelada<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelado;

	/**
	  * completo
	  * 
	  * Verdadero si se enviaron todos los productos solicitados al inicio del traspaso<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $completo;

	/**
	  * getIdTraspaso
	  * 
	  * Get the <i>id_traspaso</i> property for this object. Donde <i>id_traspaso</i> es Id de la tabla traspaso
	  * @return int(11)
	  */
	final public function getIdTraspaso()
	{
		return $this->id_traspaso;
	}

	/**
	  * setIdTraspaso( $id_traspaso )
	  * 
	  * Set the <i>id_traspaso</i> property for this object. Donde <i>id_traspaso</i> es Id de la tabla traspaso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_traspaso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdTraspaso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdTraspaso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdTraspaso( $id_traspaso )
	{
		$this->id_traspaso = $id_traspaso;
	}

	/**
	  * getIdUsuarioPrograma
	  * 
	  * Get the <i>id_usuario_programa</i> property for this object. Donde <i>id_usuario_programa</i> es Id del usuario que programa el traspaso
	  * @return int(11)
	  */
	final public function getIdUsuarioPrograma()
	{
		return $this->id_usuario_programa;
	}

	/**
	  * setIdUsuarioPrograma( $id_usuario_programa )
	  * 
	  * Set the <i>id_usuario_programa</i> property for this object. Donde <i>id_usuario_programa</i> es Id del usuario que programa el traspaso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_programa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioPrograma( $id_usuario_programa )
	{
		$this->id_usuario_programa = $id_usuario_programa;
	}

	/**
	  * getIdUsuarioEnvia
	  * 
	  * Get the <i>id_usuario_envia</i> property for this object. Donde <i>id_usuario_envia</i> es Id del usuario que envia
	  * @return int(11)
	  */
	final public function getIdUsuarioEnvia()
	{
		return $this->id_usuario_envia;
	}

	/**
	  * setIdUsuarioEnvia( $id_usuario_envia )
	  * 
	  * Set the <i>id_usuario_envia</i> property for this object. Donde <i>id_usuario_envia</i> es Id del usuario que envia.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_envia</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioEnvia( $id_usuario_envia )
	{
		$this->id_usuario_envia = $id_usuario_envia;
	}

	/**
	  * getIdAlmacenEnvia
	  * 
	  * Get the <i>id_almacen_envia</i> property for this object. Donde <i>id_almacen_envia</i> es Id del almacen que envia los productos
	  * @return int(11)
	  */
	final public function getIdAlmacenEnvia()
	{
		return $this->id_almacen_envia;
	}

	/**
	  * setIdAlmacenEnvia( $id_almacen_envia )
	  * 
	  * Set the <i>id_almacen_envia</i> property for this object. Donde <i>id_almacen_envia</i> es Id del almacen que envia los productos.
	  * Una validacion basica se hara aqui para comprobar que <i>id_almacen_envia</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdAlmacenEnvia( $id_almacen_envia )
	{
		$this->id_almacen_envia = $id_almacen_envia;
	}

	/**
	  * getFechaEnvioProgramada
	  * 
	  * Get the <i>fecha_envio_programada</i> property for this object. Donde <i>fecha_envio_programada</i> es Fecha de envio programada para este traspaso
	  * @return int(11)
	  */
	final public function getFechaEnvioProgramada()
	{
		return $this->fecha_envio_programada;
	}

	/**
	  * setFechaEnvioProgramada( $fecha_envio_programada )
	  * 
	  * Set the <i>fecha_envio_programada</i> property for this object. Donde <i>fecha_envio_programada</i> es Fecha de envio programada para este traspaso.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_envio_programada</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaEnvioProgramada( $fecha_envio_programada )
	{
		$this->fecha_envio_programada = $fecha_envio_programada;
	}

	/**
	  * getFechaEnvio
	  * 
	  * Get the <i>fecha_envio</i> property for this object. Donde <i>fecha_envio</i> es Fecha en que se envia
	  * @return int(11)
	  */
	final public function getFechaEnvio()
	{
		return $this->fecha_envio;
	}

	/**
	  * setFechaEnvio( $fecha_envio )
	  * 
	  * Set the <i>fecha_envio</i> property for this object. Donde <i>fecha_envio</i> es Fecha en que se envia.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_envio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaEnvio( $fecha_envio )
	{
		$this->fecha_envio = $fecha_envio;
	}

	/**
	  * getIdUsuarioRecibe
	  * 
	  * Get the <i>id_usuario_recibe</i> property for this object. Donde <i>id_usuario_recibe</i> es Id del usuario que recibe
	  * @return int(11)
	  */
	final public function getIdUsuarioRecibe()
	{
		return $this->id_usuario_recibe;
	}

	/**
	  * setIdUsuarioRecibe( $id_usuario_recibe )
	  * 
	  * Set the <i>id_usuario_recibe</i> property for this object. Donde <i>id_usuario_recibe</i> es Id del usuario que recibe.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_recibe</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioRecibe( $id_usuario_recibe )
	{
		$this->id_usuario_recibe = $id_usuario_recibe;
	}

	/**
	  * getIdAlmacenRecibe
	  * 
	  * Get the <i>id_almacen_recibe</i> property for this object. Donde <i>id_almacen_recibe</i> es Id del almacen que recibe los productos
	  * @return int(11)
	  */
	final public function getIdAlmacenRecibe()
	{
		return $this->id_almacen_recibe;
	}

	/**
	  * setIdAlmacenRecibe( $id_almacen_recibe )
	  * 
	  * Set the <i>id_almacen_recibe</i> property for this object. Donde <i>id_almacen_recibe</i> es Id del almacen que recibe los productos.
	  * Una validacion basica se hara aqui para comprobar que <i>id_almacen_recibe</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdAlmacenRecibe( $id_almacen_recibe )
	{
		$this->id_almacen_recibe = $id_almacen_recibe;
	}

	/**
	  * getFechaRecibo
	  * 
	  * Get the <i>fecha_recibo</i> property for this object. Donde <i>fecha_recibo</i> es Fecha en que se recibe el envio
	  * @return int(11)
	  */
	final public function getFechaRecibo()
	{
		return $this->fecha_recibo;
	}

	/**
	  * setFechaRecibo( $fecha_recibo )
	  * 
	  * Set the <i>fecha_recibo</i> property for this object. Donde <i>fecha_recibo</i> es Fecha en que se recibe el envio.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_recibo</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaRecibo( $fecha_recibo )
	{
		$this->fecha_recibo = $fecha_recibo;
	}

	/**
	  * getEstado
	  * 
	  * Get the <i>estado</i> property for this object. Donde <i>estado</i> es Si el traspaso esta en solicitud, en envio o si ya fue recibida
	  * @return enum('Envio
	  */
	final public function getEstado()
	{
		return $this->estado;
	}

	/**
	  * setEstado( $estado )
	  * 
	  * Set the <i>estado</i> property for this object. Donde <i>estado</i> es Si el traspaso esta en solicitud, en envio o si ya fue recibida.
	  * Una validacion basica se hara aqui para comprobar que <i>estado</i> es de tipo <i>enum('Envio</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('Envio
	  */
	final public function setEstado( $estado )
	{
		$this->estado = $estado;
	}

	/**
	  * getCancelado
	  * 
	  * Get the <i>cancelado</i> property for this object. Donde <i>cancelado</i> es Si la solicitud de traspaso fue cancelada
	  * @return tinyint(1)
	  */
	final public function getCancelado()
	{
		return $this->cancelado;
	}

	/**
	  * setCancelado( $cancelado )
	  * 
	  * Set the <i>cancelado</i> property for this object. Donde <i>cancelado</i> es Si la solicitud de traspaso fue cancelada.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelado</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelado( $cancelado )
	{
		$this->cancelado = $cancelado;
	}

	/**
	  * getCompleto
	  * 
	  * Get the <i>completo</i> property for this object. Donde <i>completo</i> es Verdadero si se enviaron todos los productos solicitados al inicio del traspaso
	  * @return tinyint(1)
	  */
	final public function getCompleto()
	{
		return $this->completo;
	}

	/**
	  * setCompleto( $completo )
	  * 
	  * Set the <i>completo</i> property for this object. Donde <i>completo</i> es Verdadero si se enviaron todos los productos solicitados al inicio del traspaso.
	  * Una validacion basica se hara aqui para comprobar que <i>completo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCompleto( $completo )
	{
		$this->completo = $completo;
	}

}
