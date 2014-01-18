<?php

    /**
      * Description:
      *
      *
      * Author:
      *     Manuel Garcia (manuel)
      *     Alan Gonzalez (alan)
      *
      ***/

	define("BYPASS_INSTANCE_CHECK", false);

	require_once("../../../server/bootstrap.php");




    $page = new GerenciaComponentPage();

    $page->requireParam(  "sid", "GET", "Esta sucursal no existe." );




    /* ********************************************************************* 
     * Corte
     * ********************************************************************* */
    $sucursal = SucursalDAO::getByPK( $_GET['sid'] );

    if ( is_null( $sucursal ) )
    {
        $page->render( );
        exit;
    }

    $page->addComponent( new TitleComponent( "Sucursal " . $sucursal->getDescripcion( ), 1 ) );

    $table = "<table>";

    $cortes  = EfectivoController::UltimoCorte( $sucursal );

    if ( !is_null( $cortes ) )
    {
       $fecha_inicial = $cortes->getFin( );
    }
    else
    {
        $fecha_inicial = $sucursal->getFechaApertura( );
    }
    
    $fecha_final = time( );


    $table .= "  <tr>";
    $table .= td("<b>Corte</b>");
    $table .= td("<b>Del</b>");
    $table .= "    <td colspan= \"2\">" . date("d/m/Y g:i:s A", $fecha_inicial) . "</td>";
    $table .= "    <td><b>Al</b></td>";
    $table .= "    <td colspan= \"2\">" . date("d/m/Y g:i:s A", $fecha_final) . "</td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $fondo_inicial = 0;

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td>Efectivo Inicial</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>" . FormatMoney($fondo_inicial) . "</td>";
    $table .= "    <td></td>"; 
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td>Ventas</td>";

    $table .= 	td("", 5);        
    $table .= "  </tr>";

    #------------------------------------

    $ventas_efectivo = VentaDAO::TotalVentasNoCanceladasAContadoDesdeHasta( $fecha_inicial, $fecha_final );
    $ventas_efectivo = $ventas_efectivo["total"];

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Efectivo</td>";
    $table .= "    <td>" . FormatMoney($ventas_efectivo) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $ventas_cheque = 0;

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Cheques</td>";
    $table .= "    <td>" . FormatMoney($ventas_cheque) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $ventas_credito = VentaDAO::TotalVentasNoCanceladasACreditoDesdeHasta($fecha_inicial, $fecha_final);
    $ventas_credito = $ventas_credito["total"];

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Credito</td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($ventas_credito) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $total_ventas = $ventas_efectivo + $ventas_cheque + $ventas_credito;

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>" . FormatMoney($total_ventas) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $abonos_venta = AbonoVentaDAO::TotalAbonadoAVentasDesdeHasta( $fecha_inicial, $fecha_final	);
    $abonos_venta = $abonos_venta["sum(monto)"];

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td>Cuentas por cobrar recolectado</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>" . FormatMoney($abonos_venta) . "</td>";
    $table .= "    <td></td>"; 
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>"; 

    #------------------------------------

    $otros_ingresos = 0;

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td>Otros Ingresos</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($otros_ingresos) . "</td>";
    $table .= "    <td></td>"; 
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";    

    #------------------------------------

    $efectivo_subtotal = $fondo_inicial + $total_ventas + $abonos_venta + $otros_ingresos;

    $table .= "  <tr>";       
    $table .= "    <td>Subtotal</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>" . FormatMoney($efectivo_subtotal) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------        

    $table .= "  <tr>";       
    $table .= "    <td></td>";
    $table .= "    <td>Ventas a Credito</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($ventas_credito) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $total_efectivo = $efectivo_subtotal - $ventas_credito;

    $table .= "  <tr style = \"background:#C4E8F8;\">";       
    $table .= "    <td><b>Total en Efectivo</b></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td><b>" . FormatMoney($total_efectivo) . "</b></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td>Efectivo Pagado a Clientes</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $ventas_canceladas = 0;

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Reintegro de Efectivo</td>";
    $table .= "    <td>" . FormatMoney($ventas_canceladas) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $deposito_clientes = 0;

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Deposito en Bancos</td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($deposito_clientes) . "</td>";    
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $pagado_clientes_subtotal = $ventas_canceladas + $deposito_clientes;

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td>Subtotal</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>" . FormatMoney($pagado_clientes_subtotal) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td>Efectivo Pagado al Negocio</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $retiro_efectivo = 0;

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Due&ntildeo, Socio</td>";
    $table .= "    <td>" . FormatMoney($retiro_efectivo) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $otros_gastos = 0;

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td>Gastos micelaneos</td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($otros_gastos) . "</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $pagado_negocio_subtotal = $retiro_efectivo + $otros_gastos;

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td>Subtotal</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($pagado_negocio_subtotal) . "</td>";     
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $total_efectivo_pagado = $pagado_clientes_subtotal + $pagado_negocio_subtotal;

    $table .= "  <tr style = \"background:#C4E8F8;\">";
    $table .= "    <td><b>Total en Efectivo Pagado</b></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\"><b>" . FormatMoney($total_efectivo_pagado) . "</b></td>";     
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";
               
    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $total_efectivo_disponible = $total_efectivo - $total_efectivo_pagado;

    $table .= "  <tr style = \"background:#C4E8F8;\">";       
    $table .= "    <td><b>Efectivo Disponible Recibido</b></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td><b>" . FormatMoney($total_efectivo_disponible) . "</b></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $total_efectivo_real = 0;

    $table .= "  <tr>";
    $table .= "    <td>Efectivo Disponible Real</td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td style=\"border-bottom: 1px;border-bottom-color: black;border-style: solid;\">" . FormatMoney($total_efectivo_real) . "</td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "  <tr>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "    <td></td>";
    $table .= "  </tr>";

    #------------------------------------

    $flujo_efectivo = $total_efectivo_real - $total_efectivo_disponible;

    $color = $flujo_efectivo >= 0 ? "black" : "red";

    $table .= "  <tr style = \"background:#C4E8F8;\">";
    $table .= "    <td colspan = \"7\"><b>Flujo de efectivo (Corto):</b></td>";
    $table .= "    <td><b style = \"color:{$color};\">" . FormatMoney(abs($flujo_efectivo)) . "</b></td>";
    $table .= "  </tr>";

    #------------------------------------

    $table .= "</table>";

    $page->addComponent($table);


    $submit = new ApiActionComponent( "api/sucursal/corte" );
    $submit->SetCaption("Realizar corte");
    $submit->setSuccessRedirection("corte.lista.php");

    $submit->setArguments( array( 
        "fecha_final" => time( ),
        "id_sucursal" => $_GET["sid"],
        "total_efectivo" => 99
        ) );

    $page->addcomponent( $submit );

    $page->render( );
