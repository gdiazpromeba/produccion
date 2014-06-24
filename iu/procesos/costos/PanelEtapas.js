PanelEtapas = Ext.extend(Ext.FormPanel, {
  
  constructor : function(config) {
	PanelEtapas.superclass.constructor.call(this, Ext.apply({
  	  id: 'panelEtapas',
  	  title: 'Etapas',
      frame: true,
      region: 'center',
  	  nombreElementoId: 'etapaId',
      items: [
        {fieldLabel: 'Etapa',  xtype: 'comboetapas', name: 'etapaPanEta', id: 'etapaPanEta', hiddenName: 'etapaIdPanEta', hiddenId: 'etapaIdPanEta', width: 320}
      ],
	  fuerzaValores : function(etapaId, etapaNombre){
	    Ext.getCmp('etapaPanEta').setValue(etapaNombre);
	    Ext.get('etapaIdPanEta').dom.value=etapaId;
	  },
      modifica: function (nodo){
      	var etapaId=Ext.get('etapaIdPanEta').dom.value;
	    var etapaNombre=Ext.get('etapaPanEta').getValue();
		
		if (Ext.isEmpty(etapaId)){
			Ext.Msg.alert('Modificar etapa', 'No se ha especificado ninguna etapa');
			return;
		}	    
		var conn = new Ext.data.Connection();
		conn.request({
	      url: '/produccion/svc/conector/costos.php/modificaEtapa',
		  method: 'POST',
		  params: {
		  	"costoItemId" : nodo.id,
		    "etapaId" : etapaId,
		    "etapaNombre" : etapaNombre
		  },
		  success: function(response, options) {
		    var exito=Ext.util.JSON.decode(response.responseText);
		    nodo.setText(procesoNombre);
		  },
		  failure: function(response, options) {
		    var exito=Ext.util.JSON.decode(response.responseText);
			mensaje="Error al modificar el nodo. <br/>";
			mensaje+='El mensaje devuelto por el servidor es: <br/>';
			mensaje+=exito.errors;
			Ext.MessageBox.show({
			  title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
			  icon: Ext.MessageBox.ERROR });    			    	
			}
		});
	  },
	  agrega : function (piezaId, nodoPadre){
			var etapaId=Ext.get('etapaIdPanEta').dom.value;
			var etapaNombre=Ext.get('etapaPanEta').getValue();
			var tipo=nodoPadre.attributes['tipo'];
		    if (!Ext.isEmpty(tipo) && tipo!='Raíz'){
		    	var mensaje='Las etapas sólo se pueden agregar a la raíz';
		    	Ext.MessageBox.show({
				 	       title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
				 	       icon: Ext.MessageBox.ERROR });
				return;	        
		    }
			if (etapaId==''){
				Ext.Msg.alert('Agregar etapa', 'No se ha seleccionado ninguna etapa');
				return;
			}else{
				var conn = new Ext.data.Connection();
				conn.request({
				    url: '/produccion/svc/conector/costos.php/insertaEtapa',
				    method: 'POST',
				    params: {"piezaId": piezaId, 
				             "padreId": nodoPadre.id, 
				             "etapaId" : etapaId,
					         "etapaNombre" : etapaNombre,
					         "orden": nodoPadre.childNodes.length 
					},
				    success: function(response, options) {
					           var exito=Ext.util.JSON.decode(response.responseText);
					           nodoPadre.appendChild(new Ext.tree.TreeNode({
					             id: exito.nuevoId, cls: 'nodo-etapa', text: etapaNombre, leaf: true
					           }));
				               nodoPadre.setId(exito.idRaiz); //por las dudas la raíz hubiera sido agregada al mismo tiempo que la etapa
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
				}); //de la conn.request
			}//del else
	  }//de la función "agrega"  
     }, config)); // del apply y del call del constructor
  }//del constructor 
}); // definición de clase	