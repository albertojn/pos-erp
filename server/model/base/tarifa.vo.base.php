<?php
/** Value Object file for table tarifa.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Tarifa extends VO
{
	/**
	  * Constructor de Tarifa
	  * 
	  * Para construir un objeto de tipo Tarifa debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Tarifa
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_tarifa']) ){
				$this->id_tarifa = $data['id_tarifa'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['tipo_tarifa']) ){
				$this->tipo_tarifa = $data['tipo_tarifa'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['id_moneda']) ){
				$this->id_moneda = $data['id_moneda'];
			}
			if( isset($data['default']) ){
				$this->default = $data['default'];
			}
			if( isset($data['id_version_default']) ){
				$this->id_version_default = $data['id_version_default'];
			}
			if( isset($data['id_version_activa']) ){
				$this->id_version_activa = $data['id_version_activa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Tarifa en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_tarifa" => $this->id_tarifa,
			"nombre" => $this->nombre,
			"tipo_tarifa" => $this->tipo_tarifa,
			"activa" => $this->activa,
			"id_moneda" => $this->id_moneda,
			"default" => $this->default,
			"id_version_default" => $this->id_version_default,
			"id_version_activa" => $this->id_version_activa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_tarifa
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa;

	/**
	  * nombre
	  * 
	  * Nombre de la tarifa<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * tipo_tarifa
	  * 
	  * Si el tipo de tarifa es de compra o de venta<br>
	  * @access public
	  * @var enum('compra','venta')
	  */
	public $tipo_tarifa;

	/**
	  * activa
	  * 
	  * Si la tarifa es activa o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * id_moneda
	  * 
	  * Moneda con la que se realizan los calclos de esta tarifa<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_moneda;

	/**
	  * default
	  * 
	  * Si esta tarifa es la default del sistema o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $default;

	/**
	  * id_version_default
	  * 
	  * Id de la version default de esta tarifa<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_version_default;

	/**
	  * id_version_activa
	  * 
	  * Id de la version activa de esta tarifa<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_version_activa;

	/**
	  * getIdTarifa
	  * 
	  * Get the <i>id_tarifa</i> property for this object. Donde <i>id_tarifa</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdTarifa()
	{
		return $this->id_tarifa;
	}

	/**
	  * setIdTarifa( $id_tarifa )
	  * 
	  * Set the <i>id_tarifa</i> property for this object. Donde <i>id_tarifa</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdTarifa( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdTarifa( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdTarifa( $id_tarifa )
	{
		$this->id_tarifa = $id_tarifa;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la tarifa
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la tarifa.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getTipoTarifa
	  * 
	  * Get the <i>tipo_tarifa</i> property for this object. Donde <i>tipo_tarifa</i> es Si el tipo de tarifa es de compra o de venta
	  * @return enum('compra','venta')
	  */
	final public function getTipoTarifa()
	{
		return $this->tipo_tarifa;
	}

	/**
	  * setTipoTarifa( $tipo_tarifa )
	  * 
	  * Set the <i>tipo_tarifa</i> property for this object. Donde <i>tipo_tarifa</i> es Si el tipo de tarifa es de compra o de venta.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_tarifa</i> es de tipo <i>enum('compra','venta')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('compra','venta')
	  */
	final public function setTipoTarifa( $tipo_tarifa )
	{
		$this->tipo_tarifa = $tipo_tarifa;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si la tarifa es activa o no
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si la tarifa es activa o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getIdMoneda
	  * 
	  * Get the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es Moneda con la que se realizan los calclos de esta tarifa
	  * @return int(11)
	  */
	final public function getIdMoneda()
	{
		return $this->id_moneda;
	}

	/**
	  * setIdMoneda( $id_moneda )
	  * 
	  * Set the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es Moneda con la que se realizan los calclos de esta tarifa.
	  * Una validacion basica se hara aqui para comprobar que <i>id_moneda</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdMoneda( $id_moneda )
	{
		$this->id_moneda = $id_moneda;
	}

	/**
	  * getDefault
	  * 
	  * Get the <i>default</i> property for this object. Donde <i>default</i> es Si esta tarifa es la default del sistema o no
	  * @return tinyint(1)
	  */
	final public function getDefault()
	{
		return $this->default;
	}

	/**
	  * setDefault( $default )
	  * 
	  * Set the <i>default</i> property for this object. Donde <i>default</i> es Si esta tarifa es la default del sistema o no.
	  * Una validacion basica se hara aqui para comprobar que <i>default</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setDefault( $default )
	{
		$this->default = $default;
	}

	/**
	  * getIdVersionDefault
	  * 
	  * Get the <i>id_version_default</i> property for this object. Donde <i>id_version_default</i> es Id de la version default de esta tarifa
	  * @return int(11)
	  */
	final public function getIdVersionDefault()
	{
		return $this->id_version_default;
	}

	/**
	  * setIdVersionDefault( $id_version_default )
	  * 
	  * Set the <i>id_version_default</i> property for this object. Donde <i>id_version_default</i> es Id de la version default de esta tarifa.
	  * Una validacion basica se hara aqui para comprobar que <i>id_version_default</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdVersionDefault( $id_version_default )
	{
		$this->id_version_default = $id_version_default;
	}

	/**
	  * getIdVersionActiva
	  * 
	  * Get the <i>id_version_activa</i> property for this object. Donde <i>id_version_activa</i> es Id de la version activa de esta tarifa
	  * @return int(11)
	  */
	final public function getIdVersionActiva()
	{
		return $this->id_version_activa;
	}

	/**
	  * setIdVersionActiva( $id_version_activa )
	  * 
	  * Set the <i>id_version_activa</i> property for this object. Donde <i>id_version_activa</i> es Id de la version activa de esta tarifa.
	  * Una validacion basica se hara aqui para comprobar que <i>id_version_activa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdVersionActiva( $id_version_activa )
	{
		$this->id_version_activa = $id_version_activa;
	}

}
