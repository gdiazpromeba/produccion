<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/EmpleadosSvc.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/EmpleadosOadImpl.php';
//require_once('FirePHPCore/fb.php');

   class EmpleadosSvcImpl implements EmpleadosSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new EmpleadosOadImpl();   
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene($id); 
         return $bean; 
      }

      public function obtienePorTarjeta($tarjetaNumero){ 
         $bean=$this->oad->obtienePorTarjeta($tarjetaNumero); 
         return $bean; 
      }      
      
      
      
      
      public function selPorComienzo($cadena, $desde, $cuantos){
      	return $this->oad->selPorComienzo($cadena, $desde, $cuantos);
      }      
      
      public function selPorComienzoCuenta($cadena){
      	return $this->oad->selPorComienzoCuenta($cadena);
      }
      
      public function selTodos($desde, $hasta, $apellido){
      	return $this->oad->selTodos($desde, $hasta, $apellido);
      }      
      
      public function selTodosCuenta($apellido){
      	return $this->oad->selTodosCuenta($apellido);
      }      
      
      public function inserta($bean){ 
         return $this->oad->inserta($bean); 
      }

      public function actualiza($bean){ 
         return $this->oad->actualiza($bean); 
      }

      public function inhabilita($id){ 
         return $this->oad->inhabilita($id); 
      }

      public function borra($id){ 
         return $this->oad->borra($id); 
      }      
      
      
      
      
                   
      
   }
?>