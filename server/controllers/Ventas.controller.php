<?php
require_once("interfaces/Ventas.interface.php");
/**
  *
  *
  *
  **/
	
  class VentasController implements IVentas{
  
      
        public static function ActualizarTotales($id_venta){


            Logger::log("actualizando el total de la venta ". $id_venta);

            $v = VentaDAO::getByPK($id_venta);

            if(is_null($v)){
                throw new InvalidDataException("Esta venta no existe");
            }

            //iniciar valores
            $subtotal = 0;

			//buscar los productos
			$vp = VentaProductoDAO::search( new VentaProducto( array ( "id_venta" =>$id_venta )) );
			for ($i=0; $i < sizeof($vp); $i++) {
				Logger::log( "prioducto". $vp[$i]->getPrecio());
				$subtotal  += ($vp[$i]->getPrecio() *  $vp[$i]->getCantidad());
			}

            //buscar los servicios
			$vo = VentaOrdenDAO::search( new VentaOrden( array (  "id_venta" =>$id_venta)) );
			for ($i=0; $i < sizeof($vo); $i++) {
				$subtotal  += $vo[$i]->getPrecio();
				Logger::log("servicio". $vo[$i]->getPrecio());
			}

            //buscar los ipouestos
            $im = ImpuestoDAO::search(new Impuesto( array( )));
            $iporcentaje = 0;

            for ($i=0; $i < sizeof($im); $i++) {
                $iporcentaje += $im[$i]->getImporte();
            }

            $itotal = $subtotal * $iporcentaje;
            $total = $itotal + $subtotal;

            //itotal, total, subtotal
            $v->setSubtotal($subtotal);
            $v->setImpuesto($itotal);
            $v->setTotal($total);


            try{
                VentaDAO::save($v);

            }catch(Exception $e){
                Logger::error($e);
                throw $e;
            }


            return true;
        }

        













        /*
         * Valida los parametros de la tabla venta_arpilla. Regresa un string con el error en caso de 
         * encontrarse alguno, de lo contrario regresa verdadero
         */
        private static function validarParametrosVentaArpilla
        (
                $id_venta = null,
                $peso_origen = null,
                $folio = null,
                $numero_de_viaje = null,
                $peso_destino = null,
                $arpillas = null,
                $peso_por_arpilla = null,
                $productor = null,
                $merma_por_arpilla = null,
                $total_origen = null
        )
        {
            //valida que la venta exista y que este activa
            if(!is_null($id_venta))
            {
                $venta = VentaDAO::getByPK($id_venta);
                if(is_null($venta))
                    return "La venta ".$id_venta." no existe";
                
                if($venta->getCancelada())
                    return "La venta ".$id_venta." ya esta cancelada";
            }
            
            //valida el peso de origen
            if(!is_null($peso_origen))
            {
                $e = self::validarNumero($peso_origen, 1.8e200, "peso de origen");
                if(is_string($e))
                    return $e;
            }
            
            //valida el folio
            if(!is_null($folio))
            {
                $e = self ::validarString($folio, 11, "folio");
                if(is_string($e))
                    return $e;
            }
            
            //valida el numero de viaje
            if(!is_null($numero_de_viaje))
            {
                $e = self::validarString($numero_de_viaje, 11, "numero de viaje");
                if(is_string($e))
                    return $e;
            }
            
            //valida el peso recibido
            if(!is_null($peso_destino))
            {
                $e = self::validarNumero($peso_destino, 1.8e200, "peso recibido");
                if(is_string($e))
                    return $e;
            }
            
            //valida el numero de arpillas
            if(!is_null($arpillas))
            {
                $e = self::validarNumero($arpillas, 1.8e200, "arpillas");
                if(is_string($e))
                    return $e;
            }
            
            //valida el peso por arpilla
            if(!is_null($peso_por_arpilla))
            {
                $e = self::validarNumero($peso_por_arpilla, 1.8e200, "peso por arpilla");
                if(is_string($e))
                    return $e;
            }
            
            //valida el productor
            if(!is_null($productor))
            {
                $e = self::validarString($productor, 64, "productor");
                if(is_string($e))
                    return $e;
            }
            
            //valida la merma por arpilla
            if(!is_null($merma_por_arpilla))
            {
                $e = self::validarNumero($merma_por_arpilla, 1.8e200, "merma por arpilla");
                if(is_string($e))
                    return $e;
            }
            
            //valida el total de origen
            if(!is_null($total_origen))
            {
                $e = self::validarNumero($total_origen, 1.8e200, "Total de origen");
                if(is_string($e))
                    return $e;
            }
            
            //No se encontro error
            return true;
        }
      
      
      
      
      
      
      
  
	/**
 	 *
 	 *Realiza una nueva venta por arpillas. Este m?todo tiene que llamarse en conjunto con el metodo api/ventas/nueva.
 	 *
 	 * @param peso_por_arpilla float Peso promedio por arpilla
 	 * @param merma_por_arpilla float La merma que resulto por arpilla
 	 * @param arpillas float Nmero de arpillas enviadas
 	 * @param peso_origen float Peso del embarque en el origen
 	 * @param fecha_origen string Fecha en la que se envo el embarque
 	 * @param peso_destino float Peso del embarque en el destino
 	 * @param id_venta int Id de la venta relacionada con esta entrega
 	 * @param productor string Nombre del productor
 	 * @param numero_de_viaje string Numero del viaje
 	 * @param folio string Folio de la entrega
 	 * @param total_origen float Valor del embarque segun el origen
 	 * @return id_venta_arpilla int Id autogenerado por la insercion
 	 **/
	public static function ArpillasVentaNueva
	(
		$arpillas, 
		$fecha_origen, 
		$id_venta, 
		$merma_por_arpilla, 
		$peso_destino, 
		$peso_origen, 
		$peso_por_arpilla, 
		$folio = null, 
		$numero_de_viaje = null, 
		$productor = null, 
		$total_origen = null
	)
	{  
            Logger::log("Creando nueva venta por arpillas");
            
            //Se validan los parametros recibidos
            $validar = self::validarParametrosVentaArpilla($id_venta,$peso_origen,
                    $folio,$numero_de_viaje,$peso_destino,$arpillas,$peso_por_arpilla,$productor,$merma_por_arpilla,$total_origen);
            if(is_string($validar))
            {
                Logger::error($validar);
                throw new Exception($validar);
            }
            
            //Se inicializa el objeto y se guarda
            $venta_arpilla = new VentaArpilla( array( 
                "id_venta"          => $id_venta,
                "peso_destino"      => $peso_destino,
                "fecha_origen"      => $fecha_origen,
                "folio"             => $folio,
                "numero_de_viaje"   => $numero_de_viaje,
                "peso_origen"       => $peso_origen,
                "arpillas"          => $arpillas,
                "peso_por_arpilla"  => $peso_por_arpilla,
                "productor"         => $productor,
                "merma_por_arpilla" => $merma_por_arpilla,
                "total_origen"      => $total_origen
                ) );
            DAO::transBegin();
            try
            {
                VentaArpillaDAO::save($venta_arpilla);
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se ha podido registrar la venta por arpilla: ".$e);
                throw new Exception("No se ha podido registrar la venta por arpilla");
            }
            DAO::transEnd();
            Logger::log("Venta por arpilla registrada exitosamente");
            return array( "id_venta_arpilla" => $venta_arpilla->getIdVentaArpilla() );
	}
  
	/**
 	 *
 	 *Lista el detalle de una venta, se puede ordenar de acuerdo a sus atributos.
 	 *
 	 * @param id_venta int Id de la venta a revisar
 	 * @param ordenar json Valor que determina el orden de la lista
 	 * @return detalle_venta json Objeto que contiene el detalle de la venta.
 	 **/
	public static function Detalle
	(
		$id_venta
	)
	{  
            Logger::log("Listando el detalle de la venta ".$id_venta);
            
            //Se regresara un arreglo que contendra en la primera posicion la venta en sí, en la segunda
            //contendra otro arreglo de arreglos, estos arreglos en la primera posicion tendran un arreglo con la informacion del producto,
            //en la segunda un arreglo con la informacion de la unidad, y en las siguientes posiciones la demas informacion
            //del detalle (cantidad, precio, descuento, etc.)
            //
            //En la tercera posicion contendra todos los abonos realizados para esta venta
            
            $detalle = array();
            
            array_push($detalle, VentaDAO::getByPK($id_venta));
            
            $ventas_productos = array();
            
            $venta_productos = VentaProductoDAO::search( new VentaProducto( array("id_venta" => $id_venta) ) );
            foreach($venta_productos as $v_p)
            {
                $venta_producto = array();
                array_push($venta_producto,ProductoDAO::getByPK($v_p->getIdProducto()));
                array_push($venta_producto,UnidadDAO::getByPK($v_p->getIdUnidad()));
                array_push($venta_producto,$v_p->getCantidad());
                array_push($venta_producto,$v_p->getPrecio());
                array_push($venta_producto,$v_p->getDescuento());
                array_push($venta_producto,$v_p->getImpuesto());
                array_push($venta_producto,$v_p->getRetencion());
                array_push($ventas_productos,$venta_producto);
            }
            
            array_push($detalle, $ventas_productos);
            
            array_push($detalle, AbonoVentaDAO::search(new AbonoVenta( array( "id_venta" => $id_venta ) )));
            
            
            Logger::log("Detalle obtenido exitosamente");
            return $detalle;
	}
  



	/**
 	 *
 	 *Lista las ventas, puede filtrarse por empresa, sucursal, por el total, si estan liquidadas o no, por canceladas, y puede ordenarse por sus atributos.
 	 *
 	 * @param canceladas bool Si no se obtiene este valor, se listaran las ventas tanto canceladas como las que no, si es true, se listaran solo las ventas que estan canceladas, si es false, se listaran las ventas que no estan canceladas solamente.
 	 * @param ordenar json Valor que determinara la manera en que la lista sera ordenada.
 	 * @param id_empresa int Id de la empresa de la cual se listaran sus ventas
 	 * @param id_sucursal int Id de la sucursal de la cuals e listaran sus ventas
 	 * @param total_superior_a float Si ese valor es obtenido, se listaran las ventas cuyo total sea superior al valor obtenido.
 	 * @param total_igual_a float Si este valor es obtenido, se listaran las ventas cuyo total sea igual al valor obtenido
 	 * @param total_inferior_a float Si este valor es obtenido, se listaran las empresas cuyo total sea inferior al valor obtenido.
 	 * @param liquidados bool Si este valor no es obtenido, se listaran tanto las ventas liquidadas, como las no liquidadas, si es true, se listaran solo las ventas liquidadas, si es false, se listaran las ventas no liquidadas solamente.
 	 * @return ventas json Objeto que contendra la lista de ventas
 	 **/
	/*public static function Lista
	(
		$canceladas = null, 
		$id_sucursal = null, 
		$liquidados = null, 
		$ordenar = null, 
		$total_igual_a = null, 
		$total_inferior_a = null, 
		$total_superior_a = null
	)
	{  
            Logger::log("Obteniendo la lista de ventas");
            
            
            
            //Se verifica si se recibieron parametros para saber que metodo utilizar
            $parametros = false;
            if
            (
                    !is_null($canceladas)       ||
                    !is_null($id_sucursal)      ||
                    !is_null($total_superior_a) ||
                    !is_null($total_igual_a)    ||
                    !is_null($total_inferior_a) 
            )
                $parametros = true;
            $ventas = array();

            if($parametros)
            {
                //Se inicializan dos objetos que contendran los parametros recibidos, de tal forma que se obtenga el rango entre ambos
                $venta_criterio_1 = new Venta();
                $venta_criterio_2 = new Venta();
                $venta_criterio_1->setCancelada($canceladas);
                $venta_criterio_1->setIdSucursal($id_sucursal);
                if(!is_null($total_superior_a))
                {
                    $venta_criterio_1->setTotal($total_superior_a);
                    if(!is_null($total_inferior_a))
                        $venta_criterio_2->setTotal ($total_inferior_a);
                    else
                        $venta_criterio_2->setTotal (1.8e200);
                }
                else if(!is_null($total_inferior_a))
                {
                    $venta_criterio_1->setTotal($total_inferior_a);
                    $venta_criterio_2->setTotal(0);
                }
                else if(!is_null($total_igual_a))
                    $venta_criterio_1->setTotal ($total_igual_a);
                
                $ventas = VentaDAO::byRange($venta_criterio_1, $venta_criterio_2);
            }
            else
            {
                $ventas = VentaDAO::getAll();
            }
            
            //Si se recibe el parametro liquidadas, se filtra el arreglo obtenido para mostrar las que cumplan con el valor recibido
            if(!is_null($liquidados))
            {
                $temp = array();
                if($liquidados)
                {
                    foreach($ventas as $venta)
                    {
                        if($venta->getSaldo() >= $venta->getTotal())
                            array_push($temp,$venta);
                    }
                }
                else
                {
                    foreach($ventas as $venta)
                    {
                        if($venta->getSaldo() < $venta->getTotal())
                            array_push($temp,$venta);
                    }
                }
                $ventas = $temp;
            }

            Logger::log("Lista obtenida exitosamente con ".count($ventas)." ventas");

			//ventas es un arreglo de objetos Venta, hay que darle el formato que dicta el api
			$output = array( "resultados" => array(), "numero_de_resultados" => 0 );
			
			for ($v=0; $v < sizeof($ventas); $v++) { 
				
				$pre_out = $ventas[$v]->asArray();
				

				
				$pre_out["sucursal"] = array(
										"id_sucursal" => $pre_out["id_caja"]
									   );

				$pre_out["cliente"] = array(
										"id_cliente" => $pre_out["id_comprador_venta"],
										"nombre"	=> "justo dominguez"
									   );

				unset($pre_out["id_comprador_venta"]);
			
				array_push( $output["resultados"], $pre_out );
				$output["numero_de_resultados"]++;
			}
			
            return $output;
	}*/
        
        /**
 	 *
 	 *Lista las ventas, puede filtrarse por empresa, sucursal, por el total, si estan liquidadas o no, por canceladas, y puede ordenarse por sus atributos.
 	 *
 	 * @param canceladas bool Si no se obtiene este valor, se listaran las ventas tanto canceladas como las que no, si es true, se listaran solo las ventas que estan canceladas, si es false, se listaran las ventas que no estan canceladas solamente.
 	 * @param id_cliente int Ver las ventas de este cliente
 	 * @param id_sucursal int Id de la sucursal de la cuals e listaran sus ventas
 	 * @param liquidados bool Si este valor no es obtenido, se listaran tanto las ventas liquidadas, como las no liquidadas, si es true, se listaran solo las ventas liquidadas, si es false, se listaran las ventas no liquidadas solamente.
 	 * @param ordenar string Nombre de la columan por el cual se ordenara la lista
 	 * @return numero_de_resultados int Numero de resultados
 	 * @return resultados json Resultados
 	 **/
        static function Lista
	(
		$canceladas = null, 
		$id_cliente = null, 
		$id_sucursal = null, 
		$liquidados = null, 
		$ordenar = null
	){
            
		//there must be an upper limit in how many
		//object may the array return
            
            $config = array();                        
            
            if( !is_null( $canceladas ) && is_bool( $canceladas ) && $canceladas == 1 ){                              
                $config["cancelada"] = 1;                
            }
            
            if( !is_null($id_cliente) && $cliente = UsuarioDAO::getByPK($id_cliente) ){
                $config["id_comprador_venta"] = $cliente->getIdUsuario();
            }
            
            if( $sucursal = SucursalDAO::getByPK($id_sucursal) ){                
                $config["id_sucursal"] = $sucursal->getIdSucursal();
            }
            
            if( !is_null( $liquidados ) && is_bool( $liquidados ) && $liquidados == 0 ){                              
                $config["saldo"] = 0;                
            }
            
            $ordenar = is_null($ordenar)? "id_venta" : $ordenar;                                                                                                
            
            return array( "ventas" => json_encode( VentaDAO::search(new Venta( $config ), $ordenar, 'ASC') ));
            
        }



	/**
	 *
	 * $desde unixtime
	 * $hasta unixtime
	 *
	 * */
	public static function ListaDesdeHasta($desde, $hasta){


		$configA = array(
			"es_cotizacion" => 0,
			"fecha"		=> $desde
		);


		$configB = array(
			"fecha"		=> $hasta
		);


		return array( "ventas" => json_encode( 
				VentaDAO::byRange(
					new Venta( $configA ), 
					new Venta( $configB )
				)
			));
	
	}
	



	/**
 	 *
 	 *Metodo que cancela una venta
 	 *
 	 * @param id_venta string Id de la venta a cancelar
 	 **/
	public static function Cancelar
	(
		$id_venta, 
		$billetes = null, 
		$id_caja = null
	)
    {  
             Logger::log("======= Cancenlando venta ".$id_venta . " ===========");
            
            //valida que la venta exista y que este activa
            $venta = VentaDAO::getByPK($id_venta);

            if($venta==null){
                Logger::error("La venta con id: ".$id_venta." no existe");
                throw new Exception("La venta con id: ".$id_venta." no existe");

            }


            if($venta->getCancelada()){
                Logger::warn("La venta ya ha sido cancelada");
                return;
            }
            

            //Deja la venta como cancelada y la guarda. 
            $venta->setCancelada(1);


            //Obtiene al usuario al que se le vendio
            $usuario=UsuarioDAO::getByPK($venta->getIdCompradorVenta());
            if($usuario==null){
                Logger::error("FATAL!!! Esta venta apunta a un usuario que no existe");
                throw new Exception("FATAL!!! Esta venta apunta a un usuario que no existe");

            }
            












            DAO::transBegin();

            // regresar de almacenes
            // obtener los productos que se vendieron
            // insertalos como neuvo ingreso

            $detalle = VentaProductoDAO::search( new VentaProducto( array( "id_venta" => $id_venta ) )  );


            for ( $detalleIterator=0; $detalleIterator < sizeof($detalle); $detalleIterator++ ) { 
                
                //por cada producto
                //  --- procesos ---
                //  -insertar en productoempresa
                //  -insertar en loteproducto
                //  -insertar en entradalote
                //  -si el tipo de precio de venta es costo, actualizar
                //  -insertar compra producto
                $p = $detalle[$detalleIterator];
                
                try{
                    /*
                    ProductoEmpresaDAO::save( new ProductoEmpresa( array(
                            "id_empresa" => $id_empresa,
                            "id_producto" => $p->getIdProducto()
                        ) ) );
                        
                    
                    if(is_null($p->lote)){
                        throw new InvalidDataException("No selecciono a que lote ira el producto " . $p->id_producto);
                    }
                    

                    if(strlen($p->lote) == 0){
                        throw new InvalidDataException("No selecciono a que lote ira el producto " . $p->id_producto);
                    }
                    */

                    //busquemos el id del lote
                    $l = LoteDAO::getByPk(1);
                    
                    
                    
                    
                    
                    //busquemos la unidad que nos mandaron
                    
                    $uResults = UnidadMedidaDAO::search(new UnidadMedida(array("id_unidad_medida" => $p->getIdUnidad(), "activa" => 1)));
                    
                    if(sizeof($uResults) != 1){
                        throw new InvalidDataException("La unidad de medida `". $p->id_unidad  ."` no existe, o no esta activa.");
                        
                    }
                    
                    //busequemos si este producto ya existe en este lote
                    $lp = LoteProductoDAO::getByPK( $l->getIdLote(), $p->getIdProducto() );
                    
                    if(is_null($lp)){
                        //no existe, insertar
                        $loteProducto = new LoteProducto(array(
                                "id_lote"       => $l->getIdLote(),
                                "id_producto"   => $p->getIdProducto(),
                                "cantidad"      => $p->getCantidad(), 
                                "id_unidad"     => $p->getIdUnidad()
                            ) );
                            
                        LoteProductoDAO::save ( $loteProducto);
                                        
                    }else{
                        //ya existe, sumar
                        
                        
                        
                        //revisemos si es de la misma unidad
                        if($lp->getIdUnidad() == $p->getIdUnidad()){
                            //es igual, solo hay que sumar
                            $lp->setCantidad( $lp->getCantidad() +  $p->getCantidad());    

                        }else{
                            //no es igual, hay que convertir

                            try{
                                $r = UnidadMedidaDAO::convertir($p->getIdUnidad(), $lp->getIdUnidad(), $p->getCantidad() );    

                            }catch(BusinessLogicException $ide){
                                //no se pudo convertir porque son de 
                                //diferentes categorias
                                throw $ide; //mostrar una excpetion mas fresona
                            }
                            
                            $lp->setCantidad( $lp->getCantidad() +  $r  );    
                        }


                        //$lp->setCantidad( $lp->getCantidad() + $p->cantidad );


                        LoteProductoDAO::save( $lp );
                        
                    }
                    
                    $s = SesionController::getCurrentUser();

                    
                    $loteEntrada = new LoteEntrada(array(
                            "id_lote"       =>$l->getIdLote(), 
                            "id_usuario"    =>$s->getIdUsuario(),
                            "fecha_registro"=>time(),
                            "motivo"        =>"Venta (".$id_venta.") Cancelada"
                        ) );
                        
                        
                    LoteEntradaDAO::save ( $loteEntrada );                      

                    LoteEntradaProductoDAO::save (new LoteEntradaProducto(array(
                            "id_lote_entrada"   => $loteEntrada->getIdLoteEntrada(),
                            "id_producto"       => $p->getIdProducto(),
                            "id_unidad"         => $p->getIdUnidad(),
                            "cantidad"          => $p->getCantidad()
                        ) ) );
                        
                    /*
                    $compraProducto = new CompraProducto(array(
                            "id_compra"         => $compra->getIdCompra(),
                            "id_producto"       => $p->id_producto,
                            "cantidad"          => $p->cantidad,
                            "precio"            => $p->precio,
                            "descuento"         => 0,
                            "impuesto"          => 0,
                            "id_unidad"         => $p->id_unidad,
                            "retencion"         => 0
                        ) );
                    
                    CompraProductoDAO::save ( $compraProducto);
                    */

                }catch(InvalidDataException $e){
                    Logger::error($e);
                    DAO::transRollback();
                    throw $e;
                    
                }catch(exception $e){
                    Logger::error($e);
                    DAO::transRollback();
                    throw new InvalidDatabaseOperationException($e);
                    
                }
                
                
                
            }   







            try
            {
                VentaDAO::save($venta);
                
                //Si la venta fue a credito, se cancelan todos los abonos hechos al mismo y el dinero se queda a cuenta del usuario.
                if($venta->getTipoDeVenta()=="credito")
                {
                    $abono_venta=new AbonoVenta();
                    $abono_venta->setIdVenta($id_venta);
                    $abonos=AbonoVentaDAO::search($abono_venta);
                    foreach($abonos as $abono)
                    {
                        if(!$abono->getCancelado())
                            CargosYAbonosController::EliminarAbono($abono->getIdAbonoVenta(),"Venta cancelada",0,1,0,null,null);
                    }
                    $usuario->setSaldoDelEjercicio($usuario->getSaldoDelEjercicio()+$venta->getTotal());
                    UsuarioDAO::save($usuario);
                }
                
                //Si la venta fue de contado y se tiene la caja a la que regresera el dinero, se modifica dicha caja.
                else if($venta->getTipoDeVenta()=="contado" && !is_null($id_caja))
                {
                    CajasController::modificarCaja($id_caja, 1, $billetes, $venta->getTotal());
                }
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo cancelar la venta: ".$e);
                throw new Exception("No se pudo cancelar la venta");
            }
            DAO::transEnd();
            Logger::log("Venta cancelada exitosamente");
  
    }
  
	/**
 	 *
 	 *Muestra el detalle de una venta por arpilla. Este metodo no muestra los productos de una venta, sino los detalles del embarque de la misma. Para ver los productos de una venta refierase a api/ventas/detalle
 	 *
 	 * @param id_venta int Id de la venta de la cual se listaran las ventas por arpilla
 	 * @return detalle_venta_arpilla json Objeto que contendra los detalles de las ventas por arpilla
 	 **/
	public static function ArpillaVentaDetalle
	(
		$id_venta
	)
	{  
            Logger::log("Mostrando detalle de la venta por arpillas");
            $detalle_venta_arpilla = VentaArpillaDAO::search( new VentaArpilla( array( "id_venta" => $id_venta ) ) );
            return $detalle_venta_arpilla;
	}
  










    private static function Cotizar
    (
        $descuento, 
        $id_comprador_venta, 
        $impuesto, 
        $subtotal, 
        $tipo_venta, 
        $total, 
        $datos_cheque = null, 
        $detalle_orden = null, 
        $detalle_paquete = null, 
        $detalle_venta = null,
        $id_sucursal = null, 
        $saldo = "0", 
        $tipo_de_pago = null
    ){
            Logger::log("Cotizando ....");
        
            //Se obtiene el id del usuario actualmente logueado
            $aS = SesionController::Actual();
            $id_usuario = $aS["id_usuario"];

            //Se busca al usuario comprador
            $usuario = UsuarioDAO::getByPK($id_comprador_venta);

            if(!is_null($id_sucursal))
            {
                $sucursal = SucursalDAO::getByPK($id_sucursal); 
                
                if(is_null( $sucursal)){
                    Logger::error("La sucursal ".$id_sucursal." no existe");
                    throw new InvalidDataException("La sucursal no existe",901);
                }
                
                if(!$sucursal->getActiva())
                {
                    Logger::error("La sucursal ".$id_sucursal." esta desactivada");
                    throw new InvalidDataException("La sucursal esta desactivada",901);
                }
                
            }

            
            //Se inicializa la venta con los parametros obtenidos
            $venta=new Venta();
            $venta->setRetencion(0);
            $venta->setEsCotizacion(true);
            $venta->setIdCompradorVenta($id_comprador_venta);
            $venta->setSubtotal($subtotal);
            $venta->setImpuesto($impuesto);
            $venta->setTotal($total);
            $venta->setDescuento($descuento);
            $venta->setTipoDeVenta($tipo_venta);
            $venta->setIdCaja(null);
            $venta->setIdSucursal($id_sucursal);
            $venta->setIdUsuario($id_usuario);
            $venta->setIdVentaCaja(NULL);
            $venta->setCancelada(0);
            $venta->setTipoDePago(null);
            $venta->setSaldo(0);
            $venta->setFecha(time());
            

            DAO::transBegin();

            try
            {
                VentaDAO::save($venta);

            }catch(Exception $e){
                
                DAO::transRollback();
                Logger::error("No se pudo realizar la venta: ".$e);
                throw new Exception("No se pudo realizar la venta",901);
            }
                
            //Si el detalle de las ordenes compradas, el detalle de los paquetes y el detalle de los productos
            //son nulos, manda error.
            if(is_null($detalle_orden)&&is_null($detalle_paquete)&&is_null($detalle_venta))
            {
                throw new InvalidDataException ("No se recibieron ni paquetes ni productos ni servicios para esta venta",901);
            }
                
            //Por cada detalle, se valida la informacion recibida, se guarda en un registro
            //que contiene el id de la venta generada y se guarda el detalle en su respectiva tabla.

                
            
            if(!is_null($detalle_venta))
            {
                
                $detalle_producto = object_to_array($detalle_venta);
                
                if(!is_array($detalle_producto))
                {
                    throw new Exception("El detalle del producto es invalido",901);
                }

                

                

                foreach($detalle_producto as $d_p)
                {

                    $d_producto = new VentaProducto();
                    $d_producto->setIdVenta($venta->getIdVenta());
                    
                    if
                    (
                            !array_key_exists("id_producto", $d_p)   ||
                            !array_key_exists("cantidad", $d_p)     ||
                            !array_key_exists("precio", $d_p)       ||
                            !array_key_exists("descuento", $d_p)    ||
                            !array_key_exists("impuesto", $d_p)     ||
                            !array_key_exists("retencion", $d_p)    ||
                            !array_key_exists("id_unidad", $d_p)
                    )
                    {
                        throw new Exception("El detalle del producto es invalido",901);
                    }
                    
                    Logger::log("Insertando venta_producto:" );
                    
                    

                    $d_producto->setCantidad    ( $d_p["cantidad"]  );
                    $d_producto->setDescuento   ( $d_p["descuento"] );
                    $d_producto->setIdProducto  ( $d_p["id_producto"]);
                    $d_producto->setIdUnidad    ( $d_p["id_unidad"] );
                    $d_producto->setImpuesto    ( $d_p["impuesto"]  );
                    $d_producto->setPrecio      ( $d_p["precio"]    );
                    $d_producto->setRetencion   ( $d_p["retencion"] );
                    
                    Logger::log( $d_producto );
                    
                    try
                    {
                        VentaProductoDAO::save($d_producto);

                    }catch(Exception $e){
                        
                        DAO::transRollback();
                        Logger::error("No se pudo realizar la venta: ".$e);
                        throw new Exception("No se pudo realizar la venta",901);
                    }
                }
            }/* Fin de if para detalle_producto */
                
                


            DAO::transEnd();

            Logger::log("====== Cotizacion realizada exitosamente ======== ");
            
            return array ("id_venta" => $venta->getIdVenta());


       
    }

	/**
 	 *
 	 *Genera una venta fuera de caja, puede usarse para que el administrador venda directamente a clientes especiales. EL usuario y la sucursal seran tomados de la sesion. La fecha se tomara del servidor. La empresa sera tomada del alamacen del que fueron tomados los productos
 	 *
 	 * @param total float Total de la venta
 	 * @param retencion float Monto aportado por retenciones
 	 * @param descuento float Monto descontado por descuentos
 	 * @param tipo_venta string Si esta es una venta a  credito o de contado
 	 * @param impuesto float Monto aportado por impuestos
 	 * @param subtotal float Subtotal de la venta antes de ser afectada por impuestos, descuentos y retenciones
 	 * @param id_comprador_venta int Id del usuario al que se le vende, si es a una sucursal, el id se pasa negativo
 	 * @param detalle_venta json Objeto que contendra los ids y las cantidades de los productos que se vendieron con el id almacen de donde fueron seleccionados  para determinar a que empresa pertenecen
 	 * @param datos_cheque json Si el tipo de pago fue en cheque, se pasan el nombre del banco, el monto y los ultimos 4 numeros de cada cheque que se uso para pagar la venta
 	 * @param saldo float Saldo que ha sido aportado a la venta
 	 * @param tipo_de_pago string Si la venta es pagada con tarjeta, con efectivo o con cheque
 	 * @return id_venta int Id autogenerado de la nueva venta
 	 **/
	public static function Nueva
	(
        $descuento, 
        $id_comprador_venta, 
        $impuesto, 
        $subtotal, 
        $tipo_venta, 
        $total, 
        $datos_cheque = null, 
        $detalle_orden = null, 
        $detalle_paquete = null, 
        $detalle_venta = null, 
        $es_cotizacion =  false , 
        $id_sucursal = null, 
        $saldo = "0", 
        $tipo_de_pago = null
	)
	{  

		
            if($es_cotizacion){
               return self::Cotizar(
                        $descuento, 
                        $id_comprador_venta, 
                        $impuesto, 
                        $subtotal, 
                        $tipo_venta, 
                        $total, 
                        $datos_cheque, 
                        $detalle_orden, 
                        $detalle_paquete, 
                        $detalle_venta, 
                        $id_sucursal, 
                        $saldo, 
                        $tipo_de_pago
                    );
            }



            Logger::log("Creando nueva venta fuera de caja.....");
            
            //validar que vengan datos en detalles
            if( is_null($detalle_orden) && is_null($detalle_venta) && is_null($detalle_paquete) ){
                Logger::warn("No se enviaron detalles en la venta");
                throw new InvalidDataException();
            }

            if(!is_array($detalle_orden)){
                $detalle_orden = object_to_array($detalle_orden);
            }

            if(!is_array($detalle_venta)){
                $detalle_venta = object_to_array($detalle_venta);
            }

            if(!is_array($detalle_paquete)){
                $detalle_paquete = object_to_array($detalle_paquete);
            }



            if( empty($detalle_orden) && empty($detalle_venta) && empty($detalle_paquete) ){
                Logger::warn("No se enviaron detalles en la venta");
                throw new InvalidDataException();
            }

            //Se utiliza el metodo de Sucursal controller, dejando que tome la caja y la sucursal como nulos
            try{
            	$venta = SucursalesController::VenderCaja(
							$descuento,
							$id_comprador_venta,
							$impuesto,
							0,
                    		$subtotal,
							$tipo_venta,
							$total,
							null,
							null,
							$datos_cheque,
							$detalle_orden,
							$detalle_paquete,
                    		$detalle_venta,
							null,
							$id_sucursal,
							null,
							$saldo,
							$tipo_de_pago
						);

            }catch(BusinessLogicException $ble){
				Logger::error("**************************");
				throw $ble;

			}catch(Exception $e){
	
                Logger::error("No se pudo crear la nueva venta: ".$e);

                if($e->getCode()==901)
                    throw new Exception("No se pudo crear la nueva venta: ".$e->getMessage(),901);

                throw new Exception("No se pudo crear la nueva venta",901);
            }
            
            Logger::log("======== Venta " . $venta["id_venta"] . " exitosa =========" );

            return array( "id_venta" => (int)$venta["id_venta"] );
	}
  }
