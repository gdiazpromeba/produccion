<?php

   interface TerminacionesOad {

      public function selPorComienzo($desde, $cuantos, $cadena);
      public function selPorComienzoCuenta($cadena);
      public function obtiene($terminacionId);
      public function inserta($bean);
   }

?>