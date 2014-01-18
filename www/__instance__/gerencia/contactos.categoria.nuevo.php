<?php

require_once('../../../server/bootstrap.php');

$page = new GerenciaComponentPage();
$page->addComponent(new TitleComponent('Nueva Categor&iacute;a'));

$form = new DAOFormComponent(new CategoriaContacto());
$form->hideField(array(
	'id'
));
$form->makeObligatory(array(
	'nombre'
));
$form->setType('descripcion', 'textarea');
$form->setType('activa', 'bool');
$form->setCaption('id_padre', 'Categoria padre');

$categorias = ContactosController::BuscarCategoria();
$categorias = $categorias['categorias'];
foreach ($categorias as $key => $categoria) {
	$categoria->caption = $categoria->nombre_completo;
	$categorias[$key] = $categoria->asArray();
}
$form->createComboBoxJoin(
	'id_padre',
	'nombre_completo',
	$categorias
);

$form->addApiCall('api/contactos/categoria/nuevo', 'POST');
$form->onApiCallSuccessRedirect("contactos.categorias.php");
$page->addComponent($form);

$page->addComponent('<div><a href="contactos.categorias.php">Descartar</a></div>');

$page->render();