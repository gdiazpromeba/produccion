<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/LineasOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/LineasSvc.php';  

   class LineasSvcImpl implements LineasSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new LineasOadImpl();   
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


      public function selTodos($desde, $cuantos){ 
         $arr=$this->oad->selTodos($desde, $cuantos); 
         return $arr; 
      } 


      public function selTodosCuenta(){ 
         $cantidad=$this->oad->selTodosCuenta(); 
         return $cantidad; 
      } 
      

      public function selPorComienzo($cadena, $desde, $cuantos){
         $arr=$this->oad->selPorComienzo($cadena, $desde, $cuantos); 
         return $arr; 
      }
      
      public function selPorComienzoCuenta($cadena){
         $arr=$this->oad->selPorComienzoCuenta($cadena); 
         return $arr; 
      }        

   }
?>