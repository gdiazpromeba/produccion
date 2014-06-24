GrillaBancos = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaBancos.superclass.constructor.call(this, Ext.apply( {
			region : 'center',
			store : new Ext.data.Store( {
				proxy : new Ext.data.HttpProxy( {
					url : '/produccion/svc/conector/bancos.php/selPorParte'
				}),
				baseParams : {
					start : 0,
					limit : 15
				},
				remoteSort : true,
				autoLoad : true,
				reader : new Ext.data.JsonReader( {
					root : 'data',
					totalProperty : 'total',
					idProperty : 'bancoId',
					fields : [ 
					    {name : 'bancoId', type : 'string', allowBlank : false}, 
						{name : 'bancoNombre', type : 'string', allowBlank : false} 
					]
				}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar( {
				pageSize : 15,
				displayInfo : true
			}),
			columns : [ 
			  {header : 'id', dataIndex : 'bancoId', hidden : true}, 
			  {header : 'Nombre', dataIndex : 'bancoNombre', width : 350, sortable : true},
			],
			selModel : new Ext.grid.RowSelectionModel( {
				singleSelect : true
			}),
			height : 250,
			id : 'grillaBancos',
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

			tituloHijo : function() {
				var registro = this.obtieneSeleccionado();
				var titulo = registro.get('bancoNombre');
				return titulo;
			}

		}, config));
	} //constructor
	});

Ext.reg('grillabancos', GrillaBancos);