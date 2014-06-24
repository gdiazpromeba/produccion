<?php 

   class Matriz { 
      private $id; 
      private $nombre;
      private $tipo;
      private $foto; 
      private $medidas; 
      private $anchoBase;
      private $largoBase;
      private $alturaConjunto;
      private $forma;
      private $depositoId; 
      private $depositoNombre; 
      private $condicion; 

      public function getId(){ 
         return $this->id;  
      }

      public function getNombre(){ 
         return $this->nombre;  
      }
      
      public function getTipo(){ 
         return $this->tipo;  
      }
      

      public function getFoto(){ 
         return $this->foto;  
      }

      public function getMedidas(){ 
         return $this->medidas;  
      }
      
      public function getAnchoBase(){ 
         return $this->anchoBase;  
      }
      
      public function getLargoBase(){ 
         return $this->largoBase;  
      }      
      
      public function getAlturaConjunto(){ 
         return $this->alturaConjunto;  
      }      
      
      public function getForma(){ 
         return $this->forma;  
      }      
      
      public function getDepositoId(){ 
         return $this->depositoId;  
      }

      public function getDepositoNombre(){ 
         return $this->depositoNombre;  
      }

      public function getCondicion(){ 
         return $this->condicion;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }
      
      public function setTipo($valor){ 
         $this->tipo=$valor; 
      }
      

      public function setFoto($valor){ 
         $this->foto=$valor; 
      }

      public function setMedidas($valor){ 
         $this->medidas=$valor; 
      }
      
      public function setAnchoBase($valor){ 
         $this->anchoBase=$valor;  
      }
      
      public function setLargoBase($valor){ 
         $this->largoBase=$valor;  
      }      
      
      public function setAlturaConjunto($valor){ 
         $this->alturaConjunto=$valor;  
      }      
      
      public function setForma($valor){ 
         $this->forma=$valor;  
      }      
      

      public function setDepositoId($valor){ 
         $this->depositoId=$valor; 
      }

      public function setDepositoNombre($valor){ 
         $this->depositoNombre=$valor; 
      }

      public function setCondicion($valor){ 
         $this->condicion=$valor; 
      }

   }
?>