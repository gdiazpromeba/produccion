GrillaMatrices = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaMatrices.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/matrices.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'matrizId',
							fields : [
                {name : 'matrizId', type : 'string', allowBlank : false },
                {name : 'matrizNombre', type : 'string', allowBlank : false },
                {name : 'matrizTipo', type : 'string', allowBlank : false },
                {name : 'matrizFoto', type : 'string', allowBlank : false },
                {name : 'matrizMedidas', type : 'string', allowBlank : false },
                {name : 'anchoBase', type : 'int', allowBlank : false },
                {name : 'largoBase', type : 'int', allowBlank : false },
                {name : 'alturaConjunto', type : 'int', allowBlank : false },
                {name : 'matrizForma', type : 'string', allowBlank : false },
                {name : 'depositoId', type : 'string', allowBlank : false},
                {name : 'depositoNombre', type : 'string', allowBlank : false },
                {name : 'matrizCondicion', type : 'string', allowBlank : false }
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'matrizId', hidden : true},
        {header : 'Nombre', dataIndex : 'matrizNombre', width : 150, sortable : true},
        {header : 'Deposito', dataIndex : 'depositoNombre', width : 210, sortable : true},
        {header : 'Condición', dataIndex : 'matrizCondicion', width : 485, sortable : false}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaMatrices',
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
        var titulo=registro.get('matrizNombre');
        return titulo;
      }

		}, config));
	} //constructor
});

Ext.reg('grillamatrices', GrillaMatrices);