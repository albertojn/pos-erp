<?php

require_once("model/usuario.dao.php");



?>

<script src="../frameworks/jquery/jquery-1.4.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="../frameworks/uniform/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script> 
<link rel="stylesheet" href="../frameworks/uniform/css/uniform.default.css" type="text/css" media="screen">
<script type="text/javascript" charset="utf-8"> $(function(){ $("input, select").uniform(); }); </script>

<script>
	function test()
	{
			if($('#p1').val() != $('#p2').val()){
				alert('las contasenas no coinciden');
				return false;
			}

			send();
	}
	
	
	function send(){
		data = {
			RFC : $('#rfc').val(),
			nombre : $('#nombre').val(),
			contrasena : hex_md5( $('#p2').val() ),
			sucursal : null,
			salario : null,
			grupo : $('#gpo').val()

		};
       jQuery.ajaxSettings.traditional = true;

        $.ajax({
	      url: "../proxy.php",
	      data: { 
            action : 500, 
            data : $.JSON.encode(data)
           },
	      cache: false,
	      success: function(data){
		        response = jQuery.parseJSON(data);

                if(response.success == false){
                    window.location = "usuarios.php?action=nuevo&success=false&reason=" + response.reason;
                    return;
                }


                reason = "Nuevo usuario creado exitosamente";
                window.location = 'usuarios.php?action=lista&success=true&reason=' + reason;
	      }
	    });
    }
</script>



<h1>Nuevo Usuario</h1>
<table border="0" cellspacing="5" cellpadding="5">
	<tr><td><b>Nombre</b></td><td>						<input type='text' id='nombre' ></td></tr>
	<tr><td><b>RFC</b></td><td>							<input type='text' id='rfc' ></td></tr>
	<tr><td><b>GRUPO</b></td><td>						<input type='text' id='gpo' placeholder='(0:Ingenieria, 1:Admin)'></td></tr>
	<tr><td><b>Nueva contrase&ntilde;a</b></td><td>		<input type='password' id='p1' ></td></tr>
	<tr><td><b>Repetir contrase&ntilde;a</b></td><td>	<input type='password' id='p2' ></td></tr>
	<tr><td></td><td><input type='button' onClick='test()' value='Guardar'></td></tr>	
</table>
</form>



