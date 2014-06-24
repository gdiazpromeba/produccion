<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php'; 

   class Pago { 
      private $id; 
      private $pedidoId;
      private $monto;
      private $fecha;
      private $tipo;
      private $observaciones;
      
      public function getId(){ 
         return $this->id;  
      }
      
      public function setId($valor){ 
         $this->id=$valor; 
      } 

      public function getPedidoId(){ 
         return $this->pedidoId;  
      }
      
      public function setPedidoId($valor){ 
         $this->pedidoId=$valor; 
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
         return FechaUtils::dateTimeaCadena($this->fecha);  
      }
      
      public function getFechaCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->fecha);  
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
      
      public function getTipo(){
      	return $this->tipo;
      } 

      public function setTipo($valor){ 
         $this->tipo=$valor; 
      }    

      public function getObservaciones(){
      	return $this->observaciones;
      } 

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }        
      
      
      
      
 
   }
?>