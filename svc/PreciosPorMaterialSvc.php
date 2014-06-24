<?php 

   interface PreciosPorMaterialSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $materialId); 
      public function selTodosCuenta($materialId); 
   } 

?>