<?php
/** Value Object file for table retencion_clasificacion_proveedor.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class RetencionClasificacionProveedor extends VO
{
	/**
	  * Constructor de RetencionClasificacionProveedor
	  * 
	  * Para construir un objeto de tipo RetencionClasificacionProveedor debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return RetencionClasificacionProveedor
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_retencion']) ){
				$this->id_retencion = $data['id_retencion'];
			}
			if( isset($data['id_clasificacion_proveedor']) ){
				$this->id_clasificacion_proveedor = $data['id_clasificacion_proveedor'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto RetencionClasificacionProveedor en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_retencion" => $this->id_retencion,
			"id_clasificacion_proveedor" => $this->id_clasificacion_proveedor
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_retencion
	  * 
	  * Id del retencion a aplicar al tipo de proveedor<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_retencion;

	/**
	  * id_clasificacion_proveedor
	  * 
	  * Id de la clasificacion del proveedor<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_proveedor;

	/**
	  * getIdRetencion
	  * 
	  * Get the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id del retencion a aplicar al tipo de proveedor
	  * @return int(11)
	  */
	final public function getIdRetencion()
	{
		return $this->id_retencion;
	}

	/**
	  * setIdRetencion( $id_retencion )
	  * 
	  * Set the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id del retencion a aplicar al tipo de proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>id_retencion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdRetencion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdRetencion( $id_retencion )
	{
		$this->id_retencion = $id_retencion;
	}

	/**
	  * getIdClasificacionProveedor
	  * 
	  * Get the <i>id_clasificacion_proveedor</i> property for this object. Donde <i>id_clasificacion_proveedor</i> es Id de la clasificacion del proveedor
	  * @return int(11)
	  */
	final public function getIdClasificacionProveedor()
	{
		return $this->id_clasificacion_proveedor;
	}

	/**
	  * setIdClasificacionProveedor( $id_clasificacion_proveedor )
	  * 
	  * Set the <i>id_clasificacion_proveedor</i> property for this object. Donde <i>id_clasificacion_proveedor</i> es Id de la clasificacion del proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_proveedor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionProveedor( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionProveedor( $id_clasificacion_proveedor )
	{
		$this->id_clasificacion_proveedor = $id_clasificacion_proveedor;
	}

}
