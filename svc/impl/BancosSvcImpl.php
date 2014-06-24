<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/BancosOadImpl.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/BancosSvc.php';  

   class BancosSvcImpl implements BancosSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new BancosOadImpl();   
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


      public function selPorParte($cadena, $desde, $cuantos){ 
         $arr=$this->oad->selPorParte($cadena, $desde, $cuantos); 
         return $arr; 
      } 


      public function selPorParteCuenta($cadena){ 
         $cantidad=$this->oad->selPorParteCuenta($cadena); 
         return $cantidad; 
      } 

   }
?>