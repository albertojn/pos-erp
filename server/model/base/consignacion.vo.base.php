<?php
/** Value Object file for table consignacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Consignacion extends VO
{
	/**
	  * Constructor de Consignacion
	  * 
	  * Para construir un objeto de tipo Consignacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Consignacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_consignacion']) ){
				$this->id_consignacion = $data['id_consignacion'];
			}
			if( isset($data['id_cliente']) ){
				$this->id_cliente = $data['id_cliente'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_usuario_cancelacion']) ){
				$this->id_usuario_cancelacion = $data['id_usuario_cancelacion'];
			}
			if( isset($data['fecha_creacion']) ){
				$this->fecha_creacion = $data['fecha_creacion'];
			}
			if( isset($data['tipo_consignacion']) ){
				$this->tipo_consignacion = $data['tipo_consignacion'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
			if( isset($data['cancelada']) ){
				$this->cancelada = $data['cancelada'];
			}
			if( isset($data['motivo_cancelacion']) ){
				$this->motivo_cancelacion = $data['motivo_cancelacion'];
			}
			if( isset($data['folio']) ){
				$this->folio = $data['folio'];
			}
			if( isset($data['fecha_termino']) ){
				$this->fecha_termino = $data['fecha_termino'];
			}
			if( isset($data['impuesto']) ){
				$this->impuesto = $data['impuesto'];
			}
			if( isset($data['descuento']) ){
				$this->descuento = $data['descuento'];
			}
			if( isset($data['retencion']) ){
				$this->retencion = $data['retencion'];
			}
			if( isset($data['saldo']) ){
				$this->saldo = $data['saldo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Consignacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_consignacion" => $this->id_consignacion,
			"id_cliente" => $this->id_cliente,
			"id_usuario" => $this->id_usuario,
			"id_usuario_cancelacion" => $this->id_usuario_cancelacion,
			"fecha_creacion" => $this->fecha_creacion,
			"tipo_consignacion" => $this->tipo_consignacion,
			"activa" => $this->activa,
			"cancelada" => $this->cancelada,
			"motivo_cancelacion" => $this->motivo_cancelacion,
			"folio" => $this->folio,
			"fecha_termino" => $this->fecha_termino,
			"impuesto" => $this->impuesto,
			"descuento" => $this->descuento,
			"retencion" => $this->retencion,
			"saldo" => $this->saldo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_consignacion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_consignacion;

	/**
	  * id_cliente
	  * 
	  * Id del usuario al que se le consignan los productos<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cliente;

	/**
	  * id_usuario
	  * 
	  * el usuario que inicio la consigacion<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_usuario_cancelacion
	  * 
	  * Id del usuario que cancela la consignacion<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_cancelacion;

	/**
	  * fecha_creacion
	  * 
	  * la fecha que se creo esta consignacion<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_creacion;

	/**
	  * tipo_consignacion
	  * 
	  * Si al terminar la consignacion la venta sera a credito o de contado<br>
	  * @access public
	  * @var enum('credito','contado')
	  */
	public $tipo_consignacion;

	/**
	  * activa
	  * 
	  * Si la consignacion esta activa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * cancelada
	  * 
	  * Si esta consignacion fue cancelada o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelada;

	/**
	  * motivo_cancelacion
	  * 
	  * Justificacion de la cancelacion si esta consginacion fue cancelada<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo_cancelacion;

	/**
	  * folio
	  * 
	  * Folio de la consignacion<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $folio;

	/**
	  * fecha_termino
	  * 
	  * Fecha en que se termino la consignacion, si la consignacion fue cancelada, la fecha de cancelacion se guardara aqui<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_termino;

	/**
	  * impuesto
	  * 
	  * Monto generado por impuestos para esta consignacion<br>
	  * @access public
	  * @var float
	  */
	public $impuesto;

	/**
	  * descuento
	  * 
	  * Monto a descontar de esta consignacion<br>
	  * @access public
	  * @var float
	  */
	public $descuento;

	/**
	  * retencion
	  * 
	  * Monto generado por retenciones<br>
	  * @access public
	  * @var float
	  */
	public $retencion;

	/**
	  * saldo
	  * 
	  * Saldo que ha sido abonado a la consignacion<br>
	  * @access public
	  * @var float
	  */
	public $saldo;

	/**
	  * getIdConsignacion
	  * 
	  * Get the <i>id_consignacion</i> property for this object. Donde <i>id_consignacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdConsignacion()
	{
		return $this->id_consignacion;
	}

	/**
	  * setIdConsignacion( $id_consignacion )
	  * 
	  * Set the <i>id_consignacion</i> property for this object. Donde <i>id_consignacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_consignacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdConsignacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdConsignacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdConsignacion( $id_consignacion )
	{
		$this->id_consignacion = $id_consignacion;
	}

	/**
	  * getIdCliente
	  * 
	  * Get the <i>id_cliente</i> property for this object. Donde <i>id_cliente</i> es Id del usuario al que se le consignan los productos
	  * @return int(11)
	  */
	final public function getIdCliente()
	{
		return $this->id_cliente;
	}

	/**
	  * setIdCliente( $id_cliente )
	  * 
	  * Set the <i>id_cliente</i> property for this object. Donde <i>id_cliente</i> es Id del usuario al que se le consignan los productos.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cliente</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCliente( $id_cliente )
	{
		$this->id_cliente = $id_cliente;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que inicio la consigacion
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que inicio la consigacion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdUsuarioCancelacion
	  * 
	  * Get the <i>id_usuario_cancelacion</i> property for this object. Donde <i>id_usuario_cancelacion</i> es Id del usuario que cancela la consignacion
	  * @return int(11)
	  */
	final public function getIdUsuarioCancelacion()
	{
		return $this->id_usuario_cancelacion;
	}

	/**
	  * setIdUsuarioCancelacion( $id_usuario_cancelacion )
	  * 
	  * Set the <i>id_usuario_cancelacion</i> property for this object. Donde <i>id_usuario_cancelacion</i> es Id del usuario que cancela la consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_cancelacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioCancelacion( $id_usuario_cancelacion )
	{
		$this->id_usuario_cancelacion = $id_usuario_cancelacion;
	}

	/**
	  * getFechaCreacion
	  * 
	  * Get the <i>fecha_creacion</i> property for this object. Donde <i>fecha_creacion</i> es la fecha que se creo esta consignacion
	  * @return int(11)
	  */
	final public function getFechaCreacion()
	{
		return $this->fecha_creacion;
	}

	/**
	  * setFechaCreacion( $fecha_creacion )
	  * 
	  * Set the <i>fecha_creacion</i> property for this object. Donde <i>fecha_creacion</i> es la fecha que se creo esta consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_creacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaCreacion( $fecha_creacion )
	{
		$this->fecha_creacion = $fecha_creacion;
	}

	/**
	  * getTipoConsignacion
	  * 
	  * Get the <i>tipo_consignacion</i> property for this object. Donde <i>tipo_consignacion</i> es Si al terminar la consignacion la venta sera a credito o de contado
	  * @return enum('credito','contado')
	  */
	final public function getTipoConsignacion()
	{
		return $this->tipo_consignacion;
	}

	/**
	  * setTipoConsignacion( $tipo_consignacion )
	  * 
	  * Set the <i>tipo_consignacion</i> property for this object. Donde <i>tipo_consignacion</i> es Si al terminar la consignacion la venta sera a credito o de contado.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_consignacion</i> es de tipo <i>enum('credito','contado')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('credito','contado')
	  */
	final public function setTipoConsignacion( $tipo_consignacion )
	{
		$this->tipo_consignacion = $tipo_consignacion;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si la consignacion esta activa
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si la consignacion esta activa.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

	/**
	  * getCancelada
	  * 
	  * Get the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si esta consignacion fue cancelada o no
	  * @return tinyint(1)
	  */
	final public function getCancelada()
	{
		return $this->cancelada;
	}

	/**
	  * setCancelada( $cancelada )
	  * 
	  * Set the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si esta consignacion fue cancelada o no.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelada</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelada( $cancelada )
	{
		$this->cancelada = $cancelada;
	}

	/**
	  * getMotivoCancelacion
	  * 
	  * Get the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Justificacion de la cancelacion si esta consginacion fue cancelada
	  * @return varchar(255)
	  */
	final public function getMotivoCancelacion()
	{
		return $this->motivo_cancelacion;
	}

	/**
	  * setMotivoCancelacion( $motivo_cancelacion )
	  * 
	  * Set the <i>motivo_cancelacion</i> property for this object. Donde <i>motivo_cancelacion</i> es Justificacion de la cancelacion si esta consginacion fue cancelada.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo_cancelacion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivoCancelacion( $motivo_cancelacion )
	{
		$this->motivo_cancelacion = $motivo_cancelacion;
	}

	/**
	  * getFolio
	  * 
	  * Get the <i>folio</i> property for this object. Donde <i>folio</i> es Folio de la consignacion
	  * @return varchar(50)
	  */
	final public function getFolio()
	{
		return $this->folio;
	}

	/**
	  * setFolio( $folio )
	  * 
	  * Set the <i>folio</i> property for this object. Donde <i>folio</i> es Folio de la consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>folio</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setFolio( $folio )
	{
		$this->folio = $folio;
	}

	/**
	  * getFechaTermino
	  * 
	  * Get the <i>fecha_termino</i> property for this object. Donde <i>fecha_termino</i> es Fecha en que se termino la consignacion, si la consignacion fue cancelada, la fecha de cancelacion se guardara aqui
	  * @return int(11)
	  */
	final public function getFechaTermino()
	{
		return $this->fecha_termino;
	}

	/**
	  * setFechaTermino( $fecha_termino )
	  * 
	  * Set the <i>fecha_termino</i> property for this object. Donde <i>fecha_termino</i> es Fecha en que se termino la consignacion, si la consignacion fue cancelada, la fecha de cancelacion se guardara aqui.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_termino</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaTermino( $fecha_termino )
	{
		$this->fecha_termino = $fecha_termino;
	}

	/**
	  * getImpuesto
	  * 
	  * Get the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es Monto generado por impuestos para esta consignacion
	  * @return float
	  */
	final public function getImpuesto()
	{
		return $this->impuesto;
	}

	/**
	  * setImpuesto( $impuesto )
	  * 
	  * Set the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es Monto generado por impuestos para esta consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>impuesto</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setImpuesto( $impuesto )
	{
		$this->impuesto = $impuesto;
	}

	/**
	  * getDescuento
	  * 
	  * Get the <i>descuento</i> property for this object. Donde <i>descuento</i> es Monto a descontar de esta consignacion
	  * @return float
	  */
	final public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	  * setDescuento( $descuento )
	  * 
	  * Set the <i>descuento</i> property for this object. Donde <i>descuento</i> es Monto a descontar de esta consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>descuento</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setDescuento( $descuento )
	{
		$this->descuento = $descuento;
	}

	/**
	  * getRetencion
	  * 
	  * Get the <i>retencion</i> property for this object. Donde <i>retencion</i> es Monto generado por retenciones
	  * @return float
	  */
	final public function getRetencion()
	{
		return $this->retencion;
	}

	/**
	  * setRetencion( $retencion )
	  * 
	  * Set the <i>retencion</i> property for this object. Donde <i>retencion</i> es Monto generado por retenciones.
	  * Una validacion basica se hara aqui para comprobar que <i>retencion</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setRetencion( $retencion )
	{
		$this->retencion = $retencion;
	}

	/**
	  * getSaldo
	  * 
	  * Get the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo que ha sido abonado a la consignacion
	  * @return float
	  */
	final public function getSaldo()
	{
		return $this->saldo;
	}

	/**
	  * setSaldo( $saldo )
	  * 
	  * Set the <i>saldo</i> property for this object. Donde <i>saldo</i> es Saldo que ha sido abonado a la consignacion.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldo( $saldo )
	{
		$this->saldo = $saldo;
	}

}
