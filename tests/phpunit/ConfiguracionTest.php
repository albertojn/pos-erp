<?php
//PRUEBAS UNITARIAS CONFIGURACION

date_default_timezone_set ( "America/Mexico_City" );

require_once("../../server/bootstrap.php");
if(!defined("BYPASS_INSTANCE_CHECK")){
	define("BYPASS_INSTANCE_CHECK", true);}
          class ConfiguracionTest extends PHPUnit_Framework_TestCase {
                //Pendiente: Comrpobar que no se puedan reducir la cantidad de decimales despues de una operacion.
                private static $Cambio,$Cantidades,$Costos,$Ventas;//Variables de decimales
                
                public function testConfiguracionesPrevias() 
                {//Comprueba que exista una configuración valida en la tabla de configuraciones decimales
                      //echo " >> Comprobando la existencia de una configuracion de decimales previa\n";
                      $Configuraciones = ConfiguracionDAO::search( new Configuracion( array("descripcion" => "decimales") ) );//Lee las configuraciones de la base de datos
                      
                      $nDecimales=$Configuraciones[0];//Carga la primera configuración
                      $temp=  json_decode($nDecimales->getValor());
                      
                      $Cambio=$temp->cambio;
                      $Cantidades=$temp->cantidades;
                      $Costos=$temp->costos;
                      $Ventas=$temp->ventas;
                      
                      if (is_null($Cambio))
                      {
                            $this->assertTrue(false);
                            //echo "\tError, no hay decimales asignados a 'Cambio'\n";
                      }                      else                      {
                            //echo "\tDecimales en 'Cambio': " . $Cambio."\n";
                      }
                      
                      if (is_null($Cantidades))
                      {
                            $this->assertTrue(false);
                            //echo "\tError, no hay decimales asignados a 'Cantidades'\n";
                      }                      else                      {
                            //echo "\tDecimales en 'Cantidades': " . $Cantidades."\n";
                      }
                      
                      if (is_null($Costos))
                      {
                            $this->assertTrue(false);
                            //echo "\tError, no hay decimales asignados a 'Costos'\n";
                      }                      else                      {
                            //echo "\tDecimales en 'Costos': " . $Costos."\n";
                      }
                      
                      if (is_null($Ventas))
                      {
                            $this->assertTrue(false);
                            //echo "\tError, no hay decimales asignados a 'Ventas'\n";
                      }                      else                      {
                            //echo "\tDecimales en 'Ventas': " . $Ventas."\n";
                      }
                      
                }
                public function testCadenaDecimales()
                {//Comprueba que no se admitan caracteres de texto en la configuracion de decimales
                      //echo " >> Comprobando caracteres admitidos por la configuración\n";
                      //echo "\tSe envian: A, B, C, D como argumentos";
                      try 
                      {
                            //echo "\tExcepcion capturada: ". POSController::DecimalesConfiguracion("A", "B", "C", "D");//Se envian argumentos invalidos
                      }
                      catch (Exception $e) {
                             //echo "\tExcepción capturada: ",  $e->getMessage(), "\n";
                      }
                }
                
                public function testNegativoDecimales()
                {//Comprueba que no se acepten decimales negativos
                      //echo " >> Comprobando aceptacion de decimales negativos\n";
                      //echo "\tSe envian: -1, -2, -3, -4";
                      try 
                      {
                            //echo "\tExcepcion capturada: ". POSController::DecimalesConfiguracion(-1, -2, -3, -4);//Se envian argumentos invalidos
                      }
                      catch (Exception $e) {
                             //echo "\tExcepción capturada: ",  $e->getMessage(), "\n";
                      }
                }
                
                public function testMaxDecimales()
                {//Comprueba que se admita la cantidad correcta de decimales
                      //echo " >> Comprobando numero maximo de decimales admitidos\n";
                      
                }
                                
                public function testRestaurarConfiguracionl() 
                {//Reestablece la configuracion de decimales y lo comprueba
                      //echo " >> Comprobando reestablecimiento de la configuracion\n";
                      
                }
          }
?>
