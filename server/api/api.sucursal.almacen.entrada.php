<?php
/**
  * POST api/sucursal/almacen/entrada
  * Surtir una sucursal
  *
  * Metodo que surte una sucursal por parte de un proveedor. La sucursal sera tomada de la sesion actual.

Update
Creo que este metodo tiene que estar bajo sucursal.
  *
  *
  *
  **/

  class ApiSucursalAlmacenEntrada extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"productos" => new ApiExposedProperty("productos", true, POST, array( "json" )),
			"id_almacen" => new ApiExposedProperty("id_almacen", true, POST, array( "int" )),
			"motivo" => new ApiExposedProperty("motivo", false, POST, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::EntradaAlmacen( 
 			
			
			isset($_POST['productos'] ) ? $_POST['productos'] : null,
			isset($_POST['id_almacen'] ) ? $_POST['id_almacen'] : null,
			isset($_POST['motivo'] ) ? $_POST['motivo'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  
  
  
  
  
