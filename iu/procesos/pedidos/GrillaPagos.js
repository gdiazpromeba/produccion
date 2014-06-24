GrillaPagos = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPagos.superclass.constructor.call(this, Ext.apply( {
			region : 'center',
			store : new Ext.data.Store( {
				proxy : new Ext.data.HttpProxy( {
					url : '/produccion/svc/conector/pagos.php/selTodos'
				}),
				baseParams : {
					start : 0,
					limit : 15
				},
				remoteSort : true,
				autoLoad : false,
				reader : new Ext.data.JsonReader( {
					root : 'data',
					totalProperty : 'total',
					idProperty : 'pagoId',
					fields : [
                        {name : 'pagoId', type : 'string', allowBlank : false},
                        {name : 'pedidoCabeceraId', type : 'string', allowBlank : false},
                        {name : 'monto', type : 'float', allowBlank : true},
                        {name : 'fecha', type: 'date',  dateFormat: 'Y-m-d H:i:s', allowBlank: false},
                        {name : 'tipo', type : 'string', allowBlank : false},
                        {name : 'observaciones', type : 'string', allowBlank : false},
					]
				}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar( {
				pageSize : 15,
				displayInfo : true
			}),
			columns : [ 
			  {header : 'pagoId', dataIndex : 'pagoId', hidden : true}, 
			  {header: 'Fecha', dataIndex: 'fecha', width: 90, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y') },
			  {header: 'Monto', dataIndex: 'monto', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
			  {header: 'Tipo', dataIndex: 'tipo', width: 100, sortable: true}
			],
			selModel : new Ext.grid.RowSelectionModel( {
				singleSelect : true
			}),
			height : 250,
			id : 'grillaPagos',
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
				var titulo = registro.get('pagoId');
				return titulo;
			}

		}, config));
	} //constructor
	});

Ext.reg('grillapagos', GrillaPagos);