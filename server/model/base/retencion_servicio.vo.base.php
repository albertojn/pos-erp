<?php
/** Value Object file for table retencion_servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class RetencionServicio extends VO
{
	/**
	  * Constructor de RetencionServicio
	  * 
	  * Para construir un objeto de tipo RetencionServicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return RetencionServicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_retencion']) ){
				$this->id_retencion = $data['id_retencion'];
			}
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto RetencionServicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_retencion" => $this->id_retencion,
			"id_servicio" => $this->id_servicio
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_retencion
	  * 
	  * Id de la retencion que se aplica al servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_retencion;

	/**
	  * id_servicio
	  * 
	  * Id del servicio al que se le aplica la retencion<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_servicio;

	/**
	  * getIdRetencion
	  * 
	  * Get the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id de la retencion que se aplica al servicio
	  * @return int(11)
	  */
	final public function getIdRetencion()
	{
		return $this->id_retencion;
	}

	/**
	  * setIdRetencion( $id_retencion )
	  * 
	  * Set the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id de la retencion que se aplica al servicio.
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
	  * getIdServicio
	  * 
	  * Get the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio al que se le aplica la retencion
	  * @return int(11)
	  */
	final public function getIdServicio()
	{
		return $this->id_servicio;
	}

	/**
	  * setIdServicio( $id_servicio )
	  * 
	  * Set the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio al que se le aplica la retencion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdServicio( $id_servicio )
	{
		$this->id_servicio = $id_servicio;
	}

}
