<?php 

   interface MatricesOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $nombreOParte, $depositoId); 
      public function selTodosCuenta($nombreOParte, $depositoId);  
      public function selPorComienzo($comienzo, $desde, $cuantos);
      public function selPorComienzoCuenta($cadena);
   } 

?>