<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';

   class Pedido {
      private $id;
      private $numero;
      private $clienteId;
      private $clienteNombre;
      private $fecha;
      private $fechaPrometida;
      private $referencia;
      private $estado;
      private $habilitado;
      private $items;

      public function getId(){
         return $this->id;
      }

      public function getNumero(){
         return $this->numero;
      }


      public function getClienteId(){
         return $this->clienteId;
      }

      public function getClienteNombre(){
         return $this->clienteNombre;
      }


      public function getReferencia(){
         return $this->referencia;
      }

      public function getEstado(){
         return $this->estado;
      }

      public function getHabilitado(){
         return $this->habilitado;
      }

      public function getItems(){
         return $this->items;
      }


      public function setId($valor){
         $this->id=$valor;
      }

      public function setNumero($valor){
         $this->numero=$valor;
      }

      public function setClienteId($valor){
         $this->clienteId=$valor;
      }

      public function setClienteNombre($valor){
         $this->clienteNombre=$valor;
      }


      //fecha
      public function setFecha($valor){
         $this->fecha=$valor;
      }

      public function setFechaLarga($valor){
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fecha=FechaUtils::creaDeCadena($valor);
      }

      public function setFechaCorta($valor){
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fecha=FechaUtils::cadenaDMAaObjeto($valor);
      }

      public function getFecha(){
         return $this->fecha;
      }

      public function getFechaLarga(){
         return FechaUtils::dateTimeaCadena($this->fecha);
      }

      public function getFechaCorta(){
         return FechaUtils::dateTimeaCadenaDMA($this->fecha);
      }


      //fecha prometida
      public function setFechaPrometida($valor){
         $this->fechaPrometida=$valor;
      }

      public function setFechaPrometidaLarga($valor){
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaPrometida=FechaUtils::creaDeCadena($valor);
      }

      public function setFechaPrometidaCorta($valor){
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaPrometida=FechaUtils::cadenaDMAaObjeto($valor);
      }

      public function getFechaPrometida(){
         return $this->fechaPrometida;
      }

      public function getFechaPrometidaLarga(){
         return FechaUtils::dateTimeaCadena($this->fechaPrometida);
      }

      public function getFechaPrometidaCorta(){
         return FechaUtils::dateTimeaCadenaDMA($this->fechaPrometida);
      }


      public function setReferencia($valor){
         $this->referencia=$valor;
      }


      public function setEstado($valor){
         $this->estado=$valor;
      }

      public function setHabilitado($valor){
         $this->habilitado=$valor;
      }

      public function setItems($valor){
         $this->items=$valor;
      }

   }
?>