<?php
  
//  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/definicionesBD/comunicacionesPreciosCabecera.php';
  require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/util/definicionesBD/grupoUsuarios.php';
  
  //determina el ítem que es clave
  $itemclave=null;
  foreach ($arr as $item){
  	if ($item[3]==true){
  		$itemClave=$item;
  		$break;
  	}
  }
  if ($itemClave==null){
  	echo "Especificar clave primaria";
  	exit();
  }
  
  
  $res='';
  
  function tab($Num) {
	 $output = '';
	 for($i = 1; $i <= $Num; $i++) {
	    $output .= '   ';
	 }
	 return $output;
  }
  
  function escribeArchivo($nombreArchivo, $contenido){ 
    $fh = fopen("salida/$nombreArchivo", 'w') or die("can't open file");
    fwrite($fh, $contenido);
    fclose($fh);
  }
  
  
  //archivo "OadImpl" *********************************************************************
  
  
  $res.="<?php \n";
  $res.="\n";
  $res.="require_once '../../config.php';  \n";       
  $res.="require_once \$_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/AOD.php';  \n";
  $res.="require_once \$_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/$nombreClase" . "Oad.php';  \n";
  $res.="require_once \$_SERVER['DOCUMENT_ROOT'] . '/produccion/beans/$nombreBean" . ".php';  \n";
  $res.="\n";
  
  $res.=tab(1) . "class $nombreClase" . "OadImpl extends AOD implements $nombreClase" .  "Oad { \n";
  
  //función obtiene
  $res.="\n";
  $res.=tab(2) . "public function obtiene(\$id){ \n";
  $res.=tab(3) . "\$conexion=\$this->conectarse(); \n";
  $res.=tab(3) . "\$sql=\"SELECT  \\n\"; \n";
  for ($i=0; $i<count($arr); $i++){
	$linea=tab(3) . "\$sql.=\"  " .  $arr[$i][0];
	if ($i<count($arr)-1){
		$linea.=",     \\n\"; \n";
	}else{
		$linea.="    \\n\"; \n";
	}
    $res.=$linea;
  }
  $res.=tab(3) . "\$sql.=\"FROM  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"  $nombreTabla  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"WHERE  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"  $itemClave[0]='\" . \$$itemClave[1] . \"' \\n\"; \n";
  $res.=tab(3) . "\$stm=\$this->preparar(\$conexion, \$sql);  \n";
  $res.=tab(3) . "\$stm->execute();  \n";
  $res.=tab(3) . "\$bean=new $nombreBean();  \n";
  for ($i=0; $i<count($arr); $i++){
  	$res.= tab(3) . "\$" . $arr[$i][1] . "=null;  \n"; 
  }
  $res.=tab(3) . "\$stm->bind_result(";
  for ($i=0; $i<count($arr); $i++){
  	$res.= "$" . $arr[$i][1];
  	if ($i<count($arr)-1){
  	  $res.=", ";	
  	} else{
  		$res.="); \n";	
  	}
  }
  $res.=tab(3) . "if (\$stm->fetch()) { \n";
  for ($i=0; $i<count($arr); $i++){
  	$variable=$arr[$i][1];
  	$variableM=ucfirst($variable);
    $res.=tab(4) . "\$bean->set$variableM(\$$variable);\n"; 
  }
  $res.=tab(3) . "} \n";
  $res.=tab(3) . "\$this->cierra(\$conexion, \$stm); \n";
  $res.=tab(3) . "return \$bean; \n";
  $res.=tab(2) . "} \n";
  $res.="\n";    	
  
  
  //función inserta
  $res.="\n";
  $res.=tab(2) . "public function inserta(\$bean){ \n";
  $res.=tab(3) . "\$conexion=\$this->conectarse(); \n";
  $res.=tab(3) . "\$sql=\"INSERT INTO $nombreTabla (   \\n\"; \n";
  for ($i=0; $i<count($arr); $i++){
	$linea=tab(3) . "\$sql.=\"  " .  $arr[$i][0];
	if ($i<count($arr)-1){
		$linea.=",     \\n\"; \n";
	}else{
		$linea.=")    \\n\"; \n";
	}
    $res.=$linea;
  }		
  $res.=tab(3) . "\$sql.=\"VALUES (";
  for ($i=0; $i<count($arr); $i++){
	$linea="?" ;
	if ($i<count($arr)-1){
		$linea.=", ";
	}else{
		$linea.=")    \\n\"; \n";
	}
    $res.=$linea;
  }	     
  $res.=tab(3) . "\$nuevoId=\$this->idUnico(); \n";
  $res.=tab(3) . "\$bean->setId(\$nuevoId); \n";
  $res.=tab(3) . "\$stm=\$this->preparar(\$conexion, \$sql); \n"; 
  $res.=tab(3) . "\$stm->bind_param(\"";
  for ($i=0; $i<count($arr); $i++){
	$res.=$arr[$i][2];
  }
  $res.="\",";
  for ($i=0; $i<count($arr); $i++){
	$linea="\$bean->get" . ucfirst($arr[$i][1]) . "()";
	if ($i<count($arr)-1){
		$linea.=", ";
	}else{
		$linea.="); \n";
	}	
	$res.=$linea;
  }
  $res.=tab(3) . "return \$this->ejecutaYCierra(\$conexion, \$stm, \$nuevoId); \n";
  $res.=tab(2) . "} \n";
  $res.="\n"; 

  //función borra
  $res.="\n";
  $res.=tab(2) . "public function borra(\$id){ \n";
  $res.=tab(3) . "\$conexion=\$this->conectarse(); \n";
  $res.=tab(3) . "\$sql=\"DELETE FROM $nombreTabla   \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"WHERE $itemClave[0]=?   \\n\"; \n";
  $res.=tab(3) . "\$stm=\$this->preparar(\$conexion, \$sql);  \n";
  $res.=tab(3) . "\$stm->bind_param(\"s\", \$id);  \n";
  $res.=tab(3) . "return \$this->ejecutaYCierra(\$conexion, \$stm); \n";
  $res.=tab(2) . "} \n";
  $res.="\n";   
  
  
  //función actualiza
  $res.="\n";
  $res.=tab(2) . "public function actualiza(\$bean){ \n";
  $res.=tab(3) . "\$conexion=\$this->conectarse(); \n";
  $res.=tab(3) . "\$sql=\"UPDATE $nombreTabla SET   \\n\"; \n";
  for ($i=0; $i<count($arr); $i++){
  	if ($arr[$i][3]==true)
  	  continue;
	$linea=tab(3) . "\$sql.=\"  " .  $arr[$i][0] . "=?";
	if ($i<count($arr)-1){
		$linea.=",     \\n\"; \n";
	}else{
		$linea.="     \\n\"; \n";
	}
    $res.=$linea;
  }	  
  $res.=tab(3) . "\$sql.=\"WHERE $itemClave[0]=?   \\n\"; \n";
  $res.=tab(3) . "\$stm=\$this->preparar(\$conexion, \$sql);  \n";
  $res.=tab(3) . "\$stm->bind_param(\"";
  for ($i=0; $i<count($arr); $i++){
  	if ($arr[$i][3]==true)
  	  continue;
	$res.=$arr[$i][2];
  }
  $res.="s\", ";
  for ($i=0; $i<count($arr); $i++){
    if ($arr[$i][3]==true)
  	  continue;
	$linea="\$bean->get" . ucfirst($arr[$i][1]) . "()";  $arr[$i][1];
	if ($i<count($arr)-1){
		$linea.=", ";
	}
	$res.=$linea;
  }   
  $res.=", \$bean->get" . ucfirst($itemClave[1]) . "() ); \n";	
  $res.=tab(3) . "return \$this->ejecutaYCierra(\$conexion, \$stm); \n";
  $res.=tab(2) . "} \n";
  $res.="\n"; 
  
  
  
  //función seleccionaTodos
  $res.="\n";
  $res.=tab(2) . "public function selTodos(\$desde, \$cuantos){ \n";
  $res.=tab(3) . "\$conexion=\$this->conectarse(); \n";
  $res.=tab(3) . "\$sql=\"SELECT  \\n\"; \n";
  for ($i=0; $i<count($arr); $i++){
	$linea=tab(3) . "\$sql.=\"  " .  $arr[$i][0];
	if ($i<count($arr)-1){
		$linea.=",     \\n\"; \n";
	}else{
		$linea.="    \\n\"; \n";
	}
    $res.=$linea;
  }
  $res.=tab(3) . "\$sql.=\"FROM  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"  $nombreTabla  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"ORDER BY  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"  $itemClave[0]  \\n\"; \n";
  $res.=tab(3) . "\$sql.=\"LIMIT \" . \$desde . \", \" . \$cuantos . \"  \\n\"; \n";
  $res.=tab(3) . "\$stm=\$this->preparar(\$conexion, \$sql);  \n";
  $res.=tab(3) . "\$stm->execute();  \n";
  for ($i=0; $i<count($arr); $i++){
  	$res.= tab(3) . "\$" . $arr[$i][1] . "=null;  \n"; 
  }
  $res.=tab(3) . "\$stm->bind_result(";
  for ($i=0; $i<count($arr); $i++){
  	$res.= "$" . $arr[$i][1];
  	if ($i<count($arr)-1){
  	  $res.=", ";	
  	} else{
  		$res.="); \n";	
  	}
  }
  $res.=tab(3) . "\$filas = array(); \n";
  $res.=tab(3) . "while (\$stm->fetch()) { \n";
  $res.=tab(4) . "\$bean=new $nombreBean();  \n";
  for ($i=0; $i<count($arr); $i++){
  	$variable=$arr[$i][1];
  	$variableM=ucfirst($variable);
    $res.=tab(4) . "\$bean->set$variableM(\$$variable);\n"; 
  }
  $res.=tab(4) . "\$filas[\$id]=\$bean; \n";
  $res.=tab(3) . "} \n";
  $res.=tab(3) . "\$this->cierra(\$conexion, \$stm); \n";
  $res.=tab(3) . "return \$filas; \n";
  $res.=tab(2) . "} \n";
  $res.="\n";  
  
  
  //función selTodosCuenta
  $res.="\n";
  $res.=tab(2) . "public function selTodosCuenta(){ \n";
  $res.=tab(3) . "\$conexion=\$this->conectarse(); \n";
  $res.=tab(3) . "\$sql=\"SELECT COUNT(*) FROM $nombreTabla \"; \n";
  $res.=tab(3) . "\$stm=\$this->preparar(\$conexion, \$sql);  \n";
  $res.=tab(3) . "\$stm->execute();  \n";
  $res.=tab(3) . "\$cuenta=null; \n";
  $res.=tab(3) . "\$stm->bind_result(\$cuenta); \n";
  $res.=tab(3) . "\$stm->fetch();  \n";
  $res.=tab(3) . "\$this->cierra(\$conexion, \$stm); \n";
  $res.=tab(3) . "return \$cuenta; \n"; 
  $res.=tab(2) . "} \n";
  $res.="\n";      	
  
  
  
  
  $res.=tab(1) . "} \n";
  $res.="?>"; 
  

  escribeArchivo($nombreClase . "OadImpl.php", $res);
  
  //interfaz Oad *********************************************************
  $res="<?php \n";
  $res.="\n";
  
  $res.=tab(1) . "interface $nombreClase" . "Oad { \n";
  
  //función obtiene
  $res.="\n";
  $res.=tab(2) . "public function obtiene(\$id); \n";
  $res.=tab(2) . "public function inserta(\$bean); \n";
  $res.=tab(2) . "public function actualiza(\$bean); \n";
  $res.=tab(2) . "public function borra(\$id); \n";
  $res.=tab(2) . "public function selTodos(\$desde, \$cuantos); \n";
  $res.=tab(2) . "public function selTodosCuenta(); \n";
  $res.=tab(1) . "} \n";
  $res.="\n";      	  
  $res.="?>";
  
  
  
  escribeArchivo($nombreClase . "Oad.php", $res);

  //interfaz Svc *********************************************************
  $res="<?php \n";
  $res.="\n";
  
  $res.=tab(1) . "interface $nombreClase" . "Svc { \n";
  
  //función obtiene
  $res.="\n";
  $res.=tab(2) . "public function obtiene(\$id); \n";
  $res.=tab(2) . "public function inserta(\$bean); \n";
  $res.=tab(2) . "public function actualiza(\$bean); \n";
  $res.=tab(2) . "public function borra(\$id); \n";
  $res.=tab(2) . "public function selTodos(\$desde, \$cuantos); \n";
  $res.=tab(2) . "public function selTodosCuenta(); \n";
  $res.=tab(1) . "} \n";
  $res.="\n";      	  
  $res.="?>";
  
  
  
  escribeArchivo($nombreClase . "Svc.php", $res);

  
  //bean *********************************************************************
  
  
  $res="<?php \n";
  $res.="\n";
  
  $res.=tab(1) . "class $nombreBean { \n";
  
  //miembros
  for ($i=0; $i<count($arr); $i++){
	$linea=tab(2) . "private $".  $arr[$i][1] . "; \n";
	$res.=$linea;
  }
  $res.="\n";
  
  //getters
  for ($i=0; $i<count($arr); $i++){
	$res.=tab(2) . "public function get".  ucfirst($arr[$i][1]) . "(){ \n";
	$res.=tab(3) . "return \$this->" . $arr[$i][1] . ";  \n";
	$res.=tab(2) . "}\n";
	$res.="\n";
  }
  
  //setters
  for ($i=0; $i<count($arr); $i++){
	$res.=tab(2) . "public function set".  ucfirst($arr[$i][1]) . "(\$valor){ \n";
	$res.=tab(3) . "\$this->" . $arr[$i][1] . "=\$valor; \n";
	$res.=tab(2) . "}\n";
	$res.="\n";
  }

  $res.=tab(1) . "}";
  $res.="\n";      	  
  $res.="?>";
  
  escribeArchivo($nombreBean . ".php", $res);
  
  //archivo SvcImpl ******************************************************
  
  $res="<?php \n";
  $res.="\n";
  
  $res.="require_once \$_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/$nombreClase" . "OadImpl.php';  \n";
  $res.="require_once \$_SERVER['DOCUMENT_ROOT'] . '/produccion/svc/$nombreClase" . "Svc.php';  \n";
  $res.="\n";
  
  $res.=tab(1) . "class " . $nombreClase  . "SvcImpl implements $nombreClase" .  "Svc { \n";
  
  //aod miembro
  $linea=tab(2) . "private \$oad=null; \n";
  
  //constructor
  $res.=tab(2) . "private \$oad=null; \n";
  $res.="\n";
  $res.=tab(2) . "function __construct(){ \n";
  $res.=tab(3) . "\$this->oad=new " . $nombreClase .   "OadImpl();   \n";
  $res.=tab(2) . "} \n";


  //función obtiene
  $res.="\n";
  $res.=tab(2) . "public function obtiene(\$id){ \n";
  $res.=tab(3) . "\$bean=\$this->oad->obtiene(\$id); \n";
  $res.=tab(3) . "return \$bean; \n";
  $res.=tab(2) . "} \n";
  $res.="\n";
  
   //función inserta
  $res.="\n";
  $res.=tab(2) . "public function inserta(\$bean){ \n";
  $res.=tab(3) . "return \$this->oad->inserta(\$bean); \n";
  $res.=tab(2) . "} \n";
  $res.="\n"; 
  
  
   //función actualiza
  $res.="\n";
  $res.=tab(2) . "public function actualiza(\$bean){ \n";
  $res.=tab(3) . "return \$this->oad->actualiza(\$bean); \n";
  $res.=tab(2) . "} \n";
  $res.="\n";   
  
  //función borra
  $res.="\n";
  $res.=tab(2) . "public function borra(\$id){ \n";
  $res.=tab(3) . "return \$this->oad->borra(\$id); \n";
  $res.=tab(2) . "} \n";
  $res.="\n";
  
  //función selTodos
  $res.="\n";
  $res.=tab(2) . "public function selTodos(\$desde, \$cuantos){ \n";
  $res.=tab(3) . "\$arr=\$this->oad->selTodos(\$desde, \$cuantos); \n";
  $res.=tab(3) . "return \$arr; \n";
  $res.=tab(2) . "} \n";
  $res.="\n";
  
  //función selTodosCuenta
  $res.="\n";
  $res.=tab(2) . "public function selTodosCuenta(){ \n";
  $res.=tab(3) . "\$cantidad=\$this->oad->selTodosCuenta(); \n";
  $res.=tab(3) . "return \$cantidad; \n";
  $res.=tab(2) . "} \n";
  $res.="\n";  
  
  $res.=tab(1) . "}";
  $res.="\n";      	  
  $res.="?>";
  
  escribeArchivo($nombreClase . "SvcImpl.php", $res);
    
    
  echo $res;
  
?>
