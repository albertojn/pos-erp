<h1>Editar producto</h1>



<script src="../frameworks/jquery/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../frameworks/uniform/jquery.uniform.js" type="text/javascript" charset="utf-8"></script> 
<link rel="stylesheet" href="../frameworks/uniform/css/uniform.default.css" type="text/css" media="screen">

<script type="text/javascript" charset="utf-8">
	$(function(){
      $("input, select").uniform();
    });
</script>
<?php


    require_once('model/inventario.dao.php');
    require_once('model/actualizacion_de_precio.dao.php');
    
    $producto = InventarioDAO::getByPK($_REQUEST['id']);

?>


<h2>Editar descripcion</h2>
<table border="0" cellspacing="5" cellpadding="5">
	<tr><td>Descripcion</td><td><input type="text" value="<?php echo $producto->getDescripcion();?>" size="40"/></td></tr>
	<tr><td></td><td><input type="button" value="Guardar" size="40"/></td></tr>
</table>








<h2>Editar Precio y Costo</h2>

<table border="0" cellspacing="5" cellpadding="5">
	<tr><td>Costo / Precio intersucursal </td><td><input type="text" value="<?php echo $producto->getCosto();?>" size="40"/></td></tr>
	<tr><td>Precio a la venta</td><td><input type="text" value="FALTA" size="40"/></td></tr>
	<tr><td></td><td><input type="button" value="Guardar" size="40"/></td></tr>
</table>
	





