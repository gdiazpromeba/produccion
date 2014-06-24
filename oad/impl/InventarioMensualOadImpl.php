<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/InventarioMensualOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/InventarioMensual.php';  

   class InventarioMensualOadImpl extends AOD implements InventarioMensualOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_MENSUAL_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  AÑO,     \n"; 
         $sql.="  MES,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO_MENSUAL  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  INVENTARIO_MENSUAL_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new InventarioMensual();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $año=null;  
         $mes=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $año, $mes, $cantidad); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setAño($año);
            $bean->setMes($mes);
            $bean->setCantidad($cantidad);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO INVENTARIO_MENSUAL (   \n"; 
         $sql.="  INVENTARIO_MENSUAL_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  AÑO,     \n"; 
         $sql.="  MES,     \n"; 
         $sql.="  CANTIDAD)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssiid",$bean->getId(), $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getAño(), $bean->getMes(), $bean->getCantidad()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM INVENTARIO_MENSUAL   \n"; 
         $sql.="WHERE INVENTARIO_MENSUAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function borraDesde($añoDesde, $mesDesde){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM INVENTARIO_MENSUAL   \n"; 
         $sql.="WHERE    \n"; 
         $sql.="  AÑO > ?     \n"; 
         $sql.="  OR ( AÑO = ? AND MES>=?)  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("iii", $añoDesde, $añoDesde, $mesDesde);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE INVENTARIO_MENSUAL SET   \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  CLIENTE_ID=?,     \n"; 
         $sql.="  DEPOSITO_ID=?,     \n"; 
         $sql.="  AÑO=?,     \n"; 
         $sql.="  MES=?,     \n"; 
         $sql.="  CANTIDAD=?     \n"; 
         $sql.="WHERE INVENTARIO_MENSUAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssiids", $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getAño(), $bean->getMes(), $bean->getCantidad(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_MENSUAL_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  AÑO,     \n"; 
         $sql.="  MES,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO_MENSUAL  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  INVENTARIO_MENSUAL_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $año=null;  
         $mes=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $año, $mes, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new InventarioMensual();  
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setAño($año);
            $bean->setMes($mes);
            $bean->setCantidad($cantidad);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM INVENTARIO_MENSUAL "; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function insertaOActualiza($depositoId, $clienteId, $piezaId, $año, $mes, $cantidad){
          $conexion=$this->conectarse(); 
          $id=$this->idUnico(); 
          $sql="INSERT INTO INVENTARIO_MENSUAL (\n";
          $sql.=" INVENTARIO_MENSUAL_ID, \n";
          $sql.=" DEPOSITO_ID, \n";
          $sql.=" CLIENTE_ID, \n";
          $sql.=" PIEZA_ID,  \n";
          $sql.=" AÑO,  \n";
          $sql.=" MES,  \n";
          $sql.=" CANTIDAD  \n";
          $sql.=") VALUES (?, ?, ?, ?, ?, ?, ?) \n";
          $sql.="ON DUPLICATE KEY UPDATE CANTIDAD=CANTIDAD+?  \n";
          $stm=$this->preparar($conexion, $sql);  
          $stm->bind_param("ssssiidd", $id, $depositoId, $clienteId, $piezaId, $año, $mes, $cantidad, $cantidad);
          $stm->execute();
      }     

   } 
?>