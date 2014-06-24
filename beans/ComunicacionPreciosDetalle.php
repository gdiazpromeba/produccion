<?php 

   class ComunicacionPreciosDetalle { 
      private $id; 
      private $comPrecCabId; 
      private $piezaId; 
      private $piezaNombre; 
      private $precio; 
      private $usaGeneral;

      public function getId(){ 
         return $this->id;  
      }

      public function getComPrecCabId(){ 
         return $this->comPrecCabId;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function getPiezaNombre(){ 
         return $this->piezaNombre;  
      }

      public function getPrecio(){ 
         return $this->precio;  
      }
      
      public function isUsaGeneral(){ 
         return $this->usaGeneral;  
      }
      

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setComPrecCabId($valor){ 
         $this->comPrecCabId=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setPiezaNombre($valor){ 
         $this->piezaNombre=$valor; 
      }

      public function setPrecio($valor){ 
         $this->precio=$valor; 
      }
      
      public function setUsaGeneral($valor){ 
         $this->usaGeneral=$valor; 
      }      

   }
?>