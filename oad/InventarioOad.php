<?php 

   interface InventarioOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function borraTodo(); 
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 
      public function insertaOActualiza($depositoId, $clienteId, $piezaId, $cantidad);
      public function selTodosPorParams($desde, $cuantos, $clienteId, $depositoId, $piezaId);
      public function selTodosPorParamsCuenta($clienteId, $depositoId, $piezaId);
      public function selTodosSinCliente($desde, $cuantos);    
      public function selTodosSinClienteCuenta();
      public function selTodosSinDeposito($desde, $cuantos);    
      public function selTodosSinDepositoCuenta();         
   } 

?>