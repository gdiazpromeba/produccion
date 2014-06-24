FormLineas = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormLineas.superclass.constructor.call(this, Ext.apply({
  		id: 'formLineas',
      frame: true,
  		prefijo: 'formLineas',
      region: 'center',
  		nombreElementoId: 'lineaId',
  	  urlAgregado: '/produccion/svc/conector/lineas.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/lineas.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/lineas.php/borra',
  		items: [
        {xtype: 'hidden', name: 'lineaId', id: 'lineaId', itemId: 'lineaId'},
        {fieldLabel: 'Línea', xtype: 'textfield', name: 'lineaDescripcion', itemId: 'lineaDescripcion'},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observaciones', itemId: 'observaciones',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('lineaId').setValue(record.id);
         this.getComponent('lineaDescripcion').setValue(record.get('lineaDescripcion'));
         this.getComponent('observaciones').setValue(record.get('observaciones'));
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['lineaId']=  this.getComponent('lineaId').getValue();
         record.data['lineaDescripcion']=  this.getComponent('lineaDescripcion').getValue();
         record.data['observaciones']=  this.getComponent('observaciones').getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('lineaDescripcion').isValid()){
  			   valido=false;
  			   mensaje='El número de ficha no es válido';
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











