<?php
/** Value Object file for table corte_de_caja.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class CorteDeCaja extends VO
{
	/**
	  * Constructor de CorteDeCaja
	  * 
	  * Para construir un objeto de tipo CorteDeCaja debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return CorteDeCaja
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_corte_de_caja']) ){
				$this->id_corte_de_caja = $data['id_corte_de_caja'];
			}
			if( isset($data['id_caja']) ){
				$this->id_caja = $data['id_caja'];
			}
			if( isset($data['id_cajero']) ){
				$this->id_cajero = $data['id_cajero'];
			}
			if( isset($data['id_cajero_nuevo']) ){
				$this->id_cajero_nuevo = $data['id_cajero_nuevo'];
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
			if( isset($data['saldo_final']) ){
				$this->saldo_final = $data['saldo_final'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto CorteDeCaja en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_corte_de_caja" => $this->id_corte_de_caja,
			"id_caja" => $this->id_caja,
			"id_cajero" => $this->id_cajero,
			"id_cajero_nuevo" => $this->id_cajero_nuevo,
			"fecha" => $this->fecha,
			"saldo_real" => $this->saldo_real,
			"saldo_esperado" => $this->saldo_esperado,
			"saldo_final" => $this->saldo_final
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_corte_de_caja
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_corte_de_caja;

	/**
	  * id_caja
	  * 
	  * Id de la caja a la que se le realiza el corte<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_caja;

	/**
	  * id_cajero
	  * 
	  * Id del usuario que funje como cajero<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cajero;

	/**
	  * id_cajero_nuevo
	  * 
	  * Id del usuario que entrara como nuevo cajero si es que hubo un cambio de turno con el corte de caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cajero_nuevo;

	/**
	  * fecha
	  * 
	  * fecha en la que se realiza el corte de caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * saldo_real
	  * 
	  * Saldo actual de la caja<br>
	  * @access public
	  * @var float
	  */
	public $saldo_real;

	/**
	  * saldo_esperado
	  * 
	  * Saldo que se espera de acuerdo a las ventas realizadas apartir del ÃƒÆ’Ã‚Âºltimo corte de caja o a la apertura de la misma<br>
	  * @access public
	  * @var float
	  */
	public $saldo_esperado;

	/**
	  * saldo_final
	  * 
	  * Saldo que se deja en caja despuÃƒÆ’Ã‚Â©s de realizar el corte<br>
	  * @access public
	  * @var float
	  */
	public $saldo_final;

	/**
	  * getIdCorteDeCaja
	  * 
	  * Get the <i>id_corte_de_caja</i> property for this object. Donde <i>id_corte_de_caja</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCorteDeCaja()
	{
		return $this->id_corte_de_caja;
	}

	/**
	  * setIdCorteDeCaja( $id_corte_de_caja )
	  * 
	  * Set the <i>id_corte_de_caja</i> property for this object. Donde <i>id_corte_de_caja</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_corte_de_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdCorteDeCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCorteDeCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCorteDeCaja( $id_corte_de_caja )
	{
		$this->id_corte_de_caja = $id_corte_de_caja;
	}

	/**
	  * getIdCaja
	  * 
	  * Get the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja a la que se le realiza el corte
	  * @return int(11)
	  */
	final public function getIdCaja()
	{
		return $this->id_caja;
	}

	/**
	  * setIdCaja( $id_caja )
	  * 
	  * Set the <i>id_caja</i> property for this object. Donde <i>id_caja</i> es Id de la caja a la que se le realiza el corte.
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
	  * Get the <i>id_cajero</i> property for this object. Donde <i>id_cajero</i> es Id del usuario que funje como cajero
	  * @return int(11)
	  */
	final public function getIdCajero()
	{
		return $this->id_cajero;
	}

	/**
	  * setIdCajero( $id_cajero )
	  * 
	  * Set the <i>id_cajero</i> property for this object. Donde <i>id_cajero</i> es Id del usuario que funje como cajero.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cajero</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCajero( $id_cajero )
	{
		$this->id_cajero = $id_cajero;
	}

	/**
	  * getIdCajeroNuevo
	  * 
	  * Get the <i>id_cajero_nuevo</i> property for this object. Donde <i>id_cajero_nuevo</i> es Id del usuario que entrara como nuevo cajero si es que hubo un cambio de turno con el corte de caja
	  * @return int(11)
	  */
	final public function getIdCajeroNuevo()
	{
		return $this->id_cajero_nuevo;
	}

	/**
	  * setIdCajeroNuevo( $id_cajero_nuevo )
	  * 
	  * Set the <i>id_cajero_nuevo</i> property for this object. Donde <i>id_cajero_nuevo</i> es Id del usuario que entrara como nuevo cajero si es que hubo un cambio de turno con el corte de caja.
	  * Una validacion basica se hara aqui para comprobar que <i>id_cajero_nuevo</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCajeroNuevo( $id_cajero_nuevo )
	{
		$this->id_cajero_nuevo = $id_cajero_nuevo;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es fecha en la que se realiza el corte de caja
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es fecha en la que se realiza el corte de caja.
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
	  * Get the <i>saldo_real</i> property for this object. Donde <i>saldo_real</i> es Saldo actual de la caja
	  * @return float
	  */
	final public function getSaldoReal()
	{
		return $this->saldo_real;
	}

	/**
	  * setSaldoReal( $saldo_real )
	  * 
	  * Set the <i>saldo_real</i> property for this object. Donde <i>saldo_real</i> es Saldo actual de la caja.
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
	  * Get the <i>saldo_esperado</i> property for this object. Donde <i>saldo_esperado</i> es Saldo que se espera de acuerdo a las ventas realizadas apartir del ÃƒÆ’Ã‚Âºltimo corte de caja o a la apertura de la misma
	  * @return float
	  */
	final public function getSaldoEsperado()
	{
		return $this->saldo_esperado;
	}

	/**
	  * setSaldoEsperado( $saldo_esperado )
	  * 
	  * Set the <i>saldo_esperado</i> property for this object. Donde <i>saldo_esperado</i> es Saldo que se espera de acuerdo a las ventas realizadas apartir del ÃƒÆ’Ã‚Âºltimo corte de caja o a la apertura de la misma.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo_esperado</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldoEsperado( $saldo_esperado )
	{
		$this->saldo_esperado = $saldo_esperado;
	}

	/**
	  * getSaldoFinal
	  * 
	  * Get the <i>saldo_final</i> property for this object. Donde <i>saldo_final</i> es Saldo que se deja en caja despuÃƒÆ’Ã‚Â©s de realizar el corte
	  * @return float
	  */
	final public function getSaldoFinal()
	{
		return $this->saldo_final;
	}

	/**
	  * setSaldoFinal( $saldo_final )
	  * 
	  * Set the <i>saldo_final</i> property for this object. Donde <i>saldo_final</i> es Saldo que se deja en caja despuÃƒÆ’Ã‚Â©s de realizar el corte.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo_final</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldoFinal( $saldo_final )
	{
		$this->saldo_final = $saldo_final;
	}

}
