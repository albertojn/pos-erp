<?php 



    define("BYPASS_INSTANCE_CHECK", false);

    require_once("../../../server/bootstrap.php");

    $page = new GerenciaComponentPage();

    $page->addComponent( new TitleComponent( "Cajas" ) );

    $tabla = new TableComponent(
        array(
            //"id_sucursal" => "Sucursal",
            "descripcion"=> "Descripcion",
            "saldo"=> "Saldo",
            "control_billetes" => "Control de Billetes",
            "abierta"=> "Abierta",
            "activa"=>"Activa"
        ),
        SucursalesController::ListaCaja( )
    );


    function funcion_bool_to_string($valor){
            return ($valor===true || $valor==="1" || $valor===1) ? "<strong>Si</strong>" : "No";
        }

        $tabla->addColRender("activa", "funcion_bool_to_string");
        $tabla->addColRender("abierta", "funcion_bool_to_string");
        $tabla->addColRender("control_billetes", "funcion_bool_to_string");

    $tabla->addOnClick( "id_caja", "(function(a){window.location = 'sucursales.caja.ver.php?cid='+a;})" );

    $page->addComponent( $tabla );

    $page->render();