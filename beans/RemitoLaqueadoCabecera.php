<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';


   class RemitoLaqueadoCabecera {
      private $id;
      private $laqueadorId;
      private $laqueadorNombre;
      private $fechaEnvio;
      private $numero;
      private $estado;

      //id
      public function getId(){
         return $this->id;
      }

      public function setId($valor){
         $this->id=$valor;
      }


      //laqueadorId
      public function getLaqueadorId(){
         return $this->laqueadorId;
      }

      public function setLaqueadorId($valor){
         $this->laqueadorId=$valor;
      }

      //laqueadorNombre
      public function getLaqueadorNombre(){
         return $this->laqueadorNombre;
      }

      public function setLaqueadorNombre($valor){
         $this->laqueadorNombre=$valor;
      }

      //fechaEnvio
      public function getFechaEnvio(){
         return $this->fechaEnvio;
      }

      public function getFechaEnvioLarga(){
         return FechaUtils::dateTimeaCadena($this->fechaEnvio);
      }

      public function getFechaEnvioCorta(){
         return FechaUtils::dateTimeaCadenaDMA($this->fechaEnvio);
      }

      public function setEnvioFecha($valor){
         $this->fechaEnvio=$valor;
      }

      public function setFechaEnvioLarga($valor){
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaEnvio=FechaUtils::creaDeCadena($valor);
      }

      public function setFechaEnvioCorta($valor){
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaEnvio=FechaUtils::cadenaDMAaObjeto($valor);
      }

      //numero
      public function getNumero(){
         return $this->numero;
      }

      public function setNumero($valor){
         $this->numero=$valor;
      }

      //estado
      public function getEstado(){
         return $this->estado;
      }

      public function setEstado($valor){
         $this->estado=$valor;
      }

   }
?>