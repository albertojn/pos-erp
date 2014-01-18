<?php
/** Value Object file for table servicio_sucursal.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ServicioSucursal extends VO
{
	/**
	  * Constructor de ServicioSucursal
	  * 
	  * Para construir un objeto de tipo ServicioSucursal debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ServicioSucursal
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_servicio']) ){
				$this->id_servicio = $data['id_servicio'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ServicioSucursal en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_servicio" => $this->id_servicio,
			"id_sucursal" => $this->id_sucursal
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_servicio
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_servicio;

	/**
	  * id_sucursal
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * getIdServicio
	  * 
	  * Get the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdServicio()
	{
		return $this->id_servicio;
	}

	/**
	  * setIdServicio( $id_servicio )
	  * 
	  * Set the <i>id_servicio</i> property for this object. Donde <i>id_servicio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_servicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdServicio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdServicio( $id_servicio )
	{
		$this->id_servicio = $id_servicio;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdSucursal( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

}
