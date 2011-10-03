<?php
/**
  *
  *
  *
  **/

  interaface IClientes {
  
  
	/**
 	 *
 	 *Regresa una lista de clientes. Puede filtrarse por empresa, sucursal, activos, as� como ordenarse seg�n sus atributs con el par�metro orden. Es posible que algunos clientes sean dados de alta por un admnistrador que no les asigne algun id_empresa, o id_sucursal.

<br/><br/><b>Update : </b> �Es correcto que contenga el argumento id_sucursal? Ya que as� como esta entiendo que solo te regresara los datos de los clientes de una sola sucursal.
 	 *
 	 **/
	protected function Lista();  
  
  
  
  
	/**
 	 *
 	 *Crear un nuevo cliente. Para los campos de Fecha_alta y Fecha_ultima_modificacion se usar� la fecha actual del servidor. El campo Agente y Usuario_ultima_modificacion ser�n tomados de la sesi�n activa. Para el campo Sucursal se tomar� la sucursal activa donde se est� creando el cliente. 
<br><br>
Al crear un cliente se le creara un usuario para la interfaz de cliente y pueda ver sus facturas y eso, si tiene email. Al crearse se le enviara un correo electronico con el url.
 	 *
 	 **/
	protected function Nuevo();  
  
  
  
  
	/**
 	 *
 	 *Edita la informaci�n de un cliente. El campo fecha_ultima_modificacion ser� llenado con la fecha actual del servidor. El campo Usuario_ultima_modificacion ser� llenado con la informaci�n de la sesi�n activa.
 	 *
 	 **/
	protected function Editar_perfil();  
  
  
  
  
	/**
 	 *
 	 *Edita la informaci�n de un cliente. Se diferenc�a del m�todo editar_perfil en qu� est� m�todo modifica informaci�n m�s sensible del cliente. El campo fecha_ultima_modificacion ser� llenado con la fecha actual del servidor. El campo Usuario_ultima_modificacion ser� llenado con la informaci�n de la sesi�n activa.

Si no se envia alguno de los datos opcionales del cliente. Entonces se quedaran los datos que ya tiene.
 	 *
 	 **/
	protected function Editar();  
  
  
  
  
	/**
 	 *
 	 *Obtener los detalles de un cliente.
 	 *
 	 **/
	protected function Detalle();  
  
  
  
  
	/**
 	 *
 	 *Los cliente forzosamente pertenecen a una categoria. En base a esta categoria se calcula el precio que se le dara en una venta, o el descuento, o el credito.
 	 *
 	 **/
	protected function NuevaClasificacion();  
  
  
  
  
	/**
 	 *
 	 *Obtener una lista de las categorias de clientes actuales en el sistema. Se puede ordenar por sus atributos
 	 *
 	 **/
	protected function ListaClasificacion();  
  
  
  
  
	/**
 	 *
 	 *Edita la informacion de la clasificacion de cliente
 	 *
 	 **/
	protected function EditarClasificacion();  
  
  
  
  }
