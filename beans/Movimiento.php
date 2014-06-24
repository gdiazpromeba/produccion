<?php 

   class Movimiento { 
      private $id; 
      private $piezaId; 
      private $clienteId; 
      private $depositoId; 
      private $cantidad; 
      private $usuarioId; 
      private $momento; 
      private $comentarios; 

      public function getId(){ 
         return $this->id;      }

      public function getPiezaId(){ 
         return $this->piezaId;      }

      public function getClienteId(){ 
         return $this->clienteId;      }

      public function getDepositoId(){ 
         return $this->depositoId;      }

      public function getCantidad(){ 
         return $this->cantidad;      }

      public function getUsuarioId(){ 
         return $this->usuarioId;      }

      public function getMomento(){ 
         return $this->momento;      }

      public function getComentarios(){ 
         return $this->comentarios;      }

      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setClienteId($valor){ 
         $this->clienteId=$valor; 
      }

      public function setDepositoId($valor){ 
         $this->depositoId=$valor; 
      }

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setUsuarioId($valor){ 
         $this->usuarioId=$valor; 
      }

      public function setMomento($valor){ 
         $this->momento=$valor; 
      }
      
      public function setMomentoEnteros($año, $mes, $dia){ 
      	$fechaCadena=FechaUtils::cadena($año, $mes, $dia);
        $this->momento=$fechaCadena;
      }      

      public function setComentarios($valor){ 
         $this->comentarios=$valor; 
      }

   }
?>