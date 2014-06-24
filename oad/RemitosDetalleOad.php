<?php 

   interface RemitosDetalleOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $remitoCabeceraId); 
      public function selTodosCuenta($remitoCabeceraId); 
      public function selRemitosRelacionados($pedidoDetalleId);
   } 

?>