<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PlanProdChapaCabOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PlanProdChapaCabSvc.php';  

   class PlanProdChapaCabSvcImpl implements PlanProdChapaCabSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PlanProdChapaCabOadImpl();   
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
      
      public function selPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo){
         $arr=$this->oad->selPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo); 
         return $arr; 
      }
      
      public function selPlanoCuenta($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo){
         $cantidad=$this->oad->selPlanoCuenta($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo); 
         return $cantidad; 
      }
      
      

   }
?>