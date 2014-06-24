<?php 

   interface PlanProdChapaCabOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $empleado, $fechaDesde, $fechaHasta); 
      public function selTodosCuenta($empleado, $fechaDesde, $fechaHasta); 
   } 

?>