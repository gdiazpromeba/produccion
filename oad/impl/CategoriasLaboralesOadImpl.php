<?php 


require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/CategoriasLaboralesOad.php';  

   class CategoriasLaboralesOadImpl extends AOD  { 

      public function selTodos($desde, $cuantos){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT  \n"; 
         $sql.="  CATEGORIA_LABORAL_ID,     \n"; 
         $sql.="  CATEGORIA_NOMBRE    \n";
         $sql.="FROM  \n"; 
         $sql.="  CATEGORIAS_LABORALES \n"; 
         $sql.="ORDER BY  \n"; 
         $sql.="  CATEGORIA_NOMBRE  \n"; 
         $stm=$this->preparar($conexion, $sql);  
         $stm->execute();  
         $id=null;  
         $nombre=null;  
         $stm->bind_result($id, $nombre); 
         $filas = array(); 
         while ($stm->fetch()) { 
            $bean=new CategoriaLaboral();  
            $bean->setId($id);
            $bean->setNombre($nombre);
            $filas[$id]=$bean; 
         } 
         $this->cierra($conexion, $stm); 
         return $filas; 
      } 


      public function selTodosCuenta(){ 
         $conexion=$this->conectarse(); 
         $sql="SELECT COUNT(*) FROM CATEGORIAS_LABORALES"; 
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