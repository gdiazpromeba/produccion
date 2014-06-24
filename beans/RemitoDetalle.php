<?php 

   class RemitoDetalle { 
      private $id; 
      private $cabeceraId; 
      private $cantidad; 
      private $piezaId; 
      private $piezaNombre; 
      private $pedidoDetalleId; 
      private $interno;
      private $pedidoNumero;
 

      public function getId(){ 
         return $this->id;  
      }

      public function getCabeceraId(){ 
         return $this->cabeceraId;  
      }

      public function getCantidad(){ 
         return $this->cantidad;  
      }

      public function getPiezaId(){ 
         return $this->piezaId;  
      }

      public function getPiezaNombre(){ 
         return $this->piezaNombre;  
      }

      public function getPedidoDetalleId(){ 
         return $this->pedidoDetalleId;  
      }
      
      public function getInterno(){ 
         return $this->interno;  
      }
      
      public function getPedidoNumero(){ 
         return $this->pedidoNumero;  
      }



      public function setId($valor){ 
         $this->id=$valor; 
      }

      public function setCabeceraId($valor){ 
         $this->cabeceraId=$valor; 
      }

      public function setCantidad($valor){ 
         $this->cantidad=$valor; 
      }

      public function setPiezaId($valor){ 
         $this->piezaId=$valor; 
      }

      public function setPiezaNombre($valor){ 
         $this->piezaNombre=$valor; 
      }

      public function setPedidoDetalleId($valor){ 
         $this->pedidoDetalleId=$valor; 
      }
      
      public function setInterno($valor){ 
         $this->interno=$valor; 
      }
      
      public function setPedidoNumero($valor){ 
         $this->pedidoNumero=$valor; 
      }

   }
?>