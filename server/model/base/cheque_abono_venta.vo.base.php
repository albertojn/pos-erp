<?php
/** Value Object file for table cheque_abono_venta.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ChequeAbonoVenta extends VO
{
	/**
	  * Constructor de ChequeAbonoVenta
	  * 
	  * Para construir un objeto de tipo ChequeAbonoVenta debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ChequeAbonoVenta
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_cheque']) ){
				$this->id_cheque = $data['id_cheque'];
			}
			if( isset($data['id_abono_venta']) ){
				$this->id_abono_venta = $data['id_abono_venta'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ChequeAbonoVenta en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_cheque" => $this->id_cheque,
			"id_abono_venta" => $this->id_abono_venta
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_cheque
	  * 
	  * Id del cheque con el que se abono<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cheque;

	/**
	  * id_abono_venta
	  * 
	  * Id del abono que se pago con ese cheque<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_abono_venta;

	/**
	  * getIdCheque
	  * 
	  * Get the <i>id_cheque</i> property for this object. Donde <i>id_cheque</i> es Id del cheque con el que se abono
	  * @return int(11)
	  */
	final public function getIdCheque()
	{
		return $this->id_cheque;
	}

	/**
	  * setIdCheque( $id_cheque )
	  * 
	  * Set the <i>id_cheque</i> property for this object. Donde <i>id_cheque</i> es Id del cheque con el que se abono.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cheque</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCheque( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCheque( $id_cheque )
	{
		$this->id_cheque = $id_cheque;
	}

	/**
	  * getIdAbonoVenta
	  * 
	  * Get the <i>id_abono_venta</i> property for this object. Donde <i>id_abono_venta</i> es Id del abono que se pago con ese cheque
	  * @return int(11)
	  */
	final public function getIdAbonoVenta()
	{
		return $this->id_abono_venta;
	}

	/**
	  * setIdAbonoVenta( $id_abono_venta )
	  * 
	  * Set the <i>id_abono_venta</i> property for this object. Donde <i>id_abono_venta</i> es Id del abono que se pago con ese cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>id_abono_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAbonoVenta( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAbonoVenta( $id_abono_venta )
	{
		$this->id_abono_venta = $id_abono_venta;
	}

}
