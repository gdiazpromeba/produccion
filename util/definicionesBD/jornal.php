<?php
  $nombreClase="Movimientos";
  $nombreTabla="JORNAL";
  $nombreBean="Movimiento";
  $arr=array(
    array('MOVIMIENTO_ID', 'id', 's', true),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('CLIENTE_ID', 'clienteId', 's', false),
    array('DEPOSITO_ID', 'depositoId', 's', false),
    array('CANTIDAD', 'cantidad', 'd', false),
    array('USUARIO_ID', 'usuarioId', 's', false),
    array('MOMENTO', 'momento', 's', false),
    array('COMENTARIOS', 'comentarios', 's', false),
  );
?>
