function generaPanFormPedidosDet(){

	var panel=new PanelFormCabeceraAbm({
		id: 'panFormPedidosDetalle',
		prefijo: 'DetallePedidos',
		region: 'north',
    height: 180,
		nombreElementoId: 'pedidoDetalleId',
    urlAgregado: '/produccion/svc/conector/pedidosDetalle.php/inserta',
    urlModificacion: '/produccion/svc/conector/pedidosDetalle.php/actualiza',
    urlBorrado: '/produccion/svc/conector/pedidosDetalle.php/borra',
    layout: 'column',
    pedidoNumero: null,
		items: [
          {xtype: 'hidden', name: 'pedidoDetalleId', id: 'pedidoDetalleId', itemId: 'pedidoDetalleId'},
          {xtype: 'hidden', id: 'remitidos', name: 'remitidos', itemId: 'remitidos', allowBlank: false},
          {xtype: 'fieldset',
            itemId: 'columnaIzq',
        	  border: false,
            layout: 'form',
            columnWidth: 0.5,
            items: [
                {xtype: 'combopiezas', id: 'piezaComboPedDet', name: 'piezaComboPedDet' , itemId: 'piezaCombo', hiddenName: 'piezaIdPedDet', hiddenId: 'piezaIdPedDet', width: 350},
                {xtype: 'comboterminaciones', width: 250, id: 'terminacionComboPedDet', name: 'terminacionComboPedDet' , itemId: 'terminacionCombo', hiddenName: 'terminacionIdPedDet', hiddenId: 'terminacionIdPedDet'},
  		        {fieldLabel: 'Cantidad', xtype: 'numberfield', name: 'pedidoDetalleCantidad', id: 'pedidoDetalleCantidad', itemId: 'pedidoDetalleCantidad', allowBlank: false, width: 50},
  		        {fieldLabel: 'Precio', xtype: 'numberfield', allowBlank: true, id: 'pedidoDetallePrecio', name: 'pedidoDetallePrecio', itemId: 'pedidoDetallePrecio', width: 50}
  	        ]
          },
          {	xtype: 'fieldset',
            itemId: 'columnaDer',
        	  border: false,
        	  layout: 'form',
        	  columnWidth: 0.5,
        	  items:[
               {fieldLabel: 'Sin Patas',   name: 'sinPatas', id: 'sinPatas',  itemId: 'sinPatas', xtype : 'checkbox', allowBlank : true},
	           {fieldLabel: 'Observaciones', xtype: 'textarea', allowBlank: true, id: 'pedidoDetalleObservaciones', name: 'pedidoDetalleObservaciones', itemId: 'pedidoDetalleObservaciones',  width: 300, maxLength: 200, height: 45}

          ]
        }
	   ],


	   sugierePrecio : function(piezaId){
	     var clienteId=Ext.get('clienteIdCabPed').dom.value;
	     var precio=null;
		   var conn = new Ext.data.Connection();
		   conn.request({
		     url:  '/produccion/svc/conector/preciosEfectivosActuales.php/obtienePrecio',
		       method: 'POST',
		       params: {"piezaId": piezaId, "clienteId": clienteId},
		       success: function (response, options) {
		    	   var respuesta=Ext.util.JSON.decode(response.responseText);
		    	   var compPrecio=Ext.getCmp('pedidoDetallePrecio');
		    	   if (respuesta.exito==true){
		    		   compPrecio.setValue(respuesta.precio);
		    	   }else{
		    		   compPrecio.reset();
		    	   }
		       }
		   });

	   },


	   pueblaDatosEnForm : function(record){
         this.getComponent("pedidoDetalleId").setValue(record.get("pedidoDetalleId"));
         this.getComponent('remitidos').setValue(record.get('remitidos'));
         this.getComponent(this.prefijo + "valorIdPadre").setValue(record.get("pedidoCabeceraId"));

         var izq=this.getComponent('columnaIzq');
         izq.getComponent("pedidoDetallePrecio").setValue(record.get("pedidoDetallePrecio"));
	     izq.getComponent("pedidoDetalleCantidad").setValue(record.get("pedidoDetalleCantidad"));
         izq.getComponent("piezaCombo").setValue(record.get("piezaNombre"));

         izq.getComponent('terminacionCombo').setValue(record.get('terminacionNombre'));
		 Ext.get('terminacionIdPedDet').dom.value=record.get('terminacionId');

         var der=this.getComponent('columnaDer');
         der.getComponent("sinPatas").setValue(record.get("sinPatas"));
         der.getComponent("pedidoDetalleObservaciones").setValue(record.get("pedidoDetalleObservaciones"));




		 //ocultos (combo)
		 Ext.get('piezaIdPedDet').dom.value=record.get('piezaId');

	   },

	   pueblaFormEnRegistro : function(record){
         record.data['pedidoDetalleId']= this.getComponent("pedidoDetalleId").getValue();
         record.data['remitidos']=this.getComponent("remitidos").getValue();
         record.data['pedidoCabeceraId']=this.getComponent(this.prefijo + "valorIdPadre").getValue();

         var izq=this.getComponent('columnaIzq');
	     record.data['piezaNombre']= izq.getComponent('piezaCombo').getRawValue();
         record.data['pedidoDetalleCantidad']= izq.getComponent('pedidoDetalleCantidad').getValue();
         record.data['pedidoDetallePrecio']= izq.getComponent('pedidoDetallePrecio').getValue();

         var der=this.getComponent('columnaDer');
         record.data['sinPatas']=der.getComponent('sinPatas').getValue();
	     record.data['pedidoDetalleObservaciones']= der.getComponent('pedidoDetalleObservaciones').getValue();

		 record.data['terminacionNombre']= izq.getComponent('terminacionCombo').getRawValue();
         record.data['terminacionId']=  Ext.get('terminacionIdPedDet').dom.value;

         record.data['piezaId']= Ext.get('piezaIdPedDet').dom.value;
         record.commit();
	   },

	   validaHijo : function(muestraVentana){
		   var mensaje=null;
		   var valido=true;

       var der=this.getComponent('columnaDer');
       var izq=this.getComponent('columnaIzq');

			 if (!izq.getComponent('piezaCombo').isValid()){
			   valido=false;
			   mensaje='El artículo no es válido';
		   }

		   if (!izq.getComponent('pedidoDetalleCantidad').isValid()){
			   valido=false;
			   mensaje='La cantidad no es es válida';
		   }


			 if (!izq.getComponent('pedidoDetallePrecio').isValid()){
			   valido=false;
			   mensaje='El precio no es válido';
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
	   }



	});

	return panel;
}