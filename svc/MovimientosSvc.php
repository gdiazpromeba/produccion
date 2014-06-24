<?php 

   interface MovimientosSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selecciona($momentoDesde); 
      public function seleccionaCuenta($momentoDesde); 
   } 

?>