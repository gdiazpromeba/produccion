<?php 

   class AtributoValor { 
      private $id; 
      private $atributoId; 
      private $atributoNombre; 
      private $valorNumerico; 
      private $valorAlfanumerico; 

      public function getId(){ 
         return $this->id;  
      }

      public function getAtributoId(){ 
         return $this->atributoId;  
      }

      public function getAtributoNombre(){ 
         return $this->atributoNombre;  
      }

      public function getValorNumerico(){ 
         return $this->valorNumerico;  
      }

      public function getValorAlfanumerico(){ 
         return $this->valorAlfanumerico;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setAtributoId($valor){ 
         $this->atributoId=$valor; 
      }

      public function setAtributoNombre($valor){ 
         $this->atributoNombre=$valor; 
      }

      public function setValorNumerico($valor){ 
         $this->valorNumerico=$valor; 
      }

      public function setValorAlfanumerico($valor){ 
         $this->valorAlfanumerico=$valor; 
      }

   }
?>