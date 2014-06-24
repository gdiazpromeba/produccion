<?php 

   interface FacturasCabeceraOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito); 
      public function selTodosCuenta($clienteId, $fechaDesde, $fechaHasta, $estado, $notaCredito);
      public function getMaxNumero();
      public function selReporteFactura($facturaCabeceraId);
   } 

?>