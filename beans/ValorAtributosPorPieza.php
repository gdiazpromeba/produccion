<?php

//require_once('FirePHPCore/fb.php');

  class ValorAtributosPorPieza {
  	private $id;
  	private $atributoId;
  	private $atributoNombre;
  	private $numerico;
  	private $valor;
  	
  	public function getId(){
  		return $this->id;
  	}
  	
  	public function getAtributoId(){
  		return $this->atributoId;
  	}
  	
  	public function getAtributoNombre(){
  		return $this->atributoNombre;
  	}
  	
  	public function isNumerico(){
  		return $this->numerico;
  	}
  	
  	public function getValor(){
  	  	return $this->valor;
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
  	
   	public function setValor($valor){
  	  	$this->valor=$valor;
  	}
  	
  	public function setNumerico($valor){
  		$this->numerico=$valor;
  	}
  	
  }
?>
