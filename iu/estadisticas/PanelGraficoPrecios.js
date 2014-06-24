PanelGraficoPrecios = Ext.extend(Ext.Panel, {
  constructor : function(config) {
    
    var storePrecios= new Ext.data.Store({
      proxy : new Ext.data.HttpProxy({
        url : '/produccion/svc/conector/estadisticas.php/precios'
      }),
      autoLoad: false,
      reader : new Ext.data.JsonReader({
          root : 'data',
          totalProperty : 'total',
          idProperty : 'mes',
          fields : [
            {name : 'mes', type : 'string', allowBlank : false },
            {name : 'precio', type : 'float', allowBlank : false},
            {name : 'precioMenosInflacion', type : 'float', allowBlank : false }
          ]
        }),
      autoDestroy : false
    });    
    
	PanelGraficoPrecios.superclass.constructor.call(this, Ext.apply({
        iconCls:'chart',
        title: 'Precio',
        frame:true,
        layout:'border',
        items: [
          {xtype: 'panel', itemId: 'superior', height: 160, layout: 'hbox', region: 'north', 
            layoutConfig: {
              align : 'stretch',
              pack  : 'start'
            },
            items:[
              {xtype: 'panel', itemId: 'busqueda', flex: 1.8, layout: 'form',
                items:[
                  {fieldLabel: 'Fecha desde', itemId: 'fechaDesde', xtype: 'datefield', format: 'd/m/Y', allowBlank : false },
                  {fieldLabel: 'Fecha hasta', itemId: 'fechaHasta', xtype: 'datefield', format: 'd/m/Y', allowBlank : false },
                  {fieldLabel: 'Artículo',    xtype: 'combopiezas', id: 'pieza', name: 'pieza' , itemId: 'pieza', hiddenName: 'piezaIdBusPrecios', hiddenId: 'piezaIdBusPrecios'}
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
                        store.setBaseParam('piezaId', Ext.get('piezaIdBusPrecios').getValue());
                        store.load(); 
                      }
                    }
                  }
                ]
               },
               {xtype: 'grid', flex: 1.3, frame: true,
                  colModel: new Ext.grid.ColumnModel({
                    columns: [
                      {header: 'Mes', width: 100, sortable: false, dataIndex: 'mes'},
                      {header: 'Precio', renderer: Ext.util.Format.usMoney, align: 'right', dataIndex: 'precio'},
                      {header: 'Precio Corregido', renderer: Ext.util.Format.usMoney, align: 'right', dataIndex: 'precioMenosInflacion'}
                    ]
                  }),
                  store: storePrecios
               }
             ]
           },
           {xtype: 'columnchart', region: 'center',  itemId: 'grafico',
            url : recursosInter.CHART_URL,
            store: storePrecios,
            xField: 'mes',
            yAxis: new Ext.chart.NumericAxis({
                displayName: 'Precios',
                labelRenderer : Ext.util.Format.numberRenderer('0,0')
            }),
            tipRenderer : function(chart, record, index, series){
                if(series.yField == 'precio'){
                    return Ext.util.Format.number(record.data.precio, '0,0') + ' en ' + record.data.mes;
                }else{
                    return Ext.util.Format.number(record.data.precioMenosInflacion, '0,0') + ' corregido en ' + record.data.mes;
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
                type: 'line', displayName: 'Precio', yField: 'precio', style: {mode: 'stretch', color:0x99BBE8}
            },{
                type:'line', displayName: 'Corregido', yField: 'precioMenosInflacion', style: {color: 0x15428B }
            }]
            

        }]


		}, config));
    
    
	} //constructor
});