<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PreciosEfectivosActualesOadImpl.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PreciosEfectivosActualesSvc.php';  
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/PrecioEfectivoActual.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class PreciosEfectivosActualesSvcImpl implements PreciosEfectivosActualesSvc { 
      private $oad=null; 

      function __construct(){ 
         $this->oad=new PreciosEfectivosActualesOadImpl();   
      } 

      
      
      public function selEfectivosActuales($desde, $cuantos,  $clienteId, $piezaId, $nombrePiezaOParte){ 
         $arr=$this->oad->selEfectivosActuales($desde, $cuantos, $clienteId, $piezaId, $nombrePiezaOParte);
         return $arr;
      }
      
      public function selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte){ 
         $cantidad=$this->oad->selEfectivosActualesCuenta($clienteId, $piezaId, $nombrePiezaOParte); 
         return $cantidad; 
      }   
      
      public function obtienePrecio($clienteId, $piezaId){
        $precioEspecifico=$this->oad->obtienePrecioEspecifico($clienteId, $piezaId);
        if (empty($precioEspecifico)){
          $precioGeneral=$this->oad->obtienePrecioGeneral($piezaId);
          if (empty($precioGeneral)){
            return null;  
          }else{
            return $precioGeneral;
          }
        }else{
          return $precioEspecifico;
        }
      }     
  

   }
?>