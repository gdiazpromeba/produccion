<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AtributosOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Atributo.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ValorAtributosPorPieza.php';
//require_once('FirePHPCore/fb.php');
  
   class AtributosOadImpl extends AOD implements AtributosOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  ATRIBUTO_ID,     \n"; 
         $sql.="  ATRIBUTO_NOMBRE,     \n"; 
         $sql.="  ATRIBUTO_NUMERICO,     \n"; 
         $sql.="  UNIDAD_ID    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ATRIBUTOS  \n"; 
         $sql.="WHERE  \n"; 
         $sql.="  ATRIBUTO_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new Atributo();  
         $id=null;  
         $nombre=null;  
         $numerico=null;  
         $unidad=null;  
         $stm->bind_result($id, $nombre, $numerico, $unidad); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setNumerico($numerico);
            $bean->setUnidad($unidad);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO ATRIBUTOS (   \n"; 
         $sql.="  ATRIBUTO_ID,     \n"; 
         $sql.="  ATRIBUTO_NOMBRE,     \n"; 
         $sql.="  ATRIBUTO_NUMERICO,     \n"; 
         $sql.="  UNIDAD_ID)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $bean->setId($this->idUnico()); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssis",$bean->getId(), $bean->getNombre(), $bean->getNumerico(), $bean->getUnidad());
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM ATRIBUTOS   \n"; 
         $sql.="WHERE ATRIBUTO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE ATRIBUTOS SET   \n"; 
         $sql.="  ATRIBUTO_NOMBRE=?,     \n"; 
         $sql.="  ATRIBUTO_NUMERICO=?,     \n"; 
         $sql.="  UNIDAD_ID=?     \n"; 
         $sql.="WHERE ATRIBUTO_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("siss", $bean->getNombre(), $bean->getNumerico(), $bean->getUnidad(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  ATRIBUTO_ID,     \n"; 
         $sql.="  ATRIBUTO_NOMBRE,     \n"; 
         $sql.="  ATRIBUTO_NUMERICO,     \n"; 
         $sql.="  UNIDAD_ID    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ATRIBUTOS  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  ATRIBUTO_ID  \n"; 
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $numerico=null;  
         $unidad=null;  
         $stm->bind_result($id, $nombre, $numerico, $unidad); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new Atributo();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $bean->setNumerico($numerico);
            $bean->setUnidad($unidad);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 
      
      public function selValorAtributosPieza($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  VPP.ATRIBUTO_VALOR_ID,     \n"; 
         $sql.="  V.ATRIBUTO_ID,     \n"; 
         $sql.="  A.ATRIBUTO_NOMBRE,     \n";
         $sql.="  A.ATRIBUTO_NUMERICO,     \n";
         $sql.="  V.ATRIBUTO_VALOR_NUMERICO,     \n"; 
         $sql.="  V.ATRIBUTO_VALOR_ALFANUMERICO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ATRIBUTOS_VALOR_POR_PIEZA  VPP  \n";
         $sql.="  INNER JOIN ATRIBUTOS_VALOR V ON VPP.ATRIBUTO_VALOR_ID=V.ATRIBUTO_VALOR_ID   \n";
         $sql.="  INNER JOIN ATRIBUTOS A ON V.ATRIBUTO_ID=A.ATRIBUTO_ID   \n";
         $sql.="WHERE  \n"; 
         $sql.="  VPP.PIEZA_ID='" . $piezaId . "'  \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  VPP.ATRIBUTO_VALOR_ID  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
  	     $id=null;
  	     $atributoId=null;
  	     $atributoNombre=null;
  	     $atributoNumerico=null;
  	     $valorNumerico=null;
  	     $valorAlfanumerico=null;  
         $stm->bind_result($id, $atributoId, $atributoNombre, $atributoNumerico, $valorNumerico, $valorAlfanumerico); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new ValorAtributosPorPieza();  
            $bean->setId($id);
            $bean->setAtributoId($atributoId);
            $bean->setAtributoNombre($atributoNombre);
            $bean->setNumerico($atributoNumerico>0);
            if ($bean->isNumerico()){
            	$bean->setValor($valorNumerico);
            }else{
            	$bean->setValor($valorAlfanumerico);
            }
            $filas[]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      }       


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM ATRIBUTOS "; 
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