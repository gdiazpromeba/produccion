PanelCostos = Ext.extend(Ext.Panel, {
  constructor : function(config) {
	PanelCostos.superclass.constructor.call(this, Ext.apply({
        title            : 'Costos',
        autoScroll : true,
        layout: 'border',
	   }, config)); //del apply y del constructor.call
    this.on('render', this.disposicion, this);
  }, //constructor
   
  disposicion : function(panel){
  	var busqueda=new PanelBusquedaCostos({
  		height: 40,
  		region: 'north'
  	});
  	var marcoArbol=new MarcoArbolCostos({
  		//width: 200,
  		region: 'center'
  	});
    var panDerecho=new PanelDerecho({
  		width: 800,
  		region: 'east'
  	});
	panel.add(busqueda);
	panel.add(marcoArbol);
	panel.add(panDerecho);
  },
  
});
  
