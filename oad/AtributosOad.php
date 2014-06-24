<?php 

   interface AtributosOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 
      public function selValorAtributosPieza($piezaId);
   } 

?>