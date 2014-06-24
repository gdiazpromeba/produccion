<?php 

   class Pieza { 
      private $id; 
      private $piezaGenericaId; 
      private $piezaGenericaNombre;
      private $nombre; 
      private $ficha;
      private $atributos;
      private $tipoPataId;
      private $tipoPataNombre;
      private $habilitada;

      public function getId(){ 
         return $this->id;      }

      public function getPiezaGenericaId(){ 
         return $this->piezaGenericaId;      }
         

      public function getPiezaGenericaNombre(){ 
         return $this->piezaGenericaNombre;      
      }
         

      public function getNombre(){ 
         return $this->nombre;      
      }
      
      public function getFicha(){ 
         return $this->ficha;      
      }
      

      
      public function getAtributos(){ 
         return $this->atributos;      
      }
      

      public function isHabilitada(){ 
         return $this->habilitada;      
      }
      

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setPiezaGenericaId($valor){ 
         $this->piezaGenericaId=$valor; 
      }
      
      public function setPiezaGenericaNombre($valor){ 
         $this->piezaGenericaNombre=$valor; 
      }      

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }
      
      public function setFicha($valor){ 
         $this->ficha=$valor; 
      }
      

      
      public function setAtributos($valor){ 
         $this->atributos=$valor; 
      }

      public function setHabilitada($valor){ 
         $this->habilitada=$valor; 
      }
      
      //tipo de pata
      public function setTipoPataId($valor){
      	$this->tipoPataId=$valor;
      }

      public function setTipoPataNombre($valor){
      	$this->tipoPataNombre=$valor;
      }
      
      public function getTipoPataId(){
      	return $this->tipoPataId;
      }
      
      public function getTipoPataNombre(){
      	return $this->tipoPataNombre;
      }
      
      
      
      
      
      
   }
?>