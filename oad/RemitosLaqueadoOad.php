<?php

   interface RemitosLaqueadoOad {
      public function selPedidosNoAsignados($desde, $cuantos);
      public function selPedidosNoAsignadosCuenta();
      public function insertaCabecera($bean);
      public function insertaDetalle($bean);
      public function selCabecera($desde, $cuantos,  $laqueadorId, $envioHasta, $envioDesde, $estado );
      public function selCabeceraCuenta($laqueadorId, $envioHasta, $envioDesde, $estado );
      public function modificaCabecera($bean);
      public function obtiene($id);
      public function selDetalles($desde, $cuantos,  $cabeceraId );
      public function selDetallesCuenta($cabeceraId );
   }

?>