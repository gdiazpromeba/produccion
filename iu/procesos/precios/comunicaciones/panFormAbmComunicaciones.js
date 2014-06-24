
function getPanFormAbmComunicaciones(){
	
  var panel=new PanelFormCabeceraAbm({
	title: 'Comunicaciones de precios',
	prefijo: 'ComunicacionesDePrecios',
	height: 450,
	region: 'center',
	nombreElementoId: 'comPrecCabId',
  labelWidth:200,
	id: 'cabComPrecios',
    urlAgregado: '/produccion/svc/conector/comunicacionesPreciosCabecera.php/inserta',
    urlModificacion: '/produccion/svc/conector/comunicacionesPreciosCabecera.php/actualiza',
    urlBorrado: '/produccion/svc/conector/comunicacionesPreciosCabecera.php/borra',	
	items: [
    {xtype: 'hidden', id: 'comPrecCabId', itemId : 'comPrecCabId', name: 'comPrecCabId'},
    {fieldLabel: 'Fecha',   name: 'fecha', id: 'fecha',  itemId: 'fecha',  xtype : 'datefield', format: 'd/m/Y', allowBlank : false},
    {xtype: 'comboclientes', id: 'clienteCabCom', itemId: 'clienteCombo', hiddenName: 'clienteIdCabCom', hiddenId: 'clienteIdCabCom'},
    {fieldLabel: 'Destinatario', xtype: 'textfield', name: 'destinatario', id: 'destinatario', itemId: 'destinatario', allowBlank: true},
    {fieldLabel: 'Autorizada por', id: 'autorizadorCombo', itemId: 'autorizadorCombo', allowBlank: true, width: 220, xtype: 'combo',
       hiddenName: 'autorizadorId', hiddenId: 'autorizadorId', loadingText: recursosInter.buscando,
       typeAhead: false, forceSelecion: true, editable: false, typeAhead: true, mode: 'remote', store: dsUsuariosHabilitadores, 
       displayField: 'usuarioNombreCompleto', valueField: 'usuarioId',
       minListWidth: 150, pageSize:15, hideTrigger: false,  triggerAction: 'all',
       tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{usuarioNombreCompleto}</h4>", '</div></tpl>'),
       minChars: 1, itemSelector: 'div.search-item'
     },   
     {fieldLabel: 'Método envío', name:'metodoEnvio', itemId: 'metodoEnvio',  allowBlank: false, xtype: 'textarea', allowBlank : false, maxLength: 500, width: 250},
     {fieldLabel: 'Duplicar comunicación', itemId: 'duplicar', xtype: 'button', text: 'Duplicar', scope: this,  listeners:{ click: function(boton, evento){
           var id=panel.getComponent('comPrecCabId').getValue();
           if (Ext.isEmpty(id)){
             Ext.Msg.show({ title:'Duplicar', msg: 'Primero debe seleccionar qué comunicación desea duplicar.', buttons: Ext.Msg.OK});
             return;
           }
           var vent=new VentanaVariacion();
           vent.setcabComPrecId(id);
           vent.setFechaNueva(panel.getComponent('fecha').getValue());
           vent.show();
           vent.on('hide', 
             function(){
              panel.fireEvent('datos del formulario cabecera cambiaron'); //esto es para que pueble la cabecera y el detalle sin tener que refrescar la grilla
              vent.destroy();  
             }
           );           
        }
     }},
     {fieldLabel: 'Impresión de la cotización', xtype: 'button', text: 'Imprimir', scope: this, 
        listeners: {
          click: function(boton, evento){
            var comPrecCabId = panel.getComponent('comPrecCabId').getValue();
            if (Ext.isEmpty(comPrecCabId)){
              Ext.Msg.show({ title:'Impresión de cotización', msg: 'Debe haber un registro seleccionado', buttons: Ext.Msg.OK});
              return;
            }
            Ext.Ajax.request({
            url:  '/produccion/svc/conector/comunicacionesPreciosDetalle.php/selReporteComunicacion',
            method: 'POST',
            params: { 
               comPrecCabId: comPrecCabId
            },
            failure: function (response, options) {
              Ext.Msg.show({ title:'Impresión de cotización', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
            },
            success: function (response, options) {
                var html=response.responseText;
                var win=window.open('', 'Cotización', "dependent=true, height = 800, width = 800, resizable = yes, menubar=yes");
                win.document.write(html);
                win.document.close(); 
                win.focus();
                win.print();
            }
          });
        }
     }
    },
    {fieldLabel: 'Completar desde pedidos', itemId: 'llenarDesdePedidos', xtype: 'button', text: 'Completar', scope: this,  listeners:{ click: 
        function(boton, evento){
           var id=panel.getComponent('comPrecCabId').getValue();
           var clienteId=Ext.get('clienteIdCabCom').getValue();
           if (Ext.isEmpty(id)){
             Ext.Msg.show({ title:'Completar desde pedidos', msg: 'Primero debe seleccionar qué comunicación desea duplicar.', buttons: Ext.Msg.OK});
             return;
           }
           var vent=new VentanaCreacion();
           vent.setComPrecCabId(id);
           vent.setClienteId(clienteId);
           vent.show();
           vent.on('hide', 
             function(){
              panel.fireEvent('datos del formulario cabecera cambiaron'); //esto es para que pueble el detalle
              vent.destroy();  
             }
           );
        }//función de manejo de click
     }//listeners del botón
    }//botón "Crear desde pedidos"  
  ],  
    
      

   
   pueblaDatosEnForm : function(record){
	   form=this.getForm();
     this.getComponent("comPrecCabId").setValue(record.get("comPrecCabId"));
     this.getComponent("fecha").setValue(record.get("fecha"));
     this.getComponent("clienteCombo").setValue(record.get("clienteNombre"));
     this.getComponent("destinatario").setValue(record.get("destinatario"));
     this.getComponent("autorizadorCombo").setValue(record.get("autorizadorNombre"));
     this.getComponent("metodoEnvio").setValue(record.get("metodoEnvio"));
     Ext.get('clienteIdCabCom').dom.value=(record.get('clienteId'));
     Ext.get('autorizadorId').dom.value=(record.get('autorizadorId'));
   },
   
   pueblaFormEnRegistro : function(record){
	   record.data['comPrecCabId']=  this.getComponent('comPrecCabId').getValue();
     record.data['clienteId']= Ext.get('clienteIdCabCom').dom.value;
	   record.data['clienteNombre']= this.getComponent('clienteCombo').getRawValue();
     record.data['destinatario']= this.getComponent('destinatario').getValue();
	   record.data['autorizadorNombre']= this.getComponent('autorizadorCombo').getRawValue();
	   record.data['fecha']= this.getComponent('fecha').getValue();
     record.data['metodoEnvio']= this.getComponent('metodoEnvio').getValue();
	   record.commit();
   },    
   
   validaHijo : function(muestraVentana){
	   var mensaje=null;
	   var valido=true;
	   
       if (!this.getComponent('clienteCombo').isValid()){
         valido=false;
         mensaje='El cliente no es válido';
       }
       
       if (!this.getComponent('autorizadorCombo').isValid()){
         valido=false;
         mensaje='El autorizador no es válido';
      }
      
      if (!this.getComponent('metodoEnvio').isValid()){
         valido=false;
         mensaje='El método de envío no es válido';
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













