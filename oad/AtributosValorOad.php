<?php 

   interface AtributosValorOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $atributoId); 
      public function selTodosCuenta($atributoId);
   } 

?>