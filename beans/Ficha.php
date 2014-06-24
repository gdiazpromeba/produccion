<?php 

   class Ficha { 
      private $id; 
      private $ficha; 
      private $contenido; 

      public function getId(){ 
         return $this->id;  
      }

      public function getFicha(){ 
         return $this->ficha;  
      }

      public function getContenido(){ 
         return $this->contenido;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setFicha($valor){ 
         $this->ficha=$valor; 
      }

      public function setContenido($valor){ 
         $this->contenido=$valor; 
      }

   }
?>