<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/OrdenesTerminacionDetOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/OrdenesTerminacionDetSvc.php';  

   class OrdenesTerminacionDetSvcImpl implements OrdenesTerminacionDetSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new OrdenesTerminacionDetOadImpl();   
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


      public function selTodos($desde, $cuantos, $cabId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $cabId); 
         return $arr; 
      } 


      public function selTodosCuenta($cabId){ 
         $cantidad=$this->oad->selTodosCuenta($cabId); 
         return $cantidad; 
      } 
      
  

   }
?>