<?php
/** Value Object file for table perfil.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Perfil extends VO
{
	/**
	  * Constructor de Perfil
	  * 
	  * Para construir un objeto de tipo Perfil debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Perfil
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_perfil']) ){
				$this->id_perfil = $data['id_perfil'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['configuracion']) ){
				$this->configuracion = $data['configuracion'];
			}
			if( isset($data['fecha_creacion']) ){
				$this->fecha_creacion = $data['fecha_creacion'];
			}
			if( isset($data['fecha_modificacion']) ){
				$this->fecha_modificacion = $data['fecha_modificacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Perfil en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_perfil" => $this->id_perfil,
			"descripcion" => $this->descripcion,
			"configuracion" => $this->configuracion,
			"fecha_creacion" => $this->fecha_creacion,
			"fecha_modificacion" => $this->fecha_modificacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_perfil
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_perfil;

	/**
	  * descripcion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $descripcion;

	/**
	  * configuracion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var longtext
	  */
	public $configuracion;

	/**
	  * fecha_creacion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_creacion;

	/**
	  * fecha_modificacion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_modificacion;

	/**
	  * getIdPerfil
	  * 
	  * Get the <i>id_perfil</i> property for this object. Donde <i>id_perfil</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdPerfil()
	{
		return $this->id_perfil;
	}

	/**
	  * setIdPerfil( $id_perfil )
	  * 
	  * Set the <i>id_perfil</i> property for this object. Donde <i>id_perfil</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_perfil</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdPerfil( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdPerfil( $id_perfil )
	{
		$this->id_perfil = $id_perfil;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado]
	  * @return varchar(64)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getConfiguracion
	  * 
	  * Get the <i>configuracion</i> property for this object. Donde <i>configuracion</i> es  [Campo no documentado]
	  * @return longtext
	  */
	final public function getConfiguracion()
	{
		return $this->configuracion;
	}

	/**
	  * setConfiguracion( $configuracion )
	  * 
	  * Set the <i>configuracion</i> property for this object. Donde <i>configuracion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>configuracion</i> es de tipo <i>longtext</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param longtext
	  */
	final public function setConfiguracion( $configuracion )
	{
		$this->configuracion = $configuracion;
	}

	/**
	  * getFechaCreacion
	  * 
	  * Get the <i>fecha_creacion</i> property for this object. Donde <i>fecha_creacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFechaCreacion()
	{
		return $this->fecha_creacion;
	}

	/**
	  * setFechaCreacion( $fecha_creacion )
	  * 
	  * Set the <i>fecha_creacion</i> property for this object. Donde <i>fecha_creacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_creacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaCreacion( $fecha_creacion )
	{
		$this->fecha_creacion = $fecha_creacion;
	}

	/**
	  * getFechaModificacion
	  * 
	  * Get the <i>fecha_modificacion</i> property for this object. Donde <i>fecha_modificacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFechaModificacion()
	{
		return $this->fecha_modificacion;
	}

	/**
	  * setFechaModificacion( $fecha_modificacion )
	  * 
	  * Set the <i>fecha_modificacion</i> property for this object. Donde <i>fecha_modificacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_modificacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaModificacion( $fecha_modificacion )
	{
		$this->fecha_modificacion = $fecha_modificacion;
	}

}
