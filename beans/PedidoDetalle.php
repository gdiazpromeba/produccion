<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

   class PedidoDetalle {
      private $id;
      private $cabeceraId;
      private $piezaId;
      private $piezaNombre;
      private $cantidad;
      private $remitidos;
      private $sinPatas;
      private $observaciones;
      private $precio;
      private $pedidoNumero;
      private $terminacionId;
      private $terminacionNombre;

      public function getId(){
         return $this->id;
      }

      public function getCabeceraId(){
         return $this->cabeceraId;
      }


      public function getPiezaId(){
         return $this->piezaId;
      }

      public function getPiezaNombre(){
         return $this->piezaNombre;
      }

      public function getCantidad(){
         return $this->cantidad;
      }

      public function getRemitidos(){
         return $this->remitidos;
      }


      public function getSinPatas(){
         return $this->sinPatas;
      }

      public function getFechaPrometidaLarga(){
        return FechaUtils::dateTimeACadena($this->fechaPrometida);
      }

      public function getFechaPrometidaCorta(){
        return FechaUtils::dateTimeACadena($this->fechaPrometida);
      }


      public function getObservaciones(){
         return $this->observaciones;
      }

      public function getPrecio(){
         return $this->precio;
      }

      public function getPedidoNumero(){
        return $this->pedidoNumero;
      }

      public function getTerminacionId(){
        if (empty($this->terminacionId)){
          return null;
        }else{
          return $this->terminacionId;
        }
      }

      public function getTerminacionNombre(){
	    if (empty($this->terminacionNombre)){
	      return null;
	    }else{
	      return $this->terminacionNombre;
	    }
      }


      public function setId($valor){
         $this->id=$valor;
      }

      public function setCabeceraId($valor){
         $this->cabeceraId=$valor;
      }


      public function setPiezaId($valor){
         $this->piezaId=$valor;
      }

      public function setPiezaNombre($valor){
         $this->piezaNombre=$valor;
      }

      public function setCantidad($valor){
         $this->cantidad=$valor;
      }

      public function setRemitidos($valor){
         $this->remitidos=$valor;
      }

      public function setSinPatas($valor){
         $this->sinPatas=$valor;
      }

      public function setObservaciones($valor){
         $this->observaciones=$valor;
      }

      public function setPrecio($valor){
         $this->precio=$valor;
      }

      public function setPedidoNumero($valor){
        $this->pedidoNumero=$valor;
      }

	  public function setTerminacionId($valor){
	    if (empty($valor)){
	      $this->terminacionId=null;
	    }else{
		  $this->terminacionId=$valor;
        }
	  }

	  public function setTerminacionNombre($valor){
	    if (empty($valor)){
	      $this->terminacionNombre=null;
	    }else{
		$this->terminacionNombre=$valor;
	    }
	  }



   }
?>