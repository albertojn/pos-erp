<?php

if(!class_exists("PHPUnit_Runner_Version")){
		define("BYPASS_INSTANCE_CHECK", true);
		require_once("../server/bootstrap.php");
	}

	if(isset($_POST["t"]) && ($_POST["t"] == "ajax_validation")){
			$r = InstanciasController::validateDemo( $_POST["key"] );

			echo json_encode($r);
			exit;
	}

?><html>
	<head>
		<title>Caffeina POS ERP</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="media/main_site/s.css">
	</head>
	<body style="background-image: url(media/main_site/c.png);
				 background-repeat: no-repeat;
				background-position-x: 50%">

	    <div class="topbar js-topbar">
	      <div class="global-nav" data-section-term="top_nav">
	        <div class="global-nav-inner">
	          <div class="container">
				
	            <ul class="nav js-global-actions">
	              <li class="home">
					<img class="" style="width: 40px; float:left" src="media/main_site/caffeina-logo.png">
	                <a href="http://caffeina.mx">
					<span><i class="nav-home-logged-out"></i></span>
					</a>
	         	 </li>
	            </ul>
	            <div class="pull-right">
	              <ul class="nav secondary-nav">
	              	<li><a href="j/" id="">Staff</a></li>
	                <li><a href="http://labs2.caffeina.mx/public/apis/?repname=pos" id="">API</a></li>
	                <li><a href="mailto:contacto@caffeina.mx" id="">Contacto</a></li>
	              </ul>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div>


	    <div class="blue-sky" >
	      <div class="body-content" >
		
		
			<!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - -  -->
			
			<?php
			 	if(isset($_GET["t"])){
					$t = $_GET["t"];
				}else{
					$t = "signup";
				}
				
				switch($t){ 
					 case "thanks" : ?>	
					
					
					<?php
					
					if(!isset($_POST["email"])){
						//error;
						?>
						<h1>Whoops</h1>
						<?php
						break;
					}
					
					
					$response = InstanciasController::requestDemo($_POST["email"]);

					if($response["success"] === false){
						//
						?><h1>Whoops</h1><br><br><?php
						echo "<center><h2><i>" . $response["error"] . "</i></h2></center><br><br>";
						
						break;
					}
					
					
					?>
					<table border='0'>
					<tr>
						<td rowspan='2'>
							<img class="" style="width: 100px; float:left" src="media/main_site/caffeina-logo.png">
						</td>
						<td>
							<h1>Caffeina POS ERP</h1>
						</td>
					</tr>
					<tr>
						<td>
							<p>
								&nbsp;&nbsp;Planificaci&oacute;n de recursos empresariales en la nube.
							</p>
						</td>
					</tr>
					</table>
					<div style="margin-left: 130px">
						<h2><strong>&#161; Muchas gracias por su interes en POS ERP !</strong></h2>
						<p>Por favor revise su bandeja de correo electronico para continuar con la instalacion de su nueva instancia.</p>

					</div>					
				<?php break; ?><!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
				
				
				
				<?php case "by_email" : ?>
				<?php
					//hacer ajaxaso a t=ajax_validation para crear
					?>
						<div id="response">
							<table border="0">
								<tr><td colspan=2>
									<h2>Bienvenido de regreso.</h2>
								</td></tr>
								<tr>
									<td ><img src="media/loader.gif"></td>
									<td ><p style="padding-top:10px">Por favor espere mientras creamos su nueva instancia.</td>								
								</tr>
							</table>							
						</div>

						<script type="text/javascript" charset="utf-8">
							$(document).ready(function(){
								$.ajax({
								  url: 'index.php',
								  type: 'POST',
								  dataType: 'json',
								  data: {
										t : "ajax_validation",
										key : "<?php echo $_GET["key"]; ?>"
									},
								  success: function(data) {

									if(data.success){
								    	$('#response').html( "<h2>" + data.reason + "</h2>"
										 + "Puede ingresar a su instancia haciendo click " 
										+ "<a href='http://pos2.labs2.caffeina.mx/front_ends/<?php echo $_GET["key"]; ?>/'>aqui</a>. "
										+ "Tambien hemos enviado esta liga junto con "
										+ " otra informacion importante a su correo electronico."
										+ "<br><br>"
										);
									}else{
										
										$("#response").html(
											"<h2>Algo no salio bien</h2>" + 
												data.reason
												+ "<br><br>"
											);
									}

								  }
								});								
							})

						</script>
					<?php
				?>
				<?php break; ?><!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
				
				<?php case "ajax_validation" : ?>
				<?php
					$r = InstanciasController::validateDemo( $_GET["key"] );
				?>
				<?php break; ?><!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
				
				<?php case "signup" : ?>
				<table border='0'>
				<tr>
					<td rowspan='2'>
						<img class="" style="width: 100px; float:left" src="media/main_site/caffeina-logo.png">
					</td>
					<td>
						<h1>Caffeina POS ERP</h1>
					</td>
				</tr>
				<tr>
					<td>
						<p>
							&nbsp;&nbsp;Planificaci&oacute;n de recursos empresariales en la nube.
						</p>
					</td>
				</tr>
				</table>
				<div style="margin-left: 130px; margin-bottom: 100px; margin-top:50px">
					<h2><strong>Solicitar una instancia de prueba</strong></h2>
					<form action="?t=thanks" class="signup" method="post">
						<div class="placeholding-input">
							<input type="text" class="text-input" autocomplete="off" name="email" maxlength="50" placeholder="Correo electronico">
							<button type="submit" class="btn signup-btn">
							Solicitar instancia </button>
						</div>
					</form>
				</div>
				<?php break; ?><!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
				
				
				
				
				
				
				<?php case "welcome" : ?>	
				<?php default : ?>	
				<table border=0 style="margin-top:-25px">
		          <tr>
		            <td rowspan=2>
		              <img 
						class="" 
						style="width: 150px; float:left" 
						src="media/main_site/caffeina-logo.png">
		            </td>
		            <td>
		              <h1>Caffeina POS ERP</h1>
		            </td>
		          </tr>
		          <tr>
		            <td>
						<p>&nbsp;&nbsp;Planificaci&oacute;n de recursos empresariales en la nube.</p>
					</td>
		          </tr>
		        </table>


		        <div class="">
		          <a href="?t=signup"><img style="margin-top:-20px" src="media/main_site/oferta.png"></a>
		        </div>
				<?php break; ?><!-- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -->
				<?php }?>

	        <div class="footer" style="margin-top:0px;">

<div align=center style="font-size: 19px">
	<ul class="links">
		<li><a href="sdk.php">SDK's</a> | </li>
		<li><a href="sdk.php?l=java">Java</a> </li>
		<li><a href="sdk.php?l=php">PHP</a> </li>
		<li><a href='http://labs.caffeina.mx/public/apis/?repname=pos'>HTTP Rest API</a></li>
	</ul>
</div>
	          <ul class="links">
	            <li class="first">&copy; 2012 Caffeina Software |</li>
	            <li><a href="http://www.caffeina.mx/">Acerca de caffeina</a></li>
	            <li><a href="http://www.caffeina.mx/">Contacto</a></li>
	            <li><a href="http://www.caffeina.mx/art.php?cid=3">Ayuda</a></li>
	            <li><a href="http://labs2.caffeina.mx/public/apis/?repname=pos">API</a></li>	
	          </ul>
	        </div>
	      </div>
	    </div>

		<?php
		if(defined("GOOGLE_ANALYTICS_ID") && !is_null(GOOGLE_ANALYTICS_ID)){
				?>
				<script type="text/javascript">
				  var _gaq = _gaq || [];
				  _gaq.push(['_setAccount', '<?php echo GOOGLE_ANALYTICS_ID; ?>']);
				  _gaq.push(['_trackPageview']);

				  (function() {
				    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
				    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
				    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
				  })();
				</script>
				<?php
		}
		?>
	</body>
    </html>

<!-- testing auto update -->
