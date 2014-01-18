<?php
/**
  *
  *
  *
  **/
	
  interface ISucursales {
  
  
	/**
 	 *
 	 *Lista las sucursales relacionadas con esta instancia. 
 	 *
 	 * @param activo bool Si este valor no es pasado, se listaran sucursales tanto activas como inactivas, si su valor es true, solo se mostrarn las sucursales activas, si es false, solo se mostraran las sucursales inactivas.
 	 * @param limit int Indica hasta que registro se desea obtener a partir del conjunto de resultados productos de la bsqueda.
 	 * @param order string Indica si se ordenan los registros de manera Ascendente ASC, o descendente DESC.
 	 * @param order_by string Indica por que campo se ordenan los resultados.
 	 * @param query string Valor que se buscara en la consulta
 	 * @param start int Indica desde que registro se desea obtener a partir del conjunto de resultados productos de la busqueda.
 	 * @return resultados json Objeto que contendra la lista de sucursales.
 	 * @return numero_de_resultados int 
 	 **/
  static function Buscar
	(
		$activo = null, 
		$limit = null, 
		$order = null, 
		$order_by = null, 
		$query = null, 
		$start = null
	);  
  
  
	
  
	/**
 	 *
 	 *Valida si una maquina que realizara peticiones al servidor pertenece a una sucursal.
 	 *
 	 * @param client_token string El token generado por el POS client
 	 * @param control_billetes bool Si se quiere llevar el control de billetes en la caja
 	 * @param id_caja int Id de la caja a abrir
 	 * @param saldo float Saldo con el que empieza a funcionar la caja
 	 * @param billetes json Ids de billetes y sus cantidades con los que inicia esta caja
 	 * @param id_cajero int Id del cajero que iniciara en esta caja en caso de que no sea este el que abre la caja
 	 * @return detalles_sucursal json Si esta es una sucursal valida, detalles sucursal contiene un objeto con informacion sobre esta sucursal.
 	 **/
  static function AbrirCaja
	(
		$client_token, 
		$control_billetes, 
		$id_caja, 
		$saldo, 
		$billetes = null, 
		$id_cajero = null
	);  
  
  
	
  
	/**
 	 *
 	 *Hace un corte en los flujos de dinero de la sucursal. El Id de la sucursal se tomara de la sesion actual. La fehca se tomara del servidor.
 	 *
 	 * @param id_caja int Id de la caja a cerrar
 	 * @param saldo_real float Saldo que hay actualmente en la caja
 	 * @param billetes json Ids de billetes y sus cantidades encontrados en la caja al hacer el cierre
 	 * @param id_cajero int Id del cajero en caso de que no sea este el que realiza el cierre
 	 * @return id_cierre int Id del cierre autogenerado.
 	 **/
  static function CerrarCaja
	(
		$id_caja, 
		$saldo_real, 
		$billetes = null, 
		$id_cajero = null
	);  
  
  
	
  
	/**
 	 *
 	 *Comprar productos en mostrador. No debe confundirse con comprar productos a un proveedor. Estos productos se agregaran al inventario de esta sucursal de manera automatica e instantanea. La IP ser? tomada de la m?quina que realiza la compra. El usuario y la sucursal ser?n tomados de la sesion activa. El estado del campo liquidada ser? tomado de acuerdo al campo total y pagado.
 	 *
 	 * @param descuento float Cantidad restada por descuento
 	 * @param detalle json Objeto que contendr la informacin de los productos comprados, sus cantidades, sus descuentos, y sus precios
 	 * @param id_empresa int Empresa a nombre de la cual se realiza la compra
 	 * @param id_vendedor int Id del cliente al que se le compra
 	 * @param impuesto float Cantidad sumada por impuestos
 	 * @param retencion float Cantidad sumada por retenciones
 	 * @param subtotal float Total de la compra antes de incluirle impuestos.
 	 * @param tipo_compra string Si la compra es a credito o de contado
 	 * @param total float Total de la compra despues de impuestos y descuentos
 	 * @param billetes_cambio json Ids de billetes que se recibieron como cambio
 	 * @param billetes_pago json Ids de billetes que se usaron para pagar
 	 * @param cheques json Si el tipo de pago es con cheque, se almacena el nombre del banco, el monto y los ultimos 4 numeros del o de los cheques
 	 * @param id_caja int Id de la caja de la cual se realizara la compra. Si no se recibe se tomara de la sesion
 	 * @param id_compra_caja int Id de la compra de esta caja, sirve cuando se va el internet
 	 * @param id_sucursal int Id de la sucursal de la cual se hara la compra. Si no se recibe se tomara de la sesion
 	 * @param saldo float Saldo de la compra
 	 * @param tipo_pago string Si el pago ser en efectivo, con tarjeta o con cheque
 	 * @return id_compra_cliente string Id de la nueva compra
 	 **/
  static function ComprarCaja
	(
		$descuento, 
		$detalle, 
		$id_empresa, 
		$id_vendedor, 
		$impuesto, 
		$retencion, 
		$subtotal, 
		$tipo_compra, 
		$total, 
		$billetes_cambio = null, 
		$billetes_pago = null, 
		$cheques = null, 
		$id_caja = null, 
		$id_compra_caja = null, 
		$id_sucursal = null, 
		$saldo = "0", 
		$tipo_pago = null
	);  
  
  
	
  
	/**
 	 *
 	 *Realiza un corte de caja. Este metodo reduce el dinero de la caja y va registrando el dinero acumulado de esa caja. Si faltase dinero se carga una deuda al cajero. La fecha sera tomada del servidor. El usuario sera tomado de la sesion.
 	 *
 	 * @param id_caja int Id de la caja a la que se le hace el corte
 	 * @param saldo_final float Saldo que se dejara en la caja para que continue realizando sus operaciones.
 	 * @param saldo_real float Saldo real encontrado en la caja
 	 * @param billetes_dejados json Ids de billetes dejados en la caja despues de hacer el corte
 	 * @param billetes_encontrados json Ids de billetes encontrados en la caja al hacer el corte
 	 * @param id_cajero int Id del cajero en caso de que no sea este el que realiza el corte
 	 * @param id_cajero_nuevo int Id del cajero que entrara despues de realizar el corte
 	 * @return id_corte_caja int Id generado por la insercion del nuevo corte
 	 **/
  static function CorteCaja
	(
		$id_caja, 
		$saldo_final, 
		$saldo_real, 
		$billetes_dejados = null, 
		$billetes_encontrados = null, 
		$id_cajero = null, 
		$id_cajero_nuevo = null
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informacion de una caja
 	 *
 	 * @param id_caja int Id de la caja a editar
 	 * @param control_billetes bool Si la caja llevara control de los billetes que tiene o no
 	 * @param descripcion string Descripcion de la caja
 	 * @param token string Token generado por el pos client
 	 **/
  static function EditarCaja
	(
		$id_caja, 
		$control_billetes = null, 
		$descripcion = null, 
		$token = null
	);  
  
  
	
  
	/**
 	 *
 	 *Desactiva una caja, para que la caja pueda ser desactivada, tieneq ue estar cerrada
 	 *
 	 * @param id_caja int Id de la caja a eliminar
 	 **/
  static function EliminarCaja
	(
		$id_caja
	);  
  
  
	
  
	/**
 	 *
 	 *Lista las cajas. Se puede filtrar por la sucursal a la que pertenecen.
 	 *
 	 * @param activa bool Valor de activa de las cajas que se listaran
 	 * @param id_sucursal int Sucursal de la cual se listaran sus cajas
 	 * @return cajas json Objeto que contendra la lista de cajas
 	 **/
  static function ListaCaja
	(
		$activa = null, 
		$id_sucursal = null
	);  
  
  
	
  
	/**
 	 *
 	 *Este metodo creara una caja asociada a una sucursal. Debe haber una caja por CPU. 
 	 *
 	 * @param token string el token que pos_client otorga por equipo
 	 * @param basculas json Un objeto con las basculas conectadas a esta caja.
 	 * @param control_billetes bool Si la caja llevara el control de los billetes que hay en ella
 	 * @param descripcion string Descripcion de esta caja
 	 * @param id_sucursal int Id de la sucursal a la que pertenecera esta caja. Si no es obtenido se tomara la de la sesion
 	 * @param impresoras json Un objeto con las impresoras asociadas a esta sucursal.
 	 * @return id_caja int Id de la caja generada por la insercion
 	 **/
  static function NuevaCaja
	(
		$token, 
		$basculas = null, 
		$control_billetes =  0 , 
		$descripcion = null, 
		$id_sucursal = null, 
		$impresoras = null
	);  
  
  
	
  
	/**
 	 *
 	 *Vender productos desde el mostrador de una sucursal. Cualquier producto vendido aqui sera descontado del inventario de esta sucursal. La fecha ser? tomada del servidor, el usuario y la sucursal ser?n tomados del servidor. La ip ser? tomada de la m?quina que manda a llamar al m?todo. El valor del campo liquidada depender? de los campos total y pagado. La empresa se tomara del alamcen de donde salieron los productos
 	 *
 	 * @param descuento float La cantidad que ser descontada a la compra
 	 * @param id_comprador int Id del cliente al que se le vende.
 	 * @param impuesto float Cantidad sumada por impuestos
 	 * @param retencion float Cantidad sumada por retenciones
 	 * @param subtotal float El total de la venta antes de cargarle impuestos
 	 * @param tipo_venta string Si la venta es a credito o a contado
 	 * @param total float El total de la venta
 	 * @param billetes_cambio json Ids de billetes que se entregaron como cambio
 	 * @param billetes_pago json Ids de los billetes que se recibieron 
 	 * @param cheques json Si el tipo de pago es con cheque, se almacena el nombre del banco, el monto y los ultimos 4 numeros del o de los cheques
 	 * @param detalle_orden json Objeto que contendr los id de los servicios, sus cantidades, su precio y su descuento.
 	 * @param detalle_paquete json Objeto que contendr los id de los paquetes, sus cantidades, su precio y su descuento.
 	 * @param detalle_producto json Objeto que contendr los id de los productos, sus cantidades, su precio y su descuento.
 	 * @param id_caja int Id de la caja desde la que se vende, en caso de que se venda desde otra caja
 	 * @param id_sucursal int Id de la sucursal de donde saldran los productos en caso de que se venda desde otra sucursal
 	 * @param id_venta_caja int Id de la venta de esta caja, utilizado cuando se va el internet
 	 * @param saldo float La cantidad que ha sido abonada hasta el momento de la venta
 	 * @param tipo_pago string Si el pago ser efectivo, cheque o tarjeta.
 	 * @return id_venta int Id autogenerado de la inserción de la venta.
 	 **/
  static function VenderCaja
	(
		$descuento, 
		$id_comprador, 
		$impuesto, 
		$retencion, 
		$subtotal, 
		$tipo_venta, 
		$total, 
		$billetes_cambio = null, 
		$billetes_pago = null, 
		$cheques = null, 
		$detalle_orden = null, 
		$detalle_paquete = null, 
		$detalle_producto = null, 
		$id_caja = null, 
		$id_sucursal = null, 
		$id_venta_caja = null, 
		$saldo = "0", 
		$tipo_pago = null
	);  
  
  
	
  
	/**
 	 *
 	 *Realiza un corte general para la sucrusal, ya que aun no se implementan cajas
 	 *
 	 * @param fecha_final int Fecha que acota el fin del periodo del corte.(formato de tiempo Unix)
 	 * @param id_sucursal int Id de la sucursal a la cual se realizara el corte
 	 * @param total_efectivo float Total de efectivo con el cual se cuenta en la caja al momento de realizar el corte.
 	 **/
  static function Corte
	(
		$fecha_final, 
		$id_sucursal, 
		$total_efectivo
	);  
  
  
	
  
	/**
 	 *
 	 *Muestra los detalles de una sucursal en espec?fico.
 	 *
 	 * @param id_sucursal int Id de la sucursal
 	 **/
  static function Detalles
	(
		$id_sucursal
	);  
  
  
	
  
	/**
 	 *
 	 *Edita los datos de una sucursal
 	 *
 	 * @param id_sucursal int Id de la sucursal a modificar
 	 * @param activo bool Indica si esta sucursal estar activa
 	 * @param descripcion string Descripcion de la sucursal
 	 * @param direccion json Objeto que contiene la informacin sobre al direccion
 	 * @param id_gerente int Id del gerente de la sucursal
 	 * @param id_tarifa int Id de la tarifa por default de la sucursal
 	 **/
  static function Editar
	(
		$id_sucursal, 
		$activo = null, 
		$descripcion = null, 
		$direccion = null, 
		$id_gerente = null, 
		$id_tarifa = null
	);  
  
  
	
  
	/**
 	 *
 	 *Desactiva una sucursal. Para poder desactivar una sucursal su saldo a favor tiene que ser mayor a cero y sus almacenes tienen que estar vacios.
 	 *
 	 * @param id_sucursal int Id de la sucursal a desactivar
 	 **/
  static function Eliminar
	(
		$id_sucursal
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la gerencia de una sucursal
 	 *
 	 * @param id_gerente string Id del nuevo gerente
 	 * @param id_sucursal int Id de la sucursal de la cual su gerencia sera cambiada
 	 **/
  static function EditarGerencia
	(
		$id_gerente, 
		$id_sucursal
	);  
  
  
	
  
	/**
 	 *
 	 *M?todo que crea una nueva sucursal
 	 *
 	 * @param descripcion string Descripcion de la sucursal
 	 * @param direccion json Objeto que contiene la informacin sobre al direccin 
 	 * @param id_tarifa int Id de la tarifa por default que tendra esa sucursal
 	 * @param activo bool Si esta sucursal estara activa inmediatamente despues de ser creada
 	 * @param id_gerente int ID del usuario que sera gerente de esta sucursal. Para que sea valido este usuario debe tener el nivel de acceso apropiado.
 	 * @return id_sucursal int Id autogenerado de la sucursal que se creo.
 	 **/
  static function Nueva
	(
		$descripcion, 
		$direccion, 
		$id_tarifa, 
		$activo =  1 , 
		$id_gerente = null
	);  
  
  
	
  }
