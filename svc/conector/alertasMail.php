<?php
 
  require_once   '../../config.php';
  require_once $raiz  . 'svc/impl/AlertasMailSvcImpl.php';
 

  header("Content-Type: text/html; charset=utf-8");


 

 //   require_once('FirePHPCore/fb.php');

  


  $url=$_SERVER['PHP_SELF'];

  $arr=explode("/", $url);
  $ultimo=array_pop($arr);


  $svc = new AlertasMailSvcImpl();


  
        $html="";
	//pedidos pendientes sin asignar a un laqueador
	$datos=$svc->selPendientesPasadosPrometida();
	if (count($datos)>0){
	  $html.= "<br/>";
	  $html.= "<div style='font-family:Arial,Sans Serif;'>Ítems de pedidos con laqueado y pendientes, que ho han sido asignados a ningún laqueador por más de 1 semana </div>\n";
	  $html.= "<br/>";
	  $html.= "<table style='border:1px solid black;font-family:Arial,Sans Serif'>  \n";
	  $html.= "  <tr>   \n";
	  $html.= "    <td>Pedido N°</td><td>Prometido</td><td>Cantidad</td><td>Artículo</td><td>Terminación</td><td>Cliente</td>   \n";
	  $html.= "  </tr>   \n";
	  for ($i=0; $i<count($datos); $i++){
	    $fila=$datos[$i];
	    $html.= "<tr>      \n";
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['pedidoNumero'] . "</td>  \n" ;
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['fechaPrometida'] . "</td>  \n" ;
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['cantidad'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['piezaNombre'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['terminacionNombre'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['clienteNombre'] . "</td>  \n" ;
	    $html.= "</tr>      \n";
	  }
	  $html.= "</table>  \n";   
        }
	
	$html.= "<br/>";
	$html.= "<br/>";
	
	//paquetes armados y asignados a un laqueador, que no le han sido enviados por más de un día
	$datos=$svc->selPaquetesNoEnviados();
	if (count($datos)>0){
	  $html.= "<br/>";
	  $html.= "<div style='font-family:Arial,Sans Serif;'>Paquetes ya asignados a un laqueador, pero que aún no han sido enviados</div>\n";
	  $html.= "<br/>";
	  $html.= "<table style='border:1px solid black;font-family:Arial,Sans Serif'>  \n";
	  $html.= "  <tr>   \n";
	  $html.= "    <td>Paquete N°</td><td>Laqueador</td><td>Fecha armado</td><td>Cliente</td><td>Cantidad</td><td>Artículo</td><td>Terminación</td>  \n";
	  $html.= "  </tr>   \n";
	  for ($i=0; $i<count($datos); $i++){
	    $fila=$datos[$i];
	    $html.= "<tr>      \n";
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['remitoNumero'] . "</td>  \n" ;
        $html.= "  <td style='padding:5px'>" . $fila['laqueadorNombre'] . "</td>  \n" ;	    
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['fechaEnvio'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['clienteNombre'] . "</td>  \n" ;
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['cantidad'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['piezaNombre'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['terminacionNombre'] . "</td>  \n" ;
	    $html.= "</tr>      \n";
	  }
	  $html.= "</table>  \n";   
        }
        
	//paquetes enviados a un laqueador, que éste no ha devuelto por más de 5 días
	$datos=$svc->selPaquetesNoLaqueados();
	if (count($datos)>0){
	  $html.= "<br/>";
	  $html.= "<div style='font-family:Arial,Sans Serif;'>Paquetes enviados a un laqueador, que éste no ha devuelto por más de 5 días</div>\n";
	  $html.= "<br/>";
	  $html.= "<table style='border:1px solid black;font-family:Arial,Sans Serif'>  \n";
	  $html.= "  <tr>   \n";
	  $html.= "    <td>Paquete N°</td><td>Laqueador</td><td>Fecha armado</td><td>Cliente</td><td>Cantidad</td><td>Artículo</td><td>Terminación</td>  \n";
	  $html.= "  </tr>   \n";
	  for ($i=0; $i<count($datos); $i++){
	    $fila=$datos[$i];
	    $html.= "<tr>      \n";
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['remitoNumero'] . "</td>  \n" ;
        $html.= "  <td style='padding:5px'>" . $fila['laqueadorNombre'] . "</td>  \n" ;	    
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['fechaEnvio'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['clienteNombre'] . "</td>  \n" ;
	    $html.= "  <td style='text-align:right;padding:5px'>" . $fila['cantidad'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['piezaNombre'] . "</td>  \n" ;
	    $html.= "  <td style='padding:5px'>" . $fila['terminacionNombre'] . "</td>  \n" ;
	     
	    
	    $html.= "</tr>      \n";
	  }
	  $html.= "</table>  \n";   
        }        

// 	mail('gonzalo.diaz@almarargentina.com', 'Alertas de pedidos', $html,  "Content-Type: text/html; charset=utf-8");
        mail('info@almarargentina.com', 'Alertas de pedidos', $html,  "Content-Type: text/html; charset=utf-8");
	echo $html;
	



?>