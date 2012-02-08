<?php
/** Value Object file for table sucursal.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Alan Gonzalez
  * @access public
  * @package docs
  * 
  */

class Sucursal extends VO
{
	/**
	  * Constructor de Sucursal
	  * 
	  * Para construir un objeto de tipo Sucursal debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Sucursal
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['id_direccion']) ){
				$this->id_direccion = $data['id_direccion'];
			}
			if( isset($data['rfc']) ){
				$this->rfc = $data['rfc'];
			}
			if( isset($data['razon_social']) ){
				$this->razon_social = $data['razon_social'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['id_gerente']) ){
				$this->id_gerente = $data['id_gerente'];
			}
			if( isset($data['saldo_a_favor']) ){
				$this->saldo_a_favor = $data['saldo_a_favor'];
			}
			if( isset($data['fecha_apertura']) ){
				$this->fecha_apertura = $data['fecha_apertura'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['fecha_baja']) ){
				$this->fecha_baja = $data['fecha_baja'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Sucursal en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_sucursal" => $this->id_sucursal,
			"id_direccion" => $this->id_direccion,
			"rfc" => $this->rfc,
			"razon_social" => $this->razon_social,
			"descripcion" => $this->descripcion,
			"id_gerente" => $this->id_gerente,
			"saldo_a_favor" => $this->saldo_a_favor,
			"fecha_apertura" => $this->fecha_apertura,
			"activa" => $this->activa,
			"fecha_baja" => $this->fecha_baja
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_sucursal
	  * 
	  * Id de la tabla sucursal<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * id_direccion
	  * 
	  * Id de la direccion de la sucursal<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_direccion;

	/**
	  * rfc
	  * 
	  * RFC de la sucursal<br>
	  * @access public
	  * @var varchar(30)
	  */
	public $rfc;

	/**
	  * razon_social
	  * 
	  * Razon social de la sucursal<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $razon_social;

	/**
	  * descripcion
	  * 
	  * Descrpicion de la sucursal<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * id_gerente
	  * 
	  * Id del usuario que funje como gerente general de la sucursal<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_gerente;

	/**
	  * saldo_a_favor
	  * 
	  * Saldo a favor de la sucursal<br>
	  * @access public
	  * @var float
	  */
	public $saldo_a_favor;

	/**
	  * fecha_apertura
	  * 
	  * Fecha en que se creo la sucursal<br>
	  * @access public
	  * @var datetime
	  */
	public $fecha_apertura;

	/**
	  * activa
	  * 
	  * Si esta sucursal esta activa o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * fecha_baja
	  * 
	  * Fecha en que se dio de baja esta sucursal<br>
	  * @access public
	  * @var datetime
	  */
	public $fecha_baja;

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es Id de la tabla sucursal
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es Id de la tabla sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdSucursal( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdSucursal( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getIdDireccion
	  * 
	  * Get the <i>id_direccion</i> property for this object. Donde <i>id_direccion</i> es Id de la direccion de la sucursal
	  * @return int(11)
	  */
	final public function getIdDireccion()
	{
		return $this->id_direccion;
	}

	/**
	  * setIdDireccion( $id_direccion )
	  * 
	  * Set the <i>id_direccion</i> property for this object. Donde <i>id_direccion</i> es Id de la direccion de la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>id_direccion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdDireccion( $id_direccion )
	{
		$this->id_direccion = $id_direccion;
	}

	/**
	  * getRfc
	  * 
	  * Get the <i>rfc</i> property for this object. Donde <i>rfc</i> es RFC de la sucursal
	  * @return varchar(30)
	  */
	final public function getRfc()
	{
		return $this->rfc;
	}

	/**
	  * setRfc( $rfc )
	  * 
	  * Set the <i>rfc</i> property for this object. Donde <i>rfc</i> es RFC de la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>rfc</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setRfc( $rfc )
	{
		$this->rfc = $rfc;
	}

	/**
	  * getRazonSocial
	  * 
	  * Get the <i>razon_social</i> property for this object. Donde <i>razon_social</i> es Razon social de la sucursal
	  * @return varchar(100)
	  */
	final public function getRazonSocial()
	{
		return $this->razon_social;
	}

	/**
	  * setRazonSocial( $razon_social )
	  * 
	  * Set the <i>razon_social</i> property for this object. Donde <i>razon_social</i> es Razon social de la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>razon_social</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setRazonSocial( $razon_social )
	{
		$this->razon_social = $razon_social;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descrpicion de la sucursal
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descrpicion de la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getIdGerente
	  * 
	  * Get the <i>id_gerente</i> property for this object. Donde <i>id_gerente</i> es Id del usuario que funje como gerente general de la sucursal
	  * @return int(11)
	  */
	final public function getIdGerente()
	{
		return $this->id_gerente;
	}

	/**
	  * setIdGerente( $id_gerente )
	  * 
	  * Set the <i>id_gerente</i> property for this object. Donde <i>id_gerente</i> es Id del usuario que funje como gerente general de la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>id_gerente</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdGerente( $id_gerente )
	{
		$this->id_gerente = $id_gerente;
	}

	/**
	  * getSaldoAFavor
	  * 
	  * Get the <i>saldo_a_favor</i> property for this object. Donde <i>saldo_a_favor</i> es Saldo a favor de la sucursal
	  * @return float
	  */
	final public function getSaldoAFavor()
	{
		return $this->saldo_a_favor;
	}

	/**
	  * setSaldoAFavor( $saldo_a_favor )
	  * 
	  * Set the <i>saldo_a_favor</i> property for this object. Donde <i>saldo_a_favor</i> es Saldo a favor de la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo_a_favor</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldoAFavor( $saldo_a_favor )
	{
		$this->saldo_a_favor = $saldo_a_favor;
	}

	/**
	  * getFechaApertura
	  * 
	  * Get the <i>fecha_apertura</i> property for this object. Donde <i>fecha_apertura</i> es Fecha en que se creo la sucursal
	  * @return datetime
	  */
	final public function getFechaApertura()
	{
		return $this->fecha_apertura;
	}

	/**
	  * setFechaApertura( $fecha_apertura )
	  * 
	  * Set the <i>fecha_apertura</i> property for this object. Donde <i>fecha_apertura</i> es Fecha en que se creo la sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_apertura</i> es de tipo <i>datetime</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param datetime
	  */
	final public function setFechaApertura( $fecha_apertura )
	{
		$this->fecha_apertura = $fecha_apertura;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta sucursal esta activa o no
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta sucursal esta activa o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getFechaBaja
	  * 
	  * Get the <i>fecha_baja</i> property for this object. Donde <i>fecha_baja</i> es Fecha en que se dio de baja esta sucursal
	  * @return datetime
	  */
	final public function getFechaBaja()
	{
		return $this->fecha_baja;
	}

	/**
	  * setFechaBaja( $fecha_baja )
	  * 
	  * Set the <i>fecha_baja</i> property for this object. Donde <i>fecha_baja</i> es Fecha en que se dio de baja esta sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_baja</i> es de tipo <i>datetime</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param datetime
	  */
	final public function setFechaBaja( $fecha_baja )
	{
		$this->fecha_baja = $fecha_baja;
	}

}
