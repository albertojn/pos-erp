<?	include_once("AddAllClass.php");
	
	
	function addSucursal(){
		if((!empty($_REQUEST['descripcion']))&&(!empty($_REQUEST['direccion']))){
			$descripcion=$_REQUEST['descripcion'];
			$direccion=$_REQUEST['direccion'];
			$sucursal=new sucursal($descripcion,$direccion);
			if(!$sucursal->existe()){
				if($sucursal->inserta()){
					ok();
				}else				fail("Error al guardar la sucursal.");
			}else 					fail("Ya existe esta sucursal.");
		}else						fail("Faltan datos.");
		return;
	}
	
	function deleteSucursal(){
		if(!empty($_REQUEST['id_sucursal'])){
			$id=$_REQUEST['id_sucursal'];
			$sucursal=new sucursal_existente($id);
			if($sucursal->existe()){
				if($sucursal->borra())		ok();
				else						fail("Error al borrar sucursal.");
			}else 							fail("La sucursal que desea eliminar no existe.");
		}else fail("faltan datos.");
		return;
	}
	
	function cambiaDatos(){
		if((!empty($_REQUEST['id_sucursal']))&&(!empty($_REQUEST['descripcion']))&&(!empty($_REQUEST['direccion']))){
			$id=$_REQUEST['id_sucursal'];
			$descripcion=$_REQUEST['descripcion'];
			$direccion=$_REQUEST['direccion'];
			$sucursal=new sucursal_existente($id);
			if($sucursal->existe()){
			$sucursal->descripcion=$descripcion;
			$sucursal->direccion=$direccion;
				if($sucursal->actualiza())		ok();
				else							fail("Error al modificar la sucursal.");
			}else								fail("La sucursal que desea modificar no existe.");
		}else									fail("Faltan datos.");
		return;
	}
	
	if(!empty($_REQUEST['method']))
	{
		switch($_REQUEST["method"]){
			case "addSucursal" : 			addSucursal(); break;
			case "deleteSucursal" : 		deleteSucursal(); break;
			case "cambiaDatos" : 			cambiaDatos(); break;
			default: echo "-1"; 
		}
	}
?>