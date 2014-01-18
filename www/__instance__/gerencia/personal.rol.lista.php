<?php 

    define("BYPASS_INSTANCE_CHECK", false);

    require_once("../../../server/bootstrap.php");

    $page = new GerenciaComponentPage();
	
	$menu = new MenuComponent();
	$menu->addItem("Nuevo", "personal.rol.nuevo.php");
	$page->addComponent( $menu );

    $page->addComponent( new TitleComponent( "Roles" ) );
	$page->addComponent( new MessageComponent( "Lista de roles de usuario" ) );

	$roles = PersonalYAgentesController::ListaRol();

	$tabla = new TableComponent( 
		array(
		"nombre" => "Nombre",
		"descripcion"	=> "Descripcion",
		"salario" 			=> "Salario"
		),
		$roles["resultados"]
	);

	$tabla->addOnClick( "id_rol", "(function(a){window.location = 'personal.rol.ver.php?rid=' + a;})" );
	$page->addComponent( $tabla );

    $page->render();
