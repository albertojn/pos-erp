<?php 

require_once('../../../server/bootstrap.php');

$page = new GerenciaComponentPage();
$page->addComponent(new TitleComponent("Categorias de Productos"));

$page->addComponent("<div class='POS Boton' onClick='window.location=\"productos.categoria.nueva.php\"'>Crear</div>");

// Lista
$categorias = ProductosController::BuscarCategoria();
$table = new TableComponent(
    array(
        'nombre_completo' => '<b>Nombre completo</b>',
    ),
    $categorias['categorias']
);
$table->addOnClick("id_clasificacion_producto", "(function(a){window.location = 'productos.categoria.ver.php?id='+a;})");
$page->addComponent($table);

$page->render();