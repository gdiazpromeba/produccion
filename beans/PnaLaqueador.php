<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class PnaLaqueador {
      private $clienteId;
      private $clienteNombre;
      private $pedidoCabeceraId;
      private $pedidoDetalleId;
      private $pedidoNumero;
      private $piezaId;
      private $piezaNombre;
      private $cantidad;
      private $fechaPrometida;
      private $terminacionId;
      private $terminacionNombre;


      //clienteId
      public function getClienteId(){
         return $this->clienteId;
      }

      public function setClienteId($valor){
         $this->clienteId=$valor;
      }


      //clienteNombre
      public function getClienteNombre(){
         return $this->clienteNombre;
      }

      public function setClienteNombre($valor){
         $this->clienteNombre=$valor;
      }

      //piezaId
      public function getPiezaId(){
         return $this->piezaId;
      }

      public function setPiezaId($valor){
         $this->piezaId=$valor;
      }


      //piezaNombre
      public function getPiezaNombre(){
         return $this->piezaNombre;
      }

      public function setPiezaNombre($valor){
         $this->piezaNombre=$valor;
      }


      //pedidoCabeceraId
      public function getPedidoCabeceraId(){
         return $this->pedidoCabeceraId;
      }

      public function setPedidoCabeceraId($valor){
         $this->pedidoCabeceraId=$valor;
      }

      //pedidoDetalleId
      public function getPedidoDetalleId(){
         return $this->pedidoDetalleId;
      }

      public function setPedidoDetalleId($valor){
         $this->pedidoDetalleId=$valor;
      }

      //pedidoNumero
      public function getPedidoNumero(){
         return $this->pedidoNumero;
      }

      public function setPedidoNumero($valor){
         $this->pedidoNumero=$valor;
      }

      //cantidad
      public function getCantidad(){
         return $this->cantidad;
      }

      //cantidad
      public function setCantidad($valor){
         $this->cantidad=$valor;
      }

      //terminacionId
      public function getTerminacionId(){
         return $this->terminacionId;
      }

      public function setTerminacionId($valor){
         $this->terminacionId=$valor;
      }

      //terminacionNombre
      public function getTerminacionNombre(){
         return $this->terminacionNombre;
      }

      public function setTerminacionNombre($valor){
         $this->terminacionNombre=$valor;
      }


      //fechaPrometida
      public function getFechaPrometida(){
         return $this->fechaPrometida;
      }

      public function getFechaPrometidaLarga(){
        return FechaUtils::dateTimeACadena($this->fechaPrometida);
      }

      public function getFechaPrometidaCorta(){
        return FechaUtils::dateTimeACadena($this->fechaPrometida);
      }


      public function setFechaPrometida($valor){
         $this->fechaPrometida=$valor;
      }

      public function setFechaPrometidaLarga($valor){
        $this->fechaPrometida=FechaUtils::cadenaAObjeto($valor);
      }

      public function setFechaPrometidaCorta($valor){
        $this->fechaPrometida=FechaUtils::cadenaDMAaObjeto($valor);
      }


   }
?>