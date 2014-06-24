<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/MaterialesOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/MaterialesSvc.php';

   class MaterialesSvcImpl implements MaterialesSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new MaterialesOadImpl();   
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

      public function inhabilita($id){ 
         return $this->oad->inhabilita($id); 
      } 

      public function selTodos($desde, $cuantos, $nombreOParte){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $nombreOParte); 
         return $arr; 
      } 


      public function selTodosCuenta($nombreOParte){ 
         $cantidad=$this->oad->selTodosCuenta($nombreOParte); 
         return $cantidad; 
      } 
      
      public function selPorComienzo($cadena, $desde, $cuantos){
         $cantidad=$this->oad->selPorComienzo($cadena, $desde, $cuantos); 
         return $cantidad; 
      }
      
      public function selPorComienzoCuenta($cadena){
         $cantidad=$this->oad->selPorComienzoCuenta($cadena); 
         return $cantidad; 
      } 

   }
?>