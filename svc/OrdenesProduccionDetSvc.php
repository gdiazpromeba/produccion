<?php 

   interface OrdenesProduccionDetSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $ordProcCabId); 
      public function selTodosCuenta($ordProcCabId); 
      
      /**
       * calcula la cantidad y tipos de chapa que son necesarios para los ítems de una
       * determinada orden de producción 
       */
      public function reporteTerminacionesPorOP($ordProdCabId);
   } 

?>