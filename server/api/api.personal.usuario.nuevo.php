<?php
/**
  * POST api/personal/usuario/nuevo
  * Insertar un nuevo usuario.
  *
  * Insertar un nuevo usuario. El usuario que lo crea sera tomado de la sesion actual y la fecha sera tomada del servidor. Un usuario no puede tener mas de un rol en una misma sucursal de una misma empresa.
  *
  *
  *
  **/

  class ApiPersonalUsuarioNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"codigo_usuario" => new ApiExposedProperty("codigo_usuario", true, POST, array( "string" )),
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"password" => new ApiExposedProperty("password", true, POST, array( "string" )),
			"calle" => new ApiExposedProperty("calle", false, POST, array( "string" )),
			"calle_2" => new ApiExposedProperty("calle_2", false, POST, array( "string" )),
			"codigo_postal" => new ApiExposedProperty("codigo_postal", false, POST, array( "string" )),
			"codigo_postal_2" => new ApiExposedProperty("codigo_postal_2", false, POST, array( "string" )),
			"colonia" => new ApiExposedProperty("colonia", false, POST, array( "string" )),
			"colonia_2" => new ApiExposedProperty("colonia_2", false, POST, array( "string" )),
			"comision_ventas" => new ApiExposedProperty("comision_ventas", false, POST, array( "float" )),
			"correo_electronico" => new ApiExposedProperty("correo_electronico", false, POST, array( "string" )),
			"cuenta_bancaria" => new ApiExposedProperty("cuenta_bancaria", false, POST, array( "string" )),
			"cuenta_mensajeria" => new ApiExposedProperty("cuenta_mensajeria", false, POST, array( "string" )),
			"curp" => new ApiExposedProperty("curp", false, POST, array( "string" )),
			"denominacion_comercial" => new ApiExposedProperty("denominacion_comercial", false, POST, array( "string" )),
			"descuento" => new ApiExposedProperty("descuento", false, POST, array( "float" )),
			"dias_de_credito" => new ApiExposedProperty("dias_de_credito", false, POST, array( "int" )),
			"dias_de_embarque" => new ApiExposedProperty("dias_de_embarque", false, POST, array( "int" )),
			"dia_de_pago" => new ApiExposedProperty("dia_de_pago", false, POST, array( "string" )),
			"dia_de_revision" => new ApiExposedProperty("dia_de_revision", false, POST, array( "string" )),
			"facturar_a_terceros" => new ApiExposedProperty("facturar_a_terceros", false, POST, array( "bool" )),
			"id_ciudad" => new ApiExposedProperty("id_ciudad", false, POST, array( "int" )),
			"id_ciudad_2" => new ApiExposedProperty("id_ciudad_2", false, POST, array( "int" )),
			"id_clasificacion_cliente" => new ApiExposedProperty("id_clasificacion_cliente", false, POST, array( "int" )),
			"id_clasificacion_proveedor" => new ApiExposedProperty("id_clasificacion_proveedor", false, POST, array( "int" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"intereses_moratorios" => new ApiExposedProperty("intereses_moratorios", false, POST, array( "float" )),
			"limite_credito" => new ApiExposedProperty("limite_credito", false, POST, array( "float" )),
			"mensajeria" => new ApiExposedProperty("mensajeria", false, POST, array( "bool" )),
			"numero_exterior" => new ApiExposedProperty("numero_exterior", false, POST, array( "string" )),
			"numero_exterior_2" => new ApiExposedProperty("numero_exterior_2", false, POST, array( "string" )),
			"numero_interior" => new ApiExposedProperty("numero_interior", false, POST, array( "string" )),
			"numero_interior_2" => new ApiExposedProperty("numero_interior_2", false, POST, array( "string" )),
			"pagina_web" => new ApiExposedProperty("pagina_web", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"salario" => new ApiExposedProperty("salario", false, POST, array( "float" )),
			"saldo_del_ejercicio" => new ApiExposedProperty("saldo_del_ejercicio", false, POST, array( "float" )),
			"telefono1" => new ApiExposedProperty("telefono1", false, POST, array( "string" )),
			"telefono1_2" => new ApiExposedProperty("telefono1_2", false, POST, array( "string" )),
			"telefono2" => new ApiExposedProperty("telefono2", false, POST, array( "string" )),
			"telefono2_2" => new ApiExposedProperty("telefono2_2", false, POST, array( "string" )),
			"telefono_personal1" => new ApiExposedProperty("telefono_personal1", false, POST, array( "string" )),
			"telefono_personal2" => new ApiExposedProperty("telefono_personal2", false, POST, array( "string" )),
			"texto_extra" => new ApiExposedProperty("texto_extra", false, POST, array( "string" )),
			"texto_extra_2" => new ApiExposedProperty("texto_extra_2", false, POST, array( "string" )),
			"tiempo_entrega" => new ApiExposedProperty("tiempo_entrega", false, POST, array( "int" )),
			"ventas_a_credito" => new ApiExposedProperty("ventas_a_credito", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::NuevoUsuario( 
 			
			
			isset($_POST['codigo_usuario'] ) ? $_POST['codigo_usuario'] : null,
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['password'] ) ? $_POST['password'] : null,
			isset($_POST['calle'] ) ? $_POST['calle'] : null,
			isset($_POST['calle_2'] ) ? $_POST['calle_2'] : null,
			isset($_POST['codigo_postal'] ) ? $_POST['codigo_postal'] : null,
			isset($_POST['codigo_postal_2'] ) ? $_POST['codigo_postal_2'] : null,
			isset($_POST['colonia'] ) ? $_POST['colonia'] : null,
			isset($_POST['colonia_2'] ) ? $_POST['colonia_2'] : null,
			isset($_POST['comision_ventas'] ) ? $_POST['comision_ventas'] : null,
			isset($_POST['correo_electronico'] ) ? $_POST['correo_electronico'] : null,
			isset($_POST['cuenta_bancaria'] ) ? $_POST['cuenta_bancaria'] : null,
			isset($_POST['cuenta_mensajeria'] ) ? $_POST['cuenta_mensajeria'] : null,
			isset($_POST['curp'] ) ? $_POST['curp'] : null,
			isset($_POST['denominacion_comercial'] ) ? $_POST['denominacion_comercial'] : null,
			isset($_POST['descuento'] ) ? $_POST['descuento'] : null,
			isset($_POST['dias_de_credito'] ) ? $_POST['dias_de_credito'] : null,
			isset($_POST['dias_de_embarque'] ) ? $_POST['dias_de_embarque'] : null,
			isset($_POST['dia_de_pago'] ) ? $_POST['dia_de_pago'] : null,
			isset($_POST['dia_de_revision'] ) ? $_POST['dia_de_revision'] : null,
			isset($_POST['facturar_a_terceros'] ) ? $_POST['facturar_a_terceros'] : null,
			isset($_POST['id_ciudad'] ) ? $_POST['id_ciudad'] : null,
			isset($_POST['id_ciudad_2'] ) ? $_POST['id_ciudad_2'] : null,
			isset($_POST['id_clasificacion_cliente'] ) ? $_POST['id_clasificacion_cliente'] : null,
			isset($_POST['id_clasificacion_proveedor'] ) ? $_POST['id_clasificacion_proveedor'] : null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] : null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] : null,
			isset($_POST['impuestos'] ) ? $_POST['impuestos'] : null,
			isset($_POST['intereses_moratorios'] ) ? $_POST['intereses_moratorios'] : null,
			isset($_POST['limite_credito'] ) ? $_POST['limite_credito'] : null,
			isset($_POST['mensajeria'] ) ? $_POST['mensajeria'] : null,
			isset($_POST['numero_exterior'] ) ? $_POST['numero_exterior'] : null,
			isset($_POST['numero_exterior_2'] ) ? $_POST['numero_exterior_2'] : null,
			isset($_POST['numero_interior'] ) ? $_POST['numero_interior'] : null,
			isset($_POST['numero_interior_2'] ) ? $_POST['numero_interior_2'] : null,
			isset($_POST['pagina_web'] ) ? $_POST['pagina_web'] : null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] : null,
			isset($_POST['retenciones'] ) ? $_POST['retenciones'] : null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] : null,
			isset($_POST['salario'] ) ? $_POST['salario'] : null,
			isset($_POST['saldo_del_ejercicio'] ) ? $_POST['saldo_del_ejercicio'] : null,
			isset($_POST['telefono1'] ) ? $_POST['telefono1'] : null,
			isset($_POST['telefono1_2'] ) ? $_POST['telefono1_2'] : null,
			isset($_POST['telefono2'] ) ? $_POST['telefono2'] : null,
			isset($_POST['telefono2_2'] ) ? $_POST['telefono2_2'] : null,
			isset($_POST['telefono_personal1'] ) ? $_POST['telefono_personal1'] : null,
			isset($_POST['telefono_personal2'] ) ? $_POST['telefono_personal2'] : null,
			isset($_POST['texto_extra'] ) ? $_POST['texto_extra'] : null,
			isset($_POST['texto_extra_2'] ) ? $_POST['texto_extra_2'] : null,
			isset($_POST['tiempo_entrega'] ) ? $_POST['tiempo_entrega'] : null,
			isset($_POST['ventas_a_credito'] ) ? $_POST['ventas_a_credito'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  
  
  
  
  
