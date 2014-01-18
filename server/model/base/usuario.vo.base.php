<?php
/** Value Object file for table usuario.
  * 
  * VO does not have any behaviour except for storage and retrieval of its own data (accessors and mutators).
  * @author Anonymous
  * @access public
  * @package docs
  * 
  */

class Usuario extends VO
{
	/**
	  * Constructor de Usuario
	  * 
	  * Para construir un objeto de tipo Usuario debera llamarse a el constructor 
	  * sin parametros. Es posible, construir un objeto pasando como parametro un arreglo asociativo 
	  * cuyos campos son iguales a las variables que constituyen a este objeto.
	  * @return Usuario
	  */
	function __construct( $data = NULL)
	{ 
		if(isset($data))
		{
			if( isset($data['id_usuario']) ){
				$this->id_usuario = $data['id_usuario'];
			}
			if( isset($data['id_direccion']) ){
				$this->id_direccion = $data['id_direccion'];
			}
			if( isset($data['id_direccion_alterna']) ){
				$this->id_direccion_alterna = $data['id_direccion_alterna'];
			}
			if( isset($data['id_sucursal']) ){
				$this->id_sucursal = $data['id_sucursal'];
			}
			if( isset($data['id_rol']) ){
				$this->id_rol = $data['id_rol'];
			}
			if( isset($data['id_categoria_contacto']) ){
				$this->id_categoria_contacto = $data['id_categoria_contacto'];
			}
			if( isset($data['id_clasificacion_proveedor']) ){
				$this->id_clasificacion_proveedor = $data['id_clasificacion_proveedor'];
			}
			if( isset($data['id_clasificacion_cliente']) ){
				$this->id_clasificacion_cliente = $data['id_clasificacion_cliente'];
			}
			if( isset($data['id_moneda']) ){
				$this->id_moneda = $data['id_moneda'];
			}
			if( isset($data['fecha_asignacion_rol']) ){
				$this->fecha_asignacion_rol = $data['fecha_asignacion_rol'];
			}
			if( isset($data['nombre']) ){
				$this->nombre = $data['nombre'];
			}
			if( isset($data['rfc']) ){
				$this->rfc = $data['rfc'];
			}
			if( isset($data['curp']) ){
				$this->curp = $data['curp'];
			}
			if( isset($data['comision_ventas']) ){
				$this->comision_ventas = $data['comision_ventas'];
			}
			if( isset($data['telefono_personal1']) ){
				$this->telefono_personal1 = $data['telefono_personal1'];
			}
			if( isset($data['telefono_personal2']) ){
				$this->telefono_personal2 = $data['telefono_personal2'];
			}
			if( isset($data['fecha_alta']) ){
				$this->fecha_alta = $data['fecha_alta'];
			}
			if( isset($data['fecha_baja']) ){
				$this->fecha_baja = $data['fecha_baja'];
			}
			if( isset($data['activo']) ){
				$this->activo = $data['activo'];
			}
			if( isset($data['limite_credito']) ){
				$this->limite_credito = $data['limite_credito'];
			}
			if( isset($data['descuento']) ){
				$this->descuento = $data['descuento'];
			}
			if( isset($data['password']) ){
				$this->password = $data['password'];
			}
			if( isset($data['last_login']) ){
				$this->last_login = $data['last_login'];
			}
			if( isset($data['consignatario']) ){
				$this->consignatario = $data['consignatario'];
			}
			if( isset($data['salario']) ){
				$this->salario = $data['salario'];
			}
			if( isset($data['correo_electronico']) ){
				$this->correo_electronico = $data['correo_electronico'];
			}
			if( isset($data['pagina_web']) ){
				$this->pagina_web = $data['pagina_web'];
			}
			if( isset($data['saldo_del_ejercicio']) ){
				$this->saldo_del_ejercicio = $data['saldo_del_ejercicio'];
			}
			if( isset($data['ventas_a_credito']) ){
				$this->ventas_a_credito = $data['ventas_a_credito'];
			}
			if( isset($data['representante_legal']) ){
				$this->representante_legal = $data['representante_legal'];
			}
			if( isset($data['facturar_a_terceros']) ){
				$this->facturar_a_terceros = $data['facturar_a_terceros'];
			}
			if( isset($data['dia_de_pago']) ){
				$this->dia_de_pago = $data['dia_de_pago'];
			}
			if( isset($data['mensajeria']) ){
				$this->mensajeria = $data['mensajeria'];
			}
			if( isset($data['intereses_moratorios']) ){
				$this->intereses_moratorios = $data['intereses_moratorios'];
			}
			if( isset($data['denominacion_comercial']) ){
				$this->denominacion_comercial = $data['denominacion_comercial'];
			}
			if( isset($data['dias_de_credito']) ){
				$this->dias_de_credito = $data['dias_de_credito'];
			}
			if( isset($data['cuenta_de_mensajeria']) ){
				$this->cuenta_de_mensajeria = $data['cuenta_de_mensajeria'];
			}
			if( isset($data['dia_de_revision']) ){
				$this->dia_de_revision = $data['dia_de_revision'];
			}
			if( isset($data['codigo_usuario']) ){
				$this->codigo_usuario = $data['codigo_usuario'];
			}
			if( isset($data['dias_de_embarque']) ){
				$this->dias_de_embarque = $data['dias_de_embarque'];
			}
			if( isset($data['tiempo_entrega']) ){
				$this->tiempo_entrega = $data['tiempo_entrega'];
			}
			if( isset($data['cuenta_bancaria']) ){
				$this->cuenta_bancaria = $data['cuenta_bancaria'];
			}
			if( isset($data['id_tarifa_compra']) ){
				$this->id_tarifa_compra = $data['id_tarifa_compra'];
			}
			if( isset($data['tarifa_compra_obtenida']) ){
				$this->tarifa_compra_obtenida = $data['tarifa_compra_obtenida'];
			}
			if( isset($data['id_tarifa_venta']) ){
				$this->id_tarifa_venta = $data['id_tarifa_venta'];
			}
			if( isset($data['tarifa_venta_obtenida']) ){
				$this->tarifa_venta_obtenida = $data['tarifa_venta_obtenida'];
			}
			if( isset($data['token_recuperacion_pass']) ){
				$this->token_recuperacion_pass = $data['token_recuperacion_pass'];
			}
			if( isset($data['id_perfil']) ){
				$this->id_perfil = $data['id_perfil'];
			}
		}
	}

	/**
	  * Obtener una representacion en String
	  * 
	  * Este metodo permite tratar a un objeto Usuario en forma de cadena.
	  * La representacion de este objeto en cadena es la forma JSON (JavaScript Object Notation) para este objeto.
	  * @return String 
	  */
	public function __toString( )
	{ 
		$vec = array( 
			"id_usuario" => $this->id_usuario,
			"id_direccion" => $this->id_direccion,
			"id_direccion_alterna" => $this->id_direccion_alterna,
			"id_sucursal" => $this->id_sucursal,
			"id_rol" => $this->id_rol,
			"id_categoria_contacto" => $this->id_categoria_contacto,
			"id_clasificacion_proveedor" => $this->id_clasificacion_proveedor,
			"id_clasificacion_cliente" => $this->id_clasificacion_cliente,
			"id_moneda" => $this->id_moneda,
			"fecha_asignacion_rol" => $this->fecha_asignacion_rol,
			"nombre" => $this->nombre,
			"rfc" => $this->rfc,
			"curp" => $this->curp,
			"comision_ventas" => $this->comision_ventas,
			"telefono_personal1" => $this->telefono_personal1,
			"telefono_personal2" => $this->telefono_personal2,
			"fecha_alta" => $this->fecha_alta,
			"fecha_baja" => $this->fecha_baja,
			"activo" => $this->activo,
			"limite_credito" => $this->limite_credito,
			"descuento" => $this->descuento,
			"password" => $this->password,
			"last_login" => $this->last_login,
			"consignatario" => $this->consignatario,
			"salario" => $this->salario,
			"correo_electronico" => $this->correo_electronico,
			"pagina_web" => $this->pagina_web,
			"saldo_del_ejercicio" => $this->saldo_del_ejercicio,
			"ventas_a_credito" => $this->ventas_a_credito,
			"representante_legal" => $this->representante_legal,
			"facturar_a_terceros" => $this->facturar_a_terceros,
			"dia_de_pago" => $this->dia_de_pago,
			"mensajeria" => $this->mensajeria,
			"intereses_moratorios" => $this->intereses_moratorios,
			"denominacion_comercial" => $this->denominacion_comercial,
			"dias_de_credito" => $this->dias_de_credito,
			"cuenta_de_mensajeria" => $this->cuenta_de_mensajeria,
			"dia_de_revision" => $this->dia_de_revision,
			"codigo_usuario" => $this->codigo_usuario,
			"dias_de_embarque" => $this->dias_de_embarque,
			"tiempo_entrega" => $this->tiempo_entrega,
			"cuenta_bancaria" => $this->cuenta_bancaria,
			"id_tarifa_compra" => $this->id_tarifa_compra,
			"tarifa_compra_obtenida" => $this->tarifa_compra_obtenida,
			"id_tarifa_venta" => $this->id_tarifa_venta,
			"tarifa_venta_obtenida" => $this->tarifa_venta_obtenida,
			"token_recuperacion_pass" => $this->token_recuperacion_pass,
			"id_perfil" => $this->id_perfil
		); 
	return json_encode($vec); 
	}
	
	/**
	  * id_usuario
	  * 
	  * Id de la tabla usuario<br>
	  * <b>Llave Primaria</b><br>
	  * <b>Auto Incremento</b><br>
	  * @access public
	  * @var int(11)
	  */
	public $id_usuario;

	/**
	  * id_direccion
	  * 
	  * Id de la direccion del usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_direccion;

	/**
	  * id_direccion_alterna
	  * 
	  * Id de la direccion alterna del usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_direccion_alterna;

	/**
	  * id_sucursal
	  * 
	  * Id sucursal en la que labora este usuario o dodne se dio de alta<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_sucursal;

	/**
	  * id_rol
	  * 
	  * Id del rol que desempeÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â±ara el usuario en la instancia<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_rol;

	/**
	  * id_categoria_contacto
	  * 
	  * Id de la categoria del cliente/proveedor<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_categoria_contacto;

	/**
	  * id_clasificacion_proveedor
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_proveedor;

	/**
	  * id_clasificacion_cliente
	  * 
	  *  [Campo no documentado]<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_clasificacion_cliente;

	/**
	  * id_moneda
	  * 
	  * Id moneda de preferencia del usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_moneda;

	/**
	  * fecha_asignacion_rol
	  * 
	  * Fecha en que se asigno o modifico el rol de este usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_asignacion_rol;

	/**
	  * nombre
	  * 
	  * Nombre del agente<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $nombre;

	/**
	  * rfc
	  * 
	  * RFC del agente<br>
	  * @access public
	  * @var varchar(30)
	  */
	public $rfc;

	/**
	  * curp
	  * 
	  * CURP del agente<br>
	  * @access public
	  * @var varchar(30)
	  */
	public $curp;

	/**
	  * comision_ventas
	  * 
	  * Comision sobre las ventas que recibira este agente<br>
	  * @access public
	  * @var float
	  */
	public $comision_ventas;

	/**
	  * telefono_personal1
	  * 
	  * Telefono personal del agente<br>
	  * @access public
	  * @var varchar(20)
	  */
	public $telefono_personal1;

	/**
	  * telefono_personal2
	  * 
	  * Telefono personal del agente<br>
	  * @access public
	  * @var varchar(20)
	  */
	public $telefono_personal2;

	/**
	  * fecha_alta
	  * 
	  * Fecha en que se creo este usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_alta;

	/**
	  * fecha_baja
	  * 
	  * fecha en que se desactivo este usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $fecha_baja;

	/**
	  * activo
	  * 
	  * si este usuario esta activo o no<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $activo;

	/**
	  * limite_credito
	  * 
	  * Limite de credito del usuario<br>
	  * @access public
	  * @var float
	  */
	public $limite_credito;

	/**
	  * descuento
	  * 
	  * Porcentaje del descuento del usuario<br>
	  * @access public
	  * @var float
	  */
	public $descuento;

	/**
	  * password
	  * 
	  * Password del usuario<br>
	  * @access public
	  * @var varchar(64)
	  */
	public $password;

	/**
	  * last_login
	  * 
	  * Fecha en la que ingreso el usuario por ultima vez<br>
	  * @access public
	  * @var int(11)
	  */
	public $last_login;

	/**
	  * consignatario
	  * 
	  * Si el usuario es consignatario<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $consignatario;

	/**
	  * salario
	  * 
	  * El salario que recibe el usuaario actualmente<br>
	  * @access public
	  * @var float
	  */
	public $salario;

	/**
	  * correo_electronico
	  * 
	  * Correo electronico del usuario<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $correo_electronico;

	/**
	  * pagina_web
	  * 
	  * Pagina Web del usuario<br>
	  * @access public
	  * @var varchar(30)
	  */
	public $pagina_web;

	/**
	  * saldo_del_ejercicio
	  * 
	  * Saldo del ejercicio del cliente<br>
	  * @access public
	  * @var float
	  */
	public $saldo_del_ejercicio;

	/**
	  * ventas_a_credito
	  * 
	  * Ventas a credito del cliente<br>
	  * @access public
	  * @var int(11)
	  */
	public $ventas_a_credito;

	/**
	  * representante_legal
	  * 
	  * Nombre del representante legal del usuario<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $representante_legal;

	/**
	  * facturar_a_terceros
	  * 
	  * Si el cliente puede facturar a terceros<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $facturar_a_terceros;

	/**
	  * dia_de_pago
	  * 
	  * Fecha de pago del cliente<br>
	  * @access public
	  * @var int(11)
	  */
	public $dia_de_pago;

	/**
	  * mensajeria
	  * 
	  * Si el cliente cuenta con una cuenta de mensajerÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a y paqueterÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a<br>
	  * @access public
	  * @var tinyint(1)
	  */
	public $mensajeria;

	/**
	  * intereses_moratorios
	  * 
	  * Intereses moratorios del cliente<br>
	  * @access public
	  * @var float
	  */
	public $intereses_moratorios;

	/**
	  * denominacion_comercial
	  * 
	  * DenominaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n comercial del cliente<br>
	  * @access public
	  * @var varchar(100)
	  */
	public $denominacion_comercial;

	/**
	  * dias_de_credito
	  * 
	  * DÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­as de crÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â©dito que se le darÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¡n al cliente<br>
	  * @access public
	  * @var int(11)
	  */
	public $dias_de_credito;

	/**
	  * cuenta_de_mensajeria
	  * 
	  * Cuenta de mensajeria del cliente<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $cuenta_de_mensajeria;

	/**
	  * dia_de_revision
	  * 
	  * Fecha de revisiÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n del cliente<br>
	  * @access public
	  * @var int(11)
	  */
	public $dia_de_revision;

	/**
	  * codigo_usuario
	  * 
	  * Codigo del usuario para uso interno de la empresa<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $codigo_usuario;

	/**
	  * dias_de_embarque
	  * 
	  * Dias de embarque del proveedor (Lunes, Martes, etc)<br>
	  * @access public
	  * @var int(11)
	  */
	public $dias_de_embarque;

	/**
	  * tiempo_entrega
	  * 
	  * Tiempo de entrega del proveedor en dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­as<br>
	  * @access public
	  * @var int(11)
	  */
	public $tiempo_entrega;

	/**
	  * cuenta_bancaria
	  * 
	  * Cuenta bancaria del usuario<br>
	  * @access public
	  * @var varchar(50)
	  */
	public $cuenta_bancaria;

	/**
	  * id_tarifa_compra
	  * 
	  * Id de la tarifa de compra por default para este usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa_compra;

	/**
	  * tarifa_compra_obtenida
	  * 
	  * Indica de donde fue obtenida la tarifa de compra<br>
	  * @access public
	  * @var enum('rol','proveedor','cliente','usuario')
	  */
	public $tarifa_compra_obtenida;

	/**
	  * id_tarifa_venta
	  * 
	  * Id de la tarifa de venta por default para este usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_tarifa_venta;

	/**
	  * tarifa_venta_obtenida
	  * 
	  * Indica de donde fue obtenida la tarifa de venta<br>
	  * @access public
	  * @var enum('rol','proveedor','cliente','usuario')
	  */
	public $tarifa_venta_obtenida;

	/**
	  * token_recuperacion_pass
	  * 
	  * El token que se envia por correo para recuperar contrasena<br>
	  * @access public
	  * @var varchar(30)
	  */
	public $token_recuperacion_pass;

	/**
	  * id_perfil
	  * 
	  * Id del perfil de este usuario<br>
	  * @access public
	  * @var int(11)
	  */
	public $id_perfil;

	/**
	  * getIdUsuario
	  * 
	  * Get the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id de la tabla usuario
	  * @return int(11)
	  */
	final public function getIdUsuario()
	{
		return $this->id_usuario;
	}

	/**
	  * setIdUsuario( $id_usuario )
	  * 
	  * Set the <i>id_usuario</i> property for this object. Donde <i>id_usuario</i> es Id de la tabla usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_usuario</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * <br><br>Esta propiedad se mapea con un campo que es de <b>Auto Incremento</b> !<br>
	  * No deberias usar setIdUsuario( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * <br><br>Esta propiedad se mapea con un campo que es una <b>Llave Primaria</b> !<br>
	  * No deberias usar setIdUsuario( ) a menos que sepas exactamente lo que estas haciendo.<br>
	  * @param int(11)
	  */
	final public function setIdUsuario( $id_usuario )
	{
		$this->id_usuario = $id_usuario;
	}

	/**
	  * getIdDireccion
	  * 
	  * Get the <i>id_direccion</i> property for this object. Donde <i>id_direccion</i> es Id de la direccion del usuario
	  * @return int(11)
	  */
	final public function getIdDireccion()
	{
		return $this->id_direccion;
	}

	/**
	  * setIdDireccion( $id_direccion )
	  * 
	  * Set the <i>id_direccion</i> property for this object. Donde <i>id_direccion</i> es Id de la direccion del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_direccion</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdDireccion( $id_direccion )
	{
		$this->id_direccion = $id_direccion;
	}

	/**
	  * getIdDireccionAlterna
	  * 
	  * Get the <i>id_direccion_alterna</i> property for this object. Donde <i>id_direccion_alterna</i> es Id de la direccion alterna del usuario
	  * @return int(11)
	  */
	final public function getIdDireccionAlterna()
	{
		return $this->id_direccion_alterna;
	}

	/**
	  * setIdDireccionAlterna( $id_direccion_alterna )
	  * 
	  * Set the <i>id_direccion_alterna</i> property for this object. Donde <i>id_direccion_alterna</i> es Id de la direccion alterna del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_direccion_alterna</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdDireccionAlterna( $id_direccion_alterna )
	{
		$this->id_direccion_alterna = $id_direccion_alterna;
	}

	/**
	  * getIdSucursal
	  * 
	  * Get the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es Id sucursal en la que labora este usuario o dodne se dio de alta
	  * @return int(11)
	  */
	final public function getIdSucursal()
	{
		return $this->id_sucursal;
	}

	/**
	  * setIdSucursal( $id_sucursal )
	  * 
	  * Set the <i>id_sucursal</i> property for this object. Donde <i>id_sucursal</i> es Id sucursal en la que labora este usuario o dodne se dio de alta.
	  * Una validacion basica se hara aqui para comprobar que <i>id_sucursal</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdSucursal( $id_sucursal )
	{
		$this->id_sucursal = $id_sucursal;
	}

	/**
	  * getIdRol
	  * 
	  * Get the <i>id_rol</i> property for this object. Donde <i>id_rol</i> es Id del rol que desempeÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â±ara el usuario en la instancia
	  * @return int(11)
	  */
	final public function getIdRol()
	{
		return $this->id_rol;
	}

	/**
	  * setIdRol( $id_rol )
	  * 
	  * Set the <i>id_rol</i> property for this object. Donde <i>id_rol</i> es Id del rol que desempeÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â±ara el usuario en la instancia.
	  * Una validacion basica se hara aqui para comprobar que <i>id_rol</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdRol( $id_rol )
	{
		$this->id_rol = $id_rol;
	}

	/**
	  * getIdCategoriaContacto
	  * 
	  * Get the <i>id_categoria_contacto</i> property for this object. Donde <i>id_categoria_contacto</i> es Id de la categoria del cliente/proveedor
	  * @return int(11)
	  */
	final public function getIdCategoriaContacto()
	{
		return $this->id_categoria_contacto;
	}

	/**
	  * setIdCategoriaContacto( $id_categoria_contacto )
	  * 
	  * Set the <i>id_categoria_contacto</i> property for this object. Donde <i>id_categoria_contacto</i> es Id de la categoria del cliente/proveedor.
	  * Una validacion basica se hara aqui para comprobar que <i>id_categoria_contacto</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdCategoriaContacto( $id_categoria_contacto )
	{
		$this->id_categoria_contacto = $id_categoria_contacto;
	}

	/**
	  * getIdClasificacionProveedor
	  * 
	  * Get the <i>id_clasificacion_proveedor</i> property for this object. Donde <i>id_clasificacion_proveedor</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdClasificacionProveedor()
	{
		return $this->id_clasificacion_proveedor;
	}

	/**
	  * setIdClasificacionProveedor( $id_clasificacion_proveedor )
	  * 
	  * Set the <i>id_clasificacion_proveedor</i> property for this object. Donde <i>id_clasificacion_proveedor</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_proveedor</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdClasificacionProveedor( $id_clasificacion_proveedor )
	{
		$this->id_clasificacion_proveedor = $id_clasificacion_proveedor;
	}

	/**
	  * getIdClasificacionCliente
	  * 
	  * Get the <i>id_clasificacion_cliente</i> property for this object. Donde <i>id_clasificacion_cliente</i> es  [Campo no documentado]
	  * @return int(11)
	  */
	final public function getIdClasificacionCliente()
	{
		return $this->id_clasificacion_cliente;
	}

	/**
	  * setIdClasificacionCliente( $id_clasificacion_cliente )
	  * 
	  * Set the <i>id_clasificacion_cliente</i> property for this object. Donde <i>id_clasificacion_cliente</i> es  [Campo no documentado].
	  * Una validacion basica se hara aqui para comprobar que <i>id_clasificacion_cliente</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdClasificacionCliente( $id_clasificacion_cliente )
	{
		$this->id_clasificacion_cliente = $id_clasificacion_cliente;
	}

	/**
	  * getIdMoneda
	  * 
	  * Get the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es Id moneda de preferencia del usuario
	  * @return int(11)
	  */
	final public function getIdMoneda()
	{
		return $this->id_moneda;
	}

	/**
	  * setIdMoneda( $id_moneda )
	  * 
	  * Set the <i>id_moneda</i> property for this object. Donde <i>id_moneda</i> es Id moneda de preferencia del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_moneda</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdMoneda( $id_moneda )
	{
		$this->id_moneda = $id_moneda;
	}

	/**
	  * getFechaAsignacionRol
	  * 
	  * Get the <i>fecha_asignacion_rol</i> property for this object. Donde <i>fecha_asignacion_rol</i> es Fecha en que se asigno o modifico el rol de este usuario
	  * @return int(11)
	  */
	final public function getFechaAsignacionRol()
	{
		return $this->fecha_asignacion_rol;
	}

	/**
	  * setFechaAsignacionRol( $fecha_asignacion_rol )
	  * 
	  * Set the <i>fecha_asignacion_rol</i> property for this object. Donde <i>fecha_asignacion_rol</i> es Fecha en que se asigno o modifico el rol de este usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_asignacion_rol</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaAsignacionRol( $fecha_asignacion_rol )
	{
		$this->fecha_asignacion_rol = $fecha_asignacion_rol;
	}

	/**
	  * getNombre
	  * 
	  * Get the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del agente
	  * @return varchar(100)
	  */
	final public function getNombre()
	{
		return $this->nombre;
	}

	/**
	  * setNombre( $nombre )
	  * 
	  * Set the <i>nombre</i> property for this object. Donde <i>nombre</i> es Nombre del agente.
	  * Una validacion basica se hara aqui para comprobar que <i>nombre</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setNombre( $nombre )
	{
		$this->nombre = $nombre;
	}

	/**
	  * getRfc
	  * 
	  * Get the <i>rfc</i> property for this object. Donde <i>rfc</i> es RFC del agente
	  * @return varchar(30)
	  */
	final public function getRfc()
	{
		return $this->rfc;
	}

	/**
	  * setRfc( $rfc )
	  * 
	  * Set the <i>rfc</i> property for this object. Donde <i>rfc</i> es RFC del agente.
	  * Una validacion basica se hara aqui para comprobar que <i>rfc</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setRfc( $rfc )
	{
		$this->rfc = $rfc;
	}

	/**
	  * getCurp
	  * 
	  * Get the <i>curp</i> property for this object. Donde <i>curp</i> es CURP del agente
	  * @return varchar(30)
	  */
	final public function getCurp()
	{
		return $this->curp;
	}

	/**
	  * setCurp( $curp )
	  * 
	  * Set the <i>curp</i> property for this object. Donde <i>curp</i> es CURP del agente.
	  * Una validacion basica se hara aqui para comprobar que <i>curp</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setCurp( $curp )
	{
		$this->curp = $curp;
	}

	/**
	  * getComisionVentas
	  * 
	  * Get the <i>comision_ventas</i> property for this object. Donde <i>comision_ventas</i> es Comision sobre las ventas que recibira este agente
	  * @return float
	  */
	final public function getComisionVentas()
	{
		return $this->comision_ventas;
	}

	/**
	  * setComisionVentas( $comision_ventas )
	  * 
	  * Set the <i>comision_ventas</i> property for this object. Donde <i>comision_ventas</i> es Comision sobre las ventas que recibira este agente.
	  * Una validacion basica se hara aqui para comprobar que <i>comision_ventas</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setComisionVentas( $comision_ventas )
	{
		$this->comision_ventas = $comision_ventas;
	}

	/**
	  * getTelefonoPersonal1
	  * 
	  * Get the <i>telefono_personal1</i> property for this object. Donde <i>telefono_personal1</i> es Telefono personal del agente
	  * @return varchar(20)
	  */
	final public function getTelefonoPersonal1()
	{
		return $this->telefono_personal1;
	}

	/**
	  * setTelefonoPersonal1( $telefono_personal1 )
	  * 
	  * Set the <i>telefono_personal1</i> property for this object. Donde <i>telefono_personal1</i> es Telefono personal del agente.
	  * Una validacion basica se hara aqui para comprobar que <i>telefono_personal1</i> es de tipo <i>varchar(20)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(20)
	  */
	final public function setTelefonoPersonal1( $telefono_personal1 )
	{
		$this->telefono_personal1 = $telefono_personal1;
	}

	/**
	  * getTelefonoPersonal2
	  * 
	  * Get the <i>telefono_personal2</i> property for this object. Donde <i>telefono_personal2</i> es Telefono personal del agente
	  * @return varchar(20)
	  */
	final public function getTelefonoPersonal2()
	{
		return $this->telefono_personal2;
	}

	/**
	  * setTelefonoPersonal2( $telefono_personal2 )
	  * 
	  * Set the <i>telefono_personal2</i> property for this object. Donde <i>telefono_personal2</i> es Telefono personal del agente.
	  * Una validacion basica se hara aqui para comprobar que <i>telefono_personal2</i> es de tipo <i>varchar(20)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(20)
	  */
	final public function setTelefonoPersonal2( $telefono_personal2 )
	{
		$this->telefono_personal2 = $telefono_personal2;
	}

	/**
	  * getFechaAlta
	  * 
	  * Get the <i>fecha_alta</i> property for this object. Donde <i>fecha_alta</i> es Fecha en que se creo este usuario
	  * @return int(11)
	  */
	final public function getFechaAlta()
	{
		return $this->fecha_alta;
	}

	/**
	  * setFechaAlta( $fecha_alta )
	  * 
	  * Set the <i>fecha_alta</i> property for this object. Donde <i>fecha_alta</i> es Fecha en que se creo este usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_alta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaAlta( $fecha_alta )
	{
		$this->fecha_alta = $fecha_alta;
	}

	/**
	  * getFechaBaja
	  * 
	  * Get the <i>fecha_baja</i> property for this object. Donde <i>fecha_baja</i> es fecha en que se desactivo este usuario
	  * @return int(11)
	  */
	final public function getFechaBaja()
	{
		return $this->fecha_baja;
	}

	/**
	  * setFechaBaja( $fecha_baja )
	  * 
	  * Set the <i>fecha_baja</i> property for this object. Donde <i>fecha_baja</i> es fecha en que se desactivo este usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>fecha_baja</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setFechaBaja( $fecha_baja )
	{
		$this->fecha_baja = $fecha_baja;
	}

	/**
	  * getActivo
	  * 
	  * Get the <i>activo</i> property for this object. Donde <i>activo</i> es si este usuario esta activo o no
	  * @return tinyint(1)
	  */
	final public function getActivo()
	{
		return $this->activo;
	}

	/**
	  * setActivo( $activo )
	  * 
	  * Set the <i>activo</i> property for this object. Donde <i>activo</i> es si este usuario esta activo o no.
	  * Una validacion basica se hara aqui para comprobar que <i>activo</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setActivo( $activo )
	{
		$this->activo = $activo;
	}

	/**
	  * getLimiteCredito
	  * 
	  * Get the <i>limite_credito</i> property for this object. Donde <i>limite_credito</i> es Limite de credito del usuario
	  * @return float
	  */
	final public function getLimiteCredito()
	{
		return $this->limite_credito;
	}

	/**
	  * setLimiteCredito( $limite_credito )
	  * 
	  * Set the <i>limite_credito</i> property for this object. Donde <i>limite_credito</i> es Limite de credito del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>limite_credito</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setLimiteCredito( $limite_credito )
	{
		$this->limite_credito = $limite_credito;
	}

	/**
	  * getDescuento
	  * 
	  * Get the <i>descuento</i> property for this object. Donde <i>descuento</i> es Porcentaje del descuento del usuario
	  * @return float
	  */
	final public function getDescuento()
	{
		return $this->descuento;
	}

	/**
	  * setDescuento( $descuento )
	  * 
	  * Set the <i>descuento</i> property for this object. Donde <i>descuento</i> es Porcentaje del descuento del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>descuento</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setDescuento( $descuento )
	{
		$this->descuento = $descuento;
	}

	/**
	  * getPassword
	  * 
	  * Get the <i>password</i> property for this object. Donde <i>password</i> es Password del usuario
	  * @return varchar(64)
	  */
	final public function getPassword()
	{
		return $this->password;
	}

	/**
	  * setPassword( $password )
	  * 
	  * Set the <i>password</i> property for this object. Donde <i>password</i> es Password del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>password</i> es de tipo <i>varchar(64)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(64)
	  */
	final public function setPassword( $password )
	{
		$this->password = $password;
	}

	/**
	  * getLastLogin
	  * 
	  * Get the <i>last_login</i> property for this object. Donde <i>last_login</i> es Fecha en la que ingreso el usuario por ultima vez
	  * @return int(11)
	  */
	final public function getLastLogin()
	{
		return $this->last_login;
	}

	/**
	  * setLastLogin( $last_login )
	  * 
	  * Set the <i>last_login</i> property for this object. Donde <i>last_login</i> es Fecha en la que ingreso el usuario por ultima vez.
	  * Una validacion basica se hara aqui para comprobar que <i>last_login</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setLastLogin( $last_login )
	{
		$this->last_login = $last_login;
	}

	/**
	  * getConsignatario
	  * 
	  * Get the <i>consignatario</i> property for this object. Donde <i>consignatario</i> es Si el usuario es consignatario
	  * @return tinyint(1)
	  */
	final public function getConsignatario()
	{
		return $this->consignatario;
	}

	/**
	  * setConsignatario( $consignatario )
	  * 
	  * Set the <i>consignatario</i> property for this object. Donde <i>consignatario</i> es Si el usuario es consignatario.
	  * Una validacion basica se hara aqui para comprobar que <i>consignatario</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setConsignatario( $consignatario )
	{
		$this->consignatario = $consignatario;
	}

	/**
	  * getSalario
	  * 
	  * Get the <i>salario</i> property for this object. Donde <i>salario</i> es El salario que recibe el usuaario actualmente
	  * @return float
	  */
	final public function getSalario()
	{
		return $this->salario;
	}

	/**
	  * setSalario( $salario )
	  * 
	  * Set the <i>salario</i> property for this object. Donde <i>salario</i> es El salario que recibe el usuaario actualmente.
	  * Una validacion basica se hara aqui para comprobar que <i>salario</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSalario( $salario )
	{
		$this->salario = $salario;
	}

	/**
	  * getCorreoElectronico
	  * 
	  * Get the <i>correo_electronico</i> property for this object. Donde <i>correo_electronico</i> es Correo electronico del usuario
	  * @return varchar(50)
	  */
	final public function getCorreoElectronico()
	{
		return $this->correo_electronico;
	}

	/**
	  * setCorreoElectronico( $correo_electronico )
	  * 
	  * Set the <i>correo_electronico</i> property for this object. Donde <i>correo_electronico</i> es Correo electronico del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>correo_electronico</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setCorreoElectronico( $correo_electronico )
	{
		$this->correo_electronico = $correo_electronico;
	}

	/**
	  * getPaginaWeb
	  * 
	  * Get the <i>pagina_web</i> property for this object. Donde <i>pagina_web</i> es Pagina Web del usuario
	  * @return varchar(30)
	  */
	final public function getPaginaWeb()
	{
		return $this->pagina_web;
	}

	/**
	  * setPaginaWeb( $pagina_web )
	  * 
	  * Set the <i>pagina_web</i> property for this object. Donde <i>pagina_web</i> es Pagina Web del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>pagina_web</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setPaginaWeb( $pagina_web )
	{
		$this->pagina_web = $pagina_web;
	}

	/**
	  * getSaldoDelEjercicio
	  * 
	  * Get the <i>saldo_del_ejercicio</i> property for this object. Donde <i>saldo_del_ejercicio</i> es Saldo del ejercicio del cliente
	  * @return float
	  */
	final public function getSaldoDelEjercicio()
	{
		return $this->saldo_del_ejercicio;
	}

	/**
	  * setSaldoDelEjercicio( $saldo_del_ejercicio )
	  * 
	  * Set the <i>saldo_del_ejercicio</i> property for this object. Donde <i>saldo_del_ejercicio</i> es Saldo del ejercicio del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>saldo_del_ejercicio</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setSaldoDelEjercicio( $saldo_del_ejercicio )
	{
		$this->saldo_del_ejercicio = $saldo_del_ejercicio;
	}

	/**
	  * getVentasACredito
	  * 
	  * Get the <i>ventas_a_credito</i> property for this object. Donde <i>ventas_a_credito</i> es Ventas a credito del cliente
	  * @return int(11)
	  */
	final public function getVentasACredito()
	{
		return $this->ventas_a_credito;
	}

	/**
	  * setVentasACredito( $ventas_a_credito )
	  * 
	  * Set the <i>ventas_a_credito</i> property for this object. Donde <i>ventas_a_credito</i> es Ventas a credito del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>ventas_a_credito</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setVentasACredito( $ventas_a_credito )
	{
		$this->ventas_a_credito = $ventas_a_credito;
	}

	/**
	  * getRepresentanteLegal
	  * 
	  * Get the <i>representante_legal</i> property for this object. Donde <i>representante_legal</i> es Nombre del representante legal del usuario
	  * @return varchar(100)
	  */
	final public function getRepresentanteLegal()
	{
		return $this->representante_legal;
	}

	/**
	  * setRepresentanteLegal( $representante_legal )
	  * 
	  * Set the <i>representante_legal</i> property for this object. Donde <i>representante_legal</i> es Nombre del representante legal del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>representante_legal</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setRepresentanteLegal( $representante_legal )
	{
		$this->representante_legal = $representante_legal;
	}

	/**
	  * getFacturarATerceros
	  * 
	  * Get the <i>facturar_a_terceros</i> property for this object. Donde <i>facturar_a_terceros</i> es Si el cliente puede facturar a terceros
	  * @return tinyint(1)
	  */
	final public function getFacturarATerceros()
	{
		return $this->facturar_a_terceros;
	}

	/**
	  * setFacturarATerceros( $facturar_a_terceros )
	  * 
	  * Set the <i>facturar_a_terceros</i> property for this object. Donde <i>facturar_a_terceros</i> es Si el cliente puede facturar a terceros.
	  * Una validacion basica se hara aqui para comprobar que <i>facturar_a_terceros</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setFacturarATerceros( $facturar_a_terceros )
	{
		$this->facturar_a_terceros = $facturar_a_terceros;
	}

	/**
	  * getDiaDePago
	  * 
	  * Get the <i>dia_de_pago</i> property for this object. Donde <i>dia_de_pago</i> es Fecha de pago del cliente
	  * @return int(11)
	  */
	final public function getDiaDePago()
	{
		return $this->dia_de_pago;
	}

	/**
	  * setDiaDePago( $dia_de_pago )
	  * 
	  * Set the <i>dia_de_pago</i> property for this object. Donde <i>dia_de_pago</i> es Fecha de pago del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>dia_de_pago</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setDiaDePago( $dia_de_pago )
	{
		$this->dia_de_pago = $dia_de_pago;
	}

	/**
	  * getMensajeria
	  * 
	  * Get the <i>mensajeria</i> property for this object. Donde <i>mensajeria</i> es Si el cliente cuenta con una cuenta de mensajerÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a y paqueterÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a
	  * @return tinyint(1)
	  */
	final public function getMensajeria()
	{
		return $this->mensajeria;
	}

	/**
	  * setMensajeria( $mensajeria )
	  * 
	  * Set the <i>mensajeria</i> property for this object. Donde <i>mensajeria</i> es Si el cliente cuenta con una cuenta de mensajerÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a y paqueterÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­a.
	  * Una validacion basica se hara aqui para comprobar que <i>mensajeria</i> es de tipo <i>tinyint(1)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param tinyint(1)
	  */
	final public function setMensajeria( $mensajeria )
	{
		$this->mensajeria = $mensajeria;
	}

	/**
	  * getInteresesMoratorios
	  * 
	  * Get the <i>intereses_moratorios</i> property for this object. Donde <i>intereses_moratorios</i> es Intereses moratorios del cliente
	  * @return float
	  */
	final public function getInteresesMoratorios()
	{
		return $this->intereses_moratorios;
	}

	/**
	  * setInteresesMoratorios( $intereses_moratorios )
	  * 
	  * Set the <i>intereses_moratorios</i> property for this object. Donde <i>intereses_moratorios</i> es Intereses moratorios del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>intereses_moratorios</i> es de tipo <i>float</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param float
	  */
	final public function setInteresesMoratorios( $intereses_moratorios )
	{
		$this->intereses_moratorios = $intereses_moratorios;
	}

	/**
	  * getDenominacionComercial
	  * 
	  * Get the <i>denominacion_comercial</i> property for this object. Donde <i>denominacion_comercial</i> es DenominaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n comercial del cliente
	  * @return varchar(100)
	  */
	final public function getDenominacionComercial()
	{
		return $this->denominacion_comercial;
	}

	/**
	  * setDenominacionComercial( $denominacion_comercial )
	  * 
	  * Set the <i>denominacion_comercial</i> property for this object. Donde <i>denominacion_comercial</i> es DenominaciÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n comercial del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>denominacion_comercial</i> es de tipo <i>varchar(100)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(100)
	  */
	final public function setDenominacionComercial( $denominacion_comercial )
	{
		$this->denominacion_comercial = $denominacion_comercial;
	}

	/**
	  * getDiasDeCredito
	  * 
	  * Get the <i>dias_de_credito</i> property for this object. Donde <i>dias_de_credito</i> es DÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­as de crÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â©dito que se le darÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¡n al cliente
	  * @return int(11)
	  */
	final public function getDiasDeCredito()
	{
		return $this->dias_de_credito;
	}

	/**
	  * setDiasDeCredito( $dias_de_credito )
	  * 
	  * Set the <i>dias_de_credito</i> property for this object. Donde <i>dias_de_credito</i> es DÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­as de crÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â©dito que se le darÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â¡n al cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>dias_de_credito</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setDiasDeCredito( $dias_de_credito )
	{
		$this->dias_de_credito = $dias_de_credito;
	}

	/**
	  * getCuentaDeMensajeria
	  * 
	  * Get the <i>cuenta_de_mensajeria</i> property for this object. Donde <i>cuenta_de_mensajeria</i> es Cuenta de mensajeria del cliente
	  * @return varchar(50)
	  */
	final public function getCuentaDeMensajeria()
	{
		return $this->cuenta_de_mensajeria;
	}

	/**
	  * setCuentaDeMensajeria( $cuenta_de_mensajeria )
	  * 
	  * Set the <i>cuenta_de_mensajeria</i> property for this object. Donde <i>cuenta_de_mensajeria</i> es Cuenta de mensajeria del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>cuenta_de_mensajeria</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setCuentaDeMensajeria( $cuenta_de_mensajeria )
	{
		$this->cuenta_de_mensajeria = $cuenta_de_mensajeria;
	}

	/**
	  * getDiaDeRevision
	  * 
	  * Get the <i>dia_de_revision</i> property for this object. Donde <i>dia_de_revision</i> es Fecha de revisiÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n del cliente
	  * @return int(11)
	  */
	final public function getDiaDeRevision()
	{
		return $this->dia_de_revision;
	}

	/**
	  * setDiaDeRevision( $dia_de_revision )
	  * 
	  * Set the <i>dia_de_revision</i> property for this object. Donde <i>dia_de_revision</i> es Fecha de revisiÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â³n del cliente.
	  * Una validacion basica se hara aqui para comprobar que <i>dia_de_revision</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setDiaDeRevision( $dia_de_revision )
	{
		$this->dia_de_revision = $dia_de_revision;
	}

	/**
	  * getCodigoUsuario
	  * 
	  * Get the <i>codigo_usuario</i> property for this object. Donde <i>codigo_usuario</i> es Codigo del usuario para uso interno de la empresa
	  * @return varchar(50)
	  */
	final public function getCodigoUsuario()
	{
		return $this->codigo_usuario;
	}

	/**
	  * setCodigoUsuario( $codigo_usuario )
	  * 
	  * Set the <i>codigo_usuario</i> property for this object. Donde <i>codigo_usuario</i> es Codigo del usuario para uso interno de la empresa.
	  * Una validacion basica se hara aqui para comprobar que <i>codigo_usuario</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setCodigoUsuario( $codigo_usuario )
	{
		$this->codigo_usuario = $codigo_usuario;
	}

	/**
	  * getDiasDeEmbarque
	  * 
	  * Get the <i>dias_de_embarque</i> property for this object. Donde <i>dias_de_embarque</i> es Dias de embarque del proveedor (Lunes, Martes, etc)
	  * @return int(11)
	  */
	final public function getDiasDeEmbarque()
	{
		return $this->dias_de_embarque;
	}

	/**
	  * setDiasDeEmbarque( $dias_de_embarque )
	  * 
	  * Set the <i>dias_de_embarque</i> property for this object. Donde <i>dias_de_embarque</i> es Dias de embarque del proveedor (Lunes, Martes, etc).
	  * Una validacion basica se hara aqui para comprobar que <i>dias_de_embarque</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setDiasDeEmbarque( $dias_de_embarque )
	{
		$this->dias_de_embarque = $dias_de_embarque;
	}

	/**
	  * getTiempoEntrega
	  * 
	  * Get the <i>tiempo_entrega</i> property for this object. Donde <i>tiempo_entrega</i> es Tiempo de entrega del proveedor en dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­as
	  * @return int(11)
	  */
	final public function getTiempoEntrega()
	{
		return $this->tiempo_entrega;
	}

	/**
	  * setTiempoEntrega( $tiempo_entrega )
	  * 
	  * Set the <i>tiempo_entrega</i> property for this object. Donde <i>tiempo_entrega</i> es Tiempo de entrega del proveedor en dÃƒÆ’Ã†â€™Ãƒâ€šÃ‚Â­as.
	  * Una validacion basica se hara aqui para comprobar que <i>tiempo_entrega</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setTiempoEntrega( $tiempo_entrega )
	{
		$this->tiempo_entrega = $tiempo_entrega;
	}

	/**
	  * getCuentaBancaria
	  * 
	  * Get the <i>cuenta_bancaria</i> property for this object. Donde <i>cuenta_bancaria</i> es Cuenta bancaria del usuario
	  * @return varchar(50)
	  */
	final public function getCuentaBancaria()
	{
		return $this->cuenta_bancaria;
	}

	/**
	  * setCuentaBancaria( $cuenta_bancaria )
	  * 
	  * Set the <i>cuenta_bancaria</i> property for this object. Donde <i>cuenta_bancaria</i> es Cuenta bancaria del usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>cuenta_bancaria</i> es de tipo <i>varchar(50)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(50)
	  */
	final public function setCuentaBancaria( $cuenta_bancaria )
	{
		$this->cuenta_bancaria = $cuenta_bancaria;
	}

	/**
	  * getIdTarifaCompra
	  * 
	  * Get the <i>id_tarifa_compra</i> property for this object. Donde <i>id_tarifa_compra</i> es Id de la tarifa de compra por default para este usuario
	  * @return int(11)
	  */
	final public function getIdTarifaCompra()
	{
		return $this->id_tarifa_compra;
	}

	/**
	  * setIdTarifaCompra( $id_tarifa_compra )
	  * 
	  * Set the <i>id_tarifa_compra</i> property for this object. Donde <i>id_tarifa_compra</i> es Id de la tarifa de compra por default para este usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa_compra</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifaCompra( $id_tarifa_compra )
	{
		$this->id_tarifa_compra = $id_tarifa_compra;
	}

	/**
	  * getTarifaCompraObtenida
	  * 
	  * Get the <i>tarifa_compra_obtenida</i> property for this object. Donde <i>tarifa_compra_obtenida</i> es Indica de donde fue obtenida la tarifa de compra
	  * @return enum('rol','proveedor','cliente','usuario')
	  */
	final public function getTarifaCompraObtenida()
	{
		return $this->tarifa_compra_obtenida;
	}

	/**
	  * setTarifaCompraObtenida( $tarifa_compra_obtenida )
	  * 
	  * Set the <i>tarifa_compra_obtenida</i> property for this object. Donde <i>tarifa_compra_obtenida</i> es Indica de donde fue obtenida la tarifa de compra.
	  * Una validacion basica se hara aqui para comprobar que <i>tarifa_compra_obtenida</i> es de tipo <i>enum('rol','proveedor','cliente','usuario')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('rol','proveedor','cliente','usuario')
	  */
	final public function setTarifaCompraObtenida( $tarifa_compra_obtenida )
	{
		$this->tarifa_compra_obtenida = $tarifa_compra_obtenida;
	}

	/**
	  * getIdTarifaVenta
	  * 
	  * Get the <i>id_tarifa_venta</i> property for this object. Donde <i>id_tarifa_venta</i> es Id de la tarifa de venta por default para este usuario
	  * @return int(11)
	  */
	final public function getIdTarifaVenta()
	{
		return $this->id_tarifa_venta;
	}

	/**
	  * setIdTarifaVenta( $id_tarifa_venta )
	  * 
	  * Set the <i>id_tarifa_venta</i> property for this object. Donde <i>id_tarifa_venta</i> es Id de la tarifa de venta por default para este usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_tarifa_venta</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdTarifaVenta( $id_tarifa_venta )
	{
		$this->id_tarifa_venta = $id_tarifa_venta;
	}

	/**
	  * getTarifaVentaObtenida
	  * 
	  * Get the <i>tarifa_venta_obtenida</i> property for this object. Donde <i>tarifa_venta_obtenida</i> es Indica de donde fue obtenida la tarifa de venta
	  * @return enum('rol','proveedor','cliente','usuario')
	  */
	final public function getTarifaVentaObtenida()
	{
		return $this->tarifa_venta_obtenida;
	}

	/**
	  * setTarifaVentaObtenida( $tarifa_venta_obtenida )
	  * 
	  * Set the <i>tarifa_venta_obtenida</i> property for this object. Donde <i>tarifa_venta_obtenida</i> es Indica de donde fue obtenida la tarifa de venta.
	  * Una validacion basica se hara aqui para comprobar que <i>tarifa_venta_obtenida</i> es de tipo <i>enum('rol','proveedor','cliente','usuario')</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param enum('rol','proveedor','cliente','usuario')
	  */
	final public function setTarifaVentaObtenida( $tarifa_venta_obtenida )
	{
		$this->tarifa_venta_obtenida = $tarifa_venta_obtenida;
	}

	/**
	  * getTokenRecuperacionPass
	  * 
	  * Get the <i>token_recuperacion_pass</i> property for this object. Donde <i>token_recuperacion_pass</i> es El token que se envia por correo para recuperar contrasena
	  * @return varchar(30)
	  */
	final public function getTokenRecuperacionPass()
	{
		return $this->token_recuperacion_pass;
	}

	/**
	  * setTokenRecuperacionPass( $token_recuperacion_pass )
	  * 
	  * Set the <i>token_recuperacion_pass</i> property for this object. Donde <i>token_recuperacion_pass</i> es El token que se envia por correo para recuperar contrasena.
	  * Una validacion basica se hara aqui para comprobar que <i>token_recuperacion_pass</i> es de tipo <i>varchar(30)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param varchar(30)
	  */
	final public function setTokenRecuperacionPass( $token_recuperacion_pass )
	{
		$this->token_recuperacion_pass = $token_recuperacion_pass;
	}

	/**
	  * getIdPerfil
	  * 
	  * Get the <i>id_perfil</i> property for this object. Donde <i>id_perfil</i> es Id del perfil de este usuario
	  * @return int(11)
	  */
	final public function getIdPerfil()
	{
		return $this->id_perfil;
	}

	/**
	  * setIdPerfil( $id_perfil )
	  * 
	  * Set the <i>id_perfil</i> property for this object. Donde <i>id_perfil</i> es Id del perfil de este usuario.
	  * Una validacion basica se hara aqui para comprobar que <i>id_perfil</i> es de tipo <i>int(11)</i>. 
	  * Si esta validacion falla, se arrojara... algo. 
	  * @param int(11)
	  */
	final public function setIdPerfil( $id_perfil )
	{
		$this->id_perfil = $id_perfil;
	}

}
