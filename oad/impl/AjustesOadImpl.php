<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AjustesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/AjusteCosto.php';  

   class AjustesOadImpl extends AOD implements AjustesOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  AJUSTE_COSTO_ID,     \n"; 
         $sql.="  AJUSTE_COSTO_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  AJUSTES_COSTO  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  AJUSTE_COSTO_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new AjusteCosto();  
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
         $sql="INSERT INTO AJUSTES_COSTO (   \n"; 
         $sql.="  AJUSTE_COSTO_ID,     \n"; 
         $sql.="  AJUSTE_COSTO_NOMBRE)    \n"; 
         $sql.="VALUES (?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ss",$bean->getId(), $bean->getNombre()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM AJUSTES_COSTO   \n"; 
         $sql.="WHERE AJUSTE_COSTO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE AJUSTES_COSTO SET   \n"; 
         $sql.="  AJUSTE_COSTO_NOMBRE=?     \n"; 
         $sql.="WHERE AJUSTE_COSTO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ss", $bean->getNombre(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  AJUSTE_COSTO_ID,     \n"; 
         $sql.="  AJUSTE_COSTO_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  AJUSTES_COSTO  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  AJUSTE_COSTO_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new AjusteCosto();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM AJUSTES_COSTO "; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selPorComienzo($cadena, $desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  ACO.AJUSTE_COSTO_ID,     \n"; 
         $sql.="  ACO.AJUSTE_COSTO_NOMBRE     \n";
         $sql.="FROM  \n"; 
         $sql.="  AJUSTES_COSTO  ACO \n"; 
         $sql.="WHERE  \n";
         $sql.="  AND UPPER(ACO.AJUSTE_COSTO_NOMBRE) LIKE '" . strtoupper($cadena) . "%'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  ACO.AJUSTE_COSTO_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Material();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }      
      
      public function selPorComienzoCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM AJUSTES_COSTO \n"; 
         $sql.="WHERE  \n";
         $sql.="  AND UPPER(AJUSTE_COSTO_NOMBRE) LIKE '" . strtoupper($cadena) . "%'  \n";
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