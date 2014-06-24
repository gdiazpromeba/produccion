<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanillasProduccionCabOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanillaProduccionCab.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdPrensaPlano.php';
//require_once('FirePHPCore/fb.php');

   class PlanillasProduccionCabOadImpl extends AOD implements PlanillasProduccionCabOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPC.PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  PPC.PLAN_PROD_FECHA,     \n"; 
         $sql.="  PPC.EMPLEADO_ID,     \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n"; 
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n"; 
         $sql.="  EMP.TARJETA_NUMERO,     \n";
         $sql.="  PPC.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLAN_PROD_PRENSA_CAB  PPC  \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPC.PLAN_PROD_PRENSA_CAB_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PlanillaProduccionCab();  
         $id=null;  
         $fecha=null;  
         $empleadoId=null;  
         $empleadoApellido=null;  
         $empleadoNombre=null;  
         $tarjetaNumero=null;
         $observaciones=null;  
         $stm->bind_result($id, $fecha, $empleadoId, $empleadoApellido, $empleadoNombre, $tarjetaNumero, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setFechaLarga($fecha);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setTarjetaNumero($tarjetaNumero);
            $bean->setObservacionesCab($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PLAN_PROD_PRENSA_CAB (   \n"; 
         $sql.="  PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  PLAN_PROD_FECHA,     \n"; 
         $sql.="  EMPLEADO_ID,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssss",$bean->getId(), $bean->getFechaLarga(), $bean->getEmpleadoId(), $bean->getObservacionesCab()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PLAN_PROD_PRENSA_CAB   \n"; 
         $sql.="WHERE PLAN_PROD_PRENSA_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PLAN_PROD_PRENSA_CAB SET   \n"; 
         $sql.="  PLAN_PROD_FECHA=?,     \n"; 
         $sql.="  EMPLEADO_ID=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE PLAN_PROD_PRENSA_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssss", $bean->getFechaLarga(), $bean->getEmpleadoId(), $bean->getObservacionesCab(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPC.PLAN_PROD_PRENSA_CAB_ID,     \n"; 
         $sql.="  PPC.PLAN_PROD_FECHA,     \n"; 
         $sql.="  PPC.EMPLEADO_ID,     \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n"; 
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n"; 
         $sql.="  EMP.TARJETA_NUMERO,     \n";
         $sql.="  PPC.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLAN_PROD_PRENSA_CAB  PPC  \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID  \n";         
         $sql.="WHERE 1=1  \n";
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $sql.="ORDER BY  \n"; 
         $sql.="  PPC.PLAN_PROD_FECHA  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $fecha=null;  
         $empleadoId=null;  
         $empleadoApellido=null;  
         $empleadoNombre=null;  
         $tarjetaNumero=null;
         $observaciones=null;  
         $stm->bind_result($id, $fecha, $empleadoId, $empleadoApellido, $empleadoNombre, $tarjetaNumero, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanillaProduccionCab();  
            $bean->setId($id);
            $bean->setFechaLarga($fecha);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setTarjetaNumero($tarjetaNumero);
            $bean->setObservacionesCab($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selPlano($desde, $cuantos, $empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada){ 
         $conexion=$this->conectarse();
         $sql="SELECT  \n";
		 $sql.="PPC.PLAN_PROD_FECHA,  \n";
  		 $sql.="  PPC.EMPLEADO_ID,  \n";
  		 $sql.="  EMP.EMPLEADO_APELLIDO,  \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,  \n";
         $sql.="  MAT.MATRIZ_NOMBRE,  \n";
         $sql.="  MAT.MATRIZ_TIPO,  \n";
         $sql.="  PPD.ESTACION_TRABAJO,  \n";
         $sql.="  PPD.CANTIDAD,  \n";
         $sql.="  PPD.REPARADA,  \n";
         $sql.="  PPD.DESCARTADA,  \n";
         $sql.="  PPD.ESPESOR,  \n";
         $sql.="  PPD.TERMINACION,  \n";
         $sql.="  PPD.OBSERVACIONES  \n";
         $sql.="FROM  \n";
         $sql.="  PLAN_PROD_PRENSA_CAB PPC  \n";
         $sql.="  INNER JOIN PLAN_PROD_PRENSA_DET PPD ON PPD.PLAN_PROD_PRENSA_CAB_ID=PPC.PLAN_PROD_PRENSA_CAB_ID   \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID   \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID   \n";
         $sql.="WHERE 1=1  \n";
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($estacionTrabajo)){
         	$sql.="  AND PPD.ESTACION_TRABAJO='" .$estacionTrabajo. "' \n";
         }            
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }
         if (!empty($matrizId)){
         	$sql.="  AND PPD.MATRIZ_ID = '" . $matrizId . "' \n";
         }
         if (!empty($matrizTipo)){
         	$sql.="  AND MAT.MATRIZ_TIPO = '" . $matrizTipo . "' \n";
         }
		 $sql.="  AND PPD.REPARADA = " . $reparada . " \n";
         $sql.="  AND PPD.DESCARTADA = " . $descartada . " \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  PPC.PLAN_PROD_FECHA  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $fecha=null;  
         $empleadoId=null;  
         $empleadoApellido=null;  
         $empleadoNombre=null;  
         $matrizNombre=null;
         $matrizTipo=null;
         $estacionTrabajo=null;
         $cantidad=null;
         $reparada=null;
         $descartada=null;
         $espesor=null;
         $terminacion=null;
         $observaciones=null;
         $stm->bind_result($fecha, $empleadoId, $empleadoApellido, $empleadoNombre, $matrizNombre, $matrizTipo,  
           $estacionTrabajo, $cantidad, $reparada, $descartada, $espesor, $terminacion, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanProdPrensaPlano();  
            $bean->setFechaLarga($fecha);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setMatrizId($matrizId);
            $bean->setMatrizNombre($matrizNombre);
            $bean->setMatrizTipo($matrizTipo);
            $bean->setEstacionTrabajo($estacionTrabajo);
            $bean->setCantidad($cantidad);
            $bean->setReparada($reparada);
            $bean->setDescartada($descartada);
            $bean->setEspesor($espesor);
            $bean->setTerminacion($terminacion);
            $bean->setObservacionesDet($observaciones);
            $filas[]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      


      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PLAN_PROD_PRENSA_CAB PPC ";
         $sql.="WHERE 1=1  \n";         
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selPlanoCuenta($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*)  ";
         $sql.="FROM  \n";
         $sql.="  PLAN_PROD_PRENSA_CAB PPC  \n";
         $sql.="  INNER JOIN PLAN_PROD_PRENSA_DET PPD ON PPD.PLAN_PROD_PRENSA_CAB_ID=PPC.PLAN_PROD_PRENSA_CAB_ID   \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID   \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID   \n";         
         $sql.="WHERE 1=1  \n";
         if (!empty($estacionTrabajo)){
         	$sql.="  AND PPD.ESTACION_TRABAJO='" .$estacionTrabajo. "' \n";
         }         
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }
         if (!empty($matrizId)){
         	$sql.="  AND PPD.MATRIZ_ID = '" . $matrizId . "' \n";
         }
         if (!empty($matrizTipo)){
         	$sql.="  AND MAT.MATRIZ_TIPO = '" . $matrizTipo . "' \n";
         }      
         $sql.="  AND PPD.REPARADA = " . $reparada . " \n";
         $sql.="  AND PPD.DESCARTADA = " . $descartada . " \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }  
      
      public function selPlanoCantidad($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT SUM(PPD.CANTIDAD) AS CANTIDAD  ";
         $sql.="FROM  \n";
         $sql.="  PLAN_PROD_PRENSA_CAB PPC  \n";
         $sql.="  INNER JOIN PLAN_PROD_PRENSA_DET PPD ON PPD.PLAN_PROD_PRENSA_CAB_ID=PPC.PLAN_PROD_PRENSA_CAB_ID   \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID   \n";
         $sql.="  INNER JOIN MATRICES MAT ON PPD.MATRIZ_ID=MAT.MATRIZ_ID   \n";         
         $sql.="WHERE 1=1  \n";
         if (!empty($estacionTrabajo)){
         	$sql.="  AND PPD.ESTACION_TRABAJO='" .$estacionTrabajo. "' \n";
         }         
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLAN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }
         if (!empty($matrizId)){
         	$sql.="  AND PPD.MATRIZ_ID = '" . $matrizId . "' \n";
         }
         if (!empty($matrizTipo)){
         	$sql.="  AND MAT.MATRIZ_TIPO = '" . $matrizTipo . "' \n";
         }      
         $sql.="  AND PPD.REPARADA = " . $reparada . " \n";
         $sql.="  AND PPD.DESCARTADA = " . $descartada . " \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cantidad=null; 
         $stm->bind_result($cantidad); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cantidad; 
      }       
           

   } 
?>