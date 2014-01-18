<?php
/** Value Object file for table impuesto_clasificacion_producto.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ImpuestoClasificacionProducto extends VO
{
	/**
	  * Constructor de ImpuestoClasificacionProducto
	  * 
	  * Para construir un objeto de tipo ImpuestoClasificacionProducto debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ImpuestoClasificacionProducto
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_impuesto']) ){
				$this->id_impuesto = $data['id_impuesto'];
			}
			if( isset($data['id_clasificacion_producto']) ){
				$this->id_clasificacion_producto = $data['id_clasificacion_producto'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ImpuestoClasificacionProducto en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_impuesto" => $this->id_impuesto,
			"id_clasificacion_producto" => $this->id_clasificacion_producto
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_impuesto
	  * 
	  * Id del impuesto a aplicarl al tipo de producto<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_impuesto;

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
	  * getIdImpuesto
	  * 
	  * Get the <i>id_impuesto</i> property for this object. Donde <i>id_impuesto</i> es Id del impuesto a aplicarl al tipo de producto
	  * @return int(11)
	  */
	final public function getIdImpuesto()
	{
		return $this->id_impuesto;
	}

	/**
	  * setIdImpuesto( $id_impuesto )
	  * 
	  * Set the <i>id_impuesto</i> property for this object. Donde <i>id_impuesto</i> es Id del impuesto a aplicarl al tipo de producto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_impuesto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdImpuesto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdImpuesto( $id_impuesto )
	{
		$this->id_impuesto = $id_impuesto;
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
