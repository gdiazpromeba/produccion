BusquedaRemLaq = Ext.extend(Ext.Panel, {
  constructor : function(config) {
		BusquedaRemLaq.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Búsqueda',
        frame:true,
      items: [
        {xtype: 'fieldset', itemId: 'columnaIzq', border: false, layout: 'form', columnWidth: 0.5,
           items: [
             {xtype: 'combolaqueadores', width: 250, id: 'laqueadorComboPantRemLaq', name: 'laqueadorComboPantRemLaq' , itemId: 'laqueadorComboPantRemLaq', hiddenName: 'laqueadorIdPantRemLaq', hiddenId: 'laqueadorIdPantRemLaq'},
             {xtype: 'comboestadoslaqueado', width: 250, id: 'comboEstadosBRL'}
           ]
        },
        {xtype: 'fieldset', itemId: 'columnaDer', border: false, layout: 'form', columnWidth: 0.5, labelWidth: 180,
         items: [
          {fieldLabel: 'Fecha desde',   itemId: 'envioDesdeBRL', id: 'envioDesdeBRL',  xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
          {fieldLabel: 'Fecha hasta',   itemId: 'envioHastaBRL', id: 'envioHastaBRL',  xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
         ]//los items del fiedlset
	    }//el fieldset
      ],//los items
        buttons:[
          {text:'Busqueda', itemId: 'buscarRLaq', ref: 'buscarRLaq', scope: this,
                listeners: {
                  click: function(boton, evento){
					var grilla=Ext.getCmp('grillaRemLaqCab');
                    var store=grilla.getStore();
					store.setBaseParam('start', grilla.getBottomToolbar().cursor);
					store.setBaseParam('limit', grilla.getBottomToolbar().pageSize);
					store.setBaseParam('laqueadorId', Ext.get('laqueadorIdPantRemLaq').dom.value);
					var envioDesde=Ext.getCmp('envioDesdeBRL');
					var envioHasta=Ext.getCmp('envioHastaBRL');
					store.setBaseParam('envioDesde', envioDesde.getValue());
					store.setBaseParam('envioHasta', envioHasta.getValue());
					var estado=Ext.getCmp('comboEstadosBRL');
					store.setBaseParam('estado', estado.getValue());
					store.load();
                }
             }
        },
        {text:'Reinicializar', itemId: 'reinicializaRLaq', scope: this,
           listeners: {
			  click: function(boton, evento){
				var grilla=Ext.getCmp('grillaRemLaqCab');
				var store=grilla.getStore();
				Ext.getCmp('laqueadorComboPantRemLaq').clearValue();
				Ext.getCmp('envioDesdeBRL').reset();
				Ext.getCmp('envioHastaBRL').reset();
				Ext.getCmp('comboEstadosBRL').clearValue();
	          }
		  }
        }
      ]
		}, config));




	} //constructor
});
Ext.reg('busquedaremlaq', BusquedaRemLaq);