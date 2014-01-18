<?php
/** Value Object file for table permiso.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Permiso extends VO
{
	/**
	  * Constructor de Permiso
	  * 
	  * Para construir un objeto de tipo Permiso debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Permiso
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_permiso']) ){
				$this->id_permiso = $data['id_permiso'];
			}
			if( isset($data['permiso']) ){
				$this->permiso = $data['permiso'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Permiso en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_permiso" => $this->id_permiso,
			"permiso" => $this->permiso
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_permiso
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_permiso;

	/**
	  * permiso
	  * 
	  * el nombre de la funcion en el api a la que se le dara permiso<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $permiso;

	/**
	  * getIdPermiso
	  * 
	  * Get the <i>id_permiso</i> property for this object. Donde <i>id_permiso</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdPermiso()
	{
		return $this->id_permiso;
	}

	/**
	  * setIdPermiso( $id_permiso )
	  * 
	  * Set the <i>id_permiso</i> property for this object. Donde <i>id_permiso</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_permiso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdPermiso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdPermiso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdPermiso( $id_permiso )
	{
		$this->id_permiso = $id_permiso;
	}

	/**
	  * getPermiso
	  * 
	  * Get the <i>permiso</i> property for this object. Donde <i>permiso</i> es el nombre de la funcion en el api a la que se le dara permiso
	  * @return varchar(64)
	  */
	final public function getPermiso()
	{
		return $this->permiso;
	}

	/**
	  * setPermiso( $permiso )
	  * 
	  * Set the <i>permiso</i> property for this object. Donde <i>permiso</i> es el nombre de la funcion en el api a la que se le dara permiso.
	  * Una validacion basica se hara aqui para comprobar que <i>permiso</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setPermiso( $permiso )
	{
		$this->permiso = $permiso;
	}

}
