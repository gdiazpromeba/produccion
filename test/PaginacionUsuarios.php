<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/Usuario.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/impl/UsuarioSvcImpl.php';
	
	
	
	$usv = new UsuarioSvcImpl();
	
	
	
	
	//creo 30 usuarios. Guardo sus claves en un array aparte
	$claves=array();
	for ($i=0; $i<8; $i++){
	  $usu = new Usuario();	
	  $usu->setUsuario("usuario" . $i);
	  $usu->setClave("clave" . $i);
	  $usu->setNombre("nombre del usuario" . $i);
	  $usv->insUsuario($usu);
	  $claves[$i]=$usu->getId();
	}
	
	//tomo 2 p�ginas, una central, otra en una zona l�mite
	
	echo "resultado1: 3 usuarios desde el usuario nro 4 ****************************\n";
	echo ("<br/>");
	$resultado1=$usv->selTodos(4, 3);
	print_r($resultado1);
	echo ("<br/>");
	echo "\nfin resultado1 ****************************\n";
	
	
    echo ("<br/>");
    echo ("<br/>");
    echo "resultado2: 20 usuarios desde el usuario nro 5 ****************************\n";
	echo ("<br/>");
	$resultado2=$usv->selTodos(5, 20);
	print_r($resultado2);
	echo ("<br/>");
	echo "\nfin resultado2 ****************************\n";
	
	
	
	//limpieza
	for ($i=0; $i<8; $i++){
	  $usv->borUsuario($claves[$i]);
	}
?>
