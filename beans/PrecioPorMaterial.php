<?php 

   class PrecioPorMaterial { 
      private $id; 
      private $materialId; 
      private $precio; 
      private $fecha; 
      private $proveedorId;
      private $proveedorNombre;
      private $observaciones;

      public function getId(){ 
         return $this->id;  
      }

      public function getMaterialId(){ 
         return $this->materialId;  
      }

      public function getPrecio(){ 
         return $this->precio;  
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

      public function getProveedorId(){ 
         return $this->proveedorId;  
      }
      
      public function getProveedorNombre(){ 
         return $this->proveedorNombre;  
      }
      
      public function getObservaciones(){ 
         return $this->observaciones;  
      }
      
      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setMaterialId($valor){ 
         $this->materialId=$valor; 
      }

      public function setPrecio($valor){ 
         $this->precio=$valor; 
      }

      public function setFecha($valor){ 
         $this->fecha=$valor; 
      }
      
      public function setProveedorId($valor){ 
         $this->proveedorId=$valor; 
      }
      
      public function setProveedorNombre($valor){ 
         $this->proveedorNombre=$valor; 
      }
      
      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
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

   }
?>