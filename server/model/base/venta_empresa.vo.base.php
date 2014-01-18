<?php
/** Value Object file for table venta_empresa.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class VentaEmpresa extends VO
{
	/**
	  * Constructor de VentaEmpresa
	  * 
	  * Para construir un objeto de tipo VentaEmpresa debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return VentaEmpresa
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_venta']) ){
				$this->id_venta = $data['id_venta'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
			if( isset($data['total']) ){
				$this->total = $data['total'];
			}
			if( isset($data['saldada']) ){
				$this->saldada = $data['saldada'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto VentaEmpresa en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_venta" => $this->id_venta,
			"id_empresa" => $this->id_empresa,
			"total" => $this->total,
			"saldada" => $this->saldada
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_venta
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_venta;

	/**
	  * id_empresa
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * total
	  * 
	  * El total correspondiente<br>
	  * @access public
	  * @var float
	  */
	public $total;

	/**
	  * saldada
	  * 
	  * Si la venta ya fue saldada o aun no lo ha sido<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $saldada;

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
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdVenta( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdVenta( $id_venta )
	{
		$this->id_venta = $id_venta;
	}

	/**
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdEmpresa( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

	/**
	  * getTotal
	  * 
	  * Get the <i>total</i> property for this object. Donde <i>total</i> es El total correspondiente
	  * @return float
	  */
	final public function getTotal()
	{
		return $this->total;
	}

	/**
	  * setTotal( $total )
	  * 
	  * Set the <i>total</i> property for this object. Donde <i>total</i> es El total correspondiente.
	  * Una validacion basica se hara aqui para comprobar que <i>total</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setTotal( $total )
	{
		$this->total = $total;
	}

	/**
	  * getSaldada
	  * 
	  * Get the <i>saldada</i> property for this object. Donde <i>saldada</i> es Si la venta ya fue saldada o aun no lo ha sido
	  * @return tinyint(1)
	  */
	final public function getSaldada()
	{
		return $this->saldada;
	}

	/**
	  * setSaldada( $saldada )
	  * 
	  * Set the <i>saldada</i> property for this object. Donde <i>saldada</i> es Si la venta ya fue saldada o aun no lo ha sido.
	  * Una validacion basica se hara aqui para comprobar que <i>saldada</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setSaldada( $saldada )
	{
		$this->saldada = $saldada;
	}

}
