<?php 

   interface TiposPataSvc { 
      public function selTodos($desde, $cuantos); 
      public function selTodosCuenta(); 
      public function reportePendientes();
   } 

?>