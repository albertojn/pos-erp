<?php
/** Value Object file for table tipo_almacen.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class TipoAlmacen extends VO
{
	/**
	  * Constructor de TipoAlmacen
	  * 
	  * Para construir un objeto de tipo TipoAlmacen debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return TipoAlmacen
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_tipo_almacen']) ){
				$this->id_tipo_almacen = $data['id_tipo_almacen'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto TipoAlmacen en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_tipo_almacen" => $this->id_tipo_almacen,
			"descripcion" => $this->descripcion,
			"activo" => $this->activo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_tipo_almacen
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tipo_almacen;

	/**
	  * descripcion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $descripcion;

	/**
	  * activo
	  * 
	  * Si esta activo = 1, 0 = Inactivo<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * getIdTipoAlmacen
	  * 
	  * Get the <i>id_tipo_almacen</i> property for this object. Donde <i>id_tipo_almacen</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdTipoAlmacen()
	{
		return $this->id_tipo_almacen;
	}

	/**
	  * setIdTipoAlmacen( $id_tipo_almacen )
	  * 
	  * Set the <i>id_tipo_almacen</i> property for this object. Donde <i>id_tipo_almacen</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_tipo_almacen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdTipoAlmacen( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdTipoAlmacen( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdTipoAlmacen( $id_tipo_almacen )
	{
		$this->id_tipo_almacen = $id_tipo_almacen;
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
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Si esta activo = 1, 0 = Inactivo
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Si esta activo = 1, 0 = Inactivo.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

}
