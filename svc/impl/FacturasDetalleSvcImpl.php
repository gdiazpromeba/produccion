<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FacturasDetalleOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/FacturasDetalleSvc.php';  

   class FacturasDetalleSvcImpl implements FacturasDetalleSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new FacturasDetalleOadImpl();   
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


      public function selTodos($desde, $cuantos, $facturaCabId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $facturaCabId); 
         return $arr; 
      } 


      public function selTodosCuenta($facturaCabId){ 
         $cantidad=$this->oad->selTodosCuenta($facturaCabId); 
         return $cantidad; 
      } 

   }
?>