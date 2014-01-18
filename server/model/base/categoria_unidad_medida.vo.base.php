<?php
/** Value Object file for table categoria_unidad_medida.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class CategoriaUnidadMedida extends VO
{
	/**
	  * Constructor de CategoriaUnidadMedida
	  * 
	  * Para construir un objeto de tipo CategoriaUnidadMedida debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return CategoriaUnidadMedida
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_categoria_unidad_medida']) ){
				$this->id_categoria_unidad_medida = $data['id_categoria_unidad_medida'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto CategoriaUnidadMedida en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_categoria_unidad_medida" => $this->id_categoria_unidad_medida,
			"descripcion" => $this->descripcion,
			"activa" => $this->activa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_categoria_unidad_medida
	  * 
	  * Llave primaria de la tabla<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_categoria_unidad_medida;

	/**
	  * descripcion
	  * 
	  * Descripcion de la categoria unidad de medida<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $descripcion;

	/**
	  * activa
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * getIdCategoriaUnidadMedida
	  * 
	  * Get the <i>id_categoria_unidad_medida</i> property for this object. Donde <i>id_categoria_unidad_medida</i> es Llave primaria de la tabla
	  * @return int(11)
	  */
	final public function getIdCategoriaUnidadMedida()
	{
		return $this->id_categoria_unidad_medida;
	}

	/**
	  * setIdCategoriaUnidadMedida( $id_categoria_unidad_medida )
	  * 
	  * Set the <i>id_categoria_unidad_medida</i> property for this object. Donde <i>id_categoria_unidad_medida</i> es Llave primaria de la tabla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_categoria_unidad_medida</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCategoriaUnidadMedida( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCategoriaUnidadMedida( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCategoriaUnidadMedida( $id_categoria_unidad_medida )
	{
		$this->id_categoria_unidad_medida = $id_categoria_unidad_medida;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion de la categoria unidad de medida
	  * @return varchar(50)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion de la categoria unidad de medida.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
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
