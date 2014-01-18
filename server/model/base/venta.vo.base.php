<?php
/** Value Object file for table venta.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Venta extends VO
{
	/**
	  * Constructor de Venta
	  * 
	  * Para construir un objeto de tipo Venta debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Venta
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_venta']) ){
				$this->id_venta = $data['id_venta'];
			}
			if( isset($data['es_cotizacion']) ){
				$this->es_cotizacion = $data['es_cotizacion'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['id_venta_caja']) ){
				$this->id_venta_caja = $data['id_venta_caja'];
			}
			if( isset($data['id_comprador_venta']) ){
				$this->id_comprador_venta = $data['id_comprador_venta'];
			}
			if( isset($data['tipo_de_venta']) ){
				$this->tipo_de_venta = $data['tipo_de_venta'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['subtotal']) ){
				$this->subtotal = $data['subtotal'];
			}
			if( isset($data['impuesto']) ){
				$this->impuesto = $data['impuesto'];
			}
			if( isset($data['descuento']) ){
				$this->descuento = $data['descuento'];
			}
			if( isset($data['total']) ){
				$this->total = $data['total'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['saldo']) ){
				$this->saldo = $data['saldo'];
			}
			if( isset($data['cancelada']) ){
				$this->cancelada = $data['cancelada'];
			}
			if( isset($data['tipo_de_pago']) ){
				$this->tipo_de_pago = $data['tipo_de_pago'];
			}
			if( isset($data['retencion']) ){
				$this->retencion = $data['retencion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Venta en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_venta" => $this->id_venta,
			"es_cotizacion" => $this->es_cotizacion,
			"id_caja" => $this->id_caja,
			"id_venta_caja" => $this->id_venta_caja,
			"id_comprador_venta" => $this->id_comprador_venta,
			"tipo_de_venta" => $this->tipo_de_venta,
			"fecha" => $this->fecha,
			"subtotal" => $this->subtotal,
			"impuesto" => $this->impuesto,
			"descuento" => $this->descuento,
			"total" => $this->total,
			"id_sucursal" => $this->id_sucursal,
			"id_usuario" => $this->id_usuario,
			"saldo" => $this->saldo,
			"cancelada" => $this->cancelada,
			"tipo_de_pago" => $this->tipo_de_pago,
			"retencion" => $this->retencion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_venta
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_venta;

	/**
	  * es_cotizacion
	  * 
	  * verdadero si es una cotizacion<br>
	  * @access public
	  * @var int(1)
	  */
	public $es_cotizacion;

	/**
	  * id_caja
	  * 
	  * la caja donde se hizo la venta, esta puede ser null ya que un gerente puede vender en el sistema web<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * id_venta_caja
	  * 
	  * el id de la venta de esta caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_venta_caja;

	/**
	  * id_comprador_venta
	  * 
	  * Id del usuario al que se le vende<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_comprador_venta;

	/**
	  * tipo_de_venta
	  * 
	  * nota si esta fue venta a contado o a credito<br>
	  * @access public
	  * @var enum('contado','credito')
	  */
	public $tipo_de_venta;

	/**
	  * fecha
	  * 
	  * la fecha de esta venta<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * subtotal
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var float
	  */
	public $subtotal;

	/**
	  * impuesto
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var float
	  */
	public $impuesto;

	/**
	  * descuento
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var float
	  */
	public $descuento;

	/**
	  * total
	  * 
	  * el total a pagar<br>
	  * @access public
	  * @var float
	  */
	public $total;

	/**
	  * id_sucursal
	  * 
	  * el id de donde se hizo la venta, aunque ya tenemos en que caja se hizo, guardaremos la sucursal ya que la caja puede haberse ido ademas para hacer busquedas mas rapidas<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * id_usuario
	  * 
	  * el usuario que hizo esta venta<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * saldo
	  * 
	  * el saldo pendiente por abonar en esta venta<br>
	  * @access public
	  * @var float
	  */
	public $saldo;

	/**
	  * cancelada
	  * 
	  * Si la venta ha sido cancelada<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelada;

	/**
	  * tipo_de_pago
	  * 
	  * Si la venta fue pagada con tarjeta, cheque, o en efectivo<br>
	  * @access public
	  * @var enum('cheque','tarjeta','efectivo')
	  */
	public $tipo_de_pago;

	/**
	  * retencion
	  * 
	  * Monto de retencion<br>
	  * @access public
	  * @var float
	  */
	public $retencion;

	/**
	  * getIdVenta
	  * 
	  * Get the <i>id_venta</i> property for this object. Donde <i>id_venta</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdVenta()
	{
		return $this->id_venta;
	}

	/**
	  * setIdVenta( $id_venta )
	  * 
	  * Set the <i>id_venta</i> property for this object. Donde <i>id_venta</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdVenta( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdVenta( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdVenta( $id_venta )
	{
		$this->id_venta = $id_venta;
	}

	/**
	  * getEsCotizacion
	  * 
	  * Get the <i>es_cotizacion</i> property for this object. Donde <i>es_cotizacion</i> es verdadero si es una cotizacion
	  * @return int(1)
	  */
	final public function getEsCotizacion()
	{
		return $this->es_cotizacion;
	}

	/**
	  * setEsCotizacion( $es_cotizacion )
	  * 
	  * Set the <i>es_cotizacion</i> property for this object. Donde <i>es_cotizacion</i> es verdadero si es una cotizacion.
	  * Una validacion basica se hara aqui para comprobar que <i>es_cotizacion</i> es de tipo <i>int(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(1)
	  */
	final public function setEsCotizacion( $es_cotizacion )
	{
		$this->es_cotizacion = $es_cotizacion;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es la caja donde se hizo la venta, esta puede ser null ya que un gerente puede vender en el sistema web
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es la caja donde se hizo la venta, esta puede ser null ya que un gerente puede vender en el sistema web.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getIdVentaCaja
	  * 
	  * Get the <i>id_venta_caja</i> property for this object. Donde <i>id_venta_caja</i> es el id de la venta de esta caja
	  * @return int(11)
	  */
	final public function getIdVentaCaja()
	{
		return $this->id_venta_caja;
	}

	/**
	  * setIdVentaCaja( $id_venta_caja )
	  * 
	  * Set the <i>id_venta_caja</i> property for this object. Donde <i>id_venta_caja</i> es el id de la venta de esta caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_venta_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdVentaCaja( $id_venta_caja )
	{
		$this->id_venta_caja = $id_venta_caja;
	}

	/**
	  * getIdCompradorVenta
	  * 
	  * Get the <i>id_comprador_venta</i> property for this object. Donde <i>id_comprador_venta</i> es Id del usuario al que se le vende
	  * @return int(11)
	  */
	final public function getIdCompradorVenta()
	{
		return $this->id_comprador_venta;
	}

	/**
	  * setIdCompradorVenta( $id_comprador_venta )
	  * 
	  * Set the <i>id_comprador_venta</i> property for this object. Donde <i>id_comprador_venta</i> es Id del usuario al que se le vende.
	  * Una validacion basica se hara aqui para comprobar que <i>id_comprador_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCompradorVenta( $id_comprador_venta )
	{
		$this->id_comprador_venta = $id_comprador_venta;
	}

	/**
	  * getTipoDeVenta
	  * 
	  * Get the <i>tipo_de_venta</i> property for this object. Donde <i>tipo_de_venta</i> es nota si esta fue venta a contado o a credito
	  * @return enum('contado','credito')
	  */
	final public function getTipoDeVenta()
	{
		return $this->tipo_de_venta;
	}

	/**
	  * setTipoDeVenta( $tipo_de_venta )
	  * 
	  * Set the <i>tipo_de_venta</i> property for this object. Donde <i>tipo_de_venta</i> es nota si esta fue venta a contado o a credito.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_de_venta</i> es de tipo <i>enum('contado','credito')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('contado','credito')
	  */
	final public function setTipoDeVenta( $tipo_de_venta )
	{
		$this->tipo_de_venta = $tipo_de_venta;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es la fecha de esta venta
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es la fecha de esta venta.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getSubtotal
	  * 
	  * Get the <i>subtotal</i> property for this object. Donde <i>subtotal</i> es  [Campo no documentado]
	  * @return float
	  */
	final public function getSubtotal()
	{
		return $this->subtotal;
	}

	/**
	  * setSubtotal( $subtotal )
	  * 
	  * Set the <i>subtotal</i> property for this object. Donde <i>subtotal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>subtotal</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSubtotal( $subtotal )
	{
		$this->subtotal = $subtotal;
	}

	/**
	  * getImpuesto
	  * 
	  * Get the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es  [Campo no documentado]
	  * @return float
	  */
	final public function getImpuesto()
	{
		return $this->impuesto;
	}

	/**
	  * setImpuesto( $impuesto )
	  * 
	  * Set the <i>impuesto</i> property for this object. Donde <i>impuesto</i> es  [Campo no documentado].
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
	  * Get the <i>descuento</i> property for this object. Donde <i>descuento</i> es  [Campo no documentado]
	  * @return float
	  */
	final public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	  * setDescuento( $descuento )
	  * 
	  * Set the <i>descuento</i> property for this object. Donde <i>descuento</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>descuento</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setDescuento( $descuento )
	{
		$this->descuento = $descuento;
	}

	/**
	  * getTotal
	  * 
	  * Get the <i>total</i> property for this object. Donde <i>total</i> es el total a pagar
	  * @return float
	  */
	final public function getTotal()
	{
		return $this->total;
	}

	/**
	  * setTotal( $total )
	  * 
	  * Set the <i>total</i> property for this object. Donde <i>total</i> es el total a pagar.
	  * Una validacion basica se hara aqui para comprobar que <i>total</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setTotal( $total )
	{
		$this->total = $total;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es el id de donde se hizo la venta, aunque ya tenemos en que caja se hizo, guardaremos la sucursal ya que la caja puede haberse ido ademas para hacer busquedas mas rapidas
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es el id de donde se hizo la venta, aunque ya tenemos en que caja se hizo, guardaremos la sucursal ya que la caja puede haberse ido ademas para hacer busquedas mas rapidas.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que hizo esta venta
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que hizo esta venta.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getSaldo
	  * 
	  * Get the <i>saldo</i> property for this object. Donde <i>saldo</i> es el saldo pendiente por abonar en esta venta
	  * @return float
	  */
	final public function getSaldo()
	{
		return $this->saldo;
	}

	/**
	  * setSaldo( $saldo )
	  * 
	  * Set the <i>saldo</i> property for this object. Donde <i>saldo</i> es el saldo pendiente por abonar en esta venta.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldo( $saldo )
	{
		$this->saldo = $saldo;
	}

	/**
	  * getCancelada
	  * 
	  * Get the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si la venta ha sido cancelada
	  * @return tinyint(1)
	  */
	final public function getCancelada()
	{
		return $this->cancelada;
	}

	/**
	  * setCancelada( $cancelada )
	  * 
	  * Set the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si la venta ha sido cancelada.
	  * Una validacion basica se hara aqui para comprobar que <i>cancelada</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setCancelada( $cancelada )
	{
		$this->cancelada = $cancelada;
	}

	/**
	  * getTipoDePago
	  * 
	  * Get the <i>tipo_de_pago</i> property for this object. Donde <i>tipo_de_pago</i> es Si la venta fue pagada con tarjeta, cheque, o en efectivo
	  * @return enum('cheque','tarjeta','efectivo')
	  */
	final public function getTipoDePago()
	{
		return $this->tipo_de_pago;
	}

	/**
	  * setTipoDePago( $tipo_de_pago )
	  * 
	  * Set the <i>tipo_de_pago</i> property for this object. Donde <i>tipo_de_pago</i> es Si la venta fue pagada con tarjeta, cheque, o en efectivo.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_de_pago</i> es de tipo <i>enum('cheque','tarjeta','efectivo')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('cheque','tarjeta','efectivo')
	  */
	final public function setTipoDePago( $tipo_de_pago )
	{
		$this->tipo_de_pago = $tipo_de_pago;
	}

	/**
	  * getRetencion
	  * 
	  * Get the <i>retencion</i> property for this object. Donde <i>retencion</i> es Monto de retencion
	  * @return float
	  */
	final public function getRetencion()
	{
		return $this->retencion;
	}

	/**
	  * setRetencion( $retencion )
	  * 
	  * Set the <i>retencion</i> property for this object. Donde <i>retencion</i> es Monto de retencion.
	  * Una validacion basica se hara aqui para comprobar que <i>retencion</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setRetencion( $retencion )
	{
		$this->retencion = $retencion;
	}

}
