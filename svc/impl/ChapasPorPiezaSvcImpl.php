<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ChapasPorPiezaOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/ChapasPorPiezaSvc.php';  

   class ChapasPorPiezaSvcImpl implements ChapasPorPiezaSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new ChapasPorPiezaOadImpl();   
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


      public function selTodos($desde, $cuantos, $piezaId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $piezaId); 
         return $arr; 
      } 


      public function selTodosCuenta($piezaId){ 
         $cantidad=$this->oad->selTodosCuenta($piezaId); 
         return $cantidad; 
      } 

   }
?>