<?php 

   interface FacturasDetalleOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $facturaCabId); 
      public function selTodosCuenta($facturaCabId);
      /**
       * devuelve la suma de los importes de todos los items, es decir,
       * el subtotal antes de aplicarle el impuesto y descuento
       * @param unknown_type $facturaCabId
       */
      public function subtotal($facturaCabId); 
   } 

?>