<?php
/** Value Object file for table autorizacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Autorizacion extends VO
{
	/**
	  * Constructor de Autorizacion
	  * 
	  * Para construir un objeto de tipo Autorizacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Autorizacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_autorizacion']) ){
				$this->id_autorizacion = $data['id_autorizacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Autorizacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_autorizacion" => $this->id_autorizacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_autorizacion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_autorizacion;

	/**
	  * getIdAutorizacion
	  * 
	  * Get the <i>id_autorizacion</i> property for this object. Donde <i>id_autorizacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdAutorizacion()
	{
		return $this->id_autorizacion;
	}

	/**
	  * setIdAutorizacion( $id_autorizacion )
	  * 
	  * Set the <i>id_autorizacion</i> property for this object. Donde <i>id_autorizacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_autorizacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdAutorizacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAutorizacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAutorizacion( $id_autorizacion )
	{
		$this->id_autorizacion = $id_autorizacion;
	}

}
