<?php
/** Value Object file for table documento.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Documento extends VO
{
	/**
	  * Constructor de Documento
	  * 
	  * Para construir un objeto de tipo Documento debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Documento
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_documento']) ){
				$this->id_documento = $data['id_documento'];
			}
			if( isset($data['id_documento_base']) ){
				$this->id_documento_base = $data['id_documento_base'];
			}
			if( isset($data['folio']) ){
				$this->folio = $data['folio'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['id_operacion']) ){
				$this->id_operacion = $data['id_operacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Documento en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_documento" => $this->id_documento,
			"id_documento_base" => $this->id_documento_base,
			"folio" => $this->folio,
			"fecha" => $this->fecha,
			"id_operacion" => $this->id_operacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_documento
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_documento;

	/**
	  * id_documento_base
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_documento_base;

	/**
	  * folio
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(8)
	  */
	public $folio;

	/**
	  * fecha
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * id_operacion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_operacion;

	/**
	  * getIdDocumento
	  * 
	  * Get the <i>id_documento</i> property for this object. Donde <i>id_documento</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdDocumento()
	{
		return $this->id_documento;
	}

	/**
	  * setIdDocumento( $id_documento )
	  * 
	  * Set the <i>id_documento</i> property for this object. Donde <i>id_documento</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_documento</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdDocumento( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdDocumento( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdDocumento( $id_documento )
	{
		$this->id_documento = $id_documento;
	}

	/**
	  * getIdDocumentoBase
	  * 
	  * Get the <i>id_documento_base</i> property for this object. Donde <i>id_documento_base</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdDocumentoBase()
	{
		return $this->id_documento_base;
	}

	/**
	  * setIdDocumentoBase( $id_documento_base )
	  * 
	  * Set the <i>id_documento_base</i> property for this object. Donde <i>id_documento_base</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_documento_base</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdDocumentoBase( $id_documento_base )
	{
		$this->id_documento_base = $id_documento_base;
	}

	/**
	  * getFolio
	  * 
	  * Get the <i>folio</i> property for this object. Donde <i>folio</i> es  [Campo no documentado]
	  * @return varchar(8)
	  */
	final public function getFolio()
	{
		return $this->folio;
	}

	/**
	  * setFolio( $folio )
	  * 
	  * Set the <i>folio</i> property for this object. Donde <i>folio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>folio</i> es de tipo <i>varchar(8)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(8)
	  */
	final public function setFolio( $folio )
	{
		$this->folio = $folio;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getIdOperacion
	  * 
	  * Get the <i>id_operacion</i> property for this object. Donde <i>id_operacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdOperacion()
	{
		return $this->id_operacion;
	}

	/**
	  * setIdOperacion( $id_operacion )
	  * 
	  * Set the <i>id_operacion</i> property for this object. Donde <i>id_operacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_operacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdOperacion( $id_operacion )
	{
		$this->id_operacion = $id_operacion;
	}

}
