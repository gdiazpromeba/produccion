<?php 

   class ComunicacionPrecios { 
      private $id; 
      private $clienteId; 
      private $clienteNombre; 
      private $destinatario;
      private $fecha; 
      private $autorizadorId; 
      private $autorizadorNombre; 
      private $metodoEnvio; 

      public function getId(){ 
         return $this->id;  
      }

      public function getClienteId(){ 
         return $this->clienteId;  
      }

      public function getClienteNombre(){ 
         return $this->clienteNombre;  
      }
      
      public function getDestinatario(){ 
         return $this->destinatario;  
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

      public function getAutorizadorId(){ 
         return $this->autorizadorId;  
      }

      public function getAutorizadorNombre(){ 
         return $this->autorizadorNombre;  
      }

      public function getMetodoEnvio(){ 
         return $this->metodoEnvio;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setClienteId($valor){ 
         $this->clienteId=$valor; 
      }

      public function setClienteNombre($valor){ 
         $this->clienteNombre=$valor; 
      }
      
      public function setDestinatario($valor){ 
         $this->destinatario=$valor;  
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

      public function setAutorizadorId($valor){ 
         $this->autorizadorId=$valor; 
      }

      public function setAutorizadorNombre($valor){ 
         $this->autorizadorNombre=$valor; 
      }

      public function setMetodoEnvio($valor){ 
         $this->metodoEnvio=$valor; 
      }

   }
?>