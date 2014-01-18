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
$form->hideField(array(
	'id_clasificacion_producto'
));
$form->sendHidden('id_clasificacion_producto');


$form->setValueField('nombre', $categoria->getNombre());
$form->setValueField('descripcion', $categoria->getDescripcion());
// $response = ProductosController::DetallesCategoria($categoria->getIdPadre());
// if (!is_null($response['categoria'])){
// 	$form->setValueField('id_categoria_padre', $response['categoria']->getNombre());
// }

$form->setType('descripcion', 'textarea');
$form->setType('activa', 'bool');
$form->setCaption('id_categoria_padre', 'Categor&iacute;a Padre');

$categorias = ProductosController::BuscarCategoria();
$categorias = $categorias['categorias'];
foreach ($categorias as $key => $cat) {
	$cat->caption = $cat->nombre_completo;
	$cat->id = $cat->getIdClasificacionProducto();
	$categorias[$key] = $cat->asArray();
}
$form->createComboBoxJoin(
	'id_categoria_padre',
	'nombre_completo',
	$categorias,
	$categoria->getIdCategoriaPadre()
);
$form->addApiCall('api/producto/categoria/editar', 'POST');
$form->onApiCallSuccessRedirect("productos.categoria.lista.php");

$page->addComponent(new TitleComponent($categoria->nombre_completo));
$page->addComponent($form);
$page->addComponent('<div><a href="productos.categoria.lista.php">Descartar</a></div>');
$page->render();