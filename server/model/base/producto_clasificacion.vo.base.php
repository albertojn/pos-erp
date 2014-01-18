<?php
/** Value Object file for table producto_clasificacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ProductoClasificacion extends VO
{
	/**
	  * Constructor de ProductoClasificacion
	  * 
	  * Para construir un objeto de tipo ProductoClasificacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ProductoClasificacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_producto']) ){
				$this->id_producto = $data['id_producto'];
			}
			if( isset($data['id_clasificacion_producto']) ){
				$this->id_clasificacion_producto = $data['id_clasificacion_producto'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ProductoClasificacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_producto" => $this->id_producto,
			"id_clasificacion_producto" => $this->id_clasificacion_producto
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_producto
	  * 
	  * Id del producto con esa clasificacion<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_producto;

	/**
	  * id_clasificacion_producto
	  * 
	  * Id de la clasificacion del producto<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_producto;

	/**
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es Id del producto con esa clasificacion
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es Id del producto con esa clasificacion.
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
	  * getIdClasificacionProducto
	  * 
	  * Get the <i>id_clasificacion_producto</i> property for this object. Donde <i>id_clasificacion_producto</i> es Id de la clasificacion del producto
	  * @return int(11)
	  */
	final public function getIdClasificacionProducto()
	{
		return $this->id_clasificacion_producto;
	}

	/**
	  * setIdClasificacionProducto( $id_clasificacion_producto )
	  * 
	  * Set the <i>id_clasificacion_producto</i> property for this object. Donde <i>id_clasificacion_producto</i> es Id de la clasificacion del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionProducto( $id_clasificacion_producto )
	{
		$this->id_clasificacion_producto = $id_clasificacion_producto;
	}

}
