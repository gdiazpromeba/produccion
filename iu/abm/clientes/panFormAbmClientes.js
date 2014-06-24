
function getPanFormAbmClientes(){


var panel=new PanelFormCabeceraAbm({
	title: 'ABM Clientes',
	prefijo: 'ABMClientes',
	region: 'center',
	nombreElementoId: 'idCliente',
  urlAgregado: '/produccion/svc/conector/clientes.php/inserta',
  urlModificacion: '/produccion/svc/conector/clientes.php/actualiza',
  urlBorrado: '/produccion/svc/conector/clientes.php/borra',    
	items: [
      {fieldLabel: 'Nombre', name: 'nombreCliente', id: 'nombreCliente', itemId: 'nombreCliente', allowBlank: false, tabIndex: 0, width: 250},
      {name: 'idCliente', id: 'idCliente',  itemId: 'idCliente', xtype: 'hidden'},
      {fieldLabel: 'Condiciones de pago', xtype: 'textarea', allowBlank: true, name: 'condicionesPago', itemId: 'condicionesPago',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true},
      {fieldLabel: 'Conducta', xtype: 'textarea', allowBlank: true, name: 'conducta', itemId: 'conducta',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true},
      {fieldLabel: 'Contacto de compras', xtype: 'textarea', allowBlank: true, name: 'contactoCompras', itemId: 'contactoCompras',  width: 500, maxLength: 2000, height: 60, enableKeyEvents: true},
      {fieldLabel: 'CUIT', xtype: 'textfield', allowBlank: true, name: 'cuit', itemId: 'cuit',  width: 120, maxLength: 13},
      {fieldLabel: 'Condicion IVA', xtype: 'combo', id: 'cmbCondicionIva', name: 'cmbCondicionIva', allowBlank: true, 
        store: new Ext.data.SimpleStore({
          fields: ['condicionIva'],
          data: [["Responsable inscripto"],["Responsable no inscripto"], ["Otra"]]
        }),
        displayField: 'condicionIva', valueField: 'condicionIva', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
        hiddenName: 'condicionIva', triggerAction: 'all'
      },
      {fieldLabel: 'Dirección', xtype: 'textarea', allowBlank: true, name: 'direccion', itemId: 'direccion',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true},
      {fieldLabel: 'Localidad', xtype: 'textfield', allowBlank: true, name: 'localidad', itemId: 'localidad',  width: 200, maxLength: 50},
      {fieldLabel: 'Teléfono', xtype: 'textfield', allowBlank: true, name: 'telefono', itemId: 'telefono',  width: 150, maxLength: 50}
   ],
   
   
   pueblaDatosEnForm : function(record){
     this.getComponent('idCliente').setValue(record.id);
     this.getComponent('nombreCliente').setValue(record.get('nombre'));
     this.getComponent('condicionesPago').setValue(record.get('condicionesPago'));
     this.getComponent('conducta').setValue(record.get('conducta'));
     this.getComponent('contactoCompras').setValue(record.get('contactoCompras'));
     this.getComponent('cuit').setValue(record.get('cuit'));
     this.getComponent('cmbCondicionIva').setValue(record.get('condicionIva'));
     this.getComponent('direccion').setValue(record.get('direccion'));
     this.getComponent('localidad').setValue(record.get('localidad'));
     this.getComponent('telefono').setValue(record.get('telefono'));
     Ext.get('condicionIva').dom.value=record.get('condicionIva');
   },
   
   pueblaFormEnRegistro : function(record){
	   record.data['nombre']= this.getComponent('nombreCliente').getValue();
     record.data['id']=  this.getComponent('idCliente').getValue();
     record.data['condicionesPago']=  this.getComponent('condicionesPago').getValue();
     record.data['conducta']=  this.getComponent('conducta').getValue();
     record.data['contactoCompras']=  this.getComponent('contactoCompras').getValue();
     record.data['cuit']=  this.getComponent('cuit').getValue();
     record.data['condicionIva']=  this.getComponent('condicionIva').getValue();
     record.data['direccion']=  this.getComponent('direccion').getValue();
     record.data['localidad']=  this.getComponent('localidad').getValue();
     record.data['telefono']=  this.getComponent('telefono').getValue();
	   record.commit();
   },     
   
   validaHijo : function(muestraVentana){
	   var mensaje=null;
	   var valido=true;
	   if (!this.getComponent('nombreCliente').isValid()){
		   valido=false;
		   mensaje='El nombre del cliente es inválido';
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













