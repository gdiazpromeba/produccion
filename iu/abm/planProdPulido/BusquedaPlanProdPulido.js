BusquedaPlanProdPulidoCab = Ext.extend(PanelBusquedaAbm, {
	constructor : function(config) {
		BusquedaPlanProdPulidoCab.superclass.constructor.call(this, Ext.apply({
      region: 'west',
      frame: true,
      width: 340,
      items: [
        {xtype: 'comboempleados', itemId: 'comboEmpleados', hiddenName: 'empleadoIdBusqueda', hiddenId: 'empleadoIdBusqueda', allowBlank: false, width: 220},
        {fieldLabel: 'Desde',  itemId: 'fechaDesde', ref: 'fechaDesde', xtype : 'datefield', format: 'd/m/Y', allowBlank : true},
        {fieldLabel: 'Hasta',  itemId: 'fechaHasta', ref: 'fechaHasta', xtype : 'datefield', format: 'd/m/Y', allowBlank : true}
      ],
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'empleadoId', Ext.get('empleadoIdBusqueda').dom.value);
        this.agregaClaveValor(resultado, 'fechaDesde', this.getComponent('fechaDesde').getValue());
        this.agregaClaveValor(resultado, 'fechaHasta', this.getComponent('fechaHasta').getValue());
        return resultado;
      }
      
		}, config));
    
	} //constructor
});
