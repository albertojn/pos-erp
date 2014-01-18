<?php 

require_once('../../../server/bootstrap.php');

$page = new GerenciaComponentPage();
$page->requireParam("id", "GET", "Esta categor&iacute;a no existe.");

// si no existe la categoria
$response = ProductosController::DetallesCategoria($_GET['id']);
if (is_null($response['categoria'])) {
	print("XD"); // temp
}
$categoria = $response['categoria'];

// detalles
$form = new DAOFormComponent($categoria);
$form->setEditable(false);
$form->setValueField('nombre', $categoria->getNombre());
$form->setValueField('descripcion', $categoria->getDescripcion());
$form->setValueField('activa', $categoria->getActiva() ? 'S&iacute;' : 'No');
$form->setCaption('id_categoria_padre', 'Categor&iacute;a Padre');
$form->hideField(array(
	'id_clasificacion_producto'
));
// mostrar el nombre del padre si tiene
$response = ProductosController::DetallesCategoria($categoria->getIdCategoriaPadre());
if (!is_null($response['categoria'])){
	$form->setValueField('id_categoria_padre', $response['categoria']->getNombre());
}

$page->addComponent(new TitleComponent($categoria->nombre_completo));
$page->addComponent("<div class='POS Boton' onClick='window.location=\"productos.categoria.editar.php?id=".$categoria->getIdClasificacionProducto()."\"'>Editar</div>");
$page->addComponent("<div class='POS Boton' onClick='window.location=\"productos.categoria.nueva.php\"'>Crear</div>");
$page->addComponent($form);
$page->render();