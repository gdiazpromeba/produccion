<?php 

   interface ClientesSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function inhabilita($id);
      public function selTodos($desde, $cuantos, $nombreOParte); 
      public function selTodosCuenta($nombreOParte); 
      public function selPorComienzoCuenta($cadena);
      public function selPorComienzo($cadena, $desde, $cuantos); 
   } 

?>