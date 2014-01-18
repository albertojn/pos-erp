<?php
/** Value Object file for table billete_cierre_caja.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class BilleteCierreCaja extends VO
{
	/**
	  * Constructor de BilleteCierreCaja
	  * 
	  * Para construir un objeto de tipo BilleteCierreCaja debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return BilleteCierreCaja
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_billete']) ){
				$this->id_billete = $data['id_billete'];
			}
			if( isset($data['id_cierre_caja']) ){
				$this->id_cierre_caja = $data['id_cierre_caja'];
			}
			if( isset($data['cantidad_encontrada']) ){
				$this->cantidad_encontrada = $data['cantidad_encontrada'];
			}
			if( isset($data['cantidad_sobrante']) ){
				$this->cantidad_sobrante = $data['cantidad_sobrante'];
			}
			if( isset($data['cantidad_faltante']) ){
				$this->cantidad_faltante = $data['cantidad_faltante'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto BilleteCierreCaja en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_billete" => $this->id_billete,
			"id_cierre_caja" => $this->id_cierre_caja,
			"cantidad_encontrada" => $this->cantidad_encontrada,
			"cantidad_sobrante" => $this->cantidad_sobrante,
			"cantidad_faltante" => $this->cantidad_faltante
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_billete
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_billete;

	/**
	  * id_cierre_caja
	  * 
	  *  [Campo no documentado]<br>
	  * <b>Llave Primaria</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_cierre_caja;

	/**
	  * cantidad_encontrada
	  * 
	  * Cantidad de billetes encontrados en el cierre de caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $cantidad_encontrada;

	/**
	  * cantidad_sobrante
	  * 
	  * Cantidad de billetes saobrante en el cierre de caja<br>
	  * @access public
	  * @var int(11)
	  */
	public $cantidad_sobrante;

	/**
	  * cantidad_faltante
	  * 
	  * Cantidad de billetes faltante en el cierre de caja<br>
	  * @access public
	  * @var int(1)
	  */
	public $cantidad_faltante;

	/**
	  * getIdBillete
	  * 
	  * Get the <i>id_billete</i> property for this object. Donde <i>id_billete</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdBillete()
	{
		return $this->id_billete;
	}

	/**
	  * setIdBillete( $id_billete )
	  * 
	  * Set the <i>id_billete</i> property for this object. Donde <i>id_billete</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_billete</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdBillete( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdBillete( $id_billete )
	{
		$this->id_billete = $id_billete;
	}

	/**
	  * getIdCierreCaja
	  * 
	  * Get the <i>id_cierre_caja</i> property for this object. Donde <i>id_cierre_caja</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdCierreCaja()
	{
		return $this->id_cierre_caja;
	}

	/**
	  * setIdCierreCaja( $id_cierre_caja )
	  * 
	  * Set the <i>id_cierre_caja</i> property for this object. Donde <i>id_cierre_caja</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_cierre_caja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdCierreCaja( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdCierreCaja( $id_cierre_caja )
	{
		$this->id_cierre_caja = $id_cierre_caja;
	}

	/**
	  * getCantidadEncontrada
	  * 
	  * Get the <i>cantidad_encontrada</i> property for this object. Donde <i>cantidad_encontrada</i> es Cantidad de billetes encontrados en el cierre de caja
	  * @return int(11)
	  */
	final public function getCantidadEncontrada()
	{
		return $this->cantidad_encontrada;
	}

	/**
	  * setCantidadEncontrada( $cantidad_encontrada )
	  * 
	  * Set the <i>cantidad_encontrada</i> property for this object. Donde <i>cantidad_encontrada</i> es Cantidad de billetes encontrados en el cierre de caja.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_encontrada</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setCantidadEncontrada( $cantidad_encontrada )
	{
		$this->cantidad_encontrada = $cantidad_encontrada;
	}

	/**
	  * getCantidadSobrante
	  * 
	  * Get the <i>cantidad_sobrante</i> property for this object. Donde <i>cantidad_sobrante</i> es Cantidad de billetes saobrante en el cierre de caja
	  * @return int(11)
	  */
	final public function getCantidadSobrante()
	{
		return $this->cantidad_sobrante;
	}

	/**
	  * setCantidadSobrante( $cantidad_sobrante )
	  * 
	  * Set the <i>cantidad_sobrante</i> property for this object. Donde <i>cantidad_sobrante</i> es Cantidad de billetes saobrante en el cierre de caja.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_sobrante</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setCantidadSobrante( $cantidad_sobrante )
	{
		$this->cantidad_sobrante = $cantidad_sobrante;
	}

	/**
	  * getCantidadFaltante
	  * 
	  * Get the <i>cantidad_faltante</i> property for this object. Donde <i>cantidad_faltante</i> es Cantidad de billetes faltante en el cierre de caja
	  * @return int(1)
	  */
	final public function getCantidadFaltante()
	{
		return $this->cantidad_faltante;
	}

	/**
	  * setCantidadFaltante( $cantidad_faltante )
	  * 
	  * Set the <i>cantidad_faltante</i> property for this object. Donde <i>cantidad_faltante</i> es Cantidad de billetes faltante en el cierre de caja.
	  * Una validacion basica se hara aqui para comprobar que <i>cantidad_faltante</i> es de tipo <i>int(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(1)
	  */
	final public function setCantidadFaltante( $cantidad_faltante )
	{
		$this->cantidad_faltante = $cantidad_faltante;
	}

}
