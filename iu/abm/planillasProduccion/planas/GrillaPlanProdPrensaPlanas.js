GrillaPlanProdPrensaPlanas = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
		GrillaPlanProdPrensaPlanas.superclass.constructor.call(this, Ext.apply({
			store : new Ext.data.Store({
				proxy : new Ext.data.HttpProxy({
					url : '/produccion/svc/conector/planillasProduccionCabecera.php/selPlano'
        }),
        remoteSort: true,
        autoLoad: false,
        sortInfo: {
          field: 'fecha',
          direction: 'ASC' 
        },        
				reader : new Ext.data.JsonReader({
					root : 'data',
					totalProperty : 'total',
					fields : [
                     {name : 'empleadoId', type : 'string'},
                     {name : 'empleadoApellido', type : 'string'},
                     {name : 'empleadoNombre', type : 'string'},
                     {name : 'matrizId', type : 'string'},
                     {name : 'matrizNombre', type : 'string'},
                     {name : 'matrizTipo', type : 'string'},
                     {name : 'estacionTrabajo', type : 'string'},
                     {name : 'fecha', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                     {name : 'cantidad', type : 'int'},
                     {name : 'reparada', type : 'int'},
                     {name : 'descartada', type : 'int'},
                     {name : 'observaciones', type : 'string'},
                     {name : 'cantidadTotal', type : 'string'},
							     ]
          }),
        listeners : {
							load : {
								scope : this,
								fn : function() {
									var total = Ext.getCmp('totalPrensadas');
									var store = this.store;
									var ptool = this.getBottomToolbar();
                  if (store.data.items.length>0){
									  total.setValue(store.data.items[0].data.cantidadTotal);
                  }else{
                    total.setValue(0);
                  }
								}
							}
						}             
      }),
      bbar : new Ext.PagingToolbar({
            pageSize : 15,
            displayInfo : true,
            items:[
              {xtype: 'fieldset', itemId: 'camposBarra', border: false, layout: 'form',  
                items:[
                  {fieldLabel: 'Total de prensadas', itemId: 'totalPrensadas', id: 'totalPrensadas', xtype: 'numberfield', width: 60, allowBlank: true, allowDecimals: false, disabled: true}
                ]
              }
            ]
          }),      
			columns : [
        {header : 'Apellido', dataIndex : 'empleadoApellido', width : 90, sortable : false},
        {header : 'Nombre', dataIndex : 'empleadoNombre', width : 90, sortable : false},
        {header : 'Matriz', dataIndex : 'matrizNombre', width : 60, sortable : false},
        {header : 'Tipo', dataIndex : 'matrizTipo', width : 60, sortable : false},
        {header : 'Estación', dataIndex : 'estacionTrabajo', width : 60, sortable : false},
        {header : 'Fecha', dataIndex : 'fecha', width : 90, renderer: Ext.util.Format.dateRenderer('d/m/Y'), sortable : false},
        {header : 'Cantidad', dataIndex : 'cantidad', width : 60, align: 'right', sortable : false},
        {header : 'Reparada', dataIndex:  'reparada', width: 60, renderer:function(value){return (value == 1)?'Sí':'No'}},
        {header : 'Descartada', dataIndex:  'descartada', width: 60, renderer:function(value){return (value == 1)?'Sí':'No'}},
        {header : 'Observaciones', dataIndex:  'observaciones', width : 160, sortable : false}
			],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
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


      recarga : function(params) {
        var store = this.getStore();
        store.setBaseParam('start', this.getBottomToolbar().cursor);
        store.setBaseParam('limit', this.getBottomToolbar().pageSize);
        for(i=0; i< params.length; i++){
          var nombre=params[i]['nombre'];
          var valor=params[i]['valor'];
          store.setBaseParam(nombre, valor);
        }
        store.load();
      },
      
      limpia : function() {
        var store = this.getStore();
        store.removeAll();
      },
      

			obtieneSeleccionado : function() {
				var sm = this.getSelectionModel();
				if (sm.getSelected() != null) {
					return sm.getSelected();
				} else {
					return null;
				}
			}

		}, config));
	} //constructor
});

Ext.reg('grillaplanprodprensaplanas', GrillaPlanProdPrensaPlanas);