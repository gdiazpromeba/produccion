GrillaPlanProdPulidoDet = Ext.extend(Grilla, {
	constructor : function(config) {
	  GrillaPlanProdPulidoDet.superclass.constructor.call(this, Ext.apply({
		store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/planProdPulidoDetalle.php/selecciona'
        }),
        baseParams: {start: 0, limit: 15},
        remoteSort: true,
        autoLoad: true,
				reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'planProdPulidoDetId',
							fields : [
                {name : 'planProdPulidoDetId', type : 'string'},
                {name : 'planProdPulidoCabId', type : 'string'},
                {name : 'fichaId', type : 'string'},
                {name : 'piezaFicha', type : 'string'},
                {name : 'cantidad', type : 'int'},
                {name : 'terminacion', type : 'string'},
                {name : 'reparada', type : 'bool'},
                {name : 'pulido', type : 'pulido'},
                {name : 'tupi', type : 'tupi'},
                {name : 'lijadoCantos', type : 'lijadoCantos'},
                {name : 'descartada', type : 'bool'},
                {name : 'aTapizar', type : 'bool'},
                {name : 'aMini', type : 'bool'},
                {name : 'observacionesDet', type : 'string'}
              ]
						}),
				autoDestroy : true
		}),
		columns : [
          {header : 'planProdPulidoDetId', dataIndex : 'planProdPulidoDetId', hidden : true},
          {header : 'planProdPulidoCabId', dataIndex : 'planProdPulidoCabId', hidden : true},
          {header : 'fichaId', dataIndex : 'fichaId', hidden : true},
          {header : 'Cantidad', dataIndex : 'cantidad', width: 80},
          {header : 'Ficha', dataIndex:  'piezaFicha', width: 80},
          {header : 'Terminación', dataIndex : 'terminacion', width: 80},
          {header : 'Reparadas', dataIndex:  'reparada', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'Pulido', dataIndex:  'pulido', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'Tupí', dataIndex:  'tupi', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'Lijado de cantos', dataIndex:  'lijadoCantos', width: 100, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'Descartadas', dataIndex:  'descartada', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'A Tapizar', dataIndex:  'aTapizar', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'A Mini', dataIndex:  'aMini', width: 60, renderer:function(value){return (value == 1)?'Sí':'No';}},
          {header : 'Observaciones', dataIndex: 'observacionesDet', width: 450, type : 'string'}
        ],
		height : 320,
		id : 'grillaPlanProdPulidoDet'
      
	  }, config));
	} //constructor
});
