<?php
/** Value Object file for table paquete.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Paquete extends VO
{
	/**
	  * Constructor de Paquete
	  * 
	  * Para construir un objeto de tipo Paquete debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Paquete
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_paquete']) ){
				$this->id_paquete = $data['id_paquete'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['foto_paquete']) ){
				$this->foto_paquete = $data['foto_paquete'];
			}
			if( isset($data['costo_estandar']) ){
				$this->costo_estandar = $data['costo_estandar'];
			}
			if( isset($data['precio']) ){
				$this->precio = $data['precio'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Paquete en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_paquete" => $this->id_paquete,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"foto_paquete" => $this->foto_paquete,
			"costo_estandar" => $this->costo_estandar,
			"precio" => $this->precio,
			"activo" => $this->activo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_paquete
	  * 
	  * Id de la tabla paquete<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_paquete;

	/**
	  * nombre
	  * 
	  * Nombre del paquete<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion larga del paquete<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * foto_paquete
	  * 
	  * Url de la foto del paquete<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $foto_paquete;

	/**
	  * costo_estandar
	  * 
	  * Costo estandar del paquete<br>
	  * @access public
	  * @var float
	  */
	public $costo_estandar;

	/**
	  * precio
	  * 
	  * Precio dijo del paquete<br>
	  * @access public
	  * @var float
	  */
	public $precio;

	/**
	  * activo
	  * 
	  * Si el paquete esta activo o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * getIdPaquete
	  * 
	  * Get the <i>id_paquete</i> property for this object. Donde <i>id_paquete</i> es Id de la tabla paquete
	  * @return int(11)
	  */
	final public function getIdPaquete()
	{
		return $this->id_paquete;
	}

	/**
	  * setIdPaquete( $id_paquete )
	  * 
	  * Set the <i>id_paquete</i> property for this object. Donde <i>id_paquete</i> es Id de la tabla paquete.
	  * Una validacion basica se hara aqui para comprobar que <i>id_paquete</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdPaquete( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdPaquete( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdPaquete( $id_paquete )
	{
		$this->id_paquete = $id_paquete;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del paquete
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del paquete.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga del paquete
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga del paquete.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getFotoPaquete
	  * 
	  * Get the <i>foto_paquete</i> property for this object. Donde <i>foto_paquete</i> es Url de la foto del paquete
	  * @return varchar(255)
	  */
	final public function getFotoPaquete()
	{
		return $this->foto_paquete;
	}

	/**
	  * setFotoPaquete( $foto_paquete )
	  * 
	  * Set the <i>foto_paquete</i> property for this object. Donde <i>foto_paquete</i> es Url de la foto del paquete.
	  * Una validacion basica se hara aqui para comprobar que <i>foto_paquete</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setFotoPaquete( $foto_paquete )
	{
		$this->foto_paquete = $foto_paquete;
	}

	/**
	  * getCostoEstandar
	  * 
	  * Get the <i>costo_estandar</i> property for this object. Donde <i>costo_estandar</i> es Costo estandar del paquete
	  * @return float
	  */
	final public function getCostoEstandar()
	{
		return $this->costo_estandar;
	}

	/**
	  * setCostoEstandar( $costo_estandar )
	  * 
	  * Set the <i>costo_estandar</i> property for this object. Donde <i>costo_estandar</i> es Costo estandar del paquete.
	  * Una validacion basica se hara aqui para comprobar que <i>costo_estandar</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setCostoEstandar( $costo_estandar )
	{
		$this->costo_estandar = $costo_estandar;
	}

	/**
	  * getPrecio
	  * 
	  * Get the <i>precio</i> property for this object. Donde <i>precio</i> es Precio dijo del paquete
	  * @return float
	  */
	final public function getPrecio()
	{
		return $this->precio;
	}

	/**
	  * setPrecio( $precio )
	  * 
	  * Set the <i>precio</i> property for this object. Donde <i>precio</i> es Precio dijo del paquete.
	  * Una validacion basica se hara aqui para comprobar que <i>precio</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setPrecio( $precio )
	{
		$this->precio = $precio;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Si el paquete esta activo o no
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Si el paquete esta activo o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

}
