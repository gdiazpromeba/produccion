<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/ProveedoresOad.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Proveedor.php';  

   class ProveedoresOadImpl extends AOD implements ProveedoresOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PROVEEDOR_ID,     \n"; 
         $sql.="  NOMBRE,    \n";
         $sql.="  RUBROS,    \n";
         $sql.="  OBSERVACIONES    \n";
         $sql.="FROM  \n"; 
         $sql.="  PROVEEDORES  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  PROVEEDOR_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Proveedor();  
         $id=null;  
         $nombre=null;
         $observaciones=null;
         $rubros=null;
         $stm->bind_result($id, $nombre, $rubros, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setRubros($rubros);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
      	//$exito=new Exito();
      	$conexion=null; $stm=null;
        $conexion=$this->conectarse(); 
        $sql="INSERT INTO PROVEEDORES (   \n"; 
        $sql.="  PROVEEDOR_ID,     \n"; 
        $sql.="  NOMBRE,     \n";
        $sql.="  RUBROS,     \n";
        $sql.="  OBSERVACIONES )    \n"; 
        $sql.="VALUES (?, ?, ?, ?)    \n"; 
        $idUnico=$this->idUnico();
        $bean->setId($idUnico); 
        $stm=$this->preparar($conexion, $sql); 
        $stm->bind_param("ssss",$bean->getId(), $bean->getNombre(), $bean->getRubros(), $bean->getObservaciones()); 
        return $this->ejecutaYCierra($conexion, $stm, $idUnico);
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM PROVEEDORES   \n"; 
         $sql.="WHERE PROVEEDOR_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE PROVEEDORES SET   \n"; 
         $sql.="  NOMBRE=?,     \n";
         $sql.="  RUBROS=?,     \n";
         $sql.="  OBSERVACIONES=?     \n";
         $sql.="WHERE PROVEEDOR_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("ssss", $bean->getNombre(), $bean->getRubros(), $bean->getObservaciones(), $bean->getId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $nombreOParte, $rubros){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  PROVEEDOR_ID,     \n"; 
         $sql.="  NOMBRE,    \n";
         $sql.="  RUBROS,    \n";
         $sql.="  OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  PROVEEDORES  \n"; 
         $sql.="WHERE 1=1  \n"; 
         if ($nombreOParte!=null){
         	$sql.=" AND UPPER(NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'  \n"; 
         }
         if ($rubros!=null){
         	$sql.=" AND UPPER(RUBROS) LIKE '%" . strtoupper($rubros) . "%'  \n"; 
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $rubros=null;
         $observaciones=null;
         $stm->bind_result($id, $nombre, $rubros, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Proveedor();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setRubros($rubros);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($nombreOParte, $rubros){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PROVEEDORES "; 
         $sql.="WHERE 1=1  \n"; 
         if ($nombreOParte!=null){
         	$sql.=" AND UPPER(NOMBRE) LIKE '%" . strtoupper($nombreOParte) . "%'  \n"; 
         }
         if ($rubros!=null){
         	$sql.=" AND UPPER(RUBROS) LIKE '%" . strtoupper($rubros) . "%'  \n"; 
         }         
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
         $sql.="  PROVEEDOR_ID,     \n"; 
         $sql.="  NOMBRE    \n";
         $sql.="FROM  \n"; 
         $sql.="  PROVEEDORES  \n";
         $sql.="WHERE  \n"; 
         $sql.="  UPPER(NOMBRE) LIKE '". strtoupper($cadena)  . "%'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  NOMBRE  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Proveedor();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       
      

      public function selPorComienzoCuenta($cadena){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM PROVEEDORES "; 
         $sql.="WHERE  \n"; 
         $sql.="  UPPER(NOMBRE) LIKE '". strtoupper($cadena)  . "%'  \n";
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