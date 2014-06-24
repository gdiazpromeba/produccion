PanelPedidosPlanos = Ext.extend(Ext.Panel, {
  constructor : function(config) {
		PanelPedidosPlanos.superclass.constructor.call(this, Ext.apply({
      layout: 'border',
      items: [
        {itemId: 'busqueda', xtype: 'busquedapedidosplanos', region: 'north'},
        {itemId: 'grilla', xtype: 'grillapedidosplanos', region: 'center'}
      ]


		}, config));
    
    var busqueda=this.getComponent('busqueda');
    var grilla=this.getComponent('grilla');
    
    busqueda.on('buscar pulsado', function(){
      var params=busqueda.getParamsBusqueda();
      grilla.recarga(params);  
    });
    
    busqueda.on('reinicializar pulsado', function(){
      grilla.getStore().baseParams=[];
      var params=[];
      grilla.recarga(params);
    });
    
    
	} //constructor
});