<?php

require_once '../../config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/FacturasCabeceraOad.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FacturaCabecera.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class FacturasCabeceraOadImpl extends AOD implements FacturasCabeceraOad {

      public function obtiene($id){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  FAC.FACTURA_CABECERA_ID,     \n";
         $sql.="  FAC.FACTURA_NUMERO,     \n";
         $sql.="  FAC.FACTURA_FECHA,     \n";
         $sql.="  CLI.CLIENTE_ID,     \n";
         $sql.="  FAC.REMITO_NUMERO,     \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  CLI.TELEFONO,     \n";
         $sql.="  CLI.LOCALIDAD,     \n";
         $sql.="  CLI.CONDICION_IVA,     \n";
         $sql.="  CLI.CUIT,     \n";
         $sql.="  FAC.CONDICIONES_VENTA,     \n";
         $sql.="  FAC.FACTURA_SUBTOTAL,     \n";
         $sql.="  FAC.FACTURA_TIPO,     \n";
         $sql.="  FAC.IVA_INSCRIPTO,     \n";
         $sql.="  FAC.DESCUENTO,     \n";
         $sql.="  FAC.OBSERVACIONES_CAB,     \n";
         $sql.="  FAC.FACTURA_ESTADO,     \n";
         $sql.="  FAC.FACTURA_TOTAL    \n";
         $sql.="FROM  \n";
         $sql.="  FACTURAS_CABECERA FAC    \n";
         $sql.="  INNER JOIN CLIENTES CLI ON FAC.CLIENTE_ID = CLI.CLIENTE_ID    \n";
         $sql.="WHERE  \n";
         $sql.="  FACTURA_CABECERA_ID='" . $id . "' \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $bean=new FacturaCabecera();
         $id=null;
         $numero=null;
         $fecha=null;
         $clienteId=null;
         $remitoNumero=null;
         $clienteNombre=null;
         $clienteTelefono=null;
         $clienteLocalidad=null;
         $clienteCondicionIva=null;
         $clienteCuit=null;
         $condicionesVenta=null;
         $subtotal=null;
         $facturaTipo=null;
         $ivaInscripto=null;
         $descuento=null;
         $observaciones=null;
         $estado=null;
         $total=null;
         $stm->bind_result($id, $numero, $fecha, $clienteId, $remitoNumero, $clienteNombre, $clienteTelefono, $clienteLocalidad, $clienteCondicionIva,
         	$clienteCuit, $condicionesVenta, $subtotal, $facturaTipo, $ivaInscripto, $descuento, $observaciones, $estado, $total);
         if ($stm->fetch()) {
            $bean->setId($id);
            $bean->setNumero($numero);
            $bean->setFechaLarga($fecha);
            $bean->setClienteId($clienteId);
            $bean->setRemitoNumero($remitoNumero);
            $bean->setClienteNombre($clienteNombre);
            $bean->setClienteTelefono($clienteTelefono);
            $bean->setClienteLocalidad($clienteLocalidad);
            $bean->setClienteCondicionIva($clienteCondicionIva);
            $bean->setClienteCuit($clienteCuit);
            $bean->setCondicionesVenta($condicionesVenta);
            $bean->setSubtotal($subtotal);
            $bean->setTipo($facturaTipo);
            $bean->setDescuento($descuento);
            $bean->setObservaciones($observaciones);
            $bean->setEstado($estado);
            $bean->setTotal($total);
         }
         $this->cierra($conexion, $stm);
         return $bean;
      }


      public function inserta($bean){
         $conexion=$this->conectarse();
         $sql="INSERT INTO FACTURAS_CABECERA (   \n";
         $sql.="  FACTURA_CABECERA_ID,     \n";
         $sql.="  FACTURA_NUMERO,     \n";
         $sql.="  FACTURA_FECHA,     \n";
         $sql.="  CLIENTE_ID,     \n";
         $sql.="  REMITO_NUMERO,     \n";
         $sql.="  CONDICIONES_VENTA,     \n";
         $sql.="  FACTURA_SUBTOTAL,     \n";
         $sql.="  FACTURA_TIPO,     \n";
         $sql.="  IVA_INSCRIPTO,     \n";
         $sql.="  DESCUENTO,     \n";
         $sql.="  OBSERVACIONES_CAB,     \n";
         $sql.="  FACTURA_ESTADO,     \n";
         $sql.="  FACTURA_TOTAL)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Válida', ?)    \n";
         $nuevoId=$this->idUnico();
         $bean->setId($nuevoId);
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("sissisdsddsd", $nuevoId, $bean->getNumero(), $bean->getFechaLarga(), $bean->getClienteId(),
               $bean->getRemitoNumero(), $bean->getCondicionesVenta(), $bean->getSubtotal(), $bean->getTipo(),
               $bean->getIvaInscripto(), $bean->getDescuento(),
               $bean->getObservaciones(), $bean->getTotal());
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId);
      }


      public function borra($id){
         $conexion=$this->conectarse();
         $sql="DELETE FROM FACTURAS_CABECERA   \n";
         $sql.="WHERE FACTURA_CABECERA_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("s", $id);
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function actualiza($bean){
         $conexion=$this->conectarse();
         $sql="UPDATE FACTURAS_CABECERA SET   \n";
         $sql.="  FACTURA_NUMERO=?,     \n";
         $sql.="  FACTURA_FECHA=?,     \n";
         $sql.="  CLIENTE_ID=?,     \n";
         $sql.="  REMITO_NUMERO=?,     \n";
         $sql.="  CONDICIONES_VENTA=?,     \n";
         $sql.="  FACTURA_SUBTOTAL=?,     \n";
         $sql.="  FACTURA_TIPO=?,     \n";
         $sql.="  IVA_INSCRIPTO=?,     \n";
         $sql.="  DESCUENTO=?,     \n";
         $sql.="  OBSERVACIONES_CAB=?,     \n";
         $sql.="  FACTURA_ESTADO=?,     \n";
         $sql.="  FACTURA_TOTAL=?     \n";
         $sql.="WHERE FACTURA_CABECERA_ID=?   \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->bind_param("issisdsddssds", $bean->getNumero(), $bean->getFechaLarga(), $bean->getClienteId(),
                          $bean->getRemitoNumero(), $bean->getCondicionesVenta(), $bean->getSubtotal(),
                          $bean->getTipo(), $bean->getIvaInscripto(), $bean->getDescuento(),
                          $bean->getObservaciones(), $bean->getEstado(), $bean->getTotal(), $bean->getId() );
         return $this->ejecutaYCierra($conexion, $stm);
      }


      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta, $estado, $tipo){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  FAC.FACTURA_CABECERA_ID,     \n";
         $sql.="  FAC.FACTURA_NUMERO,     \n";
         $sql.="  FAC.FACTURA_FECHA,     \n";
         $sql.="  CLI.CLIENTE_ID,     \n";
         $sql.="  FAC.REMITO_NUMERO,     \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  CLI.TELEFONO,     \n";
         $sql.="  CLI.LOCALIDAD,     \n";
         $sql.="  CLI.CONDICION_IVA,     \n";
         $sql.="  CLI.CUIT,     \n";
         $sql.="  FAC.CONDICIONES_VENTA,     \n";
         $sql.="  FAC.FACTURA_SUBTOTAL,     \n";
         $sql.="  FAC.FACTURA_TIPO,     \n";
         $sql.="  FAC.IVA_INSCRIPTO,     \n";
         $sql.="  FAC.DESCUENTO,     \n";
         $sql.="  FAC.OBSERVACIONES_CAB,     \n";
         $sql.="  FAC.FACTURA_ESTADO,     \n";
         $sql.="  FAC.FACTURA_TOTAL    \n";
         $sql.="FROM  \n";
         $sql.="  FACTURAS_CABECERA FAC    \n";
         $sql.="  INNER JOIN CLIENTES CLI ON FAC.CLIENTE_ID = CLI.CLIENTE_ID    \n";
         $sql.="WHERE  1=1 \n";
         if (!empty($tipo)){
         	$sql.="  AND FAC.FACTURA_TIPO='" . $tipo . "' \n";
         }
         if (!empty($clienteId)){
         	$sql.="  AND FAC.CLIENTE_ID='" . $clienteId . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND DATE(FAC.FACTURA_FECHA) >= DATE('" . FechaUtils::dateTimeACadenaAMD($fechaDesde) . "') \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND DATE(FAC.FACTURA_FECHA) <= DATE('" . FechaUtils::dateTimeACadenaAMD($fechaHasta) . "') \n";
         }
         if (!empty($estado)){
         	$sql.="  AND FAC.FACTURA_ESTADO='" . $estado . "' \n";
         }

         if (!empty($sort)){
           $sql.="ORDER BY  \n";
           if ($sort=='facturaNumero'){
             $sql.="  FAC.FACTURA_NUMERO " . $dir . " \n";
           }else if ($sort=='facturaFecha'){
             $sql.="  FAC.FACTURA_FECHA " . $dir . " \n";
           }else if ($sort=='clienteNombre'){
             $sql.="  CLI.CLIENTE_NOMBRE " . $dir . " \n";
           }else if ($sort=='subtotal'){
             $sql.="  FAC.FACTURA_SUBTOTAL " . $dir . " \n";
           }
           
         }
         //fb($sql);
         $sql.=" LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $id=null;
         $numero=null;
         $fecha=null;
         $clienteId=null;
         $remitoNumero=null;
         $clienteNombre=null;
         $clienteTelefono=null;
         $clienteLocalidad=null;
         $clienteCondicionIva=null;
         $clienteCuit=null;
         $condicionesVenta=null;
         $subtotal=null;
         $facturaTipo=null;
         $ivaInscripto=null;
         $descuento=null;
         $observaciones=null;
         $estado=null;
         $total=null;
         $stm->bind_result($id, $numero, $fecha, $clienteId, $remitoNumero, $clienteNombre,
            $clienteTelefono, $clienteLocalidad, $clienteCondicionIva, $clienteCuit, $condicionesVenta,
            $subtotal, $facturaTipo, $ivaInscripto, $descuento, $observaciones, $estado, $total);
         $filas = array();
         while ($stm->fetch()) {
            $bean=new FacturaCabecera();
            $bean->setId($id);
            $bean->setNumero($numero);
            $bean->setFechaLarga($fecha);
            $bean->setClienteId($clienteId);
            $bean->setRemitoNumero($remitoNumero);
            $bean->setClienteNombre($clienteNombre);
            $bean->setClienteTelefono($clienteTelefono);
            $bean->setClienteLocalidad($clienteLocalidad);
            $bean->setClienteCondicionIva($clienteCondicionIva);
            $bean->setClienteCuit($clienteCuit);
            $bean->setCondicionesVenta($condicionesVenta);
            $bean->setSubtotal($subtotal);
            $bean->setTipo($facturaTipo);
            $bean->setIvaInscripto($ivaInscripto);
            $bean->setDescuento($descuento);
            $bean->setObservaciones($observaciones);
            $bean->setEstado($estado);
            $bean->setTotal($total);
            $filas[$id]=$bean;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }


      public function selTodosCuenta($clienteId, $fechaDesde, $fechaHasta, $estado, $tipo){
         $conexion=$this->conectarse();
         $sql="SELECT COUNT(*) FROM FACTURAS_CABECERA FAC ";
         $sql.="WHERE  1=1 \n";
         if (!empty($tipo)){
         	$sql.="  AND FAC.FACTURA_TIPO='" . $tipo . "' \n";
         }
         if (!empty($clienteId)){
         	$sql.="  AND FAC.CLIENTE_ID='" . $clienteId . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND DATE(FAC.FACTURA_FECHA) >= DATE('" . FechaUtils::dateTimeACadenaAMD($fechaDesde) . "') \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND DATE(FAC.FACTURA_FECHA) <= DATE('" . FechaUtils::dateTimeACadenaAMD($fechaHasta) . "') \n";
         }
         if (!empty($estado)){
         	$sql.="  AND FAC.FACTURA_ESTADO='" . $estado . "' \n";
         }

         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }
      
      public function selSubtotalGeneral($clienteId, $fechaDesde, $fechaHasta, $estado, $tipo){
         $conexion=$this->conectarse();
         $sql="SELECT SUM(FACTURA_SUBTOTAL) FROM FACTURAS_CABECERA FAC ";
         $sql.="WHERE  1=1 \n";
         if (!empty($tipo)){
         	$sql.="  AND FAC.FACTURA_TIPO='" . $tipo . "' \n";
         }
         if (!empty($clienteId)){
         	$sql.="  AND FAC.CLIENTE_ID='" . $clienteId . "' \n";
         }
         if (!empty($fechaDesde)){
         	$sql.="  AND DATE(FAC.FACTURA_FECHA) >= DATE('" . FechaUtils::dateTimeACadenaAMD($fechaDesde) . "') \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND DATE(FAC.FACTURA_FECHA) <= DATE('" . FechaUtils::dateTimeACadenaAMD($fechaHasta) . "') \n";
         }
         if (!empty($estado)){
         	$sql.="  AND FAC.FACTURA_ESTADO='" . $estado . "' \n";
         }

         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $cuenta=null;
         $stm->bind_result($cuenta);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $cuenta;
      }
      


      public function getMaxNumero(){
         $conexion=$this->conectarse();
         $sql="SELECT MAX(FACTURA_NUMERO) FROM FACTURAS_CABECERA \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $max=null;
         $stm->bind_result($max);
         $stm->fetch();
         $this->cierra($conexion, $stm);
         return $max;
      }

      public function selReporteFactura($facturaCabeceraId){
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
         $sql.="  CLI.CLIENTE_NOMBRE,     \n";
         $sql.="  CLI.DIRECCION,     \n";
         $sql.="  CLI.LOCALIDAD,     \n";
         $sql.="  CLI.TELEFONO,     \n";
         $sql.="  CLI.CONDICION_IVA,     \n";
         $sql.="  CLI.CUIT,     \n";
         $sql.="  FAC.FACTURA_FECHA,     \n";
         $sql.="  FAC.REMITO_NUMERO,     \n";
         $sql.="  FAC.FACTURA_NUMERO,     \n";
         $sql.="  FAC.FACTURA_SUBTOTAL,     \n";
         $sql.="  FAC.IVA_INSCRIPTO,     \n";
         $sql.="  FAC.FACTURA_TIPO,     \n";
         $sql.="  FAC.FACTURA_TOTAL,     \n";
         $sql.="  FAC.OBSERVACIONES_CAB,     \n";
         $sql.="  FAD.CANTIDAD,     \n";
         $sql.="  FAD.PRECIO_UNITARIO,     \n";
         $sql.="  FAD.FACTURA_IMPORTE,     \n";
         $sql.="  FAD.REFERENCIA_PEDIDO,     \n";
         $sql.="  PIE.PIEZA_NOMBRE     \n";
         $sql.="FROM  \n";
         $sql.="  FACTURAS_CABECERA FAC  \n";
         $sql.="  INNER JOIN CLIENTES CLI ON CLI.CLIENTE_ID=FAC.CLIENTE_ID  \n";
         $sql.="  LEFT JOIN FACTURAS_DETALLE  FAD ON FAC.FACTURA_CABECERA_ID=FAD.FACTURA_CABECERA_ID\n";
         $sql.="  LEFT JOIN PIEZAS PIE ON FAD.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE     \n";
         $sql.="  FAC.FACTURA_CABECERA_ID='" . $facturaCabeceraId . "'    \n";
         $sql.="ORDER BY     \n";
         $sql.="  PIE.PIEZA_NOMBRE     \n";
         $stm=$this->preparar($conexion, $sql);
         $stm->execute();
         $clienteNombre=null;
         $direccion=null;
         $localidad=null;
         $telefono=null;
         $condicionIva=null;
         $cuit=null;
         $facturaFecha=null;
         $remitoNumero=null;
         $facturaNumero=null;
         $subtotal=null;
         $ivaInscripto=null;
         $facturaTipo=null;
         $total=null;
         $observacionesCab=null;
         $cantidad=null;
         $precioUnitario=null;
         $importe=null;
         $referenciaPedido=null;
         $piezaNombre=null;
         $stm->bind_result($clienteNombre, $direccion, $localidad, $telefono, $condicionIva, $cuit,
           $facturaFecha, $remitoNumero, $facturaNumero, $subtotal, $ivaInscripto, $facturaTipo,
           $total, $observacionesCab, $cantidad, $precioUnitario, $importe, $referenciaPedido, $piezaNombre);
         $filas = array();
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['clienteNombre']=$clienteNombre;
         	$fila['direccion']=$direccion;
         	$fila['localidad']=$localidad;
         	$fila['telefono']=$telefono;
         	$fila['condicionIva']=$condicionIva;
         	$fila['cuit']=$cuit;
         	$fila['facturaFecha']= FechaUtils::cadenaLargaADMA($facturaFecha);
         	$fila['remitoNumero']=$remitoNumero;
         	$fila['facturaNumero']=$facturaNumero;
         	$fila['subtotal']=$subtotal;
         	$fila['ivaInscripto']=$ivaInscripto;
         	$fila['facturaTipo']=$facturaTipo;
         	$fila['total']=$total;
         	$fila['observacionesCab']=$observacionesCab;
         	$fila['cantidad']=$cantidad;
         	$fila['precioUnitario']=$precioUnitario;
         	$fila['importe']=$importe;
         	$fila['referenciaPedido']=$referenciaPedido;
         	$fila['piezaNombre']=$piezaNombre;
            $filas[]=$fila;
         }
         $this->cierra($conexion, $stm);
         return $filas;
      }


   }
?>