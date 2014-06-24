<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PlanillasProduccionCabOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PlanillasProduccionCabSvc.php';  

   class PlanillasProduccionCabSvcImpl implements PlanillasProduccionCabSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PlanillasProduccionCabOadImpl();   
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
      
      public function selPlano($desde, $cuantos, $empleadoId, $estacionTrabajo,  $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada){
        $arr=$this->oad->selPlano($desde, $cuantos, $empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
        $cantidad=$this->oad->selPlanoCantidad($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
        foreach ($arr as $bean){
          $bean->setCantidadTotal($cantidad);
        }
        return $arr;
      }
      
      public function selPlanoCuenta($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada){
        $cantidad=$this->oad->selPlanoCuenta($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
        return $cantidad;
      }

   }
?>