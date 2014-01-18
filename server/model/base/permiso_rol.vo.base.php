<?php
/** Value Object file for table permiso_rol.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class PermisoRol extends VO
{
	/**
	  * Constructor de PermisoRol
	  * 
	  * Para construir un objeto de tipo PermisoRol debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return PermisoRol
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_permiso']) ){
				$this->id_permiso = $data['id_permiso'];
			}
			if( isset($data['id_rol']) ){
				$this->id_rol = $data['id_rol'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto PermisoRol en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_permiso" => $this->id_permiso,
			"id_rol" => $this->id_rol
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_permiso
	  * 
	  * Id del permiso del rol en esa empresa<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_permiso;

	/**
	  * id_rol
	  * 
	  * Id del rol que tiene el permiso en esa empresa<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_rol;

	/**
	  * getIdPermiso
	  * 
	  * Get the <i>id_permiso</i> property for this object. Donde <i>id_permiso</i> es Id del permiso del rol en esa empresa
	  * @return int(11)
	  */
	final public function getIdPermiso()
	{
		return $this->id_permiso;
	}

	/**
	  * setIdPermiso( $id_permiso )
	  * 
	  * Set the <i>id_permiso</i> property for this object. Donde <i>id_permiso</i> es Id del permiso del rol en esa empresa.
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
	  * getIdRol
	  * 
	  * Get the <i>id_rol</i> property for this object. Donde <i>id_rol</i> es Id del rol que tiene el permiso en esa empresa
	  * @return int(11)
	  */
	final public function getIdRol()
	{
		return $this->id_rol;
	}

	/**
	  * setIdRol( $id_rol )
	  * 
	  * Set the <i>id_rol</i> property for this object. Donde <i>id_rol</i> es Id del rol que tiene el permiso en esa empresa.
	  * Una validacion basica se hara aqui para comprobar que <i>id_rol</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdRol( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdRol( $id_rol )
	{
		$this->id_rol = $id_rol;
	}

}
