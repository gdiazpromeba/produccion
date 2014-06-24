<?php 

   class Empleado { 
   	
      private $id; 
      private $nombre;
      private $apellido;
      private $nombreCompleto;
      private $tarjetaNumero;
      private $fechaInicio;
      private $categoriaId;
      private $categoriaNombre;
      private $sindicalizado;
      private $direccion;
      private $cuil;
      private $nacimiento;
      private $dependientes;

      public function getId(){ 
         return $this->id;      
      }

      public function getNombre(){ 
         return $this->nombre;      
      }
      
      public function getNombreCompleto(){ 
         return $this->nombreCompleto;      
      }
      
         
      public function getApellido(){ 
         return $this->apellido;      
      }
      
      public function getCategoriaId(){ 
         return $this->categoriaId;      
      }
      
      public function getCategoriaNombre(){ 
         return $this->categoriaNombre;      
      }
      
      
         
      public function getTarjetaNumero(){ 
         return $this->tarjetaNumero;      
      }
      
      public function getFechaInicio(){ 
         return $this->fechaInicio;  
      }
      
      public function getFechaInicioLarga(){ 
         return FechaUtils::dateTimeaCadena($this->fechaInicio);  
      }
      
      public function getFechaInicioCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->fechaInicio);  
      }
      
      public function getNacimiento(){ 
         return $this->nacimiento;  
      }
      
      public function getNacimientoLarga(){ 
         return FechaUtils::dateTimeaCadena($this->nacimiento);  
      }
      
      public function getNacimientoCorta(){ 
         return FechaUtils::dateTimeaCadenaDMA($this->nacimiento);  
      }
      

      public function isSindicalizado(){
      	return $this->sindicalizado;
      }
      
      public function getDependientes(){
        return $this->dependientes;
      }
 
    
      public function getDireccion(){
        return $this->direccion;
      }      
      
      public function getCuil(){
        return $this->cuil;
      }
      

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setNombre($valor){ 
         $this->nombre=$valor; 
      }
      
      public function setNombreCompleto($valor){ 
         $this->nombreCompleto=$valor; 
      }      
      
      public function setApellido($valor){ 
         $this->apellido=$valor; 
      }
      
      public function setTarjetaNumero($valor){ 
         $this->tarjetaNumero=$valor;      
      }
      
      public function setCategoriaId($valor){ 
         $this->categoriaId=$valor;      
      }
      
      public function setCategoriaNombre($valor){ 
         $this->categoriaNombre=$valor;      
      }
      
      public function setFechaInicio($valor){ 
         $this->fechaInicio=$valor; 
      }
      
      public function setFechaInicioLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaInicio=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setFechaInicioCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->fechaInicio=FechaUtils::cadenaDMAaObjeto($valor);
      }
      
      public function setNacimiento($valor){ 
         $this->nacimiento=$valor; 
      }
      
      public function setNacimientoLarga($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->nacimiento=FechaUtils::creaDeCadena($valor); 
      }
      
      public function setNacimientoCorta($valor){ 
        if (!is_string($valor)){
  		  throw new Exception("el valor recibido debería ser una cadena");
  		}
        $this->nacimiento=FechaUtils::cadenaDMAaObjeto($valor);
      }
      
      
      public function setSindicalizado($valor){
      	$this->sindicalizado=$valor;
      }
      
      public function setDependientes($valor){
        $this->dependientes=$valor;
      }
      
      public function setDireccion($valor){
        $this->direccion=$valor;
      }
      
      public function setCuil($valor){
        $this->cuil=$valor;
      }
  }
?>