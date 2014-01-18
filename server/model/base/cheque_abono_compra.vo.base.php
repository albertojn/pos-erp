<?php
/** Value Object file for table cheque_abono_compra.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ChequeAbonoCompra extends VO
{
	/**
	  * Constructor de ChequeAbonoCompra
	  * 
	  * Para construir un objeto de tipo ChequeAbonoCompra debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ChequeAbonoCompra
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_cheque']) ){
				$this->id_cheque = $data['id_cheque'];
			}
			if( isset($data['id_abono_compra']) ){
				$this->id_abono_compra = $data['id_abono_compra'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ChequeAbonoCompra en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_cheque" => $this->id_cheque,
			"id_abono_compra" => $this->id_abono_compra
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
	  * id_abono_compra
	  * 
	  * Id del abono que se pago con ese cheque<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_abono_compra;

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
	  * getIdAbonoCompra
	  * 
	  * Get the <i>id_abono_compra</i> property for this object. Donde <i>id_abono_compra</i> es Id del abono que se pago con ese cheque
	  * @return int(11)
	  */
	final public function getIdAbonoCompra()
	{
		return $this->id_abono_compra;
	}

	/**
	  * setIdAbonoCompra( $id_abono_compra )
	  * 
	  * Set the <i>id_abono_compra</i> property for this object. Donde <i>id_abono_compra</i> es Id del abono que se pago con ese cheque.
	  * Una validacion basica se hara aqui para comprobar que <i>id_abono_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAbonoCompra( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAbonoCompra( $id_abono_compra )
	{
		$this->id_abono_compra = $id_abono_compra;
	}

}
