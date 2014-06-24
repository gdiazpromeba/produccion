GrillaChapasPorPieza = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaChapasPorPieza.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/chapasPorPieza.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'chXPId',
							fields : [
                {name : 'chPXId', type : 'string'},
                {name : 'piezaId', type : 'string'},
                {name : 'cantidad', type : 'float'},
                {name : 'terminacion', type : 'string'},
                {name : 'largo', type : 'int'},
                {name : 'ancho', type : 'int'},
                {name : 'cruzada', type : 'bool'}
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'chPXId', dataIndex : 'chPXId', hidden : true},
        {header : 'piezaId', dataIndex : 'piezaId', hidden : true},
        {header : 'Cantidad', dataIndex : 'cantidad'},
        {header : 'Terminación', dataIndex : 'terminacion', width: 80},
        {header : 'Larga', dataIndex:  'largo', width: 60},
        {header : 'Ancho', dataIndex:  'ancho', width: 60},
        {header : 'Cruzada', dataIndex:  'cruzada', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
		  id : 'chXPId',
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
