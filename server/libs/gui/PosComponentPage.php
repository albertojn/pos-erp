<?php

class PosComponentPage extends StdComponentPage{


	private $main_menu_json;
	private $title;
	private $GA;
	
	function __construct( $title = "Gerencia"){
		
		$file = $_SERVER["PHP_SELF"];
		Logger::log("[FRONTEND] " . $file);

		$this->title = $title;
		parent::__construct( $title );
		$this->partial_render_n = 0;
		$this->partial_render = false;
		$this->parital_head_rendered = false;		
		
		if(defined("GOOGLE_ANALYTICS_ID") && !is_null(GOOGLE_ANALYTICS_ID)){
			$this->GA = GOOGLE_ANALYTICS_ID;
		}else{
			$this->GA = null;
		}
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
			<html xmlns="http://www.w3.org/1999/xhtml" lang="es" >
			<head>
			<title><?php echo $this->title; ?></title>
			<meta charset=utf-8">

				<link rel="stylesheet" type="text/css" href="http://api.caffeina.mx/ext-4.0.0/resources/css/ext-all.css" /> 
			    <script type="text/javascript" src="http://api.caffeina.mx/ext-4.0.0/ext-all.js"></script>
			    <!--
				<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
			-->
			<!--
				<script type="text/javascript" charset="utf-8" src="http://cdn.sencha.io/ext-4.1.0-gpl/ext-all.js"></script>
			-->
				<?php if (is_file("../css/basic.css") ) { ?><link type="text/css" rel="stylesheet" href="../css/basic.css"/><?php } ?>
				<?php if (is_file("../../css/basic.css") ) { ?><link type="text/css" rel="stylesheet" href="../../css/basic.css"/><?php } ?>
				<?php if (is_file("css/basic.css") ) { ?><link type="text/css" rel="stylesheet" href="css/basic.css"/><?php } ?>								
				


				<script type="text/javascript" charset="utf-8" src="http://api.caffeina.mx/ext-4.0.0/examples/ux/grid/TransformGrid.js"></script>
				<?php if(is_file("../g/gerencia.js")){ ?> <script type="text/javascript" charset="utf-8" src="../g/gerencia.js"></script> <?php } 
					else{ ?> <script type="text/javascript" charset="utf-8" src="gerencia.js"></script> <?php }	?>
				
				<!--<script type="text/javascript" charset="utf-8" src="../g/gerencia.js"></script>	-->
				<script type="text/javascript" charset="utf-8">
					if(HtmlEncode===undefined){var HtmlEncode=function(a){var b=a.length,c=[];while(b--){var d=a[b].charCodeAt();if(d>127/*||d>90&&d<97*/){c[b]="&#"+d+";"}else{c[b]=a[b]}}return c.join("")}} 
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
							<img style="margin-top:8px; display: none;" id="ajax_loader" src="../../media/loader.gif">
						</a>

<!-- -->
						<?php $s = SesionController::Actual(); if(!is_null($s["id_usuario"])) { ?>
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
						</div>
						<?php } ?>
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

						<div id="bodyMenu" class="bodyMenu">
							<div>
															<?php
							if(defined("IID") && is_file("../static/" . IID . ".jpg")){
								$file = "../static/" . IID . ".jpg";
								?>
								<div style="
												border-bottom: 1px solid white;
												
												-moz-box-shadow: 0px 0px 5px rgba(0, 0, 0, .52);
												-webkit-box-shadow: 0px 0px 5px rgba(0, 0, 0, .52);
												box-shadow: 0px 0px 5px rgba(0, 0, 0, .52);
												width: 166px; 
												height: 140px; 

												background-size:166px; 
												background-repeat: no-repeat; 
												background-image: url(<?php echo $file; ?>)">
								</div>
								<?php
							}
						?>
						
							</div>
							<div class="toplevelnav">

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
					<?php if(defined("SVN_REV")){
						
						echo "CAFFEINA POS ERP DEV BUILD: <b>2.0</b> r<b>" . SVN_REV . "</b> |";
						
					} ?>
					 <a href="http://caffeina.mx"> Caffeina Software</a>
					</div>

					<div class="links">
						<a href="">Admin</a>
						<a href="">API Publica</a>
						<a href="pos/j/">Desarrolladores</a>

					</div>
				</div>
			</div>

			
		</div>
		<?php
		
		if(!is_null($this->GA)){
			?>
			<script type="text/javascript">

			  var _gaq = _gaq || [];
			  _gaq.push(['_setAccount', '<?php echo $this->GA; ?>']);
			  _gaq.push(['_trackPageview']);

			  (function() {
			    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
			    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
			    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
			  })();

			</script>
			<?php
		}

		
		?>

			<div style="" id="PosImSpace"></div>

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
