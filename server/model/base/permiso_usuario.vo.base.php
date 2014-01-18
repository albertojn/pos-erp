<?php
/** Value Object file for table permiso_usuario.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class PermisoUsuario extends VO
{
	/**
	  * Constructor de PermisoUsuario
	  * 
	  * Para construir un objeto de tipo PermisoUsuario debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return PermisoUsuario
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_permiso']) ){
				$this->id_permiso = $data['id_permiso'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto PermisoUsuario en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_permiso" => $this->id_permiso,
			"id_usuario" => $this->id_usuario
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_permiso
	  * 
	  * Id del permiso del usuario en la empresa<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_permiso;

	/**
	  * id_usuario
	  * 
	  * Id del usuario con el permiso en la empresa<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * getIdPermiso
	  * 
	  * Get the <i>id_permiso</i> property for this object. Donde <i>id_permiso</i> es Id del permiso del usuario en la empresa
	  * @return int(11)
	  */
	final public function getIdPermiso()
	{
		return $this->id_permiso;
	}

	/**
	  * setIdPermiso( $id_permiso )
	  * 
	  * Set the <i>id_permiso</i> property for this object. Donde <i>id_permiso</i> es Id del permiso del usuario en la empresa.
	  * Una validacion basica se hara aqui para comprobar que <i>id_permiso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdPermiso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdPermiso( $id_permiso )
	{
		$this->id_permiso = $id_permiso;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario con el permiso en la empresa
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario con el permiso en la empresa.
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
