<?php
/**
  *
  *
  *
  **/

  interaface ICargos y abonos {
  
  
	/**
 	 *
 	 *Registra un nuevo ingreso
 	 *
 	 **/
	protected function NuevoIngreso();  
  
  
  
  
	/**
 	 *
 	 *Cancela un abono
 	 *
 	 **/
	protected function EliminarAbono();  
  
  
  
  
	/**
 	 *
 	 *Lista los abonos, puede filtrarse por empresa, por sucursal, por caja, por usuario que abona y puede ordenarse segun sus atributos
 	 *
 	 **/
	protected function ListaAbono();  
  
  
  
  
	/**
 	 *
 	 *Cancela un gasto 
 	 *
 	 **/
	protected function EliminarGasto();  
  
  
  
  
	/**
 	 *
 	 *Lista los gastos, se puede filtrar de acuerdo a la empresa, la sucursal, el usuario que registra el gasto, el concepto de gasto, la orden de servicio, la caja de la cual se sustrajo el dinero para pagar el gasto, de una fecha inicial a una final, por monto, por cancelacion, y se puede ordenar de acuerdo a ss atributos.
 	 *
 	 **/
	protected function ListaGasto();  
  
  
  
  
	/**
 	 *
 	 *Cancela un ingreso
 	 *
 	 **/
	protected function EliminarIngreso();  
  
  
  
  
	/**
 	 *
 	 *Registra un nuevo concepto de gasto

<br/><br/><b>Update :</b> En la respuesta basta con solo indicar success : true | false, y en caso de fallo indicar el por que.
 	 *
 	 **/
	protected function NuevoConceptoGasto();  
  
  
  
  
	/**
 	 *
 	 *Edita la informaci�n de un concepto de gasto

<br/><br/><b>Update : </b>Se deber�a de tomar de la sesi�n el id del usuario que hiso la ultima modificaci�n y la fecha.
 	 *
 	 **/
	protected function EditarConceptoGasto();  
  
  
  
  
	/**
 	 *
 	 *Deshabilita un concepto de gasto
<br/><br/><b>Update :</b>Se deber�a de tomar tambi�n de la sesi�n el id del usuario y fecha de la ultima modificaci�n
 	 *
 	 **/
	protected function EliminarConceptoGasto();  
  
  
  
  
	/**
 	 *
 	 *Crea un nuevo concepto de ingreso

<br/><br/><b>Update :</b> En la respuesta basta con solo indicar success : true | false, y en caso de fallo indicar el por que.
 	 *
 	 **/
	protected function NuevoConceptoIngreso();  
  
  
  
  
	/**
 	 *
 	 *Edita un concepto de ingreso
 	 *
 	 **/
	protected function EditarConceptoIngreso();  
  
  
  
  
	/**
 	 *
 	 *Deshabilita un concepto de ingreso

<br/><br/><b>Update :</b>Se deber�a tambi�n obtener de la sesi�n el id del usuario y fecha de la ultima modificaci�n.
 	 *
 	 **/
	protected function EliminarConceptoIngreso();  
  
  
  
  
	/**
 	 *
 	 *Lista los conceptos de gasto. Se puede ordenar por los atributos de concepto de gasto
<br/><br/><b>Update : </b>Falta especificar los parametros y el ejemplo de envio.
 	 *
 	 **/
	protected function ListaConceptoGasto();  
  
  
  
  
	/**
 	 *
 	 *Lista los conceptos de ingreso, se puede ordenar por los atributos del concepto de ingreso.  

<br/><br/><b>Update :</b>Falta especificar la estructura del JSON que se env�a como parametro
 	 *
 	 **/
	protected function ListaConceptoIngreso();  
  
  
  
  
	/**
 	 *
 	 *Registrar un gasto. El usuario y la sucursal que lo registran ser�n tomados de la sesi�n actual.

<br/><br/><b>Update :</b>Ademas deber�a tambi�n de tomar la fecha de ingreso del gasto del servidor y agregar tambi�n como par�metro una fecha a la cual se deber�a de aplicar el gasto. Por ejemplo si el d�a 09/09/11 (viernes) se tomo dinero para pagar la luz, pero resulta que ese d�a se olvidaron de registrar el gasto y lo registran el 12/09/11 (lunes). Entonces tambien se deberia de tomar como parametro una <b>fecha</b> a la cual aplicar el gasto, tambien se deberia de enviar como parametro una <b>nota</b>
 	 *
 	 **/
	protected function NuevoGasto();  
  
  
  
  
	/**
 	 *
 	 *Editar los detalles de un gasto.
<br/><br/><b>Update : </b> Tambien se deberia de tomar  de la sesion el id del usuario qeu hiso al ultima modificacion y una fecha de ultima modificacion.
 	 *
 	 **/
	protected function EditarGasto();  
  
  
  
  
	/**
 	 *
 	 *Edita un ingreso

<br/><br/><b>Update :</b>El usuario y la fecha de la ultima modificaci�n se deber�an de obtener de la sesi�n
 	 *
 	 **/
	protected function EditarIngreso();  
  
  
  
  
	/**
 	 *
 	 *Se crea un  nuevo abono, la caja o sucursal y el usuario que reciben el abono se tomaran de la sesion. La fecha se tomara del servidor
 	 *
 	 **/
	protected function NuevoAbono();  
  
  
  
  
	/**
 	 *
 	 *Lista los ingresos, se puede filtrar de acuerdo a la empresa, la sucursal, el usuario que registra el ingreso, el concepto de ingreso, la caja que recibi� el ingreso, de una fecha inicial a una final, por monto, por cancelacion, y se puede ordenar de acuerdo a sus atributos.
 	 *
 	 **/
	protected function ListaIngreso();  
  
  
  
  
	/**
 	 *
 	 *Edita la informaci�n de un abono
 	 *
 	 **/
	protected function EditarAbono();  
  
  
  
  }
