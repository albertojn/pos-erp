<?php
/** Value Object file for table extra_params_estructura.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ExtraParamsEstructura extends VO
{
	/**
	  * Constructor de ExtraParamsEstructura
	  * 
	  * Para construir un objeto de tipo ExtraParamsEstructura debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ExtraParamsEstructura
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_extra_params_estructura']) ){
				$this->id_extra_params_estructura = $data['id_extra_params_estructura'];
			}
			if( isset($data['tabla']) ){
				$this->tabla = $data['tabla'];
			}
			if( isset($data['campo']) ){
				$this->campo = $data['campo'];
			}
			if( isset($data['tipo']) ){
				$this->tipo = $data['tipo'];
			}
			if( isset($data['enum']) ){
				$this->enum = $data['enum'];
			}
			if( isset($data['longitud']) ){
				$this->longitud = $data['longitud'];
			}
			if( isset($data['obligatorio']) ){
				$this->obligatorio = $data['obligatorio'];
			}
			if( isset($data['caption']) ){
				$this->caption = $data['caption'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ExtraParamsEstructura en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_extra_params_estructura" => $this->id_extra_params_estructura,
			"tabla" => $this->tabla,
			"campo" => $this->campo,
			"tipo" => $this->tipo,
			"enum" => $this->enum,
			"longitud" => $this->longitud,
			"obligatorio" => $this->obligatorio,
			"caption" => $this->caption,
			"descripcion" => $this->descripcion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_extra_params_estructura
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_extra_params_estructura;

	/**
	  * tabla
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $tabla;

	/**
	  * campo
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $campo;

	/**
	  * tipo
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var enum('text','textarea','enum','password','string','int','float','bool','date')
	  */
	public $tipo;

	/**
	  * enum
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var longtext
	  */
	public $enum;

	/**
	  * longitud
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $longitud;

	/**
	  * obligatorio
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $obligatorio;

	/**
	  * caption
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $caption;

	/**
	  * descripcion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var text
	  */
	public $descripcion;

	/**
	  * getIdExtraParamsEstructura
	  * 
	  * Get the <i>id_extra_params_estructura</i> property for this object. Donde <i>id_extra_params_estructura</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdExtraParamsEstructura()
	{
		return $this->id_extra_params_estructura;
	}

	/**
	  * setIdExtraParamsEstructura( $id_extra_params_estructura )
	  * 
	  * Set the <i>id_extra_params_estructura</i> property for this object. Donde <i>id_extra_params_estructura</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_extra_params_estructura</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdExtraParamsEstructura( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdExtraParamsEstructura( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdExtraParamsEstructura( $id_extra_params_estructura )
	{
		$this->id_extra_params_estructura = $id_extra_params_estructura;
	}

	/**
	  * getTabla
	  * 
	  * Get the <i>tabla</i> property for this object. Donde <i>tabla</i> es  [Campo no documentado]
	  * @return varchar(32)
	  */
	final public function getTabla()
	{
		return $this->tabla;
	}

	/**
	  * setTabla( $tabla )
	  * 
	  * Set the <i>tabla</i> property for this object. Donde <i>tabla</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>tabla</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setTabla( $tabla )
	{
		$this->tabla = $tabla;
	}

	/**
	  * getCampo
	  * 
	  * Get the <i>campo</i> property for this object. Donde <i>campo</i> es  [Campo no documentado]
	  * @return varchar(32)
	  */
	final public function getCampo()
	{
		return $this->campo;
	}

	/**
	  * setCampo( $campo )
	  * 
	  * Set the <i>campo</i> property for this object. Donde <i>campo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>campo</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setCampo( $campo )
	{
		$this->campo = $campo;
	}

	/**
	  * getTipo
	  * 
	  * Get the <i>tipo</i> property for this object. Donde <i>tipo</i> es  [Campo no documentado]
	  * @return enum('text','textarea','enum','password','string','int','float','bool','date')
	  */
	final public function getTipo()
	{
		return $this->tipo;
	}

	/**
	  * setTipo( $tipo )
	  * 
	  * Set the <i>tipo</i> property for this object. Donde <i>tipo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>tipo</i> es de tipo <i>enum('text','textarea','enum','password','string','int','float','bool','date')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('text','textarea','enum','password','string','int','float','bool','date')
	  */
	final public function setTipo( $tipo )
	{
		$this->tipo = $tipo;
	}

	/**
	  * getEnum
	  * 
	  * Get the <i>enum</i> property for this object. Donde <i>enum</i> es  [Campo no documentado]
	  * @return longtext
	  */
	final public function getEnum()
	{
		return $this->enum;
	}

	/**
	  * setEnum( $enum )
	  * 
	  * Set the <i>enum</i> property for this object. Donde <i>enum</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>enum</i> es de tipo <i>longtext</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param longtext
	  */
	final public function setEnum( $enum )
	{
		$this->enum = $enum;
	}

	/**
	  * getLongitud
	  * 
	  * Get the <i>longitud</i> property for this object. Donde <i>longitud</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getLongitud()
	{
		return $this->longitud;
	}

	/**
	  * setLongitud( $longitud )
	  * 
	  * Set the <i>longitud</i> property for this object. Donde <i>longitud</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>longitud</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setLongitud( $longitud )
	{
		$this->longitud = $longitud;
	}

	/**
	  * getObligatorio
	  * 
	  * Get the <i>obligatorio</i> property for this object. Donde <i>obligatorio</i> es  [Campo no documentado]
	  * @return tinyint(1)
	  */
	final public function getObligatorio()
	{
		return $this->obligatorio;
	}

	/**
	  * setObligatorio( $obligatorio )
	  * 
	  * Set the <i>obligatorio</i> property for this object. Donde <i>obligatorio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>obligatorio</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setObligatorio( $obligatorio )
	{
		$this->obligatorio = $obligatorio;
	}

	/**
	  * getCaption
	  * 
	  * Get the <i>caption</i> property for this object. Donde <i>caption</i> es  [Campo no documentado]
	  * @return varchar(32)
	  */
	final public function getCaption()
	{
		return $this->caption;
	}

	/**
	  * setCaption( $caption )
	  * 
	  * Set the <i>caption</i> property for this object. Donde <i>caption</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>caption</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setCaption( $caption )
	{
		$this->caption = $caption;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado]
	  * @return text
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>text</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param text
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

}
