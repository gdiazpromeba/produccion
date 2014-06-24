<?php 

   interface AtributosValorPorPiezaOad { 

      public function inserta($bean); 
      public function borra($piezaId); 
      public function selTodos($piezaId); 
      public function selTodosCuenta($piezaId); 
   } 

?>