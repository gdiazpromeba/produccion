GrillaPlanillasProduccionDet = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPlanillasProduccionDet.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/planillasProduccionDetalle.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'planProdDetId',
							fields : [
                {name : 'planProdDetId', type : 'string'},
                {name : 'planProdCabId', type : 'string'},
                {name : 'matrizId', type : 'string'},
                {name : 'matrizNombre', type : 'string'},
                {name : 'cantidad', type : 'int'},
                {name : 'espesor', type : 'float'},
                {name : 'estacionTrabajo', type : 'string'},
                {name : 'terminacion', type : 'string'},
                {name : 'reparada', type : 'bool'},
                {name : 'descartada', type : 'bool'},
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
        {header : 'planProdDetId', dataIndex : 'planProdDetId', hidden : true},
        {header : 'planProdCabId', dataIndex : 'planProdCabId', hidden : true},
        {header : 'matrizId', dataIndex : 'matrizId', hidden : true},
        {header : 'Estación de trabajo', dataIndex : 'estacionTrabajo'},
        {header : 'Matriz', dataIndex:  'matrizNombre', width: 80},
        {header : 'Prensadas', dataIndex : 'cantidad', width: 80},
        {header : 'Espesor', dataIndex : 'espesor', width: 80},
        {header : 'Reparadas', dataIndex:  'reparada', width: 30, renderer : function (value) { return (value == 1)?'Sí':'No';}},
        {header : 'Descartadas', dataIndex:  'descartada', width: 30, renderer : function (value) { return (value == 1)?'Sí':'No';}},
        {header : 'Terminación', dataIndex : 'terminacion', width: 80},
        {header : 'Observaciones', dataIndex: 'observacionesDet', width: 450, type : 'string'}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaPlanProdDet',
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
