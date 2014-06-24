PanelMateriales = Ext.extend(Ext.FormPanel, {
  
  constructor : function(config) {
	PanelMateriales.superclass.constructor.call(this, Ext.apply({
  	  id: 'panelMateriales',
  	  title: 'Insumos',
      frame: true,
      region: 'center',
  	  nombreElementoId: 'materialId',
      items: [
      {fieldLabel: 'Material', xtype: 'combomateriales', name: 'materialPanMat', id: 'materialPanMat', hiddenName: 'matIdPanMat', hiddenId: 'matIdPanMat', width: 200,
         scope: this, listeners: {
           'select' : function(combo, registro, indice){
 	         Ext.getCmp('textoUnidadPanMat').setText(registro.json['unidadTexto']);
           }
         }
      },
      {fieldLabel: 'Cantidad', xtype: 'fieldset', itemId: 'setCantidad', layout: 'anchor', //autoHeight:true,  collapsible: true,
       //height: 50, 
       // width: 350, 
       border: false, style: 'padding-left:0;padding-top:0;padding-bottom:0',
         items: [
       	   {xtype: 'numberfield', name: 'cantidadPanMat', id: 'cantidadPanMat', anchor: 'left 80%', decimalPrecision: 8, height: 37, width: 100},
       	   {xtype: 'label', style: 'padding-left:10px;', id: 'textoUnidadPanMat', name: 'textoUnidadPanMat', anchor: 'right 20%', itemId: 'textoUnidadPanMat', height: 30}
         ]
      }
	 ],
	  fuerzaValores : function(materialId, materialNombre, materialCantidad, unidadId, unidadTexto){
		 Ext.getCmp('materialPanMat').setValue(materialNombre);
		 Ext.get('matIdPanMat').dom.value=materialId;
		 Ext.getCmp('cantidadPanMat').setValue(materialCantidad);
		 Ext.getCmp('textoUnidadPanMat').setText(unidadTexto);
	  },
      modifica: function (nodo){
      	var materialId=Ext.get('matIdPanMat').dom.value;
	    var materialNombre=Ext.getCmp('materialPanMat').getRawValue();
		var cantidad=Ext.getCmp('cantidadPanMat').getValue();
		if (Ext.isEmpty(materialId)){
			Ext.Msg.alert('Modificar insumo', 'No se ha especificado ningún insumo');
			return;
		}else if (Ext.isEmpty(cantidad)){
		  Ext.Msg.alert('Modificar insumo', 'No se ha especificado la cantidad');
		  return;
		}	    
		var conn = new Ext.data.Connection();
		conn.request({
	      url: '/produccion/svc/conector/costos.php/modificaMaterial',
		  method: 'POST',
		  params: {
		  	"costoItemId" : nodo.id,
		  	"materialId" : materialId,
		    "materialNombre" : materialNombre,
		    "cantidad" : cantidad
		  },
		  success: function(response, options) {
		    var exito=Ext.util.JSON.decode(response.responseText);
		    nodo.setText(materialNombre);
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
		var materialId=Ext.get('matIdPanMat').dom.value;
	    var materialNombre=Ext.getCmp('materialPanMat').getRawValue();
		var cantidad=Ext.getCmp('cantidadPanMat').getValue();
	    if (nodoPadre.attributes['tipo']!='Proceso'){
	    	var mensaje='Los insumo sólo se pueden agregar a un procesp';
	    	Ext.MessageBox.show({
			 	       title: 'Error', msg: mensaje, buttons: Ext.MessageBox.OK, 
			 	       icon: Ext.MessageBox.ERROR });
			return;	        
	    }		
		if (materialId==''){
			Ext.Msg.alert('Agregar material', 'No se ha seleccionado ningún material');
			return;
		}else{
			var conn = new Ext.data.Connection();
			conn.request({
			    url: '/produccion/svc/conector/costos.php/insertaMaterial',
			    method: 'POST',
			    params: {"piezaId": piezaId, "padreId": nodoPadre.id, "materialId" : materialId,
				         "materialNombre" : materialNombre, "orden": nodoPadre.childNodes.length, "materialCantidad" : cantidad, 
				         },
			    success: function(response, options) {
				           var exito=Ext.util.JSON.decode(response.responseText);
				           nodoPadre.appendChild(new Ext.tree.TreeNode({
				             id: exito.nuevoId, cls: 'nodo-material', text: materialNombre, leaf: true
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
			});
		}
	  }//de la función "agrega"  
     }, config)); // del apply y del call del constructor
  }//del constructor 
}); // definición de clase	