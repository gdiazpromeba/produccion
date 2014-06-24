FormOrdenesTerminacionDet = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormOrdenesTerminacionDet.superclass.constructor.call(this, Ext.apply({
  		id: 'formOrdenesTerminacionDet',
      height: 200,
      frame: true,
  		prefijo: 'formOrdenesTerminacionDet',
  		nombreElementoId: 'ordTermDetId',
  	  urlAgregado: '/produccion/svc/conector/ordenTermDetalle.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/ordenTermDetalle.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/ordenTermDetalle.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'ordTermDetId', id: 'ordTermDetId', itemId: 'ordTermDetId'},
        {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'cantidadOPD', id: 'cantidadOPD', itemId: 'cantidadOPD', allowBlank: false, width: 50, invalidText: 'La cantidadddd no es válida'},
        {xtype: 'combopiezas', id: 'piezaComboOPD', name: 'piezaComboOPD' , itemId: 'comboPiezas', hiddenName: 'piezaIdOPD', hiddenId: 'piezaIdOPD', allowBlank: 'false'},
        {fieldLabel: 'Cortados', xtype: 'numberfield', name: 'cantidadCortada', id: 'cantidadCortada', itemId: 'cantidadCortada', allowBlank: true, width: 50},
        {fieldLabel: 'Pulidos', xtype: 'numberfield', name: 'cantidadPulida', id: 'cantidadPulida', itemId: 'cantidadPulida', allowBlank: true, width: 50},
        {fieldLabel: 'Entrega',   name: 'fechaEntrega', id: 'fechaEntrega', itemId: 'fechaEntrega', xtype : 'fecha', allowBlank : false, muestraHoy: false},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observacionesOPD', itemId: 'observaciones',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('ordTermDetId').setValue(record.id);
         this.getComponent('cantidadOPD').setValue(record.get('cantidad'));
         this.getComponent('cantidadCortada').setValue(record.get('cantidadCortada'));
         this.getComponent('cantidadPulida').setValue(record.get('cantidadPulida'));
         this.getComponent('fechaEntrega').setValue(record.get('fechaEntrega'));
         this.getComponent('observaciones').setValue(record.get('observaciones'));
         this.getComponent("valorIdPadre").setValue(record.get('ordTermCabId'));
         this.getComponent("comboPiezas").setValue(record.get('piezaNombre'));
         Ext.get('piezaIdOPD').dom.value=record.get('piezaId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['ordTermDetId']=  this.getComponent('ordTermDetId').getValue();
         record.data['piezaId']=  Ext.get('piezaIdOPD').dom.value;
         record.data['piezaNombre']=  this.getComponent("comboPiezas").getRawValue();
         record.data['cantidad']=  this.getComponent('cantidadOPD').getValue();
         record.data['cantidadCortada']=  this.getComponent('cantidadCortada').getValue();
         record.data['cantidadPulida']=  this.getComponent('cantidadPulida').getValue();
         record.data['fechaEntrega']=  this.getComponent('fechaEntrega').getValue();
         record.data['observaciones']=  this.getComponent('observaciones').getValue();
         record.data['ordTermCabId']=this.getComponent("valorIdPadre").getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('cantidadOPD').isValid()){
  			   valido=false;
  			   mensaje='La cantidad no es válida';
  		   }
         
         if (Ext.isEmpty(Ext.get('piezaIdOPD').dom.value)){
           valido=false;
           mensaje='El artículo no es válido';
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
  	   }
    	   
	   }, config));
  
  } //constructor
  
  
  
});











