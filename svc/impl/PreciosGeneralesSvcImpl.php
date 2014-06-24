<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/PreciosGeneralesOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/PreciosGeneralesSvc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ItemPrecioGeneral.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
//require_once('FirePHPCore/fb.php');

class PreciosGeneralesSvcImpl implements PreciosGeneralesSvc {
	private $oad=null;

	function __construct(){
		$this->oad=new PreciosGeneralesOadImpl();
	}

	public function obtiene($id){
		$bean=$this->oad->obtiene();
		return $bean;
	}


	public function inserta($bean){
		return $this->oad->inserta($bean);
	}


	public function actualiza($bean){
		return $this->oad->actualiza($bean);
	}


	public function borra($id){
		return $this->oad->borra($id);
	}


	public function selTodos($desde, $cuantos, $sort, $dir, $piezaId, $nombrePiezaOParte, $efectivoDesde){
		$arr=$this->oad->selTodos($desde, $cuantos, $sort, $dir, $piezaId, $nombrePiezaOParte, $efectivoDesde);
		return $arr;
	}


	public function selTodosCuenta($piezaId, $nombrePiezaOParte, $efectivoDesde){
		$cantidad=$this->oad->selTodosCuenta($piezaId, $nombrePiezaOParte, $efectivoDesde);
		return $cantidad;
	}

	public function selSillones(){
		$arr=$this->oad->selSillones();
		$res=array();
		foreach ($arr as $fila){
			//Berlín
			if (stripos($fila['piezaNombre'], 'Berlín') > 0){
				if (stripos($fila['piezaNombre'], '(cie)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['berlinAltoCie']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['berlinBajoCie']=$fila['precio'];
						continue;
					}
				}
			}

			//Suraki
			if (stripos($fila['piezaNombre'], 'Suraki') > 0){
				if (stripos($fila['piezaNombre'], '(cie)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['surakiAltoCie']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'mediano') > 0 ){
						$res['surakiMedianoCie']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['surakiBajoCie']=$fila['precio'];
						continue;
					}
				}
				if (stripos($fila['piezaNombre'], '(sci)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['surakiAltoSci']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'mediano') > 0 ){
						$res['surakiMedianoSci']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['surakiBajoSci']=$fila['precio'];
						continue;
					}
				}
				if (stripos($fila['piezaNombre'], '(cir)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['surakiAltoCir']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'mediano') > 0 ){
						$res['surakiMedianoCir']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['surakiBajoCir']=$fila['precio'];
						continue;
					}
				}
			}

			//Aillites
			if (stripos($fila['piezaNombre'], 'Aillites') > 0){
				if (stripos($fila['piezaNombre'], '(cie)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['aillitesAltoCie']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'mediano') > 0 ){
						$res['aillitesMedianoCie']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['aillitesBajoCie']=$fila['precio'];
						continue;
					}
				}
				if (stripos($fila['piezaNombre'], '(sci)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['aillitesAltoSci']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'mediano') > 0 ){
						$res['aillitesMedianoSci']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['aillitesBajoSci']=$fila['precio'];
						continue;
					}
				}
				if (stripos($fila['piezaNombre'], '(cir)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['aillitesAltoCir']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'mediano') > 0 ){
						$res['aillitesMedianoCir']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['aillitesBajoCir']=$fila['precio'];
						continue;
					}
				}
			}
			
		   //Chino
			if (stripos($fila['piezaNombre'], 'Chino') > 0){
				if (stripos($fila['piezaNombre'], '(cie)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['chinoAltoCie']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['chinoBajoCie']=$fila['precio'];
						continue;
					}
				}
				if (stripos($fila['piezaNombre'], '(cir)') > 0){
					if (stripos($fila['piezaNombre'], 'alto') > 0 ){
						$res['chinoAltoCir']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'bajo') > 0 ){
						$res['chinoBajoCir']=$fila['precio'];
						continue;
					}
				}
			}			
			
		}//del foreach
		
		//formato
		foreach($res as $clave=>$valor){
			$res[$clave]=number_format($res[$clave], 2, ',', '.');
		}
		return $res;
	}
	
	public function selSillas(){
		$arr=$this->oad->selSillas();
		$res=array();
		foreach ($arr as $fila){
			//Jacobsen Mariposa
			if (stripos($fila['piezaNombre'], 'Jacobsen Mariposa') > 0){
				if (stripos($fila['piezaNombre'], 'guatambú') > 0){
					if (stripos($fila['piezaNombre'], 'sin tacos') > 0 ){
						$res['jacomariGuatSin']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'con tacos') > 0 ){
						$res['jacomariGuatCon']=$fila['precio'];
						continue;
					}
				}
			}
			
			if (stripos($fila['piezaNombre'], 'Service YPF') > 0){
				if (stripos($fila['piezaNombre'], 'guatambú') > 0){
					if (stripos($fila['piezaNombre'], 'sin tacos') > 0 ){
						$res['serviceGuatSin']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'con tacos') > 0 ){
						$res['serviceGuatCon']=$fila['precio'];
						continue;
					}
				}
			}
			
			if (stripos($fila['piezaNombre'], 'Expo') > 0){
				if (stripos($fila['piezaNombre'], 'guatambú') > 0){
					if (stripos($fila['piezaNombre'], 'sin tacos') > 0 ){
						$res['expoGuatSin']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'con tacos') > 0 ){
						$res['expoGuatCon']=$fila['precio'];
						continue;
					}
				}
			}
			
			if (stripos($fila['piezaNombre'], 'New') > 0){
				if (stripos($fila['piezaNombre'], 'guatambú') > 0){
					if (stripos($fila['piezaNombre'], 'sin tacos') > 0 ){
						$res['newGuatSin']=$fila['precio'];
						continue;
					}
					if (stripos($fila['piezaNombre'], 'con tacos') > 0 ){
						$res['newGuatCon']=$fila['precio'];
						continue;
					}
				}
			}
			
			
			
			
		}//del foreach
		
		//formato
		foreach($res as $clave=>$valor){
			$res[$clave]=number_format($res[$clave], 2, ',', '.');
		}
		return $res;
	}
	


}
?>