<?php
/** Value Object file for table ingreso.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Ingreso extends VO
{
	/**
	  * Constructor de Ingreso
	  * 
	  * Para construir un objeto de tipo Ingreso debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Ingreso
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_ingreso']) ){
				$this->id_ingreso = $data['id_ingreso'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_concepto_ingreso']) ){
				$this->id_concepto_ingreso = $data['id_concepto_ingreso'];
			}
			if( isset($data['fecha_del_ingreso']) ){
				$this->fecha_del_ingreso = $data['fecha_del_ingreso'];
			}
			if( isset($data['fecha_de_registro']) ){
				$this->fecha_de_registro = $data['fecha_de_registro'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['nota']) ){
				$this->nota = $data['nota'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['folio']) ){
				$this->folio = $data['folio'];
			}
			if( isset($data['monto']) ){
				$this->monto = $data['monto'];
			}
			if( isset($data['cancelado']) ){
				$this->cancelado = $data['cancelado'];
			}
			if( isset($data['motivo_cancelacion']) ){
				$this->motivo_cancelacion = $data['motivo_cancelacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Ingreso en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_ingreso" => $this->id_ingreso,
			"id_empresa" => $this->id_empresa,
			"id_usuario" => $this->id_usuario,
			"id_concepto_ingreso" => $this->id_concepto_ingreso,
			"fecha_del_ingreso" => $this->fecha_del_ingreso,
			"fecha_de_registro" => $this->fecha_de_registro,
			"id_sucursal" => $this->id_sucursal,
			"id_caja" => $this->id_caja,
			"nota" => $this->nota,
			"descripcion" => $this->descripcion,
			"folio" => $this->folio,
			"monto" => $this->monto,
			"cancelado" => $this->cancelado,
			"motivo_cancelacion" => $this->motivo_cancelacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_ingreso
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_ingreso;

	/**
	  * id_empresa
	  * 
	  * el id de la empresa a quien pertenece este ingreso<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * id_usuario
	  * 
	  * el usuario que inserto este ingreso<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_concepto_ingreso
	  * 
	  * el id del concepto de este ingreso<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_concepto_ingreso;

	/**
	  * fecha_del_ingreso
	  * 
	  * la fecha de cuando el ingreso se hizo<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_del_ingreso;

	/**
	  * fecha_de_registro
	  * 
	  * fecha de cuando el ingreso se registro en el sistema<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_de_registro;

	/**
	  * id_sucursal
	  * 
	  * si el ingreso pertenece a una sucursal especifica, este es el id de esa sucursal<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * id_caja
	  * 
	  * si el ingreso se recibe en una caja, este es su id<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * nota
	  * 
	  * alguna nota extra para el ingreso<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $nota;

	/**
	  * descripcion
	  * 
	  * Descripcion del ingreso en caso de que no este contemplado en la lista de  conceptos de ingreso<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * folio
	  * 
	  * Folio de la factura del ingreso<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $folio;

	/**
	  * monto
	  * 
	  * Monto del ingreso si no esta definido por el concepto de gasto<br>
	  * @access public
	  * @var float
	  */
	public $monto;

	/**
	  * cancelado
	  * 
	  * Si este ingreso ha sido cancelado o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelado;

	/**
	  * motivo_cancelacion
	  * 
	  * Motivo por el cual se realiza la cancelacion<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo_cancelacion;

	/**
	  * getIdIngreso
	  * 
	  * Get the <i>id_ingreso</i> property for this object. Donde <i>id_ingreso</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdIngreso()
	{
		return $this->id_ingreso;
	}

	/**
	  * setIdIngreso( $id_ingreso )
	  * 
	  * Set the <i>id_ingreso</i> property for this object. Donde <i>id_ingreso</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_ingreso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdIngreso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdIngreso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdIngreso( $id_ingreso )
	{
		$this->id_ingreso = $id_ingreso;
	}

	/**
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es el id de la empresa a quien pertenece este ingreso
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es el id de la empresa a quien pertenece este ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que inserto este ingreso
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que inserto este ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdConceptoIngreso
	  * 
	  * Get the <i>id_concepto_ingreso</i> property for this object. Donde <i>id_concepto_ingreso</i> es el id del concepto de este ingreso
	  * @return int(11)
	  */
	final public function getIdConceptoIngreso()
	{
		return $this->id_concepto_ingreso;
	}

	/**
	  * setIdConceptoIngreso( $id_concepto_ingreso )
	  * 
	  * Set the <i>id_concepto_ingreso</i> property for this object. Donde <i>id_concepto_ingreso</i> es el id del concepto de este ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_concepto_ingreso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdConceptoIngreso( $id_concepto_ingreso )
	{
		$this->id_concepto_ingreso = $id_concepto_ingreso;
	}

	/**
	  * getFechaDelIngreso
	  * 
	  * Get the <i>fecha_del_ingreso</i> property for this object. Donde <i>fecha_del_ingreso</i> es la fecha de cuando el ingreso se hizo
	  * @return int(11)
	  */
	final public function getFechaDelIngreso()
	{
		return $this->fecha_del_ingreso;
	}

	/**
	  * setFechaDelIngreso( $fecha_del_ingreso )
	  * 
	  * Set the <i>fecha_del_ingreso</i> property for this object. Donde <i>fecha_del_ingreso</i> es la fecha de cuando el ingreso se hizo.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_del_ingreso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaDelIngreso( $fecha_del_ingreso )
	{
		$this->fecha_del_ingreso = $fecha_del_ingreso;
	}

	/**
	  * getFechaDeRegistro
	  * 
	  * Get the <i>fecha_de_registro</i> property for this object. Donde <i>fecha_de_registro</i> es fecha de cuando el ingreso se registro en el sistema
	  * @return int(11)
	  */
	final public function getFechaDeRegistro()
	{
		return $this->fecha_de_registro;
	}

	/**
	  * setFechaDeRegistro( $fecha_de_registro )
	  * 
	  * Set the <i>fecha_de_registro</i> property for this object. Donde <i>fecha_de_registro</i> es fecha de cuando el ingreso se registro en el sistema.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_de_registro</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaDeRegistro( $fecha_de_registro )
	{
		$this->fecha_de_registro = $fecha_de_registro;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es si el ingreso pertenece a una sucursal especifica, este es el id de esa sucursal
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es si el ingreso pertenece a una sucursal especifica, este es el id de esa sucursal.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es si el ingreso se recibe en una caja, este es su id
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es si el ingreso se recibe en una caja, este es su id.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getNota
	  * 
	  * Get the <i>nota</i> property for this object. Donde <i>nota</i> es alguna nota extra para el ingreso
	  * @return varchar(64)
	  */
	final public function getNota()
	{
		return $this->nota;
	}

	/**
	  * setNota( $nota )
	  * 
	  * Set the <i>nota</i> property for this object. Donde <i>nota</i> es alguna nota extra para el ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>nota</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setNota( $nota )
	{
		$this->nota = $nota;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion del ingreso en caso de que no este contemplado en la lista de  conceptos de ingreso
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion del ingreso en caso de que no este contemplado en la lista de  conceptos de ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getFolio
	  * 
	  * Get the <i>folio</i> property for this object. Donde <i>folio</i> es Folio de la factura del ingreso
	  * @return varchar(50)
	  */
	final public function getFolio()
	{
		return $this->folio;
	}

	/**
	  * setFolio( $folio )
	  * 
	  * Set the <i>folio</i> property for this object. Donde <i>folio</i> es Folio de la factura del ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>folio</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setFolio( $folio )
	{
		$this->folio = $folio;
	}

	/**
	  * getMonto
	  * 
	  * Get the <i>monto</i> property for this object. Donde <i>monto</i> es Monto del ingreso si no esta definido por el concepto de gasto
	  * @return float
	  */
	final public function getMonto()
	{
		return $this->monto;
	}

	/**
	  * setMonto( $monto )
	  * 
	  * Set the <i>monto</i> property for this object. Donde <i>monto</i> es Monto del ingreso si no esta definido por el concepto de gasto.
	  * Una validacion basica se hara aqui para comprobar que <i>monto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMonto( $monto )
	{
		$this->monto = $monto;
	}

	/**
	  * getCancelado
	  * 
	  * Get the <i>cancelado</i> property for this object. Donde <i>cancelado</i> es Si este ingreso ha sido cancelado o no
	  * @return tinyint(1)
	  */
	final public function getCancelado()
	{
		return $this->cancelado;
	}

	/**
	  * setCancelado( $cancelado )
	  * 
	  * Set the <i>cancelado</i> property for this object. Donde <i>cancelado</i> es Si este ingreso ha sido cancelado o no.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelado</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelado( $cancelado )
	{
		$this->cancelado = $cancelado;
	}

	/**
	  * getMotivoCancelacion
	  * 
	  * Get the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Motivo por el cual se realiza la cancelacion
	  * @return varchar(255)
	  */
	final public function getMotivoCancelacion()
	{
		return $this->motivo_cancelacion;
	}

	/**
	  * setMotivoCancelacion( $motivo_cancelacion )
	  * 
	  * Set the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Motivo por el cual se realiza la cancelacion.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo_cancelacion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivoCancelacion( $motivo_cancelacion )
	{
		$this->motivo_cancelacion = $motivo_cancelacion;
	}

}
