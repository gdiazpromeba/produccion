<?php
  $nombreClase="ItemsCosto";
  $nombreTabla="COSTOS";
  $nombreBean="ItemCosto";
  $arr=array(
    array('COSTO_ITEM_ID', 'id', 's', true),
    array('ORDEN', 'orden', 'i', false),
    array('TEXTO_NODO', 'texto', 's', false),
    array('ITEM_PADRE', 'padreId', 's', false),
    array('PIEZA_ID', 'piezaId', 's', false),
    array('HORAS_HOMBRE', 'horasHombre', 's', false),
    array('DOTACION_SUGERIDA', 'dotacionSugerida', 'i', false),
    array('KW_H', 'kwh', 'd', false),
    array('MATERIAL_ID', 'materialId', 's', false),
    array('CANTIDAD_MATERIAL', 'cantidadMaterial', 'd', false),
    array('GASTOS_GENERALES', 'gastosGenerales', 'd', false),
    array('IMPREVISTOS', 'imprevistos', 'd', false),
    array('GANANCIA', 'ganancia', 'd', false),
    array('TIPO', 'tipo', 's', false),
  );
?>
