FormFacturasCab = Ext.extend(PanelFormCabeceraAbm, {
  
  constructor : function(config) {
	FormFacturasCab.superclass.constructor.call(this, Ext.apply({
  	  id: 'formFacturasCab',
      frame: true,
  	  prefijo: 'formFacturasCab',
      region: 'center',
  	  nombreElementoId: 'facturaCabId',
  	  urlAgregado: '/produccion/svc/conector/facturasCabecera.php/inserta',
  	  urlModificacion: '/produccion/svc/conector/facturasCabecera.php/actualiza',
  	  urlBorrado: '/produccion/svc/conector/facturasCabecera.php/borra',
  	  layout: 'column',
  		items: [
          {xtype: 'hidden', name: 'facturaCabId', itemId: 'facturaCabId', id: 'facturaCabId'},
          {xtype: 'hidden', name: 'facturaEstado', itemId: 'facturaEstado', id: 'facturaEstado'},
          {xtype: 'fieldset', itemId: 'columnaIzq', border: false, layout: 'form', columnWidth: 0.5, 
            items: [
              {fieldLabel: 'Fecha',  name: 'facturaFecha', id: 'facturaFecha', itemId: 'facturaFecha', xtype : 'fecha', allowBlank : false, muestraHoy: true},        
              {fieldLabel: 'Número',  name: 'facturaNumero', id: 'facturaNumero', itemId: 'facturaNumero', xtype : 'numberfield', allowDecimals : false},
              {xtype: 'comboclientes', id: 'clienteComboCabFac', itemId: 'clienteCombo', hiddenName: 'clienteIdCabFac', hiddenId: 'clienteIdCabFac', width: 220},
              {fieldLabel: 'Subtotal', xtype: 'dinero', name: 'subtotal', id: 'subtotal', itemId: 'subtotal', emptyText: '0.00', width: 80, readOnly: false},
	          {fieldLabel: 'Tipo', xtype: 'combo', id: 'comboTipos', name: 'comboTipos', itemId: 'comboTipos', width: 70, ref: '../comboTipos', allowBlank: false, 
	            store: new Ext.data.SimpleStore({
	              fields: ['facturaTipo'],
	    	        data: [["A"],["B"],["NC"],["ND"]]
	    	      }),
                  displayField: 'facturaTipo', valueField: 'facturaTipo', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
                  hiddenName: 'facturaTipo', triggerAction: 'all',
                    listeners:{select:{fn:function(combo, record, index) {
                    	/*
                    	var tipo=record.data['facturaTipo'];
                    	var subtotal=Ext.getCmp('subtotal');
                        var ivaInscripto=Ext.getCmp('ivaInscripto');
                    	if (tipo=='NC' || tipo=='B'){
 						  subtotal.setReadOnly(false);
						  ivaInscripto.setReadOnly(false);                      		
                    	}else if (tipo=='A'){
						  subtotal.setReadOnly(true);
						  ivaInscripto.setReadOnly(true);
                        }
                        */
                      }
                    }
                  }
              },              
              {fieldLabel: 'IVA', xtype: 'dinero', name: 'ivaInscripto', id: 'ivaInscripto', itemId: 'ivaInscripto', value: 0,  emptyText:'0.00', width: 80, readOnly: true },
              {fieldLabel: '% descuento', xtype: 'numberfield', name: 'descuento', id: 'descuento', itemId: 'descuento', emptyText: '0.00', width: 80, maxValue: 100, minValue: 0, value: 0},
              {fieldLabel: 'Total', xtype: 'fieldset', itemId: 'setTotal', layout: 'border', height: 25, width: 150,
                  border: false, style: 'padding-left:0;padding-top:0;padding-bottom:0',
                  items: [
                    {xtype: 'dinero', region: 'center', name: 'facturaTotal', id: 'facturaTotal', itemId: 'facturaTotal', width: 80, readOnly: true, value: 0, emptyText: '0.00'},
                    {xtype: 'button', text: 'Calcular', scope: this, region: 'east', width: 60, 
                      listeners: {
                        click: function(boton, evento){
            	   			var facturaCabId=Ext.get('facturaCabId').dom.value;
            	   			var descuento=Ext.getCmp('descuento').getValue();
            	   			var tipo=Ext.getCmp('comboTipos').getValue();
            	   			if (tipo!='NC' && tipo!='ND'){
                              Ext.Ajax.request({
                                url:  '/produccion/svc/conector/facturasCabecera.php/calculaTotal',
                                method: 'POST',
                                params: { 
                                  facturaCabeceraId: facturaCabId,
                                  descuento: descuento
                                },
                                failure: function (response, options) {
                                  Ext.Msg.show({ title:'Sugerencia de número', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                                },
                                success: function (response, options) {
                                  var objRespuesta=Ext.util.JSON.decode(response.responseText);
                                  var subtotal=Ext.getCmp('subtotal');
                                  subtotal.setValue(objRespuesta.subtotal);
                                  var facturaTotal=Ext.getCmp('facturaTotal');
                                  facturaTotal.setValue(objRespuesta.facturaTotal);
                                  var ivaInscripto=Ext.getCmp('ivaInscripto');
                                  ivaInscripto.setValue(objRespuesta.ivaInscripto);
                                  Ext.getCmp('formFacturasCab').fireEvent('recalculo');
                                }
                              }
                             );
            	   			}else{//"notaCredito" está chequeado
            	   			  var subtotal=Ext.getCmp('subtotal');
            	   			  var ivaInscripto=Ext.getCmp('ivaInscripto');
            	   			  var facturaTotal=Ext.getCmp('facturaTotal');
            	   			  Ext.getCmp('descuento').setValue(0);
            	   			  Ext.getCmp('facturaEstado').setValue('Válida');
            	   			  ivaInscripto.setValue(subtotal.getValue() * 0.21);
            	   			  facturaTotal.setValue(subtotal.getValue() * 1.21);
            	   			  
            	   			}
                          }//fn
                      }//listeners
                    }//botón sugerir
                  ]//items del set de número  
              }//fieldset del total
            ]//ítems del fieldset columnaIzq
          },// fieldset columnaIzq
          {xtype: 'fieldset', itemId: 'columnaDer', border: false, layout: 'form', columnWidth: 0.5, 
            items: [
              {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, name: 'observacionesCab', itemId: 'observacionesCab',  width: 220, maxLength: 500, height: 40, enableKeyEvents: true},
              {fieldLabel: 'Remito n°',  name: 'remitoNumero', id: 'remitoNumero', itemId: 'remitoNumero', xtype : 'numberfield', allowDecimals : false},
              {fieldLabel: 'Mostrar referencia', xtype: 'checkbox', name: 'mostrarReferencia', id: 'mostrarReferencia', itemId: 'mostrarReferencia', allowBlank: false, width: 50},
              {fieldLabel: 'Impresión de la factura', xtype: 'button', text: 'Imprimir', scope: this, 
                listeners: {
                  click: function(boton, evento){
                    var facturaCabId = Ext.get('facturaCabId').dom.value;
                    mostrarReferencia=Ext.getCmp('mostrarReferencia').getValue();
                    if (Ext.isEmpty(facturaCabId)){
                      Ext.Msg.show({ title:'Impresión', msg: 'Debe haber una factura seleccionada', buttons: Ext.Msg.OK});
                      return;
                    }
            	   	var tipo=Ext.getCmp('comboTipos').getValue();
            	    if (tipo=='A'){//factura tipo 'A'                    
                      Ext.Ajax.request({
                        url:  '/produccion/svc/conector/facturasCabecera.php/imprimeA',
                        method: 'POST',
                        params: { 
                         facturaCabId: facturaCabId,
                         mostrarReferencia: mostrarReferencia
                        },
                        failure: function (response, options) {
                          Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                        },
                        success: function (response, options) {
                          var html=response.responseText;
                          var win=window.open('', 'Factura A', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                          win.document.write(html);
                          win.document.close(); 
                          win.focus();
                          win.print();
                        }
                      });//request
            	    }else if (tipo=='B'){//factura tipo 'B'                    
                      Ext.Ajax.request({
                        url:  '/produccion/svc/conector/facturasCabecera.php/imprimeB',
                        method: 'POST',
                        params: { 
                         facturaCabId: facturaCabId,
                         mostrarReferencia: mostrarReferencia
                        },
                        failure: function (response, options) {
                          Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                        },
                        success: function (response, options) {
                          var html=response.responseText;
                          var win=window.open('', 'Factura B', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                          win.document.write(html);
                          win.document.close(); 
                          win.focus();
                          win.print();
                        }
                      });//request                      
                  }else if (tipo=='NC'){ // si es una nota de crédito
                      Ext.Ajax.request({
                        url:  '/produccion/svc/conector/facturasCabecera.php/imprimeNC',
                        method: 'POST',
                        params: { 
                         facturaCabId: facturaCabId
                        },
                        failure: function (response, options) {
                          Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                        },
                        success: function (response, options) {
                          var html=response.responseText;
                          var win=window.open('', 'Nota de crédito', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                          win.document.write(html);
                          win.document.close(); 
                          win.focus();
                          win.print();
                        }
                      });//request
                  }else if (tipo=='ND'){ // si es una nota de débito
                      Ext.Ajax.request({
                        url:  '/produccion/svc/conector/facturasCabecera.php/imprimeND',
                        method: 'POST',
                        params: { 
                         facturaCabId: facturaCabId
                        },
                        failure: function (response, options) {
                          Ext.Msg.show({ title:'Impresión', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                        },
                        success: function (response, options) {
                          var html=response.responseText;
                          var win=window.open('', 'Nota de débito', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                          win.document.write(html);
                          win.document.close(); 
                          win.focus();
                          win.print();
                        }
                      });//request
                  }
                }
             }
          },
          {fieldLabel: 'Anulación de la factura', xtype: 'button', text: 'Anular', scope: this, 
              listeners: {
                click: function(boton, evento){
                  var facturaCabId = Ext.get('facturaCabId').getValue();
                  if (Ext.isEmpty(facturaCabId)){
                    Ext.Msg.show({ title:'Anulación', msg: 'Debe haber una factura seleccionada', buttons: Ext.Msg.OK});
                    return;
                  }
                  Ext.Ajax.request({
                  url:  '/produccion/svc/conector/facturasCabecera.php/anulaFactura',
                  method: 'POST',
                  params: { 
                     id: facturaCabId
                  },
                  failure: function (response, options) {
                    Ext.Msg.show({ title:'Anulación', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                  },
                  success: function (response, options) {
                      Ext.Msg.show({ title:'Anulación', msg: 'Factura anulada exitosamente', buttons: Ext.Msg.OK});
                      //panel.fireEvent('datos del formulario cabecera cambiaron');
                  }
                      
                });
              }
            }
           }                     
          ]
        }
      ],    
      
  

  	  pueblaDatosEnForm : function(record){
         var colIzq=this.getComponent('columnaIzq');
         var colDer=this.getComponent('columnaDer');
         this.getComponent('facturaCabId').setValue(record.id);
         this.getComponent('facturaEstado').setValue(record.get('estado'));
         colIzq.getComponent('facturaFecha').setValue(record.get('facturaFecha'));
         colIzq.getComponent('facturaNumero').setValue(record.get('facturaNumero'));
         colIzq.getComponent('clienteCombo').setValue(record.get('clienteNombre'));
         colIzq.getComponent('subtotal').setValue(record.get('subtotal'));
         colIzq.getComponent('comboTipos').setValue(record.get('facturaTipo'));
         colIzq.getComponent('ivaInscripto').setValue(record.get('ivaInscripto'));
         colIzq.getComponent('descuento').setValue(record.get('descuento'));
         colIzq.getComponent('setTotal').getComponent('facturaTotal').setValue(record.get('facturaTotal'));
         colDer.getComponent('observacionesCab').setValue(record.get('observacionesCab'));
         colDer.getComponent('remitoNumero').setValue(record.get('remitoNumero'));
         Ext.get('clienteIdCabFac').dom.value=record.get('clienteId');
  	   },
  	   
  	   pueblaFormEnRegistro : function(record){
  		 var colIzq=this.getComponent('columnaIzq');
  		 var colDer=this.getComponent('columnaDer');
  		 record.data['facturaCabId']=  this.getComponent('facturaCabId').getValue();
  		 record.data['estado']= this.getComponent('facturaEstado').getValue();
  		 record.data['clienteNombre']=  colIzq.getComponent('clienteCombo').getRawValue();
  		 record.data['clienteId']=  Ext.get('clienteIdCabFac').dom.value;
         record.data['facturaFecha']=  colIzq.getComponent('facturaFecha').getValue();
         record.data['facturaNumero']=  colIzq.getComponent('facturaNumero').getValue();
         record.data['subtotal']=  colIzq.getComponent('subtotal').getValue();
         record.data['facturaTipo']=  colIzq.getComponent('comboTipos').getValue();
         record.data['ivaInscripto']=  colIzq.getComponent('ivaInscripto').getValue();
         record.data['descuento']=  colIzq.getComponent('descuento').getValue();
         record.data['facturaTotal']=  colIzq.getComponent('setTotal').getComponent('facturaTotal').getValue();
         record.data['observacionesCab']=  colDer.getComponent('observacionesCab').getValue();
         record.data['remitoNumero']=  colDer.getComponent('remitoNumero').getValue();
  		 record.commit();
  	   },  	   
  	   
  	   validaHijo : function(muestraVentana){
  	     var mensaje=null;
  	     var valido=true;
  	     var colIzq=this.getComponent('columnaIzq');
 
  	     if (!colIzq.getComponent('clienteCombo').isValid() || Ext.isEmpty(colIzq.getComponent('clienteCombo').getRawValue())){
  			   valido=false;
  			   mensaje='El cliente no es válido';
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











