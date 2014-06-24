<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ProveedoresOadImpl.php';  

   class ProveedoresSvcImpl { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new ProveedoresOadImpl();   
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene(); 
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


      public function selTodos($desde, $cuantos, $nombreOParte, $rubros){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $nombreOParte, $rubros); 
         return $arr; 
      } 


      public function selTodosCuenta($nombreOParte, $rubros){ 
         $cantidad=$this->oad->selTodosCuenta($nombreOParte, $rubros); 
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