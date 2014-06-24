<?php 

   interface PedidosCabeceraSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function inhabilita($id);
      public function selTodos($desde, $cuantos, $sort, $dir, $clienteId, $estado, $fechaDesde, $fechaHasta); 
      public function selTodosCuenta($clienteId, $estado, $fechaDesde, $fechaHasta);
      /**
       * dado ei id de un pedido (cabecera), verifica si todos sus hijos ya tienen una
       * cantidad remitida mayor o igual a la pedida. Si eso ocurre, cambia el estado
       * del pedido a "Completo"
       */
      public function verificaEstado($id); 
      public function sugierePedido();
      
      public function pedidoRapido($clienteId, $clienteNombre, $email, $telefono, $piezaId, $terminacionId, $terminacionNombre, $cantidad,
        $precioUnitario, $seña, $tipoPago);
   } 

?>