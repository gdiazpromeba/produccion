FormOrdenesProduccionDet = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormOrdenesProduccionDet.superclass.constructor.call(this, Ext.apply({
  		id: 'formOrdenesProduccionDet',
      height: 200,
      frame: true,
  		prefijo: 'formOrdenesProduccionDet',
  		nombreElementoId: 'ordProdDetId',
  	  urlAgregado: '/produccion/svc/conector/ordenProdDetalle.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/ordenProdDetalle.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/ordenProdDetalle.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'ordProdDetId', id: 'ordProdDetId', itemId: 'ordProdDetId'},
        {xtype: 'combopiezas', id: 'piezaComboOPD', name: 'piezaComboOPD' , itemId: 'comboPiezas', hiddenName: 'piezaIdOPD', hiddenId: 'piezaIdOPD', allowBlank: 'false'},
        {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'cantidadOPD', id: 'cantidadOPD', itemId: 'cantidadOPD', allowBlank: false, width: 50, invalidText: 'La cantidadddd no es válida'},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observacionesOPD', itemId: 'observaciones',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('ordProdDetId').setValue(record.id);
         this.getComponent('cantidadOPD').setValue(record.get('cantidad'));
         this.getComponent('observaciones').setValue(record.get('observaciones'));
         this.getComponent("valorIdPadre").setValue(record.get('ordProdCabId'));
         this.getComponent("comboPiezas").setValue(record.get('piezaNombre'));
         Ext.get('piezaIdOPD').dom.value=record.get('piezaId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['ordProdDetId']=  this.getComponent('ordProdDetId').getValue();
         record.data['piezaId']=  Ext.get('piezaIdOPD').dom.value;
         record.data['piezaNombre']=  this.getComponent("comboPiezas").getRawValue();
         record.data['cantidad']=  this.getComponent('cantidadOPD').getValue();
         record.data['observaciones']=  this.getComponent('observaciones').getValue();
         record.data['ordProdCabId']=this.getComponent("valorIdPadre").getValue();
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











