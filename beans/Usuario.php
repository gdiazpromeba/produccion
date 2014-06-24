<?php 

   class Usuario { 
      private $id;
      private $login;
      private $nombreCompleto;
      private $clave;
      private $habilitado;
      private $grupoUsuarios;
      private $intentos;
      private $ultimaActualizacion;
      
      
      public function getId(){ 
         return $this->id;      
      }
      
      public function getLogin(){ 
         return $this->login;      
      }
      
      public function getNombreCompleto(){ 
         return $this->nombreCompleto;      
      }
      
      public function getClave(){ 
         return $this->clave;      
      }
      
      public function getHabilitado(){ 
         return $this->habilitado;      
      }
      
      public function getGrupoUsuarios(){ 
         return $this->grupoUsuarios;      
      }
      
      public function getIntentos(){ 
         return $this->intentos;      
      }
      
      public function getUltimaActualizacion(){ 
         return $this->ultimaActualizacion;  
      }
      
      public function getUltimaActualizacionLarga(){ 
         return FechaUtils::dateTimeaCadena($this->ultimaActualizacion);  
      }
      
      public function getUltimaActualizacionCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->ultimaActualizacion);  
      }
      
      public function setId($valor){ 
         $this->id=$valor;      
      }
      
      public function setLogin($valor){ 
         $this->login=$valor;      
      }
      
      public function setNombreCompleto($valor){ 
         $this->nombreCompleto=$valor;      
      }      
      
      public function setClave($valor){ 
         $this->clave=$valor;      
      }
             
      public function setHabilitado($valor){ 
         $this->habilitado=$valor;      
      }
      
      public function setGrupoUsuarios($valor){ 
         $this->grupoUsuarios=$valor;      
      }      
      
      public function setIntentos($valor){ 
         $this->intentos=$valor;      
      }      
      
      
      public function setUltimaActualizacion($valor){ 
         $this->ultimaActualizacion=$valor; 
      }
      
      public function setUltimaActualizacionLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena, pero es " . $valor);
  		}
        $this->ultimaActualizacion=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setUltimaActualizacionCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->ultimaActualizacion=FechaUtils::cadenaDMAaObjeto($valor);
      }      
      
     
      
   }
?>