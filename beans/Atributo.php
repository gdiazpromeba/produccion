<?php 

   class Atributo { 
      private $id; 
      private $nombre; 
      private $numerico; 
      private $unidad; 

      public function getId(){ 
         return $this->id;  
      }

      public function getNombre(){ 
         return $this->nombre;  
      }

      public function getNumerico(){ 
         return $this->numerico;  
      }

      public function getUnidad(){ 
         return $this->unidad;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }

      public function setNumerico($valor){ 
         $this->numerico=$valor; 
      }

      public function setUnidad($valor){ 
         $this->unidad=$valor; 
      }

   }
?>