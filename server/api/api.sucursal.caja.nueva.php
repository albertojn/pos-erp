<?php
/**
  * POST api/sucursal/caja/nueva
  * Crear una caja en la sucursal
  *
  * Este metodo creara una caja asociada a una sucursal. Debe haber una caja por CPU. 
  *
  *
  *
  **/

  class ApiSucursalCajaNueva extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"token" => new ApiExposedProperty("token", true, POST, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, POST, array( "string" )),
			"basculas" => new ApiExposedProperty("basculas", false, POST, array( "json" )),
			"impresoras" => new ApiExposedProperty("impresoras", false, POST, array( "json" )),
			"codigo_caja" => new ApiExposedProperty("codigo_caja", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::NuevaCaja( 
 			
			
			isset($_POST['token'] ) ? $_POST['token'] : null,
			isset($_POST['descripcion'] ) ? $_POST['descripcion'] : null,
			isset($_POST['basculas'] ) ? $_POST['basculas'] : null,
			isset($_POST['impresoras'] ) ? $_POST['impresoras'] : null,
			isset($_POST['codigo_caja'] ) ? $_POST['codigo_caja'] : null
			
			);
		}catch(Exception $e){
 			Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation() );
		}
 	}
  }
  
  
  
  
  
  
