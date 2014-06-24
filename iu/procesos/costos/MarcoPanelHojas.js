MarcoPanelHojas = Ext.extend(Ext.Panel, {
  constructor : function(config) {
	MarcoPanelHojas.superclass.constructor.call(this, Ext.apply({
        title            : 'Costos',
        autoScroll : true,
        layout: 'border'
	   }, config)); //del apply y del constructor.call
    this.on('render', this.inicializacion, this);
  }, //constructor

  inicializacion : function (panel){
    var panelEtapas = new PanelEtapas({
      name: 'mphEtapas',
      id: 'mphEtapas'
    });
    
    var panelProcesos = new PanelProcesos({
      name: 'mphProcesos',
      id: 'mphProcesos'
    });	
    var panelMateriales = new PanelMateriales({
      name: 'mphMateriales',
      id: 'mphMateriales'
    });

	
     var panelHojas=new Ext.TabPanel({
	    id: 'panelHojasSolapas',
		region: 'center',
		activeItem: 0, // index or id
		deferredRender : false, //esto las presenta todas al mismo tiempo (necesario para los combos)
		hideMode: 'offsets',
		items:[
		  panelEtapas,
		  panelProcesos,
		  panelMateriales
        ],
	  }
    );
     
     var panelBotones = new Ext.Panel({
   	  id: 'panelBotonesHojasCostos',
   	  prefijo: 'panelBotonesHojasCostos',
   	  frame: true,
   	  region: 'south',
      buttons:[
          {text: recursosInter.agregar, id: 'mphBotAgregar'},
          {text: recursosInter.modificar, id: 'mphBotModificar'},
          {text: 'Borrar',  id: 'mphBotBorrar'}
      ]
     });
     
     Ext.getCmp('mphBotBorrar').addListener('click', this.pulsoBorrar);
     Ext.getCmp('mphBotModificar').addListener('click', this.pulsoModificar);
     Ext.getCmp('mphBotAgregar').addListener('click', this.pulsoAgregar);
     
     panel.add(panelHojas);
     panel.add(panelBotones);
  },
  
  pulsoModificar : function() {
		var piezaId=Ext.get('piezaIdBusquedaCostos').dom.value;
		if (piezaId == undefined || piezaId==''){
			Ext.Msg.alert('Modificar proceso', 'No hay una pieza activa');
			return;
		}
	    var arbol=Ext.getCmp('arbolCostos');
	    var nodoSeleccionado = arbol.getSelectionModel().getSelectedNode();
	    if (nodoSeleccionado!=null){
	      var panelActivo=Ext.getCmp('panelHojasSolapas').getActiveTab();
	      panelActivo.modifica(nodoSeleccionado);
	    }else{
	      Ext.Msg.alert('Modificar nodo', 'No se ha seleccionado ningún nodo');
	      return;
	    }
  }, 
  
  pulsoAgregar : function () {
    var piezaId=Ext.get('piezaIdBusquedaCostos').dom.value;
	if (piezaId == undefined || piezaId==''){
	  Ext.Msg.alert('Agregar proceso', 'No hay una pieza activa');
	  return;
	}
	var arbol=Ext.getCmp('arbolCostos');
	var nodoSeleccionado = arbol.getSelectionModel().getSelectedNode();
    if (nodoSeleccionado!=null){
	  var panelActivo=Ext.getCmp('panelHojasSolapas').getActiveTab();
	  panelActivo.agrega(piezaId, nodoSeleccionado);
    }else{
      Ext.Msg.alert('Agregar nodo', 'No se ha seleccionado ningún nodo padre');
      return;
    }
  },  
  

  pulsoBorrar : function () {
	  var piezaId=Ext.get('piezaIdBusquedaCostos').dom.value;
	  if (piezaId == undefined || piezaId==''){
		Ext.Msg.alert('Borrar nodo', 'No hay una pieza activa');
		return;
	  }	  
	    var arbol=Ext.getCmp('arbolCostos');
	    var nodoSeleccionado = arbol.getSelectionModel().getSelectedNode();
	    if (nodoSeleccionado!=null){
	    	if (nodoSeleccionado.hasChildNodes()){  //no puedo usar isLeaf, porque no se actualiza al 
	    		//borrarele un hijo hasta que no recargo el árbol
	          var mensaje='No se puede borrar un nodo con hijos. Por favor, borre los hijos primero';
	    	  Ext.MessageBox.show({
			    title: 'Advertencia', msg: mensaje, buttons: Ext.MessageBox.OK, 
			 	icon: Ext.MessageBox.INFO });
	    	    return;
	    	}

	        var conn = new Ext.data.Connection();
	    	conn.request({
	    	  url: '/produccion/svc/conector/costos.php/borraNodo',
	    	  method: 'POST',
	    	  params: {"id": nodoSeleccionado.id},
	    	  success: function(response, options) {
	    		nodoSeleccionado.remove();
	    	  },
	          failure: function(response, options) {
	    	    var exito=Ext.util.JSON.decode(response.responseText);
	            mensaje="Error al insertar el nodo. <br/>";
	            mensaje+='El mensaje devuelto por el servidor es: <br/>';
	            mensaje+=exito.errors;
	            Ext.MessageBox.show({
	 	         title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
	 	         icon: Ext.MessageBox.ERROR });    			    	
	          }
	    	 });
	    }else{
	    	Ext.Msg.alert('Borrar nodo', 'No se ha seleccionado ningún nodo para borrar');
	    	return;
	    }
	  }
});