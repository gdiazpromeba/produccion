<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/DatosRelojOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/DatoReloj.php';  
//require_once('FirePHPCore/fb.php');

   class DatosRelojOadImpl extends AOD implements DatosRelojOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  DAR.DATO_RELOJ_ID,     \n"; 
         $sql.="  DAR.LECTURA_FECHA_HORA,    \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,    \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,    \n";
         $sql.="  DAR.EMPLEADO_ID    \n";
         $sql.="FROM  \n"; 
         $sql.="  DATOS_RELOJ DAR \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON EMP.EMPLEADO_ID=DAR.EMPLEADO_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  DATO_RELOJ_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new DatoReloj();  
         $id=null;  
         $lecturaFecha=null; 
         $empleadoId=null;
         $empleadoNombre=null;
         $empleadoApellido=null;
         $stm->bind_result($id, $lecturaFecha, $empleadoNombre, $empleadoApellido, $empleadoId); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setEmpleadoApellido($empleadoApellido);
            $bean->setCadenaFechaHoraLarga($lecturaFecha);
            $bean->setEmpleadoId($empleadoId);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO DATOS_RELOJ (   \n"; 
         $sql.="  DATO_RELOJ_ID,     \n"; 
         $sql.="  LECTURA_FECHA_HORA,    \n";
         $sql.="  EMPLEADO_ID)    \n";
         $sql.="VALUES (?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sss",$bean->getId(), $bean->getCadenaFechaHoraLarga(), $bean->getEmpleadoId()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM DATOS_RELOJ   \n"; 
         $sql.="WHERE DATO_RELOJ_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE DATOS_RELOJ SET   \n"; 
         $sql.="  LECTURA_FECHA_HORA=?,     \n";
         $sql.="  EMPLEADO_ID=?     \n";
         $sql.="WHERE DATO_RELOJ_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sss", $bean->getCadenaFechaHoraLarga(), $bean->getEmpleadoId(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  DAR.DATO_RELOJ_ID,     \n"; 
         $sql.="  DAR.LECTURA_FECHA_HORA,    \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,    \n";
         $sql.="  EMP.EMPLEADO_APELLIDO,    \n";
         $sql.="  DAR.EMPLEADO_ID    \n";
         $sql.="FROM  \n"; 
         $sql.="  DATOS_RELOJ DAR \n";
         $sql.="  INNER JOIN EMPLEADOS EMP ON EMP.EMPLEADO_ID=DAR.EMPLEADO_ID \n";
         $sql.="WHERE 1=1  \n"; 
         if (!empty($empleadoId)){
         	$sql.="  AND DAR.EMPLEADO_ID='" .$empleadoId . "' \n";
         }         
         if (!empty($fechaDesde)){
         	$sql.="  AND DATE(DAR.LECTURA_FECHA_HORA) >= DATE('" . FechaUtils::dateTimeACadena($fechaDesde) . "') \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND DATE(DAR.LECTURA_FECHA_HORA) <= DATE('" . FechaUtils::dateTimeACadena($fechaHasta) . "') \n";
         }      
         $sql.="ORDER BY  \n"; 
         $sql.="  EMP.EMPLEADO_APELLIDO,  \n";
         $sql.="  EMP.EMPLEADO_NOMBRE,  \n";
         $sql.="  DAR.LECTURA_FECHA_HORA ASC  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $lecturaFecha=null; 
         $empleadoNombre=null;
         $empleadoApellido=null;
         $empleadoId=null;
         $stm->bind_result($id, $lecturaFecha, $empleadoNombre, $empleadoApellido, $empleadoId); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new DatoReloj();  
            $bean->setId($id);
            $bean->setCadenaFechaHoraLarga($lecturaFecha);
            $bean->setEmpleadoId($empleadoId);
            $bean->setEmpleadoNombre($empleadoNombre);
            $bean->setEmpleadoApellido($empleadoApellido);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM DATOS_RELOJ ";
         $sql.="WHERE 1=1  \n";
         if (!empty($empleadoId)){
         	$sql.="  AND EMPLEADO_ID='" .$empleadoId . "' \n";
         }         
         if (!empty($fechaDesde)){
         	$sql.="  AND DATE(LECTURA_FECHA_HORA) >= DATE('" . FechaUtils::dateTimeACadena($fechaDesde) . "') \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND DATE(LECTURA_FECHA_HORA) <= DATE('" . FechaUtils::dateTimeACadena($fechaHasta) . "') \n";
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