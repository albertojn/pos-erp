<?php
/**
  * GET api/efectivo/ingreso/nuevo
  * Registra un nuevo ingreso
  *
  * Registra un nuevo ingreso
  *
  *
  *
  **/

  class ApiEfectivoIngresoNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"id_empresa" => new ApiExposedProperty("id_empresa", true, GET, array( "int" )),
			"fecha_ingreso" => new ApiExposedProperty("fecha_ingreso", true, GET, array( "string" )),
			"descripcion" => new ApiExposedProperty("descripcion", false, GET, array( "string" )),
			"nota" => new ApiExposedProperty("nota", false, GET, array( "string" )),
			"folio" => new ApiExposedProperty("folio", false, GET, array( "string" )),
			"id_sucursal" => new ApiExposedProperty("id_sucursal", false, GET, array( "int" )),
			"id_concepto_ingreso" => new ApiExposedProperty("id_concepto_ingreso", false, GET, array( "int" )),
			"id_caja" => new ApiExposedProperty("id_caja", false, GET, array( "int" )),
			"monto" => new ApiExposedProperty("monto", false, GET, array( "float" )),
			"billetes" => new ApiExposedProperty("billetes", false, GET, array( "json" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = CargosYAbonosController::NuevoIngreso( 
 			
			
			isset($_GET['id_empresa'] ) ? $_GET['id_empresa'] : null,
			isset($_GET['fecha_ingreso'] ) ? $_GET['fecha_ingreso'] : null,
			isset($_GET['descripcion'] ) ? $_GET['descripcion'] : null,
			isset($_GET['nota'] ) ? $_GET['nota'] : null,
			isset($_GET['folio'] ) ? $_GET['folio'] : null,
			isset($_GET['id_sucursal'] ) ? $_GET['id_sucursal'] : null,
			isset($_GET['id_concepto_ingreso'] ) ? $_GET['id_concepto_ingreso'] : null,
			isset($_GET['id_caja'] ) ? $_GET['id_caja'] : null,
			isset($_GET['monto'] ) ? $_GET['monto'] : null,
			isset($_GET['billetes'] ) ? $_GET['billetes'] : null
			
			);
		}catch(Exception $e){
 			Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation() );
		}
 	}
  }
  
  
  
  
  
  