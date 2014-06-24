// the check column is created using a custom plugin
var checkColumnGsn = new Ext.grid.CheckColumn({
   header: 'Asignar',
   dataIndex: 'asignado',
   width: 55
});

GrillaSinLaqueador = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaSinLaqueador.superclass.constructor.call(this, Ext.apply( {
			region : 'center',
			store : new Ext.data.Store( {
				proxy : new Ext.data.HttpProxy( {
					url : '/produccion/svc/conector/remitosLaqueado.php/selPedidosNoAsignados'
				}),
				baseParams : {
					start : 0,
					limit : 30
				},
				remoteSort : true,
				autoLoad : true,
				reader : new Ext.data.JsonReader( {
					root : 'data',
					totalProperty : 'total',
					idProperty : 'pagoId',
					fields : [
                        {name : 'clienteId', type : 'string', allowBlank : false},
                        {name : 'clienteNombre', type : 'string', allowBlank : false},
                        {name : 'pedidoCabeceraId', type : 'string', allowBlank : false},
                        {name : 'pedidoNumero', type : 'int', allowBlank : false},
                        {name : 'fechaPrometida', type: 'date',  dateFormat: 'Y-m-d H:i:s', allowBlank: false},
                        {name : 'piezaId', type : 'string', allowBlank : false},
                        {name : 'piezaNombre', type : 'string', allowBlank : false},
                        {name : 'terminacionId', type : 'string', allowBlank : false},
                        {name : 'terminacionNombre', type : 'string', allowBlank : false},
                        {name : 'pedidoDetalleId', type : 'string', allowBlank : false},
                        {name : 'cantidad', type : 'int', allowBlank : false},
                        {name : 'asignado', type : 'bool'},
					]
				}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar( {
				pageSize : 15,
				displayInfo : true
			}),
			columns : [
			  {header : 'clienteId', dataIndex : 'clienteId', hidden : true},
			  {header : 'Cliente', dataIndex : 'clienteNombre', width: 100},
			  {header : 'pedidoCabeceraId', dataIndex : 'pedidoCabeceraId', hidden : true},
			  {header : 'N°pedido', dataIndex : 'pedidoNumero', width: 60},
			  {header: 'Prometido', dataIndex: 'fechaPrometida', width: 90, sortable: true, renderer: Ext.util.Format.dateRenderer('d/m/Y') },
			  {header : 'piezaId', dataIndex : 'clienteId', hidden : true},
			  {header : 'Artículo', dataIndex : 'piezaNombre', width: 180},
			  {header : 'terminacionId', dataIndex : 'terminacionId', hidden : true},
			  {header : 'Terminación', dataIndex : 'terminacionNombre', width: 100},
              {header : 'pedidoDetalleId', dataIndex : 'pedidoDetalleId', hidden : true},
              {header : 'Cantidad', dataIndex : 'cantidad', width: 80},
              checkColumnGsn,
			],
			plugins: checkColumnGsn,
            clicksToEdit: 1,
            /*
			selModel : new Ext.grid.RowSelectionModel( {
				singleSelect : false
			}),
			*/
			height : 450,
			id : 'grillaSinLaqueador',
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

Ext.reg('grillasinlaqueador', GrillaSinLaqueador);