<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FichasPorLineaOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/FichasPorLineaSvc.php';  

   class FichasPorLineaSvcImpl implements FichasPorLineaSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new FichasPorLineaOadImpl();   
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


      public function selTodos($desde, $cuantos, $lineaId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $lineaId); 
         return $arr; 
      } 


      public function selTodosCuenta($lineaId){ 
         $cantidad=$this->oad->selTodosCuenta($lineaId); 
         return $cantidad; 
      } 

   }
?>