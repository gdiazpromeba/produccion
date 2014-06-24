RemitosDetalleForm = Ext.extend(PanelFormCabeceraAbm, {
  constructor : function(config) {
    RemitosDetalleForm.superclass.constructor.call(this, Ext.apply({
		id: 'panFormRemitosDetalle',
		prefijo: 'DetalleRemitos',
		title: 'Todos',
		flex: 1.2,
		nombreElementoId: 'remitoDetalleId',
	    urlAgregado: '/produccion/svc/conector/remitosDetalle.php/inserta',
	    urlModificacion: '/produccion/svc/conector/remitosDetalle.php/actualiza',
	    urlBorrado: '/produccion/svc/conector/remitosDetalle.php/borra',
	    labelAlign: 'top',
	  	items: [
          {xtype: 'hidden', name: 'remitoDetalleId', id: 'remitoDetalleId', itemId: 'remitoDetalleId', allowBlank: false},
          {xtype: 'hidden', name: 'piezaId', id: 'piezaId', itemId: 'piezaId', allowBlank: false},
          {xtype: 'hidden', name: 'pedidoDetalleId', id: 'pedidoDetalleId', itemId: 'pedidoDetalleId', allowBlank: false},
          {fieldLabel: 'Pedidos pendientes', xtype: 'grillapedidospendientes', itemId: 'grillaPendientes', width: 570},
  		    {fieldLabel: 'Cantidad', xtype: 'numberfield', id: 'cantidad', name: 'cantidad', itemId : 'cantidad', allowBlank: false, width: 50}
 	    ],
 	    listeners: {
 			  'render' : {  //para colocar el valor de de la piezaId seleccionada en el en el campo oculto
 			      fn: function(componente){
 	 	    	  var grilla=componente.getComponent('grillaPendientes');
 	 	    	  grilla.getSelectionModel().on('rowselect', function(){
 	 	    	    var registro=grilla.obtieneSeleccionado();
 	 	    	    this.getComponent('piezaId').setValue(registro.get('piezaId'));
 	 	    	    this.getComponent('pedidoDetalleId').setValue(registro.get('pedidoDetalleId'));
 	 	    	  }, this);
 		        }
 		       }
 	 	    } 	    

      }, config));
    }, //constructor
  
     /**
      * evita que se agregue nada a menos que haya algo seleccionado en la 
      * grilla de pendientes, y, si pasa, luego de la llamada a la función
      * madre, repuebla el valor de piezaId (que es reinicializado junto con
      * todo lo otro).
      */  
    pulsoAgregar: function(panel){
       var grilla=this.getComponent('grillaPendientes');
       var registro=grilla.obtieneSeleccionado();
       if (registro==null){
         Ext.Msg.show({ title:'Agregado', msg: 'Debe seleccionar un ítem pendiente',  buttons: Ext.Msg.OK});
         return;
       }else if (registro.get('remitoCabeceraId')===null){
         Ext.Msg.show({ title:'Agregado', msg: 'Debe seleccionar un registro de cabecera de remito',  buttons: Ext.Msg.OK});
         return;
       }
       PanelFormCabeceraAbm.prototype.pulsoAgregar.call(this);
       this.getComponent('piezaId').setValue(registro.get('piezaId'));
       this.getComponent('pedidoDetalleId').setValue(registro.get('pedidoDetalleId'));
    },
     
    pueblaDatosEnForm : function(record){
       this.getComponent("cantidad").setValue(record.get("cantidad"));                         
       this.getComponent("pedidoDetalleId").setValue(record.get("pedidoDetalleId"));                         
       this.getComponent(this.prefijo + "valorIdPadre").setValue(record.get("remitoCabeceraId"));
       this.getComponent('piezaId').setValue(record.get('piezaId'));
       this.getComponent('remitoDetalleId').setValue(record.id);
    },
     
    pueblaFormEnRegistro : function(record){
       record.id=  this.getComponent('remitoDetalleId').getValue();
       record.data['pedidoDetalleId']= this.getComponent('pedidoDetalleId').getValue();
       record.data['piezaId']= this.getComponent('piezaId').getValue();
       record.data['piezaNombre']= this.getComponent('grillaPendientes').obtieneSeleccionado().get('piezaNombre');
       record.data['pedidoNumero']= this.getComponent('grillaPendientes').obtieneSeleccionado().get('pedidoNumero');
       record.data['cantidad']= this.getComponent('cantidad').getValue();
       record.data['remitoCabeceraId']=  this.getComponent(this.prefijo + 'valorIdPadre').getValue();
       record.commit();
    },      
  
     

     
     /**
      * después de agregar, necesito que el panel de pendientes se refresque
      */
    exitoAgregado: function(nuevoId){
       PanelFormCabeceraAbm.prototype.exitoAgregado.call(this, nuevoId);
       this.getComponent('grillaPendientes').getStore().reload();    
    }, 
     
     /**
      * después de modificar, necesito que el panel de pendientes se refresque
      */
    exitoModificacion : function(nuevoId){
       PanelFormCabeceraAbm.prototype.exitoModificacion.call(this);
       this.getComponent('grillaPendientes').getStore().reload();
    },      
     
     /**
      * después de borrar, necesito que el panel de pendientes se refresque
      */
    exitoBorrado: function(){
       PanelFormCabeceraAbm.prototype.exitoBorrado.call(this);
       this.getComponent('grillaPendientes').getStore().reload();
    },    
     
    validaHijo : function(muestraVentana){
       var mensaje=null;
       var valido=true;

       var piezaId=this.getComponent('piezaId').getValue();
       if (piezaId==null){
         valido=false;
         mensaje='Ningún artículo ha sido seleccionado.';
       }
       
       var cantidad=this.getComponent('cantidad');
       if (!cantidad.isValid()){
         valido=false;
         mensaje='La cantidad no es es válida';
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
  
  
  
});