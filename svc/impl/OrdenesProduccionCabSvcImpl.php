<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/OrdenesProduccionCabOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/OrdenesProduccionCabSvc.php';  
//require_once('FirePHPCore/fb.php');

   class OrdenesProduccionCabSvcImpl implements OrdenesProduccionCabSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new OrdenesProduccionCabOadImpl();   
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


      public function selTodos($desde, $cuantos, $sort, $dir, $ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $sort, $dir, $ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta); 
         return $arr; 
      } 


      public function selTodosCuenta($ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta){ 
         $cantidad=$this->oad->selTodosCuenta($ordenEstado, $ordenNumero, $fechaDesde, $fechaHasta); 
         return $cantidad; 
      } 
      
      public function sugiereNumero(){
        $max=$this->oad->maximoNumero()+1;
        return $max;                                       
      }     
      
      public function selReporteAltaOrden($ordProdCabId){
      	 $arr=$this->oad->selReporteAltaOrden($ordProdCabId);  
         return $arr; 
      } 

   }
?>