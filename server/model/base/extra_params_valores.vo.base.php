<?php
/** Value Object file for table extra_params_valores.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ExtraParamsValores extends VO
{
	/**
	  * Constructor de ExtraParamsValores
	  * 
	  * Para construir un objeto de tipo ExtraParamsValores debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ExtraParamsValores
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_extra_params_valores']) ){
				$this->id_extra_params_valores = $data['id_extra_params_valores'];
			}
			if( isset($data['id_extra_params_estructura']) ){
				$this->id_extra_params_estructura = $data['id_extra_params_estructura'];
			}
			if( isset($data['id_pk_tabla']) ){
				$this->id_pk_tabla = $data['id_pk_tabla'];
			}
			if( isset($data['val']) ){
				$this->val = $data['val'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ExtraParamsValores en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_extra_params_valores" => $this->id_extra_params_valores,
			"id_extra_params_estructura" => $this->id_extra_params_estructura,
			"id_pk_tabla" => $this->id_pk_tabla,
			"val" => $this->val
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_extra_params_valores
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_extra_params_valores;

	/**
	  * id_extra_params_estructura
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_extra_params_estructura;

	/**
	  * id_pk_tabla
	  * 
	  * el id del objeto en la tabla a la que se le agrego la columna<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_pk_tabla;

	/**
	  * val
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(256)
	  */
	public $val;

	/**
	  * getIdExtraParamsValores
	  * 
	  * Get the <i>id_extra_params_valores</i> property for this object. Donde <i>id_extra_params_valores</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdExtraParamsValores()
	{
		return $this->id_extra_params_valores;
	}

	/**
	  * setIdExtraParamsValores( $id_extra_params_valores )
	  * 
	  * Set the <i>id_extra_params_valores</i> property for this object. Donde <i>id_extra_params_valores</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_extra_params_valores</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdExtraParamsValores( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdExtraParamsValores( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdExtraParamsValores( $id_extra_params_valores )
	{
		$this->id_extra_params_valores = $id_extra_params_valores;
	}

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
	  * @param int(11)
	  */
	final public function setIdExtraParamsEstructura( $id_extra_params_estructura )
	{
		$this->id_extra_params_estructura = $id_extra_params_estructura;
	}

	/**
	  * getIdPkTabla
	  * 
	  * Get the <i>id_pk_tabla</i> property for this object. Donde <i>id_pk_tabla</i> es el id del objeto en la tabla a la que se le agrego la columna
	  * @return int(11)
	  */
	final public function getIdPkTabla()
	{
		return $this->id_pk_tabla;
	}

	/**
	  * setIdPkTabla( $id_pk_tabla )
	  * 
	  * Set the <i>id_pk_tabla</i> property for this object. Donde <i>id_pk_tabla</i> es el id del objeto en la tabla a la que se le agrego la columna.
	  * Una validacion basica se hara aqui para comprobar que <i>id_pk_tabla</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdPkTabla( $id_pk_tabla )
	{
		$this->id_pk_tabla = $id_pk_tabla;
	}

	/**
	  * getVal
	  * 
	  * Get the <i>val</i> property for this object. Donde <i>val</i> es  [Campo no documentado]
	  * @return varchar(256)
	  */
	final public function getVal()
	{
		return $this->val;
	}

	/**
	  * setVal( $val )
	  * 
	  * Set the <i>val</i> property for this object. Donde <i>val</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>val</i> es de tipo <i>varchar(256)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(256)
	  */
	final public function setVal( $val )
	{
		$this->val = $val;
	}

}
