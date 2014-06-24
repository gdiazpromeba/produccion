MejoresClientesEnMonto = Ext.extend(Ext.Panel, {
  constructor : function(config) {
    
    var storeCompartido= new Ext.data.Store({
      proxy : new Ext.data.HttpProxy({
        url : '/produccion/svc/conector/estadisticas.php/mejoresClientesEnMonto'
      }),
      autoLoad: false,
      reader : new Ext.data.JsonReader({
          root : 'data',
          totalProperty : 'total',
          idProperty : 'ficha',
          fields : [
            {name : 'clienteNombre', type : 'string', allowBlank : false },
            {name : 'montoPedido', type : 'float', allowBlank : false},
            {name : 'montoRemitido', type : 'float', allowBlank : false }
          ]
        }),
      autoDestroy : false
    });    
    
		MejoresClientesEnMonto.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Mejores clientes en monto',
        frame:true,
        width:500,
        height:300,
        layout:'border',
        items: [
          {xtype: 'panel', itemId: 'superior', height: 130, layout: 'hbox', region: 'north', 
            layoutConfig: {
              align : 'stretch',
             pack  : 'start'
            },
            items:[
              {xtype: 'panel', itemId: 'busqueda', flex: 1, layout: 'form',
                items:[
                  {fieldLabel: 'Fecha desde', itemId: 'fechaDesde', xtype: 'datefield', format: 'd/m/Y', allowBlank : false },
                  {fieldLabel: 'Fecha hasta', itemId: 'fechaHasta', xtype: 'datefield', format: 'd/m/Y', allowBlank : false },
                  {fieldLabel: 'Clientes a mostrar',  itemId: 'cuantos',  xtype: 'spinnerfield', width: 45, value: 8, minValue: 1, maxValue: 10, allowDecimals: false, accelerate: false}
                ],
                buttons:[
                  {text:'Buscar', itemId: 'botBuscar', ref: 'botBuscar', 
                    listeners: {
                      scope: this,
                      'click' : function(){
                        var store=this.getComponent("grafico").store;
                        var busqueda=this.getComponent('superior').getComponent('busqueda');
                        store.setBaseParam('fechaDesde', busqueda.getComponent('fechaDesde').getValue());
                        store.setBaseParam('fechaHasta', busqueda.getComponent('fechaHasta').getValue());
                        store.setBaseParam('cuantos', busqueda.getComponent('cuantos').getValue());
                        store.load(); 
                      }
                    }
                  }
                ]
               },
               {xtype: 'grid', flex: 2, frame: true,
                  colModel: new Ext.grid.ColumnModel({
                    columns: [
                      {header: 'Cliente', width: 200, sortable: false, dataIndex: 'clienteNombre'},
                      {header: 'Monto pedido',  renderer: Ext.util.Format.usMoney, align: 'right', dataIndex: 'montoPedido'},
                      {header: 'Monto remitido',  renderer: Ext.util.Format.usMoney, align: 'right', dataIndex: 'montoRemitido'}
                    ]
                  }),
                  store: storeCompartido
               }
             ]
           },
           {xtype: 'columnchart', region: 'center',  itemId: 'grafico',
            url : recursosInter.CHART_URL,
            store: storeCompartido,
            xField: 'clienteNombre',
            yAxis: new Ext.chart.NumericAxis({
                displayName: 'Monto',
                labelRenderer : Ext.util.Format.numberRenderer('0,0')
            }),
            tipRenderer : function(chart, record, index, series){
                if(series.yField == 'montoPedido'){
                    return Ext.util.Format.number(record.data.montoPedido, '0,0') + ' pedido por  ' + record.data.clienteNombre;
                }else{
                    return Ext.util.Format.number(record.data.montoRemitido, '0,0') + ' remitido a ' + record.data.clienteNombre;
                }
            },
            chartStyle: {
                padding: 10, 
                animationEnabled: true,
                font: {name: 'Tahoma', color: 0x444444, size: 11 },
                dataTip: {
                    padding: 5,
                    border: {color: 0x99bbe8, size:1 },
                    background: {color: 0xDAE7F6, alpha: .9 },
                    font: { name: 'Tahoma', color: 0x15428B, size: 10, bold: true}
                },
                xAxis: {
                    color: 0x69aBc8,
                    majorTicks: {color: 0x69aBc8, length: 4},
                    minorTicks: {color: 0x69aBc8, length: 2},
                    majorGridLines: {size: 1, color: 0xeeeeee}
                },
                yAxis: {
                    color: 0x69aBc8,
                    majorTicks: {color: 0x69aBc8, length: 4},
                    minorTicks: {color: 0x69aBc8, length: 2},
                    majorGridLines: {size: 1, color: 0xdfe8f6}
                }
            },
            series: [{
                type: 'column', displayName: 'Pedido', yField: 'montoPedido',
                style: {mode: 'stretch', color:0x99BBE8}
            },{
                type:'column', displayName: 'Remitido', yField: 'montoRemitido',
                style: {color: 0x15428B }
            }]
            

        }]


		}, config));
    
   
    
    
	} //constructor
});