<?php
/** Value Object file for table cliente_seguimiento.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ClienteSeguimiento extends VO
{
	/**
	  * Constructor de ClienteSeguimiento
	  * 
	  * Para construir un objeto de tipo ClienteSeguimiento debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ClienteSeguimiento
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_cliente_seguimiento']) ){
				$this->id_cliente_seguimiento = $data['id_cliente_seguimiento'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_cliente']) ){
				$this->id_cliente = $data['id_cliente'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['texto']) ){
				$this->texto = $data['texto'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ClienteSeguimiento en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_cliente_seguimiento" => $this->id_cliente_seguimiento,
			"id_usuario" => $this->id_usuario,
			"id_cliente" => $this->id_cliente,
			"fecha" => $this->fecha,
			"texto" => $this->texto
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_cliente_seguimiento
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cliente_seguimiento;

	/**
	  * id_usuario
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_cliente
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cliente;

	/**
	  * fecha
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * texto
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var text
	  */
	public $texto;

	/**
	  * getIdClienteSeguimiento
	  * 
	  * Get the <i>id_cliente_seguimiento</i> property for this object. Donde <i>id_cliente_seguimiento</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdClienteSeguimiento()
	{
		return $this->id_cliente_seguimiento;
	}

	/**
	  * setIdClienteSeguimiento( $id_cliente_seguimiento )
	  * 
	  * Set the <i>id_cliente_seguimiento</i> property for this object. Donde <i>id_cliente_seguimiento</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_cliente_seguimiento</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdClienteSeguimiento( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClienteSeguimiento( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClienteSeguimiento( $id_cliente_seguimiento )
	{
		$this->id_cliente_seguimiento = $id_cliente_seguimiento;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

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
	  * @param int(11)
	  */
	final public function setIdCliente( $id_cliente )
	{
		$this->id_cliente = $id_cliente;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getTexto
	  * 
	  * Get the <i>texto</i> property for this object. Donde <i>texto</i> es  [Campo no documentado]
	  * @return text
	  */
	final public function getTexto()
	{
		return $this->texto;
	}

	/**
	  * setTexto( $texto )
	  * 
	  * Set the <i>texto</i> property for this object. Donde <i>texto</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>texto</i> es de tipo <i>text</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param text
	  */
	final public function setTexto( $texto )
	{
		$this->texto = $texto;
	}

}
