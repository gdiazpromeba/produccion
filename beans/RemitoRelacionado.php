<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php'; 

   /**
    * representa información de remitos relacionados con un ítem de detalle de pedido
    */
   class RemitoRelacionado { 
      private $numero; 
      private $fecha; 
      private $cantidad; 
      private $estado;

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
      
      public function getCantidad(){ 
         return $this->cantidad;  
      }
      
      public function getEstado(){ 
         return $this->estado;  
      }
      

      public function setNumero($valor){ 
         $this->numero=$valor; 
      }

      public function setFechaLarga($valor){ 
         $this->fecha=FechaUtils::cadenaAObjeto($valor); 
      }
      
      public function setFechaCorta($valor){ 
        $this->fecha=FechaUtils::cadenaDMAaObjeto($valor);
      }      

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }
      
      public function setEstado($valor){ 
         $this->estado=$valor; 
      }
      

   }
?>