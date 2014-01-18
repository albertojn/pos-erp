<?php
/** Value Object file for table traspaso_producto.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class TraspasoProducto extends VO
{
	/**
	  * Constructor de TraspasoProducto
	  * 
	  * Para construir un objeto de tipo TraspasoProducto debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return TraspasoProducto
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_traspaso']) ){
				$this->id_traspaso = $data['id_traspaso'];
			}
			if( isset($data['id_producto']) ){
				$this->id_producto = $data['id_producto'];
			}
			if( isset($data['id_unidad']) ){
				$this->id_unidad = $data['id_unidad'];
			}
			if( isset($data['cantidad_enviada']) ){
				$this->cantidad_enviada = $data['cantidad_enviada'];
			}
			if( isset($data['cantidad_recibida']) ){
				$this->cantidad_recibida = $data['cantidad_recibida'];
			}
			if( isset($data['id_lote_origen']) ){
				$this->id_lote_origen = $data['id_lote_origen'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto TraspasoProducto en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_traspaso" => $this->id_traspaso,
			"id_producto" => $this->id_producto,
			"id_unidad" => $this->id_unidad,
			"cantidad_enviada" => $this->cantidad_enviada,
			"cantidad_recibida" => $this->cantidad_recibida,
			"id_lote_origen" => $this->id_lote_origen
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_traspaso
	  * 
	  * Id del traspaso<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_traspaso;

	/**
	  * id_producto
	  * 
	  * Id del producto a traspasar<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_producto;

	/**
	  * id_unidad
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_unidad;

	/**
	  * cantidad_enviada
	  * 
	  * cantidad de producto a traspasar<br>
	  * @access public
	  * @var float
	  */
	public $cantidad_enviada;

	/**
	  * cantidad_recibida
	  * 
	  * Cantidad de producto recibida<br>
	  * @access public
	  * @var float
	  */
	public $cantidad_recibida;

	/**
	  * id_lote_origen
	  * 
	  * id del lote de donde provienen los productos<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_lote_origen;

	/**
	  * getIdTraspaso
	  * 
	  * Get the <i>id_traspaso</i> property for this object. Donde <i>id_traspaso</i> es Id del traspaso
	  * @return int(11)
	  */
	final public function getIdTraspaso()
	{
		return $this->id_traspaso;
	}

	/**
	  * setIdTraspaso( $id_traspaso )
	  * 
	  * Set the <i>id_traspaso</i> property for this object. Donde <i>id_traspaso</i> es Id del traspaso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_traspaso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdTraspaso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdTraspaso( $id_traspaso )
	{
		$this->id_traspaso = $id_traspaso;
	}

	/**
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es Id del producto a traspasar
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es Id del producto a traspasar.
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
	  * Get the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdUnidad()
	{
		return $this->id_unidad;
	}

	/**
	  * setIdUnidad( $id_unidad )
	  * 
	  * Set the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es  [Campo no documentado].
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
	  * getCantidadEnviada
	  * 
	  * Get the <i>cantidad_enviada</i> property for this object. Donde <i>cantidad_enviada</i> es cantidad de producto a traspasar
	  * @return float
	  */
	final public function getCantidadEnviada()
	{
		return $this->cantidad_enviada;
	}

	/**
	  * setCantidadEnviada( $cantidad_enviada )
	  * 
	  * Set the <i>cantidad_enviada</i> property for this object. Donde <i>cantidad_enviada</i> es cantidad de producto a traspasar.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_enviada</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidadEnviada( $cantidad_enviada )
	{
		$this->cantidad_enviada = $cantidad_enviada;
	}

	/**
	  * getCantidadRecibida
	  * 
	  * Get the <i>cantidad_recibida</i> property for this object. Donde <i>cantidad_recibida</i> es Cantidad de producto recibida
	  * @return float
	  */
	final public function getCantidadRecibida()
	{
		return $this->cantidad_recibida;
	}

	/**
	  * setCantidadRecibida( $cantidad_recibida )
	  * 
	  * Set the <i>cantidad_recibida</i> property for this object. Donde <i>cantidad_recibida</i> es Cantidad de producto recibida.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_recibida</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidadRecibida( $cantidad_recibida )
	{
		$this->cantidad_recibida = $cantidad_recibida;
	}

	/**
	  * getIdLoteOrigen
	  * 
	  * Get the <i>id_lote_origen</i> property for this object. Donde <i>id_lote_origen</i> es id del lote de donde provienen los productos
	  * @return int(11)
	  */
	final public function getIdLoteOrigen()
	{
		return $this->id_lote_origen;
	}

	/**
	  * setIdLoteOrigen( $id_lote_origen )
	  * 
	  * Set the <i>id_lote_origen</i> property for this object. Donde <i>id_lote_origen</i> es id del lote de donde provienen los productos.
	  * Una validacion basica se hara aqui para comprobar que <i>id_lote_origen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdLoteOrigen( $id_lote_origen )
	{
		$this->id_lote_origen = $id_lote_origen;
	}

}
