<?php 

   class PlanillaProduccionDet { 
      private $id; 
      private $planProdCabId; 
      private $matrizId; 
      private $matrizNombre; 
      private $espesor; 
      private $terminacion;
      private $reparada;
      private $descartada;
      private $cantidad;
      private $estacionTrabajo; 
      private $observacionesDet; 

      public function getId(){ 
         return $this->id;  
      }

      public function getPlanProdCabId(){ 
         return $this->planProdCabId;  
      }

      public function getMatrizId(){ 
         return $this->matrizId;  
      }

      public function getMatrizNombre(){ 
         return $this->matrizNombre;  
      }

      public function getEspesor(){ 
         return $this->espesor;  
      }
      
      public function getTerminacion(){ 
         return $this->terminacion;  
      }
      
      public function isReparada(){ 
         return $this->reparada;  
      }
      
      public function isDescartada(){ 
         return $this->descartada;  
      }
      
      
      public function getCantidad(){ 
         return $this->cantidad;  
      }
      

      public function getEstacionTrabajo(){ 
         return $this->estacionTrabajo;  
      }

      public function getObservacionesDet(){ 
         return $this->observacionesDet;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setPlanProdCabId($valor){ 
         $this->planProdCabId=$valor; 
      }

      public function setMatrizId($valor){ 
         $this->matrizId=$valor; 
      }

      public function setMatrizNombre($valor){ 
         $this->matrizNombre=$valor; 
      }

      public function setEspesor($valor){ 
         $this->espesor=$valor; 
      }
      
      public function setTerminacion($valor){ 
         $this->terminacion=$valor; 
      }
      
      public function setReparada($valor){ 
         $this->reparada=$valor; 
      }
      
      public function setDescartada($valor){ 
         $this->descartada=$valor; 
      }
      
      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setEstacionTrabajo($valor){ 
         $this->estacionTrabajo=$valor; 
      }

      public function setObservacionesDet($valor){ 
         $this->observacionesDet=$valor; 
      }

   }
?>