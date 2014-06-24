<?php 

   interface PedidosDetalleOad { 

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
      
      /**
       * selecciona todos los artículos alguna vez pedidos por ese cliente 
       * (u, opcionalmente, desde una fecha determinada). Esta función es útil para
       * confeccionar listas de precios desde cero para un cliente
       */
      public function selTodosArticulos($clienteId, $fechaDesde);    
      
      /**
       * obtiene de los pedidos el precio máximo que un cliente haya pagado por un artículo.
       * Útil para poblar el campo precio al crear comunicaciones totalmente nuevas, cuando
       * no hay otra referencia.
       */
      public function maximoPrecio($clienteId, $piezaId);                      
      /**
       * piezas pendientes en los pedidos, sumadas por "línea de producción", al día de la fecha
       */
      public function reportePendientesPorLinea();
      
      /**
       * cantidad de chapa de cada terminación necesaria, para todos los pedidos pendientes
       * (incluye la orientación de la chapa)
       */
      public function reporteDetalladoTerminacionesPendientes();
      
      /**
       * devuelve un array asociativo con el nombre de la terminación como clave y la cantidad
       * de unidades pendientes de cada uno, en los pedidos (sin estar discriminada por chaoa).
       * Con parámetro, toma (obligatoriamente) la línea de productos
       */
      public function terminacionesTotalesPorLinea($lineaId);
      
      /**
       * devuelve un array asociativo con el nombre de la terminación, y la cantidad
       * de unidades pendientes de cada uno, en los pedidos,
       * Con parámetro, devuelve sólo los valores de una línea de productos
       */
      public function terminacionesPorLinea($lineaId);   
      
         
   
   } 

?>