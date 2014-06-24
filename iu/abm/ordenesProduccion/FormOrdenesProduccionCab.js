FormOrdenesProduccionCab = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
    FormOrdenesProduccionCab.superclass.constructor.call(this, Ext.apply({
  		id: 'formOrdenesProduccionCab',
      frame: true,
  		prefijo: 'formOrdenesProduccionCab',
      region: 'center',
  		nombreElementoId: 'ordProdCabId',
  	  urlAgregado: '/produccion/svc/conector/ordenProdCabecera.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/ordenProdCabecera.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/ordenProdCabecera.php/borra',
  		items: [
        {xtype: 'hidden', name: 'ordProdCabId', itemId: 'ordProdCabId', id: 'ordProdCabId'},
        {fieldLabel: 'Número', xtype: 'numberfield', name: 'ordenNumero', itemId: 'ordenNumero', ref: '../ordenNumero', style: 'text-align:right', allowDecimals: false,  region: 'center', allowBlank: false},        
        {fieldLabel: 'Estado', xtype: 'combo', id: 'comboEstados', name: 'comboEstados', itemId: 'comboEstados', allowBlank: false, 
            store: new Ext.data.SimpleStore({
          fields: ['descripcionEstado'],
          data: [["Emitida"],["En proceso"],["Completada"],["Escribiéndose"],["Incompleta"]]
          }),
            displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
              hiddenName: 'ordenEstado', triggerAction: 'all'}, 
        {fieldLabel: 'Fecha',   name: 'ordenFecha', id: 'ordenFecha', itemId: 'ordenFecha', xtype : 'fecha', allowBlank : false, muestraHoy: true},
        {fieldLabel: 'Impresión O.P.', xtype: 'button', text: 'Imprimir', scope: this, 
                listeners: {
                  click: function(boton, evento){
                    var ordProdCabId = Ext.get('ordProdCabId').dom.value;
                    if (Ext.isEmpty(ordProdCabId)){
                      Ext.Msg.show({ title:'Impresión', msg: 'Debe haber una orden seleccionada', buttons: Ext.Msg.OK});
                      return;
                    }
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/ordenProdCabecera.php/selReporte',
                    method: 'POST',
                    params: { 
                       ordProdCabId: ordProdCabId
                    },
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        var html=response.responseText;
                        var win=window.open('', 'O.P.', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                        win.document.write(html);
                        win.document.close(); 
                        win.focus();
                        win.print();
                    }
                  });
                }
             }
        },
        {fieldLabel: 'Enchapados', xtype: 'button', text:'Calcular', itemId: 'botImprimirEnchapados', ref: 'botImprimirEnchapados', scope: this, 
                listeners: {
                  click: function(boton, evento){
                    var ordProdCabId = Ext.get('ordProdCabId').dom.value;
                    if (Ext.isEmpty(ordProdCabId)){
                      Ext.Msg.show({ title:'Impresión', msg: 'Debe haber una orden seleccionada', buttons: Ext.Msg.OK});
                      return;
                    }                    
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/ordenProdDetalle.php/reporteTerminacionesPorOPHTML',
                    method: 'POST',
                    params: {
                      ordProdCabId: ordProdCabId
                    },
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Terminaciones pendientes', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        var html=response.responseText;
                        var win=window.open('', 'Terminaciones pendientes', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                        win.document.write(html);
                        win.document.close(); 
                        win.focus();
                        win.print();
                    }
                  });
                }
             }
        }        
      ],      
  	   
  	  pueblaDatosEnForm : function(record){
         this.getComponent('ordProdCabId').setValue(record.id);
         this.getComponent('ordenNumero').setValue(record.get('ordenNumero'));
         this.getComponent('comboEstados').setValue(record.get('ordenEstado'));
         this.getComponent('ordenFecha').setValue(record.get('ordenFecha'));
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		   record.data['ordProdCabId']=  this.getComponent('ordProdCabId').getValue();
         record.data['ordenNumero']=  this.getComponent('ordenNumero').getValue();
         record.data['ordenEstado']=  this.getComponent('comboEstados').getValue();
         record.data['ordenFecha']=  this.getComponent('ordenFecha').getValue();
  		   record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  		   var mensaje=null;
  		   var valido=true;
 
  			 if (!this.getComponent('ordenNumero').isValid()){
  			   valido=false;
  			   mensaje='El número de orden no es válido';
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











