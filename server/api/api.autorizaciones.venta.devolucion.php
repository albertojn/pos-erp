<?php
/**
  * POST api/autorizaciones/venta/devolucion
  * Solicitud para devolver una venta.
  *
  * Solicitud para devolver una venta. La fecha de petici?e tomar?el servidor. El usuario y la sucursal que emiten la autorizaci?er?tomadas de la sesi?
  *
  *
  *
  **/

  class ApiAutorizacionesVentaDevolucion extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"id_venta" => new ApiExposedProperty("id_venta", true, POST, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", true, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = AutorizacionesController::DevolucionVenta( 
 			
			
			isset($_POST['id_venta'] ) ? $_POST['id_venta'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null
			
			);
		}catch(Exception $e){
 			Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation() );
		}
 	}
  }
  
  
  
  
  
  
