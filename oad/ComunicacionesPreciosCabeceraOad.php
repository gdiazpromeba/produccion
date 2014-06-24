<?php 

   interface ComunicacionesPreciosCabeceraOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos ($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta);
      public function selTodosCuenta( $clienteId, $fechaDesde, $fechaHasta);
   } 

?>