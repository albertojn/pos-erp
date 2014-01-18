<?php
/** Value Object file for table producto_orden_de_servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ProductoOrdenDeServicio extends VO
{
	/**
	  * Constructor de ProductoOrdenDeServicio
	  * 
	  * Para construir un objeto de tipo ProductoOrdenDeServicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ProductoOrdenDeServicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_orden_de_servicio']) ){
				$this->id_orden_de_servicio = $data['id_orden_de_servicio'];
			}
			if( isset($data['id_producto']) ){
				$this->id_producto = $data['id_producto'];
			}
			if( isset($data['precio']) ){
				$this->precio = $data['precio'];
			}
			if( isset($data['cantidad']) ){
				$this->cantidad = $data['cantidad'];
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
			if( isset($data['id_unidad']) ){
				$this->id_unidad = $data['id_unidad'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ProductoOrdenDeServicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_orden_de_servicio" => $this->id_orden_de_servicio,
			"id_producto" => $this->id_producto,
			"precio" => $this->precio,
			"cantidad" => $this->cantidad,
			"descuento" => $this->descuento,
			"impuesto" => $this->impuesto,
			"retencion" => $this->retencion,
			"id_unidad" => $this->id_unidad
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_orden_de_servicio
	  * 
	  * id de la orden de servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_orden_de_servicio;

	/**
	  * id_producto
	  * 
	  * id del producto a vender<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_producto;

	/**
	  * precio
	  * 
	  * precio unitario con el que se va a vender el producto<br>
	  * @access public
	  * @var float
	  */
	public $precio;

	/**
	  * cantidad
	  * 
	  * cantidad de producto que se vendera<br>
	  * @access public
	  * @var int(11)
	  */
	public $cantidad;

	/**
	  * descuento
	  * 
	  * descuento que se aplicara al producto<br>
	  * @access public
	  * @var float
	  */
	public $descuento;

	/**
	  * impuesto
	  * 
	  * impuesto que se aplicara al producto<br>
	  * @access public
	  * @var float
	  */
	public $impuesto;

	/**
	  * retencion
	  * 
	  * Retencion unitaria en el producto<br>
	  * @access public
	  * @var float
	  */
	public $retencion;

	/**
	  * id_unidad
	  * 
	  * Id de la unidad del producto<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_unidad;

	/**
	  * getIdOrdenDeServicio
	  * 
	  * Get the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es id de la orden de servicio
	  * @return int(11)
	  */
	final public function getIdOrdenDeServicio()
	{
		return $this->id_orden_de_servicio;
	}

	/**
	  * setIdOrdenDeServicio( $id_orden_de_servicio )
	  * 
	  * Set the <i>id_orden_de_servicio</i> property for this object. Donde <i>id_orden_de_servicio</i> es id de la orden de servicio.
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
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es id del producto a vender
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es id del producto a vender.
	  * Una validacion basica se hara aqui para comprobar que <i>id_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdProducto( $id_producto )
	{
		$this->id_producto = $id_producto;
	}

	/**
	  * getPrecio
	  * 
	  * Get the <i>precio</i> property for this object. Donde <i>precio</i> es precio unitario con el que se va a vender el producto
	  * @return float
	  */
	final public function getPrecio()
	{
		return $this->precio;
	}

	/**
	  * setPrecio( $precio )
	  * 
	  * Set the <i>precio</i> property for this object. Donde <i>precio</i> es precio unitario con el que se va a vender el producto.
	  * Una validacion basica se hara aqui para comprobar que <i>precio</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPrecio( $precio )
	{
		$this->precio = $precio;
	}

	/**
	  * getCantidad
	  * 
	  * Get the <i>cantidad</i> property for this object. Donde <i>cantidad</i> es cantidad de producto que se vendera
	  * @return int(11)
	  */
	final public function getCantidad()
	{
		return $this->cantidad;
	}

	/**
	  * setCantidad( $cantidad )
	  * 
	  * Set the <i>cantidad</i> property for this object. Donde <i>cantidad</i> es cantidad de producto que se vendera.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setCantidad( $cantidad )
	{
		$this->cantidad = $cantidad;
	}

	/**
	  * getDescuento
	  * 
	  * Get the <i>descuento</i> property for this object. Donde <i>descuento</i> es descuento que se aplicara al producto
	  * @return float
	  */
	final public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	  * setDescuento( $descuento )
	  * 
	  * Set the <i>descuento</i> property for this object. Donde <i>descuento</i> es descuento que se aplicara al producto.
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
	  * Get the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es impuesto que se aplicara al producto
	  * @return float
	  */
	final public function getImpuesto()
	{
		return $this->impuesto;
	}

	/**
	  * setImpuesto( $impuesto )
	  * 
	  * Set the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es impuesto que se aplicara al producto.
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
	  * Get the <i>retencion</i> property for this object. Donde <i>retencion</i> es Retencion unitaria en el producto
	  * @return float
	  */
	final public function getRetencion()
	{
		return $this->retencion;
	}

	/**
	  * setRetencion( $retencion )
	  * 
	  * Set the <i>retencion</i> property for this object. Donde <i>retencion</i> es Retencion unitaria en el producto.
	  * Una validacion basica se hara aqui para comprobar que <i>retencion</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setRetencion( $retencion )
	{
		$this->retencion = $retencion;
	}

	/**
	  * getIdUnidad
	  * 
	  * Get the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es Id de la unidad del producto
	  * @return int(11)
	  */
	final public function getIdUnidad()
	{
		return $this->id_unidad;
	}

	/**
	  * setIdUnidad( $id_unidad )
	  * 
	  * Set the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es Id de la unidad del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_unidad</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUnidad( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUnidad( $id_unidad )
	{
		$this->id_unidad = $id_unidad;
	}

}
