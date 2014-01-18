<?php
/** Value Object file for table version.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Version extends VO
{
	/**
	  * Constructor de Version
	  * 
	  * Para construir un objeto de tipo Version debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Version
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_version']) ){
				$this->id_version = $data['id_version'];
			}
			if( isset($data['id_tarifa']) ){
				$this->id_tarifa = $data['id_tarifa'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['fecha_inicio']) ){
				$this->fecha_inicio = $data['fecha_inicio'];
			}
			if( isset($data['fecha_fin']) ){
				$this->fecha_fin = $data['fecha_fin'];
			}
			if( isset($data['default']) ){
				$this->default = $data['default'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Version en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_version" => $this->id_version,
			"id_tarifa" => $this->id_tarifa,
			"nombre" => $this->nombre,
			"activa" => $this->activa,
			"fecha_inicio" => $this->fecha_inicio,
			"fecha_fin" => $this->fecha_fin,
			"default" => $this->default
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_version
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_version;

	/**
	  * id_tarifa
	  * 
	  * Id de la tarifa a la que pertenece esta version<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa;

	/**
	  * nombre
	  * 
	  * Nombre de la version<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * activa
	  * 
	  * Si la version es la version activa de esta tarifa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * fecha_inicio
	  * 
	  * Fecha a partir de la cual se aplican las reglas de esta version<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_inicio;

	/**
	  * fecha_fin
	  * 
	  * Fecha a partir de la cual se dejaran de aplicar las reglas de esta version<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_fin;

	/**
	  * default
	  * 
	  * Si esta version es la version default de la tarifa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $default;

	/**
	  * getIdVersion
	  * 
	  * Get the <i>id_version</i> property for this object. Donde <i>id_version</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdVersion()
	{
		return $this->id_version;
	}

	/**
	  * setIdVersion( $id_version )
	  * 
	  * Set the <i>id_version</i> property for this object. Donde <i>id_version</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_version</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdVersion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdVersion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdVersion( $id_version )
	{
		$this->id_version = $id_version;
	}

	/**
	  * getIdTarifa
	  * 
	  * Get the <i>id_tarifa</i> property for this object. Donde <i>id_tarifa</i> es Id de la tarifa a la que pertenece esta version
	  * @return int(11)
	  */
	final public function getIdTarifa()
	{
		return $this->id_tarifa;
	}

	/**
	  * setIdTarifa( $id_tarifa )
	  * 
	  * Set the <i>id_tarifa</i> property for this object. Donde <i>id_tarifa</i> es Id de la tarifa a la que pertenece esta version.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifa( $id_tarifa )
	{
		$this->id_tarifa = $id_tarifa;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la version
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la version.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si la version es la version activa de esta tarifa
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si la version es la version activa de esta tarifa.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getFechaInicio
	  * 
	  * Get the <i>fecha_inicio</i> property for this object. Donde <i>fecha_inicio</i> es Fecha a partir de la cual se aplican las reglas de esta version
	  * @return int(11)
	  */
	final public function getFechaInicio()
	{
		return $this->fecha_inicio;
	}

	/**
	  * setFechaInicio( $fecha_inicio )
	  * 
	  * Set the <i>fecha_inicio</i> property for this object. Donde <i>fecha_inicio</i> es Fecha a partir de la cual se aplican las reglas de esta version.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_inicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaInicio( $fecha_inicio )
	{
		$this->fecha_inicio = $fecha_inicio;
	}

	/**
	  * getFechaFin
	  * 
	  * Get the <i>fecha_fin</i> property for this object. Donde <i>fecha_fin</i> es Fecha a partir de la cual se dejaran de aplicar las reglas de esta version
	  * @return int(11)
	  */
	final public function getFechaFin()
	{
		return $this->fecha_fin;
	}

	/**
	  * setFechaFin( $fecha_fin )
	  * 
	  * Set the <i>fecha_fin</i> property for this object. Donde <i>fecha_fin</i> es Fecha a partir de la cual se dejaran de aplicar las reglas de esta version.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_fin</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaFin( $fecha_fin )
	{
		$this->fecha_fin = $fecha_fin;
	}

	/**
	  * getDefault
	  * 
	  * Get the <i>default</i> property for this object. Donde <i>default</i> es Si esta version es la version default de la tarifa
	  * @return tinyint(1)
	  */
	final public function getDefault()
	{
		return $this->default;
	}

	/**
	  * setDefault( $default )
	  * 
	  * Set the <i>default</i> property for this object. Donde <i>default</i> es Si esta version es la version default de la tarifa.
	  * Una validacion basica se hara aqui para comprobar que <i>default</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setDefault( $default )
	{
		$this->default = $default;
	}

}
