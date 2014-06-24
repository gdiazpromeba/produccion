<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/InventarioOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Inventario.php';  

   class InventarioOadImpl extends AOD implements InventarioOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  INVENTARIO_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Inventario();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $cantidad); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setCantidad($cantidad);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO INVENTARIO (   \n"; 
         $sql.="  INVENTARIO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssd",$bean->getId(), $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getCantidad()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM INVENTARIO   \n"; 
         $sql.="WHERE INVENTARIO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function borraTodo(){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM INVENTARIO   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE INVENTARIO SET   \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  CLIENTE_ID=?,     \n"; 
         $sql.="  DEPOSITO_ID=?,     \n"; 
         $sql.="  CANTIDAD=?     \n"; 
         $sql.="WHERE INVENTARIO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssds", $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getCantidad(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 



      
      
      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  DEPOSITO_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Inventario();  
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setCantidad($cantidad);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM INVENTARIO "; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }       
      
      public function selTodosPorParams($desde, $cuantos, $clienteId, $depositoId, $piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INVENTARIO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  1=1  \n"; 
         if ($clienteId!=null){
         	$sql.="  AND CLIENTE_ID='" . $clienteId . "'   \n"; 
         }
         if ($depositoId!=null){
         	$sql.="  AND DEPOSITO_ID='" . $depositoId . "'   \n"; 
         }
         if ($piezaId!=null){
         	$sql.="  AND PIEZA_ID='" . $clienteId . "'   \n"; 
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  DEPOSITO_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $cantidad=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Inventario();  
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setCantidad($cantidad);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selTodosPorParamsCuenta($clienteId, $depositoId, $piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM INVENTARIO "; 
         $sql.="WHERE  \n"; 
         $sql.="  1=1  \n"; 
         if ($clienteId!=null){
         	$sql.="  AND CLIENTE_ID='" . $clienteId . "'   \n"; 
         }
         if ($depositoId!=null){
         	$sql.="  AND DEPOSITO_ID='" . $depositoId . "'   \n"; 
         }
         if ($piezaId!=null){
         	$sql.="  AND PIEZA_ID='" . $clienteId . "'   \n"; 
         }         
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }             
      
      public function selTodosSinCliente($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INV.PIEZA_ID,     \n"; 
         $sql.="  INV.DEPOSITO_ID,     \n"; 
         $sql.="  SUM(INV.CANTIDAD)    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO INV  \n"; 
         $sql.="  INNER JOIN PIEZAS PIE  ON INV.PIEZA_ID=PIE.PIEZA_ID \n"; 
         $sql.="GROUP BY  \n"; 
         $sql.="  INV.PIEZA_ID,  \n"; 
         $sql.="  INV.DEPOSITO_ID  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PIE.PIEZA_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $piezaId=null;  
         $depositoId=null;  
         $cantidad=null;  
         $stm->bind_result($piezaId, $depositoId, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Inventario();  
            $bean->setId(null);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId(null);
            $bean->setDepositoId($depositoId);
            $bean->setCantidad($cantidad);
            $filas[$piezaId]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selTodosSinClienteCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(DISTINCT DEPOSITO_ID, PIEZA_ID) FROM INVENTARIO "; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }       
      
      public function selTodosSinDeposito($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  INV.PIEZA_ID,     \n"; 
         $sql.="  INV.CLIENTE_ID,     \n"; 
         $sql.="  SUM(INV.CANTIDAD)    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  INVENTARIO INV  \n"; 
         $sql.="  INNER JOIN PIEZAS PIE  ON INV.PIEZA_ID=PIE.PIEZA_ID \n"; 
         $sql.="GROUP BY  \n"; 
         $sql.="  INV.PIEZA_ID,  \n"; 
         $sql.="  INV.CLIENTE_ID  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PIE.PIEZA_NOMBRE  \n";          
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $piezaId=null;  
         $clienteId=null;  
         $cantidad=null;  
         $stm->bind_result($piezaId, $clienteId, $cantidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Inventario();  
            $bean->setId(null);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId(null);
            $bean->setCantidad($cantidad);
            $filas[$piezaId]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selTodosSinDepositoCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(DISTINCT CLIENTE_ID, PIEZA_ID) FROM INVENTARIO "; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }                   

     
       public function insertaOActualiza($depositoId, $clienteId, $piezaId, $cantidad){
          $conexion=$this->conectarse(); 
          $id=$this->idUnico(); 
          $sql="INSERT INTO INVENTARIO (\n";
          $sql.=" INVENTARIO_ID, \n";
          $sql.=" DEPOSITO_ID, \n";
          $sql.=" CLIENTE_ID, \n";
          $sql.=" PIEZA_ID,  \n";
          $sql.=" CANTIDAD  \n";
          $sql.=") VALUES (?, ?, ?, ?, ?) \n";
          $sql.="ON DUPLICATE KEY UPDATE CANTIDAD=CANTIDAD+?  \n";
          $stm=$this->preparar($conexion, $sql);  
          $stm->bind_param("ssssdd", $id, $depositoId, $clienteId, $piezaId, $cantidad, $cantidad);
          $stm->execute();
      }

   } 
?>