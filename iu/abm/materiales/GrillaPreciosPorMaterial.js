GrillaPreciosPorMaterial = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
	GrillaPreciosPorMaterial.superclass.constructor.call(this, Ext.apply({
          region: 'center',
		  store : new Ext.data.Store({
		    proxy : new Ext.data.HttpProxy({
		      url : '/produccion/svc/conector/preciosPorMaterial.php/selecciona'
              }),
              baseParams: {start: 0, limit: 15},
              remoteSort: true,
              autoLoad: true,
		      reader : new Ext.data.JsonReader({
			    root : 'data',
			    totalProperty : 'total',
			    idProperty : 'id',
			    fields : [
                  {name : 'id', type : 'string'},
                  {name : 'materialId', type : 'string'},
                  {name : 'precio', type : 'float'},
                  {name : 'fecha', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                  {name : 'proveedorId', type : 'string'},
                  {name : 'proveedorNombre', type : 'string'},
                  {name : 'observaciones', type : 'string'}
                ]
			  }),
			  autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
              {header : 'id', dataIndex : 'id', hidden : true},
              {header : 'materialId', dataIndex : 'materialId', hidden : true},
              {header : 'Precio', dataIndex : 'precio', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
              {header : 'Fecha', dataIndex : 'fecha', width : 90, sortable : true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
              {header : 'Proveedor', dataIndex : 'proveedorNombre', width : 160, sortable : true}
            ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		    id : 'grillaPreciosPorMaterial',
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
			}
      
		}, config));
	} //constructor
});
