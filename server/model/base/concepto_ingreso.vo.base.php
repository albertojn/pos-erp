<?php
/** Value Object file for table concepto_ingreso.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class ConceptoIngreso extends VO
{
	/**
	  * Constructor de ConceptoIngreso
	  * 
	  * Para construir un objeto de tipo ConceptoIngreso debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return ConceptoIngreso
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_concepto_ingreso']) ){
				$this->id_concepto_ingreso = $data['id_concepto_ingreso'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['descripcion']) ){
				$this->descripcion = $data['descripcion'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
			if( isset($data['id_cuenta_contable']) ){
				$this->id_cuenta_contable = $data['id_cuenta_contable'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto ConceptoIngreso en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_concepto_ingreso" => $this->id_concepto_ingreso,
			"nombre" => $this->nombre,
			"descripcion" => $this->descripcion,
			"activo" => $this->activo,
			"id_cuenta_contable" => $this->id_cuenta_contable
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_concepto_ingreso
	  * 
	  * Id del concepto de ingreso<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_concepto_ingreso;

	/**
	  * nombre
	  * 
	  * nombre del concepto<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $nombre;

	/**
	  * descripcion
	  * 
	  * Descripcion del concepto<br>
	  * @access public
	  * @var varchar(255)
	  */
	public $descripcion;

	/**
	  * activo
	  * 
	  * Si este concepto de ingreso esta activo<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * id_cuenta_contable
	  * 
	  * El id de la cuenta contable a la que apunta este concepto<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cuenta_contable;

	/**
	  * getIdConceptoIngreso
	  * 
	  * Get the <i>id_concepto_ingreso</i> property for this object. Donde <i>id_concepto_ingreso</i> es Id del concepto de ingreso
	  * @return int(11)
	  */
	final public function getIdConceptoIngreso()
	{
		return $this->id_concepto_ingreso;
	}

	/**
	  * setIdConceptoIngreso( $id_concepto_ingreso )
	  * 
	  * Set the <i>id_concepto_ingreso</i> property for this object. Donde <i>id_concepto_ingreso</i> es Id del concepto de ingreso.
	  * Una validacion basica se hara aqui para comprobar que <i>id_concepto_ingreso</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdConceptoIngreso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdConceptoIngreso( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdConceptoIngreso( $id_concepto_ingreso )
	{
		$this->id_concepto_ingreso = $id_concepto_ingreso;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es nombre del concepto
	  * @return varchar(50)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es nombre del concepto.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getDescripcion
	  * 
	  * Get the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion del concepto
	  * @return varchar(255)
	  */
	final public function getDescripcion()
	{
		return $this->descripcion;
	}

	/**
	  * setDescripcion( $descripcion )
	  * 
	  * Set the <i>descripcion</i> property for this object. Donde <i>descripcion</i> es Descripcion del concepto.
	  * Una validacion basica se hara aqui para comprobar que <i>descripcion</i> es de tipo <i>varchar(255)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(255)
	  */
	final public function setDescripcion( $descripcion )
	{
		$this->descripcion = $descripcion;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es Si este concepto de ingreso esta activo
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es Si este concepto de ingreso esta activo.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

	/**
	  * getIdCuentaContable
	  * 
	  * Get the <i>id_cuenta_contable</i> property for this object. Donde <i>id_cuenta_contable</i> es El id de la cuenta contable a la que apunta este concepto
	  * @return int(11)
	  */
	final public function getIdCuentaContable()
	{
		return $this->id_cuenta_contable;
	}

	/**
	  * setIdCuentaContable( $id_cuenta_contable )
	  * 
	  * Set the <i>id_cuenta_contable</i> property for this object. Donde <i>id_cuenta_contable</i> es El id de la cuenta contable a la que apunta este concepto.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cuenta_contable</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCuentaContable( $id_cuenta_contable )
	{
		$this->id_cuenta_contable = $id_cuenta_contable;
	}

}
