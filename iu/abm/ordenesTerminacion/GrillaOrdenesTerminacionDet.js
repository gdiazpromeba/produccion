GrillaOrdenesTerminacionDet = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaOrdenesTerminacionDet.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/ordenTermDetalle.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'ordTermDetId',
							fields : [
                {name : 'ordTermDetId', type : 'string'},
                {name : 'ordTermCabId', type : 'string'},
                {name : 'piezaId', type : 'string'},
                {name : 'cantidad', type : 'int'},
                {name : 'cantidadCortada', type : 'int'},
                {name : 'cantidadPulida', type : 'int'},
                {name : 'fechaEntrega', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                {name : 'piezaNombre', type : 'string'},
                {name : 'observaciones', type : 'string'}
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'ordTermDetId', dataIndex : 'ordTermDetId', hidden : true},
        {header : 'ordTermCabId', dataIndex : 'ordTermCabId', hidden : true},
        {header : 'piezaId', dataIndex : 'piezaId', hidden : true},
        {header : 'Cantidad', dataIndex:  'cantidad', width: 150},
        {header : 'Artículo', dataIndex : 'piezaNombre', width: 350},
        {header : 'Cortados', dataIndex:  'cantidadCortada', width: 150},
        {header : 'Pulidos', dataIndex:  'cantidadPulida', width: 150},
        {header : 'Entrega', dataIndex:  'fechaEntrega', width: 150, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
        {header : 'Observaciones', dataIndex: 'observaciones', width: 250, type : 'string'}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaOrdTermDet',
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
