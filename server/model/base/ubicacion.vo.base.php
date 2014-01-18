<?php
/** Value Object file for table ubicacion.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Ubicacion extends VO
{
	/**
	  * Constructor de Ubicacion
	  * 
	  * Para construir un objeto de tipo Ubicacion debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Ubicacion
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_ubicacion']) ){
				$this->id_ubicacion = $data['id_ubicacion'];
			}
			if( isset($data['pasillo']) ){
				$this->pasillo = $data['pasillo'];
			}
			if( isset($data['estante']) ){
				$this->estante = $data['estante'];
			}
			if( isset($data['fila']) ){
				$this->fila = $data['fila'];
			}
			if( isset($data['caja']) ){
				$this->caja = $data['caja'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Ubicacion en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_ubicacion" => $this->id_ubicacion,
			"pasillo" => $this->pasillo,
			"estante" => $this->estante,
			"fila" => $this->fila,
			"caja" => $this->caja
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_ubicacion
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_ubicacion;

	/**
	  * pasillo
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $pasillo;

	/**
	  * estante
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $estante;

	/**
	  * fila
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $fila;

	/**
	  * caja
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var varchar(128)
	  */
	public $caja;

	/**
	  * getIdUbicacion
	  * 
	  * Get the <i>id_ubicacion</i> property for this object. Donde <i>id_ubicacion</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdUbicacion()
	{
		return $this->id_ubicacion;
	}

	/**
	  * setIdUbicacion( $id_ubicacion )
	  * 
	  * Set the <i>id_ubicacion</i> property for this object. Donde <i>id_ubicacion</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_ubicacion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdUbicacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUbicacion( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUbicacion( $id_ubicacion )
	{
		$this->id_ubicacion = $id_ubicacion;
	}

	/**
	  * getPasillo
	  * 
	  * Get the <i>pasillo</i> property for this object. Donde <i>pasillo</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getPasillo()
	{
		return $this->pasillo;
	}

	/**
	  * setPasillo( $pasillo )
	  * 
	  * Set the <i>pasillo</i> property for this object. Donde <i>pasillo</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>pasillo</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setPasillo( $pasillo )
	{
		$this->pasillo = $pasillo;
	}

	/**
	  * getEstante
	  * 
	  * Get the <i>estante</i> property for this object. Donde <i>estante</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getEstante()
	{
		return $this->estante;
	}

	/**
	  * setEstante( $estante )
	  * 
	  * Set the <i>estante</i> property for this object. Donde <i>estante</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>estante</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setEstante( $estante )
	{
		$this->estante = $estante;
	}

	/**
	  * getFila
	  * 
	  * Get the <i>fila</i> property for this object. Donde <i>fila</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getFila()
	{
		return $this->fila;
	}

	/**
	  * setFila( $fila )
	  * 
	  * Set the <i>fila</i> property for this object. Donde <i>fila</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fila</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setFila( $fila )
	{
		$this->fila = $fila;
	}

	/**
	  * getCaja
	  * 
	  * Get the <i>caja</i> property for this object. Donde <i>caja</i> es  [Campo no documentado]
	  * @return varchar(128)
	  */
	final public function getCaja()
	{
		return $this->caja;
	}

	/**
	  * setCaja( $caja )
	  * 
	  * Set the <i>caja</i> property for this object. Donde <i>caja</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>caja</i> es de tipo <i>varchar(128)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(128)
	  */
	final public function setCaja( $caja )
	{
		$this->caja = $caja;
	}

}
