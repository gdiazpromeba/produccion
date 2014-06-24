<?php

   interface AlertasMailSvc {

      public function selLaqueadosNoAsignados();
      public function selPaquetesNoEnviados();
      public function selPaquetesNoLaqueados();
      public function selPendientesPasadosPrometida();
      
   }

?>