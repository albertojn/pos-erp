<?php 

require_once('../../../server/bootstrap.php');

$page = new GerenciaComponentPage();
$page->addComponent(new TitleComponent('Nueva Categor&iacute;a'));

$form = new DAOFormComponent(new ClasificacionProducto());
$form->hideField(array(
	'id_clasificacion_producto'
));
$form->makeObligatory(array(
	'nombre'
));
$form->setType('descripcion', 'textarea');
$form->setType('activa', 'bool');
$form->setCaption('id_categoria_padre', 'Categoria Padre');

$categorias = ProductosController::BuscarCategoria();
$categorias = $categorias['categorias'];
foreach ($categorias as $key => $categoria) {
	$categoria->caption = $categoria->nombre_completo;
	$categoria->id = $categoria->id_clasificacion_producto;
	$categorias[$key] = $categoria->asArray();
}
$form->createComboBoxJoin(
	'id_categoria_padre',
	'nombre_completo',
	$categorias
);

$form->addApiCall('api/producto/categoria/nueva', 'POST');
$form->onApiCallSuccessRedirect("productos.categoria.lista.php");
$page->addComponent($form);

$page->addComponent('<div><a href="productos.categoria.lista.php">Descartar</a></div>');

$page->render();