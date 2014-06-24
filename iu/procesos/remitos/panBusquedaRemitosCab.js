
function generaPanBusquedaRemitosCab(){
  var panel = new PanelBusquedaAbm({
    id: 'busquedaRemitosCab',  
    title: 'Búsqueda',
	prefijo: 'panBusquedaRemitosCab',
	width: 400,
	items: [
    {xtype: 'comboclientes', itemId: 'clienteCombo', hiddenName: 'clienteIdBusRemCab', hiddenId: 'clienteIdBusRemCab'},
    {fieldLabel: 'Estado', xtype: 'combo', id: 'comboEstadosBusRemCab', name: 'comboEstadosBusRemCab', allowBlank: true, 
	    store: new Ext.data.SimpleStore({
		  fields: ['descripcionEstado'],
		  data: [["Válida"],["Inválida"]]
		  }),
        displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
        hiddenName: 'remitoEstado', triggerAction: 'all'
      },
      {fieldLabel: 'Número', itemId: 'remitoNumero', allowBlank: true, xtype: 'numberfield', allowDecimals: false},
	  {fieldLabel: 'Desde',  itemId: 'fechaDesde', ref: 'fechaDesde', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
	  {fieldLabel: 'Hasta',  itemId: 'fechaHasta', ref: 'fechaHasta', xtype : 'datefield', format: 'd/m/Y', allowBlank : true}
	  
    ],
    
    getParamsBusqueda: function(){
	    var resultado=new Array();
	    this.agregaClaveValor(resultado, 'remitoNumero', this.getComponent('remitoNumero').getValue());
	    this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
	    this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
      this.agregaClaveValor(resultado, 'clienteId', Ext.get('clienteIdBusRemCab').dom.value);
      this.agregaClaveValor(resultado, 'remitoEstado', Ext.getCmp('comboEstadosBusRemCab').getValue());
      return resultado;
    }    
    
  });
  return panel;
}
