<?php 

   interface MovimientosOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function borraDesde($momentoDesde); 
      public function selecciona($momentoDesde); 
      public function seleccionaCuenta($momentoDesde);  
   } 

?>