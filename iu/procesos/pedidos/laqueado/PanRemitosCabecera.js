PanRemitosCabecera = Ext.extend(Ext.Panel, {
  constructor : function(config) {
	PanRemitosCabecera.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        layout:'border',
        padding: 10,
        items: [
          {xtype: 'grillaremlaqcab', itemId: 'grillaRemLaqCab', id: 'grillaRemLaqCab', region: 'center'},
          {xtype: 'panel', itemId: 'busquedaRemLaq', id: 'busquedaRemLaq',  width: 500, region: 'east', layout: 'form',
            items:[
              {xtype: 'button', text: 'Enviar a laqueador', width: 150, id: 'botEnvioLaqueador',
                          listeners: {
			                scope: this,
			                'click' : function(){
							  var grid=Ext.getCmp('grillaRemLaqCab');
							  if (grid.getSelectionModel().hasSelection()) {
								   var row = grid.getSelectionModel().getSelected();
								   //valido si está 'En Taller'
								   var estado=row.data['estado'];
								   if (estado!='En Taller'){
									   Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Sólo los conjuntos marcados como En Taller pueden enviarse al laqueador', buttons: Ext.Msg.OK});
									   return
								   }

                                   var idRemito=row.get('id');
								   Ext.Ajax.request({
									   url:  '/produccion/svc/conector/remitosLaqueado.php/remite',
										method: 'POST',
										params: {
										  remLaqCabId : idRemito
										} ,
										failure: function (response, options) {
										  Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
										},
										success: function (response, options) {
										  var objRespuesta=Ext.util.JSON.decode(response.responseText);
										  if (objRespuesta.success){
											grid.getStore().load();
										  }else{
											Ext.Msg.show({ title:'Remitos de laqueado', msg: objRespuesta.error, buttons: Ext.Msg.OK});
										  }
										}
								   });
							  }else{
								   Ext.Msg.show({ title:'Remitos de laqueado', msg: '¡Nada seleccionado!', buttons: Ext.Msg.OK});
								   return;
							  }
						    }// la función
					     }//los listeners
		      },//el botón
              {xtype: 'button', text: 'Borrar', width: 150, id: 'botBorradoRemLaqCab',
                          listeners: {
			                scope: this,
			                'click' : function(){
							  var grid=Ext.getCmp('grillaRemLaqCab');
							  if (grid.getSelectionModel().hasSelection()) {
								   var row = grid.getSelectionModel().getSelected();
                                   var idRemito=row.get('id');
								   Ext.Ajax.request({
									   url:  '/produccion/svc/conector/remitosLaqueado.php/borraRemCab',
										method: 'POST',
										params: {
										  remLaqCabId : idRemito
										} ,
										failure: function (response, options) {
										  Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
										},
										success: function (response, options) {
										  var objRespuesta=Ext.util.JSON.decode(response.responseText);
										  if (objRespuesta.success){
											grid.getStore().load();
										  }else{
											Ext.Msg.show({ title:'Remitos de laqueado', msg: objRespuesta.errors, buttons: Ext.Msg.OK});
										  }
										}
								   });
							  }else{
								   Ext.Msg.show({ title:'Remitos de laqueado', msg: '¡Nada seleccionado!', buttons: Ext.Msg.OK});
								   return;
							  }
						    }// la función
					     }//los listeners
		      },//el botón

			  {xtype: 'button', text: 'Imprimir remito', width: 150, id: 'botImpresionRemLaq',
						listeners: {
						scope: this,
						'click' : function(){
						  var grid=Ext.getCmp('grillaRemLaqCab');
						  if (grid.getSelectionModel().hasSelection()) {
							   var row = grid.getSelectionModel().getSelected();
								 var idRemito=row.get('id');
							   Ext.Ajax.request({
								   url:  '/produccion/svc/conector/remitosLaqueado.php/imprimeRemLaq',
									method: 'POST',
									params: {
									  remLaqCabId : idRemito
									} ,
									failure: function (response, options) {
									  Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
									},
									success: function (response, options) {
										var html=response.responseText;
										var win=window.open('', 'Remito de Laqueado', "dependent=true, height = 400, width = 800, resizable = yes, menubar=yes");
										win.document.write(html);
										win.document.close();
										win.focus();
										win.print();
									}
							   });
						  }else{
							   Ext.Msg.show({ title:'Remitos de laqueado', msg: '¡Nada seleccionado!', buttons: Ext.Msg.OK});
							   return;
						  }
						}// la función
					 }//los listeners
		        },//el botón

			  {xtype: 'button', text: 'Marcar como completado', width: 150, id: 'botMarcaRemLaqCompleto',
						listeners: {
						scope: this,
						'click' : function(){
						  var grid=Ext.getCmp('grillaRemLaqCab');
						  if (grid.getSelectionModel().hasSelection()) {
							   var row = grid.getSelectionModel().getSelected();
							   //valido si está 'En Taller'
							   var estado=row.data['estado'];
							   if (estado!='En Laqueador'){
								   Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Sólo los conjuntos marcados como En Laqueador pueden completarse', buttons: Ext.Msg.OK});
								   return
							   }
							   var idRemito=row.get('id');

							   Ext.Ajax.request({
								   url:  '/produccion/svc/conector/remitosLaqueado.php/completa',
									method: 'POST',
									params: {
									  remLaqCabId : idRemito
									} ,
									failure: function (response, options) {
									  Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
									},
									success: function (response, options) {
									  var objRespuesta=Ext.util.JSON.decode(response.responseText);
									  if (objRespuesta.success){
										grid.getStore().load();
									  }else{
										Ext.Msg.show({ title:'Remitos de laqueado', msg: objRespuesta.errors, buttons: Ext.Msg.OK});
									  }
									}
							   });
						  }else{
							   Ext.Msg.show({ title:'Remitos de laqueado', msg: '¡Nada seleccionado!', buttons: Ext.Msg.OK});
							   return;
						  }
						}// la función
					 }//los listeners
		        },//el botón

            ]
          },
        ]
	  }, config));
	} //constructor
});