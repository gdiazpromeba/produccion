

function getPanFormAbmProveedores(){
	
	var panel=new PanelFormCabeceraAbm({
		title: 'ABM Proveedores',
		prefijo: 'ABMProveedores',
		height: 170,
		region: 'center',
		nombreElementoId: 'idProveedor',
	    urlAgregado: '/produccion/svc/conector/proveedores.php/inserta',
	    urlModificacion: '/produccion/svc/conector/proveedores.php/actualiza',
	    urlBorrado: '/produccion/svc/conector/proveedores.php/borra',
		items: [
          {name: 'idProveedor',  id: 'idProveedor', xtype: 'hidden'},
          {fieldLabel: 'Nombre', name: 'nombreProveedor', id: 'nombreProveedor', allowBlank: false, width: 250},
          {fieldLabel: 'Rubros', xtype: 'textarea', allowBlank: false, name: 'rubros', itemId: 'rubros',  width: 400, maxLength: 1000, height: 60, enableKeyEvents: true},
          {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observaciones', itemId: 'observaciones',  width: 400, maxLength: 1000, height: 90, enableKeyEvents: true}
	     ],
	   

	
	   
	   

	   
	   
	   pueblaDatosEnForm : function(record){
	     form=this.getForm();
         this.getComponent('idProveedor').setValue(record.id);
         this.getComponent('nombreProveedor').setValue(record.get('nombre'));
         this.getComponent('rubros').setValue(record.get('rubros'));
         this.getComponent('observaciones').setValue(record.get('observaciones'));
	   },
	   
	   pueblaFormEnRegistro : function(record){
		 record.data['nombre']= this.getComponent('nombreProveedor').getValue();
		 record.data['rubros']= this.getComponent('rubros').getValue();
	     record.data['id']=  this.getComponent('idProveedor').getValue();
         record.data['observaciones']=  this.getComponent('observaciones').getValue();
		 record.commit();
	   }, 	   
	   
	   validaHijo : function(muestraVentana){
		   var nombreProveedor=this.getComponent('nombreProveedor');
		   var mensaje=null;
		   var valido=true;
		   if (nombreProveedor.getValue()==null || nombreProveedor.getValue()=='' ){
			   valido=false;
			   mensaje='El nombre de proveedor no puede ser vacío';
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











