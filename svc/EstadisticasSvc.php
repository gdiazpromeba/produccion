<?php 

   interface EstadisticasSvc { 
      public function montosPedidosYRemitidos($fechaDesde, $fechaHasta);
      public function mejoresFichasEnUnidades($fechaDesde, $fechaHasta, $cuantas); 
      public function facturacion($fechaDesde, $fechaHasta); 
      public function remitido($fechaDesde, $fechaHasta);
   } 

?>