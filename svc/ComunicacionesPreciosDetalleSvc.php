<?php 

   interface ComunicacionesPreciosDetalleSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $comPrecCabId); 
      public function selTodosCuenta($comPrecCabId); 
      public function selReporteComunicacion($comPrecCabId);
      public function haceUsarGeneral($piezaId, $clienteId);
   } 

?>