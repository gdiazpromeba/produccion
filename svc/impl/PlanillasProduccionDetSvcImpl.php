<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PlanillasProduccionDetOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PlanillasProduccionDetSvc.php';  

   class PlanillasProduccionDetSvcImpl implements PlanillasProduccionDetSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PlanillasProduccionDetOadImpl();   
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


      public function selTodos($desde, $cuantos, $planProdCabId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $planProdCabId); 
         return $arr; 
      } 


      public function selTodosCuenta($planProdCabId){ 
         $cantidad=$this->oad->selTodosCuenta($planProdCabId); 
         return $cantidad; 
      } 
      
      public function selTodosPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizNombre){
        $arr=$this->oad->selTodosselTodosPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizNombre); 
        return $arr; 
      }
      
      public function selTodosPlanoCuenta($empleadoId, $fechaDesde, $fechaHasta, $matrizNombre){
        $cantidad=$this->oad->selTodosPlanoCuenta($empleadoId, $fechaDesde, $fechaHasta, $matrizNombre);
        return $cantidad;
      }
      

   }
?>