<?php
/** Value Object file for table clasificacion_cliente.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Andres
  * @access public
  * @package docs
  * 
  */

class ClasificacionCliente extends VO
{
	/**
	  * Constructor de ClasificacionCliente
	  * 
	  * Para construir un objeto de tipo ClasificacionCliente debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ClasificacionCliente
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_clasificacion_cliente']) ){
				$this->id_clasificacion_cliente = $data['id_clasificacion_cliente'];
			}
			if( isset($data['clave_interna']) ){
				$this->clave_interna = $data['clave_interna'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['margen_utilidad']) ){
				$this->margen_utilidad = $data['margen_utilidad'];
			}
			if( isset($data['descuento']) ){
				$this->descuento = $data['descuento'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ClasificacionCliente en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_clasificacion_cliente" => $this->id_clasificacion_cliente,
			"clave_interna" => $this->clave_interna,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"margen_utilidad" => $this->margen_utilidad,
			"descuento" => $this->descuento
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_clasificacion_cliente
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_cliente;

	/**
	  * clave_interna
	  * 
	  * Clave interna del tipo de cliente<br>
	  * @access public
	  * @var varchar(20)
	  */
	public $clave_interna;

	/**
	  * nombre
	  * 
	  * un nombre corto para esta clasificacion<br>
	  * @access public
	  * @var varchar(16)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion larga de la clasificacion del cliente<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * margen_utilidad
	  * 
	  * Margen de utilidad que se le obtendra a los productos al venderle a este tipo de cliente<br>
	  * @access public
	  * @var float
	  */
	public $margen_utilidad;

	/**
	  * descuento
	  * 
	  * Porcentaje de descuento que se le dara a este tipo de cliente<br>
	  * @access public
	  * @var float
	  */
	public $descuento;

	/**
	  * getIdClasificacionCliente
	  * 
	  * Get the <i>id_clasificacion_cliente</i> property for this object. Donde <i>id_clasificacion_cliente</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdClasificacionCliente()
	{
		return $this->id_clasificacion_cliente;
	}

	/**
	  * setIdClasificacionCliente( $id_clasificacion_cliente )
	  * 
	  * Set the <i>id_clasificacion_cliente</i> property for this object. Donde <i>id_clasificacion_cliente</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_cliente</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdClasificacionCliente( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionCliente( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionCliente( $id_clasificacion_cliente )
	{
		$this->id_clasificacion_cliente = $id_clasificacion_cliente;
	}

	/**
	  * getClaveInterna
	  * 
	  * Get the <i>clave_interna</i> property for this object. Donde <i>clave_interna</i> es Clave interna del tipo de cliente
	  * @return varchar(20)
	  */
	final public function getClaveInterna()
	{
		return $this->clave_interna;
	}

	/**
	  * setClaveInterna( $clave_interna )
	  * 
	  * Set the <i>clave_interna</i> property for this object. Donde <i>clave_interna</i> es Clave interna del tipo de cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>clave_interna</i> es de tipo <i>varchar(20)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(20)
	  */
	final public function setClaveInterna( $clave_interna )
	{
		$this->clave_interna = $clave_interna;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es un nombre corto para esta clasificacion
	  * @return varchar(16)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es un nombre corto para esta clasificacion.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(16)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(16)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del cliente
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getMargenUtilidad
	  * 
	  * Get the <i>margen_utilidad</i> property for this object. Donde <i>margen_utilidad</i> es Margen de utilidad que se le obtendra a los productos al venderle a este tipo de cliente
	  * @return float
	  */
	final public function getMargenUtilidad()
	{
		return $this->margen_utilidad;
	}

	/**
	  * setMargenUtilidad( $margen_utilidad )
	  * 
	  * Set the <i>margen_utilidad</i> property for this object. Donde <i>margen_utilidad</i> es Margen de utilidad que se le obtendra a los productos al venderle a este tipo de cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>margen_utilidad</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setMargenUtilidad( $margen_utilidad )
	{
		$this->margen_utilidad = $margen_utilidad;
	}

	/**
	  * getDescuento
	  * 
	  * Get the <i>descuento</i> property for this object. Donde <i>descuento</i> es Porcentaje de descuento que se le dara a este tipo de cliente
	  * @return float
	  */
	final public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	  * setDescuento( $descuento )
	  * 
	  * Set the <i>descuento</i> property for this object. Donde <i>descuento</i> es Porcentaje de descuento que se le dara a este tipo de cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>descuento</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setDescuento( $descuento )
	{
		$this->descuento = $descuento;
	}

}
