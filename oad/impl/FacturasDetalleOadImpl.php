<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/FacturasDetalleOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FacturaDetalle.php';  
//require_once('FirePHPCore/fb.php');  

   class FacturasDetalleOadImpl extends AOD implements FacturasDetalleOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  FAD.FACTURA_DETALLE_ID,     \n"; 
         $sql.="  FAD.FACTURA_CABECERA_ID,     \n"; 
         $sql.="  FAD.CANTIDAD,     \n"; 
         $sql.="  FAD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  FAD.OBSERVACIONES_DET,     \n"; 
         $sql.="  FAD.PRECIO_UNITARIO,     \n"; 
         $sql.="  FAD.FACTURA_IMPORTE,    \n"; 
         $sql.="  FAD.REFERENCIA_PEDIDO    \n";
         $sql.="FROM  \n"; 
         $sql.="  FACTURAS_DETALLE FAD    \n"; 
         $sql.="  INNER JOIN FACTURAS_CABECERA FAC ON FAC.FACTURA_CABECERA_ID = FAD.FACTURA_CABECERA_ID    \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON FAD.PIEZA_ID = PIE.PIEZA_ID     \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  FACTURA_DETALLE_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new FacturaDetalle();  
         $id=null;  
         $facturaCabeceraId=null;  
         $cantidad=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $observacionesDet=null;  
         $precioUnitario=null;  
         $importe=null;  
         $referenciaPedido=null;
         $stm->bind_result($id, $facturaCabeceraId, $cantidad, $piezaId, $piezaNombre, $observacionesDet, 
               $precioUnitario, $importe, $referenciaPedido); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setFacturaCabeceraId($facturaCabeceraId);
            $bean->setCantidad($cantidad);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setObservacionesDet($observacionesDet);
            $bean->setPrecioUnitario($precioUnitario);
            $bean->setImporte($importe);
            $bean->setReferenciaPedido($referenciaPedido);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO FACTURAS_DETALLE (   \n"; 
         $sql.="  FACTURA_DETALLE_ID,     \n"; 
         $sql.="  FACTURA_CABECERA_ID,     \n"; 
         $sql.="  CANTIDAD,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  OBSERVACIONES_DET,     \n"; 
         $sql.="  PRECIO_UNITARIO,     \n"; 
         $sql.="  FACTURA_IMPORTE,    \n"; 
         $sql.="  REFERENCIA_PEDIDO)    \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssissdds", $nuevoId, $bean->getFacturaCabeceraId(), $bean->getCantidad(), $bean->getPiezaId(), 
           $bean->getObservacionesDet(), $bean->getPrecioUnitario(), $bean->getImporte(), $bean->getReferenciaPedido()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM FACTURAS_DETALLE   \n"; 
         $sql.="WHERE FACTURA_DETALLE_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE FACTURAS_DETALLE SET   \n"; 
         $sql.="  FACTURA_CABECERA_ID=?,     \n"; 
         $sql.="  CANTIDAD=?,     \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  OBSERVACIONES_DET=?,     \n"; 
         $sql.="  PRECIO_UNITARIO=?,     \n"; 
         $sql.="  FACTURA_IMPORTE=?,     \n"; 
         $sql.="  REFERENCIA_PEDIDO=?     \n"; 
         $sql.="WHERE FACTURA_DETALLE_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sissddss", $bean->getFacturaCabeceraId(), $bean->getCantidad(), $bean->getPiezaId(), $bean->getObservacionesDet(), 
           $bean->getPrecioUnitario(), $bean->getImporte(), $bean->getReferenciaPedido(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $facturaCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  FAD.FACTURA_DETALLE_ID,     \n"; 
         $sql.="  FAD.FACTURA_CABECERA_ID,     \n"; 
         $sql.="  FAD.CANTIDAD,     \n"; 
         $sql.="  FAD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  FAD.OBSERVACIONES_DET,     \n"; 
         $sql.="  FAD.PRECIO_UNITARIO,     \n"; 
         $sql.="  FAD.FACTURA_IMPORTE,    \n"; 
         $sql.="  FAD.REFERENCIA_PEDIDO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  FACTURAS_DETALLE FAD    \n"; 
         $sql.="  INNER JOIN FACTURAS_CABECERA FAC ON FAC.FACTURA_CABECERA_ID = FAD.FACTURA_CABECERA_ID    \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON FAD.PIEZA_ID = PIE.PIEZA_ID     \n"; 
         $sql.="WHERE       \n";
         $sql.="  1=1     \n";
         if (!empty($facturaCabId)){
           $sql.="  AND FAC.FACTURA_CABECERA_ID='" . $facturaCabId .  "'      \n";
         }          
         $sql.="ORDER BY  \n"; 
         $sql.="  FACTURA_DETALLE_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $facturaCabeceraId=null;  
         $cantidad=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $observacionesDet=null;  
         $precioUnitario=null;  
         $importe=null;  
         $referenciaPedido=null;  
         $stm->bind_result($id, $facturaCabeceraId, $cantidad, $piezaId, $piezaNombre, $observacionesDet, $precioUnitario, 
           $importe, $referenciaPedido); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new FacturaDetalle();  
            $bean->setId($id);
            $bean->setFacturaCabeceraId($facturaCabeceraId);
            $bean->setCantidad($cantidad);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setObservacionesDet($observacionesDet);
            $bean->setPrecioUnitario($precioUnitario);
            $bean->setImporte($importe);
            $bean->setReferenciaPedido($referenciaPedido);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }

      public function subtotal($facturaCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  SUM(FAD.FACTURA_IMPORTE)     \n"; 
         $sql.="FROM  \n"; 
         $sql.="  FACTURAS_DETALLE FAD    \n"; 
         $sql.="WHERE       \n";
         $sql.="  FAD.FACTURA_CABECERA_ID='" . $facturaCabId .  "'      \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $importe=null;  
         $stm->bind_result($importe); 
         $importe = null; 
         $stm->fetch(); 
         $this->cierra($conexion, $stm); 
         return $importe; 
      } 
      


      public function selTodosCuenta($facturaCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM FACTURAS_DETALLE FAC ";
         $sql.="WHERE       \n";
         $sql.="  1=1     \n";
         if (!empty($facturaCabId)){
           $sql.="  AND FAC.FACTURA_CABECERA_ID='" . $facturaCabId .  "'      \n";
         } 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 

   } 
?>