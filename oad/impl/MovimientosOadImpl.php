<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/MovimientosOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Movimiento.php';  

   class MovimientosOadImpl extends AOD implements MovimientosOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MOVIMIENTO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD,     \n"; 
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  MOMENTO,     \n"; 
         $sql.="  COMENTARIOS    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  JORNAL  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  MOVIMIENTO_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Movimiento();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $cantidad=null;  
         $usuarioId=null;  
         $momento=null;  
         $comentarios=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $cantidad, $usuarioId, $momento, $comentarios); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setCantidad($cantidad);
            $bean->setUsuarioId($usuarioId);
            $bean->setMomento($momento);
            $bean->setComentarios($comentarios);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO JORNAL (   \n"; 
         $sql.="  MOVIMIENTO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD,     \n"; 
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  MOMENTO,     \n"; 
         $sql.="  COMENTARIOS)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssdsss",$bean->getId(), $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getCantidad(), $bean->getUsuarioId(), $bean->getMomento(), $bean->getComentarios()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM JORNAL   \n"; 
         $sql.="WHERE MOVIMIENTO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function borraDesde($momentoDesde){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM JORNAL   \n"; 
         $sql.="WHERE MOMENTO>=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $momentoDesde);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE JORNAL SET   \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  CLIENTE_ID=?,     \n"; 
         $sql.="  DEPOSITO_ID=?,     \n"; 
         $sql.="  CANTIDAD=?,     \n"; 
         $sql.="  USUARIO_ID=?,     \n"; 
         $sql.="  MOMENTO=?,     \n"; 
         $sql.="  COMENTARIOS=?     \n"; 
         $sql.="WHERE MOVIMIENTO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssdssss", $bean->getPiezaId(), $bean->getClienteId(), $bean->getDepositoId(), $bean->getCantidad(), $bean->getUsuarioId(), $bean->getMomento(), $bean->getComentarios(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selecciona($momentoDesde){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MOVIMIENTO_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CLIENTE_ID,     \n"; 
         $sql.="  DEPOSITO_ID,     \n"; 
         $sql.="  CANTIDAD,     \n"; 
         $sql.="  USUARIO_ID,     \n"; 
         $sql.="  MOMENTO,     \n"; 
         $sql.="  COMENTARIOS    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  JORNAL  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  MOMENTO >='" . $momentoDesde .  "' \n";
		 $sql.="ORDER BY  \n";          
         $sql.="  MOMENTO  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $piezaId=null;  
         $clienteId=null;  
         $depositoId=null;  
         $cantidad=null;  
         $usuarioId=null;  
         $momento=null;  
         $comentarios=null;  
         $stm->bind_result($id, $piezaId, $clienteId, $depositoId, $cantidad, $usuarioId, $momento, $comentarios); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Movimiento();  
            $bean->setId($id);
            $bean->setPiezaId($piezaId);
            $bean->setClienteId($clienteId);
            $bean->setDepositoId($depositoId);
            $bean->setCantidad($cantidad);
            $bean->setUsuarioId($usuarioId);
            $bean->setMomento($momento);
            $bean->setComentarios($comentarios);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function seleccionaCuenta($momentoDesde){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM JORNAL  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  MOMENTO >='" . $momentoDesde .  "' \n";
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