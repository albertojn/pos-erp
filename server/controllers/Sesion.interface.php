<?php
/**
  *
  *
  *
  **/

  interaface ISesion {
  
  
	/**
 	 *
 	 *Regresa un url de redireccion seg�n el tipo de usuario.
 	 *
 	 **/
	protected function Cerrar();  
  
  
  
  
	/**
 	 *
 	 *Valida las credenciales de un usuario y regresa un url a donde se debe de redireccionar. Este m�todo no necesita de ning�n tipo de autenticaci�n. 
Si se detecta un tipo de usuario inferior a admin y no se ha llamado antes a api/sucursal/revisar_sucursal se regresar� un 403 Authorization Required y la sesi�n no se iniciar�.
Si el usuario que esta intentando iniciar sesion, esta descativado... 403 Authorization Required supongo
 	 *
 	 **/
	protected function Iniciar();  
  
  
  
  
	/**
 	 *
 	 *Obtener las sesiones activas.
 	 *
 	 **/
	protected function Lista();  
  
  
  
  }
