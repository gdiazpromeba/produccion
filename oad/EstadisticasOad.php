<?php 

   interface EstadisticasOad { 
   	

   	  public function setFormato($conexion);
      public function montosPedidos($fechaDesde, $fechaHasta);
      public function montosRemitidos($fechaDesde, $fechaHasta);
      public function unidadesFichasPedidasEnPeriodo($fechaDesde, $fechaHasta, $fichas);
      public function unidadesFichasRemitidasEnPeriodo($fechaDesde, $fechaHasta, $fichas);
      public function mejoresFichasRemitidasEnUnidades($fechaDesde, $fechaHasta, $cuantas); 
      public function mejoresFichasPedidasEnUnidades($fechaDesde, $fechaHasta, $cuantas);
      public function montosFacturacion($fechaDesde, $fechaHasta);
      public function montosNC($fechaDesde, $fechaHasta);
      public function indicesInflacion($fechaDesde, $fechaHasta);
      public function precios($piezaId, $fechaDesde, $fechaHasta);

   } 

?>