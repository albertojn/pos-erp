<?php 


  class ApiSesionIniciar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() { /*SESION NO NECESARIA*/ return; }
	protected function GetRequest()
	{
		$this->request = array(	
			"password" => new ApiExposedProperty("password", true, POST, array( "string" )),
			"usuario" => new ApiExposedProperty("usuario", true, POST, array( "string" )),
			"request_token" => new ApiExposedProperty("request_token", false, POST, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SesionController::Iniciar( 
 			
			
			isset($_POST['password'] ) ? $_POST['password'] : null,
			isset($_POST['usuario'] ) ? $_POST['usuario'] : null,
			isset($_POST['request_token'] ) ? $_POST['request_token'] :  true 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSesionCerrar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"auth_token" => new ApiExposedProperty("auth_token", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SesionController::Cerrar( 
 			
			
			isset($_POST['auth_token'] ) ? $_POST['auth_token'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSesionLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_grupo" => new ApiExposedProperty("id_grupo", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SesionController::Lista( 
 			
			
			isset($_GET['id_grupo'] ) ? $_GET['id_grupo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSesionActual extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SesionController::Actual( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEmpresaBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, POST, array( "bool" )),
			"limit" => new ApiExposedProperty("limit", false, POST, array( "string" )),
			"order" => new ApiExposedProperty("order", false, POST, array( "string" )),
			"order_by" => new ApiExposedProperty("order_by", false, POST, array( "string" )),
			"query" => new ApiExposedProperty("query", false, POST, array( "string" )),
			"start" => new ApiExposedProperty("start", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EmpresasController::Buscar( 
 			
			
			isset($_POST['activa'] ) ? $_POST['activa'] :  false ,
			isset($_POST['limit'] ) ? $_POST['limit'] :  null,
			isset($_POST['order'] ) ? $_POST['order'] :  null,
			isset($_POST['order_by'] ) ? $_POST['order_by'] :  null,
			isset($_POST['query'] ) ? $_POST['query'] :  null,
			isset($_POST['start'] ) ? $_POST['start'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEmpresaNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"contabilidad" => new ApiExposedProperty("contabilidad", true, POST, array( "json" )),
			"direccion" => new ApiExposedProperty("direccion", true, POST, array( "json" )),
			"razon_social" => new ApiExposedProperty("razon_social", true, POST, array( "string" )),
			"rfc" => new ApiExposedProperty("rfc", true, POST, array( "string" )),
			"cuentas_bancarias" => new ApiExposedProperty("cuentas_bancarias", false, POST, array( "json" )),
			"direccion_web" => new ApiExposedProperty("direccion_web", false, POST, array( "string" )),
			"duplicar" => new ApiExposedProperty("duplicar", false, POST, array( "bool" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
			"impuestos_compra" => new ApiExposedProperty("impuestos_compra", false, POST, array( "json" )),
			"impuestos_venta" => new ApiExposedProperty("impuestos_venta", false, POST, array( "json" )),
			"mensaje_morosos" => new ApiExposedProperty("mensaje_morosos", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"uri_logo" => new ApiExposedProperty("uri_logo", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EmpresasController::Nuevo( 
 			
			
			isset($_POST['contabilidad'] ) ? json_decode($_POST['contabilidad']) : null,
			isset($_POST['direccion'] ) ? json_decode($_POST['direccion']) : null,
			isset($_POST['razon_social'] ) ? $_POST['razon_social'] : null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] : null,
			isset($_POST['cuentas_bancarias'] ) ? json_decode($_POST['cuentas_bancarias']) : null,
			isset($_POST['direccion_web'] ) ? $_POST['direccion_web'] :  null,
			isset($_POST['duplicar'] ) ? $_POST['duplicar'] :  false ,
			isset($_POST['email'] ) ? $_POST['email'] :  null,
			isset($_POST['impuestos_compra'] ) ? json_decode($_POST['impuestos_compra']) : null,
			isset($_POST['impuestos_venta'] ) ? json_decode($_POST['impuestos_venta']) : null,
			isset($_POST['mensaje_morosos'] ) ? $_POST['mensaje_morosos'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['uri_logo'] ) ? $_POST['uri_logo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEmpresaEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EmpresasController::Eliminar( 
 			
			
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEmpresaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"cuentas_bancarias" => new ApiExposedProperty("cuentas_bancarias", false, POST, array( "json" )),
			"direccion" => new ApiExposedProperty("direccion", false, POST, array( "json" )),
			"direccion_web" => new ApiExposedProperty("direccion_web", false, POST, array( "string" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "string" )),
			"impuestos_compra" => new ApiExposedProperty("impuestos_compra", false, POST, array( "json" )),
			"impuestos_venta" => new ApiExposedProperty("impuestos_venta", false, POST, array( "json" )),
			"mensaje_morosos" => new ApiExposedProperty("mensaje_morosos", false, POST, array( "string" )),
			"razon_social" => new ApiExposedProperty("razon_social", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"uri_logo" => new ApiExposedProperty("uri_logo", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EmpresasController::Editar( 
 			
			
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['cuentas_bancarias'] ) ? json_decode($_POST['cuentas_bancarias']) : null,
			isset($_POST['direccion'] ) ? json_decode($_POST['direccion']) : null,
			isset($_POST['direccion_web'] ) ? $_POST['direccion_web'] :  null,
			isset($_POST['email'] ) ? $_POST['email'] :  null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  "0",
			isset($_POST['impuestos_compra'] ) ? json_decode($_POST['impuestos_compra']) : null,
			isset($_POST['impuestos_venta'] ) ? json_decode($_POST['impuestos_venta']) : null,
			isset($_POST['mensaje_morosos'] ) ? $_POST['mensaje_morosos'] :  null,
			isset($_POST['razon_social'] ) ? $_POST['razon_social'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] :  null,
			isset($_POST['uri_logo'] ) ? $_POST['uri_logo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEmpresaDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EmpresasController::Detalles( 
 			
			
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"razon_social" => new ApiExposedProperty("razon_social", true, POST, array( "string" )),
			"clasificacion_cliente" => new ApiExposedProperty("clasificacion_cliente", false, POST, array( "int" )),
			"codigo_cliente" => new ApiExposedProperty("codigo_cliente", false, POST, array( "string" )),
			"cuenta_de_mensajeria" => new ApiExposedProperty("cuenta_de_mensajeria", false, POST, array( "string" )),
			"curp" => new ApiExposedProperty("curp", false, POST, array( "string" )),
			"denominacion_comercial" => new ApiExposedProperty("denominacion_comercial", false, POST, array( "string" )),
			"descuento_general" => new ApiExposedProperty("descuento_general", false, POST, array( "float" )),
			"direcciones" => new ApiExposedProperty("direcciones", false, POST, array( "json" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"id_cliente_padre" => new ApiExposedProperty("id_cliente_padre", false, POST, array( "int" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"limite_credito" => new ApiExposedProperty("limite_credito", false, POST, array( "float" )),
			"password" => new ApiExposedProperty("password", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"sitio_web" => new ApiExposedProperty("sitio_web", false, POST, array( "string" )),
			"telefono_personal1" => new ApiExposedProperty("telefono_personal1", false, POST, array( "string" )),
			"telefono_personal2" => new ApiExposedProperty("telefono_personal2", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::Nuevo( 
 			
			
			isset($_POST['razon_social'] ) ? $_POST['razon_social'] : null,
			isset($_POST['clasificacion_cliente'] ) ? $_POST['clasificacion_cliente'] :  null,
			isset($_POST['codigo_cliente'] ) ? $_POST['codigo_cliente'] :  null,
			isset($_POST['cuenta_de_mensajeria'] ) ? $_POST['cuenta_de_mensajeria'] :  null,
			isset($_POST['curp'] ) ? $_POST['curp'] :  null,
			isset($_POST['denominacion_comercial'] ) ? $_POST['denominacion_comercial'] :  null,
			isset($_POST['descuento_general'] ) ? $_POST['descuento_general'] :  "0",
			isset($_POST['direcciones'] ) ? json_decode($_POST['direcciones']) : null,
			isset($_POST['email'] ) ? $_POST['email'] :  null,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['id_cliente_padre'] ) ? $_POST['id_cliente_padre'] :  null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  1 ,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['limite_credito'] ) ? $_POST['limite_credito'] :  "0",
			isset($_POST['password'] ) ? $_POST['password'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] :  null,
			isset($_POST['sitio_web'] ) ? $_POST['sitio_web'] :  null,
			isset($_POST['telefono_personal1'] ) ? $_POST['telefono_personal1'] :  null,
			isset($_POST['telefono_personal2'] ) ? $_POST['telefono_personal2'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
			"clasificacion_cliente" => new ApiExposedProperty("clasificacion_cliente", false, POST, array( "int" )),
			"codigo_cliente" => new ApiExposedProperty("codigo_cliente", false, POST, array( "string" )),
			"cuenta_de_mensajeria" => new ApiExposedProperty("cuenta_de_mensajeria", false, POST, array( "string" )),
			"curp" => new ApiExposedProperty("curp", false, POST, array( "string" )),
			"denominacion_comercial" => new ApiExposedProperty("denominacion_comercial", false, POST, array( "string" )),
			"descuento_general" => new ApiExposedProperty("descuento_general", false, POST, array( "float" )),
			"direcciones" => new ApiExposedProperty("direcciones", false, POST, array( "json" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"id_cliente_padre" => new ApiExposedProperty("id_cliente_padre", false, POST, array( "int" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"limite_credito" => new ApiExposedProperty("limite_credito", false, POST, array( "float" )),
			"password" => new ApiExposedProperty("password", false, POST, array( "string" )),
			"password_anterior" => new ApiExposedProperty("password_anterior", false, POST, array( "string" )),
			"razon_social" => new ApiExposedProperty("razon_social", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"sitio_web" => new ApiExposedProperty("sitio_web", false, POST, array( "string" )),
			"telefono_personal1" => new ApiExposedProperty("telefono_personal1", false, POST, array( "string" )),
			"telefono_personal2" => new ApiExposedProperty("telefono_personal2", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::Editar( 
 			
			
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null,
			isset($_POST['clasificacion_cliente'] ) ? $_POST['clasificacion_cliente'] :  null,
			isset($_POST['codigo_cliente'] ) ? $_POST['codigo_cliente'] :  null,
			isset($_POST['cuenta_de_mensajeria'] ) ? $_POST['cuenta_de_mensajeria'] :  null,
			isset($_POST['curp'] ) ? $_POST['curp'] :  null,
			isset($_POST['denominacion_comercial'] ) ? $_POST['denominacion_comercial'] :  null,
			isset($_POST['descuento_general'] ) ? $_POST['descuento_general'] :  null,
			isset($_POST['direcciones'] ) ? json_decode($_POST['direcciones']) : null,
			isset($_POST['email'] ) ? $_POST['email'] :  null,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['id_cliente_padre'] ) ? $_POST['id_cliente_padre'] :  null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  null,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['limite_credito'] ) ? $_POST['limite_credito'] :  null,
			isset($_POST['password'] ) ? $_POST['password'] :  null,
			isset($_POST['password_anterior'] ) ? $_POST['password_anterior'] :  null,
			isset($_POST['razon_social'] ) ? $_POST['razon_social'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] :  null,
			isset($_POST['sitio_web'] ) ? $_POST['sitio_web'] :  null,
			isset($_POST['telefono_personal1'] ) ? $_POST['telefono_personal1'] :  null,
			isset($_POST['telefono_personal2'] ) ? $_POST['telefono_personal2'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::Detalle( 
 			
			
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteClasificacionNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"clave_interna" => new ApiExposedProperty("clave_interna", true, POST, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::NuevaClasificacion( 
 			
			
			isset($_POST['clave_interna'] ) ? $_POST['clave_interna'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteClasificacionBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"limit" => new ApiExposedProperty("limit", false, GET, array( "int" )),
			"page" => new ApiExposedProperty("page", false, GET, array( "int" )),
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
			"start" => new ApiExposedProperty("start", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::BuscarClasificacion( 
 			
			
			isset($_GET['limit'] ) ? $_GET['limit'] :  50 ,
			isset($_GET['page'] ) ? $_GET['page'] :  null,
			isset($_GET['query'] ) ? $_GET['query'] :  null,
			isset($_GET['start'] ) ? $_GET['start'] :  0 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteClasificacionEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_clasificacion_cliente" => new ApiExposedProperty("id_clasificacion_cliente", true, POST, array( "int" )),
			"clave_interna" => new ApiExposedProperty("clave_interna", false, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::EditarClasificacion( 
 			
			
			isset($_POST['id_clasificacion_cliente'] ) ? $_POST['id_clasificacion_cliente'] : null,
			isset($_POST['clave_interna'] ) ? $_POST['clave_interna'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", false, GET, array( "int" )),
			"limit" => new ApiExposedProperty("limit", false, GET, array( "int" )),
			"page" => new ApiExposedProperty("page", false, GET, array( "int" )),
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
			"start" => new ApiExposedProperty("start", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::Buscar( 
 			
			
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['id_usuario'] ) ? $_GET['id_usuario'] :  null,
			isset($_GET['limit'] ) ? $_GET['limit'] :  50 ,
			isset($_GET['page'] ) ? $_GET['page'] :  null,
			isset($_GET['query'] ) ? $_GET['query'] :  null,
			isset($_GET['start'] ) ? $_GET['start'] :  0 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteAvalNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"avales" => new ApiExposedProperty("avales", true, POST, array( "json" )),
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::NuevoAval( 
 			
			
			isset($_POST['avales'] ) ? json_decode($_POST['avales']) : null,
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteAvalEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"avales" => new ApiExposedProperty("avales", true, POST, array( "json" )),
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::EliminarAval( 
 			
			
			isset($_POST['avales'] ) ? json_decode($_POST['avales']) : null,
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClientesImportar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"raw_content" => new ApiExposedProperty("raw_content", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::Importar( 
 			
			
			isset($_POST['raw_content'] ) ? $_POST['raw_content'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiClienteSeguimientoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
			"texto" => new ApiExposedProperty("texto", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ClientesController::NuevoSeguimiento( 
 			
			
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null,
			isset($_POST['texto'] ) ? $_POST['texto'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesGasto extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"monto" => new ApiExposedProperty("monto", true, POST, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::Gasto( 
 			
			
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['monto'] ) ? $_POST['monto'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesClienteEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::EditarCliente( 
 			
			
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesCompraDevolucion extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_compra" => new ApiExposedProperty("id_compra", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::DevolucionCompra( 
 			
			
			isset($_POST['id_compra'] ) ? $_POST['id_compra'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesVentaDevolucion extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"id_venta" => new ApiExposedProperty("id_venta", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::DevolucionVenta( 
 			
			
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['id_venta'] ) ? $_POST['id_venta'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesClientePrecio extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"compra" => new ApiExposedProperty("compra", true, GET, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", true, GET, array( "string" )),
			"id_cliente" => new ApiExposedProperty("id_cliente", true, GET, array( "int" )),
			"id_productos" => new ApiExposedProperty("id_productos", true, GET, array( "json" )),
			"siguiente_compra" => new ApiExposedProperty("siguiente_compra", true, GET, array( "bool" )),
			"id_precio" => new ApiExposedProperty("id_precio", false, GET, array( "int" )),
			"precio" => new ApiExposedProperty("precio", false, GET, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::PrecioCliente( 
 			
			
			isset($_GET['compra'] ) ? $_GET['compra'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] : null,
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] : null,
			isset($_GET['id_productos'] ) ? json_decode($_GET['id_productos']) : null,
			isset($_GET['siguiente_compra'] ) ? $_GET['siguiente_compra'] : null,
			isset($_GET['id_precio'] ) ? $_GET['id_precio'] :  null,
			isset($_GET['precio'] ) ? $_GET['precio'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"filtro" => new ApiExposedProperty("filtro", false, GET, array( "string" )),
			"ordenar" => new ApiExposedProperty("ordenar", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::Lista( 
 			
			
			isset($_GET['filtro'] ) ? $_GET['filtro'] :  null,
			isset($_GET['ordenar'] ) ? $_GET['ordenar'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesResponder extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"aceptar" => new ApiExposedProperty("aceptar", true, POST, array( "bool" )),
			"id_autorizacion" => new ApiExposedProperty("id_autorizacion", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::Responder( 
 			
			
			isset($_POST['aceptar'] ) ? $_POST['aceptar'] : null,
			isset($_POST['id_autorizacion'] ) ? $_POST['id_autorizacion'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesSolicitarProducto extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, GET, array( "string" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::ProductoSolicitar( 
 			
			
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_autorizacion	" => new ApiExposedProperty("id_autorizacion	", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::Detalle( 
 			
			
			isset($_GET['id_autorizacion	'] ) ? $_GET['id_autorizacion	'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAutorizacionesEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, GET, array( "string" )),
			"estado" => new ApiExposedProperty("estado", true, GET, array( "int" )),
			"id_autorizacion	" => new ApiExposedProperty("id_autorizacion	", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::Editar( 
 			
			
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] : null,
			isset($_GET['estado'] ) ? $_GET['estado'] : null,
			isset($_GET['id_autorizacion	'] ) ? $_GET['id_autorizacion	'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiInventarioExistencias extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_almacen	" => new ApiExposedProperty("id_almacen	", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_producto" => new ApiExposedProperty("id_producto", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = InventarioController::Existencias( 
 			
			
			isset($_GET['id_almacen	'] ) ? $_GET['id_almacen	'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_producto'] ) ? $_GET['id_producto'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiInventarioProcesarProducto extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cantidad_nueva" => new ApiExposedProperty("cantidad_nueva", true, GET, array( "float" )),
			"cantidad_vieja" => new ApiExposedProperty("cantidad_vieja", true, GET, array( "float" )),
			"id_almacen_nuevo" => new ApiExposedProperty("id_almacen_nuevo", true, GET, array( "int" )),
			"id_almacen_viejo" => new ApiExposedProperty("id_almacen_viejo", true, GET, array( "int" )),
			"id_producto_nuevo" => new ApiExposedProperty("id_producto_nuevo", true, GET, array( "int" )),
			"id_producto_viejo" => new ApiExposedProperty("id_producto_viejo", true, GET, array( "int" )),
			"id_unidad_nueva" => new ApiExposedProperty("id_unidad_nueva", true, GET, array( "int" )),
			"id_unidad_vieja" => new ApiExposedProperty("id_unidad_vieja", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = InventarioController::ProductoProcesar( 
 			
			
			isset($_GET['cantidad_nueva'] ) ? $_GET['cantidad_nueva'] : null,
			isset($_GET['cantidad_vieja'] ) ? $_GET['cantidad_vieja'] : null,
			isset($_GET['id_almacen_nuevo'] ) ? $_GET['id_almacen_nuevo'] : null,
			isset($_GET['id_almacen_viejo'] ) ? $_GET['id_almacen_viejo'] : null,
			isset($_GET['id_producto_nuevo'] ) ? $_GET['id_producto_nuevo'] : null,
			isset($_GET['id_producto_viejo'] ) ? $_GET['id_producto_viejo'] : null,
			isset($_GET['id_unidad_nueva'] ) ? $_GET['id_unidad_nueva'] : null,
			isset($_GET['id_unidad_vieja'] ) ? $_GET['id_unidad_vieja'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiInventarioTerminarCargamentoDeCompra extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = InventarioController::CompraDeCargamentoTerminar( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiInventarioFisico extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"inventario" => new ApiExposedProperty("inventario", true, POST, array( "json" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = InventarioController::Fisico( 
 			
			
			isset($_POST['inventario'] ) ? json_decode($_POST['inventario']) : null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiInventarioRecalcularExistencias extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"productos" => new ApiExposedProperty("productos", true, POST, array( "json" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = InventarioController::ExistenciasRecalcular( 
 			
			
			isset($_POST['productos'] ) ? json_decode($_POST['productos']) : null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"codigo_usuario" => new ApiExposedProperty("codigo_usuario", true, POST, array( "string" )),
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"password" => new ApiExposedProperty("password", true, POST, array( "string" )),
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
			"direcciones" => new ApiExposedProperty("direcciones", false, POST, array( "json" )),
			"facturar_a_terceros" => new ApiExposedProperty("facturar_a_terceros", false, POST, array( "bool" )),
			"id_clasificacion_cliente" => new ApiExposedProperty("id_clasificacion_cliente", false, POST, array( "int" )),
			"id_clasificacion_proveedor" => new ApiExposedProperty("id_clasificacion_proveedor", false, POST, array( "int" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"id_usuario_padre" => new ApiExposedProperty("id_usuario_padre", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"intereses_moratorios" => new ApiExposedProperty("intereses_moratorios", false, POST, array( "float" )),
			"limite_credito" => new ApiExposedProperty("limite_credito", false, POST, array( "float" )),
			"mensajeria" => new ApiExposedProperty("mensajeria", false, POST, array( "bool" )),
			"pagina_web" => new ApiExposedProperty("pagina_web", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"salario" => new ApiExposedProperty("salario", false, POST, array( "float" )),
			"saldo_del_ejercicio" => new ApiExposedProperty("saldo_del_ejercicio", false, POST, array( "float" )),
			"telefono_personal1" => new ApiExposedProperty("telefono_personal1", false, POST, array( "string" )),
			"telefono_personal2" => new ApiExposedProperty("telefono_personal2", false, POST, array( "string" )),
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
			isset($_POST['comision_ventas'] ) ? $_POST['comision_ventas'] :  "0",
			isset($_POST['correo_electronico'] ) ? $_POST['correo_electronico'] :  null,
			isset($_POST['cuenta_bancaria'] ) ? $_POST['cuenta_bancaria'] :  null,
			isset($_POST['cuenta_mensajeria'] ) ? $_POST['cuenta_mensajeria'] :  null,
			isset($_POST['curp'] ) ? $_POST['curp'] :  null,
			isset($_POST['denominacion_comercial'] ) ? $_POST['denominacion_comercial'] :  null,
			isset($_POST['descuento'] ) ? $_POST['descuento'] :  null,
			isset($_POST['dias_de_credito'] ) ? $_POST['dias_de_credito'] :  null,
			isset($_POST['dias_de_embarque'] ) ? $_POST['dias_de_embarque'] :  null,
			isset($_POST['dia_de_pago'] ) ? $_POST['dia_de_pago'] :  null,
			isset($_POST['dia_de_revision'] ) ? $_POST['dia_de_revision'] :  null,
			isset($_POST['direcciones'] ) ? json_decode($_POST['direcciones']) : null,
			isset($_POST['facturar_a_terceros'] ) ? $_POST['facturar_a_terceros'] :  null,
			isset($_POST['id_clasificacion_cliente'] ) ? $_POST['id_clasificacion_cliente'] :  null,
			isset($_POST['id_clasificacion_proveedor'] ) ? $_POST['id_clasificacion_proveedor'] :  null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['id_usuario_padre'] ) ? $_POST['id_usuario_padre'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['intereses_moratorios'] ) ? $_POST['intereses_moratorios'] :  null,
			isset($_POST['limite_credito'] ) ? $_POST['limite_credito'] :  "0",
			isset($_POST['mensajeria'] ) ? $_POST['mensajeria'] :  null,
			isset($_POST['pagina_web'] ) ? $_POST['pagina_web'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['retenciones'] ) ? json_decode($_POST['retenciones']) : null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] :  null,
			isset($_POST['salario'] ) ? $_POST['salario'] :  null,
			isset($_POST['saldo_del_ejercicio'] ) ? $_POST['saldo_del_ejercicio'] :  null,
			isset($_POST['telefono_personal1'] ) ? $_POST['telefono_personal1'] :  null,
			isset($_POST['telefono_personal2'] ) ? $_POST['telefono_personal2'] :  null,
			isset($_POST['tiempo_entrega'] ) ? $_POST['tiempo_entrega'] :  null,
			isset($_POST['ventas_a_credito'] ) ? $_POST['ventas_a_credito'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"ordenar" => new ApiExposedProperty("ordenar", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::ListaUsuario( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['ordenar'] ) ? $_GET['ordenar'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_usuario" => new ApiExposedProperty("id_usuario", true, POST, array( "int" )),
			"codigo_usuario" => new ApiExposedProperty("codigo_usuario", false, POST, array( "string" )),
			"comision_ventas" => new ApiExposedProperty("comision_ventas", false, POST, array( "float" )),
			"correo_electronico" => new ApiExposedProperty("correo_electronico", false, POST, array( "string" )),
			"cuenta_bancaria" => new ApiExposedProperty("cuenta_bancaria", false, POST, array( "string" )),
			"cuenta_mensajeria" => new ApiExposedProperty("cuenta_mensajeria", false, POST, array( "string" )),
			"curp" => new ApiExposedProperty("curp", false, POST, array( "string" )),
			"denominacion_comercial" => new ApiExposedProperty("denominacion_comercial", false, POST, array( "string" )),
			"descuento" => new ApiExposedProperty("descuento", false, POST, array( "float" )),
			"descuento_es_porcentaje" => new ApiExposedProperty("descuento_es_porcentaje", false, POST, array( "bool" )),
			"dias_de_credito" => new ApiExposedProperty("dias_de_credito", false, POST, array( "int" )),
			"dias_de_embarque" => new ApiExposedProperty("dias_de_embarque", false, POST, array( "int" )),
			"dia_de_pago" => new ApiExposedProperty("dia_de_pago", false, POST, array( "string" )),
			"dia_de_revision" => new ApiExposedProperty("dia_de_revision", false, POST, array( "string" )),
			"direcciones" => new ApiExposedProperty("direcciones", false, POST, array( "json" )),
			"facturar_a_terceros" => new ApiExposedProperty("facturar_a_terceros", false, POST, array( "bool" )),
			"id_clasificacion_cliente" => new ApiExposedProperty("id_clasificacion_cliente", false, POST, array( "int" )),
			"id_clasificacion_proveedor" => new ApiExposedProperty("id_clasificacion_proveedor", false, POST, array( "int" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"id_rol" => new ApiExposedProperty("id_rol", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"id_usuario_padre" => new ApiExposedProperty("id_usuario_padre", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"intereses_moratorios" => new ApiExposedProperty("intereses_moratorios", false, POST, array( "float" )),
			"limite_de_credito" => new ApiExposedProperty("limite_de_credito", false, POST, array( "float" )),
			"mensajeria" => new ApiExposedProperty("mensajeria", false, POST, array( "bool" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
			"pagina_web" => new ApiExposedProperty("pagina_web", false, POST, array( "string" )),
			"password" => new ApiExposedProperty("password", false, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"salario" => new ApiExposedProperty("salario", false, POST, array( "float" )),
			"saldo_del_ejercicio" => new ApiExposedProperty("saldo_del_ejercicio", false, POST, array( "float" )),
			"telefono_personal_1" => new ApiExposedProperty("telefono_personal_1", false, POST, array( "string" )),
			"telefono_personal_2" => new ApiExposedProperty("telefono_personal_2", false, POST, array( "string" )),
			"tiempo_entrega" => new ApiExposedProperty("tiempo_entrega", false, POST, array( "int" )),
			"ventas_a_credito" => new ApiExposedProperty("ventas_a_credito", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::EditarUsuario( 
 			
			
			isset($_POST['id_usuario'] ) ? $_POST['id_usuario'] : null,
			isset($_POST['codigo_usuario'] ) ? $_POST['codigo_usuario'] :  null,
			isset($_POST['comision_ventas'] ) ? $_POST['comision_ventas'] :  null,
			isset($_POST['correo_electronico'] ) ? $_POST['correo_electronico'] :  null,
			isset($_POST['cuenta_bancaria'] ) ? $_POST['cuenta_bancaria'] :  null,
			isset($_POST['cuenta_mensajeria'] ) ? $_POST['cuenta_mensajeria'] :  null,
			isset($_POST['curp'] ) ? $_POST['curp'] :  null,
			isset($_POST['denominacion_comercial'] ) ? $_POST['denominacion_comercial'] :  null,
			isset($_POST['descuento'] ) ? $_POST['descuento'] :  null,
			isset($_POST['descuento_es_porcentaje'] ) ? $_POST['descuento_es_porcentaje'] :  null,
			isset($_POST['dias_de_credito'] ) ? $_POST['dias_de_credito'] :  null,
			isset($_POST['dias_de_embarque'] ) ? $_POST['dias_de_embarque'] :  null,
			isset($_POST['dia_de_pago'] ) ? $_POST['dia_de_pago'] :  null,
			isset($_POST['dia_de_revision'] ) ? $_POST['dia_de_revision'] :  null,
			isset($_POST['direcciones'] ) ? json_decode($_POST['direcciones']) : null,
			isset($_POST['facturar_a_terceros'] ) ? $_POST['facturar_a_terceros'] :  null,
			isset($_POST['id_clasificacion_cliente'] ) ? $_POST['id_clasificacion_cliente'] :  null,
			isset($_POST['id_clasificacion_proveedor'] ) ? $_POST['id_clasificacion_proveedor'] :  null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  null,
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['id_usuario_padre'] ) ? $_POST['id_usuario_padre'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['intereses_moratorios'] ) ? $_POST['intereses_moratorios'] :  null,
			isset($_POST['limite_de_credito'] ) ? $_POST['limite_de_credito'] :  null,
			isset($_POST['mensajeria'] ) ? $_POST['mensajeria'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null,
			isset($_POST['pagina_web'] ) ? $_POST['pagina_web'] :  null,
			isset($_POST['password'] ) ? $_POST['password'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['retenciones'] ) ? json_decode($_POST['retenciones']) : null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] :  null,
			isset($_POST['salario'] ) ? $_POST['salario'] :  null,
			isset($_POST['saldo_del_ejercicio'] ) ? $_POST['saldo_del_ejercicio'] :  null,
			isset($_POST['telefono_personal_1'] ) ? $_POST['telefono_personal_1'] :  null,
			isset($_POST['telefono_personal_2'] ) ? $_POST['telefono_personal_2'] :  null,
			isset($_POST['tiempo_entrega'] ) ? $_POST['tiempo_entrega'] :  null,
			isset($_POST['ventas_a_credito'] ) ? $_POST['ventas_a_credito'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_perfil" => new ApiExposedProperty("id_perfil", false, POST, array( "int" )),
			"id_rol_padre" => new ApiExposedProperty("id_rol_padre", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"salario" => new ApiExposedProperty("salario", false, POST, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::NuevoRol( 
 			
			
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_perfil'] ) ? $_POST['id_perfil'] :  null,
			isset($_POST['id_rol_padre'] ) ? $_POST['id_rol_padre'] :  null,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['salario'] ) ? $_POST['salario'] :  "0"
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_perfil" => new ApiExposedProperty("id_perfil", false, POST, array( "int" )),
			"id_rol_padre" => new ApiExposedProperty("id_rol_padre", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
			"salario" => new ApiExposedProperty("salario", false, POST, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::EditarRol( 
 			
			
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_perfil'] ) ? $_POST['id_perfil'] :  null,
			isset($_POST['id_rol_padre'] ) ? $_POST['id_rol_padre'] :  null,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null,
			isset($_POST['salario'] ) ? $_POST['salario'] :  "0"
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_usuario" => new ApiExposedProperty("id_usuario", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::EliminarUsuario( 
 			
			
			isset($_POST['id_usuario'] ) ? $_POST['id_usuario'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::EliminarRol( 
 			
			
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, POST, array( "bool" )),
			"limit" => new ApiExposedProperty("limit", false, POST, array( "string" )),
			"order" => new ApiExposedProperty("order", false, POST, array( "string" )),
			"order_by" => new ApiExposedProperty("order_by", false, POST, array( "string" )),
			"query" => new ApiExposedProperty("query", false, POST, array( "string" )),
			"start" => new ApiExposedProperty("start", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::ListaRol( 
 			
			
			isset($_POST['activa'] ) ? $_POST['activa'] :  false ,
			isset($_POST['limit'] ) ? $_POST['limit'] :  null,
			isset($_POST['order'] ) ? $_POST['order'] :  null,
			isset($_POST['order_by'] ) ? $_POST['order_by'] :  null,
			isset($_POST['query'] ) ? $_POST['query'] :  null,
			isset($_POST['start'] ) ? $_POST['start'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioPermisoAsignar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_permiso" => new ApiExposedProperty("id_permiso", true, POST, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::AsignarPermisoUsuario( 
 			
			
			isset($_POST['id_permiso'] ) ? $_POST['id_permiso'] : null,
			isset($_POST['id_usuario'] ) ? $_POST['id_usuario'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolPermisoAsignar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_permiso" => new ApiExposedProperty("id_permiso", true, POST, array( "int" )),
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::AsignarPermisoRol( 
 			
			
			isset($_POST['id_permiso'] ) ? $_POST['id_permiso'] : null,
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolPermisoRemover extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_permiso" => new ApiExposedProperty("id_permiso", true, POST, array( "int" )),
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::RemoverPermisoRol( 
 			
			
			isset($_POST['id_permiso'] ) ? $_POST['id_permiso'] : null,
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioPermisoRemover extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_permiso" => new ApiExposedProperty("id_permiso", true, POST, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::RemoverPermisoUsuario( 
 			
			
			isset($_POST['id_permiso'] ) ? $_POST['id_permiso'] : null,
			isset($_POST['id_usuario'] ) ? $_POST['id_usuario'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolPermisoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_permiso" => new ApiExposedProperty("id_permiso", false, GET, array( "int" )),
			"id_rol" => new ApiExposedProperty("id_rol", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::ListaPermisoRol( 
 			
			
			isset($_GET['id_permiso'] ) ? $_GET['id_permiso'] :  null,
			isset($_GET['id_rol'] ) ? $_GET['id_rol'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioPermisoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_permiso" => new ApiExposedProperty("id_permiso", false, GET, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::ListaPermisoUsuario( 
 			
			
			isset($_GET['id_permiso'] ) ? $_GET['id_permiso'] :  null,
			isset($_GET['id_usuario'] ) ? $_GET['id_usuario'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioRecordarPassword extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"clave" => new ApiExposedProperty("clave", false, POST, array( "string" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::PasswordRecordarUsuario( 
 			
			
			isset($_POST['clave'] ) ? $_POST['clave'] :  "",
			isset($_POST['email'] ) ? $_POST['email'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalUsuarioSeguimientoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_usuario" => new ApiExposedProperty("id_usuario", true, POST, array( "int" )),
			"texto" => new ApiExposedProperty("texto", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::NuevoSeguimientoUsuario( 
 			
			
			isset($_POST['id_usuario'] ) ? $_POST['id_usuario'] : null,
			isset($_POST['texto'] ) ? $_POST['texto'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPersonalRolDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_rol" => new ApiExposedProperty("id_rol", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PersonalYAgentesController::DetallesRol( 
 			
			
			isset($_POST['id_rol'] ) ? $_POST['id_rol'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoConceptoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::NuevoConceptoGasto( 
 			
			
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoConceptoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_concepto_gasto" => new ApiExposedProperty("id_concepto_gasto", true, GET, array( "int" )),
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, GET, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EditarConceptoGasto( 
 			
			
			isset($_GET['id_concepto_gasto'] ) ? $_GET['id_concepto_gasto'] : null,
			isset($_GET['id_cuenta_contable'] ) ? $_GET['id_cuenta_contable'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoConceptoEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_concepto_gasto" => new ApiExposedProperty("id_concepto_gasto", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EliminarConceptoGasto( 
 			
			
			isset($_POST['id_concepto_gasto'] ) ? $_POST['id_concepto_gasto'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoConceptoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::NuevoConceptoIngreso( 
 			
			
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoConceptoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_concepto_ingreso" => new ApiExposedProperty("id_concepto_ingreso", true, POST, array( "int" )),
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EditarConceptoIngreso( 
 			
			
			isset($_POST['id_concepto_ingreso'] ) ? $_POST['id_concepto_ingreso'] : null,
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoConceptoEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_concepto_ingreso" => new ApiExposedProperty("id_concepto_ingreso", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EliminarConceptoIngreso( 
 			
			
			isset($_POST['id_concepto_ingreso'] ) ? $_POST['id_concepto_ingreso'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoConceptoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::ListaConceptoGasto( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoConceptoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::ListaConceptoIngreso( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_gasto" => new ApiExposedProperty("fecha_gasto", true, POST, array( "string" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, POST, array( "json" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"folio" => new ApiExposedProperty("folio", false, POST, array( "string" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, POST, array( "int" )),
			"id_concepto_gasto" => new ApiExposedProperty("id_concepto_gasto", false, POST, array( "int" )),
			"id_orden_de_servicio" => new ApiExposedProperty("id_orden_de_servicio", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"monto" => new ApiExposedProperty("monto", false, POST, array( "float" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::NuevoGasto( 
 			
			
			isset($_POST['fecha_gasto'] ) ? $_POST['fecha_gasto'] : null,
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['billetes'] ) ? json_decode($_POST['billetes']) : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['folio'] ) ? $_POST['folio'] :  null,
			isset($_POST['id_caja'] ) ? $_POST['id_caja'] :  null,
			isset($_POST['id_concepto_gasto'] ) ? $_POST['id_concepto_gasto'] :  null,
			isset($_POST['id_orden_de_servicio'] ) ? $_POST['id_orden_de_servicio'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['monto'] ) ? $_POST['monto'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_gasto" => new ApiExposedProperty("id_gasto", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"fecha_gasto" => new ApiExposedProperty("fecha_gasto", false, POST, array( "string" )),
			"folio" => new ApiExposedProperty("folio", false, POST, array( "string" )),
			"id_concepto_gasto" => new ApiExposedProperty("id_concepto_gasto", false, POST, array( "int" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EditarGasto( 
 			
			
			isset($_POST['id_gasto'] ) ? $_POST['id_gasto'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['fecha_gasto'] ) ? $_POST['fecha_gasto'] :  null,
			isset($_POST['folio'] ) ? $_POST['folio'] :  null,
			isset($_POST['id_concepto_gasto'] ) ? $_POST['id_concepto_gasto'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_ingreso" => new ApiExposedProperty("id_ingreso", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"fecha_ingreso" => new ApiExposedProperty("fecha_ingreso", false, POST, array( "string" )),
			"folio" => new ApiExposedProperty("folio", false, POST, array( "string" )),
			"id_concepto_ingreso" => new ApiExposedProperty("id_concepto_ingreso", false, POST, array( "int" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EditarIngreso( 
 			
			
			isset($_POST['id_ingreso'] ) ? $_POST['id_ingreso'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['fecha_ingreso'] ) ? $_POST['fecha_ingreso'] :  null,
			isset($_POST['folio'] ) ? $_POST['folio'] :  null,
			isset($_POST['id_concepto_ingreso'] ) ? $_POST['id_concepto_ingreso'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosAbonoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_deudor" => new ApiExposedProperty("id_deudor", true, POST, array( "int" )),
			"monto" => new ApiExposedProperty("monto", true, POST, array( "float" )),
			"tipo_pago" => new ApiExposedProperty("tipo_pago", true, POST, array( "string" )),
			"billetes" => new ApiExposedProperty("billetes", false, POST, array( "json" )),
			"cheques" => new ApiExposedProperty("cheques", false, POST, array( "json" )),
			"id_compra" => new ApiExposedProperty("id_compra", false, POST, array( "int" )),
			"id_prestamo" => new ApiExposedProperty("id_prestamo", false, POST, array( "int" )),
			"id_venta" => new ApiExposedProperty("id_venta", false, POST, array( "int" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::NuevoAbono( 
 			
			
			isset($_POST['id_deudor'] ) ? $_POST['id_deudor'] : null,
			isset($_POST['monto'] ) ? $_POST['monto'] : null,
			isset($_POST['tipo_pago'] ) ? $_POST['tipo_pago'] : null,
			isset($_POST['billetes'] ) ? json_decode($_POST['billetes']) : null,
			isset($_POST['cheques'] ) ? json_decode($_POST['cheques']) : null,
			isset($_POST['id_compra'] ) ? $_POST['id_compra'] :  null,
			isset($_POST['id_prestamo'] ) ? $_POST['id_prestamo'] :  null,
			isset($_POST['id_venta'] ) ? $_POST['id_venta'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_ingreso" => new ApiExposedProperty("fecha_ingreso", true, POST, array( "string" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, POST, array( "json" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"folio" => new ApiExposedProperty("folio", false, POST, array( "string" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, POST, array( "int" )),
			"id_concepto_ingreso" => new ApiExposedProperty("id_concepto_ingreso", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"monto" => new ApiExposedProperty("monto", false, POST, array( "float" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::NuevoIngreso( 
 			
			
			isset($_POST['fecha_ingreso'] ) ? $_POST['fecha_ingreso'] : null,
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['billetes'] ) ? json_decode($_POST['billetes']) : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['folio'] ) ? $_POST['folio'] :  null,
			isset($_POST['id_caja'] ) ? $_POST['id_caja'] :  null,
			isset($_POST['id_concepto_ingreso'] ) ? $_POST['id_concepto_ingreso'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['monto'] ) ? $_POST['monto'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosAbonoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_abono" => new ApiExposedProperty("id_abono", true, POST, array( "int" )),
			"compra" => new ApiExposedProperty("compra", false, POST, array( "bool" )),
			"motivo_cancelacion" => new ApiExposedProperty("motivo_cancelacion", false, POST, array( "string" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
			"prestamo" => new ApiExposedProperty("prestamo", false, POST, array( "bool" )),
			"venta" => new ApiExposedProperty("venta", false, POST, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EditarAbono( 
 			
			
			isset($_POST['id_abono'] ) ? $_POST['id_abono'] : null,
			isset($_POST['compra'] ) ? $_POST['compra'] :  null,
			isset($_POST['motivo_cancelacion'] ) ? $_POST['motivo_cancelacion'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null,
			isset($_POST['prestamo'] ) ? $_POST['prestamo'] :  null,
			isset($_POST['venta'] ) ? $_POST['venta'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosAbonoEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_abono" => new ApiExposedProperty("id_abono", true, POST, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, POST, array( "json" )),
			"compra" => new ApiExposedProperty("compra", false, POST, array( "bool" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, POST, array( "int" )),
			"motivo_cancelacion" => new ApiExposedProperty("motivo_cancelacion", false, POST, array( "string" )),
			"prestamo" => new ApiExposedProperty("prestamo", false, POST, array( "bool" )),
			"venta" => new ApiExposedProperty("venta", false, POST, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EliminarAbono( 
 			
			
			isset($_POST['id_abono'] ) ? $_POST['id_abono'] : null,
			isset($_POST['billetes'] ) ? json_decode($_POST['billetes']) : null,
			isset($_POST['compra'] ) ? $_POST['compra'] :  null,
			isset($_POST['id_caja'] ) ? $_POST['id_caja'] :  null,
			isset($_POST['motivo_cancelacion'] ) ? $_POST['motivo_cancelacion'] :  null,
			isset($_POST['prestamo'] ) ? $_POST['prestamo'] :  null,
			isset($_POST['venta'] ) ? $_POST['venta'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosAbonoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"compra" => new ApiExposedProperty("compra", true, GET, array( "bool" )),
			"prestamo" => new ApiExposedProperty("prestamo", true, GET, array( "bool" )),
			"venta" => new ApiExposedProperty("venta", true, GET, array( "bool" )),
			"cancelado" => new ApiExposedProperty("cancelado", false, GET, array( "bool" )),
			"fecha_actual" => new ApiExposedProperty("fecha_actual", false, GET, array( "bool" )),
			"fecha_maxima" => new ApiExposedProperty("fecha_maxima", false, GET, array( "string" )),
			"fecha_minima" => new ApiExposedProperty("fecha_minima", false, GET, array( "string" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
			"id_compra" => new ApiExposedProperty("id_compra", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_prestamo" => new ApiExposedProperty("id_prestamo", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", false, GET, array( "int" )),
			"id_venta" => new ApiExposedProperty("id_venta", false, GET, array( "int" )),
			"monto_igual_a" => new ApiExposedProperty("monto_igual_a", false, GET, array( "float" )),
			"monto_mayor_a" => new ApiExposedProperty("monto_mayor_a", false, GET, array( "float" )),
			"monto_menor_a" => new ApiExposedProperty("monto_menor_a", false, GET, array( "float" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::ListaAbono( 
 			
			
			isset($_GET['compra'] ) ? $_GET['compra'] : null,
			isset($_GET['prestamo'] ) ? $_GET['prestamo'] : null,
			isset($_GET['venta'] ) ? $_GET['venta'] : null,
			isset($_GET['cancelado'] ) ? $_GET['cancelado'] :  null,
			isset($_GET['fecha_actual'] ) ? $_GET['fecha_actual'] :  null,
			isset($_GET['fecha_maxima'] ) ? $_GET['fecha_maxima'] :  null,
			isset($_GET['fecha_minima'] ) ? $_GET['fecha_minima'] :  null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null,
			isset($_GET['id_compra'] ) ? $_GET['id_compra'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_prestamo'] ) ? $_GET['id_prestamo'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['id_usuario'] ) ? $_GET['id_usuario'] :  null,
			isset($_GET['id_venta'] ) ? $_GET['id_venta'] :  null,
			isset($_GET['monto_igual_a'] ) ? $_GET['monto_igual_a'] :  null,
			isset($_GET['monto_mayor_a'] ) ? $_GET['monto_mayor_a'] :  null,
			isset($_GET['monto_menor_a'] ) ? $_GET['monto_menor_a'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_gasto" => new ApiExposedProperty("id_gasto", true, POST, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, POST, array( "json" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, POST, array( "int" )),
			"motivo_cancelacion" => new ApiExposedProperty("motivo_cancelacion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EliminarGasto( 
 			
			
			isset($_POST['id_gasto'] ) ? $_POST['id_gasto'] : null,
			isset($_POST['billetes'] ) ? json_decode($_POST['billetes']) : null,
			isset($_POST['id_caja'] ) ? $_POST['id_caja'] :  null,
			isset($_POST['motivo_cancelacion'] ) ? $_POST['motivo_cancelacion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosGastoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cancelado" => new ApiExposedProperty("cancelado", false, GET, array( "bool" )),
			"fecha_actual" => new ApiExposedProperty("fecha_actual", false, GET, array( "bool" )),
			"fecha_final" => new ApiExposedProperty("fecha_final", false, GET, array( "string" )),
			"fecha_inicial" => new ApiExposedProperty("fecha_inicial", false, GET, array( "string" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
			"id_concepto_gasto" => new ApiExposedProperty("id_concepto_gasto", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_orden_servicio" => new ApiExposedProperty("id_orden_servicio", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", false, GET, array( "int" )),
			"monto_maximo" => new ApiExposedProperty("monto_maximo", false, GET, array( "float" )),
			"monto_minimo" => new ApiExposedProperty("monto_minimo", false, GET, array( "float" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::ListaGasto( 
 			
			
			isset($_GET['cancelado'] ) ? $_GET['cancelado'] :  null,
			isset($_GET['fecha_actual'] ) ? $_GET['fecha_actual'] :  null,
			isset($_GET['fecha_final'] ) ? $_GET['fecha_final'] :  null,
			isset($_GET['fecha_inicial'] ) ? $_GET['fecha_inicial'] :  null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null,
			isset($_GET['id_concepto_gasto'] ) ? $_GET['id_concepto_gasto'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_orden_servicio'] ) ? $_GET['id_orden_servicio'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['id_usuario'] ) ? $_GET['id_usuario'] :  null,
			isset($_GET['monto_maximo'] ) ? $_GET['monto_maximo'] :  null,
			isset($_GET['monto_minimo'] ) ? $_GET['monto_minimo'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_ingreso" => new ApiExposedProperty("id_ingreso", true, POST, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, POST, array( "json" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, POST, array( "int" )),
			"motivo_cancelacion" => new ApiExposedProperty("motivo_cancelacion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::EliminarIngreso( 
 			
			
			isset($_POST['id_ingreso'] ) ? $_POST['id_ingreso'] : null,
			isset($_POST['billetes'] ) ? json_decode($_POST['billetes']) : null,
			isset($_POST['id_caja'] ) ? $_POST['id_caja'] :  null,
			isset($_POST['motivo_cancelacion'] ) ? $_POST['motivo_cancelacion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCargosyabonosIngresoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cancelado" => new ApiExposedProperty("cancelado", false, GET, array( "bool" )),
			"fecha_actual" => new ApiExposedProperty("fecha_actual", false, GET, array( "bool" )),
			"fecha_final" => new ApiExposedProperty("fecha_final", false, GET, array( "string" )),
			"fecha_inicial" => new ApiExposedProperty("fecha_inicial", false, GET, array( "string" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
			"id_concepto_ingreso" => new ApiExposedProperty("id_concepto_ingreso", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::ListaIngreso( 
 			
			
			isset($_GET['cancelado'] ) ? $_GET['cancelado'] :  null,
			isset($_GET['fecha_actual'] ) ? $_GET['fecha_actual'] :  null,
			isset($_GET['fecha_final'] ) ? $_GET['fecha_final'] :  null,
			isset($_GET['fecha_inicial'] ) ? $_GET['fecha_inicial'] :  null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null,
			isset($_GET['id_concepto_ingreso'] ) ? $_GET['id_concepto_ingreso'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['id_usuario'] ) ? $_GET['id_usuario'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaVender extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descuento" => new ApiExposedProperty("descuento", true, POST, array( "float" )),
			"id_comprador" => new ApiExposedProperty("id_comprador", true, POST, array( "int" )),
			"impuesto" => new ApiExposedProperty("impuesto", true, POST, array( "float" )),
			"retencion" => new ApiExposedProperty("retencion", true, POST, array( "float" )),
			"subtotal" => new ApiExposedProperty("subtotal", true, POST, array( "float" )),
			"tipo_venta" => new ApiExposedProperty("tipo_venta", true, POST, array( "string" )),
			"total" => new ApiExposedProperty("total", true, POST, array( "float" )),
			"billetes_cambio" => new ApiExposedProperty("billetes_cambio", false, POST, array( "json" )),
			"billetes_pago" => new ApiExposedProperty("billetes_pago", false, POST, array( "json" )),
			"cheques" => new ApiExposedProperty("cheques", false, POST, array( "json" )),
			"detalle_orden" => new ApiExposedProperty("detalle_orden", false, POST, array( "json" )),
			"detalle_paquete" => new ApiExposedProperty("detalle_paquete", false, POST, array( "json" )),
			"detalle_producto" => new ApiExposedProperty("detalle_producto", false, POST, array( "json" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"id_venta_caja" => new ApiExposedProperty("id_venta_caja", false, POST, array( "int" )),
			"saldo" => new ApiExposedProperty("saldo", false, POST, array( "float" )),
			"tipo_pago" => new ApiExposedProperty("tipo_pago", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::VenderCaja( 
 			
			
			isset($_POST['descuento'] ) ? $_POST['descuento'] : null,
			isset($_POST['id_comprador'] ) ? $_POST['id_comprador'] : null,
			isset($_POST['impuesto'] ) ? $_POST['impuesto'] : null,
			isset($_POST['retencion'] ) ? $_POST['retencion'] : null,
			isset($_POST['subtotal'] ) ? $_POST['subtotal'] : null,
			isset($_POST['tipo_venta'] ) ? $_POST['tipo_venta'] : null,
			isset($_POST['total'] ) ? $_POST['total'] : null,
			isset($_POST['billetes_cambio'] ) ? json_decode($_POST['billetes_cambio']) : null,
			isset($_POST['billetes_pago'] ) ? json_decode($_POST['billetes_pago']) : null,
			isset($_POST['cheques'] ) ? json_decode($_POST['cheques']) : null,
			isset($_POST['detalle_orden'] ) ? json_decode($_POST['detalle_orden']) : null,
			isset($_POST['detalle_paquete'] ) ? json_decode($_POST['detalle_paquete']) : null,
			isset($_POST['detalle_producto'] ) ? json_decode($_POST['detalle_producto']) : null,
			isset($_POST['id_caja'] ) ? $_POST['id_caja'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['id_venta_caja'] ) ? $_POST['id_venta_caja'] :  null,
			isset($_POST['saldo'] ) ? $_POST['saldo'] :  "0",
			isset($_POST['tipo_pago'] ) ? $_POST['tipo_pago'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaComprar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descuento" => new ApiExposedProperty("descuento", true, GET, array( "float" )),
			"detalle" => new ApiExposedProperty("detalle", true, GET, array( "json" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", true, GET, array( "int" )),
			"id_vendedor" => new ApiExposedProperty("id_vendedor", true, GET, array( "int" )),
			"impuesto" => new ApiExposedProperty("impuesto", true, GET, array( "float" )),
			"retencion" => new ApiExposedProperty("retencion", true, GET, array( "float" )),
			"subtotal" => new ApiExposedProperty("subtotal", true, GET, array( "float" )),
			"tipo_compra" => new ApiExposedProperty("tipo_compra", true, GET, array( "string" )),
			"total" => new ApiExposedProperty("total", true, GET, array( "float" )),
			"billetes_cambio" => new ApiExposedProperty("billetes_cambio", false, GET, array( "json" )),
			"billetes_pago" => new ApiExposedProperty("billetes_pago", false, GET, array( "json" )),
			"cheques" => new ApiExposedProperty("cheques", false, GET, array( "json" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
			"id_compra_caja" => new ApiExposedProperty("id_compra_caja", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"saldo" => new ApiExposedProperty("saldo", false, GET, array( "float" )),
			"tipo_pago" => new ApiExposedProperty("tipo_pago", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::ComprarCaja( 
 			
			
			isset($_GET['descuento'] ) ? $_GET['descuento'] : null,
			isset($_GET['detalle'] ) ? json_decode($_GET['detalle']) : null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] : null,
			isset($_GET['id_vendedor'] ) ? $_GET['id_vendedor'] : null,
			isset($_GET['impuesto'] ) ? $_GET['impuesto'] : null,
			isset($_GET['retencion'] ) ? $_GET['retencion'] : null,
			isset($_GET['subtotal'] ) ? $_GET['subtotal'] : null,
			isset($_GET['tipo_compra'] ) ? $_GET['tipo_compra'] : null,
			isset($_GET['total'] ) ? $_GET['total'] : null,
			isset($_GET['billetes_cambio'] ) ? json_decode($_GET['billetes_cambio']) : null,
			isset($_GET['billetes_pago'] ) ? json_decode($_GET['billetes_pago']) : null,
			isset($_GET['cheques'] ) ? json_decode($_GET['cheques']) : null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null,
			isset($_GET['id_compra_caja'] ) ? $_GET['id_compra_caja'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['saldo'] ) ? $_GET['saldo'] :  "0",
			isset($_GET['tipo_pago'] ) ? $_GET['tipo_pago'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"limit" => new ApiExposedProperty("limit", false, POST, array( "int" )),
			"order" => new ApiExposedProperty("order", false, POST, array( "string" )),
			"order_by" => new ApiExposedProperty("order_by", false, POST, array( "string" )),
			"query" => new ApiExposedProperty("query", false, POST, array( "string" )),
			"start" => new ApiExposedProperty("start", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::Buscar( 
 			
			
			isset($_POST['activo'] ) ? $_POST['activo'] :  null,
			isset($_POST['limit'] ) ? $_POST['limit'] :  null,
			isset($_POST['order'] ) ? $_POST['order'] :  null,
			isset($_POST['order_by'] ) ? $_POST['order_by'] :  null,
			isset($_POST['query'] ) ? $_POST['query'] :  null,
			isset($_POST['start'] ) ? $_POST['start'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaAbrir extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"client_token" => new ApiExposedProperty("client_token", true, GET, array( "string" )),
			"control_billetes" => new ApiExposedProperty("control_billetes", true, GET, array( "bool" )),
			"id_caja" => new ApiExposedProperty("id_caja", true, GET, array( "int" )),
			"saldo" => new ApiExposedProperty("saldo", true, GET, array( "float" )),
			"billetes" => new ApiExposedProperty("billetes", false, GET, array( "json" )),
			"id_cajero" => new ApiExposedProperty("id_cajero", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::AbrirCaja( 
 			
			
			isset($_GET['client_token'] ) ? $_GET['client_token'] : null,
			isset($_GET['control_billetes'] ) ? $_GET['control_billetes'] : null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null,
			isset($_GET['saldo'] ) ? $_GET['saldo'] : null,
			isset($_GET['billetes'] ) ? json_decode($_GET['billetes']) : null,
			isset($_GET['id_cajero'] ) ? $_GET['id_cajero'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"direccion" => new ApiExposedProperty("direccion", true, POST, array( "json" )),
			"id_tarifa" => new ApiExposedProperty("id_tarifa", true, POST, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"id_gerente" => new ApiExposedProperty("id_gerente", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::Nueva( 
 			
			
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['direccion'] ) ? json_decode($_POST['direccion']) : null,
			isset($_POST['id_tarifa'] ) ? $_POST['id_tarifa'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  1 ,
			isset($_POST['id_gerente'] ) ? $_POST['id_gerente'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, POST, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"direccion" => new ApiExposedProperty("direccion", false, POST, array( "json" )),
			"id_gerente" => new ApiExposedProperty("id_gerente", false, POST, array( "int" )),
			"id_tarifa" => new ApiExposedProperty("id_tarifa", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::Editar( 
 			
			
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['direccion'] ) ? json_decode($_POST['direccion']) : null,
			isset($_POST['id_gerente'] ) ? $_POST['id_gerente'] :  null,
			isset($_POST['id_tarifa'] ) ? $_POST['id_tarifa'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalGerenciaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_gerente" => new ApiExposedProperty("id_gerente", true, GET, array( "string" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::EditarGerencia( 
 			
			
			isset($_GET['id_gerente'] ) ? $_GET['id_gerente'] : null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaCerrar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_caja" => new ApiExposedProperty("id_caja", true, GET, array( "int" )),
			"saldo_real" => new ApiExposedProperty("saldo_real", true, GET, array( "float" )),
			"billetes" => new ApiExposedProperty("billetes", false, GET, array( "json" )),
			"id_cajero" => new ApiExposedProperty("id_cajero", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::CerrarCaja( 
 			
			
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null,
			isset($_GET['saldo_real'] ) ? $_GET['saldo_real'] : null,
			isset($_GET['billetes'] ) ? json_decode($_GET['billetes']) : null,
			isset($_GET['id_cajero'] ) ? $_GET['id_cajero'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"token" => new ApiExposedProperty("token", true, POST, array( "string" )),
			"basculas" => new ApiExposedProperty("basculas", false, POST, array( "json" )),
			"control_billetes" => new ApiExposedProperty("control_billetes", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"impresoras" => new ApiExposedProperty("impresoras", false, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::NuevaCaja( 
 			
			
			isset($_POST['token'] ) ? $_POST['token'] : null,
			isset($_POST['basculas'] ) ? json_decode($_POST['basculas']) : null,
			isset($_POST['control_billetes'] ) ? $_POST['control_billetes'] :  0 ,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['impresoras'] ) ? json_decode($_POST['impresoras']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaCorte extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_caja" => new ApiExposedProperty("id_caja", true, GET, array( "int" )),
			"saldo_final" => new ApiExposedProperty("saldo_final", true, GET, array( "float" )),
			"saldo_real" => new ApiExposedProperty("saldo_real", true, GET, array( "float" )),
			"billetes_dejados" => new ApiExposedProperty("billetes_dejados", false, GET, array( "json" )),
			"billetes_encontrados" => new ApiExposedProperty("billetes_encontrados", false, GET, array( "json" )),
			"id_cajero" => new ApiExposedProperty("id_cajero", false, GET, array( "int" )),
			"id_cajero_nuevo" => new ApiExposedProperty("id_cajero_nuevo", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::CorteCaja( 
 			
			
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null,
			isset($_GET['saldo_final'] ) ? $_GET['saldo_final'] : null,
			isset($_GET['saldo_real'] ) ? $_GET['saldo_real'] : null,
			isset($_GET['billetes_dejados'] ) ? json_decode($_GET['billetes_dejados']) : null,
			isset($_GET['billetes_encontrados'] ) ? json_decode($_GET['billetes_encontrados']) : null,
			isset($_GET['id_cajero'] ) ? $_GET['id_cajero'] :  null,
			isset($_GET['id_cajero_nuevo'] ) ? $_GET['id_cajero_nuevo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_caja" => new ApiExposedProperty("id_caja", true, GET, array( "int" )),
			"control_billetes" => new ApiExposedProperty("control_billetes", false, GET, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"token" => new ApiExposedProperty("token", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::EditarCaja( 
 			
			
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null,
			isset($_GET['control_billetes'] ) ? $_GET['control_billetes'] :  null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['token'] ) ? $_GET['token'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_caja" => new ApiExposedProperty("id_caja", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::EliminarCaja( 
 			
			
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::Eliminar( 
 			
			
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCajaLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::ListaCaja( 
 			
			
			isset($_GET['activa'] ) ? $_GET['activa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalCorte extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_final" => new ApiExposedProperty("fecha_final", true, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, POST, array( "int" )),
			"total_efectivo" => new ApiExposedProperty("total_efectivo", true, POST, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::Corte( 
 			
			
			isset($_POST['fecha_final'] ) ? $_POST['fecha_final'] : null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] : null,
			isset($_POST['total_efectivo'] ) ? $_POST['total_efectivo'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiSucursalDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::Detalles( 
 			
			
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiVentasDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_venta" => new ApiExposedProperty("id_venta", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = VentasController::Detalle( 
 			
			
			isset($_GET['id_venta'] ) ? $_GET['id_venta'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiVentasLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"canceladas" => new ApiExposedProperty("canceladas", false, GET, array( "bool" )),
			"id_cliente" => new ApiExposedProperty("id_cliente", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"liquidados" => new ApiExposedProperty("liquidados", false, GET, array( "bool" )),
			"ordenar" => new ApiExposedProperty("ordenar", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = VentasController::Lista( 
 			
			
			isset($_GET['canceladas'] ) ? $_GET['canceladas'] :  null,
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['liquidados'] ) ? $_GET['liquidados'] :  null,
			isset($_GET['ordenar'] ) ? $_GET['ordenar'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiVentasCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_venta" => new ApiExposedProperty("id_venta", true, GET, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, GET, array( "json" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = VentasController::Cancelar( 
 			
			
			isset($_GET['id_venta'] ) ? $_GET['id_venta'] : null,
			isset($_GET['billetes'] ) ? json_decode($_GET['billetes']) : null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiVentasNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descuento" => new ApiExposedProperty("descuento", true, POST, array( "float" )),
			"id_comprador_venta" => new ApiExposedProperty("id_comprador_venta", true, POST, array( "int" )),
			"impuesto" => new ApiExposedProperty("impuesto", true, POST, array( "float" )),
			"subtotal" => new ApiExposedProperty("subtotal", true, POST, array( "float" )),
			"tipo_venta" => new ApiExposedProperty("tipo_venta", true, POST, array( "string" )),
			"total" => new ApiExposedProperty("total", true, POST, array( "float" )),
			"datos_cheque" => new ApiExposedProperty("datos_cheque", false, POST, array( "json" )),
			"detalle_orden" => new ApiExposedProperty("detalle_orden", false, POST, array( "json" )),
			"detalle_paquete" => new ApiExposedProperty("detalle_paquete", false, POST, array( "json" )),
			"detalle_venta" => new ApiExposedProperty("detalle_venta", false, POST, array( "json" )),
			"es_cotizacion" => new ApiExposedProperty("es_cotizacion", false, POST, array( "bool" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"saldo" => new ApiExposedProperty("saldo", false, POST, array( "float" )),
			"tipo_de_pago" => new ApiExposedProperty("tipo_de_pago", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = VentasController::Nueva( 
 			
			
			isset($_POST['descuento'] ) ? $_POST['descuento'] : null,
			isset($_POST['id_comprador_venta'] ) ? $_POST['id_comprador_venta'] : null,
			isset($_POST['impuesto'] ) ? $_POST['impuesto'] : null,
			isset($_POST['subtotal'] ) ? $_POST['subtotal'] : null,
			isset($_POST['tipo_venta'] ) ? $_POST['tipo_venta'] : null,
			isset($_POST['total'] ) ? $_POST['total'] : null,
			isset($_POST['datos_cheque'] ) ? json_decode($_POST['datos_cheque']) : null,
			isset($_POST['detalle_orden'] ) ? json_decode($_POST['detalle_orden']) : null,
			isset($_POST['detalle_paquete'] ) ? json_decode($_POST['detalle_paquete']) : null,
			isset($_POST['detalle_venta'] ) ? json_decode($_POST['detalle_venta']) : null,
			isset($_POST['es_cotizacion'] ) ? $_POST['es_cotizacion'] :  false ,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['saldo'] ) ? $_POST['saldo'] :  "0",
			isset($_POST['tipo_de_pago'] ) ? $_POST['tipo_de_pago'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiVentasNuevaVentaArpillas extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"arpillas" => new ApiExposedProperty("arpillas", true, GET, array( "float" )),
			"fecha_origen" => new ApiExposedProperty("fecha_origen", true, GET, array( "string" )),
			"id_venta" => new ApiExposedProperty("id_venta", true, GET, array( "int" )),
			"merma_por_arpilla" => new ApiExposedProperty("merma_por_arpilla", true, GET, array( "float" )),
			"peso_destino" => new ApiExposedProperty("peso_destino", true, GET, array( "float" )),
			"peso_origen" => new ApiExposedProperty("peso_origen", true, GET, array( "float" )),
			"peso_por_arpilla" => new ApiExposedProperty("peso_por_arpilla", true, GET, array( "float" )),
			"folio" => new ApiExposedProperty("folio", false, GET, array( "string" )),
			"numero_de_viaje" => new ApiExposedProperty("numero_de_viaje", false, GET, array( "string" )),
			"productor" => new ApiExposedProperty("productor", false, GET, array( "string" )),
			"total_origen" => new ApiExposedProperty("total_origen", false, GET, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = VentasController::ArpillasVentaNueva( 
 			
			
			isset($_GET['arpillas'] ) ? $_GET['arpillas'] : null,
			isset($_GET['fecha_origen'] ) ? $_GET['fecha_origen'] : null,
			isset($_GET['id_venta'] ) ? $_GET['id_venta'] : null,
			isset($_GET['merma_por_arpilla'] ) ? $_GET['merma_por_arpilla'] : null,
			isset($_GET['peso_destino'] ) ? $_GET['peso_destino'] : null,
			isset($_GET['peso_origen'] ) ? $_GET['peso_origen'] : null,
			isset($_GET['peso_por_arpilla'] ) ? $_GET['peso_por_arpilla'] : null,
			isset($_GET['folio'] ) ? $_GET['folio'] :  null,
			isset($_GET['numero_de_viaje'] ) ? $_GET['numero_de_viaje'] :  null,
			isset($_GET['productor'] ) ? $_GET['productor'] :  null,
			isset($_GET['total_origen'] ) ? $_GET['total_origen'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiVentasDetalleVentaArpilla extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_venta" => new ApiExposedProperty("id_venta", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = VentasController::ArpillaVentaDetalle( 
 			
			
			isset($_GET['id_venta'] ) ? $_GET['id_venta'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::Lista( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"codigo_proveedor" => new ApiExposedProperty("codigo_proveedor", true, POST, array( "string" )),
			"id_tipo_proveedor" => new ApiExposedProperty("id_tipo_proveedor", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"password" => new ApiExposedProperty("password", true, POST, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"cuenta_bancaria" => new ApiExposedProperty("cuenta_bancaria", false, POST, array( "string" )),
			"dias_de_credito" => new ApiExposedProperty("dias_de_credito", false, POST, array( "int" )),
			"dias_embarque" => new ApiExposedProperty("dias_embarque", false, POST, array( "int" )),
			"direcciones" => new ApiExposedProperty("direcciones", false, POST, array( "json" )),
			"direccion_web" => new ApiExposedProperty("direccion_web", false, POST, array( "string" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, POST, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"limite_credito" => new ApiExposedProperty("limite_credito", false, POST, array( "float" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"rfc" => new ApiExposedProperty("rfc", false, POST, array( "string" )),
			"telefono_personal1" => new ApiExposedProperty("telefono_personal1", false, POST, array( "string" )),
			"telefono_personal2" => new ApiExposedProperty("telefono_personal2", false, POST, array( "string" )),
			"tiempo_entrega" => new ApiExposedProperty("tiempo_entrega", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::Nuevo( 
 			
			
			isset($_POST['codigo_proveedor'] ) ? $_POST['codigo_proveedor'] : null,
			isset($_POST['id_tipo_proveedor'] ) ? $_POST['id_tipo_proveedor'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['password'] ) ? $_POST['password'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  null,
			isset($_POST['cuenta_bancaria'] ) ? $_POST['cuenta_bancaria'] :  null,
			isset($_POST['dias_de_credito'] ) ? $_POST['dias_de_credito'] :  null,
			isset($_POST['dias_embarque'] ) ? $_POST['dias_embarque'] :  true ,
			isset($_POST['direcciones'] ) ? json_decode($_POST['direcciones']) : null,
			isset($_POST['direccion_web'] ) ? $_POST['direccion_web'] :  null,
			isset($_POST['email'] ) ? $_POST['email'] :  null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  null,
			isset($_POST['id_tarifa_compra'] ) ? $_POST['id_tarifa_compra'] :  null,
			isset($_POST['id_tarifa_venta'] ) ? $_POST['id_tarifa_venta'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['limite_credito'] ) ? $_POST['limite_credito'] :  null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] :  null,
			isset($_POST['retenciones'] ) ? json_decode($_POST['retenciones']) : null,
			isset($_POST['rfc'] ) ? $_POST['rfc'] :  null,
			isset($_POST['telefono_personal1'] ) ? $_POST['telefono_personal1'] :  null,
			isset($_POST['telefono_personal2'] ) ? $_POST['telefono_personal2'] :  null,
			isset($_POST['tiempo_entrega'] ) ? $_POST['tiempo_entrega'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_proveedor" => new ApiExposedProperty("id_proveedor", true, GET, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"codigo_proveedor" => new ApiExposedProperty("codigo_proveedor", false, GET, array( "string" )),
			"cuenta_bancaria" => new ApiExposedProperty("cuenta_bancaria", false, GET, array( "string" )),
			"dias_de_credito" => new ApiExposedProperty("dias_de_credito", false, GET, array( "int" )),
			"dias_embarque" => new ApiExposedProperty("dias_embarque", false, GET, array( "int" )),
			"direcciones" => new ApiExposedProperty("direcciones", false, GET, array( "json" )),
			"direccion_web" => new ApiExposedProperty("direccion_web", false, GET, array( "string" )),
			"email" => new ApiExposedProperty("email", false, GET, array( "string" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, GET, array( "int" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, GET, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, GET, array( "int" )),
			"id_tipo_proveedor" => new ApiExposedProperty("id_tipo_proveedor", false, GET, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, GET, array( "json" )),
			"limite_credito" => new ApiExposedProperty("limite_credito", false, GET, array( "float" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
			"password" => new ApiExposedProperty("password", false, GET, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, GET, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, GET, array( "json" )),
			"rfc" => new ApiExposedProperty("rfc", false, GET, array( "string" )),
			"telefono_personal" => new ApiExposedProperty("telefono_personal", false, GET, array( "string" )),
			"tiempo_entrega" => new ApiExposedProperty("tiempo_entrega", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::Editar( 
 			
			
			isset($_GET['id_proveedor'] ) ? $_GET['id_proveedor'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  1 ,
			isset($_GET['codigo_proveedor'] ) ? $_GET['codigo_proveedor'] :  null,
			isset($_GET['cuenta_bancaria'] ) ? $_GET['cuenta_bancaria'] :  null,
			isset($_GET['dias_de_credito'] ) ? $_GET['dias_de_credito'] :  null,
			isset($_GET['dias_embarque'] ) ? $_GET['dias_embarque'] :  null,
			isset($_GET['direcciones'] ) ? json_decode($_GET['direcciones']) : null,
			isset($_GET['direccion_web'] ) ? $_GET['direccion_web'] :  null,
			isset($_GET['email'] ) ? $_GET['email'] :  null,
			isset($_GET['id_moneda'] ) ? $_GET['id_moneda'] :  null,
			isset($_GET['id_tarifa_compra'] ) ? $_GET['id_tarifa_compra'] :  null,
			isset($_GET['id_tarifa_venta'] ) ? $_GET['id_tarifa_venta'] :  null,
			isset($_GET['id_tipo_proveedor'] ) ? $_GET['id_tipo_proveedor'] :  null,
			isset($_GET['impuestos'] ) ? json_decode($_GET['impuestos']) : null,
			isset($_GET['limite_credito'] ) ? $_GET['limite_credito'] :  null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null,
			isset($_GET['password'] ) ? $_GET['password'] :  null,
			isset($_GET['representante_legal'] ) ? $_GET['representante_legal'] :  null,
			isset($_GET['retenciones'] ) ? json_decode($_GET['retenciones']) : null,
			isset($_GET['rfc'] ) ? $_GET['rfc'] :  null,
			isset($_GET['telefono_personal'] ) ? $_GET['telefono_personal'] :  null,
			isset($_GET['tiempo_entrega'] ) ? $_GET['tiempo_entrega'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_proveedor" => new ApiExposedProperty("id_proveedor", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::Eliminar( 
 			
			
			isset($_GET['id_proveedor'] ) ? $_GET['id_proveedor'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorClasificacionNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre" => new ApiExposedProperty("nombre", true, GET, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, GET, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, GET, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, GET, array( "json" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::NuevaClasificacion( 
 			
			
			isset($_GET['nombre'] ) ? $_GET['nombre'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['id_tarifa_compra'] ) ? $_GET['id_tarifa_compra'] :  null,
			isset($_GET['id_tarifa_venta'] ) ? $_GET['id_tarifa_venta'] :  null,
			isset($_GET['impuestos'] ) ? json_decode($_GET['impuestos']) : null,
			isset($_GET['retenciones'] ) ? json_decode($_GET['retenciones']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorClasificacionEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_clasificacion_proveedor" => new ApiExposedProperty("id_clasificacion_proveedor", true, GET, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"id_tarifa_compra" => new ApiExposedProperty("id_tarifa_compra", false, GET, array( "int" )),
			"id_tarifa_venta" => new ApiExposedProperty("id_tarifa_venta", false, GET, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, GET, array( "json" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::EditarClasificacion( 
 			
			
			isset($_GET['id_clasificacion_proveedor'] ) ? $_GET['id_clasificacion_proveedor'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['id_tarifa_compra'] ) ? $_GET['id_tarifa_compra'] :  null,
			isset($_GET['id_tarifa_venta'] ) ? $_GET['id_tarifa_venta'] :  null,
			isset($_GET['impuestos'] ) ? json_decode($_GET['impuestos']) : null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null,
			isset($_GET['retenciones'] ) ? json_decode($_GET['retenciones']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorClasificacionEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_clasificacion_proveedor" => new ApiExposedProperty("id_clasificacion_proveedor", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::EliminarClasificacion( 
 			
			
			isset($_GET['id_clasificacion_proveedor'] ) ? $_GET['id_clasificacion_proveedor'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProveedorClasificacionLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProveedoresController::ListaClasificacion( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiComprasNuevaCompraArpilla extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"arpillas" => new ApiExposedProperty("arpillas", true, GET, array( "float" )),
			"id_compra" => new ApiExposedProperty("id_compra", true, GET, array( "int" )),
			"merma_por_arpilla" => new ApiExposedProperty("merma_por_arpilla", true, GET, array( "float" )),
			"peso_por_arpilla" => new ApiExposedProperty("peso_por_arpilla", true, GET, array( "float" )),
			"peso_recibido" => new ApiExposedProperty("peso_recibido", true, GET, array( "float" )),
			"total_origen" => new ApiExposedProperty("total_origen", true, GET, array( "float" )),
			"fecha_origen" => new ApiExposedProperty("fecha_origen", false, GET, array( "string" )),
			"folio" => new ApiExposedProperty("folio", false, GET, array( "string" )),
			"numero_de_viaje" => new ApiExposedProperty("numero_de_viaje", false, GET, array( "string" )),
			"peso_origen" => new ApiExposedProperty("peso_origen", false, GET, array( "float" )),
			"productor" => new ApiExposedProperty("productor", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ComprasController::ArpillaCompraNueva( 
 			
			
			isset($_GET['arpillas'] ) ? $_GET['arpillas'] : null,
			isset($_GET['id_compra'] ) ? $_GET['id_compra'] : null,
			isset($_GET['merma_por_arpilla'] ) ? $_GET['merma_por_arpilla'] : null,
			isset($_GET['peso_por_arpilla'] ) ? $_GET['peso_por_arpilla'] : null,
			isset($_GET['peso_recibido'] ) ? $_GET['peso_recibido'] : null,
			isset($_GET['total_origen'] ) ? $_GET['total_origen'] : null,
			isset($_GET['fecha_origen'] ) ? $_GET['fecha_origen'] :  null,
			isset($_GET['folio'] ) ? $_GET['folio'] :  null,
			isset($_GET['numero_de_viaje'] ) ? $_GET['numero_de_viaje'] :  null,
			isset($_GET['peso_origen'] ) ? $_GET['peso_origen'] :  null,
			isset($_GET['productor'] ) ? $_GET['productor'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiComprasDetalleCompraArpilla extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_compra" => new ApiExposedProperty("id_compra", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ComprasController::ArpillaCompraDetalle( 
 			
			
			isset($_GET['id_compra'] ) ? $_GET['id_compra'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiComprasNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descuento" => new ApiExposedProperty("descuento", true, POST, array( "float" )),
			"detalle" => new ApiExposedProperty("detalle", true, POST, array( "json" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"id_usuario_compra" => new ApiExposedProperty("id_usuario_compra", true, POST, array( "int" )),
			"impuesto" => new ApiExposedProperty("impuesto", true, POST, array( "float" )),
			"retencion" => new ApiExposedProperty("retencion", true, POST, array( "float" )),
			"subtotal" => new ApiExposedProperty("subtotal", true, POST, array( "float" )),
			"tipo_compra" => new ApiExposedProperty("tipo_compra", true, POST, array( "string" )),
			"total" => new ApiExposedProperty("total", true, POST, array( "float" )),
			"cheques" => new ApiExposedProperty("cheques", false, POST, array( "json" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"saldo" => new ApiExposedProperty("saldo", false, POST, array( "float" )),
			"tipo_de_pago" => new ApiExposedProperty("tipo_de_pago", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ComprasController::Nueva( 
 			
			
			isset($_POST['descuento'] ) ? $_POST['descuento'] : null,
			isset($_POST['detalle'] ) ? json_decode($_POST['detalle']) : null,
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['id_usuario_compra'] ) ? $_POST['id_usuario_compra'] : null,
			isset($_POST['impuesto'] ) ? $_POST['impuesto'] : null,
			isset($_POST['retencion'] ) ? $_POST['retencion'] : null,
			isset($_POST['subtotal'] ) ? $_POST['subtotal'] : null,
			isset($_POST['tipo_compra'] ) ? $_POST['tipo_compra'] : null,
			isset($_POST['total'] ) ? $_POST['total'] : null,
			isset($_POST['cheques'] ) ? json_decode($_POST['cheques']) : null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['saldo'] ) ? $_POST['saldo'] :  "0",
			isset($_POST['tipo_de_pago'] ) ? $_POST['tipo_de_pago'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiComprasCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_compra" => new ApiExposedProperty("id_compra", true, GET, array( "int" )),
			"billetes" => new ApiExposedProperty("billetes", false, GET, array( "json" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ComprasController::Cancelar( 
 			
			
			isset($_GET['id_compra'] ) ? $_GET['id_compra'] : null,
			isset($_GET['billetes'] ) ? json_decode($_GET['billetes']) : null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiComprasDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_compra" => new ApiExposedProperty("id_compra", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ComprasController::Detalle( 
 			
			
			isset($_GET['id_compra'] ) ? $_GET['id_compra'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiComprasLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cancelada" => new ApiExposedProperty("cancelada", false, GET, array( "bool" )),
			"fecha_final" => new ApiExposedProperty("fecha_final", false, GET, array( "string" )),
			"fecha_inicial" => new ApiExposedProperty("fecha_inicial", false, GET, array( "string" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"id_usuario" => new ApiExposedProperty("id_usuario", false, GET, array( "int" )),
			"id_vendedor_compra" => new ApiExposedProperty("id_vendedor_compra", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
			"saldada" => new ApiExposedProperty("saldada", false, GET, array( "bool" )),
			"tipo_compra" => new ApiExposedProperty("tipo_compra", false, GET, array( "string" )),
			"tipo_pago" => new ApiExposedProperty("tipo_pago", false, GET, array( "string" )),
			"total_maximo" => new ApiExposedProperty("total_maximo", false, GET, array( "float" )),
			"total_minimo" => new ApiExposedProperty("total_minimo", false, GET, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ComprasController::Lista( 
 			
			
			isset($_GET['cancelada'] ) ? $_GET['cancelada'] :  null,
			isset($_GET['fecha_final'] ) ? $_GET['fecha_final'] :  null,
			isset($_GET['fecha_inicial'] ) ? $_GET['fecha_inicial'] :  null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['id_usuario'] ) ? $_GET['id_usuario'] :  null,
			isset($_GET['id_vendedor_compra'] ) ? $_GET['id_vendedor_compra'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null,
			isset($_GET['saldada'] ) ? $_GET['saldada'] :  null,
			isset($_GET['tipo_compra'] ) ? $_GET['tipo_compra'] :  null,
			isset($_GET['tipo_pago'] ) ? $_GET['tipo_pago'] :  null,
			isset($_GET['total_maximo'] ) ? $_GET['total_maximo'] :  null,
			isset($_GET['total_minimo'] ) ? $_GET['total_minimo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_carro" => new ApiExposedProperty("id_carro", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Detalle( 
 			
			
			isset($_GET['id_carro'] ) ? $_GET['id_carro'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_estado" => new ApiExposedProperty("id_estado", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Lista( 
 			
			
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_estado'] ) ? $_GET['id_estado'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_estado" => new ApiExposedProperty("id_estado", true, GET, array( "int" )),
			"id_localizacion" => new ApiExposedProperty("id_localizacion", true, GET, array( "int" )),
			"id_marca_carro" => new ApiExposedProperty("id_marca_carro", true, GET, array( "int" )),
			"id_modelo_vehiculo" => new ApiExposedProperty("id_modelo_vehiculo", true, GET, array( "int" )),
			"id_tipo_carro" => new ApiExposedProperty("id_tipo_carro", true, GET, array( "int" )),
			"imagen" => new ApiExposedProperty("imagen", true, GET, array( "string" )),
			"codigo" => new ApiExposedProperty("codigo", false, GET, array( "string" )),
			"combustible" => new ApiExposedProperty("combustible", false, GET, array( "float" )),
			"ids_empresas" => new ApiExposedProperty("ids_empresas", false, GET, array( "json" )),
			"kilometros" => new ApiExposedProperty("kilometros", false, GET, array( "float" )),
			"km_por_litro" => new ApiExposedProperty("km_por_litro", false, GET, array( "float" )),
			"matricula" => new ApiExposedProperty("matricula", false, GET, array( "string" )),
			"num_neumaticos" => new ApiExposedProperty("num_neumaticos", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Nuevo( 
 			
			
			isset($_GET['id_estado'] ) ? $_GET['id_estado'] : null,
			isset($_GET['id_localizacion'] ) ? $_GET['id_localizacion'] : null,
			isset($_GET['id_marca_carro'] ) ? $_GET['id_marca_carro'] : null,
			isset($_GET['id_modelo_vehiculo'] ) ? $_GET['id_modelo_vehiculo'] : null,
			isset($_GET['id_tipo_carro'] ) ? $_GET['id_tipo_carro'] : null,
			isset($_GET['imagen'] ) ? $_GET['imagen'] : null,
			isset($_GET['codigo'] ) ? $_GET['codigo'] :  null,
			isset($_GET['combustible'] ) ? $_GET['combustible'] :  null,
			isset($_GET['ids_empresas'] ) ? json_decode($_GET['ids_empresas']) : null,
			isset($_GET['kilometros'] ) ? $_GET['kilometros'] :  null,
			isset($_GET['km_por_litro'] ) ? $_GET['km_por_litro'] :  null,
			isset($_GET['matricula'] ) ? $_GET['matricula'] :  null,
			isset($_GET['num_neumaticos'] ) ? $_GET['num_neumaticos'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroCargar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_carro" => new ApiExposedProperty("id_carro", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Cargar( 
 			
			
			isset($_GET['id_carro'] ) ? $_GET['id_carro'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroDescargar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_carro" => new ApiExposedProperty("id_carro", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Descargar( 
 			
			
			isset($_GET['id_carro'] ) ? $_GET['id_carro'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroTransbordo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_carro_destino" => new ApiExposedProperty("id_carro_destino", true, GET, array( "int" )),
			"id_carro_origen" => new ApiExposedProperty("id_carro_origen", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Transbordo( 
 			
			
			isset($_GET['id_carro_destino'] ) ? $_GET['id_carro_destino'] : null,
			isset($_GET['id_carro_origen'] ) ? $_GET['id_carro_origen'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroEnrutar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_llegada_tentativa" => new ApiExposedProperty("fecha_llegada_tentativa", true, GET, array( "string" )),
			"fecha_salida" => new ApiExposedProperty("fecha_salida", true, GET, array( "string" )),
			"id_carro" => new ApiExposedProperty("id_carro", true, GET, array( "int" )),
			"id_sucursal_destino" => new ApiExposedProperty("id_sucursal_destino", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Enrutar( 
 			
			
			isset($_GET['fecha_llegada_tentativa'] ) ? $_GET['fecha_llegada_tentativa'] : null,
			isset($_GET['fecha_salida'] ) ? $_GET['fecha_salida'] : null,
			isset($_GET['id_carro'] ) ? $_GET['id_carro'] : null,
			isset($_GET['id_sucursal_destino'] ) ? $_GET['id_sucursal_destino'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroRegistrarLlegada extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_carro" => new ApiExposedProperty("id_carro", true, GET, array( "int" )),
			"fecha_llegada" => new ApiExposedProperty("fecha_llegada", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::LlegadaRegistrar( 
 			
			
			isset($_GET['id_carro'] ) ? $_GET['id_carro'] : null,
			isset($_GET['fecha_llegada'] ) ? $_GET['fecha_llegada'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_carro" => new ApiExposedProperty("id_carro", true, GET, array( "int" )),
			"codigo" => new ApiExposedProperty("codigo", false, GET, array( "string" )),
			"combustible" => new ApiExposedProperty("combustible", false, GET, array( "float" )),
			"ids_empresas" => new ApiExposedProperty("ids_empresas", false, GET, array( "json" )),
			"id_estado" => new ApiExposedProperty("id_estado", false, GET, array( "int" )),
			"id_localizacion" => new ApiExposedProperty("id_localizacion", false, GET, array( "int" )),
			"id_marca_carro" => new ApiExposedProperty("id_marca_carro", false, GET, array( "int" )),
			"id_modelo_vehiculo" => new ApiExposedProperty("id_modelo_vehiculo", false, GET, array( "int" )),
			"id_tipo_carro" => new ApiExposedProperty("id_tipo_carro", false, GET, array( "int" )),
			"imagen" => new ApiExposedProperty("imagen", false, GET, array( "string" )),
			"kilometros" => new ApiExposedProperty("kilometros", false, GET, array( "float" )),
			"km_por_litro" => new ApiExposedProperty("km_por_litro", false, GET, array( "float" )),
			"matricula" => new ApiExposedProperty("matricula", false, GET, array( "string" )),
			"num_neumaticos" => new ApiExposedProperty("num_neumaticos", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::Editar( 
 			
			
			isset($_GET['id_carro'] ) ? $_GET['id_carro'] : null,
			isset($_GET['codigo'] ) ? $_GET['codigo'] :  null,
			isset($_GET['combustible'] ) ? $_GET['combustible'] :  null,
			isset($_GET['ids_empresas'] ) ? json_decode($_GET['ids_empresas']) : null,
			isset($_GET['id_estado'] ) ? $_GET['id_estado'] :  null,
			isset($_GET['id_localizacion'] ) ? $_GET['id_localizacion'] :  null,
			isset($_GET['id_marca_carro'] ) ? $_GET['id_marca_carro'] :  null,
			isset($_GET['id_modelo_vehiculo'] ) ? $_GET['id_modelo_vehiculo'] :  null,
			isset($_GET['id_tipo_carro'] ) ? $_GET['id_tipo_carro'] :  null,
			isset($_GET['imagen'] ) ? $_GET['imagen'] :  null,
			isset($_GET['kilometros'] ) ? $_GET['kilometros'] :  null,
			isset($_GET['km_por_litro'] ) ? $_GET['km_por_litro'] :  null,
			isset($_GET['matricula'] ) ? $_GET['matricula'] :  null,
			isset($_GET['num_neumaticos'] ) ? $_GET['num_neumaticos'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroTipoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre_tipo" => new ApiExposedProperty("nombre_tipo", true, GET, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::NuevoTipo( 
 			
			
			isset($_GET['nombre_tipo'] ) ? $_GET['nombre_tipo'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  true 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroTipoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tipo_carro" => new ApiExposedProperty("id_tipo_carro", true, GET, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"nombre_tipo_carro" => new ApiExposedProperty("nombre_tipo_carro", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::EditarTipo( 
 			
			
			isset($_GET['id_tipo_carro'] ) ? $_GET['id_tipo_carro'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  true ,
			isset($_GET['nombre_tipo_carro'] ) ? $_GET['nombre_tipo_carro'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroModeloNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre_modelo" => new ApiExposedProperty("nombre_modelo", true, GET, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::NuevoModelo( 
 			
			
			isset($_GET['nombre_modelo'] ) ? $_GET['nombre_modelo'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  true 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroModeloEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_modelo_carro" => new ApiExposedProperty("id_modelo_carro", true, GET, array( "int" )),
			"nombre_modelo_carro" => new ApiExposedProperty("nombre_modelo_carro", true, GET, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::EditarModelo( 
 			
			
			isset($_GET['id_modelo_carro'] ) ? $_GET['id_modelo_carro'] : null,
			isset($_GET['nombre_modelo_carro'] ) ? $_GET['nombre_modelo_carro'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  true 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroMarcaNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre_marca" => new ApiExposedProperty("nombre_marca", true, GET, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::NuevoMarca( 
 			
			
			isset($_GET['nombre_marca'] ) ? $_GET['nombre_marca'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiCarroMarcaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_marca_carro" => new ApiExposedProperty("id_marca_carro", true, GET, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"nombre_marca" => new ApiExposedProperty("nombre_marca", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TransportacionYFletesController::EditarMarca( 
 			
			
			isset($_GET['id_marca_carro'] ) ? $_GET['id_marca_carro'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] :  true ,
			isset($_GET['nombre_marca'] ) ? $_GET['nombre_marca'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_termino" => new ApiExposedProperty("fecha_termino", true, GET, array( "string" )),
			"folio" => new ApiExposedProperty("folio", true, GET, array( "string" )),
			"id_consignatario" => new ApiExposedProperty("id_consignatario", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
			"tipo_consignacion" => new ApiExposedProperty("tipo_consignacion", true, GET, array( "string" )),
			"fecha_envio_programada" => new ApiExposedProperty("fecha_envio_programada", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::Nueva( 
 			
			
			isset($_GET['fecha_termino'] ) ? $_GET['fecha_termino'] : null,
			isset($_GET['folio'] ) ? $_GET['folio'] : null,
			isset($_GET['id_consignatario'] ) ? $_GET['id_consignatario'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null,
			isset($_GET['tipo_consignacion'] ) ? $_GET['tipo_consignacion'] : null,
			isset($_GET['fecha_envio_programada'] ) ? $_GET['fecha_envio_programada'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionConsignatarioNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::NuevoConsignatario( 
 			
			
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_producto" => new ApiExposedProperty("id_producto", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::Lista( 
 			
			
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_producto'] ) ? $_GET['id_producto'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionInspeccionRegistrar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_inspeccion" => new ApiExposedProperty("id_inspeccion", true, GET, array( "int" )),
			"productos_actuales" => new ApiExposedProperty("productos_actuales", true, GET, array( "json" )),
			"id_inspector" => new ApiExposedProperty("id_inspector", false, GET, array( "int" )),
			"monto_abonado" => new ApiExposedProperty("monto_abonado", false, GET, array( "float" )),
			"producto_devuelto" => new ApiExposedProperty("producto_devuelto", false, GET, array( "json" )),
			"producto_solicitado" => new ApiExposedProperty("producto_solicitado", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::RegistrarInspeccion( 
 			
			
			isset($_GET['id_inspeccion'] ) ? $_GET['id_inspeccion'] : null,
			isset($_GET['productos_actuales'] ) ? json_decode($_GET['productos_actuales']) : null,
			isset($_GET['id_inspector'] ) ? $_GET['id_inspector'] :  "",
			isset($_GET['monto_abonado'] ) ? $_GET['monto_abonado'] :  null,
			isset($_GET['producto_devuelto'] ) ? json_decode($_GET['producto_devuelto']) : null,
			isset($_GET['producto_solicitado'] ) ? json_decode($_GET['producto_solicitado']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionTerminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_consignacion" => new ApiExposedProperty("id_consignacion", true, GET, array( "int" )),
			"productos_actuales" => new ApiExposedProperty("productos_actuales", true, GET, array( "json" )),
			"motivo" => new ApiExposedProperty("motivo", false, GET, array( "string" )),
			"tipo_pago" => new ApiExposedProperty("tipo_pago", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::Terminar( 
 			
			
			isset($_GET['id_consignacion'] ) ? $_GET['id_consignacion'] : null,
			isset($_GET['productos_actuales'] ) ? json_decode($_GET['productos_actuales']) : null,
			isset($_GET['motivo'] ) ? $_GET['motivo'] :  null,
			isset($_GET['tipo_pago'] ) ? $_GET['tipo_pago'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionConsignatarioDesactivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::DesactivarConsignatario( 
 			
			
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionInspeccionAbonar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_caja" => new ApiExposedProperty("id_caja", true, GET, array( "int" )),
			"id_inspeccion" => new ApiExposedProperty("id_inspeccion", true, GET, array( "int" )),
			"monto" => new ApiExposedProperty("monto", true, GET, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::AbonarInspeccion( 
 			
			
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null,
			isset($_GET['id_inspeccion'] ) ? $_GET['id_inspeccion'] : null,
			isset($_GET['monto'] ) ? $_GET['monto'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionInspeccionNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_revision" => new ApiExposedProperty("fecha_revision", true, GET, array( "string" )),
			"id_consignacion" => new ApiExposedProperty("id_consignacion", true, GET, array( "int" )),
			"id_inspector" => new ApiExposedProperty("id_inspector", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::NuevaInspeccion( 
 			
			
			isset($_GET['fecha_revision'] ) ? $_GET['fecha_revision'] : null,
			isset($_GET['id_consignacion'] ) ? $_GET['id_consignacion'] : null,
			isset($_GET['id_inspector'] ) ? $_GET['id_inspector'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionInspeccionCambiarFecha extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_inspeccion" => new ApiExposedProperty("id_inspeccion", true, GET, array( "int" )),
			"nueva_fecha" => new ApiExposedProperty("nueva_fecha", true, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::FechaCambiarInspeccion( 
 			
			
			isset($_GET['id_inspeccion'] ) ? $_GET['id_inspeccion'] : null,
			isset($_GET['nueva_fecha'] ) ? $_GET['nueva_fecha'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionInspeccionCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_inspeccion" => new ApiExposedProperty("id_inspeccion", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::CancelarInspeccion( 
 			
			
			isset($_GET['id_inspeccion'] ) ? $_GET['id_inspeccion'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"agregar" => new ApiExposedProperty("agregar", true, GET, array( "bool" )),
			"id_consignacion" => new ApiExposedProperty("id_consignacion", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::Editar( 
 			
			
			isset($_GET['agregar'] ) ? $_GET['agregar'] : null,
			isset($_GET['id_consignacion'] ) ? $_GET['id_consignacion'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiConsignacionCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"productos_almacen" => new ApiExposedProperty("productos_almacen", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ConsignacionesController::Cancelar( 
 			
			
			isset($_GET['productos_almacen'] ) ? json_decode($_GET['productos_almacen']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::Buscar( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"codigo_servicio" => new ApiExposedProperty("codigo_servicio", true, POST, array( "string" )),
			"compra_en_mostrador" => new ApiExposedProperty("compra_en_mostrador", true, POST, array( "bool" )),
			"costo_estandar" => new ApiExposedProperty("costo_estandar", true, POST, array( "float" )),
			"metodo_costeo" => new ApiExposedProperty("metodo_costeo", true, POST, array( "string" )),
			"nombre_servicio" => new ApiExposedProperty("nombre_servicio", true, POST, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"clasificaciones" => new ApiExposedProperty("clasificaciones", false, POST, array( "json" )),
			"control_de_existencia" => new ApiExposedProperty("control_de_existencia", false, POST, array( "int" )),
			"descripcion_servicio" => new ApiExposedProperty("descripcion_servicio", false, POST, array( "string" )),
			"empresas" => new ApiExposedProperty("empresas", false, POST, array( "json" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"foto_servicio" => new ApiExposedProperty("foto_servicio", false, POST, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"precio" => new ApiExposedProperty("precio", false, POST, array( "float" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"sucursales" => new ApiExposedProperty("sucursales", false, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::Nuevo( 
 			
			
			isset($_POST['codigo_servicio'] ) ? $_POST['codigo_servicio'] : null,
			isset($_POST['compra_en_mostrador'] ) ? $_POST['compra_en_mostrador'] : null,
			isset($_POST['costo_estandar'] ) ? $_POST['costo_estandar'] : null,
			isset($_POST['metodo_costeo'] ) ? $_POST['metodo_costeo'] : null,
			isset($_POST['nombre_servicio'] ) ? $_POST['nombre_servicio'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  true ,
			isset($_POST['clasificaciones'] ) ? json_decode($_POST['clasificaciones']) : null,
			isset($_POST['control_de_existencia'] ) ? $_POST['control_de_existencia'] :  null,
			isset($_POST['descripcion_servicio'] ) ? $_POST['descripcion_servicio'] :  null,
			isset($_POST['empresas'] ) ? json_decode($_POST['empresas']) : null,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['foto_servicio'] ) ? $_POST['foto_servicio'] :  null,
			isset($_POST['garantia'] ) ? $_POST['garantia'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['precio'] ) ? $_POST['precio'] :  null,
			isset($_POST['retenciones'] ) ? json_decode($_POST['retenciones']) : null,
			isset($_POST['sucursales'] ) ? json_decode($_POST['sucursales']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_servicio" => new ApiExposedProperty("id_servicio", true, POST, array( "int" )),
			"clasificaciones" => new ApiExposedProperty("clasificaciones", false, POST, array( "json" )),
			"codigo_servicio" => new ApiExposedProperty("codigo_servicio", false, POST, array( "string" )),
			"compra_en_mostrador" => new ApiExposedProperty("compra_en_mostrador", false, POST, array( "string" )),
			"control_de_existencia" => new ApiExposedProperty("control_de_existencia", false, POST, array( "int" )),
			"costo_estandar" => new ApiExposedProperty("costo_estandar", false, POST, array( "float" )),
			"descripcion_servicio" => new ApiExposedProperty("descripcion_servicio", false, POST, array( "string" )),
			"empresas" => new ApiExposedProperty("empresas", false, POST, array( "string" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"foto_servicio" => new ApiExposedProperty("foto_servicio", false, POST, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"metodo_costeo" => new ApiExposedProperty("metodo_costeo", false, POST, array( "string" )),
			"nombre_servicio" => new ApiExposedProperty("nombre_servicio", false, POST, array( "string" )),
			"precio" => new ApiExposedProperty("precio", false, POST, array( "float" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"sucursales" => new ApiExposedProperty("sucursales", false, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::Editar( 
 			
			
			isset($_POST['id_servicio'] ) ? $_POST['id_servicio'] : null,
			isset($_POST['clasificaciones'] ) ? json_decode($_POST['clasificaciones']) : null,
			isset($_POST['codigo_servicio'] ) ? $_POST['codigo_servicio'] :  null,
			isset($_POST['compra_en_mostrador'] ) ? $_POST['compra_en_mostrador'] :  null,
			isset($_POST['control_de_existencia'] ) ? $_POST['control_de_existencia'] :  null,
			isset($_POST['costo_estandar'] ) ? $_POST['costo_estandar'] :  null,
			isset($_POST['descripcion_servicio'] ) ? $_POST['descripcion_servicio'] :  null,
			isset($_POST['empresas'] ) ? $_POST['empresas'] :  null,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['foto_servicio'] ) ? $_POST['foto_servicio'] :  null,
			isset($_POST['garantia'] ) ? $_POST['garantia'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['metodo_costeo'] ) ? $_POST['metodo_costeo'] :  null,
			isset($_POST['nombre_servicio'] ) ? $_POST['nombre_servicio'] :  null,
			isset($_POST['precio'] ) ? $_POST['precio'] :  null,
			isset($_POST['retenciones'] ) ? json_decode($_POST['retenciones']) : null,
			isset($_POST['sucursales'] ) ? json_decode($_POST['sucursales']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"cancelada" => new ApiExposedProperty("cancelada", false, GET, array( "bool" )),
			"fecha_desde" => new ApiExposedProperty("fecha_desde", false, GET, array( "int" )),
			"fecha_hasta" => new ApiExposedProperty("fecha_hasta", false, GET, array( "int" )),
			"id_servicio" => new ApiExposedProperty("id_servicio", false, GET, array( "int" )),
			"id_usuario_venta" => new ApiExposedProperty("id_usuario_venta", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::ListaOrden( 
 			
			
			isset($_GET['activa'] ) ? $_GET['activa'] :  null,
			isset($_GET['cancelada'] ) ? $_GET['cancelada'] :  null,
			isset($_GET['fecha_desde'] ) ? $_GET['fecha_desde'] :  null,
			isset($_GET['fecha_hasta'] ) ? $_GET['fecha_hasta'] :  null,
			isset($_GET['id_servicio'] ) ? $_GET['id_servicio'] :  null,
			isset($_GET['id_usuario_venta'] ) ? $_GET['id_usuario_venta'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden" => new ApiExposedProperty("id_orden", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::DetalleOrden( 
 			
			
			isset($_GET['id_orden'] ) ? $_GET['id_orden'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, POST, array( "int" )),
			"id_servicio" => new ApiExposedProperty("id_servicio", true, POST, array( "int" )),
			"adelanto" => new ApiExposedProperty("adelanto", false, POST, array( "float" )),
			"cliente_reporta" => new ApiExposedProperty("cliente_reporta", false, POST, array( "string" )),
			"condiciones_de_recepcion" => new ApiExposedProperty("condiciones_de_recepcion", false, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"fecha_entrega" => new ApiExposedProperty("fecha_entrega", false, POST, array( "int" )),
			"fotografia" => new ApiExposedProperty("fotografia", false, POST, array( "string" )),
			"id_usuario_asignado" => new ApiExposedProperty("id_usuario_asignado", false, POST, array( "int" )),
			"precio" => new ApiExposedProperty("precio", false, POST, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::NuevaOrden( 
 			
			
			isset($_POST['id_cliente'] ) ? $_POST['id_cliente'] : null,
			isset($_POST['id_servicio'] ) ? $_POST['id_servicio'] : null,
			isset($_POST['adelanto'] ) ? $_POST['adelanto'] :  null,
			isset($_POST['cliente_reporta'] ) ? $_POST['cliente_reporta'] :  null,
			isset($_POST['condiciones_de_recepcion'] ) ? $_POST['condiciones_de_recepcion'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  "",
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['fecha_entrega'] ) ? $_POST['fecha_entrega'] :  "",
			isset($_POST['fotografia'] ) ? $_POST['fotografia'] :  null,
			isset($_POST['id_usuario_asignado'] ) ? $_POST['id_usuario_asignado'] :  null,
			isset($_POST['precio'] ) ? $_POST['precio'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenSeguimiento extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden_de_servicio" => new ApiExposedProperty("id_orden_de_servicio", true, POST, array( "int" )),
			"abono" => new ApiExposedProperty("abono", false, POST, array( "json" )),
			"id_localizacion" => new ApiExposedProperty("id_localizacion", false, POST, array( "int" )),
			"nota" => new ApiExposedProperty("nota", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::SeguimientoOrden( 
 			
			
			isset($_POST['id_orden_de_servicio'] ) ? $_POST['id_orden_de_servicio'] : null,
			isset($_POST['abono'] ) ? json_decode($_POST['abono']) : null,
			isset($_POST['id_localizacion'] ) ? $_POST['id_localizacion'] :  null,
			isset($_POST['nota'] ) ? $_POST['nota'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenTerminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden" => new ApiExposedProperty("id_orden", true, POST, array( "int" )),
			"id_venta" => new ApiExposedProperty("id_venta", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::TerminarOrden( 
 			
			
			isset($_POST['id_orden'] ) ? $_POST['id_orden'] : null,
			isset($_POST['id_venta'] ) ? $_POST['id_venta'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_servicio" => new ApiExposedProperty("id_servicio", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::Eliminar( 
 			
			
			isset($_GET['id_servicio'] ) ? $_GET['id_servicio'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosClasificacionNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre" => new ApiExposedProperty("nombre", true, GET, array( "string" )),
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, GET, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, GET, array( "json" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::NuevaClasificacion( 
 			
			
			isset($_GET['nombre'] ) ? $_GET['nombre'] : null,
			isset($_GET['activa'] ) ? $_GET['activa'] :  1 ,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['garantia'] ) ? $_GET['garantia'] :  null,
			isset($_GET['impuestos'] ) ? json_decode($_GET['impuestos']) : null,
			isset($_GET['retenciones'] ) ? json_decode($_GET['retenciones']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosClasificacionEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_clasificacion_servicio" => new ApiExposedProperty("id_clasificacion_servicio", true, GET, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, GET, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, GET, array( "json" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::EditarClasificacion( 
 			
			
			isset($_GET['id_clasificacion_servicio'] ) ? $_GET['id_clasificacion_servicio'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['garantia'] ) ? $_GET['garantia'] :  null,
			isset($_GET['impuestos'] ) ? json_decode($_GET['impuestos']) : null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null,
			isset($_GET['retenciones'] ) ? json_decode($_GET['retenciones']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosClasificacionEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_clasificacion_servicio" => new ApiExposedProperty("id_clasificacion_servicio", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::EliminarClasificacion( 
 			
			
			isset($_GET['id_clasificacion_servicio'] ) ? $_GET['id_clasificacion_servicio'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden_de_servicio" => new ApiExposedProperty("id_orden_de_servicio", true, GET, array( "int" )),
			"motivo_cancelacion" => new ApiExposedProperty("motivo_cancelacion", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::CancelarOrden( 
 			
			
			isset($_GET['id_orden_de_servicio'] ) ? $_GET['id_orden_de_servicio'] : null,
			isset($_GET['motivo_cancelacion'] ) ? $_GET['motivo_cancelacion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenAgregarProductos extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden_de_servicio" => new ApiExposedProperty("id_orden_de_servicio", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::ProductosAgregarOrden( 
 			
			
			isset($_GET['id_orden_de_servicio'] ) ? $_GET['id_orden_de_servicio'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenQuitarProductos extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden_de_servicio" => new ApiExposedProperty("id_orden_de_servicio", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::ProductosQuitarOrden( 
 			
			
			isset($_GET['id_orden_de_servicio'] ) ? $_GET['id_orden_de_servicio'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiServiciosOrdenEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_orden" => new ApiExposedProperty("id_orden", true, POST, array( "int" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"fecha_entrega" => new ApiExposedProperty("fecha_entrega", false, POST, array( "int" )),
			"id_usuario_asignado" => new ApiExposedProperty("id_usuario_asignado", false, POST, array( "int" )),
			"precio" => new ApiExposedProperty("precio", false, POST, array( "float" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::EditarOrden( 
 			
			
			isset($_POST['id_orden'] ) ? $_POST['id_orden'] : null,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['fecha_entrega'] ) ? $_POST['fecha_entrega'] :  null,
			isset($_POST['id_usuario_asignado'] ) ? $_POST['id_usuario_asignado'] :  null,
			isset($_POST['precio'] ) ? $_POST['precio'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosOfflineEnviar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"compras" => new ApiExposedProperty("compras", false, POST, array( "json" )),
			"ventas" => new ApiExposedProperty("ventas", false, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::EnviarOffline( 
 			
			
			isset($_POST['compras'] ) ? json_decode($_POST['compras']) : null,
			isset($_POST['ventas'] ) ? json_decode($_POST['ventas']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosHash extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::Hash( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosProbarConexion extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::ConexionProbar( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBdRespaldar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::RespaldarBd( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosClientCheckCurrentClientVersion extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::VersionClientCurrentCheckClient( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosClientDownload extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::DownloadClient( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBdDrop extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() { /*SESION NO NECESARIA*/ return; }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::DropBd( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosMailEnviar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cuerpo" => new ApiExposedProperty("cuerpo", true, POST, array( "string" )),
			"destinatario" => new ApiExposedProperty("destinatario", true, POST, array( "string" )),
			"titulo" => new ApiExposedProperty("titulo", true, POST, array( "string" )),
			"emisor" => new ApiExposedProperty("emisor", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::EnviarMail( 
 			
			
			isset($_POST['cuerpo'] ) ? $_POST['cuerpo'] : null,
			isset($_POST['destinatario'] ) ? $_POST['destinatario'] : null,
			isset($_POST['titulo'] ) ? $_POST['titulo'] : null,
			isset($_POST['emisor'] ) ? $_POST['emisor'] :  "no-reply@caffeina.mx"
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"query" => new ApiExposedProperty("query", true, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::Buscar( 
 			
			
			isset($_GET['query'] ) ? $_GET['query'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBdColumnaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"campo" => new ApiExposedProperty("campo", true, POST, array( "string" )),
			"caption" => new ApiExposedProperty("caption", true, POST, array( "string" )),
			"obligatorio" => new ApiExposedProperty("obligatorio", true, POST, array( "bool" )),
			"tabla" => new ApiExposedProperty("tabla", true, POST, array( "string" )),
			"tipo" => new ApiExposedProperty("tipo", true, POST, array( "enum" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"longitud" => new ApiExposedProperty("longitud", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::NuevaColumnaBd( 
 			
			
			isset($_POST['campo'] ) ? $_POST['campo'] : null,
			isset($_POST['caption'] ) ? $_POST['caption'] : null,
			isset($_POST['obligatorio'] ) ? $_POST['obligatorio'] : null,
			isset($_POST['tabla'] ) ? $_POST['tabla'] : null,
			isset($_POST['tipo'] ) ? $_POST['tipo'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  "",
			isset($_POST['longitud'] ) ? $_POST['longitud'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBdColumnaEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"campo" => new ApiExposedProperty("campo", true, POST, array( "string" )),
			"tabla" => new ApiExposedProperty("tabla", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::EliminarColumnaBd( 
 			
			
			isset($_POST['campo'] ) ? $_POST['campo'] : null,
			isset($_POST['tabla'] ) ? $_POST['tabla'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBdColumnaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"campo" => new ApiExposedProperty("campo", true, POST, array( "string" )),
			"tabla" => new ApiExposedProperty("tabla", true, POST, array( "string" )),
			"caption" => new ApiExposedProperty("caption", false, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"longitud" => new ApiExposedProperty("longitud", false, POST, array( "int" )),
			"obligatorio" => new ApiExposedProperty("obligatorio", false, POST, array( "bool" )),
			"tipo" => new ApiExposedProperty("tipo", false, POST, array( "enum" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::EditarColumnaBd( 
 			
			
			isset($_POST['campo'] ) ? $_POST['campo'] : null,
			isset($_POST['tabla'] ) ? $_POST['tabla'] : null,
			isset($_POST['caption'] ) ? $_POST['caption'] :  "",
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  "",
			isset($_POST['longitud'] ) ? $_POST['longitud'] :  "",
			isset($_POST['obligatorio'] ) ? $_POST['obligatorio'] :  "",
			isset($_POST['tipo'] ) ? $_POST['tipo'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionDecimales extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cambio" => new ApiExposedProperty("cambio", true, POST, array( "int" )),
			"cantidades" => new ApiExposedProperty("cantidades", true, POST, array( "int" )),
			"costos" => new ApiExposedProperty("costos", true, POST, array( "int" )),
			"ventas" => new ApiExposedProperty("ventas", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::DecimalesConfiguracion( 
 			
			
			isset($_POST['cambio'] ) ? $_POST['cambio'] : null,
			isset($_POST['cantidades'] ) ? $_POST['cantidades'] : null,
			isset($_POST['costos'] ) ? $_POST['costos'] : null,
			isset($_POST['ventas'] ) ? $_POST['ventas'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosBdBorrarRespaldo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_instacia" => new ApiExposedProperty("id_instacia", true, POST, array( "int" )),
			"time" => new ApiExposedProperty("time", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::RespaldoBorrarBd( 
 			
			
			isset($_POST['id_instacia'] ) ? $_POST['id_instacia'] : null,
			isset($_POST['time'] ) ? $_POST['time'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionVistasClientes extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"mostrar" => new ApiExposedProperty("mostrar", true, POST, array( "bool" )),
			"propiedades" => new ApiExposedProperty("propiedades", false, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::ClientesVistasConfiguracion( 
 			
			
			isset($_POST['mostrar'] ) ? $_POST['mostrar'] : null,
			isset($_POST['propiedades'] ) ? json_decode($_POST['propiedades']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosImportarAdminpaq extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"ip" => new ApiExposedProperty("ip", true, POST, array( "string" )),
			"path" => new ApiExposedProperty("path", true, POST, array( "string" )),
			"num_precio" => new ApiExposedProperty("num_precio", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::AdminpaqImportar( 
 			
			
			isset($_POST['ip'] ) ? $_POST['ip'] : null,
			isset($_POST['path'] ) ? $_POST['path'] : null,
			isset($_POST['num_precio'] ) ? $_POST['num_precio'] :  1 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionPerfilNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"configuracion" => new ApiExposedProperty("configuracion", true, POST, array( "json" )),
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::NuevoPerfilConfiguracion( 
 			
			
			isset($_POST['configuracion'] ) ? json_decode($_POST['configuracion']) : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionPerfilEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_perfil" => new ApiExposedProperty("id_perfil", true, POST, array( "int" )),
			"configuracion" => new ApiExposedProperty("configuracion", false, POST, array( "json" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::EditarPerfilConfiguracion( 
 			
			
			isset($_POST['id_perfil'] ) ? $_POST['id_perfil'] : null,
			isset($_POST['configuracion'] ) ? json_decode($_POST['configuracion']) : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionPerfilLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"limit" => new ApiExposedProperty("limit", false, POST, array( "string" )),
			"order" => new ApiExposedProperty("order", false, POST, array( "string" )),
			"order_by" => new ApiExposedProperty("order_by", false, POST, array( "string" )),
			"query" => new ApiExposedProperty("query", false, POST, array( "string" )),
			"start" => new ApiExposedProperty("start", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::ListaPerfilConfiguracion( 
 			
			
			isset($_POST['activo'] ) ? $_POST['activo'] :  false ,
			isset($_POST['limit'] ) ? $_POST['limit'] :  null,
			isset($_POST['order'] ) ? $_POST['order'] :  null,
			isset($_POST['order_by'] ) ? $_POST['order_by'] :  null,
			isset($_POST['query'] ) ? $_POST['query'] :  null,
			isset($_POST['start'] ) ? $_POST['start'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionPerfilEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_perfil" => new ApiExposedProperty("id_perfil", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::EliminarPerfilConfiguracion( 
 			
			
			isset($_POST['id_perfil'] ) ? $_POST['id_perfil'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPosConfiguracionPerfilDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_perfil" => new ApiExposedProperty("id_perfil", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = POSController::DetallesPerfilConfiguracion( 
 			
			
			isset($_POST['id_perfil'] ) ? $_POST['id_perfil'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activos" => new ApiExposedProperty("activos", false, GET, array( "bool" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::Buscar( 
 			
			
			isset($_GET['activos'] ) ? $_GET['activos'] :  "",
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_documento_base" => new ApiExposedProperty("id_documento_base", true, POST, array( "int" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::Nuevo( 
 			
			
			isset($_POST['id_documento_base'] ) ? $_POST['id_documento_base'] : null,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoBaseEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_documento" => new ApiExposedProperty("id_documento", true, POST, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"foliado" => new ApiExposedProperty("foliado", false, POST, array( "json" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"json_impresion" => new ApiExposedProperty("json_impresion", false, POST, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
			"nombre_plantilla" => new ApiExposedProperty("nombre_plantilla", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::EditarBase( 
 			
			
			isset($_POST['id_documento'] ) ? $_POST['id_documento'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  null,
			isset($_POST['foliado'] ) ? json_decode($_POST['foliado']) : null,
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['json_impresion'] ) ? $_POST['json_impresion'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null,
			isset($_POST['nombre_plantilla'] ) ? $_POST['nombre_plantilla'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoFacturaImprimir extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_folio" => new ApiExposedProperty("id_folio", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::ImprimirFactura( 
 			
			
			isset($_GET['id_folio'] ) ? $_GET['id_folio'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoFacturaCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_folio" => new ApiExposedProperty("id_folio", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::CancelarFactura( 
 			
			
			isset($_GET['id_folio'] ) ? $_GET['id_folio'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoFacturaGenerar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", true, GET, array( "int" )),
			"id_venta" => new ApiExposedProperty("id_venta", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::GenerarFactura( 
 			
			
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] : null,
			isset($_GET['id_venta'] ) ? $_GET['id_venta'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoBaseNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"json_impresion" => new ApiExposedProperty("json_impresion", true, POST, array( "json" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"extra_params" => new ApiExposedProperty("extra_params", false, POST, array( "json" )),
			"foliado" => new ApiExposedProperty("foliado", false, POST, array( "json" )),
			"foliado" => new ApiExposedProperty("foliado", false, POST, array( "json" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, POST, array( "int" )),
			"nombre_plantilla" => new ApiExposedProperty("nombre_plantilla", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::NuevoBase( 
 			
			
			isset($_POST['json_impresion'] ) ? json_decode($_POST['json_impresion']) : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  1 ,
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['foliado'] ) ? json_decode($_POST['foliado']) : null,
			isset($_POST['foliado'] ) ? json_decode($_POST['foliado']) : null,
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] :  null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] :  null,
			isset($_POST['nombre_plantilla'] ) ? $_POST['nombre_plantilla'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"extra_params" => new ApiExposedProperty("extra_params", true, POST, array( "json" )),
			"id_documento" => new ApiExposedProperty("id_documento", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::Editar( 
 			
			
			isset($_POST['extra_params'] ) ? json_decode($_POST['extra_params']) : null,
			isset($_POST['id_documento'] ) ? $_POST['id_documento'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiDocumentoImprimir extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_documento" => new ApiExposedProperty("id_documento", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = DocumentosController::Imprimir( 
 			
			
			isset($_GET['id_documento'] ) ? $_GET['id_documento'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAdministracionFacturasLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activos" => new ApiExposedProperty("activos", false, GET, array( "bool" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContabilidadController::ListaFacturas( 
 			
			
			isset($_GET['activos'] ) ? $_GET['activos'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContabilidadCuentaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"abonos_aumentan" => new ApiExposedProperty("abonos_aumentan", true, POST, array( "bool" )),
			"cargos_aumentan" => new ApiExposedProperty("cargos_aumentan", true, POST, array( "bool" )),
			"clasificacion" => new ApiExposedProperty("clasificacion", true, POST, array( "enum" )),
			"es_cuenta_mayor" => new ApiExposedProperty("es_cuenta_mayor", true, POST, array( "bool" )),
			"es_cuenta_orden" => new ApiExposedProperty("es_cuenta_orden", true, POST, array( "bool" )),
			"id_catalogo_cuentas" => new ApiExposedProperty("id_catalogo_cuentas", true, POST, array( "int" )),
			"naturaleza" => new ApiExposedProperty("naturaleza", true, POST, array( "enum" )),
			"nombre_cuenta" => new ApiExposedProperty("nombre_cuenta", true, POST, array( "string" )),
			"tipo_cuenta" => new ApiExposedProperty("tipo_cuenta", true, POST, array( "enum" )),
			"id_cuenta_padre" => new ApiExposedProperty("id_cuenta_padre", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContabilidadController::NuevaCuenta( 
 			
			
			isset($_POST['abonos_aumentan'] ) ? $_POST['abonos_aumentan'] : null,
			isset($_POST['cargos_aumentan'] ) ? $_POST['cargos_aumentan'] : null,
			isset($_POST['clasificacion'] ) ? $_POST['clasificacion'] : null,
			isset($_POST['es_cuenta_mayor'] ) ? $_POST['es_cuenta_mayor'] : null,
			isset($_POST['es_cuenta_orden'] ) ? $_POST['es_cuenta_orden'] : null,
			isset($_POST['id_catalogo_cuentas'] ) ? $_POST['id_catalogo_cuentas'] : null,
			isset($_POST['naturaleza'] ) ? $_POST['naturaleza'] : null,
			isset($_POST['nombre_cuenta'] ) ? $_POST['nombre_cuenta'] : null,
			isset($_POST['tipo_cuenta'] ) ? $_POST['tipo_cuenta'] : null,
			isset($_POST['id_cuenta_padre'] ) ? $_POST['id_cuenta_padre'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContabilidadCuentaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, POST, array( "int" )),
			"abonos_aumentan" => new ApiExposedProperty("abonos_aumentan", false, POST, array( "bool" )),
			"afectable" => new ApiExposedProperty("afectable", false, POST, array( "bool" )),
			"cargos_aumentan" => new ApiExposedProperty("cargos_aumentan", false, POST, array( "bool" )),
			"es_cuenta_mayor" => new ApiExposedProperty("es_cuenta_mayor", false, POST, array( "bool" )),
			"es_cuenta_orden" => new ApiExposedProperty("es_cuenta_orden", false, POST, array( "bool" )),
			"id_cuenta_padre" => new ApiExposedProperty("id_cuenta_padre", false, POST, array( "int" )),
			"naturaleza" => new ApiExposedProperty("naturaleza", false, POST, array( "enum" )),
			"nombre_cuenta" => new ApiExposedProperty("nombre_cuenta", false, POST, array( "string" )),
			"tipo_cuenta" => new ApiExposedProperty("tipo_cuenta", false, POST, array( "enum" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContabilidadController::EditarCuenta( 
 			
			
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] : null,
			isset($_POST['abonos_aumentan'] ) ? $_POST['abonos_aumentan'] :  "",
			isset($_POST['afectable'] ) ? $_POST['afectable'] :  "",
			isset($_POST['cargos_aumentan'] ) ? $_POST['cargos_aumentan'] :  "",
			isset($_POST['es_cuenta_mayor'] ) ? $_POST['es_cuenta_mayor'] :  "",
			isset($_POST['es_cuenta_orden'] ) ? $_POST['es_cuenta_orden'] :  "",
			isset($_POST['id_cuenta_padre'] ) ? $_POST['id_cuenta_padre'] :  "",
			isset($_POST['naturaleza'] ) ? $_POST['naturaleza'] :  "",
			isset($_POST['nombre_cuenta'] ) ? $_POST['nombre_cuenta'] :  "",
			isset($_POST['tipo_cuenta'] ) ? $_POST['tipo_cuenta'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContabilidadCuentaEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContabilidadController::EliminarCuenta( 
 			
			
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContabilidadCuentaBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_catalogo_cuentas" => new ApiExposedProperty("id_catalogo_cuentas", true, POST, array( "int" )),
			"afectable" => new ApiExposedProperty("afectable", false, POST, array( "bool" )),
			"clasificacion" => new ApiExposedProperty("clasificacion", false, POST, array( "enum" )),
			"clave" => new ApiExposedProperty("clave", false, POST, array( "string" )),
			"consecutivo_en_nivel" => new ApiExposedProperty("consecutivo_en_nivel", false, POST, array( "int" )),
			"es_cuenta_mayor" => new ApiExposedProperty("es_cuenta_mayor", false, POST, array( "bool" )),
			"es_cuenta_orden" => new ApiExposedProperty("es_cuenta_orden", false, POST, array( "bool" )),
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", false, POST, array( "int" )),
			"id_cuenta_padre" => new ApiExposedProperty("id_cuenta_padre", false, POST, array( "int" )),
			"naturaleza" => new ApiExposedProperty("naturaleza", false, POST, array( "enum" )),
			"nivel" => new ApiExposedProperty("nivel", false, POST, array( "int" )),
			"nombre_cuenta" => new ApiExposedProperty("nombre_cuenta", false, POST, array( "string" )),
			"tipo_cuenta" => new ApiExposedProperty("tipo_cuenta", false, POST, array( "enum" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContabilidadController::BuscarCuenta( 
 			
			
			isset($_POST['id_catalogo_cuentas'] ) ? $_POST['id_catalogo_cuentas'] : null,
			isset($_POST['afectable'] ) ? $_POST['afectable'] :  "",
			isset($_POST['clasificacion'] ) ? $_POST['clasificacion'] :  "",
			isset($_POST['clave'] ) ? $_POST['clave'] :  "",
			isset($_POST['consecutivo_en_nivel'] ) ? $_POST['consecutivo_en_nivel'] :  "",
			isset($_POST['es_cuenta_mayor'] ) ? $_POST['es_cuenta_mayor'] :  "",
			isset($_POST['es_cuenta_orden'] ) ? $_POST['es_cuenta_orden'] :  "",
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] :  "",
			isset($_POST['id_cuenta_padre'] ) ? $_POST['id_cuenta_padre'] :  "",
			isset($_POST['naturaleza'] ) ? $_POST['naturaleza'] :  "",
			isset($_POST['nivel'] ) ? $_POST['nivel'] :  "",
			isset($_POST['nombre_cuenta'] ) ? $_POST['nombre_cuenta'] :  "",
			isset($_POST['tipo_cuenta'] ) ? $_POST['tipo_cuenta'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContabilidadCuentaDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cuenta_contable" => new ApiExposedProperty("id_cuenta_contable", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContabilidadController::DetalleCuenta( 
 			
			
			isset($_POST['id_cuenta_contable'] ) ? $_POST['id_cuenta_contable'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiReporteNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ReportesController::Nuevo( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiReporteNuevoRevisarSyntax extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nuevo_reporte" => new ApiExposedProperty("nuevo_reporte", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ReportesController::SyntaxRevisarNuevo( 
 			
			
			isset($_GET['nuevo_reporte'] ) ? json_decode($_GET['nuevo_reporte']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiReporteDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_reporte" => new ApiExposedProperty("id_reporte", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ReportesController::Detalle( 
 			
			
			isset($_GET['id_reporte'] ) ? $_GET['id_reporte'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiReporteLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ReportesController::Lista( 
 			
			
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiReporteClienteProductos extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ReportesController::ProductosCliente( 
 			
			
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['orden'] ) ? json_decode($_GET['orden']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiReporteServicioCliente extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_cliente" => new ApiExposedProperty("id_cliente", false, GET, array( "int" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ReportesController::ClienteServicio( 
 			
			
			isset($_GET['id_cliente'] ) ? $_GET['id_cliente'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null,
			isset($_GET['orden'] ) ? json_decode($_GET['orden']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiImpuestoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", true, POST, array( "bool" )),
			"aplica" => new ApiExposedProperty("aplica", true, POST, array( "string" )),
			"codigo" => new ApiExposedProperty("codigo", true, POST, array( "string" )),
			"importe" => new ApiExposedProperty("importe", true, POST, array( "float" )),
			"incluido_precio" => new ApiExposedProperty("incluido_precio", true, POST, array( "bool" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"tipo" => new ApiExposedProperty("tipo", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ImpuestosController::Nuevo( 
 			
			
			isset($_POST['activo'] ) ? $_POST['activo'] : null,
			isset($_POST['aplica'] ) ? $_POST['aplica'] : null,
			isset($_POST['codigo'] ) ? $_POST['codigo'] : null,
			isset($_POST['importe'] ) ? $_POST['importe'] : null,
			isset($_POST['incluido_precio'] ) ? $_POST['incluido_precio'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['tipo'] ) ? $_POST['tipo'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiImpuestoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_impuesto" => new ApiExposedProperty("id_impuesto", true, POST, array( "int" )),
			"monto_porcentaje" => new ApiExposedProperty("monto_porcentaje", false, POST, array( "float" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
			"tipo" => new ApiExposedProperty("tipo", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ImpuestosController::Editar( 
 			
			
			isset($_POST['id_impuesto'] ) ? $_POST['id_impuesto'] : null,
			isset($_POST['monto_porcentaje'] ) ? $_POST['monto_porcentaje'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null,
			isset($_POST['tipo'] ) ? $_POST['tipo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiImpuestoLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ImpuestosController::Lista( 
 			
			
			isset($_GET['query'] ) ? $_GET['query'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", true, POST, array( "bool" )),
			"codigo_producto" => new ApiExposedProperty("codigo_producto", true, POST, array( "string" )),
			"compra_en_mostrador" => new ApiExposedProperty("compra_en_mostrador", true, POST, array( "bool" )),
			"id_unidad_compra" => new ApiExposedProperty("id_unidad_compra", true, POST, array( "string" )),
			"metodo_costeo" => new ApiExposedProperty("metodo_costeo", true, POST, array( "string" )),
			"nombre_producto" => new ApiExposedProperty("nombre_producto", true, POST, array( "string" )),
			"visible_en_vc" => new ApiExposedProperty("visible_en_vc", true, POST, array( "bool" )),
			"codigo_de_barras" => new ApiExposedProperty("codigo_de_barras", false, POST, array( "string" )),
			"control_de_existencia" => new ApiExposedProperty("control_de_existencia", false, POST, array( "int" )),
			"costo_estandar" => new ApiExposedProperty("costo_estandar", false, POST, array( "float" )),
			"descripcion_producto" => new ApiExposedProperty("descripcion_producto", false, POST, array( "string" )),
			"foto_del_producto" => new ApiExposedProperty("foto_del_producto", false, POST, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, POST, array( "int" )),
			"id_categoria" => new ApiExposedProperty("id_categoria", false, POST, array( "int" )),
			"id_empresas" => new ApiExposedProperty("id_empresas", false, POST, array( "json" )),
			"id_unidad" => new ApiExposedProperty("id_unidad", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"precio_de_venta" => new ApiExposedProperty("precio_de_venta", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::Nuevo( 
 			
			
			isset($_POST['activo'] ) ? $_POST['activo'] : null,
			isset($_POST['codigo_producto'] ) ? $_POST['codigo_producto'] : null,
			isset($_POST['compra_en_mostrador'] ) ? $_POST['compra_en_mostrador'] : null,
			isset($_POST['id_unidad_compra'] ) ? $_POST['id_unidad_compra'] : null,
			isset($_POST['metodo_costeo'] ) ? $_POST['metodo_costeo'] : null,
			isset($_POST['nombre_producto'] ) ? $_POST['nombre_producto'] : null,
			isset($_POST['visible_en_vc'] ) ? $_POST['visible_en_vc'] : null,
			isset($_POST['codigo_de_barras'] ) ? $_POST['codigo_de_barras'] :  null,
			isset($_POST['control_de_existencia'] ) ? $_POST['control_de_existencia'] :  null,
			isset($_POST['costo_estandar'] ) ? $_POST['costo_estandar'] :  null,
			isset($_POST['descripcion_producto'] ) ? $_POST['descripcion_producto'] :  null,
			isset($_POST['foto_del_producto'] ) ? $_POST['foto_del_producto'] :  null,
			isset($_POST['garantia'] ) ? $_POST['garantia'] :  null,
			isset($_POST['id_categoria'] ) ? $_POST['id_categoria'] :  null,
			isset($_POST['id_empresas'] ) ? json_decode($_POST['id_empresas']) : null,
			isset($_POST['id_unidad'] ) ? $_POST['id_unidad'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['precio_de_venta'] ) ? $_POST['precio_de_venta'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoNuevoEnVolumen extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"productos" => new ApiExposedProperty("productos", true, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::VolumenEnNuevo( 
 			
			
			isset($_POST['productos'] ) ? json_decode($_POST['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoDesactivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_producto" => new ApiExposedProperty("id_producto", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::Desactivar( 
 			
			
			isset($_GET['id_producto'] ) ? $_GET['id_producto'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_producto" => new ApiExposedProperty("id_producto", true, POST, array( "int" )),
			"clasificaciones" => new ApiExposedProperty("clasificaciones", false, POST, array( "json" )),
			"codigo_de_barras" => new ApiExposedProperty("codigo_de_barras", false, POST, array( "string" )),
			"codigo_producto" => new ApiExposedProperty("codigo_producto", false, POST, array( "string" )),
			"compra_en_mostrador" => new ApiExposedProperty("compra_en_mostrador", false, POST, array( "bool" )),
			"control_de_existencia" => new ApiExposedProperty("control_de_existencia", false, POST, array( "int" )),
			"costo_estandar" => new ApiExposedProperty("costo_estandar", false, POST, array( "float" )),
			"costo_extra_almacen" => new ApiExposedProperty("costo_extra_almacen", false, POST, array( "float" )),
			"descripcion_producto" => new ApiExposedProperty("descripcion_producto", false, POST, array( "string" )),
			"empresas" => new ApiExposedProperty("empresas", false, POST, array( "json" )),
			"foto_del_producto" => new ApiExposedProperty("foto_del_producto", false, POST, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, POST, array( "int" )),
			"id_unidad" => new ApiExposedProperty("id_unidad", false, POST, array( "int" )),
			"id_unidad_compra" => new ApiExposedProperty("id_unidad_compra", false, POST, array( "int" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"metodo_costeo" => new ApiExposedProperty("metodo_costeo", false, POST, array( "string" )),
			"nombre_producto" => new ApiExposedProperty("nombre_producto", false, POST, array( "string" )),
			"peso_producto" => new ApiExposedProperty("peso_producto", false, POST, array( "float" )),
			"precio" => new ApiExposedProperty("precio", false, POST, array( "int" )),
			"visible_en_vc" => new ApiExposedProperty("visible_en_vc", false, POST, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::Editar( 
 			
			
			isset($_POST['id_producto'] ) ? $_POST['id_producto'] : null,
			isset($_POST['clasificaciones'] ) ? json_decode($_POST['clasificaciones']) : null,
			isset($_POST['codigo_de_barras'] ) ? $_POST['codigo_de_barras'] :  null,
			isset($_POST['codigo_producto'] ) ? $_POST['codigo_producto'] :  null,
			isset($_POST['compra_en_mostrador'] ) ? $_POST['compra_en_mostrador'] :  null,
			isset($_POST['control_de_existencia'] ) ? $_POST['control_de_existencia'] :  null,
			isset($_POST['costo_estandar'] ) ? $_POST['costo_estandar'] :  null,
			isset($_POST['costo_extra_almacen'] ) ? $_POST['costo_extra_almacen'] :  null,
			isset($_POST['descripcion_producto'] ) ? $_POST['descripcion_producto'] :  null,
			isset($_POST['empresas'] ) ? json_decode($_POST['empresas']) : null,
			isset($_POST['foto_del_producto'] ) ? $_POST['foto_del_producto'] :  null,
			isset($_POST['garantia'] ) ? $_POST['garantia'] :  null,
			isset($_POST['id_unidad'] ) ? $_POST['id_unidad'] :  null,
			isset($_POST['id_unidad_compra'] ) ? $_POST['id_unidad_compra'] :  null,
			isset($_POST['impuestos'] ) ? json_decode($_POST['impuestos']) : null,
			isset($_POST['metodo_costeo'] ) ? $_POST['metodo_costeo'] :  null,
			isset($_POST['nombre_producto'] ) ? $_POST['nombre_producto'] :  null,
			isset($_POST['peso_producto'] ) ? $_POST['peso_producto'] :  null,
			isset($_POST['precio'] ) ? $_POST['precio'] :  null,
			isset($_POST['visible_en_vc'] ) ? $_POST['visible_en_vc'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoCategoriaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"activa" => new ApiExposedProperty("activa", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_categoria_padre" => new ApiExposedProperty("id_categoria_padre", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::NuevaCategoria( 
 			
			
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['activa'] ) ? $_POST['activa'] :  true ,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_categoria_padre'] ) ? $_POST['id_categoria_padre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoCategoriaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_clasificacion_producto" => new ApiExposedProperty("id_clasificacion_producto", true, POST, array( "int" )),
			"activa" => new ApiExposedProperty("activa", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_categoria_padre" => new ApiExposedProperty("id_categoria_padre", false, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::EditarCategoria( 
 			
			
			isset($_POST['id_clasificacion_producto'] ) ? $_POST['id_clasificacion_producto'] : null,
			isset($_POST['activa'] ) ? $_POST['activa'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_categoria_padre'] ) ? $_POST['id_categoria_padre'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmUnidadEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_unidad_medida" => new ApiExposedProperty("id_unidad_medida", true, POST, array( "int" )),
			"abreviacion" => new ApiExposedProperty("abreviacion", false, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"factor_conversion" => new ApiExposedProperty("factor_conversion", false, POST, array( "float" )),
			"id_categoria_unidad_medida" => new ApiExposedProperty("id_categoria_unidad_medida", false, POST, array( "string" )),
			"tipo_unidad_medida" => new ApiExposedProperty("tipo_unidad_medida", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::EditarUnidadUdm( 
 			
			
			isset($_POST['id_unidad_medida'] ) ? $_POST['id_unidad_medida'] : null,
			isset($_POST['abreviacion'] ) ? $_POST['abreviacion'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['factor_conversion'] ) ? $_POST['factor_conversion'] :  null,
			isset($_POST['id_categoria_unidad_medida'] ) ? $_POST['id_categoria_unidad_medida'] :  null,
			isset($_POST['tipo_unidad_medida'] ) ? $_POST['tipo_unidad_medida'] :  ""
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmUnidadBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::BuscarUnidadUdm( 
 			
			
			isset($_GET['query'] ) ? $_GET['query'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"query" => new ApiExposedProperty("query", true, GET, array( "string" )),
			"id_producto" => new ApiExposedProperty("id_producto", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::Buscar( 
 			
			
			isset($_GET['query'] ) ? $_GET['query'] : null,
			isset($_GET['id_producto'] ) ? $_GET['id_producto'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmUnidadNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"abreviacion" => new ApiExposedProperty("abreviacion", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"factor_conversion" => new ApiExposedProperty("factor_conversion", true, POST, array( "float" )),
			"id_categoria_unidad_medida" => new ApiExposedProperty("id_categoria_unidad_medida", true, POST, array( "int" )),
			"tipo_unidad_medida" => new ApiExposedProperty("tipo_unidad_medida", true, POST, array( "enum" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::NuevaUnidadUdm( 
 			
			
			isset($_POST['abreviacion'] ) ? $_POST['abreviacion'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['factor_conversion'] ) ? $_POST['factor_conversion'] : null,
			isset($_POST['id_categoria_unidad_medida'] ) ? $_POST['id_categoria_unidad_medida'] : null,
			isset($_POST['tipo_unidad_medida'] ) ? $_POST['tipo_unidad_medida'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmCategoriaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::NuevaCategoriaUdm( 
 			
			
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  true 
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmCategoriaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_categoria_unidad_medida" => new ApiExposedProperty("id_categoria_unidad_medida", true, POST, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::EditarCategoriaUdm( 
 			
			
			isset($_POST['id_categoria_unidad_medida'] ) ? $_POST['id_categoria_unidad_medida'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmCategoriaBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::BuscarCategoriaUdm( 
 			
			
			isset($_GET['activa'] ) ? $_GET['activa'] :  true ,
			isset($_GET['query'] ) ? $_GET['query'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoCategoriaBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::BuscarCategoria( 
 			
			
			isset($_GET['activa'] ) ? $_GET['activa'] :  true ,
			isset($_GET['query'] ) ? $_GET['query'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoImportar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"raw_content" => new ApiExposedProperty("raw_content", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::Importar( 
 			
			
			isset($_POST['raw_content'] ) ? $_POST['raw_content'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoCategoriaDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_categoria" => new ApiExposedProperty("id_categoria", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::DetallesCategoria( 
 			
			
			isset($_GET['id_categoria'] ) ? $_GET['id_categoria'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmCategoriaDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_categoria_unidad_medida" => new ApiExposedProperty("id_categoria_unidad_medida", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::DetallesCategoriaUdm( 
 			
			
			isset($_GET['id_categoria_unidad_medida'] ) ? $_GET['id_categoria_unidad_medida'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmUnidadDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_unidad_medida" => new ApiExposedProperty("id_unidad_medida", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::DetallesUnidadUdm( 
 			
			
			isset($_GET['id_unidad_medida'] ) ? $_GET['id_unidad_medida'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProductoUdmUnidadDesactivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_unidad_medida" => new ApiExposedProperty("id_unidad_medida", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProductosController::DesactivarUnidadUdm( 
 			
			
			isset($_GET['id_unidad_medida'] ) ? $_GET['id_unidad_medida'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiTarifaCalcular extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"tipo_tarifa" => new ApiExposedProperty("tipo_tarifa", true, GET, array( "string" )),
			"cantidad" => new ApiExposedProperty("cantidad", false, GET, array( "float" )),
			"id_paquete" => new ApiExposedProperty("id_paquete", false, GET, array( "int" )),
			"id_producto" => new ApiExposedProperty("id_producto", false, GET, array( "int" )),
			"id_servicio" => new ApiExposedProperty("id_servicio", false, GET, array( "int" )),
			"id_tarifa" => new ApiExposedProperty("id_tarifa", false, GET, array( "int" )),
			"id_unidad" => new ApiExposedProperty("id_unidad", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TarifasController::Calcular( 
 			
			
			isset($_GET['tipo_tarifa'] ) ? $_GET['tipo_tarifa'] : null,
			isset($_GET['cantidad'] ) ? $_GET['cantidad'] :  null,
			isset($_GET['id_paquete'] ) ? $_GET['id_paquete'] :  null,
			isset($_GET['id_producto'] ) ? $_GET['id_producto'] :  null,
			isset($_GET['id_servicio'] ) ? $_GET['id_servicio'] :  null,
			isset($_GET['id_tarifa'] ) ? $_GET['id_tarifa'] :  null,
			isset($_GET['id_unidad'] ) ? $_GET['id_unidad'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiTarifaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_moneda" => new ApiExposedProperty("id_moneda", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"tipo_tarifa" => new ApiExposedProperty("tipo_tarifa", true, POST, array( "string" )),
			"default" => new ApiExposedProperty("default", false, POST, array( "bool" )),
			"fecha_fin" => new ApiExposedProperty("fecha_fin", false, POST, array( "string" )),
			"fecha_inicio" => new ApiExposedProperty("fecha_inicio", false, POST, array( "string" )),
			"formulas" => new ApiExposedProperty("formulas", false, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TarifasController::Nueva( 
 			
			
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['tipo_tarifa'] ) ? $_POST['tipo_tarifa'] : null,
			isset($_POST['default'] ) ? $_POST['default'] :  null,
			isset($_POST['fecha_fin'] ) ? $_POST['fecha_fin'] :  null,
			isset($_POST['fecha_inicio'] ) ? $_POST['fecha_inicio'] :  null,
			isset($_POST['formulas'] ) ? json_decode($_POST['formulas']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiTarifaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tarifa" => new ApiExposedProperty("id_tarifa", true, POST, array( "int" )),
			"default" => new ApiExposedProperty("default", false, POST, array( "bool" )),
			"fecha_fin" => new ApiExposedProperty("fecha_fin", false, POST, array( "string" )),
			"fecha_inicio" => new ApiExposedProperty("fecha_inicio", false, POST, array( "string" )),
			"formulas" => new ApiExposedProperty("formulas", false, POST, array( "json" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
			"tipo_tarifa" => new ApiExposedProperty("tipo_tarifa", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TarifasController::Editar( 
 			
			
			isset($_POST['id_tarifa'] ) ? $_POST['id_tarifa'] : null,
			isset($_POST['default'] ) ? $_POST['default'] :  null,
			isset($_POST['fecha_fin'] ) ? $_POST['fecha_fin'] :  null,
			isset($_POST['fecha_inicio'] ) ? $_POST['fecha_inicio'] :  null,
			isset($_POST['formulas'] ) ? json_decode($_POST['formulas']) : null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null,
			isset($_POST['tipo_tarifa'] ) ? $_POST['tipo_tarifa'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiTarifaDesactivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tarifa" => new ApiExposedProperty("id_tarifa", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TarifasController::Desactivar( 
 			
			
			isset($_POST['id_tarifa'] ) ? $_POST['id_tarifa'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiTarifaActivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tarifa" => new ApiExposedProperty("id_tarifa", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = TarifasController::Activar( 
 			
			
			isset($_GET['id_tarifa'] ) ? $_GET['id_tarifa'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPaqueteNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"empresas" => new ApiExposedProperty("empresas", true, GET, array( "json" )),
			"nombre" => new ApiExposedProperty("nombre", true, GET, array( "string" )),
			"sucursales" => new ApiExposedProperty("sucursales", true, GET, array( "json" )),
			"costo_estandar" => new ApiExposedProperty("costo_estandar", false, GET, array( "float" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"foto_paquete" => new ApiExposedProperty("foto_paquete", false, GET, array( "string" )),
			"precio" => new ApiExposedProperty("precio", false, GET, array( "float" )),
			"productos" => new ApiExposedProperty("productos", false, GET, array( "json" )),
			"servicios" => new ApiExposedProperty("servicios", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PaquetesController::Nuevo( 
 			
			
			isset($_GET['empresas'] ) ? json_decode($_GET['empresas']) : null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] : null,
			isset($_GET['sucursales'] ) ? json_decode($_GET['sucursales']) : null,
			isset($_GET['costo_estandar'] ) ? $_GET['costo_estandar'] :  null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['foto_paquete'] ) ? $_GET['foto_paquete'] :  null,
			isset($_GET['precio'] ) ? $_GET['precio'] :  null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null,
			isset($_GET['servicios'] ) ? json_decode($_GET['servicios']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPaqueteEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_paquete" => new ApiExposedProperty("id_paquete", true, GET, array( "int" )),
			"costo_estandar" => new ApiExposedProperty("costo_estandar", false, GET, array( "float" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"empresas" => new ApiExposedProperty("empresas", false, GET, array( "json" )),
			"foto_paquete" => new ApiExposedProperty("foto_paquete", false, GET, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
			"precio" => new ApiExposedProperty("precio", false, GET, array( "float" )),
			"productos" => new ApiExposedProperty("productos", false, GET, array( "json" )),
			"servicios" => new ApiExposedProperty("servicios", false, GET, array( "json" )),
			"sucursales" => new ApiExposedProperty("sucursales", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PaquetesController::Editar( 
 			
			
			isset($_GET['id_paquete'] ) ? $_GET['id_paquete'] : null,
			isset($_GET['costo_estandar'] ) ? $_GET['costo_estandar'] :  null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] :  null,
			isset($_GET['empresas'] ) ? json_decode($_GET['empresas']) : null,
			isset($_GET['foto_paquete'] ) ? $_GET['foto_paquete'] :  null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null,
			isset($_GET['precio'] ) ? $_GET['precio'] :  null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null,
			isset($_GET['servicios'] ) ? json_decode($_GET['servicios']) : null,
			isset($_GET['sucursales'] ) ? json_decode($_GET['sucursales']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPaqueteEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_paquete" => new ApiExposedProperty("id_paquete", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PaquetesController::Eliminar( 
 			
			
			isset($_GET['id_paquete'] ) ? $_GET['id_paquete'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPaqueteActivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_paquete" => new ApiExposedProperty("id_paquete", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PaquetesController::Activar( 
 			
			
			isset($_GET['id_paquete'] ) ? $_GET['id_paquete'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPaqueteLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PaquetesController::Lista( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiPaqueteDetalle extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_paquete" => new ApiExposedProperty("id_paquete", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = PaquetesController::Detalle( 
 			
			
			isset($_GET['id_paquete'] ) ? $_GET['id_paquete'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoBilleteNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_moneda" => new ApiExposedProperty("id_moneda", true, GET, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, GET, array( "string" )),
			"valor" => new ApiExposedProperty("valor", true, GET, array( "int" )),
			"foto_billete" => new ApiExposedProperty("foto_billete", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::NuevoBillete( 
 			
			
			isset($_GET['id_moneda'] ) ? $_GET['id_moneda'] : null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] : null,
			isset($_GET['valor'] ) ? $_GET['valor'] : null,
			isset($_GET['foto_billete'] ) ? $_GET['foto_billete'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoBilleteEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_billete" => new ApiExposedProperty("id_billete", true, GET, array( "int" )),
			"foto_billete" => new ApiExposedProperty("foto_billete", false, GET, array( "string" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", false, GET, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
			"valor" => new ApiExposedProperty("valor", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::EditarBillete( 
 			
			
			isset($_GET['id_billete'] ) ? $_GET['id_billete'] : null,
			isset($_GET['foto_billete'] ) ? $_GET['foto_billete'] :  null,
			isset($_GET['id_moneda'] ) ? $_GET['id_moneda'] :  null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null,
			isset($_GET['valor'] ) ? $_GET['valor'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoBilleteEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_billete" => new ApiExposedProperty("id_billete", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::EliminarBillete( 
 			
			
			isset($_GET['id_billete'] ) ? $_GET['id_billete'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoBilleteLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"ordenar" => new ApiExposedProperty("ordenar", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::ListaBillete( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['ordenar'] ) ? $_GET['ordenar'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoMonedaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre" => new ApiExposedProperty("nombre", true, GET, array( "string" )),
			"simbolo" => new ApiExposedProperty("simbolo", true, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::NuevaMoneda( 
 			
			
			isset($_GET['nombre'] ) ? $_GET['nombre'] : null,
			isset($_GET['simbolo'] ) ? $_GET['simbolo'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoMonedaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_moneda" => new ApiExposedProperty("id_moneda", true, GET, array( "int" )),
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"nombre" => new ApiExposedProperty("nombre", false, GET, array( "string" )),
			"simbolo" => new ApiExposedProperty("simbolo", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::EditarMoneda( 
 			
			
			isset($_GET['id_moneda'] ) ? $_GET['id_moneda'] : null,
			isset($_GET['activa'] ) ? $_GET['activa'] :  null,
			isset($_GET['nombre'] ) ? $_GET['nombre'] :  null,
			isset($_GET['simbolo'] ) ? $_GET['simbolo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoMonedaEliminar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_moneda" => new ApiExposedProperty("id_moneda", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::EliminarMoneda( 
 			
			
			isset($_GET['id_moneda'] ) ? $_GET['id_moneda'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoMonedaLista extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"orden" => new ApiExposedProperty("orden", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::ListaMoneda( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['orden'] ) ? $_GET['orden'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoServicioEquivalenciasObtener extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_moneda_base" => new ApiExposedProperty("id_moneda_base", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::ObtenerEquivalenciasServicio( 
 			
			
			isset($_POST['id_moneda_base'] ) ? $_POST['id_moneda_base'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoActualizarEquivalenciasMostrar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::MostrarEquivalenciasActualizar( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoCambioTiposActualizar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"monedas" => new ApiExposedProperty("monedas", true, POST, array( "json" )),
			"moneda_base" => new ApiExposedProperty("moneda_base", true, POST, array( "string" )),
			"servicios" => new ApiExposedProperty("servicios", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::ActualizarTiposCambio( 
 			
			
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['monedas'] ) ? json_decode($_POST['monedas']) : null,
			isset($_POST['moneda_base'] ) ? $_POST['moneda_base'] : null,
			isset($_POST['servicios'] ) ? $_POST['servicios'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiEfectivoMonedaEquivalenciaObtener extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"id_moneda" => new ApiExposedProperty("id_moneda", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = EfectivoController::ObtenerEquivalenciaMoneda( 
 			
			
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['id_moneda'] ) ? $_POST['id_moneda'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiProcesosNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ProcesosController::Nuevo( 
 			
			
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteEntrada extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_lote" => new ApiExposedProperty("id_lote", true, POST, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, POST, array( "json" )),
			"motivo" => new ApiExposedProperty("motivo", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::EntradaLote( 
 			
			
			isset($_POST['id_lote'] ) ? $_POST['id_lote'] : null,
			isset($_POST['productos'] ) ? json_decode($_POST['productos']) : null,
			isset($_POST['motivo'] ) ? $_POST['motivo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, POST, array( "int" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, POST, array( "int" )),
			"id_tipo_almacen" => new ApiExposedProperty("id_tipo_almacen", true, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::Nuevo( 
 			
			
			isset($_POST['id_empresa'] ) ? $_POST['id_empresa'] : null,
			isset($_POST['id_sucursal'] ) ? $_POST['id_sucursal'] : null,
			isset($_POST['id_tipo_almacen'] ) ? $_POST['id_tipo_almacen'] : null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::Buscar( 
 			
			
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteSalida extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_lote" => new ApiExposedProperty("id_lote", true, POST, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, POST, array( "json" )),
			"motivo" => new ApiExposedProperty("motivo", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::SalidaLote( 
 			
			
			isset($_POST['id_lote'] ) ? $_POST['id_lote'] : null,
			isset($_POST['productos'] ) ? json_decode($_POST['productos']) : null,
			isset($_POST['motivo'] ) ? $_POST['motivo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenDesactivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_almacen" => new ApiExposedProperty("id_almacen", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::Desactivar( 
 			
			
			isset($_POST['id_almacen'] ) ? $_POST['id_almacen'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_almacen" => new ApiExposedProperty("id_almacen", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_tipo_almacen" => new ApiExposedProperty("id_tipo_almacen", false, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::Editar( 
 			
			
			isset($_POST['id_almacen'] ) ? $_POST['id_almacen'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_tipo_almacen'] ) ? $_POST['id_tipo_almacen'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoProgramar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_envio_programada" => new ApiExposedProperty("fecha_envio_programada", true, GET, array( "string" )),
			"id_almacen_envia" => new ApiExposedProperty("id_almacen_envia", true, GET, array( "int" )),
			"id_almacen_recibe" => new ApiExposedProperty("id_almacen_recibe", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::ProgramarTraspasoLote( 
 			
			
			isset($_GET['fecha_envio_programada'] ) ? $_GET['fecha_envio_programada'] : null,
			isset($_GET['id_almacen_envia'] ) ? $_GET['id_almacen_envia'] : null,
			isset($_GET['id_almacen_recibe'] ) ? $_GET['id_almacen_recibe'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoEnviar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_traspaso" => new ApiExposedProperty("id_traspaso", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::EnviarTraspasoLote( 
 			
			
			isset($_GET['id_traspaso'] ) ? $_GET['id_traspaso'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoRecibir extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_traspaso" => new ApiExposedProperty("id_traspaso", true, POST, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::RecibirTraspasoLote( 
 			
			
			isset($_POST['id_traspaso'] ) ? $_POST['id_traspaso'] : null,
			isset($_POST['productos'] ) ? json_decode($_POST['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoCancelar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_traspaso" => new ApiExposedProperty("id_traspaso", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::CancelarTraspasoLote( 
 			
			
			isset($_POST['id_traspaso'] ) ? $_POST['id_traspaso'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"cancelado" => new ApiExposedProperty("cancelado", false, GET, array( "bool" )),
			"completo" => new ApiExposedProperty("completo", false, GET, array( "bool" )),
			"estado" => new ApiExposedProperty("estado", false, GET, array( "string" )),
			"id_almacen_envia" => new ApiExposedProperty("id_almacen_envia", false, GET, array( "int" )),
			"id_almacen_recibe" => new ApiExposedProperty("id_almacen_recibe", false, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::BuscarTraspasoLote( 
 			
			
			isset($_GET['cancelado'] ) ? $_GET['cancelado'] :  null,
			isset($_GET['completo'] ) ? $_GET['completo'] :  null,
			isset($_GET['estado'] ) ? $_GET['estado'] :  null,
			isset($_GET['id_almacen_envia'] ) ? $_GET['id_almacen_envia'] :  null,
			isset($_GET['id_almacen_recibe'] ) ? $_GET['id_almacen_recibe'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, GET, array( "string" )),
			"id_traspaso" => new ApiExposedProperty("id_traspaso", true, GET, array( "int" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
			"fecha_envio_programada" => new ApiExposedProperty("fecha_envio_programada", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::EditarTraspasoLote( 
 			
			
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] : null,
			isset($_GET['id_traspaso'] ) ? $_GET['id_traspaso'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null,
			isset($_GET['fecha_envio_programada'] ) ? $_GET['fecha_envio_programada'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenTipoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::NuevoTipo( 
 			
			
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenTipoEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tipo_almacen" => new ApiExposedProperty("id_tipo_almacen", true, POST, array( "int" )),
			"activo" => new ApiExposedProperty("activo", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::EditarTipo( 
 			
			
			isset($_POST['id_tipo_almacen'] ) ? $_POST['id_tipo_almacen'] : null,
			isset($_POST['activo'] ) ? $_POST['activo'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenTipoBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"limit" => new ApiExposedProperty("limit", false, GET, array( "string" )),
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
			"start" => new ApiExposedProperty("start", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::BuscarTipo( 
 			
			
			isset($_GET['activo'] ) ? $_GET['activo'] :  null,
			isset($_GET['limit'] ) ? $_GET['limit'] :  null,
			isset($_GET['query'] ) ? $_GET['query'] :  null,
			isset($_GET['start'] ) ? $_GET['start'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenTipoDesactivar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tipo_almacen" => new ApiExposedProperty("id_tipo_almacen", true, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::DesactivarTipo( 
 			
			
			isset($_POST['id_tipo_almacen'] ) ? $_POST['id_tipo_almacen'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_almacen" => new ApiExposedProperty("id_almacen", true, POST, array( "int" )),
			"folio" => new ApiExposedProperty("folio", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::NuevoLote( 
 			
			
			isset($_POST['id_almacen'] ) ? $_POST['id_almacen'] : null,
			isset($_POST['folio'] ) ? $_POST['folio'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteTraspasoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"fecha_envio_programada" => new ApiExposedProperty("fecha_envio_programada", true, GET, array( "string" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", true, GET, array( "string" )),
			"productos" => new ApiExposedProperty("productos", true, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::NuevoTraspasoLote( 
 			
			
			isset($_GET['fecha_envio_programada'] ) ? $_GET['fecha_envio_programada'] : null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] : null,
			isset($_GET['productos'] ) ? json_decode($_GET['productos']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiAlmacenLoteBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AlmacenesController::BuscarLote( 
 			
		
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiFormasPdfGenerar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"documento" => new ApiExposedProperty("documento", true, POST, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = FormasPreimpresasController::GenerarPdf( 
 			
			
			isset($_POST['documento'] ) ? json_decode($_POST['documento']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiFormasExcelGenerar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"datos" => new ApiExposedProperty("datos", true, GET, array( "json" )),
			"archivo_plantilla" => new ApiExposedProperty("archivo_plantilla", false, GET, array( "string" )),
			"imagenes" => new ApiExposedProperty("imagenes", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = FormasPreimpresasController::GenerarExcel( 
 			
			
			isset($_GET['datos'] ) ? json_decode($_GET['datos']) : null,
			isset($_GET['archivo_plantilla'] ) ? $_GET['archivo_plantilla'] :  "",
			isset($_GET['imagenes'] ) ? json_decode($_GET['imagenes']) : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiFormasExcelLeerpalabrasclave extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"archivo_plantilla" => new ApiExposedProperty("archivo_plantilla", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = FormasPreimpresasController::LeerpalabrasclaveExcel( 
 			
			
			isset($_POST['archivo_plantilla'] ) ? $_POST['archivo_plantilla'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiFormasExcelGenerar2 extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_documento" => new ApiExposedProperty("id_documento", true, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = FormasPreimpresasController::Generar2Excel( 
 			
			
			isset($_GET['id_documento'] ) ? $_GET['id_documento'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContactosCategoriaNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"nombre" => new ApiExposedProperty("nombre", true, POST, array( "string" )),
			"activa" => new ApiExposedProperty("activa", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_padre" => new ApiExposedProperty("id_padre", false, POST, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContactosController::NuevoCategoria( 
 			
			
			isset($_POST['nombre'] ) ? $_POST['nombre'] : null,
			isset($_POST['activa'] ) ? $_POST['activa'] :  true ,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_padre'] ) ? $_POST['id_padre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContactosCategoriaEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id" => new ApiExposedProperty("id", true, POST, array( "int" )),
			"activa" => new ApiExposedProperty("activa", false, POST, array( "bool" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"id_padre" => new ApiExposedProperty("id_padre", false, POST, array( "int" )),
			"nombre" => new ApiExposedProperty("nombre", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContactosController::EditarCategoria( 
 			
			
			isset($_POST['id'] ) ? $_POST['id'] : null,
			isset($_POST['activa'] ) ? $_POST['activa'] :  null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] :  null,
			isset($_POST['id_padre'] ) ? $_POST['id_padre'] :  null,
			isset($_POST['nombre'] ) ? $_POST['nombre'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContactosCategoriaBuscar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"activa" => new ApiExposedProperty("activa", false, GET, array( "bool" )),
			"query" => new ApiExposedProperty("query", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContactosController::BuscarCategoria( 
 			
			
			isset($_GET['activa'] ) ? $_GET['activa'] :  true ,
			isset($_GET['query'] ) ? $_GET['query'] :  null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  

  class ApiContactosCategoriaDetalles extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function GetRequest()
	{
		$this->request = array(	
			"id_categoria" => new ApiExposedProperty("id_categoria", true, GET, array( "int" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ContactosController::DetallesCategoria( 
 			
			
			isset($_GET['id_categoria'] ) ? $_GET['id_categoria'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  
