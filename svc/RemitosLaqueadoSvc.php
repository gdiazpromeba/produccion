<?php

   interface RemitosLaqueadoSvc {

      public function selPedidosNoAsignados($desde, $cuantos);
      public function selPedidosNoAsignadosCuenta();
      public function genera($datosJSON);
      public function borraRemCab($id);

      /**
       *   Convierte el estado de este remito en 'Pendiente' (es decir, en el laqueador)
      */
      public function remiteRemCab($id);
      public function imprimeRemLaq($id);
   }

?>