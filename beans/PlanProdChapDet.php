<?php 

   class PlanProdChapDet { 
      private $id; 
      private $plPrChapCabId; 
      private $unidades; 
      private $terminacion; 
      private $ancho;
      private $largo; 
      private $cruzada;

      public function getId(){ 
         return $this->id;  
      }

      public function getPlPrChapCabId(){ 
         return $this->plPrChapCabId;  
      }

      public function getUnidades(){ 
         return $this->unidades;  
      }

      public function getTerminacion(){ 
         return $this->terminacion;  
      }
      
      public function getLargo(){ 
         return $this->largo;  
      }
      
      public function getAncho(){ 
         return $this->ancho;  
      }      
      
      public function getCruzada(){ 
         return $this->cruzada;  
      }
      

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setPlPrChapCabId($valor){ 
         $this->plPrChapCabId=$valor; 
      }

      public function setUnidades($valor){ 
         $this->unidades=$valor; 
      }

      public function setTerminacion($valor){ 
         $this->terminacion=$valor; 
      }
      
      public function setLargo($valor){ 
         $this->largo=$valor; 
      }
      
      public function setAncho($valor){ 
         $this->ancho=$valor; 
      }
      

      public function setCruzada($valor){ 
         $this->cruzada=$valor; 
      }
      

   }
?>