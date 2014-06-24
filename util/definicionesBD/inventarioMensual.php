<?php
  $nombreClase="InventarioMensual";
  $nombreTabla="INVENTARIO_MENSUAL";
  $nombreBean="InventarioMensual";
  $arr=array(
    array('INVENTARIO_MENSUAL_ID', 'id', 's', true),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('CLIENTE_ID', 'clienteId', 's', false),
    array('DEPOSITO_ID', 'depositoId', 's', false),
    array('AÑO', 'año', 'i', false),
    array('MES', 'mes', 'i', false),
    array('CANTIDAD', 'cantidad', 'd', false)
  );
?>
