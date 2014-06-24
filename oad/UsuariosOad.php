<?php 

   interface UsuariosOad { 

      public function obtiene($id);
      public function obtienePorUid($uid); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function inhabilita($id); 
      public function selTodos($desde, $cuantos, $nombreOParte, $grupoId); 
      public function selTodosCuenta($nombreOParte, $grupoId); 
      public function validaUsuario($login, $clave);
   } 

?>