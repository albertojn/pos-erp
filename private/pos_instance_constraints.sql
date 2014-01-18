--
-- Constraints for dumped tables
--

--
-- Constraints for table `abasto_proveedor`
--
ALTER TABLE `abasto_proveedor`
  ADD CONSTRAINT `abasto_proveedor_ibfk_1` FOREIGN KEY (`id_proveedor`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `abasto_proveedor_ibfk_2` FOREIGN KEY (`id_almacen`) REFERENCES `almacen` (`id_almacen`),
  ADD CONSTRAINT `abasto_proveedor_ibfk_3` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `abono_compra`
--
ALTER TABLE `abono_compra`
  ADD CONSTRAINT `abono_compra_ibfk_1` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`),
  ADD CONSTRAINT `abono_compra_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `abono_compra_ibfk_3` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id_caja`),
  ADD CONSTRAINT `abono_compra_ibfk_4` FOREIGN KEY (`id_deudor`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `abono_compra_ibfk_5` FOREIGN KEY (`id_receptor`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `abono_prestamo`
--
ALTER TABLE `abono_prestamo`
  ADD CONSTRAINT `abono_prestamo_ibfk_1` FOREIGN KEY (`id_prestamo`) REFERENCES `prestamo` (`id_prestamo`),
  ADD CONSTRAINT `abono_prestamo_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `abono_prestamo_ibfk_3` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id_caja`),
  ADD CONSTRAINT `abono_prestamo_ibfk_4` FOREIGN KEY (`id_deudor`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `abono_prestamo_ibfk_5` FOREIGN KEY (`id_receptor`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `abono_venta`
--
ALTER TABLE `abono_venta`
  ADD CONSTRAINT `abono_venta_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`),
  ADD CONSTRAINT `abono_venta_ibfk_2` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `abono_venta_ibfk_3` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id_caja`),
  ADD CONSTRAINT `abono_venta_ibfk_4` FOREIGN KEY (`id_deudor`) REFERENCES `usuario` (`id_usuario`),
  ADD CONSTRAINT `abono_venta_ibfk_5` FOREIGN KEY (`id_receptor`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `almacen`
--
ALTER TABLE `almacen`
  ADD CONSTRAINT `almacen_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`),
  ADD CONSTRAINT `almacen_ibfk_2` FOREIGN KEY (`id_empresa`) REFERENCES `empresa` (`id_empresa`),
  ADD CONSTRAINT `almacen_ibfk_3` FOREIGN KEY (`id_tipo_almacen`) REFERENCES `tipo_almacen` (`id_tipo_almacen`);

--
-- Constraints for table `apertura_caja`
--
ALTER TABLE `apertura_caja`
  ADD CONSTRAINT `apertura_caja_ibfk_1` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id_caja`),
  ADD CONSTRAINT `apertura_caja_ibfk_2` FOREIGN KEY (`id_cajero`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `billete`
--
ALTER TABLE `billete`
  ADD CONSTRAINT `billete_ibfk_1` FOREIGN KEY (`id_moneda`) REFERENCES `moneda` (`id_moneda`);

--
-- Constraints for table `billete_apertura_caja`
--
ALTER TABLE `billete_apertura_caja`
  ADD CONSTRAINT `billete_apertura_caja_ibfk_1` FOREIGN KEY (`id_billete`) REFERENCES `billete` (`id_billete`),
  ADD CONSTRAINT `billete_apertura_caja_ibfk_2` FOREIGN KEY (`id_apertura_caja`) REFERENCES `apertura_caja` (`id_apertura_caja`);

--
-- Constraints for table `billete_caja`
--
ALTER TABLE `billete_caja`
  ADD CONSTRAINT `billete_caja_ibfk_1` FOREIGN KEY (`id_billete`) REFERENCES `billete` (`id_billete`),
  ADD CONSTRAINT `billete_caja_ibfk_2` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id_caja`);

--
-- Constraints for table `billete_cierre_caja`
--
ALTER TABLE `billete_cierre_caja`
  ADD CONSTRAINT `billete_cierre_caja_ibfk_1` FOREIGN KEY (`id_billete`) REFERENCES `billete` (`id_billete`),
  ADD CONSTRAINT `billete_cierre_caja_ibfk_2` FOREIGN KEY (`id_cierre_caja`) REFERENCES `cierre_caja` (`id_cierre_caja`);

--
-- Constraints for table `billete_corte_caja`
--
ALTER TABLE `billete_corte_caja`
  ADD CONSTRAINT `billete_corte_caja_ibfk_1` FOREIGN KEY (`id_billete`) REFERENCES `billete` (`id_billete`),
  ADD CONSTRAINT `billete_corte_caja_ibfk_2` FOREIGN KEY (`id_corte_caja`) REFERENCES `corte_de_caja` (`id_corte_de_caja`);

--
-- Constraints for table `caja`
--
ALTER TABLE `caja`
  ADD CONSTRAINT `caja_ibfk_1` FOREIGN KEY (`id_sucursal`) REFERENCES `sucursal` (`id_sucursal`);


--
-- Constraints for table `categoria_contacto`
--
ALTER TABLE  `categoria_contacto`
  ADD FOREIGN KEY (  `id_padre` ) REFERENCES  `pos_instance_90`.`categoria_contacto` (`id`) ON DELETE SET NULL ON UPDATE RESTRICT;

--
-- Constraints for table `cheque`
--
ALTER TABLE `cheque`
  ADD CONSTRAINT `cheque_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `cheque_abono_compra`
--
ALTER TABLE `cheque_abono_compra`
  ADD CONSTRAINT `cheque_abono_compra_ibfk_1` FOREIGN KEY (`id_cheque`) REFERENCES `cheque` (`id_cheque`),
  ADD CONSTRAINT `cheque_abono_compra_ibfk_2` FOREIGN KEY (`id_abono_compra`) REFERENCES `abono_compra` (`id_abono_compra`);

--
-- Constraints for table `cheque_abono_prestamo`
--
ALTER TABLE `cheque_abono_prestamo`
  ADD CONSTRAINT `cheque_abono_prestamo_ibfk_1` FOREIGN KEY (`id_cheque`) REFERENCES `cheque` (`id_cheque`),
  ADD CONSTRAINT `cheque_abono_prestamo_ibfk_2` FOREIGN KEY (`id_abono_prestamo`) REFERENCES `abono_prestamo` (`id_abono_prestamo`);

--
-- Constraints for table `cheque_abono_venta`
--
ALTER TABLE `cheque_abono_venta`
  ADD CONSTRAINT `cheque_abono_venta_ibfk_1` FOREIGN KEY (`id_cheque`) REFERENCES `cheque` (`id_cheque`),
  ADD CONSTRAINT `cheque_abono_venta_ibfk_2` FOREIGN KEY (`id_abono_venta`) REFERENCES `abono_venta` (`id_abono_venta`);

--
-- Constraints for table `cheque_compra`
--
ALTER TABLE `cheque_compra`
  ADD CONSTRAINT `cheque_compra_ibfk_1` FOREIGN KEY (`id_cheque`) REFERENCES `cheque` (`id_cheque`),
  ADD CONSTRAINT `cheque_compra_ibfk_2` FOREIGN KEY (`id_compra`) REFERENCES `compra` (`id_compra`);

--
-- Constraints for table `cheque_venta`
--
ALTER TABLE `cheque_venta`
  ADD CONSTRAINT `cheque_venta_ibfk_1` FOREIGN KEY (`id_cheque`) REFERENCES `cheque` (`id_cheque`),
  ADD CONSTRAINT `cheque_venta_ibfk_2` FOREIGN KEY (`id_venta`) REFERENCES `venta` (`id_venta`);

--
-- Constraints for table `cierre_caja`
--
ALTER TABLE `cierre_caja`
  ADD CONSTRAINT `cierre_caja_ibfk_1` FOREIGN KEY (`id_caja`) REFERENCES `caja` (`id_caja`),
  ADD CONSTRAINT `cierre_caja_ibfk_2` FOREIGN KEY (`id_cajero`) REFERENCES `usuario` (`id_usuario`);

--
-- Constraints for table `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `producto_ibfk_1` FOREIGN KEY (`id_clasificacion_producto`) REFERENCES `clasificacion_producto` (`id_clasificacion_producto`);

--
-- Constraints for table `unidad_medida`
--
ALTER TABLE `unidad_medida`
  ADD CONSTRAINT `unidad_medida_ibfk_1` FOREIGN KEY (`id_categoria_unidad_medida`) REFERENCES `categoria_unidad_medida` (`id_categoria_unidad_medida`);


--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_categoria_contacto`) REFERENCES `categoria_contacto` (`id`);