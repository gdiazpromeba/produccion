BusquedaFacturasCab = Ext.extend(PanelBusquedaAbm, {
	constructor : function(config) {
	  BusquedaFacturasCab.superclass.constructor.call(this, Ext.apply({
      region: 'west',
      frame: true,
      items: [
        {xtype: 'comboclientes', itemId: 'comboClientes', hiddenName: 'clienteIdBusCabFac', hiddenId: 'clienteIdBusCabFac', allowBlank: false, width: 220},
        {fieldLabel: 'Desde',  itemId: 'fechaDesdeBusCabFac', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
        {fieldLabel: 'Hasta',  itemId: 'fechaHastaBusCabFac', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
        {fieldLabel: 'Estado', xtype: 'combo', id: 'comboEstadosBusFacCab', name: 'comboEstadosBusFacCab', allowBlank: true, 
    	    store: new Ext.data.SimpleStore({
    		  fields: ['descripcionEstado'],
    		  data: [["Válida"],["Inválida"]]
    		  }),
            displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
            hiddenName: 'facturaEstado', triggerAction: 'all'
          },
          {fieldLabel: 'Tipo', xtype: 'combo', id: 'comboTiposBusFacCab', name: 'comboTiposBusFacCab', itemId: 'comboTiposBusFacCab', 
        	                   width: 70, ref: '../comboTiposBusFacCab', allowBlank: false, 
	            store: new Ext.data.SimpleStore({
	              fields: ['facturaTipo'],
	    	        data: [["A"],["B"],["NC"],["ND"]]
	    	      }),
                displayField: 'facturaTipo', valueField: 'facturaTipo', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
                hiddenName: 'facturaTipo', triggerAction: 'all',
          }

      ],
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'clienteIdBusCabFac', Ext.get('clienteIdBusCabFac').dom.value);
        this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesdeBusCabFac').getValue());
        this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHastaBusCabFac').getValue());
        this.agregaClaveValor(resultado, 'facturaEstado', this.getComponent('comboEstadosBusFacCab').getValue());
        this.agregaClaveValor(resultado, 'tipo', this.getComponent('comboTiposBusFacCab').getValue());
        return resultado;
      }
      
		}, config));
    
	} //constructor
});
