<?php

define("BYPASS_INSTANCE_CHECK", false);

require_once("../../../server//bootstrap.php");

$page = new GerenciaTabPage( );

if (isset($_GET["id_cliente"])) {
	$este_usuario = UsuarioDAO::getByPK($_GET["id_cliente"]);
} else if (isset($_GET["cid"])) {
	$este_usuario = UsuarioDAO::getByPK($_GET["cid"]);
}


if (is_null($este_usuario)) {
	die("Este cliente no existe.");
}




//
// Titulo de la pagina
//
$page->addComponent(new TitleComponent(utf8_decode($este_usuario->getNombre()), 2));


$page->nextTab("Panorama");




//buscar sus ventas
$ventas = VentaDAO::search(new Venta(array("id_comprador_venta" => $este_usuario->getIdUsuario())));
$servicios = OrdenDeServicioDAO::search(new OrdenDeServicio(array("id_usuario_venta" => $este_usuario->getIdUsuario())));
$seguimientos = ClienteSeguimientoDAO::search(new ClienteSeguimiento(array("id_cliente" => $este_usuario->getIdUsuario())));
$seguimientos_a_ordenes = array();

//seguimientos a ordenes
for ($os = 0; $os < sizeof($servicios); $os++) {
	$r = SeguimientoDeServicioDAO::search(new SeguimientoDeServicio(array("id_orden_de_servicio" => $servicios[$os]->getIdOrdenDeServicio())));
	$seguimientos_a_ordenes = array_merge($seguimientos_a_ordenes, $r);
}

$eventos = array_merge($ventas, $servicios, $seguimientos, $seguimientos_a_ordenes);

function orderByDate($eventObjA, $eventObjB) {


	$a = $eventObjA["fecha"];
	$b = $eventObjB["fecha"];

	if ($a == $b) {
		return 0;
	}

	return ($a < $b) ? 1 : -1;
}


function renderRow($unixTime, $fullArray) {

	$out = "";

	switch ($fullArray["tipo"]) {

		case "SeguimientoDeServicio":
			$ods = OrdenDeServicioDAO::getByPK($fullArray["id_orden_de_servicio"]);
			$s = ServicioDAO::getByPK($ods->getIdServicio());

			$out .= '<strong> Seguimiento De Orden ' . $s->getNombreServicio() . ' ' . $fullArray["id_orden_de_servicio"] . ' </strong>';
			$out .= $fullArray["estado"];

			$u = $fullArray["id_usuario"];
			break;

		case "ClienteSeguimiento":
			$out .= '<strong> Seguimiento </strong>';
			$out .= $fullArray["texto"];
			$u = $fullArray["id_usuario"];

			break;

		case "OrdenDeServicio":
			$ods = OrdenDeServicioDAO::getByPK($fullArray["id_orden_de_servicio"]);
			$s = ServicioDAO::getByPK($ods->getIdServicio());

			$out .= '<strong>Nueva Orden de Servicio</strong> ' . $s->getNombreServicio() . ' ' . $fullArray["id_orden_de_servicio"] . ' ';
			$out .= $fullArray["descripcion"];
			$u = $fullArray["id_usuario"];
			break;


		case "Venta":
			if ($fullArray["cancelada"]) {
				$out .= '<strong><strike>Venta Cancelada ' . $fullArray["id_venta"] . '</strike></strong>';
			} else {
				$out .= '<strong>Venta ' . $fullArray["id_venta"] . '</strong>';
			}

			$out .= '&nbsp;' . FormatMoney($fullArray["total"]) . ' ' . $fullArray["tipo_de_venta"];
			$u = $fullArray["id_usuario"];
			break;


		case "Cotizacion":
			$out .= '<strong>Venta ' . $fullArray["id_venta"] . '</strong>';
			$u = $fullArray["id_usuario"];
			break;
	}

	//return json_encode( $fullVo );
	$u = UsuarioDAO::getByPK($u)->getNombre();

	$out .= '<br><div style="text-align: right; font-size:10px; color:gray">' . FormatTime($fullArray["fecha"]) . ' por ' . $u . "</div>";
	return $out;
}

for ($ei = 0; $ei < sizeof($eventos); $ei++) {
	if ($eventos[$ei] instanceof SeguimientoDeServicio) {
		$eventos[$ei] = $eventos[$ei]->asArray();
		$eventos[$ei]["tipo"] = "SeguimientoDeServicio";
		$eventos[$ei]["fecha"] = $eventos[$ei]["fecha_seguimiento"];
		unset($eventos[$ei]["fecha_seguimiento"]);
	} elseif ($eventos[$ei] instanceof ClienteSeguimiento) {
		$eventos[$ei] = $eventos[$ei]->asArray();
		$eventos[$ei]["tipo"] = "ClienteSeguimiento";
	} elseif ($eventos[$ei] instanceof OrdenDeServicio) {
		$eventos[$ei] = $eventos[$ei]->asArray();
		$eventos[$ei]["tipo"] = "OrdenDeServicio";
		$eventos[$ei]["fecha"] = $eventos[$ei]["fecha_orden"];
		unset($eventos[$ei]["fecha_orden"]);
	} elseif ($eventos[$ei] instanceof Venta) {
		$eventos[$ei] = $eventos[$ei]->asArray();

		if ($eventos[$ei]["es_cotizacion"]) {
			$eventos[$ei]["tipo"] = "Cotizacion";
		} else {
			$eventos[$ei]["tipo"] = "Venta";
		}
	}
}

usort($eventos, "orderByDate");

$header = array("fecha" => "Actividad de " . $este_usuario->getNombre());

$tabla = new TableComponent($header, $eventos);
$tabla->addColRender("fecha", "renderRow");
$page->addComponent($tabla);




$page->nextTab("General");

//
// Menu de opciones
//
if ($este_usuario->getActivo()) {

	$menu = new MenuComponent();

	$menu->addItem("Editar", "clientes.editar.php?cid=" . $este_usuario->getIdUsuario());
	$menu->addItem("Desactivar", "clientes.desactivar.php?cid=" . $este_usuario->getIdUsuario());
	$page->addComponent($menu);
} else {

	$menu = new MenuComponent();

	$menu->addItem("Reactivar", "clientes.desactivar.php?cid=" . $este_usuario->getIdUsuario());
	$page->addComponent($menu);
}


//
// Forma de producto
//

$t = TarifaDAO::getByPK($este_usuario->getIdTarifaVenta());
if (is_null($t)) {
	$este_usuario->setIdTarifaVenta("-----");
} else {
	$este_usuario->setIdTarifaVenta($t->getNombre());
}


$form = new DAOFormComponent($este_usuario);

$form->setEditable(false);

$form->hideField(array(
	"id_usuario",
	"id_rol",
	"id_clasificacion_proveedor",
	"id_direccion",
	"id_direccion_alterna",
	"fecha_asignacion_rol",
	"comision_ventas",
	"fecha_alta",
	"fecha_baja",
	"activo",
	"last_login",
	"salario",
	"dias_de_embarque",
	"consignatario",
	"tiempo_entrega",
	"cuenta_bancaria",
	"mensajeria",
	"token_recuperacion_pass",
	"ventas_a_credito",
	"dia_de_pago",
	"dia_de_revision",
	"password",
	"id_sucursal",
	"id_clasificacion_cliente"
));

$response = ContactosController::DetallesCategoria($este_usuario->getIdCategoriaContacto());
if (!is_null($response['categoria'])) {
	$form->setValueField('id_categoria_contacto', $response['categoria']->getNombre());
}
$form->setCaption('id_categoria_contacto', 'Categor&iacute;a');

$form->createComboBoxJoin("id_moneda", "nombre", MonedaDAO::getAll(), $este_usuario->getIdMoneda());
$form->createComboBoxJoin("id_sucursal", "razon_social", SucursalDAO::getAll(), $este_usuario->getIdSucursal());

$form->setCaption("id_tarifa_venta", "Tarifa de Venta");
$form->createComboBoxJoin("id_tarifa_compra", "nombre", TarifaDAO::search(new Tarifa(array("id_tarifa" => $este_usuario->getIdTarifaCompra()))));

$page->addComponent($form);




//buscar los parametros extra
$out = ExtraParamsValoresDAO::getVals("usuarios", $este_usuario->getIdUsuario());

$epform = new FormComponent();
$epform->setEditable(false);


foreach ($out as $ep) {
	$epform->addField($ep["campo"], $ep["caption"], $ep["tipo"], $ep["val"]);
	if (!is_null($ep["descripcion"])) {
		$epform->setHelp($ep["campo"], $ep["descripcion"]);
	}
}


$page->addComponent($epform);










$page->nextTab("Direccion");

$menu = new MenuComponent();
$menu->addItem("Editar Direccion", "clientes.editar.direccion.php?cid=" . $este_usuario->getIdUsuario() . "&did=" . $este_usuario->getIdDireccion());
$page->addComponent($menu);



$direccion = $este_usuario->getIdDireccion();
$direccionObj = DireccionDAO::getByPK($direccion);

if (is_null($direccionObj)) {

} else {

	$ciudad = CiudadDAO::getByPK($direccionObj->getIdCiudad());

	if (null === $ciudad) {
		$ciudad = new Ciudad();
	}


	$page->addComponent(new FreeHtmlComponent("<div id=\"map_canvas\"></div>"));
	$page->addComponent(new FreeHtmlComponent("<script>startMap(\""
					. $direccionObj->getCalle()
					. " "
					. $direccionObj->getNumeroExterior()
					. ", "
					. $direccionObj->getColonia()
					. ", "
					. $ciudad->getNombre()
					. "\");</Script>"));
}





if (!is_null($direccionObj)) {
	$usr_ultima = UsuarioDAO::getByPK($direccionObj->getIdUsuarioUltimaModificacion());

	if (!is_null($usr_ultima))
		$direccionObj->setIdUsuarioUltimaModificacion($usr_ultima->getNombre());

	$dform = new DAOFormComponent($direccionObj);
	$dform->setEditable(false);
	$dform->hideField(array(
		"id_direccion",
		"id_usuario_ultima_modificacion",
		"ultima_modificacion"
	));
	$dform->createComboBoxJoin("id_ciudad", "nombre", CiudadDAO::getAll(), $direccionObj->getIdCiudad());
	$page->addComponent($dform);
}





/* * *******************************************************
 * 	Avales
 *
 * ******************************************************** */
$page->nextTab("Avales");

$page->addComponent(new TitleComponent("Nuevo Aval", 3));

$clientes_component = new ClienteSelectorComponent();

$clientes_component->addJsCallback("( function(record){ Ext.get('add_aval').setStyle({'display':'block'}); id_usuario = record.get('id_usuario'); nombre = record.get('nombre'); id_este_usuario = " . $este_usuario->getIdUsuario() . "; if(id_usuario == id_este_usuario){ Ext.core.Element.fly(\"agregar_aval_btn\").setVisible(false); Ext.get(\"nombre_aval_a_agregar\").update('No se puede ser aval de si mismo');}else{ Ext.core.Element.fly(\"agregar_aval_btn\").setVisible(true); Ext.get(\"nombre_aval_a_agregar\").update('Nuevo Aval: '+record.get('nombre'));}  } )");

$page->addComponent($clientes_component);

$page->addComponent(new FreeHtmlComponent("<div id= \"nombre_aval_a_agregar\" style =\"display:block; font-size=14; font-weight:bold;\" ></div>"));

$page->addComponent(new FreeHtmlComponent("<br><div id = \"add_aval\" style = \"display:none;\" ><form name = \"tipo_aval\" id = \"tipo_aval\"> <input id = \"radio_hipoteca\" type='Radio' name='taval' value='hipoteca' checked> hipoteca <input id = \"radio_prendario\"type='Radio' name='taval' value='prendario'> prendario</form> <br> <div id=\"agregar_aval_btn\" class='POS Boton' onClick = \"nuevoClienteAval(nombre, id_usuario, id_este_usuario)\" >Agregar como aval</div></div>"));

$page->addComponent(new TitleComponent("Lista de Avales", 3));

$avales = ClienteAvalDAO::search(new ClienteAval(array("id_cliente" => $este_usuario->getIdUsuario())));

$array_avales = array();

foreach ($avales as $aval) {
	array_push($array_avales, $aval->asArray());
}

$tabla_avales = new TableComponent(
				array(
					"id_aval" => "Nombre",
					"tipo_aval" => "Tipo de Aval"
				),
				$array_avales
);

function funcion_nombre_aval($id_usuario) {
	return (UsuarioDAO::getByPK($id_usuario)->getNombre());
}

$tabla_avales->addColRender("id_aval", "funcion_nombre_aval");

$page->addComponent($tabla_avales);





/* * *******************************************************
 * 	Seguimientos
 *
 * ******************************************************** */
$page->nextTab("Seguimiento");

$segs = ClienteSeguimientoDAO::search(new ClienteSeguimiento(array(
					"id_cliente" => $este_usuario->getIdUsuario()
				)));

$header = array(
	"texto" => "Descripcion",
	"fecha" => "Fecha",
	"id_usuario" => "Agente"
);

$lseguimientos = new TableComponent($header, $segs);
$lseguimientos->addColRender("id_usuario", "R::UserFullNameFromId");
$lseguimientos->addColRender("fecha", "R::FriendlyDateFromUnixTime");
$page->addComponent($lseguimientos);


$page->addComponent("<script>
			function newcommentDone(a,b,c){
				location.reload();
			}
		</script>");

$nseguimiento = new DAOFormComponent(new ClienteSeguimiento(array("id_cliente" => $este_usuario->getIdUsuario())));
$nseguimiento->onApiCallSuccess("newcommentDone");
$nseguimiento->addApiCall("api/cliente/seguimiento/nuevo");
$nseguimiento->settype("texto", "textarea");
$nseguimiento->hideField(array(
	"id_usuario",
	"id_cliente",
	"id_cliente_seguimiento",
	"fecha"
));
$nseguimiento->sendHidden("id_cliente");
$page->addComponent($nseguimiento);


/*
 * *************************************
 *                                     *
 *               VENTAS                *
 *                                     *
 * *************************************
 */

$page->nextTab("Ventas");

//ventas de contado

$ventas = VentasController::Lista($canceladas = null, $id_cliente = $este_usuario->getIdUsuario());

$ventas = json_decode($ventas["ventas"]);

$ventas_contado = array();
$ventas_credito = array();

foreach ($ventas as $venta) {

	if ($venta->tipo_de_venta === "credito") {
		array_push($ventas_credito, get_object_vars($venta));
	}

	if ($venta->tipo_de_venta === "contado") {
		array_push($ventas_contado, get_object_vars($venta));
	}
}

$tabla_contado = new TableComponent(
				array(
					"tipo_de_venta" => "<b>Tipo</b>",
					"subtotal" => "<b>Subtotal</b>",
					"descuento" => "<b>Descuento</b>",
					"impuesto" => "<b>Impuestos</b>",
					"total" => "<b>Total</b>",
					"saldo" => "<b>Saldo</b>",
					"fecha" => "<b>Fecha</b>"
				),
				$ventas_contado
);

$tabla_contado->addColRender("fecha", "FormatTime");
$tabla_contado->addOnClick("id_venta", "(function(a){ window.location = 'ventas.detalle.php?vid=' + a; })");
$page->addComponent(new TitleComponent("Contado"));
$page->addComponent($tabla_contado);

function warning($saldo){
	return $saldo > 0 ? "<font style = \"color:red;\">{$saldo}</font>":"{$saldo}";
}

$tabla_credito = new TableComponent(
				array(
					"tipo_de_venta" => "<b>Tipo</b>",
					"subtotal" => "<b>Subtotal</b>",
					"descuento" => "<b>Descuento</b>",
					"impuesto" => "<b>Impuestos</b>",
					"total" => "<b>Total</b>",
					"saldo" => "<b>Saldo</b>",
					"fecha" => "<b>Fecha</b>"
				),
				$ventas_credito
);

$tabla_credito->addColRender("fecha", "FormatTime");
$tabla_credito->addColRender("saldo", "warning");
$tabla_credito->addOnClick("id_venta", "(function(a){ window.location = 'ventas.detalle.php?vid=' + a; })");
$page->addComponent(new TitleComponent("Credito"));
$page->addComponent($tabla_credito);


$page->render();
