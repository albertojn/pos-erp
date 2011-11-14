<?php
require_once("interfaces/Paquetes.interface.php");
/**
  *
  *
  *
  **/
	
  class PaquetesController implements IPaquetes{
  
        //Metodo para pruebas que simula la obtencion del id de la sucursal actual
        private static function getSucursal()
        {
            return 1;
        }
        
        //metodo para pruebas que simula la obtencion del id de la caja actual
        private static function getCaja()
        {
            return 1;
        }
      
        
        /*
         *Se valida que un string tenga longitud en un rango de un maximo inclusivo y un minimo exclusvio.
         *Regresa true cuando es valido, y un string cuando no lo es.
         */
          private static function validarString($string, $max_length, $nombre_variable,$min_length=0)
	{
		if(strlen($string)<=$min_length||strlen($string)>$max_length)
		{
		    return "La longitud de la variable ".$nombre_variable." proporcionada (".$string.") no esta en el rango de ".$min_length." - ".$max_length;
		}
		return true;
        }


        /*
         * Se valida que un numero este en un rango de un maximo y un minimo inclusivos
         * Regresa true cuando es valido, y un string cuando no lo es
         */
	private static function validarNumero($num, $max_length, $nombre_variable, $min_length=0)
	{
	    if($num<$min_length||$num>$max_length)
	    {
	        return "La variable ".$nombre_variable." proporcionada (".$num.") no esta en el rango de ".$min_length." - ".$max_length;
	    }
	    return true;
	}
        
        /*
         * Valida los parametros de la tabla paquete. Regresa un string con el error si se encuentra
         * alguno. De lo contrario regresa verdadero
         */
        private static function validarParametrosPaquete
        (
                $id_paquete = null,
                $nombre = null,
                $descripcion = null,
                $margen_utilidad = null,
                $descuento = null,
                $foto_paquete = null,
                $costo_estandar = null,
                $precio = null,
                $activo = null
        )
        {
            //valida que el paquete exista y este activo
            if(!is_null($id_paquete))
            {
                $paquete = PaqueteDAO::getByPK($id_paquete);
                if(is_null($paquete))
                    return "El paquete ".$id_paquete." no existe";
                
                if(!$paquete->getActivo())
                    return "El paquete ".$id_paquete." no esta activo";
            }
            
            //valida que el nombre este en rango y que no se repita
            if(!is_null($nombre))
            {
                $e = self::validarString($nombre, 100, "nombre");
                if(is_string($e))
                    return $e;
                
                $paquetes = PaqueteDAO::search( new Paquete( array( "nombre" => trim($nombre) ) ) );
                foreach($paquetes as $paquete)
                {
                    if($paquete->getActivo())
                        return "El nombre (".$nombre.") ya esta siendo usado por el paquete ".$paquete->getIdPaquete();
                }
            }
            
            //valida que la descripcion este en rango
            if(!is_null($descripcion))
            {
                $e = self::validarString($descripcion, 255, "descripcion");
                if(is_string($e))
                    return $e;
            }
            
            //valida que el margen de utilidad este en rango
            if(!is_null($margen_utilidad))
            {
                $e = self::validarNumero($margen_utilidad, 1.8e200, "margen de utilidad");
                if(is_string($e))
                    return $e;
            }
            
            //valida que el descuento este en rango
            if(!is_null($descuento))
            {
                $e = self::validarNumero($descuento, 100, "descuento");
                if(is_string($e))
                    return $e;
            }
            
            //valida que la foto del paquete este en rango
            if(!is_null($foto_paquete))
            {
                $e = self::validarString($foto_paquete, 255, "foto del paquete");
                if(is_string($e))
                    return $e;
            }
            
            //valida que el costo estandar este en rango
            if(!is_null($costo_estandar))
            {
                $e = self::validarNumero($costo_estandar, 1.8e200, "costo estandar");
                if(is_string($e))
                    return $e;
            }
            
            //valida que el precio este en rango
            if(!is_null($precio))
            {
                $e = self::validarNumero($precio,1.8e200,"precio");
                if(is_string($e))
                    return $e;
            }
            
            //valida el boleano activo
            if(!is_null($activo))
            {
                $e = self::validarNumero($activo, 1, "activo");
                if(is_string($e))
                    return $e;
            }
            
            //No se encontro error
            return true;
        }
        
        /*
         * Valida los parametros de la tabla paquete_empresa. Regresa un string con el error
         * si es que se encontro uno, de lo contrario regresa verdadero
         */
        private static function validarParametrosPaqueteEmpresa
        (
                $id_empresa = null,
                $precio_utilidad = null,
                $es_margen_utilidad = null
        )
        {
            //valida que la empresa exista y qe este activa
            if(!is_null($id_empresa))
            {
                $empresa = EmpresaDAO::getByPK($id_empresa);
                if(is_null($empresa))
                    return "La empresa ".$id_empresa." no existe";
                
                if(!$empresa->getActivo())
                    return "La empresa ".$id_empresa." no esta activa";
            }
            
            //valida que el precio_utilidad este en rango
            if(!is_null($precio_utilidad))
            {
                $e = self::validarNumero($precio_utilidad, 1.8e200, "precio_utilidad");
                if(is_string($e))
                    return $e;
            }
            
            //valida el boleano es_margen_utilidad
            if(!is_null($es_margen_utilidad))
            {
                $e = self::validarNumero($es_margen_utilidad, 1, "es margen de utilidad");
                if(is_string($e))
                    return $e;
            }
            
            //no se encontro error
            return true;
        }
        
        /*
         * Valida los parametros de la tabla paquete_sucursal. Regresa un string con el error
         * si es que se encontro uno, de lo contrario regresa verdadero
         */
        private static function validarParametrosPaqueteSucursal
        (
                $id_sucursal = null,
                $precio_utilidad = null,
                $es_margen_utilidad = null
        )
        {
            //valida que la sucursal exista y que este activa
            if(!is_null($id_sucursal))
            {
                $sucursal = SucursalDAO::getByPK($id_sucursal);
                if(is_null($sucursal))
                    return "La sucursal ".$id_sucursal." no existe";
                
                if(!$sucursal->getActiva())
                    return "La sucursal ".$id_sucursal." no esta activa";
            }
            
            //valida que el precio_utilidad este en rango
            if(!is_null($precio_utilidad))
            {
                $e = self::validarNumero($precio_utilidad, 1.8e200, "precio_utilidad");
                if(is_string($e))
                    return $e;
            }
            
            //valida el boleano es_margen_utilidad
            if(!is_null($es_margen_utilidad))
            {
                $e = self::validarNumero($es_margen_utilidad, 1, "es margen de utilidad");
                if(is_string($e))
                    return $e;
            }
            
            //no se encontro error
            return true;
        }
        
        /*
         * Valida los parametros de la tabla producto_paquete. Regresa un string con el error
         * en caso de encontrarse alguno, de lo contrario regresa verdadero
         */
        private static function validarParametrosProductoPaquete
        (
                $id_producto = null,
                $id_unidad = null,
                $cantidad = null
        )
        {
            //valida que el producto exista y este activo
            if(!is_null($id_producto))
            {
                $producto = ProductoDAO::getByPK($id_producto);
                if(is_null($producto))
                    return "El producto ".$id_producto." no existe";
                
                if(!$producto->getActivo())
                    return "El producto ".$id_roducto." no esta activo";
            }
            
            //valida que la unidad exista y este activa
            if(!is_null($id_unidad))
            {
                $unidad = UnidadDAO::getByPK($id_unidad);
                if(is_null($unidad))
                    return "La unidad ".$id_unidad." no existe";
                
                if(!$unidad->getActiva())
                    return "La unidad ".$id_unidad." no existe";
            }
            
            //valida que la cantida este en rango y vaya de acuerdo a la unidad
            if(!is_null($cantidad))
            {
                $e = self::validarNumero($cantidad, 1.8e200, "cantidad");
                if(is_string($e))
                    return $e;
                
                if( ($unidad->getEsEntero() &&  is_float($cantidad)))
                    return "LA unidad que se maneja no acepta flotantes y se obtuvo una cantidad flotante (".$cantidad.")";
            }
            
            //no se encontro error
            return true;
        }
        
        
        
        
        
      
  
	/**
 	 *
 	 *Agrupa productos y/o servicios en un paquete
 	 *
 	 * @param nombre string Nombre del paquete
 	 * @param empresas json Ids de empresas en las que se ofrecera este paquete
 	 * @param sucursales json Ids de sucursales en las que se ofrecera este paquete
 	 * @param productos json Objeto que contendra los ids de los productos que se incluiran en el paquete con sus cantidades respectivas.
 	 * @param sericios json Objeto que contendra los ids de los servicios que se incluiran en el paquete con sus cantidades respectivas.
 	 * @param descripcion string Descripcion larga del paquete
 	 * @param margen_utilidad float Margen de utilidad que se obtendra al vender este paquete
 	 * @param descuento float Descuento que aplicara a este paquete
 	 * @param foto_paquete string Url de la foto del paquete
 	 * @return id_paquete int Id autogenerado por la insercion
 	 **/
	public static function Nuevo
	(
		$nombre, 
		$empresas, 
		$sucursales, 
		$productos = null, 
		$servicios = null, 
		$descripcion = null, 
		$margen_utilidad = null, 
		$descuento = null, 
		$foto_paquete = null,
                $costo_estandar = null,
                $precio = null
	)
	{  
            Logger::log("Creando nuevo paquete");
            
            //valida los parametros recibidos
            $validar = self::validarParametrosPaquete(null,$nombre,$descripcion,$margen_utilidad,$descuento,$foto_paquete,$costo_estandar,$precio);
            if(is_string($validar))
            {
                Logger::error($validar);
                throw new Exception($validar);
            }
            
            //Se inicializa el objeto
            $paquete = new Paquete( array( 
                                            "nombre"            => $nombre,
                                            "descripcion"       => $descripcion,
                                            "margen_utilidad"   => $margen_utilidad,
                                            "descuento"         => $descuento,
                                            "foto_paquete"      => $foto_paquete,
                                            "costo_estandar"    => $costo_estandar,
                                            "precio"            => $precio,
                                            "activo"            => 1
                                            )
                                    );
            
            //Se almacena el nuevo paquete y se validan y guardan los registros correspondientes a las tablas paquete_empresa,
            //paquete_sucursal, producto_paquete y orden_de_servicio_paquete
            DAO::transBegin();
            try
            {
                PaqueteDAO::save($paquete);
                foreach($empresas as $empresa)
                {
                    $validar = self::validarParametrosPaqueteEmpresa($empresa["id_empresa"],$empresa["precio_utilidad"],$empresa["es_margen_utilidad"]);
                    if(is_string($validar))
                        throw new Exception($validar);
                    
                   $paquete_empresa = new PaqueteEmpresa( array(  
                       
                                                                "id_paquete"        => $paquete->getIdPaquete(),
                                                                "id_empresa"        => $empresa["id_empresa"],
                                                                "precio_utilidad"   => $empresa["precio_utilidad"],
                                                                "es_margen_utilidad"=> $empresa["es_margen_utilidad"]
                       
                                                                ) 
                                                               );
                    PaqueteEmpresaDAO::save($paquete_empresa);
                }/* Fin foreach de empresas */
                
                foreach($sucursales as $sucursal)
                {
                    $validar = self::validarParametrosPaqueteSucursal($sucursal["id_sucursal"],$sucursal["precio_utilidad"],$sucursal["es_margen_utilidad"]);
                    if(is_string($validar))
                        throw new Exception($validar);
                    
                   $paquete_sucursal = new PaqueteSucursal( array(  
                       
                                                                "id_paquete"        => $paquete->getIdPaquete(),
                                                                "id_sucursal"       => $sucursal["id_sucursal"],
                                                                "precio_utilidad"   => $sucursal["precio_utilidad"],
                                                                "es_margen_utilidad"=> $sucursal["es_margen_utilidad"]
                       
                                                                ) 
                                                               );
                    PaqueteSucursalDAO::save($paquete_sucursal);
                }/* Fin foreach de sucursales */
                
                if(!is_null($productos))
                {
                    $producto_paquete = new ProductoPaquete( array( "id_paquete" => $paquete->getIdPaquete() ) );
                    foreach($productos as $producto)
                    {
                        $validar = self::validarParametrosProductoPaquete($producto["id_producto"], $producto["id_unidad"], $producto["cantidad"]);
                        if(is_string($validar))
                            throw new Exception($validar);
                        
                        $producto_paquete->setIdProducto($producto["id_producto"]);
                        $producto_paquete->setIdUnidad($producto["id_unidad"]);
                        $producto_paquete->setCantidad($producto["cantidad"]);
                        ProductoPaqueteDAO::save($producto_paquete);
                    }
                }/* Fin if de productos */
                
                if(!is_null($servicios))
                {
                    $orden_de_servicio_paquete = new OrdenDeServicioPaquete( array( "id_paquete" => $paquete->getIdPaquete() ) );
                    foreach($servicios as $servicio)
                    {
                        $servicio = ServicioDAO::getByPK($servicio["id_servicio"]);
                        if(is_null($servicio))
                            throw new Exception("El servicio ".$servicio["id_servicio"]." no existe");
                        
                        if(!$servicio->getActivo())
                            throw new Exception("El servicio ".$servicio["id_servicio"]." no esta activo");
                        
                        if(is_string($validar = self::validarNumero($servicio["cantidad"], 1.8e200, "cantidad")))
                                throw new Exception($validar);
                        
                        $orden_de_servicio_paquete->setIdServicio($servicio["id_servicio"]);
                        $orden_de_servicio_paquete->setCantidad($servicio["cantidad"]);
                        OrdenDeServicioPaqueteDAO::save($orden_de_servicio_paquete);
                    }
                }/* Fin if de servicios */
            }
            catch(Exception $e)
            {
                DAO::transRollback();
            }
            DAO::transEnd();
            
	}
  
	/**
 	 *
 	 *Edita la informacion de un paquete
 	 *
 	 * @param id_paquete int ID del paquete a editar
 	 * @param foto_paquete string Url de la foto del paquete
 	 * @param productos json Objeto que contendra los ids de los productos contenidos en el paquete con sus cantidades respectivas
 	 * @param descuento float Descuento que sera aplicado a este paquete
 	 * @param servicios json Objeto que contendra los ids de los servicios contenidos en el paquete con sus cantidades respectivas
 	 * @param nombre string Nombre del paquete
 	 * @param margen_utilidad float Margen de utilidad que se ganara al vender este paquete
 	 * @param descripcion string Descripcion larga del paquete
 	 **/
	public static function Editar
	(
		$id_paquete, 
		$foto_paquete = "", 
		$productos = "", 
		$descuento = "", 
		$servicios = "", 
		$nombre = "", 
		$margen_utilidad = "", 
		$descripcion = ""
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Desactiva un paquete.
 	 *
 	 * @param id_paquete int Id del paquete a desactivar
 	 **/
	public static function Eliminar
	(
		$id_paquete
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Activa un paquete previamente desactivado
 	 *
 	 * @param id_paquete int Id del paquete a activar
 	 **/
	public static function Activar
	(
		$id_paquete
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Lista los paquetes, se puede filtrar por empresa, por sucursal, por producto, por servicio y se pueden ordenar por sus atributos
 	 *
 	 * @param id_empresa int Id de la empresa de la cual se listaran los paquetes
 	 * @param id_sucursal int Id de la sucursal de la cual se listaran sus paquetes
 	 * @param id_producto int Se listaran los paquetes que contengan dicho producto
 	 * @param id_servicio int Se listaran los paquetes que contengan dicho servicio
 	 * @param activo bool Si este valor no es obtenido, se listaran paquetes tanto activos como inactivos, si es verdadera, se listaran solo paquetes activos, si es falso, se listaran paquetes inactivos
 	 * @return paquetes json Lista de apquetes
 	 **/
	public static function Lista
	(
		$id_empresa = "", 
		$id_sucursal = "", 
		$id_producto = "", 
		$id_servicio = "", 
		$activo = ""
	)
	{  
  
  
	}
  
	/**
 	 *
 	 *Muestra los productos y/o servicios englobados en este paquete as? como las sucursales y las empresas donde lo ofrecen
 	 *
 	 * @param id_paquete int Id del paquete a visualizar sus detalles
 	 * @return detalle_paquete json Informacion del detalle del paquete
 	 **/
	public static function Detalle
	(
		$id_paquete
	)
	{  
  
  
	}
  }
