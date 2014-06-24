<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ItemsCostoOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PreciosPorMaterialOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/ProcesosOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/CostoSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Proceso.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ItemCosto.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');


class CostoSvcImpl implements CostoSvc {
	private $oad=null;
	private $oadPPM=null;
	//      private $oadProcesos=null;

	function __construct(){
		$this->oad=new ItemsCostoOadImpl();
		$this->oadPPM=new PreciosPorMaterialOadImpl();
		//         $this->oadProcesos=new ProcesosOadImpl();
	}

	/**
	 * devuelve un array de campos representando a un bean ItemCosto,
	 * el cual puede luego ser codificado a JSON
	 */
	public function obtiene($itemCostoId){
		$bean=$this->oad->obtiene($itemCostoId);
		$arr=$this->convierteICEnArray($bean);
		return $arr;
	}


	public function insertaEtapa($piezaId, $padreId, $etapaId, $etapaNombre, $orden){
		//si el padreId es nulo, significa que no hay raíz (pieza nueva), por lo
	    //tanto también debe insertarla
	    $exie=null;
		if ($padreId=='Nada'){
	    	$exie=$this->insertaRaiz($piezaId);
	    	$padreId=$exie['nuevoId'];
	    }
		$bean=new ItemCosto();
		$bean->setPiezaId($piezaId);
		$bean->setTexto($etapaNombre);
		$bean->setTipo('Etapa');
		$bean->setPadreId($padreId);
		$bean->setReferenteId($etapaId);
		$bean->setOrden($orden);
		$exito= $this->oad->inserta($bean);
		//por si la raíz también hubiera sido agregada
		$exito['idRaiz']=$padreId;
		return $exito;
	}

	public function modificaEtapa($costoItemId, $etapaId, $etapaNombre){
		return $this->oad->actualizaEtapa($costoItemId, $etapaId, $etapaNombre);
	}

	public function insertaProceso($piezaId, $padreId, $procesoId, $procesoNombre, $orden, $horasHombre, $dotacionSugerida, $ajuste){
		$bean=new ItemCosto();
		$bean->setPiezaId($piezaId);
		$bean->setTexto($procesoNombre);
		$bean->setTipo('Proceso');
		$bean->setPadreId($padreId);
		$bean->setReferenteId($procesoId);
		$bean->setOrden($orden);
		$bean->setTiempo($horasHombre);
		$bean->setDotacionSugerida($dotacionSugerida);
		$bean->setPorcentajeAjuste($ajuste);
		return $this->oad->inserta($bean);
	}

	public function modificaProceso($costoItemId, $procesoId, $procesoNombre, $tiempo, $dotacionSugerida, $ajuste){
		return $this->oad->actualizaProceso($costoItemId, $procesoId, $procesoNombre, $tiempo, $dotacionSugerida, $ajuste);
	}

	public function modificaMaterial($costoItemId, $materialId, $materialNombre, $cantidad){
		return $this->oad->modificaMaterial($costoItemId, $materialId, $materialNombre, $cantidad);
	}
	 



	public function insertaMaterial($piezaId, $padreId, $materialId, $materialNombre, $orden, $materialCantidad){
		$bean=new ItemCosto();
		$bean->setPiezaId($piezaId);
		$bean->setTexto($materialNombre);
		$bean->setTipo('Material');
		$bean->setPadreId($padreId);
		$bean->setReferenteId($materialId);
		$bean->setOrden($orden);
		$bean->setCantidadMaterial($materialCantidad);
		return $this->oad->inserta($bean);
	}


	public function insertaRaiz($piezaId){
		$bean=new ItemCosto();
		$bean->setPiezaId($piezaId);
		$bean->setTexto("Raíz");
		$bean->setTipo("Raíz");
		$bean->setOrden(0);
		return $this->oad->inserta($bean);
	}


	public function borraNodo($id){
		return $this->oad->borra($id);
	}


	/**
	 * modifica el atributo 'cls' del array de un nodo, para que
	 * el nodo tenga una imagen (css) acorde a su tipo (proceso, material, etc).
	 */
	private function asignaIconos(&$arrItemCosto){
		$tipo=$arrItemCosto['tipo'];
		$cls=null;
		if ($tipo=='Proceso'){
			$cls='nodo-proceso';
		}else if ($tipo=='Material'){
			$cls='nodo-material';
		}else if ($tipo=='Etapa'){
			$cls='nodo-etapa';
		}else{
			$cls='folder';
		}
		$arrItemCosto['cls']=$cls;
	}

	/**
	 * transforma un objeto ItemCosto en un array asociativo
	 * de propiedades->valores. Al array también se le agregan las
	 * propiedades con los nombres necesarios para que el árbol funcione:
	 * leaf, id, text, etc.
	 */
	private function convierteICEnArray($itemCosto) {
		$arr = (array) $itemCosto;
		$claves = array_keys($arr);
		$resultado = array ();
		foreach ($claves as $clave) {
			$claveCorta = trim(substr($clave, 10));
			$resultado[$claveCorta] = $arr[$clave];
		}
		$resultado['children'] = array ();
		$resultado['leaf']=true;
		$resultado['text']=$itemCosto->getTexto();
		$resultado['id']=$itemCosto->getId();
		$resultado['cls']='folder';
		$this->asignaIconos($resultado);
		return $resultado;
	}



	/**
	 * dado un array de beans ItemCosto, encuentra el padre, que es el
	 * único que tendrá el padre==null, y lo quita del array.
	 * El $arr de entrada es un array asociativo cuya clave es el id del objeto,
	 * y cuyo valor es el objeto
	 */
	private function encuentraPadre(& $arr) {
		$resultado = null;
		$claveEncontrada = null;
		foreach ($arr as $clave => $valor) {
			$itemCosto = $valor;
			if ($itemCosto->getPadreId() == null) {
				$resultado = $itemCosto;
				$claveEncontrada = $clave;
				break;
			}
		}
		unset($arr[$clave]);
		return $resultado;
	}

	/**
	 * ordena un array de objetos según una propiedad cualquiera
	 */
	private function objectSort(& $data, $key) {
		for ($i = count($data) - 1; $i >= 0; $i--) {
			$swapped = false;
			for ($j = 0; $j < $i; $j++) {
				if ($data[$j]-> {
					$key }
					() > $data[$j +1]-> {
						$key }
						()) {
							$tmp = $data[$j];
							$data[$j] = $data[$j +1];
							$data[$j +1] = $tmp;
							$swapped = true;
						}
			}
			if (!$swapped)
			return;
		}
	}
	 
	/**
	 * dado el array de un bean, encuentra sus hijos dentro de un array de objetos
	 * y los devuelve ordenados por el campo "orden"
	 */
	private function encuentraHijos(& $arrPadre, & $arr) {
		$padreId = $arrPadre["id"];
		$res = array ();
		foreach ($arr as $clave => $valor) {
			$itemCosto = $valor;
			if ($itemCosto->getPadreId() == $padreId) {
				$res[] = $itemCosto;
			}
		}
		//los quito del array original
		foreach ($res as $valor ){
			unset($arr[$valor->getId()]);
		}
		//ahora ordeno a los hijos según el campo "orden"
		$this->objectSort($res, 'getOrden');
		//los agrego a la propiedad "children" del padre, convertidos en array
		foreach ($res as $icHijo) {
			array_push($arrPadre['children'], $this->convierteICEnArray($icHijo));
		}
		if (count($arrPadre['children'])>0){
			$arrPadre['leaf']=false;
		}
		//llamo recursivamente a la función para cada uno de los hijos
		//(se seguirá ejecutando hasta que a $arr se le acaben los items)
		foreach ($arrPadre['children'] as & $hijo) { //-->>notar este & ante "hijo". Sin él", no lo modifica
			$this->encuentraHijos($hijo, $arr);
		}
	}

	public function test($piezaId, $costoItemId){
		echo " selPOrPieza <br/>";
		$arr = $this->oad->selPorPieza($piezaId);
		echo " selPOranalizaInsumosDeEtapa<br/>";
		$procesos=$this->analizaInsumos($arr, $costoItemId);
		echo " selPOranalizaInsumosDeEtapa<br/>";
		$ins=$this->sumarizaInsumos($procesos);
		//$tiempo=$this->analizaMODeEtapa($arr, $costoItemId);
		echo " ins<br/>";
		echo print_r($ins);
		echo "<br/>";
		echo "<br/>";
		$this->completaArrInsumos($ins);
		echo print_r($ins);
		//echo $tiempo;
	}
	
	public function horasHombrePorEtapa($piezaId, $costoItemId){
		$arr = $this->oad->selPorPieza($piezaId);
		$tiempo=$this->analizaMO($arr, $costoItemId);
		return $tiempo;
	}

	public function horasHombre($piezaId){
		$arr = $this->oad->selPorPieza($piezaId);
		$tiempo=$this->analizaMO($arr, null);
		return $tiempo;
	}		
	 

	public function insumosPorEtapa($piezaId, $costoItemId){
		$arr = $this->oad->selPorPieza($piezaId);
		$procesos=$this->analizaInsumos($arr, $costoItemId);
		$ins=$this->sumarizaInsumos($procesos);
		$this->completaArrInsumos($ins);
		return $ins;
	}
	 
	public function insumos($piezaId){
		$arr = $this->oad->selPorPieza($piezaId);
		$procesos=$this->analizaInsumos($arr, null);
		$ins=$this->sumarizaInsumos($procesos);
		$this->completaArrInsumos($ins);
		return $ins;
	}
	 
	/**
	 * dado el array de insumos sumarizados, le agrega la unidad, precio unitario y precio total correspondiente a cada insumo
	 * cada fila interna de valor queda: 0=nombre del insumo, 1=cantidad del insumo, 2=unidad del insumo, 3=precio unitario, 4=precio total
	 * @param $arrInsumos
	 */
	private function completaArrInsumos(&$arrInsumos){
		$idsMateriales=array_keys($arrInsumos);
		$vista=$this->oadPPM->selVistaPreciosPorMaterial($idsMateriales);
		foreach($arrInsumos as $clave=>&$valor){
			$filaVista=$vista[$clave];
			$valor[]=$filaVista['unidadTexto'];
			$valor[]=$filaVista['precio'];
			$valor[]=$valor[1] * $valor[3];  //cantidad por precio
		}
	}
	 
	 
	/**
	 * Creo un array asociativo cuya clave es el procesoId, y cuyo valor es un array de 2 posiciones
	 * una es el nombre del proceso, la otra es un array asociativo de materiales.
	 * El array asociativo de materiales repite la misma forma: una clave con el materialId, y un
	 * array como valor, con el nombre y la cantidad
	 * @param unknown_type $arr           un array de items costo con todos los items de la pieza (para no ir a la base de datos)
	 * @param unknown_type $costoItemId   el id del costo que se usa para seleccionar sólo un subconjunto (una etapa). Si es nulo, se
	 * seleccionan todos los costos, y los cálculos que se hacen son para todas las etapas
	 */
	private function analizaInsumos($arr, $costoItemId){
		//primero obtengo un subarray con nada más que los procesos de esa etapa
		$arrProcesos=null;
		if(!empty($costoItemId)){
			$arrProcesos=$this->costosHijos($costoItemId, $arr);
		}else{
			$arrProcesos=$this->todosLosProcesos($arr);
		}


		$procesos=array();
		foreach($arrProcesos as $proc){
			$arr1=array();
			$arr1[]=$proc->getTexto();
			$insumosDelProceso=$this->costosHijos($proc->getId(), $arr);
			$arr2=array();
			$ajuste=$proc->getPorcentajeAjuste();
			foreach ($insumosDelProceso as $beanInsumo) {
				$arr3=array();
				$arr3[]=$beanInsumo->getTexto();
				$arr3[]=$beanInsumo->getCantidadMaterial() * (100 + $ajuste)/100;
				$arr2[$beanInsumo->getReferenteId()]=$arr3;
			}
			$arr1[]=$arr2;
			$procesos[$proc->getId()]=$arr1;
		}
		return $procesos;
	}

	 

	 
	/**
	 * toma el array jerárquico de todos los insumos de todos los procesos de una etapa, y les
	 * sumariza los insumos (es decir, suma por ejemplo todas las energías eléctricas, de manera que quede
	 * una sola.
	 * @param $procesos
	 */
	private function sumarizaInsumos($procesos){
		$insumos=array();
		foreach($procesos as $procId=>$arrValor){
			$arrIns=$arrValor[1];
			foreach($arrIns as $claveIns=>$valorIns){
				if (isset($insumos[$claveIns])){
					$insumos[$claveIns][1]+=$valorIns[1];
				}else{
					$fila=array();
					$fila[]=$valorIns[0];
					$fila[]=$valorIns[1];
					$insumos[$claveIns]=$fila;
				}
			}
		}
		return $insumos;
	}
	 
	/**
	 * analiza las horas-hombre requeridas para todos los procesos de esa etapa (multiplicando por los ajustes, y por las dotaciones 
	 * sugeridas cuando son más que uno). Si el argumento de la etapa es nulo, incluye todas las etapas 
	 * @param unknown_type $arr
	 * @param unknown_type $costoItemId  el costoId de esa etapa. Si es nulo, todas las etapas.
	 */
	private function analizaMO($arr, $costoItemId){
		$arrProcesos=null;
		if(!empty($costoItemId)){
			//primero obtengo un subarray con nada más que los procesos de esa etapa
			$arrProcesos=$this->costosHijos($costoItemId, $arr);
		}else{
			//todos los procesos
			$arrProcesos=$this->todosLosProcesos($arr);
		}
		
		$tiempo=0;
		foreach($arrProcesos as $proc){
			$tiempoProceso=FechaUtils::cadenaHMSASegundos($proc->getTiempo());
			$tiempoProceso*=$proc->getDotacionSugerida();
			$tiempoProceso*= (100 + $proc->getPorcentajeAjuste()) / 100;
			$tiempo+=$tiempoProceso;
			//echo 'tiempoOriginal=' . $proc->getTiempo() . ' dotación= ' . $proc->getDotacionSugerida()   .   ' ajuste=  '  . (100 + $proc->getPorcentajeAjuste()) .  ' &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;       total='  . $tiempoProceso .  '<br/>';
		}
		return $tiempo;// en segundos
	}
	 
	/**
	 * devuelve un array plano de filas, cada una de las cuales es un
	 * costo hijo de ese proceso
	 * @param unknown_type $costoItemId
	 * @param unknown_type $arr
	 */
	private function costosHijos($costoItemId, $arr){
		$res=array();
		foreach ($arr as $clave => $valor) {
			$itemCosto = $valor;
			if ($valor->getPadreId() == $costoItemId) {
				$res[] = $itemCosto;
			}
		}
		return $res;
	}
	 
	/**
	 * devuelve sólo aquellos items  que sean procesos
	 * @param unknown_type $arr
	 */
	private function todosLosProcesos($arr){
		$res=array();
		foreach ($arr as $clave => $valor) {
			$itemCosto = $valor;
			if ($valor->getTipo() == 'Proceso') {
				$res[] = $itemCosto;
			}
		}
		return $res;
	}
	 
	 
	/**
	 * dada una pieza, selecciona todos los registros de la tabla COSTOS que describen su
	 * estructura de costos, y los organiza en forme de árbol.
	 * Devuelve un array recursivo, que comienza con la raíz del arbol, la cual tiene varias
	 * propiedades y una propiedad "children", la cual contiene un array de objetos del mismo tipo,
	 * y así sucesivamente.
	 */
	public function arbol($piezaId){
		if ($piezaId==''){ //el parámetro "cadena vacía" se manda la primera vez automáticamente
			$arrNada=array();
			$arrNada['children'] = array ();
			$arrNada['leaf']=true;
			$arrNada['text']="Ninguna pieza ha sido seleccionada";
			$arrNada['id']="Nada"; //nodo vacío inicial
			$arrNada['cls']='none';
			return $arrNada;
		}else{
			$arr = $this->oad->selPorPieza($piezaId);
			if (count($arr)>0){
				$raiz = $this->encuentraPadre($arr);
				$arrRaiz = $this->convierteICEnArray($raiz);
				$this->encuentraHijos($arrRaiz, $arr);
				return $arrRaiz;  //esto devuelve la jerarquía completa, raíz incluida
			}else{
				$arrNada=array();
				$arrNada['children'] = array ();
				$arrNada['leaf']=true;
				$arrNada['text']="Vacío(no hay información de costos para esta pieza)";
				$arrNada['id']="Nada"; //nodo vacío inicial
				return $arrNada;
			}
		}
	}


	public function corrigeOrdenes($arrIndices){
		$exitoso=true;
		$errores=array();
		foreach ($arrIndices as $clave=> $valor){
			$id=$clave;
			$nuevoOrden=$valor;
			$exito=$this->oad->actualizaIndice($id, $nuevoOrden);
			if ($exito["success"]==false){
				$exitoso=false;
				$errores[]=$exito['errors'];
				break;
			}
		}
		$result=array("success"=>$exitoso, "errors"=>$errores);
		return $result;
	}
	
	/**
	 * TODO: que se fije en la base de datos (agregar la hh promedio como insumo, con
	 * el id hardcodeado
   	 * devuelve el costo promedio de una hora-hombre
   	*/
   	 public function getCostoPromedioHh(){
   	 	return 17;
   	 }


}

?>