<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/PiezasGenericasOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PiezaGenerica.php';  

   class PiezasGenericasOadOadImpl extends AOD implements PiezasGenericasOadOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIEZA_GENERICA_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PIEZAS_GENERICAS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  PIEZA_GENERICA_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new PiezaGenerica();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO PIEZAS_GENERICAS (   \n"; 
         $sql.="  PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIEZA_GENERICA_NOMBRE)    \n"; 
         $sql.="VALUES (?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ss",$bean->getId(), $bean->getNombre()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PIEZAS_GENERICAS   \n"; 
         $sql.="WHERE PIEZA_GENERICA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PIEZAS_GENERICAS SET   \n"; 
         $sql.="  PIEZA_GENERICA_NOMBRE=?     \n"; 
         $sql.="WHERE PIEZA_GENERICA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ss", $bean->getNombre(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PIEZA_GENERICA_ID,     \n"; 
         $sql.="  PIEZA_GENERICA_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PIEZAS_GENERICAS  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  PIEZA_GENERICA_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new PiezaGenerica();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PIEZAS_GENERICAS "; 
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