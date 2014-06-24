<?php 

   interface PreciosPorMaterialOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $materialId); 
      public function selTodosCuenta($materialId); 
      public function selVistaPreciosPorMaterial($materialIds);
   } 

?>