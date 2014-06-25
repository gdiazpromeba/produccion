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
          idProperty : 'lineaId',
          fields : [
            {name : 'cliente', type : 'string'},
            {name : 'pedidoCabeceraId', type : 'string'},
            {name : 'pedidoNumero', type : 'int'},
            {name : 'importe', type : 'float'}
          ]
        }),
      autoDestroy : false
    });    
    
    SeñasYPendientes.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Terminaciones pendientes, por medida',
        frame:true,
        layout:'border',
        items: [
          {xtype: 'panel', itemId: 'superior', height: 130, layout: 'hbox', region: 'north', 
            layoutConfig: {
             align : 'stretch',
             pack  : 'start'
            },
            items:[
               {xtype: 'grid', flex: 2, frame: true,
                  colModel: new Ext.grid.ColumnModel({
                    columns: [
                      {header: 'Medida', width: 100, dataIndex: 'medidas'},
                      {header: 'Guatambú',  width: 70, align: 'right', dataIndex: 'guatambu'},
                      {header: 'Paraíso',  width: 70, align: 'right', dataIndex: 'paraiso'},
                      {header: 'Otros',  width: 70, align: 'right', dataIndex: 'otros'}
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