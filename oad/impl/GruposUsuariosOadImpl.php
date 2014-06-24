<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/GruposUsuariosOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/GrupoUsuarios.php';  

   class GruposUsuariosOadImpl extends AOD implements GruposUsuariosOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  GRUPO_USUARIOS_ID,     \n"; 
         $sql.="  GRUPO_USUARIOS_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  GRUPOS_DE_USUARIOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  GRUPO_USUARIOS_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new GrupoUsuarios();  
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
         $sql="INSERT INTO GRUPOS_DE_USUARIOS (   \n"; 
         $sql.="  GRUPO_USUARIOS_ID,     \n"; 
         $sql.="  GRUPO_USUARIOS_NOMBRE)    \n"; 
         $sql.="VALUES (?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ss",$bean->getId(), $bean->getNombre()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM GRUPOS_DE_USUARIOS   \n"; 
         $sql.="WHERE GRUPO_USUARIOS_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE GRUPOS_DE_USUARIOS SET   \n"; 
         $sql.="  GRUPO_USUARIOS_NOMBRE=?     \n"; 
         $sql.="WHERE GRUPO_USUARIOS_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ss", $bean->getNombre(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  GRUPO_USUARIOS_ID,     \n"; 
         $sql.="  GRUPO_USUARIOS_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  GRUPOS_DE_USUARIOS  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  GRUPO_USUARIOS_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new GrupoUsuarios();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM GRUPOS_DE_USUARIOS ";
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      }

      public function selPorUsuario($desde, $cuantos, $usuarioId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  GRU.GRUPO_USUARIOS_ID,     \n"; 
         $sql.="  GRU.GRUPO_USUARIOS_NOMBRE    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  GRUPOS_DE_USUARIOS  GRU \n";
         $sql.="  INNER JOIN USUARIOS_POR_GRUPO UGR ON GRU.GRUPO_USUARIOS_ID=UGR.GRUPO_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  UGR.USUARIO_ID='" . $usuarioId . "'   \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  GRU.GRUPO_USUARIOS_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new GrupoUsuarios();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selPorUsuarioCuenta($usuarioId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  COUNT(*)     \n"; 
         $sql.="FROM  \n"; 
         $sql.="  GRUPOS_DE_USUARIOS  GRU \n";
         $sql.="  INNER JOIN USUARIOS_POR_GRUPO UGR ON GRU.GRUPO_USUARIOS_ID=UGR.GRUPO_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  UGR.USUARIO_ID='" . $usuarioId . "'   \n"; 
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