<?php 

   interface PiezasOad { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function inhabilita($id); 
      public function selTodos($desde, $cuantos, $nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo); 
      public function selTodosCuenta($nombreOParte, $piezaFicha, $piezaGenericaId, $valoresAtributo); 
      public function selPorComienzo($desde, $cuantos, $cadena); 
      public function selPorComienzoCuenta($cadena);       
   } 

?>