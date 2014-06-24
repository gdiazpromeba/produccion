GrillaPlanProdChapDet = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPlanProdChapDet.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/plPrChapDet.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'plPrChapDetId',
							fields : [
                {name : 'plPrChapDetId', type : 'string'},
                {name : 'plPrChapCabId', type : 'string'},
                {name : 'unidades', type : 'int'},
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
        {header : 'plPrChapDetId', dataIndex : 'planProdDetId', hidden : true},
        {header : 'plPrChapDetId', dataIndex : 'planProdCabId', hidden : true},
        {header : 'Unidades', dataIndex : 'unidades'},
        {header : 'Terminación', dataIndex : 'terminacion', width: 80},
        {header : 'Larga', dataIndex:  'largo', width: 60},
        {header : 'Ancho', dataIndex:  'ancho', width: 60},
        {header : 'Cruzada', dataIndex:  'cruzada', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
		  id : 'grillaPlPrChapDetId',
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
