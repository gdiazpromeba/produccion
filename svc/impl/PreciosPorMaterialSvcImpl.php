<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PreciosPorMaterialOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PreciosPorMaterialSvc.php';  

   class PreciosPorMaterialSvcImpl implements PreciosPorMaterialSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PreciosPorMaterialOadImpl();   
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


      public function selTodos($desde, $cuantos, $materialId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $materialId); 
         return $arr; 
      } 


      public function selTodosCuenta($materialId){ 
         $cantidad=$this->oad->selTodosCuenta( $materialId); 
         return $cantidad; 
      } 

   }
?>