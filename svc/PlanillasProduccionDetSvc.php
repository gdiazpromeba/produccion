<?php 

   interface PlanillasProduccionDetSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $planProdCabId); 
      public function selTodosCuenta($planProdCabId); 
      public function selTodosPlano($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta, $matrizNombre);
      public function selTodosPlanoCuenta($empleadoId, $fechaDesde, $fechaHasta, $matrizNombre);
      
   } 

?>