<?php
/** Value Object file for table compra_arpilla.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class CompraArpilla extends VO
{
	/**
	  * Constructor de CompraArpilla
	  * 
	  * Para construir un objeto de tipo CompraArpilla debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return CompraArpilla
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_compra_arpilla']) ){
				$this->id_compra_arpilla = $data['id_compra_arpilla'];
			}
			if( isset($data['id_compra']) ){
				$this->id_compra = $data['id_compra'];
			}
			if( isset($data['peso_origen']) ){
				$this->peso_origen = $data['peso_origen'];
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
			if( isset($data['peso_recibido']) ){
				$this->peso_recibido = $data['peso_recibido'];
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
	  * Este metodo permite tratar a un objeto CompraArpilla en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_compra_arpilla" => $this->id_compra_arpilla,
			"id_compra" => $this->id_compra,
			"peso_origen" => $this->peso_origen,
			"fecha_origen" => $this->fecha_origen,
			"folio" => $this->folio,
			"numero_de_viaje" => $this->numero_de_viaje,
			"peso_recibido" => $this->peso_recibido,
			"arpillas" => $this->arpillas,
			"peso_por_arpilla" => $this->peso_por_arpilla,
			"productor" => $this->productor,
			"merma_por_arpilla" => $this->merma_por_arpilla,
			"total_origen" => $this->total_origen
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_compra_arpilla
	  * 
	  * Id de la tabla compra por arpilla<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_compra_arpilla;

	/**
	  * id_compra
	  * 
	  * Id de la compra a la que se refiere<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_compra;

	/**
	  * peso_origen
	  * 
	  * El peso del camion en el origen<br>
	  * @access public
	  * @var float
	  */
	public $peso_origen;

	/**
	  * fecha_origen
	  * 
	  * Fecha en la que se envÃƒÆ’Ã‚Â­o el embarque<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_origen;

	/**
	  * folio
	  * 
	  * Folio del camion<br>
	  * @access public
	  * @var varchar(11)
	  */
	public $folio;

	/**
	  * numero_de_viaje
	  * 
	  * NÃƒÆ’Ã‚Âºmero de viaje<br>
	  * @access public
	  * @var varchar(11)
	  */
	public $numero_de_viaje;

	/**
	  * peso_recibido
	  * 
	  * Peso del camion al llegar<br>
	  * @access public
	  * @var float
	  */
	public $peso_recibido;

	/**
	  * arpillas
	  * 
	  * Cantidad de arpillas recibidas<br>
	  * @access public
	  * @var float
	  */
	public $arpillas;

	/**
	  * peso_por_arpilla
	  * 
	  * El peso por arpilla promedio<br>
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
	  * La merma de producto por arpilla<br>
	  * @access public
	  * @var float
	  */
	public $merma_por_arpilla;

	/**
	  * total_origen
	  * 
	  * El valor del embarque segÃƒÆ’Ã‚Âºn el proveedor<br>
	  * @access public
	  * @var float
	  */
	public $total_origen;

	/**
	  * getIdCompraArpilla
	  * 
	  * Get the <i>id_compra_arpilla</i> property for this object. Donde <i>id_compra_arpilla</i> es Id de la tabla compra por arpilla
	  * @return int(11)
	  */
	final public function getIdCompraArpilla()
	{
		return $this->id_compra_arpilla;
	}

	/**
	  * setIdCompraArpilla( $id_compra_arpilla )
	  * 
	  * Set the <i>id_compra_arpilla</i> property for this object. Donde <i>id_compra_arpilla</i> es Id de la tabla compra por arpilla.
	  * Una validacion basica se hara aqui para comprobar que <i>id_compra_arpilla</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCompraArpilla( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCompraArpilla( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCompraArpilla( $id_compra_arpilla )
	{
		$this->id_compra_arpilla = $id_compra_arpilla;
	}

	/**
	  * getIdCompra
	  * 
	  * Get the <i>id_compra</i> property for this object. Donde <i>id_compra</i> es Id de la compra a la que se refiere
	  * @return int(11)
	  */
	final public function getIdCompra()
	{
		return $this->id_compra;
	}

	/**
	  * setIdCompra( $id_compra )
	  * 
	  * Set the <i>id_compra</i> property for this object. Donde <i>id_compra</i> es Id de la compra a la que se refiere.
	  * Una validacion basica se hara aqui para comprobar que <i>id_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCompra( $id_compra )
	{
		$this->id_compra = $id_compra;
	}

	/**
	  * getPesoOrigen
	  * 
	  * Get the <i>peso_origen</i> property for this object. Donde <i>peso_origen</i> es El peso del camion en el origen
	  * @return float
	  */
	final public function getPesoOrigen()
	{
		return $this->peso_origen;
	}

	/**
	  * setPesoOrigen( $peso_origen )
	  * 
	  * Set the <i>peso_origen</i> property for this object. Donde <i>peso_origen</i> es El peso del camion en el origen.
	  * Una validacion basica se hara aqui para comprobar que <i>peso_origen</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPesoOrigen( $peso_origen )
	{
		$this->peso_origen = $peso_origen;
	}

	/**
	  * getFechaOrigen
	  * 
	  * Get the <i>fecha_origen</i> property for this object. Donde <i>fecha_origen</i> es Fecha en la que se envÃƒÆ’Ã‚Â­o el embarque
	  * @return int(11)
	  */
	final public function getFechaOrigen()
	{
		return $this->fecha_origen;
	}

	/**
	  * setFechaOrigen( $fecha_origen )
	  * 
	  * Set the <i>fecha_origen</i> property for this object. Donde <i>fecha_origen</i> es Fecha en la que se envÃƒÆ’Ã‚Â­o el embarque.
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
	  * Get the <i>folio</i> property for this object. Donde <i>folio</i> es Folio del camion
	  * @return varchar(11)
	  */
	final public function getFolio()
	{
		return $this->folio;
	}

	/**
	  * setFolio( $folio )
	  * 
	  * Set the <i>folio</i> property for this object. Donde <i>folio</i> es Folio del camion.
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
	  * Get the <i>numero_de_viaje</i> property for this object. Donde <i>numero_de_viaje</i> es NÃƒÆ’Ã‚Âºmero de viaje
	  * @return varchar(11)
	  */
	final public function getNumeroDeViaje()
	{
		return $this->numero_de_viaje;
	}

	/**
	  * setNumeroDeViaje( $numero_de_viaje )
	  * 
	  * Set the <i>numero_de_viaje</i> property for this object. Donde <i>numero_de_viaje</i> es NÃƒÆ’Ã‚Âºmero de viaje.
	  * Una validacion basica se hara aqui para comprobar que <i>numero_de_viaje</i> es de tipo <i>varchar(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(11)
	  */
	final public function setNumeroDeViaje( $numero_de_viaje )
	{
		$this->numero_de_viaje = $numero_de_viaje;
	}

	/**
	  * getPesoRecibido
	  * 
	  * Get the <i>peso_recibido</i> property for this object. Donde <i>peso_recibido</i> es Peso del camion al llegar
	  * @return float
	  */
	final public function getPesoRecibido()
	{
		return $this->peso_recibido;
	}

	/**
	  * setPesoRecibido( $peso_recibido )
	  * 
	  * Set the <i>peso_recibido</i> property for this object. Donde <i>peso_recibido</i> es Peso del camion al llegar.
	  * Una validacion basica se hara aqui para comprobar que <i>peso_recibido</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPesoRecibido( $peso_recibido )
	{
		$this->peso_recibido = $peso_recibido;
	}

	/**
	  * getArpillas
	  * 
	  * Get the <i>arpillas</i> property for this object. Donde <i>arpillas</i> es Cantidad de arpillas recibidas
	  * @return float
	  */
	final public function getArpillas()
	{
		return $this->arpillas;
	}

	/**
	  * setArpillas( $arpillas )
	  * 
	  * Set the <i>arpillas</i> property for this object. Donde <i>arpillas</i> es Cantidad de arpillas recibidas.
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
	  * Get the <i>peso_por_arpilla</i> property for this object. Donde <i>peso_por_arpilla</i> es El peso por arpilla promedio
	  * @return float
	  */
	final public function getPesoPorArpilla()
	{
		return $this->peso_por_arpilla;
	}

	/**
	  * setPesoPorArpilla( $peso_por_arpilla )
	  * 
	  * Set the <i>peso_por_arpilla</i> property for this object. Donde <i>peso_por_arpilla</i> es El peso por arpilla promedio.
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
	  * Get the <i>merma_por_arpilla</i> property for this object. Donde <i>merma_por_arpilla</i> es La merma de producto por arpilla
	  * @return float
	  */
	final public function getMermaPorArpilla()
	{
		return $this->merma_por_arpilla;
	}

	/**
	  * setMermaPorArpilla( $merma_por_arpilla )
	  * 
	  * Set the <i>merma_por_arpilla</i> property for this object. Donde <i>merma_por_arpilla</i> es La merma de producto por arpilla.
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
	  * Get the <i>total_origen</i> property for this object. Donde <i>total_origen</i> es El valor del embarque segÃƒÆ’Ã‚Âºn el proveedor
	  * @return float
	  */
	final public function getTotalOrigen()
	{
		return $this->total_origen;
	}

	/**
	  * setTotalOrigen( $total_origen )
	  * 
	  * Set the <i>total_origen</i> property for this object. Donde <i>total_origen</i> es El valor del embarque segÃƒÆ’Ã‚Âºn el proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>total_origen</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setTotalOrigen( $total_origen )
	{
		$this->total_origen = $total_origen;
	}

}
