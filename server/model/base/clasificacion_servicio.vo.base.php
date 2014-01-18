<?php
/** Value Object file for table clasificacion_servicio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ClasificacionServicio extends VO
{
	/**
	  * Constructor de ClasificacionServicio
	  * 
	  * Para construir un objeto de tipo ClasificacionServicio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ClasificacionServicio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_clasificacion_servicio']) ){
				$this->id_clasificacion_servicio = $data['id_clasificacion_servicio'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['garantia']) ){
				$this->garantia = $data['garantia'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ClasificacionServicio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_clasificacion_servicio" => $this->id_clasificacion_servicio,
			"nombre" => $this->nombre,
			"garantia" => $this->garantia,
			"descripcion" => $this->descripcion,
			"activa" => $this->activa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_clasificacion_servicio
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_servicio;

	/**
	  * nombre
	  * 
	  * Nombre del servicio<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $nombre;

	/**
	  * garantia
	  * 
	  * Numero de meses de garantia que tendran los servicios de esta clasificacion los servicios <br>
	  * @access public
	  * @var int(11)
	  */
	public $garantia;

	/**
	  * descripcion
	  * 
	  * Descripcion larga de la clasificacion del servicio<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * activa
	  * 
	  * Si esta categoria de servicio esta fija o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * getIdClasificacionServicio
	  * 
	  * Get the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdClasificacionServicio()
	{
		return $this->id_clasificacion_servicio;
	}

	/**
	  * setIdClasificacionServicio( $id_clasificacion_servicio )
	  * 
	  * Set the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdClasificacionServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionServicio( $id_clasificacion_servicio )
	{
		$this->id_clasificacion_servicio = $id_clasificacion_servicio;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del servicio
	  * @return varchar(50)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getGarantia
	  * 
	  * Get the <i>garantia</i> property for this object. Donde <i>garantia</i> es Numero de meses de garantia que tendran los servicios de esta clasificacion los servicios 
	  * @return int(11)
	  */
	final public function getGarantia()
	{
		return $this->garantia;
	}

	/**
	  * setGarantia( $garantia )
	  * 
	  * Set the <i>garantia</i> property for this object. Donde <i>garantia</i> es Numero de meses de garantia que tendran los servicios de esta clasificacion los servicios .
	  * Una validacion basica se hara aqui para comprobar que <i>garantia</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setGarantia( $garantia )
	{
		$this->garantia = $garantia;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del servicio
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del servicio.
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
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta categoria de servicio esta fija o no
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta categoria de servicio esta fija o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

}
