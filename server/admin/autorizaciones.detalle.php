<?php


require_once('model/autorizacion.dao.php');
require_once('model/usuario.dao.php');
require_once('model/sucursal.dao.php');
require_once('model/inventario.dao.php');
require_once('model/cliente.dao.php');

$autorizacion = AutorizacionDAO::getByPK( $_REQUEST['id'] );
$autorizacionDetalles = json_decode( $autorizacion->getParametros() );

$usuario = UsuarioDAO::getByPK( $autorizacion->getIdUsuario() );
$sucursal = SucursalDAO::getByPK( $autorizacion->getIdSucursal() );

?>



<script>
function contestar(id, response){

    jQuery.ajaxSettings.traditional = true;

    jQuery.ajax({
      url: "../proxy.php",
      data: { 
            action : 208, 
            id_autorizacion : id,
            reply : response ? "1" : "2"
       },
      cache: false,
      success: function(data){
            response = jQuery.parseJSON(data);
            if(response.success == false){
                    return jQuery("#ajax_failure").html(response.reason).show();
            }
            reason = "Autorizacion respondida.";
            window.location = "autorizaciones.php?action=historial&success=true&reason=" + reason;
      }
    });
}


function surtirSuc(id, aut){
    window.location = "inventario.php?action=surtir&sid=" + id+"&aut="+aut;
}
</script>



<?php
	if($usuario){
		$who = $usuario->getNombre();	
	}else{
		$who = "Admin";
	}
?>

<h1>Detalles de autorizacion</h1>
<h2>Detalles de la autorizacion</h2>

<table border="0" cellspacing="5" cellpadding="5">
	<tr><td><b>ID Autorizacion</b></td><td><?php    echo $autorizacion->getIdAutorizacion(); ?></td></tr>
	<tr><td><b>Usuario</b></td><td><?php            echo $who; ?></td></tr>
	<tr><td><b>Sucursal</b></td><td><?php           echo $sucursal->getDescripcion(); ?></td></tr>
	<tr><td><b>Fecha de peticion</b></td><td><?php  echo toDate($autorizacion->getFechaPeticion()); ?></td></tr>
	<tr><td><b>Descripcion</b></td><td><?php        echo $autorizacionDetalles->descripcion; ?></td></tr>	
	<tr><td><b>Estado</b></td><td> <?php        
	    switch( $autorizacion->getEstado() ){
	        case 0:
	            echo "Sin contestar";
	        break;
	        case 1:
	            echo "Aceptada";
	        break;
	        case 2:
	            echo "Rechazada";
	        break;
	        case 3:
	            echo "En transito";
	        break;
	        case 4:
	            echo "Embarque recibido";
	        break;
	        case 5:
	            echo "Eliminada";
	        break;
	        case 6:
	            echo "Aplicada";
	        break;
	        default:
	            echo "Indefinido (estado {$autorizacion->getEstado()}) ";
	    }
	 ?></td></tr>	

</table>


<?php
switch( $autorizacionDetalles->clave ){

    case "201": 
        //solicitud de autorizcion de gasto
        ?>
            <h2>Solicitud de gasto</h2>
            <table>
                <tr><td>Concepto</td><td><?php echo $autorizacionDetalles->concepto; ?></td></tr>
                <tr><td>Monto</td><td><?php echo $autorizacionDetalles->monto; ?></td></tr>
                <tr><td></td><td><input type=button value="Autorizar" onClick="contestar(<?php echo $_REQUEST['id'] ?>, true)"><input onClick="contestar(<?php echo $_REQUEST['id'] ?>, false)" type=button value="Rechazar"></td></tr>
            </table>
        <?php
        

    break;

    case "202": 
        //cambio de limite de credito
        ?>
            <h2>Solicitud de limite de credito</h2>
            <table>
                <tr><td>Cliente</td><td><?php 
						$foo = ClienteDAO::getByPK($autorizacionDetalles->id_cliente); 
						echo $foo->getNombre(); //$autorizacionDetalles->id_cliente; 
					?></td></tr>
                <tr><td>Cantidad</td><td><?php echo moneyFormat( $autorizacionDetalles->cantidad ); ?></td></tr>
                <tr><td></td><td>
						<?php
						if($autorizacion->getEstado() == "0" ){
							?>
							<h4><input type=button value="Autorizar" onClick="contestar(<?php echo $_REQUEST['id'] ?>, true)">
							<input onClick="contestar(<?php echo $_REQUEST['id'] ?>, false)" type=button value="Rechazar"></h4>							
							<?php
						}

						?>
					</td></tr>
            </table>
        <?php
    break;

    case "203": 
        //devoluciones
        ?>
            <h2>Solicitud de devolucion</h2>
            <table>
                <tr><td>Venta</td><td><?php echo $autorizacionDetalles->id_venta; ?></td></tr>
                <tr><td>Producto</td><td><?php echo $autorizacionDetalles->producto_descripcion; ?></td></tr>                
                <tr><td>Cantidad</td><td><?php echo $autorizacionDetalles->cantidad; ?></td></tr>
                <tr><td>Cantidad Procesada</td><td><?php echo $autorizacionDetalles->cantidad_procesada; ?></td></tr>
                <tr><td></td><td><input type=button value="Autorizar" onClick="contestar(<?php echo $_REQUEST['id'] ?>, true)"><input onClick="contestar(<?php echo $_REQUEST['id'] ?>, false)" type=button value="Rechazar"></td></tr>
            </table>
        <?php


    break;

    case "204": 
        //cambio de precio
        ?>
            <h2>Solicitud de autorización de venta preferencial</h2>
            <table>
                <tr><td><b>Cliente</b</td><td><?php echo $autorizacionDetalles->nombre; ?></td></tr>
                <tr><td colspan = 2>&nbsp;</td></tr>
                <tr><td></td><td><input type=button value="Autorizar" onClick="contestar(<?php echo $_REQUEST['id'] ?>, true)"><input onClick="contestar(<?php echo $_REQUEST['id'] ?>, false)" type=button value="Rechazar"></td></tr>                
            </table>
        <?php

    break;

    case "205": 
        //merma
        ?>
            <h2>Solicitud de merma</h2>
            <table>
                <tr><td>Cliente</td><td><?php echo $autorizacionDetalles->id_compra; ?></td></tr>
                <tr><td>Cantidad</td><td><?php echo $autorizacionDetalles->id_producto; ?></td></tr>
                <tr><td>Cantidad</td><td><?php echo $autorizacionDetalles->cantidad; ?></td></tr>
                <tr><td></td><td><input type=button value="Autorizar" onClick="contestar(<?php echo $_REQUEST['id'] ?>, true)"><input onClick="contestar(<?php echo $_REQUEST['id'] ?>, false)" type=button value="Rechazar"></td></tr>
            </table>
        <?php
    break;

    case "209": 
        //solicitud de surtir
        ?>
            <h2>Solicitud para surtir sucursal / envio de productos</h2>
            <table style="width:100%">
                <tr style="text-align: left;"><th>Producto solicitado</th><th>Cantidad</th></tr>
                <?php
                foreach ($autorizacionDetalles->productos as $producto)
                {
                    ?><tr>
						<td><?php 
								$p = InventarioDAO::getByPK( $producto->id_producto ) ;
								 echo $p->getDescripcion(); 
							?></td>
						<td><?php echo $producto->cantidad; ?></td></tr><?php
                }
                ?>
                <tr><td></td><td></td></tr>
            </table>

            <?php
            if($autorizacion->getEstado()==3){
            ?>
            <h4><input type=button value="Editar" onclick="surtirSuc(<?php echo $autorizacion->getIdSucursal(); ?>, <?php    echo $autorizacion->getIdAutorizacion(); ?>)" ></h4>
            <?php
            }
            if($autorizacion->getEstado() != 4){
	            ?><h4><input type=button value="Cancelar" onclick="surtirSuc(<?php echo $autorizacion->getIdSucursal(); ?>, <?php    echo $autorizacion->getIdAutorizacion(); ?>)" ></h4>
	    	<?php
            }else{
				?><div align=center><h3>Usted ya ha respondido a esta autorizacion.</h3></div><?php
			}
            ?>
            
        <?php

        
    break;


    default: 
}
?>







