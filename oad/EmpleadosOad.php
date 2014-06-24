<?php 

   interface EmpleadosOad { 

      public function obtiene($id); 
      public function obtienePorTarjeta($tarjetaNumero);
      public function selPorComienzo($cadena, $desde, $cuantos); 
      
      /**
       * dada la tarjeta de un empleado, devuelve el conjunto ordenado de períodos
       * que forman su horario actual. Cada período está representados por 2 cadenas
       * de formato horario, por ejemplo, '12:00' - '17:00' 
       */
      public function selHorarioActual($tarjetaNumero);
      
      public function inserta($bean);
      public function actualiza($bean);
      public function selTodos($desde, $hasta, $apellido);
      public function selTodosCuenta($apellido); 
      
     
   } 

?>