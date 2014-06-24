<?php 

   class Material { 
      private $id; 
      private $nombre;
      private $unidadId; 
      private $unidadTexto; 
      private $precio; 

      public function getId(){ 
         return $this->id;  
      }
      
      public function getNombre(){ 
         return $this->nombre;  
      }
      

      public function getUnidadId(){ 
         return $this->unidadId;  
      }

      public function getUnidadTexto(){ 
         return $this->unidadTexto;  
      }

      public function getPrecio(){ 
         return $this->precio;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }
      
      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }
      

      public function setUnidadId($valor){ 
         $this->unidadId=$valor; 
      }

      public function setUnidadTexto($valor){ 
         $this->unidadTexto=$valor; 
      }

      public function setPrecio($valor){ 
         $this->precio=$valor; 
      }

   }
?>