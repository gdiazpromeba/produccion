<?php 


   interface PreciosEfectivosActualesSvc { 

      public function selEfectivosActuales($desde, $cuantos,  $clienteId, $piezaId, $nombrePiezaOParte); 
      public function selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte);
      public function obtienePrecio($clienteId, $piezaId); 
 
  

   }
?>