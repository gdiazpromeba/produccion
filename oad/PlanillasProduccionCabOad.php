<?php 

   interface PlanillasProduccionCabOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta); 
      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta); 
      public function selPlano($desde, $cuantos, $empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
      public function selPlanoCuenta($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
      public function selPlanoCantidad($empleadoId, $estacionTrabajo, $fechaDesde, $fechaHasta, $matrizId, $matrizTipo, $reparada, $descartada);
   } 

?>