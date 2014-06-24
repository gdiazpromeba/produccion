FormPagos = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormPagos.superclass.constructor.call(this, Ext.apply({
      frame: true,
  	  prefijo: 'formPagos',
      region: 'center',
      height: 400,
  	  nombreElementoId: 'pagoId',
  	  urlAgregado: '/produccion/svc/conector/pagos.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/pagos.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/pagos.php/borra',
      items: [
        {xtype: 'hidden', name: 'pagoId', itemId: 'pagoId'},
        {fieldLabel: 'Monto',  xtype: 'dinero', name: 'monto', itemId: 'monto'},
        {fieldLabel: 'Fecha',  xtype: 'fecha', name: 'fecha', itemId: 'fecha', allowBlank: false},
        {fieldLabel: 'Tipo', xtype: 'combo', id: 'comboTiposPago', name: 'comboTiposPago', itemId: 'comboTiposPago', ref: '../comboTiposPago', allowBlank: false, 
	          store: new Ext.data.SimpleStore({
	          fields: ['descripcionTipoPago'],
	    	     data: [["Efectivo"],["Cheque"],["Transferencia o depósito"],["Mercado Libre"], ["Otro"]]
	    	    }),
          displayField: 'descripcionTipoPago', valueField: 'descripcionTipoPago', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
          hiddenName: 'tipoPago', triggerAction: 'all'
        },        
        {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observaciones', itemId: 'observaciones',  width: 220, maxLength: 500, height: 40, enableKeyEvents: true},
        
        
      ],      
      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('pagoId').setValue(record.get('pagoId'));
         this.getComponent(this.prefijo + "valorIdPadre").setValue(record.get("pedidoCabeceraId"));
         this.getComponent('fecha').setValue(record.get('fecha'));
         this.getComponent('monto').setValue(record.get('monto'));
         this.getComponent('comboTiposPago').setValue(record.get('tipo'));
         this.getComponent('observaciones').setValue(record.get('observaciones'));
         
        
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 record.data['pagoId'] =  this.getComponent('pagoId').getValue();
  		 record.data['pedidoCabeceraId']= this.getComponent(this.prefijo + 'valorIdPadre').getValue();
         record.data['fecha']= this.getComponent('fecha').getValue();
         record.data['monto']= this.getComponent('monto').getValue();
         record.data['tipo']= this.getComponent('comboTiposPago').getValue();
         record.data['observaciones']= this.getComponent('observaciones').getValue();
         
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
  		   
  		   var monto=this.getComponent('monto').getValue();
  		   var tipo=this.getComponent('comboTiposPago').getValue();
  		   
 		   
  		   if (Ext.isEmpty(monto)){
  		     valido=false;
  			 mensaje='Hay que indicar el monto';
  		   }
  		   
  		   if (Ext.isEmpty(tipo)){
    		     valido=false;
    			 mensaje='Hay que indicar el tipo de pago';
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

Ext.reg('formpagos', FormPagos);












