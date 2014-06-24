<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/CategoriasLaboralesOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/CategoriasLaboralesOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/CategoriasLaboralesSvc.php'; 


   class CategoriasLaboralesSvcImpl implements CategoriasLaboralesSvc{ 

      function __construct(){ 
         $this->aod=new CategoriasLaboralesOadImpl();
      } 

      public function obtiene($id){ 
         $bean=$this->aod->obtiene(); 
         return $bean; 
      } 


      public function inserta($bean){ 
         return $this->aod->inserta(); 
      } 


      public function actualiza($bean){ 
         return $this->aod->actualiza(); 
      } 


      public function borra($id){ 
         return $this->aod->borra(); 
      } 


      public function selTodos($desde, $cuantos){ 
         $arr=$this->aod->selTodos($desde, $cuantos); 
         return $arr; 
      } 


      public function selTodosCuenta(){ 
         $cantidad=$this->aod->selTodosCuenta(); 
         return $cantidad; 
      }
      
      
      

   }
?>