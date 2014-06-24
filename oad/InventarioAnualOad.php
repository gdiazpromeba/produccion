<?php 

   interface InventarioAnualOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function borraDesde($añoDesde);
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 
      public function insertaOActualiza($depositoId, $clienteId, $piezaId, $año, $cantidad);
   } 

?>