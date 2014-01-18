<?php
/** Value Object file for table cliente_aval.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ClienteAval extends VO
{
	/**
	  * Constructor de ClienteAval
	  * 
	  * Para construir un objeto de tipo ClienteAval debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ClienteAval
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_cliente']) ){
				$this->id_cliente = $data['id_cliente'];
			}
			if( isset($data['id_aval']) ){
				$this->id_aval = $data['id_aval'];
			}
			if( isset($data['tipo_aval']) ){
				$this->tipo_aval = $data['tipo_aval'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ClienteAval en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_cliente" => $this->id_cliente,
			"id_aval" => $this->id_aval,
			"tipo_aval" => $this->tipo_aval
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_cliente
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cliente;

	/**
	  * id_aval
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_aval;

	/**
	  * tipo_aval
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var enum('hipoteca','prendario')
	  */
	public $tipo_aval;

	/**
	  * getIdCliente
	  * 
	  * Get the <i>id_cliente</i> property for this object. Donde <i>id_cliente</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCliente()
	{
		return $this->id_cliente;
	}

	/**
	  * setIdCliente( $id_cliente )
	  * 
	  * Set the <i>id_cliente</i> property for this object. Donde <i>id_cliente</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_cliente</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCliente( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCliente( $id_cliente )
	{
		$this->id_cliente = $id_cliente;
	}

	/**
	  * getIdAval
	  * 
	  * Get the <i>id_aval</i> property for this object. Donde <i>id_aval</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdAval()
	{
		return $this->id_aval;
	}

	/**
	  * setIdAval( $id_aval )
	  * 
	  * Set the <i>id_aval</i> property for this object. Donde <i>id_aval</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_aval</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAval( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAval( $id_aval )
	{
		$this->id_aval = $id_aval;
	}

	/**
	  * getTipoAval
	  * 
	  * Get the <i>tipo_aval</i> property for this object. Donde <i>tipo_aval</i> es  [Campo no documentado]
	  * @return enum('hipoteca','prendario')
	  */
	final public function getTipoAval()
	{
		return $this->tipo_aval;
	}

	/**
	  * setTipoAval( $tipo_aval )
	  * 
	  * Set the <i>tipo_aval</i> property for this object. Donde <i>tipo_aval</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_aval</i> es de tipo <i>enum('hipoteca','prendario')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('hipoteca','prendario')
	  */
	final public function setTipoAval( $tipo_aval )
	{
		$this->tipo_aval = $tipo_aval;
	}

}
