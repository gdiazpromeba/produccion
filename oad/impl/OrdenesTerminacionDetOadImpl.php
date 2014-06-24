<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/OrdenesTerminacionDetOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenTerminacionDetalle.php'; 
//require_once('FirePHPCore/fb.php'); 

   class OrdenesTerminacionDetOadImpl extends AOD implements OrdenesTerminacionDetOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OPD.OP_TERM_DET_ID,     \n"; 
         $sql.="  OPD.OP_TERM_CAB_ID,     \n"; 
         $sql.="  OPD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n";
         $sql.="  OPD.CANTIDAD,     \n";
         $sql.="  OPD.CANTIDAD_CORTADA,     \n";
         $sql.="  OPD.CANTIDAD_PULIDA,     \n";
         $sql.="  OPD.FECHA_ENTREGA,     \n";
         $sql.="  OPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  OP_TERM_DET  OPD \n";
         $sql.="  INNER JOIN PIEZAS PIE ON OPD.PIEZA_ID=PIE.PIEZA_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  OP_TERM_DET_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new OrdenTerminacionDetalle();  
         $id=null;  
         $cabeceraId=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $cantidad=null;
         $cantidadCortada=null;
         $cantidadPulida=null;
         $fechaEntrega=null;
         $observaciones=null;  
         $stm->bind_result($id, $cabeceraId, $piezaId, $piezaNombre, $cantidad, $cantidadCortada, $cantidadPulida, $fechaEntrega, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setCantidad($cantidad);
            $bean->setCantidadCortada($cantidadCortada);
            $bean->setCantidadCortada($cantidadPulida);
            $bean->setFechaEntregaLarga($fechaEntrega);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO OP_TERM_DET (   \n"; 
         $sql.="  OP_TERM_DET_ID,     \n"; 
         $sql.="  OP_TERM_CAB_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CANTIDAD,     \n";
         $sql.="  CANTIDAD_CORTADA,     \n";
         $sql.="  CANTIDAD_PULIDA,     \n";
         $sql.="  FECHA_ENTREGA,     \n";
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssiiiss",$bean->getId(), $bean->getCabeceraId(), $bean->getPiezaId(), $bean->getCantidad(), $bean->getCantidadCortada(), $bean->getCantidadPulida(), $bean->getFechaEntregaLarga(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM OP_TERM_DET   \n"; 
         $sql.="WHERE OP_TERM_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE OP_TERM_DET SET   \n"; 
         $sql.="  OP_TERM_CAB_ID=?,     \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  CANTIDAD=?,     \n";
         $sql.="  CANTIDAD_CORTADA=?,     \n";
         $sql.="  CANTIDAD_PULIDA=?,     \n";
         $sql.="  FECHA_ENTREGA=?,     \n";
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE OP_TERM_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssiiisss", $bean->getCabeceraId(), $bean->getPiezaId(), $bean->getCantidad(), $bean->getCantidadCortada(), $bean->getCantidadPulida(),  $bean->getFechaEntregaLarga(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $ordenProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OPD.OP_TERM_DET_ID,     \n"; 
         $sql.="  OPD.OP_TERM_CAB_ID,     \n"; 
         $sql.="  OPD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  OPD.CANTIDAD,     \n";
         $sql.="  OPD.CANTIDAD_CORTADA,     \n";
         $sql.="  OPD.CANTIDAD_PULIDA,     \n";
         $sql.="  OPD.FECHA_ENTREGA,     \n";
         $sql.="  OPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  OP_TERM_DET  OPD \n";
         $sql.="  INNER JOIN PIEZAS PIE ON OPD.PIEZA_ID=PIE.PIEZA_ID \n";
         $sql.="WHERE   \n";
         $sql.="  OP_TERM_CAB_ID='" . $ordenProdCabId .  "' \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  OPD.FECHA_ENTREGA  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $cabeceraId=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $cantidad=null;
         $cantidadCortada=null;
         $cantidadPulida=null;
         $fechaEntrega=null;
         $observaciones=null;  
         $stm->bind_result($id, $cabeceraId, $piezaId, $piezaNombre, $cantidad, $cantidadCortada, $cantidadPulida, $fechaEntrega, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new OrdenTerminacionDetalle();  
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setCantidad($cantidad);            
            $bean->setCantidadCortada($cantidadCortada);
            $bean->setCantidadPulida($cantidadPulida);
            $bean->setFechaEntregaLarga($fechaEntrega);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      
      


      public function selTodosCuenta($ordenProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM OP_TERM_DET ";
         $sql.="WHERE   \n";
         $sql.="  OP_TERM_CAB_ID='" . $ordenProdCabId .  "' \n";
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