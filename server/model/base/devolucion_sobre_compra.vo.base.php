<?php
/** Value Object file for table devolucion_sobre_compra.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class DevolucionSobreCompra extends VO
{
	/**
	  * Constructor de DevolucionSobreCompra
	  * 
	  * Para construir un objeto de tipo DevolucionSobreCompra debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return DevolucionSobreCompra
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_devolucion_sobre_compra']) ){
				$this->id_devolucion_sobre_compra = $data['id_devolucion_sobre_compra'];
			}
			if( isset($data['id_compra']) ){
				$this->id_compra = $data['id_compra'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['motivo']) ){
				$this->motivo = $data['motivo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto DevolucionSobreCompra en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_devolucion_sobre_compra" => $this->id_devolucion_sobre_compra,
			"id_compra" => $this->id_compra,
			"id_usuario" => $this->id_usuario,
			"fecha" => $this->fecha,
			"motivo" => $this->motivo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_devolucion_sobre_compra
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_devolucion_sobre_compra;

	/**
	  * id_compra
	  * 
	  * Id de la compra a cancelar<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_compra;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que realiza la devolucion<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * fecha
	  * 
	  * Fecha en que se realiza la devolucion<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * motivo
	  * 
	  * Motivo por el cual se realiza la devolucion<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo;

	/**
	  * getIdDevolucionSobreCompra
	  * 
	  * Get the <i>id_devolucion_sobre_compra</i> property for this object. Donde <i>id_devolucion_sobre_compra</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdDevolucionSobreCompra()
	{
		return $this->id_devolucion_sobre_compra;
	}

	/**
	  * setIdDevolucionSobreCompra( $id_devolucion_sobre_compra )
	  * 
	  * Set the <i>id_devolucion_sobre_compra</i> property for this object. Donde <i>id_devolucion_sobre_compra</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_devolucion_sobre_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdDevolucionSobreCompra( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdDevolucionSobreCompra( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdDevolucionSobreCompra( $id_devolucion_sobre_compra )
	{
		$this->id_devolucion_sobre_compra = $id_devolucion_sobre_compra;
	}

	/**
	  * getIdCompra
	  * 
	  * Get the <i>id_compra</i> property for this object. Donde <i>id_compra</i> es Id de la compra a cancelar
	  * @return int(11)
	  */
	final public function getIdCompra()
	{
		return $this->id_compra;
	}

	/**
	  * setIdCompra( $id_compra )
	  * 
	  * Set the <i>id_compra</i> property for this object. Donde <i>id_compra</i> es Id de la compra a cancelar.
	  * Una validacion basica se hara aqui para comprobar que <i>id_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCompra( $id_compra )
	{
		$this->id_compra = $id_compra;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza la devolucion
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza la devolucion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realiza la devolucion
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realiza la devolucion.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getMotivo
	  * 
	  * Get the <i>motivo</i> property for this object. Donde <i>motivo</i> es Motivo por el cual se realiza la devolucion
	  * @return varchar(255)
	  */
	final public function getMotivo()
	{
		return $this->motivo;
	}

	/**
	  * setMotivo( $motivo )
	  * 
	  * Set the <i>motivo</i> property for this object. Donde <i>motivo</i> es Motivo por el cual se realiza la devolucion.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivo( $motivo )
	{
		$this->motivo = $motivo;
	}

}
