function getPanFormAbmUsuarios(){


var panel=new PanelFormCabeceraAbm({
	title: 'ABM Usuarios',
	prefijo: 'ABMUsuarios',
	height: 170,
	labelWidth: 150,
	region: 'center',
	nombreElementoId: 'idUsuario',
    urlAgregado: '/produccion/svc/conector/usuarios.php/inserta',
    urlModificacion: '/produccion/svc/conector/usuarios.php/actualiza',
    urlBorrado: '/produccion/svc/conector/usuarios.php/inhabilita',	
	items: [{
        fieldLabel: 'Nombre Completo',
        name: 'nombreUsuario',
        id: 'nombreUsuario',
        allowBlank: false,
      },{
        fieldLabel: 'Identificador de Usuario',
        name: 'usuario',
        id: 'usuario',
        allowBlank: false,
      },{
         fieldLabel: 'Clave',
         inputType: 'textfield',
         name: 'clave',
         id: 'clave',
         allowBlank: false,
      },{
    	name: 'idUsuario',
    	id: 'idUsuario',
    	xtype: 'hidden'
    }
   ],

   


     
   
   pueblaDatosEnForm : function(record){ 
	   var form=this.getForm();
	   form.setValues([
	                   {id:'idUsuario', value: record.id},
	                   {id:'nombreUsuario', value: record.get('nombreUsuario')},
	                   {id:'usuario', value: record.get('usuario')},
	                   {id:'clave', value: record.get('clave')}
                      ]);
   },
   
   pueblaFormEnRegistro : function(record){
	   record.data['nombreUsuario']= Ext.getCmp('nombreUsuario').getValue();
       record.data['id']=  Ext.get('idUsuario').dom.value;
       record.data['usuario']= Ext.getCmp('usuario').getValue();
       record.data['clave']= Ext.getCmp('clave').getValue();
	   record.commit();
   },    
   
   validaHijo : function(muestraVentana){
	   var mensaje=null;
	   var valido=true;
	   var nombreUsuario=Ext.get('nombreUsuario');
	   var usuario=Ext.get('usuario');
	   var clave=Ext.get('clave');
	   if (nombreUsuario.getValue()==null || nombreUsuario.getValue()=='' ){
		   valido=false;
		   mensaje='El nombre del usuario no puede ser vacío';
	   }else if (usuario.getValue()==null || usuario.getValue()=='' ){
		   valido=false;
		   mensaje='El identificador de usuario no puede ser vacío';
	   }else if (clave.getValue()==null || clave.getValue()=='' ){
		   valido=false;
		   mensaje='La clave no puede ser vacía';
	   }
	   
	   if (!valido && muestraVentana){
           Ext.MessageBox.show({
               title: 'Validación de campos',
               msg: mensaje,
               buttons: Ext.MessageBox.OK,
               icon: Ext.MessageBox.ERROR
           });
	   }
	   return valido;
   },
   
   
   
   onRender : function(){
	   PanelFormCabeceraAbm.superclass.onRender.apply(this, arguments);
   }
 


});

return panel;
}













