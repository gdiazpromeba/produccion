<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/OrdenesProduccionDetOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/OrdenesProduccionDetSvc.php';  

   class OrdenesProduccionDetSvcImpl implements OrdenesProduccionDetSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new OrdenesProduccionDetOadImpl();   
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


      public function selTodos($desde, $cuantos, $ordProcCabId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $ordProcCabId); 
         return $arr; 
      } 


      public function selTodosCuenta($ordProcCabId){ 
         $cantidad=$this->oad->selTodosCuenta($ordProcCabId); 
         return $cantidad; 
      } 
      
      public function reporteTerminacionesPorOP($ordProdCabId){
      	$arr=$this->oad->terminacionesPorOP($ordProdCabId);
      	return $arr;
      }      

   }
?>