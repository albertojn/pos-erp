<?php

class PosComponentPage extends StdComponentPage{


	private $main_menu_json;
	private $title;
	
	function __construct( $title = "Gerencia"){
		$this->title = $title;
		parent::__construct( $title );
		$this->partial_render_n = 0;
		$this->partial_render = false;
		$this->parital_head_rendered = false;		
	}
	
	private $partial_render_n;
	private $partial_render;
	private $parital_head_rendered;

	public function partialRender(){
		$this->partial_render = true;
		$this->render();
	}

	private function _renderWrapper()	{
		if(!$this->parital_head_rendered){
			$this->parital_head_rendered = true;
			?>
			<!DOCTYPE html>
			<html xmlns="http://www.w3.org/1999/xhtml" lang="en" >
			<head>
			<title><?php echo $this->title; ?></title>


				<link rel="stylesheet" type="text/css" href="http://api.caffeina.mx/ext-4.0.0/resources/css/ext-all.css" /> 
			    <script type="text/javascript" src="http://api.caffeina.mx/ext-4.0.0/ext-all-debug.js"></script>
			
				<?php if (is_file("../../css/basic.css") ) { ?><link type="text/css" rel="stylesheet" href="../../css/basic.css"/><?php } ?>
				<?php if (is_file("../../../css/basic.css") ) { ?><link type="text/css" rel="stylesheet" href="../../../css/basic.css"/><?php } ?>
				<?php if (is_file("css/basic.css") ) { ?><link type="text/css" rel="stylesheet" href="css/basic.css"/><?php } ?>								
				


				<script type="text/javascript" charset="utf-8" src="http://api.caffeina.mx/ext-4.0.0/examples/ux/grid/TransformGrid.js"></script>
				<script type="text/javascript" charset="utf-8" src="./gerencia.js"></script>			
				<script type="text/javascript" charset="utf-8">
					if(HtmlEncode===undefined){var HtmlEncode=function(a){var b=a.length,c=[];while(b--){var d=a[b].charCodeAt();if(d>127||d>90&&d<97){c[b]="&#"+d+";"}else{c[b]=a[b]}}return c.join("")}} 
				</script>
			</head>
			<body class="">
			<!-- <div id="FB_HiddenContainer" style="position:absolute; top:-10000px; width:0px; height:0px;"></div> -->
			<div class="devsitePage">
				<div class="menu">
					<div class="content">
						<a class="logo" href="index.php">
						
							<!--<img class="img" src="../../../media/N2f0JA5UPFU.png" alt="" width="166" height="17"/>-->
							<div style="width:166px; height: 17px">
							
							</div>
						</a>

						<?php echo $this->_renderTopMenu(); ?>
					


						<a class="l">
							<img style="margin-top:8px; display: none;" id="ajax_loader" src="../../../media/loader.gif">
						</a>

<!-- -->

						<script type="text/javascript" charset="utf-8">
							
							Ext.onReady(function(){				

						        Ext.define("Resultados", {
						            extend: 'Ext.data.Model',
						            proxy: {
						                type: 'ajax',
									    url : '../api/pos/buscar/',
									    extraParams : {
										    auth_token : Ext.util.Cookies.get("at")
									    },
						                reader: {
						                    type: 'json',
						                    root: 'resultados',
						                    totalProperty: 'numero_de_resultados'
						                }
						            },

						            fields: [

									    {name: 'texto',		mapping: 'texto'},
									    {name: 'id', 		mapping: 'id'},
									    {name: 'tipo', 		mapping: 'tipo'}
									    
						            ]
						        });

						        dss = Ext.create('Ext.data.Store', {
						            pageSize: 10,
						            model: 'Resultados'
						        });

						        Ext.create('Ext.panel.Panel', {
						            renderTo: "BuscadorComponent_001",
						            width: '88%',
						            bodyPadding: 1,
									height: "26px",
						            layout: 'anchor',

						            items: [{
									    listeners :{
										    "select" : function(a,b,c){
												if(b.length != 1) return;
												
												if(b[0].get("tipo") == "cliente"){
													window.location = "clientes.ver.php?cid=" + b[0].get("id");
													console.log("fue cliente"); return;
												}
												
												if(b[0].get("tipo") == "producto"){
													window.location = "productos.ver.php?pid=" + b[0].get("id");													
													console.log("fue producto"); return;
												}

												console.log("no fue ninguno :(");
											}
									    },
						                xtype: 'combo',
						                store: dss,
						                emptyText : "Buscar",
						                //displayField: 'title',
						                typeAhead: true,
						                hideLabel: true,
						                hideTrigger:true,
						                anchor: '100%',
						                listConfig: {
											/*Ext.view.BoundListView */
						                    loadingText: 'Buscando...',
						                    emptyText: 'No se encontraron clientes.',
												
						                    // Custom rendering template for each item
						                     getInnerTpl: function() {
							                        return '<div>{tipo}<br><b>{texto}</b></div>';
							                    }
						                },
						                pageSize: 0
						            }]


						        });

					        });//onReady
						</script>
						
						<div class="search">
							<div id="BuscadorComponent_001"></div>
							<!--
							<form method="get" action="/search">
								<div class="uiTypeahead" id="u272751_1">
									<div class="wrap">
									
										<div class="innerWrap">
											<span class="uiSearchInput textInput">
											<span>
											
											<input 
												type="text" 
												class="inputtext DOMControl_placeholder" 
												name="selection" 
												placeholder="Buscar" 
												autocomplete="off" 
												onfocus="" 
												spellcheck="false"
												title="Search Documentation / Apps"/>
												
											<button type="submit" title="Search Documentation / Apps">
											<span class="hidden_elem">
											</span>
											</button>
											</span>
											</span>
										</div>
									</div>
											
								


								</div>
							</form>
							-->
						</div>
<!-- -->
						<div class="clear">
						</div>
					</div>
				</div>
				<div class="body nav">
					<div class="content">
						<!-- ----------------------------------------------------------------------
										MENU
							 ---------------------------------------------------------------------- -->
						<div id="bodyMenu" class="bodyMenu"><div class="toplevelnav">
							<?php $this->_renderMenu(); ?>
						</div></div>
					

					
						<!-- ----------------------------------------------------------------------
										CONTENIDO
							 ---------------------------------------------------------------------- -->
						<div id="bodyText" class="bodyText">
							<div class="header">
								<div class="content">
								<style>
								.msg .x-box-mc {
								    font-size:14px;
								}
								#msg-div {
								    position:absolute;
								    left:55%;
								    top:10px;
								    width:300px;
								    z-index:20000;
								}
								#msg-div .msg {
								    border-radius: 8px;
								    -moz-border-radius: 8px;
								    background: #F6F6F6;
								    border: 2px solid #ccc;
								    margin-top: 2px;
								    padding: 10px 15px;
								    color: #555;
								}
								#msg-div .msg h3 {
								    margin: 0 0 8px;
								    font-weight: bold;
								    font-size: 15px;
								}
								#msg-div .msg p {
								    margin: 0;
								}</style>
								
								
			<?php } ?>	
								<?php 
								for ($i = $this->partial_render_n; $i < sizeof($this->components); $i++) { 
									echo $this->components[$i]->renderCmp();
									$this->partial_render_n++;
								}

								if($this->partial_render) {
									$this->partial_render = false;
									return ;	
								}
								
								?>
							</div>
						</div>


						<div class="mtm pvm uiBoxWhite topborder">
							<div class="mbm"></div>
							<!--<abbr class="timestamp">Generado <?php echo date("r",time()); ?></abbr>-->
						</div>
					</div>

					<div class="clear"></div>

				</div>
			</div>
			<div class="footer">
				<div class="content">
					
					<div class="copyright">
					<a href="http://caffeina.mx"> Caffeina Software</a>
					</div>

					<div class="links">
						<a href="">Admin</a>
						<a href="">API Publica</a>
						<a href="front_ends/j/">Desarrolladores</a>

					</div>
				</div>
			</div>

			
		</div>

		</body>
		</html>
	
		<?php
	}

	protected function _renderTopMenu( ){ return ""; }
	
	protected function _renderMenu( )	{ return ""; }
	
	private function _renderComponents(){


		for ($i = $this->partial_render_n; $i < sizeof($this->components); $i++) { 
			echo $this->components[$i]->renderCmp();
			$this->partial_render_n++;
		}

		if($this->partial_render) {
			$this->partial_render = false;
			return ;	
		}

		/*foreach( $this->components as $cmp ){
			echo $cmp->renderCmp();
		}*/

	}

	public function render(){
		$this->_renderWrapper();

	}


}