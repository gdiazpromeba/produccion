<?php 

   class FacturaDetalle { 
      private $id; 
      private $facturaCabeceraId; 
      private $cantidad; 
      private $piezaId; 
      private $piezaNombre; 
      private $observacionesDet; 
      private $precioUnitario; 
      private $importe; 
      private $referenciaPedido;

      public function getId(){ 
         return $this->id;  
      }

      public function getFacturaCabeceraId(){ 
         return $this->facturaCabeceraId;  
      }

      public function getCantidad(){ 
         return $this->cantidad;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function getPiezaNombre(){ 
         return $this->piezaNombre;  
      }

      public function getObservacionesDet(){ 
         return $this->observacionesDet;  
      }

      public function getPrecioUnitario(){ 
         return $this->precioUnitario;  
      }

      public function getImporte(){ 
         return $this->importe;  
      }
      
      public function getReferenciaPedido(){ 
         return $this->referenciaPedido;  
      }
      
      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setFacturaCabeceraId($valor){ 
         $this->facturaCabeceraId=$valor; 
      }

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setPiezaNombre($valor){ 
         $this->piezaNombre=$valor; 
      }

      public function setObservacionesDet($valor){ 
         $this->observacionesDet=$valor; 
      }

      public function setPrecioUnitario($valor){ 
         $this->precioUnitario=$valor; 
      }

      public function setImporte($valor){ 
         $this->importe=$valor; 
      }
      
      public function setReferenciaPedido($valor){ 
         $this->referenciaPedido=$valor; 
      }
      

   }
?>