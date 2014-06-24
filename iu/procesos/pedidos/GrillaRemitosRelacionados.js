GrillaRemitosRelacionados = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaRemitosRelacionados.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/remitosDetalle.php/selRemitosRelacionados'
        }),
//        remoteSort: true,
        autoLoad: false,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							fields : [{
										name : 'cantidad',
										type : 'float',
										allowBlank : false
									}, {
										name : 'fecha',
										type : 'date',
										allowBlank : false,
										dateFormat : 'Y-m-d H:i:s'
									}, {
										name : 'numero',
										type : 'int',
										allowBlank : false
									}, {
										name : 'estado',
										type : 'string',
										allowBlank : false
									}]
						}),
				autoDestroy : true
			}),
			columns : [{
            header : 'Cantidad',
            dataIndex : 'cantidad',
            width : 60,
            sortable : false,
            align : 'right'
          }, {
            header : 'N° remito',
            dataIndex : 'numero',
            width : 85,
            sortable : false
          },{         
						header : 'Fecha remito',
						dataIndex : 'fecha',
						width : 85,
						sortable : true,
						renderer : Ext.util.Format.dateRenderer('d/m/Y')
					}, {
						header : 'Estado',
						dataIndex : 'estado',
						width : 170,
						sortable : false
					}],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),


			cargaRelacionados : function(pedidoDetalleId) {
				var store = this.getStore();
				store.setBaseParam('pedidoDetalleId', pedidoDetalleId);
				store.load();
			},
      
      limpia : function() {
        var store = this.getStore();
        store.removeAll();
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