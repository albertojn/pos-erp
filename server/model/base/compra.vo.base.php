<?php
/** Value Object file for table compra.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Compra extends VO
{
	/**
	  * Constructor de Compra
	  * 
	  * Para construir un objeto de tipo Compra debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Compra
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_compra']) ){
				$this->id_compra = $data['id_compra'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['id_compra_caja']) ){
				$this->id_compra_caja = $data['id_compra_caja'];
			}
			if( isset($data['id_vendedor_compra']) ){
				$this->id_vendedor_compra = $data['id_vendedor_compra'];
			}
			if( isset($data['tipo_de_compra']) ){
				$this->tipo_de_compra = $data['tipo_de_compra'];
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
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
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
	  * Este metodo permite tratar a un objeto Compra en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_compra" => $this->id_compra,
			"id_caja" => $this->id_caja,
			"id_compra_caja" => $this->id_compra_caja,
			"id_vendedor_compra" => $this->id_vendedor_compra,
			"tipo_de_compra" => $this->tipo_de_compra,
			"fecha" => $this->fecha,
			"subtotal" => $this->subtotal,
			"impuesto" => $this->impuesto,
			"descuento" => $this->descuento,
			"total" => $this->total,
			"id_sucursal" => $this->id_sucursal,
			"id_usuario" => $this->id_usuario,
			"id_empresa" => $this->id_empresa,
			"saldo" => $this->saldo,
			"cancelada" => $this->cancelada,
			"tipo_de_pago" => $this->tipo_de_pago,
			"retencion" => $this->retencion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_compra
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_compra;

	/**
	  * id_caja
	  * 
	  * la caja donde se hizo la venta, esta puede ser null ya que un gerente puede vender en el sistema web<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * id_compra_caja
	  * 
	  * el id unico de esta caja para las compras<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_compra_caja;

	/**
	  * id_vendedor_compra
	  * 
	  * El id del usuario que nos esta vendiendo, cliente, o proveedor, etc, en caso de sucursal es el valor negativo de esa suc<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_vendedor_compra;

	/**
	  * tipo_de_compra
	  * 
	  * nota si esta fue compra a contado o a credito<br>
	  * @access public
	  * @var enum('contado','credito')
	  */
	public $tipo_de_compra;

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
	  * el usuario que hizo esta compra<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_empresa
	  * 
	  * Id de la empresa que realiza la compra<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * saldo
	  * 
	  * el saldo pendiente por abonar en esta compra<br>
	  * @access public
	  * @var float
	  */
	public $saldo;

	/**
	  * cancelada
	  * 
	  * Si la compra ha sido cancelada o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $cancelada;

	/**
	  * tipo_de_pago
	  * 
	  * Si la compra fue pagada con tarjeta, cheque o efectivo<br>
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
	  * getIdCompra
	  * 
	  * Get the <i>id_compra</i> property for this object. Donde <i>id_compra</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCompra()
	{
		return $this->id_compra;
	}

	/**
	  * setIdCompra( $id_compra )
	  * 
	  * Set the <i>id_compra</i> property for this object. Donde <i>id_compra</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCompra( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCompra( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCompra( $id_compra )
	{
		$this->id_compra = $id_compra;
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
	  * getIdCompraCaja
	  * 
	  * Get the <i>id_compra_caja</i> property for this object. Donde <i>id_compra_caja</i> es el id unico de esta caja para las compras
	  * @return int(11)
	  */
	final public function getIdCompraCaja()
	{
		return $this->id_compra_caja;
	}

	/**
	  * setIdCompraCaja( $id_compra_caja )
	  * 
	  * Set the <i>id_compra_caja</i> property for this object. Donde <i>id_compra_caja</i> es el id unico de esta caja para las compras.
	  * Una validacion basica se hara aqui para comprobar que <i>id_compra_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCompraCaja( $id_compra_caja )
	{
		$this->id_compra_caja = $id_compra_caja;
	}

	/**
	  * getIdVendedorCompra
	  * 
	  * Get the <i>id_vendedor_compra</i> property for this object. Donde <i>id_vendedor_compra</i> es El id del usuario que nos esta vendiendo, cliente, o proveedor, etc, en caso de sucursal es el valor negativo de esa suc
	  * @return int(11)
	  */
	final public function getIdVendedorCompra()
	{
		return $this->id_vendedor_compra;
	}

	/**
	  * setIdVendedorCompra( $id_vendedor_compra )
	  * 
	  * Set the <i>id_vendedor_compra</i> property for this object. Donde <i>id_vendedor_compra</i> es El id del usuario que nos esta vendiendo, cliente, o proveedor, etc, en caso de sucursal es el valor negativo de esa suc.
	  * Una validacion basica se hara aqui para comprobar que <i>id_vendedor_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdVendedorCompra( $id_vendedor_compra )
	{
		$this->id_vendedor_compra = $id_vendedor_compra;
	}

	/**
	  * getTipoDeCompra
	  * 
	  * Get the <i>tipo_de_compra</i> property for this object. Donde <i>tipo_de_compra</i> es nota si esta fue compra a contado o a credito
	  * @return enum('contado','credito')
	  */
	final public function getTipoDeCompra()
	{
		return $this->tipo_de_compra;
	}

	/**
	  * setTipoDeCompra( $tipo_de_compra )
	  * 
	  * Set the <i>tipo_de_compra</i> property for this object. Donde <i>tipo_de_compra</i> es nota si esta fue compra a contado o a credito.
	  * Una validacion basica se hara aqui para comprobar que <i>tipo_de_compra</i> es de tipo <i>enum('contado','credito')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('contado','credito')
	  */
	final public function setTipoDeCompra( $tipo_de_compra )
	{
		$this->tipo_de_compra = $tipo_de_compra;
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
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que hizo esta compra
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es el usuario que hizo esta compra.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa que realiza la compra
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es Id de la empresa que realiza la compra.
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

	/**
	  * getSaldo
	  * 
	  * Get the <i>saldo</i> property for this object. Donde <i>saldo</i> es el saldo pendiente por abonar en esta compra
	  * @return float
	  */
	final public function getSaldo()
	{
		return $this->saldo;
	}

	/**
	  * setSaldo( $saldo )
	  * 
	  * Set the <i>saldo</i> property for this object. Donde <i>saldo</i> es el saldo pendiente por abonar en esta compra.
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
	  * Get the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si la compra ha sido cancelada o no
	  * @return tinyint(1)
	  */
	final public function getCancelada()
	{
		return $this->cancelada;
	}

	/**
	  * setCancelada( $cancelada )
	  * 
	  * Set the <i>cancelada</i> property for this object. Donde <i>cancelada</i> es Si la compra ha sido cancelada o no.
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
	  * Get the <i>tipo_de_pago</i> property for this object. Donde <i>tipo_de_pago</i> es Si la compra fue pagada con tarjeta, cheque o efectivo
	  * @return enum('cheque','tarjeta','efectivo')
	  */
	final public function getTipoDePago()
	{
		return $this->tipo_de_pago;
	}

	/**
	  * setTipoDePago( $tipo_de_pago )
	  * 
	  * Set the <i>tipo_de_pago</i> property for this object. Donde <i>tipo_de_pago</i> es Si la compra fue pagada con tarjeta, cheque o efectivo.
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
