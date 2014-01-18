<?php
/** Value Object file for table unidad_medida.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class UnidadMedida extends VO
{
	/**
	  * Constructor de UnidadMedida
	  * 
	  * Para construir un objeto de tipo UnidadMedida debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return UnidadMedida
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_unidad_medida']) ){
				$this->id_unidad_medida = $data['id_unidad_medida'];
			}
			if( isset($data['id_categoria_unidad_medida']) ){
				$this->id_categoria_unidad_medida = $data['id_categoria_unidad_medida'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['abreviacion']) ){
				$this->abreviacion = $data['abreviacion'];
			}
			if( isset($data['tipo_unidad_medida']) ){
				$this->tipo_unidad_medida = $data['tipo_unidad_medida'];
			}
			if( isset($data['factor_conversion']) ){
				$this->factor_conversion = $data['factor_conversion'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto UnidadMedida en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_unidad_medida" => $this->id_unidad_medida,
			"id_categoria_unidad_medida" => $this->id_categoria_unidad_medida,
			"descripcion" => $this->descripcion,
			"abreviacion" => $this->abreviacion,
			"tipo_unidad_medida" => $this->tipo_unidad_medida,
			"factor_conversion" => $this->factor_conversion,
			"activa" => $this->activa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_unidad_medida
	  * 
	  * Llave primaria de la llave<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_unidad_medida;

	/**
	  * id_categoria_unidad_medida
	  * 
	  * Id de la categoria de unidad de medidad a la que pertenece<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_categoria_unidad_medida;

	/**
	  * descripcion
	  * 
	  * Descripcion de la nueva unidad de medida<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $descripcion;

	/**
	  * abreviacion
	  * 
	  * Descripcion corta de la nueva unidad de medida<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $abreviacion;

	/**
	  * tipo_unidad_medida
	  * 
	  * Indica que tipo de unidad de medida<br>
	  * @access public
	  * @var enum('Referencia
	  */
	public $tipo_unidad_medida;

	/**
	  * factor_conversion
	  * 
	  * Numero de veces que es mas grande esta UdM que la de referencia<br>
	  * @access public
	  * @var float
	  */
	public $factor_conversion;

	/**
	  * activa
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * getIdUnidadMedida
	  * 
	  * Get the <i>id_unidad_medida</i> property for this object. Donde <i>id_unidad_medida</i> es Llave primaria de la llave
	  * @return int(11)
	  */
	final public function getIdUnidadMedida()
	{
		return $this->id_unidad_medida;
	}

	/**
	  * setIdUnidadMedida( $id_unidad_medida )
	  * 
	  * Set the <i>id_unidad_medida</i> property for this object. Donde <i>id_unidad_medida</i> es Llave primaria de la llave.
	  * Una validacion basica se hara aqui para comprobar que <i>id_unidad_medida</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdUnidadMedida( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUnidadMedida( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUnidadMedida( $id_unidad_medida )
	{
		$this->id_unidad_medida = $id_unidad_medida;
	}

	/**
	  * getIdCategoriaUnidadMedida
	  * 
	  * Get the <i>id_categoria_unidad_medida</i> property for this object. Donde <i>id_categoria_unidad_medida</i> es Id de la categoria de unidad de medidad a la que pertenece
	  * @return int(11)
	  */
	final public function getIdCategoriaUnidadMedida()
	{
		return $this->id_categoria_unidad_medida;
	}

	/**
	  * setIdCategoriaUnidadMedida( $id_categoria_unidad_medida )
	  * 
	  * Set the <i>id_categoria_unidad_medida</i> property for this object. Donde <i>id_categoria_unidad_medida</i> es Id de la categoria de unidad de medidad a la que pertenece.
	  * Una validacion basica se hara aqui para comprobar que <i>id_categoria_unidad_medida</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCategoriaUnidadMedida( $id_categoria_unidad_medida )
	{
		$this->id_categoria_unidad_medida = $id_categoria_unidad_medida;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion de la nueva unidad de medida
	  * @return varchar(50)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion de la nueva unidad de medida.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getAbreviacion
	  * 
	  * Get the <i>abreviacion</i> property for this object. Donde <i>abreviacion</i> es Descripcion corta de la nueva unidad de medida
	  * @return varchar(50)
	  */
	final public function getAbreviacion()
	{
		return $this->abreviacion;
	}

	/**
	  * setAbreviacion( $abreviacion )
	  * 
	  * Set the <i>abreviacion</i> property for this object. Donde <i>abreviacion</i> es Descripcion corta de la nueva unidad de medida.
	  * Una validacion basica se hara aqui para comprobar que <i>abreviacion</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setAbreviacion( $abreviacion )
	{
		$this->abreviacion = $abreviacion;
	}

	/**
	  * getTipoUnidadMedida
	  * 
	  * Get the <i>tipo_unidad_medida</i> property for this object. Donde <i>tipo_unidad_medida</i> es Indica que tipo de unidad de medida
	  * @return enum('Referencia
	  */
	final public function getTipoUnidadMedida()
	{
		return $this->tipo_unidad_medida;
	}

	/**
	  * setTipoUnidadMedida( $tipo_unidad_medida )
	  * 
	  * Set the <i>tipo_unidad_medida</i> property for this object. Donde <i>tipo_unidad_medida</i> es Indica que tipo de unidad de medida.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_unidad_medida</i> es de tipo <i>enum('Referencia</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('Referencia
	  */
	final public function setTipoUnidadMedida( $tipo_unidad_medida )
	{
		$this->tipo_unidad_medida = $tipo_unidad_medida;
	}

	/**
	  * getFactorConversion
	  * 
	  * Get the <i>factor_conversion</i> property for this object. Donde <i>factor_conversion</i> es Numero de veces que es mas grande esta UdM que la de referencia
	  * @return float
	  */
	final public function getFactorConversion()
	{
		return $this->factor_conversion;
	}

	/**
	  * setFactorConversion( $factor_conversion )
	  * 
	  * Set the <i>factor_conversion</i> property for this object. Donde <i>factor_conversion</i> es Numero de veces que es mas grande esta UdM que la de referencia.
	  * Una validacion basica se hara aqui para comprobar que <i>factor_conversion</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setFactorConversion( $factor_conversion )
	{
		$this->factor_conversion = $factor_conversion;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es  [Campo no documentado]
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

}
