<?php 

   interface InventarioMensualOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta();
      public function insertaOActualiza($depositoId, $clienteId, $piezaId, $año, $mes, $cantidad); 
   } 

?>