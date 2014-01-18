<?php
/** Value Object file for table impuesto.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Impuesto extends VO
{
	/**
	  * Constructor de Impuesto
	  * 
	  * Para construir un objeto de tipo Impuesto debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Impuesto
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_impuesto']) ){
				$this->id_impuesto = $data['id_impuesto'];
			}
			if( isset($data['codigo']) ){
				$this->codigo = $data['codigo'];
			}
			if( isset($data['importe']) ){
				$this->importe = $data['importe'];
			}
			if( isset($data['incluido_precio']) ){
				$this->incluido_precio = $data['incluido_precio'];
			}
			if( isset($data['aplica']) ){
				$this->aplica = $data['aplica'];
			}
			if( isset($data['tipo']) ){
				$this->tipo = $data['tipo'];
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
	  * Este metodo permite tratar a un objeto Impuesto en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_impuesto" => $this->id_impuesto,
			"codigo" => $this->codigo,
			"importe" => $this->importe,
			"incluido_precio" => $this->incluido_precio,
			"aplica" => $this->aplica,
			"tipo" => $this->tipo,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"activo" => $this->activo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_impuesto
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_impuesto;

	/**
	  * codigo
	  * 
	  * Determina el cÃ³digo para identificar el impuesto<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $codigo;

	/**
	  * importe
	  * 
	  * El monto o el porcentaje correspondiente del impuesto<br>
	  * @access public
	  * @var float
	  */
	public $importe;

	/**
	  * incluido_precio
	  * 
	  * Determina si el importe estÃ¡ incluido en el precio<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $incluido_precio;

	/**
	  * aplica
	  * 
	  * Determina el Ã¡mbito al que aplica el impuesto (compra, venta, ambos)<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $aplica;

	/**
	  * tipo
	  * 
	  * Determina el tipo de impuesto: porcentaje, importe_fijo, ninguno, saldo_pendiente.<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $tipo;

	/**
	  * nombre
	  * 
	  * Nombre del impuesto<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion larga del impuesto<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * activo
	  * 
	  * Determina si estÃ¡ activo el impuesto<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * getIdImpuesto
	  * 
	  * Get the <i>id_impuesto</i> property for this object. Donde <i>id_impuesto</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdImpuesto()
	{
		return $this->id_impuesto;
	}

	/**
	  * setIdImpuesto( $id_impuesto )
	  * 
	  * Set the <i>id_impuesto</i> property for this object. Donde <i>id_impuesto</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_impuesto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdImpuesto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdImpuesto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdImpuesto( $id_impuesto )
	{
		$this->id_impuesto = $id_impuesto;
	}

	/**
	  * getCodigo
	  * 
	  * Get the <i>codigo</i> property for this object. Donde <i>codigo</i> es Determina el cÃ³digo para identificar el impuesto
	  * @return varchar(64)
	  */
	final public function getCodigo()
	{
		return $this->codigo;
	}

	/**
	  * setCodigo( $codigo )
	  * 
	  * Set the <i>codigo</i> property for this object. Donde <i>codigo</i> es Determina el cÃ³digo para identificar el impuesto.
	  * Una validacion basica se hara aqui para comprobar que <i>codigo</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setCodigo( $codigo )
	{
		$this->codigo = $codigo;
	}

	/**
	  * getImporte
	  * 
	  * Get the <i>importe</i> property for this object. Donde <i>importe</i> es El monto o el porcentaje correspondiente del impuesto
	  * @return float
	  */
	final public function getImporte()
	{
		return $this->importe;
	}

	/**
	  * setImporte( $importe )
	  * 
	  * Set the <i>importe</i> property for this object. Donde <i>importe</i> es El monto o el porcentaje correspondiente del impuesto.
	  * Una validacion basica se hara aqui para comprobar que <i>importe</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setImporte( $importe )
	{
		$this->importe = $importe;
	}

	/**
	  * getIncluidoPrecio
	  * 
	  * Get the <i>incluido_precio</i> property for this object. Donde <i>incluido_precio</i> es Determina si el importe estÃ¡ incluido en el precio
	  * @return tinyint(1)
	  */
	final public function getIncluidoPrecio()
	{
		return $this->incluido_precio;
	}

	/**
	  * setIncluidoPrecio( $incluido_precio )
	  * 
	  * Set the <i>incluido_precio</i> property for this object. Donde <i>incluido_precio</i> es Determina si el importe estÃ¡ incluido en el precio.
	  * Una validacion basica se hara aqui para comprobar que <i>incluido_precio</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setIncluidoPrecio( $incluido_precio )
	{
		$this->incluido_precio = $incluido_precio;
	}

	/**
	  * getAplica
	  * 
	  * Get the <i>aplica</i> property for this object. Donde <i>aplica</i> es Determina el Ã¡mbito al que aplica el impuesto (compra, venta, ambos)
	  * @return varchar(64)
	  */
	final public function getAplica()
	{
		return $this->aplica;
	}

	/**
	  * setAplica( $aplica )
	  * 
	  * Set the <i>aplica</i> property for this object. Donde <i>aplica</i> es Determina el Ã¡mbito al que aplica el impuesto (compra, venta, ambos).
	  * Una validacion basica se hara aqui para comprobar que <i>aplica</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setAplica( $aplica )
	{
		$this->aplica = $aplica;
	}

	/**
	  * getTipo
	  * 
	  * Get the <i>tipo</i> property for this object. Donde <i>tipo</i> es Determina el tipo de impuesto: porcentaje, importe_fijo, ninguno, saldo_pendiente.
	  * @return varchar(64)
	  */
	final public function getTipo()
	{
		return $this->tipo;
	}

	/**
	  * setTipo( $tipo )
	  * 
	  * Set the <i>tipo</i> property for this object. Donde <i>tipo</i> es Determina el tipo de impuesto: porcentaje, importe_fijo, ninguno, saldo_pendiente..
	  * Una validacion basica se hara aqui para comprobar que <i>tipo</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setTipo( $tipo )
	{
		$this->tipo = $tipo;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del impuesto
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del impuesto.
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
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga del impuesto
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga del impuesto.
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
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Determina si estÃ¡ activo el impuesto
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Determina si estÃ¡ activo el impuesto.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

}
