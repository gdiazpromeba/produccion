<?php 

   interface RemitosCabeceraOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
      public function selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta, $numero);
      public function selReporteRemito($remitoCabeceraId); 
   } 

?>