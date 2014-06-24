PanelDerecho = Ext.extend(Ext.Panel, {
  constructor : function(config) {
	PanelDerecho.superclass.constructor.call(this, Ext.apply({
        autoScroll : true,
        layout: 'border',
        layoutConfig: {
          align : 'stretch',
          pack  : 'start'
        }
	   }, config)); //del apply y del constructor.call
    this.on('render', this.disposicion, this);
  }, //constructor
   
  disposicion : function(panel){
  	
  	var sumario=new PanelValorInsumos({
  		region: 'center',
  		id: 'panelValorInsumos'
  	});
    var marcoHojas=new MarcoPanelHojas({
  		region: 'north',
  		height: 250
  	});
	panel.add(marcoHojas);
	panel.add(sumario);
  },
  
});
  
