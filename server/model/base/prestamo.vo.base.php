<?php
/** Value Object file for table prestamo.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Prestamo extends VO
{
	/**
	  * Constructor de Prestamo
	  * 
	  * Para construir un objeto de tipo Prestamo debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Prestamo
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_prestamo']) ){
				$this->id_prestamo = $data['id_prestamo'];
			}
			if( isset($data['id_solicitante']) ){
				$this->id_solicitante = $data['id_solicitante'];
			}
			if( isset($data['id_empresa_presta']) ){
				$this->id_empresa_presta = $data['id_empresa_presta'];
			}
			if( isset($data['id_sucursal_presta']) ){
				$this->id_sucursal_presta = $data['id_sucursal_presta'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['monto']) ){
				$this->monto = $data['monto'];
			}
			if( isset($data['saldo']) ){
				$this->saldo = $data['saldo'];
			}
			if( isset($data['interes_mensual']) ){
				$this->interes_mensual = $data['interes_mensual'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Prestamo en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_prestamo" => $this->id_prestamo,
			"id_solicitante" => $this->id_solicitante,
			"id_empresa_presta" => $this->id_empresa_presta,
			"id_sucursal_presta" => $this->id_sucursal_presta,
			"id_usuario" => $this->id_usuario,
			"monto" => $this->monto,
			"saldo" => $this->saldo,
			"interes_mensual" => $this->interes_mensual,
			"fecha" => $this->fecha
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_prestamo
	  * 
	  * Id del prestamo<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_prestamo;

	/**
	  * id_solicitante
	  * 
	  * Id de la sucursal o usuario que solicita el prestamo, la sucursal sera negativa<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_solicitante;

	/**
	  * id_empresa_presta
	  * 
	  * Id de la emresa que realiza el prestamo<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa_presta;

	/**
	  * id_sucursal_presta
	  * 
	  * Id de la sucursal que presta<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal_presta;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que realiza el prestamo<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * monto
	  * 
	  * Monto que se solicita<br>
	  * @access public
	  * @var float
	  */
	public $monto;

	/**
	  * saldo
	  * 
	  * Saldo que lleva abonado el prestamo<br>
	  * @access public
	  * @var float
	  */
	public $saldo;

	/**
	  * interes_mensual
	  * 
	  * Porcentaje de interes mensual del prestamo<br>
	  * @access public
	  * @var float
	  */
	public $interes_mensual;

	/**
	  * fecha
	  * 
	  * Fecha en que se realiza el prestamo<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * getIdPrestamo
	  * 
	  * Get the <i>id_prestamo</i> property for this object. Donde <i>id_prestamo</i> es Id del prestamo
	  * @return int(11)
	  */
	final public function getIdPrestamo()
	{
		return $this->id_prestamo;
	}

	/**
	  * setIdPrestamo( $id_prestamo )
	  * 
	  * Set the <i>id_prestamo</i> property for this object. Donde <i>id_prestamo</i> es Id del prestamo.
	  * Una validacion basica se hara aqui para comprobar que <i>id_prestamo</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdPrestamo( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdPrestamo( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdPrestamo( $id_prestamo )
	{
		$this->id_prestamo = $id_prestamo;
	}

	/**
	  * getIdSolicitante
	  * 
	  * Get the <i>id_solicitante</i> property for this object. Donde <i>id_solicitante</i> es Id de la sucursal o usuario que solicita el prestamo, la sucursal sera negativa
	  * @return int(11)
	  */
	final public function getIdSolicitante()
	{
		return $this->id_solicitante;
	}

	/**
	  * setIdSolicitante( $id_solicitante )
	  * 
	  * Set the <i>id_solicitante</i> property for this object. Donde <i>id_solicitante</i> es Id de la sucursal o usuario que solicita el prestamo, la sucursal sera negativa.
	  * Una validacion basica se hara aqui para comprobar que <i>id_solicitante</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSolicitante( $id_solicitante )
	{
		$this->id_solicitante = $id_solicitante;
	}

	/**
	  * getIdEmpresaPresta
	  * 
	  * Get the <i>id_empresa_presta</i> property for this object. Donde <i>id_empresa_presta</i> es Id de la emresa que realiza el prestamo
	  * @return int(11)
	  */
	final public function getIdEmpresaPresta()
	{
		return $this->id_empresa_presta;
	}

	/**
	  * setIdEmpresaPresta( $id_empresa_presta )
	  * 
	  * Set the <i>id_empresa_presta</i> property for this object. Donde <i>id_empresa_presta</i> es Id de la emresa que realiza el prestamo.
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa_presta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdEmpresaPresta( $id_empresa_presta )
	{
		$this->id_empresa_presta = $id_empresa_presta;
	}

	/**
	  * getIdSucursalPresta
	  * 
	  * Get the <i>id_sucursal_presta</i> property for this object. Donde <i>id_sucursal_presta</i> es Id de la sucursal que presta
	  * @return int(11)
	  */
	final public function getIdSucursalPresta()
	{
		return $this->id_sucursal_presta;
	}

	/**
	  * setIdSucursalPresta( $id_sucursal_presta )
	  * 
	  * Set the <i>id_sucursal_presta</i> property for this object. Donde <i>id_sucursal_presta</i> es Id de la sucursal que presta.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal_presta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursalPresta( $id_sucursal_presta )
	{
		$this->id_sucursal_presta = $id_sucursal_presta;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza el prestamo
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que realiza el prestamo.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getMonto
	  * 
	  * Get the <i>monto</i> property for this object. Donde <i>monto</i> es Monto que se solicita
	  * @return float
	  */
	final public function getMonto()
	{
		return $this->monto;
	}

	/**
	  * setMonto( $monto )
	  * 
	  * Set the <i>monto</i> property for this object. Donde <i>monto</i> es Monto que se solicita.
	  * Una validacion basica se hara aqui para comprobar que <i>monto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMonto( $monto )
	{
		$this->monto = $monto;
	}

	/**
	  * getSaldo
	  * 
	  * Get the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo que lleva abonado el prestamo
	  * @return float
	  */
	final public function getSaldo()
	{
		return $this->saldo;
	}

	/**
	  * setSaldo( $saldo )
	  * 
	  * Set the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo que lleva abonado el prestamo.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldo( $saldo )
	{
		$this->saldo = $saldo;
	}

	/**
	  * getInteresMensual
	  * 
	  * Get the <i>interes_mensual</i> property for this object. Donde <i>interes_mensual</i> es Porcentaje de interes mensual del prestamo
	  * @return float
	  */
	final public function getInteresMensual()
	{
		return $this->interes_mensual;
	}

	/**
	  * setInteresMensual( $interes_mensual )
	  * 
	  * Set the <i>interes_mensual</i> property for this object. Donde <i>interes_mensual</i> es Porcentaje de interes mensual del prestamo.
	  * Una validacion basica se hara aqui para comprobar que <i>interes_mensual</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setInteresMensual( $interes_mensual )
	{
		$this->interes_mensual = $interes_mensual;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realiza el prestamo
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha en que se realiza el prestamo.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

}
