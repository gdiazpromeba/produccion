
function generaPanBusquedaPedidosCab(){
  var panel = new PanelBusquedaAbm({
    id: 'busquedaPedidosCab',
    title: 'Búsqueda',
	prefijo: 'panBusquedaPedidosCab',
	width: 400,
	items: [
	  {fieldLabel: 'Cliente', name: 'clienteComboBusPedCab', id: 'clienteComboBusPedCab', allowBlank: true, width: 220, xtype: 'combo',
        hiddenName: 'clienteIdBusPedCab', hiddenId: 'clienteIdBusPedCab', loadingText: recursosInter.buscando,
		typeAhead: false, forceSelecion: true, store: getDsClientes(), displayField: 'nombre', valueField: 'id',
		minListWidth: 150, pageSize:15, hideTrigger: true,
		tpl: new Ext.XTemplate( '<tpl for="."><div class="search-item">', "<h4>{nombre}</h4>", '</div></tpl>'),
		minChars: 1, itemSelector: 'div.search-item'
	  },
      {fieldLabel: 'Estado', xtype: 'combo', id: 'comboEstadosBusPedCab', name: 'comboEstadosBusPedCab', allowBlank: true,
        store: new Ext.data.SimpleStore({
	 	  fields: ['descripcionEstado'],
		  data: [["Pendiente"],["Completo"],["Cancelado"]]
		}),
        displayField: 'descripcionEstado', valueField: 'descripcionEstado', selectOnFocus: true, mode: 'local', typeAhead: false, editable: false,
        hiddenName: 'pedidoEstado', triggerAction: 'all'
      },
	  {fieldLabel: 'Desde',  itemId: 'fechaDesde', ref: 'fechaDesde', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
	  {fieldLabel: 'Hasta',  itemId: 'fechaHasta', ref: 'fechaHasta', xtype : 'datefield', format: 'd/m/Y', allowBlank : true}

    ],

    getParamsBusqueda: function(){
	  var resultado=new Array();
	  this.agregaClaveValor(resultado, 'clienteId', Ext.get('clienteIdBusPedCab').dom.value);
	  this.agregaClaveValor(resultado, 'pedidoEstado', Ext.getCmp('comboEstadosBusPedCab').getValue());
	  this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
	  this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
      return resultado;
    }

  });
  return panel;
}
