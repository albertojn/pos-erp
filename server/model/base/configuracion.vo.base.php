<?php
/** Value Object file for table configuracion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Configuracion extends VO
{
	/**
	  * Constructor de Configuracion
	  * 
	  * Para construir un objeto de tipo Configuracion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Configuracion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_configuracion']) ){
				$this->id_configuracion = $data['id_configuracion'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['valor']) ){
				$this->valor = $data['valor'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Configuracion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_configuracion" => $this->id_configuracion,
			"descripcion" => $this->descripcion,
			"valor" => $this->valor,
			"id_usuario" => $this->id_usuario,
			"fecha" => $this->fecha
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_configuracion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_configuracion;

	/**
	  * descripcion
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $descripcion;

	/**
	  * valor
	  * 
	  * Cadena en formato de JSON que describe una configuracion<br>
	  * @access public
	  * @var varchar(2048)
	  */
	public $valor;

	/**
	  * id_usuario
	  * 
	  * id_usuario que realizo la ultima modificaciÃ³n <br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * fecha
	  * 
	  * fecha de la ultima modificaciÃ³n, descrita en formato UNIX <br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * getIdConfiguracion
	  * 
	  * Get the <i>id_configuracion</i> property for this object. Donde <i>id_configuracion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdConfiguracion()
	{
		return $this->id_configuracion;
	}

	/**
	  * setIdConfiguracion( $id_configuracion )
	  * 
	  * Set the <i>id_configuracion</i> property for this object. Donde <i>id_configuracion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_configuracion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdConfiguracion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdConfiguracion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdConfiguracion( $id_configuracion )
	{
		$this->id_configuracion = $id_configuracion;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getValor
	  * 
	  * Get the <i>valor</i> property for this object. Donde <i>valor</i> es Cadena en formato de JSON que describe una configuracion
	  * @return varchar(2048)
	  */
	final public function getValor()
	{
		return $this->valor;
	}

	/**
	  * setValor( $valor )
	  * 
	  * Set the <i>valor</i> property for this object. Donde <i>valor</i> es Cadena en formato de JSON que describe una configuracion.
	  * Una validacion basica se hara aqui para comprobar que <i>valor</i> es de tipo <i>varchar(2048)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(2048)
	  */
	final public function setValor( $valor )
	{
		$this->valor = $valor;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es id_usuario que realizo la ultima modificaciÃ³n 
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es id_usuario que realizo la ultima modificaciÃ³n .
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
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es fecha de la ultima modificaciÃ³n, descrita en formato UNIX 
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es fecha de la ultima modificaciÃ³n, descrita en formato UNIX .
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

}
