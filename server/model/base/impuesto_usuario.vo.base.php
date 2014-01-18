<?php
/** Value Object file for table impuesto_usuario.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ImpuestoUsuario extends VO
{
	/**
	  * Constructor de ImpuestoUsuario
	  * 
	  * Para construir un objeto de tipo ImpuestoUsuario debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ImpuestoUsuario
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_impuesto']) ){
				$this->id_impuesto = $data['id_impuesto'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ImpuestoUsuario en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_impuesto" => $this->id_impuesto,
			"id_usuario" => $this->id_usuario
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_impuesto
	  * 
	  * Id del impuesto que se aplica al usuario<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_impuesto;

	/**
	  * id_usuario
	  * 
	  * Id del usuario al que se le cargan impuestos<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * getIdImpuesto
	  * 
	  * Get the <i>id_impuesto</i> property for this object. Donde <i>id_impuesto</i> es Id del impuesto que se aplica al usuario
	  * @return int(11)
	  */
	final public function getIdImpuesto()
	{
		return $this->id_impuesto;
	}

	/**
	  * setIdImpuesto( $id_impuesto )
	  * 
	  * Set the <i>id_impuesto</i> property for this object. Donde <i>id_impuesto</i> es Id del impuesto que se aplica al usuario.
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
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario al que se le cargan impuestos
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario al que se le cargan impuestos.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUsuario( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

}
