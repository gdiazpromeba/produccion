<?php 

   class ChapaPorPieza { 
      private $id; 
      private $piezaId; 
      private $terminacion; 
      private $cantidad; 
      private $ancho; 
      private $largo; 
      private $cruzada; 

      public function getId(){ 
         return $this->id;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }


      public function getTerminacion(){ 
         return $this->terminacion;  
      }

      public function getCantidad(){ 
         return $this->cantidad;  
      }

      public function getAncho(){ 
         return $this->ancho;  
      }

      public function getLargo(){ 
         return $this->largo;  
      }

      public function getCruzada(){ 
         return $this->cruzada;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }


      public function setTerminacion($valor){ 
         $this->terminacion=$valor; 
      }

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setAncho($valor){ 
         $this->ancho=$valor; 
      }

      public function setLargo($valor){ 
         $this->largo=$valor; 
      }

      public function setCruzada($valor){ 
         $this->cruzada=$valor; 
      }

   }
?>