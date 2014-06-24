<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/FichasOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/FichasSvc.php';  

   class FichasSvcImpl implements FichasSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new FichasOadImpl();   
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

      public function selPorComienzo($cadena, $desde, $cuantos){
         $arr=$this->oad->selPorComienzo($cadena, $desde, $cuantos); 
         return $arr; 
      }
      
      public function selPorComienzoCuenta($cadena){
         $arr=$this->oad->selPorComienzoCuenta($cadena); 
         return $arr; 
      }      


      public function selTodos($desde, $cuantos, $numeroOParte, $parteContenido){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $numeroOParte, $parteContenido); 
         return $arr; 
      } 


      public function selTodosCuenta($numeroOParte, $parteContenido){ 
         $cantidad=$this->oad->selTodosCuenta($numeroOParte, $parteContenido); 
         return $cantidad; 
      } 

   }
?>