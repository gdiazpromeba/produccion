<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ClientesOadImpl.php';  

   class ClientesSvcImpl { 
   	
      private $oad=null;

      function __construct(){ 
         $this->oad=new ClientesOadImpl();   
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
      
      public function selPorComienzoCuenta($cadena){
      	return $this->oad->selPorComienzoCuenta($cadena);
      }
      
      public function selPorComienzo($cadena, $desde, $cuantos){
      	return $this->oad->selPorComienzo($cadena, $desde, $cuantos);
      }

   }
?>