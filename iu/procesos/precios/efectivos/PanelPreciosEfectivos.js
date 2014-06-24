PanelPreciosEfectivos = Ext.extend(Ext.Panel, {
  constructor : function(config) {
		PanelPreciosEfectivos.superclass.constructor.call(this, Ext.apply({
      layout: 'border',
      items: [
        {xtype: 'hidden', itemId: 'clienteIdSeleccionado'},
        {xtype: 'hidden', itemId: 'piezaIdSeleccionada'},
        {xtype: 'hidden', itemId: 'precioSeleccionado'},  
        {xtype: 'hidden', itemId: 'fechaSeleccionada'},
        {itemId: 'busqueda', xtype: 'busquedapreciosefectivos', region: 'north', height: 140},
        {itemId: 'grilla', xtype: 'grillapreciosefectivos', region: 'center', scope: this,              
         listeners:{
            'click':  function(evento){
              var record=this.getComponent('grilla').getSelectionModel().getSelected();
              var busqueda=this.getComponent('busqueda');
              this.cargaSeleccionados(record.data.piezaId, record.data.clienteId, record.data.precio, record.data.fechaSeleccionada);
             }, 
             scope: this}
        }
      ],
      
      recarga: function(){
        var grilla=this.getComponent('grilla');
        grilla.getStore().reload();
      }
		}, config));
    
    var busqueda=this.getComponent('busqueda');
    var grilla=this.getComponent('grilla');
    
    busqueda.on('buscar pulsado', function(){
      var params=busqueda.getParamsBusqueda();
      grilla.recarga(params);  
    });
    
    busqueda.on('reinicializar pulsado', function(){
      grilla.getStore().baseParams={start: 0, limit: 30};
      var params=[];
      grilla.recarga(params);
    });
    
    busqueda.on('agrega general pulsado', function(){
      var piezaId=this.getComponent('piezaIdSeleccionada').getValue();
      var clienteId=this.getComponent('clienteIdSeleccionado').getValue();
      var precio=this.getComponent('precioSeleccionado').getValue();
      this.agregaGeneral(piezaId, precio);
    }, this);
    
    busqueda.on('usa general pulsado', function(){
      var piezaId=this.getComponent('piezaIdSeleccionada').getValue();
      var clienteId=this.getComponent('clienteIdSeleccionado').getValue();
      this.usaGeneral(piezaId, clienteId);
    }, this);    
    
	}, //constructor
  
  cargaSeleccionados : function (piezaId, clienteId, precio, fecha){
    this.getComponent('piezaIdSeleccionada').setValue(piezaId);
    this.getComponent('clienteIdSeleccionado').setValue(clienteId);
    this.getComponent('precioSeleccionado').setValue(precio);
    this.getComponent('fechaSeleccionada').setValue(fecha);
  },  
  
  agregaGeneral : function (piezaId, precio){
    var ahora=new Date().format("d/m/Y");
    var grilla=this.getComponent('grilla');
    Ext.Ajax.request({
      url:  '/produccion/svc/conector/preciosGenerales.php/insertaAhora',
      method: 'POST',
      params: { 
        'piezaIdPrecTod' : piezaId,  
        'precioPrecTod' :  precio
        //'efectivoDesdePrecTod' :  ahora
      },
      failure: function (response, options) {
        Ext.Msg.show({ title:'Ingreso', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
      },
      success: function (response, options) {
        var objRespuesta=Ext.util.JSON.decode(response.responseText);
        if (objRespuesta.success){
          Ext.Msg.show({ title:'Ingreso', msg: 'General agregado', buttons: Ext.Msg.OK});
          grilla.recarga([]);
        }else{
          Ext.Msg.show({ title:'Ingreso', msg: 'Error al agregar general', buttons: Ext.Msg.OK});
         }
      }
    });
    },
    
  usaGeneral : function (piezaId, clienteId){
    var ahora=new Date().format("d/m/Y");
    var grilla=this.getComponent('grilla');
    Ext.Ajax.request({
      url:  '/produccion/svc/conector/comunicacionesPreciosDetalle.php/haceUsarGeneral',
      method: 'POST',
      params: { 
        'piezaId' : piezaId,  
        'clienteId' :  clienteId
      },
      failure: function (response, options) {
        Ext.Msg.show({ title:'Ingreso', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
      },
      success: function (response, options) {
        var objRespuesta=Ext.util.JSON.decode(response.responseText);
        if (objRespuesta.success){
          Ext.Msg.show({ title:'Ingreso', msg: 'Registro marcado como que usa general', buttons: Ext.Msg.OK});
          grilla.recarga([]);
        }else{
          Ext.Msg.show({ title:'Ingreso', msg: 'Error al marcar como que usa general', buttons: Ext.Msg.OK});
         }
      }
    });
    }    
    
    
  
});