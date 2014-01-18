<?php
/** Value Object file for table venta_orden.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class VentaOrden extends VO
{
	/**
	  * Constructor de VentaOrden
	  * 
	  * Para construir un objeto de tipo VentaOrden debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return VentaOrden
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_venta']) ){
				$this->id_venta = $data['id_venta'];
			}
			if( isset($data['id_orden_de_servicio']) ){
				$this->id_orden_de_servicio = $data['id_orden_de_servicio'];
			}
			if( isset($data['precio']) ){
				$this->precio = $data['precio'];
			}
			if( isset($data['descuento']) ){
				$this->descuento = $data['descuento'];
			}
			if( isset($data['impuesto']) ){
				$this->impuesto = $data['impuesto'];
			}
			if( isset($data['retencion']) ){
				$this->retencion = $data['retencion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto VentaOrden en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_venta" => $this->id_venta,
			"id_orden_de_servicio" => $this->id_orden_de_servicio,
			"precio" => $this->precio,
			"descuento" => $this->descuento,
			"impuesto" => $this->impuesto,
			"retencion" => $this->retencion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_venta
	  * 
	  * Id de la venta en la que se vendieron las ordenes de servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_venta;

	/**
	  * id_orden_de_servicio
	  * 
	  * Id de la orden de servicio que se vendio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_orden_de_servicio;

	/**
	  * precio
	  * 
	  * El precio de la orden<br>
	  * @access public
	  * @var float
	  */
	public $precio;

	/**
	  * descuento
	  * 
	  * El descuento de la orden<br>
	  * @access public
	  * @var float
	  */
	public $descuento;

	/**
	  * impuesto
	  * 
	  * Cantidad aÃƒÆ’Ã‚Â±adida por los impuestos<br>
	  * @access public
	  * @var float
	  */
	public $impuesto;

	/**
	  * retencion
	  * 
	  * Cantidad aÃƒÆ’Ã‚Â±adida por las retenciones<br>
	  * @access public
	  * @var float
	  */
	public $retencion;

	/**
	  * getIdVenta
	  * 
	  * Get the <i>id_venta</i> property for this object. Donde <i>id_venta</i> es Id de la venta en la que se vendieron las ordenes de servicio
	  * @return int(11)
	  */
	final public function getIdVenta()
	{
		return $this->id_venta;
	}

	/**
	  * setIdVenta( $id_venta )
	  * 
	  * Set the <i>id_venta</i> property for this object. Donde <i>id_venta</i> es Id de la venta en la que se vendieron las ordenes de servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>id_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdVenta( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdVenta( $id_venta )
	{
		$this->id_venta = $id_venta;
	}

	/**
	  * getIdOrdenDeServicio
	  * 
	  * Get the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es Id de la orden de servicio que se vendio
	  * @return int(11)
	  */
	final public function getIdOrdenDeServicio()
	{
		return $this->id_orden_de_servicio;
	}

	/**
	  * setIdOrdenDeServicio( $id_orden_de_servicio )
	  * 
	  * Set the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es Id de la orden de servicio que se vendio.
	  * Una validacion basica se hara aqui para comprobar que <i>id_orden_de_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdOrdenDeServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdOrdenDeServicio( $id_orden_de_servicio )
	{
		$this->id_orden_de_servicio = $id_orden_de_servicio;
	}

	/**
	  * getPrecio
	  * 
	  * Get the <i>precio</i> property for this object. Donde <i>precio</i> es El precio de la orden
	  * @return float
	  */
	final public function getPrecio()
	{
		return $this->precio;
	}

	/**
	  * setPrecio( $precio )
	  * 
	  * Set the <i>precio</i> property for this object. Donde <i>precio</i> es El precio de la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>precio</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPrecio( $precio )
	{
		$this->precio = $precio;
	}

	/**
	  * getDescuento
	  * 
	  * Get the <i>descuento</i> property for this object. Donde <i>descuento</i> es El descuento de la orden
	  * @return float
	  */
	final public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	  * setDescuento( $descuento )
	  * 
	  * Set the <i>descuento</i> property for this object. Donde <i>descuento</i> es El descuento de la orden.
	  * Una validacion basica se hara aqui para comprobar que <i>descuento</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setDescuento( $descuento )
	{
		$this->descuento = $descuento;
	}

	/**
	  * getImpuesto
	  * 
	  * Get the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es Cantidad aÃƒÆ’Ã‚Â±adida por los impuestos
	  * @return float
	  */
	final public function getImpuesto()
	{
		return $this->impuesto;
	}

	/**
	  * setImpuesto( $impuesto )
	  * 
	  * Set the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es Cantidad aÃƒÆ’Ã‚Â±adida por los impuestos.
	  * Una validacion basica se hara aqui para comprobar que <i>impuesto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setImpuesto( $impuesto )
	{
		$this->impuesto = $impuesto;
	}

	/**
	  * getRetencion
	  * 
	  * Get the <i>retencion</i> property for this object. Donde <i>retencion</i> es Cantidad aÃƒÆ’Ã‚Â±adida por las retenciones
	  * @return float
	  */
	final public function getRetencion()
	{
		return $this->retencion;
	}

	/**
	  * setRetencion( $retencion )
	  * 
	  * Set the <i>retencion</i> property for this object. Donde <i>retencion</i> es Cantidad aÃƒÆ’Ã‚Â±adida por las retenciones.
	  * Una validacion basica se hara aqui para comprobar que <i>retencion</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setRetencion( $retencion )
	{
		$this->retencion = $retencion;
	}

}
