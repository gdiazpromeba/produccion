<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/UsuariosOad.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/UsuariosOadImpl.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/GruposUsuariosOad.php'; 
require_once $_SERVER['DOCUMENT_ROOT'] . '/produccion/oad/impl/GruposUsuariosOadImpl.php'; 

 

class UsuarioSvcImpl{
	var $oad;
	
	function UsuarioSvcImpl(){
		$this->oad=new UsuariosOadImpl();
		$this->oadGrupos=new GruposUsuariosOadImpl();
	}
	
		
	public function obtUsuarioPorId($id){
		return $this->oad->obtiene($id);  	
	}
	
	public function obtUsuarioPorUid($uid){
		return $this->oad->obtienePorUid($uid);  	
	}
	
	
	public function insUsuario($usuario){
	  return $this->oad->inserta($usuario);	
	}
	
	public function borUsuario($id){
		return $this->oad->borra($id);	
	}
	
	public function inhabilita($id){
		return $this->oad->inhabilita($id);	
	}	
	
	
	public function actUsuario($usuario){
		return $this->oad->actualiza($usuario);	
	}
	
    /**
	 * 
	 * @param unknown_type $login
	 * @param unknown_type $clave
	 * 	valida si el usuario existe, y si la clave corresponde al usuario dado
	 *  devuelve:
	 *  - una propiedad "success" puesta a "verdadero" o "falso", sin diferenciar entre no existencia e
	 *    invalidez de la clave o del usuario
	 *  - un array "grupos", con las etiquetas de los grupos a los que este usuario tiene acceso 
	 *   (en caso de que la validación sea exitosa)
	*/
	public function validaUsuario($login, $clave){
	  $beanUsuario=$this->oad->obtienePorUid($login);
	  if (empty($beanUsuario)){
	  	$res=array();
	  	$res['success']=false;
	  	return $res;
	  }
	  $bean=$this->oad->validaUsuario($login, $clave);	
	  $beansGrupos=$this->oadGrupos->selPorUsuario(0, 100, $beanUsuario->getId());
	  $bean['grupos']=array();
	  foreach($beansGrupos as $grupo){
	  	$arrGrupo=array();
	  	$arrGrupo['id']=$grupo->getId();
	  	$arrGrupo['nombre']=$grupo->getNombre();
	  	$bean['grupos'][]=$arrGrupo;
	  }
	  //$bean['grupos']=$this->oadGrupos->selPorUsuario(0, 100, $beanUsuario->getId());
	  return $bean;
	}
	
	/**
	 * valida la clave para el usuario especificado, y, si es válida, la cambia por la nueva
	 * clave especificada. Se supone que ya ha sido comprobado que no son vacías, y que la clave
	 * nueva es distinta de la vieja.
	 * Si algo no funciona, devuelve mensajes de error adecuados en la propiedad "errors" del objeto JSON
	 * de resultado.
	 */
	public function cambiaClave($login, $claveAnterior, $claveNueva){
	  $res=array();
	  $valido=$this->oad->validaUsuario($login, $claveAnterior);
	  if (!$valido){
	    $res["success"]=true;
	    $res["error"]="Usuario o clave incorrectos.";
	    return $res;
	  }	
	  $usuario=$this->oad->obtienePorUid($login);
	  $usuario->setClave($claveNueva);
	  $resAct=$this->oad->actualiza($usuario);
	  if ($resAct['success']==false){
	    $res["success"]=true;
	    $res["error"]=$resAct['errors'];
	    return $res;
	  }else{
	    $res['success']=true;
	    return $res;
	  }
	}
		
	
	public function selTodosCuenta($nombreOParte, $grupoId){
	  return $this->oad->selTodosCuenta($nombreOParte, $grupoId);	
	}
	
	public function selTodos($desde, $cuantos, $nombreOParte, $grupoId){
		 return $this->oad->selTodos($desde, $cuantos, $nombreOParte, $grupoId);	
	}
}
?>
