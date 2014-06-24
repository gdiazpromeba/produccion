<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/DatosRelojSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/EmpleadosSvcImpl.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/DatoReloj.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/reloj/AnalisisLecturasDiarias.php';
  
//  require_once('FirePHPCore/fb.php');
 
 
  $url=$_SERVER['PHP_SELF'];
  $arr=explode("/", $url);
  $ultimo=array_pop($arr);
  $svc=new DatosRelojSvcImpl();
  $svcEmp=new EmpleadosSvcImpl();

  if ($ultimo=='cargaHoras'){
  	$svc->cargaHoras();
  }else if ($ultimo=='calculaQuincena'){
  	header("Content-Type: text/html; charset=utf-8");
  	$fechaDesde=FechaUtils::cadenaAObjeto($_REQUEST['fechaDesde']);
  	$fechaHasta=FechaUtils::cadenaAObjeto($_REQUEST['fechaHasta']);
  	$empleadoId=$_REQUEST['empleadoId'];
  	$empBean=$svcEmp->obtiene($empleadoId);
    $arr=$svc->calculaQuincena($fechaDesde,  $fechaHasta, $empleadoId);
//    print_r($arr);

    $sumHorasReales=0;
    $sumHorasSegunHorario=0;
    
    $html= "<html> \n";
    $html.= "  <head> \n";
	$html.= "  <link rel='stylesheet' type='text/css' href='/produccion/recursos/css/estilo.css' /> \n";
	$html.= "  </head> \n";
	$html.= "  <body> \n";
	
	$html.= "<div class='titulo-pedido'>  \n"; 
	$html.= $empBean->getApellido() . ", " . $empBean->getNombre() . "<br/>";
	$html.= "</div>  \n";
	$html.= "<div class='subtitulo-pedido'>  \n"; 
	$html.= $fechaDesde->format('d/m/Y') . " al "  . $fechaHasta->format('d/m/Y') . "<br/>";
	$html.= "</div>  \n";
	$html.= "<br/>";

	$diasSemana=array('lunes', 'martes', 'miércoles', 'jueves', 'viernes', 'sábado', 'domingo');
    $html.= "    <table border='1'> \n";
    $html.= "      <tr> \n";
    $html.= "        <td class='encabezado-tabla-pedido'>Día</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido'>Lecturas</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido'>Horas reales</td> \n";
    $html.= "        <td class='encabezado-tabla-pedido'>Horas según horario</td> \n";
    $html.= "      </tr> \n";
    foreach($arr as $al){
    	$html.= "  <tr> \n";
    	$html.= "    <td class='item-tabla-pedido'> \n";
    	$fechaDia=new DateTime($al->obtieneDia());
        $html.= $diasSemana[$fechaDia->format('N')-1] . " " .    $fechaDia->format("j") . "   ";
        $html.= "    </td> \n";
        $html.= "    <td class='item-tabla-pedido'> \n";
        $html.= $al->obtieneCadenaLecturas() ;
        $html.= "    </td> \n";
        if ($al->esValido()){
          $html.= "  <td class='item-tabla-pedido' style='text-align:right'> \n";	
          $html.=  round($al->horasReales(), 2) ;
          $html.= "    </td> \n";
          $html.= "  <td class='item-tabla-pedido' style='text-align:right'> \n";	
          $html.=  round($al->horasSegunHorario()) ;
          $html.= "    </td> \n";
          $sumHorasReales+= $al->horasReales();
          $sumHorasSegúnHorario+= $al->horasSegunHorario();
          $html.= "  <td class='item-tabla-pedido'> \n";
          if ($al->tieneAlarmas()){
            foreach($al->obtieneAlarmas() as $alarma){
              $html.= $alarma . "<br/>"; 
            }  
          }
          $html.= "  </td> \n";
        }else{
          $html.= "  <td colspan='3' class='item-tabla-pedido'> \n";	
          $html.= "&nbsp;Las horas no son v&aacute;lidas";
          $html.= "&nbsp;Motivo: " . $al->obtieneRazonInvalido() . "<br/>";
          $html.= "  </td> \n";
        }
        $html.= "  <tr> \n";
    } 
    $html.= "</table> \n";
  
    $html.= "<br/>";
    $html.= "<div class='subtitulo-pedido'>  \n";
    $html.= "  Total horas reales: " . $sumHorasReales .  "<br/>";
    $html.= "  Total horas según horario: " . $sumHorasSegúnHorario .  "<br/>";
    $html.= "</div>  \n";

    $html.= "  </body> \n";
    $html.= "</html> \n";		
		
    echo $html;    
  }

 
  
?>
