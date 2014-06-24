<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/MaterialesOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Material.php';  

   class MaterialesOadImpl extends AOD implements MaterialesOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MATERIAL_ID,     \n"; 
         $sql.="  MATERIAL_NOMBRE,     \n";
         $sql.="  MATERIAL_UNIDAD_ID,     \n"; 
         $sql.="  UNIDAD_TEXTO,     \n"; 
         $sql.="  MATERIAL_PRECIO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  MATERIALES  MAT \n"; 
         $sql.="  INNER JOIN UNIDADES UNI ON MAT.MATERIAL_UNIDAD_ID=UNI.UNIDAD_ID \n";
         $sql.="WHERE  \n"; 
         $sql.="  MATERIAL_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Material();  
         $id=null;  
         $nombre=null;  
         $unidadId=null;  
         $unidadTexto=null;  
         $precio=null;  
         $stm->bind_result($id, $nombre, $unidadId, $unidadTexto, $precio); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setUnidadId($unidadId);
            $bean->setUnidadTexto($unidadTexto);
            $bean->setPrecio($precio);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO MATERIALES (   \n"; 
         $sql.="  MATERIAL_ID,     \n"; 
         $sql.="  MATERIAL_NOMBRE,     \n";
         $sql.="  MATERIAL_UNIDAD_ID,     \n"; 
         $sql.="  MATERIAL_PRECIO)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $idUnico=$this->idUnico();
         $bean->setId($idUnico);
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sssd",$bean->getId(), $bean->getNombre(), $bean->getUnidadId(), $bean->getPrecio()); 
         return $this->ejecutaYCierra($conexion, $stm, $idUnico); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM MATERIALES   \n"; 
         $sql.="WHERE MATERIAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 
      
      public function inhabilita($id){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE MATERIALES SET HABILITADO=0 \n"; 
         $sql.="WHERE MATERIAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      }       


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE MATERIALES SET   \n"; 
         $sql.="  MATERIAL_NOMBRE=?,     \n";
         $sql.="  MATERIAL_UNIDAD_ID=?,     \n"; 
         $sql.="  MATERIAL_PRECIO=?     \n"; 
         $sql.="WHERE MATERIAL_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssds", $bean->getNombre(), $bean->getUnidadId(), $bean->getPrecio(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $nombreOParte){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MAT.MATERIAL_ID,     \n"; 
         $sql.="  MAT.MATERIAL_NOMBRE,     \n";
         $sql.="  MAT.MATERIAL_UNIDAD_ID,     \n"; 
         $sql.="  UNI.UNIDAD_TEXTO,     \n"; 
         $sql.="  MAT.MATERIAL_PRECIO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  MATERIALES  MAT \n"; 
         $sql.="  INNER JOIN UNIDADES UNI ON MAT.MATERIAL_UNIDAD_ID=UNI.UNIDAD_ID \n";
         $sql.="WHERE  \n";
         $sql.="  MAT.HABILITADO=1  \n";
         if ($nombreOParte!=null){
         	$sql.="  AND UPPER(MAT.MATERIAL_NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'  \n";
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  MAT.MATERIAL_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;
         $unidadId=null;  
         $unidadTexto=null;  
         $precio=null;  
         $stm->bind_result($id, $nombre,  $unidadId, $unidadTexto, $precio); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Material();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setUnidadId($unidadId);
            $bean->setUnidadTexto($unidadTexto);
            $bean->setPrecio($precio);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selPorComienzo($cadena, $desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  MAT.MATERIAL_ID,     \n"; 
         $sql.="  MAT.MATERIAL_NOMBRE,     \n";
         $sql.="  MAT.MATERIAL_UNIDAD_ID,     \n"; 
         $sql.="  UNI.UNIDAD_TEXTO,     \n"; 
         $sql.="  MAT.MATERIAL_PRECIO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  MATERIALES  MAT \n"; 
         $sql.="  INNER JOIN UNIDADES UNI ON MAT.MATERIAL_UNIDAD_ID=UNI.UNIDAD_ID \n";
         $sql.="WHERE  \n";
         $sql.="  MAT.HABILITADO=1  \n";
         $sql.="  AND UPPER(MAT.MATERIAL_NOMBRE) LIKE '" . strtoupper($cadena) . "%'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  MAT.MATERIAL_NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;
         $unidadId=null;  
         $unidadTexto=null;  
         $precio=null;  
         $stm->bind_result($id, $nombre,  $unidadId, $unidadTexto, $precio); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Material();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setUnidadId($unidadId);
            $bean->setUnidadTexto($unidadTexto);
            $bean->setPrecio($precio);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       


      public function selTodosCuenta($nombreOParte){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM MATERIALES \n"; 
         $sql.="WHERE  \n";
         $sql.="  HABILITADO=1  \n";
         if ($nombreOParte!=null){
         	$sql.="  AND UPPER(MATERIAL_NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'  \n";
         }
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $cuenta=null; 
         $stm->bind_result($cuenta); 
         $stm->fetch();  
         $this->cierra($conexion, $stm); 
         return $cuenta; 
      } 
      
      public function selPorComienzoCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM MATERIALES \n"; 
         $sql.="WHERE  \n";
         $sql.="  HABILITADO=1  \n";
         $sql.="  AND UPPER(MATERIAL_NOMBRE) LIKE '" . strtoupper($cadena) . "%'  \n";
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