<?php

 require_once("../../../server/bootstrap.php");
 $plantilla=null;
                        $W="";
                        if(sizeof($_FILES)>0)//Si se carga al menos 1 archivo
                        {
                              $W.="<script>";
                              $Do=1;
                              $rutaPlantillaTemp=$_FILES["Plantilla"]["tmp_name"];
                              $nombrePlantilla=$_FILES["Plantilla"]["name"];
                              $nuevaRutaPlantilla= POS_PATH_TO_SERVER_ROOT . "/../static_content/" . IID . "/plantillas/excel/" . $nombrePlantilla;


                              if ($_FILES["Plantilla"]["size"]<=(((int)$POS_CONFIG["TAM_MAX_PLANTILLAS"])*1024*1024))//Limite de tamaño
                              { $Do*=1;}else{$Do*=0;
                                    $W.="Ext.MessageBox.show({title:\"Error\",msg:\"Tamaño del archivo supera el límite\",buttons : Ext.MessageBox.OK});";
                              }
                              if (substr($_FILES["Plantilla"]["name"],(strlen($_FILES["Plantilla"]["name"])-5),5)==".xlsx")//Tipo de archivo
                              { $Do*=1;}else{$Do*=0;
                                    $W.="Ext.MessageBox.show({title:\"Error\",msg:\"Formato de plantilla inválido\",buttons : Ext.MessageBox.OK});";
                              }
                              if(file_exists(POS_PATH_TO_SERVER_ROOT . "/../static_content/" . IID . "/plantillas/excel/" ))
                              { $Do*=1;}else{$Do*=0;
                                    $W.="Ext.MessageBox.show({title:\"Error\",msg:\"No existe una carpeta para las plantillas\",buttons : Ext.MessageBox.OK});";
                              }
                              
                              if($Do==1)
                              {
                                    if(move_uploaded_file($rutaPlantillaTemp, $nuevaRutaPlantilla)){
                                    chmod($nuevaRutaPlantilla,0777);//Se cambian los permisos del archivo

                                    $W.="
                                    POS.API.POST(\"api/formas/excel/leerpalabrasclave\",
                                    {
                                       \"archivo_plantilla\":\"". $nuevaRutaPlantilla . "\"
                                    },
                                    {
                                       callback:function(a)
                                       {
                                           InsertarFila(a[\"resultados\"]);
                                           document.getElementsByName(\"nombre_plantilla\")[0].value=\"" . $nombrePlantilla . "\";
                                           document.getElementsByName(\"json_impresion\")[0].value=\"{}\";
                                       }
                                    })
                                    ";
                                    $plantilla=$nombrePlantilla;//Asigna el nombre de la plantilla a la variable de trabajo
                              }}
                              $W.="</script>";
                        }
                       
	 $page = new GerenciaTabPage();
	
                       $page->addComponent(new TitleComponent("Documentos"));

	$page->nextTab("Documentos");
	$page->addComponent(new TitleComponent("Documentos", 3));
	//buscar un documento
	$documentos_base = DocumentoDAO::getAll( NULL, NULL, "fecha", 'DESC' );

	$header = array(
			"id_documento"=> "Nombre",
			"id_documento_base" => "Tipo de documento",
			"fecha"=> "Modificacion"
		);
	
	$tableDb = new TableComponent( $header, $documentos_base  );
	$tableDb->addColRender("fecha", "R::FriendlyDateFromUnixTime");
	$tableDb->addColRender("id_documento_base", "R::NombreDocumentoBaseFromId");
	$tableDb->addColRender("id_documento", "R::NombreDocumentoFromId");
	$tableDb->addOnClick( "id_documento", "(function(a){ window.location  = 'documentos.ver.php?d=' + a;  })"  );
	$page->addComponent( $tableDb );

	/**
	  *
	  *
	  *
	  **/
	$page->nextTab("Nuevo");

	$page->addComponent(new TitleComponent("Nueva instancia de documento", 3));

	//buscar un documento
	$documentos_base = DocumentoBaseDAO::getAll();
          
	$header = array(
			"nombre"				=> "Nombre",
			"ultima_modificacion" => "Ultima modificacion"
		);
	
	$tableDb = new TableComponent( $header, $documentos_base  );
	$tableDb->addColRender("ultima_modificacion", "R::FriendlyDateFromUnixTime");
	$tableDb->addOnClick( "id_documento_base", "(function(a){ window.location  = 'documentos.nuevo.instancia.php?base=' + a;  })"  );
	$page->addComponent( $tableDb );


	/**
	  *
	  *
	  *
	  **/
	$page->nextTab("Base");
	$page->addComponent(new TitleComponent( "Nuevo documento base", 3));

	$f = new DAOFormComponent(  new DocumentoBase( ) );
	$f->addApiCall("api/documento/base/nuevo", "POST");
	$f->beforeSend("attachExtraParams");
	$f->hideField(array(
			"id_documento_base",
			"ultima_modificacion",
			"id_sucursal",
			"id_empresa",
			"activo"
		));
       
	$f->setType("json_impresion", "textarea");
	$page->addComponent($f);
                        $page->addComponent(new TitleComponent("Cargar plantilla Excel (<" . $POS_CONFIG["TAM_MAX_PLANTILLAS"] . "MB)", 4));
                        $CmdSubirArchivo="<p>\n";
                        $CmdSubirArchivo.="<form action=\"documentos.php#Base\" method=\"post\" enctype=\"multipart/form-data\">\n";
                        $CmdSubirArchivo.="<input type=\"file\" name=\"Plantilla\" size=\"50\"  class=\"POS Boton\" id=\"subArch\" accept=\"xlsx\"\n";
                        $CmdSubirArchivo.="<br><br><p>\n";
                        $CmdSubirArchivo.="<input type=\"submit\" value=\"Subir plantilla\"></p>\n";
                        $CmdSubirArchivo.="</form>\n";
                        $CmdSubirArchivo.="</p>\n";
                        
                        $page->addComponent($CmdSubirArchivo);
                        
                       
   $page->addComponent(new TitleComponent("Campos para el documento", 3));

    $html = "<div id='editor-grid' style='margin-top: 5px'></div>

	<script type='text/javascript' charset='utf-8'>
	var extraParamsStore;
	var rowEditing;
	var comboBoxEnums = [];

	function attachExtraParams(o) {
		o.extra_params = getParams();
		return o;
	}

	function getParams() {
		var c = extraParamsStore.getCount(),
		out = [];
		for (var i=0; i < c; i++) {
			var o = extraParamsStore.getAt(i);
			out.push({
					desc : o.get('desc'),
					type : o.get('type'),
					obligatory : o.get('obligatory'),
					enum : o.get('enum_list')
			});
		};
		return Ext.JSON.encode(out);
	}

	var win;
	var enumsWindow;

	function showEnumWindow(event, record) {
		enumsWindow = Ext.create('Ext.window.Window', {
			title: 'Layout Window with title <em>after</em> tools',
			closable: true,
			closeAction: 'hide',
			modal:  true,
				padding : 5,
			width: 300,
			minWidth: 250,
			items: [
			{
				xtype : 'panel',
				items :[{
					xtype : 'textarea',
					fieldLabel: 'Enums',
					id : 'enums_textarea',
					padding : 5,
					allowBlank: false,
					value : record.get('enum_list')
				},{
					xtype : 'button',
					padding : 5,
					text : 'Guardar',
					handler :  function(a,b,c){
						record.set('enum_list',Ext.getCmp('enums_textarea').getValue() );
						enumsWindow.destroy();
					}
				}]
			}
			]
		}).show();
	}

	Ext.onReady(function(){
		Ext.define('ExtraParam', {
			extend: 'Ext.data.Model',
			fields: [ 
				'id',
				'desc',
				{ name: 'type', type: 'enum' },
				{ name: 'enum_list', type: 'string' },
				{ name: 'obligatory', type: 'bool' }
			]});

			extraParamsStore = Ext.create('Ext.data.Store', {
				  autoDestroy: true,
				  model: 'ExtraParam',
				  proxy: {
						type: 'memory'
				  },
				  data: [],
				  sorters: [{
						property: 'start',
						direction: 'ASC'
				  }],
					listeners : {
						'dataChanged' : function(context, eopts) {
						},
						'update' : function(event, record) {
							var changes = record.getChanges();
							if ((changes.type !== undefined) 
								&& (changes.type == 'enum') ) {
								showEnumWindow(event, record);
							}
						}
					}
			});

			rowEditing = Ext.create('Ext.grid.plugin.RowEditing', { clicksToMoveEditor: 1, autoCancel: false });

			grid = Ext.create('Ext.grid.Panel', {
				  store: extraParamsStore,
				  bodyCls: 'foo',
				  id : 'extra-params-grid',
				  columns: [{
						header: 'Descripcion',
						dataIndex: 'desc',
						flex: 1,
						editor: { allowBlank: false }
				  },
				  {
						header: 'Tipo de dato',
						dataIndex: 'type',
						width: 130,
						field: {
							xtype: 'combobox',
							typeAhead: true,
							triggerAction: 'all',
							selectOnTab: true,
							store: [
								['textarea',		'Area de texto'],
								['text',			'Linea de texto'],
								['date',			'Fecha'],
								['bool',			'Desicion'],
								['password',		'Contrasena'],
								['enum',			'Opciones']
							],
						lazyRender: true,
						listClass: 'x-combo-list-small'
						}
				  },
				  {
						header: 'Obligatorio',
						dataIndex: 'obligatory',
						width: 130,
						field: {
							  xtype: 'combobox',
							  typeAhead: true,
							  triggerAction: 'all',
							  selectOnTab: true,
							  store: [
									[true,	'Si'],
									[false, 'No']
							  ],
							lazyRender: true,
							listClass: 'x-combo-list-small'
						}
				  }],
				  renderTo: 'editor-grid',
				  width: '100%',
				  height: 400,
				  frame: false,
				  tbar: [{
							text: 'Nuevo parametro',
							iconCls: 'not-ok',
							handler : function() {
								rowEditing.cancelEdit();
								var r = Ext.ModelManager.create({
									desc: 'nuevo',
									type: 'text',
									obligator: false
								}, 'ExtraParam');
								extraParamsStore.insert(0, r);
								rowEditing.startEdit(0, 0);
							}
						}, 
						{
							itemId: 'removeEmployee',
							text: 'Remover parametro',
							iconCls: 'ok',
							handler: function() {
								var sm = grid.getSelectionModel();
								rowEditing.cancelEdit();
								extraParamsStore.remove(sm.getSelection());
								sm.select(0);
							},
							disabled: true
						}],
					plugins: [rowEditing],
					listeners: {
						'selectionchange': function(view, records) {
						grid.down('#removeEmployee').setDisabled(!records.length);
					}
				}
			});
		});

	var grid;
	function InsertarFila(Elemento) {
		rowEditing.cancelEdit();

		for (Elem in Elemento) {
			 var r = Ext.ModelManager.create({
						desc: Elemento[Elem],
						type: 'text',
						obligator: false
						}, 'ExtraParam');

			extraParamsStore.insert(Elem, r);
		}
	};
          document.getElementsByName(\"nombre_plantilla\")[0].setAttribute(\"disabled\",\"disabled\");

</script>";
	
    $page->addComponent( $html );
    $page->addComponent($W);//Componente en caso de abrir algún archivo de plantilla
	$page->render();

	die;

		$json = '{
			"margin-top" : 1,
			"margin-bottom" : 1,
			"margin-left" : 1,
			"margin-right" : 1,
			"body" : [
				{
					"type" 		: "text",
					"fontSize" 	: 17,
					"x" 		: 0,
					"y" 		: 15,
					"value" 	: "hola {nombre}"
				},
				{
					"type" 		: "text",
					"fontSize" 	: 18,
					"x" 		: 50,
					"y" 		: 15,
					"value" 	: "hola"
				},				
				{
					"type" 		: "round-box",
					"fontSize" 	: 18,
					"x" 		: 150,
					"y" 		: 650,
					"w"			: 100,
					"h"			: 100
				},
				{
					"type" 		: "text",
					"fontSize" 	: 18,
					"x" 		: 50,
					"y" 		: 150,
					"value" 	: "hola"
				}				
			]
		}';
		$json = '{
			"margin-top" 	: 1,
			"margin-bottom" : 1,
			"margin-left" 	: 1,
			"margin-right" 	: 1,
			"width"  		: 612,
			"height" 		: 492,
			"body" : [
				{
					"type" 		: "text",
					"fontSize" 	: 17,
					"x" 		: 0,
					"y" 		: 15,
					"value" 	: "hola {nombre}, como estas? seguro {nombre} !?!?!?"
				}				
			]
		}';





		$page->render();
                    ?>
