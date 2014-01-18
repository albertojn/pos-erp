<?php
/** Value Object file for table inspeccion_consignacion_producto.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class InspeccionConsignacionProducto extends VO
{
	/**
	  * Constructor de InspeccionConsignacionProducto
	  * 
	  * Para construir un objeto de tipo InspeccionConsignacionProducto debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return InspeccionConsignacionProducto
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_inspeccion_consignacion']) ){
				$this->id_inspeccion_consignacion = $data['id_inspeccion_consignacion'];
			}
			if( isset($data['id_producto']) ){
				$this->id_producto = $data['id_producto'];
			}
			if( isset($data['id_unidad']) ){
				$this->id_unidad = $data['id_unidad'];
			}
			if( isset($data['cantidad_actual']) ){
				$this->cantidad_actual = $data['cantidad_actual'];
			}
			if( isset($data['cantidad_solicitada']) ){
				$this->cantidad_solicitada = $data['cantidad_solicitada'];
			}
			if( isset($data['cantidad_devuelta']) ){
				$this->cantidad_devuelta = $data['cantidad_devuelta'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto InspeccionConsignacionProducto en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_inspeccion_consignacion" => $this->id_inspeccion_consignacion,
			"id_producto" => $this->id_producto,
			"id_unidad" => $this->id_unidad,
			"cantidad_actual" => $this->cantidad_actual,
			"cantidad_solicitada" => $this->cantidad_solicitada,
			"cantidad_devuelta" => $this->cantidad_devuelta
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_inspeccion_consignacion
	  * 
	  * Id de la isnpeccion de consignacion<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_inspeccion_consignacion;

	/**
	  * id_producto
	  * 
	  * id del producto<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_producto;

	/**
	  * id_unidad
	  * 
	  * Id de la unidad del producto<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_unidad;

	/**
	  * cantidad_actual
	  * 
	  * cantidad del producto actualmente<br>
	  * @access public
	  * @var float
	  */
	public $cantidad_actual;

	/**
	  * cantidad_solicitada
	  * 
	  * cantidad del producto solicitado<br>
	  * @access public
	  * @var float
	  */
	public $cantidad_solicitada;

	/**
	  * cantidad_devuelta
	  * 
	  * cantidad del producto devuelto<br>
	  * @access public
	  * @var float
	  */
	public $cantidad_devuelta;

	/**
	  * getIdInspeccionConsignacion
	  * 
	  * Get the <i>id_inspeccion_consignacion</i> property for this object. Donde <i>id_inspeccion_consignacion</i> es Id de la isnpeccion de consignacion
	  * @return int(11)
	  */
	final public function getIdInspeccionConsignacion()
	{
		return $this->id_inspeccion_consignacion;
	}

	/**
	  * setIdInspeccionConsignacion( $id_inspeccion_consignacion )
	  * 
	  * Set the <i>id_inspeccion_consignacion</i> property for this object. Donde <i>id_inspeccion_consignacion</i> es Id de la isnpeccion de consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_inspeccion_consignacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdInspeccionConsignacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdInspeccionConsignacion( $id_inspeccion_consignacion )
	{
		$this->id_inspeccion_consignacion = $id_inspeccion_consignacion;
	}

	/**
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es id del producto
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es id del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdProducto( $id_producto )
	{
		$this->id_producto = $id_producto;
	}

	/**
	  * getIdUnidad
	  * 
	  * Get the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es Id de la unidad del producto
	  * @return int(11)
	  */
	final public function getIdUnidad()
	{
		return $this->id_unidad;
	}

	/**
	  * setIdUnidad( $id_unidad )
	  * 
	  * Set the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es Id de la unidad del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_unidad</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUnidad( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUnidad( $id_unidad )
	{
		$this->id_unidad = $id_unidad;
	}

	/**
	  * getCantidadActual
	  * 
	  * Get the <i>cantidad_actual</i> property for this object. Donde <i>cantidad_actual</i> es cantidad del producto actualmente
	  * @return float
	  */
	final public function getCantidadActual()
	{
		return $this->cantidad_actual;
	}

	/**
	  * setCantidadActual( $cantidad_actual )
	  * 
	  * Set the <i>cantidad_actual</i> property for this object. Donde <i>cantidad_actual</i> es cantidad del producto actualmente.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_actual</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidadActual( $cantidad_actual )
	{
		$this->cantidad_actual = $cantidad_actual;
	}

	/**
	  * getCantidadSolicitada
	  * 
	  * Get the <i>cantidad_solicitada</i> property for this object. Donde <i>cantidad_solicitada</i> es cantidad del producto solicitado
	  * @return float
	  */
	final public function getCantidadSolicitada()
	{
		return $this->cantidad_solicitada;
	}

	/**
	  * setCantidadSolicitada( $cantidad_solicitada )
	  * 
	  * Set the <i>cantidad_solicitada</i> property for this object. Donde <i>cantidad_solicitada</i> es cantidad del producto solicitado.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_solicitada</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidadSolicitada( $cantidad_solicitada )
	{
		$this->cantidad_solicitada = $cantidad_solicitada;
	}

	/**
	  * getCantidadDevuelta
	  * 
	  * Get the <i>cantidad_devuelta</i> property for this object. Donde <i>cantidad_devuelta</i> es cantidad del producto devuelto
	  * @return float
	  */
	final public function getCantidadDevuelta()
	{
		return $this->cantidad_devuelta;
	}

	/**
	  * setCantidadDevuelta( $cantidad_devuelta )
	  * 
	  * Set the <i>cantidad_devuelta</i> property for this object. Donde <i>cantidad_devuelta</i> es cantidad del producto devuelto.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_devuelta</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidadDevuelta( $cantidad_devuelta )
	{
		$this->cantidad_devuelta = $cantidad_devuelta;
	}

}
