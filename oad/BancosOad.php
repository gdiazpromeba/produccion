<?php 

   interface BancosOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selPorParte($cadena, $desde, $cuantos); 
      public function selPorParteCuenta($cadena); 
   } 

?>