<?php 

    define("BYPASS_INSTANCE_CHECK", false);

    require_once("../../../server/bootstrap.php");

    $page = new GerenciaComponentPage();

    $page->addComponent(new TitleComponent("Empresas"));

    $lista_empresas = EmpresasController::Buscar($activa = false, $limit = null, $order = "DESC", $order_by = "id_empresa", $query = null, $start = null);

    $tabla = new TableComponent(array(
    	"id_empresa" => "Id",
        "razon_social"=> "Razon Social",
        "rfc"=> "RFC",
        "fecha_alta" => "Fecha Alta",
        "activo"=> "Activa"
        ),
        $lista_empresas["resultados"]
    );

    $tabla->addColRender("activo", "funcion_activa");
    $tabla->addColRender("fecha_alta", "FormatTime");

    $tabla->addOnClick("id_empresa", "(function(a){window.location = 'empresas.ver.php?eid='+a;})");

    $tabla->addNoData("No hay ninguna empresa registrada. <a href='empresas.nuevo.php'>&iquest; Tal vez desee crear una ahora ?</a>");

    $page->addComponent($tabla);

    $page->render();
