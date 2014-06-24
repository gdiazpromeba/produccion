TerminacionesPendientes = Ext.extend(Ext.Panel, {
  constructor : function(config) {
    
    var storeCompartido= new Ext.data.Store({
      proxy : new Ext.data.HttpProxy({
        url : '/produccion/svc/conector/pedidosDetalle.php/reportePendientesPorTerminacion'
      }),
      autoLoad: true,
      reader : new Ext.data.JsonReader({
          root : 'data',
          totalProperty : 'total',
          idProperty : 'lineaId',
          fields : [
            {name : 'medidas', type : 'string'},
            {name : 'paraiso', type : 'int'},
            {name : 'guatambu', type : 'int'},
            {name : 'otros', type : 'int'}
          ]
        }),
      autoDestroy : false
    });    
    
		TerminacionesPendientes.superclass.constructor.call(this, Ext.apply({
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
           {xtype: 'stackedbarchart', region: 'center',  itemId: 'grafico',
             url : recursosInter.CHART_URL,
             store: storeCompartido,
             yField: 'medidas',
             xAxis: new Ext.chart.NumericAxis({
               displayName: 'Unidades pendientes',
               stackingEnabled: true,
               labelRenderer : Ext.util.Format.numberRenderer('0,0')
            }),
            tipRenderer : function(chart, record, index, series){
                if(series.xField == 'guatambu'){
                    return Ext.util.Format.number(record.data.guatambu, '0,0');
                }else  if(series.xField == 'paraiso'){
                    return Ext.util.Format.number(record.data.paraiso, '0,0');
                }else if(series.xField == 'otros'){
                    return Ext.util.Format.number(record.data.otros, '0,0');
                }
            },
            chartStyle: {
//                padding: 10, 
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
                xField: 'guatambu',
                displayName: 'Guatambú',
                style: {color:0xffcc33}
            },{
                xField: 'paraiso',
                displayName: 'Paraíso',
                style: {color:0xcc6633}
            },{
                xField: 'otros',
                displayName: 'Otros',
                style: {color:0x660000}
            }]

            

        }
      ],
      buttons:[
        {text:'Imprimir todos', itemId: 'botImprimirEnchapados', ref: 'botImprimirEnchapados', scope: this, 
                listeners: {
                  click: function(boton, evento){
                    Ext.Ajax.request({
                    url:  '/produccion/svc/conector/pedidosDetalle.php/reporteTerminacionesPorLineaHTML',
                    method: 'POST',
                    params: {},
                    failure: function (response, options) {
                      Ext.Msg.show({ title:'Terminaciones pendientes', msg: 'Error de red o base de datos', buttons: Ext.Msg.OK});
                    },
                    success: function (response, options) {
                        var html=response.responseText;
                        var win=window.open('', 'Terminaciones pendientes', "dependent=true, height = 800, width = 400, resizable = yes, menubar=yes");
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