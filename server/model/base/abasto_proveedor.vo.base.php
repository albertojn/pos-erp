<?php
/** Value Object file for table abasto_proveedor.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class AbastoProveedor extends VO
{
	/**
	  * Constructor de AbastoProveedor
	  * 
	  * Para construir un objeto de tipo AbastoProveedor debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return AbastoProveedor
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_abasto_proveedor']) ){
				$this->id_abasto_proveedor = $data['id_abasto_proveedor'];
			}
			if( isset($data['id_proveedor']) ){
				$this->id_proveedor = $data['id_proveedor'];
			}
			if( isset($data['id_almacen']) ){
				$this->id_almacen = $data['id_almacen'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['motivo']) ){
				$this->motivo = $data['motivo'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto AbastoProveedor en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_abasto_proveedor" => $this->id_abasto_proveedor,
			"id_proveedor" => $this->id_proveedor,
			"id_almacen" => $this->id_almacen,
			"id_usuario" => $this->id_usuario,
			"fecha" => $this->fecha,
			"motivo" => $this->motivo
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_abasto_proveedor
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_abasto_proveedor;

	/**
	  * id_proveedor
	  * 
	  * Id del proveedor que abastese, se usara -1 cuando la entrada sea por inventario fisico<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_proveedor;

	/**
	  * id_almacen
	  * 
	  * Id del almacen abastesido<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_almacen;

	/**
	  * id_usuario
	  * 
	  * Id del usuario que registra<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * fecha
	  * 
	  * Fecha del movimiento<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * motivo
	  * 
	  * Motivo de la entrada del producto<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $motivo;

	/**
	  * getIdAbastoProveedor
	  * 
	  * Get the <i>id_abasto_proveedor</i> property for this object. Donde <i>id_abasto_proveedor</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdAbastoProveedor()
	{
		return $this->id_abasto_proveedor;
	}

	/**
	  * setIdAbastoProveedor( $id_abasto_proveedor )
	  * 
	  * Set the <i>id_abasto_proveedor</i> property for this object. Donde <i>id_abasto_proveedor</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_abasto_proveedor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdAbastoProveedor( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdAbastoProveedor( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdAbastoProveedor( $id_abasto_proveedor )
	{
		$this->id_abasto_proveedor = $id_abasto_proveedor;
	}

	/**
	  * getIdProveedor
	  * 
	  * Get the <i>id_proveedor</i> property for this object. Donde <i>id_proveedor</i> es Id del proveedor que abastese, se usara -1 cuando la entrada sea por inventario fisico
	  * @return int(11)
	  */
	final public function getIdProveedor()
	{
		return $this->id_proveedor;
	}

	/**
	  * setIdProveedor( $id_proveedor )
	  * 
	  * Set the <i>id_proveedor</i> property for this object. Donde <i>id_proveedor</i> es Id del proveedor que abastese, se usara -1 cuando la entrada sea por inventario fisico.
	  * Una validacion basica se hara aqui para comprobar que <i>id_proveedor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdProveedor( $id_proveedor )
	{
		$this->id_proveedor = $id_proveedor;
	}

	/**
	  * getIdAlmacen
	  * 
	  * Get the <i>id_almacen</i> property for this object. Donde <i>id_almacen</i> es Id del almacen abastesido
	  * @return int(11)
	  */
	final public function getIdAlmacen()
	{
		return $this->id_almacen;
	}

	/**
	  * setIdAlmacen( $id_almacen )
	  * 
	  * Set the <i>id_almacen</i> property for this object. Donde <i>id_almacen</i> es Id del almacen abastesido.
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
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que registra
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id del usuario que registra.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha del movimiento
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es Fecha del movimiento.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getMotivo
	  * 
	  * Get the <i>motivo</i> property for this object. Donde <i>motivo</i> es Motivo de la entrada del producto
	  * @return varchar(255)
	  */
	final public function getMotivo()
	{
		return $this->motivo;
	}

	/**
	  * setMotivo( $motivo )
	  * 
	  * Set the <i>motivo</i> property for this object. Donde <i>motivo</i> es Motivo de la entrada del producto.
	  * Una validacion basica se hara aqui para comprobar que <i>motivo</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setMotivo( $motivo )
	{
		$this->motivo = $motivo;
	}

}
