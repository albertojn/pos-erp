<?php
/** Value Object file for table clasificacion_proveedor.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ClasificacionProveedor extends VO
{
	/**
	  * Constructor de ClasificacionProveedor
	  * 
	  * Para construir un objeto de tipo ClasificacionProveedor debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ClasificacionProveedor
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_clasificacion_proveedor']) ){
				$this->id_clasificacion_proveedor = $data['id_clasificacion_proveedor'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['id_tarifa_compra']) ){
				$this->id_tarifa_compra = $data['id_tarifa_compra'];
			}
			if( isset($data['id_tarifa_venta']) ){
				$this->id_tarifa_venta = $data['id_tarifa_venta'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ClasificacionProveedor en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_clasificacion_proveedor" => $this->id_clasificacion_proveedor,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"activa" => $this->activa,
			"id_tarifa_compra" => $this->id_tarifa_compra,
			"id_tarifa_venta" => $this->id_tarifa_venta
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_clasificacion_proveedor
	  * 
	  * Id de la tabla clasificacion_proveedor<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_proveedor;

	/**
	  * nombre
	  * 
	  * Nombre de la clasificacion<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion larga de la clasificacion del proveedor<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * activa
	  * 
	  * Si esta clasificacion esat activa o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * id_tarifa_compra
	  * 
	  * Id de la tarifa de compra por default para esta clasificacion de proveedor<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa_compra;

	/**
	  * id_tarifa_venta
	  * 
	  * Id de la tarifa de venta por default para esta clasificacion de proveedor<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa_venta;

	/**
	  * getIdClasificacionProveedor
	  * 
	  * Get the <i>id_clasificacion_proveedor</i> property for this object. Donde <i>id_clasificacion_proveedor</i> es Id de la tabla clasificacion_proveedor
	  * @return int(11)
	  */
	final public function getIdClasificacionProveedor()
	{
		return $this->id_clasificacion_proveedor;
	}

	/**
	  * setIdClasificacionProveedor( $id_clasificacion_proveedor )
	  * 
	  * Set the <i>id_clasificacion_proveedor</i> property for this object. Donde <i>id_clasificacion_proveedor</i> es Id de la tabla clasificacion_proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_proveedor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdClasificacionProveedor( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionProveedor( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionProveedor( $id_clasificacion_proveedor )
	{
		$this->id_clasificacion_proveedor = $id_clasificacion_proveedor;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la clasificacion
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la clasificacion.
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
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del proveedor
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta clasificacion esat activa o no
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta clasificacion esat activa o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getIdTarifaCompra
	  * 
	  * Get the <i>id_tarifa_compra</i> property for this object. Donde <i>id_tarifa_compra</i> es Id de la tarifa de compra por default para esta clasificacion de proveedor
	  * @return int(11)
	  */
	final public function getIdTarifaCompra()
	{
		return $this->id_tarifa_compra;
	}

	/**
	  * setIdTarifaCompra( $id_tarifa_compra )
	  * 
	  * Set the <i>id_tarifa_compra</i> property for this object. Donde <i>id_tarifa_compra</i> es Id de la tarifa de compra por default para esta clasificacion de proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifaCompra( $id_tarifa_compra )
	{
		$this->id_tarifa_compra = $id_tarifa_compra;
	}

	/**
	  * getIdTarifaVenta
	  * 
	  * Get the <i>id_tarifa_venta</i> property for this object. Donde <i>id_tarifa_venta</i> es Id de la tarifa de venta por default para esta clasificacion de proveedor
	  * @return int(11)
	  */
	final public function getIdTarifaVenta()
	{
		return $this->id_tarifa_venta;
	}

	/**
	  * setIdTarifaVenta( $id_tarifa_venta )
	  * 
	  * Set the <i>id_tarifa_venta</i> property for this object. Donde <i>id_tarifa_venta</i> es Id de la tarifa de venta por default para esta clasificacion de proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifaVenta( $id_tarifa_venta )
	{
		$this->id_tarifa_venta = $id_tarifa_venta;
	}

}
