GrillaLineas = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaLineas.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/lineas.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'lineaId',
							fields : [
                {name : 'lineaId', type : 'string', allowBlank : false },
                {name : 'lineaDescripcion', type : 'string', allowBlank : false },
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
        {header : 'id', dataIndex : 'lineaId', hidden : true},
        {header : 'Línea', dataIndex : 'lineaDescripcion', width : 300, sortable : true}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaLineas',
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
