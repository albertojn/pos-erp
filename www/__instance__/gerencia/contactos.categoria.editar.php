<?php

require_once('../../../server/bootstrap.php');

$page = new GerenciaComponentPage();
$page->requireParam("id", "GET", "Esta categor&iacute;a no existe.");

// si no existe la categoria
$response = ContactosController::DetallesCategoria($_GET['id']);
if (is_null($response['categoria'])) {
	print("XD"); // temp
}
$categoria = $response['categoria'];

// detalles
$form = new DAOFormComponent($categoria);
$form->hideField(array(
	'id'
));
$form->sendHidden('id');

// si no hago esto y hay acentos no los pone
$form->setValueField('nombre', $categoria->getNombre());
$form->setValueField('descripcion', $categoria->getDescripcion());
// $response = ContactosController::DetallesCategoria($categoria->getIdPadre());
// if (!is_null($response['categoria'])){
// 	$form->setValueField('id_padre', $response['categoria']->getNombre());
// }

$form->setType('descripcion', 'textarea');
$form->setType('activa', 'bool');
$form->setCaption('id_padre', 'Categor&iacute;a Padre');

$categorias = ContactosController::BuscarCategoria();
$categorias = $categorias['categorias'];
foreach ($categorias as $key => $cat) {
	$cat->caption = $cat->nombre_completo;
	$categorias[$key] = $cat->asArray();
}
$form->createComboBoxJoin(
	'id_padre',
	'nombre_completo',
	$categorias,
	$categoria->getIdPadre()
);

$form->addApiCall('api/contactos/categoria/editar', 'POST');
$form->onApiCallSuccessRedirect("contactos.categorias.php");

$page->addComponent(new TitleComponent($categoria->nombre_completo));
$page->addComponent($form);
$page->addComponent('<div><a href="contactos.categorias.php">Descartar</a></div>');
$page->render();