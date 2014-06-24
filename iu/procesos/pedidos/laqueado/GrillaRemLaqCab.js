GrillaRemLaqCab = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
	  GrillaRemLaqCab.superclass.constructor.call(this, Ext.apply({
		store : new Ext.data.Store({
			proxy : new Ext.data.HttpProxy({
				url : '/produccion/svc/conector/remitosLaqueado.php/selRemitosCabecera',
		}),
        baseParams: {start: 0, limit: 30},
        remoteSort: false,
        autoLoad: true,
		reader : new Ext.data.JsonReader({
					root : 'data',
					totalProperty : 'total',
					fields : [
                	 {name : 'id', type : 'string', allowBlank : false},
                	 {name : 'laqueadorId', type : 'string', allowBlank : false},
                	 {name : 'laqueadorNombre', type : 'string', allowBlank : false},
                	 {name : 'fechaEnvio', type : 'date', dateFormat : 'Y-m-d H:i:s', allowBlank : false},
                	 {name : 'numero', type : 'int', allowBlank : false},
                     {name : 'estado'}
					]
				  }),
				autoDestroy : true
			}),
		bbar : new Ext.PagingToolbar({
					pageSize : 15,
					displayInfo : true
				}),
  		columns : [
          {header : 'Laqueador', dataIndex : 'laqueadorNombre', hidden: false, groupable: true, width : 100},
          {header : 'Numero', dataIndex : 'numero', width : 60, sortable : false, align : 'right' },
          {header : 'Enviado', dataIndex : 'fechaEnvio', width : 90, renderer : Ext.util.Format.dateRenderer('d/m/Y')},
          {header : 'Estado', dataIndex : 'estado', hidden: false, width: 130}
		],
			selModel : new Ext.grid.RowSelectionModel({
				singleSelect : true,
				listeners: {
					rowselect : {
						scope: this,
						fn : function(sm, rowIdx, r){
							var gridDetalle=Ext.getCmp('grillaRemLaqDet');
							var paginacion = gridDetalle.getBottomToolbar();
							var storeDetalle=gridDetalle.getStore();
							storeDetalle.setBaseParam('cabeceraId', r.id);
							storeDetalle.setBaseParam('start', paginacion.cursor);
							storeDetalle.setBaseParam('limit', paginacion.pageSize);
        					storeDetalle.load();
						}
					}
			   }
			}),
			height : 250,
		    id : 'GrillaRemLaqCab',
			listeners : {
				render : {
					scope : this,
					fn : function() {
						var store = this.store;
						var ptool = this.getBottomToolbar();
						ptool.bindStore(store);
					}
				}
			}




		}, config));
	} //constructor
});

Ext.reg('grillaremlaqcab', GrillaRemLaqCab);