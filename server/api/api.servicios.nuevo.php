<?php
/**
  * GET api/servicios/nuevo
  * Ofrecer un nuevo servicio
  *
  * Crear un nuevo concepto de servicio.
  *
  *
  *
  **/

  class ApiServiciosNuevo extends ApiHandler {
  

	protected function DeclareAllowedRoles(){  return BYPASS;  }
	protected function CheckAuthorization() {}
	protected function GetRequest()
	{
		$this->request = array(	
			"costo_estandar" => new ApiExposedProperty("costo_estandar", true, GET, array( "float" )),
			"metodo_costeo" => new ApiExposedProperty("metodo_costeo", true, GET, array( "string" )),
			"nombre_servicio" => new ApiExposedProperty("nombre_servicio", true, GET, array( "string" )),
			"codigo_servicio" => new ApiExposedProperty("codigo_servicio", true, GET, array( "string" )),
			"empresas" => new ApiExposedProperty("empresas", true, GET, array( "json" )),
			"compra_en_mostrador" => new ApiExposedProperty("compra_en_mostrador", true, GET, array( "bool" )),
			"sucursales" => new ApiExposedProperty("sucursales", true, GET, array( "json" )),
			"descripcion_servicio" => new ApiExposedProperty("descripcion_servicio", false, GET, array( "string" )),
			"garantia" => new ApiExposedProperty("garantia", false, GET, array( "int" )),
			"retenciones" => new ApiExposedProperty("retenciones", false, GET, array( "json" )),
			"impuestos" => new ApiExposedProperty("impuestos", false, GET, array( "json" )),
			"activo" => new ApiExposedProperty("activo", false, GET, array( "bool" )),
			"clasificaciones" => new ApiExposedProperty("clasificaciones", false, GET, array( "json" )),
			"margen_de_utilidad" => new ApiExposedProperty("margen_de_utilidad", false, GET, array( "float" )),
			"control_de_existencia" => new ApiExposedProperty("control_de_existencia", false, GET, array( "int" )),
			"foto_servicio" => new ApiExposedProperty("foto_servicio", false, GET, array( "string" )),
		);
	}

	protected function GenerateResponse() {		
		try{
 		$this->response = ServiciosController::Nuevo( 
 			
			
			isset($_GET['costo_estandar'] ) ? $_GET['costo_estandar'] : null,
			isset($_GET['metodo_costeo'] ) ? $_GET['metodo_costeo'] : null,
			isset($_GET['nombre_servicio'] ) ? $_GET['nombre_servicio'] : null,
			isset($_GET['codigo_servicio'] ) ? $_GET['codigo_servicio'] : null,
			isset($_GET['empresas'] ) ? $_GET['empresas'] : null,
			isset($_GET['compra_en_mostrador'] ) ? $_GET['compra_en_mostrador'] : null,
			isset($_GET['sucursales'] ) ? $_GET['sucursales'] : null,
			isset($_GET['descripcion_servicio'] ) ? $_GET['descripcion_servicio'] : null,
			isset($_GET['garantia'] ) ? $_GET['garantia'] : null,
			isset($_GET['retenciones'] ) ? $_GET['retenciones'] : null,
			isset($_GET['impuestos'] ) ? $_GET['impuestos'] : null,
			isset($_GET['activo'] ) ? $_GET['activo'] : null,
			isset($_GET['clasificaciones'] ) ? $_GET['clasificaciones'] : null,
			isset($_GET['margen_de_utilidad'] ) ? $_GET['margen_de_utilidad'] : null,
			isset($_GET['control_de_existencia'] ) ? $_GET['control_de_existencia'] : null,
			isset($_GET['foto_servicio'] ) ? $_GET['foto_servicio'] : null
			
			);
		}catch(Exception $e){
 			Logger::error($e);
			throw new ApiException( $this->error_dispatcher->invalidDatabaseOperation() );
		}
 	}
  }
  
  
  
  
  
  