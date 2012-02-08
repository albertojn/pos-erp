<?php
/** Value Object file for table producto_salida_almacen.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Alan Gonzalez
  * @access public
  * @package docs
  * 
  */

class ProductoSalidaAlmacen extends VO
{
	/**
	  * Constructor de ProductoSalidaAlmacen
	  * 
	  * Para construir un objeto de tipo ProductoSalidaAlmacen debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ProductoSalidaAlmacen
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_salida_almacen']) ){
				$this->id_salida_almacen = $data['id_salida_almacen'];
			}
			if( isset($data['id_producto']) ){
				$this->id_producto = $data['id_producto'];
			}
			if( isset($data['id_unidad']) ){
				$this->id_unidad = $data['id_unidad'];
			}
			if( isset($data['cantidad']) ){
				$this->cantidad = $data['cantidad'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ProductoSalidaAlmacen en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_salida_almacen" => $this->id_salida_almacen,
			"id_producto" => $this->id_producto,
			"id_unidad" => $this->id_unidad,
			"cantidad" => $this->cantidad
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_salida_almacen
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_salida_almacen;

	/**
	  * id_producto
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_producto;

	/**
	  * id_unidad
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_unidad;

	/**
	  * cantidad
	  * 
	  * Cantidad de producto que sale del almacen en cierta unidad<br>
	  * @access public
	  * @var float
	  */
	public $cantidad;

	/**
	  * getIdSalidaAlmacen
	  * 
	  * Get the <i>id_salida_almacen</i> property for this object. Donde <i>id_salida_almacen</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSalidaAlmacen()
	{
		return $this->id_salida_almacen;
	}

	/**
	  * setIdSalidaAlmacen( $id_salida_almacen )
	  * 
	  * Set the <i>id_salida_almacen</i> property for this object. Donde <i>id_salida_almacen</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_salida_almacen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdSalidaAlmacen( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdSalidaAlmacen( $id_salida_almacen )
	{
		$this->id_salida_almacen = $id_salida_almacen;
	}

	/**
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es  [Campo no documentado].
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
	  * getIdUnidad
	  * 
	  * Get the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdUnidad()
	{
		return $this->id_unidad;
	}

	/**
	  * setIdUnidad( $id_unidad )
	  * 
	  * Set the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es  [Campo no documentado].
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

	/**
	  * getCantidad
	  * 
	  * Get the <i>cantidad</i> property for this object. Donde <i>cantidad</i> es Cantidad de producto que sale del almacen en cierta unidad
	  * @return float
	  */
	final public function getCantidad()
	{
		return $this->cantidad;
	}

	/**
	  * setCantidad( $cantidad )
	  * 
	  * Set the <i>cantidad</i> property for this object. Donde <i>cantidad</i> es Cantidad de producto que sale del almacen en cierta unidad.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidad( $cantidad )
	{
		$this->cantidad = $cantidad;
	}

}
