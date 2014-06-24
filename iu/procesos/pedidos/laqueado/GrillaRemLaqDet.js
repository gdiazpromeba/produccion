GrillaRemLaqDet = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaRemLaqDet.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.GroupingStore({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/remitosLaqueado.php/selRemitosDetalle',
          method: 'post'
        }),
        baseParams: {start: 0, limit: 30},
        remoteSort: false,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
				  root : 'data',
				  totalProperty : 'total',
				  fields : [
                    {name : 'id', type : 'string', allowBlank : false},
                    {name : 'item', type : 'int', allowBlank : false},
                    {name : 'clienteNombre', type : 'string', allowBlank : false},
                    {name : 'piezaNombre', type : 'string', allowBlank : false },
                    {name : 'terminacionNombre', type : 'string', allowBlank : false },
                    {name : 'cantidad', type : 'int', allowBlank : false}
				   ]
				}),
				autoDestroy : true
			}),
  		columns : [
  		  {header : 'Item', dataIndex : 'item', width : 30, sortable : false, align : 'right' },
  		  {header : 'Cliente', dataIndex : 'clienteNombre', width : 150, sortable : false},
  		  {header : 'Cantidad', dataIndex : 'cantidad', width : 30, sortable : false, align : 'right' },
          {header : 'Artículo', dataIndex : 'piezaNombre', hidden: false, width : 150},
          {header : 'Terminacion', dataIndex : 'terminacionNombre', hidden: false}
	    ],


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





		}, config));
	} //constructor
});

Ext.reg('grillaremlaqdet', GrillaRemLaqDet);