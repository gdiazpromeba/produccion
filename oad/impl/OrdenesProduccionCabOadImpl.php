<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/OrdenesProduccionCabOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenProduccion.php';  
//require_once('FirePHPCore/fb.php');

   class OrdenesProduccionCabOadImpl extends AOD implements OrdenesProduccionCabOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  ORDEN_PROD_CAB_ID,     \n"; 
         $sql.="  ORDEN_PROD_ESTADO,     \n"; 
         $sql.="  ORDEN_PROD_FECHA,     \n"; 
         $sql.="  ORDEN_PROD_NUMERO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ORDEN_PROD_CAB  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  ORDEN_PROD_CAB_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new OrdenProduccion();  
         $id=null;  
         $estado=null;  
         $fecha=null;  
         $numero=null;  
         $stm->bind_result($id, $estado, $fecha, $numero); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setEstado($estado);
            $bean->setFechaLarga($fecha);
            $bean->setNumero($numero);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO ORDEN_PROD_CAB (   \n"; 
         $sql.="  ORDEN_PROD_CAB_ID,     \n"; 
         $sql.="  ORDEN_PROD_ESTADO,     \n"; 
         $sql.="  ORDEN_PROD_FECHA,     \n"; 
         $sql.="  ORDEN_PROD_NUMERO)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssi",$bean->getId(), $bean->getEstado(), $bean->getFechaLarga(), $bean->getNumero()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM ORDEN_PROD_CAB   \n"; 
         $sql.="WHERE ORDEN_PROD_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE ORDEN_PROD_CAB SET   \n"; 
         $sql.="  ORDEN_PROD_ESTADO=?,     \n"; 
         $sql.="  ORDEN_PROD_FECHA=?,     \n"; 
         $sql.="  ORDEN_PROD_NUMERO=?     \n"; 
         $sql.="WHERE ORDEN_PROD_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssis", $bean->getEstado(), $bean->getFechaLarga(), $bean->getNumero(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $sort, $dir, $ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  ORDEN_PROD_CAB_ID,     \n"; 
         $sql.="  ORDEN_PROD_ESTADO,     \n"; 
         $sql.="  ORDEN_PROD_FECHA,     \n"; 
         $sql.="  ORDEN_PROD_NUMERO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ORDEN_PROD_CAB  \n";
         $sql.="WHERE  \n"; 
         $sql.="  1=1 \n";
         if (!empty($ordenNumero)){
         	$sql.="  AND ORDEN_PROD_NUMERO=" . $ordenEstado . " \n";
         }      
         if (!empty($ordenEstado)){
         	$sql.="  AND ORDEN_PROD_ESTADO='" . $ordenEstado . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND ORDEN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND ORDEN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $sql.="ORDER BY  \n"; 
         $sql.="  ORDEN_PROD_FECHA DESC  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $estado=null;  
         $fecha=null;  
         $numero=null;  
         $stm->bind_result($id, $estado, $fecha, $numero); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new OrdenProduccion();  
            $bean->setId($id);
            $bean->setEstado($estado);
            $bean->setFechaLarga($fecha);
            $bean->setNumero($numero);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM ORDEN_PROD_CAB "; 
         $sql.="WHERE  \n"; 
         $sql.="  1=1 \n";
         if (!empty($ordenNumero)){
         	$sql.="  AND ORDEN_PROD_NUMERO=" . $ordenEstado . " \n";
         }      
         if (!empty($ordenEstado)){
         	$sql.="  AND ORDEN_PROD_ESTADO='" . $ordenEstado . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND ORDEN_PROD_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND ORDEN_PROD_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selReporteAltaOrden($ordProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OPC.ORDEN_PROD_FECHA,     \n";
         $sql.="  OPC.ORDEN_PROD_ESTADO,     \n";
         $sql.="  OPC.ORDEN_PROD_NUMERO,     \n";
         $sql.="  OPD.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  OPD.CANTIDAD,     \n";
         $sql.="  OPD.OBSERVACIONES     \n";
         $sql.="FROM  \n"; 
         $sql.="  ORDEN_PROD_CAB OPC \n";
         $sql.="  INNER JOIN ORDEN_PROD_DET OPD ON OPC.ORDEN_PROD_CAB_ID=OPD.ORDEN_PROD_CAB_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON OPD.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE     \n";
         $sql.="  OPC.ORDEN_PROD_CAB_ID='" . $ordProdCabId . "'    \n";
         $sql.="ORDER BY     \n";
         $sql.="  PIE.PIEZA_NOMBRE     \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $fecha=null;
         $estado=null;
         $numero=null;
         $piezaId=null;
         $piezaNombre=null;
         $cantidad=null;
         $observaciones=null;
         $stm->bind_result($fecha, $estado, $numero,  $piezaId, $piezaNombre,  $cantidad, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['ordenFecha']=FechaUtils::cadenaLargaADMA($fecha);
         	$fila['ordenEstado']=$estado; 
         	$fila['ordenNumero']=$numero;
         	$fila['cantidad']=$cantidad;
         	$fila['piezaId']=$piezaId;
         	$fila['piezaNombre']=$piezaNombre;
         	$fila['observaciones']=$observaciones;
            $filas[]=$fila; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      
      
      
      public function maximoNumero(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT MAX(ORDEN_PROD_NUMERO)   "; 
         $sql.="FROM  \n"; 
         $sql.="  ORDEN_PROD_CAB   \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $max=null; 
         $stm->bind_result($max); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $max; 
      }       

   } 
?>