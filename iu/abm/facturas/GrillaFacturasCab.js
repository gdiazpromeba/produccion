GrillaFacturasCab = Ext.extend(Ext.grid.GridPanel, {
	constructor : function(config) {
	  GrillaFacturasCab.superclass.constructor.call(this, Ext.apply({
      region: 'center',
			store : new Ext.data.Store({
			  proxy : new Ext.data.HttpProxy({
			    url : '/produccion/svc/conector/facturasCabecera.php/selecciona'
              }),
              baseParams: {start: 0, limit: 15},
              remoteSort: true,
              autoLoad: false,
			  reader : new Ext.data.JsonReader({
							root : 'data',
							totalProperty : 'total',
							idProperty : 'facturaCabId',
							fields : [
                              {name : 'facturaCabId', type : 'string'},
                              {name : 'facturaFecha', type : 'date', dateFormat: 'Y-m-d H:i:s'},
                              {name : 'clienteId', type : 'string'},
                              {name : 'remitoNumero', type : 'int'},
                              {name : 'clienteNombre', type : 'string'},
                              {name : 'facturaNumero', type : 'int'},
                              {name : 'subtotal', type: 'float', allowBlank: false},
                              {name : 'facturaTipo', type: 'string'},
                              {name : 'ivaInscripto', type: 'float', allowBlank: true},
                              {name : 'descuento', type: 'float', allowBlank: true},
                              {name : 'observacionesCab', type: 'string'},
                              {name : 'estado', type: 'string'},
                              {name : 'facturaTotal', type: 'float', allowBlank: false},
                              {name : 'subtotalGeneral', type: 'float', allowBlank: false}
                            ]
			    }),
				autoDestroy : true,
				listeners : {
  				  load : {
  		            scope : this,
  		            fn : function() {
  		              var total=Ext.getCmp('totalGeneralSinIva');
  		              var store = this.store;
  		              var ptool = this.getBottomToolbar();
  		              if (store.data.items.length>0){
  		                total.setValue(store.data.items[0].data.subtotalGeneral);
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
	                  {fieldLabel: 'Total General sin IVA', itemId: 'totalGeneralSinIva', id: 'totalGeneralSinIva', xtype: 'dinero', width: 80, allowBlank: true, disabled: true}
	                ]
	            }
	          ]
	        }),					
			columns : [
	          {header : 'id', dataIndex : 'facturaCabId', hidden : true},
	          {header : 'Número', dataIndex : 'facturaNumero', width : 100, sortable : true},
	          {header : 'Fecha', dataIndex : 'facturaFecha', width : 90, sortable : true, renderer: Ext.util.Format.dateRenderer('d/m/Y')},
	          {header : 'Cliente', dataIndex : 'clienteNombre', width : 200, sortable : true},
	          {header : 'Estado', dataIndex : 'estado', width : 90, sortable : true},
	          {header : 'Subtotal', dataIndex : 'subtotal', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
	          {header : 'Total', dataIndex : 'facturaTotal', width: 80, sortable: true, align: 'right', renderer: Ext.util.Format.usMoney},
	          {header : 'Tipo', dataIndex : 'facturaTipo', width: 80, sortable: true}
	        ],
			selModel : new Ext.grid.RowSelectionModel({
						singleSelect : true
					}),
			height : 250,
		    id : 'grillaFacturaCab',
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

	  	    obtieneSeleccionado : function() {
				var sm = this.getSelectionModel();
				if (sm.getSelected() != null) {
					return sm.getSelected();
				} else {
					return null;
				}
			},
      
            tituloHijo : function (){
            var registro=this.obtieneSeleccionado();
            var titulo=registro.get('clienteNombre')  +  registro.get('facturaNumero') + ' ' + Ext.util.Format.date(registro.get('facturaFecha'), 'd/m/Y');
            return titulo;
      }

		}, config));
	} //constructor
});
