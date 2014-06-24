<?php 

   interface CostoSvc { 
   	  public function insertaProceso($piezaId, $padreId, $procesoId, $procesoNombre, $orden, 
   	                                 $horasHombre, $dotacionSugerida, $ajuste); 
      public function modificaProceso($costoItemId, $procesoId, $procesoNombre, $tiempo, 
                                     $dotacionSugerida, $ajuste);

  	  public function insertaEtapa($piezaId, $padreId, $etapaId, $etapaNombre, $orden);
      public function modificaEtapa($costoItemId, $etapaId, $etapaNombre);
                                      
      public function insertaMaterial($piezaId, $padreId, $materialId, $materialNombre, $orden, $cantidadMaterial);
      public function modificaMaterial($costoItemId, $materialId, $materialNombre, $cantidad);
      public function insertaRaiz($piezaId);
      public function arbol($piezaId);
      public function borraNodo($id);
      public function obtiene($itemCostoId);
      public function corrigeOrdenes($arrIndices);
      
      	  
      /**
       * devuelve un array con los insumos sumarizados de todos los procesos de esa etapa, incluyendo su precio unitario y su costo
       * @param unknown_type $piezaId
       * @param unknown_type $costoItemId
       */
   	  public function insumosPorEtapa($piezaId, $costoItemId);
   	  
   	  /**
   	   * similar a "insumos por etapa", pero devuelve todos los insumos de todas las etapas de esa pieza.
   	   * @param $piezaId
   	   */
   	  public function insumos($piezaId);
   	  
   	  /**
   	   * calcula ls horas hombre de una etapa en particular de la manufactura de una pieza, teniendo en cuenta los ajustes y la dotación sugerida
   	   * para cada proceso.
   	   * @param $piezaId
   	   * @param $costoItemId
   	   */
   	  public function horasHombrePorEtapa($piezaId, $costoItemId);
   	  
   	  
   	  /**
   	   * lo mismo que horasHombrePorEtapa, pero para todas las etapas de la manufactura de esa pieza
   	   * @param $piezaId
   	   * @param $costoItemId
   	   */
   	  public function horasHombre($piezaId);
   	  
   	  /**
   	   * devuelve el costo promedio de una hora-hombre
   	   */
   	  public function getCostoPromedioHh();
   	  
   } 

?>