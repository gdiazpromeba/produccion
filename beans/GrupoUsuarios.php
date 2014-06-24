<?php 

   class GrupoUsuarios { 
      private $id; 
      private $nombre; 

      public function getId(){ 
         return $this->id;  
      }

      public function getNombre(){ 
         return $this->nombre;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }

   }
?>