<?php
/** Value Object file for table retencion_clasificacion_servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class RetencionClasificacionServicio extends VO
{
	/**
	  * Constructor de RetencionClasificacionServicio
	  * 
	  * Para construir un objeto de tipo RetencionClasificacionServicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return RetencionClasificacionServicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_retencion']) ){
				$this->id_retencion = $data['id_retencion'];
			}
			if( isset($data['id_clasificacion_servicio']) ){
				$this->id_clasificacion_servicio = $data['id_clasificacion_servicio'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto RetencionClasificacionServicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_retencion" => $this->id_retencion,
			"id_clasificacion_servicio" => $this->id_clasificacion_servicio
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_retencion
	  * 
	  * Id del retencion a aplicar al tipo de servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_retencion;

	/**
	  * id_clasificacion_servicio
	  * 
	  * Id de la clasificacion del servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_servicio;

	/**
	  * getIdRetencion
	  * 
	  * Get the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id del retencion a aplicar al tipo de servicio
	  * @return int(11)
	  */
	final public function getIdRetencion()
	{
		return $this->id_retencion;
	}

	/**
	  * setIdRetencion( $id_retencion )
	  * 
	  * Set the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id del retencion a aplicar al tipo de servicio.
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
	  * getIdClasificacionServicio
	  * 
	  * Get the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es Id de la clasificacion del servicio
	  * @return int(11)
	  */
	final public function getIdClasificacionServicio()
	{
		return $this->id_clasificacion_servicio;
	}

	/**
	  * setIdClasificacionServicio( $id_clasificacion_servicio )
	  * 
	  * Set the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es Id de la clasificacion del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionServicio( $id_clasificacion_servicio )
	{
		$this->id_clasificacion_servicio = $id_clasificacion_servicio;
	}

}
