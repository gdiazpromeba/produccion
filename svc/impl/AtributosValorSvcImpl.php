<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/AtributosValorOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/AtributosValorSvc.php';  

   class AtributosValorSvcImpl implements AtributosValorSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new AtributosValorOadImpl();   
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


      public function selTodos($desde, $cuantos, $atributoId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $atributoId); 
         return $arr; 
      } 


      public function selTodosCuenta($atributoId){ 
         $cantidad=$this->oad->selTodosCuenta($atributoId); 
         return $cantidad; 
      } 

   }
?>