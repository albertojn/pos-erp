<?php
/**
  * POST api/empresa/nuevo
  * Crear una nueva empresa. Por default una nueva empresa no tiene sucursales.
  *
  * Crear una nueva empresa. Por default una nueva empresa no tiene sucursales.
  *
  *
  *
  **/

  class ApiEmpresaNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"rfc" => new ApiExposedProperty("rfc", true, POST, array( "string" )),
			"ciudad" => new ApiExposedProperty("ciudad", true, POST, array( "int" )),
			"curp" => new ApiExposedProperty("curp", true, POST, array( "string" )),
			"numero_exterior" => new ApiExposedProperty("numero_exterior", true, POST, array( "string" )),
			"razon_social" => new ApiExposedProperty("razon_social", true, POST, array( "string" )),
			"colonia" => new ApiExposedProperty("colonia", true, POST, array( "string" )),
			"codigo_postal" => new ApiExposedProperty("codigo_postal", true, POST, array( "string" )),
			"calle" => new ApiExposedProperty("calle", true, POST, array( "string" )),
			"representante_legal" => new ApiExposedProperty("representante_legal", false, POST, array( "string" )),
			"descuento" => new ApiExposedProperty("descuento", false, POST, array( "float" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, POST, array( "json" )),
			"numero_interior" => new ApiExposedProperty("numero_interior", false, POST, array( "string" )),
			"margen_utilidad" => new ApiExposedProperty("margen_utilidad", false, POST, array( "float" )),
			"texto_extra" => new ApiExposedProperty("texto_extra", false, POST, array( "string" )),
			"telefono2" => new ApiExposedProperty("telefono2", false, POST, array( "string" )),
			"email" => new ApiExposedProperty("email", false, POST, array( "string" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, POST, array( "json" )),
			"telefono1" => new ApiExposedProperty("telefono1", false, POST, array( "string" )),
			"direccion_web" => new ApiExposedProperty("direccion_web", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
			$controller = new EmpresasController();
	 		$this->response = $controller->Nuevo( 
 			
			
			isset($_POST['rfc'] ) ? $_POST['rfc'] : null,
			isset($_POST['ciudad'] ) ? $_POST['ciudad'] : null,
			isset($_POST['curp'] ) ? $_POST['curp'] : null,
			isset($_POST['numero_exterior'] ) ? $_POST['numero_exterior'] : null,
			isset($_POST['razon_social'] ) ? $_POST['razon_social'] : null,
			isset($_POST['colonia'] ) ? $_POST['colonia'] : null,
			isset($_POST['codigo_postal'] ) ? $_POST['codigo_postal'] : null,
			isset($_POST['calle'] ) ? $_POST['calle'] : null,
			isset($_POST['representante_legal'] ) ? $_POST['representante_legal'] : null,
			isset($_POST['descuento'] ) ? $_POST['descuento'] : null,
			isset($_POST['impuestos'] ) ? $_POST['impuestos'] : null,
			isset($_POST['numero_interior'] ) ? $_POST['numero_interior'] : null,
			isset($_POST['margen_utilidad'] ) ? $_POST['margen_utilidad'] : null,
			isset($_POST['texto_extra'] ) ? $_POST['texto_extra'] : null,
			isset($_POST['telefono2'] ) ? $_POST['telefono2'] : null,
			isset($_POST['email'] ) ? $_POST['email'] : null,
			isset($_POST['retenciones'] ) ? $_POST['retenciones'] : null,
			isset($_POST['telefono1'] ) ? $_POST['telefono1'] : null,
			isset($_POST['direccion_web'] ) ? $_POST['direccion_web'] : null
			
			);
		}catch(Exception $e){
 			Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation() );
		}
 	}
  }
  
  
  
  
  
  