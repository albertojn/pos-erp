<?php
/** Value Object file for table categoria_contacto.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class CategoriaContacto extends VO
{
	/**
	  * Constructor de CategoriaContacto
	  * 
	  * Para construir un objeto de tipo CategoriaContacto debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return CategoriaContacto
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id']) ){
				$this->id = $data['id'];
			}
			if( isset($data['id_padre']) ){
				$this->id_padre = $data['id_padre'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto CategoriaContacto en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id" => $this->id,
			"id_padre" => $this->id_padre,
			"nombre" => $this->nombre,
			"activa" => $this->activa,
			"descripcion" => $this->descripcion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(10)
	  */
	public $id;

	/**
	  * id_padre
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(10)
	  */
	public $id_padre;

	/**
	  * nombre
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $nombre;

	/**
	  * activa
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var tinyint(4)
	  */
	public $activa;

	/**
	  * descripcion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * getId
	  * 
	  * Get the <i>id</i> property for this object. Donde <i>id</i> es  [Campo no documentado]
	  * @return int(10)
	  */
	final public function getId()
	{
		return $this->id;
	}

	/**
	  * setId( $id )
	  * 
	  * Set the <i>id</i> property for this object. Donde <i>id</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id</i> es de tipo <i>int(10)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setId( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setId( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(10)
	  */
	final public function setId( $id )
	{
		$this->id = $id;
	}

	/**
	  * getIdPadre
	  * 
	  * Get the <i>id_padre</i> property for this object. Donde <i>id_padre</i> es  [Campo no documentado]
	  * @return int(10)
	  */
	final public function getIdPadre()
	{
		return $this->id_padre;
	}

	/**
	  * setIdPadre( $id_padre )
	  * 
	  * Set the <i>id_padre</i> property for this object. Donde <i>id_padre</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_padre</i> es de tipo <i>int(10)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(10)
	  */
	final public function setIdPadre( $id_padre )
	{
		$this->id_padre = $id_padre;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado]
	  * @return varchar(255)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es  [Campo no documentado]
	  * @return tinyint(4)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(4)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(4)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado]
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

}
