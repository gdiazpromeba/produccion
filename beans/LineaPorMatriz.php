<?php 

   class LineaPorMatriz { 
      private $id; 
      private $matrizId; 
      private $lineaId; 
      private $lineaDescripcion;
      private $observaciones; 

      public function getId(){ 
         return $this->id;  
      }

      public function getMatrizId(){ 
         return $this->matrizId;  
      }

      public function getLineaId(){ 
         return $this->lineaId;  
      }
      
      public function getLineaDescripcion(){ 
         return $this->lineaDescripcion;  
      }

      public function getObservaciones(){ 
         return $this->observaciones;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setMatrizId($valor){ 
         $this->matrizId=$valor; 
      }

      public function setLineaId($valor){ 
         $this->lineaId=$valor; 
      }
      
      public function setLineaDescripcion($valor){ 
         $this->lineaDescripcion=$valor; 
      }
      

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }

   }
?>