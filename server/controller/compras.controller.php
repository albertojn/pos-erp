<?php

require_once('model/inventario.dao.php');
require_once('model/compra_proveedor.dao.php');
require_once('model/detalle_compra_proveedor.dao.php');
require_once('model/compra_sucursal.dao.php');
require_once('model/detalle_compra_sucursal.dao.php');
require_once('model/detalle_compra_cliente.dao.php');
require_once('model/compra_proveedor_flete.dao.php');
require_once('model/inventario_maestro.dao.php');
require_once('model/autorizacion.dao.php');

require_once('logger.php');

function nuevaCompraProveedor($data = null) {

    $data = parseJSON($data);

    //{"embarque" : {"id_proveedor":1,"folio": "456","merma_por_arpilla": 0,"numero_de_viaje": null,"peso_por_arpilla": 55.45,"peso_origen" : 12345,"peso_recibido" : 12345,"productor" : "Jorge Nolasco","importe_total": 3702,"total_arpillas": 1,"costo_flete" : 123 },"conductor" : {"nombre_chofer" : "Alan Gonzalez","placas" : "afsdf67t78","marca_camion" : "Chrysler","modelo_camion" : "1977" },"productos": [{"id_producto": 3,"variedad" : "fianas","arpillas" : 12,"precio_kg" : 5.35,"sitio_descarga" : 0}]}

    if (!( isset($data->embarque) && isset($data->conductor) && isset($data->productos) )) {
        Logger::log("Uno o mas objetos necesarios para crear una nueva compra proveedor estan incompletos.");
        die('{"success": false , "reason": "Especifique los datos basicos." }');
    }

    if ($data->embarque == null || $data->conductor == null || $data->productos == null) {
        Logger::log("Uno o mas objetos necesarios para crear una nueva compra proveedor estan vacios.");
        die('{"success": false , "reason": "Especifique los datos basicos." }');
    }


    /*

      {
      "embarque" : {
      "id_proveedor": 1,
      "folio": "456",
      "merma_por_arpilla": 0,
      "numero_de_viaje": null,
      "peso_por_arpilla": 55.45,
      "peso_origen" : 12345,
      "peso_recibido" : 12345,
      "productor" : "Jorge Nolasco",
      "importe_total": 3702,
      "total_arpillas": 1,
      "costo_flete" : 123 ,
      "fecha_origen" :
      },
      "conductor" : {
      "nombre_chofer" : "Alan Gonzalez",
      "placas" : "afsdf67t78",
      "marca_camion" : "Chrysler",
      "modelo_camion" : "1977"
      },
      "productos": [
      {
      "id_producto": 3,
      "variedad" : "fianas",
      "arpillas" : 12,
      "precio_kg" : 5.35,
      "sitio_descarga" : 0
      }
      ]
      }

      //todos nulos
      {"embarque" : {"id_proveedor": null,"folio": null,"merma_por_arpilla": null,"numero_de_viaje": null,"peso_por_arpilla": null,"peso_origen" : null,"peso_recibido" : null,"productor" : null,"importe_total": null,"total_arpillas": null,"costo_flete" : null },"conductor" : {"nombre_chofer" : null,"placas" : null,"marca_camion" : null,"modelo_camion" : null },"productos": [{"id_producto": null,"variedad" : null,"arpillas" : null,"precio_kg" : null,"sitio_descarga" : null}]}

     */

    //TODO: Calcular discrepancias entre el peso por arpilla que manda alan y el que yo calculo

    Logger::log("Iniciando le proceso de registro de nueva compra a proveedor");

    //validamos que el data->embarque->total_arpillas sea > 0
    if ($data->embarque->total_arpillas <= 0) {
        Logger::log("Error : verifique el numeto toal de arpillas : " . $data->embarque->total_arpillas . ".");
        die('{ "success": false, "reason" : "Error : verifique el numeto total de arpillas :' . $data->embarque->total_arpillas . '."}');
    }

    //calculamos el peso real por arpilla
    $peso_real_por_arpilla = $data->embarque->peso_por_arpilla - $data->embarque->merma_por_arpilla;
    $otro_peso_real_por_arpilla = ( ($data->embarque->peso_recibido - ( $data->embarque->total_arpillas * $data->embarque->merma_por_arpilla )) / $data->embarque->total_arpillas );

    Logger::log("Insertando peso real por arpilla:" . $peso_real_por_arpilla . ", otro peso real por arpilla: " . $otro_peso_real_por_arpilla);

    if ($otro_peso_real_por_arpilla <= 0) {
        Logger::log("Error : verifique el valor de la merma por arpilla : " . $data->embarque->merma_por_arpilla . " ya que");
        die('{ "success": false, "reason" : "Error : verifique la merma por arpilla :' . $data->embarque->merma_por_arpilla . '"}');
    }

    //creamos la compra al proveedor
    $id_compra_proveedor = compraProveedor($data->embarque, $data->productos);

    //damos de alta el flete
    compraProveedorFlete($data->conductor, $id_compra_proveedor, $data->embarque->costo_flete);

    //damos de alta el detalle de la compra al proveedor
    ingresarDetalleCompraProveedor($data->productos, $id_compra_proveedor, $otro_peso_real_por_arpilla);

    //isertamos en el inventario maestro
    //($data = null, $id_compra_proveedor = null, $peso_por_arpilla = null, $sitio_descarga = null){
    insertarProductoInventarioMaestro($data->productos, $id_compra_proveedor, $otro_peso_real_por_arpilla);

    printf('{"success": true, "id_compra" : ' . $id_compra_proveedor . '}');
}

function compraProveedor($data = null, $productos = null) {

    /* if($json == null){
      Logger::log("No hay parametros para ingresar nueva compra a proveedor.");
      die('{ "success": false, "reason" : "Parametros invalidos" }');
      }

      $data = parseJSON( $json ); */

    /*


      NOTA: FATA PESO ORIGEN EN LA BD

     */

    if ($data == null) {
        Logger::log("Json invalido para crear nueva compra proveedor:");
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    /*

      "embarque" : {
      "id_proveedor": 1,
      "folio": "456",
      "merma_por_arpilla": 0,
      "numero_de_viaje": null,
      "peso_por_arpilla": 55.45,
      "peso_origen" : 12345,
      "peso_recibido" : 12345,
      "productor" : "Jorge Nolasco",
      "importe_total": 3702,
      "total_arpillas": 1,
      "costo_flete" : 123
      }

     */

    if (!( isset($data->id_proveedor) &&
            isset($data->merma_por_arpilla) &&
            isset($data->peso_origen) &&
            isset($data->peso_recibido) &&
            isset($data->productor) &&
            isset($data->total_arpillas) &&
            isset($data->peso_por_arpilla) &&
            isset($data->fecha_origen)
            )) {
        Logger::log("Faltan parametros para crear la compra a proveedor");
        die('{ "success": false, "reason" : "Parametros invalidos." }');
    }

    //verificamos que el numero de arpillas sea > 0
    if (!(is_numeric($data->total_arpillas) && $data->total_arpillas > 0)) {
        Logger::log("Error : verifique el numero total de arpillas : " . $data->total_arpillas . ".");
        die('{ "success": false, "reason" : "Error: verifique el numero total de arpillas : ' . $data->total_arpillas . '." }');
    }

    //verificamos la merma por arpilla
    if (!(is_numeric($data->merma_por_arpilla) && $data->merma_por_arpilla >= 0)) {
        Logger::log("Error : verifique la merma por arpilla : " . $data->merma_por_arpilla);
        die('{ "success": false, "reason" : "Error : verifique la merma por arpilla : ' . $data->merma_por_arpilla . '." }');
    }


    //verificamos el peso de origen
    if (!(is_numeric($data->peso_origen) && $data->peso_origen > 0)) {
        Logger::log("Error : verifique el peso de origen : " . $data->peso_origen);
        die('{ "success": false, "reason" : "Error : verifique el peso de origen : ' . $data->peso_origen . '." }');
    }

    //verificamos el peso recibido
    if (!(is_numeric($data->peso_recibido) && $data->peso_recibido > 0)) {
        Logger::log("Error : verifique el peso recibido : " . $data->peso_recibido);
        die('{ "success": false, "reason" : "Error : verifique el peso recibido : ' . $data->peso_recibido . '." }');
    }

    //formateamos al fecha de origen
    try {
        $fecha_o = explode("/", $data->fecha_origen);

        if (count($fecha_o) < 3) {
            Logger::log("Error en el formato de fecha");
            die('{ "success": false, "reason" : "Verifique que la fecha tenga el formato DD/MM/AA." }');
        }

        $dia = $fecha_o[0];
        $mes = $fecha_o[1];
        $anio = $fecha_o[2];

        if (!(is_numeric($dia) && $dia > 0 && $dia <= 31 )) {
            Logger::log("Error en el formato de fecha");
            die('{ "success": false, "reason" : "Verifique que la fecha tenga el formato DD/MM/AA." }');
        }

        if (!(is_numeric($mes) && $mes > 0 && $mes <= 12 )) {
            Logger::log("Error en el formato de fecha : " . $e);
            die('{ "success": false, "reason" : "Verifique que la fecha tenga el formato DD/MM/AA." }');
        }

        if (!(is_numeric($anio) && $anio >= 0 )) {
            Logger::log("Error en el formato de fecha : " . $e);
            die('{ "success": false, "reason" : "Verifique que la fecha tenga el formato DD/MM/AA." }');
        }


        $data->fecha_origen = $anio . "/" . $mes . "/" . $dia;
        //var_dump($data->fecha_origen);
    } catch (Exception $e) {
        Logger::log("Error en el formato de fecha : " . $e);
        die('{ "success": false, "reason" : "Verifique que la fecha tenga el formato DD/MM/AA." }');
    }



    //calculamos cuanto vale el viaje segun el proveedor
    /* $peso_promedio_origen = ( $data->peso_origen / $data->total_arpillas );
      $precio_total_origen = 0;

      foreach( $productos as $producto ){
      $precio_total_origen += $producto->precio_kg * $peso_promedio_origen;
      } */

    //creamos el objeto compra
    $compra = new CompraProveedor();

    $compra->setIdProveedor($data->id_proveedor);

    $compra->setPesoOrigen($data->peso_origen);
    /*
      if(isset($data->folio)){

      //verificamos que no exista el folio
      $comp = new CompraProveedor();
      $comp -> setFolio( $data->folio );
      $result = CompraProveedorDAO::search( $comp);

      if( count( $result ) > 0  ){
      Logger::log("Error al guardar la nueva compra a proveedor, se tiene registro del folio : " .  $data->folio );
      DAO::transRollback();
      die( '{"success": false, "reason": "Error al guardar la nueva compra a proveedor, ya se tiene registro del folio : ' . $data->folio . '" }' );
      }



      } */
    $compra->setFolio($data->folio);

    if (isset($data->numero_de_viaje))
        $compra->setNumeroDeViaje($data->numero_de_viaje);

    $compra->setPesoRecibido($data->peso_recibido);

    $compra->setArpillas($data->total_arpillas);

    $compra->setPesoPorArpilla($data->peso_por_arpilla);

    $compra->setProductor($data->productor);

    if (isset($data->calidad))
        $compra->setCalidad($data->calidad);

    $compra->setMermaPorArpilla($data->merma_por_arpilla);

    if (isset($data->importe_total))
        $compra->setTotalOrigen($data->importe_total);

    $compra->setFechaOrigen($data->fecha_origen);

    DAO::transBegin();

    try {
        CompraProveedorDAO::save($compra);
    } catch (Exception $e) {
        Logger::log("Error al guardar la nueva compra a proveedor:" . $e);
        DAO::transRollback();
        die('{"success": false, "reason": "Error interno al guardar la compra al proveedor, intente nuevamente." }');
    }

    Logger::log("Compra a proveedor creada !");

    return $compra->getIdCompraProveedor();

    //printf('{"success": true, "id": "%s"}' , $compra->getIdCompraProveedor());
}

function compraProveedorFlete($data = null, $id_compra_proveedor = null, $costo_flete = null) {

    /* if($json == null){
      Logger::log("No hay parametros para ingresar nuevo flete a compra a proveedor.");
      die('{ "success": false, "reason" : "Parametros invalidos" }');
      }

      $data = parseJSON( $json ); */

    if ($data == null) {
        Logger::log("Error : el juego de datos del flete esta vacio.");
        die('{"success": false , "reason": "Error : el juego de datos del flete esta vacio." }');
    }


    /*

      "conductor" : {
      "nombre_chofer" : "Alan Gonzalez",
      "placas" : "afsdf67t78",
      "marca_camion" : "Chrysler",
      "modelo_camion" : "1977"
      }

     */

    if (!( $id_compra_proveedor != null &&
            $costo_flete != null &&
            isset($data->nombre_chofer) &&
            isset($data->placas)
            )) {
        Logger::log("Faltan parametros para crear el nuevo flete a compra a proveedor : " . $json);
        die('{ "success": false, "reason" : "Error : Verifique los datos del flete. " }');
    }

    $compra = new CompraProveedorFlete();

    $compra->setIdCompraProveedor($id_compra_proveedor);

    $compra->setChofer($data->nombre_chofer);

    if (isset($data->marca_camion))
        $compra->setMarcaCamion($data->marca_camion);

    $compra->setPlacasCamion($data->placas);

    if (isset($data->modelo_camion))
        $compra->setModeloCamion($data->modelo_camion);

    $compra->setCostoFlete($costo_flete);

    try {
        CompraProveedorFleteDAO::save($compra);
    } catch (Exception $e) {
        Logger::log("Error al guardar el nuevo flete a compra a proveedor:" . $e);
        DAO::transRollback();
        die('{"success": false, "reason": "Error interno al guardar el flete, intente nuevamente." }');
    }

    Logger::log("Flete a compra a proveedor creado !");

    //printf('{"success": true}');
    return;
}

function editarCompraProveedor($json) {

    if ($json == null) {
        Logger::log("No hay parametros para editar la compra a proveedor.");
        die('{ "success": false, "reason" : "Parametros invalidos" }');
    }

    $data = parseJSON($json);

    if ($data == null) {
        Logger::log("Json invalido para crear editar la compra a proveedor:" . $json);
        die('{ "success": false, "reason" : "Parametros invalidos" }');
    }

    if (!isset($data->id_compra_proveedor)) {
        Logger::log("No se ha especificado que compra a proveedor se desea editar");
        die('{ "success": false, "reason" : "Parametros invalidos" }');
    }

    $compra = new CompraProveedor( );

    $compra->setIdCompraProveedor($data->id_compra_proveedor);

    if (isset($data->id_proveedor))
        $compra->setIdProveedor($data->id_proveedor);

    if (isset($data->folio))
        $compra->setFolio($data->folio);

    if (isset($data->numero_de_viaje))
        $compra->setNumeroDeViaje($data->numero_de_viaje);

    if (isset($data->peso_recibido))
        $compra->setPesoRecibido($data->peso_recibido);

    if (isset($data->arpillas))
        $compra->setArpillas($data->arpillas);

    if (isset($data->peso_por_arpilla))
        $compra->setPesoPorArpilla($data->peso_por_arpilla);


    if (isset($data->merma_por_arpilla))
        $compra->setMermaPorArpilla($data->merma_por_arpilla);

    if (isset($data->productor))
        $compra->setProductor($data->productor);

    if (isset($data->total_origen))
        $compra->setTotalOrigen($data->total_origen);

    try {
        CompraProveedorDAO::save($compra);
    } catch (Exception $e) {
        Logger::log("Error al guardar la edicion de la compra a proveedor:" . $e);
        die('{"success": false, "reason": "Error" }');
    }

    printf('{"success": true, "id": "%s"}', $compra->getIdCompraProveedor());
    Logger::log("Compra a proveedor modificada !");
}

function detalleCompraProveedor($id_compra) {

    if (!isset($id_compra)) {
        Logger::log("Error interno : el id de la compra no esta disponible para dar de alta el detalle compra proveedor.");
        die('{"success": false, "reason": "Error interno : el id de la compra no esta disponible para dar de alta el detalle compra proveedor." }');
    } elseif (empty($id_compra)) {
        Logger::log("Error interno : el id de la compra que se envia para dar de alta el detalle compra proveedor esta vacio.");
        die('{"success": false, "reason": "Error interno : el id de la compra que se envia para dar de alta el detalle compra proveedor esta vacio." }');
    }

    //verificamos que exista esa compra
    if (!( $compra = CompraProveedorDAO::getByPK($id_compra) )) {
        Logger::log("Error interno : no se tiene registro de la compra a proveedor " . $id_compra);
        die('{"success": false, "reason": "Error interno : no se tiene registro de la compra a proveedor." }');
    }

    $q = new DetalleCompraProveedor();
    $q->setIdCompraProveedor($id_compra);

    $detalle_compra = DetalleCompraProveedorDAO::search($q);

    $array_detalle_compra = array();

    foreach ($detalle_compra as $producto) {

        $productoData = InventarioMaestroDAO::getByPK($producto->getIdProducto(), $producto->getIdCompraProveedor());

        array_push($array_detalle_compra, array(
            "id_producto" => $producto->getIdProducto(),
            "variedad" => $producto->getVariedad(),
            "arpillas" => $producto->getArpillas(),
            "kg" => $producto->getKg(),
            "precio_por_kg" => $producto->getPrecioPorKg()
        ));
    }

    $info_compra->id_compra_proveedor = $compra->getIdCompraProveedor();
    //$info_compra -> total_origen = $compra -> getTotalOrigen(); //<--POR NO ESTA EN LA DOVUMENTACION?
    $info_compra->num_compras = count($array_detalle_compra);
    $info_compra->articulos = $array_detalle_compra;

    return $info_compra;
}

function listarComprasProveedor() {

    return CompraProveedorDAO::getAll();
}

function editarCompraProveedorFlete($json = null) {

    if ($json == null) {
        Logger::log("No hay parametros para modificar flete a compra a proveedor.");
        die('{ "success": false, "reason" : "Parametros invalidos" }');
    }

    $data = parseJSON($json);

    if ($data == null) {
        Logger::log("Json invalido para crear un nuevo flete a compra proveedor:" . $json);
        die('{ "success": false, "reason" : "Parametros invalidos" }');
    }


    if (!( isset($data->id_compra_proveedor) )) {
        Logger::log("Faltan parametros para crear el nuevo flete a compra a proveedor:" . $json);
        die('{ "success": false, "reason" : "Faltan parametros." }');
    }

    $compra = new CompraProveedorFlete();

    $compra->setIdCompraProveedor($data->id_compra_proveedor);

    if (isset($data->id_compra_proveedor))
        $compra->setIdCompraProveedor($data->id_compra_proveedor);

    if (isset($data->chofer))
        $compra->setChofer($data->chofer);

    if (isset($data->marca_camion))
        $compra->setMarcaCamion($data->marca_camion);

    if (isset($data->placas_camion))
        $compra->setPlacasCamion($data->placas_camion);

    if (isset($data->modelo_camion))
        $compra->setModeloCamion($data->modelo_camion);

    if (isset($data->costo_flete))
        $compra->setCostoFlete($data->costo_flete);

    try {
        CompraProveedorFleteDAO::save($compra);
    } catch (Exception $e) {
        Logger::log("Error al guardar el nuevo flete a compra a proveedor:" . $e);
        die('{"success": false, "reason": "Error al guardar el flete" }');
    }

    Logger::log("Flete a compra a proveedor creado !");

    printf('{"success": true}');
}

function ingresarDetalleCompraProveedor($data = null, $id_compra_proveedor =null, $peso_por_arpilla = null) {


    if ($data == null) {
        Logger::log("Error : el juego de productos empleado para dar de alta el detalle compra proveedor es nulo.");
        DAO::transRollback();
        die('{"success": false , "reason": "Error : el juego de productos empleado para dar de alta el detalle compra proveedor es nulo." }');
    }

    Logger::log("Iniciando proceso de creacion detalle compra proveedor");

    foreach ($data as $producto) {

        if (!(
                $id_compra_proveedor != null &&
                isset($producto->id_producto) &&
                isset($producto->variedad) &&
                isset($producto->arpillas) &&
                isset($producto->precio_kg) &&
                $peso_por_arpilla != null
                )) {

            Logger::log("Error : verifique que los datos de los productos a surtir esten completos.");
            DAO::transRollback();
            die('{"success": false , "reason": "Error : verifique que los datos de los productos a surtir esten completos." }');
        }

        $detalle_compra_proveedor = new DetalleCompraProveedor();

        $detalle_compra_proveedor->setIdCompraProveedor($id_compra_proveedor);
        $detalle_compra_proveedor->setIdProducto($producto->id_producto);
        $detalle_compra_proveedor->setVariedad($producto->variedad);
        $detalle_compra_proveedor->setArpillas($producto->arpillas);
        $detalle_compra_proveedor->setKg(( $peso_por_arpilla * $producto->arpillas));
        $detalle_compra_proveedor->setPrecioPorKg($producto->precio_kg);

        try {
            DetalleCompraProveedorDAO::save($detalle_compra_proveedor);
        } catch (Exception $e) {
            Logger::log("Error interno : no se guardo el detalle compra proveedor, intente nuevamente." . $e);
            DAO::transRollback();
            die('{"success": false, "reason": "Error interno : no se guardo el detalle compra proveedor, intente nuevamente."}');
        }
    }

    Logger::log("Proceso de alta a detalle proveedor finalizado con exito!");
}

function insertarProductoInventarioMaestro($data = null, $id_compra_proveedor = null, $peso_por_arpilla = null) {


    if ($data == null) {
        Logger::log("Error : el juego de productos empleado para dar de alta en el inventario maestro es nulo.");
        die('{"success": false , "reason": "Error : el juego de productos empleado para dar de alta en el inventario maestro es nulo." }');
    }

    Logger::log("Iniciando proceso de insercion de producto a inventario maestro");

    foreach ($data as $producto) {

        $existencias = $producto->arpillas * $peso_por_arpilla;

        Logger::log("Insertando " . $existencias . "(" . $producto->arpillas . " * " . $peso_por_arpilla . ") al producto " . $producto->id_producto);

        $inventario_maestro = new InventarioMaestro();

        //var_dump($producto -> sitio_descarga);

        $inventario_maestro->setIdProducto($producto->id_producto);
        $inventario_maestro->setIdCompraProveedor($id_compra_proveedor);
        $inventario_maestro->setExistencias($existencias);
        $inventario_maestro->setExistenciasProcesadas(0);
        $inventario_maestro->setSitioDescarga($producto->sitio_descarga);

        try {
            InventarioMaestroDAO::save($inventario_maestro);
        } catch (Exception $e) {
            Logger::log("Imposible modificar las existencias del producto " . $producto->id_producto . " en el inventario maestro: " . $e, 2);
            DAO::transRollback();
            die('{"success": false , "reason": "Imposible insertar producto en inventario maestro. Por favor intente de nuevO." }');
        }
    }

    DAO::transEnd();


    Logger::log("Proceso de alta a inventario maestro finalizado con exito!");
}

/**
 *
 * 	{
 *         "productos": [
 *             {
 *             "items": [
 *                 {
 *                     "id_compra": 6,
 *                     "id_producto": 2,
 *                     "cantidad": 400,
 *                     "desc": "papa segunda",
 *                     "procesada": false,
 *                     "escala": "kilogramo",
 *                     "precio": 7,
 *                     "descuento": 0
 *                 },
 *                 {
 *                     "id_compra": 10,
 *                     "id_producto": 1,
 *                     "cantidad": 200,
 *                     "desc": "papas primeras",
 *                     "procesada": false,
 *                     "escala": "kilogramo",
 *                     "precio": 7,
 *                     "descuento": 0
 *                 }
 *             ],
 *             "producto": 1,
 *             "procesado": true
 *             }
 *         ],
 *         "sucursal": "1"
 *       }
 *
 * */
function nuevaCompraSucursal($json = null) {

    $data = parseJSON($json);

    if (!( isset($data->sucursal) && isset($data->productos) )) {
        Logger::log("Json invalido para crear nueva compra sucursal:" . $json);
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    if ($data->sucursal == null || $data->productos == null) {
        Logger::log("Json invalido para crear nueva compra sucursal:" . $json);
        die('{"success": false , "reason": "Parametros invalidos." }');
    }


    //verificamos que exista la sucursal
    if (!SucursalDAO::getByPK($data->sucursal)) {
        Logger::log("Sucursal no encontrada ");
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    //verificamos que contenga almenos un producto
    if (count($data->productos) <= 0) {
        Logger::log("Sucursal no encontrada, error al crear nueva compra sucursal ");
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    Logger::log("Inicial el proceso de compra sucursal");
    DAO::transBegin();


    $detalles_de_compra = array();

    $parametros = array();

    $preparametros = array();

    $global_total_importe = 0;



    //iteramos todos los productos a surtie
    foreach ($data->productos as $producto) {

        Logger::log("Producto a surtir : " . $producto->producto . " con " . sizeof($producto->items) . " subproductos");

        $cantidad = 0;
        $precio = 0;
        $descuento = 0;

        //iteramos todos los subproductos que componen al producto actual
        foreach ($producto->items as $subproducto) {

            $cantidad += $subproducto->cantidad;
            $descuento += $subproducto->descuento;

            //calculamos el precio de este subproducto,
            //y lo sumamos a lo de los demas
            $precio += $subproducto->precio * ($subproducto->cantidad - $subproducto->descuento);

            Logger::log("SE TOMA EN CUENTA EL DESCUENTO AQUI!?!?!?");

            descontarDeInventarioMaestro($subproducto->id_compra,
                    $subproducto->id_producto,
                    $subproducto->cantidad,
                    $subproducto->procesada);
        }//foreach



        $global_total_importe += ( ($precio / $cantidad) * $cantidad );

        $detalle = new DetalleCompraSucursal();
        $detalle->setIdProducto($producto->producto);
        $detalle->setCantidad($cantidad);
        $detalle->setDescuento($descuento);
        $detalle->setPrecio($precio / $cantidad);
        $detalle->setProcesadas($producto->procesado);

        array_push($detalles_de_compra, $detalle);

        //vamos generando los datos de los parametros la autorizacion de envio de productos
        //este es el formato de como deberia de quedar
        /*
          {
          "id_producto": 1,
          "procesado": "true",
          "cantidad_procesada": 100,
          "precio_procesada": "10.5",
          "cantidad": 100,
          "precio": "9.5"
          }
         */

        array_push($parametros, array(
            "id_producto" => $producto->producto,
            "procesado" => $producto->procesado,
            "cantidad_procesada" => $producto->procesado ? $detalle->getCantidad() : 0,
            "precio_procesada" => $producto->procesado ? $detalle->getPrecio() : 0,
            "cantidad" => $producto->procesado ? 0 : $detalle->getCantidad(),
            "precio" => $producto->procesado ? 0 : $detalle->getPrecio()
        ));
    }//foreach
    //insertar la nueva compra sucursal
    $compraSucursal = new CompraSucursal();
    $compraSucursal->setSubtotal($global_total_importe);
    $compraSucursal->setIdSucursal($data->sucursal);
    $compraSucursal->setIdUsuario($_SESSION['userid']);
    $compraSucursal->setIdProveedor(0);
    $compraSucursal->setPagado(0);
    $compraSucursal->setLiquidado(0);
    $compraSucursal->setTotal($global_total_importe);

    try {
        CompraSucursalDAO::save($compraSucursal);
    } catch (Exception $e) {
        Logger::log($e);
        DAO::transRollback();
        die('{"success": false , "reason": "Error al salvar la compra sucursal." }');
    }

    Logger::log("Compra con id " . $compraSucursal->getIdCompra() . " insertada ");


    //poner el id de compra sucursal en los detalles de la compra
    foreach ($detalles_de_compra as $detalle) {

        $detalle->setIdCompra($compraSucursal->getIdCompra());

        try {
            DetalleCompraSucursalDAO::save($detalle);
        } catch (Exception $e) {
            Logger::log($e);
            DAO::transRollback();
            die('{"success": false , "reason": "Error al guardar el detalle de compra sucursal." }');
        }

        Logger::log("Ingresando detalle de compra {$compraSucursal->getIdCompra()}  producto {$detalle->getIdProducto()} ");
    }

    Logger::log("Termiando de ingresar los detalle de la compra " . $compraSucursal->getIdCompra() . ".");


    //ahora generamos la autorizacion de envio de producto para la sucursal


    $autorizacion = new Autorizacion();

    $autorizacion->setIdUsuario($_SESSION['userid']);
    $autorizacion->setIdSucursal($data->sucursal);
    $autorizacion->setEstado(3); // en transito
    $autorizacion->setTipo("envioDeProductosASucursal");

    if (!isset($data->conductor) || $data->conductor == "") {
        $conductor = "No especificado";
    } else {
        $conductor = $data->conductor;
    }


    $autorizacion->setParametros(json_encode(array(
                "clave" => 209,
                "descripcion" => "Envio de productos",
                "conductor" => $conductor,
                "productos" => $parametros))
    );


    try {
        AutorizacionDAO::save($autorizacion);
    } catch (Exception $e) {
        Logger::log("Error al agregar la autorizacion de compra sucursal" . $e);
        DAO::transRollback();
        die('{"success": false, "reason": "Error al agregar la autorizacion de compra sucursal"}');
    }

    DAO::transEnd();

    Logger::log("Proceso de venta a sucursal finalizado con exito !");


    printf('{"success": true ,  "compra_id" : ' . $compraSucursal->getIdCompra() . ' }');
}

function descontarDeInventarioMaestro($id_compra, $id_producto, $cantidad, $procesada) {
    Logger::log("Descontando " . $cantidad . " de (" . $id_compra . "," . $id_producto . ") de inventario maestro");
    DAO::transBegin();

    //obtenemos el articulo del inventario maestro
    $inventario_maestro = InventarioMaestroDAO::getByPK($id_producto, $id_compra);

    if ($procesada) {

        //verificamos que lo que se va a surtir no supere a las existencias
        if ($cantidad > $inventario_maestro->getExistenciasProcesadas()) {
            Logger::log("Error al editar producto en inventario maestro: la cantidad requerida de producto supera las existencias");
            DAO::transRollback();
            die('{"success": false, "reason": "Error al editar producto en inventario maestro: la cantidad requerida de producto supera las existencias"}');
        }

        //aqui entra se el producto es procesado (VALIDA LAS EXISTENCIAS)
        $inventario_maestro->setExistenciasProcesadas($inventario_maestro->getExistenciasProcesadas() - $cantidad);
    } else {

        //verificamos que lo que se va a surtir no supere a las existencias
        if ($cantidad > $inventario_maestro->getExistencias()) {
            Logger::log("Error al editar producto en inventario maestro: la cantidad requerida de producto supera las existencias");
            DAO::transRollback();
            die('{"success": false, "reason": "Error al editar producto en inventario maestro"}');
        }

        //aqui entra si el producto es original
        $inventario_maestro->setExistencias($inventario_maestro->getExistencias() - $cantidad);
    }



    try {
        InventarioMaestroDAO::save($inventario_maestro);
    } catch (Exception $e) {
        Logger::log("Error al editar producto en inventario maestro:" . $e);
        DAO::transRollback();
        die('{"success": false, "reason": "Error al editar producto en inventario maestro"}');
    }

    Logger::log("Se ha descontado satisfactoriamente");
    DAO::transEnd();
}

function insertarCompraSucursal($data = null, $sucursal = null) {

    Logger::log("Iniciando proceso de compra sucursal");

    if ($data == null || $sucursal == null) {
        Logger::log("compraSucursal, error : recibi uno o mas objetos nulos");
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    $subtotal_compra = 0;

    //calculamos el subtotal de la compra
    foreach ($data as $producto) {
        $subtotal_compra += ( $producto->cantidad - $producto->descuento ) * $producto->precio;
    }

    $compra_sucursal = new CompraSucursal();

    $compra_sucursal->setSubtotal($subtotal_compra);
    $compra_sucursal->setIdSucursal($sucursal);
    $compra_sucursal->setIdUsuario($_SESSION['userid']);
    $compra_sucursal->setPagado(0);
    $compra_sucursal->setLiquidado(0);
    $compra_sucursal->setTotal($subtotal_compra);

    try {
        CompraSucursalDAO::save($compra_sucursal);
    } catch (Exception $e) {
        Logger::log("Error al ingresar compra sucursal : " . $e);
        DAO::transRollback();
        die('{"success": false, "reason": "Error al ingresar compra sucursal"}');
    }

    Logger::log("Agregado la compra sucursal!");

    //AQUI TERMINA LA TRANSACCION POR QUE PARA AGREGAR EL DETALLE COMPRA SUCURSAL DEBE DE ESTAR CREADA LA COMPRA A SUCURSAL

    DAO::transEnd();

    return $compra_sucursal;
}

function ingresarDetalleCompraSucursal($data = null, $id_compra) {

    Logger::log("Creacion de detalle compra sucursal de compra " . $id_compra);

    if ($data == null || $id_compra == null) {
        Logger::log("ingresarDetalleCompraSucursal, error : recibi uno o mas objetos nulos");
        DAO::transRollback();
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    foreach ($data as $producto) {

        if (!(
                isset($producto->id_producto) &&
                isset($producto->cantidad) &&
                isset($producto->precio) &&
                isset($producto->descuento) &&
                isset($producto->procesada) &&
                isset($producto->id_compra)
                )) {
            Logger::log("Faltan parametros para crear el nuevo detalle compra sucursal");
            die('{ "success": false, "reason" : "Faltan parametros." }');
        }

        $detalle_compra_sucursal = new DetalleCompraSucursal();

        $detalle_compra_sucursal->setIdCompra($id_compra);
        $detalle_compra_sucursal->setIdProducto($producto->id_producto);
        $detalle_compra_sucursal->setCantidad($producto->cantidad);
        $detalle_compra_sucursal->setPrecio($producto->precio);
        $detalle_compra_sucursal->setDescuento($producto->descuento);
        $detalle_compra_sucursal->setProcesadas($producto->procesada);

        DAO::transBegin();

        try {
            DetalleCompraSucursalDAO::save($detalle_compra_sucursal);
            Logger::log("Detalle compra sucursal agregado correctamente para el articulo " . $producto->id_producto);
        } catch (Exception $e) {
            Logger::log("Error al agregar el detalle compra sucursal" . $e);
            DAO::transRollback();
            die('{"success": false, "reason": "Error al ingresar el detalle compra sucursal"}');
        }
    }



    Logger::log("Finalizado proceso de creacion de detalle compra sucursal!");

    return;
}

function ingresarAutorizacion($data = null, $sucursal = null, $id_compra = null) {

    Logger::log("Iniciando proceso de ingreso de autorizacion en transito");

    if ($data == null || $sucursal == null || $id_compra == null) {
        Logger::log("Error : recibi uno o mas objetos nulos");
        DAO::transRollback();
        die('{"success": false , "reason": "Parametros invalidos." }');
    }

    $parametros = array();

    foreach ($data as $producto) {

        if (!(

                isset($producto->id_producto) &&
                isset($producto->cantidad) &&
                isset($producto->precio) &&
                isset($producto->descuento) &&
                isset($producto->procesada) &&
                isset($producto->id_compra)
                )) {
            Logger::log("Faltan parametros para crear el nuevo ingreso de autorizacion");
            DAO::transRollback();
            die('{ "success": false, "reason" : "Faltan parametros." }');
        }

        array_push($parametros, array(
            "id_compra" => $id_compra,
            "id_producto" => $producto->id_producto,
            "cantidad" => $producto->cantidad,
            "procesada" => $producto->procesada,
            "descuento" => $producto->descuento,
            "precio" => $producto->precio
        ));
    }


    $autorizacion = new Autorizacion();

    $autorizacion->setIdUsuario($_SESSION['userid']);
    $autorizacion->setIdSucursal($sucursal);
    $autorizacion->setEstado(3); // en transito
    $autorizacion->setTipo("envioDeProductosASucursal");
    $autorizacion->setParametros(json_encode(array(
                "clave" => "209",
                "descripcion" => "Envio de productos",
                "productos" => $parametros)));


    try {
        AutorizacionDAO::save($autorizacion);
    } catch (Exception $e) {
        Logger::log("Error al agregar la autorizacion de compra sucursal" . $e);
        DAO::transRollback();
        die('{"success": false, "reason": "Error al agregar la autorizacion de compra sucursal"}');
    }

    DAO::transEnd();

    Logger::log("Proceso de venta a sucursal finalizado con exito!");

    printf('{"success": true}');
}

/**
 * Listar las compras de una sucursal.
 *
 * Regresa la lista de compras de una sucursal dado su id, ordenada
 * por fecha y mostrando solo las ultimas <i>n</i> compras.
 * Esta funcion recolectara todos los datos de la compra, calculando,
 * saldos de cada compra y detalles de cada compra.
 *
 * @param sid El id de la sucursal a listar
 * @param n El numero de registros a regresar. Por default sera n = 10
 * @return Array Un arreglo que contendra por cada indice, un objeto
 * {@link CompraSucursal} en forma de arreglo asociativo, junto con un indice
 * llamado <i>productos</i> que contendra objetos {@link DetalleCompraSucursal}
 * en forma de arreglo asociativo. Si la sucursal no se encuentra o se
 * encontro un error, se regresara null.
 *
 * */
function comprasDeSucursal($sid = null, $n = 10) {

    if (!$sid) {
        return null;
    }


    if (!SucursalDAO::getByPK($sid)) {
        return null;
    }

    $foo = new CompraSucursal();
    $foo->setIdSucursal($sid);
    $compras = CompraSucursalDAO::search($foo, "fecha", "desc");

    $result = array();

    foreach ($compras as $compra) {

        if ($n-- == 0) {
            break;
        }

        //buscar los detalles de esta compra
        $detalleQuery = new DetalleCompraSucursal();
        $detalleQuery->setIdCompra($compra->getIdCompra());

        $detalles = DetalleCompraSucursalDAO::search($detalleQuery);

        $compraArray = $compra->asArray();
        $compraArray['productos'] = array();

        foreach ($detalles as $detalle) {
            array_push($compraArray['productos'], $detalle->asArray());
        }

        array_push($result, $compraArray);
    }

    return $result;
}

/**
 * Listar compras por saldar de sucursal.
 *
 * Regresa todas las compras de una o todas las sucursales que no
 * han sido saldadas.
 *
 * @param sid El id de una sucursal, si es nulo, se regresaran los
 * resultados de todas las sucursales.
 *
 * */
function comprasDeSucursalSinSaldar($sid = null, $need_the_items = true) {

    $foo = new CompraSucursal();

    //si se envio una sucursal, verificar que exista
    if ($sid && !SucursalDAO::getByPK($sid)) {
        return null;
    }

    if ($sid) {
        $foo->setIdSucursal($sid);
    }

    $foo->setLiquidado(0);

    $compras = CompraSucursalDAO::search($foo, "fecha", "desc");



    if (!$need_the_items) {
        //if i dont need 'them items
        return $compras;
    }

    $result = array();

    foreach ($compras as $compra) {

        //buscar los detalles de esta compra
        $detalleQuery = new DetalleCompraSucursal();
        $detalleQuery->setIdCompra($compra->getIdCompra());

        $detalles = DetalleCompraSucursalDAO::search($detalleQuery);

        $compraArray = $compra->asArray();
        $compraArray['productos'] = array();

        foreach ($detalles as $detalle) {
            array_push($compraArray['productos'], $detalle->asArray());
        }

        array_push($result, $compraArray);
    }

    return $result;
}

/**
 * 
 * {
 *     id_cliente : int,
 *     tipo_compra : enum('credito','contado'),
 *     tipo_pago : enum('efectivo','cheque','tarjeta'),
 *     productos : [
 *         {
 *             id_producto : int
 *             cantidad : float
 *             precio : float
 *             descuento : float
 *         }
 *     ]
 * }
 *
 */
function nuevaCompraCliente($args = null) {

    Logger::log("Iniciando proceso de compra a cliente");

    if (!isset($args['data'])) {
        Logger::log("Sin parametros para realizar la compra");
        die('{"success": false, "reason": "No hay parametros para realizar la compra." }');
    }

    try {
        $data = parseJSON($args['data']);
    } catch (Exception $e) {
        Logger::log("json invalido para realizar la compra : " . $e);
        die('{"success": false, "reason": "Parametros invalidos." }');
    }

    if ($data == null) {
        Logger::log("el parseo del json de la compra resulto en un objeto nulo");
        die('{"success": false, "reason": "Parametros invalidos. El objeto es nulo." }');
    }

    //verificamos que se manden todos los parametros necesarios
    if (!( isset($data->id_cliente) && isset($data->tipo_compra) && isset($data->tipo_pago) && isset($data->productos)  )) {
        Logger::log("Falta uno o mas parametros");
        die('{"success": false, "reason": "Verifique sus datos, falta uno o mas parametros." }');
    }

    //verificar que $data->items  sea un array
    if (!is_array($data->productos)) {
        Logger::log("data -> items no es un array de productos");
        die('{"success": false, "reason": "No se generaron correctamente las descripciones de los productos para la venta." }');
    }

    //verificamos que $data->items almenos tenga un producto
    if (count($data->productos) <= 0) {
        Logger::log("data -> items no contiene ningun producto");
        die('{"success": false, "reason": "No se envio ningun producto para generar una nueva venta." }');
    }

    //verificamos que el cliente exista
    if (!( $cliente = ClienteDAO::getByPK($data->cliente) )) {
        Logger::log("No se tiene registro del cliente : " . $data->cliente);
        die('{"success": false, "reason": "No se tiene registro del cliente ' . $data->cliente . '." }');
    }

    //creamos la compra
    
    $compra = new CompraCliente();
    $compra->setCancelada(0);
    $compra->setIdCliente($cliente->getIdCliente());
    $compra->setIdSucursal($_SESSION['sucxursal']);
    $compra->setIp($_SERVER['REMOTE_ADDR']);
    $compra->setTipoCompra($data->tipo_compra);
    $compra->setTipoPago($data->tipo_pago);
    $compra->setIdUsuario($_SESSION['userid']);

   
}

if (isset($args['action'])) {
    switch ($args['action']) {

        case 1000://recibe el json para crear una compra  aproveedor

            if (!( isset($args['data']) && $args['data'] != null )) {
                Logger::log("No hay parametros para ingresar nueva compra a proveedor.");
                die('{"success": false , "reason": "No hay parametros para ingresar nueva compra a proveedor."}');
            }

            nuevaCompraProveedor($args['data']);

            break;

        case 1001://modificar compra a proveedor (admin)
            //http://127.0.0.1/pos/www/proxy.php?action=1001&data={"id_compra_proveedor":"2","id_proveedor":"1","folio":"234","numero_de_viaje":"12","peso_recibido":"12200","arpillas":"340","peso_por_arpilla":"65","productor":"El%20fenix de Celaya","merma_por_arpilla":"5","total_origen":"17900"}
            //printf('{ "success": true, "datos": %s }',  json_encode( editarCompraProveedor( $args['data'] ) ) );
            editarCompraProveedor($args['data']);
            break;

        case 1002://regresa las compras realizadas por el admin
            printf('{ "success": true, "datos": %s }', json_encode(listarComprasProveedor()));
            break;

        case 1003://regresa el detalle de la compra
            printf('{ "success": true, "datos": %s }', json_encode(detalleCompraProveedor($args['id_compra_proveedor'])));
            break;

        case 1004://modificar flete
            editarCompraProveedorFlete($args['data']);
            break;

        case 1005://funcion utilizada por el admin para vender producto a una sucursal

            /*
              {
              sucursal:1,
              copnductor:'pedro'
              productos:[
              {
              id_producto:1,
              procesada:false,
              cantidad:30,
              descuento:20,
              precio:12.4,
              id_compra:11.5
              }
              ]
              }

              {sucursal:2,productos:[{id_producto:3,procesada:false,cantidad:30,descuento:20,precio:12.4,id_compra:11.5}]}

             */

            if (!( isset($args['data']) && $args['data'] != null )) {
                Logger::log("No hay parametros para ingresar nueva compra a sucursal.");
                die('{"success": false , "reason": "Parametros invalidos." }');
            }
            nuevaCompraSucursal($args['data']);
            break;

        case 1006:
            //compra a clente
             nuevaCompraCliente($args);
            break;

        default:
            printf('{ "success" : "false" }');
            break;
    }
}
//java -classpath .;gson-1.6.jar Test compras.test
//$_SESSION['userid']



