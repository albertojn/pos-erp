<?php
/** Value Object file for table venta_arpilla.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class VentaArpilla extends VO
{
	/**
	  * Constructor de VentaArpilla
	  * 
	  * Para construir un objeto de tipo VentaArpilla debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return VentaArpilla
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_venta_arpilla']) ){
				$this->id_venta_arpilla = $data['id_venta_arpilla'];
			}
			if( isset($data['id_venta']) ){
				$this->id_venta = $data['id_venta'];
			}
			if( isset($data['peso_destino']) ){
				$this->peso_destino = $data['peso_destino'];
			}
			if( isset($data['fecha_origen']) ){
				$this->fecha_origen = $data['fecha_origen'];
			}
			if( isset($data['folio']) ){
				$this->folio = $data['folio'];
			}
			if( isset($data['numero_de_viaje']) ){
				$this->numero_de_viaje = $data['numero_de_viaje'];
			}
			if( isset($data['peso_origen']) ){
				$this->peso_origen = $data['peso_origen'];
			}
			if( isset($data['arpillas']) ){
				$this->arpillas = $data['arpillas'];
			}
			if( isset($data['peso_por_arpilla']) ){
				$this->peso_por_arpilla = $data['peso_por_arpilla'];
			}
			if( isset($data['productor']) ){
				$this->productor = $data['productor'];
			}
			if( isset($data['merma_por_arpilla']) ){
				$this->merma_por_arpilla = $data['merma_por_arpilla'];
			}
			if( isset($data['total_origen']) ){
				$this->total_origen = $data['total_origen'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto VentaArpilla en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_venta_arpilla" => $this->id_venta_arpilla,
			"id_venta" => $this->id_venta,
			"peso_destino" => $this->peso_destino,
			"fecha_origen" => $this->fecha_origen,
			"folio" => $this->folio,
			"numero_de_viaje" => $this->numero_de_viaje,
			"peso_origen" => $this->peso_origen,
			"arpillas" => $this->arpillas,
			"peso_por_arpilla" => $this->peso_por_arpilla,
			"productor" => $this->productor,
			"merma_por_arpilla" => $this->merma_por_arpilla,
			"total_origen" => $this->total_origen
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_venta_arpilla
	  * 
	  * Id de la venta por arpilla<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_venta_arpilla;

	/**
	  * id_venta
	  * 
	  * Id de la venta en arpillas<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_venta;

	/**
	  * peso_destino
	  * 
	  * Peso del embarque en el destino<br>
	  * @access public
	  * @var float
	  */
	public $peso_destino;

	/**
	  * fecha_origen
	  * 
	  * Fecha en la que se envÃƒÆ’Ã‚Â­a el embarque<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_origen;

	/**
	  * folio
	  * 
	  * Folio de la entrega<br>
	  * @access public
	  * @var varchar(11)
	  */
	public $folio;

	/**
	  * numero_de_viaje
	  * 
	  * Numero de viaje<br>
	  * @access public
	  * @var varchar(11)
	  */
	public $numero_de_viaje;

	/**
	  * peso_origen
	  * 
	  * Peso del embarque en el origen<br>
	  * @access public
	  * @var float
	  */
	public $peso_origen;

	/**
	  * arpillas
	  * 
	  * Numero de arpillas enviadas<br>
	  * @access public
	  * @var float
	  */
	public $arpillas;

	/**
	  * peso_por_arpilla
	  * 
	  * Promedio de peso por arpilla<br>
	  * @access public
	  * @var float
	  */
	public $peso_por_arpilla;

	/**
	  * productor
	  * 
	  * Nombre del productor<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $productor;

	/**
	  * merma_por_arpilla
	  * 
	  * Merma por arpilla<br>
	  * @access public
	  * @var float
	  */
	public $merma_por_arpilla;

	/**
	  * total_origen
	  * 
	  * Valor del embarque<br>
	  * @access public
	  * @var float
	  */
	public $total_origen;

	/**
	  * getIdVentaArpilla
	  * 
	  * Get the <i>id_venta_arpilla</i> property for this object. Donde <i>id_venta_arpilla</i> es Id de la venta por arpilla
	  * @return int(11)
	  */
	final public function getIdVentaArpilla()
	{
		return $this->id_venta_arpilla;
	}

	/**
	  * setIdVentaArpilla( $id_venta_arpilla )
	  * 
	  * Set the <i>id_venta_arpilla</i> property for this object. Donde <i>id_venta_arpilla</i> es Id de la venta por arpilla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_venta_arpilla</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdVentaArpilla( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdVentaArpilla( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdVentaArpilla( $id_venta_arpilla )
	{
		$this->id_venta_arpilla = $id_venta_arpilla;
	}

	/**
	  * getIdVenta
	  * 
	  * Get the <i>id_venta</i> property for this object. Donde <i>id_venta</i> es Id de la venta en arpillas
	  * @return int(11)
	  */
	final public function getIdVenta()
	{
		return $this->id_venta;
	}

	/**
	  * setIdVenta( $id_venta )
	  * 
	  * Set the <i>id_venta</i> property for this object. Donde <i>id_venta</i> es Id de la venta en arpillas.
	  * Una validacion basica se hara aqui para comprobar que <i>id_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdVenta( $id_venta )
	{
		$this->id_venta = $id_venta;
	}

	/**
	  * getPesoDestino
	  * 
	  * Get the <i>peso_destino</i> property for this object. Donde <i>peso_destino</i> es Peso del embarque en el destino
	  * @return float
	  */
	final public function getPesoDestino()
	{
		return $this->peso_destino;
	}

	/**
	  * setPesoDestino( $peso_destino )
	  * 
	  * Set the <i>peso_destino</i> property for this object. Donde <i>peso_destino</i> es Peso del embarque en el destino.
	  * Una validacion basica se hara aqui para comprobar que <i>peso_destino</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPesoDestino( $peso_destino )
	{
		$this->peso_destino = $peso_destino;
	}

	/**
	  * getFechaOrigen
	  * 
	  * Get the <i>fecha_origen</i> property for this object. Donde <i>fecha_origen</i> es Fecha en la que se envÃƒÆ’Ã‚Â­a el embarque
	  * @return int(11)
	  */
	final public function getFechaOrigen()
	{
		return $this->fecha_origen;
	}

	/**
	  * setFechaOrigen( $fecha_origen )
	  * 
	  * Set the <i>fecha_origen</i> property for this object. Donde <i>fecha_origen</i> es Fecha en la que se envÃƒÆ’Ã‚Â­a el embarque.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_origen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaOrigen( $fecha_origen )
	{
		$this->fecha_origen = $fecha_origen;
	}

	/**
	  * getFolio
	  * 
	  * Get the <i>folio</i> property for this object. Donde <i>folio</i> es Folio de la entrega
	  * @return varchar(11)
	  */
	final public function getFolio()
	{
		return $this->folio;
	}

	/**
	  * setFolio( $folio )
	  * 
	  * Set the <i>folio</i> property for this object. Donde <i>folio</i> es Folio de la entrega.
	  * Una validacion basica se hara aqui para comprobar que <i>folio</i> es de tipo <i>varchar(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(11)
	  */
	final public function setFolio( $folio )
	{
		$this->folio = $folio;
	}

	/**
	  * getNumeroDeViaje
	  * 
	  * Get the <i>numero_de_viaje</i> property for this object. Donde <i>numero_de_viaje</i> es Numero de viaje
	  * @return varchar(11)
	  */
	final public function getNumeroDeViaje()
	{
		return $this->numero_de_viaje;
	}

	/**
	  * setNumeroDeViaje( $numero_de_viaje )
	  * 
	  * Set the <i>numero_de_viaje</i> property for this object. Donde <i>numero_de_viaje</i> es Numero de viaje.
	  * Una validacion basica se hara aqui para comprobar que <i>numero_de_viaje</i> es de tipo <i>varchar(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(11)
	  */
	final public function setNumeroDeViaje( $numero_de_viaje )
	{
		$this->numero_de_viaje = $numero_de_viaje;
	}

	/**
	  * getPesoOrigen
	  * 
	  * Get the <i>peso_origen</i> property for this object. Donde <i>peso_origen</i> es Peso del embarque en el origen
	  * @return float
	  */
	final public function getPesoOrigen()
	{
		return $this->peso_origen;
	}

	/**
	  * setPesoOrigen( $peso_origen )
	  * 
	  * Set the <i>peso_origen</i> property for this object. Donde <i>peso_origen</i> es Peso del embarque en el origen.
	  * Una validacion basica se hara aqui para comprobar que <i>peso_origen</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPesoOrigen( $peso_origen )
	{
		$this->peso_origen = $peso_origen;
	}

	/**
	  * getArpillas
	  * 
	  * Get the <i>arpillas</i> property for this object. Donde <i>arpillas</i> es Numero de arpillas enviadas
	  * @return float
	  */
	final public function getArpillas()
	{
		return $this->arpillas;
	}

	/**
	  * setArpillas( $arpillas )
	  * 
	  * Set the <i>arpillas</i> property for this object. Donde <i>arpillas</i> es Numero de arpillas enviadas.
	  * Una validacion basica se hara aqui para comprobar que <i>arpillas</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setArpillas( $arpillas )
	{
		$this->arpillas = $arpillas;
	}

	/**
	  * getPesoPorArpilla
	  * 
	  * Get the <i>peso_por_arpilla</i> property for this object. Donde <i>peso_por_arpilla</i> es Promedio de peso por arpilla
	  * @return float
	  */
	final public function getPesoPorArpilla()
	{
		return $this->peso_por_arpilla;
	}

	/**
	  * setPesoPorArpilla( $peso_por_arpilla )
	  * 
	  * Set the <i>peso_por_arpilla</i> property for this object. Donde <i>peso_por_arpilla</i> es Promedio de peso por arpilla.
	  * Una validacion basica se hara aqui para comprobar que <i>peso_por_arpilla</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPesoPorArpilla( $peso_por_arpilla )
	{
		$this->peso_por_arpilla = $peso_por_arpilla;
	}

	/**
	  * getProductor
	  * 
	  * Get the <i>productor</i> property for this object. Donde <i>productor</i> es Nombre del productor
	  * @return varchar(64)
	  */
	final public function getProductor()
	{
		return $this->productor;
	}

	/**
	  * setProductor( $productor )
	  * 
	  * Set the <i>productor</i> property for this object. Donde <i>productor</i> es Nombre del productor.
	  * Una validacion basica se hara aqui para comprobar que <i>productor</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setProductor( $productor )
	{
		$this->productor = $productor;
	}

	/**
	  * getMermaPorArpilla
	  * 
	  * Get the <i>merma_por_arpilla</i> property for this object. Donde <i>merma_por_arpilla</i> es Merma por arpilla
	  * @return float
	  */
	final public function getMermaPorArpilla()
	{
		return $this->merma_por_arpilla;
	}

	/**
	  * setMermaPorArpilla( $merma_por_arpilla )
	  * 
	  * Set the <i>merma_por_arpilla</i> property for this object. Donde <i>merma_por_arpilla</i> es Merma por arpilla.
	  * Una validacion basica se hara aqui para comprobar que <i>merma_por_arpilla</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMermaPorArpilla( $merma_por_arpilla )
	{
		$this->merma_por_arpilla = $merma_por_arpilla;
	}

	/**
	  * getTotalOrigen
	  * 
	  * Get the <i>total_origen</i> property for this object. Donde <i>total_origen</i> es Valor del embarque
	  * @return float
	  */
	final public function getTotalOrigen()
	{
		return $this->total_origen;
	}

	/**
	  * setTotalOrigen( $total_origen )
	  * 
	  * Set the <i>total_origen</i> property for this object. Donde <i>total_origen</i> es Valor del embarque.
	  * Una validacion basica se hara aqui para comprobar que <i>total_origen</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setTotalOrigen( $total_origen )
	{
		$this->total_origen = $total_origen;
	}

}
