<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/RemitosDetalleOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/RemitoDetalle.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/RemitoRelacionado.php';
//require_once('FirePHPCore/fb.php');

   class RemitosDetalleOadImpl extends AOD implements RemitosDetalleOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  RED.REMITO_DETALLE_ID,     \n"; 
         $sql.="  RED.REMITO_CABECERA_ID,     \n"; 
         $sql.="  RED.REMITO_ITEM_CANTIDAD,     \n"; 
         $sql.="  RED.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  RED.PEDIDO_DETALLE_ID     \n";
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_DETALLE RED \n";
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID   \n";
         $sql.="WHERE  \n"; 
         $sql.="  RED.REMITO_DETALLE_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new RemitoDetalle();  
         $id=null;  
         $cabeceraId=null;  
         $cantidad=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $pedidoDetalleId=null;
         $stm->bind_result($id, $cabeceraId, $cantidad, $piezaId, $piezaNombre, $pedidoDetalleId); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setCantidad($cantidad);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPedidoDetalleId($pedidoDetalleId);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO REMITOS_DETALLE (   \n"; 
         $sql.="  REMITO_DETALLE_ID,     \n"; 
         $sql.="  REMITO_CABECERA_ID,     \n"; 
         $sql.="  REMITO_ITEM_CANTIDAD,     \n"; 
         $sql.="  PIEZA_ID,     \n";
          $sql.=" PEDIDO_DETALLE_ID     \n";
         $sql.=" ) VALUES (?, ?, ?, ?, ? )    \n"; 
         $bean->setId($this->idUnico()); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssdss",$bean->getId(), $bean->getCabeceraId(), $bean->getCantidad(), $bean->getPiezaId(), $bean->getPedidoDetalleId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM REMITOS_DETALLE   \n"; 
         $sql.="WHERE REMITO_DETALLE_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE REMITOS_DETALLE SET   \n"; 
         $sql.="  REMITO_CABECERA_ID=?,     \n"; 
         $sql.="  REMITO_ITEM_CANTIDAD=?,     \n"; 
         $sql.="  PIEZA_ID=?,     \n";
         $sql.="  PEDIDO_DETALLE_ID=?     \n";
         $sql.="WHERE REMITO_DETALLE_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sdsss", $bean->getCabeceraId(), $bean->getCantidad(), $bean->getPiezaId(),   $bean->getPedidoDetalleId(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $remitoCabeceraId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  RED.REMITO_DETALLE_ID,     \n"; 
         $sql.="  RED.REMITO_CABECERA_ID,     \n"; 
         $sql.="  RED.REMITO_ITEM_CANTIDAD,     \n"; 
         $sql.="  RED.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  RED.PEDIDO_DETALLE_ID,     \n";
         $sql.="  PEC.PEDIDO_NUMERO     \n";
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_DETALLE  RED \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID  \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID  \n";
         $sql.="WHERE \n"; 
         $sql.="  RED.REMITO_CABECERA_ID='" . $remitoCabeceraId .  "'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  RED.REMITO_DETALLE_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $cabeceraId=null;  
         $cantidad=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $pedidoDetalleId=null;
         $pedidoNumero=null;
         $stm->bind_result($id, $cabeceraId, $cantidad, $piezaId, $piezaNombre, $pedidoDetalleId, $pedidoNumero); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new RemitoDetalle();  
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setCantidad($cantidad);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setPedidoDetalleId($pedidoDetalleId);
            $bean->setPedidoNumero($pedidoNumero);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      
      /**
       * devuelve un array con las piezas de los pedidos relacionados, y sus cantidades y precios,
       * para poder generar la factura automáticamente a partir del remito
       * @param unknown_type $remitoCabeceraId
       */
      public function selParaFacturas($remitoCabeceraId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  RED.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  RED.REMITO_ITEM_CANTIDAD,     \n";
         $sql.="  PED.PEDIDO_DETALLE_PRECIO,     \n";
         $sql.="  PEC.PEDIDO_CONTACTO     \n";
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_DETALLE  RED \n"; 
         $sql.="  INNER JOIN PIEZAS PIE ON RED.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="  INNER JOIN PEDIDOS_DETALLE PED ON RED.PEDIDO_DETALLE_ID=PED.PEDIDO_DETALLE_ID  \n";
         $sql.="  INNER JOIN PEDIDOS_CABECERA PEC ON PED.PEDIDO_CABECERA_ID=PEC.PEDIDO_CABECERA_ID  \n";
         $sql.="WHERE \n"; 
         $sql.="  RED.REMITO_CABECERA_ID='" . $remitoCabeceraId .  "'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  RED.REMITO_DETALLE_ID  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $piezaId=null;  
         $piezaNombre=null;  
         $cantidad=null;
         $precio=null;
         $referencia=null;
         $stm->bind_result($piezaId, $piezaNombre, $cantidad, $precio, $referencia); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
            $fila['piezaId']=$piezaId;
            $fila['piezaNombre']=$piezaNombre;
            $fila['cantidad']=$cantidad;
            $fila['precio']=$precio;
            $fila['referenciaPedido']=$referencia;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      


      public function selTodosCuenta($remitoCabeceraId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM REMITOS_DETALLE RED ";
         $sql.="WHERE \n"; 
         $sql.="  RED.REMITO_CABECERA_ID='" . $remitoCabeceraId .  "'  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selRemitosRelacionados($pedidoDetalleId){
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  REC.REMITO_NUMERO,     \n"; 
         $sql.="  REC.REMITO_FECHA,     \n";
         $sql.="  REC.REMITO_ESTADO,     \n";
         $sql.="  RED.REMITO_ITEM_CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  REMITOS_DETALLE  RED \n"; 
         $sql.="  INNER JOIN REMITOS_CABECERA REC ON REC.REMITO_CABECERA_ID=RED.REMITO_CABECERA_ID   \n";
         $sql.="WHERE \n"; 
         $sql.="  RED.PEDIDO_DETALLE_ID='" . $pedidoDetalleId .  "'  \n"; 
         $sql.="  AND REC.REMITO_ESTADO <>  'Anulado'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  REC.REMITO_NUMERO,  \n"; 
         $sql.="  REC.REMITO_FECHA  \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $numero=null;  
         $fecha=null;  
         $cantidad=null;  
         $estado=null;  
         $stm->bind_result($numero, $fecha, $estado, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new RemitoRelacionado();  
            $bean->setNumero($numero);
            $bean->setFechaLarga($fecha);
            $bean->setCantidad($cantidad);
            $bean->setEstado($estado);
            $filas[]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
        
      }

   } 
?>