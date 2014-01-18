<?php
/** Value Object file for table corte_de_sucursal.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class CorteDeSucursal extends VO
{
	/**
	  * Constructor de CorteDeSucursal
	  * 
	  * Para construir un objeto de tipo CorteDeSucursal debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return CorteDeSucursal
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_corte_sucursal']) ){
				$this->id_corte_sucursal = $data['id_corte_sucursal'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['inicio']) ){
				$this->inicio = $data['inicio'];
			}
			if( isset($data['fin']) ){
				$this->fin = $data['fin'];
			}
			if( isset($data['fecha_corte']) ){
				$this->fecha_corte = $data['fecha_corte'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto CorteDeSucursal en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_corte_sucursal" => $this->id_corte_sucursal,
			"id_sucursal" => $this->id_sucursal,
			"id_usuario" => $this->id_usuario,
			"inicio" => $this->inicio,
			"fin" => $this->fin,
			"fecha_corte" => $this->fecha_corte
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_corte_sucursal
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_corte_sucursal;

	/**
	  * id_sucursal
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * id_usuario
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * inicio
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $inicio;

	/**
	  * fin
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fin;

	/**
	  * fecha_corte
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_corte;

	/**
	  * getIdCorteSucursal
	  * 
	  * Get the <i>id_corte_sucursal</i> property for this object. Donde <i>id_corte_sucursal</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCorteSucursal()
	{
		return $this->id_corte_sucursal;
	}

	/**
	  * setIdCorteSucursal( $id_corte_sucursal )
	  * 
	  * Set the <i>id_corte_sucursal</i> property for this object. Donde <i>id_corte_sucursal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_corte_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCorteSucursal( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCorteSucursal( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCorteSucursal( $id_corte_sucursal )
	{
		$this->id_corte_sucursal = $id_corte_sucursal;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getInicio
	  * 
	  * Get the <i>inicio</i> property for this object. Donde <i>inicio</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getInicio()
	{
		return $this->inicio;
	}

	/**
	  * setInicio( $inicio )
	  * 
	  * Set the <i>inicio</i> property for this object. Donde <i>inicio</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>inicio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setInicio( $inicio )
	{
		$this->inicio = $inicio;
	}

	/**
	  * getFin
	  * 
	  * Get the <i>fin</i> property for this object. Donde <i>fin</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFin()
	{
		return $this->fin;
	}

	/**
	  * setFin( $fin )
	  * 
	  * Set the <i>fin</i> property for this object. Donde <i>fin</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fin</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFin( $fin )
	{
		$this->fin = $fin;
	}

	/**
	  * getFechaCorte
	  * 
	  * Get the <i>fecha_corte</i> property for this object. Donde <i>fecha_corte</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getFechaCorte()
	{
		return $this->fecha_corte;
	}

	/**
	  * setFechaCorte( $fecha_corte )
	  * 
	  * Set the <i>fecha_corte</i> property for this object. Donde <i>fecha_corte</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_corte</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaCorte( $fecha_corte )
	{
		$this->fecha_corte = $fecha_corte;
	}

}
