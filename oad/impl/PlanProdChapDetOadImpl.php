<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanProdChapDetOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdChapDet.php';  
//require_once('FirePHPCore/fb.php');  

   class PlanProdChapDetOadImpl extends AOD implements PlanProdChapDetOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CHD.PLPR_CHAPA_DET_ID,     \n"; 
         $sql.="  CHD.PLPR_CHAPA_CAB_ID,     \n";
		 $sql.="  CHD.ANCHO,    \n";
         $sql.="  CHD.LARGO,    \n";
         $sql.="  CHD.UNIDADES,     \n";
         $sql.="  CHD.TERMINACION,     \n"; 
         $sql.="  CHD.CRUZADA    \n";
         $sql.="FROM  \n"; 
         $sql.="  PLPR_CHAPA_DET  CHD  \n";
         $sql.="WHERE  \n"; 
         $sql.="  CHD.PLPR_CHAPA_DET_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PlanProdChapDet();  
         $id=null;  
         $plrpChapaCabId=null;
         $ancho=null; $largo=null; $unidades=null;
         $terminacion=null;
         $largo=null;  
         $cruzada=null;
         $stm->bind_result($id, $plrpChapaCabId, $ancho, $largo, $unidades, $terminacion, $cruzada); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPlPrChapCabId($plrpChapaCabId);
            $bean->setAncho($ancho);
            $bean->setLargo($largo);
            $bean->setUnidades($unidades);
            $bean->setTerminacion($terminacion);
            $bean->setCruzada($cruzada);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PLPR_CHAPA_DET (   \n"; 
         $sql.="  PLPR_CHAPA_DET_ID,     \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  ANCHO,     \n";
         $sql.="  LARGO,     \n";
         $sql.="  UNIDADES,     \n";
         $sql.="  TERMINACION,     \n";
         $sql.="  CRUZADA)     \n";
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssiissd",$bean->getId(), $bean->getPlPrChapCabId(), $bean->getAncho(), $bean->getLargo(), $bean->getUnidades(), $bean->getTerminacion(), $bean->getCruzada()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PLPR_CHAPA_DET   \n"; 
         $sql.="WHERE PLPR_CHAPA_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PLPR_CHAPA_DET SET   \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID=?,     \n"; 
         $sql.="  ANCHO=?,     \n";
         $sql.="  LARGO=?,     \n";
         $sql.="  UNIDADES=?,     \n";
         $sql.="  TERMINACION=?,     \n";
         $sql.="  CRUZADA=?     \n";
         $sql.="WHERE PLPR_CHAPA_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("siiisds", $bean->getPlPrChapCabId(), $bean->getAncho(), $bean->getLargo(), $bean->getUnidades(), $bean->getTerminacion(), $bean->getCruzada(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $plprChapCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CHD.PLPR_CHAPA_DET_ID,     \n"; 
         $sql.="  CHD.PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  CHD.ANCHO,     \n";
         $sql.="  CHD.LARGO,     \n";
         $sql.="  CHD.UNIDADES,     \n";
         $sql.="  CHD.TERMINACION,     \n"; 
         $sql.="  CHD.CRUZADA    \n";
         $sql.="FROM  \n"; 
         $sql.="  PLPR_CHAPA_DET  CHD  \n";
         $sql.="WHERE  \n"; 
         $sql.="  CHD.PLPR_CHAPA_CAB_ID='" . $plprChapCabId  .   "'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  CHD.TERMINACION  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $plrpChapaCabId=null;  
         $ancho=null;
         $largo=null;
         $unidades=null;
         $terminacion=null;
         $cruzada=null;
         $stm->bind_result($id, $plrpChapaCabId, $ancho, $largo, $unidades, $terminacion, $cruzada); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanProdChapDet();  
            $bean->setId($id);
            $bean->setPlPrChapCabId($plrpChapaCabId);
            $bean->setAncho($ancho);
            $bean->setLargo($largo);
            $bean->setUnidades($unidades);
            $bean->setTerminacion($terminacion);
            $bean->setCruzada($cruzada);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }
      
      public function selTodosCuenta($plprChapCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PLPR_CHAPA_DET "; 
         $sql.="WHERE  \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID='" . $plprChapCabId  .   "'  \n"; 
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