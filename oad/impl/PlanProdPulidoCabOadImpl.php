<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PlanProdPulidoCabOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PlanProdPulidoCab.php';  

   class PlanProdPulidoCabOadImpl extends AOD implements PlanProdPulidoCabOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPC.PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PPC.PLPR_PULIDO_FECHA,     \n"; 
         $sql.="  PPC.EMPLEADO_ID,     \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n"; 
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n"; 
         $sql.="  EMP.TARJETA_NUMERO,     \n";
         $sql.="  PPC.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_CAB  PPC  \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  PPC.PLPR_PULIDO_CAB_ID='" . $id . "' \n"; 
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
         $sql="INSERT INTO PLPR_PULIDO_CAB (   \n"; 
         $sql.="  PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PLPR_PULIDO_FECHA,     \n"; 
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
         $sql="DELETE FROM PLPR_PULIDO_CAB   \n"; 
         $sql.="WHERE PLPR_PULIDO_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PLPR_PULIDO_CAB SET   \n"; 
         $sql.="  PLPR_PULIDO_FECHA=?,     \n"; 
         $sql.="  EMPLEADO_ID=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE PLPR_PULIDO_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssss", $bean->getFechaLarga(), $bean->getEmpleadoId(), $bean->getObservacionesCab(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PPC.PLPR_PULIDO_CAB_ID,     \n"; 
         $sql.="  PPC.PLPR_PULIDO_FECHA,     \n"; 
         $sql.="  PPC.EMPLEADO_ID,     \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,     \n"; 
         $sql.="  EMP.EMPLEADO_NOMBRE,     \n"; 
         $sql.="  EMP.TARJETA_NUMERO,     \n";
         $sql.="  PPC.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PLPR_PULIDO_CAB  PPC  \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON PPC.EMPLEADO_ID=EMP.EMPLEADO_ID  \n";         
         $sql.="WHERE 1=1  \n";
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLPR_PULIDO_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLPR_PULIDO_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $sql.="ORDER BY  \n"; 
         $sql.="  PPC.PLPR_PULIDO_FECHA  \n"; 
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
            $bean=new PlanProdPulidoCab();  
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


      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PLPR_PULIDO_CAB PPC ";
         $sql.="WHERE 1=1  \n";         
         if (!empty($empleadoId)){
         	$sql.="  AND PPC.EMPLEADO_ID='" .$empleadoId . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND PPC.PLPR_PULIDO_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND PPC.PLPR_PULIDO_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
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