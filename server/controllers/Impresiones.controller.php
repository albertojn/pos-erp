<?php

//require_once("librerias/CNumeroaLetra.php");
define("DONT_USE_HTML", 1);

require_once("libs/ezpdf/class.pdf.php");
require_once("libs/ezpdf/class.ezpdf.php");

class ImpresionesController {


	
	private static function puntos_cm($medida, $resolucion=72) {
	    //// 2.54 cm / pulgada
	    //se supone ke la pagina mide 29.7 cm por 21.0 cm
	    //$medida += 29.7;
	    return ( $medida / (2.54) ) * $resolucion;
	}





	private static function readableText($raw) {
	    return (html_entity_decode($raw). " ");
	    $foo = explode(" ", $raw);
	    $end = "";
	    foreach ($foo as $i) {
	        $end .= ucfirst(strtolower(trim($i))) . " ";
	    }
		
	    
		return $end;
	}





	private static function formatAddress($id_direccion) {
		
		if( is_null($daoDireccion = DireccionDAO::getByPK( $id_direccion ))){
			throw new InvalidDataException("Esta  no existe.");
		}

        $out = self::readableText($daoDireccion->getCalle()) . " " . $daoDireccion->getNumeroExterior(). " ";

        if ($daoDireccion->getNumeroInterior() != null)
            $out .= " Interior " . self::readableText($daoDireccion->getNumeroInterior());


        $out .= "\nColonia " . self::readableText($daoDireccion->getColonia());



        if (!is_null($daoDireccion->getIdCiudad())) {

			$cDao = CiudadDAO::getByPK($daoDireccion->getIdCiudad());
			if(!is_null($cDao)){
				$out .= "\n";
	            $out .= self::readableText($cDao->getNombre()) . ", ";
	
				$e = EstadoDAO::getByPK($cDao->getIdEstado());
				
				if(!is_null($e)){
					$out .= self::readableText($e->getNombre()) . "";	
				}
	            
			}

        }

        if (strlen($daoDireccion->getCodigoPostal()) > 0) {
            $out .= "\nC.P. " . $daoDireccion->getCodigoPostal() . "\n";
        }


    

	    return $out;
	}

	private static function roundRect($pdf, $x, $y, $w, $h) {
	    $pdf->setStrokeColor(0.3359375, 0.578125, 0.89453125);
	    $pdf->setLineStyle(1);
	
	    $x -= self::puntos_cm(0.1);
	    $y -= 2;

	    $pdf->line($x + 2, $y, $x + $w - 2, $y); //arriba
	    $pdf->line($x, $y - 2, $x, $y - $h + 2);  //izquierda
	    $pdf->line($x + 2, $y - $h, $x + $w - 2, $y - $h); //abajo
	    $pdf->line($x + $w, $y - 2, $x + $w, $y - $h + 2); //derecha		

	    $pdf->partEllipse($x + 3, $y - 3, 90, 180, 3); //top-left
	    $pdf->partEllipse($x + $w - 3, $y - 3, 0, 90, 3); //top-right
	    $pdf->partEllipse($x + $w - 3, $y - $h + 3, 360, 240, 3); //bottom-right
	    $pdf->partEllipse($x + 3, $y - $h + 3, 180, 270, 3); //bottom-left
	}



	private static function createPdf( $title = "", $subtitle = "", $qr_string = ""){

	    $pdf = new Cezpdf( $paper = 'letter')	;

		if (is_file(POS_PATH_TO_SERVER_ROOT . "/libs/ezpdf/fonts/Helvetica.afm")){
			$pdf->selectFont(POS_PATH_TO_SERVER_ROOT . "/libs/ezpdf/fonts/Helvetica.afm");
			
		}else{
			Logger::log("No encontre la fuente de PDF");
			throw new Exception("No encontre la fuente de PDF en ");
			
		}

	    //margenes de un centimetro para toda la pagina
	    $pdf->ezSetMargins(1, 1, 1, 1);
	    /**************************
	     * ENCABEZADO
	     ***************************/
	    $pdf->addText( self::puntos_cm(7.1), self::puntos_cm(26.1), 18, utf8_decode($title));
	    $pdf->addText( self::puntos_cm(7.1), self::puntos_cm(25.5), 12, utf8_decode($subtitle));	
	

				
	    return $pdf;
	}




	private static function drawBasicGuide( &$pdf ){

	    /**************************
	     * LOGO
	     **************************/

		$logo = "../static/".IID.".jpg";

		if (file_exists($logo)) {
				if (substr($logo, -3) == "jpg" || substr($logo, -3) == "JPG" || substr($logo, -4) == "jpeg" || substr($logo, -4) == "JPEG") {
						$pdf->addJpegFromFile($logo, self::puntos_cm(2), self::puntos_cm(24), self::puntos_cm(4.1) );

				} elseif (substr($logo, -3) == "png" || substr($logo, -3) == "PNG") {
						$pdf->addPngFromFile($logo, self::puntos_cm(2), self::puntos_cm(24), self::puntos_cm(4.1));

				} else {
						Logger::log("Verifique la configuracion del pos_config, la extension de la imagen del logo no es compatible");
				}
		}

		self::roundRect($pdf, self::puntos_cm(14.2), self::puntos_cm(26.8), self::puntos_cm(4), self::puntos_cm(4.25));
		self::roundRect($pdf, self::puntos_cm(2), self::puntos_cm(22), self::puntos_cm(16.2), self::puntos_cm(3.2));
		self::roundRect($pdf, self::puntos_cm(2), self::puntos_cm(18.6), self::puntos_cm(16.2), self::puntos_cm(13.0));
		
		self::roundRect($pdf, self::puntos_cm(2), self::puntos_cm(5.4), self::puntos_cm(16.2), self::puntos_cm(3.05));

		$qr_file_name = self::getQrCodeFromGoogle("http://www.caffeina.mx/pos/");
		if (!is_null($qr_file_name)) {
			$pdf->addJpegFromFile("../../../static_content/qr_codes/" . $qr_file_name,
				self::puntos_cm(2), 
				self::puntos_cm(2.45),
				self::puntos_cm(2.8));
		}

		$pdf->setStrokeColor(0.3359375, 0.578125, 0.89453125);
		$pdf->line(
			self::puntos_cm(8.2 + 2), 
			self::puntos_cm(21.91 ), 
			self::puntos_cm(8.2 + 2), 
			self::puntos_cm(18.751)
		);

	    /*     * ************************
	     * notas de abajo
	     * ************************* */
	    $pdf->setLineStyle(1);

	    $pdf->setStrokeColor(0.3359375, 0.578125, 0.89453125);

	    $pdf->line( self::puntos_cm(1.9), self::puntos_cm(2.0), self::puntos_cm(18.1), self::puntos_cm(2.0));

	    $pdf->addText( self::puntos_cm(2), self::puntos_cm(1.61), 7, "Generado " . date('H:i:s d/m/Y')  );

	    $pdf->addText( self::puntos_cm(16.70), self::puntos_cm(1.30), 8, "caffeina.mx");	

	}

















	public static function Documento($id_documento, $preview = FALSE , $params = NULL){



		$dbase = DocumentoBaseDAO::getByPK($id_documento);

		
		$dbase->setJsonImpresion( str_replace ( "\\n" , "" , $dbase->getJsonImpresion() ) );
		$dbase->setJsonImpresion( str_replace ( "\\t" , "" , $dbase->getJsonImpresion() ) );
		$dbase->setJsonImpresion( stripslashes($dbase->getJsonImpresion())  );

		if( "\""  == substr ( $dbase->getJsonImpresion() , 0 , 1 ) ){
			$dbase->setJsonImpresion(  substr($dbase->getJsonImpresion(), 1 , -1) );	
		}

		
		
		
		$decoded_json  = json_decode($dbase->getJsonImpresion());
		#echo $dbase->getJsonImpresion(); die;

		if(is_null($decoded_json)){
			throw new InvalidDataException("json invalido");

		}

 		$pdf = new Cezpdf( array(0,0,$decoded_json->width, $decoded_json->height));

		if (is_file(POS_PATH_TO_SERVER_ROOT . "libs/ezpdf/fonts/Helvetica.afm")){
			$pdf->selectFont(POS_PATH_TO_SERVER_ROOT . "libs/ezpdf/fonts/Helvetica.afm");
			
		}else{
			throw new Exception();
			
		}

		

		for ($i=0; $i < sizeof($decoded_json->body); $i++) { 
			
			switch($decoded_json->body[$i]->type){

				case "text" :

					if(!$preview){

						while( ($posI = strpos ( $decoded_json->body[$i]->value, "{")) !== FALSE){
							
							$posF = strpos ( $decoded_json->body[$i]->value, "}");

							$key = substr ( $decoded_json->body[$i]->value, $posI +1 , $posF - $posI -1 );
							
							if(TRUE === array_key_exists($key, $params)){

								$decoded_json->body[$i]->value = substr_replace( 
									$decoded_json->body[$i]->value, 
									$params[$key], 
									$posI, 
									$posF - $posI + 1);
							}else{
								$decoded_json->body[$i]->value = substr_replace( 
									$decoded_json->body[$i]->value, 
									"", 
									$posI, 
									$posF - $posI + 1);
							}
						}
					}


					$pdf->addText( 
						$decoded_json->body[$i]->x, 
						$decoded_json->body[$i]->y,
						$decoded_json->body[$i]->fontSize, 
						utf8_decode($decoded_json->body[$i]->value) );
				break;




				case "round-box" :
						$x = $decoded_json->body[$i]->x;
						$y = $decoded_json->body[$i]->y;
						$w = $decoded_json->body[$i]->w;
						$h = $decoded_json->body[$i]->h;

					    $pdf->setStrokeColor(0.3359375, 0.578125, 0.89453125);
	    				$pdf->setLineStyle(1);
				
					    $pdf->line($x + 2, $y, $x + $w - 2, $y); //arriba
					    $pdf->line($x, $y - 2, $x, $y - $h + 2);  //izquierda
					    $pdf->line($x + 2, $y - $h, $x + $w - 2, $y - $h); //abajo
					    $pdf->line($x + $w, $y - 2, $x + $w, $y - $h + 2); //derecha		

					    $pdf->partEllipse($x + 3, $y - 3, 90, 180, 3); //top-left
					    $pdf->partEllipse($x + $w - 3, $y - 3, 0, 90, 3); //top-right
					    $pdf->partEllipse($x + $w - 3, $y - $h + 3, 360, 240, 3); //bottom-right
					    $pdf->partEllipse($x + 3, $y - $h + 3, 180, 270, 3); //bottom-left
				break;
			}

		}




	    //margenes de un centimetro para toda la pagina
	    $pdf->ezSetMargins(
	    			$decoded_json->marginTop, 
					$decoded_json->marginBottom,
					$decoded_json->marginLeft,
					$decoded_json->marginRight
				);






	    /**************************
	     * ENCABEZADO
	     ***************************/
	    //$pdf->addText( self::puntos_cm(7.1), self::puntos_cm(26.1), 18, utf8_decode($title));
	    //$pdf->addText( self::puntos_cm(7.1), self::puntos_cm(25.5), 12, utf8_decode($subtitle));	
	
		$pdf->ezStream();
				
	    
	    exit;

	}











	private static function printProducts( &$pdf, $productos ){
	    $opciones_tabla = array();
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['showHeadings'] = 0;
	    $opciones_tabla['shaded'] = 0;
	    $opciones_tabla['fontSize'] = 8;
	    $opciones_tabla['xOrientation'] = 'right';
	    $opciones_tabla['xPos'] = self::puntos_cm(7.5);
	    $opciones_tabla['width'] = self::puntos_cm(11);
	    $opciones_tabla['textCol'] = array(0, 0, 0);
	    $opciones_tabla['titleFontSize'] = 12;
	    $opciones_tabla['rowGap'] = 3;
	    $opciones_tabla['colGap'] = 3;
	    $opciones_tabla['xPos'] = self::puntos_cm(14.2);
	    
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['shaded'] = 2;
	    $opciones_tabla['shadeCol'] = array(1, 1, 1);
	    $opciones_tabla['shadeCol2'] = array(0.8984375, 0.95703125, 0.99609375);

		/* *************************
	     * PRODUCTOS
	     * ************************* */
	    $elementos = array(
	        array('cantidad' => 'Cantidad',
	            'descripcion' => 'Descripcion                                                                                                     ', 'precio' => 'Precio', 'importe' => 'Importe'),
	    );

	    $subtotal = 0;
	    $total = 0;
	    $impuesto = 0;

	    foreach ($productos as $p) {

				if($p instanceof VentaProducto  ){
		        	$prodDao = ProductoDAO::getByPK( $p->getIdProducto() );
					if(!is_null($prodDao)){

						$prod['cantidad'] = $p->getCantidad();
						
						if(!is_null($p->getIdUnidad())){
							$unidad = UnidadMedidaDAO::getByPK($p->getIdUnidad());
							if(!is_null($unidad)){
								$prod['cantidad'] .= " " . $unidad->getAbreviacion();	
							}
							
						}
			            
			            $prod['descripcion'] = $prodDao->getNombreProducto();
			            $prod['precio'] = FormatMoney($p->getPrecio(), DONT_USE_HTML);
			            $prod['importe'] = FormatMoney($p->getPrecio() * $p->getCantidad(), DONT_USE_HTML);

			            $subtotal +=  ($p->getPrecio() * $p->getCantidad());
			            $total = $subtotal;		
			
			        	array_push($elementos, $prod);				
					}else{
						Logger::error("El producto que se intentaba imprimir ya no existe !!");
					}


					
		
				}else if($p instanceof VentaOrden){
					
					$ordenDao = OrdenDeServicioDAO::getByPK( $p->getIdOrdenDeServicio() );
					$serv = ServicioDAO::getByPK( $ordenDao->getIdServicio() );
					
		            $prod['cantidad'] = "-";
		            $prod['descripcion'] = $serv->getNombreServicio();
		
		            $prod['precio'] = FormatMoney($p->getPrecio(), DONT_USE_HTML);
		            $prod['importe'] = FormatMoney($p->getPrecio() , DONT_USE_HTML);


		            $subtotal +=  ($p->getPrecio() );
		
		            $total = $subtotal;

	        		array_push($elementos, $prod);		            
				}else if($p instanceof Venta){



				    array_push($elementos, array("cantidad" => "",
				        "descripcion" => "",
				        "precio" => "Subtotal",
				        "importe" => FormatMoney($p->getSubtotal(), DONT_USE_HTML)));

				    array_push($elementos, array("cantidad" => "",
				        "descripcion" => "",
				        "precio" => "Descuento",
				        "importe" => FormatMoney($p->getDescuento(), DONT_USE_HTML)));

				    array_push($elementos, array("cantidad" => "",
				        "descripcion" => "",
				        "precio" => "IVA",
				        "importe" => FormatMoney($p->getImpuesto(), DONT_USE_HTML)));

				    array_push($elementos, array("cantidad" => "",
				        "descripcion" => "",
				        "precio" => "Total",
				        "importe" => FormatMoney($p->getTotal(), DONT_USE_HTML)));

					$letra = new CNumeroaLetra();
					$letra->setNumero($p->getTotal());
					
				    array_push($elementos, array("cantidad" => "",
				        "descripcion" => $letra->letra(),
				        "precio" => "",
				        "importe" => ""));
				}


	    }

		
		
	    $pdf->ezSetY(self::puntos_cm(18.6));
	
	    $opciones_tabla['xPos'] = self::puntos_cm(2);
	    $opciones_tabla['width'] = self::puntos_cm(16.2);

	    $pdf->ezTable($elementos, "", "", $opciones_tabla);
	}


	private static function printClient( &$pdf, $daoCliente){

		if($daoCliente === null){
			Logger::error("Se intento imprimir un cliente que no existe");
			return;
		}

	    /* *************************
	     * Cliente
	     * ************************* */
	    $datos_receptor = self::readableText( $daoCliente->getNombre() ). "\n";
	    $datos_receptor .= $daoCliente->getRfc();
	
		if(!is_null($daoCliente->getIdDireccion()))
			$datos_receptor .= self::formatAddress($daoCliente->getIdDireccion());
  		
		



	    $receptor = array(
	        array("receptor" => "<b>Cliente</b>"),
	        array("receptor" => $datos_receptor),
	    );

	    
	    $opciones_tabla['showHeadings'] = 0;
	    $opciones_tabla['shaded'] = 0;
	    $opciones_tabla['fontSize'] = 8;
	    $opciones_tabla['xOrientation'] = 'right';
	    $opciones_tabla['xPos'] = self::puntos_cm(7.5);
	    $opciones_tabla['width'] = self::puntos_cm(11);
	    $opciones_tabla['textCol'] = array(0, 0, 0);
	    $opciones_tabla['titleFontSize'] = 12;
	    $opciones_tabla['rowGap'] = 3;
	    $opciones_tabla['colGap'] = 3;
	    $opciones_tabla['xPos'] = self::puntos_cm(14.2);
	    $opciones_tabla['width'] = self::puntos_cm(4);
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['shaded'] = 2;
	    $opciones_tabla['shadeCol'] = array(1, 1, 1);
	    $opciones_tabla['shadeCol2'] = array(0.8984375, 0.95703125, 0.99609375);
	    $opciones_tabla['xPos'] = self::puntos_cm(14.2);
	    $opciones_tabla['width'] = self::puntos_cm(4);
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['shaded'] = 2;
	    $opciones_tabla['shadeCol'] = array(1, 1, 1);
	    $opciones_tabla['shadeCol2'] = array(0.8984375, 0.95703125, 0.99609375);

	    $pdf->ezSetY(self::puntos_cm(22));
	    $opciones_tabla['xPos'] = self::puntos_cm(2);
	    $opciones_tabla['width'] = self::puntos_cm(16.2);
	    $opciones_tabla['showLines'] = 0;

	    $pdf->ezTable($receptor, "", "", $opciones_tabla);
	
	
		
	}


	public static function Venta($id_venta) {
		
		$ventaDao = VentaDAO::getByPK($id_venta);

		if($ventaDao === null){
			throw new InvalidDataException("Esta venta no existe");
		}

		$clienteDao = UsuarioDAO::getByPK( $ventaDao->getIdCompradorVenta() );
		$agenteDao = UsuarioDAO::getByPK( $ventaDao->getIdUsuario() );


		if($ventaDao->getEsCotizacion()){
			$pdf =	self::createPdf("Cotizacion");

		}else{
			$pdf =	self::createPdf("Nota de venta");	

		}


	    $opciones_tabla = array();
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['showHeadings'] = 0;
	    $opciones_tabla['shaded'] = 0;
	    $opciones_tabla['fontSize'] = 8;
	    $opciones_tabla['xOrientation'] = 'right';
	    $opciones_tabla['xPos'] = self::puntos_cm(7.5);
	    $opciones_tabla['width'] = self::puntos_cm(11);
	    $opciones_tabla['textCol'] = array(0, 0, 0);
	    $opciones_tabla['titleFontSize'] = 12;
	    $opciones_tabla['rowGap'] = 3;
	    $opciones_tabla['colGap'] = 3;


		$f = date("d/m/y", $ventaDao->getFecha()) . " " . date("H:i:s", $ventaDao->getFecha());
	    
		if($ventaDao->getEsCotizacion()){
			$datos = array(
		        array("col" => "<b>Cotizacion</b>"),
		        array("col" =>  $ventaDao->getIdVenta()),

		        array("col" => "<b>Numero de orden</b>"),
		        array("col" =>  "" ),
			
		        array("col" => "<b>Fecha de venta</b>"),
		        array("col" => $f),

		        array("col" => "<b>Agente que cotizo</b>"),
		        array("col" => self::readableText(  $agenteDao->getNombre() ))
	    	);

		}else{

			$datos = array(
		        array("col" => "<b>Venta</b>"),
		        array("col" =>  $ventaDao->getIdVenta()),

		        array("col" => "<b></b>"),
		        array("col" =>  "" ),
			
		        array("col" => "<b>Fecha de venta</b>"),
		        array("col" => $f),

		        array("col" => "<b>Agente de venta</b>"),
		        array("col" => self::readableText(  $agenteDao->getNombre() ))
	    	);
		}
		
	 

	    $pdf->ezSetY(self::puntos_cm(26.8));

	    $opciones_tabla['xPos'] = self::puntos_cm(14.2);
	    $opciones_tabla['width'] = self::puntos_cm(4);
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['shaded'] = 2;
	    $opciones_tabla['shadeCol'] = array(1, 1, 1);
	    $opciones_tabla['shadeCol2'] = array(0.8984375, 0.95703125, 0.99609375);
	    $pdf->ezTable($datos, "", "", $opciones_tabla);




			$ventaProducto = VentaProductoDAO::search( new VentaProducto( array(
					"id_venta" => $id_venta
				) ) );

			$ventaOrden = VentaOrdenDAO::search( new VentaOrden( array(
					"id_venta" => $id_venta
				) ) );

		$prods = array_merge($ventaProducto, $ventaOrden );

		array_push($prods, $ventaDao);
		

		self::printProducts($pdf, $prods);

		self::printClient($pdf, $clienteDao);

		self::drawBasicGuide( $pdf );

		$pdf->ezStream();


	}




	public static function OrdenDeServicio( $id_orden ) {

		//obtengamos datos de esta orden de servicio
		//el cliente
		$daoOrden = OrdenDeServicioDAO::getByPK($id_orden);
		$daoCliente = UsuarioDAO::getByPK( $daoOrden->getIdUsuarioVenta() );
		$daoAgente = UsuarioDAO::getByPK( $daoOrden->getIdUsuario() );
		
		

		$daoServicio = ServicioDAO::getByPK( $daoOrden->getIdServicio() );
		

		$pdf = self::createPdf("Orden de Servicio " . $id_orden, $daoServicio->getNombreServicio());

		self::printClient($pdf, $daoCliente);
	    


	    
	    $opciones_tabla = array();
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['showHeadings'] = 0;
	    $opciones_tabla['shaded'] = 0;
	    $opciones_tabla['fontSize'] = 8;
	    $opciones_tabla['xOrientation'] = 'right';
	    $opciones_tabla['xPos'] = self::puntos_cm(7.5);
	    $opciones_tabla['width'] = self::puntos_cm(11);
	    $opciones_tabla['textCol'] = array(0, 0, 0);
	    $opciones_tabla['titleFontSize'] = 12;
	    $opciones_tabla['rowGap'] = 3;
	    $opciones_tabla['colGap'] = 3;


	    $datos = array(
	        array("col" => "<b>Servicio</b>"),
	        array("col" =>  $daoServicio->getCodigoServicio()),

	        array("col" => "<b>Numero de orden</b>"),
	        array("col" =>  $daoOrden->getIdOrdenDeServicio() ),
		
	        array("col" => "<b>Fecha de entrega</b>"),
	        array("col" => ""),

	    );

	    $pdf->ezSetY(self::puntos_cm(26.8));

	    $opciones_tabla['xPos'] = self::puntos_cm(14.2);
	    $opciones_tabla['width'] = self::puntos_cm(4);
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['shaded'] = 2;
	    $opciones_tabla['shadeCol'] = array(1, 1, 1);
	    $opciones_tabla['shadeCol2'] = array(0.8984375, 0.95703125, 0.99609375);
	    $pdf->ezTable($datos, "", "", $opciones_tabla);

	    



	    /* ************************
	     * PRODUCTOS
	     * ************************* */

	    $elementos = array(
	        array(  'cantidad' 	=> 'Detalles de la orden',
	            	'unidad'		=>''
				)
		);


		$eP = $daoOrden->getExtraParams();
		
		if(!is_null($eP)){
			$ePObj = json_decode($eP);
			foreach ($ePObj as $obj) {
				$row["cantidad"] = "<b>" . $obj->desc . "</b>";
				$row["unidad"] = $obj->value;				
				$row["agrupacion"] = "";
				$row["descripcion"] = "";
				$row["precio"] = "";				
				$row["importe"] = "";				
				array_push($elementos, $row);	
			}
		}
		
		


	    $pdf->ezText("", 10, array('justification' => 'center'));
	    $pdf->ezSetY(self::puntos_cm(18.6));
	
	    $opciones_tabla['xPos'] = self::puntos_cm(2);
	    $opciones_tabla['width'] = self::puntos_cm(16.2);
	
	    $pdf->ezTable($elementos, "", "", $opciones_tabla);

		self::drawBasicGuide($pdf);
		


	    $pdf->ezStream();


	    return;
	}







	/**
	 * Crea un pdf con el estado de cuenta de el cliente especificado
	 * @param Array $args,  $args['id_cliente'=>12[,'tipo_venta'=> 'credito | contado | saldo'] ], por default obtiene todas las compras del cliente
	 */
	public static function imprimirEstadoCuentaCliente($args) {

	    //verificamos que se haya especificado el id del cliente    
	    if (!isset($args['id_cliente'])) {
	        Logger::log("Error al obtener el estado de cuenta, no se ha especificado un cliente.");
	        die('{"success": false, "reason": "Error al obtener el estado de cuenta, no se ha especificado un cliente."}');
	    }

	    //verificamos que el cliente exista
	    if (!($cliente = ClienteDAO::getByPK($args['id_cliente']))) {
	        Logger::log("Error al obtener el estado de cuenta, no se tiene registro del cliente {$args['id_cliente']}.");
	        die('{"success": false, "reason": "Error al obtener el estado de cuenta, no se tiene registro del cliente ' . $args['id_cliente'] . '"}');
	    }

	    //obtenemos los datos del emisor
	    $estado_cuenta = estadoCuentaCliente($args);

	    //buscar los datos del emisor       
	    if (!$emisor = PosConfigDAO::getByPK('emisor')) {
	        Logger::log("no encuentro los datos del emisor");
	        die("no encuentro los datos del emisor");
	    }

	    $emisor = json_decode($emisor->getValue())->emisor;

	    $sucursal = SucursalDAO::getByPK($_SESSION['sucursal']);

	    if (!$sucursal) {
	        die("Sucursal invalida");
	    }

	    include_once('librerias/ezpdf/class.pdf.php');
	    include_once('librerias/ezpdf/class.ezpdf.php');

	    $pdf = new Cezpdf();

	    $pdf->selectFont('../server/librerias/ezpdf/fonts/Helvetica.afm');

	    //margenes de un centimetro para toda la pagina
	    $pdf->ezSetMargins(1, 1, 1, 1);

	    /*
	     * LOGO
	     */

	    if (!$logo = PosConfigDAO::getByPK('url_logo')) {
	        Logger::log("Verifique la configuracion del pos_config, no se encontro el camṕo 'url_logo'");
	        die("Verifique la configuracion del POS, no se encontro el url del logo");
	    }

	    //addJpegFromFile(imgFileName,x,y,w,[h])    
	    //detectamos el tipo de imagen del logo
	    if (substr($logo->getValue(), -3) == "jpg" || substr($logo->getValue(), -3) == "JPG" || substr($logo->getValue(), -4) == "jpeg" || substr($logo->getValue(), -4) == "JPEG") {
	        $pdf->addJpegFromFile($logo->getValue(), puntos_cm(2), puntos_cm(25.5), puntos_cm(3.5));
	    } elseif (substr($logo->getValue(), -3) == "png" || substr($logo->getValue(), -3) == "PNG") {
	        $pdf->addPngFromFile($logo->getValue(), puntos_cm(2), puntos_cm(25.5), puntos_cm(3.5));
	    } else {
	        Logger::log("Verifique la configuracion del pos_config, la extension de la imagen del logo no es compatible");
	        die("La extension de la imagen usada para el logo del negocio no es valida.");
	    }


	    /*     * ************************
	     * ENCABEZADO
	     * ************************* */
	    $e = "<b>" . self::readableText($emisor->nombre) . "</b>\n";
	    $e .= formatAddress($emisor);
	    $e .= "RFC: " . $emisor->rfc . "\n\n";

	    //datos de la sucursal
	    $e .= "<b>Lugar de expedicion</b>\n";
	    $e .= self::readableText($sucursal->getDescripcion()) . "\n";
	    $e .= formatAddress($sucursal);

	    $datos = array(
	        array(
	            "emisor" => $e
	        )
	    );

	    $pdf->ezSetY(puntos_cm(28.6));
	    $opciones_tabla = array();
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['showHeadings'] = 0;
	    $opciones_tabla['shaded'] = 0;
	    $opciones_tabla['fontSize'] = 8;
	    $opciones_tabla['xOrientation'] = 'right';
	    $opciones_tabla['xPos'] = puntos_cm(7.3);
	    $opciones_tabla['width'] = puntos_cm(11);
	    $opciones_tabla['textCol'] = array(0, 0, 0);
	    $opciones_tabla['titleFontSize'] = 12;
	    $opciones_tabla['rowGap'] = 3;
	    $opciones_tabla['colGap'] = 3;

	    $pdf->ezTable($datos, "", "", $opciones_tabla);

	    $cajero = UsuarioDAO::getByPK($_SESSION['userid'])->getNombre();
	    $datos = array(
	        array("col" => "<b>Cajero</b>"),
	        array("col" => self::readableText($cajero)),
	        array("col" => "<b>Cliente</b>"),
	        array("col" => self::readableText($cliente->getRazonSocial())),
	        array("col" => "<b>Limite de  Credito</b>"),
	        array("col" => FormatMoney($estado_cuenta->limite_credito, DONT_USE_HTML)),
	        array("col" => "<b>Saldo</b>"),
	        array("col" => FormatMoney($estado_cuenta->saldo, DONT_USE_HTML))
	    );

	    $pdf->ezSetY(puntos_cm(28.8));

	    $opciones_tabla['xPos'] = puntos_cm(12.2);
	    $opciones_tabla['width'] = puntos_cm(6);
	    $opciones_tabla['showLines'] = 0;
	    $opciones_tabla['shaded'] = 2;
	    $opciones_tabla['shadeCol'] = array(1, 1, 1);
	    //$opciones_tabla['shadeCol2'] = array(0.054901961, 0.756862745, 0.196078431);
	    $opciones_tabla['shadeCol2'] = array(0.8984375, 0.95703125, 0.99609375);
	    $pdf->ezTable($datos, "", "", $opciones_tabla);

	    //roundRect($pdf, puntos_cm(12.2), puntos_cm(28.8), puntos_cm(6), puntos_cm(4.25));


	    /**
	     * ESTADO DE CUENTA
	     */
	    $elementos = array(
	        array('id_venta' => 'Venta',
	            'fecha' => 'Fecha',
	            'sucursal' => 'Sucursal',
	            'cajero' => 'Cajero',
	            //'cancelada' => 'Cancelada',
	            'tipo_venta' => 'Tipo',
	            'tipo_pago' => 'Pago',
	            'total' => 'Total',
	            'pagado' => 'Pagado',
	            'saldo' => 'Saldo'),
	    );


	    foreach ($estado_cuenta->array_ventas as $venta) {

	        $array_venta = array();

	        $array_venta['id_venta'] = $venta['id_venta'];
	        $array_venta['fecha'] = $venta['fecha'];
	        $array_venta['sucursal'] = self::readableText($venta['sucursal']);
	        $array_venta['cajero'] = self::readableText($venta['cajero']);
	        $array_venta['cancelada'] = self::readableText($venta['cancelada']);
	        $array_venta['tipo_venta'] = self::readableText($venta['tipo_venta']);
	        $array_venta['tipo_pago'] = self::readableText($venta['tipo_pago']);
	        $array_venta['total'] = FormatMoney($venta['total'], DONT_USE_HTML);
	        $array_venta['pagado'] = FormatMoney($venta['pagado'], DONT_USE_HTML);
	        $array_venta['saldo'] = FormatMoney($venta['saldo'], DONT_USE_HTML);

	        array_push($elementos, $array_venta);
	    }


	    $pdf->ezText("", 8, array('justification' => 'center'));
	    $pdf->ezSetY(puntos_cm(24));
	    $opciones_tabla['xPos'] = puntos_cm(2);
	    $opciones_tabla['width'] = puntos_cm(16.2);
	    $pdf->ezTable($elementos, "", "Estado de Cuenta", $opciones_tabla);


	    //roundRect($pdf, puntos_cm(2), puntos_cm(24.3), puntos_cm(16.2), puntos_cm(3.2));


	    /*     * ************************
	     * notas de abajo
	     * ************************* */
	    $pdf->setLineStyle(1);
	    $pdf->setStrokeColor(0.3359375, 0.578125, 0.89453125);

	    $pdf->line(puntos_cm(2), puntos_cm(1.3), puntos_cm(18.2), puntos_cm(1.3));


	    $pdf->addText(puntos_cm(2), puntos_cm(1.0), 7, "Fecha de impresion: " . date("d/m/y") . " " . date("H:i:s"));

	    //addJpegFromFile(imgFileName,x,y,w,[h])
	    //$pdf->addJpegFromFile("../www/media/logo_simbolo.jpg", puntos_cm(15.9), puntos_cm(.25), 25);


	    $pdf->addText(puntos_cm(16.70), puntos_cm(.60), 8, "caffeina.mx");

	    $pdf->ezStream();
	}




	private static function getQrCodeFromGoogle($string, $retry = 3) {

		$file_name = md5($string);
		
	    $file_full_path = "../../../static_content/qr_codes/" . $file_name . ".jpg";

	    if (is_file($file_full_path)) {
	        return $file_name . ".jpg";
	    }

	    //el codigo no existe, sacarlo de google
	    //primero tengo que ver si es posible que escriba en la carpeta de qr codes
	    if (!is_writable("../../../static_content/qr_codes/")) {
	        Logger::error("No puedo escribir en la carpeta de QRCODES !");
	        return null;
	    }

	    Logger::log("Codigo QR no esta en static, sacarlo de google");

		$google_api_call = "https://chart.googleapis.com/chart?chs=150x150&cht=qr&chld=H|1&choe=UTF-8&chl=";

		// Muste have https wrapper: check extension=php_openssl.dll in phpini
	    $f = file_get_contents($google_api_call . urlencode($string));

		if ($f == null) {
			if ($retry == 0) {
				Logger::error("Ive tried too long, giving up...");
				return null;
			}

			//volver a intentar
			Logger::log("FALLE AL OBTENER EL QR CODE DE GOOGLE, REINTENTANDO...");
			return self::getQrCodeFromGoogle($string, $retry - 1);
		}

		file_put_contents($file_full_path, $f);

		//la imagen esta en png, hay que convertirla a jpg para que no haya pedos en el pdf
		$image = imagecreatefrompng($file_full_path);
		imagejpeg($image, "../../../static_content/qr_codes/" . $file_name . ".jpg", 100);
		imagedestroy($image);

		return $file_name . ".jpg";
	}
	
	
}
