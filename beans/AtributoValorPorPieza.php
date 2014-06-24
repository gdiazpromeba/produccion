<?php 

   class AtributoValorPorPieza { 
      private $atributoValorId; 
      private $piezaId; 

      public function getAtributoValorId(){ 
         return $this->atributoValorId;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function setAtributoValorId($valor){ 
         $this->atributoValorId=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

   }
?>