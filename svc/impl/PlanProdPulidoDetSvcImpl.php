<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PlanProdPulidoDetOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PlanProdPulidoDetSvc.php';  

   class PlanProdPulidoDetSvcImpl implements PlanProdPulidoDetSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PlanProdPulidoDetOadImpl();   
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


      public function selTodos($desde, $cuantos, $ppCabId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $ppCabId); 
         return $arr; 
      } 


      public function selTodosCuenta($ppCabId){ 
         $cantidad=$this->oad->selTodosCuenta($ppCabId); 
         return $cantidad; 
      } 

   }
?>