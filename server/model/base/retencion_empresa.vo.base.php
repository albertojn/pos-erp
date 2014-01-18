<?php
/** Value Object file for table retencion_empresa.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class RetencionEmpresa extends VO
{
	/**
	  * Constructor de RetencionEmpresa
	  * 
	  * Para construir un objeto de tipo RetencionEmpresa debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return RetencionEmpresa
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_retencion']) ){
				$this->id_retencion = $data['id_retencion'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto RetencionEmpresa en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_retencion" => $this->id_retencion,
			"id_empresa" => $this->id_empresa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_retencion
	  * 
	  * Id de la retencion que se aplica a la empreas<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_retencion;

	/**
	  * id_empresa
	  * 
	  * Id de la empresa a la que se le aplica la retencion<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * getIdRetencion
	  * 
	  * Get the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id de la retencion que se aplica a la empreas
	  * @return int(11)
	  */
	final public function getIdRetencion()
	{
		return $this->id_retencion;
	}

	/**
	  * setIdRetencion( $id_retencion )
	  * 
	  * Set the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id de la retencion que se aplica a la empreas.
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
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa a la que se le aplica la retencion
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa a la que se le aplica la retencion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdEmpresa( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

}
