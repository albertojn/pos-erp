<?php
/** Value Object file for table retencion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Retencion extends VO
{
	/**
	  * Constructor de Retencion
	  * 
	  * Para construir un objeto de tipo Retencion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Retencion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_retencion']) ){
				$this->id_retencion = $data['id_retencion'];
			}
			if( isset($data['monto_porcentaje']) ){
				$this->monto_porcentaje = $data['monto_porcentaje'];
			}
			if( isset($data['es_monto']) ){
				$this->es_monto = $data['es_monto'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Retencion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_retencion" => $this->id_retencion,
			"monto_porcentaje" => $this->monto_porcentaje,
			"es_monto" => $this->es_monto,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_retencion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_retencion;

	/**
	  * monto_porcentaje
	  * 
	  * El monto o el porcentaje de la retencionde la <br>
	  * @access public
	  * @var float
	  */
	public $monto_porcentaje;

	/**
	  * es_monto
	  * 
	  * Verdadero si el valor del campo monto_porcentaje es un monto, false si es un porcentaje<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $es_monto;

	/**
	  * nombre
	  * 
	  * El nombre de la retencion<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * DEscripcion larga de la retencion<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * getIdRetencion
	  * 
	  * Get the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdRetencion()
	{
		return $this->id_retencion;
	}

	/**
	  * setIdRetencion( $id_retencion )
	  * 
	  * Set the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_retencion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdRetencion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdRetencion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdRetencion( $id_retencion )
	{
		$this->id_retencion = $id_retencion;
	}

	/**
	  * getMontoPorcentaje
	  * 
	  * Get the <i>monto_porcentaje</i> property for this object. Donde <i>monto_porcentaje</i> es El monto o el porcentaje de la retencionde la 
	  * @return float
	  */
	final public function getMontoPorcentaje()
	{
		return $this->monto_porcentaje;
	}

	/**
	  * setMontoPorcentaje( $monto_porcentaje )
	  * 
	  * Set the <i>monto_porcentaje</i> property for this object. Donde <i>monto_porcentaje</i> es El monto o el porcentaje de la retencionde la .
	  * Una validacion basica se hara aqui para comprobar que <i>monto_porcentaje</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMontoPorcentaje( $monto_porcentaje )
	{
		$this->monto_porcentaje = $monto_porcentaje;
	}

	/**
	  * getEsMonto
	  * 
	  * Get the <i>es_monto</i> property for this object. Donde <i>es_monto</i> es Verdadero si el valor del campo monto_porcentaje es un monto, false si es un porcentaje
	  * @return tinyint(1)
	  */
	final public function getEsMonto()
	{
		return $this->es_monto;
	}

	/**
	  * setEsMonto( $es_monto )
	  * 
	  * Set the <i>es_monto</i> property for this object. Donde <i>es_monto</i> es Verdadero si el valor del campo monto_porcentaje es un monto, false si es un porcentaje.
	  * Una validacion basica se hara aqui para comprobar que <i>es_monto</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setEsMonto( $es_monto )
	{
		$this->es_monto = $es_monto;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es El nombre de la retencion
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es El nombre de la retencion.
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
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es DEscripcion larga de la retencion
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es DEscripcion larga de la retencion.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

}
