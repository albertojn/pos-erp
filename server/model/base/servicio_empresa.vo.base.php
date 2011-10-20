<?php
/** Value Object file for table servicio_empresa.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Andres
  * @access public
  * @package docs
  * 
  */

class ServicioEmpresa extends VO
{
	/**
	  * Constructor de ServicioEmpresa
	  * 
	  * Para construir un objeto de tipo ServicioEmpresa debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ServicioEmpresa
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
			if( isset($data['precio_utilidad']) ){
				$this->precio_utilidad = $data['precio_utilidad'];
			}
			if( isset($data['es_margen_utilidad']) ){
				$this->es_margen_utilidad = $data['es_margen_utilidad'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ServicioEmpresa en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_servicio" => $this->id_servicio,
			"id_empresa" => $this->id_empresa,
			"precio_utilidad" => $this->precio_utilidad,
			"es_margen_utilidad" => $this->es_margen_utilidad
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_servicio
	  * 
	  * Id del servicio <br>
	  * <b>Llave Primaria</b><br>
	  * @access protected
	  * @var int(11)
	  */
	protected $id_servicio;

	/**
	  * id_empresa
	  * 
	  * Id de la empresa en la que se ofrece este servicio<br>
	  * <b>Llave Primaria</b><br>
	  * @access protected
	  * @var int(11)
	  */
	protected $id_empresa;

	/**
	  * precio_utilidad
	  * 
	  * Precio o margen de utilidad con el que se vendera este servicio en esta empresa<br>
	  * @access protected
	  * @var float
	  */
	protected $precio_utilidad;

	/**
	  * es_margen_utilidad
	  * 
	  * Si el campo precio_utilidad es un margen de utilidad o un precio fijo<br>
	  * @access protected
	  * @var float
	  */
	protected $es_margen_utilidad;

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
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa en la que se ofrece este servicio
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa en la que se ofrece este servicio.
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdEmpresa( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

	/**
	  * getPrecioUtilidad
	  * 
	  * Get the <i>precio_utilidad</i> property for this object. Donde <i>precio_utilidad</i> es Precio o margen de utilidad con el que se vendera este servicio en esta empresa
	  * @return float
	  */
	final public function getPrecioUtilidad()
	{
		return $this->precio_utilidad;
	}

	/**
	  * setPrecioUtilidad( $precio_utilidad )
	  * 
	  * Set the <i>precio_utilidad</i> property for this object. Donde <i>precio_utilidad</i> es Precio o margen de utilidad con el que se vendera este servicio en esta empresa.
	  * Una validacion basica se hara aqui para comprobar que <i>precio_utilidad</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPrecioUtilidad( $precio_utilidad )
	{
		$this->precio_utilidad = $precio_utilidad;
	}

	/**
	  * getEsMargenUtilidad
	  * 
	  * Get the <i>es_margen_utilidad</i> property for this object. Donde <i>es_margen_utilidad</i> es Si el campo precio_utilidad es un margen de utilidad o un precio fijo
	  * @return float
	  */
	final public function getEsMargenUtilidad()
	{
		return $this->es_margen_utilidad;
	}

	/**
	  * setEsMargenUtilidad( $es_margen_utilidad )
	  * 
	  * Set the <i>es_margen_utilidad</i> property for this object. Donde <i>es_margen_utilidad</i> es Si el campo precio_utilidad es un margen de utilidad o un precio fijo.
	  * Una validacion basica se hara aqui para comprobar que <i>es_margen_utilidad</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setEsMargenUtilidad( $es_margen_utilidad )
	{
		$this->es_margen_utilidad = $es_margen_utilidad;
	}

}
