<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/OrdenesProduccionDetOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/OrdenProduccionDetalle.php';  

   class OrdenesProduccionDetOadImpl extends AOD implements OrdenesProduccionDetOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OPD.ORDEN_PROD_DET_ID,     \n"; 
         $sql.="  OPD.ORDEN_PROD_CAB_ID,     \n"; 
         $sql.="  OPD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  OPD.CANTIDAD,     \n"; 
         $sql.="  OPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ORDEN_PROD_DET  OPD \n";
         $sql.="  INNER JOIN PIEZAS PIE ON OPD.PIEZA_ID=PIE.PIEZA_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  ORDEN_PROD_DET_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new OrdenProduccionDetalle();  
         $id=null;  
         $cabeceraId=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $cantidad=null;  
         $observaciones=null;  
         $stm->bind_result($id, $cabeceraId, $piezaId, $piezaNombre, $cantidad, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setCantidad($cantidad);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO ORDEN_PROD_DET (   \n"; 
         $sql.="  ORDEN_PROD_DET_ID,     \n"; 
         $sql.="  ORDEN_PROD_CAB_ID,     \n"; 
         $sql.="  PIEZA_ID,     \n"; 
         $sql.="  CANTIDAD,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssds",$bean->getId(), $bean->getCabeceraId(), $bean->getPiezaId(), $bean->getCantidad(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM ORDEN_PROD_DET   \n"; 
         $sql.="WHERE ORDEN_PROD_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE ORDEN_PROD_DET SET   \n"; 
         $sql.="  ORDEN_PROD_CAB_ID=?,     \n"; 
         $sql.="  PIEZA_ID=?,     \n"; 
         $sql.="  CANTIDAD=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE ORDEN_PROD_DET_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssdss", $bean->getCabeceraId(), $bean->getPiezaId(), $bean->getCantidad(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $ordenProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  OPD.ORDEN_PROD_DET_ID,     \n"; 
         $sql.="  OPD.ORDEN_PROD_CAB_ID,     \n"; 
         $sql.="  OPD.PIEZA_ID,     \n"; 
         $sql.="  PIE.PIEZA_NOMBRE,     \n"; 
         $sql.="  OPD.CANTIDAD,     \n"; 
         $sql.="  OPD.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ORDEN_PROD_DET  OPD \n";
         $sql.="  INNER JOIN PIEZAS PIE ON OPD.PIEZA_ID=PIE.PIEZA_ID \n";
         $sql.="WHERE   \n";
         $sql.="  ORDEN_PROD_CAB_ID='" . $ordenProdCabId .  "' \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  PIE.PIEZA_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $cabeceraId=null;  
         $piezaId=null;  
         $piezaNombre=null;  
         $cantidad=null;  
         $observaciones=null;  
         $stm->bind_result($id, $cabeceraId, $piezaId, $piezaNombre, $cantidad, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new OrdenProduccionDetalle();  
            $bean->setId($id);
            $bean->setCabeceraId($cabeceraId);
            $bean->setPiezaId($piezaId);
            $bean->setPiezaNombre($piezaNombre);
            $bean->setCantidad($cantidad);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      
      public function terminacionesPorOP($ordProdCabId){
        $conexion=$this->conectarse();
        $sql="SELECT  \n";
        $sql.="   TERMINACION,  \n";
        $sql.="   SUM(CANTIDAD_CHAPAS * CANTIDAD),  \n";
        $sql.="   MEDIDA_CHAPAS,  \n";
        $sql.="   ORIENTACION_CHAPAS  \n";
        $sql.="FROM       \n";
        $sql.="  VW_OP_CHAPA_TERM     \n";
        $sql.="WHERE       \n";
        $sql.="  ORDEN_PROD_CAB_ID='" . $ordProdCabId  .  "'      \n";
        $sql.="GROUP BY       \n";
        $sql.="  TERMINACION,      \n";
        $sql.="  MEDIDA_CHAPAS,      \n";
        $sql.="  ORIENTACION_CHAPAS      \n";
        $stm=$this->preparar($conexion, $sql);  
        $stm->execute();  
        $terminacion=null;
        $cantidadChapas=null;
        $medidaChapas=null;
        $orientacionChapas=null;
        $stm->bind_result($terminacion, $cantidadChapas, $medidaChapas, $orientacionChapas); 
        $filas = array(); 
        while ($stm->fetch()) {
       	  $fila=array();
       	  $fila["terminacion"]=$terminacion;
       	  $fila["cantidadChapas"]=$cantidadChapas;
       	  $fila["medidaChapas"]=$medidaChapas;
       	  $fila["orientacionChapas"]=$orientacionChapas;
          $filas[]=$fila; 
        } 
         $this->cierra($conexion, $stm); 
         return $filas;         
      }         
      


      public function selTodosCuenta($ordenProdCabId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM ORDEN_PROD_DET ";
         $sql.="WHERE   \n";
         $sql.="  ORDEN_PROD_CAB_ID='" . $ordenProdCabId .  "' \n";
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