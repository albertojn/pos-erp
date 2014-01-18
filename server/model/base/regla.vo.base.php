<?php
/** Value Object file for table regla.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Regla extends VO
{
	/**
	  * Constructor de Regla
	  * 
	  * Para construir un objeto de tipo Regla debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Regla
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_regla']) ){
				$this->id_regla = $data['id_regla'];
			}
			if( isset($data['id_version']) ){
				$this->id_version = $data['id_version'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['id_producto']) ){
				$this->id_producto = $data['id_producto'];
			}
			if( isset($data['id_clasificacion_producto']) ){
				$this->id_clasificacion_producto = $data['id_clasificacion_producto'];
			}
			if( isset($data['id_unidad']) ){
				$this->id_unidad = $data['id_unidad'];
			}
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
			if( isset($data['id_clasificacion_servicio']) ){
				$this->id_clasificacion_servicio = $data['id_clasificacion_servicio'];
			}
			if( isset($data['id_paquete']) ){
				$this->id_paquete = $data['id_paquete'];
			}
			if( isset($data['cantidad_minima']) ){
				$this->cantidad_minima = $data['cantidad_minima'];
			}
			if( isset($data['id_tarifa']) ){
				$this->id_tarifa = $data['id_tarifa'];
			}
			if( isset($data['porcentaje_utilidad']) ){
				$this->porcentaje_utilidad = $data['porcentaje_utilidad'];
			}
			if( isset($data['utilidad_neta']) ){
				$this->utilidad_neta = $data['utilidad_neta'];
			}
			if( isset($data['metodo_redondeo']) ){
				$this->metodo_redondeo = $data['metodo_redondeo'];
			}
			if( isset($data['margen_min']) ){
				$this->margen_min = $data['margen_min'];
			}
			if( isset($data['margen_max']) ){
				$this->margen_max = $data['margen_max'];
			}
			if( isset($data['secuencia']) ){
				$this->secuencia = $data['secuencia'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Regla en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_regla" => $this->id_regla,
			"id_version" => $this->id_version,
			"nombre" => $this->nombre,
			"id_producto" => $this->id_producto,
			"id_clasificacion_producto" => $this->id_clasificacion_producto,
			"id_unidad" => $this->id_unidad,
			"id_servicio" => $this->id_servicio,
			"id_clasificacion_servicio" => $this->id_clasificacion_servicio,
			"id_paquete" => $this->id_paquete,
			"cantidad_minima" => $this->cantidad_minima,
			"id_tarifa" => $this->id_tarifa,
			"porcentaje_utilidad" => $this->porcentaje_utilidad,
			"utilidad_neta" => $this->utilidad_neta,
			"metodo_redondeo" => $this->metodo_redondeo,
			"margen_min" => $this->margen_min,
			"margen_max" => $this->margen_max,
			"secuencia" => $this->secuencia
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_regla
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_regla;

	/**
	  * id_version
	  * 
	  * Id de la version a la que pertenece esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_version;

	/**
	  * nombre
	  * 
	  * Nombre de la regla<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * id_producto
	  * 
	  * Id del producto al que se le aplicara esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_producto;

	/**
	  * id_clasificacion_producto
	  * 
	  * Id de la clasificacion del producto al que se le aplicara esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_producto;

	/**
	  * id_unidad
	  * 
	  * Id de la unidad a la cual aplicara esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_unidad;

	/**
	  * id_servicio
	  * 
	  * Id del servicio al cual se le aplicara esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_servicio;

	/**
	  * id_clasificacion_servicio
	  * 
	  * Id de la clasificacion del servicio a la que se le aplicara esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_servicio;

	/**
	  * id_paquete
	  * 
	  * Id del paquete al cual se le aplicara esta regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_paquete;

	/**
	  * cantidad_minima
	  * 
	  * Cantidad minima de objeto necesarios apra aplicar esta regla<br>
	  * @access public
	  * @var float
	  */
	public $cantidad_minima;

	/**
	  * id_tarifa
	  * 
	  * Id de la tarifa en la cual se basa esta tarifa para obtener el precio base<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa;

	/**
	  * porcentaje_utilidad
	  * 
	  * Porcentaje de utilidad que se le ganara al precio base del objeto<br>
	  * @access public
	  * @var float
	  */
	public $porcentaje_utilidad;

	/**
	  * utilidad_neta
	  * 
	  * Utilidad neta que se le ganara al comerciar con el objeto<br>
	  * @access public
	  * @var float
	  */
	public $utilidad_neta;

	/**
	  * metodo_redondeo
	  * 
	  * Falta definir por Manuel<br>
	  * @access public
	  * @var float
	  */
	public $metodo_redondeo;

	/**
	  * margen_min
	  * 
	  * Falta definir por Manuel<br>
	  * @access public
	  * @var float
	  */
	public $margen_min;

	/**
	  * margen_max
	  * 
	  * Falta definir por Manuel<br>
	  * @access public
	  * @var float
	  */
	public $margen_max;

	/**
	  * secuencia
	  * 
	  * Secuencia de la regla<br>
	  * @access public
	  * @var int(11)
	  */
	public $secuencia;

	/**
	  * getIdRegla
	  * 
	  * Get the <i>id_regla</i> property for this object. Donde <i>id_regla</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdRegla()
	{
		return $this->id_regla;
	}

	/**
	  * setIdRegla( $id_regla )
	  * 
	  * Set the <i>id_regla</i> property for this object. Donde <i>id_regla</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_regla</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdRegla( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdRegla( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdRegla( $id_regla )
	{
		$this->id_regla = $id_regla;
	}

	/**
	  * getIdVersion
	  * 
	  * Get the <i>id_version</i> property for this object. Donde <i>id_version</i> es Id de la version a la que pertenece esta regla
	  * @return int(11)
	  */
	final public function getIdVersion()
	{
		return $this->id_version;
	}

	/**
	  * setIdVersion( $id_version )
	  * 
	  * Set the <i>id_version</i> property for this object. Donde <i>id_version</i> es Id de la version a la que pertenece esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_version</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdVersion( $id_version )
	{
		$this->id_version = $id_version;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la regla
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre de la regla.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es Id del producto al que se le aplicara esta regla
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es Id del producto al que se le aplicara esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdProducto( $id_producto )
	{
		$this->id_producto = $id_producto;
	}

	/**
	  * getIdClasificacionProducto
	  * 
	  * Get the <i>id_clasificacion_producto</i> property for this object. Donde <i>id_clasificacion_producto</i> es Id de la clasificacion del producto al que se le aplicara esta regla
	  * @return int(11)
	  */
	final public function getIdClasificacionProducto()
	{
		return $this->id_clasificacion_producto;
	}

	/**
	  * setIdClasificacionProducto( $id_clasificacion_producto )
	  * 
	  * Set the <i>id_clasificacion_producto</i> property for this object. Donde <i>id_clasificacion_producto</i> es Id de la clasificacion del producto al que se le aplicara esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdClasificacionProducto( $id_clasificacion_producto )
	{
		$this->id_clasificacion_producto = $id_clasificacion_producto;
	}

	/**
	  * getIdUnidad
	  * 
	  * Get the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es Id de la unidad a la cual aplicara esta regla
	  * @return int(11)
	  */
	final public function getIdUnidad()
	{
		return $this->id_unidad;
	}

	/**
	  * setIdUnidad( $id_unidad )
	  * 
	  * Set the <i>id_unidad</i> property for this object. Donde <i>id_unidad</i> es Id de la unidad a la cual aplicara esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_unidad</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUnidad( $id_unidad )
	{
		$this->id_unidad = $id_unidad;
	}

	/**
	  * getIdServicio
	  * 
	  * Get the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio al cual se le aplicara esta regla
	  * @return int(11)
	  */
	final public function getIdServicio()
	{
		return $this->id_servicio;
	}

	/**
	  * setIdServicio( $id_servicio )
	  * 
	  * Set the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio al cual se le aplicara esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdServicio( $id_servicio )
	{
		$this->id_servicio = $id_servicio;
	}

	/**
	  * getIdClasificacionServicio
	  * 
	  * Get the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es Id de la clasificacion del servicio a la que se le aplicara esta regla
	  * @return int(11)
	  */
	final public function getIdClasificacionServicio()
	{
		return $this->id_clasificacion_servicio;
	}

	/**
	  * setIdClasificacionServicio( $id_clasificacion_servicio )
	  * 
	  * Set the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es Id de la clasificacion del servicio a la que se le aplicara esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdClasificacionServicio( $id_clasificacion_servicio )
	{
		$this->id_clasificacion_servicio = $id_clasificacion_servicio;
	}

	/**
	  * getIdPaquete
	  * 
	  * Get the <i>id_paquete</i> property for this object. Donde <i>id_paquete</i> es Id del paquete al cual se le aplicara esta regla
	  * @return int(11)
	  */
	final public function getIdPaquete()
	{
		return $this->id_paquete;
	}

	/**
	  * setIdPaquete( $id_paquete )
	  * 
	  * Set the <i>id_paquete</i> property for this object. Donde <i>id_paquete</i> es Id del paquete al cual se le aplicara esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_paquete</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdPaquete( $id_paquete )
	{
		$this->id_paquete = $id_paquete;
	}

	/**
	  * getCantidadMinima
	  * 
	  * Get the <i>cantidad_minima</i> property for this object. Donde <i>cantidad_minima</i> es Cantidad minima de objeto necesarios apra aplicar esta regla
	  * @return float
	  */
	final public function getCantidadMinima()
	{
		return $this->cantidad_minima;
	}

	/**
	  * setCantidadMinima( $cantidad_minima )
	  * 
	  * Set the <i>cantidad_minima</i> property for this object. Donde <i>cantidad_minima</i> es Cantidad minima de objeto necesarios apra aplicar esta regla.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_minima</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCantidadMinima( $cantidad_minima )
	{
		$this->cantidad_minima = $cantidad_minima;
	}

	/**
	  * getIdTarifa
	  * 
	  * Get the <i>id_tarifa</i> property for this object. Donde <i>id_tarifa</i> es Id de la tarifa en la cual se basa esta tarifa para obtener el precio base
	  * @return int(11)
	  */
	final public function getIdTarifa()
	{
		return $this->id_tarifa;
	}

	/**
	  * setIdTarifa( $id_tarifa )
	  * 
	  * Set the <i>id_tarifa</i> property for this object. Donde <i>id_tarifa</i> es Id de la tarifa en la cual se basa esta tarifa para obtener el precio base.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifa( $id_tarifa )
	{
		$this->id_tarifa = $id_tarifa;
	}

	/**
	  * getPorcentajeUtilidad
	  * 
	  * Get the <i>porcentaje_utilidad</i> property for this object. Donde <i>porcentaje_utilidad</i> es Porcentaje de utilidad que se le ganara al precio base del objeto
	  * @return float
	  */
	final public function getPorcentajeUtilidad()
	{
		return $this->porcentaje_utilidad;
	}

	/**
	  * setPorcentajeUtilidad( $porcentaje_utilidad )
	  * 
	  * Set the <i>porcentaje_utilidad</i> property for this object. Donde <i>porcentaje_utilidad</i> es Porcentaje de utilidad que se le ganara al precio base del objeto.
	  * Una validacion basica se hara aqui para comprobar que <i>porcentaje_utilidad</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPorcentajeUtilidad( $porcentaje_utilidad )
	{
		$this->porcentaje_utilidad = $porcentaje_utilidad;
	}

	/**
	  * getUtilidadNeta
	  * 
	  * Get the <i>utilidad_neta</i> property for this object. Donde <i>utilidad_neta</i> es Utilidad neta que se le ganara al comerciar con el objeto
	  * @return float
	  */
	final public function getUtilidadNeta()
	{
		return $this->utilidad_neta;
	}

	/**
	  * setUtilidadNeta( $utilidad_neta )
	  * 
	  * Set the <i>utilidad_neta</i> property for this object. Donde <i>utilidad_neta</i> es Utilidad neta que se le ganara al comerciar con el objeto.
	  * Una validacion basica se hara aqui para comprobar que <i>utilidad_neta</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setUtilidadNeta( $utilidad_neta )
	{
		$this->utilidad_neta = $utilidad_neta;
	}

	/**
	  * getMetodoRedondeo
	  * 
	  * Get the <i>metodo_redondeo</i> property for this object. Donde <i>metodo_redondeo</i> es Falta definir por Manuel
	  * @return float
	  */
	final public function getMetodoRedondeo()
	{
		return $this->metodo_redondeo;
	}

	/**
	  * setMetodoRedondeo( $metodo_redondeo )
	  * 
	  * Set the <i>metodo_redondeo</i> property for this object. Donde <i>metodo_redondeo</i> es Falta definir por Manuel.
	  * Una validacion basica se hara aqui para comprobar que <i>metodo_redondeo</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMetodoRedondeo( $metodo_redondeo )
	{
		$this->metodo_redondeo = $metodo_redondeo;
	}

	/**
	  * getMargenMin
	  * 
	  * Get the <i>margen_min</i> property for this object. Donde <i>margen_min</i> es Falta definir por Manuel
	  * @return float
	  */
	final public function getMargenMin()
	{
		return $this->margen_min;
	}

	/**
	  * setMargenMin( $margen_min )
	  * 
	  * Set the <i>margen_min</i> property for this object. Donde <i>margen_min</i> es Falta definir por Manuel.
	  * Una validacion basica se hara aqui para comprobar que <i>margen_min</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMargenMin( $margen_min )
	{
		$this->margen_min = $margen_min;
	}

	/**
	  * getMargenMax
	  * 
	  * Get the <i>margen_max</i> property for this object. Donde <i>margen_max</i> es Falta definir por Manuel
	  * @return float
	  */
	final public function getMargenMax()
	{
		return $this->margen_max;
	}

	/**
	  * setMargenMax( $margen_max )
	  * 
	  * Set the <i>margen_max</i> property for this object. Donde <i>margen_max</i> es Falta definir por Manuel.
	  * Una validacion basica se hara aqui para comprobar que <i>margen_max</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMargenMax( $margen_max )
	{
		$this->margen_max = $margen_max;
	}

	/**
	  * getSecuencia
	  * 
	  * Get the <i>secuencia</i> property for this object. Donde <i>secuencia</i> es Secuencia de la regla
	  * @return int(11)
	  */
	final public function getSecuencia()
	{
		return $this->secuencia;
	}

	/**
	  * setSecuencia( $secuencia )
	  * 
	  * Set the <i>secuencia</i> property for this object. Donde <i>secuencia</i> es Secuencia de la regla.
	  * Una validacion basica se hara aqui para comprobar que <i>secuencia</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setSecuencia( $secuencia )
	{
		$this->secuencia = $secuencia;
	}

}
