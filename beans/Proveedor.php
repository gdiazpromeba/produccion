<?php 

   class Proveedor { 
   	
      private $id; 
      private $nombre; 
      private $observaciones;
      private $rubros;
      
      
      public function getId(){ 
         return $this->id;      }

      public function getNombre(){ 
         return $this->nombre;      
      }
      
      public function getObservaciones(){ 
         return $this->observaciones;      
      }
      
      public function getRubros(){ 
         return $this->rubros;      
      }
      
      

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }
      
      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }
      
      public function setRubros($valor){ 
         $this->rubros=$valor; 
      }
      
      

   }
?>