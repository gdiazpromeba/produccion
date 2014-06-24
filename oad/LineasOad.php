<?php 

   interface LineasOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selPorComienzo($cadena, $desde, $cuantos);
      public function selPorComienzoCuenta($cadena);
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 
   } 

?>