<?php

class CategoriaLaboral{
	
	var $id;
	var $nombre;
	var $remunerativo;
	var $noRemunerativo;
	
	public function getId(){
		return $this->id;
	}
	
	public function getNombre(){
		return $this->nombre;
	}
	
	public function getRemunerativo(){
		return $this->remunerativo;
	}
	
	public function getNoRemunerativo(){
		return $this->noRemunerativo;
	}
	
	public function setId($id){
		$this->id=$id;
	}
	
	public function setNombre($nombre){
		$this->nombre=$nombre;
	}
	
	public function setRemunerativo($valor){
		$this->remunerativo=$valor;
	}
	
	public function setNoRemunerativo($valor){
		$this->noRemunerativo=$valor;
	}	
		
}
?>
