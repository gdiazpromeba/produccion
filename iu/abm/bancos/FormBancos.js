FormBancos = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormMatrices.superclass.constructor.call(this, Ext.apply({
  		id: 'formBancos',
      frame: true,
  		prefijo: 'formBancos',
//      fileUpload: true,
      region: 'center',
  		nombreElementoId: 'bancoId',
  	  urlAgregado: '/produccion/svc/conector/bancos.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/bancos.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/bancos.php/borra',
      layout: 'column',
  		items: [
        {xtype: 'hidden', name: 'bancoId', id: 'bancoId', itemId: 'bancoId'},
        {fieldLabel: 'Nombre', xtype: 'textfield',  name: 'bancoNombre', itemId: 'bancoNombre',  id: 'bancoNombre', allowBlank: false, width: 300}
      ],      
      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('bancoId').setValue(record.id);
         this.getComponent('bancoNombre').setValue(record.get('bancoNombre'));
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 record.data['bancoId']=  this.getComponent('bancoId').getValue();
  		 record.data['bancoNombre']= this.getComponent('bancoNombre').getRawValue();
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
  		   
  		   if (!this.getComponent('bancoNombre').isValid()){
  			   valido=false;
  			   mensaje='El depósito no es válido';
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

Ext.reg('formbancos', FormBancos);












