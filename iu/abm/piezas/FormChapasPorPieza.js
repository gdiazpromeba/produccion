FormChapasPorPieza = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormChapasPorPieza.superclass.constructor.call(this, Ext.apply({
      frame: true,
      header: true,
  		prefijo: 'FormChapasPorPieza',
  		nombreElementoId: 'chXPId',
      height: 210,
  	  urlAgregado: '/produccion/svc/conector/chapasPorPieza.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/chapasPorPieza.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/chapasPorPieza.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'chXPId', id: 'chXPId', itemId: 'chXPId'},
        {fieldLabel: 'Medidas', xtype: 'combo', id: 'comboMedidas', name: 'comboMedidas', itemId: 'comboMedidas', allowBlank: false, width: 100,
            store: new Ext.data.SimpleStore({
          fields: ['medidaDescripcion', 'largo', 'ancho'],
          data: [["90 x 55", 90, 55],["110 x 55", 110, 55], ["130 x 55", 130, 55], ["120 x 65", 120, 65],["75 x 50", 75, 50],["75 x 75", 75, 75]]
          }),
            displayField: 'medidaDescripcion', valueField: 'medidaDescripcion', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false, triggerAction: 'all',            
            listeners: {
              scope: this,
              select: function(combo, record, index){
                this.getComponent('largo').setValue(record.data.largo);
                this.getComponent('ancho').setValue(record.data.ancho);
              } 
            }
        },      
        {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'cantidad', id: 'cantidad', itemId: 'cantidad', allowBlank: false, allowDecimals: true, decimalPrecision: 2, width: 50},
        {xtype: 'comboenchapados', itemId: 'cmbTerminaciones', name: 'cmbTerminaciones', allowBlank: false, width: 220, hiddenName: 'terminacion', hiddenId: 'terminacion'},
        {fieldLabel: 'Largo', xtype: 'hidden', name: 'largo', id: 'largo', itemId: 'largo'},
        {fieldLabel: 'Ancho', xtype: 'hidden', name: 'ancho', id: 'ancho', itemId: 'ancho'},
        {fieldLabel: 'Cruzada', xtype: 'checkbox', name: 'cruzada', id: 'cruzada', itemId: 'cruzada', allowBlank: false, width: 50}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('chXPId').setValue(record.id);
         this.getComponent('cmbTerminaciones').setValue(record.get('terminacion'));
         this.getComponent('valorIdPadre').setValue(record.get('piezaId'));
         this.getComponent('cantidad').setValue(record.get('cantidad'));
         this.getComponent('comboMedidas').setValue(record.get('largo') + ' x ' + record.get('ancho'));
         this.getComponent('largo').setValue(record.get('largo'));
         this.getComponent('ancho').setValue(record.get('ancho'));
         this.getComponent('cruzada').setValue(record.get('cruzada'));
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 record.id=  this.getComponent('chXPId').getValue();
         record.data['piezaId']=  this.getComponent('valorIdPadre').getValue();
         record.data['terminacion']=  Ext.get('terminacion').dom.value;
         record.data['cantidad']=  this.getComponent('cantidad').getValue();
         record.data['largo']=  this.getComponent('largo').getValue();
         record.data['ancho']=  this.getComponent('ancho').getValue();
         record.data['cruzada']=  this.getComponent('cruzada').getValue();
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('cantidad').isValid()){
  			   valido=false;
  			   mensaje='La cantidad no es válida';
  		   }
         
         if (!this.getComponent('cmbTerminaciones').isValid()){
           valido=false;
           mensaje='La terminación no es válida';
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











