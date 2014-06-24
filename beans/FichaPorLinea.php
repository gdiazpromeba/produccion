<?php 

   class FichaPorLinea { 
      private $id; 
      private $lineaId; 
      private $piezaFicha; 
      private $observaciones; 

      public function getId(){ 
         return $this->id;  
      }

      public function getLineaId(){ 
         return $this->lineaId;  
      }

      public function getPiezaFicha(){ 
         return $this->piezaFicha;  
      }

      public function getObservaciones(){ 
         return $this->observaciones;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setLineaId($valor){ 
         $this->lineaId=$valor; 
      }

      public function setPiezaFicha($valor){ 
         $this->piezaFicha=$valor; 
      }

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }

   }
?>