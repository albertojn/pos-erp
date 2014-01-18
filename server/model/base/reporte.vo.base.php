<?php
/** Value Object file for table reporte.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Reporte extends VO
{
	/**
	  * Constructor de Reporte
	  * 
	  * Para construir un objeto de tipo Reporte debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Reporte
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_reporte']) ){
				$this->id_reporte = $data['id_reporte'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Reporte en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_reporte" => $this->id_reporte
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_reporte
	  * 
	  * Id del reporte<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_reporte;

	/**
	  * getIdReporte
	  * 
	  * Get the <i>id_reporte</i> property for this object. Donde <i>id_reporte</i> es Id del reporte
	  * @return int(11)
	  */
	final public function getIdReporte()
	{
		return $this->id_reporte;
	}

	/**
	  * setIdReporte( $id_reporte )
	  * 
	  * Set the <i>id_reporte</i> property for this object. Donde <i>id_reporte</i> es Id del reporte.
	  * Una validacion basica se hara aqui para comprobar que <i>id_reporte</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdReporte( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdReporte( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdReporte( $id_reporte )
	{
		$this->id_reporte = $id_reporte;
	}

}
