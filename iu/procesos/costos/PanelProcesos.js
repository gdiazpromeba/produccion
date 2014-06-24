PanelProcesos = Ext.extend(Ext.FormPanel, {
  
  constructor : function(config) {
	PanelProcesos.superclass.constructor.call(this, Ext.apply({
  	  id: 'panelProcesos',
  	  title: 'Procesos',
      frame: true,
      region: 'center',
  	  nombreElementoId: 'procesoId',
      items: [
        {fieldLabel: 'Proceso',  xtype: 'comboprocesos', name: 'procesoPanProc', id: 'procesoPanProc', hiddenName: 'procesoIdPanProc', hiddenId: 'procesoIdPanProc', width: 320},
        {fieldLabel: 'Tiempo', xtype: 'textfield', name: 'tiempoPanProc', id: 'tiempoPanProc', regex: /^([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/, width: 60, value: '00:00:00'},
        {fieldLabel: 'Dotación', xtype: 'numberfield', name: 'dotacionSugerida', id: 'dotacionSugerida', minValue: 0, maxValue:100, value: 1, width: 50, align: 'right' },
        {fieldLabel: 'Ajustes', xtype: 'fieldset', itemId: 'setPorcentajeAjuste', layout: 'anchor', //autoHeight:true,  //collapsible: true,
          border: false, style: 'padding-left:0;padding-top:0;padding-bottom:0',
          items: [
           {xtype: 'numberfield', name: 'ajustePanProc', id: 'ajustePanProc', anchor: 'left 90%',  width: 50, height: 37, maxValue: 100, minValue:0, value: 0},
       	   {xtype: 'label', style: 'padding-left:10px;', anchor: 'right 10%', text: '%', height: 30}
          ]
        }        
      ],
	  fuerzaValores : function(procesoId, procesoNombre, tiempo, dotacionSugerida, kwh, ajuste){
	    Ext.getCmp('procesoPanProc').setValue(procesoNombre);
	    Ext.get('procesoIdPanProc').dom.value=procesoId;
	    Ext.getCmp('tiempoPanProc').setValue(tiempo);
	    Ext.getCmp('dotacionSugerida').setValue(dotacionSugerida);
	    Ext.getCmp('ajustePanProc').setValue(ajuste);
	  },
      modifica: function (nodo){
      	var procesoId=Ext.get('procesoIdPanProc').dom.value;
	    var procesoNombre=Ext.get('procesoPanProc').getValue();
		var tiempo=Ext.get('tiempoPanProc').getValue();
		var dotacionSugerida=Ext.get('dotacionSugerida').getValue();
		var ajuste=Ext.getCmp('ajustePanProc').getValue();
		
		if (Ext.isEmpty(procesoId)){
			Ext.Msg.alert('Modificar proceso', 'No se ha especificado ningún proceso');
			return;
		}else if (Ext.isEmpty(tiempo)){
		  Ext.Msg.alert('Modificar proceso', 'No se ha especificado el tiempo');
		  return;
		}else if (Ext.isEmpty(dotacionSugerida)){
		  Ext.Msg.alert('Modificar proceso', 'No se ha especificado la dotación');
		  return;
        }	    
		var conn = new Ext.data.Connection();
		conn.request({
	      url: '/produccion/svc/conector/costos.php/modificaProceso',
		  method: 'POST',
		  params: {
		  	"costoItemId" : nodo.id,
		    "procesoId" : procesoId,
		    "procesoNombre" : procesoNombre,
		    "tiempo" : tiempo, 
		    "dotacionSugerida" : dotacionSugerida,
		    "ajuste" : ajuste
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
			var procesoId=Ext.get('procesoIdPanProc').dom.value;
			var procesoNombre=Ext.get('procesoPanProc').getValue();
			var ajuste=Ext.getCmp('ajustePanProc').getValue();
			var tiempo=Ext.get('tiempoPanProc').getValue();
			var dotacionSugerida=Ext.get('dotacionSugerida').getValue();
		    if (nodoPadre.attributes['tipo']!='Etapa'){
		    	var mensaje='Los procesos sólo se pueden agregar a una etapa';
		    	Ext.MessageBox.show({
				 	       title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
				 	       icon: Ext.MessageBox.ERROR });
				return;	        
		    }		
			if (procesoId==''){
				Ext.Msg.alert('Agregar proceso', 'No se ha seleccionado ningún proceso');
				return;
			}else{
				var conn = new Ext.data.Connection();
				conn.request({
				    url: '/produccion/svc/conector/costos.php/insertaProceso',
				    method: 'POST',
				    params: {"piezaId": piezaId, 
				             "padreId": nodoPadre.id, 
				             "procesoId" : procesoId,
					         "procesoNombre" : procesoNombre, 
					         "orden": nodoPadre.childNodes.length, 
					         "tiempo" : tiempo, 
					         "dotacionSugerida" : dotacionSugerida,
					         "ajuste" : ajuste
					},
				    success: function(response, options) {
					           var exito=Ext.util.JSON.decode(response.responseText);
					           nodoPadre.appendChild(new Ext.tree.TreeNode({
					             id: exito.nuevoId, cls: 'nodo-proceso', text: procesoNombre, leaf: true
					           }));
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