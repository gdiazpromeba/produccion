GrillaPedidosPlanos = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPedidosPlanos.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/pedidosDetalle.php/selPlano'
        }),
        remoteSort: true,
        autoLoad: false,
        sortInfo: {
          field: 'fecha',
          direction: 'ASC'
        },
				reader : new Ext.data.JsonReader({
					root : 'data',
					totalProperty : 'total',
					fields : [
                     {name : 'pedidoDetalleId', type : 'string'},
                     {name : 'pedidoCabeceraId', type : 'string'},
                     {name : 'clienteId', type : 'string'},
                     {name : 'clienteNombre', type : 'string'},
                     {name : 'estado', type : 'string'},
                     {name : 'fecha', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                     {name : 'referencia', type : 'string'},
                     {name : 'interno', type : 'int'},
                     {name : 'pedidoNumero', type : 'int'},
                     {name : 'piezaId', type : 'string'},
                     {name : 'piezaNombre', type : 'string'},
                     {name : 'ficha', type : 'int'},
                     {name : 'cantidad', type : 'float'},
                     {name : 'remitidos', type : 'float'},
                     {name : 'pendientes', type : 'int'},
                     {name : 'laqueadorNombre', type : 'string'},
                     {name : 'fechaEnvio', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                     {name : 'fechaPrometida', type : 'date', dateFormat : 'd/m/Y'},
                     {name : 'precioUnitario', type : 'float'},
                     {name : 'precioTotal', type : 'float'},
                     {name : 'precioPendiente', type : 'float'},
                     {name : 'totalUnidadesPendientes', type : 'float'},
                     {name : 'terminacionId', type : 'string'},
                     {name : 'terminacionNombre', type : 'string'},
                     {name : 'estadoLaqueado', type : 'string'}
				   ]
        }),

        listeners : {
          load : {
            scope : this,
            fn : function() {
              var total=Ext.getCmp('totalUnidadesPendientes');
              var store = this.store;
              var ptool = this.getBottomToolbar();
              if (store.data.items.length>0){
                total.setValue(store.data.items[0].data.totalUnidadesPendientes);
              }else{
                total.setValue(0);
              }
            }
          }
        }

			}),
      bbar : new Ext.PagingToolbar({
            pageSize : 15,
            displayInfo : true,
            items:[
              {xtype: 'fieldset', itemId: 'camposBarra', border: false, layout: 'form',
                items:[
                  {fieldLabel: 'Total de unidades', itemId: 'totalUnidadesPendientes', id: 'totalUnidadesPendientes', xtype: 'numberfield', width: 60, allowBlank: true, allowDecimals: false, disabled: true}
                ]
              }
            ]
          }),
		columns : [
          {header : 'Cliente', dataIndex : 'clienteNombre', width : 80, sortable : false},
          {header : 'Estado', dataIndex : 'estado', width : 60, sortable : false},
          {header : 'Fecha', dataIndex : 'fecha', width : 80, renderer: Ext.util.Format.dateRenderer('d/m/Y'), sortable : false},
          {header : recursosInter.nro_pedido, dataIndex : 'pedidoNumero', width : 60, align: 'right', sortable : false},
          {header : recursosInter.articulo, dataIndex : 'piezaNombre', width : 210, sortable : false},
          {header : 'Cantidad', dataIndex : 'cantidad', width : 60, align: 'right', sortable : false},
          {header : 'Terminacion', dataIndex : 'terminacionNombre', width : 100, sortable : false},
          {header : 'Laqueador', dataIndex : 'laqueadorNombre', width : 100, sortable : false},
          {header : 'Est.laq.', dataIndex : 'estadoLaqueado', width : 100, sortable : false},
          {header : 'Precio Unitario', dataIndex: 'precioUnitario', width: 80, align: 'right', renderer: Ext.util.Format.usMoney, sortable: false},
          {header : 'Total', dataIndex: 'precioTotal', width: 80, align: 'right', renderer: Ext.util.Format.usMoney, sortable: false},
          {header : 'Pendiente', dataIndex: 'precioPendiente', width: 80, align: 'right', renderer: Ext.util.Format.usMoney, sortable: false}
		],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
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


      recarga : function(params) {
        var store = this.getStore();
        toolbar = this.getBottomToolbar();
        store.setBaseParam('start', toolbar.cursor);
        store.setBaseParam('limit', toolbar.pageSize);
        for(i=0; i< params.length; i++){
          var nombre=params[i]['nombre'];
          var valor=params[i]['valor'];
          store.setBaseParam(nombre, valor);
        }
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

Ext.reg('grillapedidosplanos', GrillaPedidosPlanos);