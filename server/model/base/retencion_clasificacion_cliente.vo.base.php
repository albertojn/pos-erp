<?php
/** Value Object file for table retencion_clasificacion_cliente.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Andres
  * @access public
  * @package docs
  * 
  */

class RetencionClasificacionCliente extends VO
{
	/**
	  * Constructor de RetencionClasificacionCliente
	  * 
	  * Para construir un objeto de tipo RetencionClasificacionCliente debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return RetencionClasificacionCliente
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_retencion']) ){
				$this->id_retencion = $data['id_retencion'];
			}
			if( isset($data['id_clasificacion_cliente']) ){
				$this->id_clasificacion_cliente = $data['id_clasificacion_cliente'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto RetencionClasificacionCliente en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_retencion" => $this->id_retencion,
			"id_clasificacion_cliente" => $this->id_clasificacion_cliente
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_retencion
	  * 
	  * Id del retencion a aplicar al tipo de cliente<br>
	  * <b>Llave Primaria</b><br>
	  * @access protected
	  * @var int(11)
	  */
	protected $id_retencion;

	/**
	  * id_clasificacion_cliente
	  * 
	  * Id de la clasificacion del cliente<br>
	  * <b>Llave Primaria</b><br>
	  * @access protected
	  * @var int(11)
	  */
	protected $id_clasificacion_cliente;

	/**
	  * getIdRetencion
	  * 
	  * Get the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id del retencion a aplicar al tipo de cliente
	  * @return int(11)
	  */
	final public function getIdRetencion()
	{
		return $this->id_retencion;
	}

	/**
	  * setIdRetencion( $id_retencion )
	  * 
	  * Set the <i>id_retencion</i> property for this object. Donde <i>id_retencion</i> es Id del retencion a aplicar al tipo de cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>id_retencion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdRetencion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdRetencion( $id_retencion )
	{
		$this->id_retencion = $id_retencion;
	}

	/**
	  * getIdClasificacionCliente
	  * 
	  * Get the <i>id_clasificacion_cliente</i> property for this object. Donde <i>id_clasificacion_cliente</i> es Id de la clasificacion del cliente
	  * @return int(11)
	  */
	final public function getIdClasificacionCliente()
	{
		return $this->id_clasificacion_cliente;
	}

	/**
	  * setIdClasificacionCliente( $id_clasificacion_cliente )
	  * 
	  * Set the <i>id_clasificacion_cliente</i> property for this object. Donde <i>id_clasificacion_cliente</i> es Id de la clasificacion del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_cliente</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionCliente( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionCliente( $id_clasificacion_cliente )
	{
		$this->id_clasificacion_cliente = $id_clasificacion_cliente;
	}

}
