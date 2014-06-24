FormPlanProdChapDet = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormPlanProdChapDet.superclass.constructor.call(this, Ext.apply({
  		id: 'formPlanillasProduccionDet',
      frame: true,
      header: true,
  		prefijo: 'FormPlanProdChapDet',
  		nombreElementoId: 'plPrChapDetId',
  	  urlAgregado: '/produccion/svc/conector/plPrChapDet.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/plPrChapDet.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/plPrChapDet.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'plPrChapDetId', id: 'plPrChapDetId', itemId: 'plPrChapDetId'},
        {xtype: 'hidden', name: 'lineaId', id: 'lineaId', itemId: 'lineaId', value: '878de393d54ccd194c41a370ec74a981'},
        {fieldLabel: 'Medidas', xtype: 'combo', id: 'comboMedidas', name: 'comboMedidas', itemId: 'comboMedidas', allowBlank: false, 
            store: new Ext.data.SimpleStore({
          fields: ['medidaDescripcion', 'largo', 'ancho'],
          data: [["90 x 55", 90, 55],
                 ["110 x 55", 110, 55],["120 x 65", 120, 65], ["130 x 55", 130, 55], ["130 x 100", 130, 100], 
                 ["75 x 50", 75, 50],["75 x 75", 75, 75]]
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
        {fieldLabel: 'Unidades', xtype: 'numberfield', name: 'unidades', id: 'unidades', itemId: 'unidades', allowBlank: false, allowDecimals: false, width: 50},
        {xtype: 'comboenchapados', itemId: 'cmbTerminaciones', name: 'cmbTerminaciones', allowBlank: false, width: 220, hiddenName: 'terminacion', hiddenId: 'terminacion'},
        {fieldLabel: 'Largo', xtype: 'hidden', name: 'largo', id: 'largo', itemId: 'largo'},
        {fieldLabel: 'Ancho', xtype: 'hidden', name: 'ancho', id: 'ancho', itemId: 'ancho'},
        {fieldLabel: 'Cruzada', xtype: 'checkbox', name: 'cruzada', id: 'cruzada', itemId: 'cruzada', allowBlank: false, width: 50}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('plPrChapDetId').setValue(record.id);
         this.getComponent('cmbTerminaciones').setValue(record.get('terminacion'));
         this.getComponent('unidades').setValue(record.get('unidades'));
         this.getComponent('comboMedidas').setValue(record.get('largo') + ' x ' + record.get('ancho'));
         this.getComponent('largo').setValue(record.get('largo'));
         this.getComponent('ancho').setValue(record.get('ancho'));
         this.getComponent('cruzada').setValue(record.get('cruzada'));
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['plPrChapDetId']=  this.getComponent('plPrChapDetId').getValue();
         record.data['terminacion']=  Ext.get('terminacion').dom.value;
         record.data['unidades']=  this.getComponent('unidades').getRawValue();
         record.data['largo']=  this.getComponent('largo').getValue();
         record.data['ancho']=  this.getComponent('ancho').getValue();
         record.data['cruzada']=  this.getComponent('cruzada').getValue();
         record.data['lineaId']= Ext.get('lineaId').dom.value;
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('unidades').isValid()){
  			   valido=false;
  			   mensaje='La cantidad de unidades no es válida';
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











