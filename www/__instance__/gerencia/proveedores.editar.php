<?php

define("BYPASS_INSTANCE_CHECK", false);
require_once("../../../server/bootstrap.php");

$page = new GerenciaComponentPage();
$page->requireParam("pid", "GET", "Este proveedor no existe.");
$este_proveedor = UsuarioDAO::getByPK($_GET["pid"]);
$esta_direccion = DireccionDAO::getByPK($este_proveedor->getIdDireccion());

$page->addComponent(new TitleComponent("Editar proveedor: ".$este_proveedor->getNombre()));

//forma de nuevo cliente
if(is_null($esta_direccion))
	$esta_direccion = new Direccion();

$form = new DAOFormComponent(array($este_proveedor, $esta_direccion));

$form->hideField(array(
	"id_usuario",
	"id_direccion",
	"id_direccion_alterna",
	"id_rol",
	"id_sucursal",
	"id_clasificacion_cliente",
	"fecha_asignacion_rol",
	"comision_ventas",
	"fecha_alta",
	"fecha_baja",
	"last_login",
	"salario",
	"id_direccion",
	"ultima_modificacion",
	"id_usuario_ultima_modificacion",
	"consignatario",
	"intereses_moratorios",
	"mensajeria",
	"cuenta_de_mensajeria",
	"denominacion_comercial",
	"facturar_a_terceros",
	"dia_de_revision",
	"dia_de_pago",
	"ventas_a_credito",
	"saldo_del_ejercicio",
	"codigo_usuario",
	"id_clasificacion_proveedor"
));

$form->createComboBoxJoin(
	"id_moneda",
	"nombre",
	MonedaDAO::search(new Moneda(array("activa" => 1))),
	$este_proveedor->getIdMoneda()
);

$clasificaciones = ContactosController::BuscarCategoria();
$clasificaciones = $clasificaciones['categorias'];
foreach ($clasificaciones as $key => $clasificacion) {
	$clasificacion->caption = $clasificacion->nombre;
	$clasificaciones[$key] = $clasificacion->asArray();
}
$form->createComboBoxJoin(
	'id_categoria_contacto',
	'nombre',
	$clasificaciones
);

$form->createComboBoxJoin(
	"id_ciudad",
	"nombre",
	CiudadDAO::getAll(),
	$esta_direccion->getIdCiudad()
);

$form->renameField(array(
	"nombre" => "razon_social",
	"telefono" => "telefono1",
	"correo_electronico" => "email",
	"id_categoria_contacto" => "id_tipo_proveedor",
	"pagina_web" => "direccion_web",
	"referencia" => "texto_extra",
	"id_usuario" => "id_proveedor"
));

$form->setValueField("password", "");

$form->addApiCall("api/proveedor/editar/" , "GET");
$form->onApiCallSuccessRedirect("proveedores.lista.php");
$form->sendHidden("id_proveedor");
$page->addComponent($form);
$page->render();
