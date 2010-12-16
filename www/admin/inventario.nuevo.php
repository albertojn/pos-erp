<h1>Nuevo Producto</h1>

<div class="g-unit g-first nav"> 
	<div class="ga-container-nav-side"> 
	Aqui puede crear nuevos productos..
	</div> 
</div>


<div class="g-unit content"> 
<h2>Detalles del nuevo producto</h2><?php

/*
 * Nuevo Cliente
 */ 

	require_once("model/sucursal.dao.php");
	require_once("controller/clientes.controller.php");


?>

<script src="../frameworks/jquery/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../frameworks/uniform/jquery.uniform.js" type="text/javascript" charset="utf-8"></script> 
<link rel="stylesheet" href="../frameworks/uniform/css/uniform.default.css" type="text/css" media="screen">

<script type="text/javascript" charset="utf-8">
	$(function(){
      $("input, select").uniform();
    });
</script>




<form id="newClient">
<table border="0" cellspacing="5" cellpadding="5">
	<tr><td>Descripcion</td><td><input type="text" id="descripcion" size="40"/></td></tr>
	<tr><td>Precio Venta</td><td><input type="text" id="precioVenta" size="40"/></td></tr>
	<tr><td>Existencias Minimas</td><td><input type="text" id="existenciasMinimas" size="40"/></td></tr>
	<tr><td>Precio Intersucursal/Costo</td><td><input type="text" id="precioIntersucursal" size="40"/></td></tr>
	<tr><td>Medida</td>
		<td>
			<select id="medida"> 
				<option value='fraccion' >Fraccion</option>
				<option value='unidad' >Unidad</option>
	        </select>
		</td>
	</tr>
	<tr><td></td><td><input type="button" onClick="save()" value="Guardar"/> </td></tr>
</table>
</form>



<script type="text/javascript" charset="utf-8">

    function save(){
        //validar
        data = {
                descripcion : $('#descripcion').val(),
                precio_venta : $('#precioVenta').val(),
                exitencias_minimas : $('#existenciasMinimas').val(),
                precio_intersucursal : $('#precioIntersucursal').val(),
                medida : $('#medida').val()
            };

        jQuery.ajaxSettings.traditional = true;


        $.ajax({
	      url: "../proxy.php",
	      data: { 
            action : 405, 
            data : $.JSON.encode(data)
           },
	      cache: false,
	      success: function(data){
		        response = jQuery.parseJSON(data);

                if(response.success == "false"){
                    alert(response.reason);
                    return;
                }


                alert("Los datos se han editado con exito !");
                window.location = "inventario.php?action=detalle&id=" response.id ;
	      }
	    });
    }
</script>


<?php
