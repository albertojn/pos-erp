<?php
/** Value Object file for table caja.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Caja extends VO
{
	/**
	  * Constructor de Caja
	  * 
	  * Para construir un objeto de tipo Caja debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Caja
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['token']) ){
				$this->token = $data['token'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['abierta']) ){
				$this->abierta = $data['abierta'];
			}
			if( isset($data['saldo']) ){
				$this->saldo = $data['saldo'];
			}
			if( isset($data['control_billetes']) ){
				$this->control_billetes = $data['control_billetes'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['id_cuenta_contable']) ){
				$this->id_cuenta_contable = $data['id_cuenta_contable'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Caja en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_caja" => $this->id_caja,
			"id_sucursal" => $this->id_sucursal,
			"token" => $this->token,
			"descripcion" => $this->descripcion,
			"abierta" => $this->abierta,
			"saldo" => $this->saldo,
			"control_billetes" => $this->control_billetes,
			"activa" => $this->activa,
			"id_cuenta_contable" => $this->id_cuenta_contable
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_caja
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * id_sucursal
	  * 
	  * a que sucursal pertenece esta caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * token
	  * 
	  * el token que genero el pos client<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $token;

	/**
	  * descripcion
	  * 
	  * alguna descripcion para esta caja<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $descripcion;

	/**
	  * abierta
	  * 
	  * Si esta abierta la caja o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $abierta;

	/**
	  * saldo
	  * 
	  * Saldo actual de la caja<br>
	  * @access public
	  * @var float
	  */
	public $saldo;

	/**
	  * control_billetes
	  * 
	  * Si esta caja esta llevando control de billetes o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $control_billetes;

	/**
	  * activa
	  * 
	  * Si la caja esta activa o ha sido eliminada<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * id_cuenta_contable
	  * 
	  * El id de la cuenta contable a la que apunta esta caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cuenta_contable;

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es a que sucursal pertenece esta caja
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es a que sucursal pertenece esta caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getToken
	  * 
	  * Get the <i>token</i> property for this object. Donde <i>token</i> es el token que genero el pos client
	  * @return varchar(32)
	  */
	final public function getToken()
	{
		return $this->token;
	}

	/**
	  * setToken( $token )
	  * 
	  * Set the <i>token</i> property for this object. Donde <i>token</i> es el token que genero el pos client.
	  * Una validacion basica se hara aqui para comprobar que <i>token</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setToken( $token )
	{
		$this->token = $token;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es alguna descripcion para esta caja
	  * @return varchar(32)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es alguna descripcion para esta caja.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getAbierta
	  * 
	  * Get the <i>abierta</i> property for this object. Donde <i>abierta</i> es Si esta abierta la caja o no
	  * @return tinyint(1)
	  */
	final public function getAbierta()
	{
		return $this->abierta;
	}

	/**
	  * setAbierta( $abierta )
	  * 
	  * Set the <i>abierta</i> property for this object. Donde <i>abierta</i> es Si esta abierta la caja o no.
	  * Una validacion basica se hara aqui para comprobar que <i>abierta</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setAbierta( $abierta )
	{
		$this->abierta = $abierta;
	}

	/**
	  * getSaldo
	  * 
	  * Get the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo actual de la caja
	  * @return float
	  */
	final public function getSaldo()
	{
		return $this->saldo;
	}

	/**
	  * setSaldo( $saldo )
	  * 
	  * Set the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo actual de la caja.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldo( $saldo )
	{
		$this->saldo = $saldo;
	}

	/**
	  * getControlBilletes
	  * 
	  * Get the <i>control_billetes</i> property for this object. Donde <i>control_billetes</i> es Si esta caja esta llevando control de billetes o no
	  * @return tinyint(1)
	  */
	final public function getControlBilletes()
	{
		return $this->control_billetes;
	}

	/**
	  * setControlBilletes( $control_billetes )
	  * 
	  * Set the <i>control_billetes</i> property for this object. Donde <i>control_billetes</i> es Si esta caja esta llevando control de billetes o no.
	  * Una validacion basica se hara aqui para comprobar que <i>control_billetes</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setControlBilletes( $control_billetes )
	{
		$this->control_billetes = $control_billetes;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si la caja esta activa o ha sido eliminada
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si la caja esta activa o ha sido eliminada.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getIdCuentaContable
	  * 
	  * Get the <i>id_cuenta_contable</i> property for this object. Donde <i>id_cuenta_contable</i> es El id de la cuenta contable a la que apunta esta caja
	  * @return int(11)
	  */
	final public function getIdCuentaContable()
	{
		return $this->id_cuenta_contable;
	}

	/**
	  * setIdCuentaContable( $id_cuenta_contable )
	  * 
	  * Set the <i>id_cuenta_contable</i> property for this object. Donde <i>id_cuenta_contable</i> es El id de la cuenta contable a la que apunta esta caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cuenta_contable</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCuentaContable( $id_cuenta_contable )
	{
		$this->id_cuenta_contable = $id_cuenta_contable;
	}

}
