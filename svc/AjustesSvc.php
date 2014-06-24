<?php 

   interface AjustesSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 
      public function selPorComienzo($cadena, $desde, $cuantos);
      public function selPorComienzoCuenta($cadena);
      
   } 

?>