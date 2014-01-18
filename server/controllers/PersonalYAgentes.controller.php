<?php
require_once("interfaces/PersonalYAgentes.interface.php");
/**
	*
	*
	*
	**/

	class PersonalYAgentesController implements IPersonalYAgentes{

			/*
			 * Valida los parametros de la tabla usuario haciendo uso de las valdiaciones basicas de strng y num,
			 * se aplican validaciones extras de acuerdo a su uso
			 * Regresa true cuando son validos, un string con el error cuando no lo es
			 */
			public static function validarParametrosUsuario
			(
							$id_usuario = null,
							$id_direccion = null,
							$id_sucursal = null,
							$id_rol = null,
							$id_clasificacion_cliente = null,
							$id_clasificacion_proveedor = null,
							$id_moneda = null,
							$activo = null,
							$nombre = null,
							$rfc = null,
							$curp = null,
							$comision_ventas = null,
							$telefono_personal1 = null,
							$telefono_personal2 = null,
							$limite_credito = null,
							$descuento = null,
							$password = null,
							$salario = null,
							$correo_electronico = null,
							$pagina_web = null,
							$saldo_del_ejercicio = null,
							$ventas_a_credito = null,
							$representante_legal = null,
							$facturar_a_terceros = null,
							$dia_de_pago = null,
							$mensajeria = null,
							$intereses_moratorios = null,
							$denominacion_comercial = null,
							$dias_de_credito = null,
							$cuenta_de_mensajeria = null,
							$dia_de_revision = null,
							$codigo_usuario = null,
							$dias_de_embarque = null,
							$tiempo_entrega = null,
							$cuenta_bancaria = null,
							$id_tarifa_compra = null,
							$id_tarifa_venta = null,
							$id_usuario_padre = null
			)
			{
					//valida que el id del usuario exista en la base de datos
					if(!is_null($id_usuario))
					{
							if(is_null(UsuarioDAO::getByPK($id_usuario)))
									return "El usuario con id: ".$id_usuario." no existe";
					}
					//valida que el id de la direccion exista en la base de datos
					if(!is_null($id_direccion))
					{
							if(is_null(DireccionDAO::getByPK($id_direccion)))
									return "La direccion con id: ".$id_direccion." no existe";
					}
					//valida el id de la sucursal exista en la base de datos
					if(!is_null($id_sucursal))
					{
							if(is_null(SucursalDAO::getByPK($id_sucursal)))
									return "La sucursal con id: ".$id_sucursal." no existe";
					}
					//valida que el id del rol exista en la base de datos
					if(!is_null($id_rol))
					{
							if(is_null(RolDAO::getByPK($id_rol)))
									return "El rol con id: ".$id_rol." no existe";
					}
					//valida que la clasificacion del cliente exista en la base de datos
					if(!is_null($id_clasificacion_cliente))
					{
							if(is_null(ClasificacionClienteDAO::getByPK($id_clasificacion_cliente)))
									return "La clasificacion cliente con id: ".$id_clasificacion_cliente." no existe";
					}
					//valida que la clasificacion del proveedor exista en la base de datos
					if(!is_null($id_clasificacion_proveedor))
					{
							if(is_null(ClasificacionProveedorDAO::getByPK($id_clasificacion_proveedor)))
									return "La clasficiacion proveedor con id: ".$id_clasificacion_proveedor." no existe";
					}
					//valida que la moneda exista en la base de datos
					if(!is_null($id_moneda))
					{
				Logger::log("Editando a moneda:".$id_moneda);
							if(is_null(MonedaDAO::getByPK($id_moneda)))
									return "La moneda con id: ".$id_moneda." no existe";
					}
					//valida el nombre
					if(!is_null($nombre))
					{
							$e=ValidacionesController::validarLongitudDeCadena($nombre, 1, 100);
							if(!$e)
									return "El numero de caracteres del nombre (".$nombre.") no esta entre 1 y 100";
					}
					//valida el rfc, el rfc solo puede estar compuesto por Letras mayusculas y numeros
					if(!is_null($rfc))
					{
							$e=ValidacionesController::validarLongitudDeCadena($rfc, 1, 30);
							if(!$e)
									return "El numero de caracteres del rfc (".$rfc.") no esta entre 1 y 30";
							if(preg_match('/[^A-Z0-9]/' ,$rfc))
									return "El rfc ".$rfc." contiene caracteres fuera del rango A-Z y 0-9";
					}
					//valida el curp, el curp solo puede tener letras mayusculas y numeros
					if(!is_null($curp))
					{
							$e=ValidacionesController::validarLongitudDeCadena($curp, 1, 30);
							if(!$e)
									return "El numero de caracteres de la curp (".$curp.") no esta entre 1 y 30";
							if(preg_match('/[^A-Z0-9]/' ,$curp))
									return "El curp ".$curp." contiene caracteres fuera del rango A-Z y 0-9";
					}
					//valida la comision por ventas
					if(!is_null($comision_ventas))
					{
							$e=ValidacionesController::validarNumero($comision_ventas, 0, 100);
							if(!$e)
									return "La comision de ventas (".$comision_ventas.") no esta entre 0 y 100";
					}
					//valida el telefono. Los telefonos solo pueden tener numeros, guiones,parentesis,asteriscos y espacios en blanco
					if(!is_null($telefono_personal1))
					{
							$e=ValidacionesController::validarLongitudDeCadena($telefono_personal1, 1, 20);
							if(!$e)
									return "El numero de caracteres del telefono personal (".$telefono_personal1.") no esta entre 1 y 20";
							if(preg_match('/[^0-9\- \(\)\*]/',$telefono_personal1))
									return "El telefono ".$telefono_personal1." tiene caracteres fuera del rango 0-9,-,(,),* o espacio vacío";
					}
					//valida el telefono. Los telefonos solo pueden tener numeros, guiones,parentesis,asteriscos y espacios en blanco
					if(!is_null($telefono_personal2))
					{
							$e=ValidacionesController::validarLongitudDeCadena($telefono_personal2, 1, 20);
							if(!$e)
									return "El numero de caracteres del telefono personal alterno (".$telefono_personal2.") no esta entre 1 y 20";
							if(preg_match('/[^0-9\- \(\)\*]/',$telefono_personal2))
									return "El telefono ".$telefono_personal2." tiene caracteres fuera del rango 0-9,-,(,),* o espacio vacío";
					}
					//valida el activo. Activo es una variable booleana.
					if(!is_null($activo))
					{
							$e=ValidacionesController::validarEntero($activo, 0, 1);
							if(!$e)
									return "La variable activo (".$activo.") no esta entre 0 y 1";
					}
					//valida el limite de credito
					if(!is_null($limite_credito))
					{
							$e=ValidacionesController::validarNumero($limite_credito, 0, 1.8e200);
							if(!$e)
									return "El limite de credito (".$limite_credito.") no esta entre 0 y 1.8e200";
					}
					//valida el descuento. El descuento es un porcentaje y no puede ser mayor a 100
					if(!is_null($descuento))
					{
							$e=ValidacionesController::validarNumero($descuento, 0, 100);
							if(!$e)
									return "El descuento (".$descuento.") no esta entre 0 y 100";
					}
					//valida el password, El pasword tiene que tener una longitud mayor o igual a 4
					if(!is_null($password))
					{
							$e=ValidacionesController::validarLongitudDeCadena($password, 4, 32);
							if(!$e)
									return "El numero de caracteres del password (".$password.") no esta entre 4 y 32";
					}
					//valida el salario
					if(!is_null($salario))
					{
							$e=ValidacionesController::validarNumero($salario, 0, 1.8e200);
							if(!$e)
									return "El salario (".$salario.") no esta entre 0 y 1.8e200";
					}
					//valida el correo electronico segun las especificaciones de php
					if(!is_null($correo_electronico))
					{
							$e=ValidacionesController::validarLongitudDeCadena($correo_electronico, 3, 30);
							if(!$e)
									return "El numero de caracteres del correo electronico (".$correo_electronico.") no esta entre 3 y 30";
							if(!is_string(filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)))
											return "El correo electronico ".$correo_electronico." no es valido";
					}
					//valida que una pagina web tenga un formato valido.
					if(!is_null($pagina_web))
					{
							$e=ValidacionesController::validarLongitudDeCadena($pagina_web, 2, 30);
							if(!$e)
									return $e;
							if(!preg_match('/^(http|https|ftp):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}'.'((:[0-9]{1,5})?\/.*)?$/i' ,$pagina_web)&&
										!preg_match('/^[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,6}'.'((:[0-9]{1,5})?\/.*)?$/i' ,$pagina_web))
														return "La direccion web ".$pagina_web." no cumple el formato valido";
					}
					//valida el saldo del ejercicio
					if(!is_null($saldo_del_ejercicio))
					{
							$e=ValidacionesController::validarNumero($saldo_del_ejercicio, -1.8e200, 1.8e200);
							if(!$e)
									return "El saldo del ejercicio (".$saldo_del_ejercicio.") no esta entre -1.8e200 y 1.8e200";
					}
					//valida las ventas a credito
					if(!is_null($ventas_a_credito))
					{
							$e=ValidacionesController::validarEntero($ventas_a_credito, 0, PHP_INT_MAX);
							if(!$e)
									return "Las venta a credito no estan entre 0 y ".PHP_INT_MAX;
					}
					//valida el represnetante legal
					if(!is_null($representante_legal))
					{
							$e=ValidacionesController::validarLongitudDeCadena($representante_legal, 0, 100);
							if(!$e)
									return "El numero de caracteres del representante legal (".$representante_legal.") no esta entre 0 y 100";
					}
					//valida la facturacion a terceros. Es un boleano
					if(!is_null($facturar_a_terceros))
					{
							$e=ValidacionesController::validarEntero($facturar_a_terceros, 0, 1);
							if(!$e)
									return "La variable facturar a terceros (".$facturar_a_terceros.") no esta entre 0 y 1";
					}
					//valida los dias de pago
					if(!is_null($dia_de_pago))
					{
							$e=ValidacionesController::validarLongitudDeCadena($dia_de_pago, 19, 19);
							if(!$e)
									return "La fecha de dia de pago (".$dia_de_pago.") es invalida, el formato valido es YYYY-MM-dd HH:mm:ss";
					}
					//valida el boleano mensajeria
					if(!is_null($mensajeria))
					{
							$e=ValidacionesController::validarEntero($mensajeria, 0, 1);
							if(!$e)
									return "La variable mensajeria (".$mensajeria.") no esta entre 0 y 1";
					}
					//valida los intereses moratorios
					if(!is_null($intereses_moratorios))
					{
							$e=ValidacionesController::validarNumero($intereses_moratorios, 0, 1.8e200);
							if(!$e)
									return "Los intereses moratorios (".$intereses_moratorios.") no estan entre 0 y 1.8e200";
					}
					//valida la denominacion comercial
					if(!is_null($denominacion_comercial))
					{
							$e=ValidacionesController::validarLongitudDeCadena($denominacion_comercial, 0, 100);
							if(!$e)
									return "El numero de caracteres de la denominacion comercial (".$denominacion_comercial.") no esta entre 0 y 100";
					}
					//valida los dias de credito
					if(!is_null($dias_de_credito))
					{
							$e=ValidacionesController::validarEntero($dias_de_credito, 0, PHP_INT_MAX);
							if(!$e)
									return "Los dias de credito (".$dias_de_credito.") no estan en el rango de 0 a ".PHP_INT_MAX;
					}
					//valida la cuenta de mensajeria
					if(!is_null($cuenta_de_mensajeria))
					{
							$e=ValidacionesController::validarLongitudDeCadena($cuenta_de_mensajeria, 0, 50);
							if(!$e)
									return "El numero de caracteres de la cuenta de mensajeria (".$cuenta_de_mensajeria.") no etsa entre 0 y 50";
					}
					//valida lso dias de revision
					if(!is_null($dia_de_revision))
					{
							$e=ValidacionesController::validarLongitudDeCadena($dia_de_revision, 19, 19);
							if(!$e)
									return "El dia de revision (".$dia_de_revision.") no tiene el formato apropiado, el formato valido es YYYY-MM-dd HH:mm:ss";
					}
					//valida el codigo de usuario
					if(!is_null($codigo_usuario))
					{
							$e=ValidacionesController::validarLongitudDeCadena($codigo_usuario, 1, 50);
							if(!$e)
									return "El numero de caracteres del codigo de usuario no esta entre 1 y 50";
							if(preg_match('/[^a-zA-Z0-9]/', $codigo_usuario))
											return "El codigo de usuario (".$codigo_usuario.") no tiene solo caracteres alfanumericos";
					}
					//valida los dias de embarque
					if(!is_null($dias_de_embarque))
					{
							$e=ValidacionesController::validarEntero($dias_de_embarque, 0, PHP_INT_MAX);
							if(!$e)
									return "Los dias de embarque (".$dias_de_embarque.") no esta entre 0 y ".PHP_INT_MAX;
					}
					//valida el tiempo de entrega
					if(!is_null($tiempo_entrega))
					{
							$e=ValidacionesController::validarEntero($tiempo_entrega, 0, PHP_INT_MAX);
							if(!$e)
									return "El tiempo de entrega (".$tiempo_entrega.") no esta entre 0 y ".PHP_INT_MAX;
					}
					//valida la cuenta bancaria
					if(!is_null($cuenta_bancaria))
					{
							$e=ValidacionesController::validarLongitudDeCadena($cuenta_bancaria, 0, 50);
							if(!$e)
									return "El numero de caracteres de la cuenta bancaria (".$cuenta_bancaria.") no esta entre 0 y 50";
					}
					//valida que la tarifa de compra sea valida
					if(!is_null($id_tarifa_compra))
					{
							$tarifa = TarifaDAO::getByPK($id_tarifa_compra);
							if(is_null($tarifa))
							{
									return "La tarifa ".$id_tarifa_compra." no existe";
							}

							if(!$tarifa->getActiva())
							{
									return "La tarifa ".$id_tarifa_compra." no esta activa";
							}

							if($tarifa->getTipoTarifa()!="compra")
							{
									return "La tarifa ".$id_tarifa_compra." no es una tarifa de compra";
							}
					}
					//valida que la tarifa de venta sea valida
					if(!is_null($id_tarifa_venta))
					{
							$tarifa = TarifaDAO::getByPK($id_tarifa_venta);
							if(is_null($tarifa))
							{
									return "La tarifa ".$id_tarifa_venta." no existe";
							}

							if(!$tarifa->getActiva())
							{
									return "La tarifa ".$id_tarifa_venta." no esta activa";
							}

							if($tarifa->getTipoTarifa()!="venta")
							{
									return "La tarifa ".$id_tarifa_venta." no es una tarifa de venta";
							}
					}
					//valida que el usuario padre exista y este activo
					if(!is_null($id_usuario_padre))
					{
							$usuario_padre = UsuarioDAO::getByPK($id_usuario_padre);
							if(is_null($usuario_padre))
							{
									return "El usuario padre ".$id_usuario_padre." no existe";
							}
							if($usuario_padre->getActivo())
							{
									return "El usuario padre ".$usuario_padre->getNombre()." no esta activo";
							}
					}
					return true;
			}


			/*
			 * Valida los campos de la tabla Impuesto_usuario
			 * Regresa true cuando son validos, un string con el error cuando no lo es
			 */
			private static function validarParametrosImpuestoUsuario
			(
							$id_impuesto = null,
							$id_usuario = null
			)
			{
					//valida que el impuesto exista en la base de datos
				if(!is_null($id_impuesto))
				{
						if(is_null(ImpuestoDAO::getByPK($id_impuesto)))
						{
								return "El impuesto con id: ".$id_impuesto." no existe";
						}
				}
				//valida que el usuario exista en la base de datos
				if(!is_null($id_usuario))
				{
						if(is_null(UsuarioDAO::getByPK($id_usuario)))
						{
								return "El usuario con id: ".$id_usuario." no existe";
						}
				}
				return true;
			}


			/*
			 * Valida los campos de al tabla retencion_usuario
			 * Regresa true cuando son validos, un string con el error cuando no lo es
			 */
			private static function validarParametrosRetencionUsuario
			(
							$id_retencion = null,
							$id_usuario = null
			)
			{
					//valida que la retencion exista en la base de datos
					if(!is_null($id_retencion))
					{
							if(is_null(RetencionDAO::getByPK($id_retencion)))
							{
									return "La retencion con id: ".$id_retencion." no existe";
							}
					}
					//valida que el usuario exista en la base de datos
					if(!is_null($id_usuario))
					{
							if(is_null(UsuarioDAO::getByPK($id_usuario)))
							{
									return "El usuario con id: ".$id_usuario." no existe";
							}
					}
					return true;
			}

	/**
	 *
	 *Insertar un nuevo usuario. El usuario que lo crea sera tomado de la sesion actual y la fecha sera tomada del servidor. Un usuario no puede tener mas de un rol en una misma sucursal de una misma empresa.
	 *
	 * @param password string Password del usuario
	 * @param id_rol int Id del rol del usuario en la instnacia
	 * @param nombre string Nombre del usuario
	 * @param codigo_usuario string Codigo interno del usuario
	 * @param facturar_a_terceros bool Si el usuario puede facturar a terceros
	 * @param id_sucursal int Id de la sucursal donde fue creado el usuario o donde labora
	 * @param mensajeria bool Si el cliente tiene una cuenta de mensajeria
	 * @param mpuestos json Objeto que contendra los impuestos que afectan a este usuario
	 * @param dia_de_pago string Fecha de pago del cliente
	 * @param cuenta_bancaria string Cuenta bancaria del usuario
	 * @param representante_legal string Nombre del representante legal del usuario
	 * @param saldo_del_ejercicio float Saldo del ejercicio del cliente
	 * @param salario float Si el usuario contara con un salario especial no especificado por el rol
	 * @param intereses_moratorios float Intereses moratorios del cliente
	 * @param ventas_a_credito int Ventas a credito del cliente
	 * @param telefono_personal1 string Telefono personal del usuario
	 * @param descuento float El porcentaje de descuento que se le hara al usuario al venderle
	 * @param pagina_web string Pagina web del usuario
	 * @param limite_credito float El limite de credito del usuario
	 * @param telefno_personal2 string Telefono personal del usuario
	 * @param telefono1_2 string Telefono de la direccion alterna del usuario
	 * @param codigo_postal string Codigo postal del Agente
	 * @param telefono2_2 string Telefono 2 de la direccion al terna del usuario
	 * @param codigo_postal_2 string Codigo postal de la direccion alterna del usuario
	 * @param texto_extra_2 string Texto extra para ubicar la direccion alterna del usuario
	 * @param numero_interior_2 string Numero interior de la direccion alterna del usuario
	 * @param id_ciudad int ID de la ciudad donde vive el agente
	 * @param colonia_2 string Colonia de la direccion alterna del usuario
	 * @param calle string Calle donde vive el agente
	 * @param numero_interior string Numero interior del agente
	 * @param id_ciudad_2 int Id de la ciudad de la direccion alterna del usuario
	 * @param correo_electronico string Correo Electronico del agente
	 * @param texto_extra string Comentario sobre la direccion del agente
	 * @param telefono2 string Otro telefono del agente
	 * @param denominacion_comercial string Denominacion comercial del cliente
	 * @param dias_de_credito int Dias de credito del cliente
	 * @param calle_2 string Calle de la direccion alterna del usuario
	 * @param numero_exterior_2 string Numero exterior de la direccion alterna del usuario
	 * @param telefono1 string Telefono principal del agente
	 * @param dias_de_embarque int Dias de embarque del proveedor ( Lunes, Miercoles, Viernes, etc)
	 * @param numero_exterior string Numero exterior del agente
	 * @param id_clasificacion_cliente int Id de la clasificacion del cliente
	 * @param curp string CURP del agente
	 * @param dia_de_revision string Fecha de revision del cliente
	 * @param cuenta_mensajeria string Cuenta de mensajeria del usuario
	 * @param comision_ventas float El porcentaje de la comision que ganara este usuario especificamente por ventas
	 * @param rfc string RFC del agente
	 * @param id_clasificacion_proveedor int Id de la clasificacion del proveedor
	 * @param colonia string Colonia donde vive el agente
	 * @param retenciones json Ids de las retenciones que afectan a este usuario
	 * @return id_usuario int Id generado por la inserci�n del usuario
	 **/
	public static function NuevoUsuario
	(
		$codigo_usuario,
		$id_rol,
		$nombre,
		$password,
		$comision_ventas = 0,
		$correo_electronico = null,
		$cuenta_bancaria = null,
		$cuenta_mensajeria = null,
		$curp = null,
		$denominacion_comercial = null,
		$descuento = null,
		$dias_de_credito = null,
		$dias_de_embarque = null,
		$dia_de_pago = null,
		$dia_de_revision = null,
		$direcciones = null,
		$facturar_a_terceros = null,
		$id_clasificacion_cliente = null,
		$id_clasificacion_proveedor = null,
		$id_moneda = null,
		$id_sucursal = null,
		$id_tarifa_compra = null,
		$id_tarifa_venta = null,
		$id_usuario_padre = null,
		$impuestos = null,
		$intereses_moratorios = null,
		$limite_credito = 0,
		$mensajeria = null,
		$pagina_web = null,
		$representante_legal = null,
		$retenciones = null,
		$rfc = null,
		$salario = null,
		$saldo_del_ejercicio = null,
		$telefono_personal1 = null,
		$telefono_personal2 = null,
		$tiempo_entrega = null,
		$ventas_a_credito = null
	)
	{
						Logger::log("Creando nuevo usuario `$nombre` ...");
			/*
						$validar = self::validarParametrosUsuario(
					null,
					null,
					$id_sucursal,
					$id_rol,
										$id_clasificacion_cliente,
					$id_clasificacion_proveedor,
					$id_moneda,
										null,
					$nombre,
					$rfc,
					$curp,
					$comision_ventas,
					$telefono_personal1,
										$telefono_personal2,
					$limite_credito,
					$descuento,
					$password,
					$salario,
										$correo_electronico,
					$pagina_web,
					$saldo_del_ejercicio,
					$ventas_a_credito,
										$representante_legal,
					$facturar_a_terceros,
					$dia_de_pago,
					$mensajeria,
										$intereses_moratorios,
					$denominacion_comercial,
					$dias_de_credito,
										$cuenta_mensajeria,
					$dia_de_revision,
					$codigo_usuario,
					$dias_de_embarque,
					$tiempo_entrega,
					$cuenta_bancaria,
										$id_tarifa_compra,
					$id_tarifa_venta,
					$id_usuario_padre);

						//se verifica que la validacion haya sido correcta
						if(is_string($validar))
						{
								Logger::error("Imposible crear a nuevo usuario: " . $validar);
								throw new Exception($validar, 901);
						}
						*/
						//Se verifica que las direcciones recibidas sean un arreglo
						if(!is_null($direcciones))
						{
								if(!is_array($direcciones))
								{
										Logger::error("Las direcciones recibidas no son un arreglo");
										throw new Exception("Las direcciones recibidas no son un arreglo",901);
								}
						}



						//se verifica que el codigo de usuario no sea repetido
						if(!is_null($codigo_usuario))
						{
								$usuarioscod = UsuarioDAO::search(new Usuario(array( "codigo_usuario" => $codigo_usuario )));

								if(sizeof($usuarioscod) > 0)
												throw new Exception("El codigo de usuario ".$codigo_usuario." ya esta en uso",901);

						}





						//se verifica que el rfc no sea repetido
						if(!is_null($rfc))
						{
								$usuariosrfc = UsuarioDAO::search(new Usuario(array( "rfc" => $rfc, "activo" => 1 )));

								if(sizeof($usuariosrfc) > 0) {
									$rfc = null;
									Logger::error("El rfc ".$rfc." ya existe");
									//throw new BusinessLogicException("El rfc ".$rfc." ya existe");
								}

						}

						//se verifica que la curp no sea repetida
						if(!is_null($curp))
						{
								$usuarios=UsuarioDAO::search(new Usuario(array( "curp" => $curp , "activo" => 1)));

								if(sizeof($usuarios) > 0) {
										Logger::error("La curp ".$curp." ya existe");
								}

						}




						//se verifica que los telefonos no sean iguales
						if(!is_null($telefono_personal1) && $telefono_personal1==$telefono_personal2){
								Logger::error("El telefono personal es igual al telefno personal alterno: ".$telefono_personal1."  ".$telefono_personal2);
								//throw new Exception("El telefono personal es igual al telefno personal alterno: ".$telefono_personal1."  ".$telefono_personal2,901);
						}




						//se verifica que el correo electronico no se repita y que sea valido
			if (!is_null($correo_electronico)) {

				if ( !filter_var($correo_electronico, FILTER_VALIDATE_EMAIL) ) {
					$correo_electronico = null ;
					Logger::error("El correo electronico ".$correo_electronico." es invalido");
					throw new InvalidDatabaseOperationException("El correo electronico es invalido");

								} else {
					$usuariose = UsuarioDAO::search(
									new Usuario( array(
										"correo_electronico" => $correo_electronico,
										"activo" => 1 ) ) );

					if (sizeof($usuariose) > 0) {
						throw new BusinessLogicException("El correo ".$correo_electronico." ya esta en uso");
						$correo_electronico = null;
					}

				}

			}




						//se verifica como medida de seguridad que el password no sea igual al codigo de usaurio ni al correo electronico
						if(!is_null($password))
						{
								if($password==$codigo_usuario||$password==$correo_electronico)
								{
										Logger::error("El password (".$password.") no puede ser igual al codigo de usuario (".$codigo_usuario.") ni al correo electronico (".$correo_electronico.")");

										throw new BusinessLogicException("El password (".$password.") no puede ser igual al codigo de usuario (".$codigo_usuario.") ni al correo electronico (".$correo_electronico.")",901);
								}

						}else{
							$password = "alk" .rand(1,9).rand(1,9);

						}




						//se ponen los valores por default en limite de credito y saldo del ejercicio
						if(is_null($limite_credito))
								$limite_credito=0;




					if(is_null($saldo_del_ejercicio))
						$saldo_del_ejercicio = 0;

						//Si la tarifa de compra o de venta es nula, entonces se tomaran las del clasificaciond el cliente, del proveedor o del rol
						// segun esten disponibles

						$origen_compra = "usuario";
						$origen_venta = "usuario";


						//Si la tarifa de venta sigue siendo nula, se toma la default
						if(is_null($id_tarifa_venta))
						{
								$id_tarifa_venta = 1;
						}

						//Si la tarifa de compra sigue siendo nula, se toma la default
						if(is_null($id_tarifa_compra))
						{
								$id_tarifa_compra = 2;
						}

						if (is_null($id_clasificacion_cliente)) {
							$id_categoria_contacto = $id_clasificacion_proveedor;
						} else {
							$id_categoria_contacto = $id_clasificacion_cliente;
						}
						//se crea el objeto usuario con todos los parametros
						$usuario = new Usuario(
							array(
								"id_sucursal"               => $id_sucursal,
								"id_rol"                    => $id_rol,
								"id_perfil"                    => 1,
								"id_clasificacion_cliente"  => $id_clasificacion_cliente,
								"id_clasificacion_proveedor"=> $id_clasificacion_proveedor,
								"id_categoria_contacto"     => $id_categoria_contacto,
								"id_moneda"                 => $id_moneda,
								"fecha_asignacion_rol"      => time(),
								"nombre"                    => $nombre,
								"rfc"                       => $rfc,
								"curp"                      => $curp,
								"comision_ventas"           => $comision_ventas,
								"telefono_personal1"        => $telefono_personal1,
								"telefono_personal2"        => $telefono_personal2,
								"fecha_alta"                => time(),
								"activo"                    => 1,
								"limite_credito"            => $limite_credito,
								"descuento"                 => $descuento,
								"password"                  => hash("md5",$password),
								"salario"                   => $salario,
								"correo_electronico"        => $correo_electronico,
								"pagina_web"                => $pagina_web,
								"saldo_del_ejercicio"       => $saldo_del_ejercicio,
								"ventas_a_credito"          => $ventas_a_credito,
								"representante_legal"       => $representante_legal,
								"facturar_a_terceros"       => $facturar_a_terceros,
								"mensajeria"                => $mensajeria,
								"intereses_moratorios"      => $intereses_moratorios,
								"denominacion_comercial"    => $denominacion_comercial,
								"dias_de_credito"           => $dias_de_credito,
								"cuenta_de_mensajeria"      => $cuenta_mensajeria,
								"codigo_usuario"            => $codigo_usuario,
								"dias_de_embarque"          => $dias_de_embarque,
								"tiempo_entrega"            => $tiempo_entrega,
								"cuenta_bancaria"           => $cuenta_bancaria,
								"consignatario"             => 0,
								"id_tarifa_compra"          => $id_tarifa_compra,
								"id_tarifa_venta"           => $id_tarifa_venta,
								"tarifa_compra_obtenida"    => $origen_compra,
								"tarifa_venta_obtenida"     => $origen_venta,
								"id_usuario_padre"          => $id_usuario_padre
							)
						);



						DAO::transBegin();
						try
						{



								//Se crean las direcciones recibidas
								if(!is_null($direcciones))
								{
										foreach($direcciones as $d)
										{

						if(!is_array($d)){
							$d = object_to_array($d);
						}

						if(!is_array($d)){
							throw new InvalidDataException("Las direcciones deben ser un arreglo de arreglos.");
						}



												$address_id = DireccionController::NuevaDireccion(
												$calle 				= isset($d["calle"]) ? $d["calle"] : null,
												$numero_exterior	= isset($d["numero_exterior"]) ? $d["numero_exterior"] : null,
												$colonia			= isset($d["colonia"]) ? $d["colonia"] : null,
												$id_ciudad			= isset($d["id_ciudad"]) ? $d["id_ciudad"] : null,
												$codigo_postal		= isset($d["codigo_postal"]) ? $d["codigo_postal"] : null,
												$numero_interior	= isset($d["numero_interior"]) ? $d["numero_interior"] : null,
												$referencia			= isset($d["referencia"]) ? $d["referencia"] : null,
												$telefono			= isset($d["telefono1"]) ? $d["telefono1"] : null,
												$telefono2			= isset($d["telefono2"]) ? $d["telefono2"] : null);

						$usuario->setIdDireccion( $address_id );
										}
								}

								//Se guarda el usuario creado.
								UsuarioDAO::save($usuario);

								//si se pasaron impuestos, se validan y se agregan a la tabla impuesto_usuario
								if(!is_null($impuestos))
								{

										$impuestos = object_to_array($impuestos);

										if(!is_array($impuestos))
										{
												throw new Exception("Los impuestos no fueron recibidos correctamente",901);
										}

										foreach($impuestos as $id_impuesto)
										{
												$validar=self::validarParametrosImpuestoUsuario($id_impuesto);
												if(is_string($validar))
														throw new Exception($validar,901);
												ImpuestoUsuarioDAO::save(new ImpuestoUsuario(array( "id_impuesto" => $id_impuesto , "id_usuario" => $usuario->getIdUsuario())));
										}
								}

								//si se pasaron retenciones, se validan y se agregan a la tabla retencion_usuario
								if(!is_null($retenciones))
								{

										$retenciones = object_to_array($retenciones);

										if(!is_array($retenciones))
										{
												throw new Exception("Las retenciones no fueron recibidas correctamente",901);
										}

										foreach($retenciones as $id_retencion)
										{
												$validar=self::validarParametrosRetencionUsuario($id_retencion);
												if(is_string($validar))
														throw new Exception($validar,901);
												RetencionUsuarioDAO::save(new RetencionUsuario(array( "id_retencion" => $id_retencion , "id_usuario" => $usuario->getIdUsuario() )));
										}
								}

								//Se buscan los permisos de este rol y se le asignan a este usuario
								$permisos_rol = PermisoRolDAO::search( new PermisoRol( array( "id_rol" => $id_rol ) ) );
								foreach($permisos_rol as $permiso_rol)
								{
										PermisoUsuarioDAO::save( new PermisoUsuario( array( "id_usuario" => $usuario->getIdUsuario() , "id_permiso" => $permiso_rol->getIdPermiso() ) ) );
								}
						}
						catch(BusinessLogicExceptoin $ble){
							throw $ble;
						}
						catch(Exception $e)
						{
								DAO::transRollback();
								Logger::error("No se pudo crear al usuario: ".$e);
								if($e->getCode()==901)
										throw new Exception("No se pudo crear al usuario: ".$e->getMessage(),901);
								throw new Exception("No se pudo crear al usuario, consulte a su administrador de sistema",901);
						}
						DAO::transEnd();
						Logger::log("Usuario creado exitosamente con id".$usuario->getIdUsuario());








						return array( "id_usuario" => $usuario->getIdUsuario() );
	}










	/**
	 *
	 *Listar a todos los usuarios del sistema. Se puede ordenar por los atributos del usuario y filtrar en activos e inactivos
	 *
	 * @param activo bool True si se mostrarn solo los usuarios activos, false si solo se mostrarn los usuarios inactivos
	 * @param ordenar json Valor numrico que indicar la forma en que se ordenar la lista
	 * @return usuarios json Arreglo de objetos que contendr� la informaci�n de los usuarios del sistema
	 **/
	public static function ListaUsuario
	(
		$activo = null,
		$ordenar = null
	)
	{
						//valida el parametro activo.
						$validar=self::validarParametrosUsuario(null, null, null, null, null, null, null, $activo);
						if(is_string($validar))
						{
								Logger::error($validar);
								throw new Exception($validar,901);
						}



						//inicializamos el arreglo que contendra la lista.
						$usuarios=array();

						//Si se paso el parametro activo, se llama al metodo search
						if(is_null($activo))  $activo = 1;

						$usuarios = UsuarioDAO::buscarEmpleados( null, 5000, $activo );

						return array("numero_de_resultados" => sizeof($usuarios),
						"resultados" => $usuarios);
	}





	public static function EditarObj(UsuarioDAO $usuario, DireccionDAO $direccion){

	}


	/**
	 *
	 *Editar los detalles de un usuario.
	 *
	 * @param id_usuario int Usuario a editar
	 * @param colonia_2 string Colonia de la direccion alterna del usuario
	 * @param id_rol int Id rol del usuario
	 * @param salario float Si el usuario contara con un salario no establecido por el rol
	 * @param descuento float Descuento que se le hara al usuario al venderle
	 * @param telefono_personal_1 string telefono personal del usuario
	 * @param limite_de_credito float Limite de credito del usuario
	 * @param pagina_web string Pagina web del usuario
	 * @param telefono2_2 string telefono2 de la direccion alterna del usuario
	 * @param facturar_a_terceros bool Si el usuario puede facturar a terceros
	 * @param mensajeria bool Si el usuario tiene una cuenta de mensajeria
	 * @param telefono_personal_2 string Telefono personal alterno del usuario
	 * @param ventas_a_credito int Ventas a credito del cliente
	 * @param texto_extra_2 string Texto extra para ubicar la direccion alterna del usuario
	 * @param impuestos json Objeto que contendra los ids de los impuestos que afectan a este usuario
	 * @param retenciones json Ids de las retenciones que afectan a este usuario
	 * @param saldo_del_ejercicio float Saldo del ejercicio del cliente
	 * @param id_ciudad_2 int Id de la ciudad de la direccion alterna del usuario
	 * @param dia_de_pago string Fecha de pago del cliente
	 * @param calle string calle del domicilio del usuario
	 * @param numero_interior_2 string Numero interior de la direccion alterna del usuario
	 * @param codigo_postal string Codigo Postal del domicilio del usuario
	 * @param texto_extra string Referencia del domicilio del usuario
	 * @param numero_interior string Numero interior del domicilio del usuario
	 * @param id_ciudad int Id de la ciudad del domicilio del usuario
	 * @param password string Password del usuario
	 * @param id_clasificacion_proveedor int Id de la clasificacion del proveedor
	 * @param codigo_usuario string Codigo interno del usuario
	 * @param nombre string Nombre del usuario
	 * @param colonia string Colonia donde vive el usuario
	 * @param comision_ventas float El porcentaje que gana como comision por ventas este usuario
	 * @param correo_electronico string correo electronico del usuario
	 * @param representante_legal string Nombre del representante legal del usuario
	 * @param calle_2 string Calle de la direccion alterna del usuario
	 * @param dias_de_embarque int Dias de emabrque del proveedor ( Lunes, Miercoles, etc)
	 * @param telefono2 string Otro telefono de la direccion del usuario
	 * @param dias_de_credito int Dias de credito del cliente
	 * @param rfc string RFC del usuario
	 * @param curp string CURP del usuario
	 * @param numero_exterior_2 string Numero exterior de la direccion alterna del usuario
	 * @param numero_exterior string Numero exterior del domicilio del usuario
	 * @param denominacion_comercial string Denominacion comercial del cliente
	 * @param descuento_es_porcentaje bool Si el descuento es un porcentaje o es un valor fijo
	 * @param id_clasificacion_cliente int Id de la clasificacion del cliente
	 * @param cuenta_bancaria string Cuenta bancaria del usuario
	 * @param dia_de_revision string Fecha de revision del cliente
	 * @param cuenta_mensajeria string Cuenta de mensajeria del usuario
	 * @param telefono1 string Telefono del usuario
	 * @param codigo_postal_2 string Codigo postal de la direccion alterna del usuario
	 * @param id_sucursal int Id de la sucursal en la que fue creada este usuario o donde labora.
	 * @param telefono1_2 string Telefono de la direccion alterna del usuario
	 * @param intereses_moratorios float Intereses moratorios del cliente
	 **/
	public static function EditarUsuario
	(
		$id_usuario,
		$codigo_usuario = null,
		$comision_ventas = null,
		$correo_electronico = null,
		$cuenta_bancaria = null,
		$cuenta_mensajeria = null,
		$curp = null,
		$denominacion_comercial = null,
		$descuento = null,
		$descuento_es_porcentaje = null,
		$dias_de_credito = null,
		$dias_de_embarque = null,
		$dia_de_pago = null,
		$dia_de_revision = null,
		$direcciones = null,
		$facturar_a_terceros = null,
		$id_clasificacion_cliente = null,
		$id_clasificacion_proveedor = null,
		$id_moneda = null,
		$id_rol = null,
		$id_sucursal = null,
		$id_tarifa_compra = null,
		$id_tarifa_venta = null,
		$id_usuario_padre = null,
		$impuestos = null,
		$intereses_moratorios = null,
		$limite_de_credito = null,
		$mensajeria = null,
		$nombre = null,
		$pagina_web = null,
		$password = null,
		$representante_legal = null,
		$retenciones = null,
		$rfc = null,
		$salario = null,
		$saldo_del_ejercicio = null,
		$telefono_personal_1 = null,
		$telefono_personal_2 = null,
		$tiempo_entrega = null,
		$ventas_a_credito = null
	)
	{
						Logger::log("Editando usuario: ".$id_usuario);

						//valida los parametros de la tabla usuario

			/*$validar=self::validarParametrosUsuario($id_usuario, null, $id_sucursal, $id_rol,
										$id_clasificacion_cliente, $id_clasificacion_proveedor, $id_moneda,
										null, $nombre, $rfc, $curp, $comision_ventas, $telefono_personal_1,
										$telefono_personal_2, $limite_de_credito, $descuento, $password, $salario,
										$correo_electronico,$pagina_web,$saldo_del_ejercicio,$ventas_a_credito,
										$representante_legal,$facturar_a_terceros,$dia_de_pago,$mensajeria,
										$intereses_moratorios,$denominacion_comercial,$dias_de_credito,
										$cuenta_mensajeria,$dia_de_revision,$codigo_usuario,$dias_de_embarque,$tiempo_entrega,$cuenta_bancaria,
										$id_tarifa_compra,$id_tarifa_venta,$id_usuario_padre);
						if(is_string($validar))
						{
								Logger::error($validar);
								throw new Exception($validar,901);
						}
			*/



						//Se trae el registro con el id obtenido
						$usuario = UsuarioDAO::getByPK($id_usuario);

						//bandera que indica si el rol se cambio o no.
						$cambio_rol = false;


						// se validan los campos, si no son nulos, se cambia el registro.
					if(!is_null($id_sucursal))
					{
							$usuario->setIdSucursal($id_sucursal);
					}


					if(!is_null($id_rol))
					{
							if($usuario->getIdRol()!=$id_rol)
							{
									//Si el usuario obtuvo la tarifa de compra o de venta del rol anterior, se actualiza su tarifa tambien
								$rol_nuevo = RolDAO::getByPK($id_rol);
								if($usuario->getTarifaCompraObtenida()=="rol")
								{
										$usuario->setIdTarifaCompra($rol_nuevo->getIdTarifaCompra());
								}
								if($usuario->getTarifaVentaObtenida()=="rol")
								{
										$usuario->setIdTarifaVenta($rol_nuevo->getIdTarifaVenta());
								}
								$usuario->setIdRol($id_rol);
								$usuario->setFechaAsignacionRol(time());
							}
					}



					if(!is_null($id_clasificacion_cliente))
					{
							$usuario->setIdCategoriaContacto($id_clasificacion_cliente);

							//Si el usuario obtuvo su tarifa de compra o de venta de la clasificacion de cliente, de proveedor o de rol,
							//entonces se tiene que actualizar
							if( $usuario->getTarifaCompraObtenida()!="usuario" )
							{
								$clasificacion_cliente = CategoriaContactoDAO::getByPK($id_clasificacion_cliente);
								$usuario->setIdTarifaCompra($clasificacion_cliente->getIdTarifaCompra());
								$usuario->setTarifaCompraObtenida("cliente");
							}
							if( $usuario->getTarifaVentaObtenida()!="usuario" )
							{
								$clasificacion_cliente = CategoriaContactoDAO::getByPK($id_clasificacion_cliente);
								$usuario->setIdTarifaVenta($clasificacion_cliente->getIdTarifaVenta());
								$usuario->setTarifaVentaObtenida("cliente");
							}

					}




					if(!is_null($id_clasificacion_proveedor))
					{
							$usuario->setIdCategoriaContacto($id_clasificacion_proveedor);

							//Si el usuario obtuvo su tarifa de compra o venta de la clasificacion de proveedor o del rol,
							//entonces se tiene que actualizar
							if($usuario->getTarifaCompraObtenida() == "rol" || $usuario->getTarifaCompraObtenida() == "proveedor")
							{
								$clasificacion_proveedor = CategoriaContactoDAO::getByPK($id_clasificacion_proveedor);
								$usuario->setIdTarifaCompra($clasificacion_proveedor->getIdTarifaCompra());
								$usuario->setTarifaCompraObtenida("proveedor");
							}
							if($usuario->getTarifaVentaObtenida() == "rol" || $usuario->getTarifaVentaObtenida() == "proveedor")
							{
								$clasificacion_proveedor = CategoriaContactoDAO::getByPK($id_clasificacion_proveedor);
								$usuario->setIdTarifaVenta($clasificacion_proveedor->getIdTarifaVenta());
								$usuario->setTarifaVentaObtenida("proveedor");
							}
					}


					if(!is_null($id_moneda))
					{
							$usuario->setIdMoneda($id_moneda);
					}
					if(!is_null($nombre))
					{
							$usuario->setNombre($nombre);
			}

			if (!is_null($rfc)) {

				$usuarios = array_diff(UsuarioDAO::search( new Usuario(array( "rfc" => $rfc ) ) ), array(UsuarioDAO::getByPK($id_usuario)));

				foreach($usuarios as $u) {
					if($u->getActivo()) {
												Logger::error("El rfc de usuario ".$rfc." ya esta en uso");
												throw new Exception("El rfc de usuario ".$rfc ." ya esta en uso",901);
										}
								}
							$usuario->setRfc($rfc);
					}
					if(!is_null($curp))
					{
							$usuarios=array_diff(UsuarioDAO::search(new Usuario(array( "curp" => $curp ))),array( UsuarioDAO::getByPK($id_usuario) ));
								foreach($usuarios as $u)
								{
										if($u->getActivo())
										{
												Logger::error("La curp ".$curp." ya existe");
												throw new Exception("La curp ".$curp." ya existe",901);
										}
								}
							$usuario->setCurp($curp);
					}
					if(!is_null($comision_ventas))
					{
							$usuario->setComisionVentas($comision_ventas);
					}
					if(!is_null($telefono_personal_1))
					{
							$usuario->setTelefonoPersonal1($telefono_personal_1);
					}
					if(!is_null($telefono_personal_2))
					{
							$usuario->setTelefonoPersonal2($telefono_personal_2);
					}
					if(!is_null($limite_de_credito))
					{
							$usuario->setLimiteCredito($limite_de_credito);
					}
					if(!is_null($descuento))
					{
							$usuario->setDescuento($descuento);
					}
					if(!is_null($password))
					{
							$usuario->setPassword(hash("md5",$password));
					}
					if(!is_null($salario))
					{
							$usuario->setSalario($salario);
					}
					if(!is_null($correo_electronico))
					{
							//se verifica que el correo electronico no se repita
								$usuarios=array_diff(UsuarioDAO::search(new Usuario( array( "correo_electronico" => $correo_electronico ) )), array(UsuarioDAO::getByPK($id_usuario)) );
								foreach($usuarios as $u)
								{
										if($u->getActivo())
										{
												Logger::error("El correo electronico ".$correo_electronico." ya esta en uso");
												throw new Exception("El correo electronico ".$correo_electronico." ya esta en uso",901);
										}
								}
							$usuario->setCorreoElectronico($correo_electronico);
					}
					if(!is_null($pagina_web))
					{
							$usuario->setPaginaWeb($pagina_web);
					}
					if(!is_null($saldo_del_ejercicio))
					{
							$usuario->setSaldoDelEjercicio($saldo_del_ejercicio);
					}
					if(!is_null($ventas_a_credito))
					{
							$usuario->setVentasACredito($ventas_a_credito);
					}
					if(!is_null($representante_legal))
					{
							$usuario->setRepresentanteLegal($representante_legal);
					}
					if(!is_null($facturar_a_terceros))
					{
							$usuario->setFacturarATerceros($facturar_a_terceros);
					}
					if(!is_null($dia_de_pago))
					{
							$usuario->setDiaDePago($dia_de_pago);
					}
					if(!is_null($mensajeria))
					{
							$usuario->setMensajeria($mensajeria);
					}
					if(!is_null($intereses_moratorios))
					{
							$usuario->setInteresesMoratorios($intereses_moratorios);
					}
					if(!is_null($denominacion_comercial))
					{
							$usuario->setDenominacionComercial($denominacion_comercial);
					}
					if(!is_null($dias_de_credito))
					{
							$usuario->setDiasDeCredito($dias_de_credito);
					}
					if(!is_null($cuenta_mensajeria))
					{
							$usuario->setCuentaDeMensajeria($cuenta_mensajeria);
					}
					if(!is_null($dia_de_revision))
					{
							$usuario->setDiaDeRevision($dia_de_revision);
					}
					if(!is_null($codigo_usuario))
					{
								//se verifica que el codigo de usuario no sea repetido
								$usuarios=array_diff(UsuarioDAO::search(new Usuario(array( "codigo_usuario" => $codigo_usuario ))), array(UsuarioDAO::getByPK($id_usuario)));
								foreach($usuarios as $u)
								{
										if($u->getActivo())
										{
												Logger::error("El codigo de usuario ".$codigo_usuario." ya esta en uso");
												throw new Exception("El codigo de usuario ".$codigo_usuario." ya esta en uso",901);
										}
								}
							$usuario->setCodigoUsuario($codigo_usuario);
					}
					if(!is_null($dias_de_embarque))
					{
							$usuario->setDiasDeEmbarque($dias_de_embarque);
					}
					if(!is_null($tiempo_entrega))
					{
							$usuario->setTiempoEntrega($tiempo_entrega);
					}
					if(!is_null($cuenta_bancaria))
					{
							$usuario->setCuentaBancaria($cuenta_bancaria);
					}

						//se verifica como medida de seguridad que el password no sea igual al codigo de usaurio ni al correo electronico
					if(!is_null($usuario->getPassword()))
					{
								if($usuario->getPassword()==$usuario->getCodigoUsuario()||$usuario->getPassword()==$usuario->getCorreoElectronico())
								{
										Logger::error("El password (".$usuario->getPassword().") no puede ser igual al codigo de usuario
												(".$usuario->getCodigoUsuario().") ni al correo electronico (".$usuario->getCorreoElectronico().")");
										throw new Exception("El password (".$usuario->getPassword().") no puede ser igual al codigo de usuario
												(".$usuario->getCodigoUsuario().") ni al correo electronico (".$usuario->getCorreoElectronico().")",901);
								}
					}
						if(!is_null($id_tarifa_compra))
						{
								$usuario->setIdTarifaCompra($id_tarifa_compra);
								$usuario->setTarifaCompraObtenida("usuario");
						}
						if(!is_null($id_tarifa_venta))
						{
								$usuario->setIdTarifaVenta($id_tarifa_venta);
								$usuario->setTarifaVentaObtenida("usuario");
						}


						DAO::transBegin();
						try
						{

								//guarda los cambios en el usuario
								UsuarioDAO::save($usuario);

								//Si se reciben direcciones, se borran todas las direcciones de este usuario y se agregan las recibidas.
								if(!is_null($direcciones))
								{

					Logger::log("Editando direcciones...");

										if(!is_array($direcciones))
										{
												throw new Exception("Las direcciones recibidas no son un arreglo",901);
										}

										//Se crean las direcciones recibidas
										foreach($direcciones as $d)
										{
												//Se envia la direccion a editar
						DireccionController::EditarDireccion($d);
										}
								}

								//si se han obtenido nuevos impuestos se llama al metodo save para que actualice
								//los ya existentes y almacene los nuevos
/*
								if(!is_null($impuestos))
								{
										 $impuestos = object_to_array($impuestos);

										if(!is_array($impuestos))
										{
												throw new Exception("Los impuestos no fueron recibidos correctamente",901);
										}


										foreach($impuestos as $id_impuesto)
										{
												ImpuestoUsuarioDAO::save(new ImpuestoUsuario( array( "id_impuesto" => $id_impuesto , "id_usuario" => $id_usuario ) ));
										}

										//Se obtiene la lista de impuestos correspondientes a este usuario y se buscan aquellos
										//que no esten incluidos en la nueva lista obtenida de impuestos para eliminarlos.
										$impuestos_usuario = ImpuestoUsuarioDAO::search( new ImpuestoUsuario( array( "id_usuario" => $id_usuario ) ));
										foreach($impuestos_usuario as $impuesto_usuario)
										{
												$encontrado=false;
												foreach($impuestos as $id_impuesto)
												{
														if($id_impuesto == $impuesto_usuario->getIdImpuesto())
														{
																$encontrado = true;
														}
												}
												if(!$encontrado)
												{
														ImpuestoUsuarioDAO::delete($impuesto_usuario);
												}
										}
								}

								//si se han obtenido nuevas retenciones se llama al metodo save para que actualice
								//las ya existentes y almacene las nuevas
								if(!is_null($retenciones))
								{

										$retenciones = object_to_array($retenciones);

										if(!is_array($retenciones))
										{
												throw new Exception("Las retenciones no fueron recibidas correctamente",901);
										}

										foreach($retenciones as $id_retencion)
										{
												RetencionUsuarioDAO::save(new RetencionUsuario( array( "id_retencion" => $id_retencion , "id_usuario" => $id_usuario ) ));
										}

										//Se obtiene la lista de retenciones correspondientes a este usuario y se buscan aquellas
										//que no esten incluidas en la nueva lista obtenida de retenciones para eliminarlas.
										$retenciones_usuario = RetencionUsuarioDAO::search( new RetencionUsuario( array( "id_usuario" => $id_usuario ) ));
										foreach($retenciones_usuario as $retencion_usuario)
										{
												$encontrado=false;
												foreach($retenciones as $id_retencion)
												{
														if($id_retencion == $retencion_usuario->getIdRetencion())
														{
																$encontrado = true;
														}
												}
												if(!$encontrado)
												{
														RetencionUsuarioDAO::delete($retencion_usuario);
												}
										}
								}
*/
								//Si cambio el rol, se borran todos los permisos del usuario y se le asignan los
								//permisos del nuevo rol.
								$permisos_usuario = PermisoUsuarioDAO::search( new PermisoUsuario( array( "id_usuario" => $id_usuario ) ) );
								foreach($permisos_usuario as $permiso_usuario)
								{
										PermisoUsuarioDAO::delete($permiso_usuario);
								}
								$permisos_rol = PermisoRolDAO::search( new PermisoRol( array( "id_rol" => $id_rol ) ) );
								foreach($permisos_rol as $permiso_rol)
								{
										PermisoUsuarioDAO::save( new PermisoUsuario( array( "id_usuario" => $id_usuario , "id_permiso" => $permiso_rol->getIdPermiso() ) ) );
								}
						}
						catch(Exception $e)
						{
								DAO::transRollback();
								Logger::error("El usuario ".$id_usuario." no ha podido se editado: ".$e);
								if($e->getCode()==901)
										throw new Exception("No se pudo editar al usuario: ".$e->getMessage(),901);
								throw new Exception("No se pudo editar al usuario, consulte a su administrador de sistema",901);
						}
						DAO::transEnd();
						Logger::log("Usuario ".$id_usuario." editado exitosamente");
	}

	/**
	 *
	 *Lista los roles, se puede filtrar y ordenar por sus atributos
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param activa bool Verdadero para mostrar solo los roles activos. En caso de false, se mostraran ambas.
	 * @param limit string Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
	 * @param order string Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
	 * @param order_by string Indica por que campo se ordenan los resultados.
	 * @param query string Valor que se buscara en la consulta
	 * @param start string Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
	 * @return resultados json Arreglo de objetos que contendr las empresas de la instancia
	 * @return numero_de_resultados int Numero de resultados obtenidos
	 **/
	public static function ListaRol
	(
		$activa =  false ,
		$limit = null,
		$order = null,
		$order_by = null,
		$query = null,
		$start = null
	)
	{
		if ($order !== NULL && !($order === "ASC" || $order === "DESC")) {
			Logger::error("Buscar() verifique el valor especificado en order, se esperaba ASC || DESC, se encontro : (" . gettype($order) . ") {$order}");
			return array("success" => false, "reason" => "Buscar() verifique el valor especificado en order, se esperaba ASC || DESC, se encontro : (" . gettype($order) . ") {$order}");
		}

		if ($order_by === NULL) {
			$order_by = "nombre";
		}

		if ($limit !== NULL && !(is_numeric($limit) && $limit >= 0)) {
			Logger::error("Buscar() verifique el valor especificado en limit, se esperaba un int >= 0, se encontro : (" . gettype($limit) . ") {$limit}");
			return array("success" => false, "reason" => "Buscar() verifique el valor especificado en limit, se esperaba un int >= 0, se encontro : (" . gettype($limit) . ") {$limit}");
		}

		if ($start !== NULL && !(is_numeric($start) && $start >= 0)) {
			Logger::error("Buscar() verifique el valor especificado en start, se esperaba un int >= 0, se encontro : (" . gettype($start) . ") {$start}");
			return array("success" => false, "reason" =>"Buscar() verifique el valor especificado en start, se esperaba un int >= 0, se encontro : (" . gettype($start) . ") {$start}");
		}

		if ($start !== NULL && $limit === NULL) {
			Logger::error("Buscar() esta especificando un valor de start, pero no especifica un limit, solo el valor limit se puede usar sin start.");
			return array("success" => false, "reason" => "Buscar() esta especificando un valor de start, pero no especifica un limit, solo el valor limit se puede usar sin start.");
		}

		if (!($start === NULL && $limit === NULL) && ($start > $limit)) {
			Logger::error("Buscar() el valor de start debe ser <= que el valor de limit, se encontro start = {$start}, limit = {$limit}");
			return array("success" => false, "reason" => "Buscar() el valor de start debe ser <= que el valor de limit, se encontro start = {$start}, limit = {$limit}");
		}

		$roles = RolDAO::buscar($limit, $order, $order_by, $query, $start);

		return array("success" => true, "numero_de_resulatos" => count($roles), "resultados" => $roles);
	}

	 /**
	 *
	 *Asigna uno o varios permisos especificos a un usuario. No se pueden asignar permisos que ya se tienen
	 *
	 * @param id_usuario int Id del usuario al que se le asignara el permiso
	 * @param id_permiso int Id del permiso que se le asignaran a este usuario en especial
	 **/
	public static function AsignarPermisoUsuario
	(
		$id_permiso,
		$id_usuario
	)
	{
						Logger::log("Asignando permiso ".$id_permiso." al usuario ".$id_usuario);

						//Se valida que el permiso exista en la base de datos.
						if(is_null(PermisoDAO::getByPK($id_permiso)))
						{
								Logger::error("El permiso con id:".$id_permiso." no existe");
								throw new Exception("El permiso no existe",901);
						}

						//Se valida que el usuario exista en la base de datos.
						$usuario=UsuarioDAO::getByPK($id_usuario);
						if(is_null($usuario))
						{
								Logger::error("El usuario con id:".$id_usuario." no existe");
								throw new Exception("El usuario no existe",901);
						}

						//Si el usuario no esta activo no se le pueden asignar permisos
						if(!$usuario->getActivo())
						{
								Logger::error("El usuario con id:".$id_usuario." esta inactivo");
								throw new Exception("El usuario esta inactivo y no se puede modificar",901);
						}
						DAO::transBegin();
						try
						{
								//se guarda el permiso con el usuario
								PermisoUsuarioDAO::save(new PermisoUsuario( array( "id_permiso" => $id_permiso , "id_usuario" => $id_usuario ) ));
						}
						catch(Exception $e)
						{
								DAO::transRollback();
								Logger::error("No se pudo asignar el permiso al usuario: ".$e);
								throw new Exception("No se pudo asignar el permiso al usuario, consulte a su administrador de sistema",901);
						}
						DAO::transEnd();
						Logger::log("Permiso asignado exitosamente");
	}

	/**
	 *
	 *Este metodo asigna permisos a un rol. Cada vez que se llame a este metodo, se asignaran estos permisos a los usuarios que pertenezcan a este rol.
	 *
	 * @param id_permiso int Arreglo de ids de los permisos que seran asignados al rol
	 * @param id_rol int Id del rol al que se le asignaran los permisos
	 **/
	public static function AsignarPermisoRol
	(
		$id_permiso,
		$id_rol
	)
	{
						Logger::log("Asignando permiso ".$id_permiso." al rol ".$id_rol);

						//Se valida que el permiso exista en la base de datos
						if(is_null(PermisoDAO::getByPK($id_permiso)))
						{
								Logger::error("El permiso con id: ".$id_permiso." no existe");
								throw new Exception("El permiso no existe",901);
						}

						//Se valida que el rol exista en la base de datos
						if(is_null(RolDAO::getByPK($id_rol)))
						{
								Logger::error("El rol con id: ".$id_rol." no existe");
								throw new Exception("El rol no existe",901);
						}

						//Se obtiene la lisa de usuarios que pertenecen a este rol
						$usuarios=UsuarioDAO::search(new Usuario( array( "id_rol" => $id_rol ) ));
						DAO::transBegin();
						try
						{
								//Por cada uno de los usuarios como usuario, se valida si el usuario este activo.
								//Si lo esta, se le asigna el permiso que se le esta asignando al rol.
								foreach($usuarios as $usuario)
								{
										if($usuario->getActivo())
												PermisoUsuarioDAO::save(new PermisoUsuario( array( "id_permiso" => $id_permiso , "id_usuario" => $usuario->getIdUsuario() ) ));
								}

								//Se guarda el permiso al rol.
								PermisoRolDAO::save(new PermisoRol( array( "id_permiso" => $id_permiso , "id_rol" => $id_rol ) ));
						}
						catch(Exception $e)
						{
								DAO::transRollback();
								Logger::error("No se pudo asignar el permiso al rol: ".$e);
								throw new Excpetion("No se pudo asignar el permiso al rol, consulte a su administrador de sistema");
						}
						DAO::transEnd();
						Logger::log("Permiso asignado exitosamente");
	}

	/**
	 *
	 *Este metodo quita un permiso de un rol. Al remover este permiso de un rol, los permisos que un usuario especifico tiene gracias a una asignacion especial se mantienen.
	 *
	 * @param id_permiso int Id del permiso a remover
	 * @param id_rol int Id del rol al que se le quitaran los permisos
	 **/
	public static function RemoverPermisoRol
	(
		$id_permiso,
		$id_rol
	)
	{
						Logger::log("Quitando permiso ".$id_permiso." al rol ".$id_rol);

						//Se valida que ese rol tenga ese permiso
						$permiso_rol = PermisoRolDAO::getByPK($id_permiso, $id_rol);
						if(is_null($permiso_rol))
						{
								Logger::error("El rol ".$id_rol." no tiene el permiso ".$id_permiso);
								throw new Exception("El rol no tiene ese permiso",901);
						}

						//Se obtienen los usuarios de ese rol
						$usuarios = UsuarioDAO::search( new Usuario( array( "id_rol" => $id_rol ) ) );
						DAO::transBegin();
						try
						{
								//Por cada uno de los usuarios como usuario, se busca que el usuario
								//tenga el permiso a remover y que este activo. Si el usuario cumple, se le quita el permiso.
								foreach($usuarios as $usuario)
								{
										if(!is_null(PermisoUsuarioDAO::getByPK($id_permiso, $usuario->getIdUsuario()))&&$usuario->getActivo())
										{
												PermisoUsuarioDAO::delete(new PermisoUsuario( array( "id_permiso" => $id_permiso , "id_usuario" => $usuario->getIdUsuario() ) ));
										}
								}

								//Se quita el permiso al rol
								PermisoRolDAO::delete($permiso_rol);
						}
						catch(Exception $e)
						{
								DAO::transRollback();
						}
						DAO::transEnd();
	}

	/**
	 *
	 *Quita uno o varios permisos a un usuario. No se puede negar un permiso que no se tiene
	 *
	 * @param id_permiso int Id del permiso a quitar de este usuario
	 * @param id_usuario int Id del usuario al que se le niegan los permisos
	 **/
	public static function RemoverPermisoUsuario
	(
		$id_permiso,
		$id_usuario
	)
	{
						Logger::log("Quitando permiso ".$id_permiso." a usuario ".$id_usuario);

						//Se valida que el usuario tenga ese permiso
						$permiso_usuario = PermisoUsuarioDAO::getByPK($id_permiso, $id_usuario);
						if(is_null($permiso_usuario))
						{
								Logger::error("El usuario ".$id_usuario." no tiene el permiso ".$id_permiso);
								throw new Exception("El usuario no tiene ese permiso",901);
						}

						//Se valida que el usuario exista en la base de datos.
						$usuario=UsuarioDAO::getByPK($id_usuario);
						if(is_null($usuario))
						{
								Logger::error("El usuario con id:".$id_usuario." no existe");
								throw new Exception("El usuario no existe",901);
						}

						//Si el usuario no esta activo no se puede cambiar su relacion.
						if(!$usuario->getActivo())
						{
								Logger::error("El usuario con id:".$id_usuario." esta inactivo");
								throw new Exception("El usuario esta inactivo y no se puede modificar",901);
						}
						DAO::transBegin();
						try
						{
								//Borra el permiso del usuario
								PermisoUsuarioDAO::delete($permiso_usuario);
						}
						catch(Exception $e)
						{
								DAO::transRollback();
								Logger::error("No se pudo eliminar el permiso del usuario: ".$e);
								throw new Exception("No se pudo quitar el permiso del usuario, consulte a su administrador de sistema",901);
						}
						DAO::transEnd();
						Logger::log("Permiso eliminado exitosamente");
	}

	/**
	 *
	 *Crea un nuevo grupo de usuarios. Se asignaran los permisos de este grupo al momento de su creacion.
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_perfil int Id del perfil de usuario en el sistema
	 * @param nombre string Nombre del grupo. Este no puede existir en el sistema, no puede ser una cadena vacia y no puede ser mayor a 30 caracteres.
	 * @param descripcion string Descripcion larga del grupo. La descripcion no puede ser una cadena vacia ni mayor a 256 caracteres.
	 * @param id_rol_padre int Id del rol padre
	 * @param id_tarifa_compra int Id de la tarifa de compra por default que aplicara a los usuario de este rol
	 * @param id_tarifa_venta int Id de la tarifa de venta por default que aplicara a los suarios de este rol
	 * @param salario float El salario de este rol.
	 * @return id_rol int El nuero id del rol que se ha generado.
	 **/
	public static function NuevoRol
	(
		$nombre,
		$descripcion = null,
		$id_perfil = null,
		$id_rol_padre = null,
		$id_tarifa_compra = null,
		$id_tarifa_venta = null,
		$salario = "0"
	)
	{
		//verificamos si ya hay un Roll con el mismo nombre
		$nombre = trim($nombre);
		$roles = RolDAO::search(new Rol(array("nombre" => $nombre)));
		if (!empty($roles)) {
			Logger::error("Ya existe un Rol con el mismo nombre");
			throw new Exception("Ya existe un Rol con el mismo nombre",901);
		}

		//validamos si el salario es numerico
		if (!is_numeric($salario)) {
			Logger::error("El salario debe ser un valor numerico");
			throw new Exception("El salario debe ser un valor numerico",901);
		}

		//validamos si el perfil existe y es valido
		if ($id_perfil !== null && $id_perfil !== "" && !PerfilDAO::getByPK($id_perfil)) {
			Logger::error("No se tiene registro del Perfil indicado");
			throw new Exception("No se tiene registro del Perfil indicado",901);
		} elseif ( $id_perfil === "") {
			$id_perfil = null;
		}

		//validamos si se envio un rol Padre y existe
		if ($id_rol_padre !== null && $id_rol_padre !== "" && !RolDAO::getByPK($id_rol_padre)) {
			Logger::error("No se tiene registro del Rol Padre indicado");
			throw new Exception("No se tiene registro del Rol Padre indicado",901);
		} elseif ( $id_rol_padre === "") {
			$id_rol_padre = null;
		}

		//validamos si se envio una tarifa de compra
		if ($id_tarifa_compra !== null && $id_tarifa_compra !== "" && !TarifaDAO::getByPK($id_tarifa_compra)) {
			Logger::error("No se tiene registro de la Tarifa de Compra indicada");
			throw new Exception("No se tiene registro de la Tarifa de Compra indicada",901);
		} elseif ( $id_tarifa_compra === "") {
			$id_tarifa_compra = null;
		}

		//validamos si se envio una tarifa de venta
		if ($id_tarifa_venta !== null && $id_tarifa_venta !== "" && !TarifaDAO::getByPK($id_tarifa_venta)) {
			Logger::error("No se tiene registro de la Tarifa de Venta indicada");
			throw new Exception("No se tiene registro de la Tarifa de Venta indicada",901);
		} elseif ( $id_tarifa_venta === "") {
			$id_tarifa_venta = null;
		}

		//Se inicializa el nuevo rol con los parametros obtenidos
		$rol = new Rol(array(
			"id_rol_padre"		=> $id_rol_padre,
			"nombre"			=> $nombre,
			"descripcion"		=> trim($descripcion),
			"salario"			=> $salario,
			"id_tarifa_compra"	=> $id_tarifa_compra,
			"id_tarifa_venta"	=> $id_tarifa_venta,
			"id_perfil"			=> $id_perfil
		));

		DAO::transBegin();
		try {
			RolDAO::save($rol);
		} catch (Exception $e) {
			DAO::transRollback();
			Logger::error("Error al crear el nuevo rol: ".$e);
			throw new Exception("Error al crear el nuevo rol, consulte a su administrador de sistema",901);
		}

		DAO::transEnd();
		Logger::log("Rol creado exitosamente con id: " . $rol->getIdRol());
		return array( "id_rol" => $rol->getIdRol());
	}

	/**
	 *
	 *Edita la informacion de un grupo, puede usarse para editar los permisos del mismo
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_rol int Id del rol a editar
	 * @param descripcion string Descripcion larga del grupo
	 * @param id_perfil int Id del perfil de usuario en el sistema
	 * @param id_rol_padre int Id del rol padre
	 * @param id_tarifa_compra int Id de la tarifa de compora por default que aplicara a los usuarios de este rol. Si un usuario tiene otra tarifa de compra, no sera sobreescrita
	 * @param id_tarifa_venta int Id de la tarifa de venta por default que aplicara a los usuarios de este rol . Si un usuario ya tiene otra tarifa de venta, no sera sobreescrita.
	 * @param nombre string Nombre del grupo
	 * @param salario float Salario base para este rol
	 **/
	public static function EditarRol
	(
		$id_rol,
		$descripcion = null,
		$id_perfil = null,
		$id_rol_padre = null,
		$id_tarifa_compra = null,
		$id_tarifa_venta = null,
		$nombre = null,
		$salario = "0"
	){
		//verificamos si el rol qeu se quiere editar existe
		if (!$rol = RolDAO::getByPK($id_rol)) {
			Logger::error("No se tiene registro del rol que desea editar");
			throw new Exception("No se tiene registro del rol que desea editar",901);
		}

		//verificamos si ya hay un Roll con el mismo nombre

		if ($nombre !== null && $nombre !== "") {
			$nombre = trim($nombre);
			if ($rol->getNombre() !== $nombre) {
				$roles = RolDAO::search(new Rol(array("nombre" => $nombre)));
				if (!empty($roles)) {
					Logger::error("Ya existe un rol con ese nombre");
					throw new Exception("Ya existe un rol con ese nombre",901);
				} else {
					$rol->setNombre($nombre);
				}
			}
		}

		//validamos si el salario es numerico
		if ($salario !== "0") {
			if (!is_numeric($salario)) {
				Logger::error("El salario debe ser un valor numerico");
				throw new Exception("El salario debe ser un valor numerico",901);
			} else {
				if ($rol->getSalario() !== $salario) {
					$rol->setSalario($salario);
				}
			}
		}

		//validamos si el perfil existe y es valido
		if ($id_perfil !== null && $id_perfil !== "" && !PerfilDAO::getByPK($id_perfil)) {
			Logger::error("No se tiene registro del Perfil indicado");
			throw new Exception("No se tiene registro del Perfil indicado",901);
		} elseif ($id_perfil !== "") {
			$rol->setIdPerfil($id_perfil);
		} elseif ($id_perfil === "") {
			$rol->setIdPerfil(null);
		}

		//validamos si se envio un rol Padre y existe
		if ($id_rol_padre !== null && $id_rol_padre !== "" && !RolDAO::getByPK($id_rol_padre)) {
			Logger::error("No se tiene registro del Rol Padre indicado");
			throw new Exception("No se tiene registro del Rol Padre indicado",901);
		} elseif ( $id_rol_padre !== "") {
			$rol->setIdRolPadre($id_rol_padre);
		} elseif ( $id_rol_padre === "") {
			$rol->setIdRolPadre(null);
		}

		//validamos si se envio una tarifa de compra
		if ($id_tarifa_compra !== null && $id_tarifa_compra !== "" && !TarifaDAO::getByPK($id_tarifa_compra)) {
			Logger::error("No se tiene registro de la Tarifa de Compra indicada");
			throw new Exception("No se tiene registro de la Tarifa de Compra indicada",901);
		} elseif ( $id_tarifa_compra !== "") {
			$rol->setIdTarifaCompra($id_tarifa_compra);
		} elseif ( $id_tarifa_compra === "") {
			$rol->setIdTarifaCompra(null);
		}

		//validamos si se envio una tarifa de venta
		if ($id_tarifa_venta !== null && $id_tarifa_venta !== "" && !TarifaDAO::getByPK($id_tarifa_venta)) {
			Logger::error("No se tiene registro de la Tarifa de Venta indicada");
			throw new Exception("No se tiene registro de la Tarifa de Venta indicada",901);
		} elseif ( $id_tarifa_venta !== "") {
			$rol->setIdTarifaVenta($id_tarifa_venta);
		} elseif ( $id_tarifa_venta === "") {
			$rol->setIdTarifaVenta(null);
		}

		$descripcion = trim($descripcion);
		//Editamos los valores
		if ($descripcion !== null && $descripcion !== "") {
			$rol->setDescripcion($descripcion);
		}

		DAO::transBegin();
		try {
			RolDAO::save($rol);
		} catch (Exception $e) {
			DAO::transRollback();
			Logger::error("Error al modificar el rol: ".$e);
			throw new Exception("Error al crear modificar el rol, consulte a su administrador de sistema",901);
		}

		DAO::transEnd();
		Logger::log("Rol editado exitosamente");
	}

	/**
	 *
	 *Este metodo desactiva un usuario, usese cuando un empleado ya no trabaje para usted. Que pasa cuando el usuario tiene cuentas abiertas o ventas a credito con saldo.
	 *
	 * @param id_usuario int Id del usuario a eliminar
	 **/
	public static function EliminarUsuario
	(
		$id_usuario
	)
	{
						Logger::log("Eliminando usuario ".$id_usuario);

						//Se obtiene y se verifica que el usuario exista en la base de datos.
						$usuario=UsuarioDAO::getByPK($id_usuario);
						if(is_null($usuario))
						{
								Logger::error("El usuario con id ".$id_usuario." no existe");
								throw new Exception("El usuario no existe",901);
						}

						//Si el usuario ya esta inactivo, no se le hacen cambios.
						if(!$usuario->getActivo())
						{
								Logger::warn("El usuario con id: ".$id_usuario." ya esta inactivo");
								throw new Exception("El usuario ya esta inactivo",901);
						}

						//Si el saldo del ejercicio del usuario no es cero, siginifica que debe o que
						//se le debe, entonces no se puede eliminar.
						if($usuario->getSaldoDelEjercicio()!=0)
						{
								Logger::error("El usuario con id: ".$id_usuario." no tiene un saldo en ceros");
								throw new Exception("El usuario no tiene un saldo en ceros",901);
						}

						//Si el usuario tiene una orden de servicio activa, no se puede eliminar
						$ordenes_de_servicio = OrdenDeServicioDAO::search( new OrdenDeServicio( array( "id_usuario_venta" => $id_usuario ) ) );
						foreach($ordenes_de_servicio as $orden_de_servicio)
						{
								if($orden_de_servicio->getActiva())
								{
										Logger::error("El usuario ".$id_usuario." no puede ser desactivado, tiene la orden ".$orden_de_servicio->getIdOrdenDeServicio()." activa");
										throw new Exception("El usuario no puede ser desactivado pues aun cuenta con ordenes de servicio activas",901);
								}
						}

						//Se cambia su estado activo a falso y se le asigna como hoy la fecha de baja.
						$usuario->setActivo(0);
						$usuario->setFechaBaja(time());
						DAO::transBegin();
						try
						{
								//Si el usuario era consignatario se desactiva como tal.
								if($usuario->getConsignatario())
								{
										ConsignacionesController::DesactivarConsignatario($id_usuario);
								}

								//Se actualiza el usuario
								UsuarioDAO::save($usuario);

								//Se eliminan los registros de la tabla permiso_usuario que contengan a este usuario
								$permisos_usuario = PermisoUsuarioDAO::search(new PermisoUsuario( array( "id_usuario" => $id_usuario ) ));
								foreach($permisos_usuario as $permiso_usuario)
								{
										PermisoUsuarioDAO::delete($permiso_usuario);
								}
						}
						catch(Exception $e)
						{
								DAO::transRollback();
								Logger::error("No se pudo eliminar el usuario: ".$e);
								if($e->getCode()==901)
										throw new Exception("No se pudo eliminar el usuario: ".$e->getMessage());
								throw new Exception("No se pudo eliminar el usuario, consulte a su administrador de sistema",901);
						}
						DAO::transEnd();
						Logger::log("Usuario eliminado exitosamente");
	}

	/**
	 *
	 *Este metodo desactiva un grupo, solo se podra desactivar un grupo si no hay ningun usuario que pertenezca a el.
	 *
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_rol int Id del grupo a eliminar
	 **/
	public static function EliminarRol
	(
		$id_rol
	)
	{
		//TODO: Este bloque se tiene que eliminar cuando se arregle perfectamente lo de los perfiles
		{
			//Los roles de administrador (1), gerente (2), cajero(3), cliente (5) y proveedor(6) no pueden ser eliminados
			if(($id_rol>=1&&$id_rol<=3)||$id_rol>=5&&$id_rol<=6)
			{
				Logger::error("El rol predeterminado ".$id_rol." no puede ser eliminado");
				throw new Exception("Los roles predeterminados no pueden ser eliminado",901);
			}
		}

		/*
		 * Se obtiene la lista de usuarios con este rol.
		 * Si almenos uno aun sigue activo, entonces no se puede eliminar el rol
		 */
		$usuarios = UsuarioDAO::search(new Usuario(array( "id_rol" => $id_rol )));

		if(!empty($usuarios))
		{
			Logger::error("No se puede eliminar este rol pues el usuario ".$usuarios[0]->getNombre()." lo tiene asignado");
			throw new Exception("No se puede eliminar este rol pues hay almenos un usuario asignado a el",901);
		}

		DAO::transBegin();

		try {
			//Se elimina el rol
			$to_delete = RolDAO::getByPK( $id_rol );
			RolDAO::delete( $to_delete );
		} catch (Exception $e) {
			DAO::transRollback();
			Logger::error("Error al eliminar el rol: ".$e);
			throw new Exception("Error al eliminar el rol, consulte a su administrador de sistema",901);
		}

		DAO::transEnd();
		Logger::log("Rol eliminado correctamente");
	}

	/**
	 *
	 *Regresa un alista de permisos, nombres y ids de los permisos del sistema.
	 *
	 **/
	public static function ListaPermisoRol
	(
		$id_permiso = null,
		$id_rol = null
	)
	{
						Logger::log("Listando roles con sus permisos");

						//Si se ha obtenido alguno de los parametros, se llama al metodo search.
						//Si no, se llama a getAll.
						if(!is_null($id_rol) || !is_null($id_permiso))
								$permisos_roles = PermisoRolDAO::search(new PermisoRol(array( "id_rol" => $id_rol , "id_permiso" => $id_permiso )));
						else
								$permisos_roles = PermisoRolDAO::getAll();
						Logger::log("Lista de roles con sus permisos obtenida exitosamente con ".count($permisos_roles)." elementos");
						return $permisos_roles;
	}

				public static function ListaPermisoUsuario
				(
			$id_permiso = null,
			$id_usuario = null
				)
				{
						Logger::log("Listando usuarios con sus permisos");

						//Si se ha obtenido alguno de los parametros, se llama al metodo search,
						//si no, se llama a getAll.
						if(!is_null($id_usuario) || !is_null($id_permiso))
								$permisos_usuario = PermisoUsuarioDAO::search(new PermisoUsuario(array( "id_usuario" => $id_usuario , "id_permiso" => $id_permiso )));
						else
								$permisos_usuario = PermisoUsuarioDAO::getAll();
						Logger::log("Lista de usuarios con sus permisos obtenida exitosamente con ".count($permisos_usuario)." elementos");
						return $permisos_usuario;
				}










	/**
	 *
	 *eviar un mail a esa persona para resetear su pass
	 *
	 * @param clave string
	 * @param email string
	 **/
	public static function PasswordRecordarUsuario
	(
		$clave = "",
		$email = ""
	){

	}


		/**
	 *
	 *Crear un seguimiento de texto a este agente
	 *
	 * @param id_usuario int El id_usuario de a quien le haremos el seguimeinto
	 * @param texto string El texto que ingresa el que realiza el seguimiento
	 * @return id_usuario_seguimiento int
	 **/
	static function NuevoSeguimientoUsuario
	(
		$id_usuario,
		$texto
	){
		$cliente = UsuarioDAO::getByPK( $id_usuario );

		if(is_null($cliente)) {
			throw new InvalidDataException("Este usuario no existe");
		}

		if( strlen( $texto ) == 0 ){
			throw new InvalidDataException("El texto no puede ser vacio");
		}

		$usuario_actual = SesionController::Actual();

		$s = new UsuarioSeguimiento();
		$s->setIdUsuario($id_usuario);
		$s->setIdUsuarioRedacto($usuario_actual["id_usuario"]);
		$s->setFecha(time());
		$s->setTexto($texto);


		try{
			UsuarioSeguimientoDAO::save( $s );

		}catch(Exception $e){
			throw new InvalidDatabaseOperationException( $e );
		}
		return array( "id_usuario_seguimiento" => $s->getIdUsuarioSeguimiento() );
	}

	/**
	 *
	 *Muestra los detalles de un Rol especifico
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 * @param id_rol int Id del rol
	 * @return detalles json objeto con los detalles del rol
	 * @return perfil json objeto con la descripcion del perfil
	 **/
	public static function DetallesRol
	(
		$id_rol
	)
	{
		//vewrificamos si el rol existe
		if (!$rol = RolDAO::getByPK($id_rol)) {
			Logger::error("No se tiene registro del rol especificado");
			throw new Exception("No se tiene registro del rol especificado",901);
		}

		//detalles del rol
		$array_detalles = array(
			"id_rol" => $rol->getIdRol(),
			"nombre" => $rol->getNombre(),
			"descripcion" => $rol->getDescripcion(),
			"salario" => $rol->getSalario(),
			"id_rol_padre" => $rol->getIdRolPadre(),
			"id_tarifa_compra" => $rol->getIdTarifaCompra(),
			"id_tarifa_venta" => $rol->getIdTarifaVenta(),
			"id_perfil" => $rol->getIdPerfil()
		);

		//detalles del perfil asociado
		if ($rol->getIdPerfil() !== null && $rol->getIdPerfil() !== "" && is_numeric($rol->getIdPerfil()) && $perfil = PerfilDAO::getByPK($rol->getIdPerfil())) {
			$array_perfil = array(
				"id_perfil" => $perfil->getIdPerfil(),
				"descripcion" => $perfil->getDescripcion(),
				"configuracion" => $perfil->getConfiguracion()
			);
		} else {
			$array_perfil = array();
		}

		return array("detalles" => $array_detalles, "perfil" => $array_perfil);

	}

}
