<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/BancosOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Banco.php';
//require_once('FirePHPCore/fb.php4');
 


   class BancosOadImpl extends AOD implements BancosOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  BANCO_ID,     \n"; 
         $sql.="  BANCO_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  BANCOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  BANCO_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Proceso();  
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
         $sql="INSERT INTO BANCOS (   \n"; 
         $sql.="  BANCO_ID,     \n"; 
         $sql.="  BANCO_NOMBRE)    \n"; 
         $sql.="VALUES (?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ss",$bean->getId(), $bean->getNombre()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM BANCOS   \n"; 
         $sql.="WHERE BANCO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE BANCOS SET   \n"; 
         $sql.="  BANCO_NOMBRE=?     \n"; 
         $sql.="WHERE BANCO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ss", $bean->getNombre(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      
      public function selPorParte($cadena, $desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  BANCO_ID,     \n"; 
         $sql.="  BANCO_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  BANCOS  \n";
         $sql.="WHERE  \n"; 
         $sql.="  UPPER(BANCO_NOMBRE) LIKE '%" . strtoupper($cadena) . "%'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  BANCO_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Banco();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }   

      public function selPorParteCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  COUNT(*) \n"; 
         $sql.="FROM  \n"; 
         $sql.="  BANCOS  \n";
         $sql.="WHERE  \n"; 
         $sql.="  UPPER(BANCO_NOMBRE) LIKE '%" . strtoupper($cadena) . "%'  \n";
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