PanelBusquedaCostos = Ext.extend(Ext.Panel, {
	constructor : function(config) {
	PanelBusquedaCostos.superclass.constructor.call(this, Ext.apply({
        //autoScroll : true,
        frame: true,
        layout: 'form',
		items: [
	          {fieldLabel: 'Artículo',   xtype: 'combopiezas', itemId: 'piezaCombo', hiddenName: 'piezaIdBusquedaCostos', hiddenId: 'piezaIdBusquedaCostos', listeners: {
	              scope: this,
	              'select' : function(combo, registro, indice){
	 	    	         var arbol=Ext.getCmp('arbolCostos');
	 	    	         var cargadorArbol=arbol.getLoader();
	 	    	         cargadorArbol.baseParams.piezaId=registro.json['piezaId'];
	 	    	         arbol.getRootNode().reload();
	 	    	         arbol.expandAll();
	 	            }
	            }
	         }
		 ]
	   }, config)); //del apply y del constructor.call
  } //constructor
});