<?php 

   interface OrdenesTerminacionCabSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $ordenEstado, $sort, $dir, $ordenNumero, $fechaDesde, $fechaHasta); 
      public function selTodosCuenta($ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta);
      public function selReporte($ordTermCabId);
      public function sugiereNumero(); 
   } 

?>