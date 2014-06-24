<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/FichasPorLineaOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/FichaPorLinea.php';  

   class FichasPorLineaOadImpl extends AOD implements FichasPorLineaOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  FXL_ID,     \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  PIEZA_FICHA,     \n"; 
         $sql.="  OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  FICHAS_POR_LINEA  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  FXL_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new FichaPorLinea();  
         $id=null;  
         $lineaId=null;  
         $piezaFicha=null;  
         $observaciones=null;  
         $stm->bind_result($id, $lineaId, $piezaFicha, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setLineaId($lineaId);
            $bean->setPiezaFicha($piezaFicha);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO FICHAS_POR_LINEA (   \n"; 
         $sql.="  FXL_ID,     \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  PIEZA_FICHA,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssss",$bean->getId(), $bean->getLineaId(), $bean->getPiezaFicha(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM FICHAS_POR_LINEA   \n"; 
         $sql.="WHERE FXL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE FICHAS_POR_LINEA SET   \n"; 
         $sql.="  LINEA_ID=?,     \n"; 
         $sql.="  PIEZA_FICHA=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE FXL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssss", $bean->getLineaId(), $bean->getPiezaFicha(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $lineaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  FXL_ID,     \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  PIEZA_FICHA,     \n"; 
         $sql.="  OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  FICHAS_POR_LINEA  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  LINEA_ID='" . $lineaId  .  "'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PIEZA_FICHA  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $lineaId=null;  
         $piezaFicha=null;  
         $observaciones=null;  
         $stm->bind_result($id, $lineaId, $piezaFicha, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new FichaPorLinea();  
            $bean->setId($id);
            $bean->setLineaId($lineaId);
            $bean->setPiezaFicha($piezaFicha);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($lineaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM FICHAS_POR_LINEA ";
         $sql.="WHERE  \n"; 
         $sql.="  LINEA_ID='" . $lineaId  .  "'  \n"; 
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