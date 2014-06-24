FormPlanillasProduccionDet = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormPlanillasProduccionDet.superclass.constructor.call(this, Ext.apply({
  		id: 'formPlanillasProduccionDet',
      frame: true,
      header: true,
  		prefijo: 'formPlanillasProduccionDet',
  		nombreElementoId: 'planProdDetId',
  	  urlAgregado: '/produccion/svc/conector/planillasProduccionDetalle.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/planillasProduccionDetalle.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/planillasProduccionDetalle.php/borra',
      layout: 'form',
  		items: [
        {xtype: 'hidden', name: 'planProdDetId', id: 'planProdDetId', itemId: 'planProdDetId'},
        {fieldLabel: 'Estación de trabajo', xtype: 'combo', id: 'comboEstaciones', name: 'comboEstaciones', itemId: 'comboEstaciones', allowBlank: false, 
           store: new Ext.data.SimpleStore({
             fields: ['descripcion'],
             data: [["1"],["2"],["3"],["4"],["5"],["Otra"]]
           }),
           displayField: 'descripcion', valueField: 'descripcion', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
           hiddenName: 'estacionTrabajo', triggerAction: 'all', width: 100},
        {xtype: 'combomatrices', name: 'comboMatrices' , itemId: 'comboMatrices', hiddenName: 'matrizId', hiddenId: 'matrizId', allowBlank: false},
        {fieldLabel: 'Prensadas', xtype: 'numberfield', name: 'cantidadOPD', id: 'cantidadPPD', itemId: 'cantidadPPD', allowBlank: false, width: 50},
        {xtype: 'comboenchapados', itemId: 'cmbTerminaciones', name: 'cmbTerminaciones', allowBlank: false, width: 220, hiddenName: 'terminacion', hiddenId: 'terminacion'},
        {fieldLabel: 'Espesor', xtype: 'numberfield', name: 'espesor', id: 'espesor', itemId: 'espesor', allowBlank: true, allowDecimals: true, width: 50},
        {fieldLabel: 'Reparadas', xtype: 'checkbox', name: 'reparadas', id: 'reparadas', itemId: 'reparadas', allowBlank: false, width: 50},
        {fieldLabel: 'Descartadas', xtype: 'checkbox', name: 'descartadas', id: 'descartadas', itemId: 'descartadas', allowBlank: false, width: 50},
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observacionesDet', itemId: 'observacionesDet',  width: 250, maxLength: 500, height: 40, enableKeyEvents: true}
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('planProdDetId').setValue(record.id);
         this.getComponent('comboMatrices').setValue(record.get('matrizNombre'));
         this.getComponent('cantidadPPD').setValue(record.get('cantidad'));
         this.getComponent('espesor').setValue(record.get('espesor'));
         this.getComponent('observacionesDet').setValue(record.get('observacionesDet'));
         this.getComponent("valorIdPadre").setValue(record.get('planProdCabId'));
         this.getComponent('comboEstaciones').setValue(record.get('estacionTrabajo'));
         this.getComponent('cmbTerminaciones').setValue(record.get('terminacion'));
         this.getComponent('reparadas').setValue(record.get('reparada'));
         this.getComponent('descartadas').setValue(record.get('descartada'));
         Ext.get('matrizId').dom.value=record.get('matrizId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['planProdDetId']=  this.getComponent('planProdDetId').getValue();
         record.data['matrizId']=  Ext.get('matrizId').dom.value;
         record.data['matrizNombre']=  this.getComponent('comboMatrices').getRawValue();
         record.data['estacionTrabajo']=  this.getComponent('comboEstaciones').getValue();
         record.data['cantidad']=  this.getComponent('cantidadPPD').getValue();
         record.data['espesor']=  this.getComponent('espesor').getValue();
         record.data['terminacion']=  Ext.get('terminacion').dom.value;
         record.data['reparada']=  this.getComponent('reparadas').getValue();
         record.data['descartada']=  this.getComponent('descartadas').getValue();
         record.data['observacionesDet']=  this.getComponent('observacionesDet').getValue();
         record.data['planProdCabId']=this.getComponent("valorIdPadre").getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('cantidadPPD').isValid()){
  			   valido=false;
  			   mensaje='La cantidad no es válida';
  		   }
         
         if (!this.getComponent('espesor').isValid()){
           valido=false;
           mensaje='El espesor no es válido';
         }
         
         if (!this.getComponent('cmbTerminaciones').isValid()){
           valido=false;
           mensaje='La terminación no es válida';
         }         
         
         if (Ext.isEmpty(Ext.get('matrizId').dom.value)){
           valido=false;
           mensaje='La matriz no es válida';
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











