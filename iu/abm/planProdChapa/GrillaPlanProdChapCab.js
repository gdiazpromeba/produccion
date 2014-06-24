GrillaPlanProdChapCab = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPlanProdChapCab.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/plPrChapCab.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'plPrChapCabId',
							fields : [
                {name : 'plPrChapCabId', type : 'string'},
                {name : 'planillaFecha', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                {name : 'empleadoId', type : 'string'},
                {name : 'empleadoApellido', type : 'string'},
                {name : 'empleadoNombre', type : 'string'},
                {name : 'tarjetaNumero', type : 'string'},
                {name : 'observacionesCab', type : 'string'}
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'plPrChapCabId', hidden : true},
        {header : 'Fecha', dataIndex : 'planillaFecha', width : 90, sortable : true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
        {header : 'Apellido', dataIndex : 'empleadoApellido', width : 100, sortable : true},
        {header : 'Nombre', dataIndex : 'empleadoNombre', width : 180, sortable : true}
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaPlprChapCabId',
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
        var titulo=registro.get('empleadoApellido') + ', '  + registro.get('empleadoNombre') + ' ' + Ext.util.Format.date(registro.get('planillaFecha'), 'd/m/Y');
        return titulo;
      }

		}, config));
	} //constructor
});
