BusquedaEmpleados = Ext.extend(PanelBusquedaAbm, {
	constructor : function(config) {
		BusquedaEmpleados.superclass.constructor.call(this, Ext.apply({
      region: 'west',
      frame: true,
      width: 340,
      items: [
        {fieldLabel: 'Apellido', xtype: 'textfield', itemId: 'apellidoBus', width: 160},
      ],
      
      getParamsBusqueda: function(){
        var resultado=new Array();
        this.agregaClaveValor(resultado, 'empleadoApellido',  this.getComponent('apellidoBus').getValue());
        return resultado;
      }
      
		}, config));
    
	} //constructor
});
