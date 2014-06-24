<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/GruposUsuariosOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/GruposUsuariosSvc.php';  

   class GruposUsuariosSvcImpl implements GruposUsuariosSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new GruposUsuariosOadImpl();   
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene($id); 
         return $bean; 
      } 


      public function inserta($bean){ 
         return $this->oad->inserta($bean); 
      } 


      public function actualiza($bean){ 
         return $this->oad->actualiza($bean); 
      } 


      public function borra($id){ 
         return $this->oad->borra($id); 
      } 


      public function selTodos($desde, $cuantos, $usuarioId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $usuarioId); 
         return $arr; 
      } 


      public function selTodosCuenta($usuarioId){ 
         $cantidad=$this->oad->selTodosCuenta($usuarioId); 
         return $cantidad; 
      } 

   }
?>