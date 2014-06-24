GrillaInsumos = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
	GrillaInsumos.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
			  proxy : new Ext.data.HttpProxy({
			    url : '/produccion/svc/conector/costos.php/insumosPorEtapa'
              }),
              baseParams: {start: 0, limit: 15},
              remoteSort: true,
              autoLoad: false,
			  reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'facturaCabId',
							fields : [
                              {name : 'materialId', type : 'string'},
                              {name : 'materialNombre', type : 'string'},
                              {name : 'cantidad', type : 'float'},
                              {name : 'unidadTexto', type : 'string'},
                              {name : 'precioUnitario', type : 'float'},
                              {name : 'precioTotal', type : 'float'}
                            ]
			    }),
				autoDestroy : true,
			    listeners : {
				  load : { 
					  scope : this,
					  fn : function(store, registros, opciones) {
                        var suma=0;
                        for (var i = 0; i < registros.length; i++) {
                          suma += registros[i].get('precioTotal');
                        }
                        Ext.getCmp('totalInsumos').setValue(suma);		
					  }
				  }
			  }				
			}),
			columns : [
	          {header : 'Insumo', dataIndex : 'materialNombre', width : 180, sortable : true},
	          {header : 'Cantidad', dataIndex : 'cantidad', width : 90, sortable : true},
	          {header : 'Unidad', dataIndex : 'unidadTexto', width : 50, sortable : true},
	          {header : 'Unitario', dataIndex : 'precioUnitario', width : 90, sortable : true, align: 'right', renderer: Ext.util.Format.usMoney},
	          {header : 'Total', dataIndex : 'precioTotal', width : 90, sortable : true, align: 'right', renderer: Ext.util.Format.usMoney}
	        ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 100,
		    id : 'grillaInsumos',
	  	    obtieneSeleccionado : function() {
				var sm = this.getSelectionModel();
				if (sm.getSelected() != null) {
					return sm.getSelected();
				} else {
					return null;
				}
			}
		}, config));
	} //constructor
});

Ext.reg('grillainsumos', GrillaInsumos);
