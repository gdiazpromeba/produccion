<?php

   class Laqueador {
      private $id;
      private $nombre;
      private $habilitada;

      public function getId(){
         return $this->id;      }



      public function getNombre(){
         return $this->nombre;
      }


      public function isHabilitada(){
         return $this->habilitada;
      }


      public function setId($valor){
         $this->id=$valor;
      }


      public function setNombre($valor){
         $this->nombre=$valor;
      }

      public function setHabilitada($valor){
         $this->habilitada=$valor;
      }
   }
?>