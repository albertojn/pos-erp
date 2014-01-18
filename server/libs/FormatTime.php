<?php

function funcion_consignatario($consignatario) {
	return ($consignatario ? "Consignatario" : "----" );
}

function funcion_clasificacion_proveedor($id_clasificacion_proveedor) {
	return (CategoriaContactoDAO::getByPK($id_clasificacion_proveedor) ? CategoriaContactoDAO::getByPK($id_clasificacion_proveedor)->getNombre() : "----" );
}

function funcion_rol($id_rol) {
	return R::DescripcionRolFromId( $id_rol );
}

function funcion_id_categoria_padre( $id_categoria_padre ) {
	if( ! is_numeric($id_categoria_padre) ){
		return "";
	}

	$cat = ClasificacionProductoDAO::getByPk($id_categoria_padre);
	return ($cat ==null)?"":$cat->getNombre();
}

function funcion_categoria_unidad_medida($id_categoria_unidad_medida) {
	$cat = CategoriaUnidadMedidaDAO::getByPK($id_categoria_unidad_medida);
	return $cat->getDescripcion();
}

function funcion_cat_padre_desc( $id_categoria_padre ) {
	$aux = ClasificacionProductoDAO::getByPK($id_categoria_padre);
	return ($aux == null)? "Sin Cat Padre" : $aux->getNombre() ;
}

function getEmpresaNombre($eid) {
	$e = EmpresaDAO::getByPK($eid);
	return $e->getRazonSocial();
}

function funcion_empresa( $id_empresa ) {
	return EmpresaDAO::getByPK($id_empresa) ? EmpresaDAO::getByPK($id_empresa)->getRazonSocial() : "------";
}

function funcion_tipo_almacen( $id_tipo_almacen ) {
	return TipoAlmacenDAO::getByPK($id_tipo_almacen) ? TipoAlmacenDAO::getByPK($id_tipo_almacen)->getDescripcion() : "------";
}

function getUserName($id_usuario) {
	if ( is_null( $u = UsuarioDAO::getByPK( $id_usuario ) ) ) {
		return "ERROR";
	}
	return $u->getNombre( );
}

function td( $inner, $repeat = 0 ) {
	$out = "";
	while ( $repeat -- >= 0) {
		$out .= "<td>" . $inner . "</td>";
	}
	return $out;
}

//cache results
$g_ClasificacionesClienteArray = null;

function cacheClasificaciones() {
	global $g_ClasificacionesClienteArray;
	$g_ClasificacionesCliente = ClasificacionClienteDAO::getAll();

	for ($a = 0 ; $a < sizeof($g_ClasificacionesCliente); $a++) {
		$g_ClasificacionesClienteArray[$g_ClasificacionesCliente[$a]->getIdClasificacionCliente()] = $g_ClasificacionesCliente[$a]->getNombre();
	}
}

function funcion_clasificacion_cliente($id_clasifiacion) {
		global $g_ClasificacionesClienteArray ;

		if (is_null($g_ClasificacionesClienteArray)) {
				cacheClasificaciones();
		}

		if (array_key_exists($id_clasifiacion, $g_ClasificacionesClienteArray)) {
			return $g_ClasificacionesClienteArray[$id_clasifiacion];
		}

		return "";
}

function funcion_gerente( $id_gerente ) {
	return UsuarioDAO::getByPK($id_gerente) ? UsuarioDAO::getByPK($id_gerente)->getNombre() : "------";
}

function funcion_sucursal( $id_sucursal ) {
	return SucursalDAO::getByPK($id_sucursal) ? SucursalDAO::getByPK($id_sucursal)->getRazonSocial() : "------";
}

function funcion_control_billetes( $control_billetes ) {
	return $control_billetes ? "Con control" : "Sin control";
}

function funcion_abierta( $abierta ) {
	return $abierta ? "Abierta" : "Cerrada";
}

function funcion_activo( $activo ) {
	return ($activo) ? "Activo" : "Inactivo";
}
function funcion_servicio($servicio) {
	return ServicioDAO::getByPK($servicio) ? ServicioDAO::getByPK($servicio)->getNombreServicio() : "????";
}

function funcion_usuario_venta($usuario_venta) {
	return UsuarioDAO::getByPK($usuario_venta) ?
			UsuarioDAO::getByPK($usuario_venta)->getNombre() :
			"<img src='../../media/iconos/user_delete.png'> Nadie esta asignado";
}

function funcion_activa($activa) {
	return ($activa) ? "Activa" : "Inactiva";
}

function funcion_cancelada($cancelada) {
	return ($cancelada) ? "Cancelada" : "No Cancelada";
}

function funcion_cancelado( $cancelado ) {
	return $cancelado ? "Cancelado" : "Activo" ;
}

function FormatMoney($float) {
	return "$" . number_format( $float, 2, '.', ',');
}

function username($id_usuario) {
	$u = UsuarioDAO::getBypK($id_usuario);
	if(is_null($u)) return "ERROR";
	return  $u->getNombre();
}

function ft($time) {
	return FormatTime(($time));
}

function FormatTime($timestamp, $type = "FB")
{
	if($timestamp === NULL){
		return "<span>&nbsp;</span>";
	}

	if(!is_numeric($timestamp))
	{
		$timestamp = strtotime($timestamp);
	}

	// Get time difference and setup arrays
	$difference = time() - $timestamp;
	$periods = array("segundo", "minuto", "hora", "dia", "semana", "mes", "years");
	$lengths = array("60","60","24","7","4.35","12");

	// Past or present
	if ($difference >= 0)
	{
		$ending = "Hace";
	}
	else
	{
		$difference = -$difference;
		$ending = "Dentro de";
	}

	// Figure out difference by looping while less than array length
	// and difference is larger than lengths.
	$arr_len = count($lengths);
	for($j = 0; $j < $arr_len && $difference >= $lengths[$j]; $j++)
	{
		$difference /= $lengths[$j];
	}

	// Round up
	$difference = round($difference);

	// Make plural if needed
	if($difference != 1)
	{
		$periods[$j].= "s";
	}

	// Default format
	$text = "$ending $difference $periods[$j]";

	// over 24 hours
	if($j > 2)
	{
		// future date over a day formate with year
		if($ending == "to go")
		{
			if($j == 3 && $difference == 1)
			{
				$text = "Ayer a las ". date("g:i a", $timestamp);
			}
			else
			{
				$text = date("F j, Y \a \l\a\s g:i a", $timestamp);
			}
			return $text;
		}

		if($j == 3 && $difference == 1) // Yesterday
		{
			$text = "Ayer a las ". date("g:i a", $timestamp);
		}
		else if($j == 3) // Less than a week display -- Monday at 5:28pm
		{
			$text = date(" \a \l\a\s g:i a", $timestamp);

			switch(date("l", $timestamp)){
				case "Monday": 		$text = "Lunes" . $text; break;
				case "Tuesday": 	$text = "Martes" . $text; break;
				case "Wednesday": 	$text = "Miercoles" . $text; break;
				case "Thursday": 	$text = "Jueves" . $text; break;
				case "Friday": 		$text = "Viernes" . $text; break;
				case "Saturday": 	$text = "Sabado" . $text; break;
				case "Sunday": 		$text = "Domingo" . $text; break;

			}
		}
		else if($j < 6 && !($j == 5 && $difference == 12)) // Less than a year display -- June 25 at 5:23am
		{
			$text = date(" j \a \l\a\s g:i a", $timestamp);

			switch(date("F", $timestamp)){
				case "January": 	$text = "Enero" 	. $text; break;
				case "February": 	$text = "Febrero" 	. $text; break;
				case "March": 		$text = "Marzo" 	. $text; break;
				case "April": 		$text = "Abril" 	. $text; break;
				case "May": 		$text = "Mayo" 	. $text; break;
				case "June": 		$text = "Junio" 	. $text; break;
				case "July": 		$text = "Julio" 	. $text; break;
				case "August": 		$text = "Agosto" 	. $text; break;
				case "September": 		$text = "Septiembre" 	. $text; break;
				case "October": 		$text = "Octubre" 	. $text; break;
				case "November": 		$text = "Noviembre" 	. $text; break;
				case "December": 		$text = "Diciembre" 	. $text; break;
			}
		}
		else // if over a year or the same month one year ago -- June 30, 2010 at 5:34pm
		{
			$text = date(" j, Y \a \l\a\s g:i a", $timestamp);

			switch(date("F", $timestamp)){
				case "January": 	$text = "Enero" 	. $text; break;
				case "February": 	$text = "Febrero" 	. $text; break;
				case "March": 		$text = "Marzo" 	. $text; break;
				case "April": 		$text = "Abril" 	. $text; break;
				case "May": 		$text = "Mayo" 	. $text; break;
				case "June": 		$text = "Junio" 	. $text; break;
				case "July": 		$text = "Julio" 	. $text; break;
				case "August": 		$text = "Agosto" 	. $text; break;
				case "September": 		$text = "Septiembre" 	. $text; break;
				case "October": 		$text = "Octubre" 	. $text; break;
				case "November": 		$text = "Noviembre" 	. $text; break;
				case "December": 		$text = "Diciembre" 	. $text; break;
			}
		}
	}

	return "<span title='".date("F j, Y \a \l\a\s g:i a", $timestamp)."'> " . $text . "</span>";
}

	/**
	 *
	 * Regresa el numero de dias de un mes y anio especificado
	 *
	 * @author Juan Manuel Garc&iacute;a Carmona <manuel@caffeina.mx>
	 *
	 * @param mes int
	 * @param anio int
	 * @return diasMes int numero de dias que tiene el mes indicadom, del anio indicado
	 **/
function getUltimoDiaDelMes( $mes, $anio )
{

	/*
		Los meses 1,3,5,7,8,10,12 siempre tienen 31 días
		Los meses 4,6,9,11 siempre tienen 30 días
		El único problema es el mes de febrero dependiendo del año puede tener 28 o 29 días
	*/
	if( ($mes == 1) || ($mes == 3) || ($mes == 5) || ($mes == 7) || ($mes == 8) || ($mes == 10) || ($mes == 12) ) {
		return 31;
	}else if( ($mes == 4) || ($mes == 6) || ($mes == 9) || ($mes == 11) ){
		return 30;
	}else if( $mes == 2 ){
		if( ($anio % 4 == 0) && ($anio % 100 != 0) || ($anio % 400 == 0) ){
			return 29;
		}else{
			return 28;
		}
	}
}

