
function generaPanFormPedidosCab(){

	var panel=new PanelFormCabeceraAbm({
		id: 'panFormPedidosCabecera',
		prefijo: 'CabeceraPedidos',
		height: 170,
    	region: 'center',
		nombreElementoId: 'pedidoCabeceraId',
		labelWidth: 130,
	    urlAgregado: '/produccion/svc/conector/pedidosCabecera.php/inserta',
	    urlModificacion: '/produccion/svc/conector/pedidosCabecera.php/actualiza',
	    urlBorrado: '/produccion/svc/conector/pedidosCabecera.php/inhabilita',
		items: [
      {xtype: 'hidden', name: 'pedidoCabeceraId', id: 'pedidoCabeceraId', itemId: 'pedidoCabeceraId'},
      {fieldLabel: 'N° pedido', xtype: 'label', name: 'pedidoNumero', itemId: 'pedidoNumero', ref: '../pedidoNumero', style: 'text-align:right', allowDecimals: false,  region: 'center', allowBlank: false, enabled: false},
      {xtype: 'comboclientes', id: 'clienteComboCabPed', itemId: 'clienteCombo', hiddenName: 'clienteIdCabPed', hiddenId: 'clienteIdCabPed'},
	  {fieldLabel: 'Fecha',   name: 'pedidoFecha', id: 'pedidoFecha', itemId: 'pedidoFecha', xtype : 'fecha', allowBlank : false, muestraHoy: true,
	    listeners: {
			scope: this,
			'change': function(){
				var controlFecha=Ext.getCmp('pedidoFecha');
				var controlPrometida=Ext.getCmp('fechaPrometidaPC');
				if (controlFecha.isValid()){
					var valorFecha=controlFecha.getValue();
					var obj=new Date(valorFecha);
					var valorPrometida=obj.add(Date.DAY, 15);
					controlPrometida.setValue(valorPrometida);
			    }else{
				  controlPrometida.setValue('');
				}
			}
		}
	  },
	  {fieldLabel: 'Referencia/contacto', name: 'pedidoReferencia', itemId: 'pedidoReferencia',  id: 'pedidoReferencia', allowBlank: true},
	  {fieldLabel: 'Fecha prometida',   name: 'fechaPrometidaPC', id: 'fechaPrometidaPC',  itemId: 'fechaPrometidaPC', xtype : 'fecha', allowBlank : false},
	  {fieldLabel: 'Estado', xtype: 'combo', id: 'comboEstados', name: 'comboEstados', itemId: 'comboEstados', allowBlank: false,
            store: new Ext.data.SimpleStore({
	 	      fields: ['descripcionEstado'],
		      data: [["Pendiente"],["Completo"],["Cancelado"]]
		      }),
	          displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
              hiddenName: 'pedidoEstado', triggerAction: 'all'},
       {fieldLabel: 'Impresión pedido', xtype: 'button', text: 'Imprimir', scope: this,
                listeners: {
                  click: function(boton, evento){
                    var pedidoCabeceraId = panel.getComponent('pedidoCabeceraId').getValue();
                    if (Ext.isEmpty(pedidoCabeceraId)){
                      Ext.Msg.show({ title:'Impresión de pedido', msg: 'Debe haber un pedido seleccionado', buttons: Ext.Msg.OK});
                      return;
                    }
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/pedidosDetalle.php/selReportePedido',
                    method: 'POST',
                    params: {
                       pedidoCabeceraId: pedidoCabeceraId
                    },
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Impresión de pedido', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        var html=response.responseText;
                        var win=window.open('', 'Pedido', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
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
	     this.getComponent('pedidoCabeceraId').setValue(record.id);
         this.getComponent('pedidoNumero').setText(record.get('pedidoNumero'));
         this.getComponent('pedidoReferencia').setValue(record.get('pedidoReferencia'));
         this.getComponent('comboEstados').setValue(record.get('pedidoEstado'));
         this.getComponent('pedidoFecha').setValue(record.get('pedidoFecha'));
         this.getComponent("fechaPrometidaPC").setValue(record.get("fechaPrometida"));
         this.getComponent('clienteCombo').setValue(record.get('clienteNombre'));
		 //combos con hiddenName aparte (esto extjs debería arreglarlo en algún momento)
		 Ext.get('clienteIdCabPed').dom.value=record.get('clienteId');
	   },

	   pueblaFormEnRegistro : function(record){
		 record.data['pedidoCabeceraId']=  this.getComponent('pedidoCabeceraId').getValue();
		 record.data['clienteNombre']= this.getComponent('clienteCombo').getRawValue();
	     record.data['pedidoFecha']= this.getComponent('pedidoFecha').getValue();
	     record.data['fechaPrometida']= this.getComponent('fechaPrometidaPC').getValue();
	     record.data['pedidoEstado']= this.getComponent('comboEstados').getRawValue();
	     record.data['pedidoReferencia']= this.getComponent('pedidoReferencia').getValue();
         record.data['clienteId']=  Ext.get('clienteIdCabPed').dom.value;
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

		   var fecha=this.getComponent('pedidoFecha');
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


	   onRender : function(){
	     PanelFormCabeceraAbm.superclass.onRender.apply(this, arguments);
	   },


     /**
       Overload para agregarla un parámetro más al éxito agregado: el pedidoNumero, que es autogenerado
     */
     agregado: function(){
		 console.log('hola');
	     var panForm=this;
	     panForm.getForm().submit({
        url : this.urlAgregado,
        waitMsg : 'Grabando datos...',
        failure: function (form, options) {
        	panForm.tratamientoFailure(panForm, form, options, 'agregado');
        },
        success: function (form, options) {
	    	var objRespuesta=Ext.util.JSON.decode(options.response.responseText);
	    	if (objRespuesta.success==true){
				panForm.fireEvent('trasExitoAgregado', objRespuesta.nuevoId, objRespuesta.numero);
				panForm.habilitaCampos(false);
				panForm.agregando=false;
				panForm.modificando=false;
				panForm.inicioBotones();
				panForm.fireEvent('cambio en agregando/modificando', this.agregando, this.modificando);
	    	}
        }
       });
     }


	});

	return panel;
}













