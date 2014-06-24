GrillaFichas = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaFichas.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/fichas.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'fichaId',
							fields : [
                {name : 'fichaId', type : 'string', allowBlank : false },
                {name : 'piezaFicha', type : 'int', allowBlank : false },
                {name : 'fichaContenido', type : 'string', allowBlank : true }
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'fichaId', hidden : true},
        {header : 'Ficha', dataIndex : 'piezaFicha', width : 150, sortable : true}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
		  id : 'grillaFichas',
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
        var titulo=registro.get('piezaFicha');
        return titulo;
      }

		}, config));
	} //constructor
});
