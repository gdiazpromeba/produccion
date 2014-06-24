<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';


   class RemitoLaqueadoDetalle {
      private $id;
      private $cabeceraId;
      private $item;
      private $pedidoDetalleId;
      private $cantidad;
      //campos de join
      private $clienteNombre;
      private $terminacionNombre;
      private $piezaNombre;


      //id
      public function getId(){
         return $this->id;
      }

      public function setId($valor){
         $this->id=$valor;
      }


      //cabeceraId
      public function getCabeceraId(){
         return $this->cabeceraId;
      }

      public function setCabeceraId($valor){
         $this->cabeceraId=$valor;
      }

      //item
      public function getItem(){
         return $this->item;
      }

      public function setItem($valor){
         $this->item=$valor;
      }

      //pedidoDetalleId
      public function getPedidoDetalleId(){
         return $this->pedidoDetalleId;
      }

      public function setPedidoDetalleId($valor){
         $this->pedidoDetalleId=$valor;
      }

      //cantidad
      public function getCantidad(){
         return $this->cantidad;
      }

      public function setCantidad($valor){
         $this->cantidad=$valor;
      }
      
      //clienteNombre
      public function getClienteNombre(){
         return $this->clienteNombre;
      }

      public function setClienteNombre($valor){
         $this->clienteNombre=$valor;
      }      
      
      //terminacionNombre
      public function getTerminacionNombre(){
         return $this->terminacionNombre;
      }

      public function setTerminacionNombre($valor){
         $this->terminacionNombre=$valor;
      }  
      
      //piezaNombre
      public function getPiezaNombre(){
         return $this->piezaNombre;
      }

      public function setPiezaNombre($valor){
         $this->piezaNombre=$valor;
      }        

   }
?>