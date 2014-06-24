<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/MovimientosOadImpl.php';  

   class MovimientosSvcImpl { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new MovimientosOadImpl();   
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene(); 
         return $bean; 
      } 


      public function inserta($bean){ 
         return $this->oad->inserta(); 
      } 


      public function actualiza($bean){ 
         return $this->oad->actualiza(); 
      } 


      public function borra($id){ 
         return $this->oad->borra(); 
      } 


      public function selecciona($momentoDesde){ 
         $arr=$this->oad->selecciona($momentoDesde); 
         return $arr; 
      } 


      public function seleccionaCuenta($momentoDesde){ 
         $cantidad=$this->oad->seleccionaCuenta($momentoDesde); 
         return $cantidad; 
      } 
      


   }
?>