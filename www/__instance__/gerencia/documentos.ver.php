<?php

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");

	if( isset($_GET["preview"]) && isset($_GET["d"]) ) {
		ImpresionesController::Documento($_GET["d"], true);
		exit;
	}

	$documento = DocumentoDAO::getByPK( $_GET["d"] );
	$documentoBase = DocumentoBaseDAO::getByPK( $documento->getIdDocumentoBase( ) );
	$values = DocumentoDAO::getDocumentWithValues( $_GET["d"] );

	$page = new GerenciaTabPage();

	$page->addComponent('<link rel="stylesheet" type="text/css" href="/pos/css/markdown.css" />
        <script type="text/javascript" src="/pos/js/Markdown.Converter.js"></script>
        <script type="text/javascript" src="/pos/js/Markdown.Sanitizer.js"></script>
        <script type="text/javascript" src="/pos/js/Markdown.Editor.js"></script>');

	$page->addComponent(new TitleComponent( $documentoBase->getNombre( ) , 3 ) );
	$page->addComponent(new TitleComponent( R::NombreDocumentoFromId( $_GET["d"] ) ) );



	//
	// $page->addComponent( 
	//		"<div class='POS Boton' onClick='window.location=\"documentos.editar.php?d=". $_GET["d"] ."\"'>Editar</div> " );
	// $page->addComponent( "<div class='POS Boton' onClick='window.location=\"documentos.ver.php?preview=1&d=". $_GET["d"] ."\"'>Vista previa</div> " );
	//
	//

	/**
	  *
	  *
	  **/
	$page->nextTab("Doc");
	$f = new FormComponent( );
	for( $i = 0 ; $i < sizeof( $values ); $i++ ) {

		if ($values[$i]["tipo"] == "enum") {

			$enum_string = explode( ",", $values[$i]["enum"]);
			$enum_array = array();

			for ($k = 0; $k < count($enum_string); $k++ ) {
				array_push( $enum_array, array(
					"caption"	=> $enum_string[$k],
					"id"		=> $enum_string[$k],
					"selected"	=> 0
				));
			}

			$f->addField(
				$values[$i]["campo"],
				$values[$i]["caption"],
				$values[$i]["tipo"],
				$enum_array);

		}else{
			$f->addField(
				$values[$i]["campo"],
				$values[$i]["caption"],
				$values[$i]["tipo"],
				$values[$i]["val"]
			/*	'<script>var converter = new Markdown.Converter();
					document.write(converter.makeHtml("'  .
							utf8_decode( 
							str_replace("\"", "\\\"",
								str_replace("\n", "<br>", $values[$i]["val"])
							)
						). '"));</script>'
			*/
			);
		}
	}
	$f->setEditable(false);
	$f->setStyle("big");
	$page->addComponent( $f );

	/** 
	  *
	  *
	  **/
	$page->nextTab("Editar");	
	$f = new FormComponent( );
	for( $i = 0 ; $i < sizeof( $values ); $i++ ) {
		$f->addField(
				$values[$i]["campo"],
				$values[$i]["caption"],
				$values[$i]["tipo"],
				utf8_decode($values[$i]["val"]) );
	}
	$f->setEditable(true);
	$f->setStyle("big");
	$f->addApiCall("api/documento/editar", "POST");
	$f->beforeSend("attachExtraParams");
	
	
	$html = " <script>
			function attachExtraParams( a ) {
				a.id_documento = " . $documento->getIdDocumento( ). ";
				a.extra_params = Ext.JSON.encode({ ";

	for( $i = 0 ; $i < sizeof( $values ); $i++ ) {
		$html .= $values[$i]["campo"] .  " : Ext.get(\"".  $f->getGuiComponentId() . $values[$i]["campo"]  ."\" ).getValue() , ";
	}
	
	$html .= "});
				return a;
			}
		</script>";

	$page->addComponent($html);
	$page->addComponent( $f );



	/** 
	  *
	  *
	  **/
	$page->nextTab("Compartir");




	/** 
	  *
	  *
	  **/
	$page->nextTab("VistaPrevia");
                        $DescargaExcel="<input type='button'  class='POS Boton' onclick=\"location.href='../api/formas/excel/generar2?id_documento=" .  $_GET["d"] . "'\" value='Descargar como excel'></input>";//Botón de descarga de excel
                        $page->addComponent($DescargaExcel);


    $html = '<iframe src="../api/documento/imprimir?id_documento='.$_GET["d"].'" scrolling="auto" height="500" width="650" ></iframe>';
    $page->addComponent($html);

	/*
	$page->addComponent(new TitleComponent("Editar", 3));


	$q = DocumentoBaseDAO::getByPK( $_GET["d"] );

	$q->setJsonImpresion( str_replace ( "\\n" , "" , $q->getJsonImpresion() ) );
	$q->setJsonImpresion( str_replace ( "\\t" , "" , $q->getJsonImpresion() ) );
	$q->setJsonImpresion( stripslashes($q->getJsonImpresion())  );
	

	if( "\""  == substr ( $q->getJsonImpresion() , 0 , 1 ) ){
		$q->setJsonImpresion(  substr($q->getJsonImpresion(), 1 , -1) );	
	}

	$tabla = new DAOFormComponent( $q );
	$tabla->setEditable(true);
	$tabla->renameField(array("id_documento_base" => "id_documento"));

	$tabla->hideField(array(
			"id_documento",
			"ultima_modificacion",

		));
	$tabla->sendHidden("id_documento");
	$tabla->setType("json_impresion", "textarea");

	$tabla->addApiCall("api/documento/editar", "POST");
	$tabla->onApiCallSuccessRedirect("documentos.ver.php?d=" . $_GET["d"]);

	$page->addComponent($tabla);

	*/


	
/*		$page->addComponent('<embed src="/file.pdf#toolbar=0&navpanes=0&scrollbar=0" width="500" height="375"></embed>');
	$page->addComponent('<embed src="documentos.ver.php?dbid='. $_GET["dbid"] .'&preview=1#toolbar=0&navpanes=0&scrollbar=0" width="500" height="375"></embed>');
*/
	$page->render();
