<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ComunicacionesPreciosDetalleOadImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PreciosGeneralesOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/ComunicacionesPreciosDetalleSvc.php';
  

   class ComunicacionesPreciosDetalleSvcImpl implements ComunicacionesPreciosDetalleSvc { 
      private $oad=null; 
      private $oadPreGen=null;

      function __construct(){ 
         $this->oad=new ComunicacionesPreciosDetalleOadImpl();
         $this->oadPreGen=new PreciosGeneralesOadImpl();
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


      public function selTodos($desde, $cuantos, $comPrecCabId){ 
         $arr=$this->oad->selTodos($desde, $cuantos, $comPrecCabId);
         foreach($arr as $bean){
         	if ($bean->isUsaGeneral()){
         	  $bean->setPrecio($this->oadPreGen->obtienePrecioGeneral($bean->getPiezaId()));
         	}
         }          
         
         return $arr; 
      } 


      public function selTodosCuenta($comPrecCabId){ 
         $cantidad=$this->oad->selTodosCuenta($comPrecCabId); 
         return $cantidad; 
      } 
      
      public function selReporteComunicacion($comPrecCabId){
         $arr=$this->oad->selReporteComunicacion($comPrecCabId);
         //hago una pasada para los que usen general
         foreach($arr as &$fila){
         	if ($fila['usaGeneral']){
         	  $fila['precio']=$this->oadPreGen->obtienePrecioGeneral($fila['piezaId']);
         	}
         } 
         return $arr; 
      } 
      
      public function haceUsarGeneral($piezaId, $clienteId){
      	 $id=$this->oad->selIdDetalle($clienteId, $piezaId);
      	 $bean=$this->oad->obtiene($id);
      	 $bean->setUsaGeneral(true);
      	 return $this->oad->actualiza($bean);
      } 
      

   }
?>