<?php
/** Value Object file for table estado.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Estado extends VO
{
	/**
	  * Constructor de Estado
	  * 
	  * Para construir un objeto de tipo Estado debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Estado
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
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
	  * Este metodo permite tratar a un objeto Estado en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_estado" => $this->id_estado,
			"nombre" => $this->nombre
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_estado
	  * 
	  * Id del estado en el sistema<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_estado;

	/**
	  * nombre
	  * 
	  * Nombre del estado<br>
	  * @access public
	  * @var varchar(16)
	  */
	public $nombre;

	/**
	  * getIdEstado
	  * 
	  * Get the <i>id_estado</i> property for this object. Donde <i>id_estado</i> es Id del estado en el sistema
	  * @return int(11)
	  */
	final public function getIdEstado()
	{
		return $this->id_estado;
	}

	/**
	  * setIdEstado( $id_estado )
	  * 
	  * Set the <i>id_estado</i> property for this object. Donde <i>id_estado</i> es Id del estado en el sistema.
	  * Una validacion basica se hara aqui para comprobar que <i>id_estado</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdEstado( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdEstado( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdEstado( $id_estado )
	{
		$this->id_estado = $id_estado;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del estado
	  * @return varchar(16)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del estado.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(16)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(16)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

}
