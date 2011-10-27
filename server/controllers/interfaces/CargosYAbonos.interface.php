<?php
/**
  *
  *
  *
  **/
	
  interface ICargosYAbonos {
  
  
	/**
 	 *
 	 *Edita la informaci?n de un abono
 	 *
 	 * @param id_abono int Id del abono a editar
 	 * @param motivo_cancelacion string Motivo por el cual se cancelo el abono
 	 * @param nota string Nota del abono
 	 * @param compra bool Si el abono a editar fue a una compra
 	 * @param venta bool Si el abono a editar fue a una venta
 	 * @param prestamo bool Si el abono a editar fue a un prestamo
 	 **/
  static function EditarAbono
	(
		$id_abono, 
		$motivo_cancelacion = "", 
		$nota = "", 
		$compra = null, 
		$venta = null, 
		$prestamo = null
	);  
  
  
	
  
	/**
 	 *
 	 *Cancela un abono
 	 *
 	 * @param id_abono int Id del abono a cancelar
 	 * @param id_caja int Id de la caja a la que ira el monto del abono cancelado. Solo se tomara en cuenta si la compra, venta o prestamo no ha sido cancelada antes.
 	 * @param prestamo bool Si el prestamo a eliminar es a un prestamo o no
 	 * @param motivo_cancelacion string Motivo por el cual se realiza la cancelacion
 	 * @param compra bool Si el abono a eliminar es a una compra o no
 	 * @param venta bool Si el abono a eliminar es a una venta o no
 	 * @param billetes json Si la caja que ha sido pasada para depositar el monto lleva un control de billetes, se necesitan pasar los billetes que seran almacenados en la misma
 	 **/
  static function EliminarAbono
	(
		$id_abono, 
		$id_caja = null, 
		$prestamo = null, 
		$motivo_cancelacion = null, 
		$compra = null, 
		$venta = null, 
		$billetes = null
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los abonos, puede filtrarse por empresa, por sucursal, por caja, por usuario que abona y puede ordenarse segun sus atributos
 	 *
 	 * @param compra bool Si se listaran solo abonos hechos a compras
 	 * @param venta bool Si se listaran abonos hechos a ventas
 	 * @param prestamo bool Si se listaran abonos hechos a prestamos
 	 * @param fecha_maxima string Se listaran los abonos cuya fecha sea menor que este valor
 	 * @param monto_mayor_a float Se listaran los abonos cuyo monto sea mayor a este
 	 * @param fecha_minima string Se listaran los abonos cuya fecha sea mayor que este valor
 	 * @param id_sucursal int Id de la sucursal de la cual se mostraran los abonos
 	 * @param fecha_actual bool Se listaran los abonos tengan la fecha de hoy
 	 * @param id_usuario int Id del usuario del cual se mostraran los abonos que ha realizado. En caso de tratarse de compras, se mostraran los abonos que se han hecho a este vendedor.
 	 * @param id_compra int Id de la compra de la cual se listaran los abonos
 	 * @param orden json Objeto que indicara el orden en que se mostrara la lista
 	 * @param id_caja int Id de la caja de la cual se mostraran los abonos
 	 * @param monto_menor_a float Se listaran los abonos cuyo monto sea menor a este
 	 * @param id_empresa int Id de la empresa de la cual se mostraran los abonos
 	 * @param id_prestamo int Id del prestamo del cual se listaran los abonos
 	 * @param cancelado bool Si este valor es verdadero, se listaran los abonos cancelados
 	 * @param id_venta int Id de la venta de la cual se listaran los abonos
 	 * @param monto_igual_a float Se listaran los abonos cuyo monto sea igual a este
 	 * @return abonos json Objeto que contendra la lista de abonos
 	 **/
  static function ListaAbono
	(
		$compra, 
		$venta, 
		$prestamo, 
		$fecha_maxima = null, 
		$monto_mayor_a = null, 
		$fecha_minima = null, 
		$id_sucursal = "", 
		$fecha_actual = null, 
		$id_usuario = "", 
		$id_compra = null, 
		$orden = "", 
		$id_caja = "", 
		$monto_menor_a = null, 
		$id_empresa = "", 
		$id_prestamo = null, 
		$cancelado = null, 
		$id_venta = null, 
		$monto_igual_a = null
	);  
  
  
	
  
	/**
 	 *
 	 *Se crea un  nuevo abono, la caja o sucursal y el usuario que reciben el abono se tomaran de la sesion. La fecha se tomara del servidor
 	 *
 	 * @param monto float monto abonado de la sucursal
 	 * @param id_deudor int Id del usuario o la sucursal que realiza el abono, las sucursales seran negativas.En el caso de las compras, este campo sera el receptor, y el deudor sera tomado del sistema. 
 	 * @param tipo_pago json JSON con la informacion que describe el tipo de pago, si es con cheque, en efectivo o con tarjeta
 	 * @param id_prestamo int Id del prestamo al que se le esta abonando
 	 * @param cheques json Se toma el nombre del banco, el monto y los ultimos cuatro numeros del o los cheques usados para este abono
 	 * @param billetes json Ids de los billetes y sus cantidades que se reciben en caso de que la caja lleve un control de billetes
 	 * @param id_compra int Id de la compra a la que se abona
 	 * @param id_venta int Id de la venta a la que se le abona
 	 * @param nota string Nota del abono
 	 * @return id_abono int El id autogenerado del abono de la sucursal
 	 **/
  static function NuevoAbono
	(
		$monto, 
		$id_deudor, 
		$tipo_pago, 
		$id_prestamo = null, 
		$cheques = null, 
		$billetes = null, 
		$id_compra = null, 
		$id_venta = null, 
		$nota = null
	);  
  
  
	
  
	/**
 	 *
 	 *Edita la informaci?n de un concepto de gasto

Update : Se deber?a de tomar de la sesi?n el id del usuario que hiso la ultima modificaci?n y la fecha.
 	 *
 	 * @param id_concepto_gasto int Id del concepto de gasto a modificar
 	 * @param descripcion string Descripcion larga del concepto de gasto
 	 * @param nombre string Justificacion del concepto de gasto que aparecera despues de la leyenda "gasto por concepto de"
 	 * @param monto float monto fijo del concepto de gasto
 	 **/
  static function EditarConceptoGasto
	(
		$id_concepto_gasto, 
		$descripcion = null, 
		$nombre = null, 
		$monto = null
	);  
  
  
	
  
	/**
 	 *
 	 *Deshabilita un concepto de gasto
Update :Se deber?a de tomar tambi?n de la sesi?n el id del usuario y fecha de la ultima modificaci?n
 	 *
 	 * @param id_concepto_gasto int Id del concepto que ser eliminado
 	 **/
  static function EliminarConceptoGasto
	(
		$id_concepto_gasto
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los conceptos de gasto. Se puede ordenar por los atributos de concepto de gasto
Update : Falta especificar los parametros y el ejemplo de envio.
 	 *
 	 * @param orden string Nombre de la columna mediante la cual se ordenara la lista
 	 * @param activo bool Si este valo no es obtenido, se listaran tanto activos como inactivos. Si es verdadero, se listaran solo los activos, si es falso, se listaran solo los inactivos
 	 * @return conceptos_gasto json Arreglo que contendrá la información de conceptos de gasto.
 	 **/
  static function ListaConceptoGasto
	(
		$orden = null, 
		$activo = null
	);  
  
  
	
  
	/**
 	 *
 	 *Registra un nuevo concepto de gasto

Update : En la respuesta basta con solo indicar success : true | false, y en caso de fallo indicar el por que.
 	 *
 	 * @param nombre string la justificacion que aparecera despues de la leyenda "gasto por concepto de"
 	 * @param descripcion string Descripcion larga del concepto de gasto
 	 * @param monto float Monto fijo del concepto de gasto
 	 * @return id_concepto_gasto int Id autogenerado por la inserción del nuevo gasto
 	 **/
  static function NuevoConceptoGasto
	(
		$nombre, 
		$descripcion = null, 
		$monto = null
	);  
  
  
	
  
	/**
 	 *
 	 *Editar los detalles de un gasto.
Update :  Tambien se deberia de tomar  de la sesion el id del usuario qeu hiso al ultima modificacion y una fecha de ultima modificacion.
 	 *
 	 * @param id_gasto int Id que hace referencia a este gasto
 	 * @param id_concepto_gasto int Id del concepto del gasto
 	 * @param folio string Folio de la factura de ese gasto
 	 * @param fecha_gasto string Fecha que el usuario selecciona en el sistema, a la cual le quiere asignar el gasto.
 	 * @param nota string Informacion adicinal sobre el gasto
 	 * @param descripcion string Descripcion del gasto en caso de que no este en la lista de conceptos.
 	 **/
  static function EditarGasto
	(
		$id_gasto, 
		$id_concepto_gasto = null, 
		$folio = null, 
		$fecha_gasto = null, 
		$nota = null, 
		$descripcion = null
	);  
  
  
	
  
	/**
 	 *
 	 *Cancela un gasto 
 	 *
 	 * @param id_gasto int Id del gasto a eliminar
 	 * @param motivo_cancelacion string Motivo por el cual se realiza la cancelacion
 	 * @param id_caja int Id de la caja a la que regresara el dinero del gasto cancelado
 	 * @param billetes json Ids de los billetes con sus cantidades en caso de que la caja lleve control de los billetes
 	 **/
  static function EliminarGasto
	(
		$id_gasto, 
		$motivo_cancelacion = "", 
		$id_caja = null, 
		$billetes = null
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los gastos, se puede filtrar de acuerdo a la empresa, la sucursal, el usuario que registra el gasto, el concepto de gasto, la orden de servicio, la caja de la cual se sustrajo el dinero para pagar el gasto, de una fecha inicial a una final, por monto, por cancelacion, y se puede ordenar de acuerdo a ss atributos.
 	 *
 	 * @param monto_maximo float Se listaran los gastos cuyo monto sea menor a este valor
 	 * @param orden string Nombre de la columna por la cual se ordenara la lista
 	 * @param monto_minimo float Se listaran los gastos cuyo monto sea mayor a este valor
 	 * @param id_usuario int Id del usuario del cual se listaran los gastos que ha registrado
 	 * @param id_empresa int Id de la empresa de la cual se listaran sus gastos
 	 * @param id_orden_servicio int Se listaran los gastos que pertenezcan solamente a esta orden de servicio
 	 * @param id_concepto_gasto int Se listaran solo los gastos que tengan como concepto este id
 	 * @param id_caja int Id de caja de la cual se listaran los gastos que ha financiado
 	 * @param fecha_final string Se listaran los gastos cuya fecha de gasto sea menor a esta fecha
 	 * @param fecha_inicial string Se listaran los gastos cuya fecha de gasto sea mayor a esta fecha
 	 * @param id_sucursal int Id de la sucursal de la cual se listaran sus gastos
 	 * @param cancelado bool Si este valor no es obtenido, se listaran los gastos tanto cancelados como no cancelados. Si es true, se listaran solo los gastos cancelados, si es false, se listaran solo los gastos que no han sido cancelados
 	 * @param fecha_actual bool Verdader si se listaran los gastos del di ade hoy
 	 **/
  static function ListaGasto
	(
		$monto_maximo = "", 
		$orden = null, 
		$monto_minimo = "", 
		$id_usuario = "", 
		$id_empresa = "", 
		$id_orden_servicio = "", 
		$id_concepto_gasto = "", 
		$id_caja = "", 
		$fecha_final = "", 
		$fecha_inicial = "", 
		$id_sucursal = "", 
		$cancelado = "", 
		$fecha_actual = null
	);  
  
  
	
  
	/**
 	 *
 	 *Registrar un gasto. El usuario y la sucursal que lo registran ser?n tomados de la sesi?n actual.

Update :Ademas deber?a tambi?n de tomar la fecha de ingreso del gasto del servidor y agregar tambi?n como par?metro una fecha a la cual se deber?a de aplicar el gasto. Por ejemplo si el d?a 09/09/11 (viernes) se tomo dinero para pagar la luz, pero resulta que ese d?a se olvidaron de registrar el gasto y lo registran el 12/09/11 (lunes). Entonces tambien se deberia de tomar como parametro una fecha a la cual aplicar el gasto, tambien se deberia de enviar como parametro una nota
 	 *
 	 * @param fecha_gasto string Fecha del gasto
 	 * @param id_empresa int Id de la empresa a la que pertenece este gasto
 	 * @param monto float Monto del gasto en caso de que no este contemplado por el concepto de gasto o sea diferente a este
 	 * @param id_sucursal int Id de la sucursal a la que pertenece este gasto
 	 * @param id_caja int Id de la caja de la que se sustrae el dinero para pagar el gasto
 	 * @param id_orden_de_servicio int Id de la orden del servicio que genero este gasto
 	 * @param id_concepto_gasto int Id del concepto al que  hace referencia el gasto
 	 * @param descripcion string Descripcion del gasto en caso de que no este contemplado en la lista de concpetos de gasto
 	 * @param folio string Folio de la factura del gasto
 	 * @param nota string Nota del gasto
 	 * @return id_gasto int Id generado por la inserción del nuevo gasto
 	 **/
  static function NuevoGasto
	(
		$fecha_gasto, 
		$id_empresa, 
		$monto = null, 
		$id_sucursal = null, 
		$id_caja = null, 
		$id_orden_de_servicio = null, 
		$id_concepto_gasto = null, 
		$descripcion = null, 
		$folio = null, 
		$nota = null
	);  
  
  
	
  
	/**
 	 *
 	 *Edita un concepto de ingreso
 	 *
 	 * @param id_concepto_ingreso int Id del concepto de ingreso a modificar
 	 * @param descripcion string Descripcion larga del concepto de ingreso
 	 * @param monto float Si este concepto tiene un monto fijo, se debe mostrar aqui. Si no hay un monto fijo, dejar esto como null.
 	 * @param nombre string Justificacion que aparecera despues de la leyenda "ingreso por concepto de"
 	 **/
  static function EditarConceptoIngreso
	(
		$id_concepto_ingreso, 
		$descripcion = null, 
		$monto = null, 
		$nombre = null
	);  
  
  
	
  
	/**
 	 *
 	 *Deshabilita un concepto de ingreso

Update :Se deber?a tambi?n obtener de la sesi?n el id del usuario y fecha de la ultima modificaci?n.
 	 *
 	 * @param id_concepto_ingreso int Id del ingreso a eliminar
 	 **/
  static function EliminarConceptoIngreso
	(
		$id_concepto_ingreso
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los conceptos de ingreso, se puede ordenar por los atributos del concepto de ingreso.  

Update :Falta especificar la estructura del JSON que se env?a como parametro
 	 *
 	 * @param ordenar json Valor que indicar la forma en que se ordenar la lista
 	 * @return conceptos_ingreso json Arreglo que contendrá la información de los conceptos de ingreso
 	 **/
  static function ListaConceptoIngreso
	(
		$ordenar = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crea un nuevo concepto de ingreso

Update : En la respuesta basta con solo indicar success : true | false, y en caso de fallo indicar el por que.
 	 *
 	 * @param nombre string Justificacion que aparecer despus de la leyenda "ingreso por concepto de"
 	 * @param monto float Monto fijo del concepto de ingreso
 	 * @param descripcion string Descripcion larga de este concepto de ingreso
 	 * @return id_concepto_ingreso int Id autogenerado por la creacion del nuevo concepto de ingreso
 	 **/
  static function NuevoConceptoIngreso
	(
		$nombre, 
		$monto = null, 
		$descripcion = null
	);  
  
  
	
  
	/**
 	 *
 	 *Edita un ingreso

Update :El usuario y la fecha de la ultima modificaci?n se deber?an de obtener de la sesi?n
 	 *
 	 * @param id_ingreso int Id del ingreso que se editar
 	 * @param folio string Folio de la factura generada por el ingreso
 	 * @param fecha_ingreso string Fecha que el usuario selecciona en el sistema, a la cual le quiere asignar el ingreso.
 	 * @param nota string Informacion adicional del ingreso
 	 * @param descripcion string Descripciond el ingreso en caso de que no se encentre en la lista de conceptos.
 	 * @param id_concepto_ingreso int Id del concepto del ingreso
 	 **/
  static function EditarIngreso
	(
		$id_ingreso, 
		$folio = null, 
		$fecha_ingreso = null, 
		$nota = null, 
		$descripcion = null, 
		$id_concepto_ingreso = null
	);  
  
  
	
  
	/**
 	 *
 	 *Cancela un ingreso
 	 *
 	 * @param id_ingreso int Id del ingreso a cancelar
 	 * @param motivo_cancelacion string Motivo por el cual se realiza la cancelacion
 	 **/
  static function EliminarIngreso
	(
		$id_ingreso, 
		$motivo_cancelacion = ""
	);  
  
  
	
  
	/**
 	 *
 	 *Lista los ingresos, se puede filtrar de acuerdo a la empresa, la sucursal, el usuario que registra el ingreso, el concepto de ingreso, la caja que recibi? el ingreso, de una fecha inicial a una final, por monto, por cancelacion, y se puede ordenar de acuerdo a sus atributos.
 	 *
 	 * @param id_empresa int Id de la empresa de la cual se listaran sus ingresos
 	 * @param fecha_final string Se listaran los ingresos cuya fecha de ingreso sea menor a este valor
 	 * @param id_sucursal int Id de la sucursal de la cual se listaran sus ingresos
 	 * @param fecha_inicial string Se listaran los ingresos cuya fecha de ingreso sea mayor a este valor
 	 * @param id_concepto_ingreso int Se listaran los ingresos que tengan este concepto de ingreso
 	 * @param id_caja int Id de la caja de la cual se listaran los ingresos que ha recibido
 	 * @param monto_maximo float Se listaran los ingresos cuyo monto sea menor a este valor
 	 * @param monto_minimo float Se listaran los ingresos cuyo monto sea mayor a este valor
 	 * @param id_usuario int Id del usuario del cual se listaran los ingresos que ha registrado
 	 * @param cancelado bool Si este valor no es obtenido, se listaran tanto ingresos cancelados como no cancelados, si es true, solo se listaran los ingresos cancelados, si es false, se listaran solo los ingresos no cancelados
 	 * @param fecha_actual bool verdaderi si solo se listaran los ingresos del dia de hoy
 	 * @param orden string Nombre de la columna mediante la cual se ordenara la lista
 	 **/
  static function ListaIngreso
	(
		$id_empresa = "", 
		$fecha_final = "", 
		$id_sucursal = "", 
		$fecha_inicial = "", 
		$id_concepto_ingreso = "", 
		$id_caja = "", 
		$monto_maximo = "", 
		$monto_minimo = "", 
		$id_usuario = "", 
		$cancelado = "", 
		$fecha_actual = null, 
		$orden = null
	);  
  
  
	
  
	/**
 	 *
 	 *Registra un nuevo ingreso
 	 *
 	 * @param id_empresa int Id de la empresa a la que pertenece este ingreso
 	 * @param fecha_ingreso string Fecha del ingreso
 	 * @param descripcion string Descripcion del ingreso en caso de no este contemplado en la lista de conceptos de ingreso
 	 * @param nota string Nota del ingreso
 	 * @param folio string Folio de la factura del ingreso
 	 * @param id_sucursal int Id de la caja a la que pertenece este ingreso
 	 * @param id_concepto_ingreso int Id del concepto al que hace referencia el ingreso
 	 * @param id_caja int Id de la caja en la que se registra el ingreso
 	 * @param monto float Monto del ingreso en caso de que no este contemplado por el concepto de ingreso o que sea diferente
 	 * @param billetes json Ids de los billetes con sus cantidades en las que ingresaran a la caja en caso de que la caja lleve control de billetes
 	 * @return id_ingreso int Id autogenerado por la insercion del ingreso
 	 **/
  static function NuevoIngreso
	(
		$id_empresa, 
		$fecha_ingreso, 
		$descripcion = null, 
		$nota = null, 
		$folio = null, 
		$id_sucursal = null, 
		$id_concepto_ingreso = "", 
		$id_caja = "", 
		$monto = null, 
		$billetes = null
	);  
  
  
	
  }
