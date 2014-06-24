FormPlanProdPulidoDet = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormPlanProdPulidoDet.superclass.constructor.call(this, Ext.apply({
  		id: 'formPlanProdPulidoDet',
      frame: true,
      header: true,
  		prefijo: 'formPlanProdPulidoDet',
  		nombreElementoId: 'planProdPulidoDetId',
  	  urlAgregado: '/produccion/svc/conector/planProdPulidoDetalle.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/planProdPulidoDetalle.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/planProdPulidoDetalle.php/borra',
      layout: 'column',
      items:[
        {xtype: 'hidden', name: 'planProdPulidoDetId', id: 'planProdPulidoDetId', itemId: 'planProdPulidoDetId'},
        {xtype: 'fieldset',
          itemId: 'columnaIzq',
      	  border: false,
          layout: 'form',
          columnWidth: 0.5,
          items: [
            {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'cantidadOPD', id: 'cantidadPPD', itemId: 'cantidadPPD', allowBlank: false, width: 50},
            {xtype: 'combofichas', name: 'comboFichas' , itemId: 'comboFichas', hiddenName: 'piezaFicha', hiddenId: 'piezaFicha', allowBlank: false, width: 150},
            {xtype: 'comboenchapados', itemId: 'cmbTerminaciones', name: 'cmbTerminaciones', allowBlank: false, width: 220, hiddenName: 'terminacion', hiddenId: 'terminacion'},
            {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observacionesDet', itemId: 'observacionesDet',  width: 250, maxLength: 500, height: 40, enableKeyEvents: true}
          ]
        },
        {xtype: 'fieldset',
           itemId: 'columnaDer',
           border: false,
           layout: 'form',
           columnWidth: 0.5,
           items: [
             {fieldLabel: 'Reparadas', xtype: 'checkbox', name: 'reparadas', id: 'reparadas', itemId: 'reparadas', allowBlank: false, width: 50},
             {fieldLabel: 'Pulido', xtype: 'checkbox', name: 'pulido', id: 'pulido', itemId: 'pulido', allowBlank: false, width: 50},
             {fieldLabel: 'Tupí', xtype: 'checkbox', name: 'tupi', id: 'tupi', itemId: 'tupi', allowBlank: false, width: 50},
             {fieldLabel: 'Lijado de cantos', xtype: 'checkbox', name: 'lijadoCantos', id: 'lijadoCantos', itemId: 'lijadoCantos', allowBlank: false, width: 50},
             {fieldLabel: 'Descartadas', xtype: 'checkbox', name: 'descartadas', id: 'descartadas', itemId: 'descartadas', allowBlank: false, width: 50},
             {fieldLabel: 'A Tapizar', xtype: 'checkbox', name: 'aTapizar', id: 'aTapizar', itemId: 'aTapizar', allowBlank: false, width: 50},
             {fieldLabel: 'A Mini', xtype: 'checkbox', name: 'aMini', id: 'aMini', itemId: 'aMini', allowBlank: false, width: 50}
          ]
        }
      ],
  	   
  	  pueblaDatosEnForm : function(record){
        this.getComponent('planProdPulidoDetId').setValue(record.id);
        this.getComponent("valorIdPadre").setValue(record.get('planProdPulidoCabId'));
        
        var izq=this.getComponent('columnaIzq');
        izq.getComponent('comboFichas').setValue(record.get('piezaFicha'));
        izq.getComponent('cantidadPPD').setValue(record.get('cantidad'));
        izq.getComponent('observacionesDet').setValue(record.get('observacionesDet'));
        izq.getComponent('cmbTerminaciones').setValue(record.get('terminacion'));
        
        var der=this.getComponent('columnaDer');
        der.getComponent('reparadas').setValue(record.get('reparada'));
        der.getComponent('pulido').setValue(record.get('pulido'));
        der.getComponent('tupi').setValue(record.get('tupi'));
        der.getComponent('lijadoCantos').setValue(record.get('lijadoCantos'));
        der.getComponent('descartadas').setValue(record.get('descartada'));
        der.getComponent('aTapizar').setValue(record.get('aTapizar'));
        der.getComponent('aMini').setValue(record.get('aMini'));
  	  },
  	   
  	  pueblaFormEnRegistro : function(record){
  	    record.data['planProdPulidoDetId']=  this.getComponent('planProdPulidoDetId').getValue();
  		record.data['planProdPulidoCabId']=this.getComponent("valorIdPadre").getValue();
  		
  		var izq=this.getComponent('columnaIzq');
        record.data['piezaFicha']=  izq.getComponent('comboFichas').getRawValue();
        record.data['cantidad']=  izq.getComponent('cantidadPPD').getValue();
        record.data['terminacion']=  Ext.get('terminacion').dom.value;
        record.data['observacionesDet']=  izq.getComponent('observacionesDet').getValue();
  		
  		var der=this.getComponent('columnaDer');
        record.data['reparada']=  der.getComponent('reparadas').getValue();
        record.data['pulido']=  der.getComponent('pulido').getValue();
        record.data['tupi']=  der.getComponent('tupi').getValue();
        record.data['lijadoCantos']=  der.getComponent('lijadoCantos').getValue();
        record.data['descartada']=  der.getComponent('descartadas').getValue();
        record.data['aTapizar']=  der.getComponent('aTapizar').getValue();
        record.data['aMini']=  der.getComponent('aMini').getValue();
         
  		record.commit();
  	  },  	   
  	   
  	  validaHijo : function(muestraVentana){
  		var izq=this.getComponent('columnaIzq');
  		var der=this.getComponent('columnaDer');
  	    var mensaje=null;
  		var valido=true;
 
		if (!izq.getComponent('cantidadPPD').isValid()){
		  valido=false;
		  mensaje='La cantidad no es válida';
	     }
         
         if (!izq.getComponent('cmbTerminaciones').isValid()){
           valido=false;
           mensaje='La terminación no es válida';
         }         
         
         if (!izq.getComponent('comboFichas').isValid()){
           valido=false;
           mensaje='La ficha no es válida';
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











