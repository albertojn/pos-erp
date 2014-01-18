<?php
/** Value Object file for table historial_tipo_cambio.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class HistorialTipoCambio extends VO
{
	/**
	  * Constructor de HistorialTipoCambio
	  * 
	  * Para construir un objeto de tipo HistorialTipoCambio debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return HistorialTipoCambio
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_historial_tipo_cambio']) ){
				$this->id_historial_tipo_cambio = $data['id_historial_tipo_cambio'];
			}
			if( isset($data['id_moneda_base']) ){
				$this->id_moneda_base = $data['id_moneda_base'];
			}
			if( isset($data['fecha']) ){
				$this->fecha = $data['fecha'];
			}
			if( isset($data['json_equivalencias']) ){
				$this->json_equivalencias = $data['json_equivalencias'];
			}
			if( isset($data['id_empresa']) ){
				$this->id_empresa = $data['id_empresa'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto HistorialTipoCambio en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_historial_tipo_cambio" => $this->id_historial_tipo_cambio,
			"id_moneda_base" => $this->id_moneda_base,
			"fecha" => $this->fecha,
			"json_equivalencias" => $this->json_equivalencias,
			"id_empresa" => $this->id_empresa
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_historial_tipo_cambio
	  * 
	  * El id del registro en la tabla.<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_historial_tipo_cambio;

	/**
	  * id_moneda_base
	  * 
	  * El id de la moneda base del sistema<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_moneda_base;

	/**
	  * fecha
	  * 
	  * La fecha en formato UNIX en que se registra el tipo de cambio con respecto a la moneda base<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha;

	/**
	  * json_equivalencias
	  * 
	  * Un JSON que contenga la equivalencia de la moneda base en las demás monedas activadas en el sistema.<br>
	  * @access public
	  * @var text
	  */
	public $json_equivalencias;

	/**
	  * id_empresa
	  * 
	  * El id de la empresa para la que aplica este tipo de cambio para su moneda base.<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_empresa;

	/**
	  * getIdHistorialTipoCambio
	  * 
	  * Get the <i>id_historial_tipo_cambio</i> property for this object. Donde <i>id_historial_tipo_cambio</i> es El id del registro en la tabla.
	  * @return int(11)
	  */
	final public function getIdHistorialTipoCambio()
	{
		return $this->id_historial_tipo_cambio;
	}

	/**
	  * setIdHistorialTipoCambio( $id_historial_tipo_cambio )
	  * 
	  * Set the <i>id_historial_tipo_cambio</i> property for this object. Donde <i>id_historial_tipo_cambio</i> es El id del registro en la tabla..
	  * Una validacion basica se hara aqui para comprobar que <i>id_historial_tipo_cambio</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdHistorialTipoCambio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdHistorialTipoCambio( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdHistorialTipoCambio( $id_historial_tipo_cambio )
	{
		$this->id_historial_tipo_cambio = $id_historial_tipo_cambio;
	}

	/**
	  * getIdMonedaBase
	  * 
	  * Get the <i>id_moneda_base</i> property for this object. Donde <i>id_moneda_base</i> es El id de la moneda base del sistema
	  * @return int(11)
	  */
	final public function getIdMonedaBase()
	{
		return $this->id_moneda_base;
	}

	/**
	  * setIdMonedaBase( $id_moneda_base )
	  * 
	  * Set the <i>id_moneda_base</i> property for this object. Donde <i>id_moneda_base</i> es El id de la moneda base del sistema.
	  * Una validacion basica se hara aqui para comprobar que <i>id_moneda_base</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdMonedaBase( $id_moneda_base )
	{
		$this->id_moneda_base = $id_moneda_base;
	}

	/**
	  * getFecha
	  * 
	  * Get the <i>fecha</i> property for this object. Donde <i>fecha</i> es La fecha en formato UNIX en que se registra el tipo de cambio con respecto a la moneda base
	  * @return int(11)
	  */
	final public function getFecha()
	{
		return $this->fecha;
	}

	/**
	  * setFecha( $fecha )
	  * 
	  * Set the <i>fecha</i> property for this object. Donde <i>fecha</i> es La fecha en formato UNIX en que se registra el tipo de cambio con respecto a la moneda base.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFecha( $fecha )
	{
		$this->fecha = $fecha;
	}

	/**
	  * getJsonEquivalencias
	  * 
	  * Get the <i>json_equivalencias</i> property for this object. Donde <i>json_equivalencias</i> es Un JSON que contenga la equivalencia de la moneda base en las demás monedas activadas en el sistema.
	  * @return text
	  */
	final public function getJsonEquivalencias()
	{
		return $this->json_equivalencias;
	}

	/**
	  * setJsonEquivalencias( $json_equivalencias )
	  * 
	  * Set the <i>json_equivalencias</i> property for this object. Donde <i>json_equivalencias</i> es Un JSON que contenga la equivalencia de la moneda base en las demás monedas activadas en el sistema..
	  * Una validacion basica se hara aqui para comprobar que <i>json_equivalencias</i> es de tipo <i>text</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param text
	  */
	final public function setJsonEquivalencias( $json_equivalencias )
	{
		$this->json_equivalencias = $json_equivalencias;
	}

	/**
	  * getIdEmpresa
	  * 
	  * Get the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es El id de la empresa para la que aplica este tipo de cambio para su moneda base.
	  * @return int(11)
	  */
	final public function getIdEmpresa()
	{
		return $this->id_empresa;
	}

	/**
	  * setIdEmpresa( $id_empresa )
	  * 
	  * Set the <i>id_empresa</i> property for this object. Donde <i>id_empresa</i> es El id de la empresa para la que aplica este tipo de cambio para su moneda base..
	  * Una validacion basica se hara aqui para comprobar que <i>id_empresa</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdEmpresa( $id_empresa )
	{
		$this->id_empresa = $id_empresa;
	}

}
