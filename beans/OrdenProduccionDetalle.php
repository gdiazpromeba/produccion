<?php 

   class OrdenProduccionDetalle { 
      private $id; 
      private $cabeceraId; 
      private $piezaId; 
      private $piezaNombre; 
      private $cantidad; 
      private $observaciones; 

      public function getId(){ 
         return $this->id;  
      }

      public function getCabeceraId(){ 
         return $this->cabeceraId;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function getPiezaNombre(){ 
         return $this->piezaNombre;  
      }

      public function getCantidad(){ 
         return $this->cantidad;  
      }

      public function getObservaciones(){ 
         return $this->observaciones;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setCabeceraId($valor){ 
         $this->cabeceraId=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setPiezaNombre($valor){ 
         $this->piezaNombre=$valor; 
      }

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }

   }
?>