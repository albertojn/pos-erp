<?php



		define("BYPASS_INSTANCE_CHECK", false);

		require_once("../../../server//bootstrap.php");

		$page = new GerenciaTabPage();

		$page->addComponent(new TitleComponent("Catalogo de clientes", 2));


		$page->nextTab("Lista");

		$page->addComponent( "<div class='POS Boton' onClick='window.location=\"clientes.nuevo.php\"'>Nuevo cliente</div> " );

		$cselector = new ClienteSelectorComponent( );
		$cselector->addJsCallback( "(function(a){ window.location = 'clientes.ver.php?cid='+a.get('id_usuario'); })" );
		$page->addComponent( $cselector);

		$lista = ClientesController::Buscar();



		$page->addComponent(sizeof($lista["resultados"]) ." clientes.");

		$tabla = new TableComponent(
			array(
				"nombre"                        => "Nombre",
				"id_categoria_contacto"		=> "Clasificacion",
				"saldo_del_ejercicio"           => "Saldo"
			),
			$lista["resultados"]
		);

		$tabla->convertToExtJs(false);
		$tabla->addColRender("saldo_del_ejercicio", "FormatMoney");

		$tabla->addColRender("id_categoria_contacto", "funcion_clasificacion_proveedor");
		$tabla->addColRender("activo", "funcion_activo");
		$tabla->addColRender("consignatario", "funcion_consignatario");
		$tabla->addOnClick( "id_usuario", "(function(a){ window.location = 'clientes.ver.php?cid=' + a; })" );


		$page->addComponent( $tabla );











		$page->nextTab("Interacciones");

		//lista de clientes con los que se cuenta correo electronico
















		$page->nextTab("Configuracion");

		$page->addComponent(new TitleComponent("Columnas extra",2));
		$page->addComponent('<div class="POS Boton" onClick="exportar()">Exportar/Importar columnas</div>');
		$page->addComponent(new TitleComponent("Columnas activas",3));

		$epc = ExtraParamsEstructuraDAO::getByTabla("clientes");



		$h = array(

			"campo" => "campo",
			"tipo" => "tipo",
			"longitud" => "longitud",
			"obligatorio" => "olbigatorio",
			"id_extra_params_estructura" => "opciones"
		);

		$tabla = new TableComponent( $h, $epc );

		$page->addComponent('
				<script>

					function delExtraCol(id, t, c){
						POS.API.POST("api/pos/bd/columna/eliminar", {
								tabla : t,
								campo : c
							}, {callback: function(){

							}});
					}

					function editExtraCol(id,t,c, fObj){


						var jObj = Ext.JSON.decode(Url.decode(fObj));

						var required = \'<span style="color:red;font-weight:bold" data-qtip="Required">*</span>\';


						var form = Ext.widget(\'form\', {
							layout: {
								type: \'vbox\',
								align: \'stretch\'
							},
							border: false,
							bodyPadding: 10,

							fieldDefaults: {
								labelAlign: \'top\',
								labelWidth: 100,
								labelStyle: \'font-weight:bold\'
							},
							items: [{
								xtype: \'fieldcontainer\',
								fieldLabel: \'Editando campo \' + c,
								labelStyle: \'font-weight:bold;padding:0\',
								layout: \'hbox\',
								defaultType: \'textfield\',

								fieldDefaults: {
									labelAlign: \'top\'
								},

								items: [{
									flex: 1,
									name: \'campo\',
									afterLabelTextTpl: required,
									fieldLabel: \'Campo\',
									allowBlank: false,
									value : c
								}, {
									flex: 2,
									name: \'tabla\',
									afterLabelTextTpl: required,
									fieldLabel: \'Tabla\',
									allowBlank: false,
									editable: false,
									value: t,
									margins: \'0 0 0 5\'
								}]
							}, {
								xtype: \'textfield\',
								fieldLabel: \'Tipo\',
								name : "tipo",
								afterLabelTextTpl: required,
								allowBlank: false,
								value :jObj.tipo
							}, {
								xtype: \'textfield\',
								name: \'longitud\',
								fieldLabel: \'Longitud\',
								afterLabelTextTpl: required,
								allowBlank: false,
								value : jObj.longitud
							}, {
								xtype: \'textfield\',
								name : "obligatorio",
								fieldLabel: \'Obligatorio\',
								afterLabelTextTpl: required,
								allowBlank: true,
								value : jObj.obligatorio
							}, {
								xtype: \'textfield\',
								name: \'caption\',
								fieldLabel: \'Caption\',
								afterLabelTextTpl: required,
								allowBlank: false,
								value : jObj.caption
							}, {
								xtype: \'textfield\',
								name : "descripcion",
								fieldLabel: \'Descripcion\',
								afterLabelTextTpl: required,
								allowBlank: true,
								value : jObj.descripcion
							}],

							buttons: [{
								text: \'Cancelar\',
								handler: function() {

									this.up(\'window\').destroy();
								}
							}, {
								text: \'Guardar cambios\',
								handler: function() {
									if (this.up(\'form\').getForm().isValid()) {

										var params = this.up("form").getValues();

										params.activo = 1;
										params.compra_en_mostrador = 0;

										var options = {
											callback: function(){
												Ext.getCmp("editarCampoQuick").destroy();
											}
										};

										POS.API.POST("api/pos/bd/columna/editar", params, options);

									}



								}
							}]
						});

						Ext.widget(\'window\', {
							id : "editarCampoQuick",
							title: \'Editar campo\',
							closeAction: \'destroy\',
							width: 500,
							height: 450,
							layout: \'fit\',
							resizable: false,
							modal: true,
							items: form
						}).show();

					}
				</script>
			');

		function smenu($id, $obj ){
			return '<div class="POS Boton" onClick="delExtraCol('. $id .', \''. $obj["tabla"] .'\',\''. $obj["campo"] .'\' )">Eliminar</div>'
					. '<div class="POS Boton" onClick="editExtraCol('. $id .', \''. $obj["tabla"] .'\',\''. $obj["campo"] .'\' , \''  . urlencode(json_encode($obj)) . '\' )">Editar</div>';
		}

		$tabla->addColRender("id_extra_params_estructura", "smenu");
		$page->addComponent($tabla);











		$page->addComponent(new TitleComponent("Nueva columna", 3));

		$nceObj = new ExtraParamsEstructura();
		$nceObj->setTabla("\"clientes\"");
		$nuevaColumnaForm = new DAOFormComponent( $nceObj );
		$nuevaColumnaForm->addApiCall("api/pos/bd/columna/nueva", "POST");
		$nuevaColumnaForm->makeObligatory(array( "campo", "tipo", "longitud", "olbigatorio","obligatorio", "caption" ));
		$nuevaColumnaForm->hideField( array("id_extra_params_estructura", "tabla") );
		$nuevaColumnaForm->sendHidden("tabla");
		$nuevaColumnaForm->setType("descripcion", "textarea");
		$nuevaColumnaForm->createComboBoxJoin("tipo", null, array("string", "int", "float", "date", "bool") );
		$nuevaColumnaForm->createComboBoxJoin("obligatorio", null, array("Si", "No") );
		$page->addComponent( $nuevaColumnaForm );


















		$q = new ExtraParamsEstructura( array("tabla" => "clientes"));
		$qr = ExtraParamsEstructuraDAO::search($q);
		for ($i=0; $i < sizeof($qr); $i++) {
			unset($qr[$i]->id_extra_params_estructura);
		}
		$export_json = json_encode( $qr );



		$page->addComponent('
				<script>
				function exportar(){
					var form = Ext.widget(\'form\', {
							layout: {
								type: \'vbox\',
								align: \'stretch\'
							},
							border: false,
							bodyPadding: 10,

							fieldDefaults: {
								labelAlign: \'top\',
								labelWidth: 100,
								labelStyle: \'font-weight:bold\'
							},
							items: [{
								xtype: \'fieldcontainer\',
								fieldLabel: \'Exportar \',
								labelStyle: \'font-weight:bold;padding:0\',
								layout: \'hbox\',
								defaultType: \'textareafield\',

								fieldDefaults: {
									labelAlign: \'top\'
								},

								items: [{
									flex: 1,
									name: \'campo\',
									fieldLabel: \'Campo\',
									allowBlank: true,
									value : \'' . $export_json . '\'
								}]
							}, {
								xtype: \'fieldcontainer\',
								fieldLabel: \'Importar \',
								labelStyle: \'font-weight:bold;padding:0\',
								layout: \'hbox\',
								defaultType: \'textareafield\',

								fieldDefaults: {
									labelAlign: \'top\'
								},

								items: [{
									flex 	: 1,
									inputId	: \'json_to_import\',
									allowBlank: true,
									emptyText : "Insertar aqui el json de otra exportacion",
									height 	: 150
								}]
							}],

							buttons: [{
								text: \'Cancelar\',
								handler: function() {
									this.up(\'window\').destroy();
								}
							}, {
								text: \'Importar columnas\',
								handler: function(a,b,c) {
									try{
										r = Ext.JSON.decode(Ext.get("json_to_import").getValue());
									}catch(e){
										return;
									}


									//@TODO validar

									var options = {
										callback : function(){
											console.log(\'ok\');
										}
									};


									for ($i=0; $i < r.length; $i++) {
										var params = r[$i];
										params.tabla = "clientes";
										POS.API.POST("api/pos/bd/columna/nueva", params, options);
									}


								}
							}]
						});

						Ext.widget(\'window\', {
							id : "exportarCampos",
							title: \'Exprtar campos\',
							closeAction: \'destroy\',
							width: 500,
							height: 450,
							layout: \'fit\',
							resizable: false,
							modal: true,
							items: form
						}).show();
				}
				</script>
			');
		$page->render();





