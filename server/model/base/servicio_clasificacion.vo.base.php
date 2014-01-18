<?php
/** Value Object file for table servicio_clasificacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ServicioClasificacion extends VO
{
	/**
	  * Constructor de ServicioClasificacion
	  * 
	  * Para construir un objeto de tipo ServicioClasificacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ServicioClasificacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
			if( isset($data['id_clasificacion_servicio']) ){
				$this->id_clasificacion_servicio = $data['id_clasificacion_servicio'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ServicioClasificacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_servicio" => $this->id_servicio,
			"id_clasificacion_servicio" => $this->id_clasificacion_servicio
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_servicio
	  * 
	  * Id del servicio <br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_servicio;

	/**
	  * id_clasificacion_servicio
	  * 
	  * Id de la clasificacio dnel servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_servicio;

	/**
	  * getIdServicio
	  * 
	  * Get the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio 
	  * @return int(11)
	  */
	final public function getIdServicio()
	{
		return $this->id_servicio;
	}

	/**
	  * setIdServicio( $id_servicio )
	  * 
	  * Set the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es Id del servicio .
	  * Una validacion basica se hara aqui para comprobar que <i>id_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdServicio( $id_servicio )
	{
		$this->id_servicio = $id_servicio;
	}

	/**
	  * getIdClasificacionServicio
	  * 
	  * Get the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es Id de la clasificacio dnel servicio
	  * @return int(11)
	  */
	final public function getIdClasificacionServicio()
	{
		return $this->id_clasificacion_servicio;
	}

	/**
	  * setIdClasificacionServicio( $id_clasificacion_servicio )
	  * 
	  * Set the <i>id_clasificacion_servicio</i> property for this object. Donde <i>id_clasificacion_servicio</i> es Id de la clasificacio dnel servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionServicio( $id_clasificacion_servicio )
	{
		$this->id_clasificacion_servicio = $id_clasificacion_servicio;
	}

}
