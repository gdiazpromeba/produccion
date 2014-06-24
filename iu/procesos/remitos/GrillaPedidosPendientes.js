GrillaPedidosPendientes = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPedidosPendientes.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/pedidosDetalle.php/seleccionaPendientes'
        }),
        remoteSort: true,
        autoLoad: false,
        sortInfo: {
          field: 'pedidoFecha',
          direction: 'ASC' 
        },        
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'pedidoDetalleId',
							fields : [
                {name : 'pedidoDetalleId', type : 'string'},
                {name : 'pedidoFecha', type : 'date', dateFormat : 'Y-m-d H:i:s' },
                {name : 'piezaId', type : 'string'},
                {name : 'piezaNombre', type : 'string'},
                {name : 'cantidad', type : 'float'},
                {name : 'remitidos', type : 'float'}, 
                {name : 'pedidoNumero', type : 'int'}
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {dataIndex : 'pedidoDetalleId', hidden: true, header: 'pedidoDetalleId'},
        {header : 'Fecha pedido', dataIndex : 'pedidoFecha', width : 85, sortable : true, renderer : Ext.util.Format.dateRenderer('d/m/Y')},
        {header : 'N° pedido', dataIndex : 'pedidoNumero', width : 85, sortable : false},
        {header : 'Artículo', dataIndex : 'piezaNombre', width : 170, sortable : false },
        {header : 'Cantidad', dataIndex : 'cantidad', width : 60, sortable : false, align : 'right' },
        {header : 'Remitidos', dataIndex : 'remitidos', width : 60, sortable : false, align : 'right'}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaPedidosPendientes',
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

			cargaPendientes : function(clienteId) {
				var store = this.getStore();
				store.setBaseParam('clienteId', clienteId);
				store.setBaseParam('start', this.getBottomToolbar().cursor);
				store.setBaseParam('limit', this.getBottomToolbar().pageSize);
				store.load();
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

Ext.reg('grillapedidospendientes', GrillaPedidosPendientes);