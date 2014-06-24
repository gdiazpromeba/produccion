<?php 

   interface ComunicacionesPreciosDetalleOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $comPrecCabId); 
      public function selTodosCuenta($comPrecCabId); 
      public function selReporteComunicacion($comPrecCabId);
      
      /**
       * devuelve el ID de fila más actual para hoy, para el cliente y la pieza dados como parámetro.
       */
      public function selIdDetalle($clienteId, $piezaId);
   } 

?>