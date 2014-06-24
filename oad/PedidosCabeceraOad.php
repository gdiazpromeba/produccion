<?php 

   interface PedidosCabeceraOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function inhabilita($id);
      public function selTodos($desde, $cuantos,  $sort, $dir, $clienteId, $pedidoEstado, $fechaDesde, $fechaHasta);
      public function selTodosCuenta($clienteId, $pedidoEstado, $fechaDesde, $fechaHasta); 
      
      public function selReporteSeñas();
   } 

?>