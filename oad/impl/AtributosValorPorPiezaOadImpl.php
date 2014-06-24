<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AtributosValorPorPiezaOad.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/AtributoValorPorPieza.php';  

   class AtributosValorPorPiezaOadImpl extends AOD implements AtributosValorPorPiezaOad { 



      public function inserta($bean){ 
         $conexion=$this->conectarse(); 
         $sql="INSERT INTO ATRIBUTOS_VALOR_POR_PIEZA (   \n"; 
         $sql.="  ATRIBUTO_VALOR_ID,     \n"; 
         $sql.="  PIEZA_ID)    \n"; 
         $sql.="VALUES (?, ?)    \n"; 
         $stm=$this->preparar($conexion, $sql); 
         $stm->bind_param("ss",$bean->getAtributoValorId(), $bean->getPiezaId()); 
         return $this->ejecutaYCierra($conexion, $stm); 
      } 


      public function borra($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="DELETE FROM ATRIBUTOS_VALOR_POR_PIEZA   \n"; 
         $sql.="WHERE PIEZA_ID=? \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->bind_param("s", $piezaId);  
         return $this->ejecutaYCierra($conexion, $stm); 
      } 



      public function selTodos($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  ATRIBUTO_VALOR_ID,     \n"; 
         $sql.="  PIEZA_ID    \n"; 
         $sql.="FROM  \n"; 
         $sql.="  ATRIBUTOS_VALOR_POR_PIEZA  \n";
         $sql.="WHERE  \n"; 
         $sql.="  PIEZA_ID='" . $piezaId . "'  \n";
         $sql.="ORDER BY  \n"; 
         $sql.="  ATRIBUTO_VALOR_ID  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $atributoValorId=null;  
         $piezaId=null;  
         $stm->bind_result($atributoValorId, $piezaId); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new AtributoValorPorPieza();  
            $bean->setAtributoValorId($atributoValorId);
            $bean->setPiezaId($piezaId);
            $filas[]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta($piezaId){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM ATRIBUTOS_VALOR_POR_PIEZA ";
         $sql.="WHERE  \n"; 
         $sql.="  PIEZA_ID='" . $piezaId . "'  \n";
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