PanelGeneraRemitoLaqueador = Ext.extend(Ext.form.FormPanel, {
	constructor : function(config) {
	  PanelGeneraRemitoLaqueador.superclass.constructor.call(this, Ext.apply({
        bodyPadding: 5,
        url: 'nada.php',
        defaultType: 'textfield',
        prefijo: null,
        items:[
          {fieldLabel: 'Fecha',  xtype: 'fecha', name: 'fechaRemLaq', itemId: 'fechaRemLaq', id: 'fechaRemLaq', allowBlank: false, muestraHoy: true},
          {xtype: 'combolaqueadores', width: 250, id: 'laqueadorComboGenRem', name: 'laqueadorComboGenRem' , itemId: 'laqueadorComboGenRen', hiddenName: 'laqueadorIdGenRem', hiddenId: 'laqueadorIdGenRem'},
          {fieldLabel: 'Pendientes', xtype: 'grillasinlaqueador', itemId: 'grillaSinLaqueador', id: 'grillaSinLaqueador',  width: 970}
        ],
        buttons: [
           {text:'Asignar', itemId: 'botGenerar', ref: '../botGenerar',
                listeners:{'click':  function(){
                    this.generacion();
           }, scope: this}}
       ],

       listeners : {
           activate:  function(){
			   var grid=Ext.getCmp('grillaSinLaqueador');
			   grid.getStore().load();
           }, scope: this
	   },

       generacion : function(){
		 //validación
		 var fechaEnvio=Ext.getCmp('fechaRemLaq');
		 var comboLaqueadores=Ext.getCmp('laqueadorComboGenRem');
		 if (!fechaEnvio.isValid()){
			 Ext.Msg.show({ title:'Generación de Remitos de Laqueado', msg: 'La fecha de envío no es válida', buttons: Ext.Msg.OK});
			 return;
		 }else if (comboLaqueadores.getValue()==''){
			 Ext.Msg.show({ title:'Generación de Remitos de Laqueado', msg: 'Se debe elegir un laqueador', buttons: Ext.Msg.OK});
			 return;
		 }




		 var remito = {};
		 remito.fechaEnvio= Ext.getCmp('fechaRemLaq').getValue();
		 var laqueador={};
		 laqueador.id = Ext.get('laqueadorIdGenRem').dom.value;
		 laqueador.nombre = Ext.getCmp('laqueadorComboGenRem').getRawValue();
		 remito.laqueador=laqueador;
	     var grid = Ext.getCmp('grillaSinLaqueador');
		 var store = grid.getStore();
         var items=[];
         remito.items=items;
         var algunoAsignado=false;
		 store.each(function(record,idx){
			 if (record.get('asignado')){
			   algunoAsignado=true;
			   var item={};
			   var cliente={};
			   cliente.id=record.get('clienteId');
			   cliente.nombre=record.get('clienteNombre');
			   item.cliente=cliente;
			   item.pedidoDetalleId=record.get('pedidoDetalleId');
			   item.cantidad=record.get('cantidad');
			   remito.items.push(item);
		   }
	     });
	     if (!algunoAsignado){
			 Ext.Msg.show({ title:'Generación de Remitos de Laqueado', msg: '¡No se ha seleccionado ningún pedido!', buttons: Ext.Msg.OK});
			 return;
		 }

	     Ext.Ajax.request({
		   url: '/produccion/svc/conector/remitosLaqueado.php/generaRemito',
		   params: {
             objetoJSON: Ext.util.JSON.encode(remito)
		   },
		   success: function(response, options) {
			  var objRespuesta=Ext.util.JSON.decode(response.responseText);
			  if (objRespuesta.success){
				grid.getStore().load();
			  }else{
				Ext.Msg.show({ title:'Remitos de laqueado', msg: objRespuesta.error, buttons: Ext.Msg.OK});
			  }
		   },
		   failure: function(response, options) {
			   Ext.Msg.show({ title:'Remitos de laqueado', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
		   },
         });
       }

     }, config));

  }// del constructor


});


