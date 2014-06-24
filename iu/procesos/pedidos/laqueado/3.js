PantallaRemitosLaqueado = Ext.extend(Ext.Panel, {
  constructor : function(config) {

    var storeCompartido= new Ext.data.Store({
      proxy : new Ext.data.HttpProxy({
        url : '/produccion/svc/conector/pedidosDetalle.php/reportePendientesPorLinea'
      }),
      autoLoad: true,
      reader : new Ext.data.JsonReader({
          root : 'data',
          totalProperty : 'total',
          idProperty : 'lineaId',
          fields : [
            {name : 'lineaId', type : 'string'},
            {name : 'lineaDescripcion', type : 'string'},
            {name : 'cantidadPendiente', type : 'float'}
          ]
        }),
      autoDestroy : false
    });

		PantallaRemitosLaqueado.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Unidades pendientes, por línea',
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
                      {header: 'Línea', width: 600, dataIndex: 'lineaDescripcion'},
                      {header: 'Pendientes',  width: 50, align: 'right', dataIndex: 'cantidadPendiente'}
                    ]
                  }),
                  store: storeCompartido
               }
             ]
           },
           {xtype: 'stackedbarchart', region: 'center',  itemId: 'grafico',
             url : recursosInter.CHART_URL,
             store: storeCompartido,
             yField: 'lineaDescripcion',
             xAxis: new Ext.chart.NumericAxis({
               displayName: 'Unidades pendientes',
               labelRenderer : Ext.util.Format.numberRenderer('0,0')
            }),
            tipRenderer : function(chart, record, index, series){
                if(series.xField == 'cantidadPendiente'){
                    return Ext.util.Format.number(record.data.cantidadPendiente, '0,0') + ' pendientes de la línea ' + record.data.lineaDescripcion;
                }
            },
            chartStyle: {
                animationEnabled: true,
                font: {name: 'Tahoma', color: 0x444444, size: 11 },
                dataTip: {
                    padding: 5,
                    border: {color: 0x99bbe8, size:1 },
                    background: {color: 0xDAE7F6, alpha: .9 },
                    font: { name: 'Tahoma', color: 0x15428B, size: 10, bold: true}
                }
            },
            series: [{
                displayName: 'Pendiente', xField: 'cantidadPendiente'
            }
            ]


        }
      ],
      buttons:[
        {text:'Imprimir todo', itemId: 'botImprimirUnidades', ref: 'botImprimirUnidades', scope: this,
                listeners: {
                  click: function(boton, evento){
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/pedidosDetalle.php/reportePendientesPorLineaHTML',
                    method: 'POST',
                    params: {},
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Impresión de pedidos pendientes', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        var html=response.responseText;
                        var win=window.open('', 'Pedidos pendientes', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
                        win.document.write(html);
                        win.document.close();
                        win.focus();
                        win.print();
                    }
                  });
                }
             }
        }
      ]
		}, config));




	} //constructor
});