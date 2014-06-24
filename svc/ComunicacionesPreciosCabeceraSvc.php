<?php 

   interface ComunicacionesPreciosCabeceraSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $fechaDesde, $fechaHasta);
      public function selTodosCuenta($clienteId, $fechaDesde, $fechaHasta);
      public function duplica($comPrecCabId, $nuevaFecha, $variacion);
      
      /**
       * crea una lista de precios a partir de los pedidos
       */
      public function creaDePedidos($clienteId, $comPrecCabId, $fechaDesde);
   } 

?>