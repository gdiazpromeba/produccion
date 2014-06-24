<?php 

   interface ItemsCostoOad { 
      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function actualizaProceso($costoItemId, $procesoId, $procesoNombre, $tiempo, $dotacionSugerida, $ajuste);
      public function modificaMaterial($costoItemId, $materialId, $materialNombre, $cantidad); 
      public function actualizaIndice($id, $nuevoOrden);
      public function borra($id); 
      public function selPorPieza($pieza); 
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 

   } 

?>