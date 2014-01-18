<?php
/** Value Object file for table logo.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Logo extends VO
{
	/**
	  * Constructor de Logo
	  * 
	  * Para construir un objeto de tipo Logo debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Logo
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_logo']) ){
				$this->id_logo = $data['id_logo'];
			}
			if( isset($data['imagen']) ){
				$this->imagen = $data['imagen'];
			}
			if( isset($data['tipo']) ){
				$this->tipo = $data['tipo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Logo en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_logo" => $this->id_logo,
			"imagen" => $this->imagen,
			"tipo" => $this->tipo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_logo
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_logo;

	/**
	  * imagen
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var text
	  */
	public $imagen;

	/**
	  * tipo
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(5)
	  */
	public $tipo;

	/**
	  * getIdLogo
	  * 
	  * Get the <i>id_logo</i> property for this object. Donde <i>id_logo</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdLogo()
	{
		return $this->id_logo;
	}

	/**
	  * setIdLogo( $id_logo )
	  * 
	  * Set the <i>id_logo</i> property for this object. Donde <i>id_logo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_logo</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdLogo( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdLogo( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdLogo( $id_logo )
	{
		$this->id_logo = $id_logo;
	}

	/**
	  * getImagen
	  * 
	  * Get the <i>imagen</i> property for this object. Donde <i>imagen</i> es  [Campo no documentado]
	  * @return text
	  */
	final public function getImagen()
	{
		return $this->imagen;
	}

	/**
	  * setImagen( $imagen )
	  * 
	  * Set the <i>imagen</i> property for this object. Donde <i>imagen</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>imagen</i> es de tipo <i>text</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param text
	  */
	final public function setImagen( $imagen )
	{
		$this->imagen = $imagen;
	}

	/**
	  * getTipo
	  * 
	  * Get the <i>tipo</i> property for this object. Donde <i>tipo</i> es  [Campo no documentado]
	  * @return varchar(5)
	  */
	final public function getTipo()
	{
		return $this->tipo;
	}

	/**
	  * setTipo( $tipo )
	  * 
	  * Set the <i>tipo</i> property for this object. Donde <i>tipo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>tipo</i> es de tipo <i>varchar(5)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(5)
	  */
	final public function setTipo( $tipo )
	{
		$this->tipo = $tipo;
	}

}
