<?php

class Cliente{
	var $id;
	var $nombre;
	var $habilitado;
	var $condicionesPago;
	var $conducta;
	var $contactoCompras;
	var $cuit;
	var $condicionIva;
	var $direccion;
	var $localidad;
	var $telefono;
	
	
	var $atributos=array();
	
	public function getId(){
		return $this->id;
	}
	
	public function isHabilitado(){
		return $this->habilitado;
	}
	
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getCuit(){
		return $this->cuit;
	}
	
    public function getCondicionIva(){
		return $this->condicionIva;
	}
	
    public function getDireccion(){
		return $this->direccion;
	}
	
    public function getLocalidad(){
		return $this->localidad;
	}
	
    public function getTelefono(){
		return $this->telefono;
	}
	
	
	
	
	
	public function getAtributo($nombreAtributo){
		return $this->atributos[$nombreAtributo];
	}
	
	public function getCondicionesPago(){
		return $this->condicionesPago;
	}
	
	public function getConducta(){
		return $this->conducta;
	}
	
	public function getContactoCompras(){
		return $this->contactoCompras;
	}
	
	
	public function setId($id){
		$this->id=$id;
	}
	
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}
	
	public function setCuit($valor){
		$this->cuit=$valor;
	}
	
	public function setCondicionIva($valor){
		$this->condicionIva=$valor;
	}	
	
	public function setDireccion($valor){
		$this->direccion=$valor;
	}	
	
	public function setLocalidad($valor){
		$this->localidad=$valor;
	}	
	
	public function setTelefono($valor){
		$this->telefono=$valor;
	}	
	

	public function setHabilitado($valor){
		$this->habilitado=$valor;
	}	
	
	
   public function setAtributo($nombreAtributo, $valor){
		$this->atributos[$nombreAtributo]=$valor;
	}
	
	public function setCondicionesPago($valor){
		$this->condicionesPago=$valor;
	}
	
	public function setConducta($valor){
		$this->conducta=$valor;
	}
	
	public function setContactoCompras($valor){
		$this->contactoCompras=$valor;
	}	
	
	
}
?>
