<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php'; 

   class Cheque { 
      private $numero;
      private $emisor;
      private $bancoId;
      private $bancoNombre;
      private $fecha;
      private $monto;
      private $observaciones;
      
      
      public function getNumero(){ 
         return $this->numero;  
      }
      
      public function setNumero($valor){ 
         $this->numero=$valor; 
      } 
      
      public function getEmisor(){ 
         return $this->emisor;  
      }
      
      public function setEmisor($valor){ 
         $this->emisor=$valor; 
      }      

      public function getBancoId(){ 
         return $this->bancoId;  
      }
      
      public function setBancoId($valor){ 
         $this->bancoId=$valor; 
      } 

      public function getBancoNombre(){ 
         return $this->bancoNombre;  
      }
      
      public function setBancoNombre($valor){ 
         $this->bancoNombre=$valor; 
      }       
      
      public function getMonto(){ 
         return $this->monto;  
      }
      
      
      public function setMonto($valor){ 
         $this->monto=$valor; 
      } 
      

      public function getFecha(){ 
         return $this->fecha;  
      }
      
      public function getFechaLarga(){ 
         if (empty($this->fecha)) return null;      	
         return FechaUtils::dateTimeaCadena($this->fecha);  
      }
      
      public function getFechaCorta(){
      	if (empty($this->fecha)) return null; 
         return FechaUtils::dateTimeaCadenaDMA($this->fecha);  
      }        
      
      public function setFecha($valor){ 
         $this->fecha=$valor; 
      }
      
      public function setFechaLarga($valor){ 
        if (!empty($valor) && !is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fecha=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setFechaCorta($valor){ 
      	if (!empty($valor) && !is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fecha=FechaUtils::cadenaDMAaObjeto($valor);
      }
      
      public function getObservaciones(){ 
         return $this->observaciones;  
      }
      
      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }     
      
      
      
      
 
   }
?>