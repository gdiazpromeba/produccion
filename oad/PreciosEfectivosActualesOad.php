<?php 
   interface PreciosEfectivosActualesOad  { 
   	
      public function selEfectivosActuales($desde, $cuantos, $clienteId, $piezaId, $nombrePiezaOParte);
      public function selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte);
   
   }
   
?>