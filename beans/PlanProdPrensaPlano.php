<?php 

   class PlanProdPrensaPlano { 
      private $id; 
      private $empleadoId;
      private $empleadoApellido;
      private $empleadoNombre;
      private $fecha;
      private $planProdCabId; 
      private $matrizId; 
      private $matrizNombre; 
      private $matrizTipo;
      private $espesor; 
      private $terminacion;
      private $reparada;
      private $descartada;
      private $cantidad;
      private $estacionTrabajo; 
      private $observacionesDet; 
      private $cantidadTotal;

      public function getId(){ 
         return $this->id;  
      }
      
      public function getEmpleadoId(){ 
         return $this->empleadoId;  
      }
      
      public function getEmpleadoApellido(){ 
         return $this->empleadoApellido;  
      }
      
      public function getEmpleadoNombre(){ 
         return $this->empleadoNombre;  
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
      
      public function getMatrizTipo(){ 
         return $this->matrizTipo;  
      }
      

      public function getEspesor(){ 
         return $this->espesor;  
      }
      
      public function getTerminacion(){ 
         return $this->terminacion;  
      }
      
      public function getFecha(){ 
         return $this->fecha;  
      }
      
      public function getFechaLarga(){ 
         return FechaUtils::dateTimeaCadena($this->fecha);  
      }
      
      public function getFechaCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->fecha);  
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
      
      public function getCantidadTotal(){ 
         return $this->cantidadTotal;  
      }
      

      public function setId($valor){ 
         $this->id=$valor; 
      }
      
      public function setEmpleadoId($valor){ 
         $this->empleadoId=$valor; 
      }
      
      public function setEmpleadoApellido($valor){ 
         $this->empleadoApellido=$valor; 
      }
      
      public function setEmpleadoNombre($valor){ 
         $this->empleadoNombre=$valor; 
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
      
      public function setMatrizTipo($valor){ 
         $this->matrizTipo=$valor; 
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
      
     public function setFecha($valor){ 
         $this->fecha=$valor; 
      }
      
      public function setFechaLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fecha=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setFechaCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fecha=FechaUtils::cadenaDMAaObjeto($valor);
      }
      
      public function setCantidadTotal($valor){ 
         $this->cantidadTotal=$valor;  
      }
      

      public function setObservacionesDet($valor){ 
         $this->observacionesDet=$valor; 
      }

   }
?>