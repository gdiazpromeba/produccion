GrillaOrdenesTerminacionCab = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaOrdenesTerminacionCab.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/ordenTermCabecera.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'ordTermCabId',
							fields : [
                {name : 'ordTermCabId', type : 'string'},
                {name : 'ordenNumero', type : 'int'},
                {name : 'ordenEstado', type : 'string'},
                {name : 'ordenFecha', type : 'date', dateFormat: 'Y-m-d H:i:s'}
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'ordTermCabId', hidden : true},
        {header : 'Número', dataIndex : 'ordenNumero', width : 100, sortable : true},
        {header : 'Estado', dataIndex : 'ordenEstado', width : 180, sortable : true},
        {header : 'Fecha', dataIndex : 'ordenFecha', width : 90, sortable : true, renderer: Ext.util.Format.dateRenderer('d/m/Y')}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaOrdTermCab',
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
        var titulo=registro.get('ordenNumero') + + Ext.util.Format.date(registro.get('ordenFecha'), 'd/m/Y');
        return titulo;
      }

		}, config));
	} //constructor
});
