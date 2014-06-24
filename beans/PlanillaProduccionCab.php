<?php 

   class PlanillaProduccionCab { 
      private $id; 
      private $fecha; 
      private $empleadoId; 
      private $empleadoApellido; 
      private $empleadoNombre; 
      private $tarjetaNumero;
      private $observacionesCab; 

      public function getId(){ 
         return $this->id;  
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

      public function getEmpleadoId(){ 
         return $this->empleadoId;  
      }

      public function getEmpleadoApellido(){ 
         return $this->empleadoApellido;  
      }

      public function getEmpleadoNombre(){ 
         return $this->empleadoNombre;  
      }
      
      public function getTarjetaNumero(){ 
         return $this->tarjetaNumero;  
      }
      

      public function getObservacionesCab(){ 
         return $this->observacionesCab;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
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

      public function setEmpleadoId($valor){ 
         $this->empleadoId=$valor; 
      }

      public function setEmpleadoApellido($valor){ 
         $this->empleadoApellido=$valor; 
      }

      public function setEmpleadoNombre($valor){ 
         $this->empleadoNombre=$valor; 
      }
      
      public function setTarjetaNumero($valor){ 
         $this->tarjetaNumero=$valor; 
      }
      

      public function setObservacionesCab($valor){ 
         $this->observacionesCab=$valor; 
      }

   }
?>