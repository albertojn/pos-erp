<?php
require_once("interfaces/CargosYAbonos.interface.php");
/**
 *
 *
 *
 **/

class CargosYAbonosController extends ValidacionesController implements ICargosYAbonos
{

    /*
     * Valida los parametros de la tabla ingreso. Regresa un string con el error en caso
     * de haber uno, de lo contrario regresa verdadero.
     */
    private static function validarParametrosIngreso($id_ingreso = null, $id_empresa = null, $id_concepto_ingreso = null, $fecha_del_ingreso = null, $id_sucursal = null, $id_caja = null, $nota = null, $descripcion = null, $folio = null, $monto = null, $cancelado = null, $motivo_cancelacion = null)
    {
        //valida que el ingreso exista en la base de datos
        if (!is_null($id_ingreso)) {
            $ingreso = IngresoDAO::getByPK($id_ingreso);
            if (is_null($ingreso))
                return "El ingreso con id " . $id_ingreso . " no existe";
            if ($ingreso->getCancelado())
                return "El ingreso ya ha sido cancelado";
        }
        
        //valida que la empresa exista en la base de datos
        if (!is_null($id_empresa)) {
            $empresa = EmpresaDAO::getByPK($id_empresa);
            if (is_null($empresa))
                return "La empresa con id " . $id_empresa . " no existe";
            if (!$empresa->getActivo())
                return "La empresa esta desactivada";
        }
        
        //valida que el concepto de ingreso exista en la base de datos
        if (!is_null($id_concepto_ingreso)) {
            $concepto_ingreso = ConceptoIngresoDAO::getByPK($id_concepto_ingreso);
            if (is_null($concepto_ingreso))
                return "El concepto de ingreso con id " . $id_concepto_ingreso . " no existe";
            if (!$concepto_ingreso->getActivo())
                return "El concepto de ingreso esta desactivado";
        }
        
        //valida que el string fecha_del_ingreso sea valido
        if (!is_null($fecha_del_ingreso)) {
            $e = self::validarString($fecha_del_ingreso, strlen("YYYY-mm-dd HH:ii:ss"), "fecha del ingreso");
            if (is_string($e))
                return $e;
        }
        
        //valida que la sucursal exista en la base de datos
        if (!is_null($id_sucursal)) {
            $sucursal = SucursalDAO::getByPK($id_sucursal);
            if (is_null($sucursal))
                return "La sucursal con id " . $id_sucursal . " no existe";
            if (!$sucursal->getActiva())
                return "La sucursal esta desactivada";
        }
        
        //valida que la caja exista en la base de datos
        if (!is_null($id_caja)) {
            $caja = CajaDAO::getByPK($id_caja);
            if (is_null($caja))
                return "La caja con id " . $id_caja . " no existe";
            
            if (!$caja->getAbierta())
                return "La caja no esta abierta, no se le pueden hacer cambios";
            
            if (!$caja->getActiva())
                return "La caja esat desactivada";
        }
        
        //valida que el string nota este en el rango
        if (!is_null($nota)) {
            $e = self::validarString($nota, 64, "nota");
            if (is_string($e))
                return $e;
        }
        
        //valida que la descripcion este en el rango
        if (!is_null($descripcion)) {
            $e = self::validarString($descripcion, 255, "descripcion");
            if (is_string($e))
                return $e;
        }
        
        //valida que el folio este en el rango
        if (!is_null($folio)) {
            $e = self::validarString($folio, 50, "folio");
            if (is_string($e))
                return $e;
        }
        
        //valida que el monto este en el rango
        if (!is_null($monto)) {
            $e = self::validarNumero($monto, 1.8e200, "monto");
            if (is_string($e))
                return $e;
        }
        
        //valida el boleano canceldo
        if (!is_null($cancelado)) {
            $e = self::validarNumero($cancelado, 1, "cancelado");
            if (is_string($e))
                return $e;
        }
        
        //valida el motivo de cancelacion
        if (!is_null($motivo_cancelacion)) {
            $e = self::validarString($motivo_cancelacion, 255, "motivo de cancelacion");
            if (is_string($e))
                return $e;
        }
        
        //No se encontro error, regresa verdadero
        return true;
    }
    
    /*
     * Valida los parametros de la tabla conceptoGasto, regresa un string con el error en caso 
     * de haber uno, de lo contrario, regresa true
     */
    private static function validarParametrosConceptoGasto($id_concepto_gasto = null, $nombre = null, $descripcion = null, $id_cuenta_contable = null, $activo = null)
    {
        //valida que el concepto de gasto exista en la base de datos y que este activo
        if (!is_null($id_concepto_gasto)) {
            $concepto_gasto = ConceptoGastoDAO::getByPK($id_concepto_gasto);
            if (is_null($concepto_gasto))
                return "El concepto gasto con id " . $id_concepto_gasto . " no existe";
            if (!$concepto_gasto->getActivo())
                return "El concepto de gasto no esta activo";
        }
        
        //valida que el nombre este en rango y que no se repita
        if (!is_null($nombre)) {
            $e = self::validarString($nombre, 50, "nombre");
            if (is_string($e))
                return $e;
            $conceptos_gasto = ConceptoGastoDAO::search(new ConceptoGasto(array(
                "nombre" => trim($nombre)
            )));
            foreach ($conceptos_gasto as $c_g) {
                if ($c_g->getActivo())
                    return "El nombre (" . trim($nombre) . ") ya esta siendo usado por el concepto_gasto " . $c_g->getIdConceptoGasto();
            }
        }
        
        //valida que la descripcion este en rango
        if (!is_null($descripcion)) {
            $e = self::validarString($descripcion, 255, "descripcion");
            if (is_string($e))
                return $e;
        }
        
        //valida que exista esa cuenta contable

        $cc = CuentaContableDAO::getByPK($id_cuenta_contable);
        if (is_null($cc))
            return "La cuenta contable con id " . $id_cuenta_contable . " no existe";

        //valida el boleano activo
        if (!is_null($activo)) {
            $e = self::validarNumero($activo, 1, "activo");
            if (is_string($e))
                return $e;
        }
        
        //No se encontro error, regresa true
        return true;
    }
    
    /*
     * Valida los parametros de la tabla concepto_ingreso. Regresa un string con el error
     * si se ha encontrado alguno, en caso contrario regresa verdadero.
     */
    private static function validarParametrosConceptoIngreso($id_concepto_ingreso = null, $nombre = null, $descripcion = null, $id_cuenta_contable = null, $activo = null)
    {
        //valida que el concepto de ingreso exista en la base de datos y que este activo
        if (!is_null($id_concepto_ingreso)) {
            $concepto_ingreso = ConceptoIngresoDAO::getByPK($id_concepto_ingreso);
            if (is_null($concepto_ingreso))
                return "El concepto de ingreso con id " . $id_concepto_ingreso . " no existe";
            if (!$concepto_ingreso->getActivo())
                return "El concepto de ingreso esta inactivo";
        }
        
        //valida que el nombre este en rango y que no se repita
        if (!is_null($nombre)) {
            $e = self::validarString($nombre, 50, "nombre");
            if (is_string($e))
                return $e;
            $conceptos_ingreso = ConceptoIngresoDAO::search(new ConceptoIngreso(array(
                "nombre" => trim($nombre)
            )));
            foreach ($conceptos_ingreso as $c_i) {
                if ($c_i->getActivo())
                    return "El nombre (" . $nombre . ") ya esta en uso por el concepto de ingreso " . $c_i->getIdConceptoIngreso();
            }
        }
        
        //valida que la descripcion este en rango
        if (!is_null($descripcion)) {
            $e = self::validarString($descripcion, 255, "descripcion");
            if (is_string($e))
                return $e;
        }
        
        $cc = CuentaContableDAO::getByPK($id_cuenta_contable);
        if (is_null($cc))
            return "La cuenta contable con id " . $id_cuenta_contable . " no existe";

        //valida el boleano activo
        if (!is_null($activo)) {
            $e = self::validarNumero($activo, 1, "activo");
            if (is_string($e))
                return $e;
        }
        
        //No se encontro error, regresa verdadero
        return true;
    }
    
    /*
     * Valida los parametros de la tabla gasto. Regresa un string con el error
     * si es que hay uno, de lo contrario regresa verdadero
     */
    private static function validarParametrosGasto($id_gasto = null, $id_empresa = null, $id_concepto_gasto = null, $id_orden_de_servicio = null, $fecha_del_gasto = null, $id_sucursal = null, $id_caja = null, $nota = null, $descripcion = null, $folio = null, $monto = null, $cancelado = null, $motivo_cancelacion = null)
    {
        //valida que el ingreso exista en la base de datos
        if (!is_null($id_gasto)) {
            $gasto = GastoDAO::getByPK($id_gasto);
            if (is_null($gasto))
                return "El gasto con id " . $id_gasto . " no existe";
            if ($gasto->getCancelado())
                return "El gasto ya ha sido cancelado";
        }
        
        //valida que la empresa exista en la base de datos
        if (!is_null($id_empresa)) {
            $empresa = EmpresaDAO::getByPK($id_empresa);
            if (is_null($empresa))
                return "La empresa con id " . $id_empresa . " no existe";
            if (!$empresa->getActivo())
                return "La empresa esta desactivada";
        }
        
        //valida que el concepto de ingreso exista en la base de datos
        if (!is_null($id_concepto_gasto)) {
            $concepto_gasto = ConceptoGastoDAO::getByPK($id_concepto_gasto);
            if (is_null($concepto_gasto))
                return "El concepto de gasto con id " . $id_concepto_gasto . " no existe";
            if (!$concepto_gasto->getActivo())
                return "El concepto de gasto esta desactivado";
        }
        
        //valida que la orden de servicio exista y que este activa
        if (!is_null($id_orden_de_servicio)) {
            $orden_de_servicio = OrdenDeServicioDAO::getByPK($id_orden_de_servicio);
            if (is_null($orden_de_servicio))
                return "La orden de servicio " . $id_orden_de_servicio . " no existe";
            if (!$orden_de_servicio->getActiva())
                return "La orden de servicio ya esta desactivada";
        }
        
        //valida que el string fecha_del_ingreso sea valido
        if (!is_null($fecha_del_gasto)) {
            $e = self::validarString($fecha_del_gasto, strlen("YYYY-mm-dd HH:ii:ss"), "fecha del ingreso");
            if (is_string($e))
                return $e;
        }
        
        //valida que la sucursal exista en la base de datos
        if (!is_null($id_sucursal)) {
            $sucursal = SucursalDAO::getByPK($id_sucursal);
            if (is_null($sucursal))
                return "La sucursal con id " . $id_sucursal . " no existe";
            if (!$sucursal->getActiva())
                return "La sucursal esta desactivada";
        }
        
        //valida que la caja exista en la base de datos
        if (!is_null($id_caja)) {
            $caja = CajaDAO::getByPK($id_caja);
            if (is_null($caja))
                return "La caja con id " . $id_caja . " no existe";
            
            if (!$caja->getAbierta())
                return "La caja no esta abierta, no se le pueden hacer cambios";
            
            if (!$caja->getActiva())
                return "La caja esat desactivada";
        }
        
        //valida que el string nota este en el rango
        if (!is_null($nota)) {
            $e = self::validarString($nota, 64, "nota");
            if (is_string($e))
                return $e;
        }
        
        //valida que la descripcion este en el rango
        if (!is_null($descripcion)) {
            $e = self::validarString($descripcion, 255, "descripcion");
            if (is_string($e))
                return $e;
        }
        
        //valida que el folio este en el rango
        if (!is_null($folio)) {
            $e = self::validarString($folio, 50, "folio");
            if (is_string($e))
                return $e;
        }
        
        //valida que el monto este en el rango
        if (!is_null($monto)) {
            $e = self::validarNumero($monto, 1.8e200, "monto");
            if (is_string($e))
                return $e;
        }
        
        //valida el boleano canceldo
        if (!is_null($cancelado)) {
            $e = self::validarNumero($cancelado, 1, "cancelado");
            if (is_string($e))
                return $e;
        }
        
        //valida el motivo de cancelacion
        if (!is_null($motivo_cancelacion)) {
            $e = self::validarString($motivo_cancelacion, 255, "motivo de cancelacion");
            if (is_string($e))
                return $e;
        }
        
        //No se encontro error, regresa verdadero
        return true;
    }
    
    
    /*
     * Valida los parametros de un abono
     */
    private static function validarParametrosAbono($monto = null, $id_deudor = null, $nota = null, $tipo_de_pago = null, $motivo_cancelacion = null)
    {
        //valida que el monto este en rango
        if (!is_null($monto)) {
            $e = self::validarNumero($monto, 1.8e200, "monto");
            if (is_string($e))
                return $e;
        }
        
        //valida que el deudor exista
        if (!is_null($id_deudor)) {
            $deudor = UsuarioDAO::getByPK($id_deudor);
            if (is_null($deudor))
                return "El usuario con id " . $id_deudor . " no existe";
            
            if (!$deudor->getActivo())
                return "EL usuario ya esta inactivo";
        }
        
        //valida que la nota este en rango
        if (!is_null($nota)) {
            $e = self::validarString($nota, 255, "nota");
            if (is_string($e))
                return $e;
        }
        
        //valida que el tipo de pago sea correcto
        if (!is_null($tipo_de_pago)) {
            if ($tipo_de_pago != "cheque" && $tipo_de_pago != "tarjeta" && $tipo_de_pago != "efectivo")
                return "El tipo de pago (" . $tipo_de_pago . ") no es valido";
        }
        
        //valida que el motivo de cancelacion este en rango
        if (!is_null($motivo_cancelacion)) {
            $e = self::validarString($motivo_cancelacion, 255, "motivo de cancelacion");
            if (is_string($e))
                return $e;
        }
        
        //no se encontro error, regresa true
        return true;
    }
    
    
    
    //Metodo para pruebas que simula la obtencion del id de la sucursal actual
    private static function getSucursal()
    {
        $s = SesionController::Actual();
        return $s["id_sucursal"];
    }
    
    //metodo para pruebas que simula la obtencion del id de la caja actual
    private static function getCaja()
    {
        $s = SesionController::Actual();
        return $s["id_caja"];
    }
    /**
     *
     *Registra un nuevo ingreso
     *
     * @param fecha_ingreso string Fecha del ingreso
     * @param id_empresa int Id de la empresa a la que pertenece este ingreso
     * @param monto float Monto del ingreso en caso de que no este contemplado por el concepto de ingreso o que sea diferente
     * @param id_sucursal int Id de la caja a la que pertenece este ingreso
     * @param id_concepto_ingreso int Id del concepto al que hace referencia el ingreso
     * @param id_caja int Id de la caja en la que se registra el ingreso
     * @param folio string Folio de la factura del ingreso
     * @param nota string Nota del ingreso
     * @param descripcion string Descripcion del ingreso en caso de no este contemplado en la lista de conceptos de ingreso
     * @return id_ingreso int Id autogenerado por la insercion del ingreso
     **/
    public static function NuevoIngreso($fecha_ingreso, $id_empresa, $billetes = null, $descripcion = null, $folio = null, $id_caja = null, $id_concepto_ingreso = null, $id_sucursal = null, $monto = null, $nota = null)
    {
        Logger::log("Creando nuevo ingreso");
        
        //Se obtiene al usuario de la sesion
        $id_usuario = SesionController::getCurrentUser();
        $id_usuario = $id_usuario->getIdUsuario();

        if (is_null($id_usuario)) {
            Logger::error("No se pudo obtener el usuario de la sesion, ya inicio sesion?");
            throw new Exception("No se pudo obtener el usuario de la sesion, ya inicio sesion?");
        }

        //Se validan los parametros obtenidos
        $validar = self::validarParametrosIngreso(null, $id_empresa, $id_concepto_ingreso, $fecha_ingreso, $id_sucursal, $id_caja, $nota, $descripcion, $folio, $monto);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        //Verifica el monto del ingreso, si no se ha recibido un monto, se busca en el concepto.
        //Si el concepto no se recibe o no tiene monto se manda una excepcion
        if (is_null($monto)) {
            Logger::log("No se recibio monto, se procede a buscar en el concepto de ingreso");
            if (is_null($id_concepto_ingreso)) {
                Logger::error("No se recibio un concepto de ingreso");
                throw new Exception("No se recibio un concepto de ingreso ni un monto");
            }
            $concepto_ingreso = ConceptoIngresoDAO::getByPK($id_concepto_ingreso);
            $monto            = $concepto_ingreso->getMonto();
            if (is_null($monto)) {
                Logger::error("El concepto de ingreso recibido no cuenta con un monto");
                throw new Exception("El concepto de ingreso recibido no cuenta con un monto ni se recibio un monto");
            }
        }
        
        //Si no se recibe sucursal, se obtiene la acutal,
        //si no se logro obtener se registra el ingreso sin sucursal
        if (!$id_sucursal)
            $id_sucursal = self::getSucursal();
        
        //Si no se recibe caja, se obtiene la actual,
        //si no se obtiene la actual, se registra el ingreso sin caja
        if (!$id_caja)
            $id_caja = self::getCaja();
        
        //Si se obtuvo una caja, se le agrega a su saldo el monto del ingreso
        if (!is_null($id_caja)) {
            try {
                CajasController::modificarCaja($id_caja, 1, $billetes, $monto);
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        
        //Se inicializa el registro de ingreso
        $ingreso = new Ingreso();
        $ingreso->setCancelado(0);
        $ingreso->setDescripcion($descripcion);
        
		// fecha_ingreso might be in the format : 2012-10-21T00:00:00
        // if this is the case then act acordingly
        if ( is_int( $fecha_ingreso ) )
        {
            $ingreso->setFechaDelIngreso( $fecha_ingreso );
        }
        else
        {
            $ingreso->setFechaDelIngreso( strtotime( $fecha_ingreso ) );
        }

        $ingreso->setFolio($folio);
        $ingreso->setIdCaja($id_caja);
        $ingreso->setIdConceptoIngreso($id_concepto_ingreso);
        $ingreso->setIdEmpresa($id_empresa);
        $ingreso->setIdSucursal($id_sucursal);
        $ingreso->setIdUsuario($id_usuario);
        $ingreso->setMonto($monto);
        $ingreso->setNota($nota);
        $ingreso->setFechaDeRegistro( time( ) );
        DAO::transBegin();
        try {
            IngresoDAO::save($ingreso);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("Error al guardar el nuevo ingreso: " . $e);
            throw new Exception("Error al guardar el nuevo ingreso");
        }
        DAO::transEnd();
        Logger::log("Ingreso creado exitosamente!");
        return array(
            "id_ingreso" => $ingreso->getIdIngreso()
        );
    }
    
    /**
     *
     *Cancela un abono
     *
     * @param id_abono int Id del abono a cancelar
     * @param motivo_cancelacion string Motivo por el cual se realiza la cancelacion
     **/
    public static function EliminarAbono($id_abono, $billetes = null, $compra = null, $id_caja = null, $motivo_cancelacion = null, $prestamo = null, $venta = null)
    {
        Logger::log("Cancelando abono");
        
        /*
         * Se comprueba que el abono sea de compra, de venta o de prestamo.
         * 
         * En los 3 casos, se busca el abono en su repectiva tabla y se verifica que 
         * este activo.
         * 
         * Despues, se le cambia el estado a inactivo, se obtiene la caja actual en caso
         * de que no haya sido pasada y se llama al metodo cancelarAbono.
         */
        if ($compra) {
            $abono = AbonoCompraDAO::getByPK($id_abono);
            if (is_null($abono)) {
                Logger::error("El abono para compra con id:" . $id_abono . " no existe");
                throw new Exception("El abono para compra con id:" . $id_abono . " no existe");
            }
            if ($abono->getCancelado()) {
                Logger::log("El abono ya ha sido cancelado antes");
                throw new Exception("El abono ya ha sido cancelado antes");
            }
            
            //valida el parametro motivo de cancelcion
            $validar = self::validarString($motivo_cancelacion, 255, "motivo de cancelacion");
            if (is_string($validar)) {
                Logger::error($validar);
                throw new Exception($validar);
            }
            
            //Actualiza el abono
            $abono->setCancelado(1);
            $abono->setMotivoCancelacion($motivo_cancelacion);
            if (!$id_caja)
                $id_caja = self::getCaja();
            DAO::transBegin();
            try {
                AbonoCompraDAO::save($abono);
                self::cancelarAbonoCompra($abono, $id_caja, $billetes);
            }
            catch (Exception $e) {
                DAO::transRollback();
                throw new Exception("Error al cancelar el abono:" . $e);
            }
            DAO::transEnd();
            Logger::log("Abono cancelado exitosamente");
        } else if ($venta) {
            $abono = AbonoVentaDAO::getByPK($id_abono);
            if (is_null($abono)) {
                Logger::error("El abono para venta con id:" . $id_abono . " no existe");
                throw new Exception("El abono para venta con id:" . $id_abono . " no existe");
            }
            if ($abono->getCancelado()) {
                Logger::log("El abono ya ha sido cancelado antes");
                throw new Exception("El abono ya ha sido cancelado antes");
            }
            $abono->setCancelado(1);
            $abono->setMotivoCancelacion($motivo_cancelacion);
            if (!$id_caja)
                $id_caja = self::getCaja();
            DAO::transBegin();
            try {
                AbonoVentaDAO::save($abono);
                self::cancelarAbonoVenta($abono, $id_caja, $billetes);
            }
            catch (Exception $e) {
                DAO::transRollback();
                Logger::error("Error al cancelar el abono: " . $e);
                throw new Exception("Error al cancelar el abono");
            }
            DAO::transEnd();
            Logger::log("Abono cancelado exitosamente");
        } else if ($prestamo) {
            $abono = AbonoPrestamoDAO::getByPK($id_abono);
            if (is_null($abono)) {
                Logger::error("El abono para prestamo con id:" . $id_abono . " no existe");
                throw new Exception("El abono para prestamo con id:" . $id_abono . " no existe");
            }
            if ($abono->getCancelado()) {
                Logger::log("El abono ya ha sido cancelado antes");
                throw new Exception("El abono ya ha sido cancelado antes");
            }
            $abono->setCancelado(1);
            $abono->setMotivoCancelacion($motivo_cancelacion);
            if (!$id_caja)
                $id_caja = self::getCaja();
            DAO::transBegin();
            try {
                AbonoPrestamoDAO::save($abono);
                self::cancelarAbonoPrestamo($abono, $id_caja, $billetes);
            }
            catch (Exception $e) {
                DAO::transRollback();
                Logger::error("Error al cancelar el abono " . $id_abono . ": " . $e);
                throw new Exception("Error al cancelar el abono");
            }
            DAO::transEnd();
            Logger::log("Abono cancelado exitosamente");
        } else {
            Logger::error("No se recibio el parametro compra, venta ni prestamo, no se sabe que abono cancelar");
            throw new Exception("No se recibio el parametro compra, venta ni prestamo, no se sabe que abono cancelar");
        }
    }
    /* Fin metodo Eliminar Abono */
    
    
    
    /*
     * Los metodos cancelarAbonoCompra,cancelarAbonoVenta y cancelarAbonoPrestamo
     * son muy parecidos, solo cambian en las tablas en las que efectuan los cambios.
     * 
     * Primero se verifica la operacion (compra,venta,prestamo) a la que hacen referencia,
     * despues al usuario que realiza dicha operacion(id_vendedor,id_comprador,id_deduor),
     * 
     * Despues proceden a efectuar los cambios a los saldos de acuerdo al monto del abono.
     */
    
    private static function cancelarAbonoCompra(AbonoCompra $abono, $id_caja, $billetes)
    {
        $compra = CompraDAO::getByPK($abono->getIdCompra());
        if (is_null($compra)) {
            Logger::error("FATAL!!!! Este abono apunta a una compra que no existe!!");
            throw new Exception("FATAL!!!! Este abono apunta a una compra que no existe!!");
        }
        $usuario = UsuarioDAO::getByPK($compra->getIdVendedorCompra());
        if (is_null($usuario)) {
            Logger::error("FATAL!!!! La compra de este abono no tiene un vendedor");
            throw new Exception("FATAL!!!! La compra de este abono no tiene un vendedor");
        }
        $monto = $abono->getMonto();
        //
        //Si la compra ha sido cancelada, quiere decir que se cancelaran todos los abonos y
        //ese dinero solo se quedara a cuenta del usuario.
        //
        //Si no ha sido cancelada, quiere decir que solo se cancela este abono y por ende el
        //dinero regresa a la caja que indica el usuario.
        //
        //Si no hay una caja, se tomara el dinero como perdido.
        if (!$compra->getCancelada() && !is_null($id_caja)) {
            try {
                CajasController::modificarCaja($id_caja, 1, $billetes, $monto);
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        
        //Si la compra no ha sido cancelada, quiere decir que solo se cancela este abono y por ende
        //los cheques se le regresan al usuario. Ademas, el saldo del usuario y de la compra se modifican
        //para eliminar este abono.
        if (!$compra->getCancelada()) {
            DAO::transBegin();
            try {
                $usuario->setSaldoDelEjercicio($usuario->getSaldoDelEjercicio() + $monto);
                $compra->setSaldo($compra->getSaldo() - $monto);
                self::eliminarCheques($abono->getIdAbonoCompra(), 1, null, null);
                UsuarioDAO::save($usuario);
                CompraDAO::save($compra);
            }
            catch (Exception $e) {
                DAO::transRollback();
                Logger::error("No se ha podido actualizar al usuario ni la compra: " . $e);
                throw new Exception("No se ha podido actualizar al usuario ni la compra");
            }
            DAO::transEnd();
        }
    }
    


    private static function cancelarAbonoVenta(AbonoVenta $abono, $id_caja, $billetes)
    {
        $venta = VentaDAO::getByPK($abono->getIdVenta());
        if (is_null($venta)) {
            Logger::error("FATAL!!!! Este abono apunta a una venta que no existe!!");
            throw new Exception("FATAL!!!! Este abono apunta a una venta que no existe!!");
        }
        $usuario = UsuarioDAO::getByPK($venta->getIdCompradorVenta());
        if (is_null($usuario)) {
            Logger::error("FATAL!!!! La venta de este abono no tiene un comprador");
            throw new Exception("FATAL!!!! La venta de este abono no tiene un comprador");
        }
        $monto = $abono->getMonto();
        //
        //Si la venta ha sido cancelada, quiere decir que se cancelaran todos los abonos y
        //ese dinero solo se quedara a cuenta del usuario.
        //
        //Si no ha sido cancelada, quiere decir que solo se cancela este abono y por ende el
        //dinero sale de la caja que indica el usuario.
        //
        //Si no hay una caja, se tomara el dinero como ganado.
        if (!$venta->getCancelada() && !is_null($id_caja)) {
            try {
                CajasController::modificarCaja($id_caja, 0, $billetes, $monto);
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        if (!$venta->getCancelada()) {
            DAO::transBegin();
            try {
                $usuario->setSaldoDelEjercicio($usuario->getSaldoDelEjercicio() - $monto);
                $venta->setSaldo($venta->getSaldo() - $monto);
                self::eliminarCheques($abono->getIdAbonoVenta(), null, 1, null);
                UsuarioDAO::save($usuario);
                VentaDAO::save($venta);
            }
            catch (Exception $e) {
                DAO::transRollback();
                Logger::error("No se ha podido actualizar al usuario ni la venta: " . $e);
                throw new Exception("No se ha podido actualizar al usuario ni a la venta");
            }
            DAO::transEnd();
        }
    }
    
    //Este metodo no necesita verificar que el prestamoa haya sido cancelado o no
    //solo tiene que verificar el id del solicitante, pues las sucursales que piden
    //prestamos guardan su id como negativas
    private static function cancelarAbonoPrestamo(AbonoPrestamo $abono, $id_caja, $billetes)
    {
        $prestamo = PrestamoDAO::getByPK($abono->getIdPrestamo());
        if (is_null($prestamo)) {
            Logger::error("FATAL!!!! Este abono apunta a un prestamo que no existe!!");
            throw new Exception("FATAL!!!! Este abono apunta a un prestamo que no existe!!");
        }
        //
        //Los solicitantes pueden ser positivos o negativos.
        //Si son positivos, son usuarios, si son negativos, son sucursales.
        //
        //Cuando un usuario cancela su abono a un prestamo, se incrementa su deuda.
        //
        //Cuando una sucursal cancela su abono, solo se afecta el prestamo, pues
        //la cuenta de la sucursal se calcula a partir de todos sus movimientos
        //y es en el prestamo donde se vera reflejado el cambio.
        //
        $id_solicitante = $prestamo->getIdSolicitante();
        if ($id_solicitante > 0)
            $solicitante = UsuarioDAO::getByPK($id_solicitante);
        else
            $solicitante = SucursalDAO::getByPK($id_solicitante * -1);
        if (is_null($solicitante)) {
            Logger::error("FATAL!!!! El prestamo de este abono no tiene un solicitante");
            throw new Exception("FATAL!!!! El prestamo de este abono no tiene un solicitante");
        }
        $monto = $abono->getMonto();
        if ($id_solicitante > 0)
            $solicitante->setSaldoDelEjercicio($solicitante->getSaldoDelEjercicio() - $monto);
        $prestamo->setSaldo($prestamo->getSaldo() - $monto);
        //
        //Un Prestamo no puede ser cancelado, solo liquidado.
        //
        //Si no hay una caja, se tomara el dinero como ganado.
        //
        if (!is_null($id_caja)) {
            try {
                CajasController::modificarCaja($id_caja, 0, $billetes, $monto);
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        try {
            self::eliminarCheques($abono->getIdAbonoPrestamo(), null, null, 1);
        }
        catch (Exception $e) {
            throw $e;
        }
        //
        //Si no ha ocurrido ningun error con los billetes o con la caja, actualizas
        //al usuario y a la compra
        //
        DAO::transBegin();
        try {
            if ($id_solicitante > 0)
                UsuarioDAO::save($solicitante);
            PrestamoDAO::save($prestamo);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se ha podido actualizar al usuario ni al prestamo: " . $e);
            throw new Exception("No se ha podido actualizar al usuario ni al prestamo");
        }
        DAO::transEnd();
    }
    
    
    
    
    /*
     * Este metodo se encarga de eliminar los cheques relacionados con un abono de compra, venta
     * o prestamo.
     */
    private static function eliminarCheques($id_abono, $compra = null, $venta = null, $prestamo = null)
    {
        $resultados = null;
        $from       = 0;
        
        //valida si el abono sera de compra, de venta o de prestamo
        //y se obtinen los cheques relacionados con dicho abono
        if ($compra) {
            $cheque_abono_compra = new ChequeAbonoCompra();
            $cheque_abono_compra->setIdAbonoCompra($id_abono);
            $resultados = ChequeAbonoCompraDAO::search($cheque_abono_compra);
            $from       = 1;
        } else if ($venta) {
            $cheque_abono_venta = new ChequeAbonoVenta();
            $cheque_abono_venta->setIdAbonoVenta($id_abono);
            $resultados = ChequeAbonoVentaDAO::search($cheque_abono_venta);
            $from       = 2;
        } else if ($prestamo) {
            $cheque_abono_prestamo = new ChequeAbonoPrestamo();
            $cheque_abono_prestamo->setIdAbonoPrestamo($id_abono);
            $resultados = ChequeAbonoPrestamoDAO::search($cheque_abono_prestamo);
            $from       = 3;
        } else {
            Logger::error("No se recibio si se eliminaran de una compra, una venta o un prestamo los cheques");
            throw new Exception("No se recibio si los cheques se eliminaran de una compra, una venta o un prestamo");
        }
        $cheque = new Cheque();
        
        //Si no se han encontrado cheques, regresa
        if (is_null($resultados))
            return;
        DAO::transBegin();
        try {
            //Se eliminan todos los registros encontrados para dicho abono
            foreach ($resultados as $resultado) {
                $cheque->setIdCheque($resultado->getIdCheque());
                ChequeDAO::delete($cheque);
                switch ($from) {
                    case 1:
                        ChequeAbonoCompraDAO::delete($resultado);
                        break;
                    case 2:
                        ChequeAbonoVentaDAO::delete($resultado);
                        break;
                    case 3:
                        ChequeAbonoPrestamoDAO::delete($resultado);
                }
            }
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudieron borrar los cheques: " . $e);
            throw new Exception("No se pudieron borrar los cheques");
        }
        DAO::transEnd();
    }
    
    /**
     *
     *Lista los abonos, puede filtrarse por empresa, por sucursal, por caja, por usuario que abona y puede ordenarse segun sus atributos
     *
     * @param id_caja int Id de la caja de la cual se mostraran los abonos
     * @param id_usuario int Id del usuario del cual se mostraran los abonos que ha realizado
     * @param orden json Objeto que indicara el orden en que se mostrara la lista
     * @param id_sucursal int Id de la sucursal de la cual se mostraran los abonos
     * @param id_empresa int Id de la empresa de la cual se mostraran los abonos
     * @return abonos json Objeto que contendra la lista de abonos
     **/
    public static function ListaAbono($compra, $prestamo, $venta, $cancelado = null, $fecha_actual = null, $fecha_maxima = null, $fecha_minima = null, $id_caja = null, $id_compra = null, $id_empresa = null, $id_prestamo = null, $id_sucursal = null, $id_usuario = null, $id_venta = null, $monto_igual_a = null, $monto_mayor_a = null, $monto_menor_a = null, $orden = null)
    {
        Logger::log("Inicia lista de abonos");
        
        //valida la variable orden
        if (!is_null($orden)) {
            if ($orden != "id_abono_compra" && $orden != "id_abono_venta" && $orden != "id_abono_prestamo" && $orden != "id_venta" && $orden != "id_compra" && $orden != "id_prestamo" && $orden != "id_sucursal" && $orden != "monto" && $orden != "id_caja" && $orden != "id_deudor" && $orden != "id_receptor" && $orden != "nota" && $orden != "fecha" && $orden != "tipo_de_pago" && $orden != "cancelado" && $orden != "motivo_cancelacion") {
                Logger::error("La variable orden (" . $orden . ") es invalida");
                throw new Exception("La variable orden (" . $orden . ") es invalida");
            }
        }
        
        //verifica que se haya recibido almenos un tipo de abono a listar
        if (!$compra && !$venta && !$prestamo) {
            Logger::warn("No se recibio si se listaran compras, ventas o prestamos, no se lista nada");
            throw new Exception("No se recibio si se listaran compras, ventas o prestamos, no se lista nada");
        }

        $abonos_compra   = null;
        $abonos_venta    = null;
        $abonos_prestamo = null;
        $parametros      = false;
        //
        //Verificar si se recibieron parametros para filtrar
        //de no ser así, usar el metodo getAll en lugar del
        //metodo getByRange
        //
        if (!is_null($id_caja) || !is_null($id_usuario) || !is_null($id_sucursal) || !is_null($id_empresa) || !is_null($id_compra) || !is_null($id_venta) || !is_null($id_prestamo) || !is_null($cancelado) || !is_null($fecha_minima) || !is_null($fecha_maxima) || !is_null($fecha_actual) || !is_null($monto_menor_a) || !is_null($monto_mayor_a) || !is_null($monto_igual_a)) {
            $parametros = true;
        }

        //
        //Verficiar si se listaran abonos de compra
        //
        if ($compra) {
            if ($parametros) {
                Logger::log("Se encontraron parametros para compra");
                $abono_criterio_compra  = new AbonoCompra();
                $abono_criterio_compra2 = new AbonoCompra();
                //
                //El objeto 1 (abono_criterio_compra) obtiene todos los valores recibidos
                //para que a la hora de comparar, getByRange traiga
                //los campos que cumplan exactamente con esa informacion
                //
                $abono_criterio_compra->setCancelado($cancelado);
                $abono_criterio_compra->setIdCaja($id_caja);
                if (!is_null($fecha_minima)) {
                    //
                    //Si pasaron una fecha minima y existe una fecha maxima, entonces
                    //el objeto 1 almacenara la minima y el objeto 2 la maxima para
                    //que se impriman los abonos entre esas dos fechas.
                    //
                    //Si no hay fecha maxima, el objeto 2 almacenara la fecha de hoy
                    //para que se impriman los abonos desde la fecha minima hasta hoy.
                    //
                    //
                    $abono_criterio_compra->setFecha($fecha_minima);
                    if (!is_null($fecha_maxima))
                        $abono_criterio_compra2->setFecha($fecha_maxima);
                    else
                        $abono_criterio_compra2->setFecha(time());
                } else if (!is_null($fecha_maxima)) {
                    //
                    //Si no se recibio fecha minima pero si fecha maxima
                    //El objeto 1 guarda la fecha maxima y el objeto 2 guarda
                    //la fecha minima posible de MySQL, para asi poder listar
                    //los abonos anteriores a la fecha maxima.
                    //
                    $abono_criterio_compra->setFecha($fecha_maxima);
                    $abono_criterio_compra2->setFecha("1000-01-01 00:00:00");
                } else if ($fecha_actual) {
                    //
                    //Si se recibio el booleano fecha_actual, se listaran los abonos
                    //solo de hoy, se crea un timestamp con el año, el mes y el dia de hoy
                    //pero se inicia con la hora 00:00:00 y se almacena como fecha en el objeto 1.
                    //
                    //Se crea un segundo timestamp con el año, el mes y el dia de hoy pero
                    //con la hora 23:59:59 y se almacena como fecha en el objeto 2.
                    //

                    $abono_criterio_compra->setFecha(time());

                    $manana = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                    $abono_criterio_compra2->setFecha(  $manana );
                }
                
                $abono_criterio_compra->setIdCompra($id_compra);
                $abono_criterio_compra->setIdReceptor($id_usuario);
                $abono_criterio_compra->setIdSucursal($id_sucursal);
                if (!is_null($monto_mayor_a)) {
                    //
                    //Si se recibio el monto_mayor_a y se recibio el monto_menor_a
                    //el objeto 1 guarda el primero y el objeto2 guarda el segundo
                    //para asi listar los abonos cuyo monto sea mayor a mayor_a y
                    //menor a menor_a
                    //
                    //Si no, el objeto 2 almacena el valor mas grande posible
                    //para que se listen los objeto cuyo monto sea mayor a mayor_a
                    //
                    $abono_criterio_compra->setMonto($monto_mayor_a);
                    if (!is_null($monto_menor_a))
                        $abono_criterio_compra2->setMonto($monto_menor_a);
                    else
                        $abono_criterio_compra2->setMonto(1.8e100);
                } else if (!is_null($monto_menor_a)) {
                    //
                    //Si solo se obtuvo monto_menor_a, el objeto 1 lo almacena y el
                    //objeto 2 almacena el monto mas bajo posible para que  se listen
                    //los abonos cuyo monto sea menor a menor_a
                    //
                    $abono_criterio_compra->setMonto($monto_menor_a);
                    $abono_criterio_compra2->setMonto(0);
                } else if (!is_null($monto_igual_a)) {
                    //
                    //Si se recibe monto_igual_a se asignara este monto al
                    //objeto 1 para que se listen solo los abonos con dicho monto
                    //
                    $abono_criterio_compra->setMonto($monto_igual_a);
                    
                }
                //
                //Almacena la consulta en un arreglo de objetos
                //
                $abonos_compra = AbonoCompraDAO::byRange($abono_criterio_compra, $abono_criterio_compra2, $orden);
            } else {
                Logger::log("No se encontraron parametros para compra, se listan todos los abonos a compra");
                $abonos_compra = AbonoCompraDAO::getAll(null, null, $orden);
            }
        }
        //
        //Verficiar si se listaran abonos de venta
        //
        if ($venta) {
            if ($parametros) {
                $abono_criterio_venta  = new AbonoVenta();
                $abono_criterio_venta2 = new AbonoVenta();
                //
                //El objeto 1 (abono_criterio_venta) obtiene todos los valores recibidos
                //para que a la hora de comparar, getByRange traiga
                //los campos que cumplan exactamente con esa informacion
                //
                $abono_criterio_venta->setCancelado($cancelado);
                $abono_criterio_venta->setIdCaja($id_caja);
                if (!is_null($fecha_minima)) {
                    //
                    //Si pasaron una fecha minima y existe una fecha maxima, entonces
                    //el objeto 1 almacenara la minima y el objeto 2 la maxima para
                    //que se impriman los abonos entre esas dos fechas.
                    //
                    //Si no hay fecha maxima, el objeto 2 almacenara la fecha de hoy
                    //para que se impriman los abonos desde la fecha minima hasta hoy.
                    //
                    //
                    $abono_criterio_venta->setFecha($fecha_minima);
                    if (!is_null($fecha_maxima))
                        $abono_criterio_venta2->setFecha($fecha_maxima);
                    else
                        $abono_criterio_venta2->setFecha( time() );
                } else if (!is_null($fecha_maxima)) {
                    //
                    //Si no se recibio fecha minima pero si fecha maxima
                    //El objeto 1 guarda la fecha maxima y el objeto 2 guarda
                    //la fecha minima posible de MySQL, para asi poder listar
                    //los abonos anteriores a la fecha maxima.
                    //
                    $abono_criterio_venta->setFecha($fecha_maxima);
                    $abono_criterio_venta2->setFecha("1000-01-01 00:00:00");
                } else if ($fecha_actual) {
                    //
                    //Si se recibio el booleano fecha_actual, se listaran los abonos
                    //solo de hoy, se crea un timestamp con el año, el mes y el dia de hoy
                    //pero se inicia con la hora 00:00:00 y se almacena como fecha en el objeto 1.
                    //
                    //Se crea un segundo timestamp con el año, el mes y el dia de hoy pero
                    //con la hora 23:59:59 y se almacena como fecha en el objeto 2.
                    //
                    $hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                    $abono_criterio_venta->setFecha(date("Y-m-d H:i:s", $hoy));
                    $manana = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                    $abono_criterio_venta2->setFecha(date("Y-m-d H:i:s", $manana));
                }
                $abono_criterio_venta->setIdVenta($id_venta);
                $abono_criterio_venta->setIdDeudor($id_usuario);
                $abono_criterio_venta->setIdSucursal($id_sucursal);
                if (!is_null($monto_mayor_a)) {
                    //
                    //Si se recibio el monto_mayor_a y se recibio el monto_menor_a
                    //el objeto 1 guarda el primero y el objeto2 guarda el segundo
                    //para asi listar los abonos cuyo monto sea mayor a mayor_a y
                    //menor a menor_a
                    //
                    //Si no, el objeto 2 almacena el valor mas grande posible
                    //para que se listen los objeto cuyo monto sea mayor a mayor_a
                    //
                    $abono_criterio_venta->setMonto($monto_mayor_a);
                    if (!is_null($monto_menor_a))
                        $abono_criterio_venta2->setMonto($monto_menor_a);
                    else
                        $abono_criterio_venta2->setMonto(1.8e100);
                } else if (!is_null($monto_menor_a)) {
                    //
                    //Si solo se obtuvo monto_menor_a, el objeto 1 lo almacena y el
                    //objeto 2 almacena el monto mas bajo posible para que  se listen
                    //los abonos cuyo monto sea menor a menor_a
                    //
                    $abono_criterio_venta->setMonto($monto_menor_a);
                    $abono_criterio_venta2->setMonto(0);
                } else if (!is_null($monto_igual_a)) {
                    //
                    //Si se recibe monto_igual_a se asignara este monto al
                    //objeto 1 para que se listen solo los abonos con dicho monto
                    //
                    $abono_criterio_venta->setMonto($monto_igual_a);
                }
                //
                //Almacena la consulta en un arreglo de objetos
                //
                $abonos_venta = AbonoVentaDAO::byRange($abono_criterio_venta, $abono_criterio_venta2, $orden);
            } else
                $abonos_venta = AbonoVentaDAO::getAll(null, null, $orden);
            
        }
        //
        //Verficiar si se listaran abonos de prestamo
        //
        if ($prestamo) {
            if ($parametros) {
                $abono_criterio_prestamo  = new AbonoPrestamo();
                $abono_criterio_prestamo2 = new AbonoPrestamo();
                //
                //El objeto 1 (abono_criterio_prestamo) obtiene todos los valores recibidos
                //para que a la hora de comparar, getByRange traiga
                //los campos que cumplan exactamente con esa informacion
                //
                $abono_criterio_prestamo->setCancelado($cancelado);
                $abono_criterio_prestamo->setIdCaja($id_caja);
                if (!is_null($fecha_minima)) {
                    //
                    //Si pasaron una fecha minima y existe una fecha maxima, entonces
                    //el objeto 1 almacenara la minima y el objeto 2 la maxima para
                    //que se impriman los abonos entre esas dos fechas.
                    //
                    //Si no hay fecha maxima, el objeto 2 almacenara la fecha de hoy
                    //para que se impriman los abonos desde la fecha minima hasta hoy.
                    //
                    //
                    $abono_criterio_prestamo->setFecha($fecha_minima);
                    if (!is_null($fecha_maxima))
                        $abono_criterio_prestamo2->setFecha($fecha_maxima);
                    else
                        $abono_criterio_prestamo2->setFecha(date("Y-m-d H:i:s", time()));
                } else if (!is_null($fecha_maxima)) {
                    //
                    //Si no se recibio fecha minima pero si fecha maxima
                    //El objeto 1 guarda la fecha maxima y el objeto 2 guarda
                    //la fecha minima posible de MySQL, para asi poder listar
                    //los abonos anteriores a la fecha maxima.
                    //
                    $abono_criterio_prestamo->setFecha($fecha_maxima);
                    $abono_criterio_prestamo2->setFecha("1000-01-01 00:00:00");
                } else if ($fecha_actual) {
                    //
                    //Si se recibio el booleano fecha_actual, se listaran los abonos
                    //solo de hoy, se crea un timestamp con el año, el mes y el dia de hoy
                    //pero se inicia con la hora 00:00:00 y se almacena como fecha en el objeto 1.
                    //
                    //Se crea un segundo timestamp con el año, el mes y el dia de hoy pero
                    //con la hora 23:59:59 y se almacena como fecha en el objeto 2.
                    //
                    $hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                    $abono_criterio_prestamo->setFecha(date("Y-m-d H:i:s", $hoy));
                    $manana = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                    $abono_criterio_prestamo2->setFecha(date("Y-m-d H:i:s", $manana));
                }
                $abono_criterio_prestamo->setIdPrestamo($id_prestamo);
                $abono_criterio_prestamo->setIdDeudor($id_usuario);
                $abono_criterio_prestamo->setIdSucursal($id_sucursal);
                if (!is_null($monto_mayor_a)) {
                    //
                    //Si se recibio el monto_mayor_a y se recibio el monto_menor_a
                    //el objeto 1 guarda el primero y el objeto2 guarda el segundo
                    //para asi listar los abonos cuyo monto sea mayor a mayor_a y
                    //menor a menor_a
                    //
                    //Si no, el objeto 2 almacena el valor mas grande posible
                    //para que se listen los objeto cuyo monto sea mayor a mayor_a
                    //
                    $abono_criterio_prestamo->setMonto($monto_mayor_a);
                    if (!is_null($monto_menor_a))
                        $abono_criterio_prestamo2->setMonto($monto_menor_a);
                    else
                        $abono_criterio_prestamo2->setMonto(1.8e100);
                } else if (!is_null($monto_menor_a)) {
                    //
                    //Si solo se obtuvo monto_menor_a, el objeto 1 lo almacena y el
                    //objeto 2 almacena el monto mas bajo posible para que  se listen
                    //los abonos cuyo monto sea menor a menor_a
                    //
                    $abono_criterio_prestamo->setMonto($monto_menor_a);
                    $abono_criterio_prestamo2->setMonto(0);
                } else if (!is_null($monto_igual_a)) {
                    //
                    //Si se recibe monto_igual_a se asignara este monto al
                    //objeto 1 para que se listen solo los abonos con dicho monto
                    //
                    $abono_criterio_prestamo->setMonto($monto_igual_a);
                }
                //
                //Almacena la consulta en un arreglo de objetos
                //
                $abonos_prestamo = AbonoPrestamoDAO::byRange($abono_criterio_prestamo, $abono_criterio_prestamo2, $orden);
            } else
                $abonos_prestamo = AbonoPrestamoDAO::getAll(null, null, $orden);
        }
        $cont   = 0;
        $abonos = array( );
        //
        //Si la consulta de abonos en compras trae un resultado, agregala al arreglo de abonos
        //y asi con las ventas y los prestamos.
        //

        if (sizeof($abonos_compra) > 0) {
            $abonos["compras"] = $abonos_compra;
            $cont++;
        }
        if (sizeof($abonos_venta) > 0) {
            $abonos["ventas"] = $abonos_venta;
            $cont++;
        }
        if (sizeof($abonos_prestamo) > 0) {
            $abonos["prestamos"] = $abonos_prestamo;
            $cont++;
        }
        Logger::log("Recuperado lista de abonos exitosamente");

        return array("resultados" => $abonos , "numero_de_resultados" => sizeof($abonos));
    }
    
    /**
     *
     *Cancela un gasto
     *
     * @param id_gasto int Id del gasto a eliminar
     * @param motivo_cancelacion string Motivo por el cual se realiza la cancelacion
     **/
    public static function EliminarGasto($id_gasto, $billetes = null, $id_caja = null, $motivo_cancelacion = null)
    {
        Logger::log("Eliminando gasto");
        $gasto = GastoDAO::getByPK($id_gasto);
        
        //verifica que el gasto exista en la base de datos y que no haya sido cancelado
        if (!$gasto) {
            Logger::error("El gasto con id:" . $id_gasto . " no existe");
            throw new Exception("El gasto con id:" . $id_gasto . " no existe");
        }
        if ($gasto->getCancelado()) {
            Logger::log("El gasto ya ha sido cancelado");
            throw new Exception("El gasto ya ha sido cancelado");
        }
        
        //valida el parametro motivo de cancelacion
        $validar = self::validarString($motivo_cancelacion, 255, "motivo de cancelacion");
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        //Actualiza el gasto y modifica la caja si se encuentra alguna
        $gasto->setCancelado(1);
        $gasto->setMotivoCancelacion($motivo_cancelacion);
        if (!$id_caja)
            $id_caja = self::getCaja();
        if (!is_null($id_caja)) {
            try {
                CajasController::modificarCaja($id_caja, 1, $billetes, $gasto->getMonto());
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        DAO::transBegin();
        try {
            GastoDAO::save($gasto);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se ha podido cancelar el gasto: " . $e);
            throw new Exception("No se ha podido cancelar el gasto");
        }
        DAO::transEnd();
        Logger::log("Gasto cancelado exitosamente");
    }
    
    /**
     *
     *Lista los gastos, se puede filtrar de acuerdo a la empresa, la sucursal, el usuario que registra el gasto, el concepto de gasto, la orden de servicio, la caja de la cual se sustrajo el dinero para pagar el gasto, de una fecha inicial a una final, por monto, por cancelacion, y se puede ordenar de acuerdo a ss atributos.
     *
     * @param id_empresa int Id de la empresa de la cual se listaran sus gastos
     * @param id_usuario int Id del usuario del cual se listaran los gastos que ha registrado
     * @param id_concepto_gasto int Se listaran solo los gastos que tengan como concepto este id
     * @param id_orden_servicio int Se listaran los gastos que pertenezcan solamente a esta orden de servicio
     * @param id_caja int Id de caja de la cual se listaran los gastos que ha financiado
     * @param fecha_inicial string Se listaran los gastos cuya fecha de gasto sea mayor a esta fecha
     * @param fecha_final string Se listaran los gastos cuya fecha de gasto sea menor a esta fecha
     * @param id_sucursal int Id de la sucursal de la cual se listaran sus gastos
     * @param cancelado bool Si este valor no es obtenido, se listaran los gastos tanto cancelados como no cancelados. Si es true, se listaran solo los gastos cancelados, si es false, se listaran solo los gastos que no han sido cancelados
     * @param monto_minimo float Se listaran los gastos cuyo monto sea mayor a este valor
     * @param monto_maximo float Se listaran los gastos cuyo monto sea menor a este valor
     **/
    public static function ListaGasto(
    	$cancelado = null,
    	$fecha_actual = null,
    	$fecha_final = null,
    	$fecha_inicial = null,
    	$id_caja = null,
    	$id_concepto_gasto = null,
    	$id_empresa = null,
    	$id_orden_servicio = null,
    	$id_sucursal = null,
    	$id_usuario = null,
    	$monto_maximo = null,
    	$monto_minimo = null,
    	$orden = null) {

        //valida la variable orden
        if (!is_null($orden)) {
            if ( $orden != "id_gasto" && $orden != "id_empresa" && $orden != "id_usuario" && $orden != "id_concepto_gasto" && $orden != "id_orden_de_servicio" && $orden != "id_caja" && $orden != "fecha_del_gasto" && $orden != "fecha_de_registro" && $orden != "id_sucursal" && $orden != "nota" && $orden != "descripcion" && $orden != "folio" && $orden != "monto" && $orden != "cancelado" && $orden != "motivo_cancelacion") {
                Logger::error("La variable orden (" . $orden . ") no es valida");
                throw new Exception("La variable orden (" . $orden . ") no es valida");
            }
        }
        
        //verifica que se hayan recibido parametros
        $parametros = false;
        if (!is_null($id_empresa) || !is_null($id_usuario) || !is_null($id_concepto_gasto) || !is_null($id_orden_servicio) || !is_null($id_caja) || !is_null($fecha_inicial) || !is_null($fecha_final) || !is_null($id_sucursal) || !is_null($cancelado) || !is_null($monto_minimo) || !is_null($monto_maximo) || !is_null($fecha_actual)){
			$parametros = true;
        }

        $gastos = null;
        if ($parametros) {
            Logger::log("Se recibieron parametros, se listan los Gastos dentro del rango");
            //
            //Se almacenan los parametros recibidos en el objeto criterio 1
            //para luego ser comparados.
            //
            $gasto_criterio_1 = new Gasto();
            $gasto_criterio_2 = new Gasto();
            $gasto_criterio_1->setIdEmpresa($id_empresa);
            $gasto_criterio_1->setIdUsuario($id_usuario);
            $gasto_criterio_1->setIdConceptoGasto($id_concepto_gasto);
            $gasto_criterio_1->setIdOrdenDeServicio($id_orden_servicio);
            $gasto_criterio_1->setIdCaja($id_caja);
            $gasto_criterio_1->setIdSucursal($id_sucursal);
            $gasto_criterio_1->setCancelado($cancelado);
            if (!is_null($fecha_inicial)) {
                //
                //Si pasaron una fecha minima y existe una fecha maxima, entonces
                //el objeto 1 almacenara la minima y el objeto 2 la maxima para
                //que se impriman los gastos entre esas dos fechas.
                //
                //Si no hay fecha maxima, el objeto 2 almacenara la fecha de hoy
                //para que se impriman los gastos desde la fecha minima hasta hoy.
                //
                //
                $gasto_criterio_1->setFechaDelGasto($fecha_inicial);
                if (!is_null($fecha_final))
                    $gasto_criterio_2->setFechaDelGasto($fecha_final);
                else
                    $gasto_criterio_2->setFechaDelGasto(date("Y-m-d H:i:s", time()));
            } else if (!is_null($fecha_final)) {
                //
                //Si no se recibio fecha minima pero si fecha maxima
                //El objeto 1 guarda la fecha maxima y el objeto 2 guarda
                //la fecha minima posible de MySQL, para asi poder listar
                //los gastos anteriores a la fecha maxima.
                //
                $gasto_criterio_1->setFechaDelGasto($fecha_final);
                $gasto_criterio_2->setFechaDelGasto("1000-01-01 00:00:00");
            } else if ($fecha_actual) {
                //
                //Si se recibio el booleano fecha_actual, se listaran los abonos
                //solo de hoy, se crea un timestamp con el año, el mes y el dia de hoy
                //pero se inicia con la hora 00:00:00 y se almacena como fecha en el objeto 1.
                //
                //Se crea un segundo timestamp con el año, el mes y el dia de hoy pero
                //con la hora 23:59:59 y se almacena como fecha en el objeto 2.
                //
                $hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                $gasto_criterio_1->setFechaDelGasto(date("Y-m-d H:i:s", $hoy));
                $manana = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                $gasto_criterio_2->setFechaDelGasto(date("Y-m-d H:i:s", $manana));
            }
            if (!is_null($monto_minimo)) {
                //
                //Si se recibio el monto_minimo y se recibio el monto_maximo
                //el objeto 1 guarda el primero y el objeto2 guarda el segundo
                //para asi listar los gastos cuyo monto sea mayor al minimo y
                //menor que el maximo
                //
                //Si no, el objeto 2 almacena el valor mas grande posible
                //para que se listen los gastos cuyo monto sea mayor al minimo
                //
                $gasto_criterio_1->setMonto($monto_minimo);
                if (!is_null($monto_maximo))
                    $gasto_criterio_2->setMonto($monto_maximo);
                else
                    $gasto_criterio_2->setMonto(1.8e100);
            } else if (!is_null($monto_maximo)) {
                //
                //Si solo se obtuvo monto_maximo, el objeto 1 lo almacena y el
                //objeto 2 almacena el monto mas bajo posible para que  se listen
                //los gastos cuyo monto sea menor al maximo
                //
                $gasto_criterio_1->setMonto($monto_maximo);
                $gasto_criterio_2->setMonto(0);
            }
            $gastos = GastoDAO::byRange($gasto_criterio_1, $gasto_criterio_2, $orden);
        } else {
            Logger::log("No se recibieron parametros, se listan todos los Gastos");
            $tipo_de_orden = "desc";
            if( is_null( $orden ) ) {
            	$orden = "fecha_de_registro";
			}
            $gastos = GastoDAO::getAll( null, null, $orden, $tipo_de_orden );
        }
        Logger::log("Se obtuvo la lista de gastos exitosamente");

        return array("resultados" => $gastos, "numero_de_resultados" => sizeof($gastos) );
    }
    
    /**
     *
     *Cancela un ingreso
     *
     * @param id_ingreso int Id del ingreso a cancelar
     * @param motivo_cancelacion string Motivo por el cual se realiza la cancelacion
     **/
    public static function EliminarIngreso($id_ingreso, $billetes = null, $id_caja = null, $motivo_cancelacion = null)
    {
        Logger::log("Cancelando Ingreso");
        
        //valida que el ingreso exista en la base de datos y que no haya sido cancelado anteriormente
        $ingreso = IngresoDAO::getByPK($id_ingreso);
        if (!$ingreso) {
            Logger::error("El ingreso con id: " . $id_ingreso . " no existe");
            throw new Exception("El ingreso con id: " . $id_ingreso . " no existe");
        }
        if ($ingreso->getCancelado()) {
            Logger::warn("El ingreso ya ha sido cancelado");
            throw new Exception("El ingreso ya ha sido cancelado");
        }
        
        //valida el parametro motivo de cancelacion
        $validar = self::validarString($motivo_cancelacion, 255, "motivo de cancelacion");
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        $ingreso->setCancelado(1);
        $ingreso->setMotivoCancelacion($motivo_cancelacion);
        
        //si se obtiene una caja se modifica su saldo
        if (!$id_caja)
            $id_caja = self::getCaja();
        if (!is_null($id_caja)) {
            try {
                CajasController::modificarCaja($id_caja, 0, $billetes, $ingreso->getMonto());
            }
            catch (Exception $e) {
                throw $e;
            }
        }
        DAO::transBegin();
        try {
            IngresoDAO::save($ingreso);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo Eliminar el ingreso: " . $e);
            throw new Exception("No se pudo eliminar el ingreso");
        }
        DAO::transEnd();
        Logger::log("Ingreso cancelado exitosamente");
    }
    
    /**
     *
     *Registra un nuevo concepto de gasto
     *Update : En la respuesta basta con solo indicar success : true | false, y en caso de fallo indicar el por que.
     *
     * @param id_cuenta_contable int El id de la cuenta contable a la que se registraran los gastos de este concepto
     * @param nombre string la justificacion que aparecera despues de la leyenda "gasto por concepto de"
     * @param descripcion string Descripcion larga del concepto de gasto
     * @return id_concepto_gasto int Id autogenerado por la insercin del nuevo gasto
     **/
    public static function NuevoConceptoGasto($id_cuenta_contable, $nombre, $descripcion = null)
    {
        Logger::log("Creando concepto de gasto");
        
        //valida los parametros de gasto
        $validar = self::validarParametrosConceptoGasto(null, $nombre, $descripcion, $id_cuenta_contable);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        //se inicializa el registro de concepto gasto
        $concepto_gasto = new ConceptoGasto();
        $concepto_gasto->setNombre(trim($nombre));
        $concepto_gasto->setDescripcion($descripcion);
        $concepto_gasto->setIdCuentaContable($id_cuenta_contable);
        $concepto_gasto->setActivo(1);
        DAO::transBegin();
        try {
            ConceptoGastoDAO::save($concepto_gasto);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo crear el concepto de gasto: " . $e);
            throw new Exception("No se pudo crear el concepto de gasto");
        }
        DAO::transEnd();
        Logger::log("Gasto creado exitosamente");

        $cuenta_padre = CuentaContableDAO::getByPK($id_cuenta_contable);

        ContabilidadController::NuevaCuenta($cuenta_padre->getAbonosAumentan(), $cuenta_padre->getCargosAumentan(),
                                            $cuenta_padre->getClasificacion(), $cuenta_padre->getEsCuentaMayor(),
                                            $cuenta_padre->getEsCuentaOrden(), $cuenta_padre->getIdCatalogoCuentas(),
                                            $cuenta_padre->getNaturaleza(), $nombre,
                                            $cuenta_padre->getTipoCuenta(), $id_cuenta_contable
                                            );

        return array(
            "id_concepto_gasto" => $concepto_gasto->getIdConceptoGasto()
        );
    }
    
    /**
     *
     *Edita la informaci?n de un concepto de gasto
     * Update : Se deber?a de tomar de la sesi?n el id del usuario que hiso la ultima modificaci?n y la fecha.
     *
     * @param id_concepto_gasto int Id del concepto de gasto a modificar
     * @param id_cuenta_contable int El id de la cuenta contable a la que se va a mover
     * @param descripcion string Descripcion larga del concepto de gasto
     * @param nombre string Justificacion del concepto de gasto que aparecera despues de la leyenda "gasto por concepto de"
     **/
    public static function EditarConceptoGasto($id_concepto_gasto, $id_cuenta_contable, $descripcion = null, $nombre = null)
    {
        Logger::log("Editando concepto de gasto");
        
        //valida que se hayan recibido parametros para editar
        if (!$nombre && !$id_cuenta_contable && !$descripcion) {
            Logger::warn("No se recibieron parametros para editar, no se edita nada");
            throw new Exception("No se recibieron parametros para editar, no se edita nada");
        }
        
        //valida los parametros
        $validar = self::validarParametrosConceptoGasto($id_concepto_gasto, $nombre, $descripcion, $id_cuenta_contable);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        $concepto_gasto = ConceptoGastoDAO::getByPK($id_concepto_gasto);
        $cuenta = CuentaContableDAO::getByPK($id_cuenta_contable);

        //Los parametros que no sean nulos seran tomados como actualizacion
        if (!is_null($nombre)){
            $concepto_gasto->setNombre($nombre);
            $cuenta->setNombreCuenta($nombre);
        }
        if (!is_null($id_cuenta_contable))
            $concepto_gasto->setIdCuentaContable($id_cuenta_contable);
        if (!is_null($descripcion))
            $concepto_gasto->setDescripcion($descripcion);
        DAO::transBegin();
        try {
            ConceptoGastoDAO::save($concepto_gasto);
            CuentaContableDAO::save($cuenta);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo editar el concepto de gasto: " . $e);
            throw new Exception("No se pudo editar el concepto de gasto");
        }
        DAO::transEnd();
        Logger::log("Se edito el concepto de gasto con exito");
        
    }
    
    /**
     *
     *Deshabilita un concepto de gasto
     *<br/><br/><b>Update :</b>Se deber?de tomar tambi?de la sesi?l id del usuario y fecha de la ultima modificaci?
     *
     * @param id_concepto_gasto int Id del concepto que ser eliminado
     **/
    public static function EliminarConceptoGasto($id_concepto_gasto)
    {
        Logger::log("Eliminando concepto de gasto " . $id_concepto_gasto);
        $concepto_gasto = ConceptoGastoDAO::getByPK($id_concepto_gasto);
        
        //valida que el concepto gasto exista en la base de datos y que este activo
        if (!$concepto_gasto) {
            Logger::error("El concepto gasto con id: " . $id_concepto_gasto . " no existe");
            throw new Exception("El concepto gasto con id: " . $id_concepto_gasto . " no existe");
        }
        if (!$concepto_gasto->getActivo()) {
            Logger::warn("El concepto de gasto ya ha sido desactivado");
            throw new Exception("El concepto de gasto ya ha sido desactivado");
        }
        $concepto_gasto->setActivo(0);
        DAO::transBegin();
        try {
            ConceptoGastoDAO::save($concepto_gasto);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo eliminar el concepto de gasto: " . $e);
            throw new Exception("No se pudo eliminar el concepto de gasto");
        }
        DAO::transEnd();
        Logger::log("Concepto de gasto eliminado con exito");
    }
    
    /**
     *
     *Crea un nuevo concepto de ingreso
     *Update : En la respuesta basta con solo indicar success : true | false, y en caso de fallo indicar el por que.
     *
     * @param id_cuenta_contable int El id de la cuenta contable a donde se registraran los ingresos  correspondientes a este concepto
     * @param nombre string Justificacion que aparecer despus de la leyenda "ingreso por concepto de"
     * @param descripcion string Descripcion larga de este concepto de ingreso
     * @return id_concepto_ingreso int Id autogenerado por la creacion del nuevo concepto de ingreso
     **/
    public static function NuevoConceptoIngreso($id_cuenta_contable, $nombre, $descripcion = null)
    {
        Logger::log("Creando nuevo concepto de ingreso");
        
        //valida los parametros de concepto ingreso
        $validar = self::validarParametrosConceptoIngreso(null, $nombre, $descripcion, $id_cuenta_contable);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        //Inicializa el registro de ingreso
        $concepto_ingreso = new ConceptoIngreso();
        $concepto_ingreso->setNombre(trim($nombre));
        $concepto_ingreso->setIdCuentaContable($id_cuenta_contable);
        $concepto_ingreso->setDescripcion($descripcion);
        $concepto_ingreso->setActivo(1);

        DAO::transBegin();
        try {
            ConceptoIngresoDAO::save($concepto_ingreso);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo crear el nuevo concepto de ingreso: " . $e);
            throw new Exception("No se pudo crear el nuevo concepto de ingreso");
        }
        DAO::transEnd();
        Logger::log("Concepto de ingreso creado exitosamente");

        $cuenta_padre = CuentaContableDAO::getByPK($id_cuenta_contable);

        ContabilidadController::NuevaCuenta($cuenta_padre->getAbonosAumentan(), $cuenta_padre->getCargosAumentan(),
                                            $cuenta_padre->getClasificacion(), $cuenta_padre->getEsCuentaMayor(),
                                            $cuenta_padre->getEsCuentaOrden(), $cuenta_padre->getIdCatalogoCuentas(),
                                            $cuenta_padre->getNaturaleza(), $nombre,
                                            $cuenta_padre->getTipoCuenta(), $id_cuenta_contable
                                            );

        return array(
            "id_concepto_ingreso" => $concepto_ingreso->getIdConceptoIngreso()
        );
    }
    
    /**
     *
     *Edita un concepto de ingreso
     *
     * @param id_concepto_ingreso int Id del concepto de ingreso a modificar
     * @param id_cuenta_contable int El id de la cuenta contable
     * @param descripcion string Descripcion larga del concepto de ingreso
     * @param nombre string Justificacion que aparecera despues de la leyenda "ingreso por concepto de"
     **/
    public static function EditarConceptoIngreso($id_concepto_ingreso, $id_cuenta_contable, $descripcion = null, $nombre = null)
    {
        Logger::log("Editando concepto de ingreso");
        
        //valida si ha recibido algun parametro para la edicion
        if (!$nombre && !$descripcion && !$id_cuenta_contable) {
            Logger::warn("No se ha recibido un parametro a editar, no hay nada que editar");
            throw new Exception("No se ha recibido un parametro a editar, no hay nada que editar");
        }
        
        //valida los parametros recibidos
        $validar = self::validarParametrosConceptoIngreso($id_concepto_ingreso, $nombre, $descripcion, $id_cuenta_contable);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        $concepto_ingreso = ConceptoIngresoDAO::getByPK($id_concepto_ingreso);
        $cuenta = CuentaContableDAO::getByPK($id_cuenta_contable);

        //se toman como actualizacion aquellos parametros que no son null
        if (!is_null($nombre)){
            $concepto_gasto->setNombre($nombre);
            $cuenta->setNombreCuenta($nombre);
        }
        if (!is_null($descripcion))
            $concepto_ingreso->setDescripcion($descripcion);
        if (!is_null($monto))
            $concepto_ingreso->setIdCuentaContable($id_cuenta_contable);
        DAO::transBegin();
        try {
            ConceptoIngresoDAO::save($concepto_ingreso);
            CuentaContableDAO::save($cuenta);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo editar el concepto de ingreso: " . $e);
            throw new Exception("No se pudo editar el concepto de ingreso");
        }
        DAO::transEnd();
        Logger::log("Concepto de Ingreso editado exitosamente");
    }
    
    /**
     *
     *Deshabilita un concepto de ingreso
     *<br/><br/><b>Update :</b>Se deber?tambi?obtener de la sesi?l id del usuario y fecha de la ultima modificaci?
     *
     * @param id_concepto_ingreso int Id del ingreso a eliminar
     **/
    public static function EliminarConceptoIngreso($id_concepto_ingreso)
    {
        Logger::log("Eliminando concepto de ingreso");
        
        //valida que el concepto ingreso exista y este activo
        $validar = self::validarParametrosConceptoIngreso($id_concepto_ingreso);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        $concepto_ingreso = ConceptoIngresoDAO::getByPK($id_concepto_ingreso);
        
        $concepto_ingreso->setActivo(0);
        DAO::transBegin();
        try {
            ConceptoIngresoDAO::save($concepto_ingreso);
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo desactivar el concepto de ingreso: " . $e);
            throw new Exception("No se pudo desactivar el concepto de ingreso");
        }
        DAO::transEnd();
        Logger::log("Concepto de ingreso desactivado exitosamente");
    }
    
    /**
     *
     *Lista los conceptos de gasto. Se puede ordenar por los atributos de concepto de gasto
     <br/><br/><b>Update : </b>Falta especificar los parametros y el ejemplo de envio.
     *
     * @param ordenar json Valor que contendr la manera en que se ordenar la lista.
     * @return conceptos_gasto json Arreglo que contendr� la informaci�n de conceptos de gasto.
     **/
    public static function ListaConceptoGasto($activo = null, $orden = null) {
        $conceptos_gasto         = null;
        $concepto_gasto_criterio = new ConceptoGasto();
        
        //valida los parametros
        $validar = self::validarParametrosConceptoGasto(null, null, null, null, $activo);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        if (!is_null($orden)) {
            if ($orden != "id_concepto_gasto" && $orden != "nombre" && $orden != "descripcion" && $orden != "monto" && $orden != "activo") {
                Logger::error("La variable orden (" . $orden . ") no es valida");
                throw new Exception("La variable orden (" . $orden . ") no es valida");
            }
        }
        if (!is_null($activo)) {
            $concepto_gasto_criterio->setActivo($activo);
            $conceptos_gasto = ConceptoGastoDAO::search($concepto_gasto_criterio, $orden);
        } else {
            $conceptos_gasto = ConceptoGastoDAO::getAll(null, null, $orden);
        }
        Logger::log("Lista exitosa");
        return $conceptos_gasto;
    }
    
    /**
     *
     *Lista los conceptos de ingreso, se puede ordenar por los atributos del concepto de ingreso.
     
     <br/><br/><b>Update :</b>Falta especificar la estructura del JSON que se env?como parametro
     *
     * @param ordenar json Valor que indicar la forma en que se ordenar la lista
     * @return conceptos_ingreso json Arreglo que contendr� la informaci�n de los conceptos de ingreso
     **/
    public static function ListaConceptoIngreso($activo = null, $orden = null)
    {
        Logger::log("Listando conceptos de ingreso");
        
        //valida los parametros
        $validar = self::validarParametrosConceptoIngreso(null, null, null, null, $activo);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        if (!is_null($orden)) {
            if ($orden != "id_concepto_ingreso" && $orden != "nombre" && $orden != "descripcion" && $orden != "monto" && $orden != "activo") {
                Logger::error("La variable orden (" . $orden . ") no es valida");
                throw new Exception("La variable orden (" . $orden . ") no es valida");
            }
        }
        
        $conceptos_ingreso         = null;
        $concepto_ingreso_criterio = new ConceptoIngreso();
        if (!is_null($activo)) {
            $concepto_ingreso_criterio->setActivo($activo);
            $conceptos_ingreso = ConceptoIngresoDAO::search($concepto_ingreso_criterio, $orden);
        } else {
            $conceptos_ingreso = ConceptoIngresoDAO::getAll(null, null, $orden);
        }
        Logger::log("Lista exitosa");
        return $conceptos_ingreso;
    }
    
    /**
     *
     * Registrar un gasto. El usuario y la sucursal que lo registran ser?tomados de la sesi?ctual.
     * 
     * <br/><br/><b>Update :</b>Ademas deber?tambi?de tomar la fecha de ingreso del gasto del servidor y agregar tambi?como par?tro una fecha a la cual se deber?de aplicar el gasto. Por ejemplo si el d?09/09/11 (viernes) se tomo dinero para pagar la luz, pero resulta que ese d?se olvidaron de registrar el gasto y lo registran el 12/09/11 (lunes). Entonces tambien se deberia de tomar como parametro una <b>fecha</b> a la cual aplicar el gasto, tambien se deberia de enviar como parametro una <b>nota</b>
     *
     * @param fecha_gasto string Fecha del gasto
     * @param id_empresa int Id de la empresa a la que pertenece este gasto
     * @param billetes json Los billetes que se retiran de la caja por pagar este gasto
     * @param descripcion string Descripcion del gasto en caso de que no este contemplado en la lista de concpetos de gasto
     * @param folio string Folio de la factura del gasto
     * @param id_caja int Id de la caja de la que se sustrae el dinero para pagar el gasto
     * @param id_concepto_gasto int Id del concepto al que  hace referencia el gasto
     * @param id_orden_de_servicio int Id de la orden del servicio que genero este gasto
     * @param id_sucursal int Id de la sucursal a la que pertenece este gasto
     * @param monto float Monto del gasto en caso de que no este contemplado por el concepto de gasto o sea diferente a este
     * @param nota string Nota del gasto
     * @return id_gasto int Id generado por la insercin del nuevo gasto
     **/
    public static function NuevoGasto(
                $fecha_gasto,
                $id_empresa,
                $billetes = null,
                $descripcion = null,
                $folio = null,
                $id_caja = null,
                $id_concepto_gasto = null,
                $id_orden_de_servicio = null,
                $id_sucursal = null,
                $monto = null,
                $nota = null
            )
    {

        //obtiene al usuario de la sesion actual
        $id_usuario = SesionController::Actual( );
        $id_usuario = $id_usuario["id_usuario"];
        
        if ( is_null( $id_usuario ) )
        {
            throw new Exception("No se pudo obtener el usuario de la sesion, ya inicio sesion?");
        }
        
        //Se validan los parametros
        $validar = self::validarParametrosGasto(null, $id_empresa, $id_concepto_gasto, $id_orden_de_servicio, $fecha_gasto, $id_sucursal, $id_caja, $nota, $descripcion, $folio, $monto);
        
        //Si no se recibio monto, se toma del concepto de gasto.
        //Si no se recibio concepto de gasto o este no cuenta con un monto se manda una excepcion
        if ( is_null( $monto ) )
        {
            if ( is_null( $id_concepto_gasto ) )
            {
                throw new Exception("No se recibio un concepto de gasto ni un monto");
            }

            $concepto_gasto = ConceptoGastoDAO::getByPK( $id_concepto_gasto );

            if ( is_null( $concepto_gasto ) )
            {
                throw new Exception("El concepto de gasto recibido no existe.");
            }

            $monto = $concepto_gasto->getMonto( );

            if ( is_null( $monto ) )
            {
                throw new Exception("El concepto de gasto recibido no cuenta con un monto ni se recibio un monto");
            }
        }
        
        //Si no se recibe sucursal ni caja se intenta tomar las actuales
        if ( !$id_sucursal )
        {
            $id_sucursal = self::getSucursal( );
        }

        if ( !$id_caja )
        {
            $id_caja = self::getCaja( );
        }
            
        if ( !is_null( $id_caja ) )
        {
            try
            {
                CajasController::modificarCaja( $id_caja, 0, $billetes, $monto );
            }
            catch (Exception $e)
            {
                throw $e;
            }
        }
        
        //Se inicializa el registro de gasto
        $gasto = new Gasto( );

        // fecha_gasto might be in the format : 2012-10-21T00:00:00
        // if this is the case then act acordingly
        if( is_int($fecha_gasto) )
        {
            $gasto->setFechaDelGasto( $fecha_gasto );
        }
        else
        {
            $gasto->setFechaDelGasto( strtotime( $fecha_gasto ) );
        }
        
        $gasto->setIdEmpresa( $id_empresa );
        $gasto->setMonto( $monto );
        $gasto->setIdSucursal( $id_sucursal );
        $gasto->setIdCaja( $id_caja );
        $gasto->setIdOrdenDeServicio( $id_orden_de_servicio );
        $gasto->setIdConceptoGasto( $id_concepto_gasto );
        $gasto->setDescripcion( $descripcion );
        $gasto->setFolio( $folio );
        $gasto->setNota( $nota );
        $gasto->setFechaDeRegistro( time( ) );
        $gasto->setIdUsuario( $id_usuario );
        $gasto->setCancelado( 0 );
        
        //Se incrementa el costo de la orden de servicio si este gasto se le asigna a alguna
        $orden_de_servicio = null;
        if ( !is_null( $id_orden_de_servicio ) )
        {
            $orden_de_servicio = OrdenDeServicioDAO::getByPK( $id_orden_de_servicio );
            $orden_de_servicio->setPrecio( $monto + $orden_de_servicio->getPrecio( ) );
        }
        
        DAO::transBegin( );
        try 
        {
            GastoDAO::save( $gasto );

            if ( !is_null( $orden_de_servicio ) )
            {
                OrdenDeServicioDAO::save($orden_de_servicio);
            }
        }
        catch( Exception $e )
        {
            DAO::transRollback();
            Logger::error("No se pudo crear el gasto: " . $e);
            throw new Exception("No se pudo crear el gasto");
        }

        DAO::transEnd();
        Logger::log("Gasto creado exitosamente");

        return array( "id_gasto" => $gasto->getIdGasto( ) );
    }


    /**
     *
     *Editar los detalles de un gasto.
     <br/><br/><b>Update : </b> Tambien se deberia de tomar  de la sesion el id del usuario qeu hiso al ultima modificacion y una fecha de ultima modificacion.
     *
     * @param id_gasto int Id que hace referencia a este gasto
     * @param fecha_gasto string Fecha que el usuario selecciona en el sistema, a la cual le quiere asignar el gasto.
     * @param monto float Monto a gastar
     * @param id_concepto_gasto int Id del concepto del gasto
     * @param descripcion string Descripcion del gasto en caso de que no este en la lista de conceptos.
     * @param nota string Informacion adicinal sobre el gasto
     * @param folio string Folio de la factura de ese gasto
     **/
    public static function EditarGasto($id_gasto, $descripcion = null, $fecha_gasto = null, $folio = null, $id_concepto_gasto = null, $nota = null)
    {
        Logger::log("Editando gasto");
        
        //valida si se recibieron parametros a editar o no
        if (!$fecha_gasto && !$id_concepto_gasto && !$descripcion && !$nota && !$folio) {
            Logger::warn("No se recibieron parametros para editar, no hay nada que editar");
            throw new Exception("No se recibieron parametros para editar, no hay nada que editar");
        }
        
        //valida los parametros obtenidos
        $validar = self::validarParametrosGasto($id_concepto_gasto, null, null, null, $fecha_gasto, null, null, $nota, $descripcion, $folio);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        $gasto = GastoDAO::getByPK($id_gasto);
        
        //Los parametros que no sean null seran tomados como actualizacion
        if (!is_null($fecha_gasto))
            $gasto->setFechaDelGasto($fecha_gasto);
        if (!is_null($id_concepto_gasto))
            $gasto->setIdConceptoGasto($id_concepto_gasto);
        if (!is_null($descripcion))
            $gasto->setDescripcion($descripcion);
        if (!is_null($nota))
            $gasto->setNota($nota);
        if (!is_null($folio))
            $gasto->setFolio($folio);
        DAO::transBegin();
        try {
            GastoDAO::save($gasto);
        }
        catch (Exception $e) {
            DAO::transRollBack();
            Logger::error("No se pudo editar el gasto: " . $e);
            throw new Exception("No se pudo editar el gasto");
        }
        DAO::transEnd();
        Logger::log("Gasto editado exitosamente");
    }
    
    /**
     *
     *Edita un ingreso
     
     <br/><br/><b>Update :</b>El usuario y la fecha de la ultima modificaci?e deber? de obtener de la sesi?
     *
     * @param fecha_ingreso string Fecha que el usuario selecciona en el sistema, a la cual le quiere asignar el ingreso.
     * @param id_ingreso int Id del ingreso que se editar
     * @param descrpicion string Descripciond el ingreso en caso de que no se encentre en la lista de conceptos.
     * @param folio string Folio de la factura generada por el ingreso
     * @param nota string Informacion adicional del ingreso
     * @param id_concepto_ingreso int Id del concepto del ingreso
     * @param monto float Monto a registrar como ingreso
     **/
    public static function EditarIngreso($id_ingreso, $descripcion = null, $fecha_ingreso = null, $folio = null, $id_concepto_ingreso = null, $nota = null)
    {
        Logger::log("Editando ingreso");
        
        //valida que se hayan recibido parametros para la edicion
        if (!$fecha_ingreso && !$id_concepto_ingreso && !$descripcion && !$nota && !$folio) {
            Logger::warn("No se recibieron parametros para editar, no hay nada que editar");
            throw new Exception("No se recibieron parametros para editar, no hay nada que editar");
        }
        
        //Valida los parametros recibidos
        $validar = self::validarParametrosIngreso($id_ingreso, null, null, $fecha_ingreso, null, null, $nota, $descripcion, $folio);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        $ingreso = IngresoDAO::getByPK($id_ingreso);
        
        //Los parametros que no sean nulos seran tomados como actualizacion
        if (!is_null($fecha_ingreso))
            $ingreso->setFechaDelIngreso($fecha_ingreso);
        if (!is_null($id_concepto_ingreso))
            $ingreso->setIdConceptoIngreso($id_concepto_ingreso);
        if (!is_null($descripcion))
            $ingreso->setDescripcion($descripcion);
        if (!is_null($nota))
            $ingreso->setNota($nota);
        if (!is_null($folio))
            $ingreso->setFolio($folio);
        DAO::transBegin();
        try {
            IngresoDAO::save($ingreso);
        }
        catch (Exception $e) {
            DAO::transRollBack();
            Logger::error("No se pudo editar el ingreso: " . $e);
            throw new Exception("No se pudo editar el ingreso");
        }
        DAO::transEnd();
        Logger::log("Ingreso editado exitosamente");
        
    }
    
    /**
     *
     *Se crea un  nuevo abono, la caja o sucursal y el usuario que reciben el abono se tomaran de la sesion. La fecha se tomara del servidor
     *
     * @param id_deudor int Id del usuario o la sucursal que realiza el abono, las sucursales seran negativas
     * @param tipo_pago json JSON con la informacion que describe el tipo de pago, si es con cheque, en efectivo o con tarjeta
     * @param monto float monto abonado de la sucursal
     * @param nota string Nota del abono
     * @param id_venta int Id de la venta a la que se le abona
     * @param varios bool True si el monto sera repartido en los prestamos,ventas o compras mas antiguas. Esto se define si se pasa el valor id_venta,id_prestamo o id_compra
     * @param cheques json Se toma el nombre del banco, el monto y los ultimos cuatro numeros del o los cheques usados para este abono
     * @param id_prestamo int Id del prestamo al que se le esta abonando
     * @param id_compra int Id de la compra a la que se abona
     * @return id_abono int El id autogenerado del abono de la sucursal
     **/
    public static function NuevoAbono( $id_deudor, $monto, $tipo_pago, $billetes = null, $cheques = null, $id_compra = null, $id_prestamo = null, $id_venta = null, $nota = null)
    {
        Logger::log("Insertando nuevo abono ... ");

        //Se obtiene la sesion del usuario
        $id_usuario = SesionController::getCurrentUser();
        $id_usuario = $id_usuario->getIdUsuario();
        
        if (is_null($id_usuario)) {
            Logger::error("No se pudo obtener el usuario de la sesion, ya inicio sesion?");
            throw new AccessDeniedException("No se pudo obtener el usuario de la sesion, ya inicio sesion?");
        }
        
        //Se validan los parametros obtenidos
        $validar = self::validarParametrosAbono($monto, $id_deudor, $nota, $tipo_pago);

        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        
        //Si el tipo de pago es con cheque y no se reciben cheques, lanzas una excepcion
        if (($tipo_pago === "cheque") && is_null($cheques)) {
            Logger::error("Se intenta pagar con cheque mas no se envio info de cheques");
            throw new Exception("No se recibio informacion del cheque");
        }
        
        //Se inicializan las variables de los parametros de las tablas de abonos
        $usuario     = UsuarioDAO::getByPK($id_deudor);
        $id_sucursal = self::getSucursal();
        $id_caja     = self::getCaja();
        $fecha       = time();
        $cancelado   = 0;
        $abono       = null; //Nuevo regitro del abono
        $from        = 0; //Bandera que indica a que operacion pertenece el abono
        $operacion   = null; //Objeto de la operacion, puede ser un objeto de venta, de ocmpra o de prestamo
        
        /*
         * Se valida de que operacion pertenece el abono y de acuerdo a lo obtenido, se realizan 
         * las operaciones necesarias en cada tabla.
         * 
         * Primero se valida que la operacion exista, que sea a credito, que no haya sido cancelada, 
         * que no haya sido saldada y que no se abone mas del total de la operacion.
         * 
         * Despues se inicializa el registro de la tabla correspondiente, se modifica el saldo del deudor
         * y se activa la bandera from
         */
        if (!is_null($id_compra)) {
			/*************************************************************
			 * 	abono a compra
			 ************************************************************* */	
			Logger::log("Abono pertenece a compra, compraid=" . $id_compra);
            $operacion = CompraDAO::getByPK($id_compra);
            
            if (is_null($operacion)) {
                Logger::error("La compra con id: " . $id_compra . " no existe");
                throw new Exception("La compra con id: " . $id_compra . " no existe");
            }
            if ($operacion->getTipoDeCompra() !== "credito") {
                Logger::error("La compra especificada no es a credito, no se puede abonar a una compra de contado");
                throw new Exception("La compra especificada no es a credito, no se puede abonar a una compra de contado");
            }
            if ($operacion->getCancelada()) {
                Logger::error("La compra ya ha sido cancelada, no se puede abonar a esta compra");
                throw new Exception("La compra ya ha sido cancelada, no se puede abonar a esta compra");
            }
            if ($operacion->getSaldo() > 0) {
                Logger::error("La compra ya ha sido saldada, no se puede abonar a esta compra");
                throw new Exception("La compra ya ha sido saldada, no se puede abonar a esta compra");
            }
            if (($operacion->getSaldo() - $monto) < 0) {
                Logger::error("No se puede abonar esta cantidad a esta compra, pues sobrepasa el total de la misma");
                throw new Exception("No se puede abonar esta cantidad a esta compra, pues sobrepasa el total de la misma");
            }
            
			Logger::log("Insertando abono compra...");
            $abono = new AbonoCompra();
            $abono->setIdCompra($id_compra);
            $abono->setIdReceptor($id_deudor);
            $abono->setIdDeudor($id_usuario);
            $usuario->setSaldoDelEjercicio($usuario->getSaldoDelEjercicio() - $monto);
            $from = 1;

        } else if (!is_null($id_prestamo)) {
			/*************************************************************
			 * abono a prestamo
			 ************************************************************* */
            $operacion = PrestamoDAO::getByPK($id_prestamo);
            if (is_null($operacion)) {
                Logger::error("El prestamo con id: " . $id_prestamo . " no existe");
                throw new Exception("El prestamo con id: " . $id_prestamo . " no existe");
            }
            if ($operacion->getMonto() <= $operacion->getSaldo()) {
                Logger::error("El prestamo ya ha sido saldado, no se puede abonar a este prestamo");
                throw new Exception("El prestamo ya ha sido saldad0, no se puede abonar a este prestamo");
            }
            if ($operacion->getMonto() < ($operacion->getSaldo() + $monto)) {
                Logger::error("No se puede abonar esta cantidad a este prestamo, pues sobrepasa el total del mismo");
                throw new Exception("No se puede abonar esta cantidad a este prestamo, pues sobrepasa el total del mismo");
            }
            $abono = new AbonoPrestamo();
            $abono->setIdPrestamo($id_prestamo);
            $abono->setIdReceptor($id_usuario);
            $abono->setIdDeudor($id_deudor);
            $usuario->setSaldoDelEjercicio($usuario->getSaldoDelEjercicio() + $monto);
            $from = 2;
        } else if (!is_null($id_venta)) {
			/*************************************************************
			 * abono a venta
			 ************************************************************* */	
            $operacion = VentaDAO::getByPK($id_venta);

            if (is_null($operacion)) {
                Logger::error("La venta con id: " . $id_venta . " no existe");
                throw new Exception("La venta con id: " . $id_venta . " no existe");
            }
            if ($operacion->getTipoDeVenta() !== "credito") {
                Logger::error("La ventaa especificada no es a credito, no se puede abonar a una venta de contado");
                throw new Exception("La venta especificada no es a credito, no se puede abonar a una venta de contado");
            }
            if ($operacion->getCancelada()) {
                Logger::error("La venta ya ha sido cancelada, no se puede abonar a esta venta");
                throw new Exception("La venta ya ha sido cancelada, no se puede abonar a esta venta");
            }
            if ($operacion->getSaldo() <= 0) {
                Logger::error("La venta ya ha sido saldada, no se puede abonar a esta venta");
                Logger::log("La venta $id_venta tiene un total de " . $operacion->getTotal() . " y un saldo pendiente de " . $operacion->getSaldo() . " por lo tanto ya ha sido saldada.");
                throw new Exception("La venta ya ha sido saldada, no se puede abonar a esta venta");
                
            }
            if (($operacion->getSaldo() - $monto) < 0) {
                Logger::error("No se puede abonar esta cantidad a esta venta, pues sobrepasa el total de la misma");
                throw new Exception("No se puede abonar esta cantidad a esta venta, pues sobrepasa el total de la misma");
            }
            
            Logger::log("Insertando AbonoVenta...");
            $abono = new AbonoVenta();
            $abono->setIdVenta($id_venta);
            $abono->setIdReceptor($id_usuario);
            $abono->setIdDeudor($id_deudor);
            //(OLD) $usuario->setSaldoDelEjercicio($usuario->getSaldoDelEjercicio() + $monto); 
			//Figu: se establece el saldo del cliente restandole la venta y a su vez si tiene adelanto se le incrementa su saldo
			//$usuario->setSaldoDelEjercicio(  ( $usuario->getSaldoDelEjercicio() - $operacion->getTotal()  ) + $monto );
            $usuario->setSaldoDelEjercicio( $usuario->getSaldoDelEjercicio() + $monto );

            $from = 3;
        } else {
            Logger::error("No se recibio si el abono sera para una venta, una compra o un prestamo, no se hace nada");
            throw new Exception("No se recibio si el abono sera para una venta, una compra o un prestamo, no se hace nada");
        }
        
        //Una vez hecho los cambios particulaes, se realizan los cambios generales
        
        $operacion->setSaldo($operacion->getSaldo() - $monto);
        $abono->setCancelado($cancelado);
        $abono->setIdCaja($id_caja);
        $abono->setFecha($fecha);
        $abono->setIdSucursal($id_sucursal);
        $abono->setMonto($monto);
        $abono->setNota($nota);
        $abono->setTipoDePago($tipo_pago);
        $id_cheques = array();
        $id_abono   = null;
        DAO::transBegin();
        try {
            //Si se reciben cheques y el tipo de pago es cheque, se genera el nuevo cheque y
            //se va almacenando su id en el arreglo id_cheques
            if ($tipo_pago === "cheque" && !is_null($cheques)) {
                foreach ($cheques as $cheque) {
                    array_push($id_cheques, ChequesController::NuevoCheque($cheque["nombre_banco"], $cheque["monto"], $cheque["numero"], $cheque["expedido"]));
                }
            }
            
            //Dependiendo de que operacion se realizo se van guardando los cheques, los abonos y las operaciones
            //pues todas cambiaron.
            //Si se recibieron cheques, no se modifica la caja.
            //En el caso de las ventas, al final se busca la venta en la tabla venta_empresa y se pone como saldada
            //si ese ha sido el caso
            switch ($from) {
                case 1:
                    AbonoCompraDAO::save($abono);
                    CompraDAO::save($operacion);
                    $id_abono            = $abono->getIdAbonoCompra();
                    $cheque_abono_compra = new ChequeAbonoCompra();
                    $cheque_abono_compra->setIdAbonoCompra($id_abono);
                    if (!is_null($id_caja) && empty($id_cheques)) {
                        CajasController::modificarCaja($id_caja, 0, $billetes, $monto);
                    }
                    foreach ($id_cheques as $id_cheque) {
                        $cheque_abono_compra->setIdCheque($id_cheque);
                        ChequeAbonoCompraDAO::save($cheque_abono_compra);
                    }
                    break;
                case 2:
                    AbonoPrestamoDAO::save($abono);
                    PrestamoDAO::save($operacion);
                    $id_abono              = $abono->getIdAbonoPrestamo();
                    $cheque_abono_prestamo = new ChequeAbonoPrestamo();
                    $cheque_abono_prestamo->setIdAbonoPrestamo($id_abono);
                    if (!is_null($id_caja) && empty($id_cheques)) {
                        CajasController::modificarCaja($id_caja, 1, $billetes, $monto);
                    }
                    foreach ($id_cheques as $id_cheque) {
                        $cheque_abono_prestamo->setIdCheque($id_cheque);
                        ChequeAbonoPrestamoDAO::save($cheque_abono_prestamo);
                    }
                    break;
                case 3:
                    AbonoVentaDAO::save($abono);
                    VentaDAO::save($operacion);
                    $id_abono           = $abono->getIdAbonoVenta();
                    $cheque_abono_venta = new ChequeAbonoVenta();
                    $cheque_abono_venta->setIdAbonoVenta($id_abono);
                    if (!is_null($id_caja) && empty($id_cheques)) {
                        CajasController::modificarCaja($id_caja, 1, $billetes, $monto);
                    }
                    foreach ($id_cheques as $id_cheque) {
                        $cheque_abono_venta->setIdCheque($id_cheque);
                        ChequeAbonoVentaDAO::save($cheque_abono_venta);
                    }
                    if ($operacion->getSaldo() >= $operacion->getTotal()) {
                        $ventas_empresa = VentaEmpresaDAO::search(new VentaEmpresa(array(
                            "id_venta" => $operacion->getIdVenta()
                        )));
                        foreach ($ventas_empresa as $venta_empresa) {
                            $venta_empresa->setSaldada(1);
                            VentaEmpresaDAO::save($venta_empresa);
                        }
                    }
            }
            /* Fin switch de from */
            UsuarioDAO::save($usuario);
        }
        /* Fin de try */
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("Error al crear el abono: " . $e);
            throw new Exception("Error al crear el abono");
        }
        DAO::transEnd();
        Logger::log("Abono creado exitosamente");
        return array(
            "id_abono" => $id_abono
        );
    }
    
    
    
    /**
     *
     *Lista los ingresos, se puede filtrar de acuerdo a la empresa, la sucursal, el usuario que registra el ingreso, el concepto de ingreso, la caja que recibi? ingreso, de una fecha inicial a una final, por monto, por cancelacion, y se puede ordenar de acuerdo a sus atributos.
     *
     * @param id_caja int Id de la caja de la cual se listaran los ingresos que ha recibido
     * @param fecha_inicial string Se listaran los ingresos cuya fecha de ingreso sea mayor a este valor
     * @param fecha_final string Se listaran los ingresos cuya fecha de ingreso sea menor a este valor
     * @param id_sucursal int Id de la sucursal de la cual se listaran sus ingresos
     * @param id_concepto_ingreso int Se listaran los ingresos que tengan este concepto de ingreso
     * @param id_empresa int Id de la empresa de la cual se listaran sus ingresos
     * @param id_usuario int Id del usuario del cual se listaran los ingresos que ha registrado
     * @param cancelado bool Si este valor no es obtenido, se listaran tanto ingresos cancelados como no cancelados, si es true, solo se listaran los ingresos cancelados, si es false, se listaran solo los ingresos no cancelados
     * @param monto_minimo float Se listaran los ingresos cuyo monto sea mayor a este valor
     * @param monto_maximo float Se listaran los ingresos cuyo monto sea menor a este valor
     **/
    public static function ListaIngreso($cancelado = null, $fecha_actual = null, $fecha_final = null, $fecha_inicial = null, $id_caja = null, $id_concepto_ingreso = null, $id_empresa = null, $id_sucursal = null, $id_usuario = null, $monto_maximo = null, $monto_minimo = null, $orden = null)
    {
        Logger::log("Listando ingresos....");
        
        //verifica que el orden sea valida
        if (!is_null($orden)) {
            if ($orden != "id_ingreso" && $orden != "id_empresa" && $orden != "id_usuario" && $orden != "id_concepto_ingreso" && $orden != "id_caja" && $orden != "fecha_del_ingreso" && $orden != "fecha_de_registro" && $orden != "id_sucursal" && $orden != "nota" && $orden != "descripcion" && $orden != "folio" && $orden != "monto" && $orden != "cancelado" && $orden != "motivo_cancelacion") {
                Logger::error("La variable orden (" . $orden . ") no es valida");
                throw new Exception("La variable orden (" . $orden . ") no es valida");
            }
        }
        
        //verifica que se hayan obtenido los parametros para usar getAll o getByRange
        $parametros = false;
        if (!is_null($id_empresa) || !is_null($id_usuario) || !is_null($id_concepto_ingreso) || !is_null($id_caja) || !is_null($fecha_inicial) || !is_null($fecha_final) || !is_null($id_sucursal) || !is_null($cancelado) || !is_null($monto_minimo) || !is_null($monto_maximo) || !is_null($fecha_actual))
            $parametros = true;
        $ingresos = null;
        if ($parametros) {
            Logger::log("Se recibieron parametros, se listan los Ingresos dentro del rango");
            //
            //Se almacenan los parametros recibidos en el objeto criterio 1
            //para luego ser comparados.
            //
            $ingreso_criterio_1 = new Ingreso();
            $ingreso_criterio_2 = new Ingreso();
            $ingreso_criterio_1->setIdEmpresa($id_empresa);
            $ingreso_criterio_1->setIdUsuario($id_usuario);
            $ingreso_criterio_1->setIdConceptoIngreso($id_concepto_ingreso);
            $ingreso_criterio_1->setIdCaja($id_caja);
            $ingreso_criterio_1->setIdSucursal($id_sucursal);
            $ingreso_criterio_1->setCancelado($cancelado);
            if (!is_null($fecha_inicial)) {
                //
                //Si pasaron una fecha minima y existe una fecha maxima, entonces
                //el objeto 1 almacenara la minima y el objeto 2 la maxima para
                //que se impriman los ingresos entre esas dos fechas.
                //
                //Si no hay fecha maxima, el objeto 2 almacenara la fecha de hoy
                //para que se impriman los ingresos desde la fecha minima hasta hoy.
                //
                //
                $ingreso_criterio_1->setFechaDelIngreso($fecha_inicial);
                if (!is_null($fecha_final))
                    $ingreso_criterio_2->setFechaDelIngreso($fecha_final);
                else
                    $ingreso_criterio_2->setFechaDelIngreso(date("Y-m-d H:i:s", time()));
            } else if (!is_null($fecha_final)) {
                //
                //Si no se recibio fecha minima pero si fecha maxima
                //El objeto 1 guarda la fecha maxima y el objeto 2 guarda
                //la fecha minima posible de MySQL, para asi poder listar
                //los ingresos anteriores a la fecha maxima.
                //
                $ingreso_criterio_1->setFechaDelIngreso($fecha_final);
                $ingreso_criterio_2->setFechaDelIngreso("1000-01-01 00:00:00");
            } else if ($fecha_actual) {
                //
                //Si se recibio el booleano fecha_actual, se listaran los ingresos
                //solo de hoy, se crea un timestamp con el año, el mes y el dia de hoy
                //pero se inicia con la hora 00:00:00 y se almacena como fecha en el objeto 1.
                //
                //Se crea un segundo timestamp con el año, el mes y el dia de hoy pero
                //con la hora 23:59:59 y se almacena como fecha en el objeto 2.
                //
                $hoy = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
                $ingreso_criterio_1->setFechaDelIngreso(date("Y-m-d H:i:s", $hoy));
                $manana = mktime(23, 59, 59, date("m"), date("d"), date("Y"));
                $ingreso_criterio_2->setFechaDelIngreso(date("Y-m-d H:i:s", $manana));
            }
            if (!is_null($monto_minimo)) {
                //
                //Si se recibio el monto_minimo y se recibio el monto_maximo
                //el objeto 1 guarda el primero y el objeto2 guarda el segundo
                //para asi listar los ingresos cuyo monto sea mayor al minimo y
                //menor que el maximo
                //
                //Si no, el objeto 2 almacena el valor mas grande posible
                //para que se listen los gastos cuyo monto sea mayor al minimo
                //
                $ingreso_criterio_1->setMonto($monto_minimo);
                if (!is_null($monto_maximo))
                    $ingreso_criterio_2->setMonto($monto_maximo);
                else
                    $ingreso_criterio_2->setMonto(1.8e100);
            } else if (!is_null($monto_maximo)) {
                //
                //Si solo se obtuvo monto_maximo, el objeto 1 lo almacena y el
                //objeto 2 almacena el monto mas bajo posible para que  se listen
                //los gastos cuyo monto sea menor al maximo
                //
                $ingreso_criterio_1->setMonto($monto_maximo);
                $ingreso_criterio_2->setMonto(0);
            }
            $ingresos = IngresoDAO::byRange($ingreso_criterio_1, $ingreso_criterio_2, $orden);
        } else {

            if(is_null($orden)){
				$orden = "fecha_del_ingreso";
            }
            $ingresos = IngresoDAO::getAll( null, null, $orden, "desc" );
        }
        Logger::log("Se obtuvo la lista de ingresos exitosamente");
        return array("resultados" => $ingresos , "numero_de_resultados" => sizeof($ingresos) ) ;
    }
    
    /**
     *
     *Edita la informaci?e un abono
     *
     * @param id_abono int Id del abono a editar
     * @param nota string Nota del abono
     * @param motivo_cancelacion string Motivo por el cual se cancelo el abono
     **/
    public static function EditarAbono($id_abono, $compra = null, $motivo_cancelacion = null, $nota = null, $prestamo = null, $venta = null)
    {
        Logger::log("Editando abono");
        
        //Se validan los parametros
        $validar = self::validarParametrosAbono(null, null, $nota, null, $motivo_cancelacion);
        if (is_string($validar)) {
            Logger::error($validar);
            throw new Exception($validar);
        }
        //verifica si el abono sera de compra, de venta o de prestamo
        $abono = null;
        $from  = 0;
        if ($compra) {
            $abono = AbonoCompraDAO::getByPK($id_abono);
            $from  = 1;
        } else if ($venta) {
            $abono = AbonoVentaDAO::getByPK($id_abono);
            $from  = 2;
        } else if ($prestamo) {
            $abono = AbonoPrestamoDAO::getByPK($id_abono);
            $from  = 3;
        } else {
            Logger::error("No se recibio si se editara un abono de compra, venta o prestamo");
            throw new Exception("No se recibio si se editara un abono de compra, venta o prestamo");
        }
        
        //valida que el abono exista
        if (is_null($abono)) {
            $texto = "";
            switch ($from) {
                case 1:
                    $texto = "compra";
                    break;
                case 2:
                    $texto = "venta";
                    break;
                case 3:
                    $texto = "prestamo";
                    break;
            }
            Logger::error("El abono de " . $texto . " con id " . $id_abono . " no existe");
            throw new Exception("El abono de " . $texto . " con id " . $id_abono . " no existe");
        }
        
        //Los parametros que sean recibidos seran tomados como actalizacion
        if (!is_null($nota))
            $abono->setNota($nota);
        if ($abono->getCancelado()) {
            if (!is_null($motivo_cancelacion))
                $abono->setMotivoCancelacion($motivo_cancelacion);
        } else if (!is_null($motivo_cancelacion))
            Logger::warn("No se editara el motivo de cancelacion pues el abono no ha sido cancelado aun");
        
        //guarda la actualizacion en la tabla correspondiente
        DAO::transBegin();
        try {
            switch ($from) {
                case 1:
                    AbonoCompraDAO::save($abono);
                    break;
                case 2:
                    AbonoVentaDAO::save($abono);
                    break;
                case 3:
                    AbonoPrestamoDAO::save($abono);
            }
        }
        catch (Exception $e) {
            DAO::transRollback();
            Logger::error("No se pudo editar el abono: " . $e);
            throw new Exception("No se pudo editar el abono");
        }
        DAO::transEnd();
        Logger::log("Abono editado exitosamente");
    }
}
