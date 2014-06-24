BusquedaOrdenesProduccionCab = Ext.extend(PanelBusquedaAbm, {
	constructor : function(config) {
		BusquedaOrdenesProduccionCab.superclass.constructor.call(this, Ext.apply({
      region: 'west',
      frame: true,
      width: 340,
      items: [
        {fieldLabel: 'Número', xtype: 'numberfield', itemId: 'ordenNumero', allowBlank: true, width: 150},
        {fieldLabel: 'Estado', xtype: 'combo', allowBlank: true, itemId: 'comboEstados', 
          store: new Ext.data.SimpleStore({
            fields: ['descripcionEstado'],
            data: [["Emitida"],["En proceso"],["Completada"],["Escribiéndose"],["Incompleta"]]
          }),
          displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
          hiddenName: 'ordenEstado', triggerAction: 'all'},        
        {fieldLabel: 'Desde',  itemId: 'fechaDesde', ref: 'fechaDesde', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
        {fieldLabel: 'Hasta',  itemId: 'fechaHasta', ref: 'fechaHasta', xtype : 'datefield', format: 'd/m/Y', allowBlank : true}
      ],
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'ordenNumero', this.getComponent('ordenNumero').getValue());
        this.agregaClaveValor(resultado, 'ordenEstado', this.getComponent('comboEstados').getValue());
        this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
        this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
        return resultado;
      }
      
		}, config));
    
	} //constructor
});
