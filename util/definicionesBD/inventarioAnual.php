<?php
  $nombreClase="InventarioAnual";
  $nombreTabla="INVENTARIO_ANUAL";
  $nombreBean="InventarioAnual";
  $arr=array(
    array('INVENTARIO_ANUAL_ID', 'id', 's', true),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('CLIENTE_ID', 'clienteId', 's', false),
    array('DEPOSITO_ID', 'depositoId', 's', false),
    array('AÑO', 'año', 'i', false),
    array('CANTIDAD', 'cantidad', 'd', false)
  );
?>
