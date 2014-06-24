FormFichasPorLinea = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormFichasPorLinea.superclass.constructor.call(this, Ext.apply({
  		id: 'formFichasPorLinea',
      height: 200,
      frame: true,
  		prefijo: 'formFichasPorLinea',
  		nombreElementoId: 'fxlId',
      valorIdPadre: 'matrizId',
  	  urlAgregado: '/produccion/svc/conector/fichasPorLinea.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/fichasPorLinea.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/fichasPorLinea.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'fxlId', id: 'fxlId', itemId: 'fxlId'},
        {xtype: 'combofichas', itemId: 'comboFichas', hiddenName: 'piezaFicha', hiddenId: 'piezaFicha', allowBlank: false, width: 60},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observaciones', itemId: 'observaciones',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('fxlId').setValue(record.id);
         this.getComponent('observaciones').setValue(record.get('observaciones'));
         this.getComponent("valorIdPadre").setValue(record.get('lineaId'));
         Ext.get('piezaFicha').dom.value=record.get('piezaFicha');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['fxlId']=  this.getComponent('fxlId').getValue();
         record.data['piezaFicha']=  Ext.get('piezaFicha').dom.value;
         record.data['observaciones']=  this.getComponent('observaciones').getValue();
         record.data['lineaId']=this.getComponent("valorIdPadre").getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('comboFichas').isValid()){
  			   valido=false;
  			   mensaje='La ficha elegida no es válida';
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











