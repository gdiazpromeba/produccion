<?php 

require_once '../../config.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/LineasOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Linea.php';  

   class LineasOadImpl extends AOD implements LineasOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  LINEA_DESCRIPCION,     \n"; 
         $sql.="  OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  LINEAS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  LINEA_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Linea();  
         $id=null;  
         $descripcion=null;  
         $observaciones=null;  
         $stm->bind_result($id, $descripcion, $observaciones); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setDescripcion($descripcion);
            $bean->setObservaciones($observaciones);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 
      
  public function selPorComienzo($comienzo, $desde, $cuantos) {
    $conexion = $this->conectarse();
    $sql = "SELECT  \n";
    $sql .= "  LINEA_ID,     \n";
    $sql .= "  LINEA_DESCRIPCION     \n";
    $sql .= "FROM  \n";
    $sql .= "  LINEAS  \n";
    $sql .= "WHERE  \n";
    $sql .= " LINEA_DESCRIPCION LIKE ?  \n";
    $sql .= "ORDER BY  \n";
    $sql .= "  LINEA_DESCRIPCION  \n";
    $sql .= "LIMIT ?, ?  \n";
    $stm=$this->preparar($conexion, $sql); 
    $comienzo = strtoupper($comienzo) . "%";
    $stm->bind_param('sii', $comienzo, $desde, $cuantos);
    $stm->execute();
    $id = null;
    $descripcion = null;
    $stm->bind_result($id, $descripcion);
    $filas = array ();
    while ($stm->fetch()) {
      $bean = new Linea();
      $bean->setId($id);
      $bean->setDescripcion($descripcion);
      $filas[$id] = $bean;
    }
    $this->cierra($conexion, $stm);
    return $filas;
  }    
  
  public function selPorComienzoCuenta($cadena) {
    $conexion = $this->conectarse();
    $sql = "SELECT COUNT(*) FROM LINEAS ";
    $sql.= "WHERE  \n";
    $sql.= "LINEA_DESCRIPCION LIKE '" . $cadena . "%'  \n";
    $stm = $this->preparar($conexion, $sql);
    $stm->execute();
    $cuenta = null;
    $stm->bind_result($cuenta);
    $stm->fetch();
    $this->cierra($conexion, $stm);
    return $cuenta;
  }    


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO LINEAS (   \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  LINEA_DESCRIPCION,     \n"; 
         $sql.="  OBSERVACIONES)    \n"; 
         $sql.="VALUES (?, ?, ?)    \n"; 
         $nuevoId=$this->idUnico(); 
         $bean->setId($nuevoId); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("sss",$bean->getId(), $bean->getDescripcion(), $bean->getObservaciones()); 
         return $this->ejecutaYCierra($conexion, $stm, $nuevoId); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM LINEAS   \n"; 
         $sql.="WHERE LINEA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE LINEAS SET   \n"; 
         $sql.="  LINEA_DESCRIPCION=?,     \n"; 
         $sql.="  OBSERVACIONES=?     \n"; 
         $sql.="WHERE LINEA_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sss", $bean->getDescripcion(), $bean->getObservaciones(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  LINEA_ID,     \n"; 
         $sql.="  LINEA_DESCRIPCION,     \n"; 
         $sql.="  OBSERVACIONES    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  LINEAS  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  LINEA_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $descripcion=null;  
         $observaciones=null;  
         $stm->bind_result($id, $descripcion, $observaciones); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Linea();  
            $bean->setId($id);
            $bean->setDescripcion($descripcion);
            $bean->setObservaciones($observaciones);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM LINEAS "; 
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