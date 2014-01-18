<?php
/** Value Object file for table billete.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Billete extends VO
{
	/**
	  * Constructor de Billete
	  * 
	  * Para construir un objeto de tipo Billete debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Billete
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_billete']) ){
				$this->id_billete = $data['id_billete'];
			}
			if( isset($data['id_moneda']) ){
				$this->id_moneda = $data['id_moneda'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['valor']) ){
				$this->valor = $data['valor'];
			}
			if( isset($data['foto_billete']) ){
				$this->foto_billete = $data['foto_billete'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Billete en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_billete" => $this->id_billete,
			"id_moneda" => $this->id_moneda,
			"nombre" => $this->nombre,
			"valor" => $this->valor,
			"foto_billete" => $this->foto_billete,
			"activo" => $this->activo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_billete
	  * 
	  * Id de la tabla billete<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_billete;

	/**
	  * id_moneda
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_moneda;

	/**
	  * nombre
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $nombre;

	/**
	  * valor
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var float
	  */
	public $valor;

	/**
	  * foto_billete
	  * 
	  * Url de la foto del billete<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $foto_billete;

	/**
	  * activo
	  * 
	  * Si este billete esta activo o ya no se usa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * getIdBillete
	  * 
	  * Get the <i>id_billete</i> property for this object. Donde <i>id_billete</i> es Id de la tabla billete
	  * @return int(11)
	  */
	final public function getIdBillete()
	{
		return $this->id_billete;
	}

	/**
	  * setIdBillete( $id_billete )
	  * 
	  * Set the <i>id_billete</i> property for this object. Donde <i>id_billete</i> es Id de la tabla billete.
	  * Una validacion basica se hara aqui para comprobar que <i>id_billete</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdBillete( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdBillete( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdBillete( $id_billete )
	{
		$this->id_billete = $id_billete;
	}

	/**
	  * getIdMoneda
	  * 
	  * Get the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdMoneda()
	{
		return $this->id_moneda;
	}

	/**
	  * setIdMoneda( $id_moneda )
	  * 
	  * Set the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_moneda</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdMoneda( $id_moneda )
	{
		$this->id_moneda = $id_moneda;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado]
	  * @return varchar(50)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getValor
	  * 
	  * Get the <i>valor</i> property for this object. Donde <i>valor</i> es  [Campo no documentado]
	  * @return float
	  */
	final public function getValor()
	{
		return $this->valor;
	}

	/**
	  * setValor( $valor )
	  * 
	  * Set the <i>valor</i> property for this object. Donde <i>valor</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>valor</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setValor( $valor )
	{
		$this->valor = $valor;
	}

	/**
	  * getFotoBillete
	  * 
	  * Get the <i>foto_billete</i> property for this object. Donde <i>foto_billete</i> es Url de la foto del billete
	  * @return varchar(100)
	  */
	final public function getFotoBillete()
	{
		return $this->foto_billete;
	}

	/**
	  * setFotoBillete( $foto_billete )
	  * 
	  * Set the <i>foto_billete</i> property for this object. Donde <i>foto_billete</i> es Url de la foto del billete.
	  * Una validacion basica se hara aqui para comprobar que <i>foto_billete</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setFotoBillete( $foto_billete )
	{
		$this->foto_billete = $foto_billete;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Si este billete esta activo o ya no se usa
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Si este billete esta activo o ya no se usa.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

}
