<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';

   class PedidoPendiente { 
      private $detalleId; 
      private $interno;
      private $pedidoFecha; 
      private $cantidad; 
      private $remitidos;
      private $piezaId; 
      private $piezaNombre;
      private $fechaPrometida;
      private $pedidoNumero;

      public function getDetalleId(){ 
         return $this->detalleId;  
      }
      
      public function getPedidoFecha(){ 
         return $this->pedidoFecha;  
      }
      
      public function getInterno(){ 
         return $this->interno;  
      }      
      
      public function getPedidoFechaLarga(){ 
         return FechaUtils::dateTimeaCadena($this->pedidoFecha);  
      }
      
      public function getPedidoFechaCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->pedidoFecha);  
      }    

      public function getFechaPrometidaLarga(){ 
        return FechaUtils::dateTimeACadena($this->fechaPrometida);	
      }
      
      public function getFechaPrometidaCorta(){ 
        return FechaUtils::dateTimeACadena($this->fechaPrometida);	
      }       
      
      public function getCantidad(){ 
         return $this->cantidad;  
      }
      
      public function getRemitidos(){ 
         return $this->remitidos;  
      }
      
      public function getPiezaId(){ 
         return $this->piezaId;  
      }
      
      public function getPiezaNombre(){ 
         return $this->piezaNombre;  
      }
      
      public function getFechaPrometida(){ 
         return $this->fechaPrometida;  
      }
      
      public function getPedidoNumero(){ 
         return $this->pedidoNumero;  
      }
      
      
      public function setDetalleId($valor){ 
         $this->detalleId=$valor;  
      }
      
      public function setInterno($valor){ 
         $this->interno=$valor;  
      }
      
      public function setPedidoFecha($valor){ 
         $this->pedidoFecha=$valor;  
      }
      
      public function setPedidoFechaLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
         $this->pedidoFecha=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setPedidoFechaCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->pedidoFecha=FechaUtils::cadenaDMAaObjeto($valor);
      }        
      
      public function setCantidad($valor){ 
         $this->cantidad=$valor;  
      }
      
      public function setRemitidos($valor){ 
         $this->remitidos=$valor;  
      }
      
      
      public function setPiezaId($valor){ 
         $this->piezaId=$valor;  
      }
      
      public function setPiezaNombre($valor){ 
         $this->piezaNombre=$valor;  
      }
      
      public function setFechaPrometida($valor){ 
         $this->fechaPrometida=$valor;  
      }
      
      public function setFechaPrometidaLarga($valor){ 
         $this->fechaPrometida=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setFechaPrometidaCorta($valor){ 
         $this->fechaPrometida=FechaUtils::cadenaDMAaObjeto($valor);
      }
      
      public function setPedidoNumero($valor){ 
         $this->pedidoNumero=$valor;  
      }
              

   }
?>