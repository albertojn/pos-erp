<?php
/** Value Object file for table inventario.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Alan Gonzalez <alan@caffeina.mx> 
  * @access public
  * 
  */

class Inventario
{
	/**
	  * Constructor de Inventario
	  * 
	  * Para construir un objeto de tipo Inventario debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Inventario
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			$this->id_producto = $data['id_producto'];
			$this->nombre = $data['nombre'];
			$this->denominacion = $data['denominacion'];
		}
	}

	/**
	  * id_producto
	  * 
	  * id del producto<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access protected
	  * @var int(11)
	  */
	protected $id_producto;

	/**
	  * nombre
	  * 
	  * Descripcion o nombre del producto<br>
	  * @access protected
	  * @var varchar(90)
	  */
	protected $nombre;

	/**
	  * denominacion
	  * 
	  * es lo que se le mostrara a los clientes<br>
	  * @access protected
	  * @var varchar(30)
	  */
	protected $denominacion;

	/**
	  * getIdProducto
	  * 
	  * Get the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es id del producto
	  * @return int(11)
	  */
	final public function getIdProducto()
	{
		return $this->id_producto;
	}

	/**
	  * setIdProducto( $id_producto )
	  * 
	  * Set the <i>id_producto</i> property for this object. Donde <i>id_producto</i> es id del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_producto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdProducto( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdProducto( $id_producto )
	{
		$this->id_producto = $id_producto;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Descripcion o nombre del producto
	  * @return varchar(90)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Descripcion o nombre del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(90)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(90)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDenominacion
	  * 
	  * Get the <i>denominacion</i> property for this object. Donde <i>denominacion</i> es es lo que se le mostrara a los clientes
	  * @return varchar(30)
	  */
	final public function getDenominacion()
	{
		return $this->denominacion;
	}

	/**
	  * setDenominacion( $denominacion )
	  * 
	  * Set the <i>denominacion</i> property for this object. Donde <i>denominacion</i> es es lo que se le mostrara a los clientes.
	  * Una validacion basica se hara aqui para comprobar que <i>denominacion</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setDenominacion( $denominacion )
	{
		$this->denominacion = $denominacion;
	}

}
