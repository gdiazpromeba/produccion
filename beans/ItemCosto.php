<?php 

   class ItemCosto { 
      private $id; 
      private $orden; 
      private $texto; 
      private $padreId; 
      private $piezaId; 
      private $horasHombre; 
      private $dotacionSugerida; 
      private $cantidadMaterial; 
      private $porcentajeAjuste; 
      private $tipo; 
      private $referenteId;
      private $hijos;
      private $padre;
      private $hermanos;

      public function getId(){ 
         return $this->id;  
      }

      public function getOrden(){ 
         return $this->orden;  
      }

      public function getTexto(){ 
         return $this->texto;  
      }

      public function getPadreId(){ 
         return $this->padreId;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function getTiempo(){ 
         return $this->horasHombre;  
      }

      public function getDotacionSugerida(){ 
         return $this->dotacionSugerida;  
      }

      public function getCantidadMaterial(){ 
         return $this->cantidadMaterial;  
      }

      public function getPorcentajeAjuste(){ 
         return $this->porcentajeAjuste;  
      }

      public function getTipo(){ 
         return $this->tipo;  
      }

      public function getReferenteId(){ 
         return $this->referenteId;  
      }
      
      public function getHijos(){ 
         return $this->hijos;  
      }
      
      public function getPadre(){ 
         return $this->padre;  
      }
      
      public function getHermanos(){ 
         return $this->hermanos;  
      }
      
      
      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setOrden($valor){ 
         $this->orden=$valor; 
      }

      public function setTexto($valor){ 
         $this->texto=$valor; 
      }

      public function setPadreId($valor){ 
         $this->padreId=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setTiempo($valor){ 
         $this->horasHombre=$valor; 
      }

      public function setDotacionSugerida($valor){ 
         $this->dotacionSugerida=$valor; 
      }

      public function setCantidadMaterial($valor){ 
         $this->cantidadMaterial=$valor; 
      }

      public function setPorcentajeAjuste($valor){ 
         $this->porcentajeAjuste=$valor; 
      }


      public function setTipo($valor){ 
         $this->tipo=$valor; 
      }
      
      public function setReferenteId($valor){ 
         $this->referenteId=$valor; 
      }

      public function setHijos($valor){ 
         $this->hijos=$valor; 
      }
      
      public function setPadre($valor){ 
         $this->padre=$valor; 
      }
      
      public function setHermanos($valor){ 
         $this->hermanos=$valor; 
      }
      

   }
?>