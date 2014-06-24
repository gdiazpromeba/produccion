<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';

   class PedidoPlano {
      private $pedidoCabeceraId;
      private $fecha;
      private $referencia;
      private $pedidoDetalleId;
      private $clienteId;
      private $clienteNombre;
      private $estado;
      private $interno;
      private $numero;
      private $piezaId;
      private $piezaNombre;
      private $ficha;
      private $cantidad;
      private $remitidos;
      private $pendientes;
      private $precioUnitario;
      private $precioTotal;
      private $precioPendiente;
      private $fechaPrometida;
      private $terminacionId;
      private $terminacionNombre;
      private $observaciones;
      private $fechaEnvio;
      private $laqueadorNombre;
      private $sinPatas;
      private $estadoLaqueado;
      

      //pedidoCabeceraId
      public function setPedidoCabeceraId($valor){
        $this->pedidoCabeceraId=$valor;
      }

      public function getPedidoCabeceraId(){
        return $this->pedidoCabeceraId;
      }

      public function setFecha($valor){
         $this->fecha=$valor;
      }

       public function setReferencia($valor){
         $this->referencia=$valor;
      }


      public function setFechaLarga($valor){
        $this->fecha=FechaUtils::creaDeCadena($valor);
      }

      public function setFechaCorta($valor){
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

      public function getReferencia(){
        return $this->referencia;
      }


      //pedidoDetalleId
      public function setPedidoDetalleId($valor){
        $this->pedidoDetalleId=$valor;
      }

      public function getPedidoDetalleId(){
        return $this->pedidoDetalleId;
      }

      //clienteId
      public function setClienteId($valor){
        $this->clienteId=$valor;
      }

      public function getClienteId(){
        return $this->clienteId;
      }

      //clienteNombre
      public function setClienteNombre($valor){
        $this->clienteNombre=$valor;
      }

      public function getClienteNombre(){
        return $this->clienteNombre;
      }

      //estado
      public function setEstado($valor){
        $this->estado=$valor;
      }

      public function getEstado(){
        return $this->estado;
      }

      //interno
      public function setInterno($valor){
        $this->interno=$valor;
      }

      public function getInterno(){
        return $this->interno;
      }

      //número de pedido (en cabecera)
      public function setNumero($valor){
        $this->numero=$valor;
      }

      public function getNumero(){
        return $this->numero;
      }


      //piezaId
      public function setPiezaId($valor){
        $this->piezaId=$valor;
      }

      public function getPiezaId(){
        return $this->piezaId;
      }

      //piezaNombre
      public function setPiezaNombre($valor){
        $this->piezaNombre=$valor;
      }

      public function getPiezaNombre(){
        return $this->piezaNombre;
      }

      public function getObservaciones(){
        return $this->observaciones;
      }

      public function setObservaciones($valor){
        $this->observaciones=$valor;
      }



      //ficha
      public function setFicha($valor){
        $this->ficha=$valor;
      }

      public function getFicha(){
        return $this->ficha;
      }

      //cantidad
      public function setCantidad($valor){
        $this->cantidad=$valor;
      }

      public function getCantidad(){
        return $this->cantidad;
      }

      //remitidos
      public function setRemitidos($valor){
        $this->remitidos=$valor;
      }

      public function getRemitidos(){
        return $this->remitidos;
      }

      //pendientes
      public function setPendientes($valor){
        $this->pendientes=$valor;
      }

      public function getPendientes(){
        return $this->pendientes;
      }

      //precio unitario
      public function setPrecioUnitario($valor){
        $this->precioUnitario=$valor;
      }

      public function getPrecioUnitario(){
        return $this->precioUnitario;
      }

      //precio total
      public function setPrecioTotal($valor){
        $this->precioTotal=$valor;
      }

      public function getPrecioTotal(){
        return $this->precioTotal;
      }

      //precio pendiente
      public function setPrecioPendiente($valor){
        $this->precioPendiente=$valor;
      }

      public function getPrecioPendiente(){
        return $this->precioPendiente;
      }

      public function getTerminacionId(){
	          return $this->terminacionId;
      }

      public function getTerminacionNombre(){
	          return $this->terminacionNombre;
      }

      public function setTerminacionId($valor){
	          $this->terminacionId=$valor;
      }

      public function setTerminacionNombre($valor){
	          $this->terminacionNombre=$valor;
      }


	  //fecha prometida
	  public function setFechaPrometida($valor){
        $this->fechaPrometida=$valor;
      }

      public function setFechaPrometidaLarga($valor){
        $this->fechaPrometida=FechaUtils::creaDeCadena($valor);
      }

      public function setFechaPrometidaCorta($valor){
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
      
      //fecha envio
      public function setFechaEnvio($valor){
        $this->fechaEnvio=$valor;
      }

      public function setFechaEnvioLarga($valor){
        $this->fechaEnvio=FechaUtils::creaDeCadena($valor);
      }

      public function setFechaEnvioCorta($valor){
        $this->fechaEnvio=FechaUtils::cadenaDMAaObjeto($valor);
      }


      public function getFechaEnvio(){
         return $this->fechaEnvio;
      }

      public function getFechaEnvioLarga(){
         return FechaUtils::dateTimeaCadena($this->fechaEnvio);
      }

      public function getFechaEnvioCorta(){
         return FechaUtils::dateTimeaCadenaDMA($this->fechaEnvio);
      }   
      
      
      public function getLaqueadorNombre(){
	  return $this->laqueadorNombre;
      }


      public function setSinPatas($valor){
	    $this->sinPatas=$valor;
      }
      
      public function getSinPatas(){
      	return $this->sinPatas;
      }
      
      
      public function setLaqueadorNombre($valor){
      	$this->laqueadorNombre=$valor;
      }

      public function getEstadoLaqueado(){
      	return $this->estadoLaqueado;
      }
      
      public function setEstadoLaqueado($valor){
      	$this->estadoLaqueado=$valor;
      }
      
      
      


   }
?>