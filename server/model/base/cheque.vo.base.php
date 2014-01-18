<?php
/** Value Object file for table cheque.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Cheque extends VO
{
	/**
	  * Constructor de Cheque
	  * 
	  * Para construir un objeto de tipo Cheque debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Cheque
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_cheque']) ){
				$this->id_cheque = $data['id_cheque'];
			}
			if( isset($data['nombre_banco']) ){
				$this->nombre_banco = $data['nombre_banco'];
			}
			if( isset($data['monto']) ){
				$this->monto = $data['monto'];
			}
			if( isset($data['numero']) ){
				$this->numero = $data['numero'];
			}
			if( isset($data['expedido']) ){
				$this->expedido = $data['expedido'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Cheque en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_cheque" => $this->id_cheque,
			"nombre_banco" => $this->nombre_banco,
			"monto" => $this->monto,
			"numero" => $this->numero,
			"expedido" => $this->expedido,
			"id_usuario" => $this->id_usuario
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_cheque
	  * 
	  * Id del cheque<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cheque;

	/**
	  * nombre_banco
	  * 
	  * Nombre del banco del que se expide el cheque<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre_banco;

	/**
	  * monto
	  * 
	  * Monto del cheque<br>
	  * @access public
	  * @var float
	  */
	public $monto;

	/**
	  * numero
	  * 
	  * Los ultimos cuatro numeros del cheque<br>
	  * @access public
	  * @var varchar(4)
	  */
	public $numero;

	/**
	  * expedido
	  * 
	  * Verdadero si el cheque es expedido por la empresa, falso si es recibido<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $expedido;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que registra el cheque<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * getIdCheque
	  * 
	  * Get the <i>id_cheque</i> property for this object. Donde <i>id_cheque</i> es Id del cheque
	  * @return int(11)
	  */
	final public function getIdCheque()
	{
		return $this->id_cheque;
	}

	/**
	  * setIdCheque( $id_cheque )
	  * 
	  * Set the <i>id_cheque</i> property for this object. Donde <i>id_cheque</i> es Id del cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cheque</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCheque( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCheque( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCheque( $id_cheque )
	{
		$this->id_cheque = $id_cheque;
	}

	/**
	  * getNombreBanco
	  * 
	  * Get the <i>nombre_banco</i> property for this object. Donde <i>nombre_banco</i> es Nombre del banco del que se expide el cheque
	  * @return varchar(100)
	  */
	final public function getNombreBanco()
	{
		return $this->nombre_banco;
	}

	/**
	  * setNombreBanco( $nombre_banco )
	  * 
	  * Set the <i>nombre_banco</i> property for this object. Donde <i>nombre_banco</i> es Nombre del banco del que se expide el cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre_banco</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombreBanco( $nombre_banco )
	{
		$this->nombre_banco = $nombre_banco;
	}

	/**
	  * getMonto
	  * 
	  * Get the <i>monto</i> property for this object. Donde <i>monto</i> es Monto del cheque
	  * @return float
	  */
	final public function getMonto()
	{
		return $this->monto;
	}

	/**
	  * setMonto( $monto )
	  * 
	  * Set the <i>monto</i> property for this object. Donde <i>monto</i> es Monto del cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>monto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMonto( $monto )
	{
		$this->monto = $monto;
	}

	/**
	  * getNumero
	  * 
	  * Get the <i>numero</i> property for this object. Donde <i>numero</i> es Los ultimos cuatro numeros del cheque
	  * @return varchar(4)
	  */
	final public function getNumero()
	{
		return $this->numero;
	}

	/**
	  * setNumero( $numero )
	  * 
	  * Set the <i>numero</i> property for this object. Donde <i>numero</i> es Los ultimos cuatro numeros del cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>numero</i> es de tipo <i>varchar(4)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(4)
	  */
	final public function setNumero( $numero )
	{
		$this->numero = $numero;
	}

	/**
	  * getExpedido
	  * 
	  * Get the <i>expedido</i> property for this object. Donde <i>expedido</i> es Verdadero si el cheque es expedido por la empresa, falso si es recibido
	  * @return tinyint(1)
	  */
	final public function getExpedido()
	{
		return $this->expedido;
	}

	/**
	  * setExpedido( $expedido )
	  * 
	  * Set the <i>expedido</i> property for this object. Donde <i>expedido</i> es Verdadero si el cheque es expedido por la empresa, falso si es recibido.
	  * Una validacion basica se hara aqui para comprobar que <i>expedido</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setExpedido( $expedido )
	{
		$this->expedido = $expedido;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que registra el cheque
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que registra el cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

}
