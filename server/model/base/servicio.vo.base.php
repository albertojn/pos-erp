<?php
/** Value Object file for table servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Servicio extends VO
{
	/**
	  * Constructor de Servicio
	  * 
	  * Para construir un objeto de tipo Servicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Servicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
			if( isset($data['nombre_servicio']) ){
				$this->nombre_servicio = $data['nombre_servicio'];
			}
			if( isset($data['metodo_costeo']) ){
				$this->metodo_costeo = $data['metodo_costeo'];
			}
			if( isset($data['codigo_servicio']) ){
				$this->codigo_servicio = $data['codigo_servicio'];
			}
			if( isset($data['compra_en_mostrador']) ){
				$this->compra_en_mostrador = $data['compra_en_mostrador'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
			if( isset($data['descripcion_servicio']) ){
				$this->descripcion_servicio = $data['descripcion_servicio'];
			}
			if( isset($data['costo_estandar']) ){
				$this->costo_estandar = $data['costo_estandar'];
			}
			if( isset($data['garantia']) ){
				$this->garantia = $data['garantia'];
			}
			if( isset($data['control_existencia']) ){
				$this->control_existencia = $data['control_existencia'];
			}
			if( isset($data['foto_servicio']) ){
				$this->foto_servicio = $data['foto_servicio'];
			}
			if( isset($data['precio']) ){
				$this->precio = $data['precio'];
			}
			if( isset($data['extra_params']) ){
				$this->extra_params = $data['extra_params'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Servicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_servicio" => $this->id_servicio,
			"nombre_servicio" => $this->nombre_servicio,
			"metodo_costeo" => $this->metodo_costeo,
			"codigo_servicio" => $this->codigo_servicio,
			"compra_en_mostrador" => $this->compra_en_mostrador,
			"activo" => $this->activo,
			"descripcion_servicio" => $this->descripcion_servicio,
			"costo_estandar" => $this->costo_estandar,
			"garantia" => $this->garantia,
			"control_existencia" => $this->control_existencia,
			"foto_servicio" => $this->foto_servicio,
			"precio" => $this->precio,
			"extra_params" => $this->extra_params
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_servicio
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_servicio;

	/**
	  * nombre_servicio
	  * 
	  * nombre del servicio<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $nombre_servicio;

	/**
	  * metodo_costeo
	  * 
	  * Si el precio final se tomara del precio base de este servicio o de su costo<br>
	  * @access public
	  * @var enum('precio','costo','variable')
	  */
	public $metodo_costeo;

	/**
	  * codigo_servicio
	  * 
	  * Codigo de control del servicio manejado por la empresa, no se puede repetir<br>
	  * @access public
	  * @var varchar(20)
	  */
	public $codigo_servicio;

	/**
	  * compra_en_mostrador
	  * 
	  * Verdadero si este servicio se puede comprar en mostrador, para aquello de compra-venta. Para poder hacer esto, el sistema debe poder hacer compras en mostrador<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $compra_en_mostrador;

	/**
	  * activo
	  * 
	  * Si el servicio esta activo<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * descripcion_servicio
	  * 
	  * Descripcion del servicio<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion_servicio;

	/**
	  * costo_estandar
	  * 
	  * Valor del costo estandar del servicio<br>
	  * @access public
	  * @var float
	  */
	public $costo_estandar;

	/**
	  * garantia
	  * 
	  * Si este servicio tiene una garantÃƒÆ’Ã‚Â­a en meses.<br>
	  * @access public
	  * @var int(11)
	  */
	public $garantia;

	/**
	  * control_existencia
	  * 
	  * 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = LoteCaractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote<br>
	  * @access public
	  * @var int(11)
	  */
	public $control_existencia;

	/**
	  * foto_servicio
	  * 
	  * Url de la foto del servicio<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $foto_servicio;

	/**
	  * precio
	  * 
	  * El precio fijo del servicio<br>
	  * @access public
	  * @var float
	  */
	public $precio;

	/**
	  * extra_params
	  * 
	  * Un json con valores extra que se necesitan llenar<br>
	  * @access public
	  * @var text
	  */
	public $extra_params;

	/**
	  * getIdServicio
	  * 
	  * Get the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdServicio()
	{
		return $this->id_servicio;
	}

	/**
	  * setIdServicio( $id_servicio )
	  * 
	  * Set the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdServicio( $id_servicio )
	{
		$this->id_servicio = $id_servicio;
	}

	/**
	  * getNombreServicio
	  * 
	  * Get the <i>nombre_servicio</i> property for this object. Donde <i>nombre_servicio</i> es nombre del servicio
	  * @return varchar(50)
	  */
	final public function getNombreServicio()
	{
		return $this->nombre_servicio;
	}

	/**
	  * setNombreServicio( $nombre_servicio )
	  * 
	  * Set the <i>nombre_servicio</i> property for this object. Donde <i>nombre_servicio</i> es nombre del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre_servicio</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setNombreServicio( $nombre_servicio )
	{
		$this->nombre_servicio = $nombre_servicio;
	}

	/**
	  * getMetodoCosteo
	  * 
	  * Get the <i>metodo_costeo</i> property for this object. Donde <i>metodo_costeo</i> es Si el precio final se tomara del precio base de este servicio o de su costo
	  * @return enum('precio','costo','variable')
	  */
	final public function getMetodoCosteo()
	{
		return $this->metodo_costeo;
	}

	/**
	  * setMetodoCosteo( $metodo_costeo )
	  * 
	  * Set the <i>metodo_costeo</i> property for this object. Donde <i>metodo_costeo</i> es Si el precio final se tomara del precio base de este servicio o de su costo.
	  * Una validacion basica se hara aqui para comprobar que <i>metodo_costeo</i> es de tipo <i>enum('precio','costo','variable')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('precio','costo','variable')
	  */
	final public function setMetodoCosteo( $metodo_costeo )
	{
		$this->metodo_costeo = $metodo_costeo;
	}

	/**
	  * getCodigoServicio
	  * 
	  * Get the <i>codigo_servicio</i> property for this object. Donde <i>codigo_servicio</i> es Codigo de control del servicio manejado por la empresa, no se puede repetir
	  * @return varchar(20)
	  */
	final public function getCodigoServicio()
	{
		return $this->codigo_servicio;
	}

	/**
	  * setCodigoServicio( $codigo_servicio )
	  * 
	  * Set the <i>codigo_servicio</i> property for this object. Donde <i>codigo_servicio</i> es Codigo de control del servicio manejado por la empresa, no se puede repetir.
	  * Una validacion basica se hara aqui para comprobar que <i>codigo_servicio</i> es de tipo <i>varchar(20)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(20)
	  */
	final public function setCodigoServicio( $codigo_servicio )
	{
		$this->codigo_servicio = $codigo_servicio;
	}

	/**
	  * getCompraEnMostrador
	  * 
	  * Get the <i>compra_en_mostrador</i> property for this object. Donde <i>compra_en_mostrador</i> es Verdadero si este servicio se puede comprar en mostrador, para aquello de compra-venta. Para poder hacer esto, el sistema debe poder hacer compras en mostrador
	  * @return tinyint(1)
	  */
	final public function getCompraEnMostrador()
	{
		return $this->compra_en_mostrador;
	}

	/**
	  * setCompraEnMostrador( $compra_en_mostrador )
	  * 
	  * Set the <i>compra_en_mostrador</i> property for this object. Donde <i>compra_en_mostrador</i> es Verdadero si este servicio se puede comprar en mostrador, para aquello de compra-venta. Para poder hacer esto, el sistema debe poder hacer compras en mostrador.
	  * Una validacion basica se hara aqui para comprobar que <i>compra_en_mostrador</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCompraEnMostrador( $compra_en_mostrador )
	{
		$this->compra_en_mostrador = $compra_en_mostrador;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Si el servicio esta activo
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Si el servicio esta activo.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

	/**
	  * getDescripcionServicio
	  * 
	  * Get the <i>descripcion_servicio</i> property for this object. Donde <i>descripcion_servicio</i> es Descripcion del servicio
	  * @return varchar(255)
	  */
	final public function getDescripcionServicio()
	{
		return $this->descripcion_servicio;
	}

	/**
	  * setDescripcionServicio( $descripcion_servicio )
	  * 
	  * Set the <i>descripcion_servicio</i> property for this object. Donde <i>descripcion_servicio</i> es Descripcion del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion_servicio</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcionServicio( $descripcion_servicio )
	{
		$this->descripcion_servicio = $descripcion_servicio;
	}

	/**
	  * getCostoEstandar
	  * 
	  * Get the <i>costo_estandar</i> property for this object. Donde <i>costo_estandar</i> es Valor del costo estandar del servicio
	  * @return float
	  */
	final public function getCostoEstandar()
	{
		return $this->costo_estandar;
	}

	/**
	  * setCostoEstandar( $costo_estandar )
	  * 
	  * Set the <i>costo_estandar</i> property for this object. Donde <i>costo_estandar</i> es Valor del costo estandar del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>costo_estandar</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCostoEstandar( $costo_estandar )
	{
		$this->costo_estandar = $costo_estandar;
	}

	/**
	  * getGarantia
	  * 
	  * Get the <i>garantia</i> property for this object. Donde <i>garantia</i> es Si este servicio tiene una garantÃƒÆ’Ã‚Â­a en meses.
	  * @return int(11)
	  */
	final public function getGarantia()
	{
		return $this->garantia;
	}

	/**
	  * setGarantia( $garantia )
	  * 
	  * Set the <i>garantia</i> property for this object. Donde <i>garantia</i> es Si este servicio tiene una garantÃƒÆ’Ã‚Â­a en meses..
	  * Una validacion basica se hara aqui para comprobar que <i>garantia</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setGarantia( $garantia )
	{
		$this->garantia = $garantia;
	}

	/**
	  * getControlExistencia
	  * 
	  * Get the <i>control_existencia</i> property for this object. Donde <i>control_existencia</i> es 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = LoteCaractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote
	  * @return int(11)
	  */
	final public function getControlExistencia()
	{
		return $this->control_existencia;
	}

	/**
	  * setControlExistencia( $control_existencia )
	  * 
	  * Set the <i>control_existencia</i> property for this object. Donde <i>control_existencia</i> es 00000001 = Unidades. 00000010 = Caractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = LoteCaractersticas. 00000100 = Series. 00001000 = Pedimentos. 00010000 = Lote.
	  * Una validacion basica se hara aqui para comprobar que <i>control_existencia</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setControlExistencia( $control_existencia )
	{
		$this->control_existencia = $control_existencia;
	}

	/**
	  * getFotoServicio
	  * 
	  * Get the <i>foto_servicio</i> property for this object. Donde <i>foto_servicio</i> es Url de la foto del servicio
	  * @return varchar(50)
	  */
	final public function getFotoServicio()
	{
		return $this->foto_servicio;
	}

	/**
	  * setFotoServicio( $foto_servicio )
	  * 
	  * Set the <i>foto_servicio</i> property for this object. Donde <i>foto_servicio</i> es Url de la foto del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>foto_servicio</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setFotoServicio( $foto_servicio )
	{
		$this->foto_servicio = $foto_servicio;
	}

	/**
	  * getPrecio
	  * 
	  * Get the <i>precio</i> property for this object. Donde <i>precio</i> es El precio fijo del servicio
	  * @return float
	  */
	final public function getPrecio()
	{
		return $this->precio;
	}

	/**
	  * setPrecio( $precio )
	  * 
	  * Set the <i>precio</i> property for this object. Donde <i>precio</i> es El precio fijo del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>precio</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPrecio( $precio )
	{
		$this->precio = $precio;
	}

	/**
	  * getExtraParams
	  * 
	  * Get the <i>extra_params</i> property for this object. Donde <i>extra_params</i> es Un json con valores extra que se necesitan llenar
	  * @return text
	  */
	final public function getExtraParams()
	{
		return $this->extra_params;
	}

	/**
	  * setExtraParams( $extra_params )
	  * 
	  * Set the <i>extra_params</i> property for this object. Donde <i>extra_params</i> es Un json con valores extra que se necesitan llenar.
	  * Una validacion basica se hara aqui para comprobar que <i>extra_params</i> es de tipo <i>text</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param text
	  */
	final public function setExtraParams( $extra_params )
	{
		$this->extra_params = $extra_params;
	}

}
