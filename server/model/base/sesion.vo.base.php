<?php
/** Value Object file for table sesion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Sesion extends VO
{
	/**
	  * Constructor de Sesion
	  * 
	  * Para construir un objeto de tipo Sesion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Sesion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_sesion']) ){
				$this->id_sesion = $data['id_sesion'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['auth_token']) ){
				$this->auth_token = $data['auth_token'];
			}
			if( isset($data['fecha_de_vencimiento']) ){
				$this->fecha_de_vencimiento = $data['fecha_de_vencimiento'];
			}
			if( isset($data['client_user_agent']) ){
				$this->client_user_agent = $data['client_user_agent'];
			}
			if( isset($data['ip']) ){
				$this->ip = $data['ip'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Sesion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_sesion" => $this->id_sesion,
			"id_usuario" => $this->id_usuario,
			"auth_token" => $this->auth_token,
			"fecha_de_vencimiento" => $this->fecha_de_vencimiento,
			"client_user_agent" => $this->client_user_agent,
			"ip" => $this->ip
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_sesion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sesion;

	/**
	  * id_usuario
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * auth_token
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $auth_token;

	/**
	  * fecha_de_vencimiento
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_de_vencimiento;

	/**
	  * client_user_agent
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $client_user_agent;

	/**
	  * ip
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(15)
	  */
	public $ip;

	/**
	  * getIdSesion
	  * 
	  * Get the <i>id_sesion</i> property for this object. Donde <i>id_sesion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSesion()
	{
		return $this->id_sesion;
	}

	/**
	  * setIdSesion( $id_sesion )
	  * 
	  * Set the <i>id_sesion</i> property for this object. Donde <i>id_sesion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_sesion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdSesion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdSesion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdSesion( $id_sesion )
	{
		$this->id_sesion = $id_sesion;
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
	  * getAuthToken
	  * 
	  * Get the <i>auth_token</i> property for this object. Donde <i>auth_token</i> es  [Campo no documentado]
	  * @return varchar(64)
	  */
	final public function getAuthToken()
	{
		return $this->auth_token;
	}

	/**
	  * setAuthToken( $auth_token )
	  * 
	  * Set the <i>auth_token</i> property for this object. Donde <i>auth_token</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>auth_token</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setAuthToken( $auth_token )
	{
		$this->auth_token = $auth_token;
	}

	/**
	  * getFechaDeVencimiento
	  * 
	  * Get the <i>fecha_de_vencimiento</i> property for this object. Donde <i>fecha_de_vencimiento</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFechaDeVencimiento()
	{
		return $this->fecha_de_vencimiento;
	}

	/**
	  * setFechaDeVencimiento( $fecha_de_vencimiento )
	  * 
	  * Set the <i>fecha_de_vencimiento</i> property for this object. Donde <i>fecha_de_vencimiento</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_de_vencimiento</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaDeVencimiento( $fecha_de_vencimiento )
	{
		$this->fecha_de_vencimiento = $fecha_de_vencimiento;
	}

	/**
	  * getClientUserAgent
	  * 
	  * Get the <i>client_user_agent</i> property for this object. Donde <i>client_user_agent</i> es  [Campo no documentado]
	  * @return varchar(64)
	  */
	final public function getClientUserAgent()
	{
		return $this->client_user_agent;
	}

	/**
	  * setClientUserAgent( $client_user_agent )
	  * 
	  * Set the <i>client_user_agent</i> property for this object. Donde <i>client_user_agent</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>client_user_agent</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setClientUserAgent( $client_user_agent )
	{
		$this->client_user_agent = $client_user_agent;
	}

	/**
	  * getIp
	  * 
	  * Get the <i>ip</i> property for this object. Donde <i>ip</i> es  [Campo no documentado]
	  * @return varchar(15)
	  */
	final public function getIp()
	{
		return $this->ip;
	}

	/**
	  * setIp( $ip )
	  * 
	  * Set the <i>ip</i> property for this object. Donde <i>ip</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>ip</i> es de tipo <i>varchar(15)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(15)
	  */
	final public function setIp( $ip )
	{
		$this->ip = $ip;
	}

}
