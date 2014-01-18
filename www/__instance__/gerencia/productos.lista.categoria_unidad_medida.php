<?php 



    define("BYPASS_INSTANCE_CHECK", false);

    require_once("../../../server/bootstrap.php");

    $page = new GerenciaComponentPage();

    $page->addComponent( new TitleComponent( "Categorias Unidades de Medida" ) );
    $page->addComponent( new MessageComponent( "Lista Categorias Unidades de Medida" ) );

    $resultados = ProductosController::BuscarCategoriaUdm();
    $tabla = new TableComponent( array(
        "descripcion" => "Descripcion",
        "activa" => "Activa"
        ),
        $resultados['resultados']
    );

    $tabla->addColRender("activa", "funcion_activa");
    $tabla->addOnClick( "id_categoria_unidad_medida", "(function(a){ window.location = 'productos.categoria_unidad_medida.ver.php?cuid=' + a; })" );
    $page->addComponent( $tabla );

    $page->render();
