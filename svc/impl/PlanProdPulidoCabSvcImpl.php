<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PlanProdPulidoCabOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PlanProdPulidoCabSvc.php';  

   class PlanProdPulidoCabSvcImpl implements PlanProdPulidoCabSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PlanProdPulidoCabOadImpl();   
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


      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta); 
         return $arr; 
      } 


      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta){ 
         $cantidad=$this->oad->selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta); 
         return $cantidad; 
      } 

   }
?>