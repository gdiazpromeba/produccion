<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/FechaUtils.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Pieza.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/ValorAtributosPorPieza.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/AtributoValorPorPieza.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/PiezasSvcImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/AtributosValorPorPiezaOadImpl.php';

header('Content-Type: text/html; charset=UTF-8');

//require_once('FirePHPCore/fb.php');



  $svc=new PiezasSvcImpl();
  $oadAvpp=new AtributosValorPorPiezaOadImpl();
  
  $av=array(
       //enchapado
       '1b9ec1fe6870a8a4a13858d18203d04e'=>'guatambú', 
       '40860fc0e7fee450d206c10796dd08f4' =>'paraíso',
       'b8ea3eccbdc39aa54f81f8489c26f7f3'=>'haya',
       '61afd081e118df17ea052bf42e025b19'=>'caoba floreada',
       'd4aa07f1ab1ff3864ec0f51da0a8e75d'=>'fresno',
       'ccf772350adaaea41e6dae2065b9cdb6'=>'curipilla',
       '36c17f318d41925b8d7501069baccfbf'=>'okoumé',
       '4e2b6af93a0ebdddc6fefb2ac3cc8927'=>'para tapizar',
       //tacos
       'ed7a9dd87f446308c2c81eb6e801fb19'=>'con tacos',
       '2a96a696b4f0703964ff343b0afc0639'=>'sin tacos',
       //tamaño
       'e1af3a380a9149b086bd43c805914ac9'=>'alto',
       '0ba5a7940fdab467fbd93b900de0ea93'=>'mediano',
       'bd96fd78aa43a564b1e72348866ec2b6'=>'bajo',
       //contactos
       '168823585963099c1a878284ea9e0188'=>'(CIE)',
       '71d3832e2d2c95436ce27822a3366e60'=>'(SCI)',
       '2923aa82c74d279309cb01c53ae1dcca'=>'(CIR)',
  );
  $arr=$pieza=$svc->selTodos(0, 10000, null, null, null);
  $atributoValorId='1b9ec1fe6870a8a4a13858d18203d04e'; //guatamb;u
  foreach($arr as $bean){
    $nombre=$bean->getNombre();
    foreach($av as $key=>$value){
      if (stripos($nombre, $value)>-1){
      	$avpp=new AtributoValorPorPieza();
      	$avpp->setAtributoValorId($key);
      	$avpp->setPiezaId($bean->getId());
      	echo "insertando " . $key . " y " . $bean->getId(); 
      	$oadAvpp->inserta($avpp);
      }
    }    
  }
  
?>
