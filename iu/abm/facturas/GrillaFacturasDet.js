GrillaFacturasDet = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaFacturasDet.superclass.constructor.call(this, Ext.apply({
          region: 'center',
		  store : new Ext.data.Store({
		    proxy : new Ext.data.HttpProxy({
		      url : '/produccion/svc/conector/facturasDetalle.php/selecciona'
              }),
              baseParams: {start: 0, limit: 15},
              remoteSort: true,
              autoLoad: false,
		      reader : new Ext.data.JsonReader({
			    root : 'data',
			    totalProperty : 'total',
			    idProperty : 'facturaDetalleId',
			    fields : [
                  {name : 'facturaDetalleId', type : 'string'},
                  {name : 'facturaCabId', type : 'string'},
                  {name : 'referenciaPedido', type : 'string'},
                  {name : 'piezaId', type : 'string'},
                  {name : 'piezaNombre', type : 'string'},
                  {name : 'cantidad', type : 'int'},
                  {name : 'precioUnitario', type : 'float'},
                  {name : 'importe', type : 'float'},
                  {name : 'observacionesDet', type : 'string'}
                ]
			  }),
			  autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
              {header : 'facturaDetalleId', dataIndex : 'facturaDetalleId', hidden : true},
              {header : 'facturaCabId', dataIndex : 'facturaCabId', hidden : true},
              {header : 'piezaId', dataIndex : 'piezaId', hidden : true},
              {header : 'Artículo', dataIndex : 'piezaNombre', width: 350},
              {header : 'Cantidad', dataIndex:  'cantidad', width: 80},
              {header : 'Precio Unitario', dataIndex : 'precioUnitario', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
              {header : 'Importe', dataIndex : 'importe', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
              {header : 'Observaciones', dataIndex: 'observacionesDet', width: 350, type : 'string'}
            ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaFacturasDet',
			listeners : {
				render : {
					scope : this,
					fn : function() {
						var store = this.store;
						var ptool = this.getBottomToolbar();
						ptool.bindStore(store);
					}
				}
			},

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
