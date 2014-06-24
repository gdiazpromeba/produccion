<?php 

   class DatoReloj { 
      private $id; 
      private $empleadoId;
      private $empleadoNombre;
      private $empleadoApellido;
      private $lecturaFechaHora; 

      public function getId(){ 
         return $this->id;  
      }
      
      public function getEmpleadoNombre(){ 
         return $this->empleadoNombre;  
      }
      
      public function getEmpleadoApellido(){ 
         return $this->empleadoApellido;  
      }
      
      public function setEmpleadoNombre($valor){ 
         $this->empleadoNombre=$valor;  
      }
      
      public function setEmpleadoApellido($valor){ 
         $this->empleadoApellido=$valor;  
      }
            
      public function setId($valor){ 
         $this->id=$valor; 
      }

      
      public function setEmpleadoId($valor){ 
         $this->empleadoId=$valor; 
      }
      
      public function getEmpleadoId(){ 
         return $this->empleadoId; 
      }
      
      

      public function getLecturaFechaHora(){ 
         return $this->lecturaFechaHora;  
      }
      

      public function setLecturaFechaHora($valor){ 
         $this->lecturaFechaHora=$valor; 
      }
      
      public function setCadenaFechaHoraLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->lecturaFechaHora=FechaUtils::creaDeCadena($valor); 
      }
      
      public function getCadenaFechaHoraLarga(){ 
         return FechaUtils::dateTimeaCadena($this->lecturaFechaHora);  
      }      
      




   }
?>