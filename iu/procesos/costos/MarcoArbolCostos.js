MarcoArbolCostos = Ext.extend(Ext.Panel, {
  constructor : function(config) {
	MarcoArbolCostos.superclass.constructor.call(this, Ext.apply({
        title            : 'Lista de insumos',
        id: 'marcoCostos',
        autoScroll : true,
        layout: 'border',
	    buttons:[
	   	        {text: 'Subir', id: 'botSubir', handler: this.pulsoSubir, scope: this},
	   	        {text: 'Bajar', id: 'botBajar', handler: this.pulsoBajar, scope: this}
	   	 ]        
	   }, config)); //del apply y del constructor.call
    this.on('render', this.disposicion, this);
  }, //constructor
   
  disposicion : function(panel){
	 var arbol=new PanelArbolCostos({
		 region: 'center',
		 id : 'arbolCostos', 
		 name: 'arbolCostos',
		 itemId: 'arbolCostos'
	 });
	 /*
	 var botones=new Ext.Panel({
		  id: 'panelBotonesHojasCostos',
		  prefijo: 'panelBotonesHojasCostos',
		  height: 80,
		  frame: true,
		  region: 'south',
	      buttons:[
	   	        {text: 'Subir', id: 'botSubir', handler: panel.pulsoSubir, scope: panel},
	   	        {text: 'Bajar', id: 'botBajar', handler: panel.pulsoBajar, scope: panel}
	   	      ],
	  });
	  * */
	 panel.add(arbol);
	 //panel.add(botones);
  },
  
  escribeOrdenCorregido : function (nodoPadre){
    var arrIndices=new Array();
    var conn = new Ext.data.Connection();
    conn.extraParams=new Object;
    for (var i=0; i<nodoPadre.childNodes.length; i++){
      var nodoHijo=nodoPadre.item(i);	
      arrIndices[nodoHijo.id]=i;
      conn.extraParams[nodoHijo.id]=i;
    }
	conn.request({
	    url: '/prototipo/svc/conector/proyectos/corrigeIndices',
	    method: 'POST',
 	    //params: Ext.util.JSON.encode(arrIndices),
	    success: function(response, options) {
		  //sería mejor si las funciones "pulsoSubir" y "pulsoBajar" fueran llamadas
		  //desde aquí, sólo si la operación de base de datos fuere exitosa, y no a la inversa,
		  //porque la escritura de BD podría fallar, y entonces el árbol quedaría en 
		  //un estado incosnsistente con ella
	    },
	     failure: function(response, options) {
	    	var exito=Ext.util.JSON.decode(response.responseText);
	        mensaje="Error al reindexar los nodos. <br/>";
	        mensaje+='El mensaje devuelto por el servidor es: <br/>';
	        mensaje+=exito.errors;
	        Ext.MessageBox.show({
	 	       title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
	 	       icon: Ext.MessageBox.ERROR });    			    	
	     }
	});    
  },
   
   
  pulsoSubir : function (panel){
	  var piezaId=Ext.get('piezaIdBusquedaCostos').dom.value;
	  if (piezaId == undefined || piezaId==''){
		Ext.Msg.alert('Subir nodo', 'No hay una pieza activa');
		return;
	  }	  
	  var piezaId=Ext.get('piezaIdBusquedaCostos').dom.value;
	  
	  var arbol=Ext.getCmp('arbolCostos');
	  var nodoSeleccionado = arbol.getSelectionModel().getSelectedNode();
	  if (nodoSeleccionado==null){
	     Ext.Msg.alert('Subir nodo', 'No se ha seleccionado ningún nodo para subir');
	     return;
	  }
	  if (nodoSeleccionado.isFirst()){
	    Ext.Msg.alert('Subir nodo', 'El nodo seleccionado ya es el primero entre sus pares, no se lo puede subir más');
		return;
	  }else if (nodoSeleccionado.nextSibling==null && nodoSeleccionado.previousSibling==null){
		Ext.Msg.alert('Subir nodo', 'El nodo seleccionado no tiene hermanos a través de los cuales subir');
	    return;
	  }
	  var nodoPadre=nodoSeleccionado.parentNode;
	  var hermanoAnterior=nodoSeleccionado.previousSibling;
	  nodoSeleccionado.remove;
	  nodoPadre.insertBefore(nodoSeleccionado, hermanoAnterior);
	  nodoSeleccionado.select();
	  this.escribeOrdenCorregido(nodoPadre);
  },
  
  pulsoBajar : function (panel){
	  var piezaId=Ext.get('piezaIdBusquedaCostos').dom.value;
	  if (piezaId == undefined || piezaId==''){
		Ext.Msg.alert('Bajar nodo', 'No hay una pieza activa');
		return;
	  }
	  var arbol=Ext.getCmp('arbolCostos');
	  var nodoSeleccionado = arbol.getSelectionModel().getSelectedNode();
	  if (nodoSeleccionado==null){
	     Ext.Msg.alert('Subir nodo', 'No se ha seleccionado ningún nodo para subir');
	     return;
	  }
	  if (nodoSeleccionado.isLast()){
	    Ext.Msg.alert('Bajar nodo', 'El nodo seleccionado ya es el último entre sus pares, no se lo puede bajar más');
		return;
	  }else if (nodoSeleccionado.nextSibling==null && nodoSeleccionado.previousSibling==null){
		Ext.Msg.alert('Bajar nodo', 'El nodo seleccionado no tiene hermanos a través de los cuales bajar');
	    return;
	  }
	  var nodoPadre=nodoSeleccionado.parentNode;
	  var hermanoSiguiente=nodoSeleccionado.nextSibling;
	  var hermanoSegundoSig=hermanoSiguiente.nextSibling;
	  nodoSeleccionado.remove;
	  if (hermanoSegundoSig!=null){
	    nodoPadre.appendChild(nodoSeleccionado);
	  }else{
		nodoPadre.insertBefore(nodoSeleccionado, hermanoSegundoSig);
	  }
	  nodoSeleccionado.select();
	  this.escribeOrdenCorregido(nodoPadre)	  
  }  
  
});
  
