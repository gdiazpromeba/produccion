<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/LineasPorMatrizOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/LineaPorMatriz.php';  

   class LineasPorMatrizOadImpl extends AOD implements LineasPorMatrizOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LXM.LXM_ID,     \n"; 
         $sql.="  LXM.MATRIZ_ID,     \n"; 
         $sql.="  LXM.LINEA_ID,     \n"; 
         $sql.="  LIN.LINEA_DESCRIPCION,     \n";
         $sql.="  LXM.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  LINEAS_POR_MATRIZ LXM \n";
         $sql.="  INNER JOIN LINEAS LIN ON LXM.LINEA_ID=LIN.LINEA_ID   \n";
         $sql.="WHERE  \n"; 
         $sql.="  LXM.LXM_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new LineaPorMatriz();  
         $id=null;  
         $matrizId=null;  
         $lineaId=null;  
         $lineaDescripcion = null; 
         $observaciones=null;  
         $stm->bind_result($id, $matrizId, $lineaId, $lineaDescripcion, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setMatrizId($matrizId);
            $bean->setLineaId($lineaId);
            $bean->setLineaDescripcion($lineaDescripcion);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO LINEAS_POR_MATRIZ (   \n"; 
         $sql.="  LXM_ID,     \n"; 
         $sql.="  MATRIZ_ID,     \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssss",$bean->getId(), $bean->getMatrizId(), $bean->getLineaId(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM LINEAS_POR_MATRIZ   \n"; 
         $sql.="WHERE LXM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE LINEAS_POR_MATRIZ SET   \n"; 
         $sql.="  MATRIZ_ID=?,     \n"; 
         $sql.="  LINEA_ID=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE LXM_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssss", $bean->getMatrizId(), $bean->getLineaId(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $matrizId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LXM.LXM_ID,     \n"; 
         $sql.="  LXM.MATRIZ_ID,     \n"; 
         $sql.="  LXM.LINEA_ID,     \n";
         $sql.="  LIN.LINEA_DESCRIPCION,     \n";
         $sql.="  LXM.OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  LINEAS_POR_MATRIZ  LXM \n";
         $sql.="  INNER JOIN LINEAS LIN ON LXM.LINEA_ID=LIN.LINEA_ID   \n";
         $sql.="WHERE    \n";
         $sql.=" LXM.MATRIZ_ID='" . $matrizId . "' \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  LXM.LXM_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $matrizId=null;  
         $lineaId=null;
         $lineaDescripcion=null;
         $observaciones=null;  
         $stm->bind_result($id, $matrizId, $lineaId, $lineaDescripcion, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new LineaPorMatriz();  
            $bean->setId($id);
            $bean->setMatrizId($matrizId);
            $bean->setLineaId($lineaId);
            $bean->setLineaDescripcion($lineaDescripcion);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($matrizId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM LINEAS_POR_MATRIZ \n";
         $sql.="WHERE \n";
         $sql.=" MATRIZ_ID='" . $matrizId . "' \n";
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