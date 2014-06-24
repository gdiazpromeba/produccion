
function generaPanFormRemitosCab(){

	var panel=new PanelFormCabeceraAbm({
		id: 'panFormRemitosCabecera',
		prefijo: 'CabeceraRemitos',
	    region: 'center',
		nombreElementoId: 'remitoCabeceraId',
		labelWidth: 130,
	    urlAgregado: '/produccion/svc/conector/remitosCabecera.php/inserta',
	    urlModificacion: '/produccion/svc/conector/remitosCabecera.php/actualiza',
	    urlBorrado: '/produccion/svc/conector/remitosCabecera.php/borra',		
		items: [
          {xtype: 'hidden', name: 'remitoCabeceraId', id: 'remitoCabeceraId', itemId: 'remitoCabeceraId'},
          {xtype: 'comboclientes', id: 'clienteComboCabRem', itemId: 'clienteCombo', hiddenName: 'clienteIdCabRem', hiddenId: 'clienteIdCabRem'}, 
	        {fieldLabel: 'Fecha',   name: 'remitoFecha', id: 'remitoFecha',  itemId: 'remitoFecha', xtype : 'datefield', format: 'd/m/Y', allowBlank : false},
	        {fieldLabel: 'Número', name: 'remitoNumero', id: 'remitoNumero', itemId: 'remitoNumero',  allowBlank: true, xtype: 'numberfield', allowDecimals: false},
	        {fieldLabel: 'Estado', xtype: 'combo', id: 'comboEstados', name: 'comboEstados', itemId: 'comboEstados', ref: '../comboEstados', allowBlank: false, 
	          store: new Ext.data.SimpleStore({
	          fields: ['descripcionEstado'],
	    	     data: [["A despachar"],["Despachado"],["Anulado"]]
	    	    }),
            displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
            hiddenName: 'remitoEstado', triggerAction: 'all'
          },
          {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observaciones', itemId: 'observaciones',  width: 250, maxLength: 1000, height: 40, enableKeyEvents: true},          
          {fieldLabel: 'Impresión del remito', xtype: 'button', text: 'Imprimir', scope: this, 
                listeners: {
                  click: function(boton, evento){
                    var remitoCabeceraId = Ext.get('remitoCabeceraId').dom.value;
                    if (Ext.isEmpty(remitoCabeceraId)){
                      Ext.Msg.show({ title:'Impresión', msg: 'Debe haber un remito seleccionado', buttons: Ext.Msg.OK});
                      return;
                    }
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/remitosCabecera.php/selReporte',
                    method: 'POST',
                    params: { 
                       remitoCabeceraId: remitoCabeceraId
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
          {fieldLabel: 'Anulación del remito', xtype: 'button', text: 'Anular', scope: this, 
                listeners: {
                  click: function(boton, evento){
                    var remitoCabeceraId = Ext.get('remitoCabeceraId').getValue();
                    if (Ext.isEmpty(remitoCabeceraId)){
                      Ext.Msg.show({ title:'Anulación', msg: 'Debe haber un remito seleccionado', buttons: Ext.Msg.OK});
                      return;
                    }else if ( Ext.getCmp('comboEstados').getValue()=='Anulado'){
                      Ext.Msg.show({ title:'Anulación', msg: 'El remito ya está anulado, no puede ser anulado nuevamente', buttons: Ext.Msg.OK});
                      return;
                    }
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/remitosCabecera.php/anulaRemito',
                    method: 'POST',
                    params: { 
                       id: remitoCabeceraId
                    },
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Anulación', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        Ext.Msg.show({ title:'Anulación', msg: 'Remito anulado exitosamente', buttons: Ext.Msg.OK});
                        panel.fireEvent('datos del formulario cabecera cambiaron');
                    }
                        
                  });
                }
             }
          },
          {fieldLabel: 'Generación de factura', text: 'Generar', xtype: 'button',  itemId: 'botGenerar', ref: '../botGenerar', scope: this,  handler :  function(){
              var remitoCabeceraId=Ext.get('remitoCabeceraId').dom.value;
              var ventana=this;
              Ext.Ajax.request({
                url:  '/produccion/svc/conector/remitosCabecera.php/generaFactura',
                method: 'POST',
                params: { 
              	  remitoCabeceraId : remitoCabeceraId 
                },
                failure: function (response, options) {
                  Ext.Msg.show({ title:'Generación de factura', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                },
                success: function (response, options) {
                  var objRespuesta=Ext.util.JSON.decode(response.responseText);
                    if (objRespuesta.success){
                      Ext.Msg.show({ title:'Generación', msg: 'Factura generada exitosamente', buttons: Ext.Msg.OK});
                    }else{
                      Ext.Msg.show({ title:'Generación', msg: 'Error al duplicar: ' + objRespuesta.errors, buttons: Ext.Msg.OK});
                    }
                }
              });
            }
          },             
	   ],
	   
	   pueblaDatosEnForm : function(record){
	     this.getComponent('remitoCabeceraId').setValue(record.get('remitoCabeceraId'));                         
       this.getComponent('remitoFecha').setValue(record.get('remitoFecha'));
       this.getComponent('remitoNumero').setValue(record.get('remitoNumero'));
       this.getComponent('comboEstados').setValue(record.get('remitoEstado'));
       this.getComponent('clienteCombo').setValue(record.get('clienteNombre'));  
       this.getComponent('observaciones').setValue(record.get('observaciones'));
		   //combos con hiddenName aparte (esto extjs debería arreglarlo en algún momento)
		   Ext.get('clienteIdCabRem').dom.value=record.get('clienteId');
		   
	   },
	   
	   pueblaFormEnRegistro : function(record){
		   record.data['clienteNombre']= this.getComponent('clienteCombo').getRawValue();
	     record.data['remitoFecha']= this.getComponent('remitoFecha').getValue();
	     record.data['remitoEstado']= this.getComponent('comboEstados').getRawValue();
	     record.data['remitoNumero']= this.getComponent('remitoNumero').getValue();
       record.data['remitoCabeceraId']=  this.getComponent('remitoCabeceraId').getValue();
       record.data['observaciones']=  this.getComponent('observaciones').getValue();
       record.data['clienteId']=  Ext.get('clienteIdCabRem').dom.value;
		   record.commit();
	   },  	   
	   
	   validaHijo : function(muestraVentana){
		   var mensaje=null;
		   var valido=true;

		   var cliente=this.getComponent('clienteCombo');
		   if (!cliente.isValid()){
			   valido=false;
			   mensaje='El cliente no es válido';
		   }
		   
		   var fecha=this.getComponent('remitoFecha');
		   if (!fecha.isValid()){
			   valido=false;
			   mensaje='La fecha no es válida';
		   }
		   
		   var comboEstados=this.getComponent('comboEstados');
		   if (!comboEstados.isValid()){
			   valido=false;
			   mensaje='El estado no es válido';
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
	   },
	   
	   obtieneClienteId : function(){
		   return Ext.get('clienteIdCabRem').dom.value;
	   },
	   
	   onRender : function(){
	     PanelFormCabeceraAbm.superclass.onRender.apply(this, arguments);
	   }
	 
	
	
	});
	
	return panel;
}













