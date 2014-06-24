FormLineasPorMatriz = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormLineasPorMatriz.superclass.constructor.call(this, Ext.apply({
  		id: 'formLineasPorMatriz',
      height: 200,
      frame: true,
  		prefijo: 'formLineasPorMatriz',
  		nombreElementoId: 'lxmId',
      valorIdPadre: 'matrizId',
  	  urlAgregado: '/produccion/svc/conector/lineasPorMatriz.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/lineasPorMatriz.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/lineasPorMatriz.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'lxmId', id: 'lxmId', itemId: 'lxmId'},
        {fieldLabel: 'Línea', xtype: 'combolineas', id: 'comboLineas', name: 'comboLineas' , itemId: 'comboLineas', hiddenName: 'lineaIdMatDet', hiddenId: 'lineaIdMatDet'},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observaciones', itemId: 'observaciones',  width: 500, maxLength: 2000, height: 40, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('lxmId').setValue(record.id);
         this.getComponent('observaciones').setValue(record.get('observaciones'));
         this.getComponent("valorIdPadre").setValue(record.get('matrizId'));
         Ext.get('lineaIdMatDet').dom.value=record.get('lineaId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['lxmId']=  this.getComponent('lxmId').getValue();
         record.data['lineaId']=  Ext.get('lineaIdMatDet').dom.value;
         record.data['observaciones']=  this.getComponent('observaciones').getValue();
         record.data['matrizId']=this.getComponent("valorIdPadre").getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('comboLineas').isValid()){
  			   valido=false;
  			   mensaje='La línea elegida no es válida';
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











