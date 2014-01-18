<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CajasController extends ValidacionesController{

    
    public static function modificarCaja
        (
                $id_caja,
                $suma,
                $billetes,
                $monto
        )
        {
            $caja=CajaDAO::getByPK($id_caja);
            if(is_null($caja))
            {
                Logger::error("La caja especificada no existe");
                throw new Exception("La caja especificada no existe",901);
            }
            if(!$caja->getAbierta())
            {
                Logger::error("La caja especificada esta cerrada, tiene que abrirla para realizar movimientos");
                throw new Exception("La caja especificada esta cerrada, tiene que abrirla para realizar movimientos",901);
            }
            //
            //Actualizas el saldo de la caja
            //
            if($suma)
                $caja->setSaldo($caja->getSaldo()+$monto);
            else
                $caja->setSaldo($caja->getSaldo()-$monto);
            DAO::transBegin();
            try
            {
                CajaDAO::save($caja);
                /////////////-editar nombre_cuenta de la cuenta contable asociada
                //
                //Si se esta llevando control de lo billetes en la caja
                //tienen que haber pasado en un arreglo bidimensional los ids
                //de los billetes con sus cantidades.
                //
                if($caja->getControlBilletes())
                {
                    if(is_null($billetes))
                    {
                        throw new Exception("No se recibieron los billetes para esta caja",901);
                    }
                    
                    $billetes = object_to_array($billetes);
                    
                    if(!is_array($billetes))
                    {
                        throw new Exception("Los billetes no son validos",901);
                    }
                    
                    $numero_billetes=count($billetes);
                    //
                    //Inicializas el arreglo de billetes_caja con los billetes que recibes
                    //para despues insertarlo o actualizarlo.
                    //
                    for($i=0;$i<$numero_billetes; $i++)
                    {
                        if
                        (
                                !array_key_exists("id_billete", $billetes[$i])  ||
                                !array_key_exists("cantidad", $billetes[$i])    
                        )
                        {
                            throw new Exception("Los billetes no son validos",901);
                        }
                        if(is_null(BilleteDAO::getByPK($billetes[$i]["id_billete"])))
                        {
                            throw new Exception("El billete con id: ".$billetes[$i]["id_billete"]." no existe",901);
                        }
                        if(is_string($validar=self::validarNumero($billetes[$i]["cantidad"], PHP_INT_MAX, "cantidad")))
                        {
                                throw new Exception($validar,901);
                        }
                        $billete_caja[$i]=new BilleteCaja();
                        $billete_caja[$i]->setIdBillete($billetes[$i]["id_billete"]);
                        $billete_caja[$i]->setIdCaja($id_caja);
                        $billete_caja[$i]->setCantidad($billetes[$i]["cantidad"]);
                    }
                    //
                    //Intentas insertar cada billete con su cantidad, si ese billete ya existe
                    //en esa caja, actulizas su cantidad.
                    //
                    for($i=0;$i<$numero_billetes;$i++)
                    {
                        $billete_caja_original=BilleteCajaDAO::getByPK($billete_caja[$i]->getIdBillete(), $billete_caja[$i]->getIdCaja());
                        if(is_null($billete_caja_original))
                        {
                            if(!$suma)
                                $billete_caja[$i]->setCantidad($billete_caja[$i]->getCantidad()*-1);
                            BilleteCajaDAO::save($billete_caja[$i]);
                        }
                        else
                        {
                            if($suma)
                                $billete_caja_original->setCantidad($billete_caja_original->getCantidad()+$billete_caja[$i]->getCantidad());
                            else
                                $billete_caja_original->setCantidad($billete_caja_original->getCantidad()-$billete_caja[$i]->getCantidad());
                            BilleteCajaDAO::save($billete_caja_original);
                        }
                    }
                }
            }
            catch(Exception $e)
            {
                DAO::transRollback();
                Logger::error("No se pudo actualizar la caja: ".$e);
                if($e->getCode()==901)
                    throw new Exception("No se pudo actualizar la caja: ".$e->getMessage(),901);
                throw new Exception("No se pudo actualizar la caja, consulte a su administrador de sistema",901);
            }
            DAO::transEnd();
            Logger::log("Caja actualizada exitosamente");
        }
}
?>
