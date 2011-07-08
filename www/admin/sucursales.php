<?php
require_once("../../server/bootstrap.php");	
require_once("admin/includes/checkSession.php");
require_once("admin/includes/static.php");

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" >

	
<head>
	<META http-equiv="Content-Type" content="text/html; charset=UTF-8">

	<title>POS | Sucursales</title>
	<script src="http://api.caffeina.mx/jquery/jquery-1.4.2.min.js" type="text/javascript"></script>

	<script>
		$.noConflict();
	</script>
	
	<script type="text/javascript" charset="utf-8" src="http://api.caffeina.mx/prototype/prototype.js"></script>		

	<script src="http://api.caffeina.mx/uniform/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script> 
	<link rel="stylesheet" href="http://api.caffeina.mx/uniform/css/uniform.default.css" type="text/css" media="screen">
	<script type="text/javascript" charset="utf-8">jQuery(function(){jQuery("input, select").uniform();});</script>
		
	<link rel="stylesheet" type="text/css" href="./../getResource.php?mod=admin&type=css">
	<script type="text/javascript" src="./../getResource.php?mod=admin&type=js"></script>

	<link href="http://api.caffeina.mx/facebox/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
	<script src="http://api.caffeina.mx/facebox/facebox.js" type="text/javascript"></script>
	
	
	<link rel="stylesheet" type="text/css" href="http://api.caffeina.mx/ext-latest/resources/css/ext-all.css" /> 
	
	<!-- ExtJS library: base/adapter --> 
    <script type="text/javascript" src="http://api.caffeina.mx/ext-latest/adapter/ext/ext-base.js"></script> 
 
    <!-- ExtJS library: all widgets --> 
    <script type="text/javascript" src="http://api.caffeina.mx/ext-latest/ext-all.js"></script>	
</head>


<body class="sub">
  <div id="wrapper">

    <div id="header" class="clientes" <?php if( POS_STYLE_SUCURSALES_BANNER ) echo " style='background-image: url(". POS_STYLE_SUCURSALES_BANNER .")'"; ?> >
      
      <div id="top-bar">
        
        <?php include_once("admin/includes/mainMenu.php"); ?>
            
      </div> 
      <!-- /top-bar -->

      <div id="header-main">
		<h1 id="MAIN_TITLE">Sucursales</h1> 
      </div>
    </div>
    
    <div id="content">
	<?php
    if(isset($_REQUEST['success'])){

        if($_REQUEST['success'] == 'true'){
            echo "<div class='success'>" . $_REQUEST['reason'] . "</div>";
        }else{
            echo "<div class='failure'>". $_REQUEST['reason'] ."</div>";
        }
    }
    ?>

	<div id="ajax_failure" class="failure" style="display: none;"></div>
	<?php
	 	if(isset($_GET["action"]) && is_file("../../server/admin/sucursales." . $_GET["action"] . ".php")){
    		require_once("admin/sucursales." . $_GET["action"] . ".php");
		}else{
    		echo "<h1>Error</h1><p>El sitio ha encontrado un error, porfavor intente de nuevo usando el menu en la parte de arriba.</p>";
    		echo '<script>document.getElementById("MAIN_TITLE").innerHTML = "Error";</script>';
		}
	?> 
	
    <?php include_once("admin/includes/footer.php"); ?>
    </div> 
    <!-- /content -->
    
    
  </div> 
  <!-- /wrapper -->

</body></HTML>
