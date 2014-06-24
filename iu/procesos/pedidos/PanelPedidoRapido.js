PanelPedidoRapido = Ext.extend(Ext.form.FormPanel, {
	constructor : function(config) {
	  PanelPedidoRapido.superclass.constructor.call(this, Ext.apply({
        bodyPadding: 5,
        frame: true,
        url: 'nada.php',
        defaultType: 'textfield',
        prefijo: null,
        items:[
          {fieldLabel: 'Cliente',  xtype: 'comboclientes', id: 'clienteComboPedRap', itemId: 'clienteComboPedRap', hiddenName: 'clienteIdPedRap', hiddenId: 'clienteIdPedRap'},
          {fieldLabel: 'Email',  xtype: 'textfield', id: 'emailPedRap', itemId: 'emailPedRap', width: 150},
          {fieldLabel: 'Teléfono',  xtype: 'textfield', id: 'telefonoPedRap', itemId: 'telefonoPedRap', width: 150},
          {fieldLabel: 'Artículo', xtype: 'combopiezas', id: 'comboPiezasPedRap', name: 'comboPiezasPedRap' , itemId: 'comboPiezasPedRap', hiddenName: 'piezaIdPedRap', hiddenId: 'piezaIdPedRap', width: 350},
		  {fieldLabel: 'Terminación',  xtype: 'comboterminaciones', width: 250, id: 'comboTerminacionesPedRap', name: 'comboTerminacionesPedRap' , itemId: 'comboTerminacionesPedRap', hiddenName: 'terminacionIdPedRap', hiddenId: 'terminacionIdPedRap'},
		  {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'cantidadPedRap', id: 'cantidadPedRap', itemId: 'cantidadPedRap', allowBlank: false, width: 50},
		  {fieldLabel: 'Precio Unitario',  xtype: 'dinero', name: 'precioUnitario', itemId: 'precioUnitario'},
		  {fieldLabel: 'Seña',  xtype: 'dinero', name: 'seña', itemId: 'seña'},
	      {fieldLabel: 'Tipo', xtype: 'combo', id: 'comboTiposPago', name: 'comboTiposPago', itemId: 'comboTiposPago', ref: '../comboTiposPago', allowBlank: false, 
	          store: new Ext.data.SimpleStore({
	          fields: ['descripcionTipoPago'],
	    	     data: [["Efectivo"],["Cheque"],["Transferencia o depósito"],["Mercado Libre"], ["Otro"]]
	    	    }),
               displayField: 'descripcionTipoPago', valueField: 'descripcionTipoPago', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
               hiddenName: 'tipoPago', triggerAction: 'all'
          },  
        ],
        buttons: [
           {text:'Ingresar', itemId: 'botingresar', ref: '../botIngresar',
                listeners:{'click':  function(){
                    this.ingreso(this);
           }, scope: this}}
       ],
       /*
       listeners : {
           activate:  function(){
			   var grid=Ext.getCmp('grillaSinLaqueador');
			   grid.getStore().load();
           }, scope: this
	   },
	   */

       /**
         averigua si lo que está ingresado en la caja de texto del combo es un valor de la lista de selección
         si no lo es, devuelve -1
       */
       indiceSeleccionado : function(combobox){
	     var v = combobox.getValue();
	     var record = combobox.findRecord(combobox.valueField || combobox.displayField, v);
         var index = combobox.store.indexOf(record);
         return index;
	   },

	   limpiaControles : function(me){
		   var arrControles=[
		     me.getComponent('clienteComboPedRap'),
		     me.getComponent('comboPiezasPedRap'),
		     me.getComponent('comboTerminacionesPedRap'),
		     me.getComponent('cantidadPedRap'),
		     me.getComponent('emailPedRap'),
		     me.getComponent('telefonoPedRap'),
		     me.getComponent('precioUnitario'),
		     me.getComponent('seña'),
		     me.getComponent('comboTiposPago')
		   ];
		   arrControles.forEach(function(control) {
		       control.reset();
		   });
	   },

       ingreso : function(panel){
		   var cmbClientes=Ext.getCmp('clienteComboPedRap');
		   var cmbPiezas=Ext.getCmp('comboPiezasPedRap');
		   var cmbTerminaciones=Ext.getCmp('comboTerminacionesPedRap');
		   var cantidad=Ext.getCmp('cantidadPedRap');
		   var precioUnitario=panel.getComponent('precioUnitario');
		   var seña=panel.getComponent('seña');
		   var cmbTiposPago=panel.getComponent('comboTiposPago');

		   //validaciones
	       if (!cmbPiezas.isValid()){
			 Ext.Msg.show({ title:'Pedido Rápido', msg: 'El artículo no es válido', buttons: Ext.Msg.OK});
			 return;
		   }else if (!cantidad.isValid() || cantidad.getValue()==0){
			 Ext.Msg.show({ title:'Pedido Rápido', msg: 'La cantidad no es válida', buttons: Ext.Msg.OK});
			 return;
		   }else if (!precioUnitario.isValid() || precioUnitario.getValue()==0){
			 Ext.Msg.show({ title:'Pedido Rápido', msg: 'El precio unitario no es válida', buttons: Ext.Msg.OK});
			 return;
		   }else if (!seña.isValid() || seña.getValue()==0){
		      Ext.Msg.show({ title:'Pedido Rápido', msg: 'La seña no es válida', buttons: Ext.Msg.OK});
			  return;
		   }else if (!cmbTiposPago.isValid()){
		      Ext.Msg.show({ title:'Pedido Rápido', msg: 'El tipo de pago no es válido', buttons: Ext.Msg.OK});
			  return;
		   }


		   var clienteId;
		   var clienteNombre;
		   var piezaId=Ext.get('piezaIdPedRap').dom.value;
		   var terminacionId;
		   var terminacionNombre;
		   var email = Ext.getCmp('emailPedRap').getValue();
		   var telefono = Ext.getCmp('telefonoPedRap').getValue();

           if (this.indiceSeleccionado(cmbClientes)>-1){
			   clienteId=Ext.get('clienteIdPedRap').dom.value;
		   }else{
			   clienteNombre=cmbClientes.getRawValue();
		   }
           if (this.indiceSeleccionado(cmbTerminaciones)>-1){
			   terminacionId=Ext.get('terminacionIdPedRap').dom.value;
		   }else{
			   terminacionNombre=cmbTerminaciones.getRawValue();
		   }



	     Ext.Ajax.request({
		   url: '/produccion/svc/conector/pedidosCabecera.php/pedidoRapido',
		   params: {
			   clienteId : clienteId,
			   clienteNombre : clienteNombre,
			   piezaId : piezaId,
			   terminacionId : terminacionId,
			   terminacionNombre : terminacionNombre,
			   cantidad: cantidad.getValue(),
			   email: email,
			   telefono: telefono,
			   precioUnitario: precioUnitario.value,
			   seña: seña.value,
			   tipoPago: tipoPago.value
		   },
		   success: function(response, options) {
			  var objRespuesta={};
			  try{
			    objRespuesta=Ext.util.JSON.decode(response.responseText);	  
			  }catch(err){
				objRespuesta.success=false;
				objRespuesta.error=response.responseText;
			  }
			  if (objRespuesta.success){
                 Ext.Msg.show({ title:'Ingreso de pedido', msg: 'Pedido rápido ingresado exitosamente', buttons: Ext.Msg.OK});
				 panel.limpiaControles(panel);
			  }else{
				Ext.Msg.show({ title:'Ingreso de pedido', msg: objRespuesta.error, buttons: Ext.Msg.OK});
			  }
		   },
		   failure: function(response, options) {
			   Ext.Msg.show({ title:'Ingreso de pedido', msg: 'Error de red o base de datos' + response.responseText, buttons: Ext.Msg.OK});
		   },
         });
       }

     }, config));

  }// del constructor


});


