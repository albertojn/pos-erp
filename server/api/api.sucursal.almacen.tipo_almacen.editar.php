<?php
/**
  * GET api/sucursal/almacen/tipo_almacen/editar
  * Edita un tipo de almacen
  *
  * Edita un tipo de almacen
  *
  *
  *
  **/

  class ApiSucursalAlmacenTipoAlmacenEditar extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"id_tipo_almacen" => new ApiExposedProperty("id_tipo_almacen", true, GET, array( "int" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = SucursalesController::EditarTipo_almacenAlmacen( 
 			
			
			isset($_GET['id_tipo_almacen'] ) ? $_GET['id_tipo_almacen'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] : null
			
			);
		}catch(Exception $e){
 			//Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation( $e->getMessage() ) );
		}
 	}
  }
  
  
  
  
  
  