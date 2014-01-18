<?php
/** Value Object file for table ciudad.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Ciudad extends VO
{
	/**
	  * Constructor de Ciudad
	  * 
	  * Para construir un objeto de tipo Ciudad debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Ciudad
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_ciudad']) ){
				$this->id_ciudad = $data['id_ciudad'];
			}
			if( isset($data['id_estado']) ){
				$this->id_estado = $data['id_estado'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Ciudad en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_ciudad" => $this->id_ciudad,
			"id_estado" => $this->id_estado,
			"nombre" => $this->nombre
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_ciudad
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_ciudad;

	/**
	  * id_estado
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_estado;

	/**
	  * nombre
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $nombre;

	/**
	  * getIdCiudad
	  * 
	  * Get the <i>id_ciudad</i> property for this object. Donde <i>id_ciudad</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCiudad()
	{
		return $this->id_ciudad;
	}

	/**
	  * setIdCiudad( $id_ciudad )
	  * 
	  * Set the <i>id_ciudad</i> property for this object. Donde <i>id_ciudad</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_ciudad</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCiudad( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCiudad( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCiudad( $id_ciudad )
	{
		$this->id_ciudad = $id_ciudad;
	}

	/**
	  * getIdEstado
	  * 
	  * Get the <i>id_estado</i> property for this object. Donde <i>id_estado</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdEstado()
	{
		return $this->id_estado;
	}

	/**
	  * setIdEstado( $id_estado )
	  * 
	  * Set the <i>id_estado</i> property for this object. Donde <i>id_estado</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_estado</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdEstado( $id_estado )
	{
		$this->id_estado = $id_estado;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

}
