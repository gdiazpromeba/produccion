<?php 

   class OrdenProduccion { 
      private $id; 
      private $estado; 
      private $fecha; 
      private $numero; 

      public function getId(){ 
         return $this->id;  
      }

      public function getEstado(){ 
         return $this->estado;  
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

      public function getNumero(){ 
         return $this->numero;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setEstado($valor){ 
         $this->estado=$valor; 
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
      

      public function setNumero($valor){ 
         $this->numero=$valor; 
      }

   }
?>