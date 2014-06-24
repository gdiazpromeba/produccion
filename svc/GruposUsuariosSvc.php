<?php 

   interface GruposUsuariosSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $usuarioId); 
      public function selTodosCuenta($usuarioId); 
   } 

?>