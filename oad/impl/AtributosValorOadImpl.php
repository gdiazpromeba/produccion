<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AtributosValorOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/AtributoValor.php';  
//require_once('FirePHPCore/fb.php');

   class AtributosValorOadImpl extends AOD implements AtributosValorOad { 

      public function obtiene($id){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_ID,     \n"; 
         $sql.="  AV.ATRIBUTO_ID,     \n"; 
         $sql.="  A.ATRIBUTO_NOMBRE,     \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_NUMERICO,     \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_ALFANUMERICO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ATRIBUTOS_VALOR  AV  \n";
         $sql.="  INNER JOIN ATRIBUTOS A ON AV.ATRIBUTO_ID=A.ATRIBUTO_ID  \n";
         $sql.="WHERE  \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_ID='" . $id . "' \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $bean=new AtributoValor();  
         $id=null;  
         $atributoId=null;  
         $atributoNombre=null;  
         $valorNumerico=null;  
         $valorAlfanumerico=null;  
         $stm->bind_result($id, $atributoId, $atributoNombre, $valorNumerico, $valorAlfanumerico); 
         if ($stm->fetch()) { 
            $bean->setId($id);
            $bean->setAtributoId($atributoId);
            $bean->setAtributoNombre($atributoNombre);
            $bean->setValorNumerico($valorNumerico);
            $bean->setValorAlfanumerico($valorAlfanumerico);
         } 
         $this->cierra($conexion, $stm); 
         return $bean; 
      } 


      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO ATRIBUTOS_VALOR (   \n"; 
         $sql.="  ATRIBUTO_VALOR_ID,     \n"; 
         $sql.="  ATRIBUTO_ID,     \n"; 
         $sql.="  ATRIBUTO_VALOR_NUMERICO,     \n"; 
         $sql.="  ATRIBUTO_VALOR_ALFANUMERICO)    \n"; 
         $sql.="VALUES (?, ?, ?, ?)    \n"; 
         $bean->setId($this->idUnico()); 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ssds",$bean->getId(), $bean->getAtributoId(), $bean->getValorNumerico(), $bean->getValorAlfanumerico()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function borra($id){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM ATRIBUTOS_VALOR   \n"; 
         $sql.="WHERE ATRIBUTO_VALOR_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $id);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function actualiza($bean){ 
         $conexion=$this->conectarse(); 
         $sql="UPDATE ATRIBUTOS_VALOR SET   \n"; 
         $sql.="  ATRIBUTO_ID=?,     \n"; 
         $sql.="  ATRIBUTO_VALOR_NUMERICO=?,     \n"; 
         $sql.="  ATRIBUTO_VALOR_ALFANUMERICO=?     \n"; 
         $sql.="WHERE ATRIBUTO_VALOR_ID=?   \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("sdss", $bean->getAtributoId(),  $bean->getValorNumerico(), $bean->getValorAlfanumerico(), $bean->getId() ); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function selTodos($desde, $cuantos, $atributoId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_ID,     \n"; 
         $sql.="  AV.ATRIBUTO_ID,     \n"; 
         $sql.="  A.ATRIBUTO_NOMBRE,     \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_NUMERICO,     \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_ALFANUMERICO    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ATRIBUTOS_VALOR  AV  \n";
         $sql.="  INNER JOIN ATRIBUTOS A ON AV.ATRIBUTO_ID=A.ATRIBUTO_ID  \n";
         $sql.="WHERE 1=1  \n";
         if (!empty($atributoId)){
           $sql.="  AND AV.ATRIBUTO_ID='" . $atributoId . "'  \n";
         }
         $sql.="ORDER BY  \n"; 
         $sql.="  A.ATRIBUTO_NOMBRE,  \n"; 
         $sql.="  AV.ATRIBUTO_VALOR_ALFANUMERICO  \n";
         $sql.="LIMIT " . $desde . ", " . $cuantos . "  \n"; 
//         fb($sql);
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $atributoId=null;  
         $atributoNombre=null;  
         $valorNumerico=null;  
         $valorAlfanumerico=null;  
         $stm->bind_result($id, $atributoId, $atributoNombre, $valorNumerico, $valorAlfanumerico); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new AtributoValor();  
            $bean->setId($id);
            $bean->setAtributoId($atributoId);
            $bean->setAtributoNombre($atributoNombre);
            $bean->setValorNumerico($valorNumerico);
            $bean->setValorAlfanumerico($valorAlfanumerico);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($atributoId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM ATRIBUTOS_VALOR "; 
         $sql.="WHERE 1=1  \n";
         if (!empty($atributoId)){
           $sql.="  AND ATRIBUTO_ID='" . $atributoId . "'  \n";
         }
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