<?php
/**
  *
  *
  *
  **/
	
  interface IContactos {
  
  
	/**
 	 *
 	 *Lista de categor?as coincidentes con los parametros de busqueda.
 	 *
 	 * @param activa bool Si es null obtener categorias tanto activas como inactivas.
 	 * @param query string Argumento para buscar por nombre completo o descripcion. Si es null, devuelve todas las categorias.
 	 * @return categorias json Lista de categorias obtenidas, o vaca si no se obtiene nada.
 	 **/
  static function BuscarCategoria
	(
		$activa =  true , 
		$query = null
	);  
  
  
	
  
	/**
 	 *
 	 *Obtener la categor?a indicada.
 	 *
 	 * @param id_categoria int El ID de la categoria a obtener.
 	 * @return categoria json Detalles de la categoria.
 	 **/
  static function DetallesCategoria
	(
		$id_categoria
	);  
  
  
	
  
	/**
 	 *
 	 *Cambiar los atributos de una categoria especifica.
 	 *
 	 * @param id int El ID de la cateforia a editar.
 	 * @param activa bool El nuevo estado de la categoria especificada.
 	 * @param descripcion string La nueva descripcion de la categoria especificada.
 	 * @param id_padre int El ID del nuevo padre de la categoria especificada.
 	 * @param nombre string El nuevo nombre de la categoria especificada.
 	 **/
  static function EditarCategoria
	(
		$id, 
		$activa = null, 
		$descripcion = null, 
		$id_padre = null, 
		$nombre = null
	);  
  
  
	
  
	/**
 	 *
 	 *Crear una nueva categoria de contactos en base a los parametros obtenidos.
 	 *
 	 * @param nombre string El nombre de la categoria a crear.
 	 * @param activa bool El estado de la categoria a crear,
 	 * @param descripcion string Descripcion de la categoria a crear.
 	 * @param id_padre int El ID del padre de la categoria a crear.
 	 * @return id_categoria int El ID de la categoria recien creada.
 	 **/
  static function NuevoCategoria
	(
		$nombre, 
		$activa =  true , 
		$descripcion = null, 
		$id_padre = null
	);  
  
  
	
  }
