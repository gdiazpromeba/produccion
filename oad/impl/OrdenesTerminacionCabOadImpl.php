<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/OrdenesTerminacionCabOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenTerminacion.php';  
//require_once('FirePHPCore/fb.php');

   class OrdenesTerminacionCabOadImpl extends AOD implements OrdenesTerminacionCabOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OP_TERM_CAB_ID,     \n"; 
         $sql.="  OP_TERM_ESTADO,     \n"; 
         $sql.="  OP_TERM_FECHA,     \n"; 
         $sql.="  OP_TERM_NUMERO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  OP_TERM_CAB  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  OP_TERM_CAB_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new OrdenTerminacion();  
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
         $sql="INSERT INTO OP_TERM_CAB (   \n"; 
         $sql.="  OP_TERM_CAB_ID,     \n"; 
         $sql.="  OP_TERM_ESTADO,     \n"; 
         $sql.="  OP_TERM_FECHA,     \n"; 
         $sql.="  OP_TERM_NUMERO)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssi",$bean->getId(), $bean->getEstado(), $bean->getFechaLarga(), $bean->getNumero()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM OP_TERM_CAB   \n"; 
         $sql.="WHERE OP_TERM_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE OP_TERM_CAB SET   \n"; 
         $sql.="  OP_TERM_ESTADO=?,     \n"; 
         $sql.="  OP_TERM_FECHA=?,     \n"; 
         $sql.="  OP_TERM_NUMERO=?     \n"; 
         $sql.="WHERE OP_TERM_CAB_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssis", $bean->getEstado(), $bean->getFechaLarga(), $bean->getNumero(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $sort, $dir, $ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OP_TERM_CAB_ID,     \n"; 
         $sql.="  OP_TERM_ESTADO,     \n"; 
         $sql.="  OP_TERM_FECHA,     \n"; 
         $sql.="  OP_TERM_NUMERO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  OP_TERM_CAB  \n";
         $sql.="WHERE  \n"; 
         $sql.="  1=1 \n";
         if (!empty($ordenNumero)){
         	$sql.="  AND OP_TERM_NUMERO=" . $ordenEstado . " \n";
         }      
         if (!empty($ordenEstado)){
         	$sql.="  AND OP_TERM_ESTADO='" . $ordenEstado . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND OP_TERM_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND OP_TERM_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $sql.="ORDER BY  \n"; 
         $sql.="  OP_TERM_FECHA DESC  \n"; 
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
            $bean=new OrdenTerminacion();  
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
         $sql="SELECT COUNT(*) FROM OP_TERM_CAB "; 
         $sql.="WHERE  \n"; 
         $sql.="  1=1 \n";
         if (!empty($ordenNumero)){
         	$sql.="  AND OP_TERM_NUMERO=" . $ordenEstado . " \n";
         }      
         if (!empty($ordenEstado)){
         	$sql.="  AND OP_TERM_ESTADO='" . $ordenEstado . "' \n";
         }      
         if (!empty($fechaDesde)){
         	$sql.="  AND OP_TERM_FECHA >= '" . FechaUtils::dateTimeACadena($fechaDesde) . "' \n";
         }      
         if (!empty($fechaHasta)){
         	$sql.="  AND OP_TERM_FECHA <= '" . FechaUtils::dateTimeACadena($fechaHasta) . "' \n";
         }      
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selReporte($cabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OPC.OP_TERM_FECHA,     \n";
         $sql.="  OPC.OP_TERM_ESTADO,     \n";
         $sql.="  OPC.OP_TERM_NUMERO,     \n";
         $sql.="  OPD.PIEZA_ID,     \n";
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  OPD.CANTIDAD,     \n";
         $sql.="  OPD.CANTIDAD_CORTADA,     \n";
         $sql.="  OPD.CANTIDAD_PULIDA,     \n";
         $sql.="  OPD.FECHA_ENTREGA,     \n";
         $sql.="  OPD.OBSERVACIONES     \n";
         $sql.="FROM  \n"; 
         $sql.="  OP_TERM_CAB OPC \n";
         $sql.="  INNER JOIN OP_TERM_DET OPD ON OPC.OP_TERM_CAB_ID=OPD.OP_TERM_CAB_ID \n";
         $sql.="  INNER JOIN PIEZAS PIE ON OPD.PIEZA_ID=PIE.PIEZA_ID  \n";
         $sql.="WHERE     \n";
         $sql.="  OPC.OP_TERM_CAB_ID='" . $cabId . "'    \n";
         $sql.="ORDER BY     \n";
         $sql.="  OPD.FECHA_ENTREGA     \n";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $fecha=null;
         $estado=null;
         $numero=null;
         $piezaId=null;
         $piezaNombre=null;
         $cantidad=null;
         $cantidadCortada=null;
         $cantidadPulida=null;
         $fechaEntrega=null;
         $observaciones=null;
         $stm->bind_result($fecha, $estado, $numero,  $piezaId, $piezaNombre,  $cantidad, $cantidadCortada, $cantidadPulida, $fechaEntrega, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) {
         	$fila=array();
         	$fila['ordenFecha']=FechaUtils::cadenaLargaADMA($fecha);
         	$fila['ordenEstado']=$estado; 
         	$fila['ordenNumero']=$numero;
         	$fila['cantidad']=$cantidad;
         	$fila['cantidadCortada']=$cantidadCortada;
         	$fila['cantidadPulida']=$cantidadPulida;
         	$fila['fechaEntrega']=FechaUtils::cadenaLargaADMA($fechaEntrega);
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
         $sql="SELECT MAX(OP_TERM_NUMERO)   "; 
         $sql.="FROM  \n"; 
         $sql.="  OP_TERM_CAB   \n";
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