<?php
/** Value Object file for table impresora_caja.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ImpresoraCaja extends VO
{
	/**
	  * Constructor de ImpresoraCaja
	  * 
	  * Para construir un objeto de tipo ImpresoraCaja debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ImpresoraCaja
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_impresora']) ){
				$this->id_impresora = $data['id_impresora'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ImpresoraCaja en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_impresora" => $this->id_impresora,
			"id_caja" => $this->id_caja
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_impresora
	  * 
	  * Id de la impresora<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_impresora;

	/**
	  * id_caja
	  * 
	  * Id de la caja que utiliza la impresora<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * getIdImpresora
	  * 
	  * Get the <i>id_impresora</i> property for this object. Donde <i>id_impresora</i> es Id de la impresora
	  * @return int(11)
	  */
	final public function getIdImpresora()
	{
		return $this->id_impresora;
	}

	/**
	  * setIdImpresora( $id_impresora )
	  * 
	  * Set the <i>id_impresora</i> property for this object. Donde <i>id_impresora</i> es Id de la impresora.
	  * Una validacion basica se hara aqui para comprobar que <i>id_impresora</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdImpresora( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdImpresora( $id_impresora )
	{
		$this->id_impresora = $id_impresora;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja que utiliza la impresora
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja que utiliza la impresora.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

}
