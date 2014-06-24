<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/InventarioAnualOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/InventarioAnual.php';  

   class InventarioAnualOadImpl extends AOD implements InventarioAnualOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_ANUAL_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  AÑO,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO_ANUAL  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  INVENTARIO_ANUAL_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new InventarioAnual();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $año=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $año, $cantidad); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setAño($año);
            $bean->setCantidad($cantidad);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO INVENTARIO_ANUAL (   \n"; 
         $sql.="  INVENTARIO_ANUAL_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  AÑO,     \n"; 
         $sql.="  CANTIDAD)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssid",$bean->getId(), $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getAño(), $bean->getCantidad()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM INVENTARIO_ANUAL   \n"; 
         $sql.="WHERE INVENTARIO_ANUAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function borraDesde($añoDesde){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM INVENTARIO_ANUAL   \n"; 
         $sql.="WHERE    \n"; 
         $sql.="  AÑO >= ?     \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("i", $añoDesde);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE INVENTARIO_ANUAL SET   \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  CLIENTE_ID=?,     \n"; 
         $sql.="  DEPOSITO_ID=?,     \n"; 
         $sql.="  AÑO=?,     \n"; 
         $sql.="  CANTIDAD=?     \n"; 
         $sql.="WHERE INVENTARIO_ANUAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssids", $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getAño(), $bean->getCantidad(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_ANUAL_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  AÑO,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO_ANUAL  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  INVENTARIO_ANUAL_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $año=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $año, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new InventarioAnual();  
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setAño($año);
            $bean->setCantidad($cantidad);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM INVENTARIO_ANUAL "; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function insertaOActualiza($depositoId, $clienteId, $piezaId, $año, $cantidad){
          $conexion=$this->conectarse(); 
          $id=$this->idUnico(); 
          $sql="INSERT INTO INVENTARIO_ANUAL (\n";
          $sql.=" INVENTARIO_ANUAL_ID, \n";
          $sql.=" DEPOSITO_ID, \n";
          $sql.=" CLIENTE_ID, \n";
          $sql.=" PIEZA_ID,  \n";
          $sql.=" AÑO,  \n";
          $sql.=" CANTIDAD  \n";
          $sql.=") VALUES (?, ?, ?, ?, ?, ?) \n";
          $sql.="ON DUPLICATE KEY UPDATE CANTIDAD=CANTIDAD+?  \n";
          $stm=$this->preparar($conexion, $sql);  
          $stm->bind_param("ssssidd", $id, $depositoId, $clienteId, $piezaId, $año, $cantidad, $cantidad);
          $stm->execute();
      }

   } 
?>