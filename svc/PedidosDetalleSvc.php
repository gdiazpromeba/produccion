<?php 

   interface PedidosDetalleSvc { 

      public function obtiene($id); 
      public function inserta($bean); 
      public function actualiza($bean); 
      public function borra($id); 
      public function selTodos($desde, $cuantos, $pedidoCabeceraId); 
      public function selTodosCuenta($pedidoCabeceraId); 
      public function selItemsPendientes($desde, $cuantos, $sort, $dir, $clienteId);
      public function selItemsPendientesCuenta($clienteId);
      public function selTodosPlano($desde, $cuantos, $sort, $dir, $clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte);
      public function selTodosPlanoCuenta($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte); 
      public function selUnidadesPendientesPlano($clienteId, $piezaId, $estado, $fechaDesde, $fechaHasta, 
                                    $precioTotalDesde, $precioPendienteDesde, $ficha, $nombreOParte);                                    
      public function unidadesPendientesPorFicha($cuantas);
      public function montosPendientePorFicha($cuantas);   
      public function selReportePedido($pedidoCabeceraId);    
      public function sugierePedido();     
      public function reportePendientesPorLinea();   
      public function reporteTerminacionesPorLinea();
      public function reporteDetalladoTerminacionesPendientes();
                 
                                    
      
                                    
                                          
   } 

?>