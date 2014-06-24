<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanProdChapDetOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdChapDet.php';  

   class PlanProdChapDetOadImpl extends AOD implements PlanProdChapDetOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PLPR_CHAPA_DET_ID,     \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  PLPR_CHAPA_PAQUETES,     \n"; 
         $sql.="  TERMINACION,     \n"; 
         $sql.="  LARGO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_CHAP_DET  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  PLPR_CHAPA_DET_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PlanProdChapDet();  
         $id=null;  
         $plrpChapaCabId=null;  
         $paquetes=null;  
         $terminacion=null;  
         $largo=null;  
         $stm->bind_result($id, $plrpChapaCabId, $paquetes, $terminacion, $largo); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPlrpChapaCabId($plrpChapaCabId);
            $bean->setPaquetes($paquetes);
            $bean->setTerminacion($terminacion);
            $bean->setLargo($largo);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PLPR_CHAP_DET (   \n"; 
         $sql.="  PLPR_CHAPA_DET_ID,     \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  PLPR_CHAPA_PAQUETES,     \n"; 
         $sql.="  TERMINACION,     \n"; 
         $sql.="  LARGO)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssd",$bean->getId(), $bean->getPlrpChapaCabId(), $bean->getPaquetes(), $bean->getTerminacion(), $bean->getLargo()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PLPR_CHAP_DET   \n"; 
         $sql.="WHERE PLPR_CHAPA_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PLPR_CHAP_DET SET   \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID=?,     \n"; 
         $sql.="  PLPR_CHAPA_PAQUETES=?,     \n"; 
         $sql.="  TERMINACION=?,     \n"; 
         $sql.="  LARGO=?     \n"; 
         $sql.="WHERE PLPR_CHAPA_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssds", $bean->getPlrpChapaCabId(), $bean->getPaquetes(), $bean->getTerminacion(), $bean->getLargo(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PLPR_CHAPA_DET_ID,     \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  PLPR_CHAPA_PAQUETES,     \n"; 
         $sql.="  TERMINACION,     \n"; 
         $sql.="  LARGO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_CHAP_DET  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PLPR_CHAPA_DET_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $plrpChapaCabId=null;  
         $paquetes=null;  
         $terminacion=null;  
         $largo=null;  
         $stm->bind_result($id, $plrpChapaCabId, $paquetes, $terminacion, $largo); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanProdChapDet();  
            $bean->setId($id);
            $bean->setPlrpChapaCabId($plrpChapaCabId);
            $bean->setPaquetes($paquetes);
            $bean->setTerminacion($terminacion);
            $bean->setLargo($largo);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PLPR_CHAP_DET "; 
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