<?php

require_once("interfaces/Almacenes.interface.php");

class AlmacenesController extends ValidacionesController implements IAlmacenes{
	

	/**
 	 *
 	 *listar almacenes de la isntancia. Se pueden filtrar por empresa, por sucursal, por tipo de almacen, por activos e inactivos y ordenar por sus atributos.
 	 *
 	 * @param activo bool Si este valor no es obtenido, se mostraran almacenes tanto activos como inactivos. Si es verdadero, solo se lsitaran los activos, si es falso solo se lsitaran los inactivos.
 	 * @param id_empresa int Id de la empresa de la cual se listaran sus almacenes
 	 * @param id_sucursal int el id de la sucursal de la cual se listaran sus almacenes
 	 * @param id_tipo_almacen int Se listaran los almacenes de este tipo
 	 * @return numero_de_resultados int 
 	 * @return resultados json Almacenes encontrados
 	 **/
  static function Buscar
	(
		$activo = null, 
		$id_empresa = null, 
		$id_sucursal = null, 
		$id_tipo_almacen = null
	){
		


		if(!is_null($id_sucursal)){


            $almacenes = AlmacenDAO::search(new Almacen(array(
                "id_sucursal"       => $id_sucursal,
                "id_empresa"        => $id_empresa,
                "id_tipo_almacen"   => $id_tipo_almacen
                )
            ));

			return array("resultados" => $almacenes, "numero_de_resultados" => sizeof($almacenes));
		}
		
		$almacenes = AlmacenDAO::getAll(  );

        return array("resultados" => $almacenes, "numero_de_resultados" => sizeof($almacenes));

		/*
            $parametros=false;
            if
            (
                    !is_null($id_empresa)  ||
                    !is_null($id_sucursal) ||
                    !is_null($id_tipo_almacen) ||
                    !is_null($activo)
            )
                $parametros=true;
            $almacenes=null;
            
            //Si se recibieron parametros, se buscan los almacenes con dichos parametros, si no
            //se imprimen todos los almacenes
            if($parametros)
            {
                Logger::log("Se recibieron parametros, se listan las almacenes en rango");
                
                //Se valida el parametro activo
                /*$validar = self::validarParametrosAlmacen(null, null, null, null, null, null, $activo);
                if(is_string($validar))
                {
                    Logger::error($validar);
                    throw new Exception($validar);
                }* /
                
                $almacen_criterio_1=new TipoAlmacenDAO();
                $almacen_criterio_1->setActivo($activo);
                $almacen_criterio_1->setIdEmpresa($id_empresa);
                $almacen_criterio_1->setIdSucursal($id_sucursal);
                $almacen_criterio_1->setIdTipoAlmacen($id_tipo_almacen);
                $almacenes=TipoAlmacenDAO::search($almacen_criterio_1);

            }else{
	            Logger::log("No se recibieron parametros, se listan todos los almacenes");
	
                

            }
			*/
			

	}
  
  
	
  
	/**
 	 *
 	 *Descativa un almacen. Para poder desactivar un almacen, este tiene que estar vac?o
 	 *
 	 * @param id_almacen int Id del almacen a desactivar
 	 **/
  static function Desactivar
	(
		$id_almacen
	){
            $almacen=AlmacenDAO::getByPK($id_almacen);

            //verifica que el almacen exista, que este activo y que su tipo no sea de consignacion
            if(is_null($almacen)) {
                Logger::error("El almacen con id: ".$id_almacen." no existe");
                throw new InvalidDataException("El almacen con id: ".$id_almacen." no existe");
			}

			if (!$almacen->getActivo()) {
                Logger::warn("El almacen ya esta inactivo");
                throw new BusinessLogicException("El almacen ya esta inactivo");
			}

            if($almacen->getIdTipoAlmacen()==2)
            {
                Logger::error("No se puede eliminar con este metodo un almacen de tipo consignacion");
                throw new BusinessLogicException("No se puede eliminar con este metodo un almacen de tipo consignacion");
            }

			//verificamos que se hayan terminado todos los productos de los lotes de esta sucursal
            $lotes_almacen = LoteDAO::search( new Lote( array(
                "id_almacen" => $id_almacen
            )));
			Logger::log("El almacen a desactivar tiene " . sizeof($lotes_almacen) . " lotes.");
            foreach( $lotes_almacen as $lote_almacen ){

                $lote_producto = LoteProductoDAO::search( new LoteProducto( array(
                    "id_lote" => $lote_almacen->getIdLote()
                ) ) );

                foreach ($lote_producto as $lote) {
                    if ($lote->getCantidad() > 0) {
                        Logger::error("El lote {$lote->getIdLote()} tiene cantidad > 0 (" . $lote->getCantidad() . ") ");
                        throw new BusinessLogicException("El lote {$lote->getIdLote()} no esta vacio.");
                    }
                }
            }
            //TODO : Revisar como se manejaran los traspasos ya que por ahora se estan omitiendo

            $almacen->setActivo(0);
            DAO::transBegin();
            try
            {
                AlmacenDAO::save($almacen);
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo eliminar el almacen: ".$e);
                throw new InvalidDatabaseOperationException("No se pudo eliminar el almacen");
            }
            DAO::transEnd();
            Logger::log("Almacen eliminado exitosamente");
	}
  
  
	
  
	/**
 	 *
 	 *Edita la informacion de un almacen
 	 *
 	 * @param id_almacen int Id del almacen a editar
 	 * @param descripcion string Descripcion del almacen
 	 * @param id_tipo_almacen int Id del tipo de almacen al que sera cambiado. No se puede cambiar este parametro si se trata de un almacen de consignacion ni se puede editar para que sea un almacen de consignacion
 	 * @param nombre string Nombre del almacen
 	 **/
  static function Editar
	(
		$id_almacen, 
		$descripcion = null, 
		$id_tipo_almacen = null, 
		$nombre = null
	){
            Logger::log("Editando almacen");

            //varificamos si el almacen exisate y esta activo
            if( ! $almacen = AlmacenDAO::getByPK($id_almacen) ){
                Logger::log("No se tiene registro del almacen {$id_almacen}");
                throw new BusinessLogicException("No se tiene registro del almacen {$id_almacen}");
            }    
                

            if(!$almacen->getActivo())
            {
                Logger::error("El almacen no esta activo, no puede ser editado");
                throw new BusinessLogicException("El almacen no esta activo, no puede ser editado");
            }
            
            //Si un parametro no es nulo, se toma como actualizacion
            if(!is_null($descripcion))
            {
                $almacen->setDescripcion($descripcion);
            }

            if(!is_null($nombre))
            {
                //Se verifica que el nombre del almacen no se repita
                $almacenes = AlmacenDAO::search( new Almacen( array( "id_sucursal" => $almacen->getIdSucursal() ) ) );
                foreach($almacenes as $a)
                {
                    if($a->getNombre()==trim($nombre) && $a->getIdAlmacen()!=$id_almacen)
                    {
                        Logger::log("El nombre (".$nombre.") ya esta siendo usado por el almacen: ".$a->getIdAlmacen());
                        throw new BusinessLogicException("El nombre ya esta en uso");
                    }
                }
                $almacen->setNombre(trim($nombre));
            }                    

            //El tipo de almacen no puede ser cambiado a un almacen de consignacion, 
            //ni un almacen de consignacion puede ser cambiado a otro tipo de almacen.
            if(!is_null($id_tipo_almacen))
            {

                //verificamos que el tipo de almacen exista
                if( ! $tipo_almacen = TipoAlmacenDAO::getByPK( $id_tipo_almacen ) ){
                    Logger::log("No se tiene registro del tipo de almacen {$id_tipo_almacen}");
                    throw new BusinessLogicException("No se tiene registro del tipo de almacen {$id_tipo_almacen}");
                }

                if($id_tipo_almacen==2)
                {
                    Logger::warn("Se busca cambiar el tipo de almacen para volverse un almacen de consignacion, no se hara nada pues esto no esta permitido");
                }
                else if($almacen->getIdTipoAlmacen()==2)
                {
                    Logger::warn("Se busca editar el tipo de almacen a un almacen de consignacion, no se hara nada pues esto no esta permitido");
                }
                else
                {
                    $almacen->setIdTipoAlmacen($id_tipo_almacen);
                }
            }
            DAO::transBegin();
            try
            {
                AlmacenDAO::save($almacen);
            }
            catch(Exception $e)
            {
                DAO::transRollBack();
                Logger::error("No se pudo editar el almacen: ".$e);
                throw new Exception("No se pudo editar el almacen");
            }
            DAO::transEnd();
            Logger::log("Almacen editado exitosamente");
	}
  
  
	
  
	/**
 	 *
 	 *Metodo que surte una sucursal por parte de un proveedor. La sucursal sera tomada de la sesion actual.

Update
Creo que este metodo tiene que estar bajo sucursal.
 	 *
 	 * @param id_almacen int Id del almacen que se surte
 	 * @param productos json Objeto que contendr los ids de los productos, sus unidades y sus cantidades
 	 * @param motivo string Motivo del movimiento
 	 * @return id_surtido string Id generado por el registro de surtir
 	 **/
  static function Entrada
	(
		$id_almacen, 
		$productos, 
		$motivo = null
	){
            Logger::log("Resgitrando entrada a almacen");
            $entrada_almacen = new EntradaAlmacen();
            
            //Se obtiene el usuario de la sesion
            $id_usuario=SesionController::getCurrentUser();
            if(is_null($id_usuario))
            {
                Logger::error("No se puede obtener al usuario de la sesion, ya inicio sesion?");
                throw new Exception("No se puede obtener al usuario de la sesion, ya inicio sesion?");
            }
            
            //valida que el almacen exista
            $almacen = AlmacenDAO::getByPK($id_almacen);
            if(is_null($almacen))
            {
                Logger::error("El almacen con id: ".$id_almacen." no existe");
                throw new Exception("El almacen con id: ".$id_almacen." no existe");
            }
            
            if(!$almacen->getActivo())
            {
                Logger::error("El almacen no esta activo, no se le pueden ingresar productos");
                throw new Exception("El almacen no esta activo, no se le pueden ingresar productos");
            }
            
            //valida que el motivo sea un string valido
            if(!is_null($motivo))
            {
                $validar = self::validarString($motivo, 255, "motivo");
                if(is_string($validar))
                {
                    Logger::error($validar);
                    throw new Exception($validar);
                }
            }
            //Se inicializa el registro de la tabla entrada_almacen
            $entrada_almacen->setIdAlmacen($id_almacen);
            $entrada_almacen->setMotivo($motivo);
            $entrada_almacen->setIdUsuario($id_usuario);
            $entrada_almacen->setFechaRegistro(time());
            DAO::transBegin();
            try
            {
                //se guarda el registro de entrada_almacen
                EntradaAlmacenDAO::save($entrada_almacen);
                
                //Por cada producto recibido se crea un registro en  la tabla producto_entrada_almacen.
                //Cada producto ingresado incrementa su cantidad en el almacen. Si aun no existe,
                //se crea su registro y se guarda.
                $producto_entrada_almacen=new ProductoEntradaAlmacen(array( "id_entrada_almacen" => $entrada_almacen->getIdEntradaAlmacen() ));
                
                $productos = object_to_array($productos);
                
                if(!is_array($productos))
                {
                    throw new Exception("Los productos fueron recibidos incorrectamente",901);
                }
                
                foreach($productos as $p)
                {
                    
                    if
                    (
                            !array_key_exists("id_producto", $p)    ||
                            !array_key_exists("id_unidad", $p)      ||
                            !array_key_exists("cantidad", $p)
                    )
                    {
                        throw new Exception("Los productos fueron recibidos incorrectamente",901);
                    }
                    
                    //valida que el producto a ingresar pertenezca a la misma empresa que el almacen
                    //pues un almacen solo puede ocntener producto de la empresa a la que pertenece.
                    $productos_empresa = ProductoEmpresaDAO::search( new ProductoEmpresa( array( "id_producto" => $p["id_producto"] ) ) );
                    $encontrado = false;
                    foreach($productos_empresa as $p_e)
                    {
                        if($p_e->getIdEmpresa() == $almacen->getIdEmpresa())
                        {
                            $encontrado = true;
                        }
                    }
                    if(!$encontrado)
                    {
                        throw new Exception("Se quiere agregar un producto que no es de la empresa de este almacen",901);
                    }
                    
                    if(is_null(ProductoDAO::getByPK($p["id_producto"])))
                        throw new Exception("El producto con id: ".$p["id_producto"]." no existe",901);

                    $producto_entrada_almacen->setIdProducto($p["id_producto"]);
                    if(is_null(UnidadDAO::getByPK($p["id_unidad"])))
                        throw new Exception("La unidad con id: ".$p["id_unidad"]." no existe",901);

                    $producto_entrada_almacen->setIdUnidad($p["id_unidad"]);
                    $producto_entrada_almacen->setCantidad($p["cantidad"]);
                    $producto_almacen=ProductoAlmacenDAO::getByPK($p["id_producto"], $id_almacen, $p["id_unidad"]);
                    
                    if(is_null($producto_almacen))
                        $producto_almacen=new ProductoAlmacen(array( "id_producto" => $p["id_producto"] , "id_almacen" => $id_almacen , "id_unidad" => $p["id_unidad"] ));

                    $producto_almacen->setCantidad($producto_almacen->getCantidad()+$p["cantidad"]);
                    ProductoEntradaAlmacenDAO::save($producto_entrada_almacen);
                    ProductoAlmacenDAO::save($producto_almacen);
                }
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo registrar la entrada al almacen: ".$e);
                if($e->getCode()==901)
                    throw new Exception("No se pudo registrar la entrada al almacen: ".$e->getCode(),901);
                throw new Exception("No se pudo registrar la entrada al almacen",901);
            }
            DAO::transEnd();
            Logger::log("Entrada a almacen registrada exitosamente");
            return array("id_surtido" => $entrada_almacen->getIdEntradaAlmacen());
	}
  
  
	
  
	/**
 	 *
 	 *Creara un nuevo almacen en una sucursal, este almacen contendra lotes.
 	 *
 	 * @param id_empresa int Id de la empresa a la que pertenecen los productos de este almacen
 	 * @param id_sucursal int El id de la sucursal a la que pertenecera este almacen.
 	 * @param id_tipo_almacen int Id del tipo de almacen 
 	 * @param nombre string nombre del almacen
 	 * @param descripcion string Descripcion extesa del almacen
 	 * @return id_almacen int el id recien generado
 	 **/
  static function Nuevo
	(
		$id_empresa, 
		$id_sucursal, 
		$id_tipo_almacen, 
		$nombre, 
		$descripcion = null
	){
            //verificamos que exista la empresa
            if( !is_null($id_empresa) && !$empresa = EmpresaDAO::getByPK( $id_empresa ) ){
                throw new Exception("No se tiene registro de la empresa {$id_empresa}");
            }
    
            //verificamos que exista la sucursal
            if( !is_null($id_sucursal) && !$sucursal = SucursalDAO::getByPK( $id_sucursal ) ){
                throw new Exception("No se tiene registro de la sucursal {$id_sucursal}");
            }

            //verificamos que exista el tipo de almacen
            if( !is_null($id_tipo_almacen) && !$almacen = TipoAlmacenDAO::getByPK( $id_tipo_almacen ) ){
                throw new Exception("No se tiene registro del tipo de almacen {$id_tipo_almacen}");
            }

            //verificamos que se haya especificado el nombre
            if( !ValidacionesController::validarLongitudDeCadena(trim($nombre), 2, 100) ){
                throw new Exception("El nombre debe ser una cadena entre 2 y 100 caracteres, se encontro \"" . trim($nombre) . "\" ");
            }
            
           
            //Se valida si hay un almacen con ese mimso nombre en esta sucursal
            $almacenes = AlmacenDAO::search(new Almacen( array( "id_sucursal" => $id_sucursal ) ) );
            foreach($almacenes as $almacen)
            {
                if($almacen->getNombre()==trim($nombre)&&$almacen->getActivo())
                {
                    Logger::log("El nombre (".$nombre.") ya esta siendo usado por el almacen: ".$almacen->getIdAlmacen());
                    throw new Exception("El nombre ya esta en uso");
                }
            }
            
            //Si se recibe un tipo de almacen de consignacion, se manda una excepcion, pues no se puede crear un almacen
            //de consignacion con este metodo.
            if($id_tipo_almacen==2)
            {
                Logger::error("No se puede crear un almacen de consignacion con este metodo");
                throw new Exception("No se puede crear un almacen de consignacion con este metodo");
            }
            
            //Solo puede haber un almacen por tipo por cada empresa en una sucursal.
            $almacenes = AlmacenDAO::search( new Almacen( array( "id_sucursal" => $id_sucursal ,
                "id_empresa" => $id_empresa , "id_tipo_almacen" => $id_tipo_almacen ) ) );
            if(!empty($almacenes))
            {
                Logger::error("Ya existe un almacen (".$almacenes[0]->getIdAlmacen().") de este tipo (".$id_tipo_almacen.") en esta sucursal (".$id_sucursal.") para esta empresa (".$id_empresa.")");
                throw new Exception("Ya existe un almacen de este tipo en esta sucursal para esta empresa");
            }
            
            //Se inicializa el registro a guardar con los datos obtenidos.
            $almacen=new Almacen();
            $almacen->setNombre(trim($nombre));
            $almacen->setDescripcion($descripcion);
            $almacen->setIdSucursal($id_sucursal);
            $almacen->setIdEmpresa($id_empresa);
            $almacen->setIdTipoAlmacen($id_tipo_almacen);
            $almacen->setActivo(1);
            DAO::transBegin();
            try
            {
                AlmacenDAO::save($almacen);
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo crear el nuevo almacen");
                throw new Exception("No se pudo crear el nuevo almacen");
            }
            DAO::transEnd();
            Logger::log("Almacen ".  $almacen->getIdAlmacen() . " creado exitosamente");
            return array( "id_almacen" => (int) $almacen->getIdAlmacen());
	}
  
  
	
  
	/**
 	 *
 	 *Envia productos fuera del almacen. Ya sea que sea un traspaso de un alamcen a otro o por motivos de inventarios fisicos.
 	 *
 	 * @param id_almacen int Id del almacen del cual se hace el movimiento
 	 * @param productos json Objeto que contendra los ids de los productos que seran sacados del alamcen con sus cantidades y sus unidades
 	 * @param motivo string Motivo de la salida del producto
 	 * @return id_salida int ID de la salida del producto
 	 **/
  static function Salida
	(
		$id_almacen, 
		$productos, 
		$motivo = null
	){  
            Logger::log("Registrando salida de almacen");
            
            //Se obtiene al usuario de la sesion
            $id_usuario=SesionController::getCurrentUser();
            if(is_null($id_usuario))
            {
                Logger::error("No se pudo obtener al usuario de la sesion, ya inicio sesion?");
                throw new Exception("No se pudo obtener al usuario de la sesion, ya inicio sesion?");
            }
            
            //valida si el almacen existe y si esta activo
            $almacen = AlmacenDAO::getByPK($id_almacen);
            if(is_null($almacen))
            {
                Logger::error("El almacen con id: ".$id_almacen." no existe");
                throw new Exception("El almacen con id: ".$id_almacen." no existe");
            }
            if(!$almacen->getActivo())
            {
                Logger::error("El almacen no esta activo, no puede salir producto de el");
                throw new Exception("El almacen no esta activo, no puede salir producto de el");
            }
            
            //Valida que el motivo sea un string valido
            if(!is_null($motivo))
            {
                $validar = self::validarString($motivo, 255, "motivo");
                if(is_string($validar))
                {
                    Logger::error($validar);
                    throw new Exception($validar);
                }
            }
            //Se inicializa el registro de la tabla salida_almacen
            $salida_almacen = new SalidaAlmacen(array(
                            "id_almacen" => $id_almacen,
                            "id_usuario" => $id_usuario,
                            "fecha_registro" => time(),
                            "motivo" => $motivo
                                    )
                                );
            DAO::transBegin();
            try
            {
                //Se guarda el registro de la salida almacen y se sacan los productos solicitados
                //del almacen
                SalidaAlmacenDAO::save($salida_almacen);
                $producto_salida_almacen=new ProductoSalidaAlmacen(array( "id_salida_almacen" => $salida_almacen->getIdSalidaAlmacen() ));
                
                $productos = object_to_array($productos);
                
                if(!is_array($productos))
                {
                    throw new Exception("Los productos son invalidos",901);
                }
                
                foreach($productos as $p)
                {
                    
                    if
                    (
                            !array_key_exists("id_producto", $p)    ||
                            !array_key_exists("id_unidad", $p)      ||
                            !array_key_exists("cantidad", $p)
                    )
                    {
                        throw new Exception("Los productos son invalidos",901);
                    }
                    
                    //Se busca en el almacen el producto solicitado, si no es encontrado, se manda una excepcion
                    $producto_almacen=ProductoAlmacenDAO::getByPK($p["id_producto"], $id_almacen, $p["id_unidad"]);
                    if(is_null($producto_almacen))
                    {
                        throw new Exception("El producto: ".$p["id_producto"]." en la unidad: ".$p["id_unidad"]."
                            no se encuentra en el almacen: ".$id_almacen.". No se puede registrar la salida");
                    }
                    //Se analiza la cantidad actual del producto en el almacen. Si la solicitada
                    //es mayor que la cantidad actual, se arroja una excepcion.
                    $cantidad_actual=$producto_almacen->getCantidad();
                    if($cantidad_actual<$p["cantidad"])
                    {
                        throw new Exception("Se busca sacar mas cantidad de producto de la que hay actualmente. Actual: ".$cantidad_actual." - Salida: ".$p["cantidad"]);
                    }
                    $producto_almacen->setCantidad($cantidad_actual-$p["cantidad"]);
                    $producto_salida_almacen->setIdProducto($p["id_producto"]);
                    $producto_salida_almacen->setIdUnidad($p["id_unidad"]);
                    $producto_salida_almacen->setCantidad($p["cantidad"]);
                    ProductoAlmacenDAO::save($producto_almacen);
                    ProductoSalidaAlmacenDAO::save($producto_salida_almacen);
                }/* Fin de foreach */
            } /* Fin de try */
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo registrar la salida de producto: ".$e);
                throw new Exception("No se pudo registrar la salida de producto");
            }
            DAO::transEnd();
            Logger::log("Salida de almacen registrada correctamente");
            return array("id_salida" => $salida_almacen->getIdSalidaAlmacen());
	}
  
  
	
  
	/**
 	 *
 	 *Imprime la lista de tipos de almacen
 	 *
 	 * @param activo bool Si este valor no es pasado, se listaran los tipos de almacen tanto activos como inactivos, si su valor es true, solo se mostraran los tipos de amacen activos, si es false, solo se mostraran los tipos de almacén inactivos.
 	 * @param limit string Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
 	 * @param query string Valor que se buscara en la consulta
 	 * @param start string Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
 	 * @return numero_de_resultados int Arreglo con la lista de almacenes
 	 * @return resultados json 
 	 **/
  static function BuscarTipo
	(
		$activo = null, 
		$limit = null, 
		$query = null, 
		$start = null
	){

        $array = Array();

        array_push( $array, isset($activo)? $activo : 1 );

        $search = TipoAlmacenDAO::buscarTipoAlmacen( $array, isset($start)?$start:null, isset($limit)?$limit:null, "id_tipo_almacen", "DESC", $query );

        return array(
            "resultados" => $search,
            "numero_de_resultados" => sizeof($search)
		);

	}
  
  
	
  
	/**
 	 *
 	 *Elimina un tipo de almacen
 	 *
 	 * @param id_tipo_almacen int Id del tipo de almacen a editar
 	 **/
  static function DesactivarTipo
	(
		$id_tipo_almacen
	){
	
        Logger::log("Eliminando tipo de almacen ".$id_tipo_almacen);
        
        //El almacen de consignacion no se puede borrar
        if($id_tipo_almacen==2)
        {
            Logger::error("Se intento eliminar el almacen de consginacion");
            throw new Exception("El almacen de consignacion no puede ser eliminado",901);
        }
        
        //Se valida que el tipo de almacen exista
        $tipo_almacen = TipoAlmacenDAO::getByPK($id_tipo_almacen);
        if(is_null($tipo_almacen))
        {
            Logger::error("El tipo de almacen ".$id_tipo_almacen." no existe");
            throw new Exception("El tipo de almacen ".$id_tipo_almacen." no existe",901);
        }
        
        //Si un almacen activo aun pertenece a este tipo de almacen, no se podra eliminar
        $almacenes = AlmacenDAO::search( new Almacen( array( "id_tipo_almacen" => $id_tipo_almacen ) ) );
        foreach($almacenes as $almacen)
        {
            if($almacen->getActivo())
            {
                Logger::error("No se puede eliminar el tipo de almacen ".$id_tipo_almacen." pues aun es usado por almacenes activos");
                throw new Exception("No se puede eliminar este tipo de almacen pues aun hay almacenes activos con este tipo",901);
            }
        }
        
        
        DAO::transBegin();
        try
        {            $tipo_almacen->setActivo(0);
            TipoAlmacenDAO::save($tipo_almacen);
        }
        catch(Exception $e)
        {
            DAO::transRollback();
            Logger::error("No se pudo eliminar el tipo de almacen: ".$e);
            throw new Exception("No se pudo eliminar el tipo de almacen, consulte a su administrador de sistema");
        }
        DAO::transEnd();
        Logger::log("Tipo de almacen eliminado exitosamente");
        
        
	}
  
  
	
  
	/**
 	 *
 	 *Edita un tipo de almacen
 	 *
 	 * @param id_tipo_almacen int Id del tipo de almacen a editar
 	 * @param activo bool Indica si el tipo almacén se activa o desactiva
 	 * @param descripcion string Descripcion del tipo de almacen
 	 **/
  static function EditarTipo
	(
		$id_tipo_almacen, 
		$activo = null, 
		$descripcion = null
	){
            Logger::log("Editando tipo de almacen ".$id_tipo_almacen);
            
            //Se valida que el tipo de almacen exista
            $tipo_almacen = TipoAlmacenDAO::getByPK($id_tipo_almacen);
            if(is_null($tipo_almacen))
            {
                Logger::error("El tipo de almacen ".$id_tipo_almacen." no existe");
                throw new Exception("El tipo de almacen ".$id_tipo_almacen." no existe");
            }
            
            //Se valida el parametro descripcion
            if(!is_null($descripcion))
            {

                if(!ValidacionesController::validarLongitudDeCadena($descripcion, 2, 64))
                {
                    Logger::error($validar);
                    throw new Exception($validar,901);
                }
                
                $tipos_almacen = array_diff(TipoAlmacenDAO::search(
                        new TipoAlmacen( array( "descripcion" => trim($descripcion) ) )), array( TipoAlmacenDAO::getByPK($id_tipo_almacen) ) );
                if(!empty($tipos_almacen))
                {
                    Logger::error("La descripcion (".$descripcion.") es repetida");
                    throw new Exception("La descripcion esta repetida");
                }
                
                $tipo_almacen->setDescripcion($descripcion);
            }
            
            DAO::transBegin();
            try
            {
                TipoAlmacenDAO::save($tipo_almacen);
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo editar el tipo de almacen ".$e);
                throw new Exception("No se pudo editar el tipo de almacen ",901);
            }
            DAO::transEnd();
            Logger::log("Tipo de almacen editado correctamente");
            
        }
  
  
	
  
	/**
 	 *
 	 *Edita un tipo de almacen
 	 *
 	 * @param id_tipo_almacen int Id del tipo de almacen a editar
 	 * @param activo bool Indica si el tipo almacén se activa o desactiva
 	 * @param descripcion string Descripcion del tipo de almacen
 	 **/
  static function NuevoTipo
	(
		$descripcion, 
		$activo = null
	){
            Logger::log("Creando nuevo tipo de almacen");
            
            
            if(!ValidacionesController::validarLongitudDeCadena($descripcion, 0, 64))
            {
                Logger::error("descripcion : {$descripcion}");
                throw new Exception($descripcion);
            }
            
            //No se puede repetir la descripcion del tipo de almacen
            $tipos_almacen = TipoAlmacenDAO::search(new TipoAlmacen( array( "descripcion" => trim($descripcion) ) ));

            if(!empty($tipos_almacen)){
                Logger::error("La descripcion (".$descripcion.") es repetida");
                throw new BusinessLogicException("La descripcion esta repetida");
            }
            
            $activo = $activo == null ? 1 : $activo;

            $tipo_almacen = new TipoAlmacen( array( "descripcion" => trim($descripcion), "activo" => $activo ) );
            
            DAO::transBegin();
            try{
                TipoAlmacenDAO::save($tipo_almacen);

            }catch(Exception $e){
                DAO::transRollback();
                
                Logger::error("No se pudo crear el nuevo tipo de almacen: ".$e);

                throw new InvalidDatabaseOperationException("No se pudo crear el nuevo tipo de almacen, contacte a su administrador de sistema");
            }

            DAO::transEnd();
            
            Logger::log("Tipo de almacen creado exitosamente");
            
            return array( "id_tipo_almacen" =>  (int)$tipo_almacen->getIdTipoAlmacen());
            
        }
  
  
	
  
	/**
 	 *
 	 *Lista los traspasos de almacenes. Puede filtrarse por empresa, por sucursal, por almacen, por producto, cancelados, completos, estado
 	 *
 	 * @param cancelado bool Si este valor no es obtenido, se listaran los traspasos tanto cancelados como no cancelados. Si su valor es verdadero se listaran solo los traspasos cancelados, si su valor es falso, se listaran los traspasos no cancelados
 	 * @param completo bool Si este valor no es obtenido, se listaran los traspasos tanto completos como no completos. Si su valor es verdadero, se listaran los traspasos completos, si es falso, se listaran los traspasos no completos
 	 * @param estado string Se listaran los traspasos cuyo estado sea este, si no es obtenido este valor, se listaran los traspasos de cualqueir estado
 	 * @param id_almacen_envia int Se listaran los traspasos enviados por este almacen
 	 * @param id_almacen_recibe int Se listaran los traspasos recibidos por este almacen
 	 * @param ordenar string Nombre de la columna por la cual se ordenara
 	 * @return traspasos json Lista de traspasos
 	 **/
  static function BuscarTraspaso
	(
		$cancelado = null, 
		$completo = null, 
		$estado = null, 
		$id_almacen_envia = null, 
		$id_almacen_recibe = null, 
		$ordenar = null
	){
		throw new Exception ("Missing Implementation");
	}
  
  
	
  
	/**
 	 *
 	 *Para poder cancelar un traspaso, este no tuvo que haber sido enviado aun.
 	 *
 	 * @param id_traspaso int Id del traspaso a cancelar
 	 **/
  static function CancelarTraspaso
	(
		$id_traspaso
	){
		throw new Exception ("Missing Implementation");
	} 
  
  
	
  
	/**
 	 *
 	 *Para poder editar un traspaso,este no tuvo que haber sido enviado aun
 	 *
 	 * @param id_traspaso int Id del traspaso a editar
 	 * @param fecha_envio_programada string Fecha de envio programada
 	 * @param productos json Productos a enviar con sus cantidades
 	 **/
  static function EditarTraspaso
	(
		$id_traspaso, 
		$fecha_envio_programada = null, 
		$productos = null
	){
		throw new Exception ("Missing Implementation");
	} 
  
  
	
  
	/**
 	 *
 	 *Cambia el estado del traspaso a enviado y captura la fecha de envio del servidor. El usuario que envia sera tomado del servidor.
 	 *
 	 * @param id_traspaso int Id del traspaso a enviar
 	 **/
  static function EnviarTraspaso
	(
		$id_traspaso
	){
		throw new Exception ("Missing Implementation");
	}  
  
  
	
  
	/**
 	 *
 	 *Crea un registro de traspaso de producto de un almacen a otro. El usuario que envia sera tomada de la sesion.
 	 *
 	 * @param fecha_envio_programada string Fecha de envio programada para este traspaso
 	 * @param id_almacen_envia int Id del almacen que envia el producto
 	 * @param id_almacen_recibe int Id del almacen al que se envia el producto
 	 * @param productos json Productos a ser enviados con sus cantidades
 	 * @return id_traspaso int Id del traspaso autogenerado
 	 **/
  static function ProgramarTraspaso
	(
		$fecha_envio_programada, 
		$id_almacen_envia, 
		$id_almacen_recibe, 
		$productos
	){
		throw new Exception ("Missing Implementation");
	}  
  
  
	
  
	/**
 	 *
 	 *Cambia el estado de un traspaso a recibido. La  bandera de completo se prende si los productos enviados son los mismos que los recibidos. La fecha de recibo es tomada del servidor. El usuario que recibe sera tomada de la sesion actual.
 	 *
 	 * @param id_traspaso int Id del traspaso que se recibe
 	 * @param productos json Productos que se reciben con sus cantidades
 	 **/
  static function RecibirTraspaso
	(
		$id_traspaso, 
		$productos
	){
		throw new Exception ("Missing Implementation");
	}  




	

	public static function DescontarDeLote($id_producto, $id_lote, $cantidad){
		
		
		
	}





	/**
 	 *
 	 *Metodo que surte una sucursal por parte de un proveedor. La sucursal sera tomada de la sesion actual.

 	 *
 	 * @param id_lote int Id del lote que se generó previamente y es el que recibe los productos
 	 * @param productos json Objeto que contendra los ids de los productos, sus unidades y sus cantidades
 	 * @param motivo string Motivo del movimiento
 	 * @return id_entrada_lote string Id generado por el registro de surtir
 	 **/
  static function EntradaLote
	(
		$id_lote, 
		$productos, 
		$motivo = null
	){

        //existe el lote?
        if(is_null(LoteDAO::getByPK( $id_lote ))){
            throw new InvalidDataException("este lote no existe");
        }

		//validemos los productos
        if(!is_array( $productos ) && !is_array( $productos = object_to_array( $productos ) )){
            throw new InvalidDataException("productos no es un array");
        }

        $sesion = SesionController::Actual();

        DAO::transBegin();

        $_lote = new LoteEntrada();
        $_lote->setIdLote( $id_lote );
        $_lote->setIdUsuario( $sesion["id_usuario"] );
        $_lote->setFechaRegistro( time() );
        $_lote->setMotivo($motivo);

        try {
            LoteEntradaDAO::save( $_lote );

        } catch (Exception $e) {
            DAO::transRollback();
            throw new InvalidDatabaseOperationException($e);
        }

        for ($i=0; $i < sizeof($productos); $i++) { 
            if(!is_array($productos[$i]) && !is_array($productos[$i] = object_to_array($productos[$i]))){
                throw new InvalidDataException("El producto en la posicion $i no es un arreglo como se esperaba");
            }

            if(!array_key_exists("id_producto", $productos[$i])){
                throw new InvalidDataException("El producto en $i no tiene id_prodcuto");
            }

            if(!array_key_exists("cantidad", $productos[$i])){
                throw new InvalidDataException("El producto en $i no tiene cantidad");
            }

            if(is_null(ProductoDAO::getByPK($productos[$i]["id_producto"]))){
                throw new InvalidDataException("El producto " . $productos[$i]["id_producto"] . " no existe.");
            }

            if($productos[$i]["cantidad"] < 0){
                throw new InvalidDataException("El producto " . $productos[$i]["id_producto"] . " no puede agregar cantidad negativas.");
            }

            try{

                $_p = ProductoDAO::getByPK($productos[$i]["id_producto"]);
                $lp = LoteProductoDAO::getByPK( $id_lote, $productos[$i]["id_producto"] );

                if(!is_null($lp)){
                    Logger::log("Este producto ya existia en este lote");

                    //revisemos si es de la misma unidad
                    if($lp->getIdUnidad() == $_p->getIdUnidad()){
                        //es igual, solo hay que sumar
                        $lp->setCantidad( $lp->getCantidad() +  $productos[$i]["cantidad"]);    

                    }else{
                        //no es igual, hay que convertir
                        $r = UnidadMedidaDAO::convertir($_p->getIdUnidad(), $lp->getIdUnidad(), $productos[$i]["cantidad"] );
                        $lp->setCantidad( $lp->getCantidad() +  $r  );    
					}

                } else {

                    Logger::log("primera vez que se pone este producto en este lote");

                    $lp = new LoteProducto( array(
                        "id_lote" => $id_lote,
                        "id_producto" => $productos[$i]["id_producto"],
                        "cantidad" => $productos[$i]["cantidad"],
                        "id_unidad" => $_p->getIdUnidad()
                    ));
                }

                LoteProductoDAO::save($lp);

                LoteEntradaProductoDAO::save(new LoteEntradaProducto(array(
                        "id_lote_entrada" => $_lote->getIdLoteEntrada(),
                        "id_producto"   => $productos[$i]["id_producto"],
                        "id_unidad" => $_p->getIdUnidad(),
                        "cantidad"  => $productos[$i]["cantidad"]
                    )));

				Logger::log("Removiendo qty=" . $productos[$i]["cantidad"] . "; prod=" . $productos[$i]["id_producto"] . "; lote=" . $id_lote );
            }catch(Exception $e){
                Logger::error($e);
        		DAO::transRollback();
                throw new InvalidDatabaseOperationException($e);
            }

        }

        DAO::transEnd();
		Logger::log( "Entrada a lote " .$_lote->getIdLoteEntrada(). " exitosa." );
        return array("id_entrada_lote" => $_lote->getIdLoteEntrada());

    }




	/**
 	 *
 	 *Crear un nuevo lote
 	 *
 	 * @param id_almacen int A que almacen pertenecera este lote.
 	 * @param observaciones string Alguna observacin o detalle relevante que se deba documentar
 	 * @return id_lote int El identificador del lote recien generado.
 	 **/
  static function NuevoLote
	(
		$id_almacen, 
		$folio = null
	){
		
        if( ! $almacen = AlmacenDAO::getByPK( $id_almacen ) ){
            Logger::error("No se tiene registro del almacen {$id_almacen}");
            throw new BusinessLogicException("No se tiene registro del almacen {$id_almacen}");
        }
    
        $sesion = SesionController::Actual();

		$l = new Lote( array(
	            "id_almacen" => $almacen->getIdAlmacen(),
	            "id_usuario" => $sesion['id_usuario'],
	            "folio" => is_null($folio) ? "" : $folio
        	) );

        try{
			
            LoteDAO::save( $l );       

        }catch(Exception $e){                

            Logger::error("Error al crear nuevo lote {$e->getMessage()}");
            throw new InvalidDatabaseOperationException("Error al crear el nuevo lote");

        }            
	   
        return array("id_lote" => $l->getIdLote());	
	} 




	/**
 	 *
 	 *Envia productos fuera del almacen. Ya sea que sea un traspaso de un alamcen a otro o por motivos de inventarios fisicos.
 	 *
 	 * @param id_lote int Id del lote de donde se descontaran los productos.
 	 * @param productos json Objeto que contendra los ids de los productos que seran sacados del alamcen con sus cantidades y sus unidades
 	 * @param motivo string Motivo de la salida del producto
 	 * @return id_salida_lote int ID de la salida del producto
 	 **/
  static function SalidaLote
	(
		$id_lote, 
		$productos, 
		$motivo = null
	){
        if(is_null(LoteDAO::getByPK( $id_lote ))){
            throw new InvalidDataException("este lote no existe");
        }

        if(!is_array( $productos )){
            throw new InvalidDataException("productos no es un array");
        }

        $sesion = SesionController::Actual();

        DAO::transBegin();

        $sl = new LoteSalida();
        $sl->setIdLote( $id_lote );
        $sl->setIdUsuario( $sesion["id_usuario"] );
        $sl->setFechaRegistro( time() );
        $sl->setMotivo( is_null($motivo) ? "" : $motivo );
        

        try {
            LoteSalidaDAO::save( $sl );

        } catch (Exception $e) {
            DAO::transRollback();
            throw new InvalidDatabaseOperationException($e);
        }

        for ($i=0; $i < sizeof($productos); $i++) { 
            if(!is_array($productos[$i])){
                throw new InvalidDataException("El producto en la posicion $i no es un arreglo como se esperaba");
            }

            if(!array_key_exists("id_producto", $productos[$i])){
                throw new InvalidDataException("El producto en $i no tiene id_prodcuto");
            }

            if(!array_key_exists("cantidad", $productos[$i])){
                throw new InvalidDataException("El producto en $i no tiene cantidad");
            }

            if(is_null(ProductoDAO::getByPK($productos[$i]["id_producto"]))){
                throw new InvalidDataException("El producto " . $productos[$i]["id_producto"] . " no existe.");
            }

			$lp = LoteProductoDAO::getByPK( $id_lote,  $productos[$i]["id_producto"]);

            if (is_null($lp)) {
                throw new InvalidDataException("El lote $id_lote no tiene el producto " . $productos[$i]["id_producto"]);
            }

            if($productos[$i]["cantidad"] > $lp->getCantidad()){
                throw new InvalidDataException("Estas intentando sacar mas de lo que hay en el lote.");
            }

			if (!isset($productos[$i]["id_unidad"])) {
					throw new InvalidDataException("El producto " . $productos[$i]["id_producto"]
													. " proporcionado no tiene id_unidad");
			}
            $equivalencia = UnidadMedidaDAO::convertir($productos[$i]["id_unidad"], $lp->getIdUnidad(), $productos[$i]["cantidad"]);

            if ($equivalencia > $lp->getCantidad()) {
                Logger::log("Se Comparara {$equivalencia} > {$lp->getCantidad()}");
                throw new InvalidDataException("Estas intentando sacar mas de lo que hay en el lote.");
            }

            $lp->setCantidad( $lp->getCantidad() - $productos[$i]["cantidad"]);

            try{
                LoteProductoDAO::save($lp);

                LoteSalidaProductoDAO::save(new LoteSalidaProducto(array(
                        "id_lote_salida" => $sl->getIdLoteSalida(),
                        "id_producto"   => $productos[$i]["id_producto"],
                        "id_unidad" => $productos[$i]["id_unidad"],
                        "cantidad"  => $productos[$i]["cantidad"]
				)));

				Logger::log("Removiendo qty=" . $productos[$i]["cantidad"] . "; prod=" . $productos[$i]["id_producto"] . "; lote=" . $id_lote );

            }catch(Exception $e){
                Logger::error($e);
                throw new InvalidDatabaseOperationException($e);
            }
            
        }

        DAO::transEnd();

        return array("id_salida_lote" => $sl->getIdLoteSalida());


    }  




	/**
 	 *
 	 *Lista los traspasos de almacenes. Puede filtrarse por empresa, por sucursal, por almacen, por producto, cancelados, completos, estado
 	 *
 	 * @param cancelado bool Si este valor no es obtenido, se listaran los traspasos tanto cancelados como no cancelados. Si su valor es verdadero se listaran solo los traspasos cancelados, si su valor es falso, se listaran los traspasos no cancelados
 	 * @param completo bool Si este valor no es obtenido, se listaran los traspasos tanto completos como no completos. Si su valor es verdadero, se listaran los traspasos completos, si es falso, se listaran los traspasos no completos
 	 * @param estado string Se listaran los traspasos cuyo estado sea este, si no es obtenido este valor, se listaran los traspasos de cualqueir estado
 	 * @param id_almacen_envia int Se listaran los traspasos enviados por este almacen
 	 * @param id_almacen_recibe int Se listaran los traspasos recibidos por este almacen
 	 * @return resultados json Lista de traspasos
 	 * @return numero_de_resultados int 
 	 **/
  static function BuscarTraspasoLote
	(
		$cancelado = null, 
		$completo = null, 
		$estado = null, 
		$id_almacen_envia = null, 
		$id_almacen_recibe = null
	){}  




	/**
 	 *
 	 *Para poder cancelar un traspaso, este no tuvo que haber sido enviado aun.
 	 *
 	 * @param id_traspaso int Id del traspaso a cancelar
 	 **/
  static function CancelarTraspasoLote
	(
		$id_traspaso
	){}  




	/**
 	 *
 	 *Para poder editar un traspaso,este no tuvo que haber sido enviado aun
 	 *
 	 * @param id_sucursal string Id de la sucursal que recibir el traspaso
 	 * @param id_traspaso int Id del traspaso a editar
 	 * @param productos json Productos a enviar con sus cantidades y respectivos lotes del cual saldran
 	 * @param fecha_envio_programada string Fecha de envio programada
 	 **/
  static function EditarTraspasoLote
	(
		$id_sucursal, 
		$id_traspaso, 
		$productos, 
		$fecha_envio_programada = null
	){} 




	/**
 	 *
 	 *Cambia el estado del traspaso a enviado y captura la fecha de envio del servidor. El usuario que envia sera tomado del servidor.
 	 *
 	 * @param id_traspaso int Id del traspaso a enviar
 	 **/
  static function EnviarTraspasoLote
	(
		$id_traspaso
	){}  




	/**
 	 *
 	 *Crea un registro de traspaso de productos de un almacen a otro. El usuario que envia sera tomada de la sesion.
 	 *
 	 * @param fecha_envio_programada string Fecha de envi programada
 	 * @param id_sucursal string Id de la sucursal que va a recibir el producto
 	 * @param productos json Conjunto de productos que se van a traspasar.
 	 * @return id_traspaso int Id del traspaso que se genero
 	 **/
  static function NuevoTraspasoLote
	(
		$fecha_envio_programada, 
		$id_sucursal, 
		$productos
	){} 




	/**
 	 *
 	 *ESTO NO SE DEBE DE TOMAR EN CUENTA, PARA ESO ESTA NUEVO Crea un registro de traspaso de producto de un almacen a otro. El usuario que envia sera tomada de la sesion.
 	 *
 	 * @param fecha_envio_programada string Fecha de envio programada para este traspaso
 	 * @param id_almacen_envia int Id del almacen que envia el producto
 	 * @param id_almacen_recibe int Id del almacen al que se envia el producto
 	 * @param productos json Productos a ser enviados con sus cantidades
 	 * @return id_traspaso int Id del traspaso autogenerado
 	 **/
  static function ProgramarTraspasoLote
	(
		$fecha_envio_programada, 
		$id_almacen_envia, 
		$id_almacen_recibe, 
		$productos
	){}  




	/**
 	 *
 	 *Cambia el estado de un traspaso a recibido. La  bandera de completo se prende si los productos enviados son los mismos que los recibidos. La fecha de recibo es tomada del servidor. El usuario que recibe sera tomada de la sesion actual.
 	 *
 	 * @param id_traspaso int Id del traspaso que se recibe
 	 * @param productos json Productos que se reciben con sus cantidades y a su respectivo lote al cual se iran
 	 **/
  static function RecibirTraspasoLote
	(
		$id_traspaso, 
		$productos
	){} 

 
	/**
 	 *
 	 *buscar entre todos los lotes del sistema
 	 *
 	 * @return resultados json 
 	 * @return numero_de_resultados int 
 	 **/
  static function BuscarLote
	(
	){
		
		
		$lotes = LoteDAO::getAll();
		
		return array(
			"resultados" => $lotes,
			"numero_de_resultados" => sizeof($lotes )
		);
		
	}
  
  
	
}
