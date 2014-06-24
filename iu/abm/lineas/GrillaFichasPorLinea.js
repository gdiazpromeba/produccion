GrillaFichasPorLinea = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaFichasPorLinea.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/fichasPorLinea.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'fxlId',
							fields : [
                {name : 'fxlId', type : 'string', allowBlank : false },
                {name : 'lineaId', type : 'string', allowBlank : false },
                {name : 'piezaFicha', type : 'string', allowBlank : false },
                {name : 'observaciones', type : 'string', allowBlank : true }
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'fxlId', dataIndex : 'fxlId', hidden : true},
        {header : 'lineaId', dataIndex:  'lineaId', hidden : true},
        {header : 'Ficha', dataIndex:  'piezaFicha', width: 150},
        {header : 'Observaciones', dataIndex: 'observaciones', width: 350, type : 'string'}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaFichasPorLinea',
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
			},
      
      tituloHijo : function (){
        var registro=this.obtieneSeleccionado();
        var titulo=registro.get('lineaDescripcion');
        return titulo;
      }

		}, config));
	} //constructor
});
