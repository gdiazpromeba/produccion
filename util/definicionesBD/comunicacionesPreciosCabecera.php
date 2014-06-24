<?php
  $nombreClase="ComunicacionesPreciosCabecera";
  $nombreTabla="COMUNICACIONES_PRECIOS_CABECERA";
  $nombreBean="ComunicacionPrecios";
  $arr=array(
    array('COM_PREC_CAB_ID', 'id', 's', true),
    array('CLIENTE_ID', 'clienteId', 's', false),
    array('CLIENTE_NOMBRE', 'clienteNombre', 's', false),
    array('COM_PREC_FECHA', 'fecha', 's', false),
    array('AUTORIZADO_POR', 'autorizadorId', 's', false),
    array('USUARIO_NOMBRE_COMPLETO', 'autorizadorNombre', 's', false),
    array('METODO_ENVIO', 'metodoEnvio', 's', false)
  );
?>
