<?php
  $nombreClase="RemitosDetalle";
  $nombreTabla="REMITOS_DETALLE";
  $nombreBean="RemitoDetalle";
  $arr=array(
    array('REMITO_DETALLE_ID', 'id', 's', true),
    array('REMITO_CABECERA_ID', 'cabeceraId', 's', false),
    array('REMITO_ITEM_CANTIDAD', 'cantidad', 'd', false),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('PIEZA_NOMBRE', 'piezaNombre', 's', false),
    array('REMITO_ITEM_PRECIO_UNITARIO', 'precioUnitario', 'd', false),
    array('REMITO_ITEM_PRECIO_TOTAL', 'precioTotal', 'd', false),
  );
?>
