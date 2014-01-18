<?php
/** Value Object file for table impresora.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Impresora extends VO
{
	/**
	  * Constructor de Impresora
	  * 
	  * Para construir un objeto de tipo Impresora debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Impresora
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_impresora']) ){
				$this->id_impresora = $data['id_impresora'];
			}
			if( isset($data['puerto']) ){
				$this->puerto = $data['puerto'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Impresora en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_impresora" => $this->id_impresora,
			"puerto" => $this->puerto
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_impresora
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_impresora;

	/**
	  * puerto
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(16)
	  */
	public $puerto;

	/**
	  * getIdImpresora
	  * 
	  * Get the <i>id_impresora</i> property for this object. Donde <i>id_impresora</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdImpresora()
	{
		return $this->id_impresora;
	}

	/**
	  * setIdImpresora( $id_impresora )
	  * 
	  * Set the <i>id_impresora</i> property for this object. Donde <i>id_impresora</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_impresora</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdImpresora( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdImpresora( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdImpresora( $id_impresora )
	{
		$this->id_impresora = $id_impresora;
	}

	/**
	  * getPuerto
	  * 
	  * Get the <i>puerto</i> property for this object. Donde <i>puerto</i> es  [Campo no documentado]
	  * @return varchar(16)
	  */
	final public function getPuerto()
	{
		return $this->puerto;
	}

	/**
	  * setPuerto( $puerto )
	  * 
	  * Set the <i>puerto</i> property for this object. Donde <i>puerto</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>puerto</i> es de tipo <i>varchar(16)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(16)
	  */
	final public function setPuerto( $puerto )
	{
		$this->puerto = $puerto;
	}

}
