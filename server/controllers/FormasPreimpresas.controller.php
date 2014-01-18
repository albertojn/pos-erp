<?php

require_once("interfaces/FormasPreimpresas.interface.php");

/**
 *
 *
 *
 * */
class FormasPreimpresasController extends ValidacionesController implements IFormasPreimpresas {

    /**
     *
     * Genera un documento en formato  PDF.
     *
     * @param documento json Objeto que indica como sera visualmente el documento.
     **/
    public static function GenerarPdf($documento) {
        $pdf = new JSON2PDF(json_decode($documento));
    }  

      /**
       *
       * Esta funcionalidad permite crear un archivo de Excel 2007 a partir de un JSON, tambi?n usando plantillas predefinidas con palabras clave
       *
       * @param archivo_salida string La ruta y el nombre del archivo que se Va a crear con esta funcionalidad
       * @param datos json Es un arreglo asociativo que contiene los valores que se van a insertar dentro del archivo de salida. Si se usa plantilla las llaves apuntar�n a las palabras clave del archivo, si no se usa plantilla, las llaves del arreglo apuntaran a las coordenadas d�nde se desea insertar dichos valores. Si solo se envia un arreglo se toma como cabeceras, pero el arrelgo puede contener otro arreglo, el primero contiene las filas y los arreglos internos las columnas
       * @param archivo_plantilla string Si se establece, permite definir la ubicaci�n de la plantilla a usar
       * @param imagenes json Contiene un arreglo con las im�genes que se van a insertar en el archivo de salida
       * @return estado string Devuelve el estado de la funci�n, 0 para correcto; En caso de haber un error, devuelve la cadena con este.
       * */
      public static function GenerarExcel
      (
      $datos, $archivo_plantilla = "", $imagenes = ""
      ) {
$Debug=1;
            try {
                  $Temp = PHPExcel_Reader_Excel2007; //Crea el nuevo objeto de saĺida
	        $ObjSalida=$Temp->Load(POS_PATH_TO_SERVER_ROOT . "../static_content/Default.xlsx");
                  if ($datos == null) {
                        Logger::error("No hay datos para trabajar"); //Termina la ejecución
                  } else {
	  if($Debug!=0){echo "Datos de entrada: \n\n"; var_dump($datos);echo "\nPlantilla:\n\n";var_dump($archivo_plantilla);echo "\n\n\n";}
	  $datos=  json_decode($datos);
	  $Datos=$datos;
                  }
                  if ($archivo_plantilla == null || $archivo_plantilla === "") {//Si no se especifica una plantilla
                        $itCol = 0;
                        $itFil = 0;
                        foreach ($Datos as $key => $value) {
                              if (substr($key, 0, 1) != "#" && substr($key, (strlen($key) - 1) != "#", 1)) {//Determina si NO es una palabra clave
                                    if (is_object($value) == true) {//Si el elemento que se obtiene es un objeto (incluye formato)
                                          $Pos = FormasPreimpresasController::SeparaColFil($key);
                                          foreach ($value as $nKey => $Filas) {
                                                if (is_array($Filas)) {//Si hay un arreglo con las columnas para esa fila
                                                      foreach ($Filas as $Columnas) {//Itera entre todas las columnas contenidas en el array
                                                            $ObjSalida->getActiveSheet()->getCellByColumnAndRow(($Pos->Col + $itCol), ($Pos->Fil + $itFil - 1))->setValue($Columnas);
                                                            $itCol++;
                                                      }
                                                      $itCol = 0;
                                                }
                                                $itFil++;
                                          }
                                          unset($itCol);
                                          unset($itFil);
                                    } else { //Si el objeto que se obtiene es un array (solo textos)
                                          $ItCol = 0;
                                          $ItFil = 0;
                                          if (is_array($value) == true) {
                                                foreach ($value as $Valinter) {//itera entre todas las filas recibidas del arreglo
                                                      if (is_Array($Valinter)) {
                                                            foreach ($Valinter as $ValInterCol) {
                                                                  $Pos = (FormasPreimpresasController::SeparaColFil($key));
                                                                  $ObjSalida->getActiveSheet()->getCellByColumnAndRow(($Pos->Col + $ItCol), ($Pos->Fil + $ItFil))->setValue($ValInterCol);
                                                                  $ItCol++;
                                                            }
                                                            $ItCol = 0;
                                                      } else {
                                                            $Pos = (FormasPreimpresasController::SeparaColFil($key));
                                                            $ObjSalida->getActiveSheet()->getCellByColumnAndRow($Pos->Col + $ItCol, $Pos->Fil)->setValue($Valinter);
                                                            $ItCol++;
                                                      }
                                                      $ItFil++;
                                                }
                                          } else {
                                                $ObjSalida->getActiveSheet()->getCell($key)->setValue($value); //Establece el valor de la celda en base al arreglo obtenido
                                          }
                                          unset($ItCol);
                                          unset($ItFil);
                                    }
                              }
                        }
                        unset($itCol);
                        unset($itFil); //Libera las variable de la memoria
                  } else {//Si se especifica una plantilla
                        if (file_exists($archivo_plantilla) == 1) {//Comprueba si existe el archivo de plantilla indicado
                              $Extension = strrchr($archivo_plantilla, ".");
                              if ($Extension == ".xlsx") {//Comprueba la extensión de la plantilla
                                    $objReader = new PHPExcel_Reader_Excel2007; //Crea el objeto lector
;
                                    $ObjetoSalida = $objReader->load($archivo_plantilla); //Carga el archivo al objeto plantilla
                                    $HojaPlantilla = $ObjetoSalida->getActiveSheet();

                                    $itCol = 0;
                                    $itFil = 0;
                                    foreach ($HojaPlantilla->getRowIterator() as $Fila) {//Iterador de Filas
                                          foreach ($Fila->getCellIterator() as $Celda) {//Iterador de Columnas
                                                if (array_key_exists((string)$Celda->getValue(), $Datos)) {//Comprueba si la palabra clave existe dentro del arreglo de datos recibidos
                                                      if (is_object($Datos[$Celda->getValue()])) {//Si se recibe un arreglo de cadenas
                                                            foreach ($Datos[$Celda->getValue()] as $Key => $Valor) {//Itera entre todos los elementos del primer arreglo recibido (el de nivel superior)
                                                                  if (is_array($Valor)) {//Si el coontenido del elemento en el primer array es un array también, lo itera.
                                                                        foreach ($Valor as $Cols) {//Iteración entre el contenido de los arrays() del primer array(Filas) para revisar todas las columnas
                                                                              $HojaPlantilla->getCellByColumnAndRow((PHPExcel_Cell::columnIndexFromString($Celda->getColumn()) + $itCol - 1), ($Celda->getRow() + $itFil) - 1)->setValue($Cols);
                                                                              $itCol++;
                                                                        }
                                                                  }
                                                                  if ($Key != "Formato") {//Si solo se manda un arreglo con los datos de las primeras columnas
                                                                        
                                                                  }
                                                                  $itFil++;
                                                                  $itCol = 0;
                                                            }
                                                            unset($itCol);
                                                            unset($itFil);
                                                      } else {
                                                            if (is_array($Datos[$Celda->getValue()])) {//Si se recibe un arreglo, se consideran como cabeceras todos sus elementos hacia la derecha
                                                                  $Fini = $Celda->getRow();
                                                                  $Cini = PHPExcel_Cell::columnIndexFromString($Celda->getColumn());
                                                                  $Cini--;
                                                                  foreach ($Datos[$Celda->getValue()] as $Val) {
                                                                        if (is_array($Val)) {
                                                                              foreach ($Val as $CelCol) {
                                                                                    $HojaPlantilla->getCellByColumnAndRow(($Cini + $itCol), ($Fini + $itFil))->setValue($CelCol);
                                                                                    $itCol++;
                                                                              }
                                                                              $itFil++;
                                                                              $itCol = 0;
                                                                        } else {
                                                                              $HojaPlantilla->getCellByColumnAndRow($Cini, $Fini)->setValue($Val); //Pone una fila de datos
                                                                              $Cini++;
                                                                        }
                                                                  }
                                                                  unset($Fini);
                                                                  unset($Cini);
                                                                  unset($Val);
                                                            } else {                                                                  
                                                                  $Celda->setValue($Datos[$Celda->getValue()]); //Cambia el valoren el archivo de plantilla de una sola celda
                                                            }
                                                      }
                                                }
                                          }
                                    }
                                    $ObjSalida->addExternalSheet($HojaPlantilla); //Carga la hoja de la plantilla al nuevo archivo
                                    //$ObjSalida->removeSheetByIndex(0);
                              } else {
                                    Logger::error("La extensión de la plantilla no es compatible (" . $Extension . ") con esta función (.xlsx)");
                              }
                              unset($Extension); //Libera la variable
                        } else {
                              Logger::error("El archivo de plantilla indicado no existe.");
                              return;
                        }
                  }
                  if ($imagenes != NULL) {
                        foreach ($imagenes as $Img) {//Itera entre todas las imagenes recibidas
                              if ($Img->Nombre == "" || $Img->Ruta == "" || $Img->Celda == "") {
                                    Logger::error("No se pueden procesar las imagenes, faltan argumentos");
                              } else {
                                    if (file_exists($Img->Ruta) == 1) {//Comprueba que exista la imagen
                                          $Extension = strrchr($Img->Ruta, ".");
                                          if ($Extension == ".jpeg" || $Extension == ".jpg" || $Extension == ".gif" || $Extension == ".png" || $Extension == ".bmp") {//Extensiones admitidas
                                                $Imagen = new PHPExcel_Worksheet_Drawing();
                                                $Imagen->setName($Img->Nombre);
                                                $Imagen->setDescription($Img->Descripcion);
                                                $Imagen->setPath($Img->Ruta);
                                                $Imagen->setHeight($Img->Altura);
                                                $Imagen->setCoordinates($Img->Celda);
                                                $Imagen->setWorksheet($ObjSalida->getActiveSheet());
                                          } else {
                                                Logger::error("Extension de archivo de imagen invalida.");
                                          }
                                    } else {
                                          Logger::error("El archivo de imagen indicado no existe.");
                                    }
                                    unset($Extension); //Libera la variable
                              }
                        }
                  }
	        $objWriter = new PHPExcel_Writer_Excel2007($ObjSalida);//Devuelve un objeto de escritura
	        if($Debug==0){
                  header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");//Cabeceras de salida
            header("Content-Disposition: attachment;filename=\"Excel.xlsx\"");
            header("Cache-Control: max-age=0");}
            $objWriter->save("php://output");//Imprime el archivo de salida
            } catch (Exception $e) {
                  Logger::error("Ha ocurrido un error: $e");
            }
      }

      /**
       *
       * Esta funcionalidad permite leer las palabras clave de un archivo (Plantilla) y las devuelve en forma de arreglo
       *
       * @param archivo_plantilla string Indica el archivo que se va a leer
       * @return estado string Devuelve el estado de la ejecuci�n, 0 en caso de todo correcto
       * @return datos json Devuelve el arreglo asociativo de palabras clave encontradas con sus respectivas coordenadas
       * */

      private static function SeparaColFil($Coordenadas) {//EJ: H5
            $Ret = new stdClass();
            $Ret->Fil = "";
            $Ret->Col = "";
            $I = 0;

            while (is_numeric(substr($Coordenadas, $I, 1)) == false) {
                  $I++;
            }

            $Ret->Col = PHPExcel_Cell::columnIndexFromString(substr($Coordenadas, 0, $I)) - 1;
            $Ret->Fil = (int) substr($Coordenadas, $I);
            return $Ret;
      }
      
      public  static function LeerpalabrasclaveExcel      (
      $archivo_plantilla
      ) {
            $ArregloSalida = array();
            $ObjetoLector = new PHPExcel_Reader_Excel2007; //Crea el objeto lector
            $Libro = $ObjetoLector->load($archivo_plantilla); //Carga el archivo
            $Hoja = $Libro->getActiveSheet();

            foreach ($Hoja->getRowIterator() as $Fila) {
                  foreach ($Fila->getCellIterator() as $Columna) {
                        $Valor = $Columna->getValue(); //Carga el valor de las celdas
                        if (substr($Valor, 0, 1) == "#" && substr($Valor, (strlen($Valor) - 1) == "#", 1)) {//Determina si es una palabra clave
                              array_push($ArregloSalida, substr($Valor, 1,  (strlen($Valor)-2))); //Inserta el valor asociado a sus coordenadas en el arreglo de respuesta
                        }
                  }
            }
            return array("resultados" => $ArregloSalida); //Devuelve el arreglo procesado
      }
      public static function Generar2Excel($id_documento) {
            $Debug=0;
            $TEMP = DocumentoDAOBase::getByPK($id_documento);
            $DocBase= DocumentoBaseDAO::getByPK($TEMP->getIdDocumentoBase());
            $DescDoc=DocumentoDAO::getDocumentWithValues($id_documento);//Descarga de documento
            $DescDoc=array_reverse($DescDoc);
            $Valores=array();
            $i=0;
                      
            if($DocBase->getNombrePlantilla()!=null){//Si Se especifica una plantilla
                  $arrLlaves=array();
                  $arrValores=array();
                  foreach($DescDoc as $Item){
                        $Llave="#".$Item["campo"]."#";
                        $Valor=$Item["val"];
                        array_push($arrLlaves, $Llave);
                        if(json_decode($Valor)!=null){
                              array_push($arrValores, json_decode($Valor));
                        }else{
                              array_push($arrValores, $Valor);
                        }
                  }
                  $datos=array_combine($arrLlaves, $arrValores);//Establece los datos a usar
                  $archivo_plantilla=POS_PATH_TO_SERVER_ROOT."/../static_content/" . IID . "/plantillas/excel/" . $DocBase->getNombrePlantilla();//Establece el archivo de plantilla que se va a usar
            }else{//Si no se especifica una plantilla
                  foreach($DescDoc as $parms)
                  {
                        if (FormasPreimpresasController::EsCoord($parms["descripcion"])){//Determina si son coordenadas
                              //FALTA
                        }else{//Si no son coordenadas las inserta desde la fila 1 hasta la fila n, en la columna A el nombre del campo y en la B el valor
                              $i++;
                              $Valores["A$i"]= array($parms["descripcion"]);
                              $Valores["B$i"]= array($parms["val"]);
                        }
                  }
                  //var_dump($Valores);
                  $datos=$Valores;//Establece los datos a usar
            }
            
            try {
                  if ($datos == null) {
                        Logger::error("No hay datos para trabajar"); //Termina la ejecución
                  } else {
                        $Datos = $datos; //Carga los datos con los que va a trabajar
                  }
                  if ($archivo_plantilla == null || $archivo_plantilla === "") {//Si no se especifica una plantilla
	  $ObjSalida = new PHPExcel(); //Crea el nuevo objeto de saĺida
                        $itCol = 0;
                        $itFil = 0;
                        foreach ($Datos as $key => $value) {
                              if (substr($key, 0, 1) != "#" && substr($key, (strlen($key) - 1) != "#", 1)) {//Determina si NO es una palabra clave
                                    if (is_object($value) == true) {//Si el elemento que se obtiene es un objeto (incluye formato)
                                          $Pos = FormasPreimpresasController::SeparaColFil($key);
                                          foreach ($value as $nKey => $Filas) {
                                                if (is_array($Filas)) {//Si hay un arreglo con las columnas para esa fila
                                                      foreach ($Filas as $Columnas) {//Itera entre todas las columnas contenidas en el array
                                                            $ObjSalida->getActiveSheet()->getCellByColumnAndRow(($Pos->Col + $itCol), ($Pos->Fil + $itFil - 1))->setValue($Columnas);
                                                            $itCol++;
                                                      }
                                                      $itCol = 0;
                                                }
                                                $itFil++;
                                          }
                                          unset($itCol);
                                          unset($itFil);
                                    } else { //Si el objeto que se obtiene es un array (solo textos)
                                          $ItCol = 0;
                                          $ItFil = 0;
                                          if (is_array($value) == true) {
                                                foreach ($value as $Valinter) {//itera entre todas las filas recibidas del arreglo
                                                      if (is_Array($Valinter)) {
                                                            foreach ($Valinter as $ValInterCol) {
                                                                  $Pos = (FormasPreimpresasController::SeparaColFil($key));
                                                                  $ObjSalida->getActiveSheet()->getCellByColumnAndRow(($Pos->Col + $ItCol), ($Pos->Fil + $ItFil))->setValue($ValInterCol);
                                                                  $ItCol++;
                                                            }
                                                            $ItCol = 0;
                                                      } else {
                                                            $Pos = (FormasPreimpresasController::SeparaColFil($key));
                                                            $ObjSalida->getActiveSheet()->getCellByColumnAndRow($Pos->Col + $ItCol, $Pos->Fil)->setValue($Valinter);
                                                            $ItCol++;
                                                      }
                                                      $ItFil++;
                                                }
                                          } else {
                                                $ObjSalida->getActiveSheet()->getCell($key)->setValue($value); //Establece el valor de la celda en base al arreglo obtenido
                                          }
                                          unset($ItCol);
                                          unset($ItFil);
                                    }
                              }
                        }
                        unset($itCol);
                        unset($itFil); //Libera las variable de la memoria
                  } else {//Si se especifica una plantilla
                        if (file_exists($archivo_plantilla) == 1) {//Comprueba si existe el archivo de plantilla indicado
                              $Extension = strrchr($archivo_plantilla, ".");
                              if ($Extension == ".xlsx") {//Comprueba la extensión de la plantilla
		      $ObjSalida = PHPExcel_IOFactory::load($archivo_plantilla);
		      $HojaPlantilla=$ObjSalida->getActiveSheet(); //Carga la hoja de la plantilla al nuevo archivo
			
                                    $itCol = 0;
                                    $itFil = 0;
                                    foreach ($HojaPlantilla->getRowIterator() as $Fila) {//Iterador de Filas
                                          foreach ($Fila->getCellIterator() as $Celda) {//Iterador de Columnas
                                                if (array_key_exists((string)$Celda->getValue(), $Datos)) {//Comprueba si la palabra clave existe dentro del arreglo de datos recibidos
                                                      if (is_object($Datos[$Celda->getValue()])) {//Si se recibe un arreglo de cadenas
                                                            foreach ($Datos[$Celda->getValue()] as $Key => $Valor) {//Itera entre todos los elementos del primer arreglo recibido (el de nivel superior)
                                                                  if (is_array($Valor)) {//Si el coontenido del elemento en el primer array es un array también, lo itera.
                                                                        foreach ($Valor as $Cols) {//Iteración entre el contenido de los arrays() del primer array(Filas) para revisar todas las columnas
                                                                              $HojaPlantilla->getCellByColumnAndRow((PHPExcel_Cell::columnIndexFromString($Celda->getColumn()) + $itCol - 1), ($Celda->getRow() + $itFil) - 1)->setValue($Cols);
                                                                              $itCol++;
                                                                        }
                                                                  }
                                                                  if ($Key != "Formato") {//Si solo se manda un arreglo con los datos de las primeras columnas
                                                                        
                                                                  }
                                                                  $itFil++;
                                                                  $itCol = 0;
                                                            }
                                                            unset($itCol);
                                                            unset($itFil);
                                                      } else {
                                                            if (is_array($Datos[$Celda->getValue()])) {//Si se recibe un arreglo, se consideran como cabeceras todos sus elementos hacia la derecha
                                                                  $Fini = $Celda->getRow();
                                                                  $Cini = PHPExcel_Cell::columnIndexFromString($Celda->getColumn());
                                                                  $Cini--;
                                                                  foreach ($Datos[$Celda->getValue()] as $Val) {
                                                                        if (is_array($Val)) {
                                                                              foreach ($Val as $CelCol) {
                                                                                    $HojaPlantilla->getCellByColumnAndRow(($Cini + $itCol), ($Fini + $itFil))->setValue($CelCol);
                                                                                    $itCol++;
                                                                              }
                                                                              $itFil++;
                                                                              $itCol = 0;
                                                                        } else {
                                                                              $HojaPlantilla->getCellByColumnAndRow($Cini, $Fini)->setValue($Val); //Pone una fila de datos
                                                                              $Cini++;
                                                                        }
                                                                  }
                                                                  unset($Fini);
                                                                  unset($Cini);
                                                                  unset($Val);
                                                            } else {                                                                  
                                                                  $Celda->setValue($Datos[$Celda->getValue()]); //Cambia el valoren el archivo de plantilla de una sola celda
                                                            }
                                                      }
                                                }
                                          }
                                    }
                              } else {
                                    Logger::error("La extensión de la plantilla no es compatible (" . $Extension . ") con esta función (.xlsx)");
                              }
                              unset($Extension); //Libera la variable
                        } else {
                              Logger::error("El archivo de plantilla indicado no existe.");
                              return;
                        }
                  }
                  $objWriter = PHPExcel_IOFactory::createWriter($ObjSalida, 'Excel2007');//Devuelve un objeto de escritura

            } catch (Exception $e) {
                  Logger::error("Ha ocurrido un error: $e");
            }
      if($Debug===1){
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");//Cabeceras de salida
            header("Content-Disposition: attachment;filename=\"Excel.xlsx\"");
            header("Cache-Control: max-age=0");
      }
            $objWriter->save("php://output");//Imprime el archivo de salida
      }
      
      /*
      * Esta función permite determinar si el argumento obtenido es una coordenada de MSExcel
      *
      *       
      */
      static function EsCoord($Dato)
      {
            $i=0;
            $j=0;
            for($i=0;$i<strlen($Dato);$i++){//Comprueba hasta donde inicia el primer caracter numerico
                  if(is_int(substr($Dato,$i,1))){//Donde encuentra el primer caracter númerico sale del ciclo
                        $j=$i;
                        break;
                  }
            }
            if(strlen($Dato)==$i){return false;};//Si ese caracter es el ultimo caracter, no es valida
            
            for($i=$j;$i<strlen($Dato);$i++){//Comprueba dede el caracter hasta el ultimo
                  if(is_string(substr($Dato,$i,1))){//Si estipo texto, es invalido, solo se esperan numeros ahi
                        break;
                  }
            }
      }
}