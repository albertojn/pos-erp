<?php
/** Value Object file for table lote_ubicacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class LoteUbicacion extends VO
{
	/**
	  * Constructor de LoteUbicacion
	  * 
	  * Para construir un objeto de tipo LoteUbicacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return LoteUbicacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_lote']) ){
				$this->id_lote = $data['id_lote'];
			}
			if( isset($data['id_ubicacion']) ){
				$this->id_ubicacion = $data['id_ubicacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto LoteUbicacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_lote" => $this->id_lote,
			"id_ubicacion" => $this->id_ubicacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_lote
	  * 
	  * id del lote<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_lote;

	/**
	  * id_ubicacion
	  * 
	  * id de la ubicacion<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_ubicacion;

	/**
	  * getIdLote
	  * 
	  * Get the <i>id_lote</i> property for this object. Donde <i>id_lote</i> es id del lote
	  * @return int(11)
	  */
	final public function getIdLote()
	{
		return $this->id_lote;
	}

	/**
	  * setIdLote( $id_lote )
	  * 
	  * Set the <i>id_lote</i> property for this object. Donde <i>id_lote</i> es id del lote.
	  * Una validacion basica se hara aqui para comprobar que <i>id_lote</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdLote( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdLote( $id_lote )
	{
		$this->id_lote = $id_lote;
	}

	/**
	  * getIdUbicacion
	  * 
	  * Get the <i>id_ubicacion</i> property for this object. Donde <i>id_ubicacion</i> es id de la ubicacion
	  * @return int(11)
	  */
	final public function getIdUbicacion()
	{
		return $this->id_ubicacion;
	}

	/**
	  * setIdUbicacion( $id_ubicacion )
	  * 
	  * Set the <i>id_ubicacion</i> property for this object. Donde <i>id_ubicacion</i> es id de la ubicacion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_ubicacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUbicacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUbicacion( $id_ubicacion )
	{
		$this->id_ubicacion = $id_ubicacion;
	}

}
