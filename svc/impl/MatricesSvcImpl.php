<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/MatricesOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/MatricesSvc.php';  

   class MatricesSvcImpl implements MatricesSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new MatricesOadImpl();   
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


      public function selTodos($desde, $cuantos, $nombreOParte, $depositoId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $nombreOParte, $depositoId); 
         return $arr; 
      } 

      public function selTodosCuenta($nombreOParte, $depositoId){ 
         $cantidad=$this->oad->selTodosCuenta($nombreOParte, $depositoId);
         return $cantidad; 
      } 
      
  	  public function selPorComienzo($cadena, $desde, $cuantos){
        $arr=$this->oad->selPorComienzo($cadena, $desde, $cuantos);
        return $arr; 
	  } 
	  
      public function selPorComienzoCuenta($cadena){ 
         $cantidad=$this->oad->selPorComienzoCuenta($cadena);
         return $cantidad; 
      } 	       

   }
?>