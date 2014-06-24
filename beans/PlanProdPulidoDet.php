<?php 

   class PlanProdPulidoDet { 
      private $id; 
      private $planProdPulidoCabId; 
      private $piezaFicha; 
      private $cantidad;
      private $terminacion; 
      private $reparada; 
      private $tapizarMini; 
      private $rota; 
      private $pulido; 
      private $tupi; 
      private $cantos; 
      private $lijadoPelota; 
      private $rotocort; 
      private $tacos; 
      private $escuadraGarlopa; 
      private $otra; 
      private $observaciones; 

      public function getId(){ 
         return $this->id;  
      }

      public function getPlanProdPulidoCabId(){ 
         return $this->planProdPulidoCabId;  
      }

      public function getPiezaFicha(){ 
         return $this->piezaFicha;  
      }

      public function getCantidad(){ 
         return $this->cantidad;  
      }

      public function getTerminacion(){ 
         return $this->terminacion;  
      }

      public function isReparada(){ 
         return $this->reparada;  
      }

      public function isTapizarMini(){ 
         return $this->tapizarMini;  
      }

      public function isRota(){ 
         return $this->rota;  
      }

      public function isPulido(){ 
         return $this->pulido;  
      }

      public function isTupi(){ 
         return $this->tupi;  
      }

      public function isCantos(){ 
         return $this->cantos;  
      }

      public function isLijadoPelota(){ 
         return $this->lijadoPelota;  
      }

      public function isRotocort(){ 
         return $this->rotocort;  
      }

      public function isTacos(){ 
         return $this->tacos;  
      }

      public function isEscuadraGarlopa(){ 
         return $this->escuadraGarlopa;  
      }

      public function isOtra(){ 
         return $this->otra;  
      }

      public function getObservaciones(){ 
         return $this->observaciones;  
      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setPlanProdPulidoCabId($valor){ 
         $this->planProdPulidoCabId=$valor; 
      }

      public function setPiezaFicha($valor){ 
         $this->piezaFicha=$valor; 
      }

      public function setTerminacion($valor){ 
         $this->terminacion=$valor; 
      }
      
      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setReparada($valor){ 
         $this->reparada=$valor; 
      }

      public function setTapizarMini($valor){ 
         $this->tapizarMini=$valor; 
      }

      public function setRota($valor){ 
         $this->rota=$valor; 
      }

      public function setPulido($valor){ 
         $this->pulido=$valor; 
      }

      public function setTupi($valor){ 
         $this->tupi=$valor; 
      }

      public function setCantos($valor){ 
         $this->cantos=$valor; 
      }

      public function setLijadoPelota($valor){ 
         $this->lijadoPelota=$valor; 
      }

      public function setRotocort($valor){ 
         $this->rotocort=$valor; 
      }

      public function setTacos($valor){ 
         $this->tacos=$valor; 
      }

      public function setEscuadraGarlopa($valor){ 
         $this->escuadraGarlopa=$valor; 
      }

      public function setOtra($valor){ 
         $this->otra=$valor; 
      }

      public function setObservaciones($valor){ 
         $this->observaciones=$valor; 
      }

   }
?>