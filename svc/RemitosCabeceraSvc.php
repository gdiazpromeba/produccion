<?php 

   interface RemitosCabeceraSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta, $numero); 
      public function selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
      public function selReporteRemito($remitoCabeceraId); 
      
      /**
       * Anula un remito ya escrito, con las consecuencias adecuadas en los pedidos.
       */
      public function anulaRemito($remitoCabeceraId);
   } 

?>