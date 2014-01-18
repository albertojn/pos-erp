<?php
/** Value Object file for table moneda.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Moneda extends VO
{
	/**
	  * Constructor de Moneda
	  * 
	  * Para construir un objeto de tipo Moneda debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Moneda
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_moneda']) ){
				$this->id_moneda = $data['id_moneda'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['simbolo']) ){
				$this->simbolo = $data['simbolo'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Moneda en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_moneda" => $this->id_moneda,
			"nombre" => $this->nombre,
			"simbolo" => $this->simbolo,
			"activa" => $this->activa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_moneda
	  * 
	  * Id de la tabla moneda<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_moneda;

	/**
	  * nombre
	  * 
	  * Nombre de la moneda<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * simbolo
	  * 
	  * Simbolo de la moneda (US$,NP$)<br>
	  * @access public
	  * @var varchar(10)
	  */
	public $simbolo;

	/**
	  * activa
	  * 
	  * Si esta moneda esta activa o ya no se usa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * getIdMoneda
	  * 
	  * Get the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es Id de la tabla moneda
	  * @return int(11)
	  */
	final public function getIdMoneda()
	{
		return $this->id_moneda;
	}

	/**
	  * setIdMoneda( $id_moneda )
	  * 
	  * Set the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es Id de la tabla moneda.
	  * Una validacion basica se hara aqui para comprobar que <i>id_moneda</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdMoneda( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdMoneda( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdMoneda( $id_moneda )
	{
		$this->id_moneda = $id_moneda;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la moneda
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la moneda.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getSimbolo
	  * 
	  * Get the <i>simbolo</i> property for this object. Donde <i>simbolo</i> es Simbolo de la moneda (US$,NP$)
	  * @return varchar(10)
	  */
	final public function getSimbolo()
	{
		return $this->simbolo;
	}

	/**
	  * setSimbolo( $simbolo )
	  * 
	  * Set the <i>simbolo</i> property for this object. Donde <i>simbolo</i> es Simbolo de la moneda (US$,NP$).
	  * Una validacion basica se hara aqui para comprobar que <i>simbolo</i> es de tipo <i>varchar(10)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(10)
	  */
	final public function setSimbolo( $simbolo )
	{
		$this->simbolo = $simbolo;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta moneda esta activa o ya no se usa
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta moneda esta activa o ya no se usa.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

}
