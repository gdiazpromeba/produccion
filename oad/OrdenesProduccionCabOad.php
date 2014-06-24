<?php 

   interface OrdenesProduccionCabOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $sort, $dir, $ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta); 
      public function selTodosCuenta($ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta);
      public function maximoNumero(); 
   } 

?>