<?php 

   class OrdenTerminacionDetalle { 
      private $id; 
      private $cabeceraId; 
      private $piezaId; 
      private $piezaNombre; 
      private $cantidad;
      private $cantidadCortada;
      private $cantidadPulida;
      private $fechaEntrega;
      private $observaciones; 

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
      
      public function getCantidadCortada(){ 
         return $this->cantidadCortada;  
      }
      
      
      public function getCantidadPulida(){ 
         return $this->cantidadPulida;  
      }
      
      public function getFechaEntrega(){ 
         return $this->fechaEntrega;  
      }
      
      public function getFechaEntregaLarga(){ 
         return FechaUtils::dateTimeaCadena($this->fechaEntrega);  
      }
      
      public function getFechaEntregaCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->fechaEntrega);  
      }      
      

      public function getObservaciones(){ 
         return $this->observaciones;  
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

      public function setCantidadCortada($valor){ 
         $this->cantidadCortada=$valor; 
      }
      
      public function setCantidadPulida($valor){ 
         $this->cantidadPulida=$valor; 
      }
      
      public function setFechaEntrega($valor){ 
         $this->fechaEntrega=$valor; 
      }
      
      public function setFechaEntregaLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaEntrega=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setFechaEntregaCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaEntrega=FechaUtils::cadenaDMAaObjeto($valor);
      }      
      

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }

   }
?>