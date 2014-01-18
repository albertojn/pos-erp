<?php
/** Value Object file for table lote.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Lote extends VO
{
	/**
	  * Constructor de Lote
	  * 
	  * Para construir un objeto de tipo Lote debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Lote
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_lote']) ){
				$this->id_lote = $data['id_lote'];
			}
			if( isset($data['id_almacen']) ){
				$this->id_almacen = $data['id_almacen'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['folio']) ){
				$this->folio = $data['folio'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Lote en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_lote" => $this->id_lote,
			"id_almacen" => $this->id_almacen,
			"id_usuario" => $this->id_usuario,
			"folio" => $this->folio
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_lote
	  * 
	  * Id del lote<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_lote;

	/**
	  * id_almacen
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_almacen;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que creo el lote<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * folio
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $folio;

	/**
	  * getIdLote
	  * 
	  * Get the <i>id_lote</i> property for this object. Donde <i>id_lote</i> es Id del lote
	  * @return int(11)
	  */
	final public function getIdLote()
	{
		return $this->id_lote;
	}

	/**
	  * setIdLote( $id_lote )
	  * 
	  * Set the <i>id_lote</i> property for this object. Donde <i>id_lote</i> es Id del lote.
	  * Una validacion basica se hara aqui para comprobar que <i>id_lote</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdLote( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdLote( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdLote( $id_lote )
	{
		$this->id_lote = $id_lote;
	}

	/**
	  * getIdAlmacen
	  * 
	  * Get the <i>id_almacen</i> property for this object. Donde <i>id_almacen</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdAlmacen()
	{
		return $this->id_almacen;
	}

	/**
	  * setIdAlmacen( $id_almacen )
	  * 
	  * Set the <i>id_almacen</i> property for this object. Donde <i>id_almacen</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_almacen</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdAlmacen( $id_almacen )
	{
		$this->id_almacen = $id_almacen;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que creo el lote
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que creo el lote.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getFolio
	  * 
	  * Get the <i>folio</i> property for this object. Donde <i>folio</i> es  [Campo no documentado]
	  * @return varchar(32)
	  */
	final public function getFolio()
	{
		return $this->folio;
	}

	/**
	  * setFolio( $folio )
	  * 
	  * Set the <i>folio</i> property for this object. Donde <i>folio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>folio</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setFolio( $folio )
	{
		$this->folio = $folio;
	}

}
