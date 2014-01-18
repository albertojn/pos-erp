<?php
/** Value Object file for table rol.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Rol extends VO
{
	/**
	  * Constructor de Rol
	  * 
	  * Para construir un objeto de tipo Rol debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Rol
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_rol']) ){
				$this->id_rol = $data['id_rol'];
			}
			if( isset($data['id_rol_padre']) ){
				$this->id_rol_padre = $data['id_rol_padre'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['salario']) ){
				$this->salario = $data['salario'];
			}
			if( isset($data['id_tarifa_compra']) ){
				$this->id_tarifa_compra = $data['id_tarifa_compra'];
			}
			if( isset($data['id_tarifa_venta']) ){
				$this->id_tarifa_venta = $data['id_tarifa_venta'];
			}
			if( isset($data['id_perfil']) ){
				$this->id_perfil = $data['id_perfil'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Rol en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_rol" => $this->id_rol,
			"id_rol_padre" => $this->id_rol_padre,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"salario" => $this->salario,
			"id_tarifa_compra" => $this->id_tarifa_compra,
			"id_tarifa_venta" => $this->id_tarifa_venta,
			"id_perfil" => $this->id_perfil
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_rol
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_rol;

	/**
	  * id_rol_padre
	  * 
	  * Id del padre de este rol<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_rol_padre;

	/**
	  * nombre
	  * 
	  * Nombre del rol<br>
	  * @access public
	  * @var varchar(30)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * descripcion larga de este rol<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * salario
	  * 
	  * Si los usuarios con dicho rol contaran con un salario<br>
	  * @access public
	  * @var float
	  */
	public $salario;

	/**
	  * id_tarifa_compra
	  * 
	  * Id de la tarifa de compra por default para los usuarios de este rol<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa_compra;

	/**
	  * id_tarifa_venta
	  * 
	  * Id de la tarifa de venta por default para los usuarios de este rol<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa_venta;

	/**
	  * id_perfil
	  * 
	  * Id del perfil que tiene por default cada usuario de este rol, posteriormente se peude personalizar el perfil de cada usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_perfil;

	/**
	  * getIdRol
	  * 
	  * Get the <i>id_rol</i> property for this object. Donde <i>id_rol</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdRol()
	{
		return $this->id_rol;
	}

	/**
	  * setIdRol( $id_rol )
	  * 
	  * Set the <i>id_rol</i> property for this object. Donde <i>id_rol</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_rol</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdRol( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdRol( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdRol( $id_rol )
	{
		$this->id_rol = $id_rol;
	}

	/**
	  * getIdRolPadre
	  * 
	  * Get the <i>id_rol_padre</i> property for this object. Donde <i>id_rol_padre</i> es Id del padre de este rol
	  * @return int(11)
	  */
	final public function getIdRolPadre()
	{
		return $this->id_rol_padre;
	}

	/**
	  * setIdRolPadre( $id_rol_padre )
	  * 
	  * Set the <i>id_rol_padre</i> property for this object. Donde <i>id_rol_padre</i> es Id del padre de este rol.
	  * Una validacion basica se hara aqui para comprobar que <i>id_rol_padre</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdRolPadre( $id_rol_padre )
	{
		$this->id_rol_padre = $id_rol_padre;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del rol
	  * @return varchar(30)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del rol.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es descripcion larga de este rol
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es descripcion larga de este rol.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getSalario
	  * 
	  * Get the <i>salario</i> property for this object. Donde <i>salario</i> es Si los usuarios con dicho rol contaran con un salario
	  * @return float
	  */
	final public function getSalario()
	{
		return $this->salario;
	}

	/**
	  * setSalario( $salario )
	  * 
	  * Set the <i>salario</i> property for this object. Donde <i>salario</i> es Si los usuarios con dicho rol contaran con un salario.
	  * Una validacion basica se hara aqui para comprobar que <i>salario</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSalario( $salario )
	{
		$this->salario = $salario;
	}

	/**
	  * getIdTarifaCompra
	  * 
	  * Get the <i>id_tarifa_compra</i> property for this object. Donde <i>id_tarifa_compra</i> es Id de la tarifa de compra por default para los usuarios de este rol
	  * @return int(11)
	  */
	final public function getIdTarifaCompra()
	{
		return $this->id_tarifa_compra;
	}

	/**
	  * setIdTarifaCompra( $id_tarifa_compra )
	  * 
	  * Set the <i>id_tarifa_compra</i> property for this object. Donde <i>id_tarifa_compra</i> es Id de la tarifa de compra por default para los usuarios de este rol.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifaCompra( $id_tarifa_compra )
	{
		$this->id_tarifa_compra = $id_tarifa_compra;
	}

	/**
	  * getIdTarifaVenta
	  * 
	  * Get the <i>id_tarifa_venta</i> property for this object. Donde <i>id_tarifa_venta</i> es Id de la tarifa de venta por default para los usuarios de este rol
	  * @return int(11)
	  */
	final public function getIdTarifaVenta()
	{
		return $this->id_tarifa_venta;
	}

	/**
	  * setIdTarifaVenta( $id_tarifa_venta )
	  * 
	  * Set the <i>id_tarifa_venta</i> property for this object. Donde <i>id_tarifa_venta</i> es Id de la tarifa de venta por default para los usuarios de este rol.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifaVenta( $id_tarifa_venta )
	{
		$this->id_tarifa_venta = $id_tarifa_venta;
	}

	/**
	  * getIdPerfil
	  * 
	  * Get the <i>id_perfil</i> property for this object. Donde <i>id_perfil</i> es Id del perfil que tiene por default cada usuario de este rol, posteriormente se peude personalizar el perfil de cada usuario
	  * @return int(11)
	  */
	final public function getIdPerfil()
	{
		return $this->id_perfil;
	}

	/**
	  * setIdPerfil( $id_perfil )
	  * 
	  * Set the <i>id_perfil</i> property for this object. Donde <i>id_perfil</i> es Id del perfil que tiene por default cada usuario de este rol, posteriormente se peude personalizar el perfil de cada usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_perfil</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdPerfil( $id_perfil )
	{
		$this->id_perfil = $id_perfil;
	}

}
