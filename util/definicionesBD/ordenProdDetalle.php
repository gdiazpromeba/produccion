<?php
  $nombreClase="OrdenesProduccion";
  $nombreTabla="ORDEN_PROD_DET";
  $nombreBean="OrdenProduccionDetalle";
  $arr=array(
    array('ORDEN_PROD_DET_ID', 'id', 's', true),
    array('ORDEN_PROD_CAB_ID', 'cabeceraId', 's', false),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('PIEZA_NOMBRE', 'piezaNombre', 's', false),
    array('CANTIDAD', 'cantidad', 'd', false),
    array('OBSERVACIONES', 'observaciones', 's', false)
  );
?>
