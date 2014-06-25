SeñasYPendientes = Ext.extend(Ext.Panel, {
  constructor : function(config) {
    
    var storeCompartido= new Ext.data.Store({
      proxy : new Ext.data.HttpProxy({
        url : '/produccion/svc/conector/pedidosCabecera.php/reportePagos'
      }),
      autoLoad: true,
      reader : new Ext.data.JsonReader({
          root : 'data',
          totalProperty : 'total',
          idProperty : 'pedidoCabeceraId',
          fields : [
            {name : 'cliente', type : 'string'},
            {name : 'pedidoCabeceraId', type : 'string'},
            {name : 'pedidoNumero', type : 'int'},
            {name : 'importe', type : 'float'},
            {name : 'pagos', type : 'float'},
            {name : 'pendiente', type : 'float'}
          ]
        }),
      autoDestroy : false
    });    
    
    SeñasYPendientes.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Pedidos y señas',
        frame:true,
        layout:'border',
        items: [
          {xtype: 'panel', itemId: 'superior', height: 130, layout: 'hbox', region: 'center', 
            layoutConfig: {
             align : 'stretch',
             pack  : 'start'
            },
            items:[
               {xtype: 'grid', flex: 2, frame: true,
            	  autoload: true,
      			  bbar : new Ext.PagingToolbar( {
    				pageSize : 20,
    				displayInfo : true
    			  }),            	  
                  colModel: new Ext.grid.ColumnModel({
                    columns: [
                      {header: 'Cliente',  width: 200, dataIndex: 'cliente'},
                      {header: 'Pedido',   width: 70, align: 'right', dataIndex: 'pedidoNumero'},
                      {header: 'Importe',  width: 100, align: 'right', dataIndex: 'importe', renderer: Ext.util.Format.usMoney},
                      {header: 'Pagado',   width: 100, align: 'right', dataIndex: 'pagos', renderer: Ext.util.Format.usMoney},
                      {header: 'Pendiente',   width: 100, align: 'right', dataIndex: 'pendiente', renderer: Ext.util.Format.usMoney},
                    ]
                  }),
                  store: storeCompartido
               }
             ]
           },
      ]
	}, config));
    
   
    
    
	} //constructor
});