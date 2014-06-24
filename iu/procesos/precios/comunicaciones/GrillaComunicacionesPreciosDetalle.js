GrillaComunicacionesPreciosDetalle = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaComunicacionesPreciosDetalle.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/comunicacionesPreciosDetalle.php/selecciona'
        }),
        remoteSort: false,
        autoLoad: false,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'comPrecDetId',
							fields : [
                {name : 'comPrecDetId', type : 'string'},
                {name : 'comPrecCabId', type : 'string'},
                {name : 'piezaId', type : 'string'},
                {name : 'piezaNombre', type : 'string'},
                {name : 'precio', type : 'float'},
                {name : 'usaGeneral', type : 'bool'}
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'comPrecDetId', hidden : true},
        {header : recursosInter.articulo, dataIndex : 'piezaNombre', width : 500, sortable : true},
        {header : recursosInter.precio, dataIndex : 'precio', width : 85, sortable : true, align: 'right', renderer: Ext.util.Format.usMoney},
        {header : 'Usa General', dataIndex:  'usaGeneral', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaComunicacionesPreciosDetalle',
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

Ext.reg('grillacomprecdet', GrillaComunicacionesPreciosDetalle);