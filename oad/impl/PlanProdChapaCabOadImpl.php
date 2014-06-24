<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanProdChapaCabOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdChapa.php';  

   class PlanProdChapaCabOadImpl extends AOD implements PlanProdChapaCabOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPCH.PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  PPCH.EMPLEADO_ID,     \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n"; 
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n"; 
         $sql.="  PPCH.PLPR_CHAPA_FECHA,     \n"; 
         $sql.="  PPCH.PLPR_CHAPA_OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_CHAPA_CAB  PPCH \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPCH.EMPLEADO_ID=EMP.EMPLEADO_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPCH.PLPR_CHAPA_CAB_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PlanProdChapa();  
         $id=null;  
         $empleadoId=null;  
         $empleadoApellido=null;  
         $empleadoNombre=null;  
         $fecha=null;  
         $observaciones=null;  
         $stm->bind_result($id, $empleadoId, $empleadoApellido, $empleadoNombre, $fecha, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setFechaLarga($fecha);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PLPR_CHAPA_CAB (   \n"; 
         $sql.="  PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  EMPLEADO_ID,     \n"; 
         $sql.="  PLPR_CHAPA_FECHA,     \n"; 
         $sql.="  PLPR_CHAPA_OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssss",$bean->getId(), $bean->getEmpleadoId(), $bean->getFechaLarga(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PLPR_CHAPA_CAB   \n"; 
         $sql.="WHERE PLPR_CHAPA_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PLPR_CHAPA_CAB SET   \n"; 
         $sql.="  EMPLEADO_ID=?,     \n"; 
         $sql.="  PLPR_CHAPA_FECHA=?,     \n"; 
         $sql.="  PLPR_CHAPA_OBSERVACIONES=?     \n"; 
         $sql.="WHERE PLPR_CHAPA_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssss", $bean->getEmpleadoId(), $bean->getFechaLarga(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPCH.PLPR_CHAPA_CAB_ID,     \n"; 
         $sql.="  PPCH.EMPLEADO_ID,     \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n"; 
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n"; 
         $sql.="  PPCH.PLPR_CHAPA_FECHA,     \n"; 
         $sql.="  PPCH.PLPR_CHAPA_OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_CHAPA_CAB  PPCH \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPCH.EMPLEADO_ID=EMP.EMPLEADO_ID \n";
         $sql.="WHERE 1=1  \n";
         if (!empty($empleadoId)){
         	$sql.="  AND PPCH.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPCH.PLPR_CHAPA_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPCH.PLPR_CHAPA_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $sql.="ORDER BY  \n"; 
         $sql.="  PPCH.PLPR_CHAPA_FECHA DESC,  \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,  \n";
         $sql.="  EMP.EMPLEADO_NOMBRE  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $empleadoId=null;  
         $empleadoApellido=null;  
         $empleadoNombre=null;  
         $fecha=null;  
         $observaciones=null;  
         $stm->bind_result($id, $empleadoId, $empleadoApellido, $empleadoNombre, $fecha, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PlanProdChapa();  
            $bean->setId($id);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setFechaLarga($fecha);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta){
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PLPR_CHAPA_CAB PPCH \n"; 
         $sql.="WHERE 1=1  \n";
         if (!empty($empleadoId)){
         	$sql.="  AND PPCH.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPCH.PLPR_CHAPA_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPCH.PLPR_CHAPA_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
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