<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PiezasGenericasOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PiezasGenericasSvc.php';

   class PiezasGenericasSvcImpl implements PiezasGenericasSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PiezasGenericasOadOadImpl();   
      } 

      public function obtiene($id){ 
         $bean=$this->oad->obtiene(); 
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


      public function selTodos($desde, $cuantos){ 
         $arr=$this->oad->selTodos($desde, $cuantos); 
         return $arr; 
      } 


      public function selTodosCuenta(){ 
         $cantidad=$this->oad->selTodosCuenta(); 
         return $cantidad; 
      } 
      
      public function selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha){
         $arr=$this->oad->selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha); 
         return $arr; 

      }
      
      public function selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha){
         $cantidad=$this->oad->selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha);                             
      }       

   }
?>