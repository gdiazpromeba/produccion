GrillaComunicacionesPreciosCabecera = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaComunicacionesPreciosCabecera.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/comunicacionesPreciosCabecera.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
        sortInfo: {
          field: 'fecha',
          direction: 'DESC' 
        },        
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'comPrecCabId',
							fields : [
                {name : 'comPrecCabId', type : 'string', allowBlank : false },
                {name : 'fecha', type : 'date', allowBlank : false, dateFormat : 'Y-m-d H:i:s' },
                {name : 'clienteId', type : 'string', allowBlank : false },
                {name : 'clienteNombre', type : 'string', allowBlank : false },
                {name : 'destinatario', type : 'string'},
                {name : 'autorizadorId', type : 'string', allowBlank : false },
                {name : 'autorizadorNombre', type : 'string', allowBlank : false },
                {name : 'metodoEnvio', type : 'string', allowBlank : false }
              ]
						}),
				autoDestroy : true
			}),
			bbar : new Ext.PagingToolbar({
						pageSize : 15,
						displayInfo : true
					}),
			columns : [
        {header : 'id', dataIndex : 'comPrecCabId', hidden : true},
        {header : 'Cliente', dataIndex : 'clienteNombre', width : 150, sortable : true},
        {header : 'Destinatario', dataIndex : 'destinatario', width : 110, sortable : true},
        {header : 'Fecha', dataIndex : 'fecha', width : 85, sortable : true, renderer : Ext.util.Format.dateRenderer('d/m/Y')},
        {header : 'Autorizado por', dataIndex : 'autorizadorNombre', width : 170, sortable : false },
        {header : 'Método de envío', dataIndex : 'metodoEnvio', width : 250, sortable : false, 
          renderer: function(v) {return Ext.util.Format.substr(v, 0, 200);}
        }
      ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		  id : 'grillaComunicacionesPreciosCabecera',
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
        var titulo=registro.get('clienteNombre') + ' - ' + Ext.util.Format.date(registro.get('fecha'), 'd/m/Y');
        return titulo;
      }

		}, config));
	} //constructor
});

Ext.reg('grillacompreccab', GrillaComunicacionesPreciosCabecera);