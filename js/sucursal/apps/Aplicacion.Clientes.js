
/**
 * Construir un nuevo objeto de tipo ApplicacionClientes.
 * @class Esta clase se encarga de la creacion de interfacez
 * que intervinen en la manipulación de clientes. 
 * @constructor
 * @throws MemoryException Si se agota la memoria
 * @return Un objeto del tipo ApplicacionClientes
 */
Aplicacion.Clientes = function (  ){

	return this._init();
}




Aplicacion.Clientes.prototype._init = function (){
    if(DEBUG){
		console.log("ApplicacionClientes: construyendo");
    }

	//cargar la lista de clientes
	this.listaDeClientesLoad();
	
	//crear el panel de lista de clientes
	this.listaDeClientesPanelCreator();
	
	//crear el panel de detalles de cliente
	this.detallesDeClientesPanelCreator();
	
	//crear el panel de nuevo cliente
	this.nuevoClientePanelCreator();
	
	//cargar la lista de compras de los clientes
	this.listaDeComprasLoad();
	
	//cargar el panel que contiene los detalles de las ventas
	this.detallesDeVentaPanelCreator();
	
	Aplicacion.Clientes.currentInstance = this;
	
	return this;
};




Aplicacion.Clientes.prototype.getConfig = function (){
	return {
	    text: 'Clientes',
	    cls: 'launchscreen',
	    items: [{
	        text: 'Lista de Clientes',
	        card: this.listaDeClientesPanel,
	        leaf: true
	    },
	    {
	        text: 'Nuevo Cliente',
	        card: this.nuevoClientePanel,
	        leaf: true
	    }]
	};
};






/* ********************************************************
	Compras de los Clientes
******************************************************** */



/**
 * Contiene un objeto con la lista de clientes actual, para no estar
 * haciendo peticiones a cada rato
 */
Aplicacion.Clientes.prototype.listaDeCompras = {
	lista : null,
	lastUpdate : null
};


/**
 * Leer la lista de clientes del servidor mediante AJAX
 */
Aplicacion.Clientes.prototype.listaDeComprasLoad = function (){
	
	if(DEBUG){
		console.log("Actualizando lista de compras de los clientes ....");
	}
	
	Ext.Ajax.request({
		url: 'proxy.php',
		scope : this,
		params : {
			action : 304
		},
		success: function(response, opts) {
			try{
				compras = Ext.util.JSON.decode( response.responseText );				
			}catch(e){
				POS.error(e);
			}
			
			if( !compras.success ){
				//volver a intentar
				return this.listaDeComprasLoad();
			}
			
			this.listaDeCompras.lista = compras.datos;
			this.listaDeCompras.lastUpdate = Math.round(new Date().getTime()/1000.0);
			

		},
		failure: function( response ){
			POS.error( response );
		}
	});

};










/* ********************************************************
	Lista de Clientes
******************************************************** */

/**
 * Registra el model para listaDeClientes
 */
Ext.regModel('listaDeClientesModel', {
	fields: [
		{name: 'nombre',     type: 'string'}
	]
});





/**
 * Contiene un objeto con la lista de clientes actual, para no estar
 * haciendo peticiones a cada rato
 */
Aplicacion.Clientes.prototype.listaDeClientes = {
	lista : null,
	lastUpdate : null
};




/**
 * Leer la lista de clientes del servidor mediante AJAX
 */
Aplicacion.Clientes.prototype.listaDeClientesLoad = function (){
	
	if(DEBUG){
		console.log("Actualizando lista de clientes ....");
	}
	
	Ext.Ajax.request({
		url: 'proxy.php',
		scope : this,
		params : {
			action : 300
		},
		success: function(response, opts) {
			try{
				clientes = Ext.util.JSON.decode( response.responseText );				
			}catch(e){
				POS.error(e);
			}
			
			if( !clientes.success ){
				//volver a intentar
				return this.listaDeClientesLoad();
			}
			
			this.listaDeClientes.lista = clientes.datos;
			this.listaDeClientes.lastUpdate = Math.round(new Date().getTime()/1000.0);
			
			//agregarlo en el store
			this.listaDeClientesStore.loadData( clientes.datos );
			
			if( Aplicacion.Mostrador && ( Aplicacion.Mostrador.currentInstance.buscarClienteForm.getComponent(0).getStore() == null ) ){
				if(DEBUG){
					console.log("Mostrador existe ya y no tiene el store, se lo cargare dese clientes...");
				}
				Aplicacion.Mostrador.currentInstance.buscarClienteForm.getComponent(0).store = this.listaDeClientesStore;
			}
			

		},
		failure: function( response ){
			POS.error( response );
		}
	});

};





/**
 * Es el Store que contiene la lista de clientes cargada con una peticion al servidor.
 * Recibe como parametros un modelo y una cadena que indica por que se va a sortear (ordenar) 
 * en este caso ese filtro es dado por 
 * @return Ext.data.Store
 */
Aplicacion.Clientes.prototype.listaDeClientesStore = new Ext.data.Store({
    model: 'listaDeClientesModel',
    sorters: 'nombre',
           
    getGroupString : function(record) {
        return record.get('nombre')[0];
    }
});




/**
 * Contiene el panel con la lista de clientes
 */
Aplicacion.Clientes.prototype.listaDeClientesPanel = null;


/**
 * Pone un panel en listaDeClientesPanel
 */
Aplicacion.Clientes.prototype.listaDeClientesPanelCreator = function (){
	this.listaDeClientesPanel =  new Ext.Panel({
        layout: Ext.is.Phone ? 'fit' : {
            type: 'vbox',
            align: 'center',
            pack: 'center'
        },
        
        items: [{
			
			width : '100%',
			height: '100%',
			xtype: 'list',
			store: this.listaDeClientesStore,
			itemTpl: '<div class="listaDeClientesCliente"><strong>{nombre}</strong> {rfc}</div>',
			grouped: true,
			indexBar: true,
			listeners : {
				"selectionchange"  : function ( view, nodos, c ){
					
					if(nodos.length > 0){
						Aplicacion.Clientes.currentInstance.detallesDeClientesPanelShow( nodos[0] );
					}

					//deseleccinar el cliente
					view.deselectAll();
				}
			}
			
        }]
	});
};








/* ********************************************************
	Detalles de la venta
******************************************************** */
/*
 * Guarda el panel donde estan los detalles de la venta
 **/
Aplicacion.Clientes.prototype.detallesDeVentaPanel = null;





/*
 * Es la funcion de entrada para mostrar los detalles del cliente
 **/
Aplicacion.Clientes.prototype.detallesDeVentaPanelShow = function ( venta ){

	
	if( this.detallesDeVentaPanel ){
		this.detallesDeVentaPanelUpdater(venta);
	}else{
		this.detallesDeVentaPanelCreator();
		this.detallesDeVentaPanelUpdater(venta);		
	}
	
	this.detallesDeVentaPanel.setCentered(true);
	this.detallesDeVentaPanel.show( Ext.anims.slide );

};






Aplicacion.Clientes.prototype.detallesDeVentaPanelUpdater = function ( venta )
{
	
	
	//buscar la venta en la estructura
	ventas = Aplicacion.Clientes.currentInstance.listaDeCompras.lista;
	var detalleVenta;
	
	for (var i = ventas.length - 1; i >= 0; i--){
		if(ventas[i].id_venta == venta){
			detalleVenta = ventas[i].detalle_venta;
			break
		}
	};
	

	var html = "";
	html += "<table border=0>";
	
	html += "<tr class='top'>";
	html += "<td>Producto</td>";
	html += "<td>Cantidad</td>";
	html += "<td>Total</td>";
	html += "</tr>";
	
	for (var i=0; i < detalleVenta.length; i++) {

	
		if( i == detalleVenta.length - 1 )
			html += "<tr class='last'>";
		else
			html += "<tr >";		
		
		html += "<td>" + detalleVenta[i].id_producto + "</td>";
		html += "<td>" + detalleVenta[i].cantidad + "</td>";
		html += "<td>" + POS.currencyFormat ( detalleVenta[i].precio ) + "</td>";		
		html += "</tr>";
	};
	
	html += "</table>";
	
	
	this.detallesDeVentaPanel.update( html );
	this.detallesDeVentaPanel.setWidth( 700 );
	this.detallesDeVentaPanel.setHeight( 600 );
};


Aplicacion.Clientes.prototype.detallesDeVentaPanelCreator = function ()
{


    var venta = [{
        text: 'Regresar',
        ui: 'normal',
		handler : function( t ){
			Aplicacion.Clientes.currentInstance.detallesDeVentaPanel.hide( Ext.anims.slide );
		}
    },{
	    text: 'Devoluciones',
	    ui: 'drastic'
	},{
        text: 'Imprimir Ticket',
        ui: 'normal'
    }];


	var dockedItems = [new Ext.Toolbar({
		ui: 'dark',
		dock: 'bottom',
		items: venta
	})];



	this.detallesDeVentaPanel = new Ext.Panel({
	    floating: true,
		ui : "dark",
	    modal: true,
		showAnimation : Ext.anims.fade ,
	    centered: true,
		hideOnMaskTap : true,
		cls : "Tabla",		
		bodyPadding : 0,
		bodyMargin : 0,
	    styleHtmlContent: false,
		html : null,
	    scroll: 'none',
		dockedItems: dockedItems
	});

};









/* ********************************************************
	Detalles del Cliente
******************************************************** */
/*
 * Guarda el panel donde estan los detalles del cliente
 **/
Aplicacion.Clientes.prototype.detallesDeClientesPanel = null;

/*
 * Es la funcion de entrada para mostrar los detalles del cliente
 **/
Aplicacion.Clientes.prototype.detallesDeClientesPanelShow = function ( cliente ){
	if(DEBUG){
		console.log("mostrando detalles", cliente)
	}
	
	if( this.detallesDeClientesPanel ){
		this.detallesDeClientesPanelUpdater(cliente);
	}else{
		this.detallesDeClientesPanelCreator();
		this.detallesDeClientesPanelUpdater(cliente);		
	}
	
	//hacer un setcard manual
	sink.Main.ui.setActiveItem( this.detallesDeClientesPanel , 'slide');
	
	//mostrar la primer pantalla en el carrusel de detalles
	Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.setActiveItem(0);
	
	
	
};


/*
 * Se llama para actualizar el contenido del panel de detalles, cuando ya existe
 **/
Aplicacion.Clientes.prototype.detallesDeClientesPanelUpdater = function ( cliente )
{

	//actualizar los detalles del cliente
	var detallesPanel = Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0];
	detallesPanel.loadRecord( cliente );
	
	//actualizar las compras del cliente
	Aplicacion.Clientes.currentInstance.comprasDeClientesPanelUpdater( cliente );
	
	
	//actualizar el panel de credito y abonos
	Aplicacion.Clientes.currentInstance.creditoDeClientesPanelUpdater( cliente );
};




















/*
 * Se llama para actualizar el contenido del panel de compras de los clientes, que ya estan en una estructura local
 **/
Aplicacion.Clientes.prototype.comprasDeClientesPanelUpdater = function ( cliente )
{

	//actualizar los detalles del cliente
	var comprasPanel = Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(1);
	
	var cid = cliente.data.id_cliente;
	
	//buscar este cliente en la estructura
	var lista = Aplicacion.Clientes.currentInstance.listaDeCompras.lista;
	
	var html = "";
	html += "<table border=0>";
	
	html += "<tr class='top'>";
	html += "<td>ID</td>";
	html += "<td>Fecha</td>";
	html += "<td>Tipo</td>";
	html += "<td>Total</td>";
	html += "</tr>";
	
	for (var i = lista.length - 1; i >= 0; i--){
		
		if(lista[i].id_cliente != cid){
			continue;
		}
		
		if( i == 0 )
			html += "<tr class='last' onClick='Aplicacion.Clientes.currentInstance.detallesDeVentaPanelShow(" +lista[i].id_venta+ ");'>";
		else
			html += "<tr onClick='Aplicacion.Clientes.currentInstance.detallesDeVentaPanelShow(" +lista[i].id_venta+ ");'>";		
		
		html += "<td>" + lista[i].id_venta + "</td>";
		html += "<td>" + lista[i].fecha + "</td>";
		html += "<td>" + lista[i].tipo_venta + "</td>";
		html += "<td>" + POS.currencyFormat ( lista[i].total ) + "</td>";		
		html += "</tr>";
	};
	
	html += "</table>";

	
	//actualizar las compras del cliente
	comprasPanel.update(html);
};











Aplicacion.Clientes.prototype.editarClienteCancelarBoton = function (  )
{
	var detallesPanel = Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0];

	//cargar los valores que tenia por default antes de modificar
	var cliente = Aplicacion.Clientes.currentInstance.CLIENTE_EDIT;
	Aplicacion.Clientes.currentInstance.CLIENTE_EDIT = null;
	
	
	if(DEBUG){
		console.log("cancelando: ", cliente);
	}
	
	detallesPanel.loadRecord( cliente );
	detallesPanel.disable();
	detallesPanel.items.items[0].setInstructions("Todos los campos son obligatorios. Serciorese de que todos los campos sean correctos.");
	
	Ext.getCmp("Clientes-EditarDetalles").setVisible(true);
	Ext.getCmp("Clientes-EditarDetallesGuardar").setVisible(false);
	Ext.getCmp("Clientes-EditarDetallesCancelar").setVisible(false);
};


Aplicacion.Clientes.prototype.editarCliente = function ( data )
{
	if(DEBUG){
		console.log("Guardando cliente", data);
	}

	Ext.getBody().mask('Guardando...', 'x-mask-loading', true);

	Ext.Ajax.request({
		url: 'proxy.php',
		scope : this,
		params : {
			action : 302,
			data : Ext.util.JSON.encode( data )
		},
		success: function(response, opts) {
			try{
				r = Ext.util.JSON.decode( response.responseText );				
			}catch(e){
				POS.error(e);
			}
			

			Ext.getBody().unmask();	
						
			if( !r.success ){
				Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0].items.items[0].setInstructions(r.reason);
				return;
			}



			//poner las instrucciones originales
			Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0].items.items[0].setInstructions("Sus cambios se han guardado satisfactoriamente.");
			
			
			//volver a cargar la estructura de los clientes
			Aplicacion.Clientes.currentInstance.listaDeClientesLoad();			

		},
		failure: function( response ){
			POS.error( response );
		}
	});	
	
};








Aplicacion.Clientes.prototype.editarClienteGuardarBoton = function (  )
{
	var detallesPanel = Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0];

	
	//validar los nuevos datos
	v = detallesPanel.getValues();

	//validar los datos antes de enviar

	var response = "";
	
	//nombre
	if(v.nombre.length < 10){
		response += "La nombre no es valida.<br>";
	}
	
	//rfc
	if(v.rfc.length < 10){
		response += "La rfc no es valida.<br>";
	}
	
	//direccion
	if(v.direccion.length < 10){
		response += "La direccion no es valida.<br>";
	}
	
	//ciudad
	if(v.ciudad.length < 3){
		response += "La ciudad no es valida.<br>";
	}
	
	//e_mail
	
	//telefono
	if(v.telefono.length < 10){
		response += "La telefono no es valida.<br>";
	}
	
	//descuento
	if(  v.descuento.length == 0 || isNaN ( v.descuento ) ){
		response += "El descuento debe ser un numero.<br>";
	}
	
	//limite_credito
	if( v.limite_credito.length == 0 || isNaN ( v.limite_credito ) ){
		response += "El limite de credito debe ser un numero.<br>";
	}

	
	if(response.length > 0){
		Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0].items.items[0].setInstructions(response);
		return;
	}


	detallesPanel.disable();
	Ext.getCmp("Clientes-EditarDetalles").setVisible(true);
	Ext.getCmp("Clientes-EditarDetallesGuardar").setVisible(false);
	Ext.getCmp("Clientes-EditarDetallesCancelar").setVisible(false);
	Aplicacion.Clientes.currentInstance.editarCliente ( v );
};




/*
 *  Aqui se guarda una copia del cliente que estoy apunto de editar
 *  por si decido cancelar la edicion entonces sacarlo de aqui y asi
 *  regresar a los valores originales
 */
Aplicacion.Clientes.prototype.CLIENTE_EDIT = null;





Aplicacion.Clientes.prototype.editarClienteBoton = function (  )
{
	
	if(!POS.pos.gerente){
		return;
	}
	

	
	var detallesPanel = Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getComponent(0).items.items[0];
	Aplicacion.Clientes.currentInstance.CLIENTE_EDIT = detallesPanel.getRecord();
	detallesPanel.enable();	
	

	Ext.getCmp("Clientes-EditarDetalles").hide( Ext.anims.slide );
	Ext.getCmp("Clientes-EditarDetallesGuardar").show( Ext.anims.slide );
	Ext.getCmp("Clientes-EditarDetallesCancelar").show( Ext.anims.slide );		

};









/*
 *
 */
Aplicacion.Clientes.prototype.doAbonar = function (  )
{
	Ext.Ajax.request({
		url: 'proxy.php',
		scope : this,
		params : {
			action : 301
		},
		success: function(response, opts) {
			

		},
		failure: function( response ){
			POS.error( response );
		}
	});
};





Aplicacion.Clientes.prototype.abonarVentaBoton = function (  )
{
	if(DEBUG){
		console.log( "abonando");
	}
	
	Ext.getCmp("Clientes-DetallesVentaAbonarCredito").show();
	Ext.getCmp("Clientes-DetallesVentaCredito").hide();
	
	Ext.getCmp("Clientes-AbonarVentaBotonCancelar").show();
	Ext.getCmp("Clientes-AbonarVentaBotonAceptar").show();
	
	Ext.getCmp("Clientes-ImprimirSaldoBoton").hide();
	Ext.getCmp("Clientes-AbonarVentaBoton").hide();

	Ext.getCmp("Clientes-SeleccionVentaCredito").hide();
	
	
};



Aplicacion.Clientes.prototype.abonarVentaCancelarBoton = function ()
{
	
	Ext.getCmp("Clientes-DetallesVentaAbonarCredito").hide();
	Ext.getCmp("Clientes-DetallesVentaCredito").show();
	
	Ext.getCmp("Clientes-AbonarVentaBotonCancelar").hide();
	Ext.getCmp("Clientes-AbonarVentaBotonAceptar").hide();
	
	Ext.getCmp("Clientes-ImprimirSaldoBoton").show();
	Ext.getCmp("Clientes-AbonarVentaBoton").show();

	Ext.getCmp("Clientes-SeleccionVentaCredito").show();
};





Aplicacion.Clientes.prototype.creditoDeClientesOptionChange = function ( a, v  )
{
	
	
	//el valor de -1 es para el mensaje de seleccionar, todo el que este arriba
	//de eso equivale al id de la venta
	
	if(v == -1){
		Ext.getCmp("Clientes-DetallesVentaCredito").hide();
		Ext.getCmp("Clientes-AbonarVentaBoton").hide();
		Ext.getCmp("Clientes-ImprimirSaldoBoton").hide();
		return;
	}
	
	

	
	
	
	//buscar esta venta especifica en la estructura
	lista = Aplicacion.Clientes.currentInstance.listaDeCompras.lista;
	var venta = null;
	
	for (var i = lista.length - 1; i >= 0; i--){
		if (  lista[i].id_venta  == v ) {
			venta = lista[i];
		};
	};	



	//fecha
	Ext.getCmp("Clientes-DetallesVentaCredito").getComponent(0).setValue(venta.fecha);
	
	//sucursal
	Ext.getCmp("Clientes-DetallesVentaCredito").getComponent(1).setValue(venta.id_sucursal);
	
	//vendedor
	Ext.getCmp("Clientes-DetallesVentaCredito").getComponent(2).setValue(venta.id_usuario);
	
	//total
	Ext.getCmp("Clientes-DetallesVentaCredito").getComponent(3).setValue( POS.currencyFormat(venta.total));
	
	//abonado
	Ext.getCmp("Clientes-DetallesVentaCredito").getComponent(4).setValue( POS.currencyFormat(venta.pagado));
	
	//saldo
	Ext.getCmp("Clientes-DetallesVentaCredito").getComponent(5).setValue( POS.currencyFormat(venta.total - venta.pagado));
	
	Ext.getCmp("Clientes-DetallesVentaCredito").show();
	Ext.getCmp("Clientes-AbonarVentaBoton").show();
	Ext.getCmp("Clientes-ImprimirSaldoBoton").show();
};








Aplicacion.Clientes.prototype.creditoDeClientesPanelUpdater = function ( cliente  ) 
{

	cid = cliente.data.id_cliente;

	lista = Aplicacion.Clientes.currentInstance.listaDeCompras.lista;

	ventasCredito  = [{
		text : "Seleccione una venta a credito de la lista",
		value : -1
	}];

	for (var i = lista.length - 1; i >= 0; i--){
		if ( lista[i].id_cliente == cid && lista[i].tipo_venta  == "credito" ) {
			ventasCredito.push( {
				
				text : "Venta " + lista[i].id_venta,
				value : lista[i].id_venta
				
			} );
		};
	};
	
	Ext.getCmp("Clientes-DetallesVentaCredito").hide();
	Ext.getCmp("Clientes-AbonarVentaBoton").hide();
	Ext.getCmp("Clientes-ImprimirSaldoBoton").hide();
	
	if( ventasCredito.length == 1 ){
		//no hay ventas a credito
		Ext.getCmp("Clentes-CreditoVentasLista").hide();
		Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getTabBar().getComponent(2).hide()
	}else{
		//si hay ventas a credito
		Ext.getCmp("Clentes-CreditoVentasLista").show();
		Ext.getCmp("Clentes-CreditoVentasLista").setOptions( ventasCredito );		
		Aplicacion.Clientes.currentInstance.detallesDeClientesPanel.getTabBar().getComponent(2).show()
	}
	
};








/*
 * Se llama para crear por primera vez el panel de detalles de cliente
 **/
Aplicacion.Clientes.prototype.detallesDeClientesPanelCreator = function (  ){
	
	if(DEBUG){ console.log ("creando panel de detalles de cliente por primera vez"); }
	
	
	detallesDelCliente = new Ext.form.FormPanel({                                                       
	title: 'Detalles del Cliente',
	
	items: [{
		xtype: 'fieldset',
	    title: 'Detalles de Cliente',

	    instructions: 'Todos los campos son obligatorios. Serciorese de que todos los campos sean correctos.',
		defaults : {
			disabled : true
		},
		items: [
			new Ext.form.Text({ name: 'nombre', label: 'Nombre' }),
			new Ext.form.Text({ name: 'id_cliente', label: 'ID'	, hidden : true}),
			new Ext.form.Text({ name: 'rfc', label: 'RFC' }),
			new Ext.form.Text({ name : 'direccion', label: 'Direccion' }),
			new Ext.form.Text({ name : 'ciudad', label: 'Ciudad' }),
			new Ext.form.Text({ name : 'e_mail', label: 'E-mail' }),
			new Ext.form.Text({ name : 'telefono',     label: 'Telefono' }),
			new Ext.form.Text({ name : 'descuento',     label: 'Descuento',     required: false }),
			new Ext.form.Text({ name : 'limite_credito',     label: 'Lim. Credito',     required: false }),
			new Ext.form.Text({ name : 'credito_restante',     label: 'Restante',     required: false }),
			new Ext.form.Text({ name : 'activo',     hidden: true }),
			new Ext.form.Text({ name : 'id_usuario',     hidden: true }),			
			new Ext.form.Text({ name : 'id_sucursal',     hidden: true })
			
		]},
		
		new Ext.Button({ id : 'Clientes-EditarDetalles', ui  : 'action', text: 'Editar', margin : 5, handler : this.editarClienteBoton, disabled : false }),
		new Ext.Button({ id : 'Clientes-EditarDetallesGuardar', ui  : 'confirm', text: 'Guardar', margin : 5, handler : this.editarClienteGuardarBoton, disabled : false, hidden : true }),
		new Ext.Button({ id : 'Clientes-EditarDetallesCancelar', ui  : 'decline', text: 'Cancelar', margin : 5,  handler : this.editarClienteCancelarBoton, disabled : false, hidden : true })
	]});







	//abonar a una compra a credito
	abonar = [ new Ext.form.FormPanel({
		                                                      
		
		items: [{
			xtype: 'fieldset',
		    title: 'Creditos y Saldos',
			id : 'Clientes-SeleccionVentaCredito',
		    instructions: 'Seleccine una venta para ver sus detalles.',
			items: [
				{
					id : "Clentes-CreditoVentasLista",
					xtype: 'selectfield',
					name: 'options',
					label : "Venta", 
					options: [  ],
					listeners : {
						"change" : function(a,b) {Aplicacion.Clientes.currentInstance.creditoDeClientesOptionChange(a,b);} 
					}
				}]
		},{
			xtype: 'fieldset',
		    title: 'Detalles de la venta',
			id : 'Clientes-DetallesVentaCredito',
			items: [
					new Ext.form.Text({ name: 'fecha', label: 'Fecha'  }),
					new Ext.form.Text({ name: 'sucursal', label: 'Sucursal'  }),
					new Ext.form.Text({ name: 'user_id', label: 'Vendedor'  }),
					new Ext.form.Text({ name: 'total', label: 'Total'  }),
					new Ext.form.Text({ name: 'abonado', label: 'Abonado'  }),
					new Ext.form.Text({ name: 'saldo', label: 'Saldo'  })
			]
		},{
			xtype: 'fieldset',
		    title: 'Abonar a la venta',
			id : 'Clientes-DetallesVentaAbonarCredito',
			hidden : true,
			items: [
					new Ext.form.Text({ name: 'saldo', label: 'Saldo'  }),
					new Ext.form.Text({ name: 'monto', label: 'Monto'  })
			]
		},

		new Ext.Button({ id : 'Clientes-AbonarVentaBoton', ui  : 'action', text: 'Abonar', margin : 15, handler : this.abonarVentaBoton, hidden : true }),
		new Ext.Button({ id : 'Clientes-AbonarVentaBotonAceptar', ui  : 'action', text: 'Abonar', margin : 15, handler : this.doAbonar, hidden : true }),
		new Ext.Button({ id : 'Clientes-AbonarVentaBotonCancelar', ui  : 'drastic', text: 'Cancelar', margin : 15, handler : this.abonarVentaCancelarBoton, hidden : true }),				
		new Ext.Button({ id : 'Clientes-ImprimirSaldoBoton', ui  : 'confirm', text: 'Imprimir Detalles', margin : 15, handler : this.imprimirSaldoVentaBoton, hidden : true }),
		
		new Ext.Button({ id : 'Clientes-VerProductosBoton', ui  : 'confirm', text: 'Ver Productos de esta venta', margin : 5, handler : this.imprimirSaldoVentaBoton, hidden : true })			

		]
	})
	];
	






	//crear el panel, y asignarselo a detallesDeClientesPanel
	this.detallesDeClientesPanel = new Ext.TabPanel({

		//NO MOVER EL ORDEN DEL MENU !!
	    items: [{
			iconCls: 'user',
	        title: 'Detalles',
	        items : detallesDelCliente       
	    },{
			iconCls: 'bookmarks',
	        title: 'Ventas',
			cls : "Tabla",
	        html: 'Lista de compras'
	    },{
			iconCls: 'download',
		    title: 'Credito',
		    items : abonar   
		}],
	    tabBar: {
	        dock: 'bottom',
	        layout: {
	            pack: 'center'
	        }
	    }
	});
	
	
};



















/* ********************************************************
	Nuevo Cliente
******************************************************** */


/*
 * Guarda el panel donde estan la forma de nuevo cliente
 **/
Aplicacion.Clientes.prototype.nuevoClientePanel = null;

/*
 * Es la funcion de entrada para mostrar el panel de nuevo cliente
 **/
Aplicacion.Clientes.prototype.nuevoClientePanelShow = function ( ){
	if(DEBUG){
		console.log("mostrando nuevo cliente")
	}
	
	//hacer un setcard manual
	sink.Main.ui.setActiveItem( this.nuevoClientePanel , 'slide');
};







/*
 * Se llama para crear por primera vez el panel de nuevo cliente
 **/
Aplicacion.Clientes.prototype.nuevoClientePanelCreator = function (  ){
	if(DEBUG){ console.log ("creando panel de nuevo cliente"); }
	
	
	this.nuevoClientePanel = new Ext.form.FormPanel({                                                       

		items: [{
			xtype: 'fieldset',
		    title: 'Ingrese los detalles del nuevo cliente',
		    instructions: 'Si desea ofrecer un limite de credito que exceda los $20,000.00 debera pedir una autorizacion.',
			items: [
				new Ext.form.Text({ name: 'nombre', label: 'Nombre' }),
				new Ext.form.Text({ name: 'rfc', label: 'RFC' }),
				new Ext.form.Text({ name : 'direccion', label: 'Direccion' }),
				new Ext.form.Text({ name : 'ciudad', label: 'Ciudad' }),
				new Ext.form.Text({ name : 'e_mail', label: 'E-mail' }),
				new Ext.form.Text({ name : 'telefono',     label: 'Telefono' }),
				new Ext.form.Text({ name : 'descuento',     label: 'Descuento',     required: false }),
				new Ext.form.Text({ name : 'limite_credito',     label: 'Lim. Credito',     required: false })
			]},
			
			new Ext.Button({ id : 'Clientes-CrearCliente', ui  : 'action', text: 'Crear Cliente', margin : 5,  handler : this.crearClienteBoton, disabled : false }),
	]});


	
};



Aplicacion.Clientes.prototype.crearCliente = function ( data )
{
	Ext.getBody().mask('Creando cliente ...', 'x-mask-loading', true);

	Ext.Ajax.request({
		url: 'proxy.php',
		scope : this,
		params : {
			action : 301,
			data : Ext.util.JSON.encode( data )
		},
		success: function(response, opts) {
			try{
				r = Ext.util.JSON.decode( response.responseText );				
			}catch(e){
				POS.error(e);
			}
			

			Ext.getBody().unmask();	
						
			if( !r.success ){
				Aplicacion.Clientes.currentInstance.nuevoClientePanel.items.items[0].setInstructions(r.reason);
				return;
			}

			//actualizar la lista de los clientes
			Aplicacion.Clientes.currentInstance.listaDeClientesLoad();
			
			//limpiar la forma		
			Aplicacion.Clientes.currentInstance.nuevoClientePanel.reset();
			
			//poner las instrucciones originales
			Aplicacion.Clientes.currentInstance.nuevoClientePanel.items.items[0].setInstructions("Si desea ofrecer un limite de credito que exceda los $20,000.00 debera pedir una autorizacion.");
			
			

		},
		failure: function( response ){
			POS.error( response );
		}
	});	
};


Aplicacion.Clientes.prototype.crearClienteBoton = function ()
{

	v = Aplicacion.Clientes.currentInstance.nuevoClientePanel.getValues();

	//validar los datos antes de enviar

	var response = "";
	
	//nombre
	if(v.nombre.length < 10){
		response += "La nombre no es valida.<br>";
	}
	
	//rfc
	if(v.rfc.length < 10){
		response += "La rfc no es valida.<br>";
	}
	
	//direccion
	if(v.direccion.length < 10){
		response += "La direccion no es valida.<br>";
	}
	
	//ciudad
	if(v.ciudad.length < 3){
		response += "La ciudad no es valida.<br>";
	}
	
	//e_mail
	
	//telefono
	if(v.telefono.length < 10){
		response += "La telefono no es valida.<br>";
	}
	
	//descuento
	if(  v.descuento.length == 0 || isNaN ( v.descuento ) ){
		response += "El descuento debe ser un numero.<br>";
	}
	
	//limite_credito
	if( v.limite_credito.length == 0 || isNaN ( v.limite_credito ) ){
		response += "El limite de credito debe ser un numero.<br>";
	}

	
	if(response.length > 0){
		Aplicacion.Clientes.currentInstance.nuevoClientePanel.items.items[0].setInstructions(response);
		return;
	}
	
	Aplicacion.Clientes.currentInstance.crearCliente( v );
};












POS.Apps.push( new Aplicacion.Clientes() );

