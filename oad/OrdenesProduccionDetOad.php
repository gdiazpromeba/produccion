<?php 

   interface OrdenesProduccionDetOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $ordenProdCabId); 
      public function selTodosCuenta($ordenProdCabId); 
      
     /**
       * Devuelve un array simple (no beans) con los valores de tipo y forma de chapa necesarios para
       * los ítems de una orden de producción determinada.
       * (La orden de producción no debe estar "Completada", pues éstas no forman parte de la view).
      */
      public function terminacionesPorOP($ordProdCabId);
   } 

?>