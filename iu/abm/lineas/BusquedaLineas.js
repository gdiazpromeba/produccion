BusquedaLineas = Ext.extend(PanelBusquedaAbm, {
	constructor : function(config) {
		BusquedaLineas.superclass.constructor.call(this, Ext.apply({
      region: 'west',
      frame: true,
      width: 340,
      items: [
        {fieldLabel: 'Nombre (o parte)', xtype: 'textfield', itemId: 'lineaDescripcion', allowBlank: true, width: 150},
        {fieldLabel: 'Observaciones', xtype: 'textfield', itemId: 'observaciones', allowBlank: true, width: 80}
      ],
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'lineaDescripcion', this.getComponent('lineaDescripcion').getValue());
        this.agregaClaveValor(resultado, 'observaciones', this.getComponent('observaciones').getValue());
        return resultado;
      }
      
		}, config));
    
	} //constructor
});
