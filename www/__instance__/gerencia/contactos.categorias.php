<?php

require_once('../../../server/bootstrap.php');

$page = new GerenciaComponentPage();
$page->addComponent(new TitleComponent("Categorias de Contactos"));

$page->addComponent("<div class='POS Boton' onClick='window.location=\"contactos.categoria.nuevo.php\"'>Crear</div>");

// Lista
$categorias = ContactosController::BuscarCategoria();
$table = new TableComponent(
	array(
		'nombre_completo' => '<b>Nombre completo</b>',
	),
	$categorias['categorias']
);
$table->addOnClick("id", "(function(a){window.location = 'contactos.categoria.ver.php?id='+a;})");
$page->addComponent($table);

$page->render();