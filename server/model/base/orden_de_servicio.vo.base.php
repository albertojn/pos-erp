<?php
/** Value Object file for table orden_de_servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class OrdenDeServicio extends VO
{
	/**
	  * Constructor de OrdenDeServicio
	  * 
	  * Para construir un objeto de tipo OrdenDeServicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return OrdenDeServicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_orden_de_servicio']) ){
				$this->id_orden_de_servicio = $data['id_orden_de_servicio'];
			}
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
			if( isset($data['id_usuario_venta']) ){
				$this->id_usuario_venta = $data['id_usuario_venta'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_usuario_asignado']) ){
				$this->id_usuario_asignado = $data['id_usuario_asignado'];
			}
			if( isset($data['fecha_orden']) ){
				$this->fecha_orden = $data['fecha_orden'];
			}
			if( isset($data['fecha_entrega']) ){
				$this->fecha_entrega = $data['fecha_entrega'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['cancelada']) ){
				$this->cancelada = $data['cancelada'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['motivo_cancelacion']) ){
				$this->motivo_cancelacion = $data['motivo_cancelacion'];
			}
			if( isset($data['adelanto']) ){
				$this->adelanto = $data['adelanto'];
			}
			if( isset($data['precio']) ){
				$this->precio = $data['precio'];
			}
			if( isset($data['extra_params']) ){
				$this->extra_params = $data['extra_params'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto OrdenDeServicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_orden_de_servicio" => $this->id_orden_de_servicio,
			"id_servicio" => $this->id_servicio,
			"id_usuario_venta" => $this->id_usuario_venta,
			"id_usuario" => $this->id_usuario,
			"id_usuario_asignado" => $this->id_usuario_asignado,
			"fecha_orden" => $this->fecha_orden,
			"fecha_entrega" => $this->fecha_entrega,
			"activa" => $this->activa,
			"cancelada" => $this->cancelada,
			"descripcion" => $this->descripcion,
			"motivo_cancelacion" => $this->motivo_cancelacion,
			"adelanto" => $this->adelanto,
			"precio" => $this->precio,
			"extra_params" => $this->extra_params
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_orden_de_servicio
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_orden_de_servicio;

	/**
	  * id_servicio
	  * 
	  * Id del servicio entregado<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_servicio;

	/**
	  * id_usuario_venta
	  * 
	  * Id del usuario al que se le relaiza la orden<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_venta;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que realiza la orden<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_usuario_asignado
	  * 
	  * Id del usuario que tiene asignada esta orden (responsable)<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_asignado;

	/**
	  * fecha_orden
	  * 
	  * fecha en la que se realiza la orden<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_orden;

	/**
	  * fecha_entrega
	  * 
	  * fecha en la que se entrega la orden<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_entrega;

	/**
	  * activa
	  * 
	  * Si la orden esta activa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * cancelada
	  * 
	  * Si la orden esta cancelada<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelada;

	/**
	  * descripcion
	  * 
	  * Descripcion de la orden<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * motivo_cancelacion
	  * 
	  * Motivo por la cual fue cancelada la orden<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo_cancelacion;

	/**
	  * adelanto
	  * 
	  * Cantidad de dinero pagada por adelantado<br>
	  * @access public
	  * @var float
	  */
	public $adelanto;

	/**
	  * precio
	  * 
	  * El precio de esta orden de servicio<br>
	  * @access public
	  * @var float
	  */
	public $precio;

	/**
	  * extra_params
	  * 
	  * Un json con valores extra que se necesitan llenar<br>
	  * @access public
	  * @var text
	  */
	public $extra_params;

	/**
	  * getIdOrdenDeServicio
	  * 
	  * Get the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdOrdenDeServicio()
	{
		return $this->id_orden_de_servicio;
	}

	/**
	  * setIdOrdenDeServicio( $id_orden_de_servicio )
	  * 
	  * Set the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_orden_de_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdOrdenDeServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdOrdenDeServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdOrdenDeServicio( $id_orden_de_servicio )
	{
		$this->id_orden_de_servicio = $id_orden_de_servicio;
	}

	/**
	  * getIdServicio
	  * 
	  * Get the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio entregado
	  * @return int(11)
	  */
	final public function getIdServicio()
	{
		return $this->id_servicio;
	}

	/**
	  * setIdServicio( $id_servicio )
	  * 
	  * Set the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio entregado.
	  * Una validacion basica se hara aqui para comprobar que <i>id_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdServicio( $id_servicio )
	{
		$this->id_servicio = $id_servicio;
	}

	/**
	  * getIdUsuarioVenta
	  * 
	  * Get the <i>id_usuario_venta</i> property for this object. Donde <i>id_usuario_venta</i> es Id del usuario al que se le relaiza la orden
	  * @return int(11)
	  */
	final public function getIdUsuarioVenta()
	{
		return $this->id_usuario_venta;
	}

	/**
	  * setIdUsuarioVenta( $id_usuario_venta )
	  * 
	  * Set the <i>id_usuario_venta</i> property for this object. Donde <i>id_usuario_venta</i> es Id del usuario al que se le relaiza la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioVenta( $id_usuario_venta )
	{
		$this->id_usuario_venta = $id_usuario_venta;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza la orden
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdUsuarioAsignado
	  * 
	  * Get the <i>id_usuario_asignado</i> property for this object. Donde <i>id_usuario_asignado</i> es Id del usuario que tiene asignada esta orden (responsable)
	  * @return int(11)
	  */
	final public function getIdUsuarioAsignado()
	{
		return $this->id_usuario_asignado;
	}

	/**
	  * setIdUsuarioAsignado( $id_usuario_asignado )
	  * 
	  * Set the <i>id_usuario_asignado</i> property for this object. Donde <i>id_usuario_asignado</i> es Id del usuario que tiene asignada esta orden (responsable).
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_asignado</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioAsignado( $id_usuario_asignado )
	{
		$this->id_usuario_asignado = $id_usuario_asignado;
	}

	/**
	  * getFechaOrden
	  * 
	  * Get the <i>fecha_orden</i> property for this object. Donde <i>fecha_orden</i> es fecha en la que se realiza la orden
	  * @return int(11)
	  */
	final public function getFechaOrden()
	{
		return $this->fecha_orden;
	}

	/**
	  * setFechaOrden( $fecha_orden )
	  * 
	  * Set the <i>fecha_orden</i> property for this object. Donde <i>fecha_orden</i> es fecha en la que se realiza la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_orden</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaOrden( $fecha_orden )
	{
		$this->fecha_orden = $fecha_orden;
	}

	/**
	  * getFechaEntrega
	  * 
	  * Get the <i>fecha_entrega</i> property for this object. Donde <i>fecha_entrega</i> es fecha en la que se entrega la orden
	  * @return int(11)
	  */
	final public function getFechaEntrega()
	{
		return $this->fecha_entrega;
	}

	/**
	  * setFechaEntrega( $fecha_entrega )
	  * 
	  * Set the <i>fecha_entrega</i> property for this object. Donde <i>fecha_entrega</i> es fecha en la que se entrega la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_entrega</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaEntrega( $fecha_entrega )
	{
		$this->fecha_entrega = $fecha_entrega;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si la orden esta activa
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si la orden esta activa.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getCancelada
	  * 
	  * Get the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si la orden esta cancelada
	  * @return tinyint(1)
	  */
	final public function getCancelada()
	{
		return $this->cancelada;
	}

	/**
	  * setCancelada( $cancelada )
	  * 
	  * Set the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si la orden esta cancelada.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelada</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelada( $cancelada )
	{
		$this->cancelada = $cancelada;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion de la orden
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion de la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getMotivoCancelacion
	  * 
	  * Get the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Motivo por la cual fue cancelada la orden
	  * @return varchar(255)
	  */
	final public function getMotivoCancelacion()
	{
		return $this->motivo_cancelacion;
	}

	/**
	  * setMotivoCancelacion( $motivo_cancelacion )
	  * 
	  * Set the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Motivo por la cual fue cancelada la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo_cancelacion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivoCancelacion( $motivo_cancelacion )
	{
		$this->motivo_cancelacion = $motivo_cancelacion;
	}

	/**
	  * getAdelanto
	  * 
	  * Get the <i>adelanto</i> property for this object. Donde <i>adelanto</i> es Cantidad de dinero pagada por adelantado
	  * @return float
	  */
	final public function getAdelanto()
	{
		return $this->adelanto;
	}

	/**
	  * setAdelanto( $adelanto )
	  * 
	  * Set the <i>adelanto</i> property for this object. Donde <i>adelanto</i> es Cantidad de dinero pagada por adelantado.
	  * Una validacion basica se hara aqui para comprobar que <i>adelanto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setAdelanto( $adelanto )
	{
		$this->adelanto = $adelanto;
	}

	/**
	  * getPrecio
	  * 
	  * Get the <i>precio</i> property for this object. Donde <i>precio</i> es El precio de esta orden de servicio
	  * @return float
	  */
	final public function getPrecio()
	{
		return $this->precio;
	}

	/**
	  * setPrecio( $precio )
	  * 
	  * Set the <i>precio</i> property for this object. Donde <i>precio</i> es El precio de esta orden de servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>precio</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPrecio( $precio )
	{
		$this->precio = $precio;
	}

	/**
	  * getExtraParams
	  * 
	  * Get the <i>extra_params</i> property for this object. Donde <i>extra_params</i> es Un json con valores extra que se necesitan llenar
	  * @return text
	  */
	final public function getExtraParams()
	{
		return $this->extra_params;
	}

	/**
	  * setExtraParams( $extra_params )
	  * 
	  * Set the <i>extra_params</i> property for this object. Donde <i>extra_params</i> es Un json con valores extra que se necesitan llenar.
	  * Una validacion basica se hara aqui para comprobar que <i>extra_params</i> es de tipo <i>text</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param text
	  */
	final public function setExtraParams( $extra_params )
	{
		$this->extra_params = $extra_params;
	}

}
