GrillaMateriales = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
	GrillaMateriales.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
			  proxy : new Ext.data.HttpProxy({
			    url : '/produccion/svc/conector/materiales.php/selecciona'
              }),
              baseParams: {start: 0, limit: 15},
              remoteSort: true,
              autoLoad: false,
			  reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'materialId',
							fields : [
                              {name : 'materialId', type : 'string'},
                              {name : 'materialNombre', type : 'string'},
                              {name : 'unidadId', type : 'string'},
                              {name : 'unidadTexto', type : 'string'},
                              {name: 'precio', type: 'float'}
                            ]
			    }),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
				pageSize : 15,
				displayInfo : true
			}),			
			columns : [
			  {header: '#', dataIndex: 'materialId', width: 50, hidden: true, locked: true },
			  {header: 'Nombre', dataIndex: 'materialNombre', width: 220, sortable: true },
			  {header: 'Unidad', dataIndex: 'unidadTexto', width: 50, sortable: true },
			  {header: 'Precio', dataIndex: 'precio', width: 100, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney }
	        ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		    id : 'grillaMateriales',
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
              var titulo='Precios de ' + registro.get('materialNombre');
              return titulo;
           }

		}, config));
	} //constructor
});
