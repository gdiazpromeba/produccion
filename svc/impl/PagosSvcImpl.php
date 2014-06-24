<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PagosOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PagosSvc.php';  
//require_once('FirePHPCore/fb.php4');

   class PagosSvcImpl implements PagosSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PagosOadImpl();   
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


      public function selTodos($desde, $cuantos, $pedidoCabeceraId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $pedidoCabeceraId); 
         return $arr; 
      } 


      public function selTodosCuenta($pedidoCabeceraId){ 
         $cantidad=$this->oad->selTodosCuenta($pedidoCabeceraId); 
         return $cantidad; 
      } 

   }
?>