GrillaOrdenesProduccionDet = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaOrdenesProduccionDet.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/ordenProdDetalle.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'ordProdDetId',
							fields : [
                {name : 'ordProdDetId', type : 'string'},
                {name : 'ordProdCabId', type : 'string'},
                {name : 'piezaId', type : 'string'},
                {name : 'cantidad', type : 'int'},
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
        {header : 'ordProdDetId', dataIndex : 'ordProdDetId', hidden : true},
        {header : 'ordProdCabId', dataIndex : 'ordProdCabId', hidden : true},
        {header : 'piezaId', dataIndex : 'piezaId', hidden : true},
        {header : 'Cantidad', dataIndex:  'cantidad', width: 150},
        {header : 'Artículo', dataIndex : 'piezaNombre', width: 350},
        {header : 'Observaciones', dataIndex: 'observaciones', width: 250, type : 'string'}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaOrdProdDet',
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
