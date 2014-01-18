<?php
/** Value Object file for table clasificacion_producto.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ClasificacionProducto extends VO
{
	/**
	  * Constructor de ClasificacionProducto
	  * 
	  * Para construir un objeto de tipo ClasificacionProducto debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ClasificacionProducto
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_clasificacion_producto']) ){
				$this->id_clasificacion_producto = $data['id_clasificacion_producto'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['id_categoria_padre']) ){
				$this->id_categoria_padre = $data['id_categoria_padre'];
			}
			if( isset($data['activa']) ){
				$this->activa = $data['activa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ClasificacionProducto en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_clasificacion_producto" => $this->id_clasificacion_producto,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"id_categoria_padre" => $this->id_categoria_padre,
			"activa" => $this->activa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_clasificacion_producto
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_producto;

	/**
	  * nombre
	  * 
	  * el nombre de esta clasificacion<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion larga de la clasificacion del producto<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * id_categoria_padre
	  * 
	  * numero de meses que tendran los productos de esta clasificacion<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_categoria_padre;

	/**
	  * activa
	  * 
	  * Si esta claificacion esta activa<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activa;

	/**
	  * getIdClasificacionProducto
	  * 
	  * Get the <i>id_clasificacion_producto</i> property for this object. Donde <i>id_clasificacion_producto</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdClasificacionProducto()
	{
		return $this->id_clasificacion_producto;
	}

	/**
	  * setIdClasificacionProducto( $id_clasificacion_producto )
	  * 
	  * Set the <i>id_clasificacion_producto</i> property for this object. Donde <i>id_clasificacion_producto</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdClasificacionProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdClasificacionProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdClasificacionProducto( $id_clasificacion_producto )
	{
		$this->id_clasificacion_producto = $id_clasificacion_producto;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es el nombre de esta clasificacion
	  * @return varchar(64)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es el nombre de esta clasificacion.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del producto
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion larga de la clasificacion del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getIdCategoriaPadre
	  * 
	  * Get the <i>id_categoria_padre</i> property for this object. Donde <i>id_categoria_padre</i> es numero de meses que tendran los productos de esta clasificacion
	  * @return int(11)
	  */
	final public function getIdCategoriaPadre()
	{
		return $this->id_categoria_padre;
	}

	/**
	  * setIdCategoriaPadre( $id_categoria_padre )
	  * 
	  * Set the <i>id_categoria_padre</i> property for this object. Donde <i>id_categoria_padre</i> es numero de meses que tendran los productos de esta clasificacion.
	  * Una validacion basica se hara aqui para comprobar que <i>id_categoria_padre</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCategoriaPadre( $id_categoria_padre )
	{
		$this->id_categoria_padre = $id_categoria_padre;
	}

	/**
	  * getActiva
	  * 
	  * Get the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta claificacion esta activa
	  * @return tinyint(1)
	  */
	final public function getActiva()
	{
		return $this->activa;
	}

	/**
	  * setActiva( $activa )
	  * 
	  * Set the <i>activa</i> property for this object. Donde <i>activa</i> es Si esta claificacion esta activa.
	  * Una validacion basica se hara aqui para comprobar que <i>activa</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActiva( $activa )
	{
		$this->activa = $activa;
	}

}
