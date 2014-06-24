<?php
  $nombreClase="PedidosCabecera";
  $nombreTabla="PEDIDOS_CABECERA";
  $nombreBean="Pedido";
  $arr=array(
    array('PEDIDO_CABECERA_ID', 'id', 's', true),
    array('CLIENTE_ID', 'clienteId', 's', false),
    array('CLIENTE_NOMBRE', 'clienteNombre', 's', false),
    array('PEDIDO_FECHA', 'fecha', 's', false),
    array('PEDIDO_ESTADO', 'estado', 's', false),
    array('HABILITADO', 'habilitado', 'i', false),
  );
?>
