<?php
require_once("interfaces/Contactos.interface.php");
/**
  *
  *
  *
  **/
	
  class ContactosController implements IContactos{
  
	/* - - - - - CRUD de categorias de contactos - - - - - */

	/**
	*
	*Crear una nueva categoria de contactos en base a los parametros obtenidos.
	*
 	 * @param nombre string El nombre de la categoria a crear.
 	 * @param activa bool El estado de la categoria a crear,
 	 * @param descripcion string Descripcion de la categoria a crear.
 	 * @param padre_id int El ID del padre de la categoria a crear.
 	 * @return id_categoria int El ID de la categoria recien creada.
 	 **/
	public static function NuevoCategoria($nombre, $activa=true, $descripcion=null, $id_padre=null) {
  		$categoria = new CategoriaContacto(array(
  			'nombre' => $nombre,
  			'activa' => $activa,
  			'descripcion' => $descripcion,
  			'id_padre' => $id_padre
  		));

  		try {
			CategoriaContactoDAO::save($categoria);
			ContabilidadController::InsertarCuentasCategoriaContactos($nombre,$id_padre);
		} catch (Exception $e) {
			throw new Exception("Error al crear categoria, verifique sus datos.", 901);
		}

  		return array("id_categoria" => ((int) $categoria->getId()));
	}
	
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
	public static function EditarCategoria($id, $activa = null, $descripcion = null, $id_padre = null, $nombre = null)	{
		$categoria = CategoriaContactoDAO::getByPK($id);

		if (!is_null($activa)) {
			$categoria->setActiva($activa);
		}
		if (!is_null($descripcion)) {
			$categoria->setDescripcion($descripcion);
		}
		if (!is_null($id_padre)) {
			$categoria->setIdPadre($id_padre);
		}
		if (!is_null($nombre)) {
			$categoria->setNombre($nombre);
		}

		if (CategoriaContactoDAO::ChecarRecursion($categoria->getId(), $categoria->getIdPadre())) {
			try {
				ContabilidadController::EditarNombreCuentasCategoriaContactos($id, $categoria->nombre,$categoria->id_padre);
				CategoriaContactoDAO::save($categoria);
			} catch (Exception $e) {
				throw new Exception("Error al modificar categoria, verifique sus datos.", 901);
			}
		} else {
			throw new Exception("Una categoria no puede ser hija de otra categoria descendiente, verifique sus datos.", 901);	
		}
	}
	
	/**
	*
	*Lista de categorias coincidentes con los parametros de busqueda.
	*
 	 * @param activa bool Si es null obtener categorias tanto activas como inactivas.
 	 * @param query string Argumento para buscar por nombre completo o descripcion. Si es null, devuelve todas las categorias.
 	 * @return categorias json Lista de categorias obtenidas, o vacía si no se obtiene nada.
 	 **/
	public static function BuscarCategoria($activa=true, $query=null) {
		$categoria = new CategoriaContacto();

		if (!is_null($activa)) {
			$categoria->setActiva($activa);
		}
		if (!is_null($query)) {
			$categoria->setNombre($query);
			$categoria->setDescripcion($query);
		}

		$categorias = CategoriaContactoDAO::search($categoria);

		foreach ($categorias as $key => $categoria) {
			$id_categoria = $categoria->getId();
			$nombre_completo = CategoriaContactoDAO::NombreCompleto($id_categoria);
			$categorias[$key]->nombre_completo = $nombre_completo;
		}

		return array('categorias' => $categorias);
	}
	
	/**
	*
	*Obtener la categoria indicada.
	*
 	 * @param id_categoria int El ID de la categoria a obtener.
 	 * @return categoria json Detalles de la categoria.
 	 **/
	public static function DetallesCategoria($id_categoria) {
		$categoria = CategoriaContactoDAO::getByPK($id_categoria);
		$alert = '';

		if (!is_null($categoria)) {
			$categoria->nombre_completo = CategoriaContactoDAO::NombreCompleto($categoria->getId());
		}

		return array('categoria' => $categoria);
	}
}
