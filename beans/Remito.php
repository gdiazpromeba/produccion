<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php'; 


   class Remito { 
      private $id; 
      private $clienteId; 
      private $clienteNombre; 
      private $numero; 
      private $fecha; 
      private $estado; 
      private $observaciones;

      public function getId(){ 
         return $this->id;  
      }

      public function getClienteId(){ 
         return $this->clienteId;  
      }

      public function getClienteNombre(){ 
         return $this->clienteNombre;  
      }
      
      public function getObservaciones(){ 
         return $this->observaciones;  
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

      public function getEstado(){ 
         return $this->estado;  
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

      public function setNumero($valor){ 
         $this->numero=$valor; 
      }
      
      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }
      

      public function setFecha($valor){ 
         $this->fecha=$valor; 
      }
      
      public function setFechaLarga($valor){ 
         $this->fecha=FechaUtils::cadenaAObjeto($valor); 
      }
      
      public function setFechaCorta($valor){ 
        $this->fecha=FechaUtils::cadenaDMAaObjeto($valor);
      }      

      public function setEstado($valor){ 
         $this->estado=$valor; 
      }

   }
?>