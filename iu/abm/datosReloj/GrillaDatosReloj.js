GrillaDatosReloj = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaEmpleados.superclass.constructor.call(this, Ext.apply({
		  region: 'center',
		  store : new Ext.data.Store({
		  proxy : new Ext.data.HttpProxy({
		    url : '/produccion/svc/conector/datosReloj.php/selecciona'
          }),
        baseParams: {start: 0, limit: 15},
        remoteSort: false,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'id',
							fields : [
                {name : 'id', type : 'string'},
                {name : 'empleadoId', type : 'string'},
                {name : 'empleadoNombre', type : 'string'},
                {name : 'empleadoApellido', type : 'string'},
                {name : 'tarjetaNumero', type : 'string'},
                {name : 'lecturaFechaHora', type : 'date', dateFormat: 'Y-m-d H:i:s'}
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
        {header : 'Apellido', dataIndex : 'empleadoApellido', width : 160, sortable : true},
        {header : 'Nombre', dataIndex : 'empleadoNombre', width : 160, sortable : true},
        {header : 'Fecha', dataIndex : 'lecturaFechaHora', width : 90, sortable : true, 
        	renderer: 
        	  function (value) {
        	    return FechaUtils.extraeCadenaFecha(value); 
             }
        },
        {header : 'Hora', dataIndex : 'lecturaFechaHora', width : 90, sortable : true, 
        	renderer: 
        	  function (value) {
        	    return FechaUtils.extraeCadenaHora(value);             
        	  }
        }
      ],
	  selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
        }),
	  height : 250,
	  id : 'grillaDatosRelojId',
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
