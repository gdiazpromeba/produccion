<?php 


   interface EmpleadosSvc { 

      public function obtiene($id); 
      public function obtienePorTarjeta($tarjetaNumero);
      
      public function selPorComienzo($cadena, $desde, $cuantos);
      
      public function selPorComienzoCuenta($cadena);
      
      public function inserta($bean);
      public function actualiza($bean);
      public function selTodos($desde, $hasta, $apellido);
      public function selTodosCuenta($apellido);
      public function inhabilita($id); 
      public function borra($id);
      

  
      
      
      
   }
?>