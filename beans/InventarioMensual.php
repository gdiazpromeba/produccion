<?php 

   class InventarioMensual { 
      private $id; 
      private $piezaId; 
      private $clienteId; 
      private $depositoId; 
      private $año; 
      private $mes; 
      private $cantidad; 

      public function getId(){ 
         return $this->id;      }

      public function getPiezaId(){ 
         return $this->piezaId;      }

      public function getClienteId(){ 
         return $this->clienteId;      }

      public function getDepositoId(){ 
         return $this->depositoId;      }

      public function getAño(){ 
         return $this->año;      }

      public function getMes(){ 
         return $this->mes;      }

      public function getCantidad(){ 
         return $this->cantidad;      }

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

      public function setAño($valor){ 
         $this->año=$valor; 
      }

      public function setMes($valor){ 
         $this->mes=$valor; 
      }

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

   }
?>