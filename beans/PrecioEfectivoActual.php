<?php 

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';

   class PrecioEfectivoActual { 
      private $id; 
      private $clienteId; 
      private $clienteNombre; 
      private $piezaId; 
      private $piezaNombre; 
      private $precio; 
      private $actualizado;
      private $efectivoDesde;

      public function getId(){ 
         return $this->id;  
      }

      public function getClienteId(){ 
         return $this->clienteId;  
      }

      public function getClienteNombre(){ 
         return $this->clienteNombre;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function getPiezaNombre(){ 
         return $this->piezaNombre;  
      }
      
      public function getSinonimos(){ 
         return $this->sinonimos;  
      }      

      public function getPrecio(){ 
         return $this->precio;  
      }
      
      public function getActualizado(){ 
         return $this->actualizado;  
      }      
      
      public function getEfectivoDesde(){ 
         return $this->efectivoDesde;  
      }
      
      public function getEfectivoDesdeLarga(){ 
         return FechaUtils::dateTimeaCadena($this->efectivoDesde);  
      }
      
      public function getEfectivoDesdeCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->efectivoDesde);  
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

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setPiezaNombre($valor){ 
         $this->piezaNombre=$valor; 
      }
      
      public function setSinonimos($valor){ 
         $this->sinonimos=$valor; 
      }      

      public function setPrecio($valor){ 
         $this->precio=$valor; 
      }
      
      public function setActualizado($valor){ 
         $this->actualizado=$valor; 
      }      
      
      public function setEfectivoDesde($valor){ 
         $this->efectivoDesde=$valor; 
      }
      
      public function setEfectivoDesdeLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->efectivoDesde=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setEfectivoDesdeCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->efectivoDesde=FechaUtils::cadenaDMAaObjeto($valor);
      }       

   }
?>