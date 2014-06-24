<?php 

   interface PreciosGeneralesOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $sort, $dir, $idPieza, $nombrePiezaOParte, $efectivoDesde); 
      public function selTodosCuenta($pieza, $nombrePiezaOParte, $efectivoDesde); 
      public function selSillones();
      public function selSillas();
   } 

?>