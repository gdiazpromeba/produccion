GrillaPreciosEfectivos = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPreciosEfectivos.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.GroupingStore({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/preciosEfectivosActuales.php/selEfectivosActuales',
          method: 'post'
        }),
        groupField: 'piezaNombre',
        sortInfo:{field: 'piezaNombre', direction: "ASC"},
        baseParams: {start: 0, limit: 30},
        remoteSort: false,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							fields : [
                {name : 'clienteId', type : 'string', allowBlank : false},
                {name : 'clienteNombre', type : 'string', allowBlank : false},
                {name : 'efectivoDesde', type : 'date', dateFormat : 'Y-m-d H:i:s', allowBlank : false},
                {name : 'piezaId', type : 'string', allowBlank : false },
                {name : 'piezaNombre', type : 'string', allowBlank : false }, 
                {name : 'precio', type : 'float', allowBlank : false}
							]
						}),
				autoDestroy : true
			}),
  		columns : [
        {header : 'Artículo', dataIndex : 'piezaNombre', hidden: true, groupable: true},
        {header : 'Cliente', dataIndex : 'clienteNombre', width : 160, sortable : false, groupable: false},
        {header : 'Precio', dataIndex : 'precio', width : 60, sortable : false, align: 'right', renderer: Ext.util.Format.usMoney, groupable: false},
        {header : 'Efectivo desde', dataIndex : 'efectivoDesde', width : 90, renderer : Ext.util.Format.dateRenderer('d/m/Y'), groupable: false}
			],
      view: new Ext.grid.GroupingView({
          forceFit:true,
          groupTextTpl: '{text} ({[values.rs.length]} {[values.rs.length > 1 ? "precios" : "precio"]})'
      }),
      
      
			selModel : new Ext.grid.RowSelectionModel({ singleSelect : true }),
      bbar : new Ext.PagingToolbar({
            pageSize : 30,
            displayInfo : true,
//      }),
      listeners : {
        render : {
          scope : this,
          fn : function() {
            var store = this.store;
            var ptool = this.getBottomToolbar();
            ptool.bindStore(store);
          }
        }
      }}),
     
      
		  recarga : function(params) {
				var store = this.getStore();
        store.setBaseParam('start', this.getBottomToolbar().cursor);
        store.setBaseParam('limit', this.getBottomToolbar().pageSize);
        for(i=0; i< params.length; i++){
          var nombre=params[i]['nombre'];
          var valor=params[i]['valor'];
          store.setBaseParam(nombre, valor);
        }
				store.load();
			}


		}, config));
	} //constructor
});

Ext.reg('grillapreciosefectivos', GrillaPreciosEfectivos);