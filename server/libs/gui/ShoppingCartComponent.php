<?php


/**
 * ShoppingCartComponent
 * 
 * ShoppingCartComponent es un componente para crear carros de compras
 * facilmente, incluye una caja de busqueda para seleccionar productos
 * o bien.
 *
 * 
 * Hay unas cuantas cosas a considerar:
 * Hay que seleccionar un cliente o una caja comun.
 * Los productos pueden ser computestos, servicios, u otras cosas.
 * Hay otras caracteristicas como "PAPA FIANA" en los productos.
 * Considerar el promedio, o procesadas y originales y todo eso.
 * Manejar Remisiones.
 * Fecha.
 * Cambio de precios.
 * 
 * 
 * 
 * 
 * */



class ShoppingCartComponent extends CartComponent implements GuiComponent
{
	
    
    function __construct()
    {
		$this->cartType = "venta";
    }
    
    function renderCmp()
    {
		?>
		<script>

		Ext.require([
		    'Ext.data.*',
		    'Ext.form.*',
		    'Ext.grid.*',
		    'Ext.util.*',
		    'Ext.state.*'
		]);
		
		
		var grid, unidadMedida;

		/* ********************************************************
	     /\  \         /\  \         /\  \         /\  \          ___        /\  \         /\  \    
	    /::\  \       /::\  \       /::\  \       /::\  \        /\  \       \:\  \       /::\  \   
	   /:/\:\  \     /:/\:\  \     /:/\:\  \     /:/\:\  \       \:\  \       \:\  \     /:/\:\  \  
	  /:/  \:\  \   /::\~\:\  \   /::\~\:\  \   /::\~\:\  \      /::\__\      /::\  \   /:/  \:\  \ 
	 /:/__/ \:\__\ /:/\:\ \:\__\ /:/\:\ \:\__\ /:/\:\ \:\__\  __/:/\/__/     /:/\:\__\ /:/__/ \:\__\
	 \:\  \  \/__/ \/__\:\/:/  / \/_|::\/:/  / \/_|::\/:/  / /\/:/  /       /:/  \/__/ \:\  \ /:/  /
	  \:\  \            \::/  /     |:|::/  /     |:|::/  /  \::/__/       /:/  /       \:\  /:/  / 
	   \:\  \           /:/  /      |:|\/__/      |:|\/__/    \:\__\       \/__/         \:\/:/  /  
	    \:\__\         /:/  /       |:|  |        |:|  |       \/__/                      \::/  /   
	     \/__/         \/__/         \|__|         \|__|                                   \/__/ 
		 * ******************************************************** */
		var actualizar_carrito = function(){

			console.group("ACTUALIZAR CARRITO");

			console.log("Actualizando el carrito...");

			// 
			// Actualizar la tabla de productos 
			// seleccionados
			//
			grid.getView().refresh();

			// 
			// Calcular precios e importes
			//		
			var carrito_store_count = carrito_store.count();
			var subtotal = 0;
			var tarifaActual = 1;

			tarifaActual = Ext.get("tarifa_seleccionada").getValue();
			console.log("la tarifa actual es :" + tarifaActual);


			for (var i=0; i < carrito_store_count; i++) {

				var p = carrito_store.getAt(i);

				var tarifasProducto = p.get("tarifas");

				for (var j=0; j < tarifasProducto.length; j++) {
					if(tarifasProducto[j].id_tarifa == tarifaActual){
							console.log("ya encontre el precio de esta tarifa");
							subtotal += parseFloat( tarifasProducto[j].precio ) * parseFloat( p.get("cantidad") ) ;
							break;
					}
				}
			};



			data  = retriveData();
			
			//subotal sin descuento
			Ext.get("carrito_subtotal").update(Ext.util.Format.usMoney( data.subtotal + data.descuento ));
			
			//total descontado
			Ext.get("carrito_descuento").update( "-" + Ext.util.Format.usMoney( data.descuento ));			
			
			//impuesto 
			Ext.get("carrito_impuesto").update("+"  + Ext.util.Format.usMoney( data.impuesto ));
			
			//total
			Ext.get("carrito_total").update(Ext.util.Format.usMoney( data.subtotal + data.impuesto ));
			


			// 
			// Buscar existencias
			//
			if(sucursal_seleccionada !== null){
				//
				// si hay una sucursal seleccionada
				// podemos calcular si hay existencias
				//
				for (var i=0; i < carrito_store_count; i++) {

					var p = carrito_store.getAt(i);

					var existencias = p.get("existencias");



					var found_existencias = false;

					for (var ei=0; ei < existencias.length; ei++) {
						//
						// buscar la sucursal que
						// tengo seleccionada
						//
						if( existencias[ei].id_sucursal == sucursal_seleccionada ){

							console.log(existencias[ei].id_sucursal,  sucursal_seleccionada)

							found_existencias = true;

							if( p.get("cantidad") > existencias[ei].cantidad ){

								console.warn("se necesitan" + p.get("cantidad") + " pero solo tengo "+ existencias[ei].cantidad);
							}else{
								console.log("quiero " + p.get("cantidad") + " y tengo "+ existencias[ei].cantidad);							
							}
							break;
						}
					}


					if(found_existencias === false){
						console.warn("No hay ningun tipo de existencias");
					}


				};
			}//if(sucursal)

			console.groupEnd();
		}



		/* ****************************************************************************************************************
		      ___           ___                   ___           ___           ___           ___           ___     
		     /\  \         /\__\      ___        /\  \         /\__\         /\  \         /\  \         /\  \    
		    /::\  \       /:/  /     /\  \      /::\  \       /::|  |        \:\  \       /::\  \       /::\  \   
		   /:/\:\  \     /:/  /      \:\  \    /:/\:\  \     /:|:|  |         \:\  \     /:/\:\  \     /:/\ \  \  
		  /:/  \:\  \   /:/  /       /::\__\  /::\~\:\  \   /:/|:|  |__       /::\  \   /::\~\:\  \   _\:\~\ \  \ 
		 /:/__/ \:\__\ /:/__/     __/:/\/__/ /:/\:\ \:\__\ /:/ |:| /\__\     /:/\:\__\ /:/\:\ \:\__\ /\ \:\ \ \__\
		 \:\  \  \/__/ \:\  \    /\/:/  /    \:\~\:\ \/__/ \/__|:|/:/  /    /:/  \/__/ \:\~\:\ \/__/ \:\ \:\ \/__/
		  \:\  \        \:\  \   \::/__/      \:\ \:\__\       |:/:/  /    /:/  /       \:\ \:\__\    \:\ \:\__\  
		   \:\  \        \:\  \   \:\__\       \:\ \/__/       |::/  /     \/__/         \:\ \/__/     \:\/:/  /  
		    \:\__\        \:\__\   \/__/        \:\__\         /:/  /                     \:\__\        \::/  /   
		     \/__/         \/__/                 \/__/         \/__/                       \/__/         \/__/                                                                                                                                                                                                
		   ****************************************************************************************************************  */

		var cliente_seleccionado = null;
		var seleccion_de_cliente = function(a,c){

			cliente_seleccionado = c[0];

			console.log("Cliente seleccionado", cliente_seleccionado);

			Ext.get("buscar_cliente_01").enableDisplayMode('block').hide();
			var pphtml = "<h3 style='margin:0px'>Venta para <a target=\"_blank\" href='clientes.ver.php?cid="+cliente_seleccionado.get("id_usuario")+"'>" + cliente_seleccionado.get("nombre") + "</a></h3>";

			if( cliente_seleccionado.get("rfc") !== null )
				pphtml += "<p>" + cliente_seleccionado.get("rfc") + "</p>";

			pphtml += "<br><div class='POS Boton' onClick='buscar_cliente()'  >Buscar otro cliente</div>";

			Ext.get("buscar_cliente_02").update(pphtml).show();

			actualizar_carrito();	
		};



		/* ********************************************************
	      ___           ___           ___           ___           ___     
	     /\__\         /\  \         /\__\         /\  \         /\  \    
	    /:/  /        /::\  \       /::|  |        \:\  \       /::\  \   
	   /:/  /        /:/\:\  \     /:|:|  |         \:\  \     /:/\:\  \  
	  /:/__/  ___   /::\~\:\  \   /:/|:|  |__       /::\  \   /::\~\:\  \ 
	  |:|  | /\__\ /:/\:\ \:\__\ /:/ |:| /\__\     /:/\:\__\ /:/\:\ \:\__\
	  |:|  |/:/  / \:\~\:\ \/__/ \/__|:|/:/  /    /:/  \/__/ \/__\:\/:/  /
	  |:|__/:/  /   \:\ \:\__\       |:/:/  /    /:/  /           \::/  / 
	   \::::/__/     \:\ \/__/       |::/  /     \/__/            /:/  /  
	    ~~~~          \:\__\         /:/  /                      /:/  /   
	                   \/__/         \/__/                       \/__/ 
		 * ******************************************************** */
		var validar_venta_a_credito = function (clienteStore, carrito){

			if(clienteStore === null){
				//no hay cliente seleccionado
				Ext.get("SeleccionDeCliente").highlight();
				return false;
			}

			var vac = clienteStore.get("limite_credito");

			if((vac === null)||( parseFloat(vac) === 0) ){
				//no tiene ventas a credito
				Ext.MessageBox.alert("Nueva venta", "El cliente "+clienteStore.get("nombre") + " no tiene ventas a credito.");
				return false;			
			}


			return true;
		}



		//
		// Valor default de venta
		// 
		var tipo_de_venta = "contado";

		var seleccion_tipo_de_venta = function(tipo){
			switch(tipo){
				case "credito" :
					console.log("seleccion_tipo_de_venta(credito)");
					validar_venta_a_credito(cliente_seleccionado, carrito_store );
					tipo_de_venta = "credito";
				break;

				case "contado" :
					console.log("seleccion_tipo_de_venta(contado)");			
					tipo_de_venta = "contado";
				break;

				default:
					throw new Exception( "seleccion_tipo_de_venta(): tipo invalido" );
			}
		}

		var buscar_cliente = function(){

			cliente_seleccionado = null;

			Ext.get("buscar_cliente_02").enableDisplayMode('block').hide();

			Ext.get("buscar_cliente_01").show();

			actualizar_carrito();

		}





		var seleccionar_producto = function( a, p ){


			console.group("SELECCION DE PRODUCTO");

			console.log( "Seleccionando producto", p );

			//ponerle cantidad inicial de 1
			console.log("cantidad inicial de 1");

			p[0].set("cantidad", 1);

			//agregar produco al store
			carrito_store.add( p[0] );

			console.groupEnd();

			actualizar_carrito();
		}

		var tipo_de_pago_seleccionado = "efectivo";

		var seleccion_de_tarifa = function(id_tarifa){

			console.log("Tarifa seleccionada:" + id_tarifa);
			actualizar_carrito();
		}

		var carrito_store;

		var retriveData = function(){

				//
				// crear un objeto con los productos
				//
				var detalle_de_venta = [];

				//
				// 
				// 


				var carrito_store_count = carrito_store.count();
				var subtotal = 0;
				var tarifaActual = 1;

				tarifaActual = Ext.get("tarifa_seleccionada").getValue();
				console.log("la tarifa actual es :" + tarifaActual);


				for (var i=0; i < carrito_store_count; i++) {

					var p = carrito_store.getAt(i);

					var tarifasProducto = p.get("tarifas");

					var precio_con_tarifa = -1; 

					for (var j=0; j < tarifasProducto.length; j++) {
						
						if(tarifasProducto[j].id_tarifa == tarifaActual){
								//console.log("ya encontre el precio de esta tarifa");
								precio_con_tarifa = parseFloat( tarifasProducto[j].precio );
								subtotal +=  precio_con_tarifa * parseFloat( p.get("cantidad") ) ;
								break;
						}
						
					}

					detalle_de_venta.push({
						id_producto : p.get("id_producto"),
						cantidad 	: p.get("cantidad"),
						precio		: precio_con_tarifa,
						descuento	: 0,
						impuesto	: 0,
						retencion	: 0,
						id_unidad	: p.get("id_unidad")
					});

				};

				
				var impuesto = 0, descuento = 0;
				
				//descuento esta en 0-100
				descuento = Ext.get("descuento_seleccionado_val").getValue();
				
				//dAplicado es el descuento sin aplicar, lol
				var dAplicado = (descuento/100) * subtotal;

				subtotal = subtotal - dAplicado;
				
				<?php
					//listar impuestos
					$i = ImpuestosController::Lista();
					$iLista = $i["resultados"];
					$impuestos_to = 0;

					//carrito_impuesto
					foreach ($iLista as $imp)
					{
						$impuestos_to += $imp->getImporte();
					}

					echo "impuesto = subtotal * " . $impuestos_to . ";";

				?>				
				
				
				ventaObj = {
					retencion 			: 0,
					descuento 			: dAplicado,
					impuesto 			: impuesto,
					subtotal			: subtotal,
					total 				: subtotal + impuesto,
					tipo_venta	 		: tipo_de_venta,
					id_sucursal			: null,
					detalle_venta		: Ext.JSON.encode( detalle_de_venta )
				};
				
				
				
				if(cliente_seleccionado == null){
					ventaObj.id_comprador_venta = null;
				}else{
					ventaObj.id_comprador_venta	= cliente_seleccionado.get("id_usuario");
				}

				if(Ext.get("sucursal_seleccionada") !==  undefined){
					ventaObj.id_sucursal = Ext.get("sucursal_seleccionada").getValue();

				}else if( sucursal_seleccionada !== undefined || sucursal_seleccionada != null ){
					ventaObj.id_sucursal = sucursal_seleccionada;

				}	

				return ventaObj;
		}


		var doCotizar = function(){
			
			var ventaObj = retriveData();
			
			ventaObj.es_cotizacion = true;

			//
			// Enviar al API
			// 
			POS.API.POST(
				"api/ventas/nueva/", 
				ventaObj,
				{
					callback : function(r){
						if(r.status === "ok"){
							window.location = "ventas.detalle.php?vid=" + r.id_venta + "&last_action=ok";

						}else{
							console.error(r);
							Ext.MessageBox.alert("Nueva venta", "Algo salio mal.");
						}
					}
				});
		}

		var doVenta = function (){

			var ventaObj = retriveData();
			ventaObj.es_cotizacion = 0;

			if( ventaObj.id_sucursal == null ){
					window.scrollTo(0, Ext.get("SeleccionDeSucursal").getY() - 20);			
					Ext.get("SeleccionDeSucursal").highlight();
					return;
			}	


			//
			// Enviar al API
			// 
			POS.API.POST(
				"api/ventas/nueva/", 
				ventaObj,
				{
					callback : function(r){
						if(r.status === "ok"){
							window.location = "ventas.detalle.php?vid=" + r.id_venta + "&last_action=ok";

						}else{
							console.error(r);
							Ext.MessageBox.alert("Nueva venta", "Algo salio mal.");
						}
					}
				});

		}


		var cellEditing = Ext.create('Ext.grid.plugin.CellEditing', {
		        clicksToEdit: 1,
		        listeners: {
		            edit: function(){
		                // refresh summaries
		                actualizar_carrito();
		            }
		        }
		});


		var sucursal_seleccionada = null;

		var seleccionar_sucursal = function( sucursalStore ){
			//sucursalStore
			console.log(sucursalStore.get("id_sucursal") + " seleccionada...");

			sucursal_seleccionada = sucursalStore.get("id_sucursal");

			actualizar_carrito();
		};




		Ext.onReady(function(){


			<?php $this->printOnReadyJs(); ?>		
		
			/** *****************************************************************
			  * CARRITO
			  *
			  * ***************************************************************** */

			   

			    // create the Grid
			    grid = Ext.create('Ext.grid.Panel', {
			        store: carrito_store,
					plugins: [cellEditing],
			        stateful: false,
					bodyCls: 'foo',
			        stateId: 'stateGrid2',
			        columns: [
			            {
			                text     : 'Codigo producto',
			                width    : 95,
			                sortable : false,
			                dataIndex: 'codigo_producto'
			            },
			            {
			                text     : 'Nombre producto',
			                flex     : 1,
			                sortable : true,
			                dataIndex: 'nombre_producto'
			            },
			            {
			                text     : 'Cantidad',
							dataIndex: 'cantidad',
			                sortable : false,
							field: {
				                xtype: 'numberfield',
								decimalPrecision : 4				
				            },
							renderer: function (cantidad, a, storeObj){
								var um = unidadMedida.getById(parseInt( storeObj.get("id_unidad") ) );
								if(um == null){
									alert("Hay un problema con las unidades del producto recien seleccionado. Porfavor verifique que tenga una unidad especificada.");
									return cantidad + " ERROR EN UNIDADES" ;
								}
								
								return cantidad + " " + um.get("descripcion");
							}
			            },	
				/*
						{
			                text     : 'Unidad',
			                width    : 75,
			                dataIndex: 'id_unidad',
				            field : {
				            	xtype : "combobox",
				            	typeAhead: false,
								invalidText : "Invalido",
				                triggerAction: 'all',
				                selectOnTab: true,
				                store: unidadMedida,
				                lazyRender: true,
				                listClass: 'x-combo-list-small',
				                displayField: "abreviacion",
				                listConfig: {
				                	loadingText: 'Buscando...',
				                	
				                	// Custom rendering template for each item
				                	getInnerTpl: function(a,b,c) {
										return "<p style='margin:0px'>{abreviacion}</p>";
				                	}
				            	},
				            }//field
			            },
			*/	
			            {
			                text     : 'Precio',
			                sortable : true,
			                dataIndex: 'tarifas',
							renderer : function(tarifasArray){

								/* ***** **** ***** 
									tarifasArray tiene las tarifas para 
									este producto solo hay que ver que cliente
									esta seleccionado para mostrar la adecuada
								***** **** ***** */
								var tf = Ext.get("tarifa_seleccionada").getValue();

								for (var i=0; i < tarifasArray.length; i++) {
									if(tarifasArray[i].id_tarifa == tf){
										return Ext.util.Format.usMoney( tarifasArray[i].precio );
									}
								}

								return "X";

							}
			            },		
			            {
			                text     : 'Importe',
			                width    : 75,
			                sortable : true,
							renderer : function(a,b,producto){

								var tf =  Ext.get("tarifa_seleccionada").getValue();
								var tarifasArray = producto.get("tarifas");

								for (var i=0; i < tarifasArray.length; i++) {
									if(tarifasArray[i].id_tarifa == tf){
										return Ext.util.Format.usMoney( 
											parseFloat(tarifasArray[i].precio ) * parseFloat(producto.get("cantidad")) );
									}
								};
							}
			            }
			        ],
			        height: 350,
			        width: "100%",
			        renderTo: 'carrito_de_compras_grid',
			        viewConfig: {
			            stripeRows: true
			        }
			    });		

			/** *****************************************************************
			  * CARRITO
			  *
			  * ***************************************************************** */

		}); /* Ext.onReady */


	</script>
				
				
				
			
	<h2>Nueva venta</h2>

	<table border="0" style="width: 100%" class="">
		<tr id="SeleccionDeCliente">
			<td colspan="4">
				<div id="buscar_cliente_01">
					<p style="margin-bottom: 0px;">Buscar cliente</p>
					<div style="margin-bottom: 15px;" id="ShoppingCartComponent_002"><!-- clientes --></div>				
				</div>
				<div id="buscar_cliente_02" style="display:none; margin-bottom: 0px"></div>						
			</td>
		</tr>
		<tr>
			<td id="SeleccionDeSucursal">
				Sucursal:
				<div >
				<?php
					$sucursales = SucursalDAO::getAll();
					if (sizeof($sucursales) == 0) {
						
				?><div style="color:gray; font-size:9px">[No hay sucursales]</div><?php

				} else if (sizeof($sucursales) > 10) {
					    $selector_de_suc = new SucursalSelectorComponent();
					    $selector_de_suc->addJsCallback("seleccionar_sucursal");
					    $selector_de_suc->renderCmp();

				} else {

					?><select id="sucursal_seleccionada" onChange="seleccionar_sucursal(this.value)" ><?php

							for ($i = 0; $i < sizeof($sucursales); $i++) {
								echo "<option value=\"" . $sucursales[$i]->getIdSucursal() . "\" >" . $sucursales[$i]->getDescripcion() . "</option>";
							}

					?></select><?php

				}	


				?>						
				</div>
			</td>
			<td id="SeleccionDeTipoDeVenta">
				Tipo de venta:
				<div >
					<select onChange="seleccion_tipo_de_venta(this.value)">
						<option value="contado" selected>Contado</option>
						<option value="credito">Credito</option>
					</select>
				</div>
			</td>
			<td id="SeleccionDeImpuestos">
				Tipo de tarifa:
				<div >
					<select id="tarifa_seleccionada" onChange="seleccion_de_tarifa(this.value)" >
						<?php

						$tarifas = TarifaDAO::obtenerTarifasActuales("venta");
						
						for ($i = 0; $i < sizeof($tarifas); $i++) {
						    echo "<option value=\"" . $tarifas[$i]["id_tarifa"] . "\" >" . $tarifas[$i]["nombre"] . "</option>";
						}
						
						?>
					</select>
				</div>
			</td>
			<td id="SeleccionDeTipoDePago">
				Tipo de pago:
				<div >
					<select name="" onChange="tipo_de_pago_seleccionado = this.value">
						<option value="efectivo">efectivo</option>
						<option value="cheque">cheque</option>
					</select>
				</div>
			</td>										
		</tr>
		<tr>
			<td id="SeleccionDeDescuento">
			Descuento:
			<input type="text" id="descuento_seleccionado_val" onchange="actualizar_carrito()" value="0" >
			<select id="descuento_seleccionado_tipo" onChange="actualizar_carrito()">
				<option value="porciento">%</option>
				<!-- <option value="MXN">MXN</option> -->
			</select>
			</td>										
		</tr>

	</table>

	<div id="CartComponent_002"><!-- buscar productos --></div>

	<div id="carrito_de_compras" style="margin: 5px auto;">
		<div id="carrito_de_compras_grid"></div>
	</div>



<div style="border:1px solid #99BBE8;	;box-sizing: border-box;
	-moz-box-sizing: border-box;
	-ms-box-sizing: border-box;
	-webkit-box-sizing: border-box; 
	margin-bottom: 20px">
	

	<table style="margin-bottom: 0px;
	width: 200px;
	margin-right: 0px;
	margin-left: auto;">
		<tr>
			<td>Subtotal</td>
			<td id="carrito_subtotal"></td>
		</tr>

		<tr>
			<td>Descuento</td>
			<td id="carrito_descuento"></td>
		</tr>

		<tr>
			<td>Impuesto</td>
			<td id="carrito_impuesto"></td>
		</tr>
		<tr>
			<td><strong>Total</strong></td>
			<td id="carrito_total"></td>
		</tr>				
	</table>
</div>



	<div class="POS Boton" onClick="cancelarVenta()">Cancelar</div>
	<div class="POS Boton" onClick="doCotizar()">Solo cotizar</div>
	<div class="POS Boton OK" onClick="doVenta()">Vender</div>

	<?php
    }
    
    

}
