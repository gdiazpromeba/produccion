<?php
  $nombreClase="RecepcionesDetalle";
  $nombreTabla="RECEPCION_DETALLE";
  $nombreBean="RecepcionDetalle";
  $arr=array(
    array('RECEPCION_DETALLE_ID', 'id', 's', true),
    array('RECEPCION_CABECERA_ID', 'recepcionCabeceraId', 's', false),
    array('ORDEN', 'orden', 'i', false),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('PIEZA_NOMBRE', 'piezaNombre', 's', false),
    array('CANTIDAD', 'cantidad', 'd', false),
  );
?>
