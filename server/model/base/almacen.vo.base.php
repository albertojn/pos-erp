<?php
/** Value Object file for table almacen.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Almacen extends VO
{
	/**
	  * Constructor de Almacen
	  * 
	  * Para construir un objeto de tipo Almacen debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Almacen
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_almacen']) ){
				$this->id_almacen = $data['id_almacen'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
			if( isset($data['id_tipo_almacen']) ){
				$this->id_tipo_almacen = $data['id_tipo_almacen'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
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
	  * Este metodo permite tratar a un objeto Almacen en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_almacen" => $this->id_almacen,
			"id_sucursal" => $this->id_sucursal,
			"id_empresa" => $this->id_empresa,
			"id_tipo_almacen" => $this->id_tipo_almacen,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"activo" => $this->activo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_almacen
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_almacen;

	/**
	  * id_sucursal
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * id_empresa
	  * 
	  * Id de la empresa de la cual pertenecen los productos que se almacenaran en este almacen<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * id_tipo_almacen
	  * 
	  * el tipo de almacen de que este tipo es<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tipo_almacen;

	/**
	  * nombre
	  * 
	  * Nombre del almacen<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion larga del almacen<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * activo
	  * 
	  * Si el almacen esta activo o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * getIdAlmacen
	  * 
	  * Get the <i>id_almacen</i> property for this object. Donde <i>id_almacen</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdAlmacen()
	{
		return $this->id_almacen;
	}

	/**
	  * setIdAlmacen( $id_almacen )
	  * 
	  * Set the <i>id_almacen</i> property for this object. Donde <i>id_almacen</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_almacen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdAlmacen( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAlmacen( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAlmacen( $id_almacen )
	{
		$this->id_almacen = $id_almacen;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa de la cual pertenecen los productos que se almacenaran en este almacen
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa de la cual pertenecen los productos que se almacenaran en este almacen.
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

	/**
	  * getIdTipoAlmacen
	  * 
	  * Get the <i>id_tipo_almacen</i> property for this object. Donde <i>id_tipo_almacen</i> es el tipo de almacen de que este tipo es
	  * @return int(11)
	  */
	final public function getIdTipoAlmacen()
	{
		return $this->id_tipo_almacen;
	}

	/**
	  * setIdTipoAlmacen( $id_tipo_almacen )
	  * 
	  * Set the <i>id_tipo_almacen</i> property for this object. Donde <i>id_tipo_almacen</i> es el tipo de almacen de que este tipo es.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tipo_almacen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTipoAlmacen( $id_tipo_almacen )
	{
		$this->id_tipo_almacen = $id_tipo_almacen;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del almacen
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del almacen.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga del almacen
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga del almacen.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Si el almacen esta activo o no
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Si el almacen esta activo o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

}
