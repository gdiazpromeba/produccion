<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/LineasPorMatrizOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/LineasPorMatrizSvc.php';  

   class LineasPorMatrizSvcImpl implements LineasPorMatrizSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new LineasPorMatrizOadImpl();   
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene($id); 
         return $bean; 
      } 


      public function inserta($bean){ 
         return $this->oad->inserta($bean); 
      } 


      public function actualiza($bean){ 
         return $this->oad->actualiza($bean); 
      } 


      public function borra($id){ 
         return $this->oad->borra($id); 
      } 


      public function selTodos($desde, $cuantos, $matrizId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $matrizId); 
         return $arr; 
      } 


      public function selTodosCuenta($matrizId){ 
         $cantidad=$this->oad->selTodosCuenta($matrizId); 
         return $cantidad; 
      } 

   }
?>