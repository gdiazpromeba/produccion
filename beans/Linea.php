<?php 

   class Linea { 
      private $id; 
      private $descripcion; 
      private $observaciones; 

      public function getId(){ 
         return $this->id;  
      }

      public function getDescripcion(){ 
         return $this->descripcion;  
      }

      public function getObservaciones(){ 
         return $this->observaciones;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setDescripcion($valor){ 
         $this->descripcion=$valor; 
      }

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }

   }
?>