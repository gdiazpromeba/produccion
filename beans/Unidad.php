<?php 

   class Unidad { 
      private $id; 
      private $magnitudId; 
      private $nombre; 
      private $texto; 
      private $factor; 

      public function getId(){ 
         return $this->id;  
      }

      public function getMagnitudId(){ 
         return $this->magnitudId;  
      }

      public function getNombre(){ 
         return $this->nombre;  
      }

      public function getTexto(){ 
         return $this->texto;  
      }

      public function getFactor(){ 
         return $this->factor;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setMagnitudId($valor){ 
         $this->magnitudId=$valor; 
      }

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }

      public function setTexto($valor){ 
         $this->texto=$valor; 
      }

      public function setFactor($valor){ 
         $this->factor=$valor; 
      }

   }
?>