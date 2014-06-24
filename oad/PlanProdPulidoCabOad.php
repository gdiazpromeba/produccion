<?php 

   interface PlanProdPulidoCabOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $empleadoId, $fechaDesde, $fechaHasta); 
      public function selTodosCuenta($empleadoId, $fechaDesde, $fechaHasta); 
   } 

?>