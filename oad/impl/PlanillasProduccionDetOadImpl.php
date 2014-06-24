<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanillasProduccionDetOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanillaProduccionDet.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdPrensaPlano.php';
//require_once('FirePHPCore/fb.php');  

   class PlanillasProduccionDetOadImpl extends AOD implements PlanillasProduccionDetOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_DET_ID,     \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  PPD.MATRIZ_ID,     \n"; 
         $sql.="  MAT.MATRIZ_NOMBRE,     \n";
         $sql.="  PPD.CANTIDAD,     \n";
         $sql.="  PPD.ESPESOR,     \n";
         $sql.="  PPD.TERMINACION,     \n";
         $sql.="  PPD.REPARADA,     \n";
         $sql.="  PPD.DESCARTADA,     \n";
         $sql.="  PPD.ESTACION_TRABAJO,     \n"; 
         $sql.="  PPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLAN_PROD_PRENSA_DET PPD  \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_DET_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PlanillaProduccionDet();  
         $id=null;  
         $planProdCabId=null;  
         $matrizId=null;  
         $matrizNombre=null;
         $cantidad=null;  
         $espesor=null;  
         $terminacion=null;
         $reparada=null;
         $descartada=null;
         $estacionTrabajo=null;  
         $observaciones=null;  
         $stm->bind_result($id, $planProdCabId, $matrizId, $matrizNombre, $cantidad, $espesor, $terminacion, $reparada, $descartada, $estacionTrabajo, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setPlanProdCabId($planProdCabId);
            $bean->setMatrizId($matrizId);
            $bean->setMatrizNombre($matrizNombre);
            $bean->setCantidad($cantidad);
            $bean->setEspesor($espesor);
            $bean->setTerminacion($terminacion);
            $bean->setReparada($reparada);
            $bean->setDescartada($descartada);
            $bean->setEstacionTrabajo($estacionTrabajo);
            $bean->setObservacionesDet($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PLAN_PROD_PRENSA_DET (   \n"; 
         $sql.="  PLAN_PROD_PRENSA_DET_ID,     \n"; 
         $sql.="  PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  MATRIZ_ID,     \n";
         $sql.="  CANTIDAD,     \n"; 
         $sql.="  ESPESOR,     \n";
         $sql.="  TERMINACION,     \n";
         $sql.="  REPARADA,     \n";
         $sql.="  DESCARTADA,     \n";
         $sql.="  ESTACION_TRABAJO,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssidsiiss",$bean->getId(), $bean->getPlanProdCabId(), $bean->getMatrizId(), $bean->getCantidad(), $bean->getEspesor(), $bean->getTerminacion(), $bean->isReparada(), $bean->isDescartada(), $bean->getEstacionTrabajo(), $bean->getObservacionesDet()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PLAN_PROD_PRENSA_DET   \n"; 
         $sql.="WHERE PLAN_PROD_PRENSA_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse();
         
         
         $sql="UPDATE PLAN_PROD_PRENSA_DET SET   \n"; 
         $sql.="  PLAN_PROD_PRENSA_CAB_ID=?,     \n"; 
         $sql.="  MATRIZ_ID=?,     \n"; 
         $sql.="  CANTIDAD=?,     \n"; 
         $sql.="  ESPESOR=?,     \n"; 
         $sql.="  TERMINACION=?,     \n";
         $sql.="  REPARADA=?,     \n";
         $sql.="  DESCARTADA=?,     \n";
         $sql.="  ESTACION_TRABAJO=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE PLAN_PROD_PRENSA_DET_ID=?   \n";
         
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssiisiisss", $bean->getPlanProdCabId(), $bean->getMatrizId(), $bean->getCantidad(), $bean->getEspesor(), 
           $bean->getTerminacion(), $bean->isReparada(), $bean->isDescartada(), $bean->getEstacionTrabajo(), $bean->getObservacionesDet(), $bean->getId());         
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $planProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_DET_ID,     \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  PPD.MATRIZ_ID,     \n"; 
         $sql.="  MAT.MATRIZ_NOMBRE,     \n";
         $sql.="  PPD.CANTIDAD,     \n";
         $sql.="  PPD.ESPESOR,     \n"; 
         $sql.="  PPD.TERMINACION,     \n";
         $sql.="  PPD.REPARADA,     \n";
         $sql.="  PPD.DESCARTADA,     \n";
         $sql.="  PPD.ESTACION_TRABAJO,     \n"; 
         $sql.="  PPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLAN_PROD_PRENSA_DET PPD  \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID  \n";         
         $sql.="WHERE   \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_CAB_ID='" . $planProdCabId . "'  \n";
         $sql.="ORDER BY   \n";
         $sql.="  MAT.MATRIZ_NOMBRE   \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $planProdCabId=null;  
         $matrizId=null;  
         $matrizNombre=null;  
         $cantidad=null;
         $espesor=null;
         $terminacion=null;
         $reparada=null;
         $descartada=null;
         $estacionTrabajo=null;  
         $observaciones=null;  
         $stm->bind_result($id, $planProdCabId, $matrizId, $matrizNombre, $cantidad, $espesor, $terminacion, $reparada, $descartada, $estacionTrabajo, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanillaProduccionDet();  
            $bean->setId($id);
            $bean->setPlanProdCabId($planProdCabId);
            $bean->setMatrizId($matrizId);
            $bean->setMatrizNombre($matrizNombre);
            $bean->setCantidad($cantidad);
            $bean->setEspesor($espesor);
            $bean->setTerminacion($terminacion);
            $bean->setReparada($reparada);
            $bean->setDescartada($descartada);
            $bean->setEstacionTrabajo($estacionTrabajo);
            $bean->setObservacionesDet($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      

      public function selTodosCuenta($planProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PLAN_PROD_PRENSA_DET ";
         $sql.="WHERE   \n"; 
         $sql.="  PLAN_PROD_PRENSA_CAB_ID='" . $planProdCabId . "'  \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }
      
      public function selTodosPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizNombre){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPC.EMPLEADO_ID,     \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n";
         $sql.="  PPC.PLAN_PROD_FECHA,     \n";
         $sql.="  PPD.PLAN_PROD_PRENSA_DET_ID,     \n"; 
         $sql.="  PPD.PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  PPD.MATRIZ_ID,     \n"; 
         $sql.="  MAT.MATRIZ_NOMBRE,     \n";
         $sql.="  PPD.CANTIDAD,     \n";
         $sql.="  PPD.ESPESOR,     \n"; 
         $sql.="  PPD.TERMINACION,     \n";
         $sql.="  PPD.REPARADA,     \n";
         $sql.="  PPD.DESCARTADA,     \n";
         $sql.="  PPD.ESTACION_TRABAJO,     \n"; 
         $sql.="  PPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLAN_PROD_PRENSA_DET PPD  \n";
         $sql.="  INNER JOIN PLAN_PROD_PRENSA_CAB PPC ON PPD.PLAN_PROD_PRENSA_CAB_ID=PPC.PLAN_PROD_PRENSA_CAB_ID \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID  \n";         
         $sql.="WHERE   1=1 \n";
         if (!empty($empleadoId)){
           $sql.="  PPC.EMPLEADO_ID='" . $empleadoId . "'  \n";  
         } 
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }          
         if ($matrizNombre!=null){
         	$sql.="  AND UPPER(MAT.MATRIZ_NOMBRE) LIKE '%" . mb_strtoupper($matrizNombre, 'utf-8')   . "%'  \n"; 
         }
         $sql.="ORDER BY   \n";
         $sql.="  PPC.PLAN_PROD_FECHA DESC   \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $empleadoId=null; $empleadoApellido=null; $empleadoNombre=null;
         $planProdFecha=null;
         $planProdCabId=null;  
         $matrizId=null;  
         $matrizNombre=null;  
         $cantidad=null;
         $espesor=null;
         $terminacion=null;
         $reparada=null;
         $descartada=null;
         $estacionTrabajo=null;  
         $observaciones=null;  
         $stm->bind_result($id, $empleadoId, $empleadoApellido, $empleadoNombre, $planProdFecha, $planProdCabId, $matrizId, $matrizNombre, $cantidad, $espesor, $terminacion, $reparada, $descartada, $estacionTrabajo, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanProdPrensaPlano();  
            $bean->setId($id);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setFechaLarga($planProdFecha);
            $bean->setPlanProdCabId($planProdCabId);
            $bean->setMatrizId($matrizId);
            $bean->setMatrizNombre($matrizNombre);
            $bean->setCantidad($cantidad);
            $bean->setEspesor($espesor);
            $bean->setTerminacion($terminacion);
            $bean->setReparada($reparada);
            $bean->setDescartada($descartada);
            $bean->setEstacionTrabajo($estacionTrabajo);
            $bean->setObservacionesDet($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }
      
      public function selTodosPlanoCuenta($empleadoId, $fechaDesde, $fechaHasta, $matrizNombre){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  COUNT(*) \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLAN_PROD_PRENSA_DET PPD  \n";
         $sql.="  INNER JOIN PLAN_PROD_PRENSA_CAB PPC ON PPD.PLAN_PROD_PRENSA_CAB_ID=PPC.PLAN_PROD_PRENSA_CAB_ID \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID  \n";         
         $sql.="WHERE   1=1 \n";
         if (!empty($empleadoId)){
           $sql.="  PPC.EMPLEADO_ID='" . $empleadoId . "'  \n";  
         } 
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >='" .  FechaUtils::dateTimeACadena($fechaDesde) .   "' \n";
         }
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <='" .  FechaUtils::dateTimeACadena($fechaHasta) .   "' \n";
         }          
         if ($matrizNombre!=null){
         	$sql.="  AND UPPER(MAT.MATRIZ_NOMBRE) LIKE '%" . mb_strtoupper($matrizNombre, 'utf-8')   . "%'  \n"; 
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