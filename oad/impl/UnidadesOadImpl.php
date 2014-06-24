<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/UnidadesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Unidad.php';  

   class UnidadesOadImpl extends AOD implements UnidadesOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  UNIDAD_ID,     \n"; 
         $sql.="  MAGNITUD_ID,     \n"; 
         $sql.="  UNIDAD_NOMBRE,     \n"; 
         $sql.="  UNIDAD_TEXTO,     \n"; 
         $sql.="  UNIDAD_FACTOR    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  UNIDADES  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  UNIDAD_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Unidad();  
         $id=null;  
         $magnitudId=null;  
         $nombre=null;  
         $texto=null;  
         $factor=null;  
         $stm->bind_result($id, $magnitudId, $nombre, $texto, $factor); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setMagnitudId($magnitudId);
            $bean->setNombre($nombre);
            $bean->setTexto($texto);
            $bean->setFactor($factor);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO UNIDADES (   \n"; 
         $sql.="  UNIDAD_ID,     \n"; 
         $sql.="  MAGNITUD_ID,     \n"; 
         $sql.="  UNIDAD_NOMBRE,     \n"; 
         $sql.="  UNIDAD_TEXTO,     \n"; 
         $sql.="  UNIDAD_FACTOR)    \n"; 
         $sql.="VALUES (?, ?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssssd",$bean->getId(), $bean->getMagnitudId(), $bean->getNombre(), $bean->getTexto(), $bean->getFactor()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM UNIDADES   \n"; 
         $sql.="WHERE UNIDAD_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE UNIDADES SET   \n"; 
         $sql.="  MAGNITUD_ID=?,     \n"; 
         $sql.="  UNIDAD_NOMBRE=?,     \n"; 
         $sql.="  UNIDAD_TEXTO=?,     \n"; 
         $sql.="  UNIDAD_FACTOR=?     \n"; 
         $sql.="WHERE UNIDAD_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sssds", $bean->getMagnitudId(), $bean->getNombre(), $bean->getTexto(), $bean->getFactor(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  UNIDAD_ID,     \n"; 
         $sql.="  MAGNITUD_ID,     \n"; 
         $sql.="  UNIDAD_NOMBRE,     \n"; 
         $sql.="  UNIDAD_TEXTO,     \n"; 
         $sql.="  UNIDAD_FACTOR    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  UNIDADES  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  UNIDAD_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $magnitudId=null;  
         $nombre=null;  
         $texto=null;  
         $factor=null;  
         $stm->bind_result($id, $magnitudId, $nombre, $texto, $factor); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Unidad();  
            $bean->setId($id);
            $bean->setMagnitudId($magnitudId);
            $bean->setNombre($nombre);
            $bean->setTexto($texto);
            $bean->setFactor($factor);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM UNIDADES "; 
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