<?php
/** Value Object file for table direccion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Direccion extends VO
{
	/**
	  * Constructor de Direccion
	  * 
	  * Para construir un objeto de tipo Direccion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Direccion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_direccion']) ){
				$this->id_direccion = $data['id_direccion'];
			}
			if( isset($data['calle']) ){
				$this->calle = $data['calle'];
			}
			if( isset($data['numero_exterior']) ){
				$this->numero_exterior = $data['numero_exterior'];
			}
			if( isset($data['numero_interior']) ){
				$this->numero_interior = $data['numero_interior'];
			}
			if( isset($data['referencia']) ){
				$this->referencia = $data['referencia'];
			}
			if( isset($data['colonia']) ){
				$this->colonia = $data['colonia'];
			}
			if( isset($data['id_ciudad']) ){
				$this->id_ciudad = $data['id_ciudad'];
			}
			if( isset($data['codigo_postal']) ){
				$this->codigo_postal = $data['codigo_postal'];
			}
			if( isset($data['telefono']) ){
				$this->telefono = $data['telefono'];
			}
			if( isset($data['telefono2']) ){
				$this->telefono2 = $data['telefono2'];
			}
			if( isset($data['ultima_modificacion']) ){
				$this->ultima_modificacion = $data['ultima_modificacion'];
			}
			if( isset($data['id_usuario_ultima_modificacion']) ){
				$this->id_usuario_ultima_modificacion = $data['id_usuario_ultima_modificacion'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Direccion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_direccion" => $this->id_direccion,
			"calle" => $this->calle,
			"numero_exterior" => $this->numero_exterior,
			"numero_interior" => $this->numero_interior,
			"referencia" => $this->referencia,
			"colonia" => $this->colonia,
			"id_ciudad" => $this->id_ciudad,
			"codigo_postal" => $this->codigo_postal,
			"telefono" => $this->telefono,
			"telefono2" => $this->telefono2,
			"ultima_modificacion" => $this->ultima_modificacion,
			"id_usuario_ultima_modificacion" => $this->id_usuario_ultima_modificacion
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_direccion
	  * 
	  * El id de esta direccion<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_direccion;

	/**
	  * calle
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $calle;

	/**
	  * numero_exterior
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(8)
	  */
	public $numero_exterior;

	/**
	  * numero_interior
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(8)
	  */
	public $numero_interior;

	/**
	  * referencia
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(256)
	  */
	public $referencia;

	/**
	  * colonia
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $colonia;

	/**
	  * id_ciudad
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_ciudad;

	/**
	  * codigo_postal
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(10)
	  */
	public $codigo_postal;

	/**
	  * telefono
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $telefono;

	/**
	  * telefono2
	  * 
	  * Telefono alterno de la direccion<br>
	  * @access public
	  * @var varchar(32)
	  */
	public $telefono2;

	/**
	  * ultima_modificacion
	  * 
	  * La ultima vez que este registro se modifico<br>
	  * @access public
	  * @var int(11)
	  */
	public $ultima_modificacion;

	/**
	  * id_usuario_ultima_modificacion
	  * 
	  * quien fue el usuario que modifico este registro la ultima vez<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario_ultima_modificacion;

	/**
	  * getIdDireccion
	  * 
	  * Get the <i>id_direccion</i> property for this object. Donde <i>id_direccion</i> es El id de esta direccion
	  * @return int(11)
	  */
	final public function getIdDireccion()
	{
		return $this->id_direccion;
	}

	/**
	  * setIdDireccion( $id_direccion )
	  * 
	  * Set the <i>id_direccion</i> property for this object. Donde <i>id_direccion</i> es El id de esta direccion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_direccion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdDireccion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdDireccion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdDireccion( $id_direccion )
	{
		$this->id_direccion = $id_direccion;
	}

	/**
	  * getCalle
	  * 
	  * Get the <i>calle</i> property for this object. Donde <i>calle</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getCalle()
	{
		return $this->calle;
	}

	/**
	  * setCalle( $calle )
	  * 
	  * Set the <i>calle</i> property for this object. Donde <i>calle</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>calle</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setCalle( $calle )
	{
		$this->calle = $calle;
	}

	/**
	  * getNumeroExterior
	  * 
	  * Get the <i>numero_exterior</i> property for this object. Donde <i>numero_exterior</i> es  [Campo no documentado]
	  * @return varchar(8)
	  */
	final public function getNumeroExterior()
	{
		return $this->numero_exterior;
	}

	/**
	  * setNumeroExterior( $numero_exterior )
	  * 
	  * Set the <i>numero_exterior</i> property for this object. Donde <i>numero_exterior</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>numero_exterior</i> es de tipo <i>varchar(8)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(8)
	  */
	final public function setNumeroExterior( $numero_exterior )
	{
		$this->numero_exterior = $numero_exterior;
	}

	/**
	  * getNumeroInterior
	  * 
	  * Get the <i>numero_interior</i> property for this object. Donde <i>numero_interior</i> es  [Campo no documentado]
	  * @return varchar(8)
	  */
	final public function getNumeroInterior()
	{
		return $this->numero_interior;
	}

	/**
	  * setNumeroInterior( $numero_interior )
	  * 
	  * Set the <i>numero_interior</i> property for this object. Donde <i>numero_interior</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>numero_interior</i> es de tipo <i>varchar(8)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(8)
	  */
	final public function setNumeroInterior( $numero_interior )
	{
		$this->numero_interior = $numero_interior;
	}

	/**
	  * getReferencia
	  * 
	  * Get the <i>referencia</i> property for this object. Donde <i>referencia</i> es  [Campo no documentado]
	  * @return varchar(256)
	  */
	final public function getReferencia()
	{
		return $this->referencia;
	}

	/**
	  * setReferencia( $referencia )
	  * 
	  * Set the <i>referencia</i> property for this object. Donde <i>referencia</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>referencia</i> es de tipo <i>varchar(256)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(256)
	  */
	final public function setReferencia( $referencia )
	{
		$this->referencia = $referencia;
	}

	/**
	  * getColonia
	  * 
	  * Get the <i>colonia</i> property for this object. Donde <i>colonia</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getColonia()
	{
		return $this->colonia;
	}

	/**
	  * setColonia( $colonia )
	  * 
	  * Set the <i>colonia</i> property for this object. Donde <i>colonia</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>colonia</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setColonia( $colonia )
	{
		$this->colonia = $colonia;
	}

	/**
	  * getIdCiudad
	  * 
	  * Get the <i>id_ciudad</i> property for this object. Donde <i>id_ciudad</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCiudad()
	{
		return $this->id_ciudad;
	}

	/**
	  * setIdCiudad( $id_ciudad )
	  * 
	  * Set the <i>id_ciudad</i> property for this object. Donde <i>id_ciudad</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_ciudad</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCiudad( $id_ciudad )
	{
		$this->id_ciudad = $id_ciudad;
	}

	/**
	  * getCodigoPostal
	  * 
	  * Get the <i>codigo_postal</i> property for this object. Donde <i>codigo_postal</i> es  [Campo no documentado]
	  * @return varchar(10)
	  */
	final public function getCodigoPostal()
	{
		return $this->codigo_postal;
	}

	/**
	  * setCodigoPostal( $codigo_postal )
	  * 
	  * Set the <i>codigo_postal</i> property for this object. Donde <i>codigo_postal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>codigo_postal</i> es de tipo <i>varchar(10)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(10)
	  */
	final public function setCodigoPostal( $codigo_postal )
	{
		$this->codigo_postal = $codigo_postal;
	}

	/**
	  * getTelefono
	  * 
	  * Get the <i>telefono</i> property for this object. Donde <i>telefono</i> es  [Campo no documentado]
	  * @return varchar(32)
	  */
	final public function getTelefono()
	{
		return $this->telefono;
	}

	/**
	  * setTelefono( $telefono )
	  * 
	  * Set the <i>telefono</i> property for this object. Donde <i>telefono</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>telefono</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setTelefono( $telefono )
	{
		$this->telefono = $telefono;
	}

	/**
	  * getTelefono2
	  * 
	  * Get the <i>telefono2</i> property for this object. Donde <i>telefono2</i> es Telefono alterno de la direccion
	  * @return varchar(32)
	  */
	final public function getTelefono2()
	{
		return $this->telefono2;
	}

	/**
	  * setTelefono2( $telefono2 )
	  * 
	  * Set the <i>telefono2</i> property for this object. Donde <i>telefono2</i> es Telefono alterno de la direccion.
	  * Una validacion basica se hara aqui para comprobar que <i>telefono2</i> es de tipo <i>varchar(32)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(32)
	  */
	final public function setTelefono2( $telefono2 )
	{
		$this->telefono2 = $telefono2;
	}

	/**
	  * getUltimaModificacion
	  * 
	  * Get the <i>ultima_modificacion</i> property for this object. Donde <i>ultima_modificacion</i> es La ultima vez que este registro se modifico
	  * @return int(11)
	  */
	final public function getUltimaModificacion()
	{
		return $this->ultima_modificacion;
	}

	/**
	  * setUltimaModificacion( $ultima_modificacion )
	  * 
	  * Set the <i>ultima_modificacion</i> property for this object. Donde <i>ultima_modificacion</i> es La ultima vez que este registro se modifico.
	  * Una validacion basica se hara aqui para comprobar que <i>ultima_modificacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setUltimaModificacion( $ultima_modificacion )
	{
		$this->ultima_modificacion = $ultima_modificacion;
	}

	/**
	  * getIdUsuarioUltimaModificacion
	  * 
	  * Get the <i>id_usuario_ultima_modificacion</i> property for this object. Donde <i>id_usuario_ultima_modificacion</i> es quien fue el usuario que modifico este registro la ultima vez
	  * @return int(11)
	  */
	final public function getIdUsuarioUltimaModificacion()
	{
		return $this->id_usuario_ultima_modificacion;
	}

	/**
	  * setIdUsuarioUltimaModificacion( $id_usuario_ultima_modificacion )
	  * 
	  * Set the <i>id_usuario_ultima_modificacion</i> property for this object. Donde <i>id_usuario_ultima_modificacion</i> es quien fue el usuario que modifico este registro la ultima vez.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario_ultima_modificacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuarioUltimaModificacion( $id_usuario_ultima_modificacion )
	{
		$this->id_usuario_ultima_modificacion = $id_usuario_ultima_modificacion;
	}

}
