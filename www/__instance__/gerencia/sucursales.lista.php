<?php 



    define("BYPASS_INSTANCE_CHECK", false);

    require_once("../../../server/bootstrap.php");

    $page = new GerenciaComponentPage();

    $page->addComponent( new TitleComponent( "Sucursales" ) );

    $sucursales = SucursalesController::Buscar();

    $tabla = new TableComponent( 
        array(
            "descripcion"	=> "Descripcion",
            "id_gerente" 	=> "Gerente",
            "activa"		=>"Activa"
        ),
        $sucursales["resultados"]
    );

    $tabla->addColRender("id_gerente", "funcion_gerente");
    $tabla->addColRender("activa", "funcion_activa");
    $tabla->addOnClick( "id_sucursal", "(function(a){window.location = 'sucursales.ver.php?sid='+a;})" );
    $page->addComponent( $tabla );

    $page->render();
