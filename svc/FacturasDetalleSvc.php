<?php 

   interface FacturasDetalleSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $facturaCabId); 
      public function selTodosCuenta($facturaCabId); 
   } 

?>