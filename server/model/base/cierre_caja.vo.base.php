<?php
/** Value Object file for table cierre_caja.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class CierreCaja extends VO
{
	/**
	  * Constructor de CierreCaja
	  * 
	  * Para construir un objeto de tipo CierreCaja debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return CierreCaja
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_cierre_caja']) ){
				$this->id_cierre_caja = $data['id_cierre_caja'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['id_cajero']) ){
				$this->id_cajero = $data['id_cajero'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['saldo_real']) ){
				$this->saldo_real = $data['saldo_real'];
			}
			if( isset($data['saldo_esperado']) ){
				$this->saldo_esperado = $data['saldo_esperado'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto CierreCaja en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_cierre_caja" => $this->id_cierre_caja,
			"id_caja" => $this->id_caja,
			"id_cajero" => $this->id_cajero,
			"fecha" => $this->fecha,
			"saldo_real" => $this->saldo_real,
			"saldo_esperado" => $this->saldo_esperado
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_cierre_caja
	  * 
	  * Id del cierre de caja<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cierre_caja;

	/**
	  * id_caja
	  * 
	  * Id de la caja que se cierra<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * id_cajero
	  * 
	  * Id del usuario que realiza las funciones de cajero al momento de cerrar la caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cajero;

	/**
	  * fecha
	  * 
	  * fecha en que se realiza la operacion<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * saldo_real
	  * 
	  * Saldo de la caja<br>
	  * @access public
	  * @var float
	  */
	public $saldo_real;

	/**
	  * saldo_esperado
	  * 
	  * Saldo que deberÃƒÆ’Ã‚Â­a de haber en la caja despuÃƒÆ’Ã‚Â©s de todos los movimientos del dÃƒÆ’Ã‚Â­a<br>
	  * @access public
	  * @var float
	  */
	public $saldo_esperado;

	/**
	  * getIdCierreCaja
	  * 
	  * Get the <i>id_cierre_caja</i> property for this object. Donde <i>id_cierre_caja</i> es Id del cierre de caja
	  * @return int(11)
	  */
	final public function getIdCierreCaja()
	{
		return $this->id_cierre_caja;
	}

	/**
	  * setIdCierreCaja( $id_cierre_caja )
	  * 
	  * Set the <i>id_cierre_caja</i> property for this object. Donde <i>id_cierre_caja</i> es Id del cierre de caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cierre_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCierreCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCierreCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCierreCaja( $id_cierre_caja )
	{
		$this->id_cierre_caja = $id_cierre_caja;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja que se cierra
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja que se cierra.
	  * Una validacion basica se hara aqui para comprobar que <i>id_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCaja( $id_caja )
	{
		$this->id_caja = $id_caja;
	}

	/**
	  * getIdCajero
	  * 
	  * Get the <i>id_cajero</i> property for this object. Donde <i>id_cajero</i> es Id del usuario que realiza las funciones de cajero al momento de cerrar la caja
	  * @return int(11)
	  */
	final public function getIdCajero()
	{
		return $this->id_cajero;
	}

	/**
	  * setIdCajero( $id_cajero )
	  * 
	  * Set the <i>id_cajero</i> property for this object. Donde <i>id_cajero</i> es Id del usuario que realiza las funciones de cajero al momento de cerrar la caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cajero</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCajero( $id_cajero )
	{
		$this->id_cajero = $id_cajero;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es fecha en que se realiza la operacion
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es fecha en que se realiza la operacion.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getSaldoReal
	  * 
	  * Get the <i>saldo_real</i> property for this object. Donde <i>saldo_real</i> es Saldo de la caja
	  * @return float
	  */
	final public function getSaldoReal()
	{
		return $this->saldo_real;
	}

	/**
	  * setSaldoReal( $saldo_real )
	  * 
	  * Set the <i>saldo_real</i> property for this object. Donde <i>saldo_real</i> es Saldo de la caja.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo_real</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldoReal( $saldo_real )
	{
		$this->saldo_real = $saldo_real;
	}

	/**
	  * getSaldoEsperado
	  * 
	  * Get the <i>saldo_esperado</i> property for this object. Donde <i>saldo_esperado</i> es Saldo que deberÃƒÆ’Ã‚Â­a de haber en la caja despuÃƒÆ’Ã‚Â©s de todos los movimientos del dÃƒÆ’Ã‚Â­a
	  * @return float
	  */
	final public function getSaldoEsperado()
	{
		return $this->saldo_esperado;
	}

	/**
	  * setSaldoEsperado( $saldo_esperado )
	  * 
	  * Set the <i>saldo_esperado</i> property for this object. Donde <i>saldo_esperado</i> es Saldo que deberÃƒÆ’Ã‚Â­a de haber en la caja despuÃƒÆ’Ã‚Â©s de todos los movimientos del dÃƒÆ’Ã‚Â­a.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo_esperado</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldoEsperado( $saldo_esperado )
	{
		$this->saldo_esperado = $saldo_esperado;
	}

}
