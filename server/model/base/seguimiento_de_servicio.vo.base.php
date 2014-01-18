<?php
/** Value Object file for table seguimiento_de_servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class SeguimientoDeServicio extends VO
{
	/**
	  * Constructor de SeguimientoDeServicio
	  * 
	  * Para construir un objeto de tipo SeguimientoDeServicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return SeguimientoDeServicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_seguimiento_de_servicio']) ){
				$this->id_seguimiento_de_servicio = $data['id_seguimiento_de_servicio'];
			}
			if( isset($data['id_orden_de_servicio']) ){
				$this->id_orden_de_servicio = $data['id_orden_de_servicio'];
			}
			if( isset($data['id_localizacion']) ){
				$this->id_localizacion = $data['id_localizacion'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['estado']) ){
				$this->estado = $data['estado'];
			}
			if( isset($data['fecha_seguimiento']) ){
				$this->fecha_seguimiento = $data['fecha_seguimiento'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto SeguimientoDeServicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_seguimiento_de_servicio" => $this->id_seguimiento_de_servicio,
			"id_orden_de_servicio" => $this->id_orden_de_servicio,
			"id_localizacion" => $this->id_localizacion,
			"id_usuario" => $this->id_usuario,
			"id_sucursal" => $this->id_sucursal,
			"estado" => $this->estado,
			"fecha_seguimiento" => $this->fecha_seguimiento
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_seguimiento_de_servicio
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_seguimiento_de_servicio;

	/**
	  * id_orden_de_servicio
	  * 
	  * Id orden de servicio a la que se le realiza el seguimiento<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_orden_de_servicio;

	/**
	  * id_localizacion
	  * 
	  * Id de la sucursal en la que se encuentra el servicio actualmente<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_localizacion;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que realiza el seguimiento<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_sucursal
	  * 
	  * Id de la sucursal de donde se realiza el seguimiento<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * estado
	  * 
	  * Estado en la que se encuentra la orden<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $estado;

	/**
	  * fecha_seguimiento
	  * 
	  * Fecha en la que se realizo el seguimiento<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_seguimiento;

	/**
	  * getIdSeguimientoDeServicio
	  * 
	  * Get the <i>id_seguimiento_de_servicio</i> property for this object. Donde <i>id_seguimiento_de_servicio</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSeguimientoDeServicio()
	{
		return $this->id_seguimiento_de_servicio;
	}

	/**
	  * setIdSeguimientoDeServicio( $id_seguimiento_de_servicio )
	  * 
	  * Set the <i>id_seguimiento_de_servicio</i> property for this object. Donde <i>id_seguimiento_de_servicio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_seguimiento_de_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdSeguimientoDeServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdSeguimientoDeServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdSeguimientoDeServicio( $id_seguimiento_de_servicio )
	{
		$this->id_seguimiento_de_servicio = $id_seguimiento_de_servicio;
	}

	/**
	  * getIdOrdenDeServicio
	  * 
	  * Get the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es Id orden de servicio a la que se le realiza el seguimiento
	  * @return int(11)
	  */
	final public function getIdOrdenDeServicio()
	{
		return $this->id_orden_de_servicio;
	}

	/**
	  * setIdOrdenDeServicio( $id_orden_de_servicio )
	  * 
	  * Set the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es Id orden de servicio a la que se le realiza el seguimiento.
	  * Una validacion basica se hara aqui para comprobar que <i>id_orden_de_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdOrdenDeServicio( $id_orden_de_servicio )
	{
		$this->id_orden_de_servicio = $id_orden_de_servicio;
	}

	/**
	  * getIdLocalizacion
	  * 
	  * Get the <i>id_localizacion</i> property for this object. Donde <i>id_localizacion</i> es Id de la sucursal en la que se encuentra el servicio actualmente
	  * @return int(11)
	  */
	final public function getIdLocalizacion()
	{
		return $this->id_localizacion;
	}

	/**
	  * setIdLocalizacion( $id_localizacion )
	  * 
	  * Set the <i>id_localizacion</i> property for this object. Donde <i>id_localizacion</i> es Id de la sucursal en la que se encuentra el servicio actualmente.
	  * Una validacion basica se hara aqui para comprobar que <i>id_localizacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdLocalizacion( $id_localizacion )
	{
		$this->id_localizacion = $id_localizacion;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza el seguimiento
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza el seguimiento.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es Id de la sucursal de donde se realiza el seguimiento
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es Id de la sucursal de donde se realiza el seguimiento.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getEstado
	  * 
	  * Get the <i>estado</i> property for this object. Donde <i>estado</i> es Estado en la que se encuentra la orden
	  * @return varchar(255)
	  */
	final public function getEstado()
	{
		return $this->estado;
	}

	/**
	  * setEstado( $estado )
	  * 
	  * Set the <i>estado</i> property for this object. Donde <i>estado</i> es Estado en la que se encuentra la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>estado</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setEstado( $estado )
	{
		$this->estado = $estado;
	}

	/**
	  * getFechaSeguimiento
	  * 
	  * Get the <i>fecha_seguimiento</i> property for this object. Donde <i>fecha_seguimiento</i> es Fecha en la que se realizo el seguimiento
	  * @return int(11)
	  */
	final public function getFechaSeguimiento()
	{
		return $this->fecha_seguimiento;
	}

	/**
	  * setFechaSeguimiento( $fecha_seguimiento )
	  * 
	  * Set the <i>fecha_seguimiento</i> property for this object. Donde <i>fecha_seguimiento</i> es Fecha en la que se realizo el seguimiento.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_seguimiento</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaSeguimiento( $fecha_seguimiento )
	{
		$this->fecha_seguimiento = $fecha_seguimiento;
	}

}
