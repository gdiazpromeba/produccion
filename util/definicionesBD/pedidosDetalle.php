<?php
  $nombreClase="PedidosDetalle";
  $nombreTabla="PEDIDOS_DETALLE";
  $nombreBean="PedidoDetalle";
  $arr=array(
    array('PEDIDO_DETALLE_ID', 'id', 's', true),
    array('PEDIDO_CABECERA_ID', 'cabeceraId', 's', false),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('PIEZA_NOMBRE', 'piezaNombre', 's', false),
    array('PEDIDO_CANTIDAD', 'cantidad', 'd', false),
    array('PEDIDO_FECHA_PROMETIDA', 'fechaPrometida', 's', false),
    array('PEDIDO_OBSERVACIONES', 'observaciones', 's', false),
    array('PEDIDO_DETALLE_PRECIO', 'precio', 's', false)
  );
?>
