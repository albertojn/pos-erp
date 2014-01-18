<?php
/** Value Object file for table documento_base.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class DocumentoBase extends VO
{
	/**
	  * Constructor de DocumentoBase
	  * 
	  * Para construir un objeto de tipo DocumentoBase debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return DocumentoBase
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_documento_base']) ){
				$this->id_documento_base = $data['id_documento_base'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
			if( isset($data['json_impresion']) ){
				$this->json_impresion = $data['json_impresion'];
			}
                                                                      if( isset($data['nombre_plantilla']) ){
				$this->nombre_plantilla = $data['nombre_plantilla'];
			}
			if( isset($data['ultima_modificacion']) ){
				$this->ultima_modificacion = $data['ultima_modificacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto DocumentoBase en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_documento_base" => $this->id_documento_base,
			"id_empresa" => $this->id_empresa,
			"id_sucursal" => $this->id_sucursal,
			"nombre" => $this->nombre,
			"activo" => $this->activo,
			"json_impresion" => $this->json_impresion,
                                                                      "nombre_plantilla"=>$this->nombre_plantilla,
			"ultima_modificacion" => $this->ultima_modificacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_documento_base
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_documento_base;

	/**
	  * id_empresa
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * id_sucursal
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * nombre
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $nombre;

	/**
	  * activo
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * json_impresion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var longtext
	  */
	public $json_impresion;

	/**
	  * ultima_modificacion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $ultima_modificacion;

	/**
	  * getIdDocumentoBase
	  * 
	  * Get the <i>id_documento_base</i> property for this object. Donde <i>id_documento_base</i> es  [Campo no documentado]
	  * @return int(11)
	  */
                        public $nombre_plantilla;
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
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdDocumentoBase( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdDocumentoBase( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdDocumentoBase( $id_documento_base )
	{
		$this->id_documento_base = $id_documento_base;
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
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
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
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado]
	  * @return varchar(32)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es  [Campo no documentado]
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

	/**
	  * getJsonImpresion
	  * 
	  * Get the <i>json_impresion</i> property for this object. Donde <i>json_impresion</i> es  [Campo no documentado]
	  * @return longtext
	  */
	final public function getJsonImpresion()
	{
		return $this->json_impresion;
	}

	/**
	  * setJsonImpresion( $json_impresion )
	  * 
	  * Set the <i>json_impresion</i> property for this object. Donde <i>json_impresion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>json_impresion</i> es de tipo <i>longtext</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param longtext
	  */
	final public function setJsonImpresion( $json_impresion )
	{
		$this->json_impresion = $json_impresion;
	}

	/**
	  * getUltimaModificacion
	  * 
	  * Get the <i>ultima_modificacion</i> property for this object. Donde <i>ultima_modificacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getUltimaModificacion()
	{
		return $this->ultima_modificacion;
	}

	/**
	  * setUltimaModificacion( $ultima_modificacion )
	  * 
	  * Set the <i>ultima_modificacion</i> property for this object. Donde <i>ultima_modificacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>ultima_modificacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setUltimaModificacion( $ultima_modificacion )
	{
		$this->ultima_modificacion = $ultima_modificacion;
	}
          
                        final public function setNombrePlantilla( $nombre_plantilla )
	{
		$this->nombre_plantilla = $nombre_plantilla;
	}
                      final public function getNombrePlantilla()
	{
		return $this->nombre_plantilla;
	}

}
