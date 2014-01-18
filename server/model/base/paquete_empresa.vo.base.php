<?php
/** Value Object file for table paquete_empresa.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class PaqueteEmpresa extends VO
{
	/**
	  * Constructor de PaqueteEmpresa
	  * 
	  * Para construir un objeto de tipo PaqueteEmpresa debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return PaqueteEmpresa
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_paquete']) ){
				$this->id_paquete = $data['id_paquete'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto PaqueteEmpresa en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_paquete" => $this->id_paquete,
			"id_empresa" => $this->id_empresa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_paquete
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_paquete;

	/**
	  * id_empresa
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * getIdPaquete
	  * 
	  * Get the <i>id_paquete</i> property for this object. Donde <i>id_paquete</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdPaquete()
	{
		return $this->id_paquete;
	}

	/**
	  * setIdPaquete( $id_paquete )
	  * 
	  * Set the <i>id_paquete</i> property for this object. Donde <i>id_paquete</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_paquete</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdPaquete( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdPaquete( $id_paquete )
	{
		$this->id_paquete = $id_paquete;
	}

	/**
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es  [Campo no documentado].
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
