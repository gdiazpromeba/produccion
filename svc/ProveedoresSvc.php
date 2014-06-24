<?php 

   interface ProveedoresSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $nombreOParte, $rubros); 
      public function selTodosCuenta($nombreOParte, $rubros); 
   } 

?>