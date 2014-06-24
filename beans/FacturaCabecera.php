<?php 

   class FacturaCabecera { 
      private $id; 
      private $numero; 
      private $fecha; 
      private $clienteId; 
      private $remitoNumero;
      private $clienteNombre; 
      private $clienteTelefono; 
      private $clienteLocalidad; 
      private $clienteCondicionIva; 
      private $clienteCuit; 
      private $condicionesVenta; 
      private $subtotal; 
      private $tipo; 
      private $ivaInscripto; 
      private $descuento; 
      private $observaciones; 
      private $estado; 
      private $total; 

      public function getId(){ 
         return $this->id;  
      }

      public function getNumero(){ 
         return $this->numero;  
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
      

      public function getClienteId(){ 
         return $this->clienteId;  
      }
      
      public function getRemitoNumero(){ 
         return $this->remitoNumero;  
      }      

      public function getClienteNombre(){ 
         return $this->clienteNombre;  
      }

      public function getClienteTelefono(){ 
         return $this->clienteTelefono;  
      }

      public function getClienteLocalidad(){ 
         return $this->clienteLocalidad;  
      }

      public function getClienteCondicionIva(){ 
         return $this->clienteCondicionIva;  
      }

      public function getClienteCuit(){ 
         return $this->clienteCuit;  
      }

      public function getCondicionesVenta(){ 
         return $this->condicionesVenta;  
      }

      public function getSubtotal(){ 
         return $this->subtotal;  
      }

      public function getTipo(){
      	return $this->tipo;
      }

      public function getIvaInscripto(){ 
         return $this->ivaInscripto;  
      }

      public function getDescuento(){ 
         return $this->descuento;  
      }

      public function getObservaciones(){ 
         return $this->observaciones;  
      }
      
      public function getEstado(){ 
         return $this->estado;  
      }      

      public function getTotal(){ 
         return $this->total;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setNumero($valor){ 
         $this->numero=$valor; 
      }

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

      public function setClienteId($valor){ 
         $this->clienteId=$valor; 
      }
      
      public function setRemitoNumero($valor){ 
         $this->remitoNumero=$valor; 
      }      

      public function setClienteNombre($valor){ 
         $this->clienteNombre=$valor; 
      }

      public function setClienteTelefono($valor){ 
         $this->clienteTelefono=$valor; 
      }

      public function setClienteLocalidad($valor){ 
         $this->clienteLocalidad=$valor; 
      }

      public function setClienteCondicionIva($valor){ 
         $this->clienteCondicionIva=$valor; 
      }

      public function setClienteCuit($valor){ 
         $this->clienteCuit=$valor; 
      }

      public function setCondicionesVenta($valor){ 
         $this->condicionesVenta=$valor; 
      }

      public function setSubtotal($valor){ 
         $this->subtotal=$valor; 
      }

      public function setTipo($valor){ 
         $this->tipo=$valor; 
      }

      public function setDescuento($valor){ 
         $this->descuento=$valor; 
      }

      public function setIvaInscripto($valor){ 
         $this->ivaInscripto=$valor; 
      }

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }
      
      public function setEstado($valor){ 
         $this->estado=$valor; 
      }      

      public function setTotal($valor){ 
         $this->total=$valor; 
      }

   }
?>